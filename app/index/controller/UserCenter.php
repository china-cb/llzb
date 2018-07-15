<?php
/**
 * Created by PhpStorm.
 * User: 翟垒垒
 * Date: 2016/12/5
 * Time: 14:04
 */
namespace app\index\controller;


use app\core\controller\Api;
use app\core\controller\Upload;
use app\index\model\UserCenterModel;
use app\lib\Condition;
use app\lib\Page;
use think\controller;
class UserCenter extends Common
{
    public function index(){
//        $mid = check_login();
//        $mid = 1;
//        $m = new UserCenterModel();
//        $user_msg = $m->get_user_message($mid);
//        $this ->assign('user_msg',$user_msg);
        return $this->fetch();
    }
    /**用户中心 */
    public function account(){
        $page = input('param.page', 1);
        $size = 5;
        $mid = check_login();
        $type = input('param.type','');
        $m = new UserCenterModel();
        $list = $m->get_user_message($mid);
        $user_phone = substr_replace($list['phone'],'***',3,6);
        $user_audit = $m->get_audit($mid);
        $info =$m->get_this_data($mid);//当前套餐
        $rt = $m->get_use_unused($mid);//未使用套餐
        $user_order =$m->get_user_bill_increase($mid,$page,$size);
        $my_page = new Page($user_order['count'], $size,$page , Url('account'), 2);
        $pages = $my_page->myde_write();

        $this ->assign('user_audit',$user_audit);
        $this ->assign('user_phone',$user_phone);
        $this->assign('page', $pages);
        $this->assign('user_order', $user_order['data']);

        $this ->assign('list',$list);
        $this ->assign('type',$type);
        $this ->assign('info',$info);
        $this ->assign('rt',$rt);

        return $this->fetch();
    }
    /** 上传头像 */
    public function user_price(){
        $mid = check_login();
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["gift_img"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('gift_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if(!empty($info)) {
                    $rt = new Upload();
                    $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                }
                $m = new UserCenterModel();
                $list = $m->up_user_price($version_name, $mid);
                (empty($list)) && wrong_return('上传失败');
                ok_return('上传成功');
            }else{
               wrong_return('上传图片不正确');
            }
        }
    }
    /** 充值订单日期筛选AJX*/
    public function recharge_ajx(){
        $post = input('post.','');
        extract($post);
        $mid = check_login();
        $page = input('param.page', 1);
        $size = 5;
        $m = new UserCenterModel();
        if(!empty($post['sta_date'])){
            empty($sta_date) && wrong_return('填写开始时间(⊙o⊙)哦!');
            empty($end_date) && wrong_return('填写结束时间(⊙o⊙)哦!');

            $condition_rules = array(
                array(
                    'field' => 'r.create_time',
                    'value' => strtotime($sta_date),
                    'operator' => '>='
                ),
                array(
                    'field' => 'r.create_time',
                    'value' => strtotime($end_date.' 23:59:59'),
                    'operator' => '<='
                )
            );
            $model = new Condition($condition_rules, $page);
            $model->init();
            $list = $m->get_recharge_list($mid,$model,$page,$size);
        }else{
            $model = '';
            $list = $m->get_recharge_list($mid,$model,$page,$size);
        }

        $my_page = new Page($list['count'], $size,$page , Url('account'), 2);
        $pages = $my_page->myde_write();
        $this->assign('pages', $pages);
        $this->assign('list',$list['data']);
        
        $data = array(
            "code"=>1,
            "html"=>$this->fetch()
        );
        die_json($data);
    }
    /** 账单详情减少 */
    public function order_ajx(){
        $post = input('post.','');
        extract($post);
        $mid = check_login();
        $page = input('param.page', 1);
        $size = 5;
        $m = new UserCenterModel();
        $list = count($post);

        if($list == 3 || $list == 2){
            $this_time = get_current_month_days($month,$year);
            $rt = $m->get_user_order($this_time,$mid,$page,$size);
            
        }else{
            $time = NOW_TIME;
            $year =  date('Y',$time);
            $month = date('m',$time);
            $this_time = '';
            $rt = $m->get_user_order($this_time,$mid,$page,$size);

        }

        $my_page = new Page($rt['count'], $size,$page , Url('account'), 2);
        $pages = $my_page->myde_write();

        $data = [
            'year' => $year,
            'month' => $month
        ];
        
        $this->assign('pages', $pages);
        $this->assign('list',$rt['data']);

        $data = array(
            "code"=>1,
            'data' => $data,
            "html"=>$this->fetch()
        );
        die_json($data);

    }
    /** 账单详情增加 */
    public function bill_increase_ajx(){
        $post = input('post.','');
        extract($post);
        $mid = check_login();
        $page = input('param.page', 1);
        $size = 5;

        $m = new UserCenterModel();
        $this_time = get_current_month_days($month,$year);
        $rt = $m->get_bill_increase($this_time,$mid,$page,$size);

        $my_page = new Page($rt['count'], $size,$page , Url('account'), 2);
        $pages = $my_page->myde_write();

        $data = [
            'year' => $year,
            'month' => $month
        ];

        $this->assign('page', $pages);
        $this->assign('rt',$rt['data']);

        $data = [
            'code' => 1,
            'data' => $data,
            'html' => $this->fetch()
        ];
        die_json($data);
    }
    /** 企业认证 */
    public function company_ajx(){
        $mid = check_login();
        $m = new UserCenterModel();
        $list = $m->get_company_list($mid);
        $rt = $m->get_user_state($mid);
        $this->assign('list', $list);
        $this->assign('rt', $rt);

        $data = [
            'code' => 1,
            'html' => $this->fetch()
        ];
        die_json($data);
    }
    /** 个人认证 */
    public function person_ajx(){
        $mid = check_login();
        $m = new UserCenterModel();
        $list = $m->get_company_list($mid);
        $rt = $m->get_user_state($mid);
        $this->assign('list', $list);
        $this->assign('rt', $rt);
        $data = [
            'code' => 1,
            'html' => $this->fetch()
        ];

        die_json($data);
    }
    /** 用户修改信息 */
    public function change_message(){
        $mid = check_login();
        $post = input('post.','');
        extract($post);
        $post['member_id'] = $mid;
        $post['update_time'] = NOW_TIME;
        $m = new UserCenterModel();
        $list = $m->change_user_message($post);
        (empty($list)) && wrong_return('修改失败');
        ok_return('修改成功');
    }
    /** 实名认证身份上传（正面） */
    public function identity_photo_positive(){
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["img"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if(!empty($info)){
                    $rt = new Upload();
                    $res1 = $rt->server_oss_img($version_name,$version_path);//上传OSS图片
                    ok_return('上传成功',1,$version_name);
                }else{
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }
    /** 实名认证身份上传（反面） */
    public function identity_photo_opposite(){
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["a_image"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('a_image');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if(!empty($info)){
                    $rt = new Upload();
                    $res1 = $rt->server_oss_img($version_name,$version_path);//上传OSS图片
                    ok_return('上传成功',1,$version_name);
                }else{
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }
    /** 营业执照 */
    public function company_img_url(){
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["c_img"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('c_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if(!empty($info)){
                    $rt = new Upload();
                    $res1 = $rt->server_oss_img($version_name,$version_path);//上传OSS图片
                    ok_return('上传成功',1,$version_name);
                }else{
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }
    /**实名认证*/
    public function my_audit(){
        $post = input('post.','');
        extract($post);
        $id = check_login();
        $m = new UserCenterModel();
       $m->judge_my_audit($id,$post);
    }
    /**发送手机验证码*/
    public function send_phone() {
        $phone = input('post.phone','');
        $type = input('post.type','');
        $mid = check_login();
        if(!checkPhone($phone) ){
            wrong_return('手机号格式有问题');
        }
        $purpose = '重要操作';
        switch ($type) {
            case "other":
                $Users = new UserCenterModel();
                $user_id = $Users->judge_user_phone($phone);
                if(!empty($user_id)){
                    wrong_return('该手机已绑定,请更换');
                }
                break;
            case "modify_phone":
                $Users = new UserCenterModel();
                $user_phone = $Users->get_use_phone($mid,$phone);
                if(empty($user_phone)){
                    wrong_return('输入的手机不是你绑定的手机号，请修改');
                }
                break;
            case "modify_email":
                $Users = new UserCenterModel();
                $user_phone = $Users->get_use_phone($mid,$phone);
                if(empty($user_phone)){
                    wrong_return('输入的手机不是你绑定的手机号，请修改');
                }
                break;
            case "modify_pwd":
                $Users = new UserCenterModel();
                $user_phone = $Users->get_use_phone($mid,$phone);
                if(empty($user_phone)){
                    wrong_return('输入的手机不是你绑定的手机号，请修改');
                }
                break;
        }

        //判断该手机号 同一类型在一分钟之内是否已经接受过验证码
        $Users = new UserCenterModel();
        $exist_code = $Users->get_code($phone,$type);
        if($exist_code) {
            if(time()- $exist_code['create_time'] < 60) {
                wrong_return('用户验证码一分钟只能发一次');
            }
        }

        $code = mt_rand(1000,9999);
        $api = new Api();
        $res = $api->get_phone_code_auto($phone,$code,$purpose);//发送过程 后期配置，验证注册否，验证需要外部做活

        if($res == 1){
            wrong_return('获取验证码过多,请稍后重试');
        }
        $this->add_code($code, $res, $phone, $type,$mid);
    }
    /**手机验证码入库*/
    public function add_code($code,$res,$phone,$type,$mid) {
        $PhoneCode = new UserCenterModel();
        $session = md6($phone . $code . NOW_TIME);
        $data['session'] = $session;
        $data['uid'] = $mid;
        $data['use_times'] = 0;
        $data['phone_code'] = $code;
        $data['data'] = json_encode($res['r']);
        $data['plat'] = $res['plat'];
        $data['phone'] = $phone;
        $data['type'] = $type;
        $data['enable'] = 'true';
        $data['expire_time'] = time()+60*10;//008800可以改成配置常量。可以更改
        $data['create_time'] = time();

        $add_res = $PhoneCode->update_code($data);
        if(!empty($add_res)){
            ok_return('获取短信验证码成功');
        }else{
            wrong_return('获取短信验证码失败');
        }
    }
    /** 修改手机号 */
    public function change_phone(){
        $mid = check_login();
        $post = input("post.",'');
        extract($post);
        (empty($phone_Verify_code)) && wrong_return("验证信息验证码不能为空");
        (empty($phone_change_code)) && wrong_return("验证码不能为空");
        //检验数据是否正确
        (empty($phone_change) || !preg_match(config('regular_rule')['phone'], $phone_change)) && wrong_return("手机号格式不正确");
        $m = new UserCenterModel();
        //判断手机号是否已注册
        $member_id = $m->get_user_info_by_phone($phone_change);
        (!empty($member_id)) && wrong_return("该手机号已注册过了!");

        //判断手机验证码是否存在
        $map['phone'] = $phone_Verify;
        $map['phone_code'] = $phone_Verify_code;
        $map['type'] = $phone_Verify_type;
        $code_info = $m->get_phone_code_by_phone($map);
        (empty($code_info)) && wrong_return("验证信息验证码错误");

        //判断手机验证码是否存在
        $map['phone'] = $phone_change;
        $map['phone_code'] = $phone_change_code;
        $map['type'] = $phone_change_type;
        $code_info = $m->get_phone_code_by_phone($map);
        (empty($code_info)) && wrong_return("手机验证码错误");
        //判断手机验证码是否过期
        $code_time = $code_info['expire_time'];
        if (NOW_TIME - $code_time > 60 * 10 || $code_info['enable'] != true) {//默认10分钟
            wrong_return("手机验证码已失效");
        }
            $list = $m->change_phone($mid,$phone_change);
            (empty($list)) && wrong_return('绑定失败');
            ok_return('绑定成功');
    }
    /** 修改邮箱 */
    public function change_email()
    {
        $post = input("post.", '');
        extract($post);
        //检验数据是否正确
        (empty($change_email) || !preg_match(config('regular_rule')['phone'], $change_email)) && wrong_return("手机号格式不正确");
        (empty($change_user_email) || !preg_match(config('regular_rule')['email'], $change_user_email)) && wrong_return("邮箱格式不正确");
        $m = new UserCenterModel();
        //判断邮箱是否已注册
        $member_id = $m->get_user_email($change_user_email);
        (!empty($member_id)) && wrong_return("该邮箱已绑定过了!");

        //判断手机验证码是否存在
        $map['phone'] = $change_email;
        $map['phone_code'] = $change_email_code;
        $map['type'] = $phone_email_type;
        $code_info = $m->get_phone_code_by_phone($map);
        (empty($code_info)) && wrong_return("验证信息验证码错误");
        //判断手机验证码是否过期
        $code_time = $code_info['expire_time'];
        if (NOW_TIME - $code_time > 60 * 10 || $code_info['enable'] != true) {//默认10分钟
            wrong_return("手机验证码已失效");
        }
        $list = $this->mailbox_verify($change_user_email);
        if ($list == 1) {
            wrong_return('发送失败');
        } else {
            $pics = explode('@', $change_user_email);
            switch ($pics[1]) {
                case 'qq.com':
                    $url = 'http://email.qq.com';
                    break;
                case '163.com':
                    $url = 'http://mail.163.com';
                    break;
                case '162.com':
                    $url = 'http://126.com';
                    break;
                default:
                    $url = 1;
            }
            ok_return('发送成功', 1, [$change_user_email, $url]);
        }
    }
    /** 绑定邮箱 */
    public function bind_user_email(){
        $post = input("post.", '');
        extract($post);
        (empty($email) || !preg_match(config('regular_rule')['email'], $email)) && wrong_return("邮箱格式不正确");
        //判断邮箱是否已注册
        $m = new UserCenterModel();
        $member_id = $m->get_user_email($email);
        (!empty($member_id)) && wrong_return("该邮箱已绑定过了!");
        $list = $this->mailbox_verify($email);
        if ($list == 1) {
            wrong_return('发送失败');
        } else {
            $pics = explode('@', $email);
            switch ($pics[1]) {
                case 'qq.com':
                    $url = 'http://email.qq.com';
                    break;
                case '163.com':
                    $url = 'http://mail.163.com';
                    break;
                case '162.com':
                    $url = 'http://126.com';
                    break;
                default:
                    $url = 1;
            }
            ok_return('发送成功', 1, [$email, $url]);
        }
    }
    /**修改密码*/
    public function modify_pwd(){
        $mid = check_login();
        $post = input("post.",'');
        extract($post);
        (empty($new_password) || !preg_match(config('regular_rule')['password'], $new_password)) && wrong_return("密码为6~30位任意字符的组合");
        (empty($re_password)  || $re_password != $new_password) && wrong_return('重复密码不正确');

        $m = new UserCenterModel();
        //判断手机验证码是否存在
        $map['phone'] = $user_phone_pwd;
        $map['phone_code'] = $phone_pwd_code;
        $map['type'] = $phone_pwd_type;
        $code_info = $m->get_phone_code_by_phone($map);
        (empty($code_info)) && wrong_return("验证信息验证码错误");
        //判断手机验证码是否过期
        $code_time = $code_info['expire_time'];
        if (NOW_TIME - $code_time > 60 * 10 || $code_info['enable'] != true) {//默认10分钟
            wrong_return("手机验证码已失效");
        }
        if((preg_match('/^\d*$/',$new_password)) == 1){
            $pwd_grade = '弱';
        }
        if((preg_match("/^[a-zA-Z]*$/",$new_password)) == 1){
            $pwd_grade = '中';
        }
        if((preg_match('/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]*$/',$new_password)) == 1){
            $pwd_grade = '高';
        }
        $password = md6($new_password);
        $list = $m->change_pwd($mid,$password,$pwd_grade);
        $list !== false && ok_return('修改成功');
        wrong_return('修改失败');
    }
    /** 邮箱绑定 */
    public function mailbox_verify($email){
        $post = input('post.','');
        extract($post);
        $mid = check_login();
        $rt = new UserCenterModel();
        $list = $rt->get_user_message($mid);
        $code = rand_str('r',8);

        $data['email'] = $email;
        $data['code'] = $code;
        $data['uid'] = $mid;
        $data['create_time'] = NOW_TIME;
        $data['expire_time'] = NOW_TIME + 3600*6;

        $info = new UserCenterModel();
        $info->insert_email($data);
        $subject = '【玲珑TV】 邮箱绑定，请激活您的邮箱';
        $url = url('index/user_center/judge_email',['id'=>$mid,'code' => $code,'email' => $email],false,true);
        $body = "<br>尊敬的客户{$list['nick_name']}您好:<br><br>您在玲珑TV的账户正在绑定邮箱
<br><br>请您在6小时内点击以下链接进行邮箱激活，或将链接复制到游览器地址栏访问以激活邮箱：
<br><a href='$url'>http://llzb.com/index.php/index/user_center/judge_email</a>
<br>激活邮箱后，您将更好体验玲珑TV的各种功能<br>
<br>此邮箱为系统自动发出，请勿直接回复<br>";
        $m = new Api();
        $list = $m->send_mail($email, $subject, $body);
        if(!empty($type)){
            if($list == 0){
                ok_return('发送成功');
            }else{
                wrong_return('发送失败');
            }
        }else{
            return $list;
        }
    }
    /** 绑定邮箱 */
    public function judge_email(){
        $mid = input('param.id','');
        $code = input('param.code');
        $email = input('param.email');

        $m = new UserCenterModel();
        $list =$m->mailbox_verify($mid,$code);
        $rt = $m->judge_email($mid,$email);
        if(empty($rt)){
            $this->redirect('user_center/account');
        }else{
            $this->redirect('user_center/account');
        }
    }
    /**修改头像*/
    public function up_img_data(){
        $post = input('post.','');
        extract($post);
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');

        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        $version_path = $info->getRealPath();//获取文件的绝对路径
        $version_name = $info->getFilename();//获取文件名

        if(!empty($info)){
            $rt = new Upload();
            $res1 = $rt->server_oss_img($version_name,$version_path);//上传OSS图片
            $id = check_login();

            $m = new UserCenterModel();
            $res = $m ->get_up_img_data($id,$version_name);//修改头像
            if(!empty($res)){
                ok_return('修改成功');
            }else{
                wrong_return('修改失败');
            }
        }else{
            wrong_return('上传失败');
        }
    }
}