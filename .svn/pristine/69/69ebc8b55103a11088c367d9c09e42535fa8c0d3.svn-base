$(function () {
    var time_reset = 60;
    var time_index;
    var is_phone_sent = false;
    var pattern_code = /\d{6}/;
    var time_redirect = 3;
    var index_url = $("#index_url").val();
    var get_phone_url = $("#get_phone_code_url").val();
    var func = {
        init: function () {

        },
        /**验证手机号*/
        vacode_reg: function () {
            //检查手机号是否符合规范
            var regx = /^[1][3-9][0-9]{9}$/;
            var phone=$("#phone_reg").val();
            if(!regx.test(phone)){
                //layer.msg('手机号格式不正确',{icon:2});
                layer.msg('手机号格式不正确',{icon:2});
                return false;
            }
            func.get_phone_code();
        },
        /**倒计时60秒*/
        time_clock: function (time_sec) {
            $(".vacode").addClass("disabled").removeClass("reg_get_code");
            $(".vacode").val(time_sec + "秒后重试");
            time_index = window.setInterval(function () {
                $(".vacode").val(--time_sec + "秒后重试");
                if (time_sec == 0) {
                    $(".vacode").val('再次获取').addClass("reg_get_code").removeClass("disabled");
                    window.clearInterval(time_index);
                }
            }, 1000)
        },
        /**获取手机验证码*/
        get_phone_code: function () {
            var phone = $("#phone_reg").val();
            var type = $(".get_phone_code_type").val();
            common.ajax_post(get_phone_url, {phone:phone,type:type}, true, function (rt) {
                common.post_tips(rt);
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    func.time_clock(time_reset);
                }
            }, true, [0.3, "#444"])
        },
        //注册登录提交
        submit_reg:function(){
            var url = $("#submit_reg_url").val();
            var phone = $("#phone_reg").val();
            var phone_code = $("#phone_code_reg").val();
            var password = $("#password_reg").val();
            var re_password = $("#re_password_reg").val();
            if(phone == ''){
                layer.msg('手机号不能为空',{icon:2});
                return false;
            }
            if(phone_code == ''){
                layer.msg('手机验证码不能为空',{icon:2});
                return false;
            }
            if(password == ''){
                layer.msg('设置密码不能为空',{icon:2});
                return false;
            }
            if(re_password == ''){
                layer.msg('确认密码不能为空',{icon:2});
                return false;
            }
            if(password !== re_password){
                layer.msg('两次输入的密码不一致',{icon:2});
                return false;
            }
            if(!($("input[name='agreement']").is(':checked'))){
                layer.msg('请同意并遵守<<玲珑TV服务协议>>',{icon:2});
                return false;
            }
            common.ajax_post(url,{phone:phone,phone_code:phone_code,password:password,re_password:re_password},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    layer.msg("注册成功,正在为您跳转... ",{icon:1});
                    location.href = index_url;
                }else{
                    layer.msg(obj.msg,{icon:2});
                }
            }, true, [0.3, "#444"])
        },
        //登录提交
        submit_login:function(btn){
            var account = $("input[name='account']").val();
            var password = $("#password_login").val();
            //var validate_code = $("input[name='verify']").val();
            if(account == ""){
                layer.msg("请输入您的手机号",{icon:2});
                return false;
            }
            if(password == ""){
                layer.msg("密码不能为空",{icon:2});
                return false;
            }
            //if(validate_code == ""){
            //    layer.msg("验证码不能为空",{icon:2});
            //    return false;
            //}
            if(!($("input[name='agreement']").is(':checked'))){
                layer.msg("请先同意并遵守<<玲珑TV服务协议>>",{icon:2});
                return false;
            }
            var url = $("#login_url").val();
            var param = $("#login_form").serialize();
            common.ajax_post(url,param,true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    layer.msg("登录成功,正在为您跳转...",{icon:1,time:1000},function(){
                        location.href = index_url;
                    })
                }else{
                    common.post_tips(rt);
                    //$('.validate_code').trigger('click');
                }
            }, true, [0.3, "#444"]);
        },
        //忘记密码提交
        submit_forget_psw:function(){
            var url = $("#submit_forget_psw_url").val();
            var phone = $("#phone_reg").val();
            var phone_code = $("#phone_code_forget").val();
            var password = $("#password_forget").val();
            var re_password = $("#re_password_forget").val();
            if(phone == ''){
                layer.msg('手机号不能为空',{icon:2});
                return false;
            }
            if(phone_code == ''){
                layer.msg('手机验证码不能为空',{icon:2});
                return false;
            }
            if(password == ''){
                layer.msg('设置密码不能为空',{icon:2});
                return false;
            }
            if(re_password == ''){
                layer.msg('确认密码不能为空',{icon:2});
                return false;
            }
            if(password !== re_password){
                layer.msg('两次输入的密码不一致',{icon:2});
                return false;
            }
            common.ajax_post(url,{phone:phone,phone_code:phone_code,password:password,re_password:re_password},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    layer.msg("密码重置成功,请用新密码进行登录 ",{icon:1,time:2000},function(){
                        var login_url = $("#login_url").val();
                        location.href = login_url;
                    });
                }else{
                    layer.msg(obj.msg,{icon:2});
                }
            }, true, [0.3, "#444"])
        },
        //绑定手机号提交
        submit_bind:function(){
            var url = $("#submit_bind_url").val();
            var phone = $("#phone_reg").val();
            var phone_code = $("#phone_code_bind").val();
            var password = $("#password_bind").val();
            var re_password = $("#re_password_bind").val();
            if(phone == ''){
                layer.msg('手机号不能为空',{icon:2});
                return false;
            }
            if(phone_code == ''){
                layer.msg('手机验证码不能为空',{icon:2});
                return false;
            }
            if(password == ''){
                layer.msg('设置密码不能为空',{icon:2});
                return false;
            }
            if(re_password == ''){
                layer.msg('确认密码不能为空',{icon:2});
                return false;
            }
            if(password !== re_password){
                layer.msg('两次输入的密码不一致',{icon:2});
                return false;
            }
            common.ajax_post(url,{phone:phone,phone_code:phone_code,password:password,re_password:re_password},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    $(".bind_phone").hide();
                    $(".bind_phone_success").show();
                }else{
                    layer.msg(obj.msg,{icon:2});
                }
            }, true, [0.3, "#444"])
        },
    };

    func.init();

    /**获取手机验证码*/
    $(document).on("click", '.reg_get_code', function () {
        func.vacode_reg();
    });

    /**注册提交*/
    $(document).on('click','.reg_submit',function () {
        func.submit_reg();
    });

    /**登录提交*/
    $(document).on('click','.login_submit_btn',function () {
        func.submit_login(this);
    });

    /** 忘记密码提交 */
    $(document).on('click','.forget_paw_btn',function(){
        func.submit_forget_psw();
    });

    /** 绑定手机号提交 **/
    $(document).on('click','.bind_phone_btn',function () {
        func.submit_bind();
    });

});