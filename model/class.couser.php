<?php

// This class allows to get information about users

class couser extends main {

	function __construct() {
	    parent::__construct();
	}

	public function getUserInfo($userId) {
		$sql = "SELECT * FROM user WHERE user_id = ?;";
		$result = $this->cast("dbmysql")->query($sql, [$userId], true, true);
		return $result;
	}

	public function testco($data) {
		$sql = "UPDATE user SET user_firstname = ? WHERE user_id = 1";
		return $this->cast("dbmysql")->query($sql, [$data]);
	}

}