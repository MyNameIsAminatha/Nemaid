<?php

// This class allows to get information about users

class cogenus extends main {

	function __construct() {
	    parent::__construct();
	}

	public function getGenuses() {
		$sql = "SELECT * FROM genus";
		return $this->cast("dbmysql")->query($sql, [], true);
	}

}
