/**
 * Created by 冯天元 on 2016/12/30.
 */
$(function(){
    var func = {
        init : function(){

        },
        rtmp_live:function(live_url){
            var url = $("#update_live").val();
            common.ajax_post(url,{live_url:live_url},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                   $(".object").html(obj.html);
                }
            },true);
        },
        hlsUrl_live:function(btn){
            var cid = $("#cid").val();
            var lid = $(btn).data('lid');
            var url = $("#hls_live_url").val();
            common.ajax_post(url,{cid:cid,lid:lid},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    $(".object").html(obj.html);
                }
            },true);
        }
    };
    //视频上传
    $(document).on("click",".upload_video",function(){
         var url = $("#upload_html_url").val();
         var cid = $("#cid").val();
         var lid = $(this).data('lid');
        common.ajax_post(url,{cid:cid,lid:lid},true,function(rt){
            var obj = common.str2json(rt);
            if(obj.code == 1){
                layer.open({
                    skin: 'layui-layer-rim',
                    type: 1,
                    area: ['600px', '400px'],
                    fix: false, //不固定
                    title:"视频上传",
                    //closeBtn: true,
                    content: obj.html,
                    success:function(rt){
                        $('.layui-layer-close').trigger("click");
                    }
                });
            }else{
               common.post_tips(rt);
            }
        })
    });
    ////拉流直播
    //$(document).on("click",".start_live",function(){
    //    var url = $(".rtmp_url").val();
    //    func.rtmp_live(url);
    //});
    //
});