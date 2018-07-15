<?php
use think\db\connector\Mysql;

use think\Db;

abstract class rewardLibrary {
    abstract protected function getData($object_id);

    abstract protected function getMessage($nickName,$num);

    abstract protected function getPayBody();


    abstract protected function getMobileMessage($money = null);

    abstract protected function getSystemMessage($uid,$money = null);

    protected $systemMessageTitle;

    public $object_type;

    public $reward_type;

    protected $ci;

    protected $pay_info;

    protected $paySum;

    protected $userInfo;

    protected $controller;

    protected $msgType;

    public $uvData;

    public $vgoods;

    public $rewardnum;

    public $balance_coin;

    public $type_name;
    public $object_uid;
    protected $returnData = array();//


    /**
     * 获取 GET/POST 参数
     * @param string $param 参数名称
     * @return mixed|string  boolean
     */
    public function getParams($param){
        $getstr=input("param.$param",null);
        if(empty($getstr)) $getstr= input("request.$param",null);
        if(empty($getstr)){
            $data = json_decode(file_get_contents('php://input'),true);

            if(empty($data["$param"])){
                $getstr ='';
            }else{
                $getstr = $data["$param"];
            }
        }
        return $getstr;
    }

    public function setController($obj) {
        $this->controller = $obj;
    }

    public function _getPublishParamters($sender,$data) {

        if($data['reward_type']) $this->reward_type = $data['reward_type'];
        if(empty($this->reward_type)) $this->reward_type = REWARD_TYPE_GOOD;//默认赠送礼物

        $parameter['object_id'] = $data['object_id'] ? intval($data['object_id']) : intval($data['liveid']);

        if(empty($parameter['object_id'])) exit_json(1,'请传入赠送对象id');

        if($this->reward_type ==2){
            $list = db_func('member','sp_')->where('member_id',$data['object_uid'])->find();
            (empty($list)) && wrong_return('赠送对象不存在');
        }else{
            $objinfo = $this->getData($parameter['object_id']);//找到标的物的 信息 ，并且将标的物相关  的 人 uid 赋值
            if (empty($objinfo)) exit_json(1, '赠送对象信息不存在',$this->returnData);
        }

        $this->rewardnum = isset($data['num'])?$data['num']:1;//单次 订购个数
        if(empty($this->rewardnum)) $this->rewardnum = 1;//单次 定购个数
        //支付信息

        $payInfo = $data['pay_info'];

        $this->pay_info = $payInfo;
        $this->paySum = intval($payInfo['input_free_coin'])*$this->rewardnum;//总价格
        if (empty($payInfo)) exit_json(1, '支付信息不能为空',$this->returnData);
        $parameter['pay_info'] = $payInfo;


        $parameter['free_coin'] = $payInfo['input_free_coin'];//支付单价
        $parameter['num'] = $this->rewardnum;//单次数量
        $parameter['coin'] = $payInfo['input_free_coin']*$this->rewardnum;//支付总价


        $parameter['uid'] = $sender['member_id'];
        $parameter['object_uid'] = $this->object_uid;

        $nickname = $sender['nick_name'] ? $sender['nick_name'] : $sender['num_id'];
        $parameter['description'] = $this->getMessage($nickname,$parameter['coin']);
//        $ip = get_client_ip();
//        $parameter['ip'] = ip2long($ip);
        $parameter['create_time'] = time();
        $parameter['reward_type'] = $this->reward_type;
        return $parameter;
    }

    public function doPay($rewardId) {
        if($this->reward_type == REWARD_TYPE_GOOD) {//实际都是走子级具体的doPAY  这里只做宏观逻辑展示
            $flag = $this->_doPayResult($rewardId);
            if(!$flag) {
                exit_json(1,'赠送失败',$this->returnData);
            }
            exit_json(0,"赠送成功",$this->returnData);
        }else{

        }
    }

    public function setPaySum($paySum) {
        $this->paySum = $paySum;
    }

    public function setUserInfo($userInfo) {
        $this->userInfo = $userInfo;
    }

    public function _doPayResult($rewardId) {

        $reward = db('reward')->where('id',$rewardId)->find();
        if (empty($reward))
        {
            log_w("reward_{$rewardId}赠送信息不存在");
            exit_json(1, '馈赠信息不存在');
        }
        
        Db::startTrans();//开启事务
        try {

            $flag = db_func('member')->where('member_id',$reward['object_uid'])->setInc('balance',$reward['coin']);//- 收到者的
            //红包 在发送初期 就已经扣过了
            if(empty($flag)) throw new Exception("reward_{$rewardId}更新对方账户信息出错");

            //查询对象用户的钱
            $reward_sender = db_func('member')->where('member_id',$reward['uid'])->find();
            $this->balance_coin = $reward_sender['coin'];

            Db::commit(); //提交事务
            $result = true;
        } catch (\Exception $ex) {
            log_w("回调错误：".$ex->getMessage());
            Db::rollback();//回滚
            $result = false;
        }
        return $result;

    }

    protected function mycallback($reward) {
        if($this->object_type == OBJECT_TYPE_LIVE){
            $step = $reward['coin']+0;
            $flag = db_func('live_record')->where('id',$reward['object_id'])->setInc('ticket',$step);
            if (empty($flag)) throw new Exception("reward_{$reward['reward_id']}更新直播进账出错，所有支付退回");
        }

    }


}
