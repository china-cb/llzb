<?php
namespace app\core\model;

Class ApiModel extends CommonModel
{
    public function __construct()
    {
        parent::__construct();
    }

    //写入手机验证码
    public function add_phone_code($post)
    {
        extract($post);
        $data = array(
            "session" => $session,
            "plat" => $plat,
            "use_times" => $use_times,
            "phone_code" => $phone_code,
            "data" => $data,
            "phone" => $phone,
            "type" => $type,
            "enable" => empty($enable) ? "true" : $enable,
            "expire_time" => $expire_time,
            'create_time' => time()
        );
        return db("phone_code")->insert($data);
    }

    //根据手机号获取验证码信息
    public function get_info_by_phone_and_code($phone, $phone_code)
    {
        return db("phone_code")->where("phone",$phone)->where("phone_code",$phone_code)->find();
    }

    //设置验证码已使用
    public function set_phone_code_used($phone, $phone_code)
    {
        $sql = 'UPDATE sp_phone_code SET `use_times` = `use_times` +1,`enable`="false",update_time="' . time() . '"
                WHERE phone = "' . $phone . '" AND phone_code = "' . $phone_code . '" AND enable="true"';
        return db('phone_code')->query($sql);
    }
}