<?php
namespace app\admin\model;

use think\Db;
Class UserAvRoomModel extends BaseModel
{

    protected $autoWriteTimestamp = true;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param $live_id
     * @return bool
     * 通过直播id 禁止直播所在房间
     */
    public function stop_room_by_live_id($live_id){
        $av_room_id = db('live_record')->where('id',$live_id)->value('av_room_id');
        $int = db('user_av_room')->where('id',$av_room_id)->update(['status'=>2]);

        if($int) return true;
        if(!$int) return false;
    }

    public function set_room_stop($room_id){

    }

    /**
     * @param $room_id
     * @return bool
     * 通过room id 开启房间状态
     */
    public function set_room_start($room_id){
        if(empty($room_id)) wrong_return('room_id 不能为空');
        $int = db('user_av_room')->where('id',$room_id)->update(['status'=>1]);
        if($int) return true;
        if($int) {
            $find = db('user_av_room')->where(array('id'=>$room_id,'status'=>1))->find();
            if($find) return true;

        }else{
            wrong_return('修改房间状态失败');
        }
    }


    public function get_stop_room_list($model){

        $condition = !empty($model) ? $model->wheresql : null;
        $m = db_func('user_av_room r', 'sp_');
        return $m->where($condition)
             ->where('r.status',2)
             ->join(['member m','sp_'],'r.member_id = m.member_id','LEFT')
             ->order('id desc')
             ->field('r.*,m.true_name,m.member_id')
             ->paginate(config('pre_page'));
    }

    //批量开启房间
    public function open_all_room_do($id){
       return db("user_av_room")->where('id','in',$id)->setField('status',1);
    }
}