<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/12/28
 * Time: 9:59
 */

namespace app\index\controller;


use app\admin\controller\Upload;
use app\index\model\ChannelSetModel;
use org\Image;
use think\Db;

class ChannelSet extends Common
{
    /** 频道基础设置_直播引导图 */
    public function set_guide_map()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "set_guide_map");
        return $this->fetch();
    }

    /** 引导图上传 */
    public function up_guide()
    {
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["guide_url"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('guide_url');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if (!empty($info)) {
                    $rt = new \app\core\controller\Upload();
                    $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                    ok_return('引导图上传成功', 1, $version_name);
                } else {
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }

    }

    /** 引导图提交 */
    public function map_guide_list()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        (empty($post['map_guide'])) && wrong_return('请提交引导图');
        $data = [
            'map_guide' => $post['map_guide'],
            'update_time' => NOW_TIME,
        ];
        
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 频道基础设置_直播窗口背景 */
    public function set_window_background()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);

        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "set_window_background");
        return $this->fetch();
    }

    /** 直播窗口背景上传 */
    public function up_window()
    {
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["window_img"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('window_img');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名
                if (!empty($info)) {
                    $rt = new \app\core\controller\Upload();
                    $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                    ok_return('引导图上传成功', 1, $version_name);
                } else {
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }

    /** 直播窗口背景提交 */
    public function up_window_list()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        $data = [
            'window' => $post['map_window'],
            'update_time' => NOW_TIME,
        ];
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 频道基础设置_直播视频LOGO */
    public function set_video_logo()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "set_video_logo");
        return $this->fetch();
    }

    /** 视频LOGO上传*/
    public function up_logo()
    {
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["logo_url"]["type"],$list)){
                $uid = input('post.logo_cover','');
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('logo_url');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名

                $m = new ChannelSetModel();
                $mid = check_login();
                $lsit = $m->up_cover_info($uid,$mid,$version_name);
                $rt = new \app\core\controller\Upload();
                $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                $image = Image::open($version_path);
// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $version_path = (ROOT_PATH . 'public' . DS . 'uploads'.NOW_TIME);
                $list = $image->thumb(180, 50)->save($version_path);
                if (!empty($info)) {
                    $version_name = 'thumb_'.$version_name;
                    $rt = new \app\core\controller\Upload();
                    $res2 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                    ok_return('引导图上传成功', 1, $version_name);
                } else {
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }

    /** 视频LOGO提交 */
    public function map_logo_list()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        if(empty($post['map_logo'])){
            $data = [
                'logo_position' => $post['logo_type'],
                'update_time' => NOW_TIME,
            ];
        }else{
            $data = [
                'logo_position' => $post['logo_type'],
                'logo' => $post['map_logo'],
                'update_time' => NOW_TIME,
            ];
        }
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 频道基础设置_直播视频图标 */
    public function set_video_icon()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);
        
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "set_video_icon");
        return $this->fetch();
    }

    /** 视频图标上传 */
    public function up_cover()
    {
        if(!empty($_FILES)){
            $list = array("image/jpeg","image/png");
            if (in_array($_FILES["cover_file"]["type"],$list)){
                // 获取表单上传文件 例如上传了001.jpg
                $file = request()->file('cover_file');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                $version_path = $info->getRealPath();//获取文件的绝对路径
                $version_name = $info->getFilename();//获取文件名

                $image = Image::open($version_path);
                // 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                $list = $image->thumb(128, 128)->save($version_path);
                if (!empty($info)) {
                    $rt = new \app\core\controller\Upload();
                    $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                    ok_return('频道图标上传成功', 1, $version_name);
                } else {
                    wrong_return('上传失败');
                }
            }else{
                wrong_return('上传图片不正确');
            }
        }
    }

    /** 视频图标提交 */
    public function map_cover_list()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        $data = [
            'cover' => $post['map_cover'],
            'update_time' => NOW_TIME,
        ];
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 互动打赏设置_打赏设置 */
    public function set_reward()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);
        $info = $m->get_reward_list($id, $mid);
        $red = $m->get_red_list($id, $mid);
        $rt = $info['gift_data'];
        $gift_list = unserialize($rt);
        if (!empty($gift_list)) {
            $length = count($gift_list);
            $this->assign("length", $length);
        }

        $this->assign("gift_list", $gift_list);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("info", $info);
        $this->assign("red", $red);
        return $this->fetch();
    }

    /**  功能开关*/
    public function all_switch()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        $post['update_time'] = NOW_TIME;
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $post);
        if (empty($list)) {
            wrong_return('設置失败');
        } else {
            ok_return('設置成功');
        }
    }

    /** 礼物打赏提交 */
    public function gift_art()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);

        if (empty($post['gift_url'][0]) || empty($post['gift_name'][0]) || empty($post['gift_price'][0]) || empty($post['gift_len'][0])) {
            wrong_return('请填写礼物名称,金额与礼物图片');
        }
        $data = [];
        foreach ($post['gift_url'] as $k => $v) {
            if (!empty($post['gift_url'][$k]) && !empty($post['gift_name'][$k]) && !empty($post['gift_price'][$k]) && !empty($post['gift_len'][$k])) {
                $data[$k]['gift_url'] = $post['gift_url'][$k];
                $data[$k]['gift_name'] = $post['gift_name'][$k];
                $data[$k]['gift_price'] = $post['gift_price'][$k];
                $data[$k]['gift_len'] = $post['gift_len'][$k];
            } else if (empty($post['gift_url'][$k]) && empty($post['gift_name'][$k]) && empty($post['gift_price'][$k]) && empty($post['gift_len'][$k])) {
                //....
            } else {
                wrong_return('请填写礼物名称,金额与礼物图片');
            }
        }

        $reward_gift = serialize($data);
        $rt = [
            'gift_data' => $reward_gift,
        ];
        $m = new ChannelSetModel();
        $list = $m->up_gift_list($mid, $post['rid'], $rt);

        $gift_list = [
            'reward_data' => $reward_name,
            'phone_data' => $phone_prompt,
            'update_time' => NOW_TIME,
        ];
        $info = $m->up_map_guide($mid, $post['rid'], $gift_list);
        (empty($list) || empty($info)) && wrong_return('礼物打赏提交失败');
        ok_return('提交成功');
    }

    /** 礼物上传 */
    public function gift_img()
    {
        foreach ($_FILES as $K => $v) {
            if (!empty($v['name'])) {
                if(!empty($_FILES)){
                    $list = array("image/jpeg","image/png");
                    if (in_array($_FILES[$K]["type"],$list)){
                        // 获取表单上传文件 例如上传了001.jpg
                        $file = request()->file($K);
                        // 移动到框架应用根目录/public/uploads/ 目录下
                        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                        $version_path = $info->getRealPath();//获取文件的绝对路径
                        $version_name = $info->getFilename();//获取文件名
                        if (!empty($info)) {
                            $rt = new \app\core\controller\Upload();
                            $res1 = $rt->server_oss_img($version_name, $version_path);//上传OSS图片
                            ok_return('引导图上传成功', 1, $version_name);
                        } else {
                            wrong_return('上传失败');
                        }
                    }else{
                        wrong_return('上传图片不正确');
                    }
                }
            }
        }
    }

    /** 红包打赏提交 */
    public function red_reward()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);

        $m = new ChannelSetModel();
        $m->send_red_new($mid,$post);
      
    }

    /** 互动打赏设置_礼物打赏记录 */
    public function gift_reward_record()
    {
        $id = input("param.id", "");

        $this->assign("id", $id);
        $this->assign("type", "gift_reward_record");
        return $this->fetch();
    }

    /** 互动打赏设置_红包打赏记录 */
    public function red_reward_record()
    {
        $mid = check_login();
        $id = input("param.id", "");//频道ID
        $m = new ChannelSetModel();
        $list  = $m->get_bonus_list($mid,$id);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "red_reward_record");
        return $this->fetch();
    }

    /** 观看设置 */
    public function set_look()
    {
        $id = input("param.id", "");
        $mid = check_login();
        $m = new ChannelSetModel();
        $list = $m->get_user_av_room_list($id, $mid);
        $this->assign("id", $id);
        $this->assign("list", $list);
        $this->assign("type", "set_look");
        return $this->fetch();
    }

    /** 付费直播 */
    public function record_unit_price()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        $data = [
            'unit_price' => $post['money'],
            'update_time' => NOW_TIME,
            'type' => 2,
        ];
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 私密直播 */
    public function record_secret_key()
    {
        $mid = check_login();
        $post = input('post.', '');
        extract($post);
        $data = [
            'secret_key' => $post['pwds'],
            'update_time' => NOW_TIME,
            'type' => 1,
        ];
        $id = $post['id'];
        $m = new ChannelSetModel();
        $list = $m->up_map_guide($mid, $id, $data);
        if (empty($list)) {
            wrong_return('提交失败');
        } else {
            ok_return('提交成功');
        }
    }

    /** 微信分享设置 */
    public function set_weixin_share()
    {
        $id = input("param.id", "");

        $this->assign("id", $id);
        $this->assign("type", "set_weixin_share");
        return $this->fetch();
    }

    /** 嵌入地址 */
    public function set_embed_address()
    {
        $id = input("param.id", "");

        $this->assign("id", $id);
        $this->assign("type", "set_embed_address");
        return $this->fetch();
    }

    /** 视频回放 */
    public function video_back_play()
    {
        $id = input("param.id", "");

        $this->assign("id", $id);
        $this->assign("type", "video_back_play");
        return $this->fetch();
    }

    /** 抢红包 */
    public function get_red_new(){
        $mid = check_login();
        $bonus_id = input('post.','');
        (empty($bonus_id)) && wrong_return('领取紅包不正确');
        try{
            $redis = new \Redis();
            $redis->connect('127.0.0.1') or die('连接redis失败');

            //判断用户是否已经领取过红包
            if($redis->hExists('bonus_map_'.$bonus_id,$mid)){//过滤已经领取过红包的用户
                    wrong_return('你已经领取过红包了');
            }else{
                if($red_bag = $redis->rPop('bonus_'.$bonus_id.'_list')){//能取出一个数据
                    $x = json_decode($red_bag,true);
                    $x['uid'] = $mid;
                    $re = json_encode($x);

                    $redis->hSet('bonus_map_'.$bonus_id,$mid,$re);//放入过滤
                    $redis->lPush('bonus_consumed_list',$re);//放入已经消费的总列表  留给 单线程批量回库

                    ok_return('恭喜你领取成功领取');
                }else{
                    $m = new ChannelSetModel();
                    $list = $m->up_bonus($bonus_id);
                    if(empty($list)){
                        wrong_return('红包已经抢光了');
                    }
                }
                wrong_return('红包已经抢光了');
            }
            
            $redis->close();
        }catch(\RedisException $e){
            wrong_return($e->getCode(),$e->getMessage());
        }
    }
    /** 一分钟扫描一次，处理红包结果 */
    public function red_testing(){
        $redis = new \Redis();
        $rid = 4;
        $redis->connect('127.0.0.1') or die('连接redis失败');
        $len = $redis->lLen('bonus_consumed_list');
        if($len>0){        //入库
            for($i=0;$i<$len;$i++){
                //入库
                $bonus_consumed = $redis->rPop('bonus_consumed_list');//取出最右侧
                $bonus_consumed = json_decode($bonus_consumed,true);
                $coin =$bonus_consumed['coin'];
                $uid =$bonus_consumed['uid'];
                $bonus_id =$bonus_consumed['bonus_id'];

                $bonus_info = db_func('bonus')->where('id',$bonus_id)->cache(true)->find();
              
                $m = new ChannelSetModel();
                $data = array(
                    "reward_type"=> 2,
                    "object_id"=> $bonus_id,
                    "uid"=>$bonus_info['mid'],
                    'rid' => $rid,
                    "object_uid"=> $uid,
                    "pay_info"=> array( "input_free_coin"=> $coin),
                    "num"=> 1,//抢红包数量 肯定是1  通用方法里的个数 肯定是1
                );
                $tepp = time();
                log_w('->'.$tepp);
                $temp = $m->create_reward($data);//和打赏礼物 走同一个通用方法
                log_w($tepp.'<-');
                if($temp['code'] == 0) {
                    echo '0k';
                }
                log_w($i);
            }
        }else{
            echo 'meil';
            $step1 =true;
        }
        //作废 过期  的 红包 ，返回 未领取的 钱
        $info = $redis->keys('bonus_'.'*'.'_info');//全部信息

        foreach($info as $inf){
            //处理每一个 红包
            $bonus_info = $redis->hGetAll($inf);//
            if($bonus_info['expiretime'] < time()) {//过了24小时  008800  <
                Db::startTrans();
                try {
                    $bonus_id = $bonus_info['bonus_id'];//得到红包id  将剩余的 返还给用户
                    $no_sent = $redis->lRange('bonus_' . $bonus_id . '_list', 0, -1);
                    $no_sent_lenth= count($no_sent);//没发出去的个数
                    $coinsum = 0;
                    if (!empty($no_sent)) {
                        foreach ($no_sent as $rem) {
                            $rem = json_decode($rem, true);
                            $coinsum += intval($rem['coin']);
                        }
                    }
                    $have_send = intval($bonus_info['num'])-intval($no_sent_lenth);
                    //空 就是都发完了 ，而且所有信息都已经入库后 不要理会  在下方 同一删除bonus_id
                    //对红包进行 完结处理
                    $data = array(
                        'expiration_time' => time(),
                        'have_send' => $have_send,
                        'refund_coin' => $coinsum,
                    );
                    $temp = db_func('bonus','sp_')->where('id', $bonus_id)->update($data);//红包完结
                    if (empty($temp)) throw new \Exception("bonus_id:" . $bonus_id . "完结红包过期处理时出错！");

                    if ($coinsum > 0) {
                        //用户回款
                        $bonus_inf = db_func('bonus')->where('id', $bonus_id)->cache(true)->find();
                        $mid = $bonus_inf['mid'];
                        $flag = db_func('member')->where('member_id', $mid)->setInc('coin', $coinsum);//- 收到者的
                        if (empty($flag)) throw new \Exception("bonus_id:" . $bonus_id . "更发送红包账户信息出错");
                    }
                    $list = db_func('bonus','sp_')->where('id',$bonus_id)->update(['status' => 1,'update_time' => NOW_TIME]);
                    if (empty($list)) throw new \Exception("bonus_id:" . $bonus_id . "完结红包状态处理时出错！");

                    if ($temp) {
                        //删除 释放
                        $redis->del('bonus_' . $bonus_id . '_list');
                        $redis->del('bonus_' . $bonus_id . '_info');
                        $redis->del('bonus_map_' . $bonus_id);
                    }
                    // 提交事务
                    Db::commit();
                    echo '2k';
                } catch (\Exception $e) {
                    // 回滚事务
                    dump($e->getMessage());
                    Db::rollback();
                }
            }
        }
    }
}