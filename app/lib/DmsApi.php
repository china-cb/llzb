<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/1/7
 * Time: 13:11
 */

namespace app\lib;


class DmsApi
{
    private $accessId;
    private $host = "http://api.dms.aodianyun.com";
    private $accessKey;
//    public function __construct($accessId,$accessKey) {
//        $this->accessKey = $accessKey;
//        $this->accessId = $accessId;
//    }
    //签名
    public function Sign($str){
        $signature = $this->accessId.":".base64_encode(hash_hmac("sha1", $str, $this->accessKey, true));
        return $signature;
    }
    //获取历史消息
    public function history(){
        $topic = "tis_891484533210";
        $skip = 0;
        $num = 100;
//        if(!empty($param['skip'])){
//            $skip=$param['skip'];
//        }
//        if(!empty($param['num'])){
//            $num=$param['num'];
//        }
        return $this->curl("http://api.dms.aodianyun.com/v1/historys/tis_891484533210/0/10");
    }
    private function curl($path,$method="GET",$content="",$expire=3600,$timeout=60){
        $ch = curl_init();
        $expire = time() + $expire;
        if(($method == "POST" || $method == "PUT") && !empty($content)){
            $contentMd5 = md5($content);
            $str = $method."\n".$path."\n".$expire."\n".$contentMd5."\n";
        }else{
            $str = $method."\n".$path."\n".$expire."\n";
        }
        $query_url = $this->host.$path;

        curl_setopt($ch,CURLOPT_URL,$query_url);
        curl_setopt($ch,CURLOPT_HEADER,false);

        curl_setopt($ch,CURLOPT_AUTOREFERER,true);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch,CURLOPT_FRESH_CONNECT,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
        //	curl_setopt($ch,CURLOPT_USERAGENT,$useragent);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        if($method == 'POST') {
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$content);
        } else if($method == 'PUT') {
            curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$content);
        }
        $authorization = 'Authorization: dms s_19d2ea8b7f9d92e2686fe9c11fec00df';
        //print_r($authorization);exit();
        $header = array($authorization,'AD-Expire: '.$expire,'Content-Type: application/json');
        curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
        //execute post
        $response = curl_exec($ch);
        //get response code
        $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //close connection
        curl_close($ch);
        //return result

        if($response_code == 401  || $response_code == 404 || $response_code == 500) {
            $rst = json_decode(trim($response),true);
        } else {
            $rr = json_decode(trim($response),true);
            if($rr) {
                $rst = $rr;
            } else {
                $rst = array(
                    'Flag'=>$response_code,
                    'FlagString'=>trim($response)
                );
            }
        }
        return $rst;
    }
}