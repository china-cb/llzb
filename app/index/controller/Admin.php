<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/12/12
 * Time: 17:22
 */

namespace app\index\controller;

use app\core\controller\Business;
use app\core\model\BusinessModel;
use app\index\model\AdminModel;
use app\lib\DmsApi;
use app\lib\PhpExcel;
use app\lib\TisApi;
use app\lib\WisApi;
use think\Controller;

class Admin extends Common
{
    public function test(){
        return $this->fetch();
    }
    /** 控制台首页 */
    public function index(){
        $mid = check_login();
        $m = new AdminModel();
        $data = $m->get_user_count_info($mid);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**正在开发中**/
    public function developing(){
        return $this->fetch();
    }


    /** ajax统计账单情况 */
    public function count_bill(){
        $mid = check_login();
        $m = new AdminModel();
        //本月类型账单
        $count_data = $m->count_bill_do($mid);
        //本月总花费
        $all_money = $m->count_sum_all($mid);
        $all_money = round($all_money,1);
        foreach($count_data as $k=>$v){
            $count_data[$k]['value'] = round($v['value'],1);
            $bili = round($v['value']/$all_money,4)*100;
            if($v['name'] == 1){
                $count_data[$k]['name'] = "直播"." : ".$bili."%";
            }else{
                $count_data[$k]['name'] = "点播"." : ".$bili."%";
            }
        }
//        dump($count_data);
        (!empty($count_data)) && ok_return("success",1,$count_data);
        wrong_return("获取失败");
    }

    /** 频道管理列表 */
    public function channel_manage(){
        $type = input("param.type",'');
        $mid = check_login();
        $m = new AdminModel();
        $channel_list = $m->get_channel_list_count($mid);

        foreach($channel_list as $k=>$v){
            $channel_list[$k]['watch_count'] = ceil($v['watch_count']);
            $channel_list[$k]['end_time'] = $m->get_channel_end_time($v['id']);
            $channel_list[$k]['live_status'] = $m->get_channel_live_status($mid,$v['id']);
            $channel_list[$k]['mobile_live'] = Url('index/preview/mobile',['cid'=>$v['id'],false,true]);
        }

        $this->assign('channel_list',$channel_list);
        $this->assign('type',$type);
        return $this->fetch();
    }

    /** 创建频道 */
    public function set_channel(){
        $mid = check_login();
        $post = input("param.","");
        extract($post);
        (empty($title)) && wrong_return("频道名称不能为空");
        //创建白板服务
        $api = new WisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));
        $param = [
            "desc" => "linglong",
            "dmsSecKey"=>"s_19d2ea8b7f9d92e2686fe9c11fec00df",
            "lssApp" => "linglong735"
        ];
        $result = $api->CreateWis($param);
        ($result['Flag'] != 100) && wrong_return("白板创建失败");
        //创建频道
        $data = [
            'uid'=>$mid,
            'status'=>1,
            'title'=>$title,
            'wisId'=>$result['Info']['wisId'],
            'auth_key'=>$result['Info']['authKey'],
            'create_time'=>NOW_TIME
        ];
        $m = new AdminModel();
        $channel_id = $m->set_channel_do($data);
        //创建tis聊天服务
        $tis = new TisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));
        $arr = [
            "dmsSecKey"=>"s_19d2ea8b7f9d92e2686fe9c11fec00df",  //dms服务中的s_key
            "auditEnable"=>0,        //可选，默认为0。是否开启消息审核。
            "filterType"=>3,         //可选，默认为0。当开启审核时起作用。0:不过滤，1:包含关键字的需要审核，3:包含关键字的直接替换为*
            "filterKeys"=>"",    //可选，默认为""
            "description"=>$mid."_".$channel_id."_tis",    //可选，默认为""，描述
            "groupIds"=>[928,1]      //可选，需要关联的表情组的Id，该表情组必须是已经存在的。
            //表情组Id可以在控制台--TIS服务--表情管理--选择一个表情组--查看表情--浏览器地址上的groupId参数中获取
        ];
        $result2 = $tis->create_tis($arr);

        if($channel_id > 0 && $result2['Flag'] == 100){
            $stream = $mid."_".$channel_id;
            //获取推流和拉流地址
            $api = new Business();
            $address = $api->get_push_url($stream);

            if(!empty($address)){
                //更新频道
                $update_data = [
                    'id'=>$channel_id,
                    'stream'=>$stream,
                    'push_url'=>$address['push_url'],
                    'rtmp'=>$address['rtmp'],
                    'hls'=>$address['hls'],
                    'tis_id'=>$result2['id']
                ];
                $res = $m->update_channel($update_data);
                ($res > 0) && ok_return("创建成功");
            }
        }
        wrong_return("创建失败");
    }

    /** 获取流地址信息 */
    public function ajax_liu_info(){
        $uid = check_login();
        $cid = input("post.cid",'');
        $m = new AdminModel();
        $channel_info = $m->get_channel_info($cid,$uid);
        empty($channel_info) && wrong_return("频道信息不存在");
//        dump(config('CONFIG_CDN_URL'));
        if(!empty($channel_info['cover'])){
            $channel_info['cover'] = config('CONFIG_CDN_URL').$channel_info['cover'];
        }else{
            $channel_info['cover'] = config('CONFIG_CDN_URL')."97e76f3cf45e0e1c2a69e7bb1ae9ea73.png";
        }
//        $this->assign("channel_info",$channel_info);
//        $data = [
//            'code'=>1,
//            'html'=>$this->fetch()
//        ];
//        die_json($data);
        ok_return("success",1,$channel_info);
    }
    /** 搜索频道 */
    public function search_channel(){
        $mid = check_login();
        $title = input("param.title",'');
        empty($title) && wrong_return("频道名称不能为空");

        $m = new AdminModel();
        $channel_info = $m->search_channel_do($mid,$title);
        empty($channel_info) && wrong_return("没找到该频道");
        $channel_info = $channel_info['0'];
        $channel_info['watch_count'] = ceil($channel_info['watch_count']);
        $channel_info['end_time'] = $m->get_channel_end_time($channel_info['id']);
        $channel_info['live_status'] = $m->get_channel_live_status($mid,$channel_info['id']);
        $this->assign("channel_info",$channel_info);
        $data = [
            'code'=>1,
            'html'=>$this->fetch()
        ];
        die_json($data);
    }

    /** 删除频道 */
    public function del_channel(){
        $mid = check_login();
        $id = input("param.id",'');
        empty($id) && wrong_return("频道ID不存在");
        
        $m = new AdminModel();
        $res = $m->update_channel_info($id,"status",'-2');
        ($res > 0) && ok_return("删除成功");
        wrong_return("删除失败");
    }

    /** 频道设置管理 */
    public function channel(){
        $cid = input("param.id",'');
        $mid = check_login();
        empty($cid) && die("频道不存在");
        //查询频道详细信息
        $m = new AdminModel();
        $channel_info = $m->get_channel_info($cid,$mid); //获取频道房间信息
//        session("admin_tis_id",$channel_info['tis_id']);
        $tis_id = cache("tis_id_".$cid);
        if(empty($tis_id)){
            cache("tis_id_".$cid,$channel_info['tis_id']);
        }
//      dump(session("admin_tis_id"));
        $video_list = $m->get_video_list($cid);  //获取视频列表
        foreach($video_list as $k=>$v){
            $video_list[$k]['data'] = $m->get_video_info($v['list_id']);
        }
        $this->assign([
            "channel_info"=>$channel_info,
            "video_list"=>$video_list,
            "uid"=>$mid
        ]);
        //获取白板url
        $authKey = $channel_info["auth_key"];
        $userId = 26836;
        $wisId = $channel_info["wisId"];
        $power = 60; //观看端为1, 上麦端为60
        $domain = "";
        $expire = NOW_TIME + 24*60*60; //有效期一天
        $rand = rand(1000,9999).'';
        $signStr = $this->signStr($authKey, $userId, $wisId, $power, $domain, $expire, $rand);
        $dmn = empty($_REQUEST['domain'])?'':1;
        $recordUrl =
            "wisId=".$wisId.
            "&power=".$power.
            "&expire=".$expire.
            "&rand=".$rand.
            "&dmn=".$dmn.
            "&sign=".$signStr;
//        echo "上麦地址：".$recordUrl;
//        dump($recordUrl);
        $this->assign("recordUrl",$recordUrl);
        return $this->fetch();
    }

    public function signstr($authKey, $wisId, $userId, $domain, $power, $expire, $rand){
        $sigArr = array($wisId, $userId.'', $expire.'');
        if(!empty($power))
            $sigArr[] = $power;
        if(!empty($domain))
            $sigArr[] = $domain;
        if(!empty($rand))
            $sigArr[] = $rand;
        sort($sigArr,SORT_STRING);
        $signStr = join("",$sigArr);
        return urlencode(base64_encode(hash_hmac("sha1", $signStr, $authKey, true)));
    }


    /** 频道数据统计 */
    public function channel_count(){
        $cid = input('param.id','');
        (empty($cid)) && die("参数错误");
        $mid = check_login();
        $m = new AdminModel();
        //获取所有频道
        $channel_list = $m->get_channel_list($mid);
        //获取当前频道信息
        $channel_info = $m->get_channel_info($cid,$mid);
        //获取当前频道的用户信息
        $r = $m->get_channel_user($cid,$mid);
        $this->assign('channel_list',$channel_list);
        $this->assign('channel_info',$channel_info);
        $this->assign('page', $r->render());
        $this->assign('channel_user', $r->all());
        $this->assign('total',$r->total());
        return $this->fetch();
    }

    /** ajax频道用户列表 */
    public function ajax_channel_user(){
        $id = input("param.id","");
        empty($id) && wrong_return("频道ID不存在");
        $mid = check_login();
        $m = new AdminModel();
        //获取频道的用户信息
        $r = $m->get_channel_user($id,$mid);
        $this->assign('page', $r->render());
        $this->assign('channel_user', $r->all());

        $data = [
            'code'=>1,
            'total'=>$r->total(),
            'html'=>$this->fetch()
        ];
        die_json($data);
    }

    /** 频道设置 */
    public function channel_setting(){
        $id = input("param.id","");
        $this->assign('id',$id);
        return $this->fetch();
    }

    /** 频道数据统计 */
    public function channel_count_data(){
        $id = input("param.id","");
        empty($id) && wrong_return("频道ID不存在");
        $mid = check_login();
        $m = new AdminModel();
        //获取所有频道
        $channel_list = $m->get_channel_list($mid);
        //获取频道的统计信息
        $count = $m->get_channel_count_data($id);
        $this->assign('channel_list',$channel_list);
        $this->assign('count',$count);
        $this->assign('channel_id',$id);
        return $this->fetch();
    }

    /** 频道每月新增人数 */
    public function count_text(){
        $id = input("param.id",'');
        $list = db_func("live_record","sp_")->field("id,online_num,end_time")->where(["cid"=>$id,"status"=>-1])->order("create_time desc")->limit(5)->select();
        sort($list);
//        $data = array();
//        foreach($res as $key=>$value){
//            $value['flag'] = date("m",$value['create_time']);
//            if(!isset($data[$value['flag']])){
//                $data[$value['flag']] = 0;
//            }
//            $data[$value['flag']] ++;
//        }
        foreach($list as $k=>$v){
            $list[$k]['end_time'] = date("m/d H:i",$v['end_time']);
        }
        ok_return("success",1,$list);
    }
    /** 获取上传插件页面 */
    public function upload_html(){
        $post = input('param.','');
        if(empty($post['cid'] || empty($post['lid'])))  wrong_return("参数异常,请重新上传");
        session("chan_info",$post);
        $data = [
            'code'=>1,
            'html'=>$this->fetch()
        ];
        die_json($data);
    }
    /** 上传执行　*/
    public function upload_do()
    {
        $mid = check_login();
        // Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        $access_id =  config("LIVE_ACCESS_ID"); //填入access_id
        $access_key = config("LIVE_ACCESS_KEY");//填入access_key
        $upload_api = 'http://upload.dvr.aodianyun.com/v2'; //上传接口地址
// 5 minutes execution time
        @set_time_limit(5 * 60);
// Get a file name
        if (isset($_POST["name"])) {
            $fileName = $_POST["name"];
        } elseif (isset($_GET["name"])) {
            $fileName = $_GET["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        }

// Chunking might be enabled
        $chunk = 0;
        $chunks = 0;
        if (isset($_POST["chunk"])) {
            $chunk = intval($_POST["chunk"]);
        } elseif (isset($_GET["chunk"])) {
            $chunk = intval($_GET["chunk"]);
        }
        if (isset($_POST["chunks"])) {
            $chunks = intval($_POST["chunks"]);
        } elseif (isset($_GET["chunks"])) {
            $chunks = intval($_GET["chunks"]);
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !$_FILES["file"]["size"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"Flag":101,"FlagString":"服务器异常，无法移动上传的文件。"}');
            }
        }

        $part = urlencode(base64_encode(file_get_contents($_FILES["file"]["tmp_name"])));
        $partNum = $chunk + 1;//partNum从1开始
        $param = array(
            'access_id' => $access_id,
            'access_key' => $access_key,
            'fileName' => $fileName,
            'part' => $part,
            'partNum' => $partNum
        );
        $res = $this->curl($upload_api . '/DVR.UploadPart', 'parameter=' . json_encode($param));
        if (!empty($res)) {
            $res = json_decode($res, true);
            if ($res['Flag'] != 100) {
                die('{"Flag":102,"FlagString":"' . $res['FlagString'] . '"}');
            }
        } else {
            die('{"Flag":102,"FlagString":"Part文件上传接口或网络异常"}');
        }

// Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            $param = array(
                'access_id' => $access_id,
                'access_key' => $access_key,
                'fileName' => $fileName
            );
            $success = $this->curl($upload_api . '/DVR.UploadComplete', 'parameter=' . json_encode($param));
            if (!empty($success)) {
                $res = json_decode($success, true);
                if ($res['Flag'] != 100) {
                    die('{"Flag":102,"FlagString":"' . $res['FlagString'] . '"}');
                }
                if(isset($res['location']) && isset($res['fileName'])){
                    $arr = [
                        'access_id' => $access_id,
                        'access_key' => $access_key,
                         'url'=>$res['location']
                    ];
                    $video_info = $this->curl("http://openapi.aodianyun.com/v2/VOD.GetUploadVodList",'parameter=' . json_encode($arr));
                    if(!empty($video_info)){
                        //插入数据库
                        $video = json_decode($video_info, true);
                        $info = session("chan_info");
//                        dump($info);
                        $data = [
                            'cid'=>$info['cid'],
                            'lid'=>$info['lid'],
                            'name'=>$fileName,
                            'cover_img'=>$video['List'][0]['thumbnail'],
                            'duration'=>pc_auto_sec(intval($video['List'][0]['duration'])),
                            'mss_url'=>$res['location'],
                            'vod_url'=>$video['List'][0]['adaptive'],
                            'create_time'=>NOW_TIME
                        ];
                        $result = db_func("channel_video")->insert($data);
                    }
                }
            } else {
                die('{"Flag":102,"FlagString":"上传完成接口或网络异常"}');
            }
        }
        die('{"Flag":100,"FlagString":"上传完成"}');
    }
    public function curl($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    /** 获取上传成功后的视频列表 */
    public function get_video_success(){
        $info = session("chan_info");
        (empty($info['cid'] || empty($info['lid']))) && wrong_return("缺少必要参数");
        $m = new AdminModel();
        $list =$m->get_video_last_info($info);
        $num = count($list);
        if(!empty($list) && $num == 1){  //说明该列表是第一次上传视频
            $this->assign("list",$list['0']);
            $data = [
                'code'=>2,
                'html'=>$this->fetch('first_video_info')
            ];
            die_json($data);
        }else if($num > 1){  //说明原列表中已经有视频了
            $this->assign("list",$list['0']);
            $data = [
                'code'=>1,
                'html'=>$this->fetch('video_info')
            ];
            die_json($data);
        }else{
            wrong_return("上传失败");
        }
    }

    /** 添加视频列表 */
    public function add_video_list(){
        $post = input("param."."");
        extract($post);
        empty($cid) && wrong_return("频道ID不能为空");
        $m = new AdminModel();
        $list_id = $m->add_video_list_do($cid);
        ($list_id > 0) && ok_return('success',1,$list_id);
    }

    /** 修改频道列表直播信息 */
    public function update_video(){
        $post = input("param."."");
        extract($post);
        empty($list_name) && wrong_return("列表名称不能为空");
        empty($list_id) && wrong_return("列表id不能为空");
        $m = new AdminModel();
        $res = $m->update_video_do($list_id,$list_name);
        ($res !== false) && ok_return("操作成功");
        wrong_return("操作失败");
    }

    /** 删除频道列表直播的列表 */
    public function del_video(){
        $id = input("param.id","");
        empty($id) && wrong_return("列表ID不存在");
        $m = new AdminModel();
        $res = $m->del_video_by_id($id);
        ($res > 0) && ok_return("删除成功");
        wrong_return("删除失败");
    }

    /** 拉流直播 */
    public function update_live(){
        $post = input("param.",'');
        $this->assign('rtmp_url',$post['live_url']);
        $this->assign('rank',NOW_TIME);
        $data = [
            'code'=>1,
            'html'=>$this->fetch("live")
        ];
        die_json($data);
    }

    /** 列表点播直播 */
    public function hls_live(){
        $post = input("param.",'');
        extract($post);
        (empty($cid) || empty($lid)) && wrong_return("缺少参数");
        $m = new AdminModel();
        $data = [];
        $list = $m->get_hls_list($cid,$lid);
        foreach($list as $k=>$v){
            $data[] = $v['vod_url'];
        };
        ok_return("success",1,$data);
    }

    /** 控制台开始或切换直播流 */
    public function update_live_record(){
        $uid = check_login();
        $post = input("param.",[]);
        extract($post);
        (empty($cid) || empty($live_url) || empty($url_style) || empty($live_type)) && wrong_return("缺少必要参数");
        //查询上一次直播是否结束
        $m = new AdminModel();
        $record_info = $m->get_last_live_record($uid,$cid);
        if(empty($record_info) || (isset($record_info['status']) && $record_info['status'] == -1)){
             //说明是第一次直播或者直播已结束,则重新添加直播记录
             $channel_info = $m->get_channel_info($cid,$uid); //获取频道信息
             $data = [
                 "uid"=>$uid,
                 "cid"=>$cid,
                 "status"=>1,
                 "url_style"=>$url_style,
                 "url_time"=>NOW_TIME,
                 "url_status"=>1,
                 "push_status"=>$channel_info['push_switch'],
                 "create_time"=>NOW_TIME
             ];
            if($url_style == 1){
                $data['rtmp_url'] = $live_url;
            }else if($url_style == 2){
                $data['hls_url'] = $live_url;
            }else{
                $data['rtmp_url'] = $live_url;
            }
           $res = $m->add_live_record($data);
        }else{
            //说明正在直播,只是切换不同的流
            $data = [
                "id"=>$record_info['id'],
                "url_style"=>$url_style,
                "url_time"=>NOW_TIME
            ];
            if($url_style == 1){
                $data['rtmp_url'] = $live_url;
            }else if($url_style == 2){
                $data['hls_url'] = $live_url;
            }else{
                $data['rtmp_url'] = $live_url;
            }
            $res = $m->update_live_record($data);
        }
        //更新频道当前推流类型
        $result = $m->update_channel_info($cid,"live_type",$live_type);
        ($res !== false && $result !== false) && ok_return("操作成功");
        wrong_return("操作失败");
    }

    /** 白板观看页面 */
    public function white_live(){
        $get = input("param.",[]);
        extract($get);
        $mid = check_login();
        $m = new AdminModel();
        //获取频道信息
        $channel_info = $m->get_channel_info($cid,$mid);
        //获取直播信息
        $live_record = $m->get_live_record_last($channel_info['uid'],$cid);
        $this->assign("channel_info",$channel_info);
        $this->assign("live_record",$live_record);
        return $this->fetch();
    }

    /** 奥点云白板和tis接口 */
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

    /** 直播第一次加载获取播放的url */
    public function get_first_url(){
        $post = input("param.",[]);
        extract($post);
        (empty($cid) || empty($uid)) && wrong_return("缺少参数");
        $m = new AdminModel();
        $live_record = $m->get_live_record_last($uid,$cid);
        if(!empty($live_record)){
            switch($live_record['url_style']){
                case 1:
                    $data['url'] = $live_record['rtmp_url'];
                    break;
                case 2:
                    $data['url'] = $live_record['hls_url'];
                    break;
                default:
                    $data['url'] = $live_record['hls_url'];
            }
            $data['url_style'] = $live_record['url_style'];
            $data['last_time'] = $live_record['url_time'];
            ok_return("获取成功",1,$data);
        }else {
            $channel_info = $m->get_channel_info($cid,$uid);
            (empty($channel_info)) && wrong_return("频道信息不存在");
            if ($channel_info['push_switch'] == 1 && $channel_info['live_type'] == 1) {
                //检测obs是否在推流
                $arr = [
                    'access_id' => config("LIVE_ACCESS_ID"),//填入access_id
                    'access_key' => config("LIVE_ACCESS_KEY"),//填入access_key
                    'appid' => config("LIVE_APP_ID"),//填入live_app_id,
                    'stream' => $uid . "_" . $cid
                ];
                $result = $this->curl("http://openapi.aodianyun.com/v2/LSS.GetAppLiveStatus", 'parameter=' . json_encode($arr));//判断是否在直播接口
                $result = json_decode($result, true);
                if ($result['Flag'] == 100 && $result['Living'] == 1) { //说明该obs正在推流,当上一次直播结束时,新建一条直播记录
                    $array = [
                        "uid" => $uid,
                        "cid" => $cid,
                        "status" => 1,
                        "url_style" => 1,
                        "url_time" => NOW_TIME,
                        "rtmp_url" => $channel_info['rtmp'],
                        "hls_url" => $channel_info['hls'],
                        "create_time" => NOW_TIME
                    ];
                    $res = $m->add_live_record($array);
                    ($res > 0) && ok_return("获取直播推流成功", 1, ["live_url" => $channel_info['rtmp'], "url_style" => 1, "last_time" => $array['url_time']]);
                }
            }
        }
        wrong_return("该频道暂未直播,请观看其它频道吧");
    }

    /** 结束直播 */
    public function break_channel_live(){
        $post = input("param.","");
        extract($post);
        $m = new AdminModel();
        (empty($cid) || empty($uid)) && wrong_return("缺少参数");
        $live_record = $m->get_live_record_last($uid,$cid);
        if(!empty($live_record)){
            //说明正在直播,结束该直播
            $res = $m->break_channel_live_do($uid,$cid);
            //将频道的live_type回归为1,obs可播状态
            $result = $m->update_channel_info($cid,"live_type",1);
            ($res > 0 && $result !== false) && ok_return("断开成功",1,$live_record['url_style']);
            wrong_return("断开失败");
        }
        wrong_return("直播已结束,请勿重复提交");
    }

    /** 白板开关 */
    public function white_switch(){
        $post = input('param.',[]);
        extract($post);
        (empty($cid) || !isset($white_value)) && wrong_return("缺少参数");
        $m = new AdminModel();
//        $channel_info = $m->get_channel_info($cid);
//        (empty($channel_info)) && wrong_return("频道信息不存在");
//        //奥点远程开启和关闭白板
//        $api = new WisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));
//        $param = [
//            "wisId" => $channel_info['wisId'],
//            "state"=>($white_value == 1)?1:0,  //默认关闭
//        ];
//        $result = $api->off_Wis($param);
//        ($result['Flag'] != 100) && wrong_return("白板修改失败");
        $res = $m->update_channel_white_switch($cid,$white_value);
        if($res > 0 && $white_value == 1){
            ok_return("打开成功");
        }elseif($res > 0 && $white_value == 0){
            ok_return("关闭成功");
        }
        wrong_return("操作失败");
    }

    /** 导出用户数据到excel */
    public function export_user_data(){
        $cid = input('param.cid','');
        $uid = check_login();
        $m = new AdminModel();
        $data = $m->get_channel_user_by_cid($uid,$cid);
        (empty($data)) && die("暂无数据");
        $name='Excelfile';    //生成的Excel文件文件名
        $excle = new PhpExcel();
        $excle->push($data,$name);
    }

    /** 用户禁言 / 解禁 */
    public function gag_channel_user(){
        $uid = check_login();
        $post = input("param.",[]);
        extract($post);
        (empty($cid) || !isset($is_gag) || !isset($user_type) || empty($user_value)) && wrong_return("缺少参数");
        if($uid == $user_value) wrong_return("管理员不可被禁言");
        $m = new AdminModel();
        if($user_type == 1){//代表是本站会员
             $map['mid'] = $user_value;
        }else{ //代表游客
            $map['ip'] = $user_value;
        }
        $user_info = $m->get_channel_user_info($uid,$cid,$map);
        (empty($user_info)) && wrong_return("用户信息不存在");
        if($is_gag == 1){  //禁言
            $value = 1;
            $tips = "禁言";
            ($user_info['is_gag'] == 1) && wrong_return("该用户已被禁言过了,请勿重复操作");
        }else{  //解禁
            $value = 0;
            $tips = "解禁";
            ($user_info['is_gag'] == 0) && wrong_return("该用户已被解禁过了,请勿重复操作");
        }
        $res = $m->update_channel_user_info($user_info['id'],$value);
        ($res > 0) && ok_return($tips."成功",1,$user_info['nick_name']?$user_info['nick_name']:"匿名网友");
        wrong_return($tips."失败");
    }

    /** 消息置顶 */
    public function top_news(){
        $post = input("param.",[]);
        extract($post);
        (empty($cid) || empty($nick_name) || empty($user_face) || empty($content) || empty($send_time) || empty($user_type) || empty($user_value)) && wrong_return("缺少参数");
        $m = new AdminModel();
        //检测该频道是否有其它置顶消息
        $news_info = $m->check_top_news($cid);
        (!empty($news_info)) && wrong_return("一个频道只允许一个置顶消息");
        $data = [
            "cid"=>$cid,
            "nick_name"=>$nick_name,
            "user_face"=>$user_face,
            "content"=>$content,
            "send_time"=>$send_time,
            "user_type"=>$user_type,
            "user_value"=>$user_value,
            "status"=>1,
            "top_time"=>NOW_TIME
        ];
        $res = $m->add_top_news($data);
        ($res > 0) && ok_return("置顶成功");
        wrong_return("置顶失败");
    }

    /** 取消置顶 */
    public function cancel_top_new(){
        $post = input("param.",[]);
        extract($post);
        (empty($cid) && empty($user_type) && empty($user_value)) && wrong_return("缺少参数");
        $m = new AdminModel();
        $res = $m->cancel_top_new_do($post);
        ($res > 0) && ok_return("取消置顶成功");
        wrong_return("取消置顶失败");
    }

    /** 后台获取tis信息 */
    public function msg(){
        $cid = input('param.cid','');
        $method = $_REQUEST['method'];
        $api = new TisApi(config("LIVE_ACCESS_ID"),config("LIVE_ACCESS_KEY"));
//        $instId = session("admin_tis_id");
        $instId = cache("tis_id_".$cid);
//        dump($instId);
//        $instId = "dd8c5318bd0afb99ca70fa8c0bcf2746";
        $rst = $api->$method($_REQUEST,$instId);
        echo json_encode($rst);
    }

    /** 页面初始化获取置顶和禁言记录 */
    public function get_top_gag_info(){
        $cid = input('param.cid','');
        empty($cid) && wrong_return("频道ID不能为空");
        $m = new AdminModel();
        $data = $m->get_top_gag_info_do($cid);
        (empty($data['top_info']) && empty($data['gag_list'])) && ok_return("没有置顶和禁言记录",2);
        if(!empty($data['gag_info'])){
            foreach($data['gag_info'] as $k=>$v){
                if(!empty($v['mid'])){
                    $data['gag_list'][] = strval($v['mid']);
                }else{
                    $data['gag_list'][] = $v['ip'];
                }
            };
        }
        if(!empty($data['delete_info'])){
            foreach($data['delete_info'] as $k=>$v){
               $data['delete_list'][] = intval($v['send_time']);
            };
        }
        unset($data['gag_info']);
        unset($data['delete_info']);
        ok_return("success",1,$data);
    }

    /** 删除tips消息 */
    public function delete_tis(){
        $post = input("param.",[]);
        extract($post);
        (empty($cid) && empty($send_time)) && wrong_return("缺少参数");
        $m = new AdminModel();
        $res = $m->delete_tips_do($cid,$send_time);
        ($res > 0) && ok_return("删除成功");
        wrong_return("删除失败");
    }
}