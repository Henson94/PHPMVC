<?php
namespace Lib\Controller;
use Mvc\Controller;

class IndexController extends Controller{

  public function index() {
    echo "<div style='font-size:48px; font-weight:bolder;'>:)</div>MVC框架成功！";
    //$this->assign('name','Henson');
    //$this->assign('age', '23');
    //$this->age = "23";
    //$this->display('index.html');
    $data['username'] = 'hensonabc';
    $data['password'] = 'nsonheabc';
    $user = M('user');
    var_dump($user->where('id > 0')->find());
    echo $user->getLastSql();
   // var_dump(M('user')->where('id=1')->create());
  }
}
