<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:34:"../tpl/admin/users\audit_list.html";i:1486436061;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  审核管理
    <span class="c-gray en">&gt;</span>  实名认证
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
        <div class="text-c">
            <a type="submit" class="btn btn-success all_audit l"> 一键审核</a>
            名称搜索：
            <input type="text" class="input-text" style="width:250px" placeholder="输入梦蝶id"  value="<?php echo input('get.search_word'); ?>" name="search_word">
            &nbsp; &nbsp; &nbsp; &nbsp;
                  <select class="select" size="1" name="type"  style="width: 200px;">
                      <option value="" selected>请选择用戶类型</option>
                      <option value="1" <?php if($type == '1'): ?>selected<?php endif; ?>>个人</option>
                      <option value="2" <?php if($type == '2'): ?>selected<?php endif; ?>>企业</option>
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
        <th scope="col" colspan="11">审核列表</th>
    </tr>
    <tr class="text-c">
        <th>ID</th>
        <th>玲珑ID</th>
        <th>登录账号</th>
        <th>真实姓名</th>
        <th>认证类型</th>
        <th>身份证号码</th>
        <th>所属行业</th>
        <th>所在地区</th>
        <th>详细地址</th>
        <th>认证状态</th>
        <th width="20%">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
    <tr>
        <td class="text-c" colspan="12">暂无数据..</td>
    </tr>
    <?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
    <tr class="text-c">
        <td><input class="check" type="checkbox" data-id="<?php echo $item['id']; ?>" ></td>
        <td><?php echo (isset($item['id']) && ($item['id'] !== '')?$item['id']:'--'); ?></td>
        <td><?php echo (isset($item['phone']) && ($item['phone'] !== '')?$item['phone']:'--'); ?></td>
        <td><?php echo (isset($item['true_name']) && ($item['true_name'] !== '')?$item['true_name']:'--'); ?></td>
        <td>
            <?php switch($item['type']): case "1": ?><span class="label label-success radius">个人</span><?php break; case "2": ?><span class="label label-primary radius">企业</span><?php break; default: ?><span class="label label-success radius">个人</span>
            <?php endswitch; ?>
        </td>
        <td><?php echo (isset($item['identity_card']) && ($item['identity_card'] !== '')?$item['identity_card']:'--'); ?></td>
        <td><?php echo (isset($item['industry']) && ($item['industry'] !== '')?$item['industry']:''); ?></td>
        <td><?php echo (isset($item['city']) && ($item['city'] !== '')?$item['city']:'--'); ?>　<?php echo (isset($item['province']) && ($item['province'] !== '')?$item['province']:'--'); ?></td>
        <td><?php echo (isset($item['detailed_address']) && ($item['detailed_address'] !== '')?$item['detailed_address']:''); ?></td>
        <td>
            <?php switch($item['status']): case "0": ?><span class="label label-warning radius">待审核</span><?php break; case "1": ?><span class="label label-success radius">已认证</span><?php break; case "-1": ?><span class="label label-danger radius">未通过</span><?php break; default: ?><span class="label label-warning radius">待审核</span>
            <?php endswitch; ?>
        </td>
        <td class="td-manage">
            <a title="查看详情" href="javascript:;" data-url="<?php echo url('audit_edit',['id'=>$item['id'],'type'=>$item['type']]); ?>" class="btn btn-primary ml-5 open_form radius" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;&nbsp;查看详情</i></a>
            <?php if($item['status'] == '0'): ?>
            <a title="审核" href="javascript:;" data-url="<?php echo url('verify_user'); ?>" data-id="<?php echo (isset($item['id']) && ($item['id'] !== '')?$item['id']:''); ?>" class="btn btn-secondary ml-5 radius verify_btn" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e0;&nbsp;&nbsp;审核&nbsp;&nbsp;</i></a>
            <?php else: ?>
            <a title="已审核" href="javascript:;" class="btn btn-default ml-5 radius" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e0;&nbsp;已审核</i></a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
    </tbody>
</table>
</div>
<nav class="page_admin">
    <?php echo (isset($page) && ($page !== '')?$page:""); ?>
</nav>
<input type="hidden" id="del_url" value="<?php echo Url('audit_del'); ?>">
<input type="hidden" id="all_audit_change" value="<?php echo Url('all_audit_change'); ?>">

</div>



<script type="text/javascript" src="__static__/admin/js/index/index.js"></script>
<script type="text/javascript" src="__static__/admin/js/users/audit_edit.js"></script>

</body>
</html>