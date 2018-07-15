<?php
namespace app\lib;


use app\core\model\CommonModel;
use app\lib\tb_sdk\top\TopClient;
use app\lib\tb_sdk\top\request;
use think\Exception;

/**
 * 手机验证码
 * User: phil
 * Date: 2016/3/24
 * Time: 14:03
 */
Class PhoneCode
{

    //螺丝帽短信发送接口    $flag=true时允许发送,重试的时候防止多发
    public function send_sms_luosimao($mobile, $phone_code, $plat_name = '梦蝶')
    {
        if (empty($mobile) || empty($phone_code)) return false;
//        $m_com = new CommonModel();
        $luosi_key = Config('LUOSIMAO_KEY');
        $content = "验证码:" . $phone_code . "【" . $plat_name . "】";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $luosi_key);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile, 'message' => $content));

        $res = curl_exec($ch);
        curl_close($ch);
        //file_put_contents("sms.txt", "luosimao send success ! " . $mobile . " : " . $res, FILE_APPEND);
        $json = json_decode($res, true);
        $json['plat'] = 'luosimao';
        return $json;
    }

    //获奖螺丝帽发送短信
    public function luosimao_win($mobile, $nper_id)
    {
        if (empty($mobile) || empty($phone_code)) return false;
//        $base_model = new CommonModel();
//        $web_name = $base_model->get_conf("WEBSITE_NAME");
//        $plat_name = $base_model->get_conf("LUOSIMAO_SIGN");

        $luosi_key = Config('LUOSIMAO_KEY');
        $content = "恭喜您在第" . $nper_id . "期中获奖,请登录" . $web_name . "官网查看【" . $plat_name . "】";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-' . $luosi_key);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile, 'message' => $content));

        $res = curl_exec($ch);
        curl_close($ch);
        //file_put_contents("sms.txt", "luosimao send success ! " . $mobile . " : " . $res, FILE_APPEND);
        $json = json_decode($res, true);
        $json['plat'] = 'luosimao';
        return $json;
    }



    //鼎信企业通短信接口
    public function dingxintong_send($mobile, $phone_code, $product="梦蝶直播")
    {
        if (empty($mobile) || empty($phone_code)) return false;

        $base_model = new CommonModel();
//        $username = $base_model->get_conf("DINGXIN_USERNAME");//鼎信企业通用户名
//        $password = $base_model->get_conf("DINGXIN_PASSWORD");//鼎信企业通密码
//        $appid = $base_model->get_conf("DINGXIN_APIID");//鼎信企业通APIID
        $ch = curl_init();
        $url = "http://121.40.160.86:7890/msgapiv2.aspx?action=send&username=$username&password=$password&apiid=$appid&mobiles=" . $mobile . "&text=【" . $product . "】你好,欢迎来到本网,如非本人操作,请忽略,你的注册验证码是:" . $phone_code;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        $res = json_encode(simplexml_load_string(curl_exec($ch)), JSON_UNESCAPED_UNICODE);
        return $res;
    }

    //鼎信企业通中奖短信接口
    public function dingxintong_win($mobile, $nper_id)
    {
        if (empty($mobile) || empty($nper_id)) return false;

        $base_model = new CommonModel();
//        $web_name = $base_model->get_conf("WEBSITE_NAME");
//        $username = $base_model->get_conf("DINGXIN_USERNAME");
//        $password = $base_model->get_conf("DINGXIN_PASSWORD");
//        $appid = $base_model->get_conf("DINGXIN_APIID");
//        $product = $base_model->get_conf("DINGXIN_SIGN");
        $ch = curl_init();
        $url = "http://121.40.160.86:7890/msgapiv2.aspx?action=send&username=$username&password=$password&apiid=$appid&mobiles=" . $mobile . "&text=【" . $product . "】恭喜您在第" . $nper_id . "期中获奖,请登录" . $web_name . "官网查看";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        try {
            $res = json_encode(simplexml_load_string(curl_exec($ch)), JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            $res = false;
        }
        return $res;
    }

    //百度API凯立通验证码接口
    public function baidu_api_klt($mobile, $phone_code, $product = '梦蝶直播')
    {
        if (empty($mobile) || empty($phone_code)) return false;
        $m_com = new CommonModel();
        $baidu_api = $m_com->get_conf('BAIDU_KEY');
        $ch = curl_init();
        $text = '【' . $product . '】您的验证码是' . $phone_code . '，有效时间10分钟，请不要告诉他人';
        $url = 'http://apis.baidu.com/kingtto_media/106sms/106sms?mobile=' . $mobile . '&content=' . urlencode($text);
        $header = array(
            'apikey: ' . $baidu_api,
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch, CURLOPT_URL, $url);
        return curl_exec($ch);
    }

    //阿里大鱼发短信接口
    public function alidayu_reg_sms($phone, $phone_code, $product,$purpose='重要操作')
    {
        $top = new TopClient();
        $m_com = new CommonModel();

        $appkey = config('CONFIG_ALI_DAYU_MSG_APPKEY');
        $secret = config('CONFIG_ALI_DAYU_SECRET');
        $ali_tmp = config('CONFIG_ALI_DAYU_MSG');//大鱼模版


        if (empty($ali_tmp)) return false;

        $top->appkey = $appkey;
        $top->secretKey = $secret;
        $req = new request\AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("654321");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("注册验证");//必须在大鱼配置过
        $param = '{"code":"' . $phone_code . '","product":"' . $product . '"}';
        $req->setSmsParam($param);
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($ali_tmp);
        $obj = $top->execute($req);
        return obj_to_arr($obj);
    }

    //阿里大鱼语音通知接口
    public function alidayu_vn($phone){
        $top = new TopClient();
//        $m_com = new CommonModel();

//        $appkey = $m_com->get_conf("ALIDAYU_KEY");
//        $secret = $m_com->get_conf("ALIDAYU_SECRET");
//        $show_num = $m_com->get_conf("被叫号显");//被叫号显，传入的显示号码必须是阿里大鱼“管理中心-号码管理”中申请通过的号码
//        $voice_code = $m_com->get_conf("语音文件ID");//语音文件ID，传入的语音文件必须是在阿里大鱼“管理中心-语音文件管理”中的可用语音文件

        if(empty($show_num) || empty($voice_code)) return false;

        $top->appkey = $appkey;
        $top->secretKey = $secret;
        $req = new request\AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("12345");
        $req->setCalledNum($phone);
        $req->setCalledShowNum($show_num);
        $req->setVoiceCode($voice_code);
        $obj = $top->execute($req);
        return obj_to_arr($obj);
    }

    //身份验证验证码
    public function alidayu_forgot_sms($phone, $phone_code, $product = '梦蝶')
    {
        $top = new TopClient();
        $m_com = new CommonModel();

        $appkey = "23332184";
        $secret = "58652b2b204514bce486c18fd9f4abec";
        $ali_tmp = "SMS_6740183";
        if (empty($ali_tmp)) return false;

        $top->appkey = $appkey;
        $top->secretKey = $secret;
        $req = new request\AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("654321");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("注册验证");
        $param = '{"code":"' . $phone_code . '","product":"' . $product . '"}';
        $req->setSmsParam($param);
        $req->setRecNum($phone);
        $req->setSmsTemplateCode($ali_tmp);
        $obj = $top->execute($req);
        return obj_to_arr($obj);
    }
}