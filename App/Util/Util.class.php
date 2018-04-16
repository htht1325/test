<?php

class Util{
    
    static function checkEmail(){
        
        echo 'fuck!';
    }
    
    /**
     * 环境检测，包括服务器软件版本和目录读写权限
     */
    static function checkEnv(){
        
        $phpVersion = phpversion();
        $mainVersion = substr($phpVersion, 0,1);
        $subVersion = substr($phpVersion, 2,1);
        
        if(!($mainVersion>=5 && $subVersion>=3)){
            
            die('php版本号过低！请升级php环境！');
            
        }
        if(!file_exists("install.lock")){

            if(!is_writable('.')){

                die('当前目录没有写入权限!请设置目录权限!');

            }else{
                if(defined('HOME_PATH')){

                    self::createDir(HOME_PATH);

                    if(!file_exists("install.lock")){

                        $fh = fopen("install.lock", 'a');
                        fwrite($fh,"install");
                        fclose($fh);
                    }
                }

                else
                    die('未定义HOME模块目录!');
            }

        }


        
    }
    
    /**
     * 自动创建项目文件夹
     * @param unknown $dir
     */
    private static function createDir($dir){
        
        if(!is_dir($dir)){
            
            mkdir($dir);
            chmod($dir,0777);
           
        }
        
        if(!is_dir($dir.'Controller')){
            
            mkdir($dir.'Controller');
            chmod($dir.'Controller',0777);


        }
        
        if(!is_dir($dir.'Model')){
            
            mkdir($dir.'Model');
            chmod($dir.'Model',0777);
           
            
            
        }
        
        if(!is_dir($dir.'View')){
            
            mkdir($dir.'View');
            chmod($dir.'View',0777);
            
           
            
        }
        
        if(!is_dir($dir.'Cache')){
            
            mkdir($dir.'Cache');
            chmod($dir.'Cache',0777);
            
        }
        
        if(!is_dir($dir.'Log')){
            
            mkdir($dir.'Log');
            chmod($dir.'Log',0777);
           
            
            
        }
        
        if(!is_dir($dir.'Public')){
            
            mkdir($dir.'Public');
            chmod($dir.'Public',0777);
           
            
        }
        
    }
    
}