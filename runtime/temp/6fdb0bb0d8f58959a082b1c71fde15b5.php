<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:41:"../tpl/admin/finance\recharge_config.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1484634306;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  充值管理
    <span class="c-gray en">&gt;</span>  套餐配置列表
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
       <button type="button" class="btn btn-success radius open_form" data-url="<?php echo url('exec',['type'=>'add']); ?>"><i class="Hui-iconfont">&#xe600;</i> 添加套餐配置</button>
    </span>
    <form id="form_condition" class="form-search" method="get">
        <div class="text-c">
            名称搜索：
            <input type="text" name="search_word" value="<?php echo input('param.search_word',''); ?>" placeholder="请输入套餐钱数" class="input-text" style="width:250px;">
            <button type="submit" class="btn btn-success radius" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <button type="submit" class="btn btn-default radius" onclick="$('input[name=\'search_word\']').val('')"  name=""><i class="fa fa-times"></i> 清空搜索</button>
            <span class="r">共有数据：<strong><?php echo $total; ?></strong> 条</span>
        </div>
    </form>
</div>
<div class="mt-20 list_div dataTables_wrapper no-footer">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th>序号</th>
            <th>套餐名称</th>
            <th>套餐价格</th>
            <th>额外赠送</th>
            <th>套餐时长</th>
            <th>套餐描述</th>
            <th>状态</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody id="search_list">
        <?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
        <tr>
            <td class="text-c" colspan="9">暂无数据..</td>
        </tr>
        <?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?></td>
            <td>
               <?php echo (isset($vo['name']) && ($vo['name'] !== '')?$vo['name']:'--'); ?>
            </td>
            <td>
                <?php echo (isset($vo['money']) && ($vo['money'] !== '')?$vo['money']:''); ?>元
                <?php if(!(empty($vo['unit']) || ($vo['unit'] instanceof \think\Collection && $vo['unit']->isEmpty()))): ?>
                   /<?php echo (isset($vo['unit']) && ($vo['unit'] !== '')?$vo['unit']:'秒'); endif; ?>
            </td>
            <td><?php echo (isset($vo['extra']) && ($vo['extra'] !== '')?$vo['extra']:''); ?>元</td>
            <td>
                <?php if(empty($vo['all_time']) || ($vo['all_time'] instanceof \think\Collection && $vo['all_time']->isEmpty())): ?>
                   --
                <?php else: ?>
                   <?php echo (isset($vo['all_time']) && ($vo['all_time'] !== '')?$vo['all_time']:'0'); ?>分钟
                <?php endif; ?>
            </td>
            <td><?php echo (isset($vo['desc']) && ($vo['desc'] !== '')?$vo['desc']:""); ?></td>
            <td>
                <?php switch($vo['status']): case "1": ?><span class="label label-success radius">可用</span><?php break; case "-1": ?><span class="label label-default radius">禁用</span><?php break; endswitch; ?>
            </td>
            <td><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?></td>
            <td class="td-manage">
                <a title="编辑" data-url="<?php echo url('exec',['type'=>'edit','id'=>$vo['id']]); ?>" href="javascript:;" class="ml-5 open_form" style="text-decoration:none">
                    <i class="Hui-iconfont">&#xe6df;</i>
                </a>
                <a  title="删除" data-url="<?php echo url('del_recharge_conf'); ?>" data-id="<?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:0); ?>" href="javascript:;" class="ml-5 del_by_id" style="text-decoration:none">
                    <i class="Hui-iconfont">&#xe6e2;</i>
                </a>
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