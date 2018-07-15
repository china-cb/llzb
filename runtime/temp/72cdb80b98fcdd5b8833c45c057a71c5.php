<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:28:"../tpl/admin/auth\index.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1484634306;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  管理员
    <span class="c-gray en">&gt;</span>  角色管理
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
    

<div class="cl pd-5 bg-1 bk-gray mt-10">
    <span class="l">
    <a class="btn btn-primary radius open_form" data-url="<?php echo url('exec',['type'=>'add']); ?>" href="javascript:;">
        <i class="Hui-iconfont">&#xe600;</i> 添加角色</a>
    </span>

</div>
<div class="mt-10">
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">角色ID</th>
            <th  width="300">角色名称</th>
            <th width="50">是否超级管理员</th>
            <th width="50">状态</th>
            <th width="150">默认打开页</th>
            <th width="300">描述</th>
            <th width="60">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?></td>
            <td class="text-l"><?php echo (isset($vo['title_show']) && ($vo['title_show'] !== '')?$vo['title_show']:'--'); ?></td>
            <td>
                <?php if(!(empty($vo['is_super']) || ($vo['is_super'] instanceof \think\Collection && $vo['is_super']->isEmpty()))): switch($vo['is_super']): case "true": ?><span class="label label-success radius">√</span><?php break; case "false": ?><span class="label label-info radius">×</span><?php break; default: ?>--
                <?php endswitch; endif; ?>
            </td>
            <td class="text-c">
                <?php if(!(empty($vo['status']) || ($vo['status'] instanceof \think\Collection && $vo['status']->isEmpty()))): switch($vo['status']): case "1": ?><span class="label label-default radius">生效</span><?php break; case "-2": ?><span class="label label-info radius">冻结</span><?php break; default: ?>--
                <?php endswitch; endif; ?>
            </td>
            <td><?php echo (isset($vo['index_name']) && ($vo['index_name'] !== '')?$vo['index_name']:'--'); ?></td>
            <td><?php echo (isset($vo['tips']) && ($vo['tips'] !== '')?$vo['tips']:'--'); ?></td>
            <td class="td-manage">
                <a style="text-decoration:none"  href="javascript:;" title="当前节点新增" class="open_form"  data-url="<?php echo url('exec',['type'=>'add','pid'=>$vo['id']]); ?>">
                    <i class="Hui-iconfont">&#xe600;</i>
                </a>
                <a style="text-decoration:none" class="ml-5 open_form" href="javascript:" data-url="<?php echo url('exec',['type'=>'edit','id'=>$vo['id']]); ?>" title="编辑">
                    <i class="Hui-iconfont">&#xe6df;</i>
                </a>
                <a data-url="<?php echo url('del'); ?>" data-id="<?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:0); ?>" style="text-decoration:none" class="ml-5 del_by_id" href="javascript:;" title="删除">
                    <i class="Hui-iconfont">&#xe6e2;</i>
                </a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>

</div>



</body>
</html>