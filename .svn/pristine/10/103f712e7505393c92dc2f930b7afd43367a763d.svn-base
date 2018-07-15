<?php
namespace app\admin\model;

use think\Model;
use think\Db;
Class BaseModel extends Model{

    public $timestamp;

    public function __construct()
    {
        $this->timestamp = time();
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function getInsert()
    {
        return $this->insert;
    }

    /**
     * 得到单个图片地址
     * @param $image_id
     * @return string
     */
    protected function get_one_image_src($image_id) {


        if(empty($image_id)) {

            return '';
        }

        $ImageList = db('image_list');
        $path_info = $ImageList->field('img_path')->where(array("id"=>$image_id))->find();


        $path = $path_info['img_path'] ? $path_info['img_path'] : '';

        return $path;
    }
}