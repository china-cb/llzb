<?php
namespace app\admin\controller;

use app\core\controller\Auth;
use app\core\model\LogBehaviorModel;
use think\Controller;
use think\Request;

Class Common extends Auth
{
    public $page;
    public $page_num = 1;
    public $del_model;
    public $request = '';

    public function __construct()
    {
        parent::__construct();
        chk_login();
        //检测是否超时
        $this->chk_expire();
        //第几页
        $this->page = (int)input('post.page', '1');
        $this->page_num = 10;//每页显示条数

        //记录日志
        $this->request = Request::instance();
        if (config('admin_log_open') === 1) {
            $path = $this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action();
            if (!in_array($path, config('no_log_list'))) {
                $l_model = new LogBehaviorModel();
                $l_model->log_behavior_add();
            }
        }
    }

    private function chk_expire()
    {
        $chk_expire = db_func('session', 'admin_')->where(["uid" => get_admin_id()])->field(['expire_time', 'session_id'])->find();

        $r_0 = empty($chk_expire['session_id'] || empty($chk_expire['expire_time']));
        $r_1 = intval($chk_expire['expire_time']) - time() < 0;
        $r_2 = session('login_session') !== $chk_expire['session_id'];

        //超时或session不同登出
        if ($r_0 || $r_1 || $r_2) {
            session(null);
            top_jump_url(url('admin/account/index'));

        }
    }

}