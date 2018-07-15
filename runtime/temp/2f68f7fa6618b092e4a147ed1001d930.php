<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:34:"../tpl/index/login\bind_phone.html";i:1485159945;s:33:"../tpl/index/base\login_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\login_footer.html";i:1484634306;}*/ ?>
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
    <span class="logo"></span>
    <span class="login-list">绑定手机号</span>
    <div class="login-main">
        <a href="<?php echo url('index/index/index'); ?>">
            玲珑直播首页
            <i class="arrow-right"></i>
        </a>
    </div>
</header>
<div class="main login_reg bind_phone" >
    <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($list['user_face']) && ($list['user_face'] !== '')?$list['user_face']:''); ?>" alt="" class="login_header">
    <h2 class="login_name"><?php echo (isset($list['nick_name']) && ($list['nick_name'] !== '')?$list['nick_name']:'我是个假登录'); ?></h2>
    <!--<a href="" class="login_name">-->
        <!--<i class="qq_img"></i>-->
        <!--<span class="qq_go">QQ登录</span>-->
        <!--<i class="iconfont">&#xe601;</i>-->
    <!--</a>-->
    <form action="" method="get">
        <label class="login_reg_lable">
            <input type="text" id="phone_reg" name="phone" placeholder="请输入手机号" class="login_reg_inpit1" />
        </label>
        <label class="login_reg_lable">
            <input type="text" id="phone_code_bind" name="phone_code" placeholder="请输入验证码" class="login_reg_inpit1"/>
            <input type="button" id="btn" value="发送验证码" class="login_reg_free reg_get_code vacode"/>
        </label>
        <!-- 密码不一致添加 .password_no_act -->
        <div class="password_no">密码输入不一致</div>
        <label class="login_reg_lable">
            <input type="password" id="password_bind" name="password" placeholder="6～16位密码" class="login_reg_inpit2" />
            <span class="login_reg_span1">设置密码</span>
        </label>
        <label class="login_reg_lable">
            <input type="password" id="re_password_bind" name="re_password" placeholder="6～16位密码" class="login_reg_inpit2"/>
            <span class="login_reg_span1">确认密码</span>
        </label>
        <label class="login_reg_lable">
            <input type="button" class="login_reg_inpit3 bind_phone_btn" value="下一步" />
        </label>
    </form>
</div>

<!-- 绑定成功 -->
<div class="main login_reg bind_phone_success" style="display:none">
    <img src="" alt="" class="login_header login_header_win">
    <h2 class="login_name">虫虫科技</h2>
    <h2 class="login_win">绑定手机号成功！</h2>
    <form action="" method="get">
        <label class="login_reg_lable">
            <a href="<?php echo url('index/user_center/account'); ?>" class="login_reg_inpit3">进入控制台</a>
            <!--<input type="submit" name="" class="login_reg_inpit3" value="进入控制台" />-->
        </label>
    </form>
</div>
<input type="hidden" id="submit_bind_url" value="<?php echo url('index/login/bind_phone_do'); ?>">
<input type="hidden" class="get_phone_code_type" value="bind">

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
</footer>
<input type="hidden" id="index_url" value="<?php echo url('index/admin/index'); ?>">
<input type="hidden" id="get_phone_code_url" value="<?php echo url('core/api/get_phone_code'); ?>">

<script type="text/javascript" src="__static__/index/src/js/login/login.js"></script>
<script type="text/javascript" src="__static__/index/js/login/reg.js"></script>

</body>
</html>
