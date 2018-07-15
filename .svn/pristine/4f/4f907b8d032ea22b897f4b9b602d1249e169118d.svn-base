<?php
namespace app\index\model;
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/1/14
 * Time: 16:37
 */
class PreviewModel
{
    /** 获取频道信息 */
     public function get_channel_info($cid){
         return db("user_av_room r")
             ->join("channel_record c","r.id = c.cid","LEFT")
             ->field("r.*,count(c.id) as people")
             ->where("r.id",$cid)
             ->find();
     }

    /** 获取用户信息 */
    public function get_member_info($mid){
        return db("member")->field("member_id,nick_name,user_face")->find($mid);
    }

    /** 获取最后一次正在直播的直播记录信息 */
    public function get_live_record_last($uid,$cid){
        return db("live_record")->where(['uid'=>$uid,'cid'=>$cid,'status'=>1])->order("id desc")->limit(1)->find();
    }

    /** 检测是否有发言权限 */
    public function check_is_gag($type,$value,$uid,$cid){
        if($type == 1){
            $data = db("channel_record")->where(['uid'=>$uid,'cid'=>$cid,'mid'=>$value])->field("is_gag")->cache("is_gag",60)->find();
        }else{
            $data = db("channel_record")->where(['uid'=>$uid,'cid'=>$cid,'ip'=>$value])->field("is_gag")->cache("is_gag",60)->find();
        }
        return $data['is_gag'];
    }

    /** 初始化获取置顶,禁言和删除信息 */
    public function get_top_gag_info_do($cid){
        $data['top_info'] = db("top_news")->where(['cid'=>$cid,'status'=>1])->find();
        $data['delete_info'] = db("delete_tips")->field("send_time")->where(['cid'=>$cid,'status'=>1])->order("id desc")->limit(10)->select();
        return $data;
    }
}