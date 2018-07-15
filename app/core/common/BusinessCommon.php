<?php
namespace app\core\common;

use app\core\model\BusinessModel;
/**
 * 关于业务的公共逻辑,如下单,开通等
 * User: feel
 * Date: 2016/9/7
 * Time: 21:53
 */
Class BusinessCommon
{
    /**
     * 统一下单接口
     * @post int money 充值金额*
     * @post int coin 充值币额*
     * @post string pay_type 支付类型*
     * @post string q 订单来源
     * @return string order_id 返回订单id
     */
    public function union_order($post)
    {
        $money = $pay_type = $type = $package_name = $package_id =  $price_money = $package_money = null;
        extract($post);
        empty($pay_type) && wrong_return("充值类型不能为空");
        $order_id = create_order_num(); //生成全局唯一订单号
        $mid = check_login(); //获取用户ID
        //根据用户ID查询用户信息
        $m_user = new BusinessModel();
        $member_info = $m_user->get_user_info_by_id($mid);
        empty($money) && wrong_return("充值金额不能为空");
 
        if(!is_numeric($money) || floatval($money) < 0){
            wrong_return("充值金额必须是纯数字而且要大于零");
        }

        if($type == 'recharge'){
            //创建充值子订单(recharge表)
            $order_temp = array(
                "order_id" => $order_id,//充值的时候 父子同一个order_id
                "uid" => $mid,
                'description' => '用户(' . $member_info['nick_name'].')'. '充值' . $money . '元',
                "exec_data" => null,//回调执行参数
                "money" => $money,//子订单价
                'create_time' => NOW_TIME,
                'pay_status' => 0,
                'pay_type'=> $pay_type
            );
        }elseif($type == 'buy'){
            $rt = $m_user -> get_recharge_conf($package_id);
            if($rt['money'] != $money){
                wrong_return("套餐开通金额不正确");
            }
            //创建套餐子订单(buy_orders表)
            $order_temp = array(
                "order_id" => $order_id,//
                "uid" => $mid,
                "package_name" => $rt['name'],
                'package_id' => $package_id,
                "money" => $money,
                'description' => '用户(' . $member_info['nick_name'].')'. '购买' . $rt['name'] .'支付'.$money.'元',
                "exec_data" => null,//回调执行参数
                'create_time' => NOW_TIME,
                'expire_time' => NOW_TIME + 60*60*12,
                'pay_status' => 0,
                'pay_type'=> $pay_type
            );
        }else{
            $rt = $m_user -> get_recharge_conf($package_id);
            if($rt['unit_price'] != $price_money){
                wrong_return("自定义购买单价不正确");
            }
            if($money == $package_money * $price_money){
                wrong_return('支付金额不正确');
            }
            //创建套餐子订单(buy_orders表)
            $order_temp = array(
                "order_id" => $order_id,//
                "uid" => $mid,
                "package_name" => $rt['name'],
                'package_id' => $package_id,
                "money" => $money,
                'description' => '用户(' . $member_info['nick_name'].')'. '购买' . $rt['name'] .'支付'.$money.'元',
                "exec_data" => null,//回调执行参数
                'create_time' => NOW_TIME,
                'expire_time' => NOW_TIME + 60*60*12,
                'pay_status' => 0,
                'pay_type'=> $pay_type
            );
        }

        /**生成支付回调执行的参数信息START*/
        $exec_data = array(
            "TYPE" => "CHARGE",
            "EXEC_DATA" => array(
                "VALUE" => $money
            )
        );

        $token = config('TOKEN_ACCESS');//全局加密密码
        //MD5= MD5(订单ID,订单类型,执行数据,密钥)
        $exec_data["MD5"] = md5($order_id . $exec_data["TYPE"] . json_encode($exec_data["EXEC_DATA"]) . $token);
        $order_temp["exec_data"] = json_encode($exec_data);
        if($type == 'recharge'){
            $rechargeId = db_func('recharge')->insertGetId($order_temp);//充值表 作为 子订单入库
            ($rechargeId <= 0) && wrong_return("子订单入库失败");
        }else{
            $rechargeId = db_func('buy_orders')->insertGetId($order_temp);//购买表 作为 子订单入库
            ($rechargeId <= 0) && wrong_return("子订单入库失败");
        }

        //创建支付父级订单(order_list_parents)
        $close_time = config('ORDER_CLOSE_TIME');//订单结束时间，
        $order_parent_data = array(
            "order_id" => $order_id,
            "name" => $order_temp['description'],//商品名称
            "uid" => $mid,
            "num" => 1,
            "order_list" => $rechargeId,//本来是子订单的列表的
            'username' => $member_info['nick_name'],
            "buy_type" => $type,
            "price" => 0.01,
            'create_time' => NOW_TIME,
            "close_time" => NOW_TIME + (int)$close_time,//当前时间加上自定义结束时间
            'plat_form' => $pay_type,
        );

        $id = db_func('order_list_parent')->insertGetId($order_parent_data);
        if(!empty($id)){
            ok_return('success', 1, ['order' => $order_id]);
        }
        wrong_return('下单失败');
    }
}