<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/10/29
 * Time: 11:05
 */

namespace app\admin\controller;


use app\admin\model\LiveCategoryModel;
use app\lib\Condition;

class LiveCategory extends Common
{
    /** 直播主题主类型列表 */
    public function index(){
        $page = input("param.page",1);

        $condition_rules = [
            array(
                'field'=>'title',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
        ];

        $model = new Condition($condition_rules,$page);
        $model->init();
        $m = new LiveCategoryModel();
        $r = $m->get_live_category_list($model);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total()
            ]
        );
        return $this->fetch();
    }

    /*** 添加/编辑 */
    public function exec(){
        $type = input('param.type','add');
        $id = input('param.id','');
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $m = new LiveCategoryModel();
            $res = $m->get_category_info_by_id($id);
            $this->assign('info',$res);
        }
        //获取当前列表名称
        $this->assign("type",$type);
        return $this->fetch('form');
    }

    /*** 执行添加列表 */
    public function update(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
        empty($title) && wrong_return("主题类型名称不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new LiveCategoryModel();
        $res = $m->update_live_category($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /*** 删除主题类型 */
    public function del(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new LiveCategoryModel();
        $m->del_live_category($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }

    /***主题类型详情列表 */
    public function category_child_list(){
        $page = input("param.page",1);
        $id = input("param.id");
        empty($id) && !is_numeric($id) && wrong_return("分类id不正确");//分类id不正确
        $condition_rules = [
            array(
                'field'=>'h.name',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
        ];
        $model = new Condition($condition_rules,$page);
        $model->init();
        $m = new LiveCategoryModel();
        $r = $m->get_category_child_list($model,$id);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total(),
                'pid'=>$id
            ]
        );
        return $this->fetch();
    }

    /*** 添加主题类型子分类 */
    public function category_child_form(){
        $type = input('param.type','add');
        $pid = input('param.pid','');
        $id = input('param.id','');
        empty($pid) && !is_numeric($pid) && wrong_return("分类id不正确");//分类id不正确
        //检测父级id是否存在
        $m = new LiveCategoryModel();
        $info = $m->get_category_list();
        !$info && wrong_return("分类信息不存在"); //分类信息不存在
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $m = new LiveCategoryModel();
            $res = $m->get_category_child_info_by_id($id);
            $this->assign('child_info',$res);
        }
        $this->assign('type',$type);
        $this->assign('pid',$pid);
        $this->assign('info',$info);
        return $this->fetch();
    }

    /** 执行添加/更新主题类型分类 */
    public function update_category_child(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
//        dump($post);
        empty($pid) && wrong_return("上级类型不能为空");
        empty($name) && wrong_return("主题类型名称不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new LiveCategoryModel();
        $res = $m->update_live_category_child($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /** 删除主题子类型分类 */
    public function del_live_category_child(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new LiveCategoryModel();
        $m->del_category_child($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }
}