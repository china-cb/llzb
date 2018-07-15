<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:29:"../tpl/index/login\index.html";i:1486603691;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <!-- inject:login_base:html -->                                                                                <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="玲珑直播">
    <meta name="keywords" content="玲珑直播">
    <link rel="shortcut icon" href="__static__/index/src/img/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="__static__/index/src/img/favicon.png" type="image/x-icon" />
    <link href="__static__/index/src/css/common.css" rel="stylesheet">
    <script  src="__static__/index/src/js/jquery.min.js" type="text/javascript"></script>
    <script  src="__static__/index/src/js/common.js" type="text/javascript"></script>
    <!-- endinject -->
    <link href="__static__/index/src/css/login.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__static__/index/src/css/common.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/mCustomScrollbar.css" />
    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>玲珑直播</title>
    <style>
        html,body{width: 100%;height: 100%;}
    </style>
</head>
<!--  -->
<body class="sign_in">

<header id="header" class="login-header">
    <a class="logo" href="<?php echo url('index/index/index'); ?>"></a>
    <div class="login-main">
        <a href="<?php echo url('index/index/index'); ?>" class="login_sign_s">
            玲珑直播首页
            <i class="arrow-right sign-arrow"></i>
        </a>
    </div>
</header>

<div class="main login_reg login_reg_signs">
    <form action="" method="post" id="login_form">
        <label class="login_reg_lable login_reg_sign">
            <input type="text" name="account" placeholder="请输入手机号" class=" login_reg_inpit1s"/>
        <span class="login_sign_ico1">
         <i class="iconfont">&#xe659;</i>
         <i class="iconline"></i>
        </span>
        </label>
        <label class="login_reg_lable login_reg_sign">
            <input id="password_login" type="password" name="password" placeholder="6～16位密码" class=" login_reg_inpit1s" onclick="this.type='password'"/>
        <span class="login_sign_ico1">
         <i class="iconfont">&#xe621;</i>
         <i class="iconline"></i>
        </span>
        </label>

        <div class="login_agreement agreement_sign">
            <?php if(\think\Config::get('CONFIG_FREE_LOGIN') == '1'): ?>
                <label for="sign_label" class="free_sign">15天免登录</label>
                <input type="checkbox" name="free_login"  id="sign_label" value="true"/>
                <i class="iconfont">&#xe617;</i>
                <p class="login_checkeds"></p>
            <?php endif; ?>
            <a href="<?php echo url('register'); ?>" class="register_reg">注册</a>
            <a href="<?php echo url('forget_password'); ?>" class="forget_pss">忘记密码？</a>
        </div>


        <label class="login_reg_lable ">
            <input type="button" class="login_reg_inpit3 login_reg_inpit3s login_submit_btn" value="登录"/>
        </label>
        <div class="login_agreement">
            <input type="checkbox" name="agreement" checked="checked"/>
            <i class="iconfont">&#xe617;</i>
            <p class="login_checkeds"></p>
            <a href="" class="sign-fff">同意并遵守《玲珑TV服务协议》</a>
        </div>

        <div class="other_sign">
            <?php if(\think\Config::get('CONFIG_QQ_LOGIN') == '1'): ?>
                 <a href="<?php echo url('index/login/union_login',['plat'=>'qq']); ?>" class="other_sign_qq">QQ登录<i class="iconfont">&#xe601;</i></a>
            <?php endif; if(\think\Config::get('CONFIG_WEIXIN_LOGIN') == '1'): ?>
                 <a href="<?php echo url('index/login/union_login',['plat'=>'wechat']); ?>" class="other_sign_wx">微信登录<i class="iconfont">&#xe601;</i></a>
            <?php endif; ?>

        </div>
    </form>
</div>



<footer class="footer_sign">
    <div class="introduce footer_sign_in1">
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
    <div class="footer_inner footer_sign_in1">
        <section class="footer_main">
            <p>
                <a href="">关于我们</a>
                <a href="">法律声明</a>
                <a href="">友情链接</a>
            </p>
            <p>
                <a href="">梦蝶一元购</a>
                <a href="">梦蝶直播</a>
                <a href="">梦蝶跑腿</a>
                <a href="">跑嘀快</a>
                <a href="">虫虫加速器</a>
                <a href="">芝麻代理</a>
                <a href="">梦蝶直播</a>
            </p>
        </section>
    </div>
    <p class="footer_sign_in2"></p>
    <p class="footer_sign_in3"></p>
</footer>
<input type="hidden" id="login_url" value="<?php echo url('index/login/login_do'); ?>">
<input type="hidden" id="index_url" value="<?php echo url('index/admin/index'); ?>">
<!-- inject:main:html --><!-- endinject -->
<script  src="__static__/index/src/js/login/login.js " type="text/javascript"></script>
<script type="text/javascript" src="__static__/index/js/login/reg.js"></script>
</body>
</html>