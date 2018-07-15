<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:40:"../tpl/index/channel_set\set_reward.html";i:1486623444;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:39:"../tpl/index/base\channel_set_menu.html";i:1484634306;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
    <title>打赏设置 - 玲珑直播</title>
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
            <form id="reward_list" method="post" action="">
                <input type="hidden" name="rid" value="<?php echo (isset($id) && ($id !== '')?$id:''); ?>"><!--当前房间ID-->
                <div class="block-com rp">
                <h4 class="title">打赏配置</h4>
                <div class="reword-config">
                    <div class="rc-line">
                        <span>打赏功能开关</span>
                        <label class="ll-switch">
                            <input id="hs-1" class="reward_switch <?php if($list['reward_switch'] == '1'): ?>reward_on<?php else: ?>reward_off<?php endif; ?>" type="checkbox" <?php if($list['reward_switch'] == '1'): ?>checked="checked"<?php endif; ?>>
                            <label for="hs-1"></label>
                        </label>
                        <span>打赏名称</span>
                        <label class="input">
                            <span></span>
                            <input placeholder="" id="share_speak" name="reward_name" value="<?php echo (isset($list['reward_data']) && ($list['reward_data'] !== '')?$list['reward_data']:''); ?>" onkeyup="count_num();"  maxlength="10">
                            <span class="count"><i id="share_num">0</i>/10</span>
                        </label>
                    </div>
                    <div class="rc-line">
                        <span>填写手机号开关</span>
                        <label class="ll-switch">
                            <input id="hs-2" class="phone_switch <?php if($list['phone_switch'] == '1'): ?>phone_on<?php else: ?>phone_off<?php endif; ?>"  type="checkbox" <?php if($list['phone_switch'] == '1'): ?>checked="checked"<?php endif; ?>>
                            <label for="hs-2"></label>
                        </label>
                        <span>手机提示语</span>
                        <label class="input">
                            <input placeholder="输入手机号才可以参与打赏哦" name="phone_prompt" value="<?php echo (isset($list['phone_data']) && ($list['phone_data'] !== '')?$list['phone_data']:''); ?>" id="phone_speak"  onkeyup="phone_num();"  maxlength="10">
                            <span class="count"><i id="phone_num">0</i>/10</span>
                        </label>
                    </div>
                </div>
                <div class="gc-block">
                    <div class="gc-menu">
                        <a class="">礼物打赏</a>
                        <a>红包打赏</a>
                        <h6 class="gift-tips">建议上传图片为180*180像素，大小不能超过100K，礼物数量上限为6个</h6>
                    </div>
                    <div  class="gc-content">
                        <div class="warp ">
                            <div class="gifts">
                            <?php if(is_array($gift_list) || $gift_list instanceof \think\Collection): $k = 0; $__LIST__ = $gift_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                <div class="item gift_box" data-id="$k">
                                    <div class="cover">
                                        <?php if(empty($vo['gift_url']) || ($vo['gift_url'] instanceof \think\Collection && $vo['gift_url']->isEmpty())): ?>
                                        <img class="preview" src="__static__/index/src/img/admin/sitives.png">
                                        <?php else: ?>
                                        <img class="preview" src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($vo['gift_url']) && ($vo['gift_url'] !== '')?$vo['gift_url']:''); ?>">
                                        <?php endif; ?>
                                        <label class="add-new">
                                            <input class="file_upload gift_img" type="file" accept="image" name="gift_img<?php echo $k; ?>"/>
                                            <i class="iconfont"></i>
                                            <span>上传图片</span>
                                        </label>
                                        <input type="hidden" class="gift_msg" name="gift_url[]" value="<?php echo (isset($vo['gift_url']) && ($vo['gift_url'] !== '')?$vo['gift_url']:''); ?>">
                                    </div>
                                    <div class="info">
                                        <div class="gc-i-line">
                                            <span class="label">礼物名称</span>
                                            <label class="input">
                                                <input placeholder="请输入礼物名称" name="gift_name[]" id="gift_name_len" onkeyup="gift_num(this);" class="gift_length" value="<?php echo (isset($vo['gift_name']) && ($vo['gift_name'] !== '')?$vo['gift_name']:''); ?>" maxlength="10">
                                                <span class="tip"><i class="gift_num"><?php echo (isset($vo['gift_len']) && ($vo['gift_len'] !== '')?$vo['gift_len']:'0'); ?></i>/10</span>
                                                <input type="hidden" class="gift_length" name="gift_len[]" value="<?php echo (isset($vo['gift_len']) && ($vo['gift_len'] !== '')?$vo['gift_len']:'0'); ?>">
                                            </label>
                                        </div>
                                        <div class="gc-i-line">
                                            <span class="label">礼物金额</span>
                                            <label class="input">
                                                <input placeholder="请输入礼物价格" name="gift_price[]" value="<?php echo (isset($vo['gift_price']) && ($vo['gift_price'] !== '')?$vo['gift_price']:''); ?>" >
                                                <span class="tip">元</span>
                                            </label>
                                        </div>
                                        <div class="control">
                                            <a class="delete">
                                                <i class="iconfont">&#xe623;</i>
                                                删除
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                <div class="item gift_list" >
                                    <div class="cover">
                                        <img  src="__static__/index/src/img/admin/sitives.png" class="preview"  />
                                        <label class="add-new">
                                            <input class="file_upload gift_img" type="file"  accept="image" name="gift_img"/>
                                            <i class="iconfont">&#xe6cb;</i>
                                            <span>上传图片</span>
                                        </label>
                                        <input type="hidden" class="gift_msg" name="gift_url[]" value="">
                                    </div>
                                    <div class="info">
                                        <div class="gc-i-line">
                                            <span class="label">礼物名称</span>
                                            <label class="input">
                                                <input placeholder="请输入礼物名称" name="gift_name[]" onkeyup="gift_num(this);" value="" maxlength="10">
                                                <span class="tip"><i class="gift_num">0</i>/10</span>
                                                <input type="hidden" class="gift_length" name="gift_len[]" value="">
                                            </label>
                                        </div>
                                        <div class="gc-i-line">
                                            <span class="label">礼物金额</span>
                                            <label class="input">
                                                <input placeholder="请输入礼物价格" name="gift_price[]" value="" >
                                                <span class="tip">元</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <a class="gift-submit">提交</a>
                            </div>
                        </div>



                        <div class="warp ">
                            <div class="gc-form">
                                <div class="gc-line">
                                    <span class="label">红包描述</span>
                                    <label class="input">
                                        <input placeholder="" onkeyup="red_warde_num();" id="red_reward" maxlength="20" value="<?php echo (isset($red['red_des']) && ($red['red_des'] !== '')?$red['red_des']:''); ?>">
                                        <span class="tip"><i id="red_length">0</i>/20</span>
                                    </label>
                                    <span class="info">*请输入你想要的红包描述</span>
                                </div>
                                <div class="gc-line">
                                    <span class="label">红包金额</span>
                                    <label class="input">
                                        <input placeholder="" id="red_price" value="<?php echo (isset($red['coin']) && ($red['coin'] !== '')?$red['coin']:''); ?>">
                                        <span class="tip">元</span>
                                    </label>
                                </div>
                                <div class="gc-line">
                                    <span class="label">红包个数</span>
                                    <label class="input">
                                        <input placeholder="" id="red_num" value="<?php echo (isset($red['num']) && ($red['num'] !== '')?$red['num']:''); ?>">
                                        <span class="tip">个</span>
                                    </label>
                                </div>
                                <div class="gc-line">
                                    <span class="label">红包分配规则</span>
                                    <label class="radio">
                                        <input type="radio" name="rule"  value="1" <?php if($red['type'] == '1'): ?>checked="checked"<?php endif; ?>>
                                        <span class="radio-main"></span>
                                        <span class="radio-text">随机分配</span>
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="rule" value="2" <?php if($red['type'] == '2'): ?>checked="checked"<?php endif; ?>>
                                        <span class="radio-main"></span>
                                        <span class="radio-text">平均分配</span>
                                    </label>
                                </div>
                                <div class="gc-line">
                                    <span class="label">&nbsp;</span>
                                    <?php if($red['status'] == '1'): ?>
                                    <a class="submit">提交</a>
                                    <?php endif; if(empty($red) || ($red instanceof \think\Collection && $red->isEmpty())): ?>
                                    <a class="submit">提交</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal-gift">
    <div class="modal-main">
        <span class="top"></span>
        <p>你上传的照片不是建议尺寸，有可能会导致封面图不美观,建议您按照建议尺寸上传，效果更好哦～</p>
        <a>我知道了</a>
    </div>
</div>
<input type="hidden" id="reward_id" value="<?php echo $id; ?>"><!--当前房间ID-->
<input type="hidden" id="all_switch" value="<?php echo url('index/channel_set/all_switch'); ?>"><!--功能开关-->
<input type="hidden" id="gift_art" value="<?php echo url('index/channel_set/gift_art'); ?>"><!--礼物打赏提交-->
<input type="hidden" id="gift_img_url" value="<?php echo url('index/channel_set/gift_img'); ?>"><!--礼物打赏上传-->
<input type="hidden" id="length" value="<?php echo (isset($length) && ($length !== '')?$length:'0'); ?>"><!--礼物数量-->
<input type="hidden" id="gift_red_reward" value="<?php echo url('index/channel_set/red_reward'); ?>"><!--红包打赏上传-->

<script>
    $(function(){
        var gif_length = $("#length").val();
        if(gif_length == 6){
            $(".gift_list").remove();
        }
    });
    $(function(){
        var num = $("#share_speak").val();
        $("#share_num").html(num.length);
    });
    $(function(){
        var num = $("#phone_speak").val();
        $("#phone_num").html(num.length);
    });
    $(function(){
        var num = $("#red_reward").val();
        $("#red_length").html(num.length);
    });
</script>
<script>
    function count_num(){
        var num = $("#share_speak").val();
        $("#share_num").html(num.length);
    }
    function phone_num(){
        var num = $("#phone_speak").val();
        $("#phone_num").html(num.length);
    }
    function gift_num(btn){
        var data = $(btn).val();
        $(btn).next().children(".gift_num").html(data.length);
        $(btn).siblings('.gift_length').val(data.length);
    }
   function red_warde_num(){
       var num = $("#red_reward").val();
       $("#red_length").html(num.length);
   }
</script>

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
<script type="text/javascript" src="__static__/index/src/js/admin/live_reward.js"></script>
<script type="text/javascript" src="__static__/index/js/admin/channel_set.js"></script>

</body>
</html>