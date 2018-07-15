<?php
namespace app\admin\controller;

use app\admin\model\AdminRoleModel;
use app\admin\model\AuthModel;
use app\admin\model\MemberModel;
use app\admin\model\UsersModel;
use app\admin\model\AuditModel;
use app\core\model\UserModel;
use app\lib\Condition;
use app\lib\Page;
use app\lib\Tree;

Class Users extends Common
{
    public function __construct()
    {
        parent::__construct();

    }

    /** 后台管理员列表（管理员） */
    public function index()
    {
        $page = input('param.page', 1);
        $m_user = new UsersModel();
        $condition_rules = array(
            [
                'field' => 'u.name',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ]
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $r = $m_user->get_users_list($model);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        return $this->fetch();
    }

    /** 会员用户列表 */
    public function show_list(){
        $page = input('param.page', 1);
        $search_word = input('param.search_word');
        $user_type = input('param.user_type');
        $condition_rules = array(
            array(
                'field' => 'user_type',
                'value' => $user_type,
                'operator' => '='
            ),
            array(
                'field' => 'num_id',
                'value' => $search_word,
                'operator' => '='
            ),
            array(
                'field' => 'account',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),
            array(
                'field' => 'phone',
                'value' => $search_word,
                'relation' => 'or',
                'operator' => '='
            ),

        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new MemberModel();
        $r = $m->get_member_list($model);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total',$r->total());
        $this->assign('user_type',$user_type);
        return $this->fetch();
    }

    /** 会员用户的编辑/新增 */
    public function member_exec(){
        $type = input("param.type", 'add');
        $id = input("param.id", '');

        $m= new UsersModel();
        if($type=='edit' || $type=='info' && chk_id($id)){
            $user_info = $m->get_info_by_id($id);
            empty($user_info) && wrong_return('用户信息获取失败');
            $this->assign('user_info',$user_info);
        }

        $this->assign('type',$type);
        if($type=='info'){
            return $this->fetch('member_info');
        }else{
            return $this->fetch('member_form');
        }
    }

    /** 会员添加或更新 */
    public function member_update()
    {
        $post = input("post.");
        extract($post);
        $m = new MemberModel();
        $rt = $m->update_users($post);
        $rt && ok_return('操作成功');
        wrong_return('操作失败');
    }

    /** 禁用或启用会员 */
    public function member_status(){
        $post = input("post.",'');
        extract($post);
        empty($id) && wrong_return("用户ID不能为空");
        empty($value) && wrong_return("改变值不能为空");
        $field = "status";
        $m = new MemberModel();
        $res = $m->update_member_info($id,$field,$value);
        ($res !== false) && ok_return("操作成功");
        wrong_return("操作失败");
    }



    //删除会员
    public function member_del()
    {
        $id = input("post.id");
        (empty($id) || !is_numeric($id)) && wrong_return('参数异常,删除失败');
        $m = new MemberModel();
        ($m->del_users($id) !== false) && ok_return('删除成功');
        wrong_return('删除操作失败');
    }
    //后台管理员编辑/新增
    public function admin_exec()
    {
        $type = input("param.type", 'add');
        $id = input("param.id", '');
        //获取全部角色
        $m_auth = new AuthModel();
        $role_list = $m_auth->get_all_role_list();
        $tree = new Tree();
        $role_list = $tree->toFormatTree($role_list, 'name');

        $role_list_arr = [];
        //编辑时候用到的内容
        if ($type == "edit" && chk_id($id)) {
            $m = new UsersModel();
            $info = $m->get_admin_info_by_id($id);
            if (!empty($info['role_list'])) {
                $role_list_arr = str_to_arr($info['role_list']);
            }
            $this->assign('info', $info);
        }
        //获取当前列表的名称
        $this->assign('role_list_arr', $role_list_arr);
        $this->assign('role_list', $role_list);
        $this->assign('type', $type);
        return $this->fetch('form');
    }

    //执行添加管理员用户
    public function admin_update()
    {
        $user_login = $nick_name = null;
        $post = input("post.");
        extract($post);
        !empty($id) && !chk_id($id) && wrong_return('id格式不正确');

        $m = new UsersModel();
        //检测用户是否已存在
        if (empty($id)) {//说明是增加
            if(empty($nick_name)||empty($status)||empty($user_login)||empty($user_pass)){
                wrong_return('请将信息填完整');
            }
            $r = $m->get_admin_info_by_user_login($user_login);
            !empty($r&&$r['status'] != 1) && wrong_return('用户已存在，且已经被禁用');
            !empty($r) && wrong_return('用户已存在');

        }

        $rt = $m->admin_update($post);
        $rt && ok_return('恭喜!操作成功!');
        wrong_return('数据写入失败');
    }

    //删除管理员
    public function admin_del(){
        $user_login = $nick_name = null;
        $post = input("post.");
        extract($post);
        !empty($id) && !chk_id($id) && wrong_return('id格式不正确');

        $m = new UsersModel();
        //检测用户是否已存在


        $r = $m->get_admin_info_by_id($id);
        if(session("admin")['user_login'] == $r['user_login']){
            wrong_return('不能删除自己');
        }else{
            $rt = $m->admin_del($id);
            $rt && ok_return('恭喜!操作成功!');
            wrong_return('数据写入失败');
        }

    }

    //玲珑实名认证审核列表
    public function audit_list()
    {
        $page = input('param.page', 1);
        $type = input("param.type",'');
        $map = '';
        $search_word = input('param.search_word');
        if(!empty($search_word)){
            $map['nickname'] = $search_word;
            $map['phone'] = $search_word;
        }
        if(!empty($type)){
            $map['type'] = $type;
        }
        $condition_rules = array(
            array(
                'field' => 'm.num_id',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
            array(
                'field' => 'aud.status',
                'value' => input('param.status', ''),
                'operator' => '='
            )

        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new AuditModel();
        $r = $m->get_audit_list($model,$map);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total',$r->total());
        $this->assign('type',$type);
        return $this->fetch();
    }

    //主播认证审核编辑
    public function audit_edit()
    {
        $m = new AuditModel();
        $id = input("param.id", null);
        $type = input('param.type','');
        if (!empty($id)) {
            !is_numeric($id) && die('id格式不正确');
            //获取详情
            $audit_info = $m->get_user_info_by_id($id,$type);
            empty($audit_info) && die('获取信息失败');
            $this->assign('audit_info', $audit_info);
            $this->assign('type', $type);
        }
        return $this->fetch();
    }

    //执行审核状态改变
    public function audit_change()
    {
        $post = input("post.");
        extract($post);
            $m = new MemberModel();
            $res = $m->verify_user_do($post['id'],$post['status']);
            $res !== false && ok_return("审核成功");
        wrong_return('审核失败');
    }
    //执行一键审核审核状态改变
    public function all_audit_change()
    {
        $id = input("post.id",'');
        $m = new MemberModel();
        $res = $m->all_audit_change($id);
        $res !== false && ok_return("审核成功");
        wrong_return('审核失败');
    }
    //举报列表
    public function report_list()
    {
        $page = input('param.page', 1);
        $map = '';
        $search_word = input('param.search_word');
        if(!empty($search_word)){
            $map['m.nickname'] = $search_word;
            $map['m.phone'] = $search_word;
        }
        $condition_rules = array(
            array(
                'field' => 'm.nickname',
                'value' => input('param.search_word', ''),
                'operator' => 'like'
            ),
            array(
                'field' => 'rp.create_time',
                'value' => strtotime(input('param.start_time', '')),
                'operator' => '>='
            ),
            array(
                'field' => 'rp.create_time',
                'value' => strtotime(input('param.end_time', '')),
                'operator' => '<='
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();
        $m = new MemberModel();
        $r = $m->get_report_list($model,$map);
        $this->assign('page', $r->render());
        $this->assign('list', $r->all());
        $this->assign('total',$r->total());
        return $this->fetch();
    }
    //举报信息处理
    public function up_report_message(){
        $id = input('param.id', null);
        if (!empty($id)) {
            !is_numeric($id) && wrong_return('id格式有问题');
        } else {
            wrong_return('id有问题');
        }
        $rt = db('report')->where(array('id' => $id))->update(array('status' => 1));
        $rt && ok_return('标记成功!');
        wrong_return('未发生更改');
    }
    //批量举报信息出来
    public function up_all_message(){
        $id = input('post.id');
        $m = new MemberModel();
        $list = $m->up_all_message_do($id);
        $list && ok_return('删除成功');
        wrong_return('删除失败');
    }
    //举报处理编辑
    public function report_edit()
    {
        $id = input('param.id', null);
        empty($id) && wrong_return('id传入为空');
        $m = new MemberModel();
        $reportinfo = $m->get_report_list_by_id($id);
        $this->assign('reportinfo', $reportinfo);

        return $this->fetch();

    }

    //执行举报信息更新
    public function report_change()
    {
        //收集数据
        $post = input('post.', null);
        if (empty($post['id'])) wrong_return('id不能为空');
        $m = new MemberModel();
        $row = $m->update_report_post($post);

        if ($row) ok_return('更新成功');
        wrong_return('反馈处理出错');
    }

    //删除举报
    public function report_del()
    {
        $id = input('param.id', null);
        if (!empty($id)) {
            !is_numeric($id) && wrong_return('id格式有问题');
        } else {
            wrong_return('id有问题');
        }
        $rt = db('report')->where(array('id' => $id))->update(array('status' => -1));
        $rt && ok_return('删除成功!');
        wrong_return('未发生更改');
    }

    //反馈列表
    public function feedback_list()
    {

    }

    //后台管理员列表
    public function admin_list()
    {
        //获取列表
        $condition_rule = array(
            array(
                'field' => 'username',
                'value' => input('post.keywords')
            )
        );
        $model = new Condition($condition_rule, $this->page, $this->page_num);
        $model->init();
        $m = new UsersModel();
        $users_list = $m->get_admin_users_list($model);

        /*生成分页html*/
        $my_page = new Page($users_list["count"], $this->page_num, $this->page, Url('admin_list'), 5);
        $pages = $my_page->myde_write();
        $this->assign('pages', $pages);
        $this->assign('users_list', $users_list['data']);

        return $this->fetch();
    }

    //禁用用户
    public function member_stop(){
        $id = input('post.id');
        (empty($id)) && wrong_return("用户ID不存在,请重新选择");
        $m = new MemberModel();
        $status = '-1';
        $res = $m->update_user_status_by_id($id,$status);
        $res !== false && ok_return('禁用成功');
        wrong_return('禁用失败');
    }

    //启用用户
    public function member_start(){
        $id = input('post.id');
        (empty($id)) && wrong_return("用户ID不存在,请重新选择");
        $m = new MemberModel();
        $status = '1';
        $res = $m->update_user_status_by_id($id,$status);
        $res !== false && ok_return('启用成功');
        wrong_return('启用失败');
    }


    //审核
    public function verify_user(){
        $post = input("post.");
        $post = remove_arr_xss($post);
        extract($post);
        empty($id) && wrong_return("审核主播ID不存在,请重新选择");
        empty($status) && wrong_return("审核结果不能为空");
        !in_array($status,(["通过","不通过"])) && wrong_return("审核结果只能是通过或者不通过哦");
        if($status == "通过"){
            $status = "1";
        }else{
            $status = "-1";
        }
        $m = new MemberModel();
        $res = $m->verify_user_do($id,$status);
        $res !== false && ok_return("操作成功");
        wrong_return($res);
    }

    //用户反馈列表
    public function feedback(){
        $page = input("param.page",1);
        $condition_rules = [
            array(
                'field'=>'f.uid',
                'value'=>input('param.search_word',''),
                'operator'=>'like'
            ),
            array(
                'field' => 'f.createline',
                'value' => strtotime(input('param.start_time', '')),
                'operator' => '>='
            ),
            array(
                'field' => 'f.createline',
                'value' => strtotime(input('param.end_time', '')),
                'operator' => '<='
            )
        ];

        $model = new Condition($condition_rules,$page);
        $model->init();

        $m = new MemberModel();
        $r = $m->get_user_feedback_list($model);
        $this->assign(
            [
                'page'=>$r->render(),
                'list'=>$r->all(),
                'total'=>$r->total()
            ]
        );
        return $this->fetch();
    }

    //用户反馈查看详情
    public function look_feedback(){
        $id = input("param.id",'');
        empty($id) && wrong_return("ID不存在,请重新选择");
        $m = new MemberModel();
        $info = $m->get_user_feedback_info($id);
        $this->assign("info",$info);
        return $this->fetch();
    }
    //删除用户反馈
    public function del_feedback(){
        $id = input("post.id",'');
        empty($id) && wrong_return("ID不存在,请重新选择");
        $m = new MemberModel();
        $res = $m->del_feedback_by_id($id);
        $res !== false && ok_return("删除成功");
        wrong_return("删除失败");
    }

    //举报删除
    public function del_all_report(){
        $id = input('post.id');
        $m = new MemberModel();
        $list = $m->del_all_report_do($id);
        $list && ok_return('删除成功');
        wrong_return('删除失败');
    }

    //举报处理
    public function report_treatment(){
        $id = input('post.id','');
        $status = input('post.status','');
        $m = new MemberModel();
        if($status == 1){
            $rt = $m->get_report_user($id);//获取被举报人的ID
            $info = $m->report_treatment_user($rt);//处理被举报用户
        }
        $list = $m->report_treatment_list($id,$status);
        $list && ok_return('处理成功');
        wrong_return('处理失败');
    }
}