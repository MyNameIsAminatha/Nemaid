<?php

class axsample extends main {

	public $publicFunctions = array(
	  'saveSample' => '*',
	);

  public function __construct($controller) {
    parent::__construct($controller);
  }

  public function saveSample() {
    $data = $_POST;

		if(!empty($data['Id_Sample'])) {
			$sample_id = $data['Id_Sample'];
		} else {
    	$sample_id = $this->cast("cosample")->addSample($data);
		}

		// Removing unecessary data
		unset($data['action'], $data['Genus_Name'], $data['date'], $data['Id_Sample']);

		$result = $this->cast("coquantchar")->saveQuantChars($sample_id, $data);

    echo json_encode($result);
  }

}
