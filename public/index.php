<?php

define('__version__', 'V0.1');//前台版本号
define('__admin_version__', 'V0.1');//后台版本号
// 定义应用目录
define('APP_PATH', __DIR__ . '/../app/');
//网站根目录
define('ROOT_PATH', __DIR__ . '/../');
//前台模版目录
define('TPL_PATH', ROOT_PATH . 'tpl/');

define('NOW_TIME', $_SERVER['REQUEST_TIME']);
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
