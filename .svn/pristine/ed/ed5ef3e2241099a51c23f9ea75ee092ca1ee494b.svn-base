<?php
namespace app\admin\model;

use PHPMailer\PHPMailer\Exception;
use think\Db;

Class MemberModel extends BaseModel
{


    public function __construct()
    {
        parent::__construct();
    }


    //根据条件，获取会员列表
    public function get_member_list($model){
        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('member', 'sp_');
        return $m->where($condition)
            ->order('member_id desc')
            ->paginate(config('pre_page'));
    }

    //获取用户详情
    public function get_info_by_id($id)
    {
        $user_info = db('member')->where(array("member_id" => $id))->find();
        $user_info['user_face'] = $this->get_one_image_src($user_info['user_face']);
        return $user_info;
    }

    //获取用户类型
    public function get_user_type_by_id($id)
    {
        return db('member')->where(['id' => intval($id)])->getField('type');
    }

    //停掉会员
    public function stop_vip($post){
        return db_func('member','sp_')->where('member_id',$post['mid'])->update(['vip' => $post['status']]);
    }

    /** 添加用户 */
    public function update_users($post)
    {
        $member_id = $user_type = $account = $password = $re_password = $phone = $email = $status = null;
        extract($post);

        empty($user_type) && wrong_return("用户类型不能为空");
        empty($account) && wrong_return("登录账户不能为空");
        empty($phone) && wrong_return("手机号不能为空");
        empty($email) && wrong_return("邮箱不能为空");
        empty($status) && wrong_return("用户状态不能为空");

        (empty($account) || !preg_match(config('regular_rule')['username'], $account)) && wrong_return("登录账户格式不正确");
        if(!validate_rule($phone)&&!empty($phone)) wrong_return('手机号错误');
        if (empty($member_id)) {//说明是新添用户
            $account_info = db('member')->where('account',$account)->field("account")->find();
            !empty($account_info) && wrong_return('该登录账户已被注册,请更换其它登录账户');
            $phone_info = db('member')->where(['phone' => $phone])->field("phone")->find();
            !empty($phone_info) && wrong_return('该手机号已经注册过，请更换其它手机号');
        }
        (empty($email) || !preg_match(config('regular_rule')['email'], $email)) && wrong_return("邮箱格式不正确");

        //如果全部正确,执行写入数据
        $data = array(
            "user_type" => $user_type,
            "account" => $account,
            "phone" => $phone,
            "email" => $email,
            "status" => $status
        );

        if(!empty($password)){
            (empty($password) || !preg_match(config('regular_rule')['password'], $password)) && wrong_return("密码为6~30位任意字符的组合");
            ($password !== $re_password) && wrong_return("两次输入的密码不一致");
            $data["password"] = md6($password);
        }

       if(empty($member_id)){
           //添加新用户
           $data['create_time'] = NOW_TIME;
           $member_id =  db("member")->insertGetId($data);
           ($member_id < 0) && wrong_return("用户添加失败");
           //更新玲珑账号
           $num_id = INIT_LIVE_NUM + $member_id;
           $res = db("member")->where("member_id",$member_id)->setField("num_id",$num_id);
       }else{
           //更新用户信息
           $data['update_time'] = NOW_TIME;
           $res = db("member")->where("member_id",$member_id)->update($data);
       }
        return $res;
    }

    /** 更新用户信息的某个字段值 */
    public function update_member_info($id,$field,$value){
        return db("member")->where("member_id",$id)->setField($field,$value);
    }
    //删除用户
    public function del_users($id)
    {
        return db('member')->where(array("member_id" => $id))->update(array("status" => "-1"));
    }


    //获取举报列表
    public function get_report_list($model,$map)
    {
        $condition = !empty($model)?$model->wheresql : null;
        $m = db_func('report rp','sp_');
        return $m->where($condition)
            ->whereOr($map)
            ->where('rp.status !=-1')
            ->field('rp.*,m.nickname as m_nickname,m1.nickname as reportname ')
            ->join('__MEMBER__ m','rp.uid = m.member_id','LEFT')
            ->join('__MEMBER__ m1','rp.reportuid = m1.member_id','LEFT')
            ->order('rp.status <> 0')
            ->paginate(config('pre_page'));
    }


    //更新举报数据
    public function update_report_post($post)
    {
        $temp = db('report')
            ->update($post);
        return $temp;
    }

    //根据id获取举报信息
    public function get_report_list_by_id($id)
    {

        $info = db('report r')
            ->field('r.*,m.nickname as m_nickname,m1.nickname as reportname')
            ->join('member m ', 'r.uid=m.member_id')
            ->join('member m1 ', 'r.reportuid = m1.member_id ', 'left')
            ->where(array('id' => $id))
            ->order('create_time desc')
            ->find();
        if (empty($info)) wrong_return('查询错误');
        return $info;

    }

    //
    public function del_select($ids)
    {
        return db('member')->where(array('id' => ['in', $ids]))->save(array('status' => -1));
    }

    public function import_users($users)
    {
        return db('member')->addAll($users);
    }

    //禁用用户
    public function update_user_status_by_id($id,$status){
        return db('member')->where('member_id',$id)->setField('status',$status);
    }

    //修改用户密码
    public function update_user_pwd_by_id($id,$value){
        $data = [
            'member_id'=>$id,
            'password'=>md6($value)
        ];
        return db('member')->update($data);
    }

    //审核用户
    public function verify_user_do($id,$status){

        Db::startTrans();
        try{
            $data = [
                'id'=>$id,
                'status'=>$status,
                'update_time'=>NOW_TIME,
            ];
            $temp = db_func('audit')->update($data);
            if(empty($temp)) throw new Exception('后台审核audit_id:'.$id.'出错');

            $auditinfo = db('audit')->where(['id'=>$id])->find();
            if(empty($auditinfo)) throw new Exception('后台审核audit_id:'.$id.'不存在');
            //如果审核通过  真实姓名入库   state = 2
             if($status == 1){
                 $updata = array(
                     'user_type'=>$auditinfo['type'],
                     'true_name'=>$auditinfo['true_name'],
                     'identity'=>$auditinfo['identity_card'],
                     'province'=>$auditinfo['province'],
                     'city'=>$auditinfo['city'],
                     'vocation'=>$auditinfo['industry'],
                     'registration'=>$auditinfo['registration'],
                     'addr'=>$auditinfo['detailed_address'],
                     'enterprise_name'=>$auditinfo['enterprise_name'],
                     'identity_img_z'=>$auditinfo['positive_img_url'],
                     'identity_img_f'=>$auditinfo['negative_img_url'],
                     'business_img_url'=>$auditinfo['business_img_url'],
                     'create_time'=>NOW_TIME,
                     'update_time'=>NOW_TIME,
                     'state'=>2,//通过
                 );
                 $uptemp = db('member')->where('member_id',$auditinfo['mid'])->update($updata);
                 if(empty($uptemp)) throw new Exception('后台审核更新'.$auditinfo['mid'].'state状态时出错');

             }elseif($status == -1){//如果不通过   三者不入库  但是 state 此刻由1 = 0 ,
                 $uptemp = db('member')->where('member_id',$auditinfo['mid'])->setField('state',0);
                 if(empty($uptemp)) throw new Exception('后台审核更新'.$auditinfo['mid'].'state状态时出错');
             }

            Db::commit();
            return true;
        } catch (Exception $e) {
            log_w($e->getMessage());
            Db::rollback();
            return $re = $e->getMessage();
        }
    }
    //一键审核用户
    public function all_audit_change($id)
    {
        Db::startTrans();
        try{
            $data = [
                'status' => 1,
                'update_time' => NOW_TIME,
            ];
            $tenp = db_func('audit')->where('id', 'IN', $id)->update($data);

            if(empty($temp)) throw new Exception('后台审核audit_id:'.$id.'出错');
            $list = db_func('audit', 'sp_')->where('id', 'IN', $id)->select();

            if(empty($list)) throw new Exception('后台审核audit_id:'.$id.'不存在');
            //如果审核通过  真实姓名入库   state = 2
            //将我审核用户数据信息变成一维数组
            if (!empty($list)) {
                foreach ($list as $k => $v) {
                    $data = [
                        'user_type' => $v['type'],
                        'true_name' => $v['true_name'],
                        'identity' => $v['identity_card'],
                        'province' => $v['province'],
                        'city' => $v['city'],
                        'vocation' => $v['industry'],
                        'registration' => $v['registration'],
                        'addr' => $v['detailed_address'],
                        'enterprise_name' => $v['enterprise_name'],
                        'identity_img_z' => $v['positive_img_url'],
                        'identity_img_f' => $v['negative_img_url'],
                        'business_img_url' => $v['business_img_url'],
                        'create_time' => NOW_TIME,
                        'update_time' => NOW_TIME,
                        'state' => 2,//通过
                    ];
                    $uptemp = db_func('member', 'sp_')->update($data);
                    if(empty($uptemp)) throw new Exception('后台审核更新'.$list['mid'].'state状态时出错');
                }
            }
            Db::commit();
            return true;
        } catch (Exception $e) {
            log_w($e->getMessage());
            Db::rollback();
            return $re = $e->getMessage();
        }
    }
    //获取用户反馈信息列表
    public function get_user_feedback_list($model){
        $condition = empty($model)?null:$model->wheresql;
        return db('feedback f')
            ->where($condition)
            ->join('member m','f.uid = m.member_id')
            ->field("f.*,m.nickname")
            ->order('id desc')
            ->paginate(config('pre_page'));
    }
    //获取用户反馈详细信息
    public function get_user_feedback_info($id){
        return db("feedback f")
            ->join("member m","f.uid = m.member_id")
            ->field("f.*,m.nickname")
            ->find($id);
    }

    //删除用户反馈
    public function del_feedback_by_id($id){
        return db("feedback")->delete($id);
    }
    //批量删除-
    public function del_all_report_do($id){
        return db_func('report','sp_')->where('id',"in",$id)->setField('status',-1);
    }
    //批量举报信息处理已读
    //批量删除
    public function up_all_message_do($id){
        return db_func('report','sp_')->where('id',"in",$id)->setField('status',1);
    }
    //获取被举报人的ID
    public function get_report_user($id){
        return db_func('report','sp_')->where('id',$id)->field('reportuid')->find();
    }
    //处理被举报用户
    public function report_treatment_user($rt){
        return db_func('report','sp_')->where('member_id',$rt)->setField('status',-1);
    }
    //举报处理
    public function report_treatment_list($id,$status){
        return db_func('report','sp_')->where('id',$id)->setField('status',$status);
    }
}