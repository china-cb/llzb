/**
 * Created by deloo on 2016/11/30.
 */
var _admin=(function(){
        var menu_admin;
        function init(){
            menu_admin=$(".header.admin .hm-menu>li");
        }
        /*定义菜单位置*/
        function menu(n,m){
            if(n){
                menu.eq(n).trigger("click");
                if(m){
                    menu.find(".ig-item").removeClass("active").eq(m).addClass("active");
                }
            }
        }
        return {
            menu:menu,
            init:init
        }
    })();

$(function(){
    _admin.init();

});