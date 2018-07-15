<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:33:"../tpl/index/setmeal\submits.html";i:1485410615;s:27:"../tpl/index/base\base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:29:"../tpl/index/base\header.html";i:1485410615;s:29:"../tpl/index/base\footer.html";i:1484634306;}*/ ?>
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
                <a class="">首页</a>
                <a class="">产品体验</a>
                <a class="">应用场景</a>
                <a class="">套餐购买</a>
                <a class="">帮助中心</a>
            </div>
            <div class="hm-qu-link">
                <a class="hq-item" href="<?php echo url('index/admin/index'); ?>">控制台</a>
                <a class="hq-item" href="<?php echo url('index/login/index'); ?>">登录</a>
                <a class="hq-item" href="<?php echo url('index/login/register'); ?>">注册</a>
                <a class="hq-info" href="">
                    <img src="__static__/index/src/img/temp/user_ava.png">
                    <h4>你好, 虫虫科技</h4>
                    <i class="iconfont"></i>
                </a>
                <div class="user-info-warp ">
                    <div class="user-ava">
                        <img src="__static__/index/src/img/temp/user_ava.png">
                        <h4>你好,<span>大兄弟!</span></h4>
                        <div class="user-auth">
                            <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="real-name "></a>
                            <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="phone "></a>
                            <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="email "></a>
                        </div>
                        <div class="user-info">
                            <div class="info-item">
                                <p><span>账户类型 :</span>企业版<a class="updata">升级</a></p>
                                <p><span>账户余额 :</span><i class="iconfont">&#xe644;</i>9999.00<a class="charge" href="<?php echo url('index/user_center/account','type=3'); ?>">充值</a></p>
                                <p><span>套餐类型 :</span>高级VIP<a class="buy">购买</a></p>
                            </div>
                        </div>
                    </div>
                    <a class="mc-close quit_btn">退出</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="main">
	<div class="submits">
		<h1 class="submits_h1">套餐提交</h1>
		<div class="submits_main">
			<h1 class="current_h1">
				当前套餐
				<span class="current_right">时长套餐A</span>
			</h1>
			<i class="line"></i>
			<h1 class="current_h1">选择套餐</h1>
			<div class="set_choose set_choose_act">
				<h1 class="package_h1 package_h1s">
					<span class="border_o">基础套餐</span>
					无套餐限制，实时结算，方便快捷
				</h1>
				<ul class="package_ul">
					<li>
						<span>每人每分钟约为</span>
						<span class="span_f">
							0.006
							<i>元</i>
						</span>
						<i class="border_line"></i>
					</li>
					<li>
						<span>起订金额</span>
						<span class="black_c span_f">
							10
							<i>元</i>
						</span>
						<i class="border_line"></i>
					</li>
					<li>
						<span class="li_c">订购时间</span>
						<span class="black_c span_f">
							灵活可选
						</span>
					</li>
				</ul>
				<div class="arrow_down arrow_down_act">
					<i class="iconfont">&#xe745;</i>
				</div>
			</div>
			<h1 class="package_h1 package_h1s package_h2s">
				<span class="border_o">时长套餐A</span>
			</h1>
			<div style="clear: both"></div>
			<div class="set_choose set_choose2sx ">
				
				<ul class="charging_ul charging_ul2s">
					<!-- <li class="charging_img"></li> -->
					<li class="li_act">
						<span>30000分钟</span>
						<span>
							<i>0.04</i>
							元／人／分钟
						</span>
						<span class="annotation">无套餐限制，一元起充，实时结算</span>
						<i></i>	
						<span class="arrow_down">
							<i class="iconfont">&#xe745;</i>
						</span>
					</li>
					<li>
						<span>1200000分钟</span>
						<span>
							<i>0.03</i>
							元／人／分钟
						</span>
						<span class="annotation">无套餐限制，一元起充，实时结算</span>
						<i></i>
						<span class="arrow_down ">
							<i class="iconfont">&#xe745;</i>
						</span>
					</li>
					<li>
						<span>4500000分钟</span>
						<span>
							<i>0.02</i>
							元／人／分钟
						</span>
						<span class="annotation">无套餐限制，一元起充，实时结算</span>
						<i></i>
						<span class="arrow_down ">
							<i class="iconfont">&#xe745;</i>
						</span>
					</li>
					<li>
						<span>10000000分钟</span>
						<span>
							<i>0.015</i>
							元／人／分钟
						</span>
						<span class="annotation">无套餐限制，一元起充，实时结算</span>
						<span class="arrow_down ">
							<i class="iconfont">&#xe745;</i>
						</span>
					</li>
			    </ul>
			    
			</div>
			<i class="line lines"></i>
			<div class="basis1 basis_act">
				<h1 class="current_h1">选择金额</h1>
				<div class="choose_money"></div>
			</div>
			<div class="basis1 basis_act">
				<h1 class="current_h1">
					有效期
					<span class="year_times">1年</span>
				</h1>
			</div>
			<i class="line"></i>
			<h1 class="current_h1">
				支付方式
			</h1>
			<div class="ways">
				<span class="span_act">
					支付宝
					<span class="arrow_down arrow_down_act">
						<i class="iconfont">&#xe745;</i>
					</span>
				</span>
				<span>
					微信
					<span class="arrow_down">
						<i class="iconfont">&#xe745;</i>
					</span>
				</span>
			</div>

			<div class="payment">
				<span class="payment_right">
					￥20000
				</span>
				<span class="payment_left">应付金额</span>
			</div>
			<a class="go_pay">立即支付</a>
			<div style="clear: both"></div>
			<ul class="prompts">
				<li>温馨提示：</li>
				<li>1.支持微信，银联支付，线下银行付款等方式充值。</li>
				<li>2.支付成功后，可在账户总览中查看最新余额。</li>
				<li>3.充值成功的金额不支持提现。</li>
				<li>4.支持查看所有历史充值记录，点击进入查询。</li>
				<li>5.若充值未到账或有其他疑问可致电客服热线：4009-618-610。</li>
			</ul>
		</div>
	</div>
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


<script type="text/javascript" src="__static__/index/src/js/setmeal.js"></script>

</body>
</html>