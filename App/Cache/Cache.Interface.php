<?php
interface Cache{
    
    /**
     * 获取指定key值的缓存值
     * @param unknown $key
     */
    function getValue($key);
    
    /**
     * 
     * @param unknown $key        索引
     * @param unknown $value      值
     * @param unknown $expiretime 缓存时间
     */
    function setValue($key,$value,$expiretime);
    
    /**
     * 删除指定Key的缓存
     * @param unknown $key
     */
    function deleteValue($key);
    
    /**
     * 删除所有缓存数据
     */
    function clearCache();
    
    
}