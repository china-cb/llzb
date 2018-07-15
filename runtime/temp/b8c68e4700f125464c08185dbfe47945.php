<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:39:"../tpl/index/user_center\order_ajx.html";i:1486609814;}*/ ?>
<?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
<div class="statis_list_no">
    <span></span>
    无数据
</div>
<?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<ul class="statis_ul">
    <li><?php echo (isset($vo['order_id']) && ($vo['order_id'] !== '')?$vo['order_id']:''); ?></li>
    <!--<li><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:''); ?></li>-->
    <li><?php echo (isset($vo['consume']) && ($vo['consume'] !== '')?$vo['consume']:''); ?>分钟</li>
    <li><?php echo (isset($vo['package_rest']) && ($vo['package_rest'] !== '')?$vo['package_rest']:''); ?>分钟</li>
    <li><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?></li>
   <!--  ￥{}
    $vo.cost_money|default='' -->
</ul>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div>
    <?php echo (isset($pages) && ($pages !== '')?$pages:''); ?>
</div>
<?php endif; ?>