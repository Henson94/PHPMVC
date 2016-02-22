<?php
//+-----------------
//|应用程序初始化
//|加载必要的数据
//+-----------------
namespace Mvc;

class App {
  protected $controller;
  protected $model;
  /**
   * 初始化环境变量
   */
  static public function Run() {
    $app = new App();
    $app->initAppDir();
    $app->AutoLoadFun();
    $app->NavUrl();
  }
  /**
   *自动载入自定义函数库
   */
  private function AutoLoadFun() {
    if(file_exists(AppDir."/Common/function.php")) {
      include_once AppDir."/Common/function.php";
    }
  }

  /**
   *页面导航模型
   */
  private function NavUrl() {
    $controller = NULL;
    $model = NULL;
    if(!empty($_SERVER['PATH_INFO'])) {
      //PATH_INFO 模式
      $parray = $_SERVER['PATH_INFO'];
      $cm = explode('/', trim($parray, '\/'));
      $controller = ucfirst(empty($cm[0])? "Index" : $cm[0])."Controller";
      $model = ucfirst(empty($cm[1])? "Index" : $cm[1]);
    }
    else {
      //普通模式
      $controller = isset($_GET['m'])? ucfirst($_GET['m'])."Controller" : "IndexController";
      $model = isset($_GET['a'])?ucfirst($_GET['a']) : "Index" ;
    }
    //判断控制器是否存在
    $nSController = "\\Lib\\Controller\\".$controller;
    if(@!class_exists($nSController)) {
      exit($controller."控制器不存在！");
    }
    $this->controller = $nSController;
    $this->model = $model;

    //声明系统变量 控制器名，操作名
    define("CONTROLLER_NAME", str_replace('Controller', '', $controller));
    define("ACTION_NAME", $model);

    //打开控制器
    $controllerClass = new $nSController();
    //执行操作
    $controllerClass->$model();
  }

  /**
   *初始化项目目录
   */
  public function initAppDir() {
    if(!is_dir(AppDir)) {
      mkdir(AppDir);
      touch(AppDir."/index.html");
      
      mkdir(AppDir."/Lib");
      touch(AppDir."/Lib/index.html");
      
      mkdir(AppDir."/Lib/Controller");
      touch(AppDir."/Lib/Controller/index.html");
      touch(AppDir."/Lib/Controller/IndexController.class.php");

      mkdir(AppDir."/Lib/Model");
      touch(AppDir."/Lib/Model/index.html");

      mkdir(AppDir."Lib/View");
      touch(AppDir."Lib/View/index.html");
    }
  }

}

