$(function(){
    var func = {
        init:function(){

        },
        //计算币额
        count_coin:function(){
            var money = $("input[name='money']").val();
            var url = $("#count_coin_url").val();
            common.ajax_post(url,{money:money},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == "-1"){
                    common.post_tips(rt);
                }else{
                    $("input[name='coin']").val(obj.code);
                }
            });
        },
        //计算币率
        count_rate:function(){
            var money = $("input[name='money']").val();
            var coin = $("input[name='coin']").val();
            var extra = $("input[name='extra']").val();
            if(money == ""){
                layer.msg("充值金额不能为空",{icon:2});
                return false;
            }
            if(coin == ""){
                layer.msg("虚拟币额不能为空",{icon:2});
                return false;
            }
            if(extra == ""){
                layer.msg("额外赠送不能为空",{icon:2});
                return false;
            }
            var rate = (parseInt(coin) + parseInt(extra))/parseInt(money);
            $("input[name='actual_rate']").val(rate);
        }
    };

    func.init();
    //计算币额
    $(".money").blur(function(){
        func.count_coin();
    });

    //计算虚拟实际币率
    $(".extra").blur(function(){
        func.count_rate();
    });
});
