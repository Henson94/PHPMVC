<?php
namespace Lib\Controller;
use MVC\Model;
use MVC\Controller;
use MVC\A;

class IndexController extends Controller{
  public function index() {
    print_r(new A()); 
    echo "<div style='font-size:48px; font-weight:bolder;'>:)</div>MVC框架成功！";
  }
}
