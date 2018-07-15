<?php
namespace app\admin\model;

class AuthModel
{

    //获取角色列表
    public function get_role_list($model)
    {
        $condition = $model->wheresql;
        $m = db_func('role_list r', 'admin_');
        return $m->field('r.*,r2.title index_name')
            ->where($condition)
            ->where('r.`status`', 'neq', '-1')
            ->join(['menu r2', 'admin_'], 'r2.id = r.index_id', 'LEFT')
            ->order('r.id desc')
            ->paginate(config('pre_page'));
    }

    //获取全部角色列表
    public function get_all_role_list()
    {
        return db_func('role_list', 'admin_')->where(['status' => ['neq', '-1']])->order("id desc")->select();
    }

    //获取角色信息
    public function get_role_info_by_id($id)
    {
        return db_func('role_list', 'admin_')->where(['id' => $id])->find();
    }


    //获取全部菜单列表
    public function get_all_menu_list()
    {
        return db_func('menu', 'admin_')->where("status", "neq", -1)->order("sort desc,id")->select();
    }

    //根据ids获取详情
    public function get_privilege_list_by_ids($ids)
    {
        if (empty($ids)) return false;
        $m = db_func('role_list', 'admin_');
        return $m->where("id", "in", $ids)->select();
    }

    //根据用户获取用户有权限的菜单
    public function get_user_auth_tree($uid)
    {

        $m_user = new UsersModel();
        $user_info = $m_user->get_admin_info_by_id($uid);

        if (empty($user_info["role_list"])) return false;
        $role_list = $user_info["role_list"];
        if (empty($role_list)) return false;
        $role_list = str_implode($role_list);

        //获取用户组的权限
        $privilege_list = $this->get_privilege_list_by_ids($role_list);

        if (empty($privilege_list)) return false;

        //拼合权限列表,检测是否为超级管理员
        $sp = "";
        foreach ($privilege_list as $k => $v) {
            $sp .= $v['auth_list'] . ',';
            if ($v['is_super'] === 'true') {
                $list = $this->get_all_menu_list();
                if (!empty($list)) {
                    return list_to_tree($list);
                }
                return false;
            }
        }

        $sp = str_to_arr($sp);
        //获取全部菜单列表
        $m_menu = new MenuModel();
        $list = $m_menu->get_menu_list_by_ids($sp);
        if (!empty($list)) {
            return list_to_tree($list);
        } else {
            return false;
        }
    }
}