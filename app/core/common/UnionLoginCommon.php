<?php
namespace app\core\common;
use app\lib\iHttp;
use app\lib\oAuth\SaeTClientV2;
use app\lib\oAuth\SaeTOAuthV2;
use org\wechatconnect\WeChat;
use org\qqconnect\QC;

/**
 * Created by PhpStorm.
 * User: feel
 * Date: 2016/8/17
 * Time: 15:11
 */
class UnionLoginCommon
{
    /**接入QQ互联传入配置
     * @param array $conf
     * appid=>QQ互联APPID
     * appkey=>QQ互联APPKEY
     * callback=>QQ互联回调地址
     * scope=>需要哪些权限:[get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,check_page_fans,add_t,add_pic_t,del_t,get_repost_list,get_info,get_other_info,get_fanslist,get_idolist,add_idol,del_idol,get_tenpay_addr]
     * errorReport=>true 错误报告
     */
    public function qq_conn($conf){
        config('appid',$conf['appid']);
        config('appkey',$conf['appkey']);
        config('callback',$conf['callback']);
        config('scope',$conf['scope']);
        config('errorReport',$conf['errorReport']);

        $qc = new  QC();
        return $qc->qq_login();
    }

    //处理并返回QQ回调的内容
    public function qq_callback($arr){
        $url = 'https://graph.qq.com/oauth2.0/token?';
        $arr = [
            'grant_type'=>'authorization_code',
            'client_id'=>$arr['client_id'],
            'client_secret'=>$arr['client_secret'],
            'code'=>$arr['code'],
            'redirect_uri'=>$arr['redirect_uri']
        ];
        $url = $url . arr2get($arr);

        $http = new iHttp();
        $r = $http->get($url);
        parse_str($r, $get);

        (!is_array($get)||empty($get['access_token'])) && wrong_return('返回值不正确');

        $open_url = 'https://graph.qq.com/oauth2.0/me?access_token='.$get['access_token'];
        $r = $http->get($open_url);
        preg_match_all('/\{.*\}/',$r,$rt);
        $json = json_decode(trim($rt[0][0]),true);
        empty($json['openid']) && wrong_return('open_id获取失败');

        //组装查询字符串
        $arr = [
            'access_token'=>$get['access_token'],
            'oauth_consumer_key'=>$json['client_id'],
            'openid'=>$json['openid']
        ];
        $url = 'https://graph.qq.com/user/get_user_info?'. arr2get($arr);
        $r = json_decode($http->get($url),true);
        !is_array($r) && wrong_return('QQ error');
        $r['ret']!==0 && wrong_return('get user info failed');
        $r['openid'] = $json['openid'];
        return $r;
    }

    /*** 接入微信公众平台传入配置 */
    public function wechat_conn($conf){
        config('appid',$conf['appid']);
        config('redirect_uri',$conf['redirect_uri']);
        config('scope',$conf['scope']);
        //拼装url
        $url = " https://open.weixin.qq.com/connect/qrconnect?appid={$conf['appid']}&redirect_uri={$conf['redirect_uri']}&response_type=code&scope=snsapi_login&state=from_wechat_menu#wechat_redirect";
        return $url;
    }

    /** 处理并返回微信回调的内容 */
    public function wechat_callback($code,$state){
        ($state != "from_wechat_menu") && wrong_return("state参数回调错误");
        $conf = [
            'appid' => config('BKG_WEICHAT_LOGIN_APP_ID'),
            'appsecret' => config('BKG_WEICHAT_LOGIN_APP_SECRET'),
        ];

        //通过code获取微信的access_token 和 openid;
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$conf['appid'].'&secret='.$conf['appsecret'].'&code='.$code.'&grant_type=authorization_code';
        $result  = json_decode($this->_curl_get_content($token_url),true);
        empty($result['access_token']) && wrong_return('access_token获取失败');
        empty($result['openid']) && wrong_return('openid获取失败');
        $r['openid'] = $result['openid'];
        setcookie('accesstoken', $result['access_token'], time() + 86400);//设置有效期为1天

        //通过access_token和openid获取用户信息
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$result['access_token'].'&openid='.$result['openid'];
        $r = json_decode($this->_curl_get_content($url), TRUE);
        !is_array($r) && wrong_return('wechat error');
        !isset($r['unionid']) && wrong_return('get user info failed');
       return $r; //返回用户的基本信息
    }

    private function _curl_get_content($url)
    {
        // 创建一个新cURL资源
        $ch = curl_init();
        // 设置URL和相应的选项
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        //设置超时时间为3s
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 3);
        // 抓取URL并把它传递给浏览器
        $result = curl_exec($ch);
        //关闭cURL资源，并且释放系统资源
        curl_close($ch);
        return $result;
    }

    /** 接入微博公众平台传入配置 */
    public function weibo_conn($conf){
        config('client_id',$conf['client_id']);
        config('redirect_uri',$conf['redirect_uri']);
        //拼装URL
        $url = "https://api.weibo.com/oauth2/authorize?client_id={$conf['client_id']}&response_type=code&redirect_uri={$conf['redirect_uri']}&state=from_weibo_menu";
        return $url;
    }

    /** 处理并返回新浪微博的回调内容 */
    public function weibo_callback($code,$state){
        ($state != "from_weibo_menu") && wrong_return("state参数回调错误");
        $conf = [
            'client_id' => config('BKG_WEIBO_LOGIN_APP_ID'),
            'client_secret' => config('BKG_WEIBO_LOGIN_APP_SECRET'),
            'redirect_uri' => config('BKG_WEIBO_LOGIN_CALLBACK'),
        ];

        //通过code获取access_token和uid
        $keys['code'] = $code;
        $keys['redirect_uri'] = $conf['config'];
        $oauth = new SaeTOAuthV2($conf['client_id'],$conf['client_secret']);
        $result = $oauth->getAccessToken($keys);//获取微博的access_token
        empty($result['access_token']) && wrong_return('access_token获取失败');
        empty($result['uid']) && wrong_return('uid获取失败');
        $r['uid'] = $result['uid'];
        setcookie('access_token', $result['access_token'], time() + 86400);//设置有效期为1天

        //使用access_token获取调用新浪API的授权
        $c = new SaeTClientV2($conf['client_id'],$conf['client_secret'],$result['access_token']);
//        $uid_get = $c->get_uid();
        $r = $c->show_user_by_id($result['uid']);
        !is_array($r) && wrong_return('weibo error');
//      !isset($r['']) && wrong_return('get user info failed');
        return $r;//返回用户的基本信息
    }
}