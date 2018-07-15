<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:31:"../tpl/admin/index\desktop.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
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
    
<link rel="stylesheet" type="text/css" href="__hui__/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="__hui_admin__/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="__hui_admin__/skin/default/skin.css" />
<link rel="stylesheet" type="text/css" href="__hui_admin__/css/style.css" />
<link rel="stylesheet" type="text/css" href="__static__/hui/admin/css/style.css" />
<link rel="stylesheet" type="text/css" href="__plugin__/zTree/css/zTreeStyle/zTreeStyle.css" />

<link rel="stylesheet" type="text/css" href="__static__/admin/css/public.css" />

    


    <title>
        
    </title>
</head>
<body>
<nav class="breadcrumb">
    <i class="Hui-iconfont">&#xe67f;</i> 控制台
    <span class="c-gray en">&gt;</span>  系统
    <span class="c-gray en">&gt;</span>  桌面
    <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
       href="javascript:location.replace(location.href);" title="刷新">
        <i class="Hui-iconfont">&#xe68f;</i>
    </a>
</nav>
<!--插件-->
<script type="text/javascript" src="__plugin__/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__plugin__/laydate/laydate.js"></script>
<script type="text/javascript" src="__plugin__/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="__plugin__/zTree/js/jquery.ztree.core-3.5.min.js"></script>
<script type="text/javascript" src="__plugin__/zTree/js/jquery.ztree.excheck-3.5.min.js"></script>
<script type="text/javascript" src="__plugin__/webuploader/0.1.5/webuploader.min.js"></script>





<!--基础-->
<script type="text/javascript" src="__hui__/js/H-ui.js"></script>
<script type="text/javascript" src="__hui_admin__/js/H-ui.admin.js"></script>

<!--[if lt IE 9]>
<script type="text/javascript" src="__plugin__/html5.js"></script>
<script type="text/javascript" src="__plugin__/respond.min.js"></script>
<script type="text/javascript" src="__plugin__/PIE_IE678.js"></script>
<![endif]-->

<!--通用-->
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__static__/admin/js/public.js"></script>




<div class="page-container">
    
    <p class="f-20 text-success">梦蝶直播CMS管理系统</p>
    <p>登录次数：<?php echo \think\Session::get('admin')['login_times']; ?> </p>
    <p>上次登录IP：<?php echo \think\Session::get('admin')['admin_login_ip']; ?>  上次登录时间：<?php echo date('Y-m-d H:i:s',\think\Session::get('admin')['admin_login_time']); ?></p>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th colspan="7" scope="col">每日统计</th>
        </tr>
        <tr class="text-c">
            <th width="20%">日注册数</th>
            <th width="20%">日登录数</th>
            <th width="20%">日充值总额</th>
            <th width="20%">日消费总额</th>
            <th width="20%">日提现总额</th>
        </tr>
        </thead>
        <tbody>
        <tr class="text-c">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
<br><br>
<table class="table table-border table-bordered table-bg">
    <thead>
    <tr>
        <th colspan="7" scope="col">数据统计</th>
    </tr>
    <tr class="text-c">
        <th width="20%">平台用户数</th>
        <th width="20%">总充值金额</th>
        <th width="20%">总提现金额</th>
        <th width="20%">待审核提现数</th>
        <th width="20%">待申请认证数</th>
    </tr>
    </thead>
    <tbody>
    <tr class="text-c">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tbody>
</table>
<br><br>
<table class="table table-border table-bordered table-bg">
    <thead>
    <tr>
        <th colspan="4" scope="col">收益状况</th>
    </tr>
    <tr class="text-c">
        <th width="10%">收益总数</th>
        <th width="20%">平台收益</th>
        <th width="20%">主播收益</th>
    </tr>
    </thead>
    <tbody>
    <tr class="text-c">
        <td>总数</td>
        <td></td>
        <td>￥</td>
    </tr>
    </tbody>
</table>
    <!--<table class="table table-border table-bordered table-bg mt-20">-->
        <!--<thead>-->
        <!--<tr>-->
            <!--<th colspan="2" scope="col">服务器信息</th>-->
        <!--</tr>-->
        <!--</thead>-->
        <!--<tbody>-->
        <!--<tr>-->
            <!--<th width="30%">服务器计算机名</th>-->
            <!--<td><span id="lbServerName">http://127.0.0.1/</span></td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器IP地址</td>-->
            <!--<td>192.168.1.1</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器域名</td>-->
            <!--<td>www.h-ui.net</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器端口 </td>-->
            <!--<td>80</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器IIS版本 </td>-->
            <!--<td>Microsoft-IIS/6.0</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>本文件所在文件夹 </td>-->
            <!--<td>D:\WebSite\HanXiPuTai.com\XinYiCMS.Web\</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器操作系统 </td>-->
            <!--<td>Microsoft Windows NT 5.2.3790 Service Pack 2</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>系统所在文件夹 </td>-->
            <!--<td>C:\WINDOWS\system32</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器脚本超时时间 </td>-->
            <!--<td>30000秒</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器的语言种类 </td>-->
            <!--<td>Chinese (People's Republic of China)</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>.NET Framework 版本 </td>-->
            <!--<td>2.050727.3655</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器当前时间 </td>-->
            <!--<td>2014-6-14 12:06:23</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器IE版本 </td>-->
            <!--<td>6.0000</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>服务器上次启动到现在已运行 </td>-->
            <!--<td>7210分钟</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>逻辑驱动器 </td>-->
            <!--<td>C:\D:\</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>CPU 总数 </td>-->
            <!--<td>4</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>CPU 类型 </td>-->
            <!--<td>x86 Family 6 Model 42 Stepping 1, GenuineIntel</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>虚拟内存 </td>-->
            <!--<td>52480M</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>当前程序占用内存 </td>-->
            <!--<td>3.29M</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>Asp.net所占内存 </td>-->
            <!--<td>51.46M</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>当前Session数量 </td>-->
            <!--<td>8</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>当前SessionID </td>-->
            <!--<td>gznhpwmp34004345jz2q3l45</td>-->
        <!--</tr>-->
        <!--<tr>-->
            <!--<td>当前系统用户名 </td>-->
            <!--<td>NETWORK SERVICE</td>-->
        <!--</tr>-->
        <!--</tbody>-->
    <!--</table>-->
<!--
</div>





</body>
</html>