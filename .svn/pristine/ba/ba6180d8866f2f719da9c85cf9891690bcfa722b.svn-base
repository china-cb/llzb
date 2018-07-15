<?php
namespace app\core\common;

use app\core\model\AccountModel;
use app\core\model\ApiModel;
use app\core\model\UserModel;

Class AccountCommon
{
    //获取用户业务信息
    public function get_user_bus_info($username)
    {
        $m = new UserModel();
        $info = $m->get_user_info_by_filed("username", $username);
        if (empty($info)) return false;
        //过期时间
        $expire_time_format = (NOW_TIME > $info['expire_time']) ? date("Y-m-d H:i:s") : date("Y-m-d H:i:s", intval($info['expire_time']));
        //总终端数
        $num = empty($info['num']) ? 0 : intval($info['num']);
        //PC端数
        $pc_num = empty($info['pc_num']) ? 0 : intval($info['pc_num']);
        //app端数
        $app_num = empty($info['app_num']) ? 0 : intval($info['app_num']);
        //插件端数
        $plugin_num = empty($info['plugin_num']) ? 0 : intval($info['plugin_num']);
        //剩余时间
        $last_time = (NOW_TIME > intval($info['expire_time'])) ? 0 : (intval($info['expire_time']) - NOW_TIME);
        $last_time = rt_auto_sec_split_type($last_time);

        $arr = [
            'expire_time' => $info['expire_time'],
            'expire_time_format' => $expire_time_format,
            'sum_num' => $num,
            'pc_num' => $pc_num,
            'app_num' => $app_num,
            'plugin_num' => $plugin_num,
            'last_time' => $last_time['time'],
            'last_time_type' => $last_time['type']
        ];
        return $arr;
    }

    public function get_bind_type($bind)
    {
        $type = null;
        if (preg_match(config('regular_rule')['username'], $bind)) {
            $type = 'username';
        } else if (preg_match(config('regular_rule')['phone'], $bind)) {
            $type = 'phone';
        } else if (preg_match(config('regular_rule')['email'], $bind)) {
            $type = 'email';
        }
        return $type;
    }

    //检测验证码
    public function check_code($phone, $phone_code)
    {

        if (empty($phone)) wrong_return("绑定号码不能为空");
        if (empty($phone_code)) wrong_return("验证码不能为空");
        $m_api = new ApiModel();

        //检测使用次数
        $try_times = intval(cache('try_times'));
        //同一个绑定号码尝试错误超过三次,设置改绑定号码全部验证码失效
        if ($try_times >= 3) {
            $m_api->set_expired_by_phone($phone);
            wrong_return("原验证码已经失效,请重新获取验证码");
        }
        $try_times++;
        cache('try_times', $try_times);

        $info = $m_api->get_info_by_phone_and_code($phone, $phone_code);
        if (empty($info)) {
            //设置验证码使用次数+1
            wrong_return("验证码错误");
        }
        //如果检测过期时间
        if (isset($expire) && $info['expire_time'] > 0 && $info['expire_time'] < time()) wrong_return("已过期");

        //检测是否可用
        if ($info['enable'] != 'true') wrong_return("验证码不可用");
        if ($info['phone_code'] != $phone_code) wrong_return("验证码不正确");
        //可用,设置验证码已使用
        $r = $m_api->set_phone_code_used($phone, $phone_code);
        if ($r !== false) return true;
        return false;
    }

    //公共登录
    public function com_login($value, $type = null)
    {
        $m = new AccountModel();
        switch ($type) {
            case 'id':
                $user_info = $m->get_user_info_by_field($type, $value);
                break;
            case 'username':
                $user_info = $m->get_user_info_by_field($type, $value);
                break;
            case 'session_id':
                $user_info = $m->get_user_info_by_session_id($value);
                break;
            default:
                $user_info = $value;
        }
        session('user',null);
        session("user", $user_info);
        //记录用户登录信息
        $m->set_login_info();

        //如果存在绑定信息
        $bind = session('bind_info');
        //如果有绑定标记
        if(!empty($bind)){
            if (!empty($bind['plat'])) {
                switch ($bind['plat']) {
                    case 'qq':
                        $m->set_user_by_condition(['id' => get_user_id()], ['qq_openid' => $bind['info']['openid']]);
                        break;
                    case 'wechat':
                        $m->set_user_by_condition(['id' => get_user_id()], ['wechat_unionid' => $bind['info']['unionid']]);
                        break;
                }
                session('bind_info', null);
            }
        }

        return true;
    }



}