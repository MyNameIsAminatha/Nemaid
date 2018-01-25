<?php

// This class allows to get information about users

class coauth extends main {

	function __construct() {
	    parent::__construct();
	}

	public function isAuthenticated() {
		return (isset($_SESSION['auth']));
	}

	public function login($email, $password) {
		$sql = "SELECT * FROM user WHERE user_email = ? AND user_password = ?";
		$user = $this->cast("dbmysql")->query($sql, [$email, hash('sha256', $password)], true, true);
		if($user != null) { // We found a user matching the email and password provided
			$_SESSION['auth'] = $user; // Let's store the user info in a session auth
			return "success";
		} else {
			return "error";
		}
	}

	public function logout() {
		unset($_SESSION['auth']);
	}

}
