<?php

include_once 'rewardLibrary.php';
class personreward extends rewardLibrary {
    public $object_type = OBJECT_TYPE_PERSON;
    public $type_name = "主播馈赠";
    public $msgType = 6; //
    public $object_uid;
    protected function getData($object_id) {

        $data = db('member')->where('member_id',$object_id)->find();

        $this->object_uid = $data['member_id'];
        return $data;
    }

    public function getGoodMessage($nickName,$objectname,$something='神秘礼物',$num=1,$coin=1) {

        if($this->reward_type == REWARD_TYPE_GOOD){
            return $nickName.'赠送了'.$objectname.$num.'个'. $something.'价值'.$coin.'个'.config('CONFIG_FLATFORM_NAME').'票';
        }else
            return '你获得'.$nickName.'发送的红包中的'. number_format($num, 2) .'个'.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT');

    }
    protected function getMessage($nickName,$coin) {

        if($this->reward_type == REWARD_TYPE_GOOD){
            return $nickName.'赠送了你'.$coin.'个'.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT');
        }else
            return '你获得'.$nickName.'发送的红包中的'. number_format($coin, 0) .'个'.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT');

    }

    public function doPay($rewardId) { //
        $result = $this->_doPayResult($rewardId);
        if(!$result) {
            exit_json(2,'赠送失败');
        }
        exit_json(0, '你成功赠送消费了'.$this->paySum.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT'));
    }

    protected function getPayBody() {
        return "";
    }

    protected function mycallback($reward) {
        return true;
    }

    protected function getMobileMessage($money = null) {
        return "";
    }

    protected function getSystemMessage($nickname, $good_name = null) {

    }
}
