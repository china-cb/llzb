
$(function(){
    var func = {
        change_status:function(obj,status){
            var id = obj.data('id');
            var url = $('#change_reference_url').val();
            if(status == 'pass'){
                var msg ='确定要通过吗？';
            }else if(status =='no_pass'){
                var msg ='确定不通过吗？';
            }else{
                var msg = '确定吗？';
            }

            layer.confirm(msg,function(){
                common.ajax_post(url,{'id':id,'status':status},true,function(rt){
                    common.post_tips(rt,function(index){
                        if(status =='no_pass'){
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已经失效</span>');
                            $(obj).parents("tr").find(".td-manage").children().remove();

                        }else if(status =='pass'){
                            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已通过</span>');
                            $(obj).parents("tr").find(".td-manage").prepend(' <a style="text-decoration:none"   class ="no_pass " data-id='+id+ ' href="javascript:;" title="不通过"><i class="Hui-iconfont">&#xe631;</i></a>  ');
                            $(obj).parents("tr").find(".td-manage").prepend(' <a style="text-decoration:none"   class ="have_pay" data-id='+id+ ' href="javascript:;" title="标记为已支付"><i class="Hui-iconfont">&#xe64b;</i></a>  ');
                        }

                        $(obj).parents("tr").find(".passstatus").remove();

                        layer.msg(index.msg,{icon: 1,time:1500});

                    });
                })
            });
        },

        have_pay:function(obj,status){
            var id = obj.data('id');
            var url = $('#change_reference_url').val();

            layer.confirm('确定已经完成支付了吗？',function(){
                common.ajax_post(url,{'id':id,'status':status},true,function(rwt){
                    common.post_tips(rwt,function(index){
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-secondary radius">已提现成功</span>');
                        $(obj).parents("tr").find(".td-manage").children().remove();
                        //$(obj).parents("tr").find(".have_pay").remove();
                        layer.msg(index.msg,{icon: 1,time:1500});

                    });

                })

            });

        }


    };

    $(document).on('click','.no_pass',function(){
        func.change_status($(this),'no_pass');
    });
    $(document).on('click','.pass',function(){
        func.change_status($(this),'pass');
    });
    $(document).on('click','.have_pay',function(){
        func.have_pay($(this),'have_pay');
    });

});