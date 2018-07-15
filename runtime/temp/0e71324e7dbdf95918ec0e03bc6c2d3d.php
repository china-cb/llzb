<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:29:"../tpl/index/index\index.html";i:1486603691;s:27:"../tpl/index/base\base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:29:"../tpl/index/base\header.html";i:1486603691;s:29:"../tpl/index/base\footer.html";i:1486603691;}*/ ?>
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
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/index.css" />

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
<div class="header">
    <div class="h-bar">
        <div class="warp">
            <h6 class="info" >服务热线：0516-83994999（周一至周五9:00～18:00）</h6>
            <div class="nav">
                <a class="nav-link" href="http://ip.mengdie.com/" target="_blank">芝麻代理</a>
                <a class="nav-link" href="http://pt.mengdie.com/" target="_blank">梦蝶跑腿</a>
                <a class="nav-link" href="http://zb.mengdie.com/" target="_blank">梦蝶直播</a>
                <a class="nav-link" href="http://yyg.mengdie.com/" target="_blank">梦蝶一元购</a>
            </div>
        </div>
    </div>
    <div class="h-main">
        <div class="warp">
            <a href="<?php echo url('index/index/index'); ?>" class="logo-top-index"></a>
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
    <div class="index-banner">
        <div class="banner-main">
            <h4></h4>
            <h6>提供视频流媒体服务，全平台播放，支持多终端实时稳定流畅观看直播，解决很多行业的痛点，<br/>
                低成本、播放流畅、安全加密等，从录播到直播，为您实现完整的端到端直播服务，满足不同网络环境。</h6>
            <div class="banner-btn">
                <a  href="<?php echo url('index/index/package'); ?>" class="buy">套餐购买</a>
                <a class="connect">联系我们</a>
            </div>
        </div>
    </div>
    <div class="index-acts">
        <ul>
            <li class="item">
                <h4>直播</h4>
                <h6>端到端服务，安全认证，数据加密，秒级时延</h6>
            </li>
            <li class="item">
                <h4>点播</h4>
                <h6>上传、转码、播放、云分发，多码率支持</h6>
            </li>
            <li class="item">
                <h4>客户端SDK</h4>
                <h6>完全开源，多平台，支持推流拉流，开发者最优使用体验</h6>
            </li>
            <li class="item">
                <h4>转码</h4>
                <h6>开放式API，方便用户接入</h6>
            </li>
            <li class="item">
                <h4>跨平台直播</h4>
                <h6>支持全部H5浏览器实现多平台观看直播</h6>
            </li>
        </ul>
    </div>
    <div class="index-block-1">
        <h4></h4>
        <ul class="block-main">
            <li >
                <h5>微博直播</h5>
                <p>精准推送，无需跳转，直接在微博客户端观看直播，读取微博用户名、头像参与互动，</p>
            </li>
            <li >
                <h5>微信直播</h5>
                <p>自助式发起，开放接入微信、微信公众号，分享、传播、互动、嵌入微信公众号，可以进行独立配置</p>
            </li>
            <li >
                <h5>大型活动直播保障</h5>
                <p>高并发稳定承载，保障网络直播活动额画面清晰度，传输稳定性</p>
            </li>
            <li >
                <h5>教育直播</h5>
                <p>创新在线学习模式，引领直播课堂潮流</p>
            </li>
        </ul>
    </div>
    <div class="index-block-2">
        <h4></h4>
        <h6>无论视频编解码、流媒体、课件、管理接口都采用最流行的国际标准，大幅增加互动录播的兼容性，<br/>提高可用性，更适应与其它第三方平台对接。</h6>
        <ul class="active">
            <li class="active">
                <span class="cover iconfont">&#xe650;</span>
                <div class="content">
                    <h4>多端直播</h4>
                    <p>支持PC、OTT机顶盒、超级电视等多屏播放</p>

                </div>
            </li>
            <li class="active-none">
                <span class="cover iconfont" >&#xe65c;</span>
                <div class="content">
                    <h4>云平台</h4>
                    <p>接口简单易操作可快速接入您的业务</p>

                </div>
            </li>
            <li class="active-none">
                <span class="cover iconfont">&#xe64e;</span>
                <div class="content">
                    <h4>实时性强</h4>
                    <p>支持word、ppt图片各种数据的实时传输</p>
                </div>
            </li>
            <li class="active-none">
                <span class="cover iconfont">&#xe912;</span>
                <div class="content">
                    <h4>高交互低延时</h4>
                    <p>多用户同时在线观看直播，实时书写绘制，观看页面清晰流畅</p>
                </div>
            </li>
            <li class="active-none">
                <span class="cover iconfont">&#xe907;</span>
                <div class="content">
                    <h4>音视频分流</h4>
                    <p>支持独立音频、视频直播，在直播过程可灵活切换</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="index-block-3">
        <h4></h4>
        <p>直播内容实时储存，视频上传、下载、外嵌支持。<br/>
            云媒体库兼具视频管理、储存的功能，并融合了自动转码、剪辑、拼合的视频线上处理功能，帮助用户轻松做视频运营。</p>
        <div class="block-main">
            <h4>视频点播</h4>
            <p>从媒体库选择视频即可自助创建点播频道；从云媒体库获取Iframe地址，进行页面嵌入，同样能够获取点播解决方案。</p>
            <div class="content">
                <ul>
                    <li><span>双向加速</span>上传分双向加速</li>
                    <li><span>多种格式</span>MP4，FLV，F4V，HLS，TS等通用格式</li>
                    <li><span>加密保障</span>多重安全加密机制保障视频内容</li>
                </ul>
                <span></span>
            </div>
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
            <p><span>微信</span>General_Pn</p>
            <p><span>QQ</span>800133388</p>
            <p><span>联系电话</span>0516-83994999</p>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe658;</i>关于我们</h4>
            <a href="<?php echo url('index/index/help_center'); ?>">关于我们</a>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe616;</i>合作伙伴</h4>
            <a href="http://www.aodianyun.com/" target="_blank">奥点云</a>
        </div>
        <div class="focus-qr">
            <img src="__static__/index/src/img/temp/qr.png">
            <h4>关注微信</h4>
            <h6>了解更多直播方案</h6>
        </div>
    </div>
    <div class="fot-bar">
        <p><a href="http://yyg.mengdie.com" target="_blank">梦蝶一元购</a><a href="http://ip.mengdie.com" target="_blank">芝麻代理</a><a href="http://zb.mengdie.com" target="_blank">梦蝶直播</a><a href="http://pt.mengdie.com" target="_blank">梦蝶跑腿</a></p>
        <h6>徐州灵匠信息科技有限公司 版权所有</h6>
    </div>
</div>
<input type="hidden" id="quit_url" value="<?php echo url('index/login/quit'); ?>">
<input type="hidden" id="root_url" value="<?php echo url('index/index/index'); ?>">


<script type="text/javascript" src="__static__/index/src/js/index.js"></script>

</body>
</html>