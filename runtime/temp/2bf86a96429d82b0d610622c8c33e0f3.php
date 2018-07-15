<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:37:"../tpl/index/admin\channel_count.html";i:1484964687;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin_channel.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>频道管理-用户管理 直播中心</title>
</head>
<body>
<!-- inject:admin_header:html -->
<div class="header admin">
    <div class="h-bar">
        <div class="warp">
            <h6 class="info" >服务热线：0516-83994999（周一至周五9:00～18:00）</h6>
            <a class="logo" href=""></a>
            <div class="nav">
                <div class="name">你好,<a>
                    <?php if(empty($user_info['nick_name']) || ($user_info['nick_name'] instanceof \think\Collection && $user_info['nick_name']->isEmpty())): ?>
                    <?php echo (isset($user_info['phone']) && ($user_info['phone'] !== '')?$user_info['phone']:''); else: ?>
                    <?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:"大哥,您火星来的吧"); endif; ?>
                </a></div>
                <a class="logout quit_btn">退出</a>
<!--                <a class="nav-item">安全中心</a>
                <a class="nav-item">会员保障</a>
                <a class="nav-item">客户服务</a>-->
            </div>
        </div>
    </div>
    <div class="h-main">
        <div class="warp">
            <a class="logo-top" href="<?php echo url('index/index/index'); ?>"></a>
            <ul class="hm-menu">
                <li class="menu-item active"><a href="<?php echo url('index/admin/index'); ?>">玲珑首页</a></li>
                <li class="menu-item">
                    <div class="mi-list">
                        <div class="menu-content">
                            <a class="mc-close">
                                <i class="iconfont">&#xe61f;</i>
                            </a>
                            <a href="<?php echo url('index/admin/channel_manage'); ?>" class="mc-item">
                                频道管理
                            </a>
<!--                            <a href="<?php echo url('index/admin/channel_manage',['type'=>2]); ?>" class="mc-item">
                                数据统计
                            </a>-->
                        </div>
                        <div class="menu-title">直播服务</div>
                    </div>
                </li>
                <li class="menu-center">
                    <div class="user-info-warp">
                        <div class="user-ava">
                            <?php if(empty($user_info['user_face']) || ($user_info['user_face'] instanceof \think\Collection && $user_info['user_face']->isEmpty())): ?>
                            <img src="__static__/index/src/img/temp/user_ava.png">
                            <?php else: ?>
                            <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($user_info['user_face']) && ($user_info['user_face'] !== '')?$user_info['user_face']:''); ?>">
                            <?php endif; ?>
                            <h4>你好,<span>
                                <?php if(empty($user_info['nick_name']) || ($user_info['nick_name'] instanceof \think\Collection && $user_info['nick_name']->isEmpty())): ?>
                                   <?php echo (isset($user_info['phone']) && ($user_info['phone'] !== '')?$user_info['phone']:''); else: ?>
                                   <?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:"大哥,您火星来的吧"); endif; ?>
                            </span></h4>
                            <div class="user-auth">
                                <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="real-name "></a>
                                <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="phone "></a>
                                <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="email "></a>
                            </div>
                            <div class="user-info">
                                <div class="info-item">
                                    <p><span>账户类型 :</span><?php switch($user_info['account_type']): case "1": ?>基础版<?php break; case "2": ?>专业版<?php break; case "3": ?>企业版<?php break; default: ?>基础版
                                        <?php endswitch; ?>
                                        <a class="updata">升级</a></p>
                                    <p><span>账户余额 :</span>¥<?php echo (isset($user_info['balance']) && ($user_info['balance'] !== '')?$user_info['balance']:'0.00'); ?><a class="charge" href="<?php echo url('index/user_center/account','type=3'); ?>">充值</a></p>
                                    <p><span>套餐类型 :</span><?php echo (isset($user_info['type']) && ($user_info['type'] !== '')?$user_info['type']:'无'); ?><a class="buy">购买</a></p>
                                </div>
                            </div>
                        </div>
                        <a class="mc-close quit_btn">退出</a>
                    </div>
                </li>
                <li class="menu-item"><a href="<?php echo url('index/admin/developing'); ?>" class="demand_live">点播服务</a></li>
                <li class="menu-item">
                    <div class="mi-list">
                        <div class="menu-content">
                            <a class="mc-close">
                                <i class="iconfont">&#xe61f;</i>
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="mc-item">
                                账户信息
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=2'); ?>" class="mc-item">
                                我的套餐
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=3'); ?>" class="mc-item">
                                余额充值
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=4'); ?>" class="mc-item">
                                充值订单
                            </a>
                        </div>
                        <div class="menu-title">账户管理</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


    <script  src="__static__/index/src/js/admin/admin.js" type="text/javascript"></script>
<!-- endinject -->
<div class="main admin admin-bg-1 channel-user">
    <div class="channel-title">
        直播监控
        <div class="drop-sel channel-change">
            <div class="dp-content">
                <span class="dp-text"><?php echo (isset($channel_info['title']) && ($channel_info['title'] !== '')?$channel_info['title']:"--"); ?></span>
                <button class="dp-icon"></button>
                <input type="hidden" value="2010-01-01">
                <ul class="dp-group">
                    <?php if(is_array($channel_list) || $channel_list instanceof \think\Collection): $i = 0; $__LIST__ = $channel_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li class="dp-item channel_title" data-val="<?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?>"><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:"--"); ?></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content  ">
            <span class="cu-title">用户管理</span>
            <h4>累计用户量:
                <span class="all_count_num"><?php echo (isset($total) && ($total !== '')?$total:'0'); ?></span>
                <a class="export_data_btn" href="<?php echo url('index/admin/export_user_data',['cid'=>$channel_info['id']]); ?>">数据导出</a>
            </h4>
            <div class="cu-sheet user_count">
                <div class="cs-th">
                    <div class="cs-td nick"><i class="iconfont">&#xe630;</i>用户昵称</div>
                    <div class="cs-td address"><i class="iconfont">&#xe642;</i>地址</div>
                    <div class="cs-td time"><i class="iconfont">&#xe619;</i>观看时长</div>
                    <div class="cs-td phone"><i class="iconfont">&#xe627;</i>手机号</div>
                    <div class="cs-td vv"><i class="iconfont">&#xe6f8;</i>访问次数</div>
                    <div class="cs-td chat"><i class="iconfont">&#xe613;</i>聊天数</div>
                    <div class="cs-td time-1"><i class="iconfont">&#xe61a;</i>首次登录时间</div>
                    <div class="cs-td time-2"><i class="iconfont">&#xe695;</i>最后在线时间</div>
                    <div class="cs-td device"><i class="iconfont">&#xe628;</i>最后登录设备</div>
                    <div class="cs-td way"><i class="iconfont">&#xe675;</i>最后登录方式</div>
                </div>
                <?php if(empty($channel_user) || ($channel_user instanceof \think\Collection && $channel_user->isEmpty())): ?>
                   <div class="cs-tr" colspan="12">暂无记录..</div>
                <?php else: if(is_array($channel_user) || $channel_user instanceof \think\Collection): $i = 0; $__LIST__ = $channel_user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                   <div class="cs-tr">
                    <div class="cs-td nick">
                        <h4>
                            <?php if(empty($vo['face_img']) || ($vo['face_img'] instanceof \think\Collection && $vo['face_img']->isEmpty())): ?>
                            <img src="__static__/index/src/img/temp/user_ava.png">
                            <?php else: ?>
                            <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($vo['face_img']) && ($vo['face_img'] !== '')?$vo['face_img']:''); ?>" alt="">
                            <?php endif; ?>
                            <span>
                               <?php if(mb_strlen($vo['nick_name'],'utf8') <= '4'): ?>
                                   <?php echo (isset($vo['nick_name']) && ($vo['nick_name'] !== '')?$vo['nick_name']:'匿名用户'); else: ?>
                                   <?php echo mb_substr($vo['nick_name'],0,4,'utf-8'); ?>..
                               <?php endif; ?>
                            </span>
                        </h4>
                    </div>
                    <div class="cs-td address">
                        <span><?php echo (isset($vo['address']) && ($vo['address'] !== '')?$vo['address']:"--"); ?></span>
                    </div>
                    <div class="cs-td time">
                        <!--<span><?php echo (gmstrftime("%H:%M:%S",$vo['watch_count']) !== ''?gmstrftime("%H:%M:%S",$vo['watch_count']):"0"); ?></span>-->
                        <span><?php echo (isset($vo['watch_count']) && ($vo['watch_count'] !== '')?$vo['watch_count']:"0"); ?>分钟</span>
                    </div>
                    <div class="cs-td phone">
                        <span><?php echo (isset($vo['phone']) && ($vo['phone'] !== '')?$vo['phone']:"--"); ?></span>
                    </div>
                    <div class="cs-td vv">
                        <span><?php echo (isset($vo['visit_count']) && ($vo['visit_count'] !== '')?$vo['visit_count']:'0'); ?></span>
                    </div>
                    <div class="cs-td chat">
                        <span><?php echo (isset($vo['chat_count']) && ($vo['chat_count'] !== '')?$vo['chat_count']:'0'); ?></span>
                    </div>
                    <div class="cs-td time-1">
                        <span>
                            <?php if(empty($vo['create_time']) || ($vo['create_time'] instanceof \think\Collection && $vo['create_time']->isEmpty())): ?>
                               --
                            <?php else: ?>
                               <?php echo date("Y.m.d H:i",$vo['create_time']); endif; ?>
                        </span>
                    </div>
                    <div class="cs-td time-2">
                        <span>
                            <?php if(empty($vo['end_time']) || ($vo['end_time'] instanceof \think\Collection && $vo['end_time']->isEmpty())): ?>
                               --
                            <?php else: ?>
                               <?php echo date("Y.m.d H:i",$vo['end_time']); endif; ?>
                        </span>
                    </div>
                    <div class="cs-td device">
                        <span><?php echo (isset($vo['last_login_device']) && ($vo['last_login_device'] !== '')?$vo['last_login_device']:"电脑端"); ?></span>
                    </div>
                    <div class="cs-td way">
                        <span><?php echo (isset($vo['last_login_type']) && ($vo['last_login_type'] !== '')?$vo['last_login_type']:"pc"); ?></span>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                <div class="page">
                    <?php echo (isset($page) && ($page !== '')?$page:''); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="channel_user_url" value="<?php echo url('index/admin/ajax_channel_user'); ?>">

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

<script type="text/javascript" src="__static__/index/js/admin/channel.js"></script>
<script type="text/javascript" src="__static__/index/src/js/admin/admin.js"></script>
<script type="text/javascript" src="__static__/index/src/js/admin_account.js"></script>


</body>
</html>