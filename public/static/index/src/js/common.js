var _common=(function(){
    var menu_admin,
        menu,
        modal;
    function init(){
        menu=$(".header .hm-nav>a");
        menu_admin=$(".header.admin .hm-menu>li");
        modal=$(".modal");
        set_raf();
        init_admin_menu();
        init_admin_content();
        modal_init();
        drop_down_init();
        mouse_tip("[data-tip]","tip",20,0);
    }
    /*菜单设置*/
    function set_menu(i){
        i=i?i:0;
        if(menu.length>0)
            menu.removeClass("active").eq(i).addClass("active");
        if(menu_admin.length>0)
            menu_admin.removeClass("active").eq(i).addClass("active");
    }

    /*admin 菜单设置*/
    function init_admin_menu(){
        if(menu_admin.length<=0)
            return;
        menu_admin.on("click",function(){
            var content=$(this).find(">.mi-list");
            if(content.length>0){
                if($(this).hasClass(".mc-close")){
                    content.removeClass("active");
                    item.height(0);
                    return;
                }
                var item=content.find(".menu-content"),
                    dh=0;
                item.children().each(function(){
                    dh=dh+$(this).outerHeight()+parseInt($(this).css("margin-top"))+parseInt($(this).css("margin-bottom"));
                });
                if(content.hasClass("active")){
                    content.removeClass("active");
                    item.height(0);
                }else{
                    content.addClass("active");
                    requestAnimationFrame(function(){
                        item.height(dh);
                    });
                }
            }
        });
        $(document).on("click",function(e){
            var target=$(e.target||e.toElement);
            if(!target.hasClass("mi-list")&&target.parents(".mi-list").length<=0){
                menu_admin.find(">.mi-list").removeClass("active").end().find(".menu-content").height(0);
            }
        });

    }
    /*admin 内容页&分类菜单控制*/
    function init_admin_content(){
        var con=$(".admin.main>.container");
        if(con.length<=0){
            return;
        }

        var menu=con.find(".menu"),
            content=con.find(".content");
        menu.on("click",".menu-item",function () {
            menu=con.find(".menu-item").removeClass("active");
            menu.find(".item-group").removeClass("active");
            var temp=$(this);
            temp.addClass("active");
            var items=temp.find(".item-group");
            if(items.length>0){
                items.addClass("active");
            }
            fresh_height();
        });

        /*控制高度*/
        function fresh_height(){
            setTimeout(function(){
                var mh=menu.parent().height(),
                    ch=content.height();
                if(mh>ch){
                    content.height(mh);
                }
            },300);
        }
    }

    /*modal 初始化*/
    function modal_init(){
        modal.each(function(){
            var temp=$(this);
            $(this).find(".close").on("click",function(){
                temp.removeClass("active");
                setTimeout(function(){
                    temp.hide();
                },300);
            });
        });
    }

    /*drop_down初始化*/
    function drop_down_init(){
        var dp=$(".drop-sel");
        dp.each(function(){
            var temp=$(this);
            temp.find(".dp-content").on("click",function(e){
               var target=$(e.target||e.toElement);
                if(target.hasClass("dp-item")){
                    temp.removeClass("active").find(".dp-text").text(target.text()).end().find("input").val(target.data("val"));
                }else{
                    if(temp.hasClass("active")){
                        temp.removeClass("active");
                    }else{
                        temp.addClass("active");
                    }
                }
            })
        });
        $(document).on("click",function(e){
            var target=$(e.target||e.toElement);
            if(!target.hasClass(".drop-sel")&&target.parents(".drop-sel").length<=0){
                dp.removeClass("active");
            }
        });
    }

    /*波纹按钮*/
    function set_pos_click(){
        $(document).on("onmousedown",".ripple-btn",function(e){
            var os=$(this).offset(),
                x=e.pageX,
                y=e.pageY;
            set_pos_dom($(this),"rgba(0,0,0,0.3)",x-os.left,y-os.top);
        });
        /*按钮生成与删除*/
        function set_pos_dom(obj,color,p_x,p_y){
            var w=obj.outerWidth(),
                h=obj.outerHeight(),
                b_v=h>w?h:w;
            if(!color){
                color="rgba(0,0,0,0.1)";
            }
            var temp=$("<b></b>"),
                css_obj={
                    "position":"absolute",
                    "width":b_v*2,
                    "height":b_v*2,
                    "display":"block",
                    "-webkit-transition": "all 0.4s ease-out",
                    "transition": "all 0.4s ease-out",
                    "-moz-transition": "all 0.4s ease-out",
                    "border-radius":"100%",
                    "-webkit-transform": "scale(0)",
                    "transform": "scale(0)",
                    "-moz-transform": "scale(0)",
                    "opacity":0,
                    "background-color":color,
                    "z-index":1,
                    "left":p_x-b_v,
                    "top":p_y-b_v
                };

            if(obj.css("position")=="static"){
                obj.css("position","relative");
            }
            obj.css("overflow","hidden");
            obj.append(temp);
            temp.css(css_obj);
            requestAnimationFrame(function(){
                temp.css({
                    "-webkit-transform": "scale(1)",
                    "transform": "scale(1)",
                    "-moz-transform": "scale(1)",
                    "opacity":1,
                }).one("webkitTransitionEnd transitionend" ,function(){
                    requestAnimationFrame(function(){
                        temp.remove();
                    });
                });
            });
        }
    }

    /*自定义tips*/
    function mouse_tip(selector,tip,fix_x,fix_y){
        var dom,
            live_on=false;
        if(typeof(selector)=='string')
        {
            dom=$(selector);
            live_on=true;
        }
        if(typeof(selector)=="object")
        {
            dom=selector;
        }
        if(dom.length<=0)
            return;
        tip=tip?tip:"tip";
        fix_x=fix_x?parseInt(fix_x):10;
        fix_y=fix_y?parseInt(fix_y):10;
        var m_tip=$(".mouse_tip");
        if(m_tip.length<=0){
            m_tip=$("<div class='mouse_tip'></div>").css({
                    "padding":"4px 8px",
                    "border-radius": "0px 10px 10px 10px",
                    "background": "rgba(0,0,0,0.4)",
                    "+background":"#000",
                    "font-size":"12px",
                    "color":"#fff",
                    "max-width":"450px",
                    "z-index":10000,
                    "position": "fixed",
                    "letter-spacing":"1px",
                    "display": "none",
                    "text-align":"left",
                    "box-shadow":"0 0 1px rgba(255,255,255,0.5),0 0 3px #fff"
                }
            );
            $("body").append(m_tip);
        }
        if(live_on) {
            $(document).on("mousemove mouseleave", selector, function (e) {
                if (e.type == "mousemove") {
                    var tom = $(this);
                    if (tom.data(tip)) {
                        var top = $(document).scrollTop();
                        m_tip.text(tom.data(tip));
                        m_tip.show().css("left", e.pageX + fix_x).css("top", e.pageY - top + fix_y);
                    }
                }
                else {
                    m_tip.hide();
                }

            });
        }else{
            dom.on("mousemove mouseleave", function (e) {
                if (e.type == "mousemove") {
                    var tom = $(this);
                    if (tom.data(tip)) {
                        var top = $(document).scrollTop();
                        m_tip.text(tom.data(tip));
                        m_tip.show().css("left", e.pageX + fix_x).css("top", e.pageY - top + fix_y);
                    }
                }
                else {
                    m_tip.hide();
                }
            });
        }
    }

    /*配置requestAnimationFrame*/
    function set_raf(){
        var lastTime = 0;
        var vendors = ['ms', 'moz', 'webkit', 'o'];
        for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
            window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
            window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] || window[vendors[x] + 'CancelRequestAnimationFrame'];
        }
        if (!window.requestAnimationFrame) window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16.7 - (currTime - lastTime));
            var id = window.setTimeout(function() {
                callback(currTime + timeToCall);
            }, timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
        if (!window.cancelAnimationFrame) window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }

    function init_modal_obj(html,fun){
        var obj=$(html);
        $("body").append(obj);
        if(typeof(fun)=="function"){
            fun(html);
        }
        obj.open=function(){

            obj.show();
            requestAnimationFrame(function(){
                obj.addClass("active");
            });
        };
        obj.close=function(){
            obj.removeClass("active");
            setTimeout(function(){
                obj.hide();
            },300);
        };
        obj.find(".close").on("click",function(){
            obj.close();
        });
        return obj;
    }

    function init_share(fun){
        var html='<div class="modal modal-share"> ' +
            '<div class="modal-main"> <span class="close"><i class="iconfont">&#xe61f;</i></span> ' +
            '<span class="title">分享到</span> ' +
            '<ul class="shares-list">' +
            ' <li class="item sc-item zo active" data-share="space">空间</li>' +
            ' <li class="item sc-item qq" data-share="qq" >QQ</li> ' +
            '<li class="item sc-item wc" data-share="wechat" >微信</li> ' +
            '<li class="item sc-item wb" data-share="sina" >微博</li> ' +
            '<li class="item sc-item fs" data-share="friends">朋友圈</li> ' +
            '</ul>' +
            ' <div class="share-form"> ' +
            '<label class="share-input">' +
            ' <textarea id="share_speak" onkeyup="count_num();" maxlength="200"></textarea>' +
            ' <span data-max="200"><i id="share_num">0</i>/200</span> </label>' +
            ' <button class="share-submit">分享</button> </div> </div> </div>';
        return init_modal_obj(html,fun);
    }

    function init_phone_qr(fun){
        var html=' <div class="modal modal-qr-phone"> ' +
            '<div class="modal-main"> <span class="close">&#xe61f;</span> <h4>扫描二维码,手机观看</h4>' +
            ' <div class="qr-main"> <img id="phone_qr" src=""> </div> </div> </div>';
        return init_modal_obj(html,fun);
    }



    return {
        init:init,
        menu:set_menu,
        modal:{
            open:function(selector){
                var temp=modal.filter(selector);
                temp.show();
                requestAnimationFrame(function(){
                    temp.addClass("active");
                });
            },
            close:function(selector){
                var temp=modal.filter(selector);
                temp.removeClass("active");
                setTimeout(function(){
                    temp.hide();
                },300);
            }
        },
        rippleBtn:set_pos_click,
        get_share:init_share,
        get_qr_mobile:init_phone_qr
    }
})();
$(function(){
    _common.init();
});
