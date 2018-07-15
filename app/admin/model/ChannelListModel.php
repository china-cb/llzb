<?php
/**
 * Created by PhpStorm.
 * User: 翟垒垒
 * Date: 2017/1/16
 * Time: 9:48
 */

namespace app\admin\model;


class ChannelListModel
{
    /** 频道列表 */
    public function get_channel_list($model, $map)
    {
        $condition = !empty($model) ? $model->wheresql : null;
        
        return db_func('member m', 'sp_')
            ->where($map)
            ->join('user_av_room u', 'm.member_id = u.uid', "LEFT")
//            ->join('channel_record c', 'm.member_id = c.uid', "LEFT")
//            ->join('live_record l','m.member_id = l.uid and l.status = 1','LEFT')
            ->field('m.account,m.num_id,m.member_id,count(u.id) u_num,u.id cid')
            ->group("m.member_id")
            ->paginate(5,4,['query' => request()->param()]);
    }
    /** 频道列表子频道 */
    public function get_user_channel($id,$model){
        $condition = !empty($model) ? $model->wheresql : null;

        return db_func('user_av_room u')
            ->where($condition)
            ->join('channel_record c','u.id = c.cid','LEFT')
            ->join('live_record l','u.id = l.cid','LEFT')
            ->field('u.title,u.cover,u.id,u.uid,max(c.update_time) update_time')
            ->where('u.uid',$id)
            ->group('u.id')
            ->paginate(5,4,['query' => request()->param()]);
    }
    /** 直播监控 */
    public function get_channel_info()
    {
        $condition = !empty($model) ? $model->wheresql : null;
        
        return db_func('live_record l', 'sp_')
            ->join('user_av_room u', 'l.cid = u.id', "LEFT")
            ->join('member m','l.uid = m.member_id','LEFT')
            ->where('l.status',1)
            ->field('m.account,m.num_id,m.member_id,u.id cid,u.title,u.cover,l.status,l.create_time,l.id lid')
            ->paginate(5,4,['query' => request()->param()]);
    }
    /** 关闭直播 */
    public function up_live_status($lid){
      return db_func('live_record')->where('id',$lid)->update(['status' => -1]);
    }
}