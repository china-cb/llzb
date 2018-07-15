
$(function(){
    var func = {
        init:function(){
        },
        verify_btn:function(btn) {
            var url = $(btn).data('url');
            var id = $(btn).data('id');
            layer.confirm('审核是否通过?', {
                btn: ['通过', '不通过', '取消'] //可以无限个按钮
            }, function(index, layero){
                common.ajax_post(url,{id:id,status:"通过"},true,function(rt){
                    common.post_tips(rt);
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        location.replace(location);
                    }
                });
            }, function(index){
                common.ajax_post(url,{id:id,status:"不通过"},true,function(rt){
                    common.post_tips(rt);
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        location.replace(location);
                    }
                });
            });
        }
    };
    func.init();
    $(document).on('click','.verify_btn',function(){
        func.verify_btn(this);
    });
});
