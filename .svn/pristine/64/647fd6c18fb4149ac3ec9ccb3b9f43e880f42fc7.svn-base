<?php
namespace app\admin\controller;

use app\admin\model\MenuModel;
use app\lib\Tree;
use think\Controller;

Class Template extends Common
{
    public function __construct()
    {
        parent::__construct();
    }

    //首页
    public function index()
    {
        $base_path = input('param.path', '');
        $base_path = trim(base64_decode($base_path), '/');
        $path = TPL_PATH . $base_path;


        //获取当前目录下的文件列表
        $list = scan_dir($path);
        $list_arr = array();
        foreach ($list as $k => $v) {
            if (is_array($v)) {
                $tmp = array(
                    'type' => 'dir',
                    'name' => $k
                );
            } else {
                $tmp = array(
                    'type' => 'file',
                    'name' => $v
                );
            }
            array_push($list_arr, $tmp);
        }

        $this->assign('list', $list_arr);

        //分离基础路径
        $path_arr = explode('/', $base_path);

        $this->assign('path_arr', $path_arr);
        $this->assign('base_path', $base_path);
        $this->assign('base_path_line', str_replace('/', '-', $base_path));
        //获取目录
        return $this->fetch();
    }

    public function tree_list()
    {
        return $this->fetch();
    }

    public function code_edit()
    {
        $base_path = input('param.path', '');
        $this->assign('path', $base_path);
        return $this->fetch();
    }

    public function edit()
    {
        $base_path = input('param.path', '');
        $base_path = trim(base64_decode($base_path), '/');
        $path = TPL_PATH . $base_path;
        $html = file_get_contents($path);
        $this->assign('html', htmlentities($html));
        $this->assign('path', $base_path);
        return $this->fetch();
    }

    public function preview()
    {
        return $this->fetch();
    }

    //删除菜单
    public function del()
    {
        $id = input("post.id");
        (empty($id) || !is_numeric($id)) && wrong_return('参数异常,删除失败');
        $m_menu = new MenuModel();
        $r = $m_menu->get_info_by_pid($id);
        $r && wrong_return('此菜单子级菜单不为空,不能删除');
        $m_menu->del_menu($id) !== false && ok_return('删除成功');
        wrong_return('删除操作失败');
    }

    //查看/编辑/新增
    public function exec()
    {
        $m_menu = new MenuModel();
        //查看,编辑
        $id = input("param.id", null);

        $type = input("param.type", null);
        //获取全部菜单
        $menus = $m_menu->get_all_menu_list();
        $tree = new Tree();
        $menus = $tree->toFormatTree($menus);
        $menus = array_merge(array(0 => array('id' => 0, 'title_show' => '顶级菜单')), $menus);
        $this->assign('menus', $menus);

        if (!empty($id)) {

            !is_numeric($id) && wrong_return('id格式不正确');
            //获取详情
            $m_menu = new MenuModel();
            $info = $m_menu->get_menu_info_by_id($id);
            empty($info) && wrong_return('获取信息失败');
            $this->assign("info", $info);
            if ($type == 'edit') {
                $this->assign('type', 'edit');//编辑
            } else {
                $this->assign('type', 'see');//查看
            }
        } //新增
        else {
            $this->assign('type', 'add');//新增
        }

        return $this->fetch('form');
    }

    //执行添加菜单
    public function update()
    {
        $pid = $hide = $title = $sort = $ico = $url = $hide = $tip = $param = $target = $is_admin = 0;
        $post = input("post.");
        extract($post);
        //初始化
        !empty($sort) && $sort = intval($sort);//转换排序号
        !empty($id) && !is_numeric($id) && wrong_return('id格式不正确');
        empty($title) && wrong_return('标题不能为空');
        empty($url) && wrong_return('url不能为空');
        (empty($pid) && $pid != 0 && $pid != '0') && wrong_return('上级菜单不能为空');
        (empty($hide) && $hide != 'false' && $hide != 'true') && wrong_return('隐藏选择不能为空');
        $m_menu = new MenuModel();
        //获取父级级别信息
        $p_info = $m_menu->get_menu_info_by_id($pid);

        //如果全部正确,执行写入数据
        $data = array(
            "id" => !empty($id) ? $id : "",
            "title" => $title,
            "status" => '1',
            "pid" => $pid,
            "level" => empty($p_info) ? 0 : ((int)$p_info['level'] + 1),
            "sort" => $sort,
            "ico" => $ico,
            "url" => $url,
            "hide" => $hide,
            "tip" => $tip,
            "param" => $param,
            "target" => $target,
            "is_admin" => $is_admin
        );

        $rt = $m_menu->update($data);
        $rt && ok_return('恭喜!操作成功!');
        wrong_return('数据写入失败');
    }

    //保存内容
    public function save()
    {
        $path = input('param.path', '');
        $html = input('param.html', '');

        $path = TPL_PATH . $path;
        file_put_contents($path, $html);
        ok_return('保存成功!');
    }


}