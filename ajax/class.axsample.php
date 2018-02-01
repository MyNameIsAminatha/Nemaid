<?php

class axsample extends main {

	public $publicFunctions = array(
	  'addSample' => '*',
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function addSample() {
    $data = $_POST;
    $result = $this->cast("cosample")->addSample($data);
    echo json_encode($result);
  }

}
