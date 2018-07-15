<?php
/**
 * Created by PhpStorm.
 * User: feel
 * Date: 2016/7/28
 * Time: 9:55
 */

//检测是否登录
function chk_login()
{
    //CLI模式下绕过
    if (IS_CLI) {
        return true;
    }

    //允许免检登录的地方
    $allow_list = [
        //'admin/account/index',
    ];
    $request = \think\Request::instance();
    $path = strtolower($request->module() . '/' . $request->controller() . '/' . $request->action());

    if (in_array($path, $allow_list)) {
        return true;
    }

    if (!is_admin_login()) {

        top_jump_url(url('admin/account/index'));
    }
    return true;
}

function is_admin_login()
{
    $admin_id = session("admin.id");
    if ($admin_id) return true;
    return false;
}

function admin_group()
{
    if (is_admin_login()) {
        $user_group = session("admin.user_group");
        if (!empty($user_group)) {
            return (string)$user_group;
        } else {
            return false;
        }
    } else return false;

}

function get_admin_id()
{
    $admin = session("admin");
    return $admin["id"];
}


function get_admin_name()
{
    $user_login = session("admin.user_login");
    return $user_login;
}

//获取admin登录信息
function admin_info()
{
    return session("admin");
}

//扫描文件夹下面的所有文件目录存为数组
function scan_dir($dir)
{
    $files = array();
    $dir_list = scandir($dir);
    foreach ($dir_list as $file) {
        if ($file != ".." && $file != ".") {
            if (is_dir($dir . "/" . $file)) {
                $files[$file] = scan_dir($dir . "/" . $file);
            } else {
                $files[] = $file;
            }
        }
    }
    return $files;
}




/**
 * Goofy 2011-11-30
 * getDir()去文件夹列表，getFile()去对应文件夹下面的文件列表,二者的区别在于判断有没有“.”后缀的文件，其他都一样
 */

//获取文件目录列表,该方法返回数组
function getDir($dir) {
    $dirArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&!strpos($file,".")) {
                $dirArray[$i]=$file;
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $dirArray;
}

//获取文件列表
function getFile($dir) {
    $fileArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != ".."&&strpos($file,".")) {
                $fileArray[$i]="./imageroot/current/".$file;
                if($i==100){
                    break;
                }
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $fileArray;
}

