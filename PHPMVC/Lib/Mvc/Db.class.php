<?php
//+----------------
//|数据库操作类
//+----------------
namespace Mvc;

class Db{

  private $sql;  //SQL语句
  private $conn;  //数据库连接
  private $rs;    //查询的结果
  /**
   *构造函数
   */
  public function __construct() {
    $db_host = C('db_host');
    $db_name = C('db_name');
    $db_user = C('db_user');
    $db_pwd = C('db_pwd'); 
    $db_table_prefix = C('db_table_prefix');
    $db_charset = C('db_charset');
    
    $this->conn = mysql_connect($db_host, $db_user, $db_pwd) or die("Unable to connect to the MySQL!");
    mysql_select_db($db_name, $this->conn);
    mysql_query("set names ".$db_charset);
  }
  /**
   *析构函数
   */
  public function __destruct() {
    $this->close();
  }
  
  /**
   *关闭数据库连接
   */
  public function close() {
    mysql_close($this->conn);
  }
  
  /**
   *执行sql 语句
   */
  public function exec($sql) {
    $this->sql = $sql;
    $this->rs = mysql_query($this->sql);
    //var_dump($this->rs);
    return $this->rs;
  }

  /**
   *读取多条数据
   */
  public function fetchAll() {
    $arr = array();
    while($row = mysql_fetch_array($this->rs)) {
      array_push($arr, $row);
    }
    return $arr;
  }

  /**
   *读取一条数据
   */
  public function fetch() {
    return mysql_fetch_array($this->rs); 
  }
}
