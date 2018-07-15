<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:30:"../tpl/admin/config\index.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  自定义配置
    <span class="c-gray en">&gt;</span>  全部配置
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
    

<div class="cl pd-5 bg-1 bk-gray mt-20">
    <span class="l">
    <a class="btn btn-primary radius open_form" data-title="自定义配置->添加配置" data-url="<?php echo url('exec',['type'=>'add']); ?>" href="javascript:;">
        <i class="Hui-iconfont">&#xe600;</i> 添加配置</a>
    </span>

    <form id="form_condition" class="form-search" method="get">
        <div class="text-c"> 名称搜索：
            <input type="text" class="input-text" style="width:250px" placeholder="请输入配置名称关键字" id="" name="search_word" value="<?php echo input('param.search_word',''); ?>">
            <button type="submit" class="btn btn-success " name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        <button type="submit" class="btn btn-default" onclick="$('input[name=\'search_word\']').val('')"  name=""><i class="fa fa-times"></i> 清空搜索</button>
        </div>
    </form>
</div>
<div class="mt-20">
    <table class="table table-border table-bordered table-bg table-hover table-sort">
        <thead>
        <tr class="text-c">
            <th width="80">排序号</th>
            <th width="100">配置标题</th>
            <th width="100">配置标识</th>
            <th width="100">配置类型</th>
            <th width="60">分组</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
        <tr>
            <td class="text-c" colspan="6">暂无数据..</td>
        </tr>
        <?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr  class="text-c" >
                <td ><?php echo (isset($vo['sort']) && ($vo['sort'] !== '')?$vo['sort']:''); ?></td>
                <td  class="text-l" ><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:''); ?></td>
                <td  class="text-l" ><?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?></td>
                <td ><span class="label label-default"><?php echo (isset($vo['type_name']) && ($vo['type_name'] !== '')?$vo['type_name']:'隐藏配置'); ?></span></td>
                <td><span class="label label-info"><?php echo (isset($vo['group_name']) && ($vo['group_name'] !== '')?$vo['group_name']:''); ?></span></td>
                <td class="td-manage">
                    <?php if(!(empty($vo['editable']) || ($vo['editable'] instanceof \think\Collection && $vo['editable']->isEmpty()))): switch($vo['editable']): case "true": ?>
                    <a style="text-decoration:none" class="ml-5 open_form" href="javascript:" data-url="<?php echo url('exec',['type'=>'edit','id'=>$vo['id']]); ?>" title="编辑">
                        <i class="Hui-iconfont">&#xe6df;</i>
                    </a>
                    <a data-url="<?php echo url('del'); ?>" data-id="<?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:0); ?>" style="text-decoration:none" class="ml-5 del_by_id" href="javascript:;" title="删除">
                        <i class="Hui-iconfont">&#xe6e2;</i>
                    </a>
                    <?php break; default: ?>
                    <a style="text-decoration:none" class="ml-5" href="javascript:" title="不可操作">
                        <i class="Hui-iconfont disabled_btn">&#xe6df;</i>
                    </a>
                    <a style="text-decoration:none" class="ml-5" href="javascript:;" title="不可操作">
                        <i class="Hui-iconfont disabled_btn">&#xe6e2;</i>
                    </a>
                    <?php endswitch; endif; ?>

                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>
</div>


<nav class="page_admin">
    <?php echo (isset($page) && ($page !== '')?$page:''); ?>
</nav>

</div>



</body>
</html>