<?php 
//入口文件

//检测PHP环境
if(version_compare(PHP_VERSION, '5.3.0', '<')) die('require PHP > 5.3.0!');

//定义应用文件夹
define('APP_DIR', './App/');

//引入Mvc 框架的入口文件
require './Mvc/Mvc.php';


