<?php
namespace app\admin\widget;

use app\admin\model\AuthModel;
use think\Controller;

Class Menu extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //显示菜单
    public function show_menu()
    {
        $list = session("admin_menu");
        if (!empty($list)) {
            $this->assign("list", $list);
        } else {
            $m_auth = new AuthModel();
            empty($list) && $list = $m_auth->get_user_auth_tree(get_admin_id());
            $this->assign("list", $list);
        }
        return $this->fetch('menu/show_menu');
    }
}