<?php

/*
  query($sql, $params, $returnArray, $returnSingleRow)
  $sql : the sql instruction to be executed (INSERT, SELECT ...)
  $params : The parameters, must be container in an array[]. Example : query($sql, [$param1, $param2, $param3]);
  $returnArray : if set to true, will return the result of the query as an array indexed by row number, then db fields (example $array[0]['username'])
  $returnSingleRow : if set to true, will return an array indexed by db fields (example $array['username'])
*/

class dbmysql extends main {

  var $db;

  function __construct(){
    parent::__construct();
    $this->db = new PDO("mysql:dbname=" . $this::$config['DB_NAME'] . ";host=" . $this::$config['DB_SERVER'] . ";charset=" . $this::$config['DB_CHARSET'], $this::$config['DB_USER'], $this::$config['DB_PASSWORD']);
    $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
  }

  /**
   * Execute a query
   */
  public function query($query, $params = false, $returnArray = false, $returnSingleRow = false) {

    if($params) {
      $req = $this->db->prepare($query);
      $req->execute($params);
    } else {
      $req = $this->db->query($query);
    }

    if($returnArray) {
      if($returnSingleRow) {
        $result = $req->fetchAll(PDO::FETCH_NAMED);
        return (isset($result[0]) ? $result[0] : null);
      } else {
        return $req->fetchAll(PDO::FETCH_NAMED);
      }
    } else {
      return $req;
    }

  }

  public function escape_string($str){
    return $this->db->escape_string($str);
  }

  public function lastInsertId(){
    return $this->db->lastInsertId();
  }

}
