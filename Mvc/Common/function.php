<?php 
//读取配置文件函数
function C($name = '') {
  $name = strtolower($name);
  $sysConfig = include_once "./Mvc/Conf/config.php";
  $appConfig = (file_exists(APP_DIR."Conf/config.php"))? include_once "./App/Conf/config.php" : NULL;
  $moduleConfig = (defined(@MODULE_NAME))? include_once APP_DIR.MODULE_NAME."/Conf/config.php" : NULL;
  
  $sysConfig = (is_array($sysConfig))? $sysConfig : array();
  $appConfig = (is_array($appConfig))? $appConfig : array();
  $moduleConfig = (is_array($moduleConfig))? $moduleConfig : array();
  
  $config = array_replace($sysConfig, $appConfig, $moduleConfig);
  //把key值全部转换为小写
  $config = array_change_key_case($config);

  if(!empty($name)) {
    return $config[$name];
  } 
  else {
    return $config;
  }
}

//获得URL
function U($args,$pram = array()) {
  $entryPath = "http://".$_SERVER['HTTP_HOST'].str_replace($_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF']);
  $module = defined(@MODULE_NAME)? "/".MODULE_NAME : NULL;
  $controllerActionArr = explode("/",$args);
  $url = $entryPath.$module;
  $url .= !empty($controllerActionArr[0])? "/".$controllerActionArr[0] : "/Index";
  $url .= !empty($controllerActionArr[1])? "/".$controllerActionArr[1] : "/Index";
  foreach($pram as $key=>$value) {
    $url .= "/".$key."/".$value;
  }
  $url .= ".html";
  return $url;
}
