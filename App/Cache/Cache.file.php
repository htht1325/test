<?php
include_once 'Cache.Interface.php';

/**
 * 文件缓存实现类
 * @author Administrator
 *
 */
class Cache_file implements Cache{
    
    public function getValue($key) {
        
        
        $cachefile = array();
        $allcachefiles = array();
        $dir = CACHE_PATH;
        $files = read_all_dir($dir);
        
        if(!empty($files)){
            
            foreach ($files['file'] as $key2=>$value){
            
                if(strpos($value, $key)!==false){
            
                    $cachefile['file'] = $value;
                    $tempStr = explode('.', $value);
                    $tempStr2=explode('_', $tempStr[0]);
                    $cachefile['time'] = $tempStr2[1];
                }else{
                    $allcachefiles['file'][] = $value;
                }
                
                
            }
            if(!empty($allcachefiles['file'])){
                foreach ($allcachefiles['file'] as $key3 =>$value3){
                    $tempfile = $value3;
                    $tempArr = explode('.', $tempfile);
                    $tempArr2 = explode('_', $tempArr[0]);
                    $tempfiletime = $tempArr2[1];
                    if(time()-filectime(CACHE_PATH.$tempfile)>$tempfiletime){
                        unlink(CACHE_PATH.$tempfile);
                    }
                }
            }
          
            
            
            
            
        }
        
        if(!empty($cachefile)){
            
            $nowtime = time();
            
            $filecratetime = filectime(CACHE_PATH.$cachefile['file']);
            
            if($nowtime-$filecratetime > $cachefile['time']){
                unlink(CACHE_PATH.$cachefile['file']);
                return null;
            }else{
                return $cachefile['file'];
            }
        }else{
            return null;
        }
        
    }
    
    
    
    public function setValue($key, $value, $expiretime){
        
        $filename = $key.'_'.$expiretime.'.cache';
        
        $filepath = CACHE_PATH.$filename;
        
        if(file_exists($filepath)) unlink($filepath);
         
            $fh = fopen($filepath, 'a');
            
            if($fh){
                
                fwrite($fh, $value);
                
                fclose($fh);
                
            }else{
                
                die('打开或创建文件失败!');
                
            }      
    }
    
    public function deleteValue($key) {
        $dir = CACHE_PATH;
        $files = read_all_dir($dir);
        if(!empty($files)){
            foreach ($files['file'] as $filekey=>$value){
            if(strpos($value, $key)!==false){
                $tempFile = CACHE_PATH.$value;
                unlink($tempFile);
            }
        }
        }
        
    }
    
    public function clearCache() {
        $dir = CACHE_PATH;
        $files = read_all_dir($dir);
        if(!empty($files)){
            foreach ($files['file'] as $filekey=>$value){
                $tempFile = CACHE_PATH.$value;
                unlink($tempFile);
            }
            
        }
    }
}