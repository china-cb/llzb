<?php
namespace app\core\model;

use think\Model;
class UploadModel extends Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function save_img(){
//        db('image_list')->
    }

    public function save_img_info($post)
    {
//        extract($post);
//        $data = array(
//            "name" => empty($name) ? "" : $name,
//            "uid" => 20980,
//            "type" => empty($type) ? "" : $type,
//            "status" => "1",
//            "img_path" => empty($img_path) ? "" : $img_path,
//            "thumb_path" => empty($thumb_path) ? "" : $thumb_path,
//            "width" => empty($width) ? "" : $width,
//            "height" => empty($height) ? "" : $height,
//            "ext" => empty($ext) ? "" : $ext,
//            "hash" => empty($hash) ? "" : $hash,
//            "sha1" => empty($sha1) ? "" : $sha1,
//            "update_time" => time(),
//            "create_time" => time()
//        );
//
//        return db("image_list")->insertGetId($data);
        return db('image_list')->insertGetId($post);
    }
}