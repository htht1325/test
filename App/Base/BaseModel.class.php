<?php
/**
 * 模型基础类，封装和业务无关的数据库基础操作
 * @author Administrator
 *
 */
class BaseModel{
    
    private $db;
    private $tableName;
    
    /**
     * 初始化模型，进行数据库的连接，传入参数为子类名称，用于表名引用
     * @param string $classname
     */
    function __construct($classname=''){
        
        if(!file_exists(APP_PATH.'config.php')){
            
            die('没有找到配置文件!');
            
        }else{
            
            $dbArr = include APP_PATH.'config.php';
            
            $dbArr = $dbArr['db'];
            
            
            require_once APP_PATH.'Db'.'/Db.'.$dbArr['type'].'.class.php';
            
            $dbClass = 'Db_'.$dbArr['type'];
            
            $this->db = $dbClass::getInstance();
            
            $this->tableName = $dbArr['table_fix'].strtolower(str_replace('Model', '', $classname));//根据类名和规则获取表名
        }
    
    }
    
    
    /**
     * 基础操作，增加数据
     * @param array  $dataArr
     */
    public function insert($dataArr){
        if(!is_array($dataArr)){
            die('插入数据操作参数必须为数组!');
        }else{
            if(!$this->checkFields($dataArr)){
                die('插入数据中key值没有与字段相对应!');
            }else{
                if(isset($this->filterArray))
                    $this->filterFields($dataArr); //根据规则对输入字段进行检查
                $sql = $this->createInsertSql($dataArr);
                $result = $this->db->query($sql);
                return $result;
            }
        }
    }
    /**
     * 删除指定条件的记录
     * @param array $condition　条件数组
     */
    public function delete($condition){
        if(!is_array($condition)){
            die('参数必须是条件数组!');
        }else{
            $sql = $this->createDeleteSql($condition);
            
            $result = $this->db->query($sql);
            return $result;
        }
    }
    /**
     * 构建删除条件的sql语句
     * @param array $condition
     */
    protected function createDeleteSql($condition){
        $conditionStr = $this->createConditonStr($condition);
        return "DELETE FROM {$this->tableName} WHERE {$conditionStr}";
    }
    
    protected function createConditonStr($condition){
        $conditionStr = '';
        $tempstr='';
        foreach ($condition as $key => $value){
            if(isset($condition['logic'])){
                if($condition['logic']=='AND' && $key!='logic'){
                    $conditionStr.=$key."="."'".$value."'".' and ';
                }else if($condition['logic']=='OR' && $key!='logic'){
                    $conditionStr.=$key."="."'".$value."'".' or ';
                }else{
                    die('条件参数设置不正确!');
                }
            }else if(is_array($value)){
                foreach($value as $key2 =>$value2){
                    $tempstr.=("'".$value2."'".',');
                }
                $tempstr = rtrim($tempstr,',');
                $conditionStr = $key." in(".$tempstr.")";
            }else if(isset($condition['like'])){
                if($key!='like')
                $conditionStr.=$key." like "."'%".$value."%'".' and ';
            }
            
            else{
                $conditionStr.=$key."="."'".$value."'".' and ';
            }
        }
        if(isset($condition['logic']) && $condition['logic']=='OR'){
            $conditionStr = rtrim($conditionStr,' or ');
        }else{
            $conditionStr = rtrim($conditionStr,' and ');
        }
        
        return $conditionStr;
    }
    
    /**
     * 更新数据
     * @param array $dataArr
     * @param array $conditionArr
     */
    public function update($dataArr,$conditionArr){
        if(!is_array($dataArr) || !is_array($conditionArr)){
            die('更新函数参数必须是数组');
        }else{
            if(!$this->checkFields($dataArr)){
                die('插入数据中key值没有与字段相对应!');
            }else{
                if(isset($this->filterArray))
                    $this->filterFields($dataArr,'update'); //根据规则对输入字段进行检查
                    $sql = $this->createUpdateStr($dataArr, $conditionArr);
                    $result = $this->db->query($sql);
                    return $result;
            }
        }
        
    }
    
    
    
    public function select($conditionArr=array(),$pageArr=array(),$orderArr=array()){
        if(!is_array($conditionArr) || !is_array($pageArr) || !is_array($orderArr)){
            die('选择操作参数必须为数组');
        }else{
            $conditionStr = !empty($conditionArr)?$this->createConditonStr($conditionArr):'';
            $pageStr = !empty($pageArr)?$this->createPageStr($pageArr):'';
            $orderStr = !empty($orderArr)?$this->createOrderStr($orderArr):'';
            $fields = $this->db->getFields($this->tableName);
            $fieldsStr = '';
            foreach ($fields as $key=>$value){
                $fieldsStr.=$this->tableName.'.'.$value.",";
            }
            $fieldsStr = rtrim($fieldsStr,",");
            
            $sql = "SELECT {$fieldsStr} FROM {$this->tableName} WHERE {$conditionStr} {$orderStr} {$pageStr} ";
            if($conditionStr=='')
                $sql = "SELECT {$fieldsStr} FROM {$this->tableName} {$orderStr} {$pageStr} ";
            
           
            
            /**
             * 这里可以加入memcache或者redis等缓存进行查询结果的缓存
             
            
            $key = md5($sql);
            $memcache = CacheFactory::getInstance('memcache');
            if($memcache->getStatus()){
                
                if($memcache->getValue($key)){
                    return $memcache->getValue($key);
                }else{
                    $result = $this->db->query($sql);
                    $memcache->setValue($key,$result,60);
                    return $result;
                }
            }else{
                
                $result = $this->db->query($sql);
                 return $result;
            }
            */
            
            $result = $this->db->query($sql);
            return $result;
        }
    }
    /**
     * 创建分页的语句
     * @param array $pageArr array('page'=>1,'num'=>10)
     */
    protected function createPageStr($pageArr){
        $pageStr = '';
        $pageNum = isset($pageArr['page'])?$pageArr['page']:1;
        $recordNum = isset($pageArr['num'])?$pageArr['num']:10;
        $index = ($pageNum-1)*$recordNum;
        $pageStr = "LIMIT {$index},{$recordNum}";
        return $pageStr;
    }
    /**
     * 生成排序语句
     * @param unknown $orderArr array("key"=>id,"set"=>"DESC")
     * @return string
     */
    protected function createOrderStr($orderArr){
        $orderStr = '';
        if(!isset($orderArr['set'])) $orderArr['set'] = 'DESC';
        $orderStr = "ORDER BY {$orderArr['key']} {$orderArr['set']}";
        return $orderStr;
    }
    /**
     * 构建更新的sql语句，指定条件
     * @param array $dataArr
     * @param array $condition
     */
    protected function createUpdateStr($dataArr,$condition){
        $conditionStr = $this->createConditonStr($condition);
        $gpc = get_magic_quotes_gpc();
        $updateStr = '';
        foreach($dataArr as $key=>$value){
            $value = !$gpc?addslashes($value):$value;
            $updateStr.="`".$key."`"."="."'".$value."',";
        }
        $updateStr = rtrim($updateStr,",");
        $sql = "UPDATE {$this->tableName} SET {$updateStr} WHERE {$conditionStr}";
        return $sql;
    }
    /**
     * 输入数据进行规则检查
     * @param  array $dataArr
     */
    protected function filterFields($dataArr,$type='add'){
        foreach ($this->filterArray as $key=>$value){
            
            if($type=='add'){
                if(strpos($value,'require')!==false){
                    if(!array_key_exists($key, $dataArr) || $dataArr[$key]==''){
                        die("必须输入的字段{$key}没有输入!");
                    }
                }
            }
            
            if(strpos($value,'email')!==false && isset($dataArr[$key])){
                
                if(!checkEmail($dataArr[$key])){
                    echo json_encode(array('status'=>false,'msg'=>'邮箱格式不正确!'));
                    die();
                }
            }
            if(strpos($value,'mobile')!==false && isset($dataArr[$key])){
                if(!checkMobile($dataArr[$key])){
                    echo json_encode(array('status'=>false,'msg'=>'手机号码格式不正确!'));
                    die();
                }
            }
        }
    }
    /**
     * 构建插入条件的sql语句
     * @param array $dataArr
     */
    protected  function createInsertSql(array $dataArr){
        $insertKeyStr = '';
        $insertValueStr = '';
        foreach ($dataArr as $key=>$value){
            $insertKeyStr.="`".$key."`".",";
            if(!get_magic_quotes_gpc()) //检查默认的转义功能是否开启
                $insertValueStr.="'".addslashes($value)."',";
            else 
                $insertValueStr.="'".$value."',";
        }
        $insertKeyStr = rtrim($insertKeyStr,',');
        $insertValueStr = rtrim($insertValueStr,',');
        $sqlStr = "INSERT INTO {$this->tableName} ({$insertKeyStr}) VALUES ({$insertValueStr})";
        return $sqlStr;
    }
    /**
     * 判断插入数据中的key值是否和数据表中的字段一致
     * @param unknown $dataArr
     */
    protected function checkFields($dataArr){
        $fieldsStr = json_encode($this->db->getFields($this->tableName));
        foreach ($dataArr as $key=>$value){
            if(strpos($fieldsStr, $key)===false){
                return false;
            }
        }
        return true;
    }
    
}