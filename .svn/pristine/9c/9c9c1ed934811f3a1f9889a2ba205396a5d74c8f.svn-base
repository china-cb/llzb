
$(function(){
    var func = {
        edit:function(obj) {
            var url = $("#edit_url").val();
            var id = obj.data('id');
            layer_show('举报编辑',url,id,null,1000,500);
        },

        del: function(obj){
            layer.confirm('确认删除吗?',{title:false,closeBtn:false},function(){
                var url = $("#del_url").val();
                var id = obj.data('id');
                if(url=='undefined'){
                    layer.msg('请求地址错误');
                    return;
                }
                common.ajax_post(url,{id:id},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        layer.msg(obj.msg,{icon:1});
                        location.reload();
                    }else{
                        layer.msg(obj.msg,{icon:2});
                    }
                });
            });

        },
        up_message: function(obj){
                var url = $("#up_report_message").val();
                var id = obj.data('id');
                common.ajax_post(url,{id:id},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        layer.msg(obj.msg,{icon:1});
                        location.reload();
                    }else{
                        layer.msg(obj.msg,{icon:2});
                    }
                });
        },
        //批量标记已读
        up_all_message:function(){
            var check_audit = $('.check:checked');
            var url = $('#up_all_message').val();

            var check_str = '';
            check_audit.each(function () {
                check_str += $(this).data('id') + ',';

            });
            check_str = check_str.substring(0,check_str.length-1);
            layer.confirm("您确定要批量标记选中的文章么?",{
                btn:["确定","取消"]
            },function(){
                common.ajax_post(url,{id:check_str},true,function(rt){
                    common.post_tips(rt);
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        location.replace(location);
                    }
                })
            })
        },
        //批量删除
        del_all:function(){
            var check_audit = $('.check:checked');
            var url = $('#del_all_url').val();
            if(check_audit.length == 0) {
                layer.msg('请选择要删除的文章',{icon:2});
                return false;
            }
            var check_str = '';
            check_audit.each(function () {
                check_str += $(this).data('id') + ',';

            });
            check_str = check_str.substring(0,check_str.length-1);
            layer.confirm("您确定要批量删除选中的文章么?",{
                btn:["确定","取消"]
            },function(){
                common.ajax_post(url,{id:check_str},true,function(rt){
                    common.post_tips(rt);
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        location.replace(location);
                    }
                })
            })
        }
    };



    $(document).on('click','.edit',function(){
        func.edit($(this));
    });
    //删除单个
    $(document).on('click','.del_by_report',function(){
        func.del($(this));
    });

    //批量删除
    $(document).on("click",".del_all_btn",function(){
        func.del_all();
    });
    //标记消息
    $(document).on('click','.up_report_message',function(){
        func.up_message($(this));
    });
    //批量标记消息
    $(document).on('click','.up_all_message',function(){
        func.up_all_message();
    });
    /**
     * 选择全部/个别
     */
    $(document).on("click",".check_all",function(){
        var check_all = $(this);
        var check = $(".check:enabled");//所有启用的checkbox

        if(check_all.is(':checked')) {
            check.prop('checked',true);
        }else{
            check.prop('checked',false);
        }
    });




});