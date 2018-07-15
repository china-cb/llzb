<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/6
 * Time: 16:46
 */
namespace app\core\controller;

use app\core\model\PaymentModel;
use think\Controller;
Class  Payment extends Controller
{
    //支付宝充值回调改变状态
    public function ali_notify()
    {
        log_w('支付宝回调进入数据啦。。-》》》》');
        
        $m = new PaymentModel();
        $rt = $m->ali_notify();
    }
    //微信充值回调并改变状态
    public function notify()
    {
        log_w('微信充值进入');

        $m = new PaymentModel();
        $rt = $m->notify();

        log_w(json_encode($rt));
        echo  $rt;
    }
    
}