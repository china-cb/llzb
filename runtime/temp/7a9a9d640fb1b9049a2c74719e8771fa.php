<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:38:"../tpl/index/channel_set\set_look.html";i:1486617547;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:39:"../tpl/index/base\channel_set_menu.html";i:1484634306;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin_live.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>观看设置 - 玲珑直播</title>
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
<div class="statistics">
<div class="main admin ">
    <div class="container">
        <!-- inject:live_menu:html -->
        <ul class="menu">
    <li class="menu-item">
        <h4 class="mi-text">
            <i class="iconfont">&#xe6c2;</i>
            基础设置
        </h4>
        <div class="item-group">
            <a class="ig-item" id="set_guide_map" href="<?php echo url('index/channel_set/set_guide_map',['id'=> $id]); ?>">
                <i class="iconfont">&#xe737;</i>
                直播引导图
            </a>

            <a class="ig-item" id="set_window_background" href="<?php echo url('index/channel_set/set_window_background',['id'=> $id]); ?>">
                <i class="iconfont">&#xe61e;</i>
                直播窗口背景
            </a>
            <a class="ig-item" id="set_video_logo" href="<?php echo url('index/channel_set/set_video_logo',['id'=> $id]); ?>">
                <i class="font">Logo</i>
                视频LOGO
            </a>
            <a class="ig-item" id="set_video_icon" href="<?php echo url('index/channel_set/set_video_icon',['id'=> $id]); ?>">
                <i class="iconfont">&#xe62e;</i>
                视频图标
            </a>
        </div>
    </li>
    <li class="menu-item">
        <h4 class="mi-text">
            <i class="iconfont">&#xe60c;</i>
            互动打赏
        </h4>
        <div class="item-group">
            <a class="ig-item" id="set_reward" href="<?php echo url('index/channel_set/set_reward',['id'=> $id]); ?>">
                <i class="iconfont">&#xe625;</i>
                打赏设置
            </a>
            <a class="ig-item" id="gift_reward_record" href="<?php echo url('index/channel_set/gift_reward_record',['id'=> $id]); ?>">
                <i class="iconfont">&#xe61b;</i>
                礼物打赏记录
            </a>
            <a class="ig-item" id="red_reward_record" href="<?php echo url('index/channel_set/red_reward_record',['id'=> $id]); ?>">
                <i class="iconfont">&#xe600;</i>
                红包打赏记录
            </a>
        </div>
    </li>
    <li class="menu-item">
        <a class="mi-text ig-item" id="set_look" href="<?php echo url('index/channel_set/set_look',['id'=> $id]); ?>">
            <i class="iconfont">&#xe605;</i>
            观看设置
        </a>
    </li>
    <li class="menu-item">
        <h4 class="mi-text">
            <i class="iconfont">&#xe654;</i>
            分享及嵌入
        </h4>
        <div class="item-group">
            <a class="ig-item"  id="set_weixin_share" href="<?php echo url('index/channel_set/set_weixin_share',['id'=> $id]); ?>">
                <i class="iconfont">&#xe60a;</i>
                微信分享设置
            </a>
            <a class="ig-item"  id="set_embed_address">
                <i class="iconfont">&#xe60d;</i>
                嵌入地址
            </a>
        </div>
    </li>
    <li class="menu-item">
        <a class="mi-text"  id="video_back_play" href="<?php echo url('index/channel_set/video_back_play',['id'=> $id]); ?>">
            <i class="iconfont">&#xe61c;</i>
            视频回放
        </a>
    </li>
</ul>
<input type="hidden" id="type_html" value="<?php echo (isset($type) && ($type !== '')?$type:''); ?>">
        <!-- endinject -->   
        <div class="content">
            <div class="block">
                <h1 class="basic_h1">
                    <span class="basic_h1_left">观看设置</span>
                </h1>
                <div class="guide">
                    <div class="guide_title guide_title2s">
                        付费观看：
                        <span class="on_off secret_val <?php if($list['type'] == '2'): ?>secret_off<?php else: ?>secret_on<?php endif; ?>">
                            <i class="<?php if($list['type'] == '2'): else: ?>off_act<?php endif; ?>"></i>
                        </span>
                        <div class="preview_none preview_none2">
                            <p class="sum_of_money">
                                <input type="text/css" name="" value="" placeholder="请输入观看金额" class="moneys">
                                <span class="money_ps2s">*请设置粉丝观看该直播时的付费金额</span>
                            </p>
                            <input type="submit" name="" value="修改" class="preview_sub preview_sub4">
                        </div>

                        <div class="preview_block preview_block2">
                            <p class="sum_of_money">
                                <span class="money_ps1"><i class="iconfont">&#xe644;</i><span class="moneys"><?php echo (isset($list['unit_price']) && ($list['unit_price'] !== '')?$list['unit_price']:'0'); ?></span></span>
                            </p>
                            <input type="submit" name="" value="修改" class="preview_sub preview_sub4">
                            
                        </div>

                        <div class="guide_layer secret_key guide_layer_e <?php if($list['type'] == '2'): else: ?>guide_layer_dis<?php endif; ?>"></div>
                    </div>
                    <!-- 密码15位 -->
                    <div class="guide_title guide_title2s">
                        私密观看：
                        <span class="on_off unit_val <?php if($list['type'] == '1'): ?>unit_off<?php else: ?>unit_on<?php endif; ?>">
                            <i class="<?php if($list['type'] == '1'): else: ?>off_act<?php endif; ?>"></i>
                        </span>

                        <div class="preview_none preview_none1">
                            <p class="sum_of_money">
                                <input type="text/css" name="" value="" placeholder="请输入观看密码" class="pawds1">
                                <span class="money_ps2s">*成功设置密码后，粉丝进入房间需输入密码。密码框清空，观看密码取消</span>
                            </p>
                            <input type="submit" name="" value="保存" class="preview_sub preview_sub4 preserve_submit2">
                        </div>
                        <div class="preview_block preview_block1">
                            <p class="sum_of_money">
                                <span class="money_ps1">
                                    <span class="money_ps1_line1">
                                        <span class="shows"><?php if(empty($list['secret_key']) || ($list['secret_key'] instanceof \think\Collection && $list['secret_key']->isEmpty())): else: ?>******<?php endif; ?></span>
                                        <span class="disappears shows dislpays pwds"><?php echo (isset($list['secret_key']) && ($list['secret_key'] !== '')?$list['secret_key']:''); ?></span>
                                    </span>
                                    <i class="iconfont eyes">&#xe63a;</i>
                                    <i class="iconfont line_ico shows">&#xe63d;</i>
                                </span>
                            </p>
                            <input type="submit" name="" value="修改" class="preview_sub preview_sub4 preserve_submit">
                        </div>
                        <div class="guide_layer guide_layer_e unit_key <?php if($list['type'] == '1'): else: ?>guide_layer_dis<?php endif; ?>"></div>
                    </div>
                    
                </div>
            </div>

        </div>
</div>
    </div>
</div>
<input type="hidden" id="record_id" value="<?php echo $id; ?>"><!--当前房间ID-->
<input type="hidden" id="unit_price_url" value="<?php echo url('index/channel_set/record_unit_price'); ?>"><!--设置付费直播金额-->
<input type="hidden" id="secret_key_url" value="<?php echo url('index/channel_set/record_secret_key'); ?>"><!--设置私密直播金额-->
<input type="hidden" id="all_switch" value="<?php echo url('index/channel_set/all_switch'); ?>"><!--功能开关-->


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
<script type="text/javascript" src="__static__/index/src/js/admin/control_inner.js"></script>
<script type="text/javascript" src="__static__/index/js/admin/channel_set.js"></script>

</body>
</html>