<?php 
//+--------------------------------------------------------------------
//|应用程序初始化
//|1.初始化应用目录
//|2.创建自动加载类
//|3.解析路由,设置$_GET, 定义Module,controller, action, 框架系统常量
//|4.创建控制器，进行操作
//+--------------------------------------------------------------------

namespace Mvc;

class App {
  private $module;        //模块
  private $controller;    //控制器
  private $action;         //操作

  /**
   *程序运行
   */
  public function run() {
    $app = new App();

    //检查是否创建应用,没有则创建
    $app->initApplication();
    
    //实现类的自动加载
    $app->autoload();

    //解析URL路由
    $app->parseUrl();

    //根据路由进行操作
    $app->routeAction();
  }

  /**
   *URL路由解析
   */
  private function parseUrl() {
    if(isset($_SERVER['PATH_INFO'])) {
      $pathinfo = $_SERVER['PATH_INFO'];
      $pathArr = explode("/",trim($pathinfo, '/.html'));
      $pramPos;
      if(!empty($pathArr[0]) && is_dir(APP_DIR.$pathArr[0])) {
        $this->module = $pathArr[0];
        $this->controller = !empty($pathArr[1])? $pathArr[1]."Controller" : "IndexController";
        $this->action = !empty($pathArr[2])? $pathArr[2] : "Index";
        $pramPos = 3;
      }
      else {
        $this->module = C("MODULE_DEFAULT");
        $this->controller = !empty($pathArr[0])? $pathArr[0]."Controller" : "IndexController";
        $this->action = !empty($pathArr[1])? $pathArr[1] : "Index";
        $pramPos = 2;
      }
      //解析参数,并设置$_GET 参数
      for($i = $pramPos; $i < count($pathArr); $i+=2) {
        $_GET[$pathArr[$i]] = !empty($pathArr[$i+1])? $pathArr[$i+1] : NULL;
      }
      
    } 
    else {
      $this->module = "Home";
      $this->controller = "IndexController";
      $this->action = "Index";
    }
    //声明Mvc框架系统常量
    define("MODULE_NAME", $this->module);
    define("CONTROLLER_NAME", $this->controller);
    define("ACTION_NAME", $this->action);
  }

  /**
   *自动加载类函数
   */
  private function autoload() {
    
    spl_autoload_register(function ($className) {
      echo $className;
      $className = ltrim($className, "\\");
      $file = '';
      $namespace = '';
      $class = '';
      if($pos = strrpos($className, "\\")) {
        $namespace = substr($className, 0, $pos);
        $class = substr($className, $pos + 1);
        if(substr($class, 0, 15) == "Smarty_Internal") {
          $class = "sysplugins/".strtolower($class);
          $file = str_replace("\\", DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
          $file .= $class.".php";   
        }
        else {
          $file = str_replace("\\", DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
          //$file .= str_replace("_", DIRECTORY_SEPARATOR, $class).".class.php";     //类名包含 “_”会被解析成目录，比如MyController_IndexController 会解析成MyController/IndexController
          $file .= $class.".class.php";   
        }
      }
      echo "<p>".$file."</p>";

      if(strpos($class, "Model") > 1) {
        include_once APP_DIR."/".$file;
      }
      else if(strpos($class, "Controller") > 1) {
       include_once APP_DIR."/".$file;
      }
      else {
        include_once "./Mvc/Lib/".$file;
      }
    });
  }

  /**
   *根据路由进行操作
   */
  private function routeAction() {
    $controllerClassName = "\\".$this->module."\\Controller\\".$this->controller;
    $action = $this->action;
    if(!class_exists($controllerClassName)) {
      exit($this->controller."控制器不存在！"); 
    }
    else {
      $controller = new $controllerClassName();
      if(!method_exists($controller, $action)) {
        exit($controllerClassName."控制器不存在操作".$action."!");
      }
      $controller->$action();
    }  
  }

  /**
   *初始化应用
   */
  private function initApplication() {
    $appDir = ltrim(APP_DIR, './');  //APP_DIR = ./AppName/ 这里使得 $appDir = AppName/

    if(is_dir(APP_DIR)) return ;    //应用存在直接返回不创建应用

    //应用不存在创建应用
    mkdir($appDir);

    (!is_dir($appDir."Common"))? mkdir($appDir."Common") : NULL;
    (!is_dir($appDir."Conf"))? mkdir($appDir."Conf") : NULL;
    (!is_dir($appDir."Runtime"))? mkdir($appDir."Runtime") : NULL;
    (!is_dir($appDir."Runtime/Cache"))? mkdir($appDir."Runtime/Cache") : NULL;
    (!is_dir($appDir."Runtime/Cache/Home"))? mkdir($appDir."Runtime/Cache/Home") : NULL;
    (!is_dir($appDir."Runtime/Compile"))? mkdir($appDir."Runtime/Compile") : NULL;
    (!is_dir($appDir."Runtime/Compile/Home"))? mkdir($appDir."Runtime/Compile/Home") : NULL;

    (!is_dir($appDir."Home"))? mkdir($appDir."Home") : NULL;
    (!is_dir($appDir."Home/Common"))? mkdir($appDir."Home/Common") : NULL;
    (!is_dir($appDir."Home/Conf"))? mkdir($appDir."Home/Conf") : NULL;
    (!is_dir($appDir."Home/Controller"))? mkdir($appDir."Home/Controller") : NULL;
    (!is_dir($appDir."Home/Model"))? mkdir($appDir."Home/Model") : NULL;
    (!is_dir($appDir."Home/View"))? mkdir($appDir."Home/View") : NULL;

    (!file_exists($appDir."Common/function.php"))? touch($appDir."Common/function.php") : NULL;
    (!file_exists($appDir."Conf/config.php"))? touch($appDir."Conf/config.php") : NULL;
    (!file_exists($appDir."Home/Common/function.php"))? touch($appDir."Home/Common/function.php") : NULL;
    (!file_exists($appDir."Home/Conf/config.php"))? touch($appDir."Home/Conf/config.php") : NULL;
    (!file_exists($appDir."Home/Controller/IndexController.class.php"))? touch($appDir."Home/Controller/IndexController.class.php") : NULL;
    
    $initIndexString = "<?php\n namespace Home\Controller;\nuse Mvc\\Controller;\nclass IndexController extends Controller {\n\tpublic function index() {\n\t\techo \"<p style='font-size:48px;'>Mvc works!</p>\";\n\t}\n}\n";
    file_put_contents($appDir."Home/Controller/IndexController.class.php", $initIndexString);

  }
}
