<?php
namespace app\admin\controller;

use app\admin\model\MemberModel;
use app\api\model\LiveRecord;
use think\Controller;
use app\lib\Condition;
use app\admin\model\UserAvRoomModel;
use app\admin\model\LiveRecordModel;
use app\lib\Page;
class Room extends Common{

    public function index(){
        return $this->fetch();
    }
    //显示直播间列表
    public function show_list()
    {
        $page = input('param.page', 1);
        $source = input("param.source",'pc');

        //获取列表
        $map = '';
        $condition = input("param.search_word",'');
        if(!empty($condition)){
            $map['av_room_id'] = $condition;
        }
        $condition_rule = array(
            array(
                'field' => "mid",
                'value' => $condition,
                'operator'=> 'like'
            )
        );
        $model = new Condition($condition_rule,$page);//取数据
        $model->init();
        $m = new LiveRecordModel();
        $r = $m->get_liveing_record($model,$map,$source);
        $this->assign('page', $r->render());
        $this->assign('live_list', $r->all());
        $this->assign('total',$r->total());
        return $this->fetch();
    }
    //只是禁止该次直播
    /**
     * @param $live_id
     * @return bool
     */
    public function close_live(){

        $id = input('post.id',null);//直播记录id传入
        if(!$id) wrong_return('传入ID不能为空');

        $m = new LiveRecordModel();
        $rt = $m->set_live_stop($id);
        if($rt){
            ok_return("$id".'OK');
        }else{
            wrong_return('直播状态未改变');
        }

        wrong_return('该主播已经结束了直播');
    }
    /**
     * @param $live_id
     *
     * 结束本次直播，并且将该直播所在的房间号进行禁止。意味着主播被禁用直播间了,
     */
    /**
     * 直播中禁止房间（包括干掉当前直播）
     */
    public function stop_room(){
        $live_id = input('post.live_id',null);//直播记录id传入
        if(!$live_id) wrong_return('传入ID不能为空');

        $m = new LiveRecordModel();
        $rt = $m->set_live_stop($live_id);//返回true 或者 直接结束发警告
        //2.禁用该直播的主播的房间       //没有考虑小概率事件   此刻用户自己结束直播 ，根据实际可以更改
        if($rt) {
            $room = new UserAvRoomModel();
            $request = $room->stop_room_by_live_id($live_id);
            if($request){
                ok_return('禁止房间成功');
            }else{
                wrong_return('已经结束直播,但房间状态未改变');
            }
        }else{
            wrong_return('直播已经结束，未进行改变');//只是增加健壮性，无实际意义
        }

    }

    /**
     * 开启用户房间
     */
    public function start_room(){
        $room_id = input('post.room_id',null);//直播记录id传入
        if(!$room_id) wrong_return('传入ID不能为空');

        $m = new UserAvRoomModel();
        $rt = $m->set_room_start($room_id);//返回true 或者 直接结束发警告
        //2.禁用该直播的主播的房间       //没有考虑小概率事件   此刻用户自己结束直播 ，根据实际可以更改
        if($rt) {
            ok_return('房间状态恢复成功');
        }else{
            wrong_return('房间状态未进行改变');//只是作闭合处理，增加健壮性，无实际意义
        }

    }

    /**
     * @return 已禁用的房间列表
     */
    public function stop_room_list(){
        $page = input('param.page', 1);
        //获取列表
        $condition = input("param.search_word",'');
        $condition_rule = array(
            array(
                'field' => "id",
                'value' => $condition,
                'operator'=> 'like'
            ),
            array(
                'field' => "m.member_id",
                'value' => $condition,
                'operator'=> 'like',
                'relation' => 'or'
            )
        );

        $model = new Condition($condition_rule, $page);//取数据
        $model->init();
        $m = new UserAvRoomModel();
        $r = $m->get_stop_room_list($model);
        $this->assign('page', $r->render());
        $this->assign('stop_room_list', $r->all());
        return $this->fetch();
    }

    /**
     * 批量开启直播间
     */
    public function open_all_room(){
        $id = input('post.id');
        $m = new UserAvRoomModel();
        $result = $m->open_all_room_do($id);
        $result && ok_return("操作成功");
        wrong_return("操作失败");
    }


    public function stop_vip(){
        $post = input('param.','');

        $m = new MemberModel();
        $res = $m->stop_vip($post);

        if(empty($res)){
            wrong_return('设置失败');
        }else{
            ok_return('设置成功');
        }

    }

}