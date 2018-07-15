<?php
namespace app\admin\model;

use think\Db;

Class AdminRoleModel extends BaseModel
{
    public $admin_role_list_model;

    public function __construct()
    {

    }

    //获取角色列表
    public function get_role_list($post)
    {
        $m = Db::table('admin_role_list');
        $sql = "SELECT SQL_CALC_FOUND_ROWS  *
        FROM  admin_role_list
        WHERE  status <> '-1' " . $post->wheresql .
            " ORDER BY id desc " . $post->limitData;

        $sql_count = "SELECT FOUND_ROWS() as num";
        $info = $m->query($sql);
        $num = $m->query($sql_count);


        if ($info) {
            foreach ($info as $key => $value) {
                if ($value['pid'] != 0) {
                    $info[$key]['parent_user'] = Db::table('admin_role_list')->field('name')->where(array("id" => $value['pid']))->find()['name'];
                }
                $info[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
                $info[$key]['update_time'] = date('Y-m-d H:i:s', $value['update_time']);
            }
        }

        $rt["data"] = $info;
        $rt["count"] = $num[0]["num"];
        return $rt;

    }

    //获取用户详情

    public function get_info_by_id($id)
    {
        $user_info = Db::table('admin_role_list')->where(array("id" => $id))->find();
        return $user_info;
    }

    public function get_all_role_list()
    {
        return Db::table('admin_role_list')->where("status <> '-1'")->select();
    }

    /**
     * 用于后台管理员选择角色
     * @return mixed
     */
    public function get_admin_role_list()
    {
        return Db::table('admin_role_list')->field('id,pid,name')->where("status <> '-1'")->select();
    }

    public function update_role($post)
    {
        $status = $name = $pid = $index_id = $tips = $is_super = $id = $auth_list = null;
        extract($post);

        //如果全部正确,执行写入数据
        $data = array(
            "id" => !empty($id) ? $id : "",
            "status" => $status,
            "name" => $name,
            "tips" => $tips,
            "is_super" => $is_super,
            "auth_list" => $auth_list,

        );
        !empty($index_id) && $data['index_id'] = $index_id;
        !empty($pid) && $data['pid'] = $pid;

        $m = db_func('role_list', 'admin_');
        if (chk_id($id)) {
            $r = $m->where(array("id" => $id))->update($data);
            return $r !== false;
        } else {
            return $m->insert($data);
        }
    }

    //删除角色
    public function del_role($id)
    {
        return Db::table('admin_role_list')->where(array("id" => $id))->update(array("status" => "-1"));
    }


}