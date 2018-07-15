/**
 * Created by 冯天元 on 2016/8/1.
 */
$(function(){
    var func = {
        init:function(){

        },
        //添加文章分类
        add_classify:function(){
            var url = $('#add_classify_url').val();
            var param = $('#form_content').serialize();
            common.ajax_post(url,param,true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    layer.msg(obj.msg,{
                        icon:1,
                        time:2000
                    },function(){
                        location.href = $('#classify_url').val();
                    });
                }else{
                    common.post_tips(rt);
                }
            })
        },
        //编辑(弹框界面)
        edit_article:function(btn,url){
            var id = $(btn).data('id');
            var index = layer.open({
                type: 2,
                title: '信息',
                maxmin: true, //开启最大化最小化按钮
                area: ['800px', '500px'],
                content: url+'?id='+id,
                success:function(layero,index){
                    //var index = parent.layer.getFrameIndex(window.name);
                    layer.full(index);
                },
                end:function(){
                    var handle_status = $("#handle_status").val();
                    if ( handle_status == '1' ) {
                        layer.msg('编辑成功！',{
                            icon: 1,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        },function(){
                            location.reload();
                        });
                    } else if ( handle_status == '2' ) {
                        layer.msg('编辑失败！',{
                            icon: 2,
                            time: 1000 //2秒关闭（如果不配置，默认是3秒）
                        });
                    }
                }
            });
        },
        //提交修改
        edit_article_do:function(url){

            var index = parent.layer.getFrameIndex(window.name);
            var param = $('#form_content').serialize();
            common.ajax_post(url,param,true,function(rt){
                var obj = common.str2json(rt)
                if(obj.code == 1){
                    parent.$("#handle_status").val('1');

                    //parent.layer.close(index);
                    parent.location.reload();


                }else{
                    parent.$("#handle_status").val('2');
                    common.post_tips(rt);
                    //parent.layer.close(index);
                }
            });
        },
        //删除分类
        del_classify:function(btn,url){
            var conf = $(btn);
            //var url = $("#del_gift_url").val();
            //询问框
            var index = layer.confirm('您确定要删除么？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                common.ajax_post(url,{id : conf.data('id')},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        layer.msg(obj.msg,{
                            icon:1,
                            time:1000
                        },function(){
                            conf.parents('tr').fadeOut("slow");
                        });
                    }else{
                        common.post_tips(rt);
                    }
                    layer.close(index);
                });
            });
        },
        //添加文章
        add_article:function(){
            var url = $('#add_article_url').val();
            var param = $('#form_content').serialize();
            common.ajax_post(url,param,true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    layer.msg(obj.msg,{
                        icon:1,
                        time:2000
                    },function(){
                        location.href = $('#article_list_url').val();
                    });
                }else{
                    common.post_tips(rt);
                }
            })
        },
       //搜索
        search:function(btn){
            var conf  = $(btn);
            var url = conf.data('url');
            var param = $("#form_condition").serialize();
            common.ajax_post(url,param,true,function(rt){
                console.log(rt);
                 var obj = common.str2json(rt);
                console.log(obj);
                 $("#form_content").html(obj.html);
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
    }

    func.init();
    //添加文章分类
    $(document).on("click",".add_classify_btn",function(){
        func.add_classify();
    });
    //分类编辑
    $(document).on("click",".edit_classify_btn",function(){
        var url = $('#edit_classify_url').val();
        func.edit_article(this,url);
    });
    //分类编辑执行
    $('.edit_classify_btn').click(function(){
        var url = $('#edit_classify_do_url').val();
        func.edit_article_do(url);
    });
    //分类删除
    $(document).on("click",".del_classify_btn",function(){
        var url = $('#del_classify_url').val();
        func.del_classify(this,url);
    });
    //添加文章
    $(document).on("click",".add_article_btn",function(){
        func.add_article();
    });
    //查看详情
    $(document).on("click",".look_btn",function(){
        var url = $('#look_btn_url').val();
        func.edit_article(this,url);
    });
    //编辑文章
    $(document).on("click",".edit_article_btn",function(){
        var url = $('#edit_article_url').val();
        func.edit_article(this,url);
    });
    //编辑文章执行
    $(document).on("click",".edit_article_btn_do",function(){
        var url = $('#edit_article_do_url').val();
        func.edit_article_do(url);
    });
    //单个删除文章
    $(document).on("click",".del_article_btn",function(){
        var url = $('#del_article_url').val();
        func.del_classify(this,url);
    });
    //搜索
    $(document).on("click",".search_btn_do",function(){
        func.search(this);
    });
    //批量删除
    $(document).on("click",".del_all_btn",function(){
        func.del_all();
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
})
