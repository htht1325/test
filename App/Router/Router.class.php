<?php

class Router{
    
    private static $moudle;
    private static $controller;
    private static $action;
    
    
    /**
     * 解析url，得到相应的参数
     */
    static function parseUrl(){


        
        $paramStr = $_SERVER['QUERY_STRING'];



        $paramArr = explode('&', $paramStr);


        
        if($paramStr!=''){
            
            foreach ($paramArr as $key => $value){
                
                $strArr = explode('=', $value);
                if(count($strArr)!=2){
                    
                }else{
                    switch ($strArr[0]){
                        case 'm':
                            self::$moudle = strtolower($strArr[1]);
                            break;
                        case 'c':
                            self::$controller = ucfirst($strArr[1]);
                            break;
                        case 'a':
                            self::$action = strtolower($strArr[1]);
                            break;
                        default:break;
                    }
                }
            }
            
            
        }else{



            $config = require_once APP_PATH.'config.php';
            
            self::$moudle = strtolower($config['default_moudle']);

            self::$controller = ucfirst('index');

            self::$action = strtolower('index');
             
        }
        
        self::transPage();
        
        
    }
    
    /**
     * 根据url解析的结果，调用相应控制器里的方法
     */
    static function transPage(){

        $config = require_once APP_PATH.'config.php';
        
        $moudle = self::$moudle==''?$config['default_moudle']:self::$moudle;define('MOUDLE', $moudle);define('CACHE_PATH', './'.MOUDLE.'/Cache/');
        $controller = self::$controller==''?'Index':self::$controller;define('CONTROLLER', $controller);
        $action = self::$action==''?'index':self::$action;define('ACTION', $action);
        
        $control = $controller.'Controller';
        $control = new $control;
        
        $control->$action();
        
        
        
    }
}