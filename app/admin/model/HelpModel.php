<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/2/3
 * Time: 14:03
 */

namespace app\admin\model;


class HelpModel
{
    /** 帮助列表 */
    public function get_help_category($model){

        $condition = !empty($model) ? $model->wheresql : null;
        return db("help_category")
            ->where($condition)
            ->where(['fid'=>0,'status'=>1])
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }

    /** 根据id获取帮助分类信息 */
    public function get_help_category_by_id($id){
        return db("help_category")->where("id",$id)->find();
    }

    /*** 新增或更新帮助顶级菜单*/
    public function update_help_category($post){
        extract($post);
        $data = [
            'fid'=>0,
            'title'=>$title,
            'status' => intval($status),
        ];

        if(!empty($id)){
            $info = db("help_category")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("help_category")->insert($data);
        }
    }

    /*** 删除主题类型 */
    public function del_help_category($id){
        return db('help_category')->where('id',$id)->setField('status',-1);
    }

    /*** 删除二级分类*/
    public function del_help_category_do($id){
        return db('help_category')->where('id',$id)->setField('status',-1);
    }

    /*** 新增或更新帮助二级分类*/
    public function update_help_category_do($post){
        extract($post);
        $data = [
            'fid'=>$fid,
            'title'=>$title,
            'status' => intval($status),
        ];

        if(!empty($id)){
            $info = db("help_category")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("help_category")->insert($data);
        }
    }

    /** 获取主题类型子类列表 */
    public function get_category_child_list($model,$id){
        $condition = !empty($model) ? $model->wheresql : null;
        return db("help_category_child h")
            ->where($condition)
            ->join('help_category c','c.id = h.pid','LEFT')
            ->order('h.id desc')
            ->field('h.*,c.title')
            ->where(['h.pid'=>$id,'h.status'=>1])
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }

    /** 获取所有顶级菜单 */
    public function get_category_list(){
        return db("help_category")->where(['fid'=>0,'status'=>1])->select();
    }

    /** 获取所有二级菜单 */
    public function get_category_list_two(){
        return db("help_category")->where("status",1)->where("fid","<>",0)->select();
    }

    /** 获取id获取子类型信息 */
    public function get_category_child_info_by_id($id){
        return db("help_category_child")->where("id",$id)->find();
    }

    /** 新增或更新主题子类型 */
    public function update_live_category_child($post){
        extract($post);
        $data = [
            'pid' => $pid,
            'name'=>$name,
            'content'=>$content,
            'status' => intval($status),
        ];
        if(!empty($id)){
            $info = db("help_category_child")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("help_category_child")->insert($data);
        }
    }

    /** 删除主题子类型分类 */
    public function del_category_child($id){
        return db("help_category_child")->where('id',$id)->setField("status",-1);
    }

    /** 获取帮助二级分类 */
    public function get_category_list_do($model,$id){
        $condition = !empty($model) ? $model->wheresql : null;
        return db("help_category")
            ->where($condition)
            ->where(['fid'=>$id,'status'=>1])
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }
}