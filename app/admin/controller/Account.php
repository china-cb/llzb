<?php
namespace app\admin\controller;

use app\admin\model\AccountModel;
use app\admin\model\MenuModel;
use app\admin\model\AuthModel;
use think\Controller;

Class Account extends Controller
{
    public $u;

    public function __construct()
    {
        parent::__construct();
        $auth = new AuthModel();
        // $auth->init();//鉴权 和 初始化 配置 wt
    }

    //登录页
    public function index()
    {

        if (is_admin_login())
            jump_url(url('admin/index/index'));



        $logo = config('CONFIG_WELCOME_LOGO_IMG_PATH');
        $mail = config('CONFIG_WELCOME_EMAIL');
        $qq   = config('CONFIG_WELCOME_QQ');
        $beian = config('CONFIG_WELCOME_BEIAN_CODE');
        $phone = config('CONFIG_WELCOME_PHONE');



        $this->assign('logo',$logo);
        $this->assign('mail',$mail);
        $this->assign('qq',$qq);
        $this->assign('beian',$beian);
        $this->assign('phone',$phone);
        return $this->fetch();
    }

    public function md6_run()
    {
        empty(input('request.str')) && die('param not exist str');
        die(md6(input('request.str')));
    }

    //执行登录
    public function login_do()
    {
        $user_pass = $user_login = null;
        $post = input("post.");
        $post = remove_arr_xss($post);
        extract($post);
        //检测验证码
       !sp_check_verify_code() && wrong_return('验证码错误');
        $m_acc = new AccountModel();
        $m_menu = new MenuModel();
        //校验用户信息
        empty($user_login) && wrong_return('用户名不能为空');
        $user_info = $m_acc->get_user_info_by_user_login($user_login);
        empty($user_info) && wrong_return('用户不存在');
        //获取用户角色信息
        $role_list = $m_acc->get_user_role_list($user_info['role_list']);
        foreach($role_list as $k=>$v){
            $role_list[$k]=$v['name'];
        }
        $user_info["role_name"] = implode(' ',$role_list);
        $uid = $user_info["id"];
        !in_array($user_info['status'], array(1)) && wrong_return('用户已经禁用');
        if ($user_info["user_pass"] === md6($user_pass)) {
            if (!empty($remember)) {
                $data = array(
                    "user_login" => $user_login,
                    "user_pass" => $user_pass,
                    "remember" => $remember
                );
                cookie("admin_login", $data);
            } else {
                cookie("admin_login", null);
            }

            $user_info["admin_login_time"] = time();//用户登录时间
            $user_info["admin_login_ip"] = get_client_ip_true();//用户登录ip
            session("admin", $user_info);
            //写入菜单到session
            $m_auth = new AuthModel();
            $r = $m_auth->get_user_auth_tree($user_info["id"]);
            session('admin_menu', $r);
            //记录用户登录信息
            $m_acc->set_login_info();
            //刷新登录用户session
            $m_acc->refresh_login_user_session(true);
            ok_return("登录成功");
        } else {
            $login_times = session('admin_login_times_' . $user_login);
            empty($login_times) && $login_times = 0;
            //尝试登录多少次后锁定多少秒
            $login_lock_times = intval(config('login_lock_times'));
            $login_lock_sec = intval(config('login_lock_sec'));
            if (!empty($login_lock_times) && !empty($login_lock_sec)) {
                if ($login_times > 3) {
                    //用户加入黑名单锁定5分钟
//                    empty($user_info['id']) && wrong_return("密码错误");
                    $m_acc->add_user_to_black($uid, 300);
                }
            }
            $login_times++;
            session('admin_login_times_' . $user_login, $login_times);
            wrong_return("密码错误");
        }
    }

    /*** 退出*/
    public function quit()
    {
        session(null);
        ok_return("退出成功");
    }

    //注意:每30s发一次心跳请求
    public function refresh_login_user_session()
    {
        $m = new AccountModel();
        $m->refresh_login_user_session();
    }
}