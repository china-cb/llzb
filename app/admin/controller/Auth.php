<?php
namespace app\admin\controller;

use app\admin\model\AdminRoleModel;
use app\admin\model\AuthModel;
use app\admin\model\MenuModel;
use app\lib\Condition;
use app\lib\Tree;

Class Auth extends Common
{
    public function __construct()
    {
        parent::__construct();
    }

    //角色列表
    public function index()
    {
        $page = input('param.page', 1);
        $cate_list = new AuthModel();
        $condition_rules = array(
            array(
                'field' => 'r.name',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $r = $cate_list->get_role_list($model);
        $tree = new Tree();
        $list = $tree->toFormatTree($r->all(), 'name');

        $this->assign('page', $r->render());
        $this->assign('list', $list);
        return $this->fetch();
    }


    //查看/编辑/新增
    public function exec()
    {
        $m = new AuthModel();
        //查看,编辑
        $id = input("param.id", null);
        $type = input("param.type", null);


        //获取全部操作菜单项
        $m_menu = new MenuModel();
        $menu_list = $m_menu->get_all_menu_list();
        $tree = new Tree();
        $menu_list = $tree->toFormatTree($menu_list, 'title');
        $this->assign('menu_list', $menu_list);

        //获取全部角色
        $role_list = $m->get_all_role_list();
        $tree = new Tree();
        $role_list = $tree->toFormatTree($role_list, 'name');
        $role_list = array_merge(array(0 => array('id' => 0, 'title_show' => '请选择')), $role_list);

        $this->assign('role_list', $role_list);

        //形成zTree所需要的数据格式
        $auth_list_arr = array();
        if (!empty($id)) {
            !is_numeric($id) && wrong_return('id格式不正确');
            //获取详情
            $info = $m->get_role_info_by_id($id);
            empty($info) && wrong_return('获取信息失败');
            $this->assign("info", $info);
            if ($type == 'edit') {
                $this->assign('type', 'edit');//编辑
            } else {
                $this->assign('type', 'see');//查看
            }
            !empty($info) && $auth_list_arr = explode(',', $info['auth_list']);
        } //新增
        else {
            $this->assign('type', 'add');//新增
        }

        if (!empty($menu_list)) {
            foreach ($menu_list as $key => $value) {
                if (in_array($value['id'], $auth_list_arr)) {
                    $menu_list[$key]['checked'] = true;
                }
                if (is_null($value['url'])) {
                    $menu_list[$key]['open'] = true;
                }
                $menu_list[$key]['pId'] = $value['pid'];
                $menu_list[$key]['name'] = $value['title'];
                unset($menu_list[$key]['pid']);
                unset($menu_list[$key]['url']);
            }
        }
        $this->assign('menu_list_json', json_encode($menu_list));

        return $this->fetch('form');
    }

    //执行添加角色
    public function update()
    {
        $post = input("post.");
        $id = null;
        extract($post);
        !empty($id) && !chk_id($id) && wrong_return('id格式不正确');
        $m = new AdminRoleModel();

        $rt = $m->update_role($post);
        $rt && ok_return('恭喜!操作成功!');
        wrong_return('数据写入失败');
    }

    //删除角色
    public function del()
    {
        $id = input("post.id");
        (empty($id) || !is_numeric($id)) && wrong_return('参数异常,删除失败');
        $m = new AdminRoleModel();
        $m->del_role($id) !== false && ok_return('删除成功');
        wrong_return('删除操作失败');
    }


}