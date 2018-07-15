/**
 * Created by deloo on 2016/12/23.
 */
var monitor=(function(){
    var nav,
        block,
        v_list,
        v_con;
    function init(){
        init_view_menu();
        init_view_list();
        init_doc_list();
        init_list_view();
        init_mes_list();
    }
    function init_view_menu(){
        nav=$(".view-top .info .nav a");
        block=$(".view-top .info .content");
        set_index();
        function set_index(i) {
            if(!i){
                i=0;
            }
            nav.removeClass("active").eq(i).addClass("active");
            block.removeClass("active").eq(i).addClass("active");
        }
        nav.on("click",function(){
            set_index($(this).index());
        });
    }
    function init_view_list(){
        v_list=$(".view-list-menu");
    }
    /*初始化docList*/
    function init_doc_list(){
        var list=$(".doc-list>.container");
        list.mCustomScrollbar({theme:"llzb-common"});
    }
    /*初始化列表直播*/
    function init_list_view(){
        /*todo  修改生成ID*/
        var id_base="ref_",
            start_id=0;
        var menu=$(".view-list .view-list-menu"),
            content=$(".view-list .view-content"),
            empty_list=$(".empty.empty-warp");
        content.find(".vc-block>.container").each(function(){
            $(this).mCustomScrollbar({theme:"llzb-common"});
        });
        menu.mCustomScrollbar({theme:"llzb-common"});
        menu.on("click",".item .edit",function(){
            $(this).parents(".item").eq(0).addClass("edit");
        });
        menu.on("click",".item>label .ensure",function(){
            var obj = $(this);
            var name = obj.siblings(".list_name").val();
            var id = obj.parents(".channel-video").data('id');
            var url = $("#edit_video_url").val();
            common.ajax_post(url,{list_name:name,list_id:id},true,function(rt){
                 var obs = common.str2json(rt);
                if(obs.code == 1){
                    obj.parent().siblings(".list-name").html(name);
                }else{
                    common.post_tips(rt);
                }
            });
            $(this).parents(".item").eq(0).removeClass("edit");
            /*todo 保存*/
        });
        menu.on("click",".item:not(.add)",function(){
            set_index($(this).index());
        });
        menu.on("click",".item .delete",function(){
            var dom=$(this).parents(".item").eq(0),
                ref=dom.data("listid");
            console.log(dom,dom.data());
            var obj = $(this);
            var id = obj.parents(".channel-video").data('id');
            var url = $("#del_video_list").val();
            var index = layer.confirm("您确定要删除该列表吗?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
                common.ajax_post(url,{id:id},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        layer.close(index);
                        /*todo 删除*/
                         dom.remove();
                        console.log(ref);
                        content.find("#"+ref).remove();
                        $(".mouse_tip").hide();
                        var list=content.find(".vc-block");
                        if(list.length<=0){
                            empty_list.show();
                        }else{
                            empty_list.hide();
                            menu.find(".item:not(.add)").eq(0).trigger("click");
                        }
                    }else{
                        common.post_tips(rt);
                    }
                },true);
            });
        });
        menu.on("click",".item.add",function(){
            var id = $(this).data('id');
            var url = $("#add_video_url").val();
            common.ajax_post(url,{cid:id},true,function(rt){
                 var obj = common.str2json(rt);
                 if(obj.code == 1){
                     var id = obj.ret_data;
                     /*todo 添加列表 生成数据*/
                     var list={
                         name:"未定列表",
                         id:id_base+id
                     };
                     var temp_menu=$('<li data-listid="'+list.id+'" class="item channel-video" data-id="'+id+'"><span class="list-name"></span><label>' +
                         '<input class="list_name" type="text"><a class="ensure" data-tip="保存"></a></label>' +
                         '<a class=" edit" data-tip="编辑"></a><a class="delete" data-tip="删除"></a></li>');
                     temp_menu.data("listid",list.id);
                     temp_menu.find(">span").text(list.name);
                     menu.find(".item").last().after(temp_menu);
                     var block=$('<div  class="vc-block"><div class="container con-empty">' +
                         '<div class="empty"> <h6>当前列表为空</h6> ' +
                         '<a class="upload_video" data-lid="id"><i class="iconfont">&#xe638;</i>添加视频</a> </div> </div> </div>');
                     block.prop("id",list.id).find(">.container").mCustomScrollbar({theme:"llzb-common"});
                     /*content.find(".vc-block").last().after(block);*/
                     content.append(block);
                     set_index(temp_menu.index());
                     var list_temp=content.find(".vc-block");
                     if(list_temp.length<=0){
                         empty_list.show();
                     }else{
                         empty_list.hide();
                     }
                 }else{
                     common.post_tips(rt);
                 }
            });

        });
        set_index(1);
        /*切换列表*/
        function set_index(i){
            var temp=menu.find(".item").eq(i);
            menu.find(".item").removeClass("active");
            temp.addClass("active");
            var ref=temp.data("listid");
            content.find(".vc-block").removeClass("active").filter("#"+ref).addClass("active");
        }

    }
    /*初始化msg列表*/
    function init_mes_list(){
        var list=$(".mes-list>.container");
        list.mCustomScrollbar({theme:"llzb-common"});
    }
    /*添加tips*/
    /*禁言 forbid*/
    /*置顶 top*/
    function add_tips(text,cls){
        var html=$('<span class="con-tips "></span>'),
            block=$(".view-message");
        html.text(text).addClass(cls);
        var tips=block.find(".con-tips");
        tips.addClass("hide");
        setTimeout(function(){
            tips.remove();
        },200);
        block.append(html);
        setTimeout(function(){
            html.addClass("hide");
            setTimeout(function(){
                html.remove();
            },300);
        },1200)
    }
    return init;
})();

var tis_temp = (function () {
    var tisApp,                 /*tis*/
        temp,                   /*模板对象定义*/
        dom,                    /*tis-dom*/
        _face_block,            /*表情块*/
        _msg_flag=true,         /*自动滚动锁定标志*/
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
        msg_block =dom.find(".container");
        msg_send=dom.find(".doc-send");
        msg_input=dom.find("input");
        msg_content=dom.find(".mes-l-warp");
        _face_block = msg_send.find(".face-block");
        face_btn = msg_send.find(".face");
        _face_block.find(".face-warp").html("");
        dom.find(".mes-l-warp").html("");
        init_face_group();
        bind_send();

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

        msg_send.find(".send").on("click",function(){
            sendMessage();
        });
    }

    /*信息发送*/
    function sendMessage() {
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
    }

    /*message 添加到列表*/
    function appendTisMessage(msgBox, data, faceMap) {
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
        var msg_html=$('<li class="item"><div class="warp">' +
            '<img src="/static/index/src/img/temp/user_ava.png" class="">' +
            '<h4></h4>' +
            '<p data-tip=""></p> ' +
            '<div class="right-info"><span></span> ' +
            '<div class="controls"> ' +
                '<a class="control-btn top top_do" data-tip="置顶"><i class="iconfont">&#xe6ad;</i></a> ' +
                '<a class="control-btn cancel-top" data-tip="取消置顶">取消置顶</a> ' +
                '<a class="control-btn cancel-forbid" data-tip="取消禁言">取消禁言</a> ' +
                '<a class="control-btn forbid" data-tip="禁言"><i class="iconfont">&#xe710;</i></a> ' +
                '<a class="control-btn del" data-tip="删除"><i class="iconfont">&#xe623;</i></a>' +
            '</div> </div></div></li>');
        msg_html.find("img").prop("src",!!data.image ? data.image : "http://cdn.aodianyun.com/tis/ui/perty/img/anonymous2.png");
        msg_html.find("h4").text(data.name);
        msg_html.find(".right-info>span").text(timestr);
        msg_html.find("p").html(data.body);
        msg_html.data('sender',data);
        /* todo 判断置顶 & 判断禁言*/
        if(sign == 1){
            if(arr['top_info']['send_time'] == data.time){
                msg_html.addClass("top");
            }
        }
        if(sign == 1){
             var ss = JSON.parse(data.extra);
             if(($.inArray(ss.user_value,arr['gag_list']) != -1)){
                 msg_html.addClass("forbid");
             }
        }
        if(sign == 1){
            //alert(typeof (data.time));
            if(($.inArray(data.time,arr['delete_list']) != -1)){
                msg_html = "";
            }
        }
        /*
        * 置顶
        * msg_html.addClass("top");
        * *
        * 禁言
        *  msg_html.addClass("forbid");
        * */
        msgBox.append(msg_html);
        /*控制滚动*/
        if(_msg_flag){
            msg_block.mCustomScrollbar("scrollTo","bottom");
        }
    }

    /*收到信息 触发*/
    function onReceiveMessage(data, container, faceMap) {
        var msglist = $(container + " .mes-l-warp");
        appendTisMessage(msglist, data, faceMap);
    }

    /*加载历史消息 触发*/
    function onLoadHistory(data, container, faceMap , opts) {
        var msglist = $(container + " .mes-l-warp");
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
        $(container + " .face").attr("gid",data[0].id).on("click",groupClicked);
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
        var pagePanel = $(container + " .face-warp");
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
        accessKey: " "
    }, false);
    window.tis = TIS(".mes-list", {
        api: api,                               //必须
        useSSL: false,    //是否使用SSL连接，默认false
        name: "官方",                           //我的名字
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
            console.log("在线人数:", total);
        }
    });
}



$(function(){
    monitor();
    _admin.menu(3);
    init_tis();
    var cid = $("#cid").val();
    var delete_tis_url = $("#delete_tis_url").val();
    /**置顶*/
    $(document).on("click",".item .top_do",function(){
        var btn = $(this);
        layer.confirm("您确定要将该条消息置顶吗?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
            var obj = btn.parents(".item").eq(0).data("sender");
            var ss = JSON.parse(obj.extra);
            var top_url = $("#top_url").val();
            common.ajax_post(top_url,{cid:cid,nick_name:obj.name,user_face:obj.image,content:obj.body,send_time:obj.time,user_type:ss.user_type,user_value:ss.user_value},false,function(rt){
                var obj = common.str2json(rt);
                common.post_tips(rt);
                if(obj.code == 1){
                    /*成功的回调*/
                    btn.parents(".item").addClass("top");
                }
            });
        });
    });

    /** 取消置顶 */
    $(document).on("click",".cancel-top",function(){
        var btn = $(this);
        layer.confirm("您确定要取消该条消息的置顶吗?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
            var obj = btn.parents(".item").eq(0).data("sender");
            var ss = JSON.parse(obj.extra);
            var cancel_top_url = $("#cancel_top_url").val();
            common.ajax_post(cancel_top_url,{cid:cid,user_type:ss.user_type,user_value:ss.user_value},true,function(rt){
                var obj = common.str2json(rt);
                common.post_tips(rt);
                if(obj.code == 1){
                    /*成功的回调*/
                    btn.parents(".item").removeClass("top");
                }
            });
        });
    });

    /**禁言*/
    $(document).on("click",".item .forbid",function(){
        var btn = $(this);
        layer.confirm("您确定要将该用户禁言吗?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
            var obj = btn.parents(".item").eq(0).data("sender");
            var ss = JSON.parse(obj.extra);
            var gag_url = $("#gag_url").val();
            //alert(gag_url);
            //alert(ss.user_type);
            common.ajax_post(gag_url,{cid:cid,is_gag:1,user_type:ss.user_type,user_value:ss.user_value},false,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    /*成功的回调*/
                    add_tips("用户:"+obj.ret_data+"被禁言","forbid");
                    btn.hide();
                    btn.siblings(".cancel-forbid").show();
                    layer.closeAll();
                }else{
                    common.post_tips(rt);
                }
            });
        });
    });

    /**解禁*/
    $(document).on("click",".item .cancel-forbid",function(){
        var btn = $(this);
        layer.confirm("您确定要将该用户解禁吗?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
            var obj = btn.parents(".item").eq(0).data("sender");
            var ss = JSON.parse(obj.extra);
            var gag_url = $("#gag_url").val();
            //alert(gag_url);
            //alert(ss.user_type);
            common.ajax_post(gag_url,{cid:cid,is_gag:0,user_type:ss.user_type,user_value:ss.user_value},false,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    /*成功的回调*/
                    add_tips("用户:"+obj.ret_data+"被解禁","forbid");
                    btn.hide();
                    btn.siblings(".forbid").show();
                    layer.closeAll();
                }else{
                    common.post_tips(rt);
                }
            });
        });
    });

    /**删除*/
    $(document).on("click",".item .del",function(){
        var btn = $(this);
        var delete_layer = layer.confirm("您确定要删除该条消息么?",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
            var obs = btn.parents(".item").eq(0).data("sender");
            common.ajax_post(delete_tis_url,{cid:cid,send_time:obs.time},true, function (rt) {
                 var obj = common.str2json(rt);
                 if(obj.code == 1){
                     btn.parents(".item").fadeOut("slow");
                     layer.close(delete_layer);
                 }else{
                     common.post_tips(rt);
                 }
            });
        });
    });

    /*添加tips*/
    /*禁言 forbid*/
    /*置顶 top*/
    function add_tips(text,cls){
        var html=$('<span class="con-tips "></span>'),
            block=$(".view-message");
        html.text(text).addClass(cls);
        var tips=block.find(".con-tips");
        tips.addClass("hide");
        setTimeout(function(){
            tips.remove();
        },200);
        block.append(html);
        setTimeout(function(){
            html.addClass("hide");
            setTimeout(function(){
                html.remove();
            },300);
        },1200)
    }
});