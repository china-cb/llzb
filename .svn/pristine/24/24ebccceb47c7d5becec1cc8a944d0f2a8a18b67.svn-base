<?php
namespace app\core\model;

use think\Db;
use think\Request;

class LogBehaviorModel
{

    //添加行为日志
    public function log_behavior_add()
    {
        $req = json_encode(input("request.", ''), JSON_UNESCAPED_UNICODE);
        if(strlen($req)>255) $req=mb_substr($req, strlen($req)-255, strlen($req), 'utf-8');


        $request = Request::instance();
        $data = array(
            "uid" => get_admin_id(),
            "use_login" => get_admin_name(),
            "modules" => $request->module(),
            "controllers" => $request->controller(),
            "action" => $request->action(),
            "action_cn_name" => null,
            "request_type" => $request->isAjax() ? "ajax" : "normal",
            "method_type" => $request->isPost() ? "post" : "get",
            "request_data" => $req,
            "ip" => get_client_ip_true(),
            "platform" => get_os(),
            "create_time" => time()
        );
        Db::table('log_behavior')->insert($data);
    }

}