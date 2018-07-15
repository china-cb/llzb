<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/2/5
 * Time: 13:13
 */

namespace app\admin\model;


class ApplicationModel
{
      /** 获取应用场景的菜单列表 */
    public function get_app_category($model){
        $condition = !empty($model) ? $model->wheresql : null;
        return db("app_category")
            ->where($condition)
            ->where('status',1)
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }

    /** 根据id获取分类信息 */
    public function get_app_category_by_id($id){
        return db("app_category")->where("id",$id)->find();
    }

    /*** 新增或更新应用场景分类*/
    public function update_app_category($post){
        extract($post);
        $data = [
            'title'=>$title,
            'status' => intval($status),
        ];
        if(!empty($id)){
            $info = db("app_category")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("app_category")->insert($data);
        }
    }

    /*** 删除主题类型 */
    public function del_app_category($id){
        return db('app_category')->where('id',$id)->setField('status',-1);
    }

    /** 获取主题类型子类列表 */
    public function get_category_child_list($model,$id){
        $condition = !empty($model) ? $model->wheresql : null;
        return db("app_category_child a")
            ->where($condition)
            ->join('app_category c','c.id = a.pid','LEFT')
            ->order('a.id desc')
            ->field('a.*,c.title')
            ->where(['a.pid'=>$id,'a.status'=>1])
            ->paginate(config('pre_page'),false,['query' => request()->param()]);
    }

    /** 获取所有上级分类 */
    public function get_category_list(){
        return db("app_category")->where("status",1)->select();
    }

    /** 获取id获取子类型信息 */
    public function get_category_child_info_by_id($id){
        return db("app_category_child")->where("id",$id)->find();
    }

    /** 新增或更新文章 */
    public function update_live_category_child($post){
        extract($post);
        $data = [
            'pid' => $pid,
            'name'=>$name,
            'desc'=>$desc,
            'cover'=>$cover,
            'content'=>$content,
            'type'=>$type,
            'status' => intval($status),
        ];
        if(!empty($id)){
            $data['update_time'] = NOW_TIME;
            $info = db("app_category_child")->where('id',$id)->update($data);
            return $info !== false;
        }else{
            $data['create_time'] = NOW_TIME;
            return db("app_category_child")->insert($data);
        }
    }

    /** 删除主题子类型分类 */
    public function del_category_child($id){
        return db("app_category_child")->where('id',$id)->setField("status",-1);
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