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

  /**
   * Add (if id<=0) or update
   * @param $table name of the table
   * @param $data $_POST
   * @param $isPartialData should be false if full set of data is provided (if false and fields are missing -> values in the db will be deleted)
   * @param $type INSERT or UPDATE
   * @return array containing the values of the row inserted.
   */
  public function savePost($table, $data, $isPartialData = false, $type = false){

    // Construct an array of primary keys and an array of autoincrements
    $primaryKeys = $this->cast("dbmysql")->list_primary_keys("$table");
    $autoIncrements = $this->cast("dbmysql")->list_auto_increments("$table");

    if(!$type) { // The function has to determine the nature of the action (insert or update)

      // Construction of an array of the primary keys associated with their value providing from $data. Check if a value is missing.
      $dataKeys = array();
      foreach ($primaryKeys as $primaryKey) {
        if(!isset($data[$primaryKey]) && !in_array($primaryKey, $autoIncrements)) $this->log(__METHOD__." Missing value for key '$primaryKey'", LOG_ALERT);
        $dataKeys[$primaryKey] = $this->cast("dbmysql")->escape_string($data[$primaryKey]);
      }

      // We search in the table is the first primary keys value exist (if the row is already present)
      if($data[$primaryKeys[0]] != ""){
        $item = $this->getItem($table, $dataKeys);
        if($item){
          $sqlAction = "UPDATE";
        } else {
          $sqlAction = "INSERT";
        }
      } else {
        $sqlAction = "INSERT";
      }

    } else { // The user choosed an action manually
      $sqlAction = strtoupper($type);
    }

    $sql = $sqlAction ." $table SET ";

    // Determine list of fields
    $sqlFields = "";
    $fields = $this->cast("dbmysql")->list_fields("$table");
    foreach($fields as $field){
      if(!in_array($field['Field'], $primaryKeys) || (  in_array($field['Field'], $primaryKeys) && !in_array($field['Field'], $autoIncrements))  ){
        if(isset($data[$field['Field']])){
          $sqlFields .= ($sqlFields != "" ? ", " : "");
          $sqlFields .= $field['Field'] ."=". $this->getMySqlFieldValue($data[$field['Field']], $field) ."";
        }else if(!$isPartialData){ // Full dataset : missing fields are assumed to be empty fields
          $sqlFields .= ($sqlFields != "" ? ", " : "");
          $sqlFields .= $field['Field'] ."=". $this->getMySqlFieldValue("", $field) ."";
        }
      }
    }
    $sql .= $sqlFields;

    // Calculate the WHERE condition if the action is an update
    if($sqlAction == "UPDATE"){
      $sqlWHERE = "";
      foreach ($primaryKeys as $primaryKey) {
        if(!isset($data[$primaryKey]) && !in_array($primaryKey, $autoIncrements)) $this->log(__METHOD__." Missing value for key '$primaryKey'", LOG_ALERT);
        $sqlWHERE .= ($sqlWHERE != "" ? " AND " : "");
        $sqlWHERE .= "$primaryKey='". $this->cast("dbmysql")->escape_string($data[$primaryKey]) ."'";
      }
      $sql .=" WHERE " . $sqlWHERE;
    }

    // Query is executed.
    $result = $this->cast("dbmysql")->query($sql, []);

    // Getting the result (fetching the row inserted).
    if($result) {
      $dataKeys = array();
      foreach ($primaryKeys as $primaryKey) {
        if($sqlAction=="INSERT" && in_array($primaryKey, $autoIncrements)){
          $dataKeys[$primaryKey] = $this->cast("dbmysql")->lastInsertId();
        } else {
          $dataKeys[$primaryKey] = $this->cast("dbmysql")->escape_string($data[$primaryKey]);
        }
      }
      return $this->getItem($table, $dataKeys);
    }

    return false;

  }

    /**
   * Return default value consistent with the MySQL field type for empty value
   * If value is not empty => the value
   * If value is empty => the consistent default value
   * @param value
   * @param field info array(Field, Type, Null, Key, Default, Extra)
   * return $string
   */
  private function getMySqlFieldValue($value, $field){
    if($value!=""){
      return "'". $this->cast("dbmysql")->escape_string($value) ."'";
    } else {
      if($field['Null'] == "YES"){
        return "NULL";
      } else {
        return "'" . $field['Default'] . "'";
      }
    }
  }


  /**
   * Resource
   * @param $table
   * @param $resourceId value or array(key1 => value1, key2 => value2, ...)
   * @return array
   */
  public function getItem($table, $resourceIdOrResourceKeys){
    $sqlWHERE = "";
    if(is_array($resourceIdOrResourceKeys)){
      foreach ($resourceIdOrResourceKeys as $index => $value) {
        $sqlWHERE .= ($sqlWHERE!=""?" AND ":"");
        $sqlWHERE .= "$index='". $this->cast("dbmysql")->escape_string($value) ."'";
      }
    }else{
      $sqlWHERE = "id='". $this->cast("dbmysql")->escape_string($resourceId) ."'";
    }

    $sql = "SELECT * FROM $table WHERE ". $sqlWHERE;
    $result = $this->cast("dbmysql")->query($sql, [], true, true);
    if($result){
      return $result;
    }

    return false;
  }

}
