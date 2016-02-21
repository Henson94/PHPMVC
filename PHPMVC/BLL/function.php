<?php
//+----------------
//|自动加载类文件
//+----------------
function __autoload($className) {
  if(strpos($className, "Model") > 1) {
    include AppDir."/Lib/Model/".ucfirst($className).".class.php";
  }
  else if(strpos($className == "Model")) {
    include "PHPMVC/DALFactory/Model.class.php";
  }
  
  else if(strpos($className, "Controller") > 1) {
    include AppDir."/Lib/Controller/".ucfirst($className).".class.php";
  }
  else if($className == "Controller") {
    include "PHPMVC/DALFactory/Controller.class.php";
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
