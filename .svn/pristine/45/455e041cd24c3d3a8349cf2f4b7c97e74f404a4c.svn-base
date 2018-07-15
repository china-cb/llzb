<?php
namespace app\core\model;

require_once APP_PATH.'lib/qcloudapi/src/QcloudApi/QcloudApi.php';


class Qcloudapi
{
    private $config ='';
    private $private_pem_path ='';
    private $admin_user_sig ='';
    private $api ='';

    public function __construct(){
        $this->config = array(
            'SecretId' => config('CONFIG_CLOUND_SECRETID'),
            'SecretKey' => config('CONFIG_CLOUND_SECRET_KEY'),
            'RequestMethod'  => 'GET',
            'DefaultRegion'  => 'gz',
        );


    }

    /** 通过视频文件名称获取视频播放信息 包括多 个  或 1个id和播放url  可能有多个 */
    public function DescribeVodPlayInfo($fileName){
        log_w($fileName.'请求异步转码开始 文件名 获取 1或多个ids');
        $action = 'DescribeVodPlayInfo';
        $package =array(
            'fileName'=>$fileName,
        );
        $rq = $this->common($action,$package,$module='vod');
        if(isset($rq['codeDesc'])&& $rq['codeDesc'] =='Success'){
            return $rq;//是个

/*           $rq= {
              "code": 0,
              "message": "",
              "codeDesc": "Success",
              "totalCount": "1",
              "fileSet": [
                {
                    "fileId": "14651978969409866913",
                  "fileName": "liveId_4097_1478096982954_2016-11-02-22-29-42_2016-11-02-22-29-59",
                  "duration": 14,
                  "status": "2",
                  "image_url": "http://p.qpic.cn/videoyun/0/200016371_b8d71adcf1bf4ab2a54d4b03ae0d75b8_1/640",
                  "playSet": [
                    {
                        "url": "http://200016371.vod.myqcloud.com/200016371_b8d71adcf1bf4ab2a54d4b03ae0d75b8.f0.mp4",
                      "definition": 0,// 0源码
                      "vbitrate": 0,
                      "vheight": 0,
                      "vwidth": 0
                    }
                  ]
                }
              ]
            }*/
        }else{
            log_w('error :DescribeVodPlayInfo输入'.$fileName.'获取ids出现错误');
        }

    }

    /**
     * 获取视频详细信息
     * @param $fileId
     */
    public function DescribeVodPlayUrls($fileId){
        $action = 'DescribeVodPlayUrls';
        $package =array(
            'fileId'=>$fileId,
        );
        $rq = $this->common($action,$package,$module='vod');
        if(isset($rq['codeDesc'])&& $rq['codeDesc'] =='Success');
        //status  -1：未上传完成，不存在；0：初始化，暂未使用；1：审核不通过，暂未使用；2：正常；3：暂停；4：转码中；5：发布中；6：删除中；7：转码失败；10：等待转码；100：已删除
        if($rq) exit_json(0,'...',$rq);
    }

    /**
     * 获取视频列表信息（暂时不支持批量）
     *  param  $fileId
     */
    public function DescribeVodInfo($package){
        $action = 'DescribeVodInfo';
        $package =array(

        );
        $rq = $this->common($action,$package,$module='vod');
        if(isset($rq['codeDesc'])&& $rq['codeDesc'] =='Success');

        //status  -1：未上传完成，不存在；0：初始化，暂未使用；1：审核不通过，暂未使用；2：正常；3：暂停；4：转码中；5：发布中；6：删除中；7：转码失败；10：等待转码；100：已删除
        if($rq) exit_json(0,'...',$rq);
    }
    /**
     * 对点播入库视频进行转码
     */
    public function ConvertVodFile($fileId,$notifyUrl){
        $action = 'ConvertVodFile';
        $package = array(
            'fileId'=>$fileId,
            'notifyUrl'=>$notifyUrl,
        );

        $rq = $this->common($action,$package,$module='vod');
        if(isset($rq['codeDesc'])&& $rq['codeDesc'] =='Success'){
            log_w('fileid:'.$fileId.'请求转码成功;发送的回调地址：'.$notifyUrl);
            return true;
        }


    }
    /** 通用接口 */
    private function common($action = 'DescribeInstances',$package = array('offset' => 0, 'limit' => 10),$module){
        switch($module){
            case 'vod':
                $cvm = \QcloudApi::load(\QcloudApi::MODULE_VOD, $this->config);
                break;
            case 'market':
                $cvm = \QcloudApi::load(\QcloudApi::MODULE_MARKET, $this->config);
                break;
        }

        //$package = array('offset' => 0, 'limit' => 3);
        $a = $cvm->$action($package);
//       $a = $cvm->generateUrl($action, $package);
//        var_dump($a);
//die();
        if ($a === false) {
            $error = $cvm->getError();
            $ext = var_export($error->getExt(), true);
            log_w("Error code:" . $error->getCode() . "message:" . $error->getMessage() . "ext:" .$ext  );
            exit_json(119,'异步请求腾讯云出错：'.$error->getMessage());
        } else {
            return $a;
        }

    }


}