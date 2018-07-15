<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:43:"../tpl/admin/channel_list\channel_list.html";i:1484638013;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  频道管理
    <span class="c-gray en">&gt;</span>  频道列表
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
            名称搜索：
            <input type="text" class="input-text" style="width:250px" placeholder="请输入登录账户"  value="<?php echo input('get.search_word'); ?>" name="search_word">
            &nbsp; &nbsp; &nbsp; &nbsp;
            日期范围：
            <input type="text" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" id="datemin" name="start_time" value="<?php echo input('get.start_time'); ?>" placeholder="请输入直播开始时间" class="input-text Wdate" style="width:250px;">
            -
            <input type="text"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" id="datemax" name="end_time" value="<?php echo input('get.end_time'); ?>" class="input-text Wdate" placeholder="请输入直播结束时间" style="width:250px;">
            <button type="submit" class="btn btn-success " name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <button type="submit" class="btn btn-default" onclick="$('input[name=\'search_word\']').val('')"  name="search_empty"><i class="fa fa-times"></i> 清空搜索</button>
            <span class="r">共有数据：<strong><?php echo (isset($total) && ($total !== '')?$total:''); ?></strong> 条</span>
        </div>
    </form>
</div>

<div class="mt-20">
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="11">频道列表</th>
        </tr>
        <tr class="text-c">
            <th>玲珑ID</th>
            <th>登录账号</th>
            <th>频道个数</th>
            <th>正在直播频道数</th>
            <th>最后直播时间</th>
            <th>累计直播播放时长</th>
            <th>累计花费</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($item) || ($item instanceof \think\Collection && $item->isEmpty())): ?>
        <tr>
            <td class="text-c" colspan="12">暂无数据..</td>
        </tr>
        <?php else: if(is_array($item) || $item instanceof \think\Collection): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><?php echo (isset($item['num_id']) && ($item['num_id'] !== '')?$item['num_id']:'--'); ?></td>
            <td><?php echo (isset($item['account']) && ($item['account'] !== '')?$item['account']:'--'); ?></td>
            <td><?php echo (isset($item['u_num']) && ($item['u_num'] !== '')?$item['u_num']:'0'); ?></td>
            <td><?php echo (isset($item['live_num']) && ($item['live_num'] !== '')?$item['live_num']:'0'); ?></td>
            <td><?php echo date("Y-m-d H:i:s",$item['end_time']); ?></td>
            <td><?php echo (isset($item['c_num']) && ($item['c_num'] !== '')?$item['c_num']:'--'); ?>分钟</td>
            <td>￥<?php echo (isset($item['sum_money']) && ($item['sum_money'] !== '')?$item['sum_money']:'0.00'); ?></td>
            <td class="td-manage">
                <a title="查看详情" href="javascript:;" data-url="<?php echo url('channel_info',['id' => $item['member_id'],'cid' => $item['cid']]); ?>" class="btn btn-primary ml-5 open_form radius" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;&nbsp;查看详情</i></a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>
</div>
<nav class="page_admin">
    <?php echo (isset($page) && ($page !== '')?$page:""); ?>
</nav>
<script>
    $("#search_empty").click(function(){
        $("input[name='start_time']").val('');
        $("input[name='end_time']").val('');
    })
</script>

</div>



<script type="text/javascript" src="__static__/admin/js/index/index.js"></script>

</body>
</html>