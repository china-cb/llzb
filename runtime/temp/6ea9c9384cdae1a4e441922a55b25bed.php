<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:29:"../tpl/index/admin\index.html";i:1486449741;s:33:"../tpl/index/base\admin_base.html";i:1484634306;s:33:"../tpl/index/base\common_css.html";i:1484634306;s:32:"../tpl/index/base\common_js.html";i:1484634306;s:35:"../tpl/index/base\admin_header.html";i:1486605588;s:35:"../tpl/index/base\admin_footer.html";i:1486603691;}*/ ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <!--base-->
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="玲珑TV">
    <meta name="keywords" content="玲珑TV">
    <link rel="shortcut icon" href="__static__/index/src/img/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="__static__/index/src/img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="__static__/index/src/css/common.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/mCustomScrollbar.css" />
    
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin.css" />
<link rel="stylesheet" type="text/css" href="__static__/index/src/css/admin-index.css" />

    <script type="text/javascript" src="__static__/index/src/js/jquery.min.js"></script>
<script type="text/javascript" src="__static__/public/js/common.js"></script>
<script type="text/javascript" src="__plugin__/layer/2.1/layer.js"></script>
<script type="text/javascript" src="__static__/index/src/js/common.js"></script>
<script type="text/javascript" src="__static__/index/js/admin_public.js"></script>
<script type="text/javascript" src="__static__/index/src/js/mCustomScrollbar.js"></script>
<script type="text/javascript" src="__static__/index/src/assembly/laydate.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script><!--微信登录-->
    <title>玲珑直播</title>
</head>
<body>
<!-- inject:admin_header:html -->
<div class="header admin">
    <div class="h-bar">
        <div class="warp">
            <h6 class="info" >服务热线：0516-83994999（周一至周五9:00～18:00）</h6>
            <a class="logo" href=""></a>
            <div class="nav">
                <div class="name">你好,<a>
                    <?php if(empty($user_info['nick_name']) || ($user_info['nick_name'] instanceof \think\Collection && $user_info['nick_name']->isEmpty())): ?>
                    <?php echo (isset($user_info['phone']) && ($user_info['phone'] !== '')?$user_info['phone']:''); else: ?>
                    <?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:"大哥,您火星来的吧"); endif; ?>
                </a></div>
                <a class="logout quit_btn">退出</a>
<!--                <a class="nav-item">安全中心</a>
                <a class="nav-item">会员保障</a>
                <a class="nav-item">客户服务</a>-->
            </div>
        </div>
    </div>
    <div class="h-main">
        <div class="warp">
            <a class="logo-top" href="<?php echo url('index/index/index'); ?>"></a>
            <ul class="hm-menu">
                <li class="menu-item active"><a href="<?php echo url('index/admin/index'); ?>">玲珑首页</a></li>
                <li class="menu-item">
                    <div class="mi-list">
                        <div class="menu-content">
                            <a class="mc-close">
                                <i class="iconfont">&#xe61f;</i>
                            </a>
                            <a href="<?php echo url('index/admin/channel_manage'); ?>" class="mc-item">
                                频道管理
                            </a>
<!--                            <a href="<?php echo url('index/admin/channel_manage',['type'=>2]); ?>" class="mc-item">
                                数据统计
                            </a>-->
                        </div>
                        <div class="menu-title">直播服务</div>
                    </div>
                </li>
                <li class="menu-center">
                    <div class="user-info-warp">
                        <div class="user-ava">
                            <?php if(empty($user_info['user_face']) || ($user_info['user_face'] instanceof \think\Collection && $user_info['user_face']->isEmpty())): ?>
                            <img src="__static__/index/src/img/temp/user_ava.png">
                            <?php else: ?>
                            <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($user_info['user_face']) && ($user_info['user_face'] !== '')?$user_info['user_face']:''); ?>">
                            <?php endif; ?>
                            <h4>你好,<span>
                                <?php if(empty($user_info['nick_name']) || ($user_info['nick_name'] instanceof \think\Collection && $user_info['nick_name']->isEmpty())): ?>
                                   <?php echo (isset($user_info['phone']) && ($user_info['phone'] !== '')?$user_info['phone']:''); else: ?>
                                   <?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:"大哥,您火星来的吧"); endif; ?>
                            </span></h4>
                            <div class="user-auth">
                                <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="real-name "></a>
                                <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="phone "></a>
                                <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="email "></a>
                            </div>
                            <div class="user-info">
                                <div class="info-item">
                                    <p><span>账户类型 :</span><?php switch($user_info['account_type']): case "1": ?>基础版<?php break; case "2": ?>专业版<?php break; case "3": ?>企业版<?php break; default: ?>基础版
                                        <?php endswitch; ?>
                                        <a class="updata">升级</a></p>
                                    <p><span>账户余额 :</span>¥<?php echo (isset($user_info['balance']) && ($user_info['balance'] !== '')?$user_info['balance']:'0.00'); ?><a class="charge" href="<?php echo url('index/user_center/account','type=3'); ?>">充值</a></p>
                                    <p><span>套餐类型 :</span><?php echo (isset($user_info['type']) && ($user_info['type'] !== '')?$user_info['type']:'无'); ?><a class="buy">购买</a></p>
                                </div>
                            </div>
                        </div>
                        <a class="mc-close quit_btn">退出</a>
                    </div>
                </li>
                <li class="menu-item"><a href="<?php echo url('index/admin/developing'); ?>" class="demand_live">点播服务</a></li>
                <li class="menu-item">
                    <div class="mi-list">
                        <div class="menu-content">
                            <a class="mc-close">
                                <i class="iconfont">&#xe61f;</i>
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="mc-item">
                                账户信息
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=2'); ?>" class="mc-item">
                                我的套餐
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=3'); ?>" class="mc-item">
                                余额充值
                            </a>
                            <a href="<?php echo url('index/user_center/account','type=4'); ?>" class="mc-item">
                                充值订单
                            </a>
                        </div>
                        <div class="menu-title">账户管理</div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>


<!-- endinject -->
<div class="main admin-index">
    <div class="container">
        <div class="ai-cards">
            <div class="user-info">
                <a class="user-ava">
                    <?php if(empty($user_info['user_face']) || ($user_info['user_face'] instanceof \think\Collection && $user_info['user_face']->isEmpty())): ?>
                    <img src="__static__/index/src/img/temp/user_ava.png">
                    <?php else: ?>
                    <img src="<?php echo \think\Config::get('CONFIG_CDN_URL'); ?><?php echo (isset($user_info['user_face']) && ($user_info['user_face'] !== '')?$user_info['user_face']:''); ?>">
                    <?php endif; ?>
                </a>
                <a class="user-name">你好,
                    <?php if(empty($user_info['nick_name']) || ($user_info['nick_name'] instanceof \think\Collection && $user_info['nick_name']->isEmpty())): ?>
                       <?php echo (isset($user_info['phone']) && ($user_info['phone'] !== '')?$user_info['phone']:''); else: ?>
                       <?php echo (isset($user_info['nick_name']) && ($user_info['nick_name'] !== '')?$user_info['nick_name']:"大哥,您火星来的吧"); endif; ?>
                </a>
                <div class="user-auth">
                    <?php if($user_info['state'] == '2'): ?>
                        <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="ua-item ua-success">
                            <i class="iconfont">&#xe61d;</i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo url('index/user_center/account','type=1'); ?>" class="ua-item ua-warning">
                            <i class="iconfont">&#xe61d;</i>
                        </a>
                    <?php endif; if(empty($user_info['phone']) || ($user_info['phone'] instanceof \think\Collection && $user_info['phone']->isEmpty())): ?>
                        <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="ua-item ua-warning">
                            <i class="iconfont">&#xe737;</i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo url('index/user_center/account','type=5'); ?>" class="ua-item ua-success">
                            <i class="iconfont">&#xe737;</i>
                        </a>
                    <?php endif; if(empty($user_info['email']) || ($user_info['email'] instanceof \think\Collection && $user_info['email']->isEmpty())): ?>
                        <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="ua-item ua-warning">
                            <i class="iconfont">&#xe603;</i>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo url('index/user_center/account','type=6'); ?>" class="ua-item ua-success">
                            <i class="iconfont">&#xe603;</i>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="user-num">
                    <h4>
                        账户类型：<span>
                        <?php switch($user_info['account_type']): case "1": ?>基础版<?php break; case "2": ?>专业版<?php break; case "3": ?>企业版<?php break; default: ?>基础版
                        <?php endswitch; ?>
                    </span>
                        <a href="<?php echo url('index/index/package'); ?>" target="_blank">升级</a>
                    </h4>
                    <h4>
                        账户余额：<span>¥<?php echo (isset($user_info['balance']) && ($user_info['balance'] !== '')?$user_info['balance']:'0.00'); ?></span>
                        <a href="<?php echo url('index/user_center/account','type=3'); ?>">充值</a>
                    </h4>
                    <h4>
                        套餐类型：<span><?php echo (isset($user_info['type']) && ($user_info['type'] !== '')?$user_info['type']:'无'); ?></span>
                        <a href="<?php echo url('index/index/package'); ?>" target="_blank">购买</a>
                    </h4>
                </div>
            </div>
            <div class="adi-card fee">
                <span class="title">账户余额</span>
                <h4>￥<?php echo (isset($user_info['balance']) && ($user_info['balance'] !== '')?$user_info['balance']:'0.00'); ?></h4>
                <a href="<?php echo url('index/user_center/account',['type'=>3]); ?>">立即充值</a>
            </div>
            <div class="adi-card bill">
                <!--<span class="title">本月账单</span>-->
                <div class="chart">
                    <!-- 为 ECharts 准备一个具备大小（宽高）的 DOM -->
                    <div id="main1" style="width: 400px;height:280px;"></div>
                    <a class="detail" href="<?php echo url('index/user_center/account',['type'=>2]); ?>">查看详情</a>
                </div>
            </div>
            <div class="adi-card count">
                <span class="title">数据概况</span>
                <h4>本月计费方式：观看时长</h4>
                <div class="count-list">
                    <span>昨日流量：<i class="iconfont">&#xe644;</i><b>0.0</b>GB</span>
                    <span>直播频道总数：<b><?php echo (isset($data['all_rooms']) && ($data['all_rooms'] !== '')?$data['all_rooms']:'0'); ?></b>个</span>
                    <span>昨日宽带峰值：<b>10</b>Mbps</span>
                    <span>正在直播频道数：<b><?php echo (isset($data['live_rooms']) && ($data['live_rooms'] !== '')?$data['live_rooms']:'0'); ?></b>个</span>
                </div>
            </div>
        </div>
        <h4 class="ai-title">所有服务</h4>
        <ul class="ai-tips">
            <li class="ai-item">
                <h4>直播</h4>
                <p>全方位的端到端解决方案，提供低延时、高并发的1对多视频直播服务。</p>
            </li>
            <li class="ai-item">
                <h4>点播</h4>
                <p>全方位的端到端解决方案，提供低延时、高并发的1对多视频直播服务。</p>
            </li>
            <li class="ai-item empty">
            </li>
        </ul>
    </div>
</div>
<input type="hidden" id="count_url" value="<?php echo url('count_bill'); ?>">
<!-- inject:admin_footer:html -->

<!--footer-->
<div class="footer">
    <div class="fot-top">
        <div class="fb-item"><i class="iconfont">&#xe612;</i>100倍故障时长赔偿</div>
        <div class="fb-item"><i class="iconfont">&#xe640;</i>7*24小时售后支持</div>
        <div class="fb-item"><i class="iconfont">&#xe636;</i>7天无理由赔偿</div>
        <div class="fb-item"><i class="iconfont">&#xe611;</i>首充多少送多少</div>
    </div>
    <div class="fot-list">
        <div class="fl-group">
            <h4><i class="iconfont">&#xe744;</i>联系我们</h4>
            <p><span>微信</span>General_Pn</p>
            <p><span>QQ</span>800133388</p>
            <p><span>联系电话</span>0516-83994999</p>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe658;</i>关于我们</h4>
            <a href="<?php echo url('index/index/help_center'); ?>">关于我们</a>
        </div>
        <div class="fl-group">
            <h4><i class="iconfont">&#xe616;</i>合作伙伴</h4>
            <a href="http://www.aodianyun.com/" target="_blank">奥点云</a>
        </div>
        <div class="focus-qr">
            <img src="__static__/index/src/img/temp/qr.png">
            <h4>关注微信</h4>
            <h6>了解更多直播方案</h6>
        </div>
    </div>
    <div class="fot-bar">
        <p><a href="http://yyg.mengdie.com" target="_blank">梦蝶一元购</a><a href="http://ip.mengdie.com" target="_blank">芝麻代理</a><a href="http://zb.mengdie.com" target="_blank">梦蝶直播</a><a href="http://pt.mengdie.com" target="_blank">梦蝶跑腿</a></p>
        <h6>徐州灵匠信息科技有限公司 版权所有</h6>
    </div>
</div>
<input type="hidden" id="quit_url" value="<?php echo url('index/login/quit'); ?>">
<input type="hidden" id="root_url" value="<?php echo url('index/index/index'); ?>">

<script type="text/javascript" src="__static__/index/js/echarts.min.js"></script>
<script type="text/javascript" src="__static__/index/src/js/login/login.js"></script>
<script>
    // 基于准备好的dom，初始化echarts实例
    var myChart1 = echarts.init(document.getElementById('main1'));
    myChart1.showLoading();
    myChart1.setOption(option = {
        title : {
            text: '本月账单',
            subtext: '',
            x:'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data: ['直播','点播']
        },
        series: [
            {
                name:'本月账单',
                type:'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[

                ]
            },
            {
                name:'账单花费',
                type:'pie',
                radius: ['40%', '55%'],

                data:[

                ]
            }
        ]
    });
    // 异步加载数据
    var url = $("#count_url").val();
    common.ajax_post(url,false,true,function(rt){
        myChart1.hideLoading();
        var obj = common.str2json(rt);
        var cate1_1 = [];
        var data1_1 = [];
        var data1_2 = [];

        for(var i in obj.ret_data){
            cate1_1.push(obj.ret_data[i]["name"]);
            data1_1.push(obj.ret_data[i]);
        }

// 上个月人员完成工单数填入数据
        myChart1.setOption({
            legend: {
                data: cate1_1
            },
            series: [
                {
// 根据名字对应到相应的系列
                    data: []
                },
                {
// 根据名字对应到相应的系列
                    data: data1_1
                }
            ]
        });
    });
</script>

</body>
</html>