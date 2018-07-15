<?php
namespace app\core\model;

Class LogapiModel
{

    //增加通用日志
//    public function log_add($post)
//    {
//        extract($post);
//        $m_log =  M('log','');
//        $data = array(
//            'user'=>empty($user) ? "" : $user,
//            'type'=>empty($type) ? "" : $type,
//            'log'=>empty($log) ? "" : $log,
//            'create_time'=>date('Y-m-d H:i:s'),
//        );
//        return $m_log->add($data);
//    }

    public function record($pre_data,$after_data,$flag='2',$status=1){
        $data = array(
            "uid" => $pre_data['member_id'],
            "username" => $pre_data['nickname'],
            "pre_coin" => $pre_data['coin'],
            "after_coin" => $after_data['coin'],
            "type" => $flag,//2
            "status" => $status,
            "create_time" => time(),
            "coin_change" =>abs($pre_data['coin']-$after_data['coin']),

        );
        db_func("charge","log_")->insert($data);
    }

//    public function get_score_exchange($post){
//        $sql = "SELECT SQL_CALC_FOUND_ROWS  l.*,u.nick_name
//                    FROM  log_charge l
//                    LEFT JOIN sp_users u ON u.id=l.uid
//                    WHERE  l.type=3 " . $post->wheresql .
//            " ORDER BY create_time desc " . $post->limitData;
//
//        $sql_count = "SELECT FOUND_ROWS() as num";
//        $act_info = M("charge","log_")->query($sql);
//        $num = M("charge","log_")->query($sql_count);
//
//        $rt["data"] = $act_info;
//        $rt["count"] = $num[0]["num"];
//        return $rt;
//    }
//
//    public function get_cash_exchange($post){
//        $sql = "SELECT SQL_CALC_FOUND_ROWS  l.*,u.nick_name
//                    FROM  log_charge l
//                    LEFT JOIN sp_users u ON u.id=l.uid
//                    WHERE  l.type=6 " . $post->wheresql .
//            " ORDER BY create_time desc " . $post->limitData;
//
//        $sql_count = "SELECT FOUND_ROWS() as num";
//        $act_info = M("charge","log_")->query($sql);
//        $num = M("charge","log_")->query($sql_count);
//
//        $rt["data"] = $act_info;
//        $rt["count"] = $num[0]["num"];
//        return $rt;
//    }
//
//    public function get_all_exchange($post){
//        $sql = "SELECT SQL_CALC_FOUND_ROWS  l.*,u.nick_name
//                    FROM  log_charge l
//                    LEFT JOIN sp_users u ON u.id=l.uid
//                    WHERE  (l.type=6 OR l.type=3) AND l.uid = ".get_user_id() . $post->wheresql .
//            " ORDER BY create_time desc " . $post->limitData;
//
//        $sql_count = "SELECT FOUND_ROWS() as num";
//        $act_info = M("charge","log_")->query($sql);
//        $num = M("charge","log_")->query($sql_count);
//
//        $rt["data"] = $act_info;
//        $rt["count"] = $num[0]["num"];
//        return $rt;
//    }





}