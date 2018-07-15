<?php
namespace app\admin\controller;

use app\admin\model\CategoryModel;
use app\lib\Page;
use app\lib\Condition;
use app\lib\Tree;

Class Category extends Common
{

    public function __construct()
    {
        parent::__construct();
    }

    //分类默认页
    public function index()
    {
        $page = input('param.page', 1);
        $cate_list = new CategoryModel();
        $condition_rules = array(
            array(
                'field' => 'name',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $r = $cate_list->get_category($model);

        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        return $this->fetch();
    }

    //编辑/新增
    public function exec()
    {
        $type = input("param.type", 'add');
        $id = input("param.id", '');

        //编辑时候用到的内容
        if ($type == "edit" && chk_id($id)) {
            $m = new CategoryModel();

            $res = $m->get_cate_info_by_id($id);
            $this->assign('info', $res);
        }
        //获取当前列表的名称
        $this->assign('type', $type);
        return $this->fetch('form');
    }

    //执行添加列表
    public function update()
    {
        //获取表单信息
        $post = input("request.", []);
        extract($post);

        empty($code) && wrong_return('唯一标识符不能为空');
        empty($name) && wrong_return('列表名称不能为空');

        //添加进库
        $m = new CategoryModel();
        $res = $m->update_cate($post);
        ($res === '-1') && wrong_return('该唯一标识符已存在,请更换!');
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    //删除
    public function del()
    {
        $id = input("post.id");
        !chk_id($id) && wrong_return('删除失败');
        $m = new CategoryModel();
        !empty($m->get_category_list_by_mid($id)) && wrong_return('含有子列表,无法删除');
        $m->del_category($id) !== false && ok_return('删除成功');
        wrong_return('删除操作失败');
    }


    //分类列表页
    public function cate_list_index()
    {
        $page = input('param.page', 1);
        $mid = input('param.mid', '');
        !chk_id($mid) && die('您无权查看本页面');

        $m = new CategoryModel();
        //获取mid关联列表信息
        $m_info = $m->get_cate_info_by_id($mid);
        empty($m_info) && die('获取列表信息失败');
        $this->assign('m_info', $m_info);

        $condition_rules = array(
            array(
                'field' => 'name',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
            array(
                'field' => 'mid',
                'value' => input('param.mid', ''),
                'operator' => '='
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $r = $m->get_category_list($model);

        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        return $this->fetch();
    }


    //编辑/新增列表项
    public function cate_list_exec()
    {
        $type = input("param.type", 'add');
        $id = input("param.id", '');
        $mid = input("param.mid", '');

        !chk_id($mid) && die('您没有权限操作本页面');

        $m = new CategoryModel();

        //获取当前mid下的全部列表
        $category_list = $m->get_category_list_by_mid($mid);
        $tree = new Tree();
        $category_list =$tree->toFormatTree($category_list,'name');
        $this->assign('category_list', $category_list);

        //编辑时候用到的内容
        if ($type == "edit" && chk_id($id,true)) {
            //获取该ID对应的列表信息
            $res = $m->get_cate_list_info_by_id($id);
            $this->assign('info', $res);
        }
        //获取当前列表的名称

        $this->assign('type', $type);
        return $this->fetch('cate_list_form');
    }


    //执行添加列表项目
    public function cate_list_update()
    {
        //获取表单信息
        $post = get_all();
        extract($post);
        empty($pid) && $pid=0;
        !chk_id($pid,true) && wrong_return('上级列表项目错误');
        empty($name) && wrong_return('列表名称不能为空');

        //添加进库
        $m = new CategoryModel();
        $res = $m->update_cate_list($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    //删除
    public function cate_list_del()
    {
        $id = input("post.id");
        !chk_id($id) && wrong_return('删除失败');
        $m = new CategoryModel();
        !empty($m->get_list_by_pid($id)) && wrong_return('含有子列表,无法删除');
        $m->del_category_list($id) !== false && ok_return('删除成功');
        wrong_return('删除操作失败');
    }



}