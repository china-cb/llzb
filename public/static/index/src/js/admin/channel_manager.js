/**
 * Created by deloo on 2016/12/8.
 */

_channelManager=(function(){
    var lives,
        blocks,
        block_menu,
        data_block,
        data_menu;
    /*初始化*/
    function init(){
        lives=$(".channel-group > .channel-item");
        blocks=$(".content .channel-block");
        block_menu=$(".channel_menu > .item");
        data_block=$(".channel-data .cd-block");
        data_menu=$(".channel-data .cd-menu .cdm-item");
        set_zoom_index();
        set_change_block();
        set_change_data_block();
        init_add_modal();
        init_url_modal();
    }
    /*设置不同zoom*/
    function set_zoom_index() {
        if(lives.length>0){
            lives.each(function(i){
                $(this).css("z-index",lives.length-i);
            });
        }
    }
    /*设置切换block*/
    function set_change_block(){
        set_index();
        block_menu.on("click",function(){
            set_index($(this).index());
        });
        function set_index(i){
            if(!i){
                i=0;
            }
            blocks.removeClass("active").eq(i).addClass("active");
            block_menu.removeClass("active").eq(i).addClass("active");
        }
    }
    /*设置切换data-block*/
    function set_change_data_block(){
        set_index();
        data_menu.on("click",function(){
            set_index($(this).index());
        });
        function set_index(i){
            if(!i){
                i=0;
            }
            data_block.removeClass("active").eq(i).addClass("active");
            data_menu.removeClass("active").eq(i).addClass("active");
        }
    }
    /*初始化弹层*/
    function init_add_modal(){
        var add_btn=$(".channel-item.add-new"),
            add_modal=$(".modal.m-channel-add");
        add_btn.on("click",function(){
            _common.modal.open(add_modal);
        });
    }

    /*初始化地址弹层*/
    function init_url_modal() {
        var btn=$(".location"),
            modal=$(".modal.m-channel-url");
        btn.on("click",function(){

            var url = $("#liu_channel_url").val();
            var cid = $(this).parent().data('id');
            common.ajax_post(url,{cid:cid},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    var data = obj.ret_data;
                    $(".channel_img").attr("src",data.cover);
                    $(".channel_title").html(data.title);
                    $("#push").val(data.push_url);
                    $("#rtmp").val(data.rtmp);
                    $("#hls").val(data.hls);
                    _common.modal.open(modal);
                }else{
                    common.post_tips(rt);
                }
            });
        });
        modal.find(".m-url-list").mCustomScrollbar({
            theme:"llzb-view"
        });

    }

    return {
        init:init
    }

})();
$(function(){
    _common.menu(1);
    _channelManager.init();
});