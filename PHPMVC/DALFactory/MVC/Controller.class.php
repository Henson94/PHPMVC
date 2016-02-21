<?php
namespace MVC;
//+---------------------
//|控制器
//+---------------------
class Controller {

  public function __call($method, $args) {
    exit($method."方法不存在");
  }

}
