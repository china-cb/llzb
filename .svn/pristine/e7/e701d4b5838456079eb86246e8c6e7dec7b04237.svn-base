<?php
namespace app\lib;
/**
 * 点触验证类，
 *
 * @author Tianyuan
 */
class touclick {
    /**
     * 点触验证
     * @param $publicKey 公钥
     * @param $privateKey 私钥
     * @param $check_key 二次验证口令
     * @param $check_address 二次验证地址
     * @param $uname 用户名
     * @param $uid 用户id
     * @return result 返回结果
     **/

    public function touclickCheck($publicKey, $privateKey, $check_key, $check_address, $uname="0", $uid="0"){
        $url = "";
        $path = "";

        if(empty($publicKey) || empty($privateKey) || empty($check_key) ||empty($check_address) ) {
            return false;
        }
        //解析来自客户端提交的隐藏域$check_address，成功返回true
        if(!$this->filterUrl($url, $path, $check_address)){
            return false;
        }
        $path = $path
            ."?b=".$publicKey  //验证码公钥
            ."&z=".$privateKey //验证码私钥
            ."&i=".$check_key  //二次验证的口令来自客户端隐藏域：check_key 的值
            ."&p=".$this->getClientIp()//浏览器端用户的IP 地址
            ."&un=".urldecode($uname) //该次验证的浏览器端用户的用户名（若没有可为""）
            ."&ud=".$uid; //该次验证的浏览器端用户的用户ID（若没有可为""）

        $getres = $this->requestGet($url, $path, array(),80);
//        dump($getres);die();
        return !!strpos($getres['content'], "[yes]");
    }

    //$check_address 来自客户端提交的隐藏域
    //$url (引用参数)解析 $check_address 得到的二次验证域名
    //$path (引用参数)解析 $check_address 得到的二次验证路径
    private function filterUrl(&$url, &$path, $check_address) {
        $check_address_arr = explode ( ",", $check_address );
        if (! is_array ( $check_address_arr ) || count ( $check_address_arr ) != 2) {
            return false;
        }
        $url_arr = explode ( ".", $check_address_arr [0] );
        if (! is_array ( $url_arr ) || count ( $url_arr ) != 3) {
            return false;
        }
        $path_arr = explode ( ".", $check_address_arr [1] );
        if (! is_array ( $path_arr ) || count ( $path_arr ) != 2) {
            return false;
        }
        if (! $this->filterStr ( $url_arr [0] ) || ! $this->filterStr ( $path_arr [0] )) {
            return false;
        }
        $url = "http://" . $url_arr [0] . ".touclick.com";

        $path = "/" . $path_arr [0] . ".touclick";
        return true;
    }
    //校验字符串，只允许数字和字母组合
    private function filterStr($str){
        if (preg_match("/^[a-z0-9]+$/", $str) ) {
            return true;
        } else {
            return false;
        }
    }

    private function requestGet($url, $path, $data, $port) {
        $data = http_build_query($data);
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
            die('Error: Only HTTP request are supported !');
        }
        $host = $url['host'];
        $fp = $this->sendGet($host, $port, $errno, $errstr, 15);
        if ($fp){
            fputs($fp, "GET $path HTTP/1.1\r\n");
            fputs($fp, "Host: $host\r\n");
            fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
            fputs($fp, "Content-length: ". strlen($data) ."\r\n");
            fputs($fp, "Connection: close\r\n\r\n");
            fputs($fp, $data);
            $result = '';
            while(!feof($fp)) {
                $result .= fgets($fp, 1028);
            }
        }
        else {
            return array(
                'status' => 'err',
                'error' => "$errstr ($errno)"
            );
        }
        fclose($fp);
        $result = explode("\r\n\r\n", $result, 2);
        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';
        return array(
            'status' => 'ok',
            'content' => $content,
        );
    }

    private function sendGet($hostname, $port = 80, &$errno, &$errstr, $timeout = 15) {
        $fp = '';
        if(function_exists('fsockopen')) {
            $fp = @fsockopen($hostname, $port, $errno, $errstr, $timeout);
        } elseif(function_exists('pfsockopen')) {
            $fp = @pfsockopen($hostname, $port, $errno, $errstr, $timeout);
        } elseif(function_exists('stream_socket_client')) {
            $fp = @stream_socket_client($hostname.':'.$port, $errno, $errstr, $timeout);
        }
        return $fp;
    }

    private function getClientIp() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $clientip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $clientip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (!empty($_SERVER["REMOTE_ADDR"])) {
            $clientip = $_SERVER["REMOTE_ADDR"];
        } else {
            $clientip = '0.0.0.0';
        }
        return $clientip;
    }
}