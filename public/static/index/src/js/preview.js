/**
 * Created by deloo on 2016/11/30.
 */
var _preview;

_preview = (function () {
    var msg_content,
        top_v;

    function init(){
        msg_content=$(".pv-message");
        top_v=parseInt(msg_content.css("padding-top"));
    }

    /*设置置顶*/
    function set_top(obj){

        var temp=$('<div class="message  top">' +
            ' <img class="avatar " src=""> ' +
            '<h4><span class="name"></span><span class="time"></span></h4>' +
            ' <p></p> ' +
            '<a class=" cancel-top">取消置顶</a>' +
            '</div>');
        temp.find(".avatar").prop("src",obj.img);
        temp.find(".name").text(obj.name);
        temp.find(".time").text(obj.time);
        temp.find(">p").html(obj.content);
        temp.addClass("top");
        msg_content.append(temp);
        var h=temp.outerHeight();
        msg_content.css("padding-top",h + top_v);
        /*todo  置顶*/
        temp.on("click",".cancel-top",function(){
            cancel_top(temp);
        });
        msg_content.addClass("has-top");
    }

    /*取消设置置顶*/
    function cancel_top(dom){
        $(dom).remove();
        msg_content.css("padding-top",top_v);
        /*todo 取消置顶*/
        if(msg_content.find(".message.top").length<=0){
            msg_content.removeClass("has-top");
        }
    }
    return {
        init: init,
        top:{
            set:set_top,
            cancel:cancel_top
        }
    }
})();



var tis_temp = (function () {
        var tisApp,                 /*tis*/
            temp,                   /*模板对象定义*/
            dom,                    /*tis-dom*/
            _face_block,            /*表情块*/
            _msg_flag=true,         /*自动滚动锁定标志*/
            total=0,                  /*总信息量*/
            msg_content,            /*信息发送DOM*/
            msg_input,              /*信息输入input*/
            ops_obj,                /*options */
            msg_block,              /*信息列表*/
            msg_send,               /*信息发送DOM*/
            face_btn,               /*表情按钮*/
            timer,                  /*自动滚动计时器*/
            arr,
            sign,
            scroll_waiting=3000;    /*自动滚动锁定时间*/
            get_top_and_gag();
        /*tis 初始化触发*/
        function onInitUI(container,options) {
            dom=$(container);
            ops_obj=options;
            msg_block =dom.find(".psm-warp");
            msg_send=dom.find(".pv-send");
            msg_input=dom.find(".msg-input");
            msg_content=dom.find(".psm-warp");
            _face_block = msg_send.find(".face-block");
            face_btn = msg_send.find(".face-btn");
            total=dom.find(".total");
            total.data("count",0);
            _face_block.find(".face-contain").html("");
            dom.find(".psm-contain").html("");
            init_msg_block();
            init_face_group();
            bind_send();
        }

        /*初始化信息显示块*/
        function init_msg_block() {
            msg_block.mCustomScrollbar({
                theme: "llzb-common"
            });
        }

        /*获取tis置顶和禁言信息*/
        function get_top_and_gag(){
            var url = $("#top_and_gag_url").val();
            var cid = $("#cid").val();
            common.ajax_post(url,{cid:cid},false,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    sign = 1;
                    arr = obj.ret_data;
                }else{
                    sign = -1;
                }
            });
        }

        /*初始化表情块*/
        function init_face_group() {
            _face_block._isShow = false;
            _face_block.open = function () {
                _face_block.show();
                setTimeout(function () {
                    _face_block.addClass("active");
                    _face_block._isShow = true;
                }, 50);
            };
            _face_block.close = function () {
                _face_block.removeClass("active");
                setTimeout(function () {
                    $(this).hide();
                    _face_block._isShow = false;
                }, 300);
            };
            _face_block.mCustomScrollbar({
                theme: "llzb-common",
                callbacks:{
                    onScroll:function(){
                        _msg_flag=false;
                        clearTimeout(timer);
                        timer=setTimeout(function(){
                            _msg_flag=true;
                        },scroll_waiting);
                    }
                }
            });

        }

        /*发送信息绑定*/
        function bind_send() {
            msg_input.on("keydown",function (e) {

                if (e == null || e.keyCode == null || e.ctrlKey == null) return;
                if (e.keyCode == 13 && e.ctrlKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            _face_block.on("click",".face-item",function(){
                msg_input.val(msg_input.val() + $(this).data("text"));
            });

            msg_send.find(".psv-submit").on("click",function(){
                sendMessage();
            });
        }

        /*信息发送*/
        function sendMessage() {
            /*发言前先检测是否有权限*/
            var url = $("#is_gag_url").val();
            var cid = $("#cid").val();
            var uid = $("#uid").val();
            common.ajax_post(url,{uid:uid,cid:cid},false,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    tisApp = tisApp ? tisApp : window.tis;
                    var sendText= msg_input.val();
                    /*todo  发送内容校验*/
                    if (sendText.length > 200) {
                        alert("发送内容太长啦");
                        return;
                    }
                    tisApp.SendMessage(sendText);
                    _face_block.close();
                    msg_input.val("")
                }else{
                    common.post_tips(rt);
                }
            });
        }
        /*message 添加到列表*/
        function appendTisMessage(msgBox, data, faceMap) {

            var last_time;
            if (msgBox.children().length >= temp.maxMesageNum) {
                msgBox.children().eq(0).remove();
            }
            /*text转表情*/
            for (var item in faceMap) {
                data.body = data.body.replace(new RegExp("\\" + item, "g"), "<img src='" + faceMap[item] + "'/>");
            }
            /*事件处理*/

            var timestr;

            if(data.time) {
                var date = new Date(data.time*1000);
                timestr = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            }
            /*生成html*/
            var msg_html=$('<div class="message ">' +
                ' <img class="avatar " src=""> ' +
                '<h4><span class="name"></span><span class="time"></span></h4> ' +
                '<p></p> ' +
                '<a class=" set-top" data-tip="设为置顶"><i class="iconfont">&#xe6ad;</i></a>' +
                '<a class=" cancel-top">取消置顶</a>' +
                '</div>');
            msg_html.find(".avatar").prop("src",!!data.image ? data.image : "http://cdn.aodianyun.com/tis/ui/perty/img/anonymous2.png");
            msg_html.find(".name").text(data.name);
            msg_html.data("time",data.time);
            msg_html.find(".time").text(timestr);
            msg_html.find(">p").html(data.body);
            var msg_list=msg_content.find(".message");
            total.find("span").text(msg_list.length);

            //if(sign == 1){
            //    //alert(typeof (data.time));
            //    if(($.inArray(data.time,arr['delete_list']) != -1)){
            //        msg_html = "";
            //    }
            //}
            msgBox.append(msg_html);

            /*todo  设置置顶*/

            /*设置置顶*/
            function set_top(dom){
                cancel_top(msg_content.find(".message .top"));
                var temp=dom.clone(),
                    warp=$(".pv-message");
                temp.data("ref",dom.index()).addClass("top");
                warp.append(temp);
                var h=dom.outerHeight();
                dom.addClass("hide");
                warp.css("padding-top",h + 30);
                /*todo  置顶*/
                temp.on("click",".cancel-top",function(){
                    cancel_top(temp);
                });
                warp.addClass("has-top");
            }

            /*取消设置置顶*/
            function cancel_top(dom){
                var ref=$(dom).data("ref"),
                    warp=$(".pv-message");
                msg_content.find(".message").eq(ref).removeClass("hide");
                $(dom).remove();
                $(".pv-message").css("padding-top",30);
                /*todo 取消置顶*/
                if(warp.find(".message.top").length<=0){
                    warp.removeClass("has-top");
                }
            }
            msg_html.on("click",".set-top",function(){
                set_top(msg_html);
            });
            /*控制滚动*/
            if(_msg_flag){
                msg_content.mCustomScrollbar("scrollTo","bottom");
            }
        }

        /*收到信息 触发*/
        function onReceiveMessage(data, container, faceMap) {
            var msglist = $(container + " .psm-contain");
            appendTisMessage(msglist, data, faceMap);
        }

        /*加载历史消息 触发*/
        function onLoadHistory(data, container, faceMap , opts) {
            var msglist = $(container + " .psm-contain");
            var list = data.list;
            var length = 0;
            if (list) {
                length = list.length;
            }
            for (var index = length - 1; index >= 0; --index) {
                var item = list[index];
                if (!item.content) continue;
                var msgdata;
                try {
                    msgdata = JSON.parse(item.content);
                    msgdata = opts.prepareMessage(msgdata);
                    appendTisMessage(msglist, msgdata, faceMap);
                } catch (ex) { }
            }
        }

        /*加载表情组*/
        function onLoadGroup(data, container, groupClicked) {
            /*默认不分组,直接触发*/
            $(container + " .face-btn").attr("gid",data[0].id).on("click",groupClicked);
            face_btn.on("click",function(){
                if(_face_block._isShow){
                    _face_block.close()
                }else{
                    _face_block.open();
                }
            });
        }

        /*加载表情*/
        function onLoadFaces(keys, faceMap, container, groupId) {
            var pagePanel = $(container + " .face-contain");
            if(pagePanel.data("loaded")!="true"){
                for (var index = 0; index < keys.length; index++) {
                    var item = keys[index],
                        temp=$('<a class="face-item" data-tip="添加表情"><img src=""></a>');
                    temp.find("img").prop("src", faceMap[item]);
                    temp.data("text",item);
                    pagePanel.append(temp);
                }
                pagePanel.data("loaded","true");
            }
        }
        /*生成对象*/
        temp = {
            onInitUI: onInitUI,               //必须，在这个时机去初始化界面
            onLoadHistory: onLoadHistory,          //可选，加载历史消息时调用，不填则不加载
            onLoadGroup: onLoadGroup,            //加载分组完毕时调用
            onLoadFaces: onLoadFaces,            //加载表情完毕时调用
            onReceiveMessage: onReceiveMessage,         //收到消息时调用
            onPreSendMessage: function (msg) { return true },         //发送消息之前调用
            setTisApp: function (_tisApp) {
                tisApp = _tisApp;
            },
            historyPageSize: 10,                        //加载历史消息的条数
            maxMesageNum:100,
            version: 1.2                                //模版版本
        };
        return temp;
    })();

/*初始化tis*/
function init_tis() {
    var api = TISAPI.New('msg', {
        tisId: "",
        accessId: "",
        accessKey: ""
    }, false);
    window.tis = TIS(".pv-message", {
        api: api,                               //必须
        useSSL: false,    //是否使用SSL连接，默认false
        name: $("#nick_name").val(),                           //我的名字
        image: $("#user_face").val(),          //我的头像
        generateUserEvent: true,             //可选，默认为true
        template:tis_temp,
        //以下均可选
        failure: function (error, when) {       //某个操作失败时调用
            if (typeof error != "string") {
                if (when == "sendMsg" && error.code == 400 && error.error == "instance closed") {
                    alert("TIS实例已关闭");
                    return;
                }
                alert(when + "操作失败");
            } else {
                alert("操作失败：" + error);
            }
        },
        onSendSuccess: function (data) {
            /*console.log("消息发送成功");*/
            var chat_num = $("#chat_num").val();
            $("#chat_num").val(Number(chat_num)+Number(1));
        },
        onReconnect: function () {
            /*console.log("正在与服务器重连");*/
        },
        onConnect: function (e) {
            window._tis_client=e;
            console.log("与服务器重连接成功");
},
        onLoadComponent: function () {
            console.log("组件加载完成");
        },
        updateUser: function (total, clientId) {
            $(".watch_count").html(total);
            console.log("在线人数:", total);
        }
    });
}

$(function(){
    _preview.init();
    _common.menu(0);
    init_tis();
    var url = $("#top_and_gag_url").val();
    var cid = $("#cid").val();
    common.ajax_post(url,{cid:cid},false,function(rt){
        var obj = common.str2json(rt);
        if(obj.code == 1){
            var arr = obj.ret_data;
            /*todo  置顶方法*/
            var top_obj={
                img:arr['top_info']['user_face'],
                name:arr['top_info']['nick_name'],
                time:arr['top_info']['send_time'],
                content:arr['top_info']['content']
            };
            _preview.top.set(top_obj);
        }
    });
});