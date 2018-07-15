<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:37:"../tpl/index/user_center\account.html";i:1486610862;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
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
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin_account.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/mCustomScrollbar.css" />

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


<!-- inject:admin_header:html -->
<!-- endinject -->
<div class="main admin">
    <div class="container">
        <!-- inject:account_menu:html -->
        <ul class="menu">
            <li class="menu-item account">
                <h4 class="mi-text">
                    <i class="iconfont">&#xe615;</i>
                    账户信息
                </h4>
                <ul class="item-group">
                    <li class="ig-item">
                        <i class="iconfont">&#xe737;</i>
                        修改手机号
                    </li>
                    <li class="ig-item">
                        <i class="iconfont">&#xe62f;</i>
                        修改邮箱
                    </li>
                    <li class="ig-item">
                        <i class="iconfont">&#xe62c;</i>
                        修改密码
                    </li>
                    <li class="ig-item">
                        <i class="iconfont">&#xe61d;</i>
                        实名认证
                        <?php if($list['state'] == '1'): ?>
                        <span class="auth ing">审核中</span>
                        <?php endif; ?>
                    </li>
                </ul>
            </li>
            <li class="menu-item bill" data-val="1">
                <a class="mi-text">
                    <i class="iconfont">&#xe729;</i>
                    我的套餐
                </a>
            </li>
            <li class="menu-item balance">
                <a class="mi-text">
                    <i class="iconfont">&#xe610;</i>
                    余额充值
                </a>
            </li>
            <li class="menu-item recharge" data-val="3">
                <a class="mi-text">
                    <i class="iconfont">&#xe656;</i>
                    充值订单
                </a>
            </li>
        </ul>
        <!-- endinject -->
        <div class="content account-msg content_act">
            <div class="block block1s block_act">
                <h1 class="basic_h1">
                    <span class="basic_h1_left">基本信息</span>
                    <span class="reg_time">注册时间<span><?php echo date("Y-m-d",$list['create_time']); ?></span></span>
                    <a class="modify modify-msg modify_act">修改信息</a>
                    <!-- 修改激活 -->
                    <a class="modify save-msg">保存</a>
                </h1>
                <form action=""  method="get" id="chang_price">
                <section class="basic_content">
                    <label class="add_head_img">
                        <?php if(empty($list['user_face']) || ($list['user_face'] instanceof \think\Collection && $list['user_face']->isEmpty())): ?>
                            <img class="preview head_img" src="__static__/index/src/img/temp/user_ava.png">
                        <?php else: ?>
                            <img class="preview head_img" src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($list['user_face']) && ($list['user_face'] !== '')?$list['user_face']:''); ?>">
                        <?php endif; ?>
                        <input class="file_upload" type="file" id="user_face" accept="image" name="gift_img"/>
                        <i>上传头像</i>
                    </label>
                    <ul class="basic_info basic-modify basic_info_act" >
                        <li>
                            <span>账号昵称</span>
                            <span><?php echo (isset($list['nick_name']) && ($list['nick_name'] !== '')?$list['nick_name']:"0"); ?></span>
                        </li>
                        <li>
                            <span>行业</span>
                            <span><?php echo (isset($list['vocation']) && ($list['vocation'] !== '')?$list['vocation']:"暂无信息"); ?></span>
                        </li>
                        <li>
                            <span>企业名称</span>
                            <span><?php echo (isset($list['enterprise_name']) && ($list['enterprise_name'] !== '')?$list['enterprise_name']:"暂无信息"); ?></span>
                        </li>
                        <li>
                            <span>手机号</span>
                            <span><?php echo (isset($list['phone']) && ($list['phone'] !== '')?$list['phone']:"0"); ?></span>
                        </li>
                        <li>
                            <span>邮箱</span>
                            <?php if(empty($list['email']) || ($list['email'] instanceof \think\Collection && $list['email']->isEmpty())): ?>
                              <span>
                                 <span class="not_bound">未绑定</span>
                                 绑定邮箱用于用户找回密码
                                <a class="go_bound go_email">去绑定</a>
                             </span>
                            <?php else: ?>
                            <span><?php echo (isset($list['email']) && ($list['email'] !== '')?$list['email']:"0"); ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                    <!-- 修改激活 -->
                    <ul class="basic_info basic-save">
                        <li>
                            <span>账号昵称</span>
                            <input type="" name="nickname" class="industry" value="<?php echo (isset($list['nick_name']) && ($list['nick_name'] !== '')?$list['nick_name']:''); ?>">
                        </li>
                        <li>
                            <span>行业</span>
                             <span class="industry industrys">
                                <span class="industry_inner"><?php echo (isset($list['vocation']) && ($list['vocation'] !== '')?$list['vocation']:""); ?></span>
                                <span class="triangle_up"></span>
                             </span>
                            <ul class="industry_ul">
                                <li class="vocation">机构组织</li>
                                <li class="vocation">农林牧渔</li>
                                <li class="vocation">医药卫生</li>
                                <li class="vocation">建筑建材</li>
                                <li class="vocation">石油化工</li>
                                <li class="vocation">水利水电</li>
                                <li class="vocation">交通运输</li>
                                <li class="vocation">信息产业</li>
                                <li class="vocation">机械机电</li>
                                <li class="vocation">轻工食品</li>
                                <li class="vocation">服装纺织</li>
                                <li class="vocation">专业服饰</li>
                                <li class="vocation">安全防护</li>
                                <li class="vocation">环保绿化</li>
                                <li class="vocation">旅游休闲</li>
                                <li class="vocation">办公文教</li>
                                <li class="vocation">电子电工</li>
                                <li class="vocation">玩具礼品</li>
                                <li class="vocation">家居用品</li>
                                <li class="vocation">其它类型</li>
                            </ul>
                        </li>
                        <li>
                            <span>企业名称</span>
                            <input type="" name="industry" class="industry" value="<?php echo (isset($list['enterprise_name']) && ($list['enterprise_name'] !== '')?$list['enterprise_name']:''); ?>">
                        </li>
                        <li>
                            <span>手机号</span>
                            <span class="x_modify">
                                <?php echo (isset($list['phone']) && ($list['phone'] !== '')?$list['phone']:"/(ㄒoㄒ)/~~"); ?>
                                <a  class="go_bound go_phone_up">修改</a>
                            </span>
                        </li>
                        <li>
                            <span>邮箱</span>
                            <span class="x_modify">
                                 <?php echo (isset($list['email']) && ($list['email'] !== '')?$list['email']:"0"); ?>
                                 <a  class="go_bound go_email_up">修改</a>
                            </span>
                        </li>
                    </ul>
                </section>
                </form>
                <h1 class="basic_h1">
                    <span class="basic_h1_left">安全信息</span>
                </h1>
                <ul class="security">
                    <li>
                        <span class="security_ico">
                            <i class="iconfont">&#xe655;</i>
                            <?php switch($list['state']): case "0": ?> <i class="i_img"></i><?php break; case "1": ?> <i class="i_img"></i><?php break; case "2": ?> <i class="i_img i_img_ok"></i><?php break; case "-1": ?><i class="i_img"></i><?php break; default: ?><i class="i_img"></i>
                            <?php endswitch; ?>
                        </span>
                        <span class="real_1">实名认证</span>
                        <!-- real_2_no 未认证 -->
                        <span class="real_2
                            <?php if($list['state'] == '2'): ?>
                                  real_2_no
                            <?php endif; ?>
                        ">
                            <?php switch($list['state']): case "0": ?>未认证<?php break; case "1": ?>待审核<?php break; case "2": ?>已认证<?php break; case "-1": ?>认证失败<?php break; default: ?>未认证
                            <?php endswitch; ?>
                        </span>
                        <span class="real_3">
                            <?php switch($list['state']): case "0": ?>您还没有进行实名认证，为保障您的权益最大化，请进行实名认证<?php break; case "1": ?>您的实名认证已经在审核中，请耐心等待...<?php break; case "2": ?>恭喜您,您的实名认证已通过啦 !<?php break; case "-1": ?>您的认证因某些原因导致失败，核实后再次提交认证。。<?php break; default: ?>您还没有进行实名认证，为保障您的权益最大化，请进行实名认证。
                            <?php endswitch; ?>
                        </span>
                        <?php switch($list['state']): case "0": ?><a  class="go_real go_audit">去认证</a><?php break; case "1": ?><a  class="go_real">待审核</a><?php break; case "2": ?><a  class="go_real">已认证</a><?php break; case "-1": ?><a  class="go_real go_audit">去认证</a><?php break; default: ?><a  class="go_real go_audit">去认证</a>
                        <?php endswitch; ?>
                    </li>
                    <li>
                        <span class="security_ico">
                            <i class="iconfont">&#xe622;</i>
                            <!-- 等级高 i_img3 -->
                            <!-- 等级中 i_img2 -->
                            <!-- 等级低 i_img0 -->
                            <?php switch($list['pwd_grade']): case "弱": ?><i class="i_img i_img0"></i><?php break; case "中": ?><i class="i_img i_img2"></i><?php break; case "强": ?><i class="i_img i_img3"></i><?php break; default: ?>default
                            <?php endswitch; ?>
                        </span>
                        <span class="real_1">登录密码</span>
                            <!-- 等级高 psd_1_2 -->
                            <!-- 等级中 psd_1_1 -->
                            <!-- 等级低 psd_1_0 -->
                        <span class="real_2
                         <?php switch($list['pwd_grade']): case "弱": ?>psd_1_0<?php break; case "中": ?>psd_1_1<?php break; case "强": ?>psd_1_2<?php break; default: ?>暂无密码
                         <?php endswitch; ?>
                        ">安全等级：<?php echo (isset($list['pwd_grade']) && ($list['pwd_grade'] !== '')?$list['pwd_grade']:''); ?></span>
                        <span class="real_3 real_3s">安全性高的密码可以使账户更安全，建议您定期修改密码。</span>
                        <a  class="go_real go_modify">修改密码</a>
                    </li>
                </ul>
            </div>
            <div class="contents">
                <!-- 修改手机号码 -->
                <!-- 验证码填写有误 .password_no_act -->
                <div class="block block2s go_phone_list">
                    <h1 class="basic_h1">
                        <span class="basic_h1_left">更换安全手机号</span>
                        <a href="" class="other_verification">选择其他验证方式</a>
                    </h1>
                    <div class="login_reg" style="display: block;">
                        <h1 class="sent_to">验证码将发送到手机<?php echo (isset($user_phone) && ($user_phone !== '')?$user_phone:''); ?></h1 >
                        <form id="change-phone"  method="post">
                            <label class="login_reg_lable">
                                <input type="hidden" name="phone_Verify" value="<?php echo (isset($list['phone']) && ($list['phone'] !== '')?$list['phone']:''); ?>">
                                <input type="hidden" name="phone_Verify_type" value="modify_phone">

                                <input type="text" name="phone_Verify_code" placeholder="请输入验证码" class="login_reg_inpit1"/>
                                <input type="button"  value="发送验证码"  class="login_reg_free get_phone_Verify verify_phone"/>
                            </label>
                            <label class="login_reg_lable">
                                <input type="text" data-id="<?php echo $list['phone']; ?>" name="phone_change"  placeholder="请输入手机号" class="login_reg_inpit1" />
                                <input type="hidden" name="phone_change_type" value="other">
                            </label>
                            <label class="login_reg_lable">
                                <input type="text" name="phone_change_code"  placeholder="请输入验证码" class="login_reg_inpit1"/>
                                <input type="button" id="btn" value="发送验证码"  class="login_reg_free get_phone_change change_phone"/>
                            </label>
                            <label class="login_reg_lable">
                                <input type="button" id="Submit-change-phone" class="login_reg_inpit3" value="下一步" />
                            </label>
                            <div type="hidden" style="display: none;" id="error_message" class="password_no password_no_act">验证码填写有误！</div>
                        </form>
                    </div>
                    <h2 class="prompts">温馨提示：安全手机是找回密码的凭证，登录时请使用注册时填写的手机号</h2>
                    <!-- 验证码成功之后 -->
                    <div class="succes_mb phone_pwd" style="display: none;">
                        <span class="succes_mb_img"></span>
                        <h1 class="prompt2s">绑定安全手机号才做成功，<span id="phone_down">5s</span>后自动返回账户信息</h1>
                        <a href="<?php echo url('index/user_center/account','type=1'); ?>">返回账户信息</a>
                    </div>
                </div>
                <!-- 修改邮箱  绑定邮箱-->
                <div class="block block2s go_email_list">
                    <?php if(empty($list['email']) || ($list['email'] instanceof \think\Collection && $list['email']->isEmpty())): ?>
                         <h1 class="basic_h1">
                            <span class="basic_h1_left">绑定邮箱</span>
                        </h1>
                        <div class="login_reg" style="display: block;">
                            <form action="" id="bind-user-email" method="get">
                                <label class="login_reg_lable">
                                    <input type="text" name="bind_user_email" placeholder="请输入绑定邮箱" value="" class="login_reg_inpit1" />
                                </label>
                                <label class="login_reg_lable">
                                    <input type="button" id="bind-email" class="login_reg_inpit3" value="确认绑定" />
                                </label>
                                <div style="display: none;" id="error_email_img" class="password_no password_no_act">验邮箱格式有误！</div>
                            </form>
                        </div>
                    <?php else: ?>
                        <h1 class="basic_h1">
                            <span class="basic_h1_left">更换邮箱</span>
                        </h1>
                        <div class="login_reg" style="display: block;">
                            <h1 class="sent_to">验证码将发送到手机<?php echo (isset($user_phone) && ($user_phone !== '')?$user_phone:''); ?></h1 >
                            <form action="" id="change-user-email" method="get">
                                <label class="login_reg_lable">
                                    <input type="hidden" name="change_email" value="<?php echo (isset($list['phone']) && ($list['phone'] !== '')?$list['phone']:''); ?>">
                                    <input type="hidden" name="phone_email_type" value="modify_email">
                                    <input type="text" name="change_email_code" placeholder="请输入验证码" class="login_reg_inpit1"/>
                                    <input type="button" id="btn" value="发送验证码" class="login_reg_free change_email change-email-code"/>
                                </label>
                                <label class="login_reg_lable">
                                    <input type="text" name="change_user_email" placeholder="请输入邮箱" class="login_reg_inpit1" />
                                </label>
                                <label class="login_reg_lable">
                                    <input type="button" id="change-email" class="login_reg_inpit3" value="下一步" />
                                </label>
                                <div style="display: none;" id="error_email_message" class="password_no password_no_act">验证码填写有误！</div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <!-- 修改邮箱成功后 -->
                    <div class="email_succes" style="display: none;">
                         <span class="email_succes_img"></span>
                         <p class="email_succes_p1">邮件发送成功</p>
                         <p class="email_succes_p1">绑定密保邮箱已经成功发送到<p id="user-email">2234590989@qq.com</p>邮箱，请在6小时内登录邮箱点击链接完成操作</p>
                         <ul class="email_list">
                             <li>没有收到邮件怎么办？</li>
                             <li class="email_list2">尝试在广告邮件、垃圾邮件目录下查找</li>
                             <li><a id="email_form">重新发送</a>邮件</li>
                             <li><a id="email_jump" href="" target="_blank">立即跳往</a></li>
                         </ul>
                     </div>
                </div>
                <!-- 修改密码 -->
                <div class="block block2s go_modify_list">
                    <h1 class="basic_h1">
                        <span class="basic_h1_left">更换密码</span>
                    </h1>
                    <div class="login_reg">
                        <h1 class="sent_to">验证码将发送到手机<?php echo (isset($user_phone) && ($user_phone !== '')?$user_phone:''); ?></h1 >
                        <form id="change_user_pwd" action="" method="get">
                            <label class="login_reg_lable">
                                <input type="hidden" name="user_phone_pwd" value="<?php echo (isset($list['phone']) && ($list['phone'] !== '')?$list['phone']:''); ?>">
                                <input type="hidden" name="phone_pwd_type" value="modify_pwd">
                                <input type="text" name="phone_pwd_code" placeholder="请输入验证码" class="login_reg_inpit1"/>
                                <input type="button" id="btn" value="发送验证码"  class="login_reg_free change_pwd change_user_pwd"/>
                            </label>
                            <label class="login_reg_lable">
                                <input type="password" name="new_password" placeholder="6～16位密码" class="login_reg_inpit2" />
                                <span class="login_reg_span1">设置密码</span>
                            </label>
                            <label class="login_reg_lable">
                                <input type="password" name="re_password" placeholder="6～16位密码" class="login_reg_inpit2"/>
                                <span class="login_reg_span1">确认密码</span>
                            </label>
                            <label class="login_reg_lable">
                                <input type="button" id="change-pwd" name="" class="login_reg_inpit3" value="下一步" />
                            </label>
                            <div style="display: none;" id="error_pwd_message" class="password_no password_no_act">验证码填写有误！</div>
                        </form>
                    </div>
                    <!-- 修改密码 -->
                    <div class="succes_mb modify_pwd" style="display: none;">
                         <span class="pwd_mb_img"></span>
                         <h1 class="prompt2s">更换密码操作成功，<span id="modify_down">5s</span>后自动返回账户信息</h1>
                         <a href="<?php echo url('index/user_center/account','type=1'); ?>">返回账户信息</a>
                     </div>
                </div>
                <!-- 实名认证 -->
                <div class="block block2s audit">
                    <h1 class="basic_h1">
                        <span class="basic_h1_left">实名认证</span>
                        <a class="other_ver2">＊实名认证填写真实有效的信息</a>
                    </h1>
                        <div class="select_type">
                            <h1>选择类型</h1>
                            <div class="login_agreement">
                                <label for="types">个人</label>
                                <input name="radios" type="radio"  value="1" id="types"  <?php if(empty($user_audit['type']) OR $user_audit['type'] == 1): ?>checked<?php endif; ?>/>
                                <i></i>
                                <p class="login_checkeds"></p>
                            </div>
                            <div class="login_agreement">
                                <label for="types2">企业</label>
                                <input name="radios" type="radio" value="2" id="types2" <?php if($user_audit['type'] == '2'): ?>  checked<?php endif; ?>/>
                                <i></i>
                                <p class="login_checkeds"></p>
                            </div>
                        </div>
                            <div class="company_ajx">
   
                            </div>
                        <!-- 审核中显示遮罩层 -->
                        <div class="types_ad">111111</div>
                </div>
            </div>
        </div>
        <div class="content bill-msg">
            <div class="block block_act">
                <h1 class="basic_h1">
                    <span class="basic_h1_left">套餐详情</span>
                </h1>

                <div class="statistics">
                    <?php if(empty($info['balance']) || ($info['balance'] instanceof \think\Collection && $info['balance']->isEmpty())): ?>
                         <span class="no_buy"><i></i>无数据</span>
                    <?php else: ?>
                        <ul>
                            <li><?php echo (isset($info['type']) && ($info['type'] !== '')?$info['type']:''); ?></li>
                            <li>剩余时长<span><?php echo (isset($info['balance']) && ($info['balance'] !== '')?$info['balance']:''); ?></span>分钟</li>
                            <li><?php echo date("Y-m-d H:i:s",$info['expire_time']); ?></li>
                        </ul>
                    <?php endif; if(!(empty($rt) || ($rt instanceof \think\Collection && $rt->isEmpty()))): ?>
                    <ul>
                        <li><?php echo (isset($rt['type']) && ($rt['type'] !== '')?$rt['type']:''); ?></li>
                        <li>剩余时长<span><?php echo (isset($rt['balance']) && ($rt['balance'] !== '')?$rt['balance']:''); ?></span>分钟</li>
                        <?php if(!(empty($rt['expire_time']) || ($rt['expire_time'] instanceof \think\Collection && $rt['expire_time']->isEmpty()))): ?>
                        <li><?php echo date("Y-m-d H:i:s",$rt['expire_time']); ?></li>
                        <?php endif; ?>
                        <li class="not_used">未使用</li>
                    </ul>
                    <?php endif; ?>
        
                </div>

                <div style="clear: both;"></div>
                 <h1 class="basic_h1">
                    <span class="basic_h1_left">时长记录</span>
                </h1>
                <ul class="years_days">
                    <li>时间范围</li>
                    <li>
                        <span class="li_text li_text1">
                            <span class="li_texts li_text1s">开始日期</span><i class="icon icon1"></i>
                        </span>
                        <ul class="years_list years_list1">
                            <li class="years_li"><span class="years_li_list">2017</span>年</li>
                            <li class="years_li"><span class="years_li_list">2016</span>年</li>
                            <li class="years_li"><span class="years_li_list">2015</span>年</li>
                            <li class="years_li"><span class="years_li_list">2014</span>年</li>
                        </ul>
                    </li>
                    <li>至</li>
                    <li>
                        <span class="li_text li_text2">
                            <span class="li_texts li_text2s">结束日期</span><i class="icon icon2"></i>
                        </span>
                        <ul class="years_list years_list2">
                            <li class="years_li2"><span class="years_li2_list">1</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">2</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">3</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">4</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">5</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">6</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">7</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">8</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">9</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">10</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">11</span>月</li>
                            <li class="years_li2"><span class="years_li2_list">12</span>月</li>
                        </ul>
                    </li>
                    <li id="bill_msg">查&nbsp;询</li>
                </ul>
                <div class="records">
                    <a id="bill_increase" data-bill="1" class="active">时长增加记录</a>
                    <a id="bill_reduce" data-bill="2">时长减少记录</a>
                </div>
                <ul class="statis_list">
                    <li><i class="iconfont">&#xe661;</i>订单号</li>
                    <li class="adds_or_reduces"><i class="iconfont adds_ico">&#xe649;</i>增加时长（分钟）</li>
                    <!-- <li><i class="iconfont">&#xe65e;</i>减少时长（分钟）</li> -->
                    <li><i class="iconfont">&#xe64b;</i>剩余时长（分钟）</li>
                    <li><i class="iconfont">&#xe64d;</i>操作时间</li>
                </ul>
                <!-- 无数据 -->
                <!-- <div class="statis_list_no">
                    <span></span>
                    无数据
                </div> -->
                <!-- 有数据 -->
                <div style="clear: both"></div>
                <div class="cost_order">
                    <?php if(empty($user_order) || ($user_order instanceof \think\Collection && $user_order->isEmpty())): ?>
                    <div class="statis_list_no">
                        <span></span>
                        无数据
                    </div>
                    <?php else: if(is_array($user_order) || $user_order instanceof \think\Collection): $i = 0; $__LIST__ = $user_order;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <ul class="statis_ul">
                        <li><?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?></li>
                        <!--<li><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:''); ?></li>-->
                        <li><?php echo (isset($vo['package_all']) && ($vo['package_all'] !== '')?$vo['package_all']:''); ?>分钟</li>
                        <li><?php echo (isset($vo['balance']) && ($vo['balance'] !== '')?$vo['balance']:''); ?>分钟</li>
                        <li><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?>分钟</li>
                        <!--  ￥{}
                         $vo.cost_money|default='' -->
                    </ul>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div>
                        <?php echo (isset($page) && ($page !== '')?$page:''); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="content balance-msg">
            <form  method="post" id="order_form" target="_blank">
            <div class="block block_act">
                <h1 class="basic_h1">
                    <span class="basic_h1_left">余额充值</span>
                </h1>
                <div class="balance">
                    <span>账户余额</span>
                    <span><?php echo (isset($list['balance']) && ($list['balance'] !== '')?$list['balance']:''); ?></span>
                </div>
                <div class="balance">
                    <span>充值金额</span>
                    <ul class="amount_money">
                        <li class="labels money" data-val="10000" >1万元</li>
                        <li class="labels money" data-val="20000" >2万元</li>
                        <li class="labels money" data-val="30000" >3万元</li>
                        <li class="labels money" data-val="50000" >5万元</li>
                        <label  class="labels">
                            <input type="text" id="balance" value="" placeholder="其他金额" />
                            元
                        </label>
                    </ul>
                </div>
                <div class="balance">
                    <span>账户余额</span>
                    <div class="login_agreement">
                        <label for="types1s"><i class="iconfont zfb">&#xe60f;</i>支付宝</label>
                        <input name="radios" type="radio" class="pay" data-type="1" id="types1s"/>
                        <i></i>
                        <p class="login_checkeds"></p>
                    </div>
                    <div class="login_agreement">
                        <label for="types2s"><i class="iconfont wx">&#xe639;</i>微信</label>
                        <input name="radios" type="radio" class="pay" data-type="2" id="types2s" />
                        <i></i>
                        <p class="login_checkeds"></p>
                    </div>
                </div>
                <a class="at_recharges" data-url="<?php echo url('core/business/order'); ?>">立即充值</a>
                <div style="clear: both"></div>
                <div class="point_out">
                    <h1>温馨提示</h1>
                    <ul>
                        <li>1.支持支付宝，微信方式充值</li>
                        <li>2.充值成功的金额不支持提现</li>
                        <li>3.若充值未到账或有其他疑问请致电客户热线：0516-83994999</li>
                    </ul>
                </div>
            </div>
            </form>
        </div>
        <div class="content recharge-msg">
            <div class="block block_act ">
                <h1 class="basic_h1">
                    <span class="basic_h1_left">充值订单</span>
                </h1>
                <ul class="date_choice">
                    <i class="icon_date1"></i>
                    <i class="icon_date1"></i>
                    <li class="laydate-icon" id="start">开始日期</li>
                    <li class="laydate-icon" id="end">结束日期</li>
                    <span class=block1s"date_span1"></span>
                    <!-- <span class="date_span1 date_span1_act"></span> -->
                </ul>
                <ul class="statis_list statis_list2">
                    <li><i class="iconfont">&#xe661;</i>流水单号</li>
                    <li><i class="iconfont">&#xe61a;</i>充值时间</li>
                    <li><i class="iconfont">&#xe618;</i>金额（元）</li>
                    <li><i class="iconfont">&#xe643;</i>状态</li>
                    <li><i class="iconfont">&#xe62d;</i>支付方式</li>
                    <li><i class="iconfont">&#xe6e8;</i>立即支付</li>
                </ul>
                <div class="rechage">
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="item_type" value="<?php echo (isset($type) && ($type !== '')?$type:''); ?>">
<input type="hidden" id="vocation_val" value="<?php echo (isset($list['vocation']) && ($list['vocation'] !== '')?$list['vocation']:''); ?>"><!--基本信息修改写入行业-->
<input type="hidden" id="industry" value=""><!--实名认证写入行业-->
<input type="hidden" id="province" value=""><!--实名认证写入地区省-->
<input type="hidden" id="city" value=""><!--实名认证写入地区市-->
<input type="hidden" id="balance_all" value=""><!--余额充值写入金额-->
<input type="hidden" id="pay_type" value=""><!--支付方式写入-->
<input type="hidden" id="start_date" value=""><!--充值订单开始日期写入-->
<input type="hidden" id="end_date" value=""><!--充值订单結束日期写入-->
<input type="hidden" id="recharge_ajx" value="<?php echo url('index/user_center/recharge_ajx'); ?>"><!--时间筛选充值订单-->
<input type="hidden" id="company_ajx" value="<?php echo url('index/user_center/company_ajx'); ?>"><!--获取实名认证企业页面-->
<input type="hidden" id="person_ajx" value="<?php echo url('index/user_center/person_ajx'); ?>"><!--获取实名认证企业页面-->
<input type="hidden" id="user_order_ajx" value="<?php echo url('index/user_center/order_ajx'); ?>"><!--时间筛选账单详情减少-->
<input type="hidden" id="bill_increase_ajx" value="<?php echo url('index/user_center/bill_increase_ajx'); ?>"><!--时间筛选账单详情增加-->
<input type="hidden" id="bill_list" value="1"><!--时间筛选账单类型-->

<input type="hidden" id="change_message" value="<?php echo url('index/user_center/change_message'); ?>">
<input type="hidden" id="get_phone_code" value="<?php echo url('index/user_center/send_phone'); ?>"><!--发送手机验证码-->
<input type="hidden" id="change_user_phone_url" value="<?php echo url('index/user_center/change_phone'); ?>"><!--更换手机号-->
<input type="hidden" id="change_user_email_url" value="<?php echo url('index/user_center/change_email'); ?>"><!--更换邮箱-->
<input type="hidden" id="bind_user_email_url" value="<?php echo url('index/user_center/bind_user_email'); ?>"><!--绑定邮箱-->
<input type="hidden" id="change_user_pwd_url" value="<?php echo url('index/user_center/modify_pwd'); ?>"><!--修改密码-->
<input type="hidden" id="user_email_url" value="<?php echo url('index/user_center/mailbox_verify'); ?>"><!--重新发送邮箱链接-->
<input type="hidden" id="send_email" value=""><!--邮箱账号-->

<input type="hidden" id="jump_user_email" value="<?php echo url('index/user_center/email_jump'); ?>"><!--跳往指定邮箱-->
<input type="hidden" id="audit" value="<?php echo url('index/user_center/my_audit'); ?>"><!--实名认证-->
<input type="hidden" id="identity_photo_url" value="<?php echo url('index/user_center/identity_photo_positive'); ?>"><!--实名认证身份证上传(正面)-->
<input type="hidden" id="identity_opposite_url" value="<?php echo url('index/user_center/identity_photo_opposite'); ?>"><!--实名认证身份证上传（反面）-->
<input type="hidden" id="company_img_url" value="<?php echo url('index/user_center/company_img_url'); ?>"><!--营业执照-->
<input type="hidden" id="user_price_url" value="<?php echo url('index/user_center/user_price'); ?>"><!--上传头像-->
<input type="hidden" id="alipay_url" value="<?php echo url('core/unionpay/alipay'); ?>"><!--支付宝-->
<input type="hidden" id="get_qrcode_url" value="<?php echo url('core/unionpay/get_qrcode_url'); ?>"><!--微信-->
<input type="hidden" id="get_order_pay_status" value="<?php echo url('core/order/get_order_pay_status'); ?>"><!--扫描订单状态-->
<input type="hidden" id="user_center" value="<?php echo url('index/user_center/account','type=1'); ?>"><!--用户中心-->


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

<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<!-- <script type="text/javascript">
     (function($){
      $(document).ready(function(){
          $(".industry_ul,.addres_ul1s,.years_list").mCustomScrollbar();
      });
  })(jQuery);
</script> -->
<script type="text/javascript" src="__static__/index/src/js/admin_account.js"></script>
<script type="text/javascript" src="__static__/index/js/account/usercenter.js"></script>
<script type="text/javascript" src="__static__/index/js/account/account.js"></script>

</body>
</html>