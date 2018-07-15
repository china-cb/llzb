<?php
namespace app\index\model;

use app\core\model\Serversdk;
use think\Model;
use app\core\controller\Upload;
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/12/5
 * Time: 14:20
 */
class LoginModel extends Model
{
    /** 更新用户信息的某个字段 */
    public function update_user_info($mid,$field,$value){
        return db("member")->where("member_id",$mid)->setField($field,$value);
    }
    /** 验证用户手机号是已注册 */
    public function get_user_info_by_phone($phone){
        return db('member')->where("phone",$phone)->field("member_id")->find();
    }

    /** 验证用户手机号是否入手机验证码库 */
    public function get_phone_code_by_phone($map){
        return db('phone_code')->where($map)->find();
    }

    /** 注册新用户 */
    public function reg_do($post){
        $phone = $password = $cookie_code = '';
        extract($post);
        $data = [
            'phone' => strtolower($phone),
            'account'=>$phone,
            'password' => md6($password),
            'state'=>0,
            'pwd_grade'=>$post['pwd_grade'],
            'status'=>1,
            'reg_ip'=>get_client_ip(),
            'create_time' => NOW_TIME
        ];
        return db_func('member', 'sp_')->insertGetId($data);
    }

    /** 添加 session */
    public function add_user_session($session_data){
       return db('session_pc')->insert($session_data);
    }

    /** 添加登录或注册记录信息 */
    public function insert_log_manager($data){
        return db("log_manager")->insert($data);
    }
    /** 获取session信息 */
    public function get_session_info($mid){
        return db("session_pc")->where('uid',$mid)->find();
    }
    /** 设置用户登录后的信息 */
    public function set_login_info($user_info)
    {
        $ip = get_client_ip(); //获取登录ip
        //设置用户登录日志
        $data = [
            "uid" => $user_info['member_id'],
            "type" => 0,
            "phone" => $user_info['phone'],
            "source" => get_user_browser(),
            "ip" => $ip,
            "login_way" => 1,
//            "provicence"=>get_province_by_ip($ip),
//            "city"=>get_city_by_ip($ip),
            "create_time" => NOW_TIME
        ];
        db_func('log_manager', 'sp_')->insert($data);
    }

    /** 根据用户id查询用户信息 */
    public function get_user_info_by_mid($mid){
        return db('member')->where('member_id',$mid)->find();
    }

    /** 根据账号查询用户信息 */
    public function get_user_info_by_account($account){
        return db('member')->where("phone",$account)->whereOr("account",$account)->find();
    }

    /** 修改用户字段信息*/
    public function modify_user_info_do($mid,$type,$value){
        return db('member')->where('member_id',$mid)->setField($type,$value);
    }

    /** 更新用户信息 */
    public function update_user_info_do($data){
        return db("member")->update($data);
    }

    //三方登录
    public function thirdlogin($data) {

        if(empty($data['type']) || empty($data['unionid'])){
            return exit_array('缺少必要参数','');
        }

        if(!in_array($data['type'],array('weibo','qq','weixin'))){
            wrong_return('传入参数错误');
        }

        //处理经纬度
        $ip = get_client_ip_true();
        if(empty($data['longitude'])||empty($data['latitude'])){
            $data['longitude'] = get_logitude_by_ip($ip);
            $data['latitude'] = get_latitude_by_ip($ip);
        }
        //检测是否存在
        $check_type = $data['type'].'_id';
        $user_info = db('member')->where(array($check_type => $data['unionid'],'status'=>1))->find();

        if(empty($user_info)) {
            //为空，说明第一次登陆，执行首次内部注册
            $request = $this->thirdregist($data);

            if($request['code'] != 0){//有错误弹错误
            }else{
                //没错误，拿到同步信息
                $mid = $request['data']['uid'];//内含签名 ui
                $user_info = db('member')->where('member_id',$mid)->find();//
            }
        }
        //执行登录
        $res =  $this->_login_action($user_info);
        return $res;

    }
    private function thirdregist($data){
        $img_name = md5($data['pic_path_name']);
        $check_type = $data['type'].'_id';
        //插入数据
        $rt['user_face'] = $img_name;
        $rt['source'] = $data['source'];
        $rt['reg_ip'] = get_client_ip();
        $rt['nick_name'] =  $data['nick_name'];
        $rt['create_time'] = NOW_TIME;
        $rt["$check_type"] = $data['unionid'];

        $mid =db_func('member','sp_')->insertGetId($rt);//用户插入一条新数据，并且返回uid
        if($mid <= 0) {
            return exit_array(119,0,$m='三方内部注册失败,请重新登录');
        }
        $pic_info = GrabImage($url = $data['pic_path_name']);
        $rt = new Upload();
        $res = $rt->server_oss_img($img_name,$pic_info);

        if($res == -1){
            exit_json(117,"OSS图片上传失败");
        }

        //分配会员号 num
        $num = INIT_LIVE_NUM + $mid;//一般会员生成规则
        db_func('member','sp_')->where('member_id',$mid)->update(['num_id'=>$num]);
//        $existInfo = db_func('member','sp_')->where(array('num_id'=>$num))->find();//查下有没有注册过
//        $goodnum = checkGoodNum($num);
//        if (!empty($existInfo)||$goodnum) {//有记录或者是吉祥号
//            for($i=0;$i<1000;$i++){
//                $num =INIT_LIVE_NUM*2 + $mid+$i;
//                $temp = db_func('member','sp_')->where(array('num_id'=>$num))->find();//查下有没有注册过
//                $isgood = checkGoodNum($num);
//                if(empty($temp)&&empty($isgood)) {
//                    break;//没注册过 ，且不是吉祥号，就用这个号
//                }else{
//                    exit_array(120,0,'注册分配会员号错误，请重新登录');
//                }
//            }
//        }
        //插入注册记录表
        $list = [
            'uid'=>$mid,
            'type'=>1,  //注册
            'phone'=>$num,
            'source'=>get_user_browser(),
            'login_way'=>1, //pc
            'ip'=>get_client_ip(),//获取登录ip
            'create_time'=>NOW_TIME
        ];
        $resu = $this->insert_log_manager($list);
        ($resu <= 0) && wrong_return("记录插入失败");

        $userinfo = db('member')->where('member_id',$mid)->find();

        $data = array();
        $data['uid'] = $mid;
        $data['identify'] = $userinfo['tencent_uid'];
        $data['nickname'] = $userinfo['nick_name'];
        $data['user_face'] = $userinfo['user_face'];

        return exit_array(0,1,'内部注册成功',$data);
    }
    //执行登录操作
    private function _login_action($user_info){
        $ip = get_client_ip();
        //更新用户信息
        $user_map['member_id'] = $user_info['member_id'];

        $user_data['last_login_ip'] =$ip;
        $user_data['last_login_time'] = NOW_TIME;
        $user_data['login_count'] = $user_info['login_count']+1;


        $user_up =db('member')->where($user_map)->update($user_data);
        if(!$user_up) return exit_array(135,0,'用户信息更新错误');

        $randsal = createNumber(4);
        $session_data['uid'] = $user_info['member_id'];
        $session_data['session_id'] = md5(time().$user_info['member_id'].$randsal);
        $session_data['enable'] = 'true';
        $session_data['create_time'] = time();
        $session_data['session_expire_time'] = time() + config('session_expire');
        $session_data['randsal'] = $randsal;

        $SessionUser = db('session_pc');
        $session_info = $SessionUser->where(['uid'=> $session_data['uid']])->find();
        //有就更新，没就增加

        $up = $add = false;
        if(!empty($session_info)){
            $up = $SessionUser->where(['uid'=> $user_info['member_id']])->update($session_data);
            if(empty($up)) return exit_array('更新失败','');
        }else{
            $add = $SessionUser->insert($session_data);
        }
        if ($up||$add) {
            session("session_id",$session_data['session_id']);
            session("member_id",$user_info['member_id']);
            $user_info['third'] = 1;
            return $user_info;
        }else{
            wrong_return('seesion存入错误');
        }
    }
    /**  */
    public function get_use_list($member_id){
        return db_func('member','sp_')->where('member_id',$member_id)->find();
    }

}