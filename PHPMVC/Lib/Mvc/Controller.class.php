<?php
namespace Mvc;
//+---------------------
//|控制器
//+---------------------
class Controller{
  public $view = NULL;

  public function __construct() {
    $this->view = new \Mvc\Template();
    method_exists($this, 'initlize')? $this->initlize() : null;
  }

  public function assign($varS, $value) {
    $this->view->assign($varS, $value);
  }
  public function display($tplName) {
    $this->view->display($tplName);
  }

  public function __call($method, $args) {
    exit($method."方法不存在");
  }

}
