<?php
namespace app\core\model;



use think\Exception;
use think\Model;

Class ExecModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
    //设置订单状态,type=true 按照id 默认按照订单            99
    public function set_order_status($order_id = null, $pay_status = null, $limit_status = null, $type = false)
    {
        $m_p_order = db_func('order_list_parent', 'sp_');

        if (empty($order_id) || empty($pay_status)) return false;

        if ($type == true) {
            $where = array(
                "id" => $order_id
            );
        } else {
            $where = array(
                "order_id" => $order_id
            );
        }
        if ($limit_status) {
            $where['pay_status'] = (string)$limit_status;
        }
        return $m_p_order->where($where)->update(array("pay_status" => $pay_status));
    }

    //设置父级订单的付款时间
    public function set_p_order_pay_time($order_id)
    {
        $m_p_order = db_func('order_list_parent', 'sp_');
        $time = microtime_float();
        $data = array(
            'pay_time' => $time,
        );
        $ke =  $m_p_order->where(array("order_id" => $order_id))->update($data);

        return $ke;
    }

    //获取父级订单信息根据id
    public function get_p_info_by_id($id)
    {
        return db('order_list_parent')->where(array("id" => $id))->find();
    }

    //获取父级订单信息根据order_id
    public function get_p_info_by_order_id($order_id)
    {
        return db('order_list_parent')->where(array("order_id" => $order_id))->find();
    }
    //获取充值订单内容
    public function get_charge_order_by_order_id($order_id)
    {
        $m_order = db_func('recharge', 'sp_');
        return $m_order->where(array("order_id" => $order_id))->find();
    }

    //获取充值订单内容
    public function get_record_order_by_order_id($order_id)
    {
        $m_order = db_func('buy_orders', 'sp_');
        return $m_order->where(array("order_id" => $order_id))->find();
    }

    //设置 作为子订单的
    public function set_charge_order_pay_time($order_id)
    {
        $m_p_order = db_func('recharge', 'sp_');
        $time = microtime_float();
        $data = array(
            'pay_time' => $time,
        );

        return $m_p_order->where(array("order_id" => $order_id))->update($data);
    }

    //设置套餐 作为子订单的
    public function set_record_order_pay_time($order_id)
    {
        $m_p_order = db_func('buy_orders', 'sp_');
        $time = microtime_float();
        $data = array(
            'pay_time' => $time,
        );
        return $m_p_order->where(array("order_id" => $order_id))->update($data);
    }

    /** 查询套餐信息 */
    public function get_recharge_conf($id){
        return db_func('recharge_conf','sp_')->where('id',$id)->find();
    }

    /** 查询是否正在使用套餐 */
    public function get_user_package($id){
        return db_func('user_package','sp_')
            ->where('balance','>',0)
            ->where('expire_time','>',0)
            ->where(['uid' => $id,'status' => 1])
            ->order('create_time desc')
            ->limit(1)
            ->select();
    }

    /** 添加套餐 */
    public function insert_user_package($data){
        return db_func('user_package','sp_')->insert($data);
    }
    //设置子级订单的付款时间
    public function set_c_order_pay_time($order_id)
    {
        $m_p_order = db_func('order_list', 'sp_');
        $time = microtime_float();
        $data = array(
            'pay_time' => $time,
            'pay_time_format' => microtime_format($time, 1, 'His')
        );
        return $m_p_order->where(array("order_id" => $order_id))->update($data);
    }
































}