<?php
//+----------------
//|自动加载类文件
//+----------------

function __autoload($className) {
  //echo '《'.$className.'》';

  $className = ltrim($className,"\\");
  $fileName = '';
  $namespace = '';

  if($lastNsPos = strrpos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $className = ucfirst($className);
    $fileName = str_replace('\\',DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).".class.php";
  }

  if(strpos($className, "Model") > 1) {
    include AppDir."/Lib/Model/".$fileName;
  }
  else if($className == "Model") {
    include "PHPMVC/Lib/".$fileName;
  }
  
  else if(strpos($className, "Controller") > 1) {
    include AppDir."/".$fileName;
  }
  else if($className == "Controller") {
    include "PHPMVC/Lib/".$fileName;
  }

  else if($className == "Cache") {
    include "PHPMVC/Lib/Cache.class.php";
  }

  else if($className == "Log") {
    include "PHPMVC/Lib/Log.class.php";
  }

  else if($className == "Session") {
    include "PHPMVC/Lib/Session.class.php";
  }
  else {
    include "PHPMVC/Lib/".$fileName;
  }
}

//+-------------------
//|配置文件读取
//+-------------------
function C($name = '') {
  $mvcConfig = include "PHPMVC/Conf/config.php";
  $userConfig = include AppDir."/Conf/config.php";
  $config = array_replace($mvcConfig, $userConfig);
  if($name != '') {
    return $config[$name];
  }
  else {
    return $config;
  }
}
