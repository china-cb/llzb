<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/6
 * Time: 16:58
 */
namespace app\core\model;
use app\core\plugin\UnionNotify;
use PHPMailer\PHPMailer\Exception;
use think\Db;
use think\Model;
class PaymentModel extends Model
{
    /** 支付宝充值回调并改变状态 */
    public function ali_notify()
    {
        $data = input('post.');
        log_w('app_alipay_notify'."【支付宝回调App】post:\n".json_encode($data)."\n");
        $out_trade_no = $data['out_trade_no'];//订单id
        $notify = new UnionNotify();
        $rt = $notify->app_alipay_notify($data);//验签  返回true  false
        if($rt){
            log_w('订单号：'.$out_trade_no.'支付宝回调验签成功后');
            //交易状态
            $trade_status = $data['trade_status'];
            log_w('app_alipay_notify'."【支付宝回调App】:\n".json_encode($data)."\n");

            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                /**检测订单号*/
                if (empty($out_trade_no)) {
                    log_w("支付宝订单号为空获取失败");
                    die("SUCCESS");
                }
                /**初始化信息*/
                $order_id = $out_trade_no;

                /**获取父级订单信息*/
                $order_m = new PayModel();
                $info = $order_m->get_order_info_by_id($order_id);
                if (empty($info)) {
                    return $notify->ALI_notify_return($order_id,1,'无效订单');
                }
                /**校验订单状态是否为1*/
                $pay_status = $info["pay_status"];
                if ($pay_status == "3") {
                    return $notify->ALI_notify_return($order_id,0,'重复请求');
                }
                /**标记支付成功*/
                $m_exec = new ExecModel();
                $res = $m_exec->set_order_status($order_id, "2", "1");

                try{
                    if($res){
                        $spread_result = $this->_doPayResult($order_id);//code =  value=
                        if($spread_result['code'] != '1') {
                            throw new Exception('出现错误，请查看上方日志');
                        }
                        //至此 业务完成
                        $temp = $notify->ALI_notify_return($order_id,0,'回调完成');
                        return $temp;
                    }else{
                        $spread_result = $this->_doPayResult($order_id);//code =  value=
                        if($spread_result['code'] != '1') {
                            throw new Exception('出现错误，请查看上方日志');
                        }
                        //至此 业务完成
                        $temp = $notify->ALI_notify_return($order_id,0,'回调完成');
                        return $temp;
                    }
                }catch(Exception $ex){
                    log_w("回调执行dopayreqult，返回非 1：".$ex->getMessage());
                }

            }else{
                /**拦截交易状态不成功的*/
                log_w("支付宝通知结果:交易不成功!-order_id:" . $out_trade_no . '-trade_status:' . $trade_status);
                die("SUCCESS");
            }

        }else{
            log_w('订单号：'.$out_trade_no.'支付宝回调验签失败');
            die('FAIL');
        }
    }
    //微信充值回调并改变状态
    public function notify()
    {   
        //调通用接口 获取数据
        $notify = new UnionNotify();
        $rt = $notify->app_wxpay_notify();//验签
        if($rt['code']==0){//xml预备成功  做业务处理
            $result = $rt['data'];

            /**初始化信息*/
            $order_id = $result['out_trade_no'];

            /**获取父级订单信息*/
            $order_m = new PayModel();
            $info = $order_m->get_order_info_by_id($order_id);
            if (empty($info)) {
                return $notify->xml_notify_return($order_id,1,'无效订单');
            }
            /**校验订单状态是否为1*/
            $pay_status = $info["pay_status"];
            if ($pay_status == "3") {
                return $notify->xml_notify_return($order_id,0,'重复请求');
            }
            /**标记支付成功*/
            $m_exec = new ExecModel();

            $res = $m_exec->set_order_status($order_id, "2", "1");
            try{
                if($res){
                    $spread_result = $this->_doPayResult($order_id);//code =  value=
                    if($spread_result['code'] != '1') {
                        throw new Exception('出现错误，请查看上方日志');
                    }
                    //至此 业务完成
                    $temp = $notify->xml_notify_return($order_id,0,'回调完成');
                    return $temp;
                }else{
                    $spread_result = $this->_doPayResult($order_id);//code =  value=
                    if($spread_result['code'] != '1') {
                        throw new Exception('出现错误，请查看上方日志');
                    }
                    //至此 业务完成
                    $temp = $notify->xml_notify_return($order_id,0,'回调完成');
                    return $temp;
                }
            }catch(Exception $ex){
                log_w("回调执行dopayreqult，返回非 1：".$ex->getMessage());
            }

        }else{
            return ($rt['xml']);
        }
    }

    //执行操作
    private function _doPayResult($order_id)
    {
        $order_m = new PayModel();
        $info = $order_m->get_order_info_by_id($order_id);
        if (empty($info)) {
            return rt("-100", "", "开通业务-订单信息获取失败:" . $order_id);
        }
        /**判断订单类型:recharge充值,buy 购买*/
        $buy_type = $info['buy_type'];
        if (!in_array($buy_type, array("buy", "recharge","custom"))) {
            return rt("-100", "order type error", "开通业务-订单类型不正确:" . $order_id . '-' . $buy_type);
        }
        /**业务状态*/
        $pay_status = $info["pay_status"];
        if ($pay_status !== '2') {
            return rt("-100", "order type error1", "开通业务-订单状态不为2:" . $order_id . '-' . $pay_status);
        }

        //根据支付类型  执行 子级操作 和 相关数据处理
        switch ($buy_type) {
            case "buy":
                //开通业务
                $r_1 = $this->open($order_id);
                break;
            case "custom":
                //开通业务
                $r_1 = $this->open($order_id);
                break;
            case "recharge":
                //充值
                $r_1 = $this->charge($order_id);// 仅返回 code -100 或者 1
                break;
            default:
                return rt("-100", "", "开通业务-订单类型错误1:" . $order_id . '-' . $pay_status);
        }

        if (empty($r_1["code"])) return rt("-100", "返回值错误", json_encode($r_1["code"]));//008800

        if ($r_1["code"] == '1') {
            return rt("1", "success", $order_id ."：开通成功");
        } else if (!is_array($r_1)) {
            return rt($r_1["code"], "failed", "开通返回值不是数组返回值错误" . json_encode($r_1));
        } else {
            return rt($r_1["code"], "failed", 'this->charge返回信息:'.json_encode($r_1));
        }
    }
    //执行充值
    public function charge($order_id)
    {
        $recharge = db_func('recharge')->where('order_id', $order_id)->find();
        if (empty($recharge)) {
            return rt("-100", "", '充值信息不存在');
        }
        $m_exec = new ExecModel();
        $info = $m_exec->get_p_info_by_order_id($order_id);
        //子订单信息
        $c_info = $m_exec->get_charge_order_by_order_id($order_id);
        if (empty($c_info)) {
            return rt("-100", "", '充值子订单获取失败');
        }
        //订单执行数据
        $exec_data = json_decode($c_info['exec_data'], true);
        if (empty($exec_data)) {
            return rt("-100", "", "充值子订单执行信息获取失败");
        }
        //余额执行充值虚拟币
        $money = $exec_data["EXEC_DATA"]["VALUE"];
        if (is_numeric($money) && floatval($money) > 0) {
            /**
             * 尝试将充值所在父级订单 改成  开通完成
             */
            log_w('开始执行');
            Db::startTrans();
            try {
                $m_exec = new ExecModel();
                //设置父级订单为3 已经开通
                $k1 = $m_exec->set_order_status($order_id, "3", "2");
                if (!$k1) throw new Exception('order_id:' . $order_id . '尝试更新父级为3状态出错');
                //更新父级订单支付时间***
                $k2 = $m_exec->set_p_order_pay_time($order_id);
                if (!$k2) throw new Exception('order_id:' . $order_id . '尝试更新父级支付时间出错');

                if ($info['status'] != 1) {//1代表order 正常
                    throw new Exception('订单状态已经失效,order_id:' . $order_id);
                }

                if ($recharge['pay_status'] == 1) { //1代表已经支付
                    throw new Exception('该充值列状态' . $recharge['pay_status'] . '已经不是待支付状态了order_id:' . $order_id);
                }
                $upData = array(
                    'pay_status' => 1,
                    'update_time' => NOW_TIME,
                );
                
                $k3 = db_func('recharge')->where('order_id', $order_id)->update($upData); //充值表支付状态变为1
                if (!$k3) throw new Exception('order_id:' . $order_id . '尝试更新充值表支付状态变为1出错');
//写入子订单充值时间
                $k4 = $m_exec->set_charge_order_pay_time($c_info['order_id']);
                if (!$k4) throw new Exception('order_id:' . $order_id . '尝试更新充值表支付时间出错');

                $old_user_info = db_func('member')->where('member_id', $recharge['uid'])->find();
                log_w($recharge['money']);
                /*********************************后期需要可以插入充值订单等业务***************************************/
                $shod_coin = $old_user_info['balance'] + $recharge['money'];
                log_w($shod_coin);
                
                $r_1 = db_func('member')->where('member_id', $recharge['uid'])->setField('balance', $shod_coin);//改变用户金额

                $new_user_info = db_func('member')->where('member_id', $info['uid'])->find();

                $check = ($shod_coin == $new_user_info['balance']);
                if ($check && $r_1 != false) {
                    $charge_log = new LogapiModel();
                    Db::table('sp_order_list_parent')->where(array("order_id" => $order_id))->update(array("pay_time" => time()));//订单改变时间
                } else {
                    throw new Exception("$order_id.'充值失败,花费金额：'.$money");
                }
                Db::commit();
                return rt("1", "", $order_id . '充值成功,花费金额：' . $money);
            } catch (Exception $e) {
                log_w('539有异常');
                // 回滚事务
                $charge_log = new LogapiModel();
                if (isset($old_user_info) && isset($new_user_info))
                    $charge_log->record($old_user_info, $new_user_info, 1, 0);//2表示充成虚拟币 0失败
                Db::rollback();
 
                $msg = $e->getMessage();
                //标记充值异常
                $upData = array(
                    'pay_status' => 2,
                    'update_time' => NOW_TIME,
                );
                $ktemp = db_func('recharge')->where('order_id', $order_id)->update($upData); //充值表支付状态变为2 充值故障
                if (!$ktemp) $msg .= '，且尝试将充值表支付状态改为支付障碍时出错！';
                return rt('-100', '', $msg);
            }
        } else {
            return rt("-100", "", '返回解析支付金额非法');

        }
    }
    public function open($order_id){
       $list = db_func('buy_orders')->where('order_id',$order_id)->find();
        if (empty($list)) {
            return rt("-100", "", '套餐信息不存在');
        }
        $m_exec = new ExecModel();
        $info = $m_exec->get_p_info_by_order_id($order_id);
        //子订单信息
        $c_info = $m_exec->get_record_order_by_order_id($order_id);
        if (empty($c_info)) {
            return rt("-100", "", '充值子订单获取失败');
        }
        //订单执行数据
        $exec_data = json_decode($c_info['exec_data'], true);
        if (empty($exec_data)) {
            return rt("-100", "", "充值子订单执行信息获取失败");
        }
        log_w('套餐开始写入用户表');
        Db::startTrans();
        try{
            $m_exec = new ExecModel();
            //设置父级订单为3 已经开通
            $k1 = $m_exec->set_order_status($order_id, "3", "2");
            if (!$k1) throw new Exception('order_id:' . $order_id . '尝试更新父级为3状态出错');
            //更新父级订单支付时间***
            $k2 = $m_exec->set_p_order_pay_time($order_id);
            if (!$k2) throw new Exception('order_id:' . $order_id . '尝试更新父级支付时间出错');

            if ($info['status'] != 1) {//1代表order 正常
                throw new Exception('订单状态已经失效,order_id:' . $order_id);
            }

            if ($list['pay_status'] == 1) { //1代表已经支付
                throw new Exception('该充值列状态' . $list['pay_status'] . '已经不是待支付状态了order_id:' . $order_id);
            }
            $upData = array(
                'pay_status' => 1,
                'update_time' => NOW_TIME,
            );

            $k3 = db_func('buy_orders')->where('order_id', $order_id)->update($upData); //充值表支付状态变为1
            if (!$k3) throw new Exception('order_id:' . $order_id . '尝试更新套餐表支付状态变为1出错');
            //写入子订单充值时间
            $k4 = $m_exec->set_record_order_pay_time($c_info['order_id']);
            if (!$k4) throw new Exception('order_id:' . $order_id . '尝试更新套餐表支付时间出错');

            $k5 = $m_exec->get_recharge_conf($list['package_id']);
            if(!$k5 && $k5['status'] == -1) throw new Exception('order_id:' . $order_id . '开通套餐不可用');
            $k6 = $m_exec->get_user_package($list['uid']);

            if($list['package_id'] == 14){
                log_w('1111111111');

                $data = [
                    'package_id' => $list['package_id'],
                    'unit_price' => $k5['unit_price'],
                    'package_all' => $c_info['money']/$k5['unit_price'],
                    'balance' => $c_info['money']/$k5['unit_price'],
                    'create_time' => NOW_TIME,
                    'type' => $k5['name'],
                    'uid' => $list['uid']
                ];
            }else{
                log_w('222222222222');

                $data = [
                    'package_id' => $list['package_id'],
                    'unit_price' => $k5['unit_price'],
                    'package_all' => $k5['all_time'],
                    'balance' => $k5['all_time'],
                    'create_time' => NOW_TIME,
                    'type' => $k5['name'],
                    'uid' => $list['uid']
                ];
            }

            if(empty($k6)){
                $data['status'] = 1;
                if($list['package_id'] != 14){
                    $data['expire_time'] = NOW_TIME + 60*60*24*365;
                    $k7  = $m_exec->insert_user_package($data);
                }else{
                    $k7  = $m_exec->insert_user_package($data);
                }
            }else{
                $data['status'] = -1;
                if($list['package_id'] != 14){
                    $data['expire_time'] = NOW_TIME + 60*60*24*365;
                    $k7  = $m_exec->insert_user_package($data);
                }else{
                    $k7  = $m_exec->insert_user_package($data);
                }
            }
            
            if(empty($k7)) throw new Exception('order_id:' . $order_id . '开通套餐失败');

            $k9 = db_func('order_list_parent','sp_')->where(array("order_id" => $order_id))->update(array("pay_time" => time()));//订单改变时间
            if($k9 == 0){
                log_w('订单改变时间失败');
                throw new Exception('order_id:' . $order_id . '订单改变时间失败');
            }
            log_w('333333333333333333333');
            Db::commit();
            return rt("1", "", $order_id . '套餐开通成功,花费金额：' . $list['money']);
        } catch (Exception $e){
            log_w('539有异常');
            // 回滚事务
            $charge_log = new LogapiModel();
            if (isset($old_user_info) && isset($new_user_info))
                $charge_log->record($old_user_info, $new_user_info, 2, 0);//1充值 0失败
            Db::rollback();

            $msg = $e->getMessage();
            log_w($msg);
            //标记充值异常
            $upData = array(
                'pay_status' => 2,
                'update_time' => NOW_TIME,
            );
            $ktemp = db_func('buy_orders')->where('order_id', $order_id)->update($upData); //充值表支付状态变为2 充值故障
            if (!$ktemp) $msg .= '，且尝试将充值表支付状态改为支付障碍时出错！';
            return rt('-100', '', $msg);
        }
    }
}
