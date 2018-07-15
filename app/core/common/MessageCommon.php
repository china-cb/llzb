<?php
namespace app\core\common;
use app\lib\PhoneCode;
use PHPMailer\PHPMailer\PHPMailer;
/**
 * 消息.
 * User: feel
 * Date: 2016/9/7
 * Time: 15:40
 */

Class MessageCommon{


    //阿里大鱼验证码
    public function alidayu_sms($phone, $phone_code, $product = '梦蝶')
    {
//        $product = empty(Config('SMS_TEMP_NAME')) ? $product : Config('SMS_TEMP_NAME');//短信模板;
        $m_sms = new PhoneCode();
        return $m_sms->alidayu_reg_sms($phone, $phone_code, $product);
    }

    //螺丝帽
    public function luosimao_sms($phone, $phone_code)
    {
        $m_phone_code = new PhoneCode();
        return $m_phone_code->send_sms_luosimao($phone, $phone_code, $product = '梦蝶');

    }

    //阿里大鱼语音接口
    public function alidayu_vn_send($phone)
    {
        $model = new phoneCode();
        return $model->alidayu_vn($phone);
    }

    //根据优先级自动获取手机验证码
    public function get_phone_code_auto($phone, $rand_num)
    {
        $plat = 'alidayu';
        $r = $this->alidayu_sms($phone, $rand_num);
        //阿里大鱼不能用时,用备用接口
        if (empty($r["result"]['success'])) {
            $plat = 'luosimao';
//            /**记录日志*/
//            $log = new LogModel();
//            $log_text = [
//                'user' => $phone,
//                'type' => 'phone_code_error',
//                'log' => json_encode($r)
//            ];
//            $log->log_add($log_text);
            $r = $this->luosimao_sms($phone, $rand_num);

        }

        return array(
            "r" => $r,//接口返回
            "plat" => $plat
        );
    }
    //phpmail邮件发送接口
    public function send_mail($email, $subject, $body)
    {

        $mail = new PHPMailer(true);
        // 服务器设置
        $mail->SMTPDebug = 0;                                    // 开启Debug
        $mail->isSMTP();                                        // 使用SMTP
        $mail->Host = 'smtp.exmail.qq.com ';                        // 服务器地址
        $mail->SMTPAuth = true;                                    // 开启SMTP验证
        $mail->Username = 'service@mengdie.com';                // SMTP 用户名（你要使用的邮件发送账号）
        $mail->Password = 'bSEyZOTI0b8acd9LtRlg';                 // SMTP 密码
        $mail->SMTPSecure = 'tls';                                // 开启TLS 可选
        $mail->Port = 25;                                        // 端口
        // 发件人
        $mail->setFrom('service@mengdie.com', '梦蝶官网');            // 来自
        $mail->addAddress($email);        // 添加一个收件人
        //收件人
//        $mail->addAddress($mail_name);                        // 可以只传邮箱地址
        $mail->addReplyTo('service@mengdie.com', '梦蝶官网');        // 回复地址
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // 附件
//            $mail->addAttachment('/var/tmp/file.tar.gz');                // 添加附件
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');            // 可以设定名字
        // 内容
        $mail->isHTML(true);                                        // 设置邮件格式为HTML
        $mail->Subject = $subject;
//        $mail->Body    = '<br>尊敬的客户'.$list['user_name'].'您好:<br>您于'.$order_time.'申请的版本预约更新我们已处理完成，请您及时登录系统进行验证并对网站相关流程进行测试检验以免影响您的网站正常运行，谢谢您的配合。
//<br>点击登录查看:<a href="http://workorder.mengdie.com/index.php/index/index/login">http://workorder.mengdie.com/index.php/index/index/login</a></br>';
        $mail->Body = $body;
        if ($mail->send()) {
            return '发送成功';
        }
    }
}