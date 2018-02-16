<?php

class axresult extends main {

	public $publicFunctions = array(
	  'calculateResults' => '*',
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function calculateResults() {
    $sql = "CALL BoucleAlgo";
		$this->cast("dbmysql")->query($sql, []);
		return true;
  }

}
