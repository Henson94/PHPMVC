<?php
//+----------------
//|自动加载类文件
//+----------------
function __autoload($className) {
  $className = ltrim($className,"\\");
  $fileName = '';
  $namespace = '';
  echo '《'.$className.'》';
  if($lastNsPos = strrpos($className, '\\')) {
    $namespace = substr($className, 0, $lastNsPos);
    $className = substr($className, $lastNsPos + 1);
    $className = ucfirst($className);
    $fileName = str_replace('\\',DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).".class.php";
    //echo '《'.$fileName.'》';
  }


  if(strpos($className, "Model") > 1) {
    include AppDir."/Lib/Model/".ucfirst($className).".class.php";
  }
  else if($className == "Model") {
    //include "PHPMVC/DALFactory/MVC/Model.class.php";
  }
  
  else if(strpos($className, "Controller") > 1) {
    include AppDir."/Lib/Controller/".$className.".class.php";
  }
  else if($className == "Controller") {
    include "PHPMVC/DALFactory/MVC/Controller.class.php";
  }

  else if($className == "Cache") {
    include "PHPMVC/DALFactory/Cache.class.php";
  }

  else if($className == "Log") {
    include "PHPMVC/DALFactory/Log.class.php";
  }

  else if($className == "Session") {
    include "PHPMVC/DALFactory/Session.class.php";
  }
}
