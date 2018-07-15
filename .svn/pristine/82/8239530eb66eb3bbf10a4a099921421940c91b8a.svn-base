
$(function () {
    var func = {

        //审核通过
        through: function () {
            var url = $("#submit_url").val();
            var id = $("#audit_id").val();
            common.ajax_post(url, {id:id,status:1}, true, function (rt) {
                var obj = common.str2json(rt);
                if (obj.code == 1) {
                    layer.msg(obj.msg,{icon:1});
                    location.reload();
                }else{
                    layer.msg(obj.msg,{icon:2});
                }
            }, true);
        },
        //审核不通过
        not_through: function () {
            var url = $("#submit_url").val();
            var id = $("#audit_id").val();
            common.ajax_post(url, {id:id,status:-1}, true, function (rt) {
                var obj = common.str2json(rt);
                if (obj.code == 1) {
                    layer.msg(obj.msg,{icon:1});
                    location.reload();
                }else{
                    layer.msg(obj.msg,{icon:2});
                }
            }, true);
        },
        //返回
        Return: function () {
            var url = $("#root_url").val();
            location.href = url;
        },
        //一键审核
        all_audit:function(){
            var check_audit = $('.check:checked');
            var url = $('#all_audit_change').val();

            if(check_audit.length == 0) {
                layer.msg('请选择要审核的用户',{icon:2});
                return false;
            }
            var check_str = '';
            check_audit.each(function () {
                check_str += $(this).data('id') + ',';

            });
            check_str = check_str.substring(0,check_str.length-1);
            layer.confirm("您确定要批量审核选中的用户么?",{
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


    $(document).on("click", ".through", function () {
        func.through();
    });
    $(document).on("click", ".not_through", function () {
        func.not_through();
    });
    $(document).on("click", ".Return", function () {
        func.Return();
    });
    $(document).on("click",".all_audit",function(){
        func.all_audit();
    })
});