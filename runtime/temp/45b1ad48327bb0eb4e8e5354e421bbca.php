<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:33:"../tpl/admin/users\show_list.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1484634306;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  会员管理
    <span class="c-gray en">&gt;</span>  会员列表
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
        <span class="l">
            <a href="javascript:;" class="btn btn-primary radius open_form" data-url="<?php echo url('member_exec',['type'=>'add']); ?>"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
        </span>
        <div class="text-c">
            名称搜索:
            <input type="text" class="input-text" style="width:250px" placeholder="请输入玲珑ID/登录账号/手机号" id="" name="search_word"  value="<?php echo input('get.search_word'); ?>">
            &nbsp;&nbsp;
            <select class="select" size="1" name="user_type"  style="width: 200px;">
                <option value="1" <?php if($user_type == '1'): ?>selected<?php endif; ?>>个人</option>
                <option value="2" <?php if($user_type == '2'): ?>selected<?php endif; ?>>企业</option>
            </select>
            &nbsp;
            <button type="submit" class="btn btn-success " ><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
            <button type="submit" class="btn btn-default" onclick="$('input[name=\'search_word\']').val('')"  id="search_empty"><i class="fa fa-times"></i> 清空搜索</button>
            <span class="r">共有数据：<strong><?php echo $total; ?></strong> 条</span>
        </div>
    </form>
</div>

<div class="mt-20">
    <table class="table table-border table-bordered table-hover table-bg table-sort">
        <thead>
        <tr class="text-c">
            <th><input type="checkbox" name="" value=""></th>
            <th>UID</th>
            <th>玲珑ID</th>
            <th>登录账号</th>
            <th>手机号</th>
            <th>邮箱</th>
            <th>用户状态</th>
            <th>用户类型</th>
            <th>认证状态</th>
            <th>真实姓名</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
        <tr>
            <td class="text-c" colspan="14">暂无数据..</td>
        </tr>
        <?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="text-c">
            <td><input type="checkbox" value="1" name=""></td>
            <td><?php echo (isset($vo['member_id']) && ($vo['member_id'] !== '')?$vo['member_id']:'--'); ?></td>
            <td><?php echo (isset($vo['num_id']) && ($vo['num_id'] !== '')?$vo['num_id']:'--'); ?></td>
            <td><?php echo (isset($vo['account']) && ($vo['account'] !== '')?$vo['account']:'--'); ?></td>
            <td><?php echo (isset($vo['phone']) && ($vo['phone'] !== '')?$vo['phone']:'--'); ?></td>
            <td><?php echo (isset($vo['email']) && ($vo['email'] !== '')?$vo['email']:'--'); ?></td>
            <td>
                <?php switch($vo['status']): case "1": ?><span class="label label-success radius">正常</span><?php break; case "-1": ?><span class="label label-danger radius">禁用</span><?php break; case "-2": ?><span class="label label-danger radius">删除</span><?php break; default: ?><span class="label label-success radius">正常</span>
                <?php endswitch; ?>
            </td>
            <td>
                <?php switch($vo['user_type']): case "1": ?>个人<?php break; case "2": ?>企业<?php break; default: ?>个人
                <?php endswitch; ?>
            </td>
            <td>
                <?php switch($vo['state']): case "0": ?><span class="label label-warning radius">未认证</span><?php break; case "1": ?><span class="label label-primary radius">待审核</span><?php break; case "2": ?><span class="label label-success radius">已认证</span><?php break; case "-1": ?><span class="label label-danger radius">认证失败</span><?php break; default: ?><span class="label label-warning radius">未认证</span>
                <?php endswitch; ?>
            </td>
            <td><?php echo (isset($vo['true_name']) && ($vo['true_name'] !== '')?$vo['true_name']:'无'); ?></td>
            <td>
                <?php if(empty($vo['create_time']) || ($vo['create_time'] instanceof \think\Collection && $vo['create_time']->isEmpty())): ?>
                --
                <?php else: ?>
                <?php echo date("Y-m-d H:i:s",$vo['create_time']); endif; ?>
            </td>
            <td class="td-manage">
                <a title="查看详情" data-url="<?php echo url('member_exec',['type'=>'info','id'=>$vo['member_id']]); ?>" href="javascript:;"  class="ml-5 open_form" style="text-decoration:none"><i class="Hui-iconfont">&#xe695;</i></a>
                <a title="编辑" data-url="<?php echo url('member_exec',['type'=>'edit','id'=>$vo['member_id']]); ?>" href="javascript:;" class="ml-5 open_form" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                <?php if($vo['status'] == 1): ?>
                <a style="text-decoration:none" class="switch_btn" data-tip="禁用" data-id="<?php echo $vo['member_id']; ?>" data-value="-1" href="javascript:;" title="禁用"><i class="Hui-iconfont">&#xe631;</i></a>
                <?php else: ?>
                <a class="switch_btn" href="javascript:;" data-tip="启用" data-id="<?php echo $vo['member_id']; ?>" title="启用" data-value="1" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
                <?php endif; ?>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>
</div>

<input type="hidden" id="switch_url" value="<?php echo Url('member_status'); ?>">

<nav class="page_admin">
    <?php echo (isset($page) && ($page !== '')?$page:""); ?>
</nav>

</div>



<script type="text/javascript">
     $(document).on("click",".switch_btn",function(){
         var url = $("#switch_url").val();
         var tips = $(this).data("tip");
         var id = $(this).data("id");
         var value = $(this).data("value");
         layer.confirm("您确定要"+tips+"么?",{btn:['确定','取消']},function(){
             common.ajax_post(url,{id:id,value:value},true,function(rt){
                  common.post_tips(rt);
                 var obj = common.str2json(rt);
                 if(obj.code == 1){
                     location.reload();
                 }
             },true)
         });
     });
</script>

</body>
</html>