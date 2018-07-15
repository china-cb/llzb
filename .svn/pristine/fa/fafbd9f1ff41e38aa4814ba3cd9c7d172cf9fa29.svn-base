<?php
namespace app\core\controller;

use app\core\model\OrderModel;

Class Order
{
    public function get_order_pay_status()
    {
        $order_id = input('post.order', null);
        empty($order_id) && wrong_return('订单id错误');
        $m = new OrderModel();
        $info = $m->get_info_by_order($order_id);
        ($info['pay_status'] == 3) && ok_return('开通成功');
        wrong_return('没有开通');
    }
}