<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:29:"../tpl/admin/index\index.html";i:1484634306;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <LINK rel="Bookmark" href="/favicon.ico" >
    <LINK rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="__plugin__/html5.js"></script>
    <script type="text/javascript" src="__plugin__/respond.min.js"></script>
    <script type="text/javascript" src="__plugin__/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="__hui__/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="__hui_admin__/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="__plugin__/Hui-iconfont/1.0.7/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="__plugin__/icheck/icheck.css" />
    <link rel="stylesheet" type="text/css" href="__hui_admin__/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="__hui_admin__/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>后台管理系统<?php echo __admin_version__; ?></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="<?php echo url('admin/index/index'); ?>"><?php echo \think\Config::get('backstage_name'); ?></a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="<?php echo url('admin/index/index'); ?>">H-ui</a> <span class="logo navbar-slogan f-l mr-10 hidden-xs"><?php echo \think\Config::get('vesion_num'); ?></span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li id="Hui-msg" class="dropDown dropDown_hover" style="margin-right: 5px;">
                        <a data-title="服务消息">
                            <span class="badge badge-danger all_massage"></span>
                            <i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i>
                            <i class="Hui-iconfont">&#xe6d5;</i>
                            <ul class="dropDown-menu menu radius box-shadow" style="width: 135px;">
                                <li>
                                    <span class="badge badge-danger" style="margin-left: 83px;margin-top: 16px;"></span>
                                    <a _href="<?php echo url('admin/users/audit_list'); ?>" data-title="主播申请" onClick="Hui_admin_tab(this)" > <i class="Hui-iconfont">&#xe622;</i>&nbsp;主播申请:
                                    </a>
                                </li>
                                <li>
                                    <span class="reference badge  badge-danger" style="margin-left: 83px;margin-top: 6px;"></span>
                                    <a  _href="<?php echo url('admin/finance/reference_list'); ?>" data-title="提现申请" onClick="Hui_admin_tab(this)" > <i class="Hui-iconfont">&#xe622;</i>&nbsp;提现申请:
                                    </a>
                                </li>
                                <li>
                                    <span class="report badge  badge-danger" style="margin-left: 83px;margin-top: 6px;"></span>
                                    <a  _href="<?php echo url('admin/users/report_list'); ?>" data-title="举报管理" onClick="Hui_admin_tab(this)" > <i class="Hui-iconfont">&#xe622;</i>&nbsp;举报管理:
                                    </a>
                                </li>
                                <li>
                                    <span class="treasure_box badge  badge-danger" style="margin-left: 83px;margin-top: 6px;"></span>
                                    <a  _href="<?php echo url('admin/treasure_box/review_list'); ?>" data-title="百宝箱申请" onClick="Hui_admin_tab(this)" > <i class="Hui-iconfont">&#xe622;</i>&nbsp;宝箱申请:
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </li>
                    <li><?php echo \think\Session::get('admin')['role_name']; ?></li>
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A"><?php echo \think\Session::get('admin')['user_login']; ?> <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:" class="admin_quit">退出</a></li>
                        </ul>
                    </li>
                    <!--<li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>-->
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <!--菜单开始-->
    <?php echo widget('Menu/show_menu'); ?>
    <!--菜单结束-->
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="我的桌面" data-href="<?php echo Url('desktop'); ?>">我的桌面</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="<?php echo Url('index/desktop'); ?>"></iframe>
        </div>
    </div>
</section>
<input type="hidden" id="get_message_number" value="<?php echo url('admin/index/get_message_number'); ?>">
<input type="hidden" id="get_session" value="<?php echo url('admin/account/refresh_login_user_session'); ?>">
<script type="text/javascript" src="__plugin__/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__hui__/js/H-ui.js"></script>
<script type="text/javascript" src="__hui_admin__/js/H-ui.admin.js"></script>

<!--通用-->
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__static__/admin/js/public.js"></script>
<script type="text/javascript" src="__static__/admin/js/index/index.js"></script>

<script type="text/javascript">
    //定时刷新用户session
    common.delay(function(){
        var url = $("#get_session").val();
        common.ajax_post(url,false,true,function(rt){
            if(rt==='-1')location.reload();
            console.log('更新用户session');
        });
    },15000,1,true);
    
//    function get_message_number() {
//        var message_url = $("#get_message_number").val();
//        common.ajax_post(message_url,false,true,function(rt){
//            var obj = common.str2json(rt);
//            $('.audit').html(obj.anchor_apply_num);
//            $('.reference').html(obj.reference_apply_num);
//            $('.report').html(obj.report_apply_num);
//            $('.treasure_box').html(obj.treasure_box_num);
//            $('.all_massage').html(obj.all_massage);
//        });
//    }
//    setInterval('get_message_number()',1000*20);
</script>
<input type="hidden" id="admin_quit" value='<?php echo url("admin/account/quit"); ?>'/><!--用户退出-->
</body>
</html>