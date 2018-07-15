<?php
/* PHP SDK
 * @version 2.0.0
 * @author connect@qq.com
 * @copyright © 2013, Tencent Corporation. All rights reserved.
 */
namespace app\lib\oAuth;
use app\lib\oAuth\Recorder;
use app\lib\oAuth\URL;
use app\lib\oAuth\ErrorCase;
use think\Model;
class Oauth{
    const VERSION = "2.0";
    const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";//获取Authorization Code 的PC网站地址;
    const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";//通过Authorization Code获取Access Token的PC网址地址;
    const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";

    protected $recorder;
    public $urlUtils;
    protected $error;

    protected $config;


    function __construct(){
        $this->recorder = new Recorder();
        $this->urlUtils = new URL();
        $this->error = new ErrorCase();
    }

    public function init($appid,$appkey,$callback){
        $this->config['appid']=$appid;
        $this->config['appsec']=$appkey;
        $this->config['callback']=$callback;
    }

    public function qq_login(){
        $appid = !empty($this->config['appid'])?$this->config['appid']:$this->recorder->readInc("appid");
        $callback = !empty($this->config['callback'])?$this->config['callback']:$this->recorder->readInc("callback");
        $scope = $this->recorder->readInc("scope");
       // dump($scope);die();
        //  dump($callback);die();
        //-------生成唯一随机串防CSRF攻击(跨站请求伪造)
        $state = md5(uniqid(rand(), TRUE));
//        $this->recorder->write('state',$state);
//        //-------构造请求参数列表,用来获取Authorization Code;（授权代码！）
        $keysArr = array(
            "response_type" => "code",//授权类型，此值固定为"code"
            "client_id" => $appid,//申请QQ登录成功后，分配给应用的appid。
            "redirect_url" => urlencode("http://1.xiangchang.com/index.php/yyg/user/union_login_do/plat/qq.html"),//成功授权后的回调地址，必须是注册appid时填写的主域名下的地址，建议设置为网站首页或网站的用户中心。注意需要将url进行URLEncode。
            "state" => $state,//client端的状态值。用于第三方应用防止CSRF攻击，成功授权后回调时会原样带回。
            "scope" => $scope//请求用户授权时向用户显示的可进行授权的列表。
        );
        $login_url =  $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
        //dump($login_url);die();
        header("Location:$login_url");
    }

    public function qq_callback(){
//        $state = $this->recorder->read("state");
//        //--------验证state防止CSRF攻击
//        if($_GET['state'] != $state){
//            $this->error->showError("30001");
//        }

        //-------请求参数列表
        $keysArr = array(
            "grant_type" => "authorization_code",//授权类型，本步骤此值就是authorization_code;
            "client_id" =>!empty($this->config['appid'])?$this->config['appid']:$this->recorder->readInc("appid"),//申请QQ登录成功后，分配给网站的appid。
            "redirect_uri" =>urlencode("http://1.xiangchang.com/index.php/yyg/user/union_login_do/plat/qq.html"),//与上面一步中传入的redirect_uri保持一致。
            "client_secret" =>!empty($this->config['appsec'])?$this->config['appsec']:$this->recorder->readInc("appkey"),//申请QQ登录成功后，分配给网站的appkey。
            "code" => $_GET['code']//上一步返回的authorization code
        );

        //------构造请求access_token的url
        $token_url = $this->urlUtils->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);//拼接url
        $response = $this->urlUtils->get_contents($token_url);//服务器通过get请求获得内容

        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);//返回字符串的一部分；
            $msg = json_decode($response);

            if(isset($msg->error)){
                $this->error->showError($msg->error, $msg->error_description);//显示错误信息
            }
        }

        $params = array();
        parse_str($response, $params);//把查询字符串解析到变量中;

        $this->recorder->write("access_token", $params["access_token"]);
        return $params["access_token"];
    }

    public function get_openid(){

        //-------请求参数列表
        $keysArr = array(
            "access_token" => $this->recorder->read("access_token")
        );

        $graph_url = $this->urlUtils->combineURL(self::GET_OPENID_URL, $keysArr);//拼接
        $response = $this->urlUtils->get_contents($graph_url);//服务器通过get请求获得内容

        //--------检测错误是否发生
        if(strpos($response, "callback") !== false){

            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }

        $user = json_decode($response);
        if(isset($user->error)){
            $this->error->showError($user->error, $user->error_description);
        }

        //------记录openid
        $this->recorder->write("openid", $user->openid);
        return $user->openid;

    }
}
