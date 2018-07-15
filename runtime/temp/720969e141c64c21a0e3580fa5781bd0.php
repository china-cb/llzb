<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:32:"../tpl/index/login\register.html";i:1486603691;s:33:"../tpl/index/base\login_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\login_footer.html";i:1486603691;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <!--base-->
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="玲珑直播">
    <meta name="keywords" content="玲珑直播">
    <link rel="shortcut icon" href="__static__/index/src/img/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="__static__/index/src/img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="__static__/index/src/css/common.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/mCustomScrollbar.css" />
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/login.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>玲珑直播</title>
</head>
<body>

<header id="header" class="login-header">
    <a href="<?php echo url('index/index/index'); ?>" class="logo"></a>
    <span class="login-list">注册</span>
    <div class="login-main">
        <a href="<?php echo url('index/index/index'); ?>">
            玲珑直播首页
            <i class="arrow-right"></i>
        </a>
    </div>
</header>
<div class="main login_reg">
    <h1>已有账号直接<a href="<?php echo url('index'); ?>">登录</a></h1>
    <form action="" method="get">
        <label class="login_reg_lable">
            <input type="text" id="phone_reg" name="phone" placeholder="请输入手机号" class="login_reg_inpit1" />
        </label>
        <label class="login_reg_lable">
            <input type="text" id="phone_code_reg" name="phone_code" placeholder="请输入验证码" class="login_reg_inpit1"/>
            <input type="button" value="发送验证码" class="reg_get_code login_reg_free vacode"/>
        </label>
        <label class="login_reg_lable">
            <input type="password" id="password_reg" name="password" placeholder="6～16位密码" class="login_reg_inpit2" />
            <span class="login_reg_span1">设置密码</span>
        </label>
        <label class="login_reg_lable">
            <input type="password" id="re_password_reg" name="re_password" placeholder="6～16位密码" class="login_reg_inpit2"/>
            <span class="login_reg_span1">确认密码</span>
        </label>
        <div class="login_agreement">
            <input type="checkbox" name="agreement" checked="checked"/>
            <i class="iconfont">&#xe617;</i>
            <p class="login_checkeds"></p>
            <a >同意并遵守《玲珑TV服务协议》</a>
        </div>
        <label class="login_reg_lable">
            <input type="button" class="login_reg_inpit3 reg_submit" value="注册" />
        </label>
    </form>
</div>
<input type="hidden" id="submit_reg_url" value="<?php echo url('index/login/register_do'); ?>">
<input type="hidden" class="get_phone_code_type" value="reg">

<footer>
    <div class="introduce">
        <div class="introduce_inner">
            <span class="introduce_time">
               <i class="iconfont">&#xe614;</i>
               <span>售前咨询</span>
               <span>200-8000-900</span>
            </span>
            <ul>
                <li>全方位购买咨询</li>
                <li>精准的配置推荐</li>
                <li>灵活的价格方案</li>
                <li>1对1贴心服务</li>
            </ul>
        </div>
    </div>
    <div class="footer_inner">
        <section class="footer_main">
            <p>
                <a href="http://yyg.mengdie.com" target="_blank">梦蝶一元购</a>
                <a href="http://ip.mengdie.com" target="_blank">芝麻代理</a>
                <a href="http://zb.mengdie.com" target="_blank">梦蝶直播</a>
                <a href="http://pt.mengdie.com" target="_blank">梦蝶跑腿</a>
            </p>
        </section>
    </div>
</footer>
<input type="hidden" id="index_url" value="<?php echo url('index/admin/index'); ?>">
<input type="hidden" id="get_phone_code_url" value="<?php echo url('core/api/get_phone_code'); ?>">

<script type="text/javascript" src="__static__/index/src/js/login/login.js"></script>
<script type="text/javascript" src="__static__/index/js/login/reg.js"></script>

</body>
</html>
