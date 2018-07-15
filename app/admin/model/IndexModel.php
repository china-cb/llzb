<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2016/11/26
 * Time: 9:54
 */

namespace app\admin\model;


class IndexModel
{

    /** 统计每日注册人数 */
    public function get_reg_nums_by_day(){
        return db("member")->whereTime('create_time', 'd')->count("member_id");
    }

    /** 统计每日登录总人数 */
    public function get_login_nums_by_day(){
        return db("session_user")->whereTime('create_time', 'd')->count("id");
    }

    /** 统计每日充值总数 */
    public function get_recharge_nums_by_day(){
        return db("recharge")->where('pay_status',1)->whereTime('create_time', 'd')->sum('money');
    }

    /** 统计每日消费总数 */
    public function get_cost_nums_by_day(){
        return db("account_log")->where("income","0")->whereTime('create_time','d')->sum('coin');
    }

    /** 统计每日提现总数 */
    public function get_reference_nums_by_day(){
        return db("reference")->where('status',['<>',-1],['<>',-2],'or')->whereTime('create_time','d')->sum('money');
    }

    /** 统计平台总人数 */
    public function get_user_all_by_plat(){
        return db('member')->where('status',1)->count("member_id");
    }

    /** 统计平台总充值数 */
    public function get_recharge_all_by_plat(){
        return db("recharge")->where('pay_status',1)->sum('money');
    }

    /** 统计总提现金额 */
    public function get_reference_money_all_by_plat(){
        return db("reference")->where('status',['<>',-1],['<>',-2],'or')->sum('money');
    }
    /** 统计待审核提现数 */
    public function get_reference_all_by_plat(){
        return db('reference')->where('status',0)->count('reference_id');

    }

    /** 统计待申请认证数 */
    public function get_audit_all_by_plat(){
        return db('audit')->where('status',0)->count('id');
    }

    /** 统计主播收益 */
    public function get_liver_income_all_by_plat(){
        return db('reference')->where('status',2)->sum('money');
    }
    /** 统计主播申请 */
    public function get_anchor_apply_num(){
        return db_func('audit')->where('status',0)->count();
    }
    /** 统计提现申请 */
    public function get_reference_apply_num(){
        return db_func('reference')->where('status',0)->count();
    }
    /** 统计举报申请 */
    public function get_report_apply_num(){
        return db_func('report')->where('status',0)->count();
    }
    /** 统计百宝箱待申请 */
    public function get_treasure_box_num(){
        return db_func('treasure_box')->where('status',1)->count();
    }
}