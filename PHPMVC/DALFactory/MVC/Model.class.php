<?php
namespace MVC;

class Model {
  public function __call($method, $args) {
    exit($method."方法不存在！");
  } 
}
