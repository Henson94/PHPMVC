<?php 
//+-------------------------
//|控制器类
//+-------------------------

namespace Mvc;

class Controller {
  
  public $smarty;

  public function __construct() {
    $this->initSmarty(); 
  }

  /**
   *引入smarty 模板引擎，并初始化
   */
  public function initSmarty() {
    include_once "./Mvc/Lib/Vendor/Smarty/Smarty.class.php";
    $this->smarty = new \Vendor\Smarty\Smarty();
    $appDir = ltrim(APP_DIR, './');
    (!is_dir($appDir."Runtime/Compile".MODULE_NAME))? mkdir($appDir."Runtime/Compile".MODULE_NAME) : NULL;
    (!is_dir($appDir."Runtime/Cache".MODULE_NAME))? mkdir($appDir."Runtime/Cache".MODULE_NAME) : NULL;

    $this->smarty->template_dir = APP_DIR.MODULE_NAME."/View/".CONTROLLER_NAME."/";
    $this->smarty->compile_dir = APP_DIR."Runtime/Compile/".MODULE_NAME."/";
    $this->smarty->cache_dir = APP_DIR."Runtime/Cache/".MODULE_NAME."/";
    $this->smarty->left_delimiter = "{";
    $this->smarty->right_delimiter = "}";

  }
  public function display($tpl) {
    $this->smarty->display($tpl);
  }
  public function assign($key, $value) {
    $this->smarty->assign($key, $value);
  }

  public function __call($method, $args) {
    exit($method."方法不存在！");
  }

}
