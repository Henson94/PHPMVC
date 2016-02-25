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
  public $db;
  /**
   *__call 方法实现连续操作
   */
  public function __call($method, $args) {
    if(in_array(strtolower($method), array('where', 'order', 'limit', 'filed'), true)) {
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
      $table = strtolower(str_replace('Model', '', substr(get_called_class(), strrpos(get_called_class(), "\\")+1)));
      $this->tableName = C("DB_TABLE_PREFIX").$table;
    }
    else {
      $this->tableName = C("DB_TABLE_PREFIX").$tableName;
    }
    $this->db = new Db();
    //$this->db->exec("insert into $this->tableName(username, password) values('henson1', 'abc123')");
  }

  /**
   *插入数据C
   */
  public function create($data) {
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
      $this->sql = "insert into ". $this->tableName. "($field)". " values($val)";
      return $this->db->exec($this->sql);
    }
    else {
      exit("数据为空！");
    }
  }
  /**
   *更新数据 U
   */
  public function update($data) {
    if(array_key_exists("where", $this->options)) {
      $where = " where ".$this->options['where'];
      $sets = "";
      foreach($data as $key => $value) {
        if(is_string($value)) {
          $value = "'$value'";
        }
        else {
          $value = intval($value);
        }
        $sets .=  ", `".$key."`=". $value;
      }
      $sets = " set ".trim($sets, ',');
      $this->sql = "update ".$this->tableName.$sets.$where;
      return $this->db->exec($this->sql);
    }
    else {
      $this->error = "where 条件不能为空！";
    }
  }
  /**
   *读取数据
   */
  public function read() {
    $where = '';
    $field = '';
    $order = '';
    $limit = '';
    if(array_key_exists('where', $this->options)) {
      $where = " where ".$this->options['where'];
    }
    else {
      $where = NULL;
    }
    if(array_key_exists('field', $this->options)) {
      $field = $this->options['filed'];
    }
    else {
      $field = " * ";
    }
    if(array_key_exists('order', $this->options)) {
      $order = " order by ".$this->options['order'];
    }
    else {
      $order = NULL;
    }
    if(array_key_exists('limit', $this->options)) {
      $limit = " limit ".$this->options['limit'];
    }
    else {
      $limit = NULL;
    }
    $this->sql = "select ".$field." from ".$this->tableName.$where.$order.$limit;
    $this->db->exec($this->sql);
    return $this->db->fetchAll();
  }

  /**
   *读取一条数据
   */
  public function find() {
    $where = '';
    $field = '';
    $order = '';
    $limit = ' limit 0, 1 ';
    if(array_key_exists('where', $this->options)) {
      $where = " where ".$this->options['where'];
    } else {
      $where = NULL;
    }
    if(array_key_exists('filed', $this->options)) {
      $field = $this->options['field'];
    } else {
      $field = " * ";
    }
    if(array_key_exists('order', $this->options)) {
      $order = " order by".$this->options['order'];
    } else {
      $order = NULL;
    }
    $this->sql = "select ".$field." from ".$this->tableName.$where.$order.$limit;
    $this->db->exec($this->sql);
    return $this->db->fetch();
  }

  /**
   *删除数据
   */
  public function delete() {
    if(array_key_exists('where', $this->options)) {
      $where = " where ".$this->options['where'];
      $this->sql = "delete from {$this->tableName} ".$where;
    }
    else {
      $this->error = "where 条件不能为空！";
      return false;
    }
    return $this->db->exec($this->sql);
  }
  /**
   ×最后执行的sql
   */
  public function getLastSql() {
    return $this->sql;
  }


}
