<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:32:"../tpl/admin/config\setting.html";i:1484634306;s:27:"../tpl/admin/base\base.html";i:1484634306;s:33:"../tpl/admin/base\common_css.html";i:1484634306;s:32:"../tpl/admin/base\common_js.html";i:1484634306;}*/ ?>
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
    <span class="c-gray en">&gt;</span>  
<?php if(!(empty($type) || ($type instanceof \think\Collection && $type->isEmpty()))): switch($type): case "add": ?>添加配置<?php break; case "edit": ?>编辑配置<?php break; default: ?>查看配置
<?php endswitch; endif; ?>

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
    <a class="btn btn-primary radius refresh_config"  href="javascript:;">
        <i class="fa fa-refresh"></i>更新配置缓存</a>
    </span>
</div>
<div class="mt-20">
    <form class="form form-horizontal" id="form-article-add">
        <div id="tab-system" class="HuiTab">
            <div class="tabBar cl">
                <?php if(is_array($cate_list) || $cate_list instanceof \think\Collection): $i = 0; $__LIST__ = $cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <span><?php echo (isset($vo['name']) && ($vo['name'] !== '')?$vo['name']:''); ?></span>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php if(is_array($conf_list) || $conf_list instanceof \think\Collection): if( count($conf_list)==0 ) : echo "" ;else: foreach($conf_list as $k=>$item): ?>
            <div class="tabCon">
                <?php if(is_array($item) || $item instanceof \think\Collection): $i = 0; $__LIST__ = $item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <div class="row cl config_one">
                    <img class="status_img" src="__static__/public/img/loading.gif" style="width: 20px;height: 20px;display: none;">
                    <label class="form-label col-xs-4 col-sm-2"><span
                            class="c-red">*</span><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:''); ?>：</label>
                    <div class="formControls col-xs-8 col-sm-9">
                        <?php switch($vo['type']): case "CONFIG_TYPE_NUMBER": ?>
                        <input name="<?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?>" type="text" placeholder="<?php echo (isset($vo['tips']) && ($vo['tips'] !== '')?$vo['tips']:'请输入'); ?>" value="<?php echo (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:''); ?>" class="input-text conf_one">
                        <?php break; case "CONFIG_TYPE_STRING": ?>
                        <input name="<?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?>" type="text" placeholder="<?php echo (isset($vo['tips']) && ($vo['tips'] !== '')?$vo['tips']:'请输入'); ?>" value="<?php echo (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:''); ?>" class="input-text conf_one">
                        <?php break; case "CONFIG_TYPE_TEXT": ?>
                        <textarea name="<?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?>"  class="textarea conf_one"><?php echo (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:''); ?></textarea>
                        <?php break; case "CONFIG_TYPE_ARRAY": ?>
                        <textarea name="<?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?>"  class="textarea conf_one"><?php echo (isset($vo['value']) && ($vo['value'] !== '')?$vo['value']:''); ?></textarea>
                        <?php break; case "CONFIG_TYPE_ENUM": 
                            $tmp_arr = json_decode($vo['extra'],true);
                        ?>
                        <select class="select conf_one" name="<?php echo (isset($vo['code']) && ($vo['code'] !== '')?$vo['code']:''); ?>" >
                            <?php if(is_array($tmp_arr) || $tmp_arr instanceof \think\Collection): if( count($tmp_arr)==0 ) : echo "" ;else: foreach($tmp_arr as $k_1=>$t_vo): ?>
                            <option <?php if($vo['value'] == $t_vo): ?>selected="selected"<?php endif; ?> value="<?php echo $t_vo; ?>"><?php echo $k_1; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <?php break; endswitch; ?>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $.Huitab("#tab-system .tabBar span", "#tab-system .tabCon", "current", "click", "0");
    });
</script>

<input type="hidden" id="refresh_config" value="<?php echo url('refresh_config'); ?>">
<input type="hidden" id="save_url" value="<?php echo url('save_config'); ?>">
<input type="hidden" id="img_loading" value="__static__/public/img/loading.gif">
<input type="hidden" id="img_ok" value="__static__/public/img/ok.png">
<input type="hidden" id="img_times" value="__static__/public/img/times.png">


</div>



<script type="text/javascript" src="__static__/admin/js/config/setting.js"></script>

</body>
</html>