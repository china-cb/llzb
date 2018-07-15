<?php
namespace app\lib\tb_sdk;//Demo插件英文名，改成你的插件英文就行了
use app\lib;
use think\Model;
class Alidayu
{
	/**
	 * 阿里大鱼发短信
	 */
	public function smsAlidayu($phone, $ok_code = '0')
	{
		include "TopSdk.php";
		date_default_timezone_set('Asia/Shanghai');

		$appkey = '12497914';
		$secret = '4b0f28396e072d67fae169684613bcd1';
		$c = new TopClient;
		$c->appkey = $appkey;
		$c->secretKey = $secret;
		$c->format = 'json';

		$v_code = mt_rand(1000, 9999);       //生成四位随机数
		$req = new AlibabaAliqinFcSmsNumSendRequest;
		$req->setExtend("123456");
		$req->setSmsType("normal");
		$req->setSmsFreeSignName("阿里大鱼
		");
		$req->setSmsParam("{\"code\":\"{$v_code}\",\"product\":\"DoDoBook\"}");
		$req->setRecNum($phone);
		$req->setSmsTemplateCode("SMS_*********");
		$resp = $c->execute($req);

		$sms_ok = '2';              //默认情况下不成功
		if (isset($resp->result->err_code)) {
			if ($resp->result->err_code == '0') {   //发送成功
				$sms_ok = '1';
				Yii::$app->session->set('tel_' . $phone, $v_code);   //把验证码存入session
			}
		}
		$model = new WebsiteSmsList;        //记录发送验证码的信息到数据库
		$model->code = $v_code;
		$model->name = $phone;
		$model->add_time = time();
		$model->isNewRecord = true;
		if ($sms_ok == '1') {     //发送成功的情况下
			$model->status = '1';
			$model->remark = '发送成功';
			$model->save();
			$this->_end($ok_code, '手机验证码发送成功.', '');
		} else {
			$model->status = '2';
			$model->remark = '发送失败';
			$model->save();
			$this->_end('1', '非常抱歉,短信验证码发送失败,请稍后再试.', '');
		}
	}
}