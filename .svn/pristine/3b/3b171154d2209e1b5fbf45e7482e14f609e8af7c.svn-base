/**
 * Created by 冯天元 on 2017/2/4.
 */
$(function(){
   var func = {
       init:function(){

       },
       get_help_menu:function(btn){
           var id = $(btn).data('id');
           var value = $(btn).data('value');
           var url = $("#get_help_list_url").val();
           common.ajax_post(url,{id:id,value:value},true,function(rt){
               var obj = common.str2json(rt);
               if(obj.code == 1){
                   $(".block").html(obj.html);
               }
           });
       }
   };

    //选项卡
    $(document).on("click",".ig-item",function(){
        $(".ig-item").removeClass("active");
        $(this).addClass("active");
        func.get_help_menu(this);
    });

    //获取帮助中心文章内容
    $(document).on("click",".item-category",function(){
        var id = $(this).data('id');
        var value = $(this).data('value');
        var url = $("#help_url").val();
        common.ajax_post(url,{id:id,value:value},true,function(rt){
            var obj = common.str2json(rt);
            if(obj.code == 1){
                $(".content").html(obj.html);
            }else{
                common.post_tips(rt);
            }
        });
    });

    //顶部导航栏
    $(document).on("click",".top-category",function(){
        func.get_help_menu(this);
    });
});