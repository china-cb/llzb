
var countdown=60; 
function settime(obj) { 
    if (countdown == 0) { 
        obj.removeAttribute("disabled");    
        obj.value="免费获取验证码"; 
        countdown = 60; 
        return;
    } else { 
        obj.setAttribute("disabled", true); 
        obj.value="重新发送(" + countdown + ")"; 
        countdown--; 
    } 
setTimeout(function() { 
    settime(obj) }
    ,1000) 
}

var login = {
    login_lable:function() {
        $(".login_reg_sign").on("click",function () {
            var a = $(this).index(".login_reg_sign");
           $(".login_reg_sign").eq(a).addClass("login_sign_act").siblings(".login_reg_sign").removeClass("login_sign_act")
        })
    }
}
login.login_lable();