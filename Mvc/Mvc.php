<?php

//Mvc框架入口文件

//引入框架系统函数
require_once "./Mvc/Common/function.php";

//引入应用启动类
require_once "./Mvc/Lib/Mvc/App.php";

//启动应用
\Mvc\App::run();


/*Mvc框架系统变量
  MODULE_NAME 模块名
  CONTROLLER_NAME 控制器名
  ACTION_NAME 操作名
 */

