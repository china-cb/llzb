<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:42:"../tpl/index/user_center\recharge_ajx.html";i:1486609679;}*/ ?>
<?php if(empty($list) || ($list instanceof \think\Collection && $list->isEmpty())): ?>
     <div class="statis_list_no">
         <span></span>
             无数据
    </div>
<?php else: if(is_array($list) || $list instanceof \think\Collection): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <ul class="statis_ul statis_ul2">
        <li><?php echo (isset($vo['recharge_id']) && ($vo['recharge_id'] !== '')?$vo['recharge_id']:''); ?></li>
        <li><?php echo date("Y-m-d H:i:s",$vo['create_time']); ?></li>
        <li><?php echo (isset($vo['money']) && ($vo['money'] !== '')?$vo['money']:''); ?></li>
        <li>
            <?php switch($vo['pay_status']): case "0": ?>未支付<?php break; case "1": ?>已支付<?php break; case "2": ?>支付失败<?php break; default: ?>未支付
            <?php endswitch; ?>
        </li>
        <li>
            <?php switch($vo['pay_type']): case "0": ?>未知<?php break; case "1": ?>支付宝<?php break; case "2": ?>微信<?php break; case "2": ?>苹果支付<?php break; case "2": ?>爱贝<?php break; default: ?>未知
            <?php endswitch; ?>
        </li>
        <li>
            <?php if($vo['pay_status'] == '0'): ?>
            <a data-url="<?php echo url('core/business/order'); ?>"  title="" class="at_buys" data-val="<?php echo (isset($vo['pay_type']) && ($vo['pay_type'] !== '')?$vo['pay_type']:''); ?>">立即支付</a>
            <input type="hidden" id="order_id" value="<?php echo (isset($vo['order_id']) && ($vo['order_id'] !== '')?$vo['order_id']:''); ?>">
            <?php endif; if($vo['pay_status'] == '1'): ?>
            --
            <?php endif; if($vo['pay_status'] == '3'): ?>
            支付失敗
            <?php endif; ?>
        </li>
    </ul>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <div>
        <?php echo (isset($pages) && ($pages !== '')?$pages:''); ?>
    </div>
<?php endif; ?>
