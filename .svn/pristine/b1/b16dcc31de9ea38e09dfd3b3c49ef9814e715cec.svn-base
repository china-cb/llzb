/**
 * Created by 冯天元 on 2017/1/20.
 */
//less ie8
if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s+|\s+$/g, '');
    }
}
if (!String.prototype.startsWith) {
    String.prototype.startsWith = function (str) {
        return (this.match("^" + str) == str)
    }
}
var WIS = function () {
    if (!window.console) window.console = { log: function () { } }
    function loger(level, prefix, msg) {
        if (WIS.Log > level)
            console.log("WIS." + prefix, msg)
    }
    function logInfo(prefix, msg) {
        loger(5, prefix, msg);
    }
    function logError(prefix, msg) {
        loger(10, prefix, msg);
    }
    function logWarn(prefix, msg) {
        loger(15, prefix, msg);
    }
    var mqttClient_ = null;
    var WIS_FLASH_PATH = "http://cdn.aodianyun.com/wis/wis.swf";
    //var WIS_FLASH_PATH = "http://localhost/record/js/wis/wis.swf";
    var WIS_H5DRAW_PATH = "http://cdn.aodianyun.com/wis/draw.js";
    var WIS_FLASH_INSTALL_PATH = "http://cdn.aodianyun.com/wis/playerProductInstall.swf";
    var waitTimes = 600;
    var opt_ = {
        maxPage: 18,
        curPage: 0
    }
    function parseHistory(obj) {
        var hasDif = false;
        for (var i = obj.length - 1; i >= 0; i--) {
            try {
                var data = eval("(" + obj[i] + ")");
                if (data.docId == opt_.docId) {
                    if (data.page != null) hasDif = true;
                    data.flag = "history";
                    drawQueue_.Push(data);
                }
            } catch (err) {
                logWarn("parseHistory",err);
            }
        }
        if (!hasDif) {
            drawQueue_.Push({ page: 1 });
        }
    }
    function syncPoint(x, y) {
        if (!mqttClient_ || !mqttClient_.isConnected()) return;
        var data = { x: x, y: y, cmd: "point", clientid: clientid_ };
        data.width = opt_.width;
        data.height = opt_.height;
        var message = new Paho.MQTT.Message(JSON.stringify(data));
        message.destinationName = opt_.topic + "_P";
        message.qos = 0;
        message.retained = false;
        mqttClient_.send(message);
    }
    function syncData(data) {
        data.page = opt_.curPage;
        data.width = opt_.width;
        data.height = opt_.height;
        data.clientid = clientid_;
        if (opt_.useFlash) {
            var str = opt_.drawFactory.JSONEncode(data);
        } else {
            var str = JSON.stringify(data)
        }
        opt_.api.syncDraw({
            wisId: opt_.wisId,
            body: str,
            success: function () { },
            failure: function () { }
        })
    }
    var clientid_ = null;
    function connect() {
        if (opt_.useFlash) {
            window.__onMessage = onMessage;
            window.__onClose = function () {
                try { if (opt_.onConnectClose) opt_.onConnectClose(); } catch (err) { logInfo("connect",err) }
            };
            window.__onConnectSuc = function () {
                try { if (opt_.onConnect) opt_.onConnect(); } catch (err) { logInfo("connect", err) }
            }
            window.__onReconnect = function () {
                try { if (opt_.onReconnect) opt_.onReconnect(); } catch (err) { logInfo("connect", err) }
            }
            clientid_ = opt_.drawFactory.connect(opt_.pubKey, opt_.subKey, opt_.topic, opt_.clientId, opt_.dmsHost/*, opt_.customTopics*/);
        } else if (opt_.useWs) {
            wsconnect();
        } else {
            logInfo("connect", "wsconnect_portable");
            wsconnect_portable();
        }
    }
    //兼容移动设备使用
    function wsconnect_portable() {
        //tell message arrived
        window.__onMessageArrived = onMessage;
        //tell connection closed
        window.__onClose = function () {
            try {
                if (opt_.onConnectClose) opt_.onConnectClose();
            } catch (err) {
                logWarn("window.__onClose", err);
            }
        };
        //tell connection succeed
        window.__onConnectSuc = function (clientid) {
            logInfo("window.__onConnectSuc", clientid);
            try {
                if (opt_.onConnect) opt_.onConnect();
                clientid_ = clientid;
            } catch (err) {
                logWarn("window.__onConnectSuc", err);
            }
        }
        //tell connection restart
        window.__onReconnect = function () {
            try {
                if (opt_.onReconnect) opt_.onReconnect();
            } catch (err) {
                logWarn("window.__onReconnect", err);
            }
        }

        var url = "wsconnect&topic=" + opt_.topic + "&subKey=" + opt_.subKey;
        logInfo("wsconnect_portable", url);
        self.location = url;
    }
    function wsconnect() {
        if (!clientid_) {
            if (opt_.clientId) {
                clientid_ = opt_.clientId
            } else {
                clientid_ = "ws2-" + Paho.MQTT.NewGuid()
            }
        } else {
            try { if (opt_.onReconnect) opt_.onReconnect(); } catch (err) { logWarn("wsconnect",err) }
        }
        mqttClient_ = new Paho.MQTT.Client(opt_.dmsHost, Number(8000), clientid_);
        mqttClient_.onConnectionLost = function (responseObject) {
            if (responseObject.errorCode !== 0) {
                if (mqttClient_ != null) {
                    try {
                        mqttClient_.disconnect()
                    } catch (err) {

                    }
                    mqttClient_ = null
                    setTimeout(wsconnect, 100)
                }
            }
        };
        mqttClient_.onMessageArrived = function (message) {
            onMessage(message.destinationName, message.payloadString)
        }
        mqttClient_.connect({
            timeout: 10, // connect timeout
            userName: opt_.pubKey,
            password: opt_.subKey,
            useSSL:opt_.useSSL,
            keepAliveInterval: 60, // keepalive
            cleanSession: false, //
            onSuccess: function () {
                mqttClient_.subscribe("__present__" + opt_.topic, { qos: 1 });
                mqttClient_.subscribe(opt_.topic, { qos: 1 });
                mqttClient_.subscribe(opt_.topic + "_C", { qos: 1 });
                mqttClient_.subscribe(opt_.topic + "_P", { qos: 0 });
                /*
                 for (var i = 0; i < opt_.customTopics.length; ++i) {
                 var topic = opt_.customTopics[i];
                 if (topic != opt_.topic && topic != (opt_.topic + "_P") && topic != (opt_.topic + "_C"))
                 mqttClient_.subscribe(topic, { qos: 1 });
                 }*/
                try { if (opt_.onConnect) opt_.onConnect(); } catch (err) { logInfo("mqttClient_.connect.onSuccess", err) }
            },
            onFailure: function (err) {
                try { if (opt_.onConnectClose) opt_.onConnectClose(); } catch (err) { logWarn("mqttClient_.connect.onFailure", err) }
                setTimeout(wsconnect, 1000)
            }
        });
    }
    function onMessage(topic, msg) {
        if (opt_.replayer.IsPlaying()) return;
        try {
            logInfo("onMessage", msg);
            if (topic == opt_.topic) {
                var data = eval('(' + msg + ')');
                if (data.clientid == clientid_) {
                    return;
                }
                data.recvAt = new Date().getTime();
                drawQueue_.Push(data)
            } else if (topic == "__present__" + opt_.topic) {
                var data = eval('(' + msg + ')');
                total_ = data.total;
                if (opt_.updateUser != null) {
                    opt_.updateUser(data.total, data);
                }
            } else if (topic == opt_.topic + "_C") {
                try {
                    msg = eval('(' + msg + ')');
                } catch (err) { }
                if (opt_.onCustomMessage != null) {
                    opt_.onCustomMessage(msg, topic);
                }
            } else if (topic == opt_.topic + "_P") {
                var data = eval('(' + msg + ')');
                if (data.clientid == clientid_) {
                    return;
                }
                data.recvAt = new Date().getTime();
                drawQueue_.Push(data)
            } else {
                try {
                    msg = eval('(' + msg + ')');
                } catch (err) { }
                if (opt_.onCustomMessage != null) {
                    opt_.onCustomMessage(msg, topic);
                }
            }
        } catch (err) {
            logWarn("onMessage", err);
        }
    }
    function parseScale(message) {
        var sx = opt_.width / message.width
        var sy = opt_.height / message.height
        if (message.start) {
            message.start.x *= sx;
            message.start.y *= sy;
        }
        if (message.end) {
            message.end.x *= sx;
            message.end.y *= sy;
        }
        if (message.plots) {
            for (var i = 0; i < message.plots.length / 2; i++) {
                message.plots[2 * i] *= sx;
                message.plots[2 * i + 1] *= sy;
            }
        }
        if (message.x) {
            message.x *= sx;
        }
        if (message.y) {
            message.y *= sx;
        }
    }

    var drawQueue_ = new DrawQueue();
    function DrawQueue() {
        this.queue_ = [];
        this.drawing = false;
    }
    DrawQueue.prototype.Push = function (message) {
        if (message != null) {
            this.queue_.push(message);
            this.drawQueue();
        }
    }
    DrawQueue.prototype.Run = function () {
        setInterval(function () {
            opt_.currentTime = parseInt(opt_.currentTime) + 50;
            drawQueue_.drawQueue();
        }, 50);
    }

    DrawQueue.prototype.drawQueue = function () {
        if (this.drawing) return
        this.drawing = true;
        while (this.queue_.length > 0) {
            var self = this;
            message = this.queue_.shift();
            var now = new Date().getTime();
            if (message.flag != "history" && message.flag != "record" && opt_.delay > 0 && (now - message.recvAt) < opt_.delay) {
                this.queue_.unshift(message);
                this.drawing = false;
                return;
            }
            if (message.docId != undefined && opt_.docId != message.docId) {
                opt_.docId = message.docId;
                this.queue_.unshift(message);
                (function (docId, page, pageUrl) {
                    opt_.api.getDocInfo({
                        docId: docId,
                        success: function (info) {
                            initDocInfo(info)
                            opt_.curPage = page;
                            ShowPage({
                                pageUrl: pageUrl,
                                success: function () {
                                    self.drawing = false;
                                    self.drawQueue();
                                },
                                failure: function () {
                                    self.drawing = false;
                                    self.drawQueue();
                                }
                            });
                        },
                        failure: function (obj) {
                            self.drawing = false;
                            self.drawQueue();
                        }
                    });
                })(opt_.docId, message.page!=undefined?message.page:1, message.pageUrl);
                return;
            } else if (message.reset) {
                message.reset = false;
                this.queue_.unshift(message);
                ShowPage({
                    pageUrl: message.pageUrl,
                    success: function () {
                        self.drawing = false;
                        self.drawQueue();
                    },
                    failure: function () {
                        self.drawing = false;
                        self.drawQueue();
                    }
                });
                return;
            }
            if (message.cmd == "point") {
                parseScale(message)
                opt_.drawFactory.recvPoint(message);
                continue;
            }
            if (message.page != null && message.page != opt_.curPage) {
                opt_.curPage = message.page;
                delete message.page;
                if (message.cmd != "page") {
                    this.queue_.unshift(message);
                }
                ShowPage({
                    pageUrl: message.pageUrl,
                    success: function () {
                        self.drawing = false;
                        self.drawQueue();
                    },
                    failure: function () {
                        self.drawing = false;
                        self.drawQueue();
                    }
                });
                return;
            }
            if (message.cmd == "draw") {
                parseScale(message)
                var r = opt_.drawFactory.RecvDraw(message)
            }
            if (message.cmd == "clear") {
                opt_.drawFactory.Clear();
            }
            if (message.cmd == "choseDoc") {
                if (opt_.docId != message.docId) {
                    opt_.docId = message.docId
                    opt_.api.getDocInfo({
                        docId: opt_.docId,
                        success: function (info) {
                            initDocInfo(info)
                            opt_.curPage = 1;
                            ShowPage({
                                pageUrl: message.pageUrl,
                                success: function () {
                                    self.drawing = false;
                                    self.drawQueue();
                                },
                                failure: function () {
                                    self.drawing = false;
                                    self.drawQueue();
                                }
                            });
                        },
                        failure: function (obj) {
                            self.drawing = false;
                            self.drawQueue();
                        }
                    })
                    //need return;
                    return
                }
            }
        }
        this.drawing = false;
    }
    function initDocInfo(info) {
        if (!opt_.useDoc) {
            resize();
            return;
        }
        opt_.pdf = info.pdfUrl;
        opt_.maxPage = info.page;

        opt_.whs = info.width / info.height

        resize();
        try {
            if (opt_.onDocLoad) opt_.onDocLoad({ fileName: info.fileName, id: info.id, page: info.page, width: info.width, height: info.height, pdf: info.pdfUrl })
        } catch (err) {
            logWarn("initDocInfo", err);
        }
    }
    function resize() {
        s1 = opt_.orgWidth / opt_.orgHeight
        opt_.width = opt_.orgWidth;
        opt_.height = opt_.orgHeight;
        if (s1 > opt_.whs) {
            opt_.width = opt_.whs * opt_.orgHeight
            opt_.width = opt_.width << 0
        } else {
            opt_.height = opt_.orgWidth / opt_.whs
            opt_.height = opt_.height << 0
        }
        opt_.drawFactory.width = opt_.width;
        opt_.drawFactory.height = opt_.height;
        var data = {
            top: (opt_.orgHeight - opt_.height) / 2,
            left: (opt_.orgWidth - opt_.width) / 2,
            width: opt_.width,
            height: opt_.height
        }
        if (opt_.center) {
            $("#" + opt_.container)[0].style.paddingTop = data.top + "px"
            $("#" + opt_.container)[0].style.marginLeft = 0 + "px"
        }
        $("#" + opt_.container)[0].style.width = data.width + "px"
        $("#" + opt_.container)[0].style.height = data.height + "px"
        opt_.drawFactory.Resize(data);
    }
    function getImg(width, tmp) {
        var url = opt_.pdf + '?page/' + tmp + '/density/150/quality/80/resize/' + width;
        var img = new Image();
        img.src = url;
        img.onload = function () {
            //logInfo("getImg", url);
        }
        img.onerror = function (err) {
            //logWarn("getImg", url, err);
        }
    }
    function defaultCache(page, width) {
        for (var i = 0; i < 3; i++) {
            tmp = page - i - 1;
            if (tmp <= 0) {
                break;
            }
            getImg(width, tmp);
        }
        for (var i = 0; i < 3; i++) {
            tmp = page + i + 1;
            if (tmp > opt_.maxPage) {
                break;
            }
            getImg(width, tmp);
        }
    }

    function ShowPage(option) {
        if (!option) option = {};
        function callback() {
            if (option && option.success) option.success();
        }
        if (opt_.curPage <= 0) {
            callback();
            return
        }
        var url = opt_.useDoc ? (opt_.pdf + '?page/' + opt_.curPage + '/density/150/quality/80/resize/800') : "";
        var tmpPage = opt_.curPage;

        if (opt_.useFlash) {
            opt_.callBackIndex++;
            opt_.callBackMap[opt_.callBackIndex] = callback
        }
        if (opt_.useDoc) {
            if (opt_.width > 800) {
                url = opt_.pdf + '?page/' + opt_.curPage + '/density/150/quality/80/resize/1024';
                defaultCache(opt_.curPage, 1024)
            } else {
                defaultCache(opt_.curPage, 800)
            }
        }
        if (option.pageUrl != null) {
            var pageUrl = option.pageUrl;
            if (option.pageUrl == "nodraw") {
                pageUrl = null
            }
            opt_.drawFactory.ShowBg({
                url: url,
                pageUrl: pageUrl,
                index: opt_.callBackIndex,
                success: callback,
                failure: callback
            });
            try {
                if (opt_.onPageChange) opt_.onPageChange(opt_.curPage, opt_.maxPage);
            } catch (err) {
                logWarn("onPageChange", err);
            }
            return
        } else if (opt_.replayer.IsPlaying()) {
            opt_.drawFactory.ShowBg({
                url: url,
                pageUrl: option.pageUrl, //新加
                index: opt_.callBackIndex,
                success: callback,
                failure: callback
            });
            try {
                if (opt_.onPageChange) opt_.onPageChange(opt_.curPage, opt_.maxPage);
            } catch (err) {
                logWarn("onPageChange", err);
            }
            return;
        }
        opt_.api.getPageInfo({
            docId: opt_.docId,
            wisId: opt_.wisId,
            page: tmpPage,
            success: function (data) {
                var pageUrl = null;
                if (data.url) {
                    pageUrl = data.url + "?" + data.ts;
                }
                opt_.drawFactory.ShowBg({
                    url: url,
                    pageUrl: pageUrl,
                    index: opt_.callBackIndex,
                    success: callback,
                    failure: callback
                });
                try {
                    if (opt_.onPageChange) opt_.onPageChange(opt_.curPage, opt_.maxPage);
                } catch (err) {
                    logWarn("onPageChange", err);
                }
            },
            failure: function (err) {
                opt_.drawFactory.ShowBg({
                    url: url,
                    index: opt_.callBackIndex,
                    success: callback,
                    failure: callback
                });
                try {
                    if (opt_.onPageChange) opt_.onPageChange(opt_.curPage, opt_.maxPage);
                } catch (err) {
                    logWarn("onPageChange", err);
                }
            }
        })
    }
    function syncAndShowPage(page, option) {
        opt_.curPage = page;
        ShowPage(option);
        opt_.api.syncPage({
            wisId: opt_.wisId,
            clientid: clientid_,
            page: page,
            success: function (info) {
                if (info) {
                    if (!option) {
                        option = {}
                    };
                    option.pageUrl = info.pageUrl;
                }
            },
            failure: function () {
                if (option && option.failure) {
                    option.failure();
                }
            }
        })
    }
    function canvasSupport() {
        if (window.ActiveXObject) {
            var reg = /10\.0/;
            var str = navigator.userAgent;
            //reg.test(str);
            if (reg.test(str)) {
                return false;
            };
        };
        if (window.WebSocket || !opt_.useWs) {
            try {
                return !!document.createElement('canvas').getContext;
            } catch (err) {
                return false;
            }
        } else {
            return false;
        }
    }

    function loadInfo(option) {
        opt_.api.getWisInfo({
            wisId: opt_.wisId,
            success: function (data) {
                opt_.docId = data.docId;
                opt_.topic = data.topic;
                opt_.subKey = data.subKey;
                opt_.pubKey = data.pubKey;
                opt_.secKey = data.secKey;
                opt_.useDoc = data.useDoc;
                opt_.useDoc = opt_.useDoc == undefined ? true : opt_.useDoc;
                opt_.docId = !data.useDoc ? "emptyDoc" : opt_.docId;
                opt_.whs = data.whs;
                opt_.whs = isNaN(opt_.whs) ? 0.706 : opt_.whs;
                opt_.loaded = true;
                opt_.recordId = data.recordId;
                opt_.lssApp = data.lssApp;
                opt_.lssStream = data.lssStream;
                opt_.userId = data.userId;
                opt_.lssPubAddr = "rtmp://" + (data.userId != undefined ? data.userId : 0) + ".lsspublish.aodianyun.com";
                opt_.lssPlayAddr = "rtmp://" + (data.userId != undefined ? data.userId : 0) + ".lssplay.aodianyun.com";
                opt_.hlsPlayAddr = "http://" + (data.userId != undefined ? data.userId : 0) + ".hlsplay.aodianyun.com";
                if (opt_.useWisType != undefined && data.type != opt_.useWisType) {
                    opt_.failure("WIS_TYPE_ERROR");
                    return;
                }
                if (option && option.success) option.success();
                opt_.success({
                    type: data.type, lssApp: opt_.lssApp, lssStream: opt_.lssStream, recordId: opt_.recordId,
                    lssPubAddr: opt_.lssPubAddr,
                    lssPlayAddr: opt_.lssPlayAddr,
                    hlsPlayAddr: opt_.hlsPlayAddr,
                    hlsPlayUrl: opt_.hlsPlayAddr + "/" + opt_.lssApp + "/" + opt_.lssStream + ".m3u8",
                    rtmpPlayUrl: opt_.lssPlayAddr + "/" + opt_.lssApp + "/" + opt_.lssStream,
                    rtmpPubUrl:  opt_.lssPubAddr + "/" + opt_.lssApp + "/" + opt_.lssStream,
                    recordId: opt_.recordId,
                    userId: opt_.userId
                });
                function _loadHistory(info) {
                    initDocInfo(info);
                    opt_.api.getHistory({
                        wisId: opt_.wisId,
                        success: function (data) {
                            parseHistory(data)
                            connect()
                        },
                        failure: function () {
                            opt_.curPage = 1;
                            ShowPage();
                            connect()
                        }
                    });
                }
                if (opt_.docId == "" || opt_.docId == null) {
                    if (!opt_.useDoc) {
                        _loadHistory();
                    } else {
                        connect()
                    }
                } else {
                    if (opt_.useDoc) {
                        opt_.api.getDocInfo({
                            docId: opt_.docId,
                            success: _loadHistory,
                            failure: function (text) {
                                if (typeof text == "string") {
                                    opt_.failure("获取文档信息失败:" + text);
                                } else {
                                    opt_.failure("获取文档信息失败:" + text.responseText);
                                }
                            }
                        })
                    } else {
                        _loadHistory();
                    }
                }
            },
            failure: function (text) {
                if (typeof text == "string") {
                    opt_.failure("获取白板信息失败:" + text);
                } else {
                    opt_.failure("获取白板信息失败:" + text.responseText);
                }
            }
        })
    }
    function LoadWsAndDrawJs() {
        var hasPaho = !opt_.useWs || (typeof Paho != "undefined")
        var hasDrawJs = (typeof WISDRAW != "undefined")
        if (!hasPaho) {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = false;
            s.src = 'http://cdn.aodianyun.com/dms/ws.js';
            s.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s);
        }
        if (!hasDrawJs) {
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = false;
            s.src = WIS_H5DRAW_PATH;
            s.charset = 'UTF-8';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s);
        }
        var wait = waitTimes
        var timerrr = setInterval(function () {
            hasPaho = !opt_.useWs || (typeof Paho != "undefined")
            hasDrawJs = (typeof WISDRAW != "undefined")
            if (hasPaho && hasDrawJs) {
                clearInterval(timerrr);
                opt_.drawFactory = WISDRAW();
                loadInfo({
                    success: function () {
                        $("#" + opt_.container).prepend('<div id="__wis__sm__container__"  style="cursor:none;background:none;position: absolute; z-index: 5;"><img id="__wis__cursor__container__"  style="pointer-events: none;background:none;position: absolute; z-index: 4;"></img></div>')
                        $("#" + opt_.container).prepend('<canvas id="__wis_draw_fg__"  style="background:none;position: absolute; z-index: 3"></canvas>')
                        if (opt_.useDoc) {
                            $("#" + opt_.container).prepend('<canvas id="__wis_draw__" style="background:none;position: absolute; z-index: 2"></canvas>')
                            $("#" + opt_.container).prepend('<img id="__wis_bg_img__" alt="" style="background:none;position: absolute; z-index: 1"></img>')
                        } else {
                            $("#" + opt_.container).prepend('<canvas id="__wis_draw__" style="background:#FFFFFF;position: absolute; z-index: 2"></canvas>')
                        }
                        cursor = document.getElementById('__wis__cursor__container__');
                        cursor.src = opt_.cursorUrl;
                        opt_.drawFactory.Init(document.getElementById("__wis_draw__"),
                            document.getElementById("__wis_draw_fg__"),
                            syncData, syncPoint, opt_.useDoc ? document.getElementById("__wis_bg_img__") : false, document.getElementById("__wis__sm__container__"), cursor);
                    }
                });
            }
            wait--
            if (wait <= 0) {
                clearInterval(timerrr);
                if (!hasPaho) {
                    opt_.failure("load ws.js fail")
                } else if (!hasDrawJs) {
                    opt_.failure("load draw.js fail")
                }
            }
        }, 10);
    }
    function LoadSwfObject() {
        if (typeof swfobject != "undefined") {
            loadFlush();
            return;
        }
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = false;
        s.src = 'http://cdn.aodianyun.com/wis/swfobject.js';
        s.charset = 'UTF-8';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(s);
        var wait = waitTimes
        var timerrr = setInterval(function () {
            if (typeof swfobject != "undefined") {
                clearInterval(timerrr);
                loadFlush();
                return
            }
            wait--
            if (wait <= 0) {
                clearInterval(timerrr);
                opt_.failure("load swfobject.js fail")
            }
        }, 10);
    }
    function loadFlush() {
        function callback(item) {
            if (item.success) {
                var wait = waitTimes
                var timerrr = setInterval(function () {
                    flash_obj = swfobject.getObjectById("__wis__");
                    if (flash_obj && flash_obj.init) {
                        clearInterval(timerrr);
                        flash_obj.init(opt_.cursorUrl);
                        window.__wis__syncDraw = syncData;
                        //window.__onDocLoadComplete = onDocLoadComplete;
                        opt_.drawFactory = flash_obj;
                        loadInfo();
                        return;
                    }
                    wait--
                    if (wait <= 0) {
                        clearInterval(timerrr);
                        opt_.failure("flash init fail")
                    }
                }, 10)
            } else {
                opt_.failure("flash load fail");
            }
        }
        if (swfobject.getObjectById("__wis__")) {
            callback({ success: true });
            return
        }
        swfobject.embedSWF(WIS_FLASH_PATH, '__wis__flash__div__', "0", "0", "11.0.0",
            WIS_FLASH_INSTALL_PATH, { id: "__wis__" }, { AllowScriptAccess: "always", wmode: "Transparent" }, { id: "__wis__", name: "__wis__", align: "middle" },
            callback);
    }
    function checkDiff() {
        var now = new Date().getTime();
        if (now - opt_.preTime > opt_.pageDiff) {
            opt_.preTime = now;
            return true;
        }
        return false;
    }
    //白板回放
    function Replayer() {
        var self = this, curRecord, videoPlayer, isPuase = false, resizeFlag = false;
        function Record(_recordId, _wisId, option) {
            var self = this, recordId = _recordId, wisId = _wisId, curInfo, timeOffset = 0;
            var opt = option ? option : {}, loadFlag = 0, playFlag = 0, preloadTime = 6000, isDrawFrameLoading;
            this.PrepareData = function (option) {
                ++playFlag;
                if (opt.onLoading) opt.onLoading();
                //加载重播数据
                opt_.api.getRecordInfo({
                    wisId: wisId,
                    recordId: recordId,
                    success: function (data) {
                        curInfo = {
                            record: data,
                            frames: [],curFrameIndex:0, draws: [], nextDrawIndex: 0,nextItemIndex:0,
                            startLoadTime: data.startTime - 3000, endLoadTime: data.startTime + preloadTime
                        };
                        curInfo.record.recBaseUrl = curInfo.record.recUrl?curInfo.record.recUrl.substr(0, curInfo.record.recUrl.lastIndexOf("/") + 1):"";
                        load_hlsData(option);
                        drawQueue_.Push({
                            cmd: "clear",
                            flag: "record",
                        });
                    },
                    failure: function (error) {
                        alert("白板回放失败:" + error);
                    }
                });
            }
            //停止播放
            this.StopPlay = function (option) {
                clearInterval(curInfo.timerId), curInfo.timerId = null, loadFlag = playFlag = 0;
                logInfo("StopPlay", "WIS.Replay is finished !");
                if (opt.onFinished) opt.onFinished();
            }
            //放在播放器事件调用，表示可以开始播放了
            this.StartPlay = function (option) {
                ++playFlag;
                if (loadFlag < 3 && ++loadFlag > 2) startPlay();
            }
            this.IsPlaying = function () {
                return playFlag >= 2;
            }
            function load_hlsData(option) {
                if (!curInfo.record.videoUrl || curInfo.record.videoUrl == "noVideo") {
                    curInfo.frames.push({
                        ts: {
                            duration: curInfo.record.endTime - curInfo.record.startTime,
                            playTime: 0,
                            startTime: curInfo.record.startTime
                        }
                    });
                    load_drawList(option);
                    if (loadFlag < 3 && ++loadFlag > 2) startPlay();
                    return;
                }
                opt_.api.getHlsData({
                    url: curInfo.record.videoUrl,
                    success: function (rsp) {
                        parseHls(rsp);
                        load_drawList(option);
                        if (loadFlag < 3 && ++loadFlag > 2) startPlay();
                    },
                    failure: function (error) {
                        alert("获取hls数据失败:" + error);
                    }
                });
            }
            function load_drawList(option) {
                if (curInfo.record.recUrl) {
                    opt_.api.getDrawData({
                        url: curInfo.record.recUrl,
                        success: function (rsp) {
                            parseDraws(rsp);
                            load_drawFrame({ startIndex: 0 });
                        },
                        failure: function (error) {
                            alert("获取回放数据失败:" + error);
                        }
                    });
                } else {
                    load_drawFrame({ startIndex: 0 });
                }
            }
            function load_drawItems(curIndex, lastIndex, option) {
                var startIdx = -1;
                for (var i = curIndex; i <= lastIndex; ++i) {
                    var item = curInfo.draws[i];
                    if (!item.draw) {
                        startIdx = i;
                        break;
                    }
                }
                if (startIdx < 0) {
                    option.success();
                    return;
                }
                var item = curInfo.draws[startIdx];
                var itemUrl = curInfo.record.recBaseUrl + item.url;
                opt_.api.getDrawData({
                    url: itemUrl,
                    success: function (rsp) {
                        rsp = rsp.split("\n");
                        item.list = [];
                        for (var i = 0; i < rsp.length; i++) {
                            if (!rsp[i].trim()) continue;
                            try {
                                var drw = $.parseJSON(rsp[i]);
                                drw.parent = item;
                                if (curInfo.timeOffset == undefined)
                                    curInfo.timeOffset = curInfo.record.startTime - drw.CliTime;
                                drw.Time = drw.CliTime;
                                drw.Time += curInfo.timeOffset;
                                item.list.push(drw);
                            } catch (e) {
                                logWarn("getDrawData",e);
                            }
                        }
                        if (curInfo.timeOffset == undefined) curInfo.timeOffset = 0;
                        if (item.list.length > 0) {
                            item.startTime = item.list[0].Time;
                            item.endTime = item.list[item.list.length - 1].Time;
                        }
                        if (startIdx < lastIndex) load_drawItems(startIdx + 1, lastIndex, option);
                        else option.success();
                    },
                    failure: function (error) {
                        alert("获取回放数据失败:" + error);
                    }
                });
            }
            function findAfterDrawIndexs(startIndex) {
                var draws = curInfo.draws
                var idxList = [];
                if (draws.length > 0) {
                    var endTime = draws[startIndex].startTime + preloadTime;
                    for (var i = startIndex; i < draws.length; ++i) {
                        var item = draws[i];
                        if (item.startTime <= endTime)
                            idxList.push(i);
                    }
                }
                return idxList
            }
            function load_drawFrame(option) {
                //获取
                if (curInfo.record.recUrl) {
                    var idxList = findAfterDrawIndexs(option.startIndex);
                    if (idxList.length > 0) {
                        isDrawFrameLoading = true;
                        load_drawItems(idxList[0], idxList[idxList.length - 1], {
                            success: function () {
                                isDrawFrameLoading = false;
                                if (loadFlag < 3 && ++loadFlag > 2) startPlay();
                            }
                        });
                    } else {
                        isDrawFrameLoading = false;
                        if (loadFlag < 3 && ++loadFlag > 2) startPlay();
                    }
                } else {
                    //兼容老的播放方式
                    isDrawFrameLoading = true;
                    function getRecordData(startLoadTime, endLoadTime) {
                        if (startLoadTime >= curInfo.record.endTime) {
                            var drawItems = curInfo.curDrawItems;
                            if (drawItems) {
                                curInfo.draws.push({
                                    index: curInfo.draws.length,
                                    url: "",
                                    startTime: drawItems[0].Time,
                                    endTime: drawItems[drawItems.length - 1].Time,
                                    list: drawItems
                                });
                            }
                        }
                        opt_.api.getRecordData({
                            wisId: wisId,
                            recordId: recordId,
                            startTime: startLoadTime,   //单位毫秒
                            endTime: endLoadTime,   //单位毫秒
                            skip: 0, num: 1000,
                            success: function (info) {
                                var list = info.list, drawItems = curInfo.curDrawItems;
                                for (var i = 0; i < list.length; ++i) {
                                    var item = list[i];
                                    if (item.Data.cmd == "clear" || item.Data.cmd == "choseDoc" || item.Data.cmd == "page") {
                                        if (drawItems) {
                                            curInfo.draws.push({
                                                index: curInfo.draws.length,
                                                url: "",
                                                startTime: drawItems[0].Time,
                                                endTime: drawItems[drawItems.length - 1].Time,
                                                list: drawItems
                                            });
                                        }
                                        curInfo.curDrawItems = drawItems = [];
                                        drawItems.push(item);
                                    } else {
                                        if (drawItems)
                                            drawItems.push(item);
                                    }
                                }
                                if (endLoadTime >= curInfo.record.endTime) {
                                    if (drawItems) {
                                        curInfo.draws.push({
                                            index: curInfo.draws.length,
                                            url: "",
                                            startTime: drawItems[0].Time,
                                            endTime: drawItems[drawItems.length - 1].Time,
                                            list: drawItems
                                        });
                                    }
                                    isDrawFrameLoading = false;
                                    if (loadFlag < 3 && ++loadFlag > 2) startPlay();
                                } else {
                                    getRecordData(endLoadTime, endLoadTime + preloadTime);
                                }
                            },
                            failure: function (error) {
                                alert("获取回放数据失败:" + error);
                            }
                        });
                    }
                    getRecordData(curInfo.record.startTime - 3000,curInfo.record.startTime + preloadTime);
                }
            }
            function parseHls(text) {            //start parse
                var lines = text.split("\n");
                if (lines.length < 4) {
                    alert("无效的m3u8, line error : " + lines.length); return;
                }
                //first line must be #EXTM3U
                if (lines[0].trim() != "#EXTM3U") {
                    alert("无效的m3u8, #EXTM3U missing"); return;
                }
                //other lines
                var curTs, playTime = 0, newStartTime = "first", startTime = curInfo.record.startTime, startTimeInc = 0;
                var tsReg = /^http:\/\/.*-(\d{10,20})-\d{1,}-\d{1,6}\.ts$/;
                for (var i = 1; i < lines.length; ++i) {
                    var line = lines[i].trim();
                    try {
                        if (line.startsWith("#EXTINF")) {
                            curTs = {};
                            line = line.split(":");
                            var tag = line[0];
                            curTs.duration = line.length > 1 ? parseFloat(line[1].split(",")[0].trim()) : 0;
                            curTs.duration *= 1000;
                            if (curInfo.frames.length < 2)
                                curTs.newStart = true;
                        } else if (!line.startsWith("#") && line != "" && curTs) {
                            curTs.url = line;
                            if (newStartTime) {
                                var match = tsReg.exec(curTs.url);
                                if (match) {
                                    startTime = parseInt(match[1]) * 1000;
                                    startTimeInc = 0;
                                    if (newStartTime == "first") {
                                        if ((Math.abs(curInfo.record.startTime - startTime)) < 3000) {
                                            curInfo.record.startTime = startTime;
                                        } else {
                                            startTime = curInfo.record.startTime;
                                        }
                                    }
                                    curTs.newStart = true;
                                }
                                newStartTime = false;
                            }
                            curTs.startTime = startTimeInc + startTime;
                            curTs.playTime = playTime;
                            playTime += curTs.duration;
                            startTimeInc += curTs.duration;
                            curInfo.frames.push({ ts: curTs });
                            curTs = null;
                        } else if (line.startsWith("#EXT-X-DISCONTINUITY")) {
                            newStartTime = true;
                        } else if (line.startsWith("#EXT-X-VERSION")) {
                            var version = parseInt(line.split(":")[1]);
                            if (version < 3) {
                                alert("hls version " + version + " not support"); return;
                            }
                        }
                        //ignore other tags
                    } catch (e) {
                        logWarn("parseHls", "parse hls line " + i + " error : ", e);
                    }
                }
            }
            function parseDraws(text) {            //start parse
                var lines = text.split("\n");
                if (lines.length < 2) {
                    alert("无效的录制文件, line error : " + lines.length); return;
                }
                //first line must be #DRWREC
                if (lines[0].trim() != "#DRWREC") {
                    alert("无效的录制文件, #DRWREC missing"); return;
                }
                //other lines
                var curDrw, playTime = 0, startTime = curInfo.record.startTime, startTimeInc = 0;
                for (var i = 1; i < lines.length; ++i) {
                    var line = lines[i].trim();
                    try {
                        if (line.startsWith("#DRWAT")) {
                            curDrw = {};
                            line = line.split(":");
                            var tag = line[0];
                            if (line.length > 1) {
                                var ts = line[1].split(",");
                                curDrw.startTime = parseInt(ts[0]);
                                curDrw.endTime = parseInt(ts[1]);
                            }
                        } else if (!line.startsWith("#") && line != "" && curDrw) {
                            curDrw.url = line;
                            curDrw.index = curInfo.draws.length;
                            curInfo.draws.push(curDrw);
                            curDrw = null;
                        } else if (line.startsWith("#DRW-VERSION")) {
                            var version = parseInt(line.split(":")[1]);
                            if (version < 1) {
                                alert("record version " + version + " not support"); return;
                            }
                        }
                        //ignore other tags
                    } catch (e) {
                        logWarn("parseDraws", "parse record file line " + i + " error : ", e);
                    }
                }
            }
            function findDrawByStartTime(time) {
                var draws = curInfo.draws;
                var low = 0, high = draws.length - 1, middle = 0;
                while (low <= high) {
                    middle = parseInt((high - low) / 2 + low);
                    var startTime = draws[middle].startTime;
                    if (startTime == time) break;
                    if (draws[middle].startTime > time) {
                        high = middle - 1;
                    } else {
                        low = middle + 1;
                    }
                }
                var index = high < low ? high : middle;
                return index < 0 ? 0 : index;
            }
            function findDrawItemByStartTime(draw, time) {
                var list = draw.list;
                if (!list || list.length <= 0) return -1;
                var low = 0, high = list.length - 1, middle = 0;
                while (low <= high) {
                    middle = parseInt((high - low) / 2 + low);
                    var startTime = list[middle].Time;
                    if (startTime == time) break;
                    if (list[middle].Time > time) {
                        high = middle - 1;
                    } else {
                        low = middle + 1;
                    }
                }
                return high < low ? high : middle;
            }
            function findFrameByPlayTime(time) {
                var frames = curInfo.frames;
                var low = 0, high = frames.length - 1, middle = 0;
                while (low <= high) {
                    middle = parseInt((high - low) / 2 + low);
                    var playTime = frames[middle].ts.playTime;
                    if (playTime == time) break;
                    if (frames[middle].ts.playTime > time) {
                        high = middle - 1;
                    } else {
                        low = middle + 1;
                    }
                }
                var index = high < low ? high : middle;
                return index < 0 ? 0 : index;
            }
            function startPlay() {
                if (opt.onStartPlay) opt.onStartPlay($.parseJSON(JSON.stringify(curInfo.record)));
                var frames = curInfo.frames;
                var draws = curInfo.draws;
                if (frames.length <= 0 || draws.length <= 0) {
                    self.StopPlay(); return;
                }
                console.log(draws);
                curInfo.startPlayTime = new Date().getTime();
                curInfo.isVideoStart = false;
                function pausePlayForLoading() {
                    if (!curInfo.loadPauseCall) {
                        videoPlayer.pausePlay();
                        curInfo.loadPauseCall = true;
                    }
                    logInfo("playFrames", "wis replay data loading");
                    if (opt.onLoading) opt.onLoading();
                }
                function resumePlayForLoading() {
                    if (curInfo.loadPauseCall) {
                        if (!isPuase)
                            videoPlayer.resumePlay();
                        curInfo.loadPauseCall = false;
                    }
                }
                console.log("...wwww",curInfo);
                function playFrames() {
                    /*
                     if (curInfo.nextDrawIndex >= draws.length) {
                     self.StopPlay(); return;
                     }*/
                    if (curInfo.dragging) return;
                    if (!curInfo.isVideoStart) {
                        if (videoPlayer.startPlay()) {
                            curInfo.isVideoStart = true;
                            if (isPuase) videoPlayer.pausePlay();
                        } else {
                            return;
                        }
                    }
                    //获取播放的时间
                    var playTime = videoPlayer.currenttime();
                    if (playTime === false) return;
                    var curFrameIndex = findFrameByPlayTime(playTime);
                    var frame = frames[curFrameIndex];
                    var startTime = playTime - frame.ts.playTime + frame.ts.startTime;
                    if (startTime > curInfo.record.endTime + 2000) {
                        videoPlayer.stopPlay();
                        self.StopPlay(); return;
                    }
                    var curDrawIndex = findDrawByStartTime(startTime);
                    var draw = draws[curDrawIndex];
                    //拖动或者合并的视频片段
                    var reset = false;
                    if (resizeFlag) {
                        curInfo.nextDrawIndex = curDrawIndex;
                        curInfo.nextItemIndex = 0;
                        reset = true;
                        resizeFlag = false;
                    }
                    else if (draw.list && (frame.newStart || curInfo.dragUp || true)) {
                        if(curDrawIndex != curInfo.nextDrawIndex) {
                            if (curDrawIndex == curInfo.nextDrawIndex - 1 && curInfo.nextItemIndex == 0) {
                                if (curInfo.lastStartTime > startTime) {
                                    curInfo.nextDrawIndex = curDrawIndex;
                                    curInfo.nextItemIndex = 0;
                                    reset = true;
                                    //console.log("当前未画而前一个draw拖动");
                                }
                            } else {
                                curInfo.nextDrawIndex = curDrawIndex;
                                curInfo.nextItemIndex = 0;
                                reset = true;
                                //console.log("不同draw之间的拉动");
                            }
                        } else {
                            var preItemIndex = curInfo.nextItemIndex - 1;
                            if (preItemIndex >= 0 && preItemIndex < draw.list.length && draw.list[preItemIndex].startTime > startTime) {
                                curInfo.nextDrawIndex = curDrawIndex;
                                curInfo.nextItemIndex = 0;
                                reset = true;
                                //console.log("当前draw往后拉");
                            }
                        }
                        curInfo.dragUp = false;
                    }
                    if (draw.list) {
                        resumePlayForLoading();
                    } else {
                        if (!isDrawFrameLoading)
                            load_drawFrame({ startIndex: curDrawIndex });
                        pausePlayForLoading();
                        return;
                    }
                    //预加载
                    if(!isDrawFrameLoading) {
                        for (var i = curDrawIndex + 1; i < draws.length ; ++i) {
                            draw = draws[i];
                            if (draw.startTime < startTime + preloadTime) {
                                if (!draw.list) {
                                    load_drawFrame({ startIndex: i });
                                    break;
                                }
                            } else {
                                break;
                            }
                        }
                    }
                    //开始播放
                    var maxDrawLoop = 1000;//避免死循环
                    while (curInfo.nextDrawIndex <= curDrawIndex && maxDrawLoop-- > 0) {
                        draw = draws[curInfo.nextDrawIndex];
                        var drawItemIdx = findDrawItemByStartTime(draw, startTime);
                        var maxItemLoop = 1000;//避免死循环
                        while (curInfo.nextItemIndex <= drawItemIdx && maxItemLoop-- > 0) {
                            var itemData = draw.list[curInfo.nextItemIndex++];
                            //开始绘制白板
                            try {
                                var data = itemData.Data;
                                data.flag = "record";
                                data.reset = reset;
                                reset = false;
                                drawQueue_.Push($.parseJSON(JSON.stringify(data)));
                            } catch (err) {
                                logWarn("playFrames->parseRecord", err);
                            }
                            curInfo.lastStartTime = itemData.Time;
                        }
                        if (drawItemIdx < 0 || curInfo.nextItemIndex >= draw.list.length)
                            ++curInfo.nextDrawIndex, curInfo.nextItemIndex = 0;
                        else break;
                    }
                    curInfo.curFrameIndex = curFrameIndex;
                }
                playFrames();
                curInfo.timerId = setInterval(playFrames, 60);
            }
        }
        this.Prepare = function (recordId, option) {
            if (this.IsPlaying()) throw "Replayer status error";
            option = option ? option : {};
            option.onFinished = function () {
                curRecord = undefined;
            };
            option.onStartPlay = function (recordInfo) {
                videoPlayer.initPlayer({ url: recordInfo.videoUrl });
            };
            curRecord = new Record(recordId, opt_.wisId, option);
            curRecord.PrepareData(option);
        }
        this.Start = function (option) {
            if (this.IsPlaying()) throw "Replayer status error";
            if (!curRecord) this.Prepare(option.recordId, option);
            isPuase = false;
            curRecord.StartPlay(option);
        },
            this.Stop = function (option) {
                if (this.IsPlaying())
                    curRecord.StopPlay(option);
                videoPlayer.stopPlay();
                curRecord = undefined;
            }
        this.Pause = function(option) {
            isPuase = true;
            videoPlayer.pausePlay();
        }
        this.Resume = function() {
            isPuase = false;
            videoPlayer.resumePlay();
        }
        this.IsPlaying = function () {
            return !!curRecord && curRecord.IsPlaying();
        }
        //默认播放器
        videoPlayer = {
            initPlayer: function (option) {
                if (!videoPlayer.container) return;
                $("#" + videoPlayer.container).html("").width(videoPlayer.width).height(videoPlayer.height).css("background-color","black");
                if (option.url == "noVideo") {
                    $("#" + videoPlayer.container).html("无视频"); return;
                }
                videoPlayer.isReady = false;
                var param = {
                    container: videoPlayer.container,
                    width: videoPlayer.width,
                    height: videoPlayer.height,
                    stretching: 1,
                    //controlbardisplay: 'enable',
                    isfullscreen: true,
                    isclickplay: false,
                    //autostart: true,
                    onReady: function () {
                        videoPlayer.isReady = true;
                        if (option.url) {
                            videoPlayer.player.addPlayerCallback("play.stop", function () {
                                self.Stop();
                                $("#" + videoPlayer.container).html("").width(videoPlayer.width).height(videoPlayer.height).css("background-color", "black");
                            });
                        }
                    }
                };
                if (option.url) {
                    param.controlbardisplay = "enable";
                    param.hlsUrl = option.url;
                    logInfo("initPlayer.hlsUrl", option.url);
                } else {
                    param.controlbardisplay = "disable";
                    param.hlsUrl = option.hlsUrl;
                    param.rtmpUrl = option.rtmpUrl;
                    logInfo("initPlayer.hlsUrl", param.hlsUrl);
                    logInfo("initPlayer.rtmpUrl", param.rtmpUrl);
                    param.autostart = true;
                }
                videoPlayer.player = new aodianPlayer(param);
                window.videoPlayer = videoPlayer.player;
            },
            startPlay: function () {
                videoPlayer.startTime = new Date().getTime();
                if (!videoPlayer.player) return true;
                if (videoPlayer.isReady && videoPlayer.player.startPlay) {
                    videoPlayer.player.startPlay();
                    return true;
                }
                return false;
            },
            pausePlay: function (option) {
                if (!videoPlayer.player) return true;
                if (videoPlayer.player.pausePlay) {
                    videoPlayer.player.pausePlay();
                    return true;
                }
                return false;
            },
            resumePlay: function (option) {
                if (!videoPlayer.player) return true;
                if (videoPlayer.player.resumePlay) {
                    videoPlayer.player.resumePlay();
                    return true;
                }
                return false;
            },
            stopPlay: function () {
                if (!videoPlayer.player) return true;
                if (videoPlayer.player.stopPlay) {
                    videoPlayer.player.stopPlay();
                    videoPlayer.isReady = false;
                    videoPlayer.player = undefined;
                    $("#" + videoPlayer.container).html("").width(videoPlayer.width).height(videoPlayer.height).css("background-color", "black");
                    return true;
                }
                return false;
            },
            currenttime: function (option) {
                if (videoPlayer.player) {
                    if (videoPlayer.player.currenttime) {
                        var time = videoPlayer.player.currenttime();
                        if (isNaN(time)) return false;
                        return parseInt(time * 1000);
                    }
                } else {
                    return new Date().getTime() - videoPlayer.startTime;
                }
                return false;
            }
        }
        this.InitVideoPlayer = function (option) {
            videoPlayer.container = option.container;
            videoPlayer.width = option.width;
            videoPlayer.height = option.height;
            if (option.initPlayer) videoPlayer.initPlayer = option.initPlayer;
            if (option.pausePlay) videoPlayer.pausePlay = option.pausePlay;
            if (option.resumePlay) videoPlayer.resumePlay = option.resumePlay;
            if (option.startPlay) videoPlayer.startPlay = option.startPlay;
            if (option.stopPlay) videoPlayer.stopPlay = option.stopPlay;
            if (option.currenttime) videoPlayer.currenttime = option.currenttime;
            if (option.autostart)
                videoPlayer.initPlayer({
                    hlsUrl: opt_.hlsPlayAddr + "/" + opt_.lssApp + "/" + opt_.lssStream + ".m3u8",
                    rtmpUrl: opt_.lssPlayAddr + "/" + opt_.lssApp + "/" + opt_.lssStream
                });
        }
        this.Resize = function (option) {
            resizeFlag = true;
        }
    }
    //白板录制
    function Recorder(option) {
        this.Start = function (option) {
            option = option ? option : {};
            if (opt_.replayer.IsPlaying()) throw "Replayer is playing";
            opt_.api.startRecord({
                wisId: opt_.wisId,
                lssApp: opt_.lssApp,
                lssStream: opt_.lssStream,
                title: option.title,
                success: function (data) {
                    opt_.recordId = data.recordId;
                    opt_.api.choseDoc({
                        wisId: opt_.wisId,
                        docId: opt_.docId,
                        recordId: opt_.recordId,
                        success:function() {
                            WIS.Clear();
                        },
                        failure: function () {
                            WIS.Clear();
                        }
                    });
                    if (option.success) option.success(data);
                },
                failure: option.failure
            });
        },
            this.Stop = function (option) {
                option = option ? option : {};
                if (opt_.replayer.IsPlaying()) throw "Replayer is playing";
                opt_.api.stopRecord({
                    wisId: opt_.wisId,
                    lssApp: opt_.lssApp,
                    lssStream: opt_.lssStream,
                    success: function (data) {
                        opt_.recordId = "";
                        if (option.success) option.success(data);
                    },
                    failure: option.failure
                });
            },
            this.GetCurRecordId = function () {
                return opt_.recordId;
            }
        this.IsRecording = function () {
            return !!opt_.recordId;
        }
    }
    opt_.replayer = new Replayer();
    opt_.recorder = new Recorder();
    return {
        Init: function (opt) {
            if (opt.cursorUrl) {
                opt_.cursorUrl = opt.cursorUrl;
            } else {
                opt_.cursorUrl = "http://cdn.aodianyun.com/wis/penIco.png";
            }
            opt_.api = opt.api;
            this.Api = opt.api;
            opt_.onCustomMessage = opt.onCustomMessage;
            opt_.wisId = opt.wisId;
            opt_.topic = null;
            opt_.updateUser = opt.updateUser;
            opt_.orgWidth = opt.width;
            opt_.orgHeight = opt.height;
            opt_.width = opt.width;
            opt_.height = opt.height;
            opt_.onPageChange = opt.onPageChange
            opt_.onConnect = opt.onConnect
            opt_.onReconnect = opt.onReconnect
            opt_.onConnectClose = opt.onConnectClose
            opt_.onDocLoad = opt.onDocLoad
            opt_.onResize = opt.onResize
            opt_.flashId = opt.flashId
            opt_.success = opt.success
            opt_.failure = opt.failure
            opt_.center = (opt.center == null) ? true : !!opt.center;
            opt_.curPage = 0;
            opt_.container = opt.container;
            opt_.pageDiff = 150;
            opt_.preTime = new Date().getTime();
            opt_.useWs = true;
            opt_.clientId = opt.clientId ? opt.clientId : "";
            /*
             function isArray(obj) {
             return Object.prototype.toString.call(obj) === '[object Array]'; 搜索
             }
             if (isArray(opt.customTopics))
             opt_.customTopics = opt.customTopics;
             else
             opt_.customTopics = [];*/
            if (opt.dmsHost) {
                opt_.dmsHost = opt.dmsHost;
            } else {
                opt_.dmsHost = "mqtt.dms.aodianyun.com";
            }
            if (opt.useSSL) {
                opt_.dmsHost = "mqttdms.aodianyun.com";
            }
            opt_.useSSL = !!opt.useSSL;
            if (opt.useWs === false) {
                opt_.useWs = false;
            }
            if (opt.useWisType) {
                opt_.useWisType = opt.useWisType;
            }
            if (opt.delay > 0) {
                opt_.delay = opt.delay;
            }
            drawQueue_.Run();
            if (canvasSupport()) {
                opt_.useFlash = false;
                setTimeout(LoadWsAndDrawJs, 100);
            } else {
                $("#" + opt_.container).prepend('<div id="__wis__flash__div__"></div>')
                opt_.useFlash = true;
                opt_.callBackMap = {};
                opt_.callBackIndex = 1;
                window.__call__wis__pageload = function (index, sused) {
                    cb = opt_.callBackMap[index];
                    delete opt_.callBackMap[index];
                    if (cb) {
                        cb(sused);
                    }
                }
                LoadSwfObject();
            }
        },
        NextPage: function (option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                if (option && option.failure) option.failure("文档服务加载中");
                return;
            }
            if (opt_.curPage == opt_.maxPage) {
                if (option && option.failure) option.failure("已到达最后一页");
                return;
            }
            if (!checkDiff()) {
                if (option && option.failure) option.failure("翻页太频繁了");
                return
            }
            var page = Number(opt_.curPage) + 1;
            syncAndShowPage(page, option)
        },
        PrevPage: function (option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                if (option && option.failure) option.failure("文档服务加载中");
                return;
            }
            if (opt_.curPage == 1) {
                if (option && option.failure) option.failure("已到达第一页");
                return;
            }
            if (!checkDiff()) {
                if (option && option.failure) option.failure("翻页太频繁了");
                return
            }
            var page = Number(opt_.curPage) - 1;
            syncAndShowPage(page, option)
        },
        ToPage: function (page, option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                if (option && option.failure) option.failure("文档服务加载中");
                return;
            }
            if (page <= 0 || page > opt_.maxPage) {
                if (option && option.failure) option.failure("页码不正确");
                return;
            }
            if (!checkDiff()) {
                if (option && option.failure) option.failure("翻页太频繁了");
                return
            }
            syncAndShowPage(page, option)
        },
        GetCurrentDoc: function () {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                throw new Error("文档服务加载中");
            }
            return opt_.docId;
        },
        LineWidth: function (lw) {
            if (opt_.replayer.IsPlaying()) return;
            if (!lw) {
                lw = null;
            }
            if (opt_.drawFactory) {
                return opt_.drawFactory.LineWidth(lw)
            }
        },
        FontSize: function (fs) {
            if (opt_.replayer.IsPlaying()) return;
            if (!fs) {
                fs = null;
            }
            if (opt_.drawFactory) {
                return opt_.drawFactory.FontSize(fs)
            }
        },
        Loaded: function () {
            return opt_.loaded;
        },
        Color: function (co) {
            if (opt_.replayer.IsPlaying()) return;
            if (!co) {
                co = null;
            }
            if (opt_.drawFactory) {
                return opt_.drawFactory.Color(co)
            }
        },
        Alpha: function (alpha) {
            if (opt_.replayer.IsPlaying()) return;
            if (!alpha) {
                alpha = null;
            }
            if (opt_.drawFactory) {
                return opt_.drawFactory.Alpha(alpha)
            }
        },
        Track: function (obj) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                throw new Error("文档服务加载中");
            }
            if (opt_.drawFactory) {
                opt_.drawFactory.Track(obj)
            }
        },
        SetDrawType: function (type) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                throw new Error("文档服务加载中");
            }
            if (opt_.drawFactory) {
                opt_.drawFactory.SetDrawType(type)
            }
        },
        AllowDraw_Portable: function (bval) {
            if (opt_.replayer.IsPlaying()) return;
            WIS.AllowDraw({ ballow: bval })
        },
        AllowDraw: function (option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                if (option.failure) {
                    option.failure("文档服务加载中")
                }
                return
            }
            if (!!option.ballow) {
                opt_.api.allowDraw({
                    success: function () {
                        if (opt_.drawFactory) {
                            opt_.drawFactory.AllowDraw(true)
                            if (option.failure) {
                                option.failure(err)
                            }
                        }
                        if (option.failure) {
                            option.failure("文档服务加载中")
                        }
                    },
                    failure: function (err) {
                        if (option.failure) {
                            option.failure(err)
                        }
                    }
                })
            } else {
                if (opt_.drawFactory) {
                    return opt_.drawFactory.AllowDraw(false)
                }
            }
        },
        Clear: function () {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                throw new Error("文档服务加载中");
            }
            syncData({ cmd: "clear" })
            opt_.drawFactory.Clear();
        },
        SendCustomMessage: function (option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!option || !option.msg) {
                throw new Error("参数错误");
            }
            if (typeof option.msg != "string") {
                if (opt_.useFlash) {
                    option.msg = opt_.drawFactory.JSONEncode(option.msg);
                } else {
                    option.msg = JSON.stringify(option.msg)
                }
            }
            option.topic = option.topic ? option.topic : opt_.topic + "_C";
            opt_.api.customMessage({
                wisId: opt_.wisId,
                body: option.msg,
                topic: option.topic,
                success: option.success,
                failure: option.failure
            })
        },
        Subscribe: function (topic, qos) {
            qos = qos == undefined ? 1 : qos;
            if(opt_.useFlash) {
                opt_.drawFactory.subscribe(topic, qos);
            } else {
                mqttClient_.subscribe(topic, { qos: qos });
            }
        },
        Unsubscribe: function(topic) {
            if (opt_.useFlash) {
                opt_.drawFactory.unSubscribe(topic);
            } else {
                mqttClient_.unsubscribe(topic);
            }
        },
        ChoseDoc: function (option) {
            if (opt_.replayer.IsPlaying()) return;
            if (!opt_.useDoc) return;
            if (!option.wisId) {
                option.wisId = opt_.wisId;
            }
            if (this.Recorder.IsRecording())
                option.recordId = this.Recorder.GetCurRecordId();
            opt_.api.choseDoc(option)
        },
        Resize: function (w, h) {
            //if (opt_.replayer.IsPlaying()) return;
            if (!opt_.loaded) {
                throw new Error("文档服务加载中");
            }
            //if (!opt_.pdf) return;
            if (!!w) {
                opt_.orgWidth = w;
            }
            if (!!h) {
                opt_.orgHeight = h
            }
            resize();
            if (opt_.replayer.IsPlaying()) {
                opt_.replayer.Resize();
            } else {
                opt_.api.getHistory({
                    wisId: opt_.wisId,
                    success: function (data) {
                        ShowPage({
                            success: function () {
                                parseHistory(data)
                            }
                        });
                    },
                    failure: function () {
                        ShowPage();
                    }
                });
            }
        },
        GetTopic: function () {
            return opt_.topic;
        },
        Recorder: opt_.recorder,
        Replayer: opt_.replayer
    }
}();
function getQueryStr(str, url) {
    var LocString = String(url != undefined ? url : window.document.location.href);
    var rs = new RegExp("(^|)" + str + "=([^&]*)(&|$)", "gi").exec(LocString), tmp;
    if (tmp = rs) return decodeURIComponent(tmp[2]);
    return "";
}
WIS.Log =  parseInt(getQueryStr("WIS.Log"));
WIS.Log = isNaN(WIS.Log) ? 0 : WIS.Log;