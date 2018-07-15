<?php
namespace app\admin\model;
use PHPMailer\PHPMailer\Exception;
use think\Db;

class Finance extends BaseModel{
    public function __construct()
    {
        parent::__construct();
    }

    /** 充值订单列表 */
    static function get_recharge_list($model){
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('recharge r', 'sp_');
        return $m->where($condition)
            ->join('__MEMBER__ m','r.uid = m.member_id','LEFT')
            ->field('r.*,m.num_id,m.account,m.balance')
            ->order('r.create_time desc')
            ->paginate(config('pre_page'));
    }

    /** 购买订单列表 */
    static function get_buy_order_list($model){
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('buy_orders r', 'sp_');
        return $m->where($condition)
            ->join('__MEMBER__ m','r.uid = m.member_id','LEFT')
            ->field('r.*,m.num_id,m.account')
            ->order('r.create_time desc')
            ->paginate(config('pre_page'));
    }

    /** 使用订单列表 */
    static function get_use_order_list($model){
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('cost_orders c', 'sp_');
        return $m->where($condition)
            ->join('member m','c.uid = m.member_id','LEFT')
            ->field('c.*,m.num_id,m.account,m.balance')
            ->order('c.create_time desc')
            ->paginate(config('pre_page'));
    }
    /** 获取充值配置列表 */
    public function get_recharge_config_list($model){
        $condition = empty($model)?null:$model->wheresql;
        return db('recharge_conf')
            ->where($condition)
            ->where('status',1)
            ->paginate(config('pre_page'));
    }

    /** 获取充值配置详细信息 */
    public function get_recharge_conf_info_by_id($id){
        return db('recharge_conf')->where(['id'=>$id,'status'=>1])->find();
    }

    /** 执行添加/编辑 */
    public function update_recharge_conf_do($post){
        extract($post);
        $data = [
            'type'=>$type,
            'name'=>$name,
            'money'=>(int)$money,
            'unit'=>empty($unit)?"":$unit,
            'all_time'=>empty($all_time)?"":$all_time,
            'unit_price'=>empty($unit_price)?"":$unit_price,
            'extra'=>(int)$extra,
            'status'=>$status,
            'desc'=>$desc
        ];
        if(!empty($id)){
            $data['update_time'] = NOW_TIME;
            return db("recharge_conf")->where("id",$id)->update($data);
        }else{
            $data['create_time'] = NOW_TIME;
            return db("recharge_conf")->insert($data);
        }
    }

    /** 删除充值配置 */
    public function del_recharge_conf($id){
        return db("recharge_conf")->where('id',$id)->setField('status',-1);
    }

    /** 获取充值总金额 */
    public function get_all_recharge_money(){
        return db("recharge")->where("pay_status",1)->sum("money");
    }

    /** 获取购买总金额 */
    public function get_all_buy_order_money(){
        return db("buy_orders")->where("pay_status",1)->sum("money");
    }
}