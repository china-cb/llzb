<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/2/3
 * Time: 13:58
 */

namespace app\admin\controller;


use app\admin\model\HelpModel;
use app\lib\Condition;

class Help extends Common
{
    /** 帮助列表 */
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
        $m = new HelpModel();
        $r = $m->get_help_category($model);
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
            $m = new HelpModel();
            $res = $m->get_help_category_by_id($id);
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
        empty($title) && wrong_return("帮助菜单名称不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new HelpModel();
        $res = $m->update_help_category($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /*** 删除帮助分类*/
    public function del(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new HelpModel();
        $m->del_help_category($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }

    /***帮助二级分类详情列表 */
    public function category_list(){
        $page = input("param.page",1);
        $id = input("param.id");
        $title = input("param.title",'');
        empty($id) && !is_numeric($id) && wrong_return("分类id不正确");//分类id不正确
        $condition_rules = [
            array(
                'field'=>'title',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
        ];
        $model = new Condition($condition_rules,$page);
        $model->init();
        $m = new HelpModel();
        $r = $m->get_category_list_do($model,$id);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total(),
                'pid'=>$id,
                'title'=>$title
            ]
        );
        return $this->fetch();
    }

    /*** 添加/编辑 */
    public function two_exec(){
        $type = input('param.type','add');
        $id = input('param.id','');
        //获取所有分类类型
        $m = new HelpModel();
        $c_info = $m->get_category_list();
        !$c_info && wrong_return("分类信息不存在"); //分类信息不存在
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $res = $m->get_help_category_by_id($id);
            $this->assign('info',$res);
        }
        //获取当前列表名称
        $this->assign("type",$type);
        $this->assign("c_info",$c_info);
        return $this->fetch('two_form');
    }

    /*** 执行添加列表 */
    public function two_update(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
        empty($fid) && wrong_return("所属上级分类不能为空");
        empty($title) && wrong_return("帮助分类名称不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new HelpModel();
        $res = $m->update_help_category_do($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /*** 删除帮助分类*/
    public function two_del(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new HelpModel();
        $m->del_help_category_do($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }

    /***帮助分类详情列表 */
    public function category_child_list(){
        $page = input("param.page",1);
        $id = input("param.id");
        $title = input("param.title",'');
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
        $m = new HelpModel();
        $r = $m->get_category_child_list($model,$id);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total(),
                'pid'=>$id,
                'title'=>$title
            ]
        );
        return $this->fetch();
    }

    /*** 添加帮助分类子分类 */
    public function category_child_form(){
        $type = input('param.type','add');
        $pid = input('param.pid','');
        $id = input('param.id','');
        $title = input('param.title','');
        empty($pid) && !is_numeric($pid) && wrong_return("分类id不正确");//分类id不正确
        $m = new HelpModel();
        //获取所有二级分类类型
        $info = $m->get_category_list_two();
        !$info && wrong_return("分类信息不存在"); //分类信息不存在
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $m = new HelpModel();
            $res = $m->get_category_child_info_by_id($id);
            $this->assign('child_info',$res);
        }

        $this->assign('type',$type);
        $this->assign('pid',$pid);
        $this->assign('info',$info);
        $this->assign('title',$title);
        return $this->fetch();
    }

    /** 获取百度编辑器中的内容 */
    public function get_editor_content(){
        $id = input('param.id');
        empty($id)&& wrong_return("分类id不正确");//分类id不正确
        $m = new HelpModel();
        $res = $m->get_category_child_info_by_id($id);
        !empty($res) && ok_return("success",1,$res['content']);
    }
    /** 执行添加/更新主题类型分类 */
    public function update_category_child(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
        empty($pid) && wrong_return("上级分类名称不能为空");
        empty($name) && wrong_return("帮助标题名称不能为空");
        empty($content) && wrong_return("帮助内容不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new HelpModel();
        $res = $m->update_live_category_child($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /** 删除主题子类型分类 */
    public function del_live_category_child(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new HelpModel();
        $m->del_category_child($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }
}