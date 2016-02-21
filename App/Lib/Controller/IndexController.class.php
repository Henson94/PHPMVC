<?php
namespace Lib\Controller;
use Mvc\Controller;

class IndexController extends Controller{
  public function index() {
    echo "<div style='font-size:48px; font-weight:bolder;'>:)</div>MVC框架成功！";
  }
}
