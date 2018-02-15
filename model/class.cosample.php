<?php

// This class allows to get information about users

class cosample extends main {

	function __construct() {
	    parent::__construct();
	}

	public function addSample($data) {
		$sql = "INSERT INTO sample (date, Genus_Name, Id_User) VALUES (?, ?, ?)";
		$this->cast("dbmysql")->query($sql, [$data['date'], $data['Genus_Name'], 4]);
		return $this->cast("dbmysql")->lastInsertId();
	}

	public function getSample($code) {
		$sql = "SELECT * FROM sample WHERE Id_Sample = ?";
		return $this->cast("dbmysql")->query($sql, [$code], true, true);
	}

	public function getSamples() {
		$sql = "SELECT * FROM sample";
		return $this->cast("dbmysql")->query($sql, [], true);
	}

}
