<?php
/**公共函数类库*/
function check_login(){
    $mid = session('member_id');
    if(!empty($mid)){
        return $mid;
    }else{
        die_json(array('code' => "-1", 'msg' => '请先登录'), 1);
    }
}
/*md5加密升级版*/
function md6($str)
{
    return md5(serialize(json_encode($str)));
}

// 一维数组XSS过滤
function remove_arr_xss($data)
{
    foreach ($data as $k => $v) {
        $data[$k] = trim(remove_xss($v));
    }
    return $data;
}

//字符串XSS过滤
function remove_xss($val)
{
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }

    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true;
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2);
            $val = preg_replace($pattern, $replacement, $val);
            if ($val_before == $val) {
                $found = false;
            }
        }
    }
    return $val;
}

////错误返回值
//function wrong_return($msg = 'error')
//{
//    die_json(array('code' => "-1", 'msg' => $msg), 1);
//}
//
////正确返回值
//function ok_return($msg = 'success')
//{
//    die_json(array('code' => "1", 'msg' => $msg));
//}

function ok_return($msg = 'success', $code = 1, $ret_data = [])
{
    $arr = [
        'ret' => 0,
        'code' => strval($code),
        'msg' => $msg,
        'ret_data' => $ret_data
    ];
    die_json($arr);
}

function wrong_return($msg = 'failed', $code = -1, $ret_data = [])
{
    $arr = [
        'ret' => 1,
        'code' => strval($code),
        'msg' => $msg,
        'ret_data' => $ret_data
    ];
    die_json($arr, 1);
}

//返回信息的封装
function rt($code = null, $val = null, $msg = null){
    if (!empty($msg)) {
        log_w($msg);
    }
    return array("code" => $code, "value" => $val);
}


//通用返回值
function com_return($code = 300, $msg = 'error')
{
    die_json(array('code' => $code, 'msg' => $msg));
}

//本站签名方法
function sign_by_key($arr = array('uid' => '', 'timestamp' => ''))
{
    $uid = empty($uid) ? 0 : $arr['uid'];
    $timestamp = empty($arr['timestamp']) ? microtime() : $arr['timestamp'];
    $key = config('TOKEN_ACCESS');
    return md5($uid . $timestamp . $key);
}

/*数组返回json
字符串返回code=字符串
type存在,返回中文**/
function rt_json($post, $type = null, $msg = null)
{

    if (is_array($post)) {
        if ($type) return json_encode($post, JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return json_encode($post,JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    } else {
        $tmp = array(
            "code" => $post
        );
        if (!empty($msg)) {
            $tmp['msg'] = $tmp;
        }
        if ($type) return json_encode($tmp, JSON_UNESCAPED_UNICODE);
        return json_encode($tmp,JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}

//输入json并且结束
function die_json($post, $type = null)
{
    die(rt_json($post, $type));
}
function obj_to_arr($obj)
{
    return json_decode(json_encode($obj), true);
}
//跳转
function jump_url($url)
{
    header("Location: " . $url);
//    echo "<script>window.top.location.href='$url'</script>";
    die();
}


//top跳转
function top_jump_url($url)
{
//    header("Location: " . $url);
    echo "<script>window.top.location.href='$url'</script>";
    die();
}


//模拟get请求
function curl_get($url)
{
    //初始化
    $ch = curl_init();

    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    //执行并获取HTML文档内容
    $output = curl_exec($ch);

    //释放curl句柄
    curl_close($ch);

    //返回获得的数据
    return $output;
}



/**
 *  Function: 获取远程图片写入图片表
 *
 * 变量说明:
 * $。
 * $filename 是可选变量: 如果为空，本地文件名将基于时间和日期// 自动生成.
 * @param $url
 * @param string $filename
 * @return bool|string
 */
function GrabHeardpic($img_path,$mid,$filename='') {


    $data = array();
    $data['name'] = $filename;
    $data['uid'] = $mid;
    $data['type'] = IMG_TYPE2;
    $data['status'] = IMG_STATUS1;
    $data['img_path'] = $img_path;
    $data['width'] = 0;
    $data['height'] = 0;
    $data['origin'] = 'fetch';
    $data['update_time'] = time();
    $data['create_time'] = time();

    $pic_id = think\Db::table('sp_image_list')->insertGetId($data);//头像图片入库 返回pic_id

    if(!$pic_id) exit_array(118,0,'头像同步到本地错误');
    $pic_info = ['pic_id'=>$pic_id,'pic_path'=>$img_path];

    return $pic_info;
}

/**
 *  Function: 获取远程图片并把它保存到本地
 *  确定您有把文件写入本地服务器的权限
 * 变量说明:
 * $url 是远程图片的完整URL地址，不能为空。
 * $filename 是可选变量: 如果为空，本地文件名将基于时间和日期// 自动生成.
 * @param $url
 * @param string $filename
 * @return bool|string
 */
function GrabImage($url) {
    if($url==''):return false;endif;

    $save_path = 'data/fetch/';
    @mkdir($save_path, 0777, true);
    @chmod($save_path, 0777);
    $img_content = curl_get($url);
    $str = rand_str($k = 's', $n = 6);
    $filename =  md5(time() . $str) . '.jpg';
    file_put_contents($save_path . $filename, $img_content);
    $img_path = './' . $save_path . $filename;



   return $img_path;



//    $data = array();
//        $data['name'] = $filename;
//        $data['uid'] = $mid;
//        $data['type'] = IMG_TYPE2;
//        $data['status'] = IMG_STATUS1;
//        $data['img_path'] = $img_path;
//        $data['width'] = 0;
//        $data['height'] = 0;
//        $data['ext'] = !empty($ext)?$ext:0;
//        $data['origin'] = 'fetch';
//        $data['update_time'] = time();
//        $data['create_time'] = time();
//
//    $pic_id = think\Db::table('sp_image_list')->insertGetId($data);//头像图片入库 返回pic_id
//
//    if(!$pic_id) exit_array(118,0,'头像同步到本地错误');
//    $pic_info = ['pic_id'=>$pic_id,'pic_path'=>$img_path];

    return $pic_info;
}

/**
 * 借助百度api接口通过ip获取 经度
 * @param $ip
 * @return mixed
 */
function get_logitude_by_ip($ip)
{
    $m = new \app\lib\iHttp();
    $content = $m->get('http://api.map.baidu.com/location/ip?ak='.config('BAIDU_IP_API_KEY').'&ip='.$ip.'&coor=bd09ll');
    $json = json_decode($content);
    if(!isset($json->{'content'})) return 0;
    return $json->{'content'}->{'point'}->{'x'};//按层级关系提取经度数据
}

/**
 * 借助百度api接口通过ip获取 纬度
 * @param $ip
 * @return mixed
 */
function get_latitude_by_ip($ip)
{
    $m = new \app\lib\iHttp();
    $content = $m->get('http://api.map.baidu.com/location/ip?ak='.config('BAIDU_IP_API_KEY').'&ip=' . $ip . '&coor=bd09ll');
    $json = json_decode($content);
    if(!isset($json->{'content'})) return 0;
    return $json->{'content'}->{'point'}->{'y'};//按层级关系提取纬度数据
}


/**
 * 借助百度api接口通过ip获取 地理信息 省
 * @param $ip
 * @return mixed
 */
function get_province_by_ip($ip)
{
    $m = new \app\lib\iHttp();
    $content = $m->get('http://api.map.baidu.com/location/ip?ak='.config('BAIDU_IP_API_KEY').'&ip=' . $ip . '&coor=bd09ll');
    $json = json_decode($content);
    if(!isset($json->{'content'})) return 0;
    return $json->{'content'}->{'address_detail'}->{'province'};
}
/**
 * 借助百度api接口通过ip获取 地理信息 市
 * @param $ip
 * @return mixed
 */
function get_city_by_ip($ip)
{
    $m = new \app\lib\iHttp();
    $content = $m->get('http://api.map.baidu.com/location/ip?ak='.config('BAIDU_IP_API_KEY').'&ip=' . $ip . '&coor=bd09ll');

    $json = json_decode($content);
    if(!isset($json->{'content'})) return 0;
    return $json->{'content'}->{'address_detail'}->{'city'};
}
/**
 * 检验手机号是否符合规范
 * @param $phone
 * @return bool
 */
function checkPhone($phone)
{
    if (preg_match("/^1\\d{10}$/", $phone)) {
        return true;
    } else {
        return false;
    }
}



/**
 * 获取当前时间戳，精确到毫秒,如果包含参数,格式为'2016-10-5 12:12:12.538'则转换为参数的时间戳
 * @param string $time 精确到毫秒的时间
 * @return int 返回值
 */
function microtime_float($time = null)
{
    if ($time) {
        $tmp = explode('.', $time);
        if (empty($tmp[1])) $m_time = strtotime($tmp[0]);
        else $m_time = strtotime($tmp[0]) . substr($tmp[1], 0, 3);
    } else {
        list($usec, $sec) = explode(" ", microtime());
        $time = ((float)$usec + (float)$sec) * 1000;
        $m_time = round($time, 0);
    }
    return $m_time;
}
/**
 * 生成若干长度的随机数字串
 * @param string $txt
 * @param string $keywords
 */


function createNumber($len = 20, $capital = true){
    $str = '0123456789';
    $i = 0;
    $numberStr = '';
    while($i< $len) {
        $rand = rand(0,9);
        $numberStr .= substr($str,$rand,1);
        $i++;
    }

    return $capital == true ? strtoupper($numberStr) : $numberStr;
}

//返回数组
function exit_array($code, $status, $message = '', $data = '', $extData = array())
{
    $result = array(
        'code' => $code,
        'success' => $status == 1 ? true : false,
        'msg' => $message,
        'data' => $data,
    );

//    if (!empty($data) && is_array($data)) $result['data'] = $data;//可以返回空数组
        if(empty($data)) $result['data'] = array();
    // 扩展数据追加到列表
    if (!empty($extData) && is_array($extData)) {
        foreach ($extData as $key => $value) {
            $result[$key] = $value;
        }
    }

    return $result;
    // echo $json;
    // exit;
}


function exit_json($code, $message='', $data = array(), $extData = array())
{
    $result = array(
        'code'=>$code,
        'success' => $code == 0 ? true : false,
        'msg' => (string)$message,
    );

//    if (!empty($data)) $result['data'] = $data;
    $result['data'] = $data;

    //PHP索引数组转换成json是数组，php关联数组转换成json是对象。
    //$data =array_values(array_filter($data));

    // 扩展数据追加到列表
    if (!empty($extData) && is_array($extData))
    {
        foreach ($extData as $key => $value)
        {
            $result[$key] = $value;
        }
    }

    $json = json_encode($result, JSON_HEX_TAG|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
//    return $json;
    echo $json;
    exit;
}
//返回验证码地址
function verify_url()
{
    return Url('core/api/verify') . "?&amp;time";
}
/**
 *  @desc 根据两点间的经纬度计算距离
 *  @param float $latitude 纬度值
 *  @param float $longitude 经度值
 */
function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
{
    $earth_radius = 6371000;   //approximate radius of earth in meters

    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);
    /*
      Using the
      Haversine formula

      http://en.wikipedia.org/wiki/Haversine_formula
      http://www.codecodex.com/wiki/Calculate_Distance_Between_Two_Points_on_a_Globe
      验证：百度地图  http://developer.baidu.com/map/jsdemo.htm#a6_1
      calculate the distance
    */
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;

    return round($d);   //四舍五入
}
/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
{
    if (is_array($tree)) {
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if (isset($reffer[$child])) {
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby = 'asc');
    }
    return $list;
}

//获取客户真实ip
function get_client_ip_true()
{
    if (isset($_SERVER)) {
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
    }
    return $ip;
}

/**
 * @param $url
 * @param string $filename
 * @return bool|string   false or  oss 路径
 */
function put_url_pic_to_oss($url,$filename=''){
    if($url==''):return false;endif;

    if($filename=='') {
        $ext = pathinfo($url, PATHINFO_EXTENSION);
        $str = rand_str($k = 's', $n = 6);
        if($ext!='.gif' && $ext!='.jpg' && $ext!='.png'){
            $filename=date('dMYHis').$str.'.jpg';
            $ext ='jpg';
        }else{
            $filename=date('dMYHis').$str.$ext;
        }
    }

    $img_content = curl_get($url);
    $save_path ='data/img/uploads/'.date('Ymd'); // 接收文件目录

    if (! file_exists ( $save_path )) {
        $temp = mkdir( "$save_path", 0777, true );
    }

    file_put_contents($save_path.'/'.$filename, $img_content);

    $img_path = './' . $save_path.'/'.$filename;// /data/img/uploads/20160809/fsfasfas.jpg

    $img_name = md5($img_path);
    $res = server_oss_img($img_name,$img_path);

    if($res == 1) return $img_name;
}
//oss  上传
function server_oss_img($object,$file){

    $accessKeyId = config('CONFIG_OSS_ACCESSKEYID');
    $accessKeySecret = config('CONFIG_OSS_ACCESSKEYSECRET');
    $endpoint = 'http://'.config('CONFIG_OSS_ENDPOINT');
    $bucket= config('CONFIG_OSS_BUCKET_IMG');
    if(empty($object) || empty($file)) return -1;
//
    try {
        $ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint, false);
//
        $obj = $ossClient->uploadFile($bucket, $object, $file); //上传文件

        if(!empty($obj)){
            return 1;
        }else{
            return -1;
        }
//
    } catch (OssException $e) {
        print ($e->getMessage() . "\n");
    }

}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0, $adv = false)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) return $ip[$type];
    if ($adv) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}
/**
 * 通过主键ID 获取member 信息
 * @param $id
 * @return bool
 */
function get_member_info_by_id($id)
{
    if ($id) {
        Return db('member')->where('member_id', $id)->find();
    } else {
        return false;
    }

}


/**
 * 通过主键ID 获取member 信息
 * @param $id
 * @return bool
 */
function get_member_cache_info_by_id($id)
{
    if ($id) {
        Return db('member')->where('member_id', $id)->cache()->find();
    } else {
        return false;
    }

}

/**
 * 验证一个日期格式  是否合法 2017-18-22  返回false 写的不够好  回头继续优化
 * @param $date
 * @return bool
 */
function check_date_format($date) {
    if (preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $date, $parts)) {

        if (checkdate($parts[2], $parts[3], $parts[1])) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}


/**
 * 验证密码规则
 *6~16位字符，
 */
function check_password($password){
    if (preg_match("/^[a-zA-Z0-9`~!@#$%^&*()-=_+{}\|\:\;\"'<>,.?\/]{6,16}$/", $password)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 获取字符串中英文混合长度
 * @param $str string 字符串
 * @param $$charset string 编码
 * @return 返回长度，1中文=1位，2英文=1位
 */
function strLength($str, $charset = 'utf-8')
{
    if($charset=='utf-8') $str = @iconv('UTF-8', 'GB18030', $str);

    $length = strlen($str);
    $cnNum = 0;
    for ($i=0; $i<$length; $i++) {
        if (ord(substr($str,$i+1,1)) > 127) {
            $cnNum++;
            $i++;
        }
    }

    $enNum = $length - ($cnNum * 2);
    $number = ($enNum / 2) + $cnNum;
    return ceil($number);
}

/**
 * 获取字符长度限制配置
 * @param $id
 * @return mixed
 */
function getFontRule($id)
{

    $fontlimits = config("rule_fontlimit");
    if (!isset($fontlimits[$id])) exit_json(1, '配置信息不存在');

    $fontlimit = $fontlimits[$id];
    $fontlimit['errmsg'] = $fontlimit['keyname'] . '长度为' . $fontlimit['min'] . '-' . $fontlimit['max'] . '字';

    return $fontlimit;
}


/**
 * 接口请求时带上验证参数
 *
 * @param  string $paramter 参数
 * @return string           签名串
 */
function genSign($paramter, $encryptKey=null)
{
    unset($paramter['sign']);
    unset($paramter['_Mk']);
    ksort($paramter);

    $querys = '';

    foreach ($paramter as $key => $value)
    {
        if(is_object($value)) $value = (array)$value;
        if (is_array($value))
        {
            genSign($value, $encryptKey);
        }
        else {
            $querys .= "&{$key}={$value}";
        }
    }

    if ($encryptKey === null)
    {

        $encryptKey = config('encryption_key');
    }

    $str = $querys . $encryptKey;

    $sign = md5($str);

    return $sign;
}



/**
 * 接口请求参数进行验证
 *
 * @return array  $result
 */
function checkSign($encryptKey = null)
{

    if (empty($_REQUEST['sign'])) exit_json(1, '签名不能为空');
    if (empty($_REQUEST['timestamp'])) exit_json(1, '请求时间不能为空');

    $requestTimestamp = strlen($_REQUEST['timestamp']) == 13 ? substr($_REQUEST['timestamp'], 0, -3) : $_REQUEST['timestamp'];
    if ( (time() - $requestTimestamp) > 60 ) exit_json(1, '请求超时');
    $serverSign = genSign($_REQUEST, $encryptKey);
    if ($_REQUEST['sign'] != $serverSign) exit_json(1, '签名错误');

    return true; // 验证通过;
}

function recordlog($content)
{
    $file = APP_PATH . 'logs/'.date('Y-m').'_live.log';

    $uri = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : 'cron';
    error_log(date('Y-m-d H:i:s')."========={$uri}\n".$content."\n\n",3, $file);
}


/**
 * 加密函数
 * @param array $auth           需要加密的数组
 * return string  $authStr      返回加密后的字符串
 */
function encrypt($auth, $secret = '')
{
    return base64_encode(_crypt(serialize($auth), 'encrypt', $secret));
}

/**
 * 加密/解密函数
 * @param mixde     $input      操作的变量
 * @param string    $action     操作类型
 * @return mixde    auth        返回处理后的结果
 */
function _crypt($input, $action = 'encrypt', $secret = '')
{
    $secret = !empty($secret) ? $secret : '87_zxcd^%@yb~!@)(*&';
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
    mcrypt_generic_init($td, $secret, $iv);
    $ret = (($action=='encrypt') ? mcrypt_generic($td, $input) : mdecrypt_generic($td,$input));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return $ret;
}

/**
 * 解密函数
 * @param string    $authStr    需要解密的字符串
 * @return array    $auth       返回解密后的数组
 */
function decrypt($authStr, $secret = '')
{
    return @unserialize(_crypt(base64_decode($authStr), 'decrypt', $secret));
}

/**
 * 判断是否是吉祥号
 */



function checkGoodNum($num)
{
    return false;//此处回头写一些吉祥号的规则，判断是否是吉祥号
}
/**
 * 通过主键ID 获取话题信息
 * @parameter $id
 * @return mixed
 */
function get_topic_by_id($id)
{
    if (empty($id)) return false;
    return db('topic')->where(array('id' => $id))->find();
}


function get_member_info_by_phone($phone)
{
    if(empty($phone)) return false;
    return db('member')->where('phone',$phone)->find();

}



/**
 * 验证码检查，验证完后销毁验证码增加安全性 ,<br>返回true验证码正确，false验证码错误
 * @return boolean <br>true：验证码正确，false：验证码错误
 */
function sp_check_verify_code()
{
    if (!empty($_REQUEST['verify'])) {
        $verify = new \org\Verify();
        return $verify->check($_REQUEST['verify'], "");
    }
    return false;
}


 function sign($order_id, $timestamp){
    //获取系统公钥
    $key = config('TOKEN_ACCESS');
    return md5($order_id.$timestamp.$key);
}

/**
 * 鉴定权限签名
 * @param string $order_id 订单号id
 * @param string $timestamp 时间戳
 * @param string $sign 签名
 * @return bool
 */
function auth($order_id, $timestamp, $sign)
{
    //获取系统公钥
    $key = config('TOKEN_ACCESS');

    $token = md5($order_id . $timestamp . $key);

    //权限校验失败
    if ($sign !== $token) return rt("-100",$token);
    //时间戳超时
    if (NOW_TIME - $timestamp > 7200) return rt("-200",date("Y-m-d H:i:s"));
    return rt("1","成功");
}
/**
 * 获取客户端操作系统信息包括win10
 * @author  Jea杨
 * @return string
 */
function get_os()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10';#添加win10判断
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}

function paraFilter($para)
{
    $para_filter = array();
    while (list ($key, $val) = each($para)) {
        if ($key == "sign" || $key == "sign_type" || $val == "") continue;
        else    $para_filter[$key] = $para[$key];
    }
    return $para_filter;
}

//输入日志信息
function log_w($txt = '', $keywords = '')
{
    if (!is_dir('./log')) {
        mkdir('./log');
    }
    $t = !empty($keywords) ? "关键字:" . $keywords . "\r\n" : '';
    file_put_contents("./log/log_" . date("Y-m-d") . ".txt",/* $split_start.*/
        "\r\n" . date("Y-m-d H:i:s") . ": \r\n" . $t . $txt . "\r\n" /*. $split_end*/, FILE_APPEND);
}
//die_json函数的进一步封装
function die_result($code = null, $msg = null, $flag = null)
{
    if ($flag == 1) {
        return array("code" => $code, 'msg' => $msg);
    } else {
        die_json(array("code" => $code, 'msg' => $msg), 1);
    }

}
//生成全局唯一订单号
function create_order_num($i = '')
{
    return date("ymdhis") . rand(1000, 9999) . $i;
}

/**
 * 获取所有输入
 */
/**
 * RSA签名
 * @param $data 待签名数据
 * @param $private_key_path 商户私钥文件路径
 * return 签名结果
 */
function rsaSign($data, $private_key_path) {
    $priKey = file_get_contents($private_key_path);
    $res = openssl_get_privatekey($priKey);
    openssl_sign($data, $sign, $res);
    openssl_free_key($res);
    //base64编码

    $sign = base64_encode($sign);

    return $sign;
}
/**
 * 支付宝的签名校验函数
 * @param array $post 支付宝签名
 * @return string 签名后的值
 */
function md5_sign_verify($post, $info_sign)
{
    // 验证sign
    unset($post['sign']);
    unset($post['sign_type']);
    // 升序排列数组
    $data = paraFilter($post);//删除全部空值
    $data = argSort($data);
    $str = createLinkstring($data);
    $token = config('ALI_PAY_MD5_SECRET');
    $str = trim($str, '&') . $token;
    return md5($str) === $info_sign;//验证签名是否相等
}
/**
 * RSA验签
 * @param $data 待签名数据
 * @param $ali_public_key_path 支付宝的公钥文件路径
 * @param $sign 要校对的的签名结果
 * return 验证结果
 */
function rsaVerify($data, $ali_public_key_path, $sign)  {
    $pubKey = file_get_contents($ali_public_key_path);
    $res = openssl_get_publickey($pubKey);
    $result = (bool)openssl_verify($data, base64_decode($sign), $res);
    openssl_free_key($res);

    return $result;
}

/**
 * RSA解密
 * @param $content 需要解密的内容，密文
 * @param $private_key_path 商户私钥文件路径
 * return 解密后内容，明文
 */
function rsaDecrypt($content, $private_key_path) {
    $priKey = file_get_contents($private_key_path);
    $res = openssl_get_privatekey($priKey);
    //用base64将内容还原成二进制
    $content = base64_decode($content);
    //把需要解密的内容，按128位拆开解密
    $result  = '';
    for($i = 0; $i < strlen($content)/128; $i++  ) {
        $data = substr($content, $i * 128, 128);
        openssl_private_decrypt($data, $decrypt, $res);
        $result .= $decrypt;
    }
    openssl_free_key($res);
    return $result;
}

function get_all_input(){
    $inout_1 =input('param.',[]);
    $inout_2 =input('request.',[]);
    $input_3 =json_decode(file_get_contents('php://input'),true);
    if(!is_array($input_3)) $input_3 =array();

    if(empty($inout_1)&&empty($inout_2)&&empty($input_3)) return array();
    return $data = array_merge($inout_1,$inout_2,$input_3);
}


/**
 * 格式化时间戳，精确到毫秒，x代表毫秒
 * @param string $time 毫秒级时间戳
 * @param int $type 1返回正常时间戳,2返回正常时间戳加毫秒,3返回正常时间戳加毫秒 加点再加毫秒
 * @param string $format 格式化的形式
 * @return string 返回值
 */

function microtime_format($time, $type = 1, $format = 'His')
{
    $length = strlen($time);
    if (!is_numeric($time) || $length < 13) return false;

    $sec = intval(substr($time, 0, $length - 3));
    $m_sec = substr($time, $length - 3, $length);

    switch ($type) {
        case "1":
            return date($format, $sec);
        case "2":
            return date($format, $sec) . $m_sec;
        default:
            return date($format, $sec) . '.' . $m_sec;
    }
}
/**
 * 对数组排序
 * @param $para 排序前的数组
 * @return 排序后的数组
 */
function argSort($para)
{
    ksort($para);
    reset($para);
    return $para;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * @return 拼接完成以后的字符串
 */
function createLinkstring($para)
{
    $arg = "";
    while (list ($key, $val) = each($para)) {
        $arg .= $key . "=" . $val . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;
}
//检测是否为post
function is_post()
{
    $request = \think\Request::instance();
    return $request->isPost();
}

//检测是否为post
function is_ajax_post()
{
    $request = \think\Request::instance();
    return $request->isAjax() && $request->isPost();
}

//验证信息
function validate_rule($type = null, $str = 'null')
{
    if (empty($type) || empty($str)) return false;
    switch ($type) {
        case 'id':
            $rgx = '/[a-zA-Z0-9_]/';
            break;
        case 'username':
            $rgx = '/[a-zA-Z0-9_]/';
            break;
        case 'password':
            $rgx = '/[a-zA-Z0-9_]/';
            break;
        case 'phone':
            $rgx = '/[1][3-9][0-9]{9}/';
            break;
        default:
            $rgx = '/.*/';
    }

    if (!preg_match($rgx, $str)) return false;
    return true;
}


//字符串转数组去空
function str_to_arr($str, $split = ",")
{
    $arr = explode($split, $str);
    $arr = array_filter($arr);
    return $arr;
}

//字符串去空逗号分割
function str_implode($str, $split = ",")
{
    $arr = explode($split, $str);
    $arr = array_filter($arr);
    return implode(",", $arr);
}

//实例化数据库,
function db_func($str = null, $pre_fix = null, $connect = null)
{
    if (!empty($connect)) \think\Db::connect($connect);
    if (!empty($pre_fix)) {
        return \think\Db::table($pre_fix . $str);
    }
    return \think\Db::name($str);
}

function chk_id($id, $allow_zero = false)
{
    if ($allow_zero) {
        if (empty($id) && $id !== 0) return false;
    } else {
        if (empty($id)) return false;
    }

    if (!is_numeric($id)) return false;
    return true;
}

function get_all()
{
    $arr_1 = input('param.', []);
    $arr_2 = input('request.', []);
    return array_merge($arr_1, $arr_2);
}

//数组转换字符串去重
function arr_to_str($arr, $filter = true, $glue = ',')
{
    if ($filter) {
        $arr = array_filter($arr);
    }
    return implode($glue, $arr);
}


/*
 * 生成随机数加强版
 * @param $k 生成随机数字的模式,n为数字,s为字符串,r为字符串或数字
 * @param $n 生成随机数字长度
 * @return 生成的随机数
 * */
function rand_str($k = 'n', $n = 6)
{
    $r = "";

    switch (strtolower($k)) {
        case "n":
            $pattern = '1234567890';
            $length = 9;
            break;
        case "s":
            $pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
            $length = 52;
            break;

        case "r":
            $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
            $length = 62;
            break;
        default:
            $pattern = '1234567890';
            $length = 9;
            break;
    }

    for ($i = 0; $i < $n; $i++) {
        $r .= $pattern{mt_rand(0, $length)};    //生成php随机数
    }
    return $r;
}

//数组转get格式
function arr2get($para)
{
    $arg = "";
    while (list ($key, $val) = each($para)) {
        $arg .= $key . "=" . urlencode($val) . "&";
    }

    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }

    return $arg;



}

//根据秒,返回指定类型的计量单位
function rt_time_format($type, $sec)
{
    switch ($type) {
        case "year":
            return round($sec / (86400 * 365), 2);
        case "month":
            return round($sec / (86400 * 30), 2);
        case "week":
            return round($sec / (86400 * 7), 2);
        case "day":
            return round($sec / 86400, 2);
        case "hour":
            return round($sec / 3600, 2);
        case "min":
            return round($sec / 60, 2);
        case "sec":
            return round($sec, 0);
        default :
            return false;
    }
}

//根据秒,自动返回计量单位
function rt_auto_sec($sec)
{
    switch ($sec) {
        case ($sec > 0 && $sec <= 60):
            return rt_time_format('sec', $sec) . '秒';
        case ($sec >= 60 && $sec < 3600):
            return rt_time_format('min', $sec) . '分钟';
        case ($sec >= 3600 && $sec < 86400):
            return rt_time_format('hour', $sec) . '小时';
        case ($sec >= 86400 && $sec < (86400 * 7)):
            return rt_time_format('day', $sec) . '天';
        case ($sec >= (86400 * 7) && $sec < (86400 * 30)):
            return rt_time_format('week', $sec) . '周';
        case ($sec >= (86400 * 30) && $sec < (86400 * 365)):
            return rt_time_format('month', $sec) . '月';
        case ($sec >= (86400 * 365)):
            return rt_time_format('year', $sec) . '年';
        default:
            return false;
    }
}

//根据秒,自动返回计量单位
function pc_auto_sec($sec)
{
    switch ($sec) {
        case ($sec > 0 && $sec <= 60): //秒
            if($sec < 10){
                $sec = "0".$sec;
            }
            return ('00:00:'.$sec);
        case ($sec >= 60 && $sec < 3600):
            $min = floor($sec / 60);
            $sec = floor($sec % 60);
            if($sec < 10) $sec = "0".$sec;
            if($min < 10) $min = "0".$min;
            return ('00:'.$min.':'.$sec); //分钟
        case ($sec >= 3600):
            $hour = floor($sec / 60 / 60);
            $min = floor(($sec-$hour*3600) / 60 % 60);
            $sec = floor(($sec-$hour*3600) % 60);
            if($sec < 10) $sec = "0".$sec;
            if($min < 10) $min = "0".$min;
            if($hour < 10) $hour = "0".$hour;
            return ($hour.':'.$min.':'.$sec); //小时
        default:
            return false;
    }
}

/** 根据输入月份筛选当前月的天数 */
function get_current_month_days($month,$year){
    if(!empty($month)){
        $max_month = array(1,3,5,7,8,11);
        $min_month = array(4,6,9,12);

        if(in_array($month, $max_month)) $this_month = 31;
        if(in_array($month, $min_month)) $this_month = 30;

        $leap_year  = fmod($year,4);
        if($leap_year == 0){
            if($month == 2) $this_month = 29;
        }else{
            if($month == 2) $this_month = 28;
        }
    }
    $data1 = $year.'-'.$month.'-'.'1';
    $data2 = $year.'-'.$month.'-'.$this_month;

    $data = [
        'start' => strtotime($data1),
        'end'  => strtotime($data2)
    ];
    return $data;
}
//输入日志信息
function log_sql($txt = '', $flag = '')
{
    if (!is_string($txt)) {
        $txt = json_encode($txt);
    }

    if (!empty($flag)) {
        $txt = '[' . $flag . ']' . $txt;
    }

    return db_func('log', 'sp_')->insert(['text' => $txt, 'create_time' => NOW_TIME]);
}

//获取用户的浏览器信息
function get_user_browser()
{
    if (empty($_SERVER['HTTP_USER_AGENT']))
    {
        return '';
    }

    $agent       = $_SERVER['HTTP_USER_AGENT'];
    $browser     = '';
    $browser_ver = '';

    if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'IE浏览器';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = '火狐浏览器';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/QQBrowser\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'QQ浏览器';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Maxthon/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') Maxthon';
        $browser_ver = '';
    }
    elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs))
    {
        $browser     = '欧朋浏览器';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = 'OmniWeb浏览器';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/Chrome\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = '谷歌浏览器';
    }
    elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = '百度浏览器';
        $browser_ver = $regs[2];
    }
    elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = '苹果浏览器';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs))
    {
        $browser     = '(Internet Explorer ' .$browser_ver. ') NetCaptor';
        $browser_ver = $regs[1];
    }
    elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs))
    {
        $browser     = 'Lynx浏览器';
        $browser_ver = $regs[1];
    }
    if (!empty($browser))
    {
//        return addslashes($browser . ' ' . $browser_ver);
        return addslashes($browser);
    }
    else
    {
        return 'QQ浏览器';
    }
}