<?php
namespace Htai\Controller;
use Think\Controller;
use Think\Template;
class IndexController extends Controller {
    public function index()
    {

        $userInfo = getUserInfo();

        // 或者批量赋值
        $this->assign([
            'userInfo'  => $userInfo,
            'email' => 'thinkphp@qq.com'
        ]);

        // 模板输出
        $this->display();
    }

    public function welcome()
    {
        //备份数据
        $userInfo = getUserInfo();
        if ($userInfo['id'] == 1) {
            $this->makeBackupSql();
        }

        // 或者批量赋值
        $this->assign([
            'userInfo'  => $userInfo,
            'email' => 'thinkphp@qq.com'
        ]);

        // 模板输出
        $this->display();
    }

    /**
     * 导出数据库备份
     */
    public function makeBackupSql() {
        header("Content-type:text/html;charset=utf-8");
        $path = $_SERVER['DOCUMENT_ROOT']; // 存储位置
        // 检查文件是否存在
        $fileName = C('db_name').'-'.date("Y-m-d",time()).'.sql';
        $fullPath = $path . '/' . $fileName;
        if(file_exists($fullPath)){
            //echo "数据备份文件已存在！";
           return;
        }

        $model = M();
        //查询所有表
        $sql="show tables";
        $result=$model->query($sql);

        $info = "-- ----------------------------\r\n";
        $info .= "-- 日期：".date("Y-m-d H:i:s",time())."\r\n";
        $info .= "-- MySQL - 5.6 : Database - ".C('db_name')."\r\n";
        $info .= "-- ----------------------------\r\n\r\n";
        $info .= "CREATE DATAbase IF NOT EXISTS `".C('db_name')."` DEFAULT CHARACTER SET utf8 ;\r\n\r\n";
        $info .= "USE `".C('db_name')."`;\r\n\r\n";
        // 检查目录是否存在
        if(is_dir($path)){
            //echo '目录存在';
            // 检查目录是否可写
            if(is_writable($path)){
                //echo '目录可写';exit;
            } else {
                echo '目录不可写';exit;
                //chmod($path,0777);
            }
        } else {
            //echo '目录不存在';exit;
            // 新建目录
            mkdir($path, 0777, true);
            //chmod($path,0777);
        }

        file_put_contents($fullPath, $info, FILE_APPEND);

        foreach ($result as $k => $v) {
            //查询表结构
            $val = $v['Tables_in_' . C('db_name')];
            $sql_table = "show create table ".$val;
            $res = $model->query($sql_table);
            //print_r($res);exit;
            $info_table = "-- ----------------------------\r\n";
            $info_table .= "-- Table structure for `".$val."`\r\n";
            $info_table .= "-- ----------------------------\r\n\r\n";
            $info_table .= "DROP TABLE IF EXISTS `".$val."`;\r\n\r\n";
            $info_table .= $res[0]['Create Table'].";\r\n\r\n";
            //查询表数据
            $info_table .= "-- ----------------------------\r\n";
            $info_table .= "-- Data for the table `".$val."`\r\n";
            $info_table .= "-- ----------------------------\r\n\r\n";

            file_put_contents($fullPath, $info_table, FILE_APPEND);

            $sql_data = "select * from " . $val;
            $data = $model->query($sql_data);
            //print_r($data);exit;
            $count = count($data);
            //print_r($count);exit;
            if($count<1) continue;

            foreach ($data as $key => $value){
                $sqlStr = "INSERT INTO `". $val ."` VALUES (";
                foreach($value as $v_d){
                    $v_d = str_replace("'","\'",$v_d);
                    $sqlStr .= "'".$v_d."', ";
                }
                //需要特别注意对数据的单引号进行转义处理
                //去掉最后一个逗号和空格
                $sqlStr = substr($sqlStr,0,strlen($sqlStr)-2);
                $sqlStr .= ");\r\n";
                file_put_contents($fullPath, $sqlStr, FILE_APPEND);
            }
            $info = "\r\n";
            file_put_contents($fullPath, $info, FILE_APPEND);
        }
    }

    public function downloadSql() {
        $path = $_SERVER['DOCUMENT_ROOT']; // 存储位置
        // 检查文件是否存在
        $fileName = C('db_name').'-'.date("Y-m-d",time()).'.sql';
        $fullPath = $path . '/' . $fileName;

        //以只读和二进制模式打开文件
        $file = fopen ($fullPath, "rb" );

        //告诉浏览器这是一个文件流格式的文件
        Header ( "Content-type: application/octet-stream" );

        //请求范围的度量单位
        Header ( "Accept-Ranges: bytes" );

        //Content-Length是指定包含于请求或响应中数据的字节长度
        Header ( "Accept-Length: " . filesize ( $fullPath ) );

        //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$fileName该变量的值。
        Header ( "Content-Disposition: attachment; filename=" . $fileName );

        //读取文件内容并直接输出到浏览器
        echo fread ( $file, filesize ( $fullPath ) );

        fclose ( $file );
    }
}
