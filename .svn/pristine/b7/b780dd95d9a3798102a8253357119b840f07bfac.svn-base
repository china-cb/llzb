/**
 * Created by 冯天元 on 2017/1/20.
 */
var WISAPI = function () {
    var timeout = 5000;
    function Api(url, extData, postJsonStr) {
        this.url = url;
        this.extData = extData;
        this.postJsonStr = postJsonStr;
        if (extData) {
            this.syncTimeout = parseInt(extData.syncTimeout);
            this.noSync = !!extData.noSync
        }
    }
    Api.prototype.post = function (data, option) {
        if (!option) option = {};
        if (this.extData) {
            for (var k in this.extData) {
                data[k] = this.extData[k];
            }
        }
        $.ajax({
            type: "POST",
            timeout: timeout,
            url: this.url,
            dataType: "json",
            data: this.postJsonStr?JSON.stringify(data):data,
            success: function (data) {
                if (data.Flag == 100) {
                    if (option.success) option.success(data.Info);
                } else {
                    if (option.failure) option.failure(data.FlagString);
                }
            },
            error: option.failure
        });
    }
    Api.prototype.choseDoc = function (option) {
        this.post({ method: "ChoseDoc", wisId: option.wisId, docId: option.docId, recordId: option.recordId, time: new Date().getTime() }, option)
    }
    Api.prototype.getPageInfo = function (option) {
        this.post({ method: "PageInfo", docId: option.docId, page: option.page, wisId: option.wisId }, option)
    }
    Api.prototype.getHistory = function (option) {
        this.post({ method: "History", wisId: option.wisId }, option)
    }
    Api.prototype.getWisInfo = function (option) {
        this.post({ method: "WisInfo", wisId: option.wisId }, option)
    }
    Api.prototype.getDocInfo = function (option) {
        this.post({ method: "DocInfo", docId: option.docId }, option)
    }
    Api.prototype.syncDraw = function (option) {
        if (this.noSync) {
            if (option.success) option.success({})
            return
        }
        var self = this;
        if (this.syncTimeout) {
            setTimeout(function () {
                self.post({ method: "SyncDraw", wisId: option.wisId, content: option.body, time: new Date().getTime() }, option)
            }, this.syncTimeout)
        } else {
            self.post({ method: "SyncDraw", wisId: option.wisId, content: option.body, time: new Date().getTime() }, option)
        }
    }
    Api.prototype.syncPage = function (option) {
        if (this.noSync) {
            if (option.success) option.success({})
            return
        }
        if (this.syncTimeout) {
            var self = this;
            setTimeout(function () {
                self.post({ method: "SyncPage", wisId: option.wisId, page: option.page, clientid: option.clientid, time: new Date().getTime() }, option)
            }, this.syncTimeout)
        } else {
            this.post({ method: "SyncPage", wisId: option.wisId, page: option.page, clientid: option.clientid, time: new Date().getTime() }, option)
        }
    }
    Api.prototype.allowDraw = function (option) {
        this.post({ method: "AllowDraw" }, option)
    }
    Api.prototype.customMessage = function (option) {
        this.post({ method: "CustomMessage", wisId: option.wisId, content: option.body, topic:option.topic }, option)
    }
    Api.prototype.getDocList = function (option) {
        this.post({ method: "DocList", skip: option.skip, num: option.num, wisId: (option.wisId?option.wisId:"") }, option)
    }
    //录制
    Api.prototype.startRecord = function (option) {
        this.post({ method: "SetRecordState", state: 1, wisId: option.wisId, lssApp: option.lssApp, lssStream: option.lssStream, title: option.title }, option)
    }
    Api.prototype.stopRecord = function (option) {
        this.post({ method: "SetRecordState", state: 0, wisId: option.wisId, lssApp: option.lssApp, lssStream: option.lssStream }, option)
    }
    Api.prototype.getRecordList = function (option) {
        this.post({ method: "RecordList", wisId: option.wisId, skip: option.skip != undefined ? option.skip : 0, num: option.num != undefined ? option.num : 100 }, option)
    }
    Api.prototype.getRecordData = function (option) {
        this.post({
            method: "RecordData", wisId: option.wisId, recordId: option.recordId,
            startTime: option.startTime, endTime: option.endTime, skip: option.skip, num: option.num
        }, option)
    }
    Api.prototype.getRecordInfo = function (option) {
        this.post({ method: "RecordInfo", wisId: option.wisId, recordId: option.recordId }, option)
    }
    //hls
    Api.prototype.getHlsData = function (option) {
        $.ajax({
            method: 'GET',
            url: "./index.php?c=wis&a=getData&url=" + encodeURIComponent(option.url),
            //crossDomain: true,
            error: option.failure,
            success: option.success
        });
    }
    //draw
    Api.prototype.getDrawData = function (option) {
        $.ajax({
            method: 'GET',
            url: "./index.php?c=wis&a=getData&url=" + encodeURIComponent(option.url),
            //crossDomain: true,
            error: option.failure,
            success: option.success
        });
    }
    return {
        New: function (url, extData, postJsonStr) {
            return new Api(url, extData, postJsonStr);
        }
    }
}();