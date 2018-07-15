<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:39:"../tpl/admin/finance\recharge_list.html";i:1486175764;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1486175874;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  订单管理
    <span class="c-gray en">&gt;</span>  充值订单
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
    <form id="form_condition" class="form-search" method="get">
        <div class="text-c">
            &nbsp;名称搜索:&nbsp;
            <input type="text"  name="search_word" value="<?php echo input('param.search_word',''); ?>" class="input-text" style="width:250px" placeholder="请输入登录账户/订单号">
            &nbsp;&nbsp;
            日期范围：
            <input type="text" name="start_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="input-text start_time" style="width:250px;" placeholder="开始时间" value="<?php echo input('param.start_time'); ?>">&nbsp;-&nbsp;
            <input type="text" name="end_time" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" class="input-text end_time" style="width:250px;" placeholder="结束时间" value="<?php echo input('param.end_time'); ?>">
            <button type="submit" class="btn btn-success " name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <button type="submit" class="btn btn-default" onclick="$('input[name=\'search_word\']').val('')"  id="search_empty"><i class="fa fa-times"></i> 清空搜索</button>
            <span class="r">总订单数量：<strong style="color: #ff0000"><?php echo (isset($total) && ($total !== '')?$total:'0'); ?></strong> &nbsp;&nbsp;&nbsp;&nbsp;充值金额总计：<strong style="color: #ff0000">￥<?php echo (isset($recharge_all) && ($recharge_all !== '')?$recharge_all:'0.00'); ?></strong></span>
        </div>
    </form>
</div>


<div class="mt-20">
    <table class="table table-border table-bordered table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th>玲珑ID</th>
            <th>登陆账号</th>
            <th>订单号</th>
            <th>充值金额</th>
            <th>充值前账户余额</th>
            <th>充值后账户余额</th>
            <th>充值方式</th>
            <th>支付状态</th>
            <th>支付时间</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
        <tr>
            <td class="text-c" colspan="11">暂无数据...</td>
        </tr>
        <?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><?php echo (isset($vo['num_id']) && ($vo['num_id'] !== '')?$vo['num_id']:'--'); ?></td>
            <td><?php echo (isset($vo['account']) && ($vo['account'] !== '')?$vo['account']:'--'); ?></td>
            <td><?php echo (isset($vo['order_id']) && ($vo['order_id'] !== '')?$vo['order_id']:'--'); ?></td>
            <td>￥<?php echo (isset($vo['money']) && ($vo['money'] !== '')?$vo['money']:'0.00'); ?></td>
            <td>
                <?php if($vo['pay_status'] == '1'): ?>
                   ￥<?php echo $vo['balance'] - $vo['money']; else: ?>
                   ￥<?php echo (isset($vo['balance']) && ($vo['balance'] !== '')?$vo['balance']:'0.00'); endif; ?>
            </td>
            <td> ￥<?php echo (isset($vo['balance']) && ($vo['balance'] !== '')?$vo['balance']:'0.00'); ?></td>
            <td>
                <?php switch($vo['pay_type']): case "1": ?><i class='Hui-iconfont'>&#xe71f;</i>&nbsp;支付宝<?php break; case "2": ?><i class="Hui-iconfont">&#xe719;</i>&nbsp;微信<?php break; case "3": ?>苹果<?php break; case "4": ?>爱贝<?php break; default: ?>未知
                <?php endswitch; ?>
            </td>
            <td>
                <?php switch($vo['pay_status']): case "0": ?><span class="label label-warning radius">待支付</span><?php break; case "1": ?><span class="label label-success radius">已支付</span><?php break; case "2": ?><span class="label label-danger radius">支付失败</span><?php break; default: ?><span class="label label-danger radius">支付失败</span>
                <?php endswitch; ?>
            </td>
            <td>
                <?php if(empty($vo['pay_time']) || ($vo['pay_time'] instanceof \think\Collection && $vo['pay_time']->isEmpty())): ?>
                --
                <?php else: ?>
                <?php echo (date("Y-m-d H:i:s",$vo['pay_time']) !== ''?date("Y-m-d H:i:s",$vo['pay_time']):'--'); endif; ?>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>
</div>
<div class="page">
    <?php echo (isset($pages) && ($pages !== '')?$pages:''); ?>
</div>


<nav class="page_admin">
    <?php echo $page; ?>
</nav>



</div>



<!--<script type="text/javascript" src="__static__/admin/js/finance/recharge_list.js"></script>-->
<script>
    $("#search_empty").click(function(){
        $("input[name='start_time']").val('');
        $("input[name='end_time']").val('');
    });
</script>

</body>
</html>