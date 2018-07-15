<?php

/**
 * Live常量配置
 *
 * @author hunter
 */
//system const
const LAST_INDEX = 0;
const PAGE_SIZE = 18;
const LIVE_PAGE_SIZE = 50;
const LIKE_PAGE_SIZE = 8;
const RECOMMEND_PAGE_SIZE = 4;


const CONTENT_LENGTH = 300;//评论长度

//user:type
const USER_TYPE1 = 1;//'普通';
const USER_TYPE2 = 2;//'rt';
//member_status
const MEMBER_STATUS1 = 1;//'正常'
const MEMBER_STATUS_F1 = -1;//'禁用'
const MEMBER_STATUS_F2 = 2;//'删除'

//members：emotion
const EMOTION_STATUS1 = 1;//保密
const EMOTION_STATUS2 = 2;//单身
const EMOTION_STATUS3 = 3;//恋爱中
const EMOTION_STATUS4 = 4;//已婚
const EMOTION_STATUS5 = 5;//同性


//clent:type
const CLIENT_TYPE1 = 1;//'WAP';
const CLIENT_TYPE2 = 2;//‘PC’;
const CLIENT_TYPE3 = 3;//'安卓';
const CLIENT_TYPE4 = 4;//'IOS';

//user:sex
const USER_SEX0 = 0;//'保密';
const USER_SEX1 = 1;//'男';
const USER_SEX2 = 2;//'女';

//user:status
const USER_STATUS_DELETE = -2; //已删除
const USER_STATUS1 = 1; //正常
const USER_STATUS_STOP = -1; //禁用

//account_log type
const ACCOUNT_LOG_TYPE_MONEY = 1; //现金
const ACCOUNT_LOG_TYPE_COIN = 2; //虚拟币
const ACCOUNT_LOG_TYPE_TICKET = 3; //虚拟票

//account_log object_type         全局对象类型


const OBJECT_TYPE_RECHARGE_COIN = 1; //充值虚拟币
const OBJECT_TYPE_REBATE = 2; //提现
const OBJECT_TYPE_REWARD = 3; //打赏
const OBJECT_TYPE_RETURN = 4; //退款
const OBJECT_TYPE_LIVE = 5; //直播
const OBJECT_TYPE_PERSON = 6; //用户
const OBJECT_TYPE_REDBAG = 7; //红包
const OBJECT_TYPE_REDBAG_RETURN = 8; //红包退还


//account_log income
const ACCOUNT_LOG_INCOME_TRUE = 1; //收入
const ACCOUNT_LOG_INCOME_FALSE = 0; //支出

//AV_ROOM STATUS
const ROOM_STATUS_NOM = 1;//正常
const ROOM_STATUS_STOP = 2;//禁用
const ROOM_STATUS_WAR = 3;//警告
const ROOM_STATUS_F2 = -2;//删除


//audit status
const AUDIT_STATUS0 = 0;//0=待审核
const AUDIT_STATUS1 = 1;//，1=已审核
const AUDIT_STATUS_F1 = -1;//，-1不通过且作废,

//live_record_type
const LIVE_RECORD_TYPE1 = 1;//正常
const LIVE_RECORD_TYPE2 = 2;//私密
const LIVE_RECORD_TYPE3 = 3;//付费
const LIVE_RECORD_TYPE4 = 4;//时间付费私播


//live_record_status直播状态
const LIVE_RECORD_STATUS1 = 1;//1:正在直播
const LIVE_RECORD_STATUS2 = 2;//2：直播已经结束
const LIVE_RECORD_STATUS3 = 3;//3：主播删除
const LIVE_RECORD_STATUS_F1 = -1;//-1：直播已删除',


//img_list_TYPE
const IMG_TYPE0 = 0;// 0:网站素材
const IMG_TYPE1 = 1;//1:商品图片
const IMG_TYPE2 = 2;//2:用户头像
const IMG_TYPE3 = 3;//3:用户晒单
const IMG_TYPE4 = 4;//4.认证图片
const IMG_TYPE5 = 5;//5。封面图片

//img_list_status -2 禁用 -1删除 1.正常 0.审核中',
const IMG_STATUS0 = 0;
const IMG_STATUS1 = 1;//默认
const IMG_STATUS_F1 = -1;
const IMG_STATUS_F2 = -2;


//recharge type
const RECHARGE_COIN = 1;//充值类型金币
//reward type
const REWARD_TYPE_GOOD = 1;//礼物打赏
const REWARD_TYPE_REDBAG = 2;//金币红包打赏
const REWARD_TYPE_FEEBASED = 3;//付费直播打赏
const REWARD_TYPE_TIME_LIVE_FEE = 4;//按时直播打赏


//pay_info  status
const PAY_INFO_STATUS0 = 0;//未支付
const PAY_INFO_STATUS1 = 1;//已支付

//pay_info   type

const PAY_INFO_TYPE_ALIPAY = 1;//支付宝
const PAY_INFO_TYPE_WX = 2;//微信
const PAY_INFO_TYPE_APPLEPAY = 3;//APPLEPAY
const PAY_INFO_TYPE_bank = 4;//线下银行卡

const ORDER_PAY_STATUS1 = 1;//默认
const ORDER_PAY_STATUS2 = 2;//已付款
const ORDER_PAY_STATUS3 = 3;//已开通

const RECORD_SOURCE1 = 1;//APP
const RECORD_SOURCE2 = 2;//PC

const HEART_UP_HZ = 10;//心跳频率 10s
const HEART_UP_EXPIRES_TIME = 60;//redis  心跳过期时间
const HEART_INTOSQL_TIMES = 10;//心跳积攒够该数 就 进一次库

define( 'CDN_UIL_ROOT_PATH' ,config('CONFIG_CDN_URL'));
define('OSS_UIL_ROOT_PATH' , 'http://'.config('CONFIG_OSS_BUCKET_IMG').'.'.config('CONFIG_OSS_ENDPOINT').'/');
define('INIT_LIVE_NUM', 100000);//会员号的初始基数
//if (ENVIRONMENT == 'develop') {
//    define('INIT_LIVE_NUM', 20000000);//会员号的初始基数
//    define('TENCENT_HEAD', 'user');//冠子头
//
//} elseif (ENVIRONMENT == 'official') {
//    config('config_enable', false);
//    define('INIT_LIVE_NUM', 80000000);//会员号的初始基数
//    define('TENCENT_HEAD', 'mem');//冠子头
//} else {
//    define('INIT_LIVE_NUM', 80000000);//会员号的初始基数
//    define('TENCENT_HEAD', 'member');//冠子头
//}

