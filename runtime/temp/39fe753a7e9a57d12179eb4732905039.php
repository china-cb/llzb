<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:32:"../tpl/index/index\pay_fail.html";i:1486282963;s:27:"../tpl/index/base\base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:29:"../tpl/index/base\header.html";i:1486436061;s:29:"../tpl/index/base\footer.html";i:1485411622;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <!--base-->
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="玲珑TV">
    <meta name="keywords" content="玲珑TV">
    <link rel="shortcut icon" href="__static__/index/src/img/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="__static__/index/src/img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="__static__/index/src/css/common.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/mCustomScrollbar.css" />
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/setmeal.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>套餐购买</title>
</head>
<body>
<div class="header">
    <div class="h-bar">
        <div class="warp">
            <h6 class="info" >服务热线：200-190000（周一至周五9:00～18:00）</h6>
            <div class="nav">
                <a class="nav-link">芝麻代理</a>
                <a class="nav-link">梦蝶跑腿</a>
                <a class="nav-link">梦蝶直播</a>
                <a class="nav-link">梦蝶一元购</a>
            </div>
        </div>
    </div>
    <div class="h-main">
        <div class="warp">
            <a class="logo-top-index"></a>
            <div class="hm-nav">
                <a class="navigation" id="home_page" href="<?php echo url('index/index/index'); ?>">首页</a>
                <a class="navigation product_experience" href="<?php echo url('index/index/experience'); ?>">产品体验</a>
                <a class="navigation application_" href="<?php echo url('index/index/application'); ?>">应用场景</a>
                <a class="navigation" id="package_buy" href="<?php echo url('index/index/package'); ?>">套餐购买</a>
                <a class="navigation href_center" id="help_center" href="<?php echo url('index/index/help_center'); ?>">帮助中心</a>
            </div>
            <div class="hm-qu-link">
                <?php if(empty($member_info['member_id']) || ($member_info['member_id'] instanceof \think\Collection && $member_info['member_id']->isEmpty())): ?>
                    <a class="hq-item" href="<?php echo url('index/login/index'); ?>">登录</a>
                    <a class="hq-item" href="<?php echo url('index/login/register'); ?>">注册</a>
                <?php else: ?>
                    <a class="hq-item" href="<?php echo url('index/admin/index'); ?>">控制台</a>
                    <a class="hq-info" href="">
                        <?php if(empty($member_info['user_face']) || ($member_info['user_face'] instanceof \think\Collection && $member_info['user_face']->isEmpty())): ?>
                        <img src="__static__/index/src/img/temp/user_ava.png">
                        <?php else: ?>
                        <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($member_info['user_face']) && ($member_info['user_face'] !== '')?$member_info['user_face']:''); ?>" alt="">
                        <?php endif; ?>
                        <h4>你好, <?php echo (isset($member_info['nick_name']) && ($member_info['nick_name'] !== '')?$member_info['nick_name']:'玲珑用户'); ?></h4>
                        <i class="iconfont"></i>
                    </a>
                    <div class="user-info-warp ">
                        <div class="user-ava">
                            <?php if(empty($member_info['user_face']) || ($member_info['user_face'] instanceof \think\Collection && $member_info['user_face']->isEmpty())): ?>
                                <img src="__static__/index/src/img/temp/user_ava.png">
                            <?php else: ?>
                                <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($member_info['user_face']) && ($member_info['user_face'] !== '')?$member_info['user_face']:''); ?>" alt="">
                            <?php endif; ?>
                            <h4>你好,<span><?php echo (isset($member_info['nick_name']) && ($member_info['nick_name'] !== '')?$member_info['nick_name']:'玲珑用户'); ?></span></h4>
                            <div class="user-auth">
                                <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="real-name "></a>
                                <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="phone "></a>
                                <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="email "></a>
                            </div>
                            <div class="user-info">
                                <div class="info-item">
                                    <p><span>账户类型 :</span><?php switch($member_info['account_type']): case "1": ?>基础版<?php break; case "2": ?>专业版<?php break; case "3": ?>企业版<?php break; default: ?>基础版
                                        <?php endswitch; ?>
                                        <a class="updata" href="<?php echo url('index/index/package'); ?>">升级</a></p>
                                    <p><span>账户余额 :</span><i class="iconfont">&#xe644;</i><?php echo (isset($member_info['balance']) && ($member_info['balance'] !== '')?$member_info['balance']:'0.00'); ?><a class="charge" href="<?php echo url('index/user_center/account','type=3'); ?>">充值</a></p>
                                    <p><span>套餐类型 :</span><?php echo (isset($member_info['type']) && ($member_info['type'] !== '')?$member_info['type']:'无'); ?><a class="buy" href="<?php echo url('index/index/package'); ?>">购买</a></p>
                                </div>
                            </div>
                        </div>
                        <a class="mc-close quit_btn">退出</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="nav_num" value="<?php echo (isset($nav_num) && ($nav_num !== '')?$nav_num:''); ?>">

	<div class="submits">
		<h1 class="submits_h1">购买结果</h1>
		<!-- 失败哦 -->
		<div class="succes_img error_img"></div>
		<p class="succes_p">
			<span>很抱歉，您的支付未成功！</span>
			<a title="" href="<?php echo url('index/index/package'); ?>" class="go_ok continue">继续支付</a>
			<a title="" href="<?php echo url('index/UserCenter/account'); ?>" class="go_ok returns">返回个人中心</a>
		</p>
	</div>


<!--footer-->
<div class="footer">
    <div class="fot-top">
        <div class="fb-item"><i class="iconfont">&#xe612;</i>100倍故障时长赔偿</div>
        <div class="fb-item"><i class="iconfont">&#xe640;</i>7*24小时售后支持</div>
        <div class="fb-item"><i class="iconfont">&#xe636;</i>7天无理由赔偿</div>
        <div class="fb-item"><i class="iconfont">&#xe611;</i>首充多少送多少</div>
    </div>
    <div class="fot-list">
        <div class="fl-group">
            <h4><i class="iconfont">&#xe744;</i>联系我们</h4>
            <p><span>微信</span>General</p>
            <p><span>QQ</span>800-133-388</p>
            <p><span>邮箱</span>yyg@mengdie.com</p>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe658;</i>关于我们</h4>
            <a >关于我们链接</a>
            <a >关于我们链接</a>
            <a >关于我们链接</a>
            <a >关于我们链接</a>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe616;</i>合作伙伴</h4>
            <a >合作伙伴链接</a>
            <a >合作伙伴链接</a>
            <a >合作伙伴链接</a>
        </div>
        <div class="focus-qr">
            <img src="__static__/index/src/img/temp/qr.png">
            <h4>关注微信</h4>
            <h6>了解更多直播方案</h6>
        </div>
    </div>
    <div class="fot-bar">
        <p><a>虫虫加速器</a>|<a>芝麻代理</a>|<a>一元购</a>|<a>梦蝶直播</a></p>
        <h6>徐州灵匠信息科技有限公司 版权所有</h6>
    </div>
</div>
<input type="hidden" id="quit_url" value="<?php echo url('index/login/quit'); ?>">
<input type="hidden" id="root_url" value="<?php echo url('index/index/index'); ?>">


<script type="text/javascript" src="__static__/index/src/js/setmeal.js"></script>

</body>
</html>