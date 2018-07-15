<?php
namespace app\core\model;

Class UserModel
{
    
    //根据字段获取用户信息
    public function get_user_info_by_filed($phone)
    {
        $info = db('member')->where('phone',$phone)->find();
        if(!empty($info)){
            return $info;
        }
        return false;
    }

    //检测是否为用户绑定的手机号
    public function get_user_bind_phone($mid,$phone){
       return db('member')->where(['member_id'=>$mid,'phone'=>$phone])->find();
    }

    //检测用户手机验证码是否过期(一分钟只能发一次手机验证码)
    public function get_phone_code_expire_time($phone,$types){
        return db("phone_code")->where(['phone'=>$phone,'type'=>$types])->field('create_time')->order('create_time desc')->limit(1)->find();
    }
}