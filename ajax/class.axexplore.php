<?php

class axexplore extends main {

	public $publicFunctions = array(
    'getTableResult' => true,
    'exportResults' => "*",
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function getTableResult() {
    $params = $_POST;
    $result = $this->cast("coexplore")->getTableResult($params);
    echo json_encode($result);
  }

  public function exportResults() {
    $params = json_decode($_REQUEST['params'], true);
    $filename = $params['exportFileName'];
    $headers = $this->cast("coexplore")->prepareExcelHeaders($params);
    $datas = $this->cast("coexplore")->prepareExcelDatas($params);
    $this->cast("coexplore")->getExcel($headers, $datas, $filename);
  }

}
