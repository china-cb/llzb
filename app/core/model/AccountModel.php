<?php
namespace app\core\model;

use org\Crypt;

Class AccountModel
{

    //设置用户登录后的信息
    public function set_login_info()
    {
        //设置用户最后登录信息
        $data = [
            "last_login_time" => time(),
            "last_login_ip" => get_client_ip_true()
        ];
        db_func('users', 'md_')->where(["id" => get_user_id()])->update($data);
        //设置用户登录日志
        $data = [
            "uid" => get_user_id(),
            "user_login" => get_user_name(),
            "ip" => get_client_ip_true(),
            "login_time" => time()
        ];
        db_func('login', 'log_')->insert($data);
    }

    //根据字段获取用户信息***
    public function get_user_info_by_field($field, $value)
    {
        return db_func('member', 'sp_')->where([$field => $value])->find();
    }

    //根据字段设置用户信息
    public function set_user_by_condition($condition, $arr)
    {
        return db_func('member', 'sp_')->where($condition)->update($arr);
    }


    //根据session_id获取
    public function get_user_info_by_session_id($session_id)
    {
        $info = db_func('session', 'md_')->where(["session_id" => $session_id])->find();
        if (empty($info['uid'])) return false;
        if($info['enable']==='false'||intval($info['expire_time']) < NOW_TIME)return false;
        return db_func('users', 'md_')->where(['id' => $info['uid']])->find();
    }
}