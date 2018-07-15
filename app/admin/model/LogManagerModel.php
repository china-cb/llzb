<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/10
 * Time: 14:38
 */
namespace app\admin\model;

use think\Db;
Class LogManagerModel
{
    public function get_log_manager_list($model,$map,$type){
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('log_manager l','sp_');
        return $m->where('type',$type)
            ->where($condition)
            ->whereOr($map)
            ->join('member m','l.uid = m.member_id')
            ->order('id desc')
            ->field('l.*,m.num_id')
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }
}