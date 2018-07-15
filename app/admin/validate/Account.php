<?php
namespace app\index\validate;

use think\Validate;

class Account extends Validate
{
    // 验证规则
    protected $rule = [
        'nickname' => 'require|/(?!^[0-9]+$)(?!^[A-z]+$)(?!^[^A-z0-9]+$)^.{6,16}$/',
        'mobile'   => 'require|"/^1\\d{10}$/"',
        '' => 'dateFormat:Y-m-d',
    ];
    protected $message  =   [
        'name.require' => '必须存在',
        'mobile.max'   => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',    
    ];

}