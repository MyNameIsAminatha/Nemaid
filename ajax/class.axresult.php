<?php

class axresult extends main {

	public $publicFunctions = array(
	  'calculateResults' => '*',
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function calculateResults() {
		$sql = "TRUNCATE `Resultats`";
		$this->cast("dbmysql")->query($sql, []);
		$samples = $this->cast("cosample")->getSamples();
		foreach ($samples as $sample) {
			$sql = "CALL BoucleAlgo(" . $sample['Id_Sample'] . ")";
			$this->cast("dbmysql")->query($sql, []);
		}
		return true;
  }

}
