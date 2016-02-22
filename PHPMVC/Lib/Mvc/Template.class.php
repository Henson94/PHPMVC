<?php
//+-------------------
//|模板类
//+-------------------
namespace Mvc;

class Template {
  private $var = array();  //注册的变量
  private $tplDoc = null;    //存放读取模板的内容
  private $tplFile = NULL;    //模板文件的文件名全名
  private $parFile = NULL;    //编译后的文件

  public function __construct() {
    //验证目录是否存在
    if(!is_dir(AppDir."/Lib/View/") || !is_dir(AppDir."/Runtime/Cache")) {
      exit("模板文件夹不存在或缓存文件夹不存在！");
    }
  }

  /**
   *@param string $varS
   *@param unknoe_type $value
   */
  public function assign($varS, $value) {
    if(isset($varS) && !empty($varS)) {
      $this->var[$varS] = $value;
    }
    else {
      exit("ERROR: 未设置模板变量！");
    }
  }

  /**
   *@param string $tplName
   */
  public function display($tplName) {
    $this->tplFile = AppDir."/Lib/View/".CONTROLLER_NAME.'/'.$tplName;  // 模板文件
    $this->parFile = AppDir."/Runtime/Cache/".md5($tplName).$tplName.'.php';    //编译后的文件
    if(!file_exists($this->tplFile)) {
      exit($tplName."模板文件不存在！");
    }
    //读取模板的内容到$tplDoc
    if(!$this->tplDoc = file_get_contents($this->tplFile)) {
      exit("ERROR:".$tplName."模板文件读取错误！");
    }
    //判断是否要重新编译
    if(!file_exists($this->parFile) || filemtime($this->parFile) < filemtime($this->tplFile)) {
      $this->compile();
    }
    include $this->parFile;
  }

  /**
   *编译模板文件
   *@param string $tplFile
   */
  public function compile() {
    //解析模板内容
    $this->compVar();

    if(!file_put_contents($this->parFile, $this->tplDoc)) {
      exit("ERROR:生成编译文件错误！");
    }

  }
  protected function compVar() {
    $patten = '/\{\$([\w]+)\}/';
    if(preg_match($patten, $this->tplDoc)) {
      $this->tplDoc = preg_replace($patten, "<?php echo @\$this->var['$1']?>", $this->tplDoc);
    }
  }

}
