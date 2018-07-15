<?php
namespace app\core\model;

Class CommonModel
{
    public $m_model;

    public function __construct()
    {
//        $m_auth = new AuthModel();
//        $m_auth->init();
    }

    public function get_all_conf(){
        $info = db('config')->field(array("code","value"))->select();
        return $info;
    }
    //获取配置信息
    public function get_conf($code)
    {
        $info = db('config')->where(array('code' => strtoupper($code)))->find();
        return $info["value"];
    }

    //设置配置信息
    public function set_conf($code, $value)
    {
        return db_func('config')->where(array('code' => strtoupper($code)))->update(array('value' => $value));
    }

    //批量获取配置信息 主键统一小写
    public function get_conf_by_keys($keys)
    {
        if(is_array($keys)){
            $where = ['code' => ['in', $keys]];
        }else if(is_string($keys)){
            $where = ['code' => ['like',$keys]];
        }else{
            return false;
        }
        $result = db('config')->where($where)->select();
        $map = [];
        foreach ($result as $each_result) {
            $map[strtolower($each_result['code'])] = $each_result['value'];
        }
        return $map;
    }

    //批量获取配置信息 主键统一小写
    public function get_conf_website()
    {
        $result = db(null)->table('sp_conf')->where(['name' => ['like', 'WEBSITE\_%']])->select();
        $map = [];
        foreach ($result as $each_result) {
            $map[strtolower($each_result['name'])] = $each_result['value'];
        }
        return $map;
    }
}