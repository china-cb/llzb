<?php
namespace app\admin\model;

use think\Db;

Class AccountModel
{

    private $member;

    /***检测用户名*/
    public function get_user_info_by_user_login($user_login)
    {
        $m = db_func("users", "admin_");
        return $m->where(['user_login' => $user_login])->where('status', 'neq', -1)->find();
    }

    /** 获取用户角色信息 */
    public function get_user_role_list($role_list){
        $m = db_func("role_list","admin_");
        return $m->where("id","in",$role_list)->field('name')->select();
    }

    /***设置用户登录后的信息*/
    public function set_login_info()
    {
        //设置用户最后登录信息
        $data = [
            "last_login_time" => time(),
            "last_login_ip" => get_client_ip_true()
        ];
        db_func('users', 'admin_')->where(["id" => get_admin_id()])->update($data);
        db_func('users', 'admin_')->where(["id" => get_admin_id()])->setInc('login_times');
        //设置用户登录日志
        $data = [
            "uid" => get_admin_id(),
            "user_login" => get_admin_name(),
            "ip" => get_client_ip_true(),
            "login_time" => time()
        ];
        db_func('login', 'log_')->insert($data);
    }

    /***刷新已登录用户session*/
    public function refresh_login_user_session($session = false)
    {
        $m = db_func('session', 'admin_');
        //设置用户最后登录信息,已登录更新,未登录新增
        $data = [
            "expire_time" => time() + 60,
            "ip" => get_client_ip_true()
        ];
        if ($session) {

            $data['session_id'] = md5(get_admin_id() . time() . rand_str('r', 1, 4));
            session('login_session',$data['session_id']);
        }
        $r = $m->where(['uid' => get_admin_id()])->find();

        $m2 = db_func('session', 'admin_');
        if ($r) {
            $m2->where(['uid' => get_admin_id()])->update($data);
        } else {

            $data['uid'] = get_admin_id();
            $m2->insert($data);
        }
    }


    //获取全部用户列表
    public function get_user_list($post)
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS *
        FROM  sp_users
        WHERE  status <> '-1' " . $post->wheresql .
            " ORDER BY id desc " . $post->limitData;

        $sql_count = "SELECT FOUND_ROWS() as num";
        $user_info = $this->m_model->query($sql);
        $num = $this->m_model->query($sql_count);

        $rt["data"] = $user_info;
        $rt["count"] = $num[0]["num"];
        return $rt;
    }


    //根据id获取用户名
    public function get_user_info_by_id($id)
    {
        return db("users")->where(array("id" => $id))->where("status<>-1")->find();
    }

    //添加新用户
    public function update_user($post)
    {
        $status = $username = $user_pass = $type = $phone = $nick_name = $from_domain = $section = $sex = null;
        extract($post);
        $data = array(
            "status" => $status,
            "username" => strtolower($username),
            "user_pass" => md6($user_pass),
            "type" => $type,
            "phone" => $phone,
            "nick_name" => $nick_name,
            "from_domain" => $from_domain,
            "section" => $section,
            "sex" => $sex,
            "create_time" => NOW_TIME
        );

        if (!empty($id) && is_numeric($id)) {
            $info = db("users")->where(array("id" => $id))->save($data);
            return $info !== false;
        } else {
            return db("users")->add($data);
        }
    }

    //保存用户
    public function save_user($post)
    {
        extract($post);
        $data = array(
            "status" => $status,
            "type" => $type,
            "phone" => $phone,
            "nick_name" => $nick_name,
            "sex" => $sex,
            "section" => $section,
            "update_time" => NOW_TIME
        );
        !empty($user_pass) && $data["user_pass"] = md6($user_pass);
        return db("users")->where(array("id" => $id))->save($data);
    }

    //删除菜单
    public function del_user($id)
    {
        return db("users")->where(array("id" => $id))->save(array("status" => "-1"));
    }

    //保存用户最后一次登录ip和时间
    public function save_last_ip_and_time($username)
    {
        $data = array(
            "last_login_ip" => get_client_ip(),
            "last_login_time" => time(),
        );
        $this->add_login_log($username);
        return db("users")->where(array("username" => $username))->save($data);

    }

    //添加登录日志
    public function add_login_log($username)
    {
        $m_login_log = Db::table('log_login');
        $data = array(
            "username" => $username,
            "ip" => get_client_ip(),
            "login_time" => date("Y-m-d H:i:s"),
        );
        return $m_login_log->where(array("username" => $username))->add($data);
    }


    //根据列保存列的值
    public function save_user_info_by_field($username, $field, $value)
    {
        if (empty($username)) return false;
//        db("users")->where(array("username"=>$username))->save(array($field,$value));
        $sql = "UPDATE pcvpn_member SET $field='$value' WHERE username='$username'";
        return $this->member->execute($sql);
    }

    //获取角色列表
    public function get_role_list()
    {
        $m_role = db("role");
        return $m_role->select();
    }

    //执行添加角色
    public function role_add_do($post)
    {
        $m_role = db("users");
        $id = $post['id'];
        $role_list = implode(",", $post['role_list']);
        return $m_role->where(array("id" => $id))->save(array("role_list" => $role_list));
        //die($m_role->getLastSql());
    }

    //获取管理员信息
    public function get_user_info($id)
    {
        $m_user = db("users");
        return $m_user->where(array("id" => $id))->find();
    }

    //根据管理员信息获取角色信息
    public function get_role_info($role_list)
    {
        $m_role = db("role");
        return $m_role->where(array("id" => array("in", $role_list)))->select();
    }

    //根据角色信息字符串获取菜单权限
    public function get_menu_info($auth_list)
    {
        $m_menu = db("menu");
        return $m_menu->where(array("id" => array("in", $auth_list)))->order("`sort`,id")->select();
    }

    //获取数据分类树结构
    public function get_tree($data, $pid = 0, $level = 0, $isClear = TRUE)
    {
        static $ret = array();
        if ($isClear)
            $ret = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['level'] = $level;
                $ret[] = $v;
                $this->get_tree($data, $v['id'], $level + 1, FALSE);
            }
        }
        return $ret;
    }

    //添加到黑名单
    public function add_user_to_black($uid, $sec)
    {
        $arr = array(
            "uid" => $uid,
            "expire_time" => time() + intval($sec),
            "reson" => '登陆次数过多锁定' . $sec . "秒",
            "create_time" => time(),
            "create_time_format" => date("Y-m-d H:i:s")
        );

    }
}