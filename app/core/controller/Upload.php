<?php
namespace app\core\controller;

use app\core\model\AuthModel;
use app\core\model\UploadModel;
use org\Image;
use org\image\driver\Gd;
use think\template\driver\File;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 * Created by PhpStorm.
 * User: phil
 * Date: 2016/4/13
 * Time: 16:15
 */
Class Upload
{

    //上传图片
    public function img()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $uid=$timestamp=$token=null;
        file_put_contents('./aaa.txt',var_export(input('post.'),true));
        $post = input('post.',array());
        extract($post);

//        $sign = sign_by_key(array('uid'=>$uid,'timestamp'=>$timestamp));

//        if (($_FILES && ($sign===$token)))


        if ($_FILES )
        {
            //裁剪信息
            $width = input("post.width", null);//裁剪长
            $height = input("post.height", null);//裁剪宽
            $x = input("post.x", null);//x坐标
            $y = input("post.y", null);//y坐标
            $jcrop_flag = false;

            if (isset($width) && isset($height) && isset($x) && isset($y)) {
                $jcrop_flag = true;
            }
            print_r($_FILES);
            $files = $_FILES['file'];
            print_r($files);

            $m_up = new UploadModel();

//            if(!is_dir($config['rootPath'])){
//                mkdir($config['rootPath'],777,true);
//            }
            $upload = new  \think\File($files['tmp_name'], 'a');// 实例化上传类

//            $post['img_path'] = $post['savepath'] . $post['savename'];

            $f['rootpath'] = 'public' . DS . 'uploads';
            $file = $upload->move(ROOT_PATH .$f['rootpath'] ,true,false);//返回SplFileInfo对象


            if($file){
                $f['savepath'] = $file->getPathInfo();
                $f['temp'] = $f['savepath']->fileName;
                $f['savename'] = $file->getBasename();
//                print_r(array(
//                    'getATime' => $file->getATime(), //最后访问时间
//                    'getBasename' => $file->getBasename(), //获取无路径的basename
//                    'getCTime' => $file->getCTime(), //获取inode修改时间
//                    'getExtension' => $file->getExtension(), //文件扩展名
//                    'getFilename' => $file->getFilename(), //获取文件名
//                    'getGroup' => $file->getGroup(), //获取文件组
//                    'getInode' => $file->getInode(), //获取文件inode
//                    'getLinkTarget' => $file->getLinkTarget(), //获取文件链接目标文件
//                    'getMTime' => $file->getMTime(), //获取最后修改时间
//                    'getOwner' => $file->getOwner(), //文件拥有者
//                    'getPath' => $file->getPath(), //不带文件名的文件路径
//                    'getPathInfo' => $file->getPathInfo(), //上级路径的SplFileInfo对象
//                    'getPathname' => $file->getPathname(), //全路径
//                    'getPerms' => $file->getPerms(), //文件权限
//                    'getRealPath' => $file->getRealPath(), //文件绝对路径
//                    'getSize' => $file->getSize(),//文件大小，单位字节
//                    'getType' => $file->getType(),//文件类型 file  dir  link
//                    'isDir' => $file->isDir(), //是否是目录
//                    'isFile' => $file->isFile(), //是否是文件
//                    'isLink' => $file->isLink(), //是否是快捷链接
//                    'isExecutable' => $file->isExecutable(), //是否可执行
//                    'isReadable' => $file->isReadable(), //是否可读
//                    'isWritable' => $file->isWritable(), //是否可写
//                ));

            print_r($f);


                die();

            }else{
                echo'2';
                die();
            }

            $post = $post['file'];

            $post['img_path'] = $post['savepath'] . $post['savename'];
            $img_path = $config['rootPath'] . $post['img_path'];

            /*保存后如果有裁剪标记则进行裁剪*/
            if ($jcrop_flag) {
                $img = new Gd();
                $img->open($img_path);
                $img->crop($width, $height, $x, $y)->save($img_path);
            }



            /**校验图片是否已经上传,如果已经上传则直接从数据看里拷贝配置创建一条 E*/


            if (empty($post['img_path'])) {
                die("-1");
            }

            $filePath = $config['rootPath'] . trim($post['img_path'], "/");
            $image_size = getimagesize($filePath);

            //保存到数据库
            $arr = array(
                "name" => $post['name'],
                "img_path" =>  trim($img_path,"."),
                "origin" => empty(input('request.q',null))?null:input('request.q',null),
                "width" => $image_size[0],
                "height" => $image_size[1],
                "ext" => $post['ext'],
                "hash" => $post['md5'],
                "sha1" => $post['sha1'],
            );

            $save = $m_up->save_img_info($arr);

            if ($save) {
                $rt = array(
                    "code" => '1',
                    "id" => $save,
                    "img_path" => trim($img_path,"."),
                    "width" => $arr["width"],
                    "height" => $arr["height"],
                );
                die_json($rt);
            }
            die_json(array("code"=>"-1","msg"=>"save error"));
        }
        $data['code'] = "-1";
        $data['message'] = "up error";
        die_json($data);
    }

    public function upload_img()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');

        if (1)//($_FILES && (md5($_POST['uid'] . $_POST['timestamp']) == $_POST['token']))
        {
            //裁剪信息
            $width = input("post.width", null);//裁剪长
            $height = input("post.height", null);//裁剪宽
            $x = input("post.x", null);//x坐标
            $y = input("post.y", null);//y坐标
            $jcrop_flag = false;

            if (isset($width) && isset($height) && isset($x) && isset($y)) {
                $jcrop_flag = true;
            }

            $m_up = new UploadModel();
            $config = array(
                // 允许上传的文件MiMe类型
                'mimes' => [],
                // 上传的文件大小限制 (0-不做限制)
                'maxSize' => 2014000,
                // 允许上传的文件后缀
                'exts' => ['jpg', 'gif', 'png', 'jpeg', 'bmp'],
                // 自动子目录保存文件
                'autoSub' => true,
                // 子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'subName' => ['date', 'ymd'],
                //保存根路径
                'rootPath' => './data/img/',
                // 保存路径
                'savePath' => '',
                // 上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                'saveName' => ['uniqid', ''],
                // 文件保存后缀，空则使用原后缀
                'saveExt' => '',
                // 存在同名是否覆盖
                'replace' => true,
                // 是否生成hash编码
                'hash' => true,
                // 检测文件是否存在回调，如果存在返回文件信息数组
                'callback' => false,
                // 文件上传驱动e,
                'driver' => '',
                // 上传驱动配置
                'driverConfig' => ["Local"],
            );

            $upload = new \org\Upload($config, 'LOCAL');// 实例化上传类
            $post = $upload->upload();
            $post = $post['file'];


            $post['img_path'] = $post['savepath'] . $post['savename'];
            $img_path = $config['rootPath'] . $post['img_path'];
//            /*保存后如果有裁剪标记则进行裁剪*/
//            if ($jcrop_flag) {
//                $img = new Gd();
//                $img->open($img_path);
//                $img->crop($width, $height, $x, $y)->save($img_path);
//            }
            if (empty($post['img_path'])) {
                die("-1");
            }
            $img_name = md5($img_path);
            $res = $this->server_oss_img($img_name,$img_path);

            if($res == -1){
                die_json("OSS图片上传失败");
            }
            //保存到数据库
            $arr = array(
                "name" => $img_name,
                "img_path" => $img_name,
                "type" => 6,
                "create_time"=>time()
            );
            $id = $m_up->save_img_info($arr);

            if ($id) {
                $rt = array(
                    "code" => '1',
                    "id"=>$id,
                    "img_path" => $img_name,
                );
                die(json_encode($rt));
            }
            die_json(array("code"=>"-1","msg"=>"save error"));
        }
        $data['code'] = "-1";
        $data['message'] = "上传失败";
        die(json_encode($data));
    }

    //Oss图片上传
    public function server_oss_img($object,$file){
//        $accessKeyId = "LTAIdhExWX2iwdW0";
//        $accessKeySecret = "3fSrJw4erU2sZL1N7jbG09y0h9EJqn";
//        $endpoint = "http://oss-cn-shanghai.aliyuncs.com";
        $accessKeyId = config('CONFIG_OSS_ACCESSKEYID');
        $accessKeySecret = config('CONFIG_OSS_ACCESSKEYSECRET');
        $endpoint = 'http://'.config('CONFIG_OSS_ENDPOINT');
        $bucket= config('CONFIG_OSS_BUCKET_IMG');
        if(empty($object) || empty($file)) return -1;
//        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint, false);
//            $ossClient->createBucket($bucket); //创建存储空间bucket
            $obj = $ossClient->uploadFile($bucket, $object, $file); //上传文件
            if(!empty($obj)){
                return 1;
            }else{
                return -1;
            }
//            $content = $ossClient->getObject($bucket, $object);  //下载文件
//            print("object content: " . $content);
//            $ossClient->deleteObject($bucket, $object); //删除文件
        } catch (OssException $e) {
            print ($e->getMessage() . "\n");
        }
    }

    
}