<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:35:"../tpl/index/index\package_buy.html";i:1486435794;s:27:"../tpl/index/base\base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:29:"../tpl/index/base\header.html";i:1486436061;s:29:"../tpl/index/base\footer.html";i:1485411622;}*/ ?>
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

<div class="main">
	<div class="submits">
		<h1 class="submits_h1">套餐提交</h1>
		<form  method="post" id="package_form" target="_blank">
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
						<span id="price" data-val="0.06" class="span_f">
							0.06
							<i>元</i>
						</span>
						<i class="border_line"></i>
					</li>
					<li>
						<span>起订时间</span>
						<span class="black_c span_f">
							10
							<i>分钟</i>
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
					<li class="li_act" data-val="15">
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
					<li data-val="16">
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
					<li data-val="17">
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
					<li data-val="18">
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
				<h1 class="current_h1">选择时间</h1>
				<div class="choose_money">
					<div id="chose_money_slide" class="pn-slide" data-min="10" data-max="10000000" data-val="10">
						<input id="custom_pay" value="" type="hidden">
						<div class="slide-back">
							<div class="container" >
							</div>
						</div>
						<div class="slide-front">
							<div class="container" >
							</div>
						</div>
						<div class="slide-btn">
							<a class="btn">
								<span></span>
							</a>
						</div>
						<div class="slide-info">
							<span class="start">100</span>
							<span class="end">10000000</span>
						</div>
					</div>
					<div id="chose_money_picker" class="pn-num-picker" data-max="10000000" data-min="10" data-val="0" data-errmax="最多可{0}分钟" data-errmin="最少{0}分钟起订">
						<label>
							<input value="10000000" placeholder="¥0.00">
						</label>
						<span class="pn-label">分钟</span>
						<p class="error"></p>
					</div>
				</div>
			</div>
			<div class="basis1">
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
				<span class="pay" data-type="1">
					支付宝
					<span class="arrow_down">
						<i class="iconfont">&#xe745;</i>
					</span>
				</span>
				<span class="pay" data-type="2">
					微信
					<span class="arrow_down" >
						<i class="iconfont">&#xe745;</i>
					</span>
				</span>
				<span class="pay" data-type="3">
					余额支付
					<span class="arrow_down" >
						<i class="iconfont">&#xe745;</i>
					</span>
				</span>
			</div>

			<div class="payment">
				<span class="payment_right">
					100
				</span>
				<span class="payment_left">应付金额</span>
			</div>
			<a class="go_pay" data-url="<?php echo url('core/business/order'); ?>">立即支付</a>
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
		</form>
	</div>
</div>
<input type="hidden" id="package_type" value="14"><!--获取套餐类型ID-->
<input type="hidden" id="package_time" value=""><!--获取套餐时长-->
<input type="hidden" id="package_money" value=""><!--获取套餐金额-->
<input type="hidden" id="price_money" value="0.06"><!--获取套餐金额单价-->
<input type="hidden" id="pay_type" value=""><!--支付方式写入-->
<input type="hidden" id="pay_url" value="<?php echo url('index/index/pay_info'); ?>"><!--支付方式写入-->
<input type="hidden" id="alipay_url" value="<?php echo url('core/unionpay/alipay'); ?>"><!--支付宝-->
<input type="hidden" id="balance_url" value="<?php echo url('index/index/balance_pay'); ?>"><!--余额支付-->
<input type="hidden" id="get_qrcode_url" value="<?php echo url('core/unionpay/get_qrcode_url'); ?>"><!--微信-->
<input type="hidden" value="<?php echo url('core/order/get_order_pay_status'); ?>" id="get_order_pay_status"><!--扫描订单状态-->

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
<script type="text/javascript" src="__static__/index/js/index/index.js"></script>

</body>
</html>