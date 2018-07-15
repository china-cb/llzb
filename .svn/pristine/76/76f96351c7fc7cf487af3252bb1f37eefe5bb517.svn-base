<?php
namespace app\admin\controller;

use app\admin\model\CategoryModel;
use app\admin\model\ConfigModel;
use app\lib\Condition;
use app\lib\Tree;

Class Config extends Common
{
    public function __construct()
    {
        parent::__construct();
    }

    //分类默认页
    public function index()
    {
        $page = input('param.page', 1);
        $m = new ConfigModel();
        $condition_rules = array(
            array(
                'field' => 'c.title',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $page = config('pre_page',10);
        $r = $m->get_list($model,$page);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        return $this->fetch();
    }

    //编辑/新增
    public function exec()
    {
        $type = input("param.type", 'add');
        $id = input("param.id", '');



        $m_cate_l = new CategoryModel();
        //获取配置类型
        $conf_type = $m_cate_l->get_list_by_code_mid('CATE_CONFIG_TYPE');
        //获取配置分组
        $conf_group = $m_cate_l->get_list_by_code_mid('CATE_CONFIG_GROUP');

        //编辑时候用到的内容
        if ($type == "edit" && chk_id($id)) {
            $m = new ConfigModel();
            $res = $m->get_info_by_id($id);
            $this->assign('info', $res);
        }
        //获取当前列表的名称
        $this->assign('conf_type', $conf_type);
        $this->assign('conf_group', $conf_group);
        $this->assign('type', $type);
        return $this->fetch('form');
    }

    //执行添加列表
    public function update()
    {
        //获取表单信息
        $post = input("request.", []);
        extract($post);

        empty($title) && wrong_return('配置标题不能为空');
        empty($code) && wrong_return('唯一标识不能为空');
        empty($sort) && wrong_return('排序不能为空');
        empty($type) && wrong_return('配置类型不能为空');
        empty($group) && wrong_return('配置分组不能为空');

        //添加进库
        $m = new ConfigModel();
        $res = $m->update($post);
        ($res === '-1') && wrong_return('该唯一标识符已存在,请更换!');
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    //删除
    public function del()
    {
        $id = input("post.id");
        !chk_id($id) && wrong_return('删除失败');
        $m = new ConfigModel();
        $m->del($id) !== false && ok_return('删除成功');
        wrong_return('删除操作失败');
    }

    //参数设置
    public function setting()
    {
        //获取配置一级分类
        $m_cat = new CategoryModel();
        $m_conf = new ConfigModel();
        $cate_list = $m_cat->get_list_by_code_mid('CATE_CONFIG_GROUP');
        $this->assign('cate_list', $cate_list);

        empty($cate_list) && die('暂无可配置内容');
        $conf_list = $m_conf->get_conf_list();

        $arr = [];
        foreach($cate_list as $k=>$v){
            $arr[$v['code']]="";
            foreach($conf_list as $k2=>$v2){
                if($v['code']==$v2['group']){
                    $arr[$v['code']][] = $v2;
                }
            }
        }

        //按照顺序获得配置的内容
        $this->assign('conf_list', $arr);
        return $this->fetch();
    }

    //保存配置
    public function save_config()
    {
        $value = $code = null;
        $post = input('post.', []);
        extract($post);
        config('config_enable',true);//允许修改 参数
        (empty($code) || !config('config_enable')) && wrong_return('无权修改');
        $m_conf = new ConfigModel();
        $m_conf->save_config($code, $value) && ok_return('success');

    }

    //设置配置
    public function refresh_config($force = false)
    {
        if(empty($force)) $force = input('param.force', false);
        //配置不存在

        if (empty(cache('config_cache')) || $force) {
            //获取全部配置
            $m_conf = new ConfigModel();
            $conf_all = $m_conf->get_all_conf();
            foreach ($conf_all as $k => $v) {
                $r[$k]['code'] = strtoupper($conf_all[$k]['code']);
            }
            $conf_all = array_column($conf_all, 'value', 'code');
            cache('config_cache', $conf_all);
        }
        if (is_post()) {
            if (cache('config_cache'))
                ok_return('刷新成功!');
            wrong_return("刷新失败");
        }
    }
}