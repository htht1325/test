<?php

class BaseController{
    
    protected $bindVar;
    
    function __call($function_name,array $arguments){
        
        $this->error('调用了不存在的'.$function_name.'方法', '');
        
    }
    
    
    protected function success($msg,$jumpurl='',$time=3){
        
        $jumpurl = ($jumpurl==''?$_SERVER['HTTP_REFERER']:$jumpurl);
        
        $this->assign('info', $msg);
        $this->assign('time', $time);
        $this->assign('topinfo', '成功提示');
        $this->render(APP_PATH.'Templates/showinfo.php');
        header("refresh:{$time};url=$jumpurl");
        exit();
        
    }
    
    protected function error($msg,$jumpurl,$time=3){
        
        $jumpurl = ($jumpurl==''?$_SERVER['HTTP_REFERER']:$jumpurl);
        
        $this->assign('info', $msg);
        $this->assign('time', $time);
        $this->assign('topinfo', '错误提示');
        
        $this->render(APP_PATH.'Templates/showinfo.php');
        header("refresh:{$time};url=$jumpurl");
        exit();
    }
    
    protected function assign($name,$value){
        
        $this->bindVar[$name] = $value;
        
    }


    /**模板渲染函数
     * @param string $path  指定模板的路径
     * @param int $cachetime  缓存时间
     */
    
    protected function render($path='',$cachetime=0){
        
        if(!empty($this->bindVar)){
            foreach ($this->bindVar as $key => $value){
                $$key = $value;
            }
        }
        
        if(file_exists($path)){
            
            if($cachetime!=0){
                
                $key = md5(MOUDLE.CONTROLLER.ACTION);
                $cache = CacheFactory::getInstance('file');
                $cachefile = $cache->getValue($key);
                if($cachefile!=null){
                    
                    require_once CACHE_PATH.$cachefile;
                    
                }else{
                    
                    ob_end_clean();
                    
                    ob_start();
                    
                    require_once $path;
                    
                    $content = ob_get_contents();
                    
                    $cache->setValue($key,$content,$cachetime);
                    
                    ob_end_flush();
                }
                
            }else{
                
                require_once $path;
            }
            
        }else{
            
            if($cachetime!=0){
                
                $key = md5(MOUDLE.CONTROLLER.ACTION);
                $cache = CacheFactory::getInstance('file');
                $cachefile = $cache->getValue($key);
                if($cachefile!=null){
                    
                    require_once CACHE_PATH.$cachefile;
                    
                }else{
                    
                    ob_end_clean();
                    
                    ob_start();
                    
                    if(!file_exists(MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php'))
                    {
                        die(MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php'.'模板文件不存在!');
                    }
                    
                    require_once MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php';
                    
                    $content = ob_get_contents();
                    
                    $cache->setValue($key,$content,$cachetime);
                    
                    ob_end_flush();
                }
                
            }else{
                
                if(!file_exists(MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php'))
                {
                    die(MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php'.'模板文件不存在!');
                }
                
                require_once MOUDLE.'/View/'.CONTROLLER.'/'.ACTION.'.php';
            }
            
        }
        
        
    }

    /**
     * 以json格式返回消息
     * @param $msgArr
     *
     */
    protected function jsonMsg($msgArr){

        if(!is_array($msgArr)){

        }else{
            echo json_encode($msgArr);
        }

    }
    
    
    
}