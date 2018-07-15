<?php

namespace org\qqconnect;
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */

class Recorder{
    private static $data;
    private $inc;
    private $error;

    public function __construct(){
        if(empty(config('appid'))||empty(config('appkey'))||empty(config('callback')))
        {
            if(empty($this->inc['appid']))echo 'appid error<br>';
            if(empty($this->inc['appkey']))echo 'appkey error<br>';
            if(empty($this->inc['callback']))echo 'callback error<br>';
            die();
        }

        $this->error = new ErrorCase();
        //-------读取配置文件
        $this->inc = [
            'appid' => config('appid'),
            'appkey' =>  config('appkey'),
            'callback' =>  config('callback'),
            'scope' => config('scope'),
            'errorReport' => config('errorReport'),
        ];





        if(empty(session('QC_userData'))){
            self::$data = array();
        }else{
            self::$data = session('QC_userData');
        }
    }

    public function write($name,$value){
        self::$data[$name] = $value;
    }

    public function read($name){
        if(empty(self::$data[$name])){
            return null;
        }else{
            return self::$data[$name];
        }
    }

    public function readInc($name){
        if(empty($this->inc[$name])){
            return null;
        }else{
            return $this->inc[$name];
        }
    }

    public function delete($name){
        unset(self::$data[$name]);
    }

    function __destruct(){
        session('QC_userData', self::$data);
    }
}
