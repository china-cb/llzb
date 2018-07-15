<?php
namespace app\admin\controller;

use think\Controller;
use app\lib\Condition;
use app\admin\model\Finance as Finance_Model;

/**
 * 用户账户控制器
 * author: hunter
 * date: 2016-8-01 3:14
 */
class Finance extends Common{

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * 充值订单列表
     */
    public function recharge_list()
    {
        $page = input('param.page', 1);
        $search_word = input('param.search_word','');
        $condition_rules = array(
            array(
                'field' => 'm.num_id',
                'value' => $search_word,
                'operator' => '='
            ),
            array(
                'field' => 'm.account',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'r.order_id',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'r.create_time',
                'value' => strtotime(input('param.start_time', '')),
                'operator' => '<='
            ),
            array(
                'field' => 'r.create_time',
                'value' => strtotime(input('param.end_time', '')),
                'operator' => '>='
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new Finance_Model();
        $r = $m->get_recharge_list($model);
        //获取充值总金额
        $recharge_all = $m->get_all_recharge_money();
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total', $r->total());
        $this->assign('recharge_all',number_format($recharge_all,2));
        return $this->fetch();
    }

    /**
     * 购买订单列表
     */
    public function buy_order_list()
    {
        $page = input('param.page', 1);
        $search_word = input('param.search_word','');
        $condition_rules = array(
            array(
                'field' => 'm.num_id',
                'value' => $search_word,
                'operator' => '='
            ),
            array(
                'field' => 'm.account',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'r.order_id',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'r.create_time',
                'value' => strtotime(input('param.start_time', '')),
                'operator' => '<='
            ),
            array(
                'field' => 'r.create_time',
                'value' => strtotime(input('param.end_time', '')),
                'operator' => '>='
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new Finance_Model();
        $r = $m->get_buy_order_list($model);
        //获取订单总金额
        $all_money = $m->get_all_buy_order_money();
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total', $r->total());
        $this->assign('all_money',number_format($all_money,2));
        return $this->fetch();
    }

    /**
     * 使用订单列表
     */
    public function use_order_list()
    {
        $page = input('param.page', 1);
        $search_word = input('param.search_word','');
        $condition_rules = array(
            array(
                'field' => 'c.order_id',
                'value' => $search_word,
                'operator' => '='
            ),
            array(
                'field' => 'm.account',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'c.create_time',
                'value' => strtotime(input('param.start_time', '')),
                'operator' => '<='
            ),
            array(
                'field' => 'c.create_time',
                'value' => strtotime(input('param.end_time', '')),
                'operator' => '>='
            ),
        );
        
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new Finance_Model();
        $r = $m->get_use_order_list($model);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total', $r->total());
        return $this->fetch();
    }

    /** 获取套餐配置列表 */
    public function recharge_config(){
        $page = input("param.page",1);
        $condition_rules = [
            array(
                'field'=>'name',
                'value'=>input('param.search_word',''),
                'operator'=>'='
            ),
        ];
        $model = new Condition($condition_rules,$page);
        $model->init();

        $m = new Finance_Model();
        $r = $m->get_recharge_config_list($model);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total()
            ]
        );
        return $this->fetch();
    }

    /** 新增/编辑界面 */
    public function exec(){
        $type = input('param.type','add');
        $id = input('param.id','');
        $m = new Finance_Model();

        //编辑时用到的内容
        if($type == "edit" || $type == "look" && chk_id($id) ){
            $res = $m->get_recharge_conf_info_by_id($id);
            $this->assign('info',$res);
        }
        //获取当前列表名称
        $this->assign([
            'type'=>$type,
        ]);
        return $this->fetch('form');
    }


    /** 执行新增/更新队列任务 */
    public function update(){
        $post = input('param.',[]);
        extract($post);
        empty($type) && wrong_return("套餐配置类型不能为空");
        empty($name) && wrong_return('套餐名称不能为空');
        (!is_numeric($money) || $money<0) && wrong_return("套餐价格格式不正确");
        (!is_numeric($extra) || $extra<0) && wrong_return('额外赠送格式不正确');
        empty($desc) && wrong_return('套餐描述不能为空');
        empty($status) && wrong_return('状态不能为空');
        empty($unit) && wrong_return("套餐单位不能为空");
        if($type == 2){
            empty($all_time) && wrong_return("套餐总时长不能为空");
            empty($unit_price) && wrong_return("套餐单价不能为空");
        }

        $m = new Finance_Model();
        $re = $m->update_recharge_conf_do($post);
        $re !== false && ok_return('操作成功');
        wrong_return('操作失败');
    }

    /** 删除套餐配置 */
    public function del_recharge_conf(){
        $id = input('param.id','');
        empty($id) && wrong_return('id不存在,删除失败');
        $m = new Finance_Model();
        $re = $m->del_recharge_conf($id);
        $re !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }
}