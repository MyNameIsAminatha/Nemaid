<?php

class axuser extends main {

	public $publicFunctions = array(
	  'testax' => '*',
	);
		
  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function testax() {
    $data = $_POST['data'];
    $result = $this->cast("couser")->testco($data);
    echo json_encode($result);
  }

}