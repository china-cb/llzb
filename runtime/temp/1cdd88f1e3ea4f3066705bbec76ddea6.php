<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:31:"../tpl/index/admin\channel.html";i:1486541781;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin_monitor.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/preview.css" />
<style>
    #wisIframe {
        min-height:720px;
        width: 850px;
        margin:0 auto;
    }
    #__wis__sm__container__{
        display: none;
    }
</style>

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
    <div class="container">
        <!-- inject:admin_menu:html -->
        <ul class="menu">
            <li class="menu-item channel_menu active">
                <a class="mi-text" href="<?php echo url('index/admin/channel',['id'=>$channel_info['id']]); ?>">
                    <i class="iconfont">&#xe615;</i>
                    直播监控
                </a>
            </li>
            <li class="menu-item">
                <a class="mi-text" href="<?php echo url('index/admin/channel_setting',['id'=>$channel_info['id']]); ?>">
                    <i class="iconfont">&#xe729;</i>
                    频道设置
                </a>
            </li>
            <li class="menu-item">
                <a class="mi-text" href="<?php echo url('index/admin/channel_count',['id'=>$channel_info['id']]); ?>">
                    <i class="iconfont">&#xe610;</i>
                    用户管理
                </a>
            </li>
            <li class="menu-item">
                <a class="mi-text" href="<?php echo url('index/admin/channel_count_data',['id'=>$channel_info['id']]); ?>">
                    <i class="iconfont">&#xe656;</i>
                    数据统计
                </a>
            </li>
        </ul>
        <!-- endinject -->
        <div class="content">
            <div class="block-com view-top">
                <h4 class="title">直播监控</h4>
                <div class="object">
                    <div class="warp" id="media1">
                    </div>
                    <div class="warp" id="media2" style="display: none">
                    </div>
                    <a class="control" style="display: none">断开直播</a>
                </div>
                <div class="info">
                    <div class="nav">
                        <a class="active">推流地址</a>
                        <a class="">拉流直播</a>
                        <a class="">列表直播</a>
                        <a class="">桌面直播</a>
                        <a class="">手机直播</a>
                    </div>
                    <div class="content ">
                        <div class="m-input">
                            <label>
                                <input value="<?php echo (isset($channel_info['push_url']) && ($channel_info['push_url'] !== '')?$channel_info['push_url']:''); ?>" id="push_url1">
                                <button class="btn" onClick="copy_push_url1()">复制</button>
                            </label>
                        </div>
                    </div>
                    <div class="content ">
                        <div class="m-input">
                            <label>
                                <input class="rtmp_url" placeholder="请输入拉流地址">
                                <button class="btn start_live">开始直播</button>
                            </label>
                            <p class="tip">
                                拉流地址支持：  直播流：rtmp ; 点播流：hls
                            </p>
                        </div>
                    </div>
                    <div class="content  view-list">
                        <div class="view-list-menu">
                            <ul class="warp">
                                <li class="item add" data-ref="" data-id="<?php echo (isset($channel_info['id']) && ($channel_info['id'] !== '')?$channel_info['id']:''); ?>"><i class="iconfont">&#xe637;</i>添加列表</li>
                                <?php if(is_array($video_list) || $video_list instanceof \think\Collection): $k = 0; $__LIST__ = $video_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                    <li data-listid="ref_<?php echo $vo['list_id']; ?>" class="item channel-video" data-id="<?php echo (isset($vo['list_id']) && ($vo['list_id'] !== '')?$vo['list_id']:''); ?>">
                                        <span class="list-name"><?php echo (isset($vo['list_name']) && ($vo['list_name'] !== '')?$vo['list_name']:'暂无名称'); ?></span>
                                        <label>
                                            <input class="list_name" type="text">
                                            <a class="ensure" data-tip="保存"></a>
                                        </label>
                                        <a class="edit" data-tip="编辑"></a>
                                        <a class="delete" data-tip="删除"></a>
                                    </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <div class="view-content">
                            <?php if(empty($video_list) || ($video_list instanceof \think\Collection && $video_list->isEmpty())): ?>
                            <div class="empty empty-warp">
                                <h6>当前直播没有内容</h6>
                                <p>请先添加列表</p>
                            </div>
                            <?php else: ?>
                            <div class="empty empty-warp" style="display: none;">
                                <h6>当前直播没有内容</h6>
                                <p>请先添加列表</p>
                            </div>
                            <?php if(is_array($video_list) || $video_list instanceof \think\Collection): $k = 0; $__LIST__ = $video_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>

                                <div id="ref_<?php echo $vo['list_id']; ?>" class="vc-block">
                                    <?php if(empty($vo['data']) || ($vo['data'] instanceof \think\Collection && $vo['data']->isEmpty())): ?>
                                    <div class="container con-empty">
                                        <div class="empty">
                                                <h6>当前列表为空</h6>
                                                <a class="upload_video" data-lid="<?php echo (isset($vo['list_id']) && ($vo['list_id'] !== '')?$vo['list_id']:''); ?>"><i class="iconfont">&#xe638;</i>添加视频</a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                    <div class="container">
                                        <div class="warp">
                                            <?php if(is_array($vo['data']) || $vo['data'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['data'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
                                            <div class="video-list">
                                                <?php if(empty($list['cover_img']) || ($list['cover_img'] instanceof \think\Collection && $list['cover_img']->isEmpty())): ?>
                                                   <img src="__static__/index/src/img/temp/cover-img.png">
                                                <?php else: ?>
                                                   <img src="<?php echo (isset($list['cover_img']) && ($list['cover_img'] !== '')?$list['cover_img']:''); ?>" alt="">
                                                <?php endif; ?>
                                                <div class="info">
                                                    <h4><span>原片</span><?php echo (isset($list['name']) && ($list['name'] !== '')?$list['name']:'暂无名称'); ?></h4>
                                                    <!--<div class="process" >-->
                                                    <!--<div class="axis"><span style="width:15.5%"></span></div>-->
                                                    <!--<span class="label">14.5%</span>-->
                                                    <!--</div>-->
                                                </div>
                                                <span><?php echo (isset($list['duration']) && ($list['duration'] !== '')?$list['duration']:'0'); ?></span>
                                            </div>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </div>
                                    </div>
                                    <div class="vc-con-bar">
                                        <a class="btn list_live" data-lid="<?php echo (isset($vo['list_id']) && ($vo['list_id'] !== '')?$vo['list_id']:''); ?>"><i class="iconfont">&#xe606;</i>开始直播</a>
                                        <a class="btn upload_video" data-lid="<?php echo (isset($vo['list_id']) && ($vo['list_id'] !== '')?$vo['list_id']:''); ?>"><i class="iconfont">&#xe638;</i>添加新视频</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div>
                    </div>
                    <div class="content ">
                        <div class="tablet-download">
                            <h4>支持摄像头直播 电脑桌面演示直播</h4>
                            <div class="down-btn">
                                <a>Windows 版</a>
                                <a>Mac 版</a>
                            </div>
                            <p>桌面直播推流地址: <span><?php echo (isset($channel_info['push_url']) && ($channel_info['push_url'] !== '')?$channel_info['push_url']:''); ?></span></p>
                        </div>
                    </div>
                    <div class="content phone">
                        <div class="m-input">
                            <label>
                                <input value="<?php echo (isset($channel_info['push_url']) && ($channel_info['push_url'] !== '')?$channel_info['push_url']:''); ?>" id="push_url2">
                                <button class="btn" onClick="copy_push_url2()">复制</button>
                            </label>
                        </div>
                        <div class="download-qr"><i class="iconfont">&#xe6f6;</i>安卓扫码下载
                            <div class="hd-block">
                                <img src="__static__/index/src/img/temp/qr.png">
                            </div>
                        </div>
                        <div class="download-qr"><i class="iconfont">&#xe712;</i>苹果扫码下载
                            <div class="hd-block"><img src="__static__/index/src/img/temp/qr.png"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-com view-docs">
                <h4 class="title">直播文档</h4>
                <div class="doc-top">
                    <div class="right-control">
                        <div class="hide-switch">
                            <span>观看页显示</span>
                            <label class="ll-switch">
                                <input id="hs-1" type="checkbox" <?php if($channel_info['wis_type'] == '1'): ?> checked="checked" <?php endif; ?>>
                                <label class="white_switch"></label>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="doc-view wis-block <?php if($channel_info['wis_type'] == '0'): ?>hide<?php endif; ?>" >
                    <iframe id="wisIframe" frameborder="0" name="wisIframe" ></iframe>
                    <a class="doc-bt-view" href="<?php echo url('index/preview/index',['cid'=>$channel_info['id']]); ?>" target="_blank">观看预览</a>
                </div>
            </div>
            <div class="block-com view-message ">
                <!--<span class="con-tips forbid">用户被禁言</span>-->
                <h4 class="title">聊天互动</h4>
                <div class="mes-list ">
                    <div class="container ">
                        <ul class="mes-l-warp">
                        </ul>
                    </div>
                    <div class="doc-send">
                        <div class="warp">
                            <input placeholder="我也来说两句" data-tip="ctrl + enter 快捷发送">
                            <a class="face" data-tip="发送表情"><i class="iconfont">&#xe635;</i>

                            </a>
                            <div class="face-block">
                                <span class="face-warp"></span>
                            </div>
                            <a class="send">发表

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div>-->
                <!--<iframe id="wisIframe" frameborder="0" ></iframe>-->
                <!--<a href="<?php echo url('white_live',['uid'=>$uid,'cid'=>$channel_info['id']]); ?>" target="_blank">观看预览</a>-->
            <!--</div>-->
        </div>
    </div>
</div>
<input type="hidden" id="upload_html_url" value="<?php echo url('index/admin/upload_html'); ?>">
<input type="hidden" id="cid" value="<?php echo (isset($channel_info['id']) && ($channel_info['id'] !== '')?$channel_info['id']:''); ?>">
<input type="hidden" id="uid" value="<?php echo (isset($channel_info['uid']) && ($channel_info['uid'] !== '')?$channel_info['uid']:''); ?>">
<input type="hidden" id="add_video_url" value="<?php echo url('index/admin/add_video_list'); ?>">
<input type="hidden" id="edit_video_url" value="<?php echo url('index/admin/update_video'); ?>">
<input type="hidden" id="update_live" value="<?php echo url('index/admin/update_live'); ?>">
<input type="hidden" id="hls_live_url" value="<?php echo url('index/admin/hls_live'); ?>">
<input type="hidden" id="recordUrl" value="<?php echo (isset($recordUrl) && ($recordUrl !== '')?$recordUrl:''); ?>">
<input type="hidden" id="update_live_record" value="<?php echo url('update_live_record'); ?>">
<input type="hidden" id="first_url" value="<?php echo url('get_first_url'); ?>">
<input type="hidden" id="break_url" value="<?php echo url('break_channel_live'); ?>">
<input type="hidden" id="white_switch_url" value="<?php echo url('white_switch'); ?>">

<input type="hidden" id="sign" value="false">
<input type="hidden" id="last_update_time" value="0">
<input type="hidden" id="msg_url" value="<?php echo url('index/admin/msg',['cid'=>$channel_info['id']]); ?>">
<input type="hidden" id="nick_name" value="<?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:'匿名网友'); ?>">
<input type="hidden" id="user_face" value="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($channel_info['user_face']) && ($channel_info['user_face'] !== '')?$channel_info['user_face']:'09b0deb8ac55e50fef76c0870d5a0052.png'); ?>">
<input type="hidden" id="background" value="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($channel_info['window']) && ($channel_info['window'] !== '')?$channel_info['window']:''); ?>">
<input type="hidden" id="user_type" value="1">
<input type="hidden" id="user_value" value="<?php echo (isset($channel_info['uid']) && ($channel_info['uid'] !== '')?$channel_info['uid']:''); ?>">
<input type="hidden" id="gag_url" value="<?php echo url('gag_channel_user'); ?>">
<input type="hidden" id="top_url" value="<?php echo url('top_news'); ?>">
<input type="hidden" id="top_and_gag_url" value="<?php echo url('get_top_gag_info'); ?>">
<input type="hidden" id="delete_tis_url" value="<?php echo url('delete_tis'); ?>">
<input type="hidden" id="check_account_balance_url" value="<?php echo url('core/business/check_account_balance'); ?>">
<input type="hidden" id="recharge_url" value="<?php echo url('index/index/package'); ?>">
<input type="hidden" id="del_video_list" value="<?php echo url('del_video'); ?>">
<input type="hidden" id="get_video_url" value="<?php echo url('get_video_success'); ?>">
<input type="hidden" id="cancel_top_url" value="<?php echo url('cancel_top_new'); ?>">

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

<script src="http://cdn.aodianyun.com/wis/exchange.js"></script>
<script type="text/javascript" src="http://cdn.aodianyun.com/static/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://cdn.aodianyun.com/static/plupload/js/plupload.full.min.js"></script>
<script type="text/javascript" src="http://cdn.aodianyun.com/static/plupload/js/jquery.simple.ui.plupload/jquery.simple.ui.plupload.min.js"></script>
<script type="text/javascript" src="http://cdn.aodianyun.com/static/plupload/js/i18n/zh_CN.js"></script>
<script type="text/javascript" src="__static__/index/src/js/tis/tis_api.js"></script>
<script type="text/javascript" src="__static__/index/src/js/tis/tis.js"></script>
<script type="text/javascript" src="__static__/index/src/js/admin/admin.js"></script>
<script type="text/javascript" src="__static__/index/src/js/admin/admin_monitor.js"></script>
<script type="text/javascript" src="__static__/index/js/admin/upload.js"></script>


<script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
<script>
    function copy_push_url1()
    {
        var Url1=document.getElementById("push_url1");
        Url1.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        layer.msg('已复制,按ctr+v粘贴',{time:1000});
    }
    function copy_push_url2()
    {
        var Url1=document.getElementById("push_url2");
        Url1.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        layer.msg('已复制,按ctr+v粘贴',{time:1000});
    }
</script>
<script type="text/javascript">
    $(function(){
        $(".white_switch").click(function(){
            if($('#hs-1').is(':checked')){
                $('#hs-1').prop("checked",true);
                var  white_value = 0;
                var  tips = "您确定要关闭直播文档么?";
            }else{
                $('#hs-1').prop("checked",false);
                var  tips = "您确定要打开直播文档么?";
                var  white_value = 1;
            }
            layer.confirm(tips,{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
                var white_switch_url = $("#white_switch_url").val();
                common.ajax_post(white_switch_url,{cid:cid,white_value:white_value},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        if(white_value == 0){
                            $('#hs-1').prop("checked",false);
                            $(".wis-block").addClass('hide');
                        }else{
                            $('#hs-1').prop("checked",true);
                            $(".wis-block").removeClass('hide');
                        }
                    }
                    common.post_tips(rt);
                });
            });

        });
        var index1;
        var index2;
        var uid = $("#uid").val();
        var cid = $("#cid").val();
        var objectPlayer1=new aodianPlayer({
            container:'media1',//播放器容器ID，必要参数
            rtmpUrl:"rtmp://26836.lssplay.aodianyun.com/linglong735/0_1?k=d7b7140d463c4b6d98b4fddc118babfe&t=1484190902",//控制台开通的APP rtmp地址，必要参数
            /* 以下为可选参数*/
            width: '320',//播放器宽度，可用数字、百分比等
            height: '180',//播放器高度，可用数字、百分比等
            autostart: true,//是否自动播放，默认为false
            bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
            maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
            stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
            controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
            adveDeAddr: $("#background").val(),//封面图片链接
            adveWidth: '320',//封面图宽度
            adveHeight: '180',//封面图高度
            //adveReAddr: '',//封面图点击链接
            //isclickplay: false,//是否单击播放，默认为false
            isfullscreen: true//是否双击全屏，默认为true
        });

        /** 拉流直播 */
        $(document).on("click",".start_live",function(){
            window.clearInterval(index1);
            $("#media1").show();
            $("#media2").hide();
            var live_url = $(".rtmp_url").val();
            var url = $("#update_live_record").val();
            setTimeout(function(){
                common.ajax_post(url,{cid:cid,live_url:live_url,url_style:1,live_type:2},true,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        objectPlayer1.changePlayer(live_url);
                        $(".control").show();
                    }else{
                        common.post_tips(rt);
                    }
                },true);
            },1000);
        });

        var objectPlayer2=new aodianPlayer({
            container:'media2',//播放器容器ID，必要参数
            hlsUrl:"http://26836.hlsplay.aodianyun.com/linglong735/111111111111.m3u8?",//控制台开通的APP hls地址，必要参数
            /* 以下为可选参数*/
            width: '320',//播放器宽度，可用数字、百分比等
            height: '180',//播放器高度，可用数字、百分比等
            autostart: true,//是否自动播放，默认为false
            bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
            maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
            stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
            controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
            adveDeAddr: 'www.oss.com',//封面图片链接
            adveWidth: '320',//封面图宽度
            adveHeight: '180',//封面图高度
            //adveReAddr: '',//封面图点击链接
            //isclickplay: false,//是否单击播放，默认为false
            isfullscreen: true//是否双击全屏，默认为true
        });

         //首次加载时判断当前是否在直播
        var first_url = $("#first_url").val();
        setTimeout(function(){
            common.ajax_post(first_url,{uid:uid,cid:cid},true,function(rt){
                var obj = common.str2json(rt);
                var data = obj.ret_data;
                if(obj.code == 1){
                    if(data['url_style'] == 1){
                        $("#media1").show();
                        $("#media2").hide();
                         objectPlayer1.changePlayer(data['url']);
                        $(".control").show();
                    }else{
                        $("#media2").show();
                        $("#media1").hide();
                        $(".control").show();
                        var first_time = 0;
                        index1 = setInterval(function(){
                            first_time = objectPlayer2.currenttime();
                            if(first_time == 0){
                                objectPlayer2.changePlayer(data['url']);
                            }
                        },2000);
                    }
                }
            });
        },3000);

        /** 检测余额 */
        setInterval(function(){
            var uid = $("#uid").val();
            var url = $("#check_account_balance_url").val();
            common.ajax_post(url,{uid:uid},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code != 1){
                    layer.confirm(obj.msg,{btn:['立即充值','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
                         var recharge_url = $("#recharge_url").val();
                         window.open(recharge_url);
                    });
                    objectPlayer1.stopPlay();//停止直播 */
                    objectPlayer2.stopPlay();//停止直播 */
                }
            });
        },30000);

        /**断开直播 */
        $(document).on("click",".control",function(){
            var break_url = $("#break_url").val();
            layer.confirm("您确定要关闭直播吗?<br><span style='font-size: 13px;color:#ff0000;font-weight: bolder;'>如果您是使用推流直播,请先关闭OBS等推流软件再关闭直播</span>",{btn:['确定','取消'],icon:3,skin:'layui-layer-lan',title:'玲珑TV小提示'},function(){
                common.ajax_post(break_url,{uid:uid,cid:cid},false,function(rt){
                    var obj = common.str2json(rt);
                    if(obj.code == 1){
                        clearInterval(index1);
                        clearInterval(index2);
                        if(obj.ret_data == 1){
                            objectPlayer1.stopPlay();//停止直播 */
                        }else{
                            objectPlayer2.stopPlay();
                        }
                        layer.msg("断开成功",{icon:1});
                        $(".control").hide();
                    }else{
                        common.post_tips(rt);
                    }
                });
            });
        });

        $(document).on("click",".list_live",function(){
            $("#media1").hide();
            $("#media2").show();
            var curr = 0; // 初始化播放的视频索引
            var vList = '';
            var cid = $("#cid").val();
            var lid = $(this).data('lid');
            var url = $("#hls_live_url").val();
            common.ajax_post(url,{cid:cid,lid:lid},true,function(rt){
                var obj = common.str2json(rt);
                if(obj.code == 1){
                    vList = obj.ret_data; // 初始化播放列表
                    var vLen = vList.length; // 播放列表的长度
                    var cur_time = 0;
                    setTimeout(function(){
                        index2 = setInterval(function(){
                            cur_time = objectPlayer2.currenttime();
                            if(cur_time == 0){
                                var update_url = $("#update_live_record").val();
                                common.ajax_post(update_url,{cid:cid,live_url:vList[curr],url_style:2,live_type:3},true,function(rt){
                                    var obj = common.str2json(rt);
                                    if(obj.code == 1){
                                        objectPlayer2.changePlayer(vList[curr]);
                                        curr++;
                                        if (curr >= vLen){
                                            curr = 0; // 播放完了，重新播放
                                        }
                                    }else{
                                        common.post_tips(rt);
                                    }
                                });
                            }
                        },2000);
                    },1000);
                }
            });
        });

        $(".menu-item").removeClass("active");
        $(".channel_menu").addClass("active");
    });
    /* rtmpUrl与hlsUrl同时存在时播放器优先加载rtmp*/
    /* 以下为Aodian Player支持的事件 */
    /* objectPlayer.startPlay();//播放 */
    /* objectPlayer.pausePlay();//暂停 */
    /* objectPlayer.stopPlay();//停止 hls不支持*/
    /* objectPlayer.closeConnect();//断开连接 */
    /* objectPlayer.setMute(true);//静音或恢复音量，参数为true|false */
    /* objectPlayer.setVolume(volume);//设置音量，参数为0-100数字 */
    /* objectPlayer.setFullScreenMode(1);//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。手机不支持 */

</script>
<script>
    var urlParam = $("#recordUrl").val() + "&tm=" + new Date().getTime();
    var url = "http://web.wis.aodianyun.com/record.php?" + urlParam;
    $(function () {
        $("#wisIframe").attr("src", url + "&style=112");
        $("#wisIframe").load(function () {
            console.log(WISExchange);
            WISExchange.Init({
                iframe: "wisIframe",
                onSuccess: function (info) {
                },
                onDocLoad: function (info) {
                    WISExchange.Clear();
                    WISExchange.AllowDraw({ ballow: true });
                    $("#__wis__sm__container__").hide();
                },
                onPageChange: function (info) {
                    WISExchange.Clear();
                    WISExchange.AllowDraw({ ballow: true });
                    $("#__wis__sm__container__").hide();
                },
                onFailure: function (info) {
                    console.log("onFailure", info.error);
                }
            });

        });

        $(".toggleBtn").click(function() {
            if ($(this).hasClass("active"))
                $(this).removeClass("active");
            else
                $(this).addClass("active");
        });
    });
</script>

</body>
</html>