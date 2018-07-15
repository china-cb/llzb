<?php
namespace app\lib;
class Getpoint
{
    public function get_point_url($Action,$SecretId,$secretKey){

        $Action = DescribeRecordPlayInfo;
        $SecretId =$SecretId;	//密钥Id 	AKIDz8krbsJ5yKBZQpn74WFkmLPx3gnPhESA
        $Timestamp = time();
        $Nonce = rand();	//随机正整数 	11886
        $Region = 'gz';	//实例所在区域 	gz
        $instanceIds = 'ins-09dx96dg';// 	待查询的实例ID 	ins-09dx96dg
        $offset = 0;	//偏移量 	0
        $limit =20 ;	//最大允许输出 	20


        $url = "Action=$Action&Nonce=$Nonce&Region=$Region&SecretId=$SecretId&Timestamp=$Timestamp&instanceIds.0=$instanceIds&limit=20&offset=0";


        $secretKey = 'lvOAIockE6N9IoiBiXjNLdDDWudpKBZO';//
        $srcStr = 'vod.api.qcloud.com/v2/index.php?'.$url;
        $signStr = base64_encode(hash_hmac('sha1', $srcStr, $secretKey, true));
        echo $signStr;



    }




}