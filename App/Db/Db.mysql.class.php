<?php
require_once 'Db.Interface.php';
class Db_mysql implements Db{
    
    private static $db;
    private $conn;
    private function __construct(){
        if(!file_exists(APP_PATH.'config.php')){
            die('没有找到配置文件!');
        }else{
            
            $dbConfigArr = include APP_PATH.'config.php';
            
            if($dbConfigArr['db']!=''){
                $this->connect($dbConfigArr['db']);
            }else{
                die('没有mysql数据库配置信息!');
            }
            
        }
    }
    
    function __destruct(){
        mysql_close($this->conn);
    }
    
    /**
     * 采用单例模式返回唯一的数据库类实例
     */
    public static function getInstance(){
        if(self::$db==null){
            self::$db = new Db_mysql();
            return self::$db;
        }else{
            return self::$db;
        }
    }
    
   
    public  function connect($connStrArr) {
        $this->conn = mysql_connect($connStrArr['host'],$connStrArr['user'],$connStrArr['pwd']) or
        die('mysql数据库连接失败!请检查相关的配置参数!'.__LINE__);
        mysql_query("set names 'utf8'");
        mysql_select_db($connStrArr['dbname']);
    }
    
    /**
     * 执行查询操作
     * @see Db::query()
     */
    public function query($sqlStr) {
            
            if(strpos($sqlStr,"SELECT")!==false){ 
                $result = mysql_query($sqlStr,$this->conn);
                if(!$result) die("执行查询语句出错!".__LINE__);
                $dataArr = array();
                while($row = mysql_fetch_assoc($result)){
                    array_push($dataArr, $row);
                }
                return $dataArr;
            }else{
                $result = mysql_query($sqlStr,$this->conn);
                if(!$result) die("执行查询语句出错!".__LINE__);
                if($result){
                    return mysql_affected_rows();
                }else{
                    return 0;
                }
            }         
    }
    /**
     * 获取指定数据表的字段
     * @see Db::getFields()
     */
    function getFields($tableName){
        $sql = 'SELECT *FROM '.$tableName;
        $result = mysql_query($sql);
        $filedArr = array();
        for($i=0;$i<mysql_num_fields($result);$i++){
            $filedName = mysql_field_name($result, $i);
            array_push($filedArr, $filedName);
        }
        return $filedArr;
    }
}