<?php
namespace Mvc;

class PdoDbConn {
  $static public $PDOs;
  public function PdbDbConn() {
    try{
      $db_host = C("db_host");
      $db_name = C("db_name");
      $db_user = C("db_user");
      $db_pwd = C("db_pwd");
      self::$PDOs = new PDO("mysql:host=$db_host; db_name=$db_name; $db_user; $db_pwd");
      self::$PDOs->query("set names utf8");
    } catch (Exception $e) {
      print $e->getMessage();
    }
  }
}

