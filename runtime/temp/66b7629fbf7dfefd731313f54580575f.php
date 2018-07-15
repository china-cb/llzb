<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"../tpl/admin/log_manager\login_log.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1484634306;}*/ ?>
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
    <i class="Hui-iconfont">&#xe67f;</i> 后台
    <span class="c-gray en">&gt;</span>  日志管理
    <span class="c-gray en">&gt;</span>  登录日志
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
    
<title>主播认证</title>

<div class="cl pd-5 bg-1 bk-gray mt-20">
    <form id="form_condition" class="form-search" method="get">
        <div class="text-c">名称搜索：
            <input type="text" class="input-text" style="width:250px" placeholder="输入注册手机号"  value="<?php echo input('get.search_word'); ?>" name="search_word">
            &nbsp; &nbsp; &nbsp; &nbsp;
            日期范围：
                <input type="text" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" id="datemin" name="start_time" value="<?php echo input('get.start_time'); ?>" class="input-text Wdate" style="width:250px;">
                -
                <input type="text"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" id="datemax" name="end_time" value="<?php echo input('get.end_time'); ?>"class="input-text Wdate" style="width:250px;">
            <select class="select" size="1" name="type"  style="width: 200px;">
                <option value="" selected>请选择日志类型</option>
                <option value="0" <?php if($type == '0'): ?>selected<?php endif; ?>>登录</option>
                <option value="1" <?php if($type == '1'): ?>selected<?php endif; ?>>注册</option>
            </select>
            <button type="submit" class="btn btn-success " name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <button type="submit" class="btn btn-default" onclick="$('input[name=\'search_word\']').val('')"  name=""><i class="fa fa-times"></i> 清空搜索</button>
            <span class="r">共有数据：<strong><?php echo $total; ?></strong> 条</span>
        </div>
    </form>
</div>

<div class="mt-20">
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">登录日志</th>
        </tr>
        <tr class="text-c">
            <th width="40">玲珑ID</th>
            <th width="150"><?php if($type == '0'): ?>登录手机号<?php else: ?>注册手机号<?php endif; ?></th>
            <?php if($type == '0'): ?><th width="150">登录方式</th><?php endif; ?>
            <th width="150"><?php if($type == '0'): ?>登录来源<?php else: ?>注册来源<?php endif; ?></th>
            <th width="100"><?php if($type == '0'): ?>登录日期<?php else: ?>注册日期<?php endif; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($live_list) || $live_list instanceof \think\Collection): $i = 0; $__LIST__ = $live_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><?php echo (isset($item['num_id']) && ($item['num_id'] !== '')?$item['num_id']:'--'); ?></td>
            <td><?php echo (isset($item['phone']) && ($item['phone'] !== '')?$item['phone']:'--'); ?></td>
            <?php if($type == '0'): ?>
            <td>
                <?php switch($item['login_way']): case "1": ?>pc<?php break; case "2": ?>app<?php break; case "3": ?>客户端<?php break; default: ?>pc
                <?php endswitch; ?>
            </td><?php endif; ?>
            <td><?php echo (isset($item['source']) && ($item['source'] !== '')?$item['source']:'--'); ?></td>
            <td><?php echo date("Y-m-d H:i:s",$item['create_time']); ?></td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<nav class="page_admin">
    <?php echo (isset($page) && ($page !== '')?$page:''); ?>
</nav>

</div>




</body>
</html>