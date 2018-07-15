<?php
/**
 * Created by PhpStorm.
 * User: 翟垒垒
 * Date: 2017/1/16
 * Time: 9:48
 */
namespace app\admin\controller;

use app\admin\model\ChannelListModel;
use app\index\model\ChannelSetModel;
use app\lib\Condition;

Class ChannelList extends Common
{
    /** 频道列表 */
   public function channel_list(){
       $page = input('param.page', 1);
       $search_word = input('param.search_word','');
       $map = "";
       if(!empty($search_word)){
           $map['m.account'] = $search_word;
       }

       $condition_rules = array(
           array(
               'field' => 'l.end_time',
               'value' => strtotime(input('param.end_time', '')),
               'operator' => '<='
           ),
           array(
               'field' => 'l.create_time',
               'value' => strtotime(input('param.start_time', '')),
               'operator' => '>='
           ),
       );

       $model = new Condition($condition_rules, $page);
       $model->init();

       $m = new ChannelListModel();
       $list = $m->get_channel_list($model,$map);
       $item = $list->all();

       foreach ($item as $k=>$v){
           $item[$k]['live_num'] = db("live_record")->where(["uid"=>$v['member_id'],"status"=>1])->count('id');
           $item[$k]['end_time'] = db("live_record")->field("end_time")->where(["uid"=>$v['member_id'],"status"=>-1])->order('id desc')->limit(1)->find()['end_time'];
           $item[$k]['sum_money'] = round(db("cost_orders")->where(["uid"=>$v['member_id']])->sum('cost_money'),2);
           $item[$k]['c_num'] = db("channel_record")->where(["uid"=>$v['member_id']])->sum('watch_count');
       }

       $this->assign('item',$item);
       $this->assign('total',$list->total());
       $this->assign('page',$list->render());

       return $this->fetch();
   }
    /** 频道详情 */
    public function channel_info(){
        $id = input('param.id','');
        $cid = input('param.cid','');
        $page = input('param.page', 1);
        $condition_rules = array(
            array(
                'field' => 'u.title',
                'value' => input('get.search_word'),
                'operator' => 'like'
            ),
        );
        $model = new Condition($condition_rules, $page);
        $model->init();

        $m = new ChannelListModel();
        $info = $m->get_user_channel($id,$model);
        $item = $info->all();
        
        foreach ($item as $k=>$v){
            $item[$k]['sum_money'] = round(db("cost_orders")->where(["uid"=>$v['uid'],'cid'=>$v['id']])->sum('cost_money'),2);
            $item[$k]['s_num'] = db("channel_record")->where(["uid"=>$v['uid'],'cid'=>$v['id']])->sum('watch_count');
            $item[$k]['c_num'] = db("channel_record")->where(["uid"=>$v['uid'],'cid'=>$v['id']])->count('id');
            $item[$k]['status'] = db("live_record")->field("status")->where(["uid"=>$v['uid'],'cid'=>$v['id']])->order('create_time desc')->limit(1)->find()['status'];
        }

        $this->assign('list',$item);
        $this->assign('total',$info->total());
        $this->assign('page',$info->render());
        return $this->fetch();
    }
    /** 直播监控 */
    public function channel_monitor(){
        $m = new ChannelListModel();
        $list = $m->get_channel_info();
        $item = $list->all();

        foreach ($item as $k=>$v){
            $item[$k]['sum_money'] = round(db("cost_orders")->where(["uid"=>$v['member_id'],'cid'=>$v['cid']])->sum('cost_money'),2);
            $item[$k]['s_num'] = db("channel_record")->where(["uid"=>$v['member_id'],'cid'=>$v['cid']])->sum('watch_count');
            $item[$k]['c_num'] = db("channel_record")->where(["uid"=>$v['member_id'],'cid'=>$v['cid']])->count('id');
        }
       
        $this->assign('list',$item);
        $this->assign('total',$list->total());
        $this->assign('page',$list->render());

        return $this->fetch();
    }
    /** 关闭直播 */
    public function channel_status(){
        $lid  = input('post.id','');
        $m = new ChannelListModel();
        $rt = $m->up_live_status($lid);
     
        (empty($rt)) && wrong_return('关闭直播失败');
        ok_return('成功关闭');
    }
}