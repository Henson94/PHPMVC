<?php
namespace Lib\Controller;
use Mvc\Controller;

class IndexController extends Controller{
  public function index() {
   // echo "<div style='font-size:48px; font-weight:bolder;'>:)</div>MVC框架成功！";
    $this->assign('name','Henson');
    $this->assign('age', '23');
    $this->age = "23";
   $this->display('index.html');
  }
}
