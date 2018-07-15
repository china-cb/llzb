/**
 * Created by 冯天元 on 2016/12/13.
 */
$(function(){
    var func = {
        init:function(){
        },
        set_channel:function(){
            var url = $("#set_channel_url").val();
            var title = $("#channel_name").val();
            if(title == ""){
                layer.msg("频道名称不能为空");
                return false;
            }
            common.ajax_post(url,{title:title},true,function(rt){
                 common.post_tips(rt);
                 var obj = common.str2json(rt);
                if(obj.code == 1){
                    location.reload();
                }
            },true);
        },
        search_channel:function(){
            var url = $("#search_channel_url").val();
            var title = $(".channel_name").val();
            if(title == ""){
                layer.tips('请输入视频名称', '.channel_name', {tips: [4, '#00c1df'], time: 2000});
                return false;
            }
            common.ajax_post(url,{title:title},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    $(".channel-group").html(obj.html);
                }else{
                    common.post_tips(rt);
                }
            },true,[0.3,'#444']);
        },
        del_channel:function(btn){
            var index = layer.confirm("确定要删除该频道吗?",{btn:["确定","取消"],title:false,icon:3},function(){
                 var url = $("#del_channel_url").val();
                 var id = $(btn).parent().data('id');
                 common.ajax_post(url,{id:id},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        layer.close(index);
                        $(btn).parents(".channel-item").fadeOut("slow");
                    }else{
                        common.post_tips(rt);
                    }
                },true,[0.3,'#444']);
            });
        },
        channel_user:function(btn){
            var object = $(btn);
            var id = object.data('val');
            var url = $("#channel_user_url").val();
            common.ajax_post(url,{id:id},true,function(rt){
                var obs = common.str2json(rt);
                if(obs.code == 1){
                    $(".all_count_num").html(obs.total);
                    $(".user_count").html(obs.html);
                    if(obs.total != 0){
                        $(".export_data_btn").attr('href',id);
                        $(".export_data_btn").show();
                    }else{
                        $(".export_data_btn").hide();
                    }
                }else{
                    common.post_tips(rt);
                }
            },true,[0.3,'#444']);
        }
        //channel_count:function(btn){
        //    var id = $(btn).data('val');
        //    var url = $("#channel_count").val();
        //    common.ajax_post(url,{id:id},true,function(rt){
        //        var object = common.str2json(rt);
        //        if(object.code == 1){
        //            $(".now_channel").html(object.channel_title);
        //            $(".channel_content").html(object.html);
        //        }else{
        //            common.post_tips(rt);
        //        }
        //    },true,[0.3,'#444']);
        //}
    };
    func.init();
    /** 创建频道 */
    $(document).on("click",".set_channel_btn",function(){
        func.set_channel();
    });

    /** 搜索频道 */
    $(document).on("click",".search_channel_btn",function(){
        func.search_channel();
    });

    /** 删除频道 */
    $(document).on("click",".del_channel_btn",function(){
        func.del_channel(this);
    });

    /** 根据频道名称获取用户信息 */
    $(document).on("click",".channel_title",function(){
        func.channel_user(this);
    });

    /** 流地址弹层关闭 */
    $(document).on("click",".url_close",function(){
        _common.modal.close($(".modal.m-channel-url"));
    });

    /** 选项卡切换 */
    $(document).on("click",".item_btn",function(){
        $(".item").removeClass("active");
        $(".block.channel-block").removeClass("active");
        $(this).addClass("active");
        var type = $(this).data("type");
        if(type == "list"){
            $(".channel-list").addClass("active");
        }else if(type == "data"){
            $(".channel-data").addClass("active");
        }
    });

    /** 流地址的复制 */
    $(document).on('click','.copy',function(){
        var id = $(this).data('id');
        var Url1=document.getElementById(id);
        Url1.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        layer.msg('已复制,按ctr+v粘贴',{time:1000});
    });


});