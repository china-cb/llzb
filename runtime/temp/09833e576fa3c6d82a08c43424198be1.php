<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:38:"../tpl/index/admin\channel_manage.html";i:1486274140;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/live-center.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>频道管理 - 玲珑直播</title>
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


<!-- endinject -->
<div class="main admin ">
    <div class="container without-menu">
        <div class="channel_menu">
            <a class="item item_btn <?php if($type == ''): ?>active<?php endif; ?>" data-type="list"><i class="iconfont">&#xe6ba;</i>频道管理</a>
            <!--<a class="item item_btn <?php if($type == '2'): ?>active<?php endif; ?>" data-type="data"><i class="iconfont">&#xe609;</i>数据统计</a>-->
        </div>
        <div class="content">
            <div class="block channel-block channel-list <?php if($type == ''): ?>active<?php endif; ?>">
                <div class="channel-search">
                    <label class="cs-input">
                        <input class="channel_name" name="title" placeholder="请输入视频名称">
                        <a class="cs-submit search_channel_btn"><i class="iconfont">&#xe626;</i></a>
                    </label>
                </div>
                <div class="channel-group">
                    <a class="channel-item add-new">
                        创建直播频道
                    </a>
                    <?php if(is_array($channel_list) || $channel_list instanceof \think\Collection): $i = 0; $__LIST__ = $channel_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

                        <div class="channel-item">
                            <div class="ci-btn" data-id="<?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?>">
                                <a class="location"></a>
                                <a class="return"></a>
                                <a class="pause"></a>
                                <a class="play"></a>
                                <a data-tip="删除" class="close del_channel_btn"></a>
                            </div>
                            <a href="<?php echo url('index/admin/channel',['id'=>$vo['id']]); ?>">
                            <div class="channel-cover">
                                <?php if($vo['live_status'] == '1'): ?><span class="play-flag">正在直播</span><?php endif; if(empty($vo['cover']) || ($vo['cover'] instanceof \think\Collection && $vo['cover']->isEmpty())): ?>
                                   <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?>97e76f3cf45e0e1c2a69e7bb1ae9ea73.png">
                                <?php else: ?>
                                   <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($vo['cover']) && ($vo['cover'] !== '')?$vo['cover']:''); ?>">
                                <?php endif; ?>
                                <h4><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:"暂无频道名称"); ?></h4>
                            </div>
                            <div class="channel-desc">
                                <h4>
                                    <label>观看人次:</label>
                                    <span class="cd-num"><?php echo (isset($vo['people']) && ($vo['people'] !== '')?$vo['people']:'0'); ?>人次</span>
                                </h4>
                                <h4>
                                    <label>观看时长:</label>
                                    <span class="cd-error"><?php echo (isset($vo['watch_count']) && ($vo['watch_count'] !== '')?$vo['watch_count']:'0'); ?>分钟</span>
                                </h4>
                                <h4>
                                    <label>最后直播时间:</label>
                                    <span class="cd-time">
                                        <?php if(empty($vo['end_time']) || ($vo['end_time'] instanceof \think\Collection && $vo['end_time']->isEmpty())): ?>
                                           该频道暂未直播
                                        <?php else: ?>
                                          <?php echo date("Y-m-d H:i:s",$vo['end_time']); endif; ?>
                                    </span>
                                </h4>
                            </div>
                            </a>
                            <div class="channel-control">
                                <a class="cc-item" href="<?php echo url('index/admin/channel_setting',['id'=>$vo['id']]); ?>">
                                    <span>
                                        <i class="iconfont">&#xe604;</i>
                                    </span>
                                    <h4>频道设置</h4>
                                </a>
                                <a class="cc-item" href="<?php echo url('index/admin/channel_count_data',['id'=>$vo['id']]); ?>">
                                    <span>
                                        <i class="iconfont">&#xe6ba;</i>
                                    </span>
                                    <h4>数据统计</h4>
                                </a>
                                <a class="cc-item" href="<?php echo url('index/preview/index',['cid'=>$vo['id']]); ?>" target="_blank">
                                    <span>
                                        <i class="iconfont">&#xe77f;</i>
                                    </span>
                                    <h4>PC预览</h4>
                                </a>
                                <a class="cc-item phone-view">
                                    <span>
                                        <i class="iconfont">&#xe62a;</i>
                                    </span>
                                    <h4>手机预览</h4>
                                    <div class="phone-view-hd">
                                        <!--<img src="__static__/index/src/img/temp/qr.png">-->
                                        <img src="<?php echo url('core/business/qr_base64',['text'=>base64_encode($vo['mobile_live'])]); ?>">
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <!--<div class="block channel-block channel-data <?php if($type == '2'): ?>active<?php endif; ?>">-->
                <!--<span class="title">统计报表</span>-->
                <!--<div class="drop-sel channel-change">-->
                    <!--<div class="dp-content">-->
                        <!--<span class="dp-text"><?php echo (isset($channel_list[0]['title']) && ($channel_list[0]['title'] !== '')?$channel_list[0]['title']:'&#45;&#45;'); ?></span>-->
                        <!--<button class="dp-icon"></button>-->
                        <!--<input type="hidden">-->
                        <!--<ul class="dp-group">-->
                            <!--<?php if(is_array($channel_list) || $channel_list instanceof \think\Collection): $i = 0; $__LIST__ = $channel_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                               <!--<li class="dp-item" data-id="<?php echo $vo['title']; ?>"><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:"&#45;&#45;"); ?></li>-->
                            <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                        <!--</ul>-->
                    <!--</div>-->

                <!--</div>-->
                <!--<div class="time-change">-->
                    <!--<div class="drop-sel time-ds">-->
                        <!--<label class="dp-label">开始时间</label>-->
                        <!--<input type="hidden">-->
                        <!--<div class="dp-content">-->
                            <!--<span class="dp-text">2016-01</span>-->
                            <!--<button class="dp-icon"></button>-->
                            <!--<ul class="dp-group">-->
                                <!--<li class="dp-item" data-val="2010-01-01">2016-01</li>-->
                                <!--<li class="dp-item" data-val="2010-01-01">2016-02</li>-->
                                <!--<li class="dp-item" data-val="2010-01-01">2016-03</li>-->
                                <!--<li class="dp-item" data-val="2010-01-01">2016-04</li>-->
                                <!--<li class="dp-item" data-val="2010-01-01">2016-05</li>-->
                            <!--</ul>-->
                        <!--</div>-->
                    <!--</div>-->
                    <!--<a class="tc-submit">查询</a>-->
                <!--</div>-->
                <!--<div class="cd-container">-->
                    <!--<div class="cd-menu">-->
                        <!--<a class="cdm-item">-->
                            <!--流量统计-->
                        <!--</a>-->
                        <!--<a class="cdm-item">-->
                            <!--宽带统计-->
                        <!--</a>-->
                    <!--</div>-->
                    <!--<div class="cd-block flow-data">-->
                        <!--<div>-->
                            <!--这里是流量统计报表-->
                        <!--</div>-->
                        <!--<p class="title">-->
                            <!--统计数据仅供参考,实际数据以账单为准-->
                        <!--</p>-->
                    <!--</div>-->
                    <!--<div class="cd-block wb-data">-->
                        <!--<div>-->
                            <!--这里是宽带统计报表-->
                        <!--</div>-->
                        <!--<p class="title">-->
                            <!--统计数据仅供参考,实际数据以账单为准-->
                        <!--</p>-->
                    <!--</div>-->
                <!--</div>-->
            <!--</div>-->
        </div>
    </div>
</div>
<div class="modal m-channel-add">
    <div class="modal-main">
        <span class="close">&#xe607;</span>
        <h4>创建频道</h4>
        <div class="modal-form">
            <div class="mf-line">
                <label class="mfl-warp" > 频道名称<input type="text" id="channel_name" placeholder="请输入频道名称"></label>
            </div>
            <div class="mf-line">
                <label class="mfl-warp">频道类型 <span class="text channel">RTMP</span></label>
            </div>
            <button class="mf-submit set_channel_btn">创建频道</button>
        </div>
    </div>
</div>
<div class="modal m-channel-url ">
    <div class="modal-main">
        <span class="close url_close">&#xe607;</span>
        <div class="m-url-top">
            <img src="__static__/index/src/img/temp/cover-img.png" class="channel_img">
            <h4 class="channel_title" >这是频道标题内容</h4>
        </div>
        <div class="m-url-list">
            <div class="container">
                <div class="item">
                    <h4>推流地址</h4>
                    <div class="url-line">
                        <label><input value="1111" id="push"></label>
                        <a class="copy" data-id="push">复制</a>
                    </div>
                </div>
                <div class="item">
                    <h4>拉流地址（RTMP）</h4>
                    <div class="url-line">
                        <label><input value="222" id="rtmp"></label>
                        <a class="copy" data-id="rtmp">复制</a>
                    </div>
                </div>
                <div class="item">
                    <h4>拉流地址（HLS）</h4>
                    <div class="url-line">
                        <label><input value="333" id="hls"></label>
                        <a class="copy" data-id="hls">复制</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="set_channel_url" value="<?php echo url('index/admin/set_channel'); ?>">
<input type="hidden" id="search_channel_url" value="<?php echo url('index/admin/search_channel'); ?>">
<input type="hidden" id="del_channel_url" value="<?php echo url('index/admin/del_channel'); ?>">
<input type="hidden" id="liu_channel_url" value="<?php echo url('index/admin/ajax_liu_info'); ?>">

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

<script type="text/javascript" src="__static__/index/src/js/admin/admin.js"></script>
<script type="text/javascript" src="__static__/index/src/js/admin/channel_manager.js"></script>
<script type="text/javascript" src="__static__/index/js/admin/channel.js"></script>

</body>
</html>