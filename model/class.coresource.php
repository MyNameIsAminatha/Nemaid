<?php

class coresource extends main {
  
  function __construct(){
    parent::__construct();
  }

  var $tpl = array(
    "eq" => "%1\$s = '%2\$s'",
    "ne" => "%1\$s <> '%2\$s'",
    "le" => "%1\$s <= '%2\$s'",
    "lt" => "%1\$s < '%2\$s'",
    "gt" => "%1\$s > '%2\$s'",
    "ge" => "%1\$s >= '%2\$s'",
    "bw" => "%1\$s LIKE '%2\$s%%'",
    "bn" => "%1\$s NOT LIKE '%2\$s%%'",
    "in" => "%1\$s IN (%2\$s)",
    "ni" => "%1\$s NOT IN ('%2\$s')",
    "ew" => "%1\$s LIKE '%%%2\$s'",
    "en" => "%1\$s NOT LIKE '%%%2\$s'",
    "cn" => "%1\$s LIKE '%%%2\$s%%'",
    "nc" => "%1\$s NOT LIKE '%%%2\$s%%'",
    "nu" => "%1\$s = ''",
    "nn" => "%1\$s <> ''"
  );

  public function select($table, $fields = [], $where = [], $pfirstResultOnly = NULL) {

    if($fields === true) { // User ask for 1rst result only
      $firstResultOnly = true;
    } elseif($where === true) {
      $firstResultOnly = true;
    } else {
      $firstResultOnly = $pfirstResultOnly;
    }

    $sql_fields = "";
    if(empty($fields)){
      $sql_fields = "*";
    } else {
      foreach ($fields as $value) {
        $sql_fields .= (empty($sql_fields)) ? $value : ", " . $value ; 
      }
    }
    $sql = "SELECT " . $sql_fields . " FROM " . $table;
    if(!empty($where)) $sql .= " WHERE " . $this->constructWhere($where);
    var_dump($sql);
    /*$res = $this->cast("dbmysql")->query($sql, [], true, $firstResultOnly);
    return $res;*/
  }

  public function count($table, array $where = []) {
  	$sql = "SELECT count(*) as 'nbr' FROM " . $table;
  	if(!empty($where)) $sql .= " WHERE " . $this->constructWhere($where);
  	$res = $this->cast("dbmysql")->query($sql, [], true, true);
  	return $res['nbr'];
  }

  public function insert($type) {
    $sql = $type;
  }

  private function constructWhere($array) {
  	$where = "";
    // Check if where is a single array or a multiple array
    if(count($array[0]) == 1) { // Single where
      var_dump('1 where');
      $where .= $this->constructSearchTemplate($array[0], $array[1], $array[2]);
    } else { // Multiples where
      var_dump('multiple where');
    	foreach ($array as $whereKey => $whereValue) {
        if(count($whereValue) == 1) { // User is sending the word OR, AND
          $where .= ' ' . $whereValue . ' ';
        } else {
          $tempWhere = $this->constructSearchTemplate($whereValue[0], $whereValue[1], $whereValue[2]);
      		$where .= $tempWhere;
        }
    	}
    }
  	return $where;
  }

  public function constructSearchTemplate($field, $tplCode, $value) {
    $template = $this->tpl[$tplCode];
    return sprintf($template, $field, $value);
  }
}  
