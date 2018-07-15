<?php
namespace app\core\model;

Class OrderModel
{
    //根据订单号获取订单信息
    public function get_info_by_order($order)
    {
        return db_func('order_list_parent','sp_')->where('order_id',$order)->find();
    }
}