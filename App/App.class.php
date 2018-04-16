<?php
/**
 * 框架核心类，负责整个框架的流程控制
 * @author heting 2018
 *
 */
class App{
    
    static function Run(){
        
        
        Util::checkEnv();// 环境检测并创建项目目录
        Router::parseUrl();//url解析
        
        
    }
}