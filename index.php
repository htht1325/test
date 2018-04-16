<?php
/**
 * 入口文件,引入核心文件
 */
	define('APP_PATH','./App/');
	define('HOME_PATH', './admin/');
	require_once(APP_PATH.'Corefunc.php');
	App::run();
