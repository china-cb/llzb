<?php
namespace app\admin\controller;

use think\Controller;
use think\Exception;
use think\Request;
Class Upload extends Controller{
    public function index(){
        return $this->fetch('upload/index');
    }
    public function getupload(Request $request){
        // 获取表单上传文件 例如上传了001.jpg
        $file = $request->file('image');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            echo $info->getExtension();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

    public function up(Request $request)
    {
        // 获取表单上传文件
        $file = $request->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if ($info) {
            $this->success('文件上传成功：' . $info->getRealPath());
        } else {
            // 上传失败获取错误信息
            $this->error($file->getError());
        }

    }
}