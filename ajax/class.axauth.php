<?php

class axauth extends main {

	public $publicFunctions = array(
	  'login' => '*',
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function login() {
		$data = $_POST;
    $result = $this->cast("coauth")->login($data['email'], $data['password']);
    echo json_encode($result);
  }

}
