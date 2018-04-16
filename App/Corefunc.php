<?php

/**
 * 自动加载类文件函数
 */
spl_autoload_register(function($className){
    
    if(file_exists(APP_PATH.$className.'.class.php')){
        
        require_once $className.'.class.php';
    
    }else{
        
        $dir_sub = getSubDir(APP_PATH);
        
        
        if($dir_sub){
            
            foreach ($dir_sub as $key=>$path){
                
                
                if(file_exists($path.'/'.$className.'.class.php')){
                    
                    require_once $path.'/'.$className.'.class.php';
                }
                
            }
            
           
        }
        
        if(defined('MOUDLE')){
            
            if(!is_dir(MOUDLE))
                die('没有创建'.MOUDLE.'模块目录');
            
           if(strpos($className, 'Controller')!==false && !class_exists($className)){
               
               if(file_exists('./'.MOUDLE.'/Controller/'.ucfirst($className).'.class.php')){
                require_once './'.MOUDLE.'/Controller/'.ucfirst($className).'.class.php';
            }else{
                die(ucfirst($className).'.class.php 不存在!');
            }
            
           }
           
           if(strpos($className, 'Model')!==false && !class_exists($className)){
               
               if(file_exists('./'.MOUDLE.'/Model/'.ucfirst($className).'.class.php')){
                   require_once './'.MOUDLE.'/Model/'.ucfirst($className).'.class.php';
               }else{
                   die(ucfirst($className).'.class.php 不存在!');
               }
           }
               
        }
        
        
    }
   
    
});

/**
 * 返回指定目录下的子目录
 * @param 指定的目录名
 * @return 子目录的数组
 */
function getSubDir($dirName){
    
    $files = array();
    $dir_list = scandir($dirName);
    foreach($dir_list as $file){
        if($file!='.' && $file!='..'){
            if(is_dir($dirName.'/'.$file)){
                $files[] = $dirName.$file;
            }
        }
    }
    return $files;
    
}


function read_all_dir($dir){
    $result = array();
    $handle = opendir($dir);
    if($handle){
        while(($file = readdir($handle))!==false){
            if($file!='.' && $file!='..'){
                $cur_path = $file;
                if(is_dir($cur_path)){
                    $result['dir'][$cur_path] = read_all_dir($cur_path);
                }else{
                    $result['file'][] = $cur_path;
                }
            }
        }
    }
    return $result;
}

/**语言函数
 * @param $str 字符串
 */
function L($str){

    static $lanArr;

    if($lanArr==''){

        $config = include APP_PATH."config.php";

        $lanfile = '';

        if($config[MOUDLE.'_lan']){

            $lanfile = APP_PATH."language/".$config[MOUDLE.'_lan'];

        }else{

            $lanfile = APP_PATH."language/".MOUDLE."-lan.php";
        }



        if(!file_exists($lanfile)){

            die('没有找到语言文件!');
        }

        $lanArr = require_once $lanfile;
        if($lanArr[$str]){
            echo $lanArr[$str];
        }else{
            echo '';
        }


    }else{

        if($lanArr[$str]){
            echo $lanArr[$str];
        }else{
            echo '';
        }
    }








}


function D($timestr){


}