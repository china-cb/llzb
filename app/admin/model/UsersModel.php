<?php
namespace app\admin\model;

use app\admin\model\AdminRoleModel;
use think\Db;

Class UsersModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }


    /***根据id获取用户名*/
    public function get_user_info_by_id($id)
    {
        $m = db('users', 'admin_');
        return $m->where(array("id" => $id))->where("status", 'neq', '-1')->find();
    }

    /*** 获取列表 */
    public function get_users_list($model)
    {
        $condition = $model->wheresql;
        $m = db_func('users u', 'admin_');
        return $m->join(['role_list'=>'r', 'admin_'],'u.role_list = r.id','LEFT')
            ->where($condition)
//            ->where('u.status', 'neq', '-1')
            ->order('u.id desc')
            ->field("u.*,r.name")
            ->paginate(config('pre_page'));
    }

    /***根据id返回管理员用户信息*/
    public function get_admin_info_by_id($id)
    {
        return db_func('users', 'admin_')->where(['id' => $id])->find();
    }

    /***根据user_login返回管理员用户信息*/
    public function get_admin_info_by_user_login($user_login)
    {
        return db_func('users', 'admin_')->where(['user_login' => $user_login])->find();
    }


    /** 获取用户详情 */
    public function get_info_by_id($id)
    {
        $user_info = db('member')->where("member_id",$id)->find();
        return $user_info;
    }

    //获取用户类型
    public function get_user_type_by_id($id)
    {
        return db('users')->where(['id' => intval($id)])->getField('type');
    }

    //添加admin
    public function admin_update($post)
    {
        $user_login = $img_id = $user_pass = $status = $nick_name = null;
        extract($post);

        //如果全部正确,执行写入数据
        $data = array(
            "user_login" => $user_login,
            "status" => $status,
            "nick_name" => $nick_name,
            "img_id" => $img_id,
            "role_list" => !empty($role_list) ? arr_to_str($role_list) : '',
        );
        if (!empty($user_pass)) {
            $data['user_pass'] = md6($user_pass);
        }

        $m = db_func('users', 'admin_');
        if (!empty($id) && chk_id($id)) {
            $data['update_time'] = time();
            $r = $m->where(array("id" => $id))->update($data);
            return $r !== false;
        } else {
            $data['create_time'] = time();
            return $m->insert($data);
        }
    }

    //删除admin
    public function admin_del($id)
    {
        return db_func('users', 'admin_')->where(["id" => $id])->update(["status" => "-1"]);
    }

    //检测是否已存在
    public function check_exist($username = '', $phone = '')
    {
        $sql = 'SELECT * FROM sp_users WHERE 1=1';
        if ($username && !$phone) {
            $sql .= ' AND username="' . $username . '"';
        } elseif ($phone && !$username) {
            $sql .= ' AND phone="' . $phone . '"';
        } elseif ($username && $phone) {
            $sql .= ' AND (phone="' . $phone . '" OR username="' . $username . '")';
        }
        return db('users')->query($sql);
    }

    //获取后台用户列表
    public function get_admin_users_list($post)
    {
        $m = db('users');
        $sql = "SELECT SQL_CALC_FOUND_ROWS  *
        FROM  sp_users
        WHERE user_group = 1 AND status <> '-1' AND type <> 2" . $post->wheresql .
            " ORDER BY id desc " . $post->limitData;

        $sql_count = "SELECT FOUND_ROWS() as num";
        $info = $m->query($sql);
        $num = $m->query($sql_count);

        foreach ($info as $key => $value) {
            $info[$key]['user_face'] = $this->get_one_image_src($value['user_pic']);
        }

        foreach ($info as &$k) {

            if ($k['role_list']) {
                if (strpos($k['role_list'], ',')) {
//                    $temp = Db::table('admin_role_list')->field('name')->where('id','in',$k['role_list'])->where('status','<>',-1)->select();
                    $temp = Db::table('admin_role_list')->field('name')->where('id', 'in', $k['role_list'])->select();
                    $res = array_column($temp, "name");
                    $k['role_name'] = implode(',', $res);
                } else {
//                    $k['role_name'] = Db::table('admin_role_list')->field('name')->where('id',$k['role_list'])->where('status','<>',-1)->find()['name'];
                    $k['role_name'] = Db::table('admin_role_list')->field('name')->where('id', $k['role_list'])->find()['name'];
                }
            } else {
                $k['role_name'] = '';
            }
        }
        $rt["data"] = $info;
        $rt["count"] = $num[0]["num"];
        return $rt;

    }

    //关注人的id
    public function get_focus_uid($id,$mid){
        return db_func('friends','sp_')->where(['uid' => $id,'friend_uid' => $mid])->field('id')->find();
    }
    //粉丝id
    public function go_new_focus($id,$mid){
        $rt = db_func('friends','sp_')->where(['uid' => $mid,'friend_uid' => $id])->field('id')->find();
        if(empty($rt)){
            return db_func('friends','sp_')->insert(['uid' => $mid,'friend_uid'=>$id,'status'=>2,'createline'=>NOW_TIME]);
        }
    }
    //标记关注
    public function go_focus($uid){
        return db_func('friends','sp_')->where('id',$uid)->update(['status' => 2,'createline' => NOW_TIME]);
    }
    //添加关注

    //修改
    public function del_select($ids){
        return db('users')->where(array('id' => ['in', $ids]))->update(array('status' => -1));
    }

    public function import_users($users){
        return db('users')->addAll($users);
    }


}