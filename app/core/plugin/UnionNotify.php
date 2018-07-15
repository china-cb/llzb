<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/8/27
 * Time: 11:21
 */

namespace app\core\plugin;
use app\core\model\PayModel;
use think\Controller;
use think\Db;
class UnionNotify extends Controller
{
    /**
     * 支付宝回调方法
     */
    public function alipay_notify()
    {
        $info = input('param.','');
        extract($info);
        //获取签名数据
        $info_sign = empty($info['sign']) ? '' : $info['sign'];
//        if (is_array($_GET)&&count($_GET)>0) {
//            $info_sign = urldecode(str_replace(" ", "%2B", $info_sign));
//        }
        /**支付宝通知签名*/
        if ($sign_type == 'MD5') {
            /**获取参数签名*/
            $result = $this->md5_sign_verify($info, $info_sign);
        } else if ($sign_type == 'RSA') {
            /**获取参数签名*/
            $result = $this->rsa_sign($info, $info_sign);
        } else {
            log_w("支付宝签名校验失败!:" . json_encode($info));
            return (-1);
        }
        /**比较数字签名是否正确*/
        if (!$result) {
            log_w("支付宝参数:" . json_encode($info));
            log_w("验证签名结果:" . json_encode($result));
            log_w("支付宝签名参数错误!-" . $out_trade_no . '-' . $trade_status);
            return (-1);
        } else {
            log_w("支付宝验证通过!" . json_encode($result));
        }

        /**支付宝信息校验结束***************/

        /**拦截交易状态不成功的*/
        if ($trade_status !== 'TRADE_SUCCESS') {
            log_w("支付宝通知结果:交易不成功!-" . $out_trade_no . '-' . $trade_status);
            return (-1);
        }

        /**检测订单号*/
        if (empty($out_trade_no)) {
            log_w("支付宝订单号为空获取失败");
            return (-1);
        }
        /**初始化信息*/
        $order_id = $out_trade_no;//充值订单号
        $pay_type = "alipay";

        /**根据订单号获取充值订单信息*/
        $order = new PayModel();
        $info = $order->get_order_info_by_id($order_id);

        if (empty($info)) {
            log_w("充值订单信息查询失败");
            return (-1);
        }

        /**验证商品金额于交易金额是否一致*/
        if($info['price'] !== $total_fee){
            log_w("商品金额于交易金额不一致");
            return (-1);
        }
        /**校验订单状态是否为1*/
        $pay_status = $info["status"];
        if ($pay_status == "2" || $pay_status == "3") {
            log_w("订单已标记为已开通,请勿重复开通");
            return (-1);
        }
        /**标记支付成功*/
        $res = $order->sign_order_status_to_one($order_id);
        /**全部校验完毕,开始走下一步流程*/
        if($res){
            return (1);
        }else{
            return (-1);
        }
    }

    /**
     * 支付宝的签名校验函数
     * @param array $post 支付宝签名
     * @return string 签名后的值
     */
    private function md5_sign_verify($post, $info_sign)
    {
        // 验证sign
        unset($post['sign']);
        unset($post['sign_type']);
        // 升序排列数组
        $data = paraFilter($post);//删除全部空值
        $data = argSort($data);
        $str = createLinkstring($data);
        $token = "mtl3got4jzgj20iqazi2k59ec1eizli9";
        $str = trim($str, '&') . $token;
        return md5($str) === $info_sign;//验证签名是否相等
    }
    /**
     * 支付宝的RSA签名校验函数
     * @param array $post 支付宝签名
     * @param string $sign 支付宝签名
     * @return string 签名后的值
     */
    private function rsa_sign($post, $sign)
    {
        $private_key_path = $this->m_pub->get_conf('ALIPAY_PUBLIC_KEY');
//        log_w('公钥:'.$private_key_path);
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($post);
//        log_w('除去待签名参数数组中的空值和签名参数:'.json_encode($para_filter));
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
//        log_w('对待签名参数数组排序:'.json_encode($para_sort));
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);
//        log_w($prestr);
//        return rsaVerify($prestr, trim('./alipay_public_key.pem'), $sign);
        return rsaVerify($prestr, $private_key_path, $sign);
    }

    /**
     * 苹果支付类似回调  验签
     */

    public function apple_pay_like_notify($order_id,$mid,$receipt,$trade_no){
       if(empty($order_id)||empty($mid)||empty($receipt)||empty($trade_no)) exit_json(118,'缺少必要参数');

            //创建订单，使用苹果给的订单号
            // $record = db_func('Recharge_log')->where("trade_no='%s'", $trade_no)->find();
            $record =array();
            if(empty($record)){
                $data = array(
                    'uid'           => $mid,
                    'trade_no'      => $trade_no,
                    'order_id'      => $order_id,
                    'money'         => 0,
                    'recharge_time' => time(),
                    'pay_type'      => 'iap',
                );
                // M('Recharge_log')->add($data);
                log_w(json_encode($data));
            }
            // if(config('debug') == true){

            // }
            $isSandbox = false;//沙箱是测试环境，正式环境改为false
            $info = $this->getReceiptData($receipt, $isSandbox);//去苹果进行二次验证，防止收到的是伪造的数据
            log_w('info:->'.json_encode($info,JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
            return $info ;

    }


     //去苹果服务器二次验证代码
        protected function getReceiptData($receipt, $isSandbox = false) {
            if ($isSandbox) {
                $endpoint = 'https://sandbox.itunes.apple.com/verifyReceipt';//沙箱地址
            } else {
                $endpoint = 'https://buy.itunes.apple.com/verifyReceipt';//真实运营地址
            }
            $postData = json_encode(
                array('receipt-data' => $receipt)
            );
            $ch = curl_init($endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  //这两行一定要加，不加会报SSL 错误
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            $response = curl_exec($ch);
            $errno    = curl_errno($ch);
            //$errmsg   = curl_error($ch);
            curl_close($ch);
            
            if ($errno != 0) {//curl请求有错误
                log_w('苹果2验证 出错');
                return [
                    'errNo' => 1,
                    'errMsg' => '请求超时，请稍后重试',
                ];


            }else{
                $data = json_decode($response, true);
                log_w('苹果返回信息-》'.json_encode($data,JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
                if (!is_array($data)) {
                    return [
                        'errNo' => 2,
                        'errMsg' => '苹果返回数据有误，请稍后重试',
                    ];
                }
                //判断购买时候成功
                if (!isset($data['status']) || $data['status'] != 0) {
                    return [
                        'errNo' => 3,
                        'errMsg' => '购买失败',
                    ];
                }
                //返回产品的信息

                $order = $data['receipt']['in_app'][0];
                $order['errNo'] = 0;
                return $order;
            }
        }

    /**
     * 支付宝回调方法  验签
     */
    public function app_alipay_notify($data)
    {

        log_w('支付宝进来开始验签了');
        require_once("../app/lib/apiAlipay/alipay.config.php");
        require_once("../app/lib/apiAlipay/lib/alipay_notify.class.php");

        //计算得出通知验证结果

        $alipay_config['partner']	= config('ALI_PAY_PARTNER');
        $alipay_config['sign_type'] = $data['sign_type'];

        //$alipay_config 的其他参数直接放在 ../app/lib/apiAlipay/alipay.config.php  里密钥路径也是固定，各家自己还自己的密钥
        $alipayNotify = new \AlipayNotify($alipay_config);

        $post_data =get_all_input();

        $verify_result = $alipayNotify->verifyNotify();//集成验签  true  false  008800

        if($verify_result == true) log_w('支付宝验证成功'); //debug
//
//        $verify_result = true; //上面此处先绕过签名    008800
//        log_w('调试阶段，验签已经绕过。。。');

        return $verify_result;
//
/*        if($verify_result) {//验证成功
            log_w('支付宝回调验签成功');
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];

            log_w('app_alipay_notify',"【支付宝回调App】:\n".json_encode($_POST)."\n");
            if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

                $order = $this->order_model->get_order_info($out_trade_no);

                if($order['TradeStatus'] != 'TRADE_FINISHED' && $order['TradeStatus'] != 'TRADE_SUCCESS'){
                    $data = array('TradeStatus'=>$trade_status,'TradeNo'=>$trade_no,'PayTime'=>time(),'PayType'=>'alipay');
                    $this->order_model->update_order_info($out_trade_no,$data);
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success";		//请不要修改或删除
        } else {
            log_w("支付宝签名校验失败!:" . json_encode($post_data));
            echo "fail";
        }*/
    }


    /**
     * 微信APP支付异步回调接口
     * input 流
     * return  code msg
     */
    public function app_wxpay_notify(){

        //引入SDK
        import("app.lib.Wxpay.WxPayApi",null,'.php');
        //返回结果
        
        //RAW
        $raw_post_data = file_get_contents('php://input', 'r');
        Db::table('log_notify')->insert([
            'order_id'=>'微信回调：raw',
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>$raw_post_data
        ]);
        //微信签名  格式化
        $notify = new \WxPayNotify();
        $notify->FromXml($raw_post_data);//格式化
        $result = $notify->GetValues();
        Db::table('log_notify')->insert([
            'order_id'=>'微信回调解析：result'.$result['out_trade_no'],
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>json_encode($result)
        ]);
        $order_id =$result['out_trade_no'];
        //接受回调数据，已经初步判断
        $key = config('WXPAY_APP_KEY');//带包请求请另做处理

        $xml_fail = '';
        if($notify->SetSign($key)!=$notify->GetSign()){
            $xml_fail = $this->xml_notify_return($order_id,1,'签名无效');
            //签名无效
        }
        if($notify->GetReturn_code()!='SUCCESS'){
            $xml_fail = $this->xml_notify_return($order_id,1,'1');
            //返回错误
        }
        if($result['result_code']!='SUCCESS'){
            $xml_fail = $this->xml_notify_return($order_id,1,'2');
            //业务错误
        }
        if($xml_fail){//失败
            log_w('微信回调UNIONnotify.php 367上方错误');
            return array('code'=>1,'xml'=>$xml_fail);
        }else{        //无异常就返回 数据 ，进行数据 处理 然后
            return array('code'=>0,'data'=>$result);
        }
    }

    /**
     * 微信 应答封装 xml
     * code 1 ='FAIL' 0=SUCCESS msg=''
     * RETURN xml
     */
    public function xml_notify_return($order_id,$code=0,$msg='正确返回'){
        import("app.lib.Wxpay.WxPayApi",null,'.php');
        $response_result = new \WxPayNotifyReply();//
            if($code == 0){
                $response_result->SetReturn_code('SUCCESS');
            }else{
                $response_result->SetReturn_code('FAIL');
            }

            $response_result->SetReturn_msg($msg);
            $xml_info = $response_result->ToXml();

        $temp =Db::table('log_notify')->insert([
            'order_id'=>'微信回调return:'.$order_id,
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>$xml_info
        ]);
        log_w('微信回调:'.$order_id.$msg);
        return $xml_info;
    }

    /**
     * ALI  应答封装
     * code 1 ='FAIL' 0=SUCCESS msg=''
     * RETURN xml
     */
    public function ALI_notify_return($order_id,$code=0,$msg='正确返回'){
        if($code == 0){
            $return_info = 'success';
        }else{
            $return_info ='fail';
        }

        $temp =Db::table('log_notify')->insert([
            'order_id'=>'支付宝return:'.$order_id,
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>$return_info.'--'.$msg
        ]);
        log_w('支付宝回调:'.$order_id.$msg);
        die($return_info);
    }


    /**
     * apple_pay  应答封装
     * code 1 ='FAIL' 0=SUCCESS msg=''
     * RETURN xml
     */
    public function Apple_notify_return($order_id,$code=0,$msg='正确返回'){

        if($code == 0){
            $return_info = 'success';
        }else{
            $return_info ='fail';
        }
        $temp =Db::table('log_notify')->insert([
            'order_id'=>'APPLE_PAY-return:'.$order_id,
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>$return_info.'--'.$msg
        ]);
        log_w('APPLE_PAY回调:'.$order_id.$msg);
        exit_json($code,$msg);
    }

    /**
     * 微信支付异步回调接口
     */
    public function wxpay_notify($result,$GetValues,$MakeSign,$GetSign,$GetReturn_code){
        Config('default_return_type','xml');
        //引入SDK
        import("app.lib.Wxpay.WxPayApi",null,'.php');
        //微信回调基础类
        $response_result = new \WxPayNotifyReply();
        //RAW
        $raw_post_data = file_get_contents('php://input', 'r');
        $m = db_func('notify','log_');
        $m->insert([
            'order_id'=>'微信回调：raw',
            'create_time'=>date('Y-m-d H:i:s'),
            'log'=>$raw_post_data
        ]);
        //微信签名
        $notify = new \WxPayNotify();
        $notify->FromXml($raw_post_data);
        $m->insert([
            'order_id'=>'微信回调：result',
            'create_time'=>date('Y-m-d H:i:s'),
//            'log'=>json_encode($notify->GetValues())
            'log'=>json_encode($GetValues)
        ]);
//        /** 获取微信回调的参数 */
//        $result = $notify->GetValues();
        //设置交易类型
        if(array_key_exists('trade_type',$result) &&  $result['trade_type']=='NATIVE'){//判断交易类型
            define('WXPAY_CONF_PREFIX','wxpay_pc_');
        }else{
            define('WXPAY_CONF_PREFIX','wxpay_app_');
        }
        //签名密钥检测
        $key = input('param.key');
        if($MakeSign!=$GetSign){
            $response_result->SetReturn_code('FAIL');
            $response_result->SetReturn_msg('签名无效');
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
            //签名无效
        }
        //获取错误码 FAIL 或者 SUCCESS
        if($GetReturn_code!='SUCCESS'){
            $response_result->SetReturn_code('FAIL');//设置错误码 FAIL 或者 SUCCESS
            $response_result->SetReturn_msg('1'); //设置错误信息
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
            //返回错误
        }
        if($result['result_code']!='SUCCESS'){
            $response_result->SetReturn_code('FAIL');
            $response_result->SetReturn_msg('2');
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
            //业务错误
        }

        /**初始化信息*/
        $order_id = $result['out_trade_no'];//订单号
        $pay_type = "wxpay";//支付类型

        /** 根据订单号获取订单信息 */
        $order = new PayModel();
        $info = $order->get_order_info_by_id($order_id);
        /** 校验订单信息是否存在 */
        if (empty($info)) {
            $response_result->SetReturn_code('FAIL');
            $response_result->SetReturn_msg('无效订单');
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
        }
        /**校验订单状态是否为1*/
        $pay_status = $info["status"];
        if ($pay_status == "1") {
            $response_result->SetReturn_code('SUCCESS');
            $response_result->SetReturn_msg('重复开通');
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
        }
        /**校验商品订单金额与交易回调金额是否一致*/
        if($info['money'] !== $result['cash_fee']){
            $response_result->SetReturn_code('FAIL');
            $response_result->SetReturn_msg('商品订单金额与交易回调金额不一致');
            return ['code'=>-1,'msg'=>$response_result->ToXml()];
        }
        /**标记支付成功*/
        $res = $order->sign_order_status_to_one($order_id);
        /**全部校验完毕,开始走下一步流程*/
        if($res){
            return (['code'=>1,'msg'=>'订单标记成功']);
        }else{
            return (['code'=>-1,'msg'=>'订单标记失败']);
        }

    }

    /** 爱贝支付回调接口 */
    public function aipay_notify($post){
        $aipay = new UnionPay();
        $platpkey = config('AIPAY_PLAT_KEY');
        if (empty($post)) {
            return (['code'=>'-1']);
        } else {
            $transdata = $post['transdata'];
            if (stripos("%22", $transdata)) { //判断接收到的数据是否做过 Urldecode处理，如果没有处理则对数据进行Urldecode处理
                $post = array_map('urldecode', $post);
            }
            $respData = 'transdata=' . $post['transdata'] . '&sign=' . $post['sign'] . '&signtype=' . $post['signtype'];//把数据组装成验签函数要求的参数格式
            if (!$aipay->parseResp($respData, $platpkey, $respJson)) {
                //验签失败
               return (1);
            } else {
//                //验签成功
//                echo "success"."\n";
                //以下是 验签通过之后 对数据的解析。
                $transdata = $post['transdata'];
                $arr = json_decode($transdata);
                $data['cporderid'] = $arr->cporderid;

                /**检测订单号*/
                if (empty($data['cporderid'])) {
                    log_w("爱贝订单号为空获取失败");
                    return (['code'=>'-1']);
                }
                /**根据订单号获取充值订单信息*/
                $order = new PayModel();
                $info = $order->get_order_info_by_id($data['cporderid']);
                if (empty($info)) {
                    log_w("订单信息查询失败");
                    return (['code'=>'-1']);
                }
                /**校验订单状态是否为1*/
                if ($info['status'] == "1") {
                    log_w("订单已标记为已开通,请勿重复开通");
                    return (['code'=>'-1']);
                }
                /**标记支付成功*/
                $res = $order->sign_order_status_to_one($data['cporderid']);
                /**全部校验完毕,开始走下一步流程*/
                if($res){
                    return (['code'=>'1','order_id'=>$data['cporderid']]);
                }else{
                    return (['code'=>'-1']);
                }
            }
        }
    }





}