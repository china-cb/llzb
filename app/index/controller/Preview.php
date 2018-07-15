<?php
namespace app\index\controller;
use app\index\model\AdminModel;
use app\index\model\PreviewModel;
use app\lib\TisApi;
use app\lib\WisApi;
use think\Controller;

class Preview extends CommonIndex
{
    protected  $instId;
    protected  $channel_info;
    public function __construct()
    {
        parent::__construct();
    }


    /** 玲珑TV首页 */
    public function index()
    {
        $post = input('param.',[]);
        extract($post);
        (empty($cid)) && wrong_return("缺少参数");
        $m = new PreviewModel();
        $channel_info = $m->get_channel_info($cid);
//      session("tis_id",$channel_info['tis_id']);
        $tis_id = cache("tis_id_".$cid);
        if(empty($tis_id)){
            cache("tis_id_".$cid,$channel_info['tis_id']);
        }
//        dump(cache("tis_id_".$cid));
        $mid = session('member_id');
        if(!empty($mid)){//会员观看
            $m = new PreviewModel();
            $user_info = $m->get_member_info($mid);
            $user_info['user_type'] = 1;
            $user_info['user_value'] = $mid;
        }else{//游客观看
            $ip = get_client_ip();
            $province = get_province_by_ip($ip);
            $user_info['nick_name'] = !empty($province)?$province."网友":"匿名网友";
            $user_info['user_type'] = 0;
            $user_info['user_value'] = $ip;
        }
        $this->assign("user_info",$user_info);
        $this->assign("channel_info",$channel_info);
        if($channel_info['wis_type'] == 1){
              //获取直播信息
              $live_record = $m->get_live_record_last($channel_info['uid'],$channel_info['id']);
              $this->assign("live_record",$live_record);
              return $this->fetch("white_live");
        }
        return $this->fetch();
    }

    /** 获取tis信息 */
    public function msg(){
        $cid = input('param.cid','');
        $method = $_REQUEST['method'];
        $api = new TisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));
        $instId = cache("tis_id_".$cid);
//        $instId = "dd8c5318bd0afb99ca70fa8c0bcf2746";
        $rst = $api->$method($_REQUEST,$instId);
        echo json_encode($rst);
    }

    /** 奥点云白板接口 */
    public function interface1(){
        $api = new WisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));

        $method = $_REQUEST['method'];
        if($method == "AllowDraw"){
            echo json_encode(array("Flag"=>100));
            exit();
        }
        $rst = $api->$method($_REQUEST);
        echo json_encode($rst);
    }

    /** 发言权限检测 */
    public function is_gag(){
        $post = input("param.",[]);
//        dump($post);die();
        extract($post);
        //检测发言权限
        $mid = session("member_id");
        if($mid != $uid){
            $m = new PreviewModel();
            if(!empty($mid)){ //说明是本站会员
                $res = $m->check_is_gag(1,$mid,$uid,$cid);
            }else{ //说明是游客
                $ip = get_client_ip();
                $res = $m->check_is_gag(0,$ip,$uid,$cid);
            }
            ($res === null) && wrong_return("注册会员后才能发言哦");
            if($res == 0) ok_return("success");
            wrong_return("您已被禁言,如有错误,请联系管理员");
        }
        ok_return("success");
    }

    /** 手机观看页面 */
    public function mobile(){
        return $this->fetch();
    }

    /** 获取置顶和tips删除信息*/
    public function get_top_delete_tips(){
        $cid = input('param.cid','');
        empty($cid) && wrong_return("频道ID不能为空");
        $m = new PreviewModel();
        $data = $m->get_top_gag_info_do($cid);

        (empty($data['top_info']) && empty($data['delete_info'])) && ok_return("没有置顶和删除记录",2);
        if(!empty($data['top_info'])){
            $data['top_info']['send_time'] = date("Y-m-d H:i:s",$data['top_info']['send_time']);
        }
        if(!empty($data['delete_info'])){
            foreach($data['delete_info'] as $k=>$v){
                $data['delete_list'][] = intval($v['send_time']);
            };
        }
        unset($data['delete_info']);
        ok_return("success",1,$data);
    }
}