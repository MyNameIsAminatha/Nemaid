<?php

class coexplore extends main {

  function __construct($controller) {
    parent::__construct($controller);
  }

  var $sopt = array(
    "eq" => "%1\$s = '%2\$s'",
    "ne" => "%1\$s <> '%2\$s'",
    "le" => "%1\$s <= '%2\$s'",
    "lt" => "%1\$s < '%2\$s'",
    "gt" => "%1\$s > '%2\$s'",
    "ge" => "%1\$s >= '%2\$s'",
    "bw" => "%1\$s LIKE '%2\$s%%'",
    "bn" => "%1\$s NOT LIKE '%2\$s%%'",
    "in" => "%1\$s IN (%2\$s)", // IN ('%2\$s') -> JQGrid version
    "ni" => "%1\$s NOT IN ('%2\$s')",
    "ew" => "%1\$s LIKE '%%%2\$s'",
    "en" => "%1\$s NOT LIKE '%%%2\$s'",
    "cn" => "%1\$s LIKE '%%%2\$s%%'",
    "nc" => "%1\$s NOT LIKE '%%%2\$s%%'",
    "nu" => "%1\$s = ''",
    "nn" => "%1\$s <> ''"
  );

  public function getTableResult($params) {

    $result['data'] = $this->prepareFieldsDisplay($params, $this->getData($params));
    $result['count'] = $this->getCountData($params);

    return $result;

  }

  public function prepareFieldsDisplay($params, $dataFromTable) {
    $cleanFields = [];
    foreach ($dataFromTable as $rowNum => $rowVal) {
      foreach ($params['params']['fields'] as $paramKey => $paramValue) {
        $cleanFields[$rowNum][$paramKey] = $this->cast("cotools")->utf8_force($dataFromTable[$rowNum][$paramValue]);
      }
      if(isset($dataFromTable[$rowNum]['rowId'])) $cleanFields[$rowNum]['rowId'] = $dataFromTable[$rowNum]['rowId'];
    }
    return $cleanFields;
  }

  public function getData($params, $optionalFields = "", $optionalCondition = false, $specialKeys = false, $translationArray = false) {

    $params = $params['params']; // Removing the action

    $sql = "";
    foreach ($params['fields'] as $param) {
      if($param != 'undefined') {
        $sql .= ($sql!=""?", ":"") . addslashes($param);
      }
    }

    // Allow to give a row id
    if($params['rowId'] != null) {
      $rowId = $params['rowId'] . " as 'rowId', ";
    } else {
      $rowId = "";
    }

    $sql = "SELECT " . $rowId . $optionalFields . " " . $sql ." FROM " . $params['table'];

    $sql .= $this->constructWhere($params, $optionalCondition, $specialKeys, $translationArray);

    $sql .= " ORDER BY " . $params['orderBy'] . " " . $params['sort'];
    $sql .= " LIMIT " . $params['resultPerPage'];
    $offset = ($params['currentPage'] - 1) * $params['resultPerPage'];
    $sql .= " OFFSET " . $offset;
    $sql .= ";";

    //var_dump($sql);
    return $this->cast("dbmysql")->query($sql, [], true);

  }

  public function getCountData($params, $optionalCondition = false, $specialKeys = false, $translationArray = false) {

    $params = $params['params']; // Removing the action

    $sql = "";
    $sql = "SELECT count(*) as nbr FROM " . $params['table'];

    $sql .= $this->constructWhere($params, $optionalCondition, $specialKeys, $translationArray);

    $sql .= ";";
    return $this->cast("dbmysql")->query($sql, [], true, true);

  }

  public function constructSearchTemplate($searchField, $searchValue, $searchTplCode) {
    $template = $this->sopt[$searchTplCode];
    return sprintf($template, $searchField, $searchValue);
  }

  /**
  * @param $params : The params sent by the AJAX (sql fields etc)
  * @param $specialKeys : An array containing the names of the fields to be displayed and searched with a label.
  * @param $translationArray : An array containing the translations between the metadata and the labels.
  * @param $optionalCondition : A SQL where condition (ex: "SITEID in ('1', '50')").
  * Construct the where condition according to parameters given in the global research, the field research and the filters.
  * @return string : a WHERE sql instruction
  */
  public function constructWhere($params, $optionalCondition = false, $specialKeys = false, $translationArray = false) {

    $sql = "";

    // Global research
    $globalConcat = "";
    $specialResult = "";
    if(strlen($params['research']) > 0) {
      $globalConcat = "(";
      $concat = "";
      foreach ($params['fields'] as $fieldName) {
        if($fieldName != 'undefined') {
          if($specialKeys != false AND in_array($fieldName, $specialKeys)) { // The field is a special field
            $specialResult .= ($specialResult != "" ? " OR " : "") . $this->getResearchSpecialFields($fieldName, $params['research'], $fieldName . " LIKE '%" . $params['research'] . "%'", $translationArray, true);
          } else {
            $temp = "lower(" . $fieldName . ") like lower('%" . $params['research'] . "%')";
            $globalConcat .= ($globalConcat == "(") ? "(" . $temp . ")" : " OR (" . $temp . ")";
          }
        }
      }
      if(!empty($specialResult)) {
        $globalConcat .= " OR (" . $specialResult . ")";
      }
      $globalConcat .= ")";
    }

    // Research per fields
    $fieldsConcat = "";
    if(isset($params['searchFields'])) {
      foreach ($params['searchFields'] as $searchKey => $search) { // For each search input
        if(!empty($search['searchVal'])) { // If the input isn't empty
          $searchTpl = $this->constructSearchTemplate($search['searchId'], $search['searchVal'], $search['searchTpl']);
          if($specialKeys != false && in_array($search['searchId'], $specialKeys)) { // The input is a special input
            $fieldsResult = $this->getResearchSpecialFields($search['searchId'], $search['searchVal'], $searchTpl, $translationArray, false);
          } else {
            $fieldsResult = $searchTpl;
          }
          $fieldsConcat .= ($fieldsConcat != "" ? " AND " : "");
          $fieldsConcat .= $fieldsResult;
        }
      }
    }

    // Research per filter
    $filterConcat = "";
    if(isset($params['searchFilters'])) {
      foreach ($params['searchFilters'] as $searchKey => $search) { // For each filter
        if(!empty($search['searchTpl'])) {
          $searchTpl = $this->constructSearchTemplate($search['searchId'], $search['searchVal'], $search['searchTpl']);
          $filterResult = $searchTpl;
          $filterConcat .= ($filterConcat != "" ? " AND " : "");
          $filterConcat .= $filterResult;
        }
      }
    }

    $sqlc = "";
    if(!empty($fieldsConcat) OR !empty($globalConcat) OR !empty($filterConcat) OR $optionalCondition != false) {
      $sql .= " WHERE ";
      $sqlc .= $fieldsConcat;
      $sqlc .= (!empty($sqlc) && !empty($globalConcat)) ? (" AND " . $globalConcat) : ($globalConcat);
      $sqlc .= (!empty($sqlc) && !empty($filterConcat)) ? (" AND " . $filterConcat) : ($filterConcat);
      $sqlc .= (!empty($sqlc) && $optionalCondition != false) ? (" AND " . $optionalCondition) : ($optionalCondition);
      $sql .= $sqlc;
    }

    return $sql;

  }

  /**
  * @param $fieldName : the database field ex : user_name
  * @param $searchValue : the value of the search ex : toto
  * @param $searchTemplate : the value of the search with template ex : USER LIKE '%toto%'
  * @param $translationArray : An array containing the translations between the metadata and the labels ex : $translationArray['user_name']['toto'] = 'Thomas'
  * @param $emptyReturn : boolean, if true will return null if the value is not found in translationArray, otherwise will return a regular search expression
  * Search in the translationArray for a match with a label.
  * If there is match, return the corresponding WHERE SQL expression.
  * If there is no match, will return empty or a regular WHERE SQL expression according to emptyReturn parameter.
  * @return string : a sql expression or null.
  */
  private function getResearchSpecialFields($fieldName, $searchValue, $searchTemplate, $translationArray, $emptyReturn) {
    $abrevResult = $this->getMatchedAbr($searchValue, $fieldName, $translationArray);
    if(empty($abrevResult)) {
      if($emptyReturn) {
        $searchResult = 'null';
      } else {
        $searchResult = $searchTemplate;
      }
    } else {
      $res = "";
      foreach ($abrevResult as $abrev) {
        $res .= ($res != "" ? " OR " : "");
        $res .= $fieldName . " LIKE '" . $abrev . "'";
      }
      $searchResult = "(" . $res . ")";
    }
    return $searchResult;
  }

  /**
  * @param $fieldName : the database field ex : user_name
  * @param $searchValue : the value of the search ex : toto
  * @param $translationArray : An array containing the translations between the metadata and the labels ex : $translationArray['user_name']['toto'] = 'Thomas'
  * Search in the translationArray for a match between a label and the search value, return an array containing all the matched elements
  * @return array : an array containing all the matched elements
  */
  private function getMatchedAbr($searchValue, $fieldName, $translationArray) {
    $abrevResult = []; // Tab of abreviation resulting from the match of the user input with the description array
    foreach ($translationArray[$fieldName] as $abrev => $label) {
      if(preg_match("/" . $searchValue . "/i", $label)){
        $abrevResult[$abrev] = $abrev;
      }
    }
    return $abrevResult;
  }

  public function prepareExcelHeaders($params) {
    $headers = [];
    foreach ($params['fieldsLabels'] as $key => $value) {
      $headers[] = utf8_decode($this->cast("cotools")->utf8_force($value));
    }
    return $headers;
  }

  public function prepareExcelDatas($params) {

    $str = "";
    foreach ($params['fields'] as $param) {
      if($param != 'undefined') {
        $str .= ($str!=""?", ":"") . $param;
      }
    }
    $str = "SELECT ". $str ." FROM " . $params['table'];

    $str .= $this->constructWhere($params);

    $str .= " ORDER BY " . $params['orderBy'] . " " . $params['sort'];
    $str .= ";";

    $res = $this->cast("dbmysql")->query($str, [], true);

    $data = [];

    foreach ($res as $row => $rowvalue) {
      foreach ($res[$row] as $field => $fieldvalue) {
        $data[$row][$field] = utf8_decode($fieldvalue);
      }
    }

    return $data;

  }

  public function getExcel($headers, $datas, $filename) {
    header("Content-Disposition: attachment; filename=" . $filename);
    header("Content-Type: application/csv");
    header("Content-Description: File Transfer");
    header("Pragma: no-cache");
    header("Expires: 0");

    $buffer = fopen('php://output', 'w');
    fputcsv($buffer, $headers,";");
    foreach($datas as $row){
      fputcsv($buffer, $row,";");
    }
  }
}
