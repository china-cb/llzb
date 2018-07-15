<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:31:"../tpl/admin/account\index.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="renderer" content="webkit">
    <link href="__static__/admin//css/account/common.css" rel="stylesheet">
    <link href="__static__/admin/css/account/login_u.css" rel="stylesheet">
    <title>首页</title>
</head>
<body>
<div class="header">
    <div class="nav">
        <div class="head-cap">
            <a class="logo" href="<?php echo url('/'); ?>"  style="background-image:url(<?php echo $logo; ?>);background-repeat:no-repeat; ">
            </a>
            <span>
                <b>互联网创新模式与技术服务解决方案提供商</b><br>
                TCECHNICAL SERVICE SOLUTIONS PROVIDER
            </span>
        </div>
    </div>
</div>
<div class="body">
    <div class="login-bgcon">
        <div class="bgcon"><span class="login-bot"></span></div>
        <div class="center-cell">

            <div class="login-con">
                <div class="lgn-link">
                </div>
                <form id="form_content" autocomplete="off">
                    <div class="logo-form">
                        <h2>后台登录</h2>
                        <div class="lgn-f-l">
                            <span class="icon username"></span>
                            <input placeholder="请输入用户名" name="user_login" value="">
                        </div>
                        <div class="lgn-f-l">
                            <span class="icon password"></span>
                            <input placeholder="请输入密码" type="password" name="user_pass">
                        </div>
                        <div class="lgn-f-l v-code">
                            <input class="v-code" placeholder="验证码" name="verify">
                            <img class="val-img verify_img" src="<?php echo url('core/api/verify'); ?>" onclick="this.src='<?php echo url('core/api/verify') . "?&amp;time"; ?>'+Math.random()" style="cursor: pointer;width:30%;height:100%;" title="点击获取">  </div>


                        <input class="lgn-submit submit_btn" type="button" value="登录">
                    </div>
                </form>
            </div>
        </div></div>

</div>
<div class="foot">
    <div class="ft-con">
        <p>
            企业QQ：<?php echo (isset($qq) && ($qq !== '')?$qq:''); ?>&nbsp;&nbsp;&nbsp;&nbsp;企业邮箱：<?php echo (isset($mail) && ($mail !== '')?$mail:'--'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo (isset($beian) && ($beian !== '')?$beian:''); ?><br>
            400电话：<?php echo (isset($phone) && ($phone !== '')?$phone:'--'); ?>&nbsp;&nbsp;&nbsp;&nbsp;（售前咨询：8:00～24:00）
        </p>
    </div>
</div>
<!--插件-->
<script type="text/javascript" src="__plugin__/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__plugin__/laydate/laydate.js"></script>
<script type="text/javascript" src="__plugin__/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__plugin__/zTree/js/jquery.ztree.core-3.5.min.js"></script>
<script type="text/javascript" src="__plugin__/zTree/js/jquery.ztree.excheck-3.5.min.js"></script>
<script type="text/javascript" src="__plugin__/webuploader/0.1.5/webuploader.min.js"></script>





<!--基础-->
<script type="text/javascript" src="__hui__/js/H-ui.js"></script>
<script type="text/javascript" src="__hui_admin__/js/H-ui.admin.js"></script>

<!--[if lt IE 9]>
<script type="text/javascript" src="__plugin__/html5.js"></script>
<script type="text/javascript" src="__plugin__/respond.min.js"></script>
<script type="text/javascript" src="__plugin__/PIE_IE678.js"></script>
<![endif]-->

<!--通用-->
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__static__/admin/js/public.js"></script>





<script type="text/javascript" src="__static__/admin/js/account/index.js"></script>
<script>
    var wh = $(window).height();
    if (wh >= 500) {
        $(".body").height(wh - $(".header").height() - $(".foot").height());
    }

</script>
<input type="hidden" id="root_url" value="<?php echo url('index/index'); ?>">
<input type="hidden" id="submit_url" value="<?php echo url('login_do'); ?>">
</body>
</html>