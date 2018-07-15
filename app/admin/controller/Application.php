<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/2/5
 * Time: 13:11
 */

namespace app\admin\controller;


use app\admin\model\ApplicationModel;
use app\core\controller\Upload;
use app\lib\Condition;

class Application extends Common
{
    /** 应用场景菜单列表 */
    public function index(){
        $page = input("param.page",1);

        $condition_rules = [
            array(
                'field'=>'title',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
        ];

        $model = new Condition($condition_rules,$page);
        $model->init();
        $m = new ApplicationModel();
        $r = $m->get_app_category($model);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total()
            ]
        );
        return $this->fetch();
    }

    /*** 添加/编辑 */
    public function exec(){
        $type = input('param.type','add');
        $id = input('param.id','');
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $m = new ApplicationModel();
            $res = $m->get_app_category_by_id($id);
            $this->assign('info',$res);
        }
        //获取当前列表名称
        $this->assign("type",$type);
        return $this->fetch('form');
    }

    /*** 执行添加列表 */
    public function update(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
        empty($title) && wrong_return("帮助菜单名称不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new ApplicationModel();
        $res = $m->update_app_category($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /*** 删除分类*/
    public function del(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new ApplicationModel();
        $m->del_app_category($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }

    /***应用场景分类详情列表 */
    public function category_child_list(){
        $page = input("param.page",1);
        $id = input("param.id");
        $title = input("param.title",'');
        empty($id) && !is_numeric($id) && wrong_return("分类id不正确");//分类id不正确
        $condition_rules = [
            array(
                'field'=>'a.name',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
        ];
        $model = new Condition($condition_rules,$page);
        $model->init();
        $m = new ApplicationModel();
        $r = $m->get_category_child_list($model,$id);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total(),
                'pid'=>$id,
                'title'=>$title
            ]
        );
        return $this->fetch();
    }

    /*** 添加/编辑 应用场景文章 */
    public function category_child_form(){
        $type = input('param.type','add');
        $pid = input('param.pid','');
        $id = input('param.id','');
        $title = input('param.title','');
        empty($pid) && !is_numeric($pid) && wrong_return("分类id不正确");//分类id不正确
        $m = new ApplicationModel();
        //获取所有上级分类
        $info = $m->get_category_list();
        !$info && wrong_return("分类信息不存在"); //分类信息不存在
        //编辑时用到的内容
        if($type == "edit" && chk_id($id)){
            $m = new ApplicationModel();
            $res = $m->get_category_child_info_by_id($id);
            $this->assign('child_info',$res);
        }

        $this->assign('type',$type);
        $this->assign('pid',$pid);
        $this->assign('info',$info);
        $this->assign('title',$title);
        return $this->fetch();
    }

    /** 获取百度编辑器中的内容 */
    public function get_editor_content(){
        $id = input('param.id');
        empty($id)&& wrong_return("分类id不正确");//分类id不正确
        $m = new ApplicationModel();
        $res = $m->get_category_child_info_by_id($id);
        !empty($res) && ok_return("success",1,$res['content']);
    }

    /** 执行添加/更新应用场景的文章*/
    public function update_category_child(){
        //获取表单信息
        $post = input("param.",[]);
        extract($post);
        empty($pid) && wrong_return("上级分类不能为空");
        empty($name) && wrong_return("文章标题不能为空");
        empty($desc) && wrong_return("文章简介不能为空");
        empty($cover) && wrong_return("文章封面图不能为空");
        empty($content) && wrong_return("文章内容不能为空");
        empty($type) && wrong_return("是否推荐不能为空");
        empty($status) && wrong_return("状态类型不能为空");

        //添加入库
        $m = new ApplicationModel();
        $res = $m->update_live_category_child($post);
        $res && ok_return('操作成功!');
        wrong_return('操作失败!');
    }

    /** 删除主题子类型分类 */
    public function del_live_category_child(){
        $id = input('post.id');
        !chk_id($id) && wrong_return('删除失败');
        $m = new ApplicationModel();
        $m->del_category_child($id) !== false && ok_return('删除成功');
        wrong_return('删除失败');
    }

    /** 上传封面图 */
    public function article_cover(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('cover_file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        $version_path = $info->getRealPath();//获取文件的绝对路径
        $version_name = $info->getFilename();//获取文件名
        if(!empty($info)) {
            $rt = new Upload();
            $res = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
        }
        ($res == -1) && wrong_return('上传失败');
        ok_return('上传成功',1,$version_name);
    }
}