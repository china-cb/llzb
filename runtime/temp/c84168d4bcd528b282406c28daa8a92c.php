<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:47:"../tpl/index/user_center\bill_increase_ajx.html";i:1486200665;}*/ ?>
<?php if(empty($rt) || ($rt instanceof \think\Collection && $rt->isEmpty())): ?>
<div class="statis_list_no">
    <span></span>
    暂无数据。。。
</div>
<?php else: if(is_array($rt) || $rt instanceof \think\Collection): $i = 0; $__LIST__ = $rt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
<ul class="statis_ul">
    <li><?php echo (isset($vo['id']) && ($vo['id'] !== '')?$vo['id']:''); ?></li>
    <!--<li><?php echo (isset($vo['title']) && ($vo['title'] !== '')?$vo['title']:''); ?></li>-->
    <li><?php echo (isset($vo['package_all']) && ($vo['package_all'] !== '')?$vo['package_all']:''); ?>分钟</li>
    <li><?php echo (isset($vo['balance']) && ($vo['balance'] !== '')?$vo['balance']:''); ?>分钟</li>
    <li><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?>分钟</li>
   <!--  ￥{}
    $vo.cost_money|default='' -->
</ul>
<?php endforeach; endif; else: echo "" ;endif; ?>
<div>
    <?php echo (isset($page) && ($page !== '')?$page:''); ?>
</div>
<?php endif; ?>