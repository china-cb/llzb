<?php

/**
 * 从数据库加载配置,配置改变后需要更新缓存
 */
if (!function_exists('cache')) {
    function cache($name, $value = '', $options = null)
    {
        if (is_array($options)) {
            // 缓存操作的同时初始化
            \think\Cache::connect($options);
        } elseif (is_array($name)) {
            // 缓存初始化
            return think\Cache::connect($name);
        }
        if ('' === $value) {
            // 获取缓存
            return think\Cache::get($name);
        } elseif (is_null($value)) {
            // 删除缓存
            return think\Cache::rm($name);
        } else {
            // 缓存数据
            if (is_array($options)) {
                $expire = isset($options['expire']) ? $options['expire'] : null; //修复查询缓存无法设置过期时间
            } else {
                $expire = is_numeric($options) ? $options : null; //默认快捷缓存设置过期时间
            }
            return think\Cache::set($name, $value, $expire);
        }
    }
}
if (!function_exists('config')) {
    function config($name = '', $value = null, $range = '')
    {
        if (is_null($value) && is_string($name)) {
            return \think\Config::get($name, $range);
        } else {
            return \think\Config::set($name, $value, $range);
        }
    }
}
if (empty(cache('config_cache'))) {
    /* 读取站点配置 */
    $m = think\Db::table('sp_config');
    $r = $m->select();
    foreach ($r as $k => $v) {
        $r[$k]['name'] = strtoupper($r[$k]['code']);
    }
    $r = array_column($r, 'value', 'code');

    cache('config_cache', $r);
}
//取配置,赋值
config(cache('config_cache')); //添加配置