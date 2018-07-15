/**
 * Created by deloo on 2016/12/26.
 */
var _live_reward=(function(){
    var modal;
    function init() {
        init_block();
        init_info_modal();
        file_upload();
    }

    /*初始化菜单切换*/
    function init_block(){
        var menu=$(".gc-menu"),
            content=$(".gc-content>.warp");
        set_index();
        menu.find(">a").on("click",function(){

            set_index($(this).index());
        });
        function set_index(i){
            if(!i){
                i=0;

            }
            menu.find(">a").removeClass("active").eq(i).addClass("active");
            if(i==1){
                $(".gift-tips").show();
            }else{
                $(".gift-tips").hide();
            }
            content.removeClass("active").eq(i).addClass("active");
        }
    }

    function init_info_modal(){
        modal=$(".modal.modal-gift");
        modal.find(".modal-main>a").on("click",function(){
            modal.removeClass("active");
            setTimeout(function(){
                modal.hide();
            },300);
        });
    }
     // 上传图片
    function file_upload(){
        $(".file_upload").change(function() {
            var $file = $(this);
            var $file_indx = $(this).index(".file_upload");
            var fileObj = $file[0];
            var windowURL = window.URL || window.webkitURL;
            var dataURL;
            var $img = $(".preview").eq($file_indx);
            if(fileObj && fileObj.files && fileObj.files[0]){
                dataURL = windowURL.createObjectURL(fileObj.files[0]);
                $img.attr('src',dataURL);
            }else{
                dataURL = $file.val();
                var imgObj = $(".preview").eq($file_indx);
                }
            });
        }
    /*提示弹层*/
    function show_tip(){
        _common.modal.open($(".modal.modal-gift"));
    }
    return {
        init:init,
        tip:show_tip
    };
})();
$(function(){
    _live_reward.init();
});
console.log('12');