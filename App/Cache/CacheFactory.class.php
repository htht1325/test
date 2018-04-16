<?php
class CacheFactory{
    private static  $cache;
    public static function getInstance($type){
        if(isset(self::$cache[$type]))
            return self::$cache[$type];
        else
        {
            if(file_exists(APP_PATH.'Cache/'.'Cache.'.$type.'.php')){
                require_once APP_PATH.'Cache/'.'Cache.'.$type.'.php';
                $cache_class = 'Cache_'.$type;
                self::$cache[$type] = new $cache_class;
                return self::$cache[$type];          
            }else{
                die(APP_PATH.'Cache/'.'Cache.'.$type.'.php'."不存在");
            }
        }
    }
}