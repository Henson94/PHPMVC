<?php
//+--------------------
//|实现Model
//+--------------------
namespace Mvc;

class Model {
  public $sql;
  public $tableName;
  public $lastSql;
  public $error;
  protected $options = array();
  /**
   *__call 方法实现连续操作
   */
  public function __call($method, $args) {
    if(in_array(strtolower($method), array('where', 'order', 'limit', 'filed'), true) {
      //连贯操作的实现
      $this->options[strtolower($method)] = $args[0];
      return $this;
    } 
    else {
      exit($method."方法不存在！");
    }
  } 

  public function __construct($tableName = '') {
    if(!empty($tableName)) {
      $this->tableName = C("DB_TABLE_PREFIX").str_replace("Model", "", get_called_class());
    }
    else {
      $this->tableName = C("DB_TABLE_PREFIX").$tableName;
    }
    new PdoDbConn();
  }

  /**
   *插入数据
   */
  public function create() {
    $data = $this->options['data'];
    $field = null;
    $val = null;
    if($data) {
      foreach($data as $key=>$value) {
        if(is_string($value)) {
          $value = mysql_escape_string($value);
          $value = "'$value'";
        }
        else {
          $value = intval($value);
        }
        $val .= $value.",";
        $field .= "`".$key."`,";
      }
      $field = rtrim($field, ",");
      $val = rtrim($val, ",");
      $this->sql = "insert into ". $this->tableName. "($field)". "values($val)";
    }
    else {
      exit("数据为空！");
    }
    if($pdo = PdoDbConn::$PDOs) {
      $rs = $pdo->prepare($this->sql);
      return $rs->execute();
    }
    else {
      $this->error = $pdo->errorInfo();
      return false;
    }
  }

}
