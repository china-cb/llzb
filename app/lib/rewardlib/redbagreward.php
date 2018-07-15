<?php

include_once 'rewardLibrary.php';
class redbagreward extends rewardLibrary {
    public $object_type = OBJECT_TYPE_PERSON;
    public $type_name = "红包";
    public $msgType = 6; //
    public $object_uid;
    protected function getData($objec_uid) {//红包收的人
        $data = db('member')->where('member_id',$objec_uid)->find();
        $this->object_uid = $data['member_id'];
        return $data;
    }

    protected function getMessage($nickName,$coin) {
            return '你获得'.$nickName.'发送的红包中的'. $coin.'个'.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT');
    }

    public function doPay($rewardId) { //
        $result = $this->_doPayResult($rewardId);
        if(!$result) {
            return exit_array(2,0,$rewardId.'红包回库失败');
        }
        return exit_array(0,1, $rewardId.'红包回库成功'.$this->paySum.config('CONFIG_FLATFORM_NAME').config('PLATFORM_UNIT'));
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
