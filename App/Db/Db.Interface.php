<?php
    /**
     * 
     * @author Administrator
     *统一数据库接口函数，便于不同的数据库扩展
     */
    interface Db{
        /**
         * 单例方式返回数据库类实例
         */
        static function getInstance();
        /**
         * 数据库连接函数
         * @param unknown $dbConnStr
         */
        function connect($dbConnStr);
        /**
         * 执行查询语句
         * @param unknown $sqlStr
         */
        function query($sqlStr);
        /**
         * 返回指定的表字段
         * @param unknown $tableName
         */
        function getFields($tableName);
    }