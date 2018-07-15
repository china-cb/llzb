<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/8/27
 * Time: 10:35
 */

namespace app\core\plugin;
use app\pay\model\PublicModel;
use app\core\model\PayModel;
use think\Controller;
use think\Db;
use think\Url;

class UnionPay extends Controller
{
    /**
     * 支付接口入口
     * @order_id request 订单id
     * @timestamp request 时间戳
     * @sign request 签名
     */
    public function alipay($order_id = null,$timestamp = null,$sign = null)
    {
        //鉴定权限签名
        $r = auth($order_id, $timestamp, $sign);
        if ($r["code"] !== "1") {
            if (IS_AJAX) {
                die_result('-100', "本请求失效或超时,请重新发起请求" . $sign);
            } else {
                $this->redirect('/');
            }
        }
        $this->construct_param_alipay($order_id);
        die($this->fetch('alipay/go_alipay'));
    }

    /**
     * 构建提交参数信息
     */
    public function construct_param_alipay($order_id){


        //根据订单号获取订单信息
        $info = db('order_list')->where('order_id',$order_id)->find();
        $price = empty(floatval($info["price"])) ? 100 : round(floatval($info["price"]), 2);

        (!is_array($info) || empty($info)) && die_result("-100", "提交参数不正确");
        extract($info);

        //获取支付宝必要的参数配置
        $conf_alipay = [
            'partner' => config('BKG_ALIPAY_PARTNER'),
            'notify_url' => config('BKG_ALIPAY_NOTIFY_URL'),
            'return_url' => config('BKG_ALIPAY_RETURN_URL'),
        ];

        //构造要请求的参数数组，无需改动
        $parameter = array(
            //基本参数

            "service" => 'create_direct_pay_by_user',//pc端支付宝接口名称
            "partner" => '2088122812964810',//合作者身份ID

            "notify_url" => "http://ip.mengdie.com/index.php/core/UnionNotify/alipay_notify",//支付宝异步通知接口，/pay/notify/alipay
            "return_url" => "http://ip.mengdie.com/index.php/wap/alipay/return_url",
            "_input_charset" => "UTF-8",//字符集编码,utf-8

            //业务参数
            "out_trade_no" => $order_id,//商户网站唯一订单号****
//            "subject" => $info['subject'], //商品名称
            "subject" => "天元测试购买",
            "payment_type" => "1",//只支持取值为1（商品购买）
            "total_fee" => empty($price) ? "10000.00" : $price,//交易金额精确到小数点后两位。****
//            "seller_id" => $conf_alipay['ALIPAY_PARTNER'],//卖家支付宝用户号****
//            "seller_email" => $conf_alipay['ALIPAY_SELLER_EMAIL'],//卖家支付宝账号****
//            "seller_account_name" => $conf_alipay['ALIPAY_SELLER_EMAIL'],//卖家别名支付宝账号****
            "seller_id" => 'ali@ttruanjian.com',//卖家支付宝账号
//            "show_url" => 'www.baidu.com',
//            "body" => '',
            "it_b_pay" =>'2h',//超时时间
//            "qr_pay_mode" => empty($qr_pay_mode) ? '3' : $this->m_pub->$this->get_conf('QR_PAY_MODE'),//扫码支付方式
        );

        if (strtolower(Config('OPEN_TEST_ENV')) == 'true') {
            $parameter['total_fee'] = '0.01';
        }

        //建立请求
        $url = $this->create_pay_url($parameter); //生成付款链接的url
        $this->go_alipay($url); //跳转url

    }

    /**跳转到支付宝*/
    private function go_alipay($url)
    {
        $data = explode("?", $url);
        $url = $data[0];
        $param = $data[1];

        //构造form表单的数组
        $param = explode("&", $param);
        $param_const = array();
        foreach ($param as $k => $v) {
            $arr = explode("=", $v);
            $param_const[$arr[0]] = $arr[1];
        }

        $this->assign("url", $url);
        $this->assign("list", $param_const);
//        die($this->fetch('form_submit'));
    }

    /**md5加密签名参数*/
    private function md5_sign($parameter)
    {
        //获取支付宝必要的参数配置
        $conf_alipay = [
            'md5_token' => config('ALIPAY_MD5_TOKEN'),
        ];
        $data = paraFilter($parameter);//除去数组中的空值和签名参数
        $data = argSort($data);//对数组排序,按照第一个字符的键值ASCII码递增排序（字母升序排序）
        $str = createLinkstring($data);//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $str = trim($str, '&') . "mtl3got4jzgj20iqazi2k59ec1eizli9";//尾部加上 MD5签名密钥
//        $str = trim($str, '&') . $conf_alipay['md5_alipay'];//尾部加上 MD5签名密钥
        $rt = array(
            'param' => $data,
            'sign' => md5($str)
        );
        return $rt;
    }

    /**生成付款链接*/
    private function create_pay_url($parameter)
    {
        $arr = $this->md5_sign($parameter);//md5加密签名参数

        $data = $arr["param"];//没签名之前的参数
        $data["sign"] = $arr['sign'];//签名之后的参数
        $data['sign_type'] = "MD5";//支付宝签名方式(MD5)
        // 升序排列数组
        argSort($data);
        $url = "https://mapi.alipay.com/gateway.do?" . createLinkstring($data);//支付宝HTTPS形式消息验证地址+把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        return $url;
    }

    /**
     * 微信支付接口
     * @order_id request 订单id
     * @timestamp request 时间戳
     * @sign request 签名
     */
    public function wxpay($order_id = null,$timestamp = null,$sign = null,$params = array())
    {


        //鉴定权限签名
        $r = auth($order_id, $timestamp, $sign);

        if($r["code"]!=="1"){
            if(IS_AJAX){
                die_result('-100',"本请求失效或超时,请重新发起请求".$sign);
            }else{
                $this->redirect('/');
            }
        }
//        $conf_wxpay = [
//            'appid' => config('BKG_wxpay_APPID'),
//            'mchid' => config('BKG_wxpay_MCHID'),
//            'notify_url' => config('BKG_wxpay_NOTIFY_URL'),
//        ];
        //微信统一订单
        import("app.lib.Wxpay.WxPayApi",null,'.php');

//        //根据订单号查询订单信息
//        $info = db("order_list")->where("order_id",$order_id)->find();
//        (!is_array($info) || empty($info)) && die_result("-100", "提交参数不正确");

        $order = new \WxPayUnifiedOrder();
//        $order->SetAppid($conf_wxpay['appid']);
//        $order->SetMch_id($conf_wxpay['mchid']);

        $order->SetAppid('wx04a6e7de38e51da9');
        $order->SetMch_id('1330555801');

        //构造微信下订单参数
        //$out_trade_no = date('YmdHis').rand(100000,999999);
        $order->SetOut_trade_no($order_id);   //商户订单号
//        $order->SetBody($info['subject']);    //商品描述
        $order->SetBody("沃田测试商品描述");    //商品描述
//        $recharge_money = floatval($info['money'])*100;// 总金额,最小单位为分
        $recharge_money = floatval(0.01)*100;// 总金额,最小单位为分
        if(strtolower(Config('OPEN_TEST_ENV'))=='true'){
            $recharge_money = 1;
        }
        $order->SetTotal_fee($recharge_money);  // 总金额
        $order->SetTrade_type('NATIVE');   //交易类型,NATIVE为扫码支付方式,JSAPI为公众号支付
        $order->SetProduct_id($order_id);  //此id为二维码中包含的商品ID，商户自行定义
//        $order->SetNotify_url($conf_wxpay['notify_url']);   //设置接收微信支付异步通知回调地址
        $order->SetNotify_url(url('pay/core/notify'));   //设置接收微信支付异步通知回调地址
//        dump($order);
        $wxpai = new \WxPayApi();
        //统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
        $result = $wxpai->unifiedOrder($order);
        if($result){
            if(array_key_exists('return_code',$result) && $result['return_code']=='SUCCESS'){
                if(array_key_exists('result_code',$result) && $result['result_code']=='SUCCESS'){
//                    $pay_money =floatval($info['money'])*100;
                    $pay_money =floatval(0.01)*100;
                    if(strtolower(Config('OPEN_TEST_ENV'))=='true'){
                        $pay_money = 0.01;
                    }
                    return $this->redirect(url('admin/task/charge_wxscan',['code'=>base64_encode(serialize([$result['code_url'],$order_id,$pay_money]))]));
                }else{
                    echo $result['err_code'].':'.$result['err_code_des'];
                }
            }else{
                echo $result['return_msg'];
            }
        }
    }

    /**
     * 业务建立后传参进来，进行支付签名
     * @param null $order_id
     * @param null $timestamp
     * @param null $sign
     * @param array $params
     */
    public function app_alipay($order_id = null,$timestamp = null ,$sign = null ,$params = array())
    {
        //此处如果需要使用配置 1，后台配置 2 $params 去除该字段 。
        $conf_alipay = [
            'alipay_private_key' => config('ALIPAY_private_key_PATH'),//后台设置
            'alipay_public_key' => config('ALIPAY_public_key_PATH'),//后台设置
            'partner' => config('ALIPAY_partner'),//使用者ID
            'notify_url' => config('BKG_alipay_NOTIFY_URL'),//后台设置
            'seller_id' => config('ALIPAY_SELLER_ID')//
            //除了订单 其他都可以配  /
        ];

        //根据订单号查询订单信息
        $info = db("order_list_parent")->where("order_id",$order_id)->find();
        (!is_array($info) || empty($info)) && die_result("-100", "提交参数不正确");

        //商号id
        if(!empty($params['partner'])){
            $sign_arr['partner']= $params['partner'];
        }else{
            $sign_arr['partner']= $conf_alipay['partner'];
        }
        //支付宝
        if(!empty($params['seller_id'])){
            $sign_arr['seller_id']= $params['seller_id'];
        }else{
            $sign_arr['seller_id']= $conf_alipay['seller_id'];
        }
        //订单号
        if(!empty($params['trade_no'])){
            $sign_arr['out_trade_no'] =$params['trade_no'];
        }else{
            $sign_arr['out_trade_no'] =$order_id;
        }
        //介绍
        if(!empty($params['order_desc'])){
            $sign_arr['subject']= $params['order_desc'];
        }else{
            $sign_arr['subject']= $info['name'];
        }
        //body
        $sign_arr['body'] ='this is BODY';//
        //金额
        $recharge_money = floatval($info['price']);// 总金额
        if(config('app_debug') == 'true' && ENVIRONMENT == 'develop'){
            $recharge_money = 0.01;
        }
        $sign_arr['total_fee'] = $recharge_money;  // 总金额

        //设置接收支付异步通知回调地址  传入 就用 传入 的 ，不然就用 配置项中的 通用

        if(!empty($params['notify_url'])){
            $sign_arr['notify_url']= Url($params['notify_url'], null, true, true);
        }else{
            $sign_arr['notify_url']= Url($conf_alipay['notify_url'], null, true, true);
        }
        //
        $sign_arr['service'] ='mobile.securitypay.pay';//
        //
        $sign_arr['payment_type'] =1;//
        //
        $sign_arr['_input_charset'] ='utf-8';//
        //
        $sign_arr['it_b_pay'] ='30m';//
        $sign_arr['show_url'] ='m.alipay.com';//

        $str = '';


        foreach ($sign_arr as $key => $value) {
            $str .= $key . '="' . $value . '"&';
        }
        $res_str = substr($str, 0, -1);

        //密钥路径
        if(!empty($params['alipay_private_key'])){
           $private_key_path= $params['alipay_private_key'];
        }else{
           $private_key_path= $conf_alipay['alipay_private_key'];//此处写死，需要更换 008800
        }

        $sign = urlencode(rsaSign($res_str,$private_key_path));


        $res_str = stripslashes($res_str);

        $pay_info = $res_str.'&sign="'.$sign.'"&sign_type="RSA"';

        exit_json(0,'支付签名成功',$data=array('pay_info'=>$pay_info));

    }


    /**
     * 业务建立后传参进来，进行支付签名
     * @param null $order_id
     * @param null $timestamp
     * @param null $sign
     * @param array $params
     * @throws \WxPayException
     */
    public function app_wxpay($order_id = null,$timestamp = null,$sign = null,$params = array())
    {
        //注意!!!!!!!!!  此处 用的是 $params
        $conf_wxpay = [
            'appid' => config('wxpay_app_APPID'),
            'mchid' => config('wxpay_app_MCHID'),
            'key' => config('wxpay_app_key'),
            'notify_url' => config('BKG_wxpay_NOTIFY_URL'),//后台设置
        ];
        //微信统一订单
        import("app.lib.Wxpay.WxPayApi",null,'.php');


       //根据订单号查询订单信息
        $info = db("order_list_parent")->where("order_id",$order_id)->find();

        (!is_array($info) || empty($info)) && die_result("-100", "提交参数不正确");

        $order = new \WxPayUnifiedOrder();
        $order->SetAppid($conf_wxpay['appid']);
        $order->SetMch_id($conf_wxpay['mchid']);

        //构造微信下订单参数

        if(!empty($params['trade_no'])){
            $order->SetOut_trade_no($params['trade_no']);
        }else{
            $order->SetOut_trade_no($order_id);   //商户订单号
        }

        //商品描述
        if(!empty($params['order_desc'])) {
            $order->SetBody($params['order_desc']);
        }else{
            $order->SetBody($info['name']);
        }


        $recharge_money = floatval($info['price'])*100;// 总金额,最小单位为分
        if(config('app_debug') == 'true' && ENVIRONMENT == 'develop'){
            $recharge_money = 1;
        }
        $order->SetTotal_fee($recharge_money);  // 总金额

        //交易类型,NATIVE为扫码支付方式,JSAPI为公众号支付,APP 为ADK app支付

        if(!empty($params['Trade_type'])) {
            $order->SetTrade_type($params['Trade_type']);
        }else{
            $order->SetTrade_type('APP');
        }
        //设置附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
        if(!empty($params['Attach'])){
            $order->SetAttach($params['Attach']);
        }

        $order->SetProduct_id($order_id);  //此id为二维码中包含的商品ID，商户自行定义

        //设置接收微信支付异步通知回调地址  传入 就用 传入 的 ，不然就用 配置项中的 通用
        if(!empty($params['notify_url'])){
            $order->SetNotify_url(Url($params['notify_url'], null, true, true));
        }else{
            $order->SetNotify_url(url("/core/unionnotify/wxpay_notify", null, true, true));
        }

        $wxpai = new \WxPayApi();
        $package_name='';//带包请求的时候
        !empty($package_name)&&$c=$this->get_conf_by_package($package_name);
        $wxpay_app_appid=!empty($c['wxpay_app_appid'])?trim($c['wxpay_app_appid']):'';
        $wxpay_app_mchid=!empty($c['wxpay_app_mchid'])?trim($c['wxpay_app_mchid']):'';

        $result = $wxpai->unifiedOrder($order,'',$conf_wxpay['appid'],$conf_wxpay['mchid'],$conf_wxpay['key']);

        if (empty($result)) {
            exit_json(181,'服务器接口请求失败');
        }

        if (config('app_debug')) {//调式打开 服务器收到信息  入
            $m_log = db_func('notify', 'log_');
            $m_log->insert([
                'order_id' => 'wxpaySign:' . $order_id,
                'create_time' => date('Y-m-d H:i:s'),
                'log' => json_encode($result)
            ]);
        }


        if (key_exists('return_code', $result) && $result['return_code'] == 'SUCCESS') {
            if (key_exists('result_code', $result) && $result['result_code'] == 'SUCCESS') {
                //为APP生成参数
                $param = new \WxPayResults();
                if(!empty($c)){
                    $param->FromArray([
                        'appid' => $wxpay_app_appid,
                        'partnerid' => $wxpay_app_mchid,
                        'prepayid' => $result['prepay_id'],
                        'package' => 'Sign=WXPay',
                        'noncestr' => \WxPayApi::getNonceStr(),
                        'timestamp' => time()
                    ]);
                }else{
                    $param->FromArray([
                        'appid' => \WxPayConfig::getConf('APP_APPID'),
                        'partnerid' => \WxPayConfig::getConf('APP_MCHID'),
                        'prepayid' => $result['prepay_id'],
                        'package' => 'Sign=WXPay',
                        'noncestr' => \WxPayApi::getNonceStr(),
                        'timestamp' => time()
                    ]);
                }

                //签名
                $wxpay_app_key=!empty($c['wxpay_app_key'])?trim($c['wxpay_app_key']):'';

                if(empty($wxpay_app_key)) $wxpay_app_key=!empty($conf_wxpay['key'])?$conf_wxpay['key']:'';
                $param->SetSign($wxpay_app_key);
                log_w('订单order_id:'.$order_id.':微信签名成功');
                exit_json(0,'success',$param->GetValues());
            } else {
                exit_json(182,'微信接口错误'.$result['return_msg']);
            }
        } else {
            exit_json(183,'微信接口错误');
        }
    }


    public function app_apple_pay($order_id = null,$params = array()){
         //苹果支付预处理  只要告诉 app 回调地址和order_id  
         //根据订单号查询订单信息
        $info = db("order_list_parent")->where("order_id",$order_id)->find();

        (!is_array($info) || empty($info)) && die_result("-100", "提交参数不正确");
        log_w('苹果支付预处理成功：order_id');
        exit_json(0,'支付预处理成功',$params);

    }
    /**
     * 爱贝支付入口
     * @order_id request 订单id
     * @timestamp request 时间戳
     * @sign request 签名
     */
    public function aipay($order_id = null,$timestamp = null,$sign = null)
    {
//        $order_id = input("param.order_id", null);
//        $timestamp = input("param.timestamp", null);
//        $sign = input("param.sign", null);
        //鉴定权限签名
        $r = auth($order_id, $timestamp, $sign);

        if ($r["code"] !== "1") {
            if (IS_AJAX) {
                die_result('-100', "本请求失效或超时,请重新发起请求" . $sign);
            } else {
                $this->redirect('/');
            }
        }
        //下单等流程
        $url = $this->construct_param_aipay($order_id);
        if($url == "failed"){
            $this->error("下单错误");
        }
        $this->redirect($url);
    }

    /**
     * 爱贝构造下单参数
     * @return array
     */
    public function construct_param_aipay($order_id){

        //根据订单号获取订单信息
//        $order = new PayModel();
//        $info = $order->get_order_info_by_id($order_id);
        //获取爱贝支付必要参数
//        $conf_aipay = [
//            'appid' => config('AIPAY_APPID'),
//            'appkey'=>config('AIPAY_PRIVATE_KEY'),
//            'platpkey' =>config('AIPAY_PRIVATE_KEY'),
//        ];
        $orderUrl = "http://ipay.iapppay.com:9999/payapi/order";
        $appkey = "MIICXQIBAAKBgQCJIqPM/qVMyUg45QgshLbD1Y5G5YNZo944KmoES5zMZzwp4aD+f4ImyxsP87Do8jsMTP/nkNC6kAXM8GlEQp60y6eHJLM/qAM5PECQ7IhFhig8YmAxKcVD/1tniNrKNFCBfcvNxMUGd9vm7lLispJbwqaL60M1TWEzIO7rEAO5jQIDAQABAoGAHO9WKHbCYgVGW9rXcq098uwobQUYRd2xkaBBZk6d8vMFWsDku04kJBNOznrYpQ4XL20/wZhosjSZRLilPWXhHm1GRa2uT9lNZF9PLe9vFDtz22tvljjcjJvoj4SQEC5S1qdIyAc7vkKLcQ+b48sd3Ht23bjOoeJlpcKafn7l6fECQQDNCcKs3VjoiUaOGYee0MYsSWX2gbN3S628KGCoOZ+d9GIEY0N7FY+SGjAWcX9H0Ky+7GAeGrGippgjgAw1aXTXAkEAqzhVr6vim6+a6jes1mYxn3pxbThvLK8/dt3NijfGknQGG+PstBpxYA9nGy06tNpGzEYbz+RDEu3+u/dBUXMUOwJBAMMZPnxuQmNB/DjKYhnkXi1Vyge9cp9ZC3+2jAKGkjMijwHN0jAUXACRmqBAbvROw5EIKo16qPwzuSBOf09zgRECQHE97CYo59KSXUJFmnGe23kf0X8sURNbwPzMDBI7e4EHbbbqk3Y2+v9OkKH/0xEkQKkAQYrI7LfLYqxNBw1osFsCQQCcf7kFGQBdshV43Q8ILY6LgZOBI0F0D91w07kIEpPMZxLWTBaQmNtW91+XKMATgvxUmyKS7PWUOu30jMgCtjPb";

        $platpkey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDvE5k/RTyi4rubrN+vbudC/8qk84BUj85YegEa9YDBBTyGz3YBb79ooAVBHRAzf2kGrg0LIjw5GK7qfAdIfpQ9X55bBYAVkq0ix7fdQDHzCbv9aIi1tb+7FZGB5tPqCK6CRORw4A7lotKxLCxf4ZT+i9DZjTAFX1Ie8h+OAF+yxwIDAQAB";
        $appid = "3006649307";
        //下单接口
        $orderReq['appid'] = $appid;
        $orderReq['waresid'] = 1;
        $orderReq['waresname'] = "天元测试";
        $orderReq['cporderid'] = "16081310522642732"; //确保该参数每次 都不一样。否则下单会出问题。
        $orderReq['price'] = 0.01;   //单位：元
        $orderReq['currency'] = 'RMB';
        $orderReq['appuserid'] = '2';
        $orderReq['cpprivateinfo'] = '';
        $orderReq['notifyurl'] = 'http://test.mengdie.com/index.php/pay/notify/aipay_result.html';
        //下单接口
//        $orderReq['appid'] = $appid;
//        $orderReq['waresid'] = 1;
//        $orderReq['waresname'] = $info['description'];
//        $orderReq['cporderid'] = $order_id; //确保该参数每次 都不一样。否则下单会出问题。
//        $orderReq['price'] = floatval($info['money']);  //单位：元
//        $orderReq['currency'] = 'RMB';
//        $orderReq['appuserid'] = '2';
//        $orderReq['cpprivateinfo'] = '';
//        $orderReq['notifyurl'] = 'http://live.com/index.php/pay/notify/aipay_notify';

        //组装请求报文  对数据签名
//        $this = new \app\pay\controller\Aipay();
        $reqData = $this->composeReq($orderReq, $appkey);

        //发送到爱贝服务后台请求下单
        $respData = $this->request_by_curl($orderUrl, $reqData, 'order test');
        //验签数据并且解析返回报文
        if(!$this->parseResp($respData, $platpkey, $respJson)) {
            die("验签数据失败");
//            $this->redirect("order/pay_fail");
        }else{
            //     下单成功之后获取 transid
            $pcurl         = "https://web.iapppay.com/h5/exbegpay?";
            $url_data['transid']=$respJson->transid;
            $url_data['cpurl']       = 'aaa';
            $url_data['redirecturl'] = "http://ip.mengdie.com/index.php/wap/aipay/return_url";
            $reqData                 = $this->composeReq($url_data, $appkey);
            $url=$pcurl.$reqData;//我们的常连接版本 有PC 版本 和移动版本。 根据使用的环境不同请更换相应的URL:$h5url,$pcurl.
            return $url;
        }
    }

    /**格式化公钥
     * $pubKey PKCS#1格式的公钥串
     * return pem格式公钥， 可以保存为.pem文件
     */
    function formatPubKey($pubKey) {
        $fKey = "-----BEGIN PUBLIC KEY-----\n";
        $len = strlen($pubKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($pubKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END PUBLIC KEY-----";
        return $fKey;
    }


    /**格式化公钥
     * $priKey PKCS#1格式的私钥串
     * return pem格式私钥， 可以保存为.pem文件
     */
    function formatPriKey($priKey) {
        $fKey = "-----BEGIN RSA PRIVATE KEY-----\n";
        $len = strlen($priKey);
        for($i = 0; $i < $len; ) {
            $fKey = $fKey . substr($priKey, $i, 64) . "\n";
            $i += 64;
        }
        $fKey .= "-----END RSA PRIVATE KEY-----";
        return $fKey;
    }

    /**RSA签名
     * $data待签名数据
     * $priKey商户私钥
     * 签名用商户私钥
     * 使用MD5摘要算法
     * 最后的签名，需要用base64编码
     * return Sign签名
     */
    function sign($data, $priKey) {
        //转换为openssl密钥
        $res = openssl_get_privatekey($priKey);

        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_MD5);

        //释放资源
        openssl_free_key($res);

        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**RSA验签
     * $data待签名数据
     * $sign需要验签的签名
     * $pubKey爱贝公钥
     * 验签用爱贝公钥，摘要算法为MD5
     * return 验签是否通过 bool值
     */
    function verify($data, $sign, $pubKey)  {
        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);

        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $res, OPENSSL_ALGO_MD5);

        //释放资源
        openssl_free_key($res);

        //返回资源是否成功
        return $result;
    }

    /**
     * 解析response报文
     * $content  收到的response报文
     * $pkey     爱贝平台公钥，用于验签
     * $respJson 返回解析后的json报文
     * return    解析成功TRUE，失败FALSE
     */
    function parseResp($content, $pkey, &$respJson) {
        $arr=array_map(create_function('$v', 'return explode("=", $v);'), explode('&', $content));
        foreach($arr as $value) {
            $resp[($value[0])] = $value[1];
        }

        //解析transdata
        if(array_key_exists("transdata", $resp)) {
            $respJson = json_decode($resp["transdata"]);
        } else {
            return FALSE;
        }

        //验证签名，失败应答报文没有sign，跳过验签
        if(array_key_exists("sign", $resp)) {
            //校验签名
            $pkey = $this->formatPubKey($pkey);
            return $this->verify($resp["transdata"], $resp["sign"], $pkey);
        } else if(array_key_exists("errmsg", $respJson)) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * curl方式发送post报文
     * $remoteServer 请求地址
     * $postData post报文内容
     * $userAgent用户属性
     * return 返回报文
     */
    function request_by_curl($remoteServer, $postData, $userAgent) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteServer);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        $data = urldecode(curl_exec($ch));
        curl_close($ch);

        return $data;
    }
    /**
     * 组装request报文
     * $reqJson 需要组装的json报文
     * $vkey  cp私钥，格式化之前的私钥
     * return 返回组装后的报文
     */
    function composeReq($reqJson, $vkey) {
        //获取待签名字符串
        $content = json_encode($reqJson);
        //格式化key，建议将格式化后的key保存，直接调用
        $vkey = $this->formatPriKey($vkey);

        //生成签名
        $sign = $this->sign($content, $vkey);

        //组装请求报文，目前签名方式只支持RSA这一种
        $reqData = "transdata=".urlencode($content)."&sign=".urlencode($sign)."&signtype=RSA";

        return $reqData;
    }

//发送post请求 ，并得到响应数据  和对数据进行验签
    function HttpPost($Url,$reqData){
        global  $cpvkey, $platpkey;
        $respData = $this->request_by_curl($Url,$reqData," demo ");
        if(!$this->parseResp($respData,$platpkey, $notifyJson)) {
            //获取数据失败
            return false;
        }
        return  $respData;
    }


}