<?php

// This class allows to get information about users

class cosample extends main {

	function __construct() {
	    parent::__construct();
	}

	public function addSample($data) {
		return $this->cast("coresource")->savePost("sample", $data, true);
	}

	public function getSample($code) {
		$sql = "SELECT * FROM sample WHERE code = ?";
		return $this->cast("dbmysql")->query($sql, [$code], true, true);
	}

	public function getSamples() {
		$sql = "SELECT * FROM sample";
		return $this->cast("dbmysql")->query($sql, [], true);
	}

}
