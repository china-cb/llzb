<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace' => 'app',
    // 应用调试模式
    'app_debug' => true,
    // 应用Trace
    'app_trace' => false,
    // 应用模式状态
    'app_status' => '',
    // 是否支持多模块
    'app_multi_module' => true,
    // 注册的根命名空间
    'root_namespace' => [],
    // 扩展配置文件
    'extra_config_list' => ['database', 'route', 'validate','conf_func','common_const','common_const_mapping'],
    // 扩展函数文件
    'extra_file_list' => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type' => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return' => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler' => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler' => 'callback',
    // 默认时区
    'default_timezone' => 'PRC',
    // 是否开启多语言
    'lang_switch_on' => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter' => '',
    // 默认语言
    'default_lang' => 'zh-cn',
    // 是否启用控制器类后缀
    'use_controller_suffix' => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module' => 'index',
    // 禁止访问模块
    'deny_module_list' => ['common'],
    // 默认控制器名
    'default_controller' => 'Index',
    // 默认操作名
    'default_action' => 'index',
    // 默认验证器
    'default_validate' => '',
    // 默认的空控制器名
    'empty_controller' => 'Error',
    // 操作方法后缀
    'action_suffix' => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo' => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch' => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr' => '/',
    // URL伪静态后缀
    'url_html_suffix' => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param' => false,
    //url禁止访问的后缀
    'url_deny_suffix' => 'ico|png|gif|jpg',
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type' => 0,
    // 是否开启路由
    'url_route_on' => true,
    // 是否强制使用路由
    'url_route_must' => false,
    // 域名部署
    'url_domain_deploy' => false,
    // 域名根，如.thinkphp.cn
    'url_domain_root' => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert' => true,
    // 默认的访问控制器层
    'url_controller_layer' => 'controller',
    // 表单请求类型伪装变量
    'var_method' => '_method',

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template' => [
        // 模板引擎类型 支持 php think 支持扩展
        'type' => 'Think',
        // 模板路径
        'view_path' => '..\tpl\\',
        // 模板后缀
        'view_suffix' => 'html',
        // 模板文件名分隔符
        'view_depr' => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin' => '{',
        // 模板引擎普通标签结束标记
        'tpl_end' => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end' => '}',
    ],

    // 视图输出字符串内容替换
    'view_replace_str' => [
        '__public__' => '/',
        '__static__' => '/static',
        '__plugin__' => '/static/plugin',
        '__hui__' => '/static/hui/base',
        '__hui_admin__' => '/static/hui/admin',
    ],
//    // 默认跳转页面对应的模板文件
//    'dispatch_success_tmpl' => TPL_PATH . 'error_pages/dispatch_jump.tpl',
//    'dispatch_error_tmpl' => TPL_PATH . 'error_pages/dispatch_jump.tpl',
//
//    // +----------------------------------------------------------------------
//    // | 异常及错误设置
//    // +----------------------------------------------------------------------
//
//    // 异常页面的模板文件
//    'exception_tmpl' => TPL_PATH . 'error_pages/think_exception.tpl',
//
//    // 错误显示信息,非调试模式有效
//    'error_message' => '404 not found',
    // 显示错误信息
    'show_error_msg' => True,
//    // 异常处理handle类 留空使用 \think\exception\Handle
//    'exception_handle' => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log' => [
        // 日志记录方式，支持 file sae
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
    ],

    // +----------------------------------------------------------------------
    // | Trace设置
    // +----------------------------------------------------------------------

    'trace' => [
        //支持Html Console socket
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache' => [
        // 驱动方式
        'type' => 'File',
        // 缓存保存目录
        'path' => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session' => [
        'id' => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix' => 'think',
        // 驱动方式 支持redis memcache memcached
        'type' => '',
        // 是否自动开启 SESSION
        'auto_start' => true,
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie' => [
        // cookie 名称前缀
        'prefix' => '',
        // cookie 保存时间
        'expire' => 0,
        // cookie 保存路径
        'path' => '/',
        // cookie 有效域名
        'domain' => '',
        //  cookie 启用安全传输
        'secure' => false,
        // httponly设置
        'httponly' => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate' => [
        'type' => 'bootstrap',
        'var_page' => 'page',
        'list_rows' => 15,
    ],
    //密钥一旦配置，上线后不允许更改
    'key_nate' => [
        'UC_AUTH_KEY' => 'live_mengdie_key',

    ],

//    define('NOW_TIME', $_SERVER['REQUEST_TIME']),



    //权限密钥，初次修改一次，以后一旦修改，影响校验密码等
    'UC_AUTH_KEY'=>'P~^nlxj3i?e-%pwSHr"gLyA|EQ+Is@5!1.2RbM<W',
    //每天十万次请求，ip获取定位服务的请求key
    'BAIDU_IP_API_KEY'=>'VG6iXiGeteFcckytpiCsQLdMKdWUKBI4',
    //测试用，不重要的一个常量
    'api_url' => 'live.xiangchang.com/index.php',

    //seesion 过期时间 秒
    'session_expire' => 60 * 60 * 24,

    //字数限制
   'rule_fontlimit' => [
            'nickname'  => ['keyname'=>'用户昵称', 'min'=>1, 'max'=>10],
            'comment'   => ['keyname'=>'评论内容', 'min'=>1, 'max'=>60],
            'card_introduce' => ['keyname'=>'个人介绍', 'min'=>1, 'max'=>40],
            'user_signature' => ['keyname'=>'个人签名', 'min'=>1, 'max'=>40],
            'true_name' => ['keyname'=>'真实姓名', 'min'=>2, 'max'=>10],
            'secret_key' => ['keyname'=>'私密直播密钥', 'min'=>4, 'max'=>6],
    ],
    //正则配置
    'regular_rule' => [
        'phone' => '/^1[3-9]\d{9}$/',
        'email' => '/^\w{1,30}\@\w{1,20}\.[a-zA-Z]{2,10}$/',
        'username' => '/^[^0-9]\w{5,19}$/',
        'password' => '/^.{6,30}$/',
        'ip'=>'/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/',
        'identity_code'=>'/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/'
    ],

    //每页分页数量
    'pagesize_app' => 10 ,

    //本地签名密钥
    'TOKEN_ACCESS' => 'A!~^nlx#j3i?e-%p>[Hr"gLyA|EQ+Is@5!1.2RbM<W',

    //后台是否开启pc直播列表
    'IS_START_PC_LIVE' => 'true',

    define('ENVIRONMENT', 'develop'),//测试环境
//    define('ENVIRONMENT', 'official'),//正式环境
//    define('ENVIRONMENT', 'production'),//生产环境





];
