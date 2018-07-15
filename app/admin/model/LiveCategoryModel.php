<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/10/29
 * Time: 11:06
 */

namespace app\admin\model;


use think\Model;
class LiveCategoryModel extends Model
{
     /** 获取pc直播主题主类型列表 */
    public function get_live_category_list($model){

        $condition = !empty($model) ? $model->wheresql : null;
        return db("live_category")
            ->where($condition)
            ->paginate(config('pre_page'));
    }

    /** 根据id获取直播主题类型信息 */
    public function get_category_info_by_id($id){
        return db("live_category")->where("id",$id)->find();
    }

    /*** 新增或更新主题类型 */
    public function update_live_category($post){
        extract($post);
        $data = [
            'title'=>$title,
            'status' => intval($status),
        ];

        if(!empty($id)){
            $info = db("live_category")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("live_category")->insert($data);
        }
    }

    /*** 删除主题类型 */
    public function del_live_category($id){
        return db('live_category')->delete($id);
    }

    /** 获取主题类型子类列表 */
    public function get_category_child_list($model,$id){
        $condition = !empty($model) ? $model->wheresql : null;
        return db("live_category_child h")
            ->where($condition)
            ->join('live_category c','c.id = h.pid')
            ->order('h.id desc')
            ->field('h.*,c.title')
            ->where('h.pid',$id)
            ->paginate(config('pre_page'));
    }

    /** 获取所有主题类型 */
    public function get_category_list(){
        return db("live_category")->select();
    }

    /** 获取id获取子类型信息 */
    public function get_category_child_info_by_id($id){
        return db("live_category_child")->where("id",$id)->find();
    }

    /** 新增或更新主题子类型 */
    public function update_live_category_child($post){
        extract($post);
        $data = [
            'pid' => $pid,
            'name'=>$name,
            'status' => intval($status),
        ];
        if(!empty($id)){
            $info = db("live_category_child")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("live_category_child")->insert($data);
        }
    }

    /** 删除主题子类型分类 */
    public function del_category_child($id){
        return db("live_category_child")->delete($id);
    }
}