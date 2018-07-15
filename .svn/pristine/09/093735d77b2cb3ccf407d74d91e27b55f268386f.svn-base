<?php
/**
 * Created by PhpStorm.
 * User: 冯天元
 * Date: 2017/1/19
 * Time: 11:17
 */

namespace app\lib;


use think\Controller;

class PhpExcel extends Controller
{
    public function __construct()
    {

        /*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
//        import("extend.PHPExcel", null, '.php');
//        include_once('./extend/PHPExcel.php');
    }

    /* 导出excel函数*/
    public function push($data, $name = 'Excel')
    {

        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        $objPHPExcel = new \PHPExcel();

        /*以下是一些设置 ，什么作者  标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("转弯的阳光")
            ->setLastModifiedBy("转弯的阳光")
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','用户昵称')
            ->setCellValue('B1','地址')
            ->setCellValue('C1','观看时长')
            ->setCellValue('D1','手机号')
            ->setCellValue('E1','访问次数')
            ->setCellValue('F1','聊天数')
            ->setCellValue('G1','首次登录时间')
            ->setCellValue('H1','最后在线时间')
            ->setCellValue('I1','最后登录设备')
            ->setCellValue('J1','最后登录方式');
        foreach ($data as $k => $v) {

            $num = $k + 2;
            $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A' . $num, !empty($v['nick_name'])?$v['nick_name']:"匿名用户")
                ->setCellValue('B' . $num, !empty($v['address'])?$v['address']:"未知地区")
                ->setCellValue('C' . $num, $v['watch_count'].' min')
                ->setCellValue('D' . $num, !empty($v['phone'])?$v['phone']:"--")
                ->setCellValue('E' . $num, $v['visit_count'])
                ->setCellValue('F' . $num, $v['chat_count'])
                ->setCellValue('G' . $num, $v['create_time'])
                ->setCellValue('H' . $num, !empty($v['end_time'])?$v['end_time']:'--')
                ->setCellValue('I' . $num, $v['last_login_device'])
                ->setCellValue('J' . $num, $v['last_login_type']);
            }

        $objPHPExcel->getActiveSheet()->setTitle('User');
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}