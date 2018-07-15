<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/12/13
 * Time: 10:35
 */

namespace app\index\model;


use think\Model;

class AdminModel extends Model
{
    /** 获取首页统计数据 */
    public function get_user_count_info($mid){
        //获取总频道数
        $data['all_rooms'] = db("user_av_room")->where("uid",$mid)->where('status','<>',-2)->count('id');
        //获取正在直播频道数
        $data['live_rooms'] = db("live_record")->where(['uid'=>$mid,'status'=>1])->count('id');
        return $data;
    }
    /** 获取频道列表 */
    public function get_channel_list($mid){
        return db("user_av_room")->where("uid",$mid)->where("status","<>",-2)->select();
    }

    /** 统计账单 */
    public function count_bill_do($mid){
        return db("cost_orders")->field("char_type as name,sum(cost_money) as value")->where("uid",$mid)->whereTime('create_time', 'month')->group("char_type")->select();
    }

    /** 本月花费总金额 */
    public function count_sum_all($mid){
        return db("cost_orders")->field("sum(cost_money) as all_money")->where("uid",$mid)->whereTime('create_time', 'month')->find()['all_money'];
    }
    /** 获取频道列表和统计数据 */
    public function get_channel_list_count($mid){
        return db("user_av_room u")
            ->join("channel_record c","u.id = c.cid","LEFT")
            ->field("u.*,count(c.id) as people,sum(c.watch_count) as watch_count")
            ->where("u.uid",$mid)
            ->where("u.status","<>",-2)
            ->group("u.id")
            ->select();
    }
    /** 获取频道最后直播时间 */
    public function get_channel_end_time($cid){
        return db("live_record")->field("end_time")->where(["cid"=>$cid,"status"=>-1])->limit(1)->order("create_time desc")->find()['end_time'];
    }
    /** 获取频道当前直播状态 */
    public function get_channel_live_status($mid,$cid){
        return db("live_record")->field("status")->where(['uid'=>$mid,'cid'=>$cid])->order("id desc")->limit(1)->find()['status'];
    }
    /** 统计频道数据 */
    public function count_channel_data($mid){
        return db("channel_record")->field("cid,count(id) as people,sum(watch_count) as watch_count")->where("uid",$mid)->group("cid")->select();
    }

     /** 创建频道 */
    public function set_channel_do($data){
        return db("user_av_room")->insertGetId($data);
    }

    /** 搜索频道 */
    public function search_channel_do($mid,$title){
//        return db("user_av_room u")->where(['uid'=>$mid,'title'=>$title])->where('status','<>',-2)->find();
        return db("user_av_room u")
            ->join("channel_record c","u.id = c.cid","LEFT")
            ->field("u.*,count(c.id) as people,sum(c.watch_count) as watch_count")
            ->where(['u.uid'=>$mid,'u.title'=>$title])
            ->where("u.status","<>",-2)
            ->group("u.id")
            ->select();
    }

    /** 更新频道的某个值 */
    public function update_channel_info($id,$field,$value){
        return db("user_av_room")->where("id",$id)->setField($field,$value);
    }

    /** 更新频道的信息数据 */
    public function update_channel($update_data){
        return db("user_av_room")->update($update_data);
    }

    /** 获取频道的详细信息 */
    public function get_channel_info($cid,$uid){
//        return db("user_av_room")->where('id',$cid)->find();
        return db("user_av_room u")
            ->join("member m","m.member_id = u.uid","LEFT")
            ->field("u.*,m.user_face")
            ->where(['u.id'=>$cid,'u.uid'=>$uid])
            ->find();
    }

    /** 获取视频列表 */
    public function get_video_list($cid){
        return db("video_list")->where(['cid'=>$cid,'status'=>1])->select();
    }

    /** 获取列表一的视频信息 */
    public function get_video_info($lid){
        return db("channel_video")->where("lid",$lid)->select();
    }

    /** 获取频道累计用户信息 */
    public function get_channel_user($cid,$uid){
       return db("channel_record")->where(['cid'=>$cid,'uid'=>$uid])->paginate(8);
    }

    /** 获取频道的统计信息 */
    public function get_channel_count_data($id){
        //统计直播状况信息
        $data = db("channel_record")->field("sum(visit_count) as visit_count,count(id) as people,count(distinct('ip')) as ip,sum(watch_count) as watch_count")->where("cid",$id)->select()['0'];
        //获取直播记录信息
        $channel_info = db("live_record")->where(['cid'=>$id,'status'=>1])->find();
        if(!empty($channel_info)){
            $data['online_time'] = NOW_TIME - $channel_info["create_time"];
        }else{
            $data['online_time'] = 0;
        }
        $data['max_online_time'] =  db("live_record")->field("max(end_time-create_time) as max_online_time")->where("cid",$id)->select()[0]['max_online_time'];
        $data['channel_title'] = db("user_av_room")->field("title")->where("id",$id)->where("status","<>",-2)->find()["title"];
        return $data;
    }

    /** 修改频道列表信息 */
    public function update_video_do($list_id,$list_name){
        return db("video_list")->where("list_id",$list_id)->setField("list_name",$list_name);
    }

    /** 删除列表 */
    public function del_video_by_id($id){
        return db("video_list")->where("list_id",$id)->setField("status",-1);
    }

    /** 添加频道列表 */
    public function add_video_list_do($cid){
        $data = [
            'cid'=>$cid,
            'list_name'=>"列表",
            'create_time'=>NOW_TIME
        ];
        return db("video_list")->insertGetId($data);
    }

    /** 获取列表直播流 */
    public function get_hls_list($cid,$lid){
        return db("channel_video")->field("vod_url")->where(['cid'=>$cid,'lid'=>$lid])->select();
    }

    /** 获取最后一次直播记录信息 */
    public function get_last_live_record($uid,$cid){
        return db("live_record")->where(['uid'=>$uid,'cid'=>$cid])->order("create_time desc")->limit(1)->find();
    }

    /** 添加直播记录 */
    public function add_live_record($data){
        return db("live_record")->insert($data);
    }

    /** 更新直播记录 */
    public function update_live_record($data){
        return db("live_record")->update($data);
    }

    /** 根据mid获取会员观看记录 */
    public function get_channel_record_by_mid($uid,$cid,$mid){
        return db("channel_record")->where(['uid'=>$uid,"cid"=>$cid,'mid'=>$mid])->find();
    }

    /** 根据ip获取游客观看记录 */
    public function get_channel_record_by_ip($uid,$cid,$ip){
        return db("channel_record")->where(['uid'=>$uid,"cid"=>$cid,'ip'=>$ip])->find();
    }

    /** 添加观看记录 */
    public function add_channel_record($data){
        return db("channel_record")->insert($data);
    }

    /** 更新观看记录 */
    public function update_channel_record($data){
        return db("channel_record")->update($data);
    }

    /** 根据mid获取用户基本信息 */
    public function get_user_info_by_mid($mid){
        return db("member")->where("member_id",$mid)->find();
    }

    /** 获取最后一次正在直播的直播记录信息 */
    public function get_live_record_last($uid,$cid){
        return db("live_record")->where(['uid'=>$uid,'cid'=>$cid,'status'=>1])->order("id desc")->limit(1)->find();
    }

    /** 结束正在直播的频道 */
    public function break_channel_live_do($uid,$cid){
        $data = [
            'status'=>-1,
            'end_time'=>NOW_TIME
        ];
        return db("live_record")->where(['uid'=>$uid,'cid'=>$cid,'status'=>1])->update($data);
    }

    /** 更新白板直播的开关 */
    public function update_channel_white_switch($cid,$white_value){
        return db("user_av_room")->where(['id'=>$cid])->setField("wis_type",$white_value);
    }

    /** 获取频道下累计的所有用户信息 */
    public function get_channel_user_by_cid($uid,$cid){
        return db("channel_record")->where(["uid"=>$uid,"cid"=>$cid])->select();
    }

    /** 根据mid/'ip获取频道观看者信息 */
    public function get_channel_user_info($uid,$cid,$map){
        return db("channel_record")
            ->where(['uid'=>$uid,'cid'=>$cid])
            ->where($map)
            ->find();
    }
    /** 频道用户禁言/解禁执行 */
    public function update_channel_user_info($id,$value){
         return db("channel_record")
             ->cache("is_gag")
             ->update(['id'=>$id,'is_gag'=>$value]);
    }

    /** 检测频道是否有其它置顶消息 */
    public function check_top_news($cid){
        return db("top_news")->where(['cid'=>$cid,'status'=>1])->find();
    }

    /** 置顶消息 */
    public function add_top_news($data){
        return db("top_news")->insert($data);
    }

    /** 取消置顶 */
    public function cancel_top_new_do($post){
        extract($post);
        return db("top_news")->where(['cid'=>$cid,'user_type'=>$user_type,'user_value'=>$user_value])->setField('status',-1);
    }

    /** 初始化获取置顶,禁言和删除信息 */
    public function get_top_gag_info_do($cid){
        $data['top_info'] = db("top_news")->field("send_time,user_type,user_value")->where(['cid'=>$cid,'status'=>1])->find();
        $data['gag_info'] = db("channel_record")->field("mid,ip")->where(['cid'=>$cid,"is_gag"=>1])->select();
        $data['delete_info'] = db("delete_tips")->field("send_time")->where(['cid'=>$cid,'status'=>1])->order("id desc")->limit(10)->select();
        return $data;
    }

    /** 删除tips消息执行 */
    public function delete_tips_do($cid,$send_time){
        $data = [
            'cid'=>$cid,
            'send_time'=>$send_time,
            'status'=>1,
            'create_time'=>NOW_TIME
        ];
        return db("delete_tips")->insert($data);
    }

    /** 获取刚上传的视频 */
    public function get_video_last_info($info){
        return db("channel_video")->where(['cid'=>$info['cid'],'lid'=>$info['lid']])->order("id desc")->select();
    }
}