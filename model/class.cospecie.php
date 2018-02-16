<?php

// This class allows to get information about users

class cospecie extends main {

	function __construct() {
	    parent::__construct();
	}

	public function getSpecies() {
		$sql = "SELECT * FROM species";
		return $this->cast("dbmysql")->query($sql, [], true);
	}

}
