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
		$data['Id_User'] = 4;

		$sample = $this->cast("coresource")->savePost("sample", $data, false);

		if(!empty($data['Id_Sample'])) {
			$sample_id = $data['Id_Sample'];
		} else {
    	$sample_id = $sample['Id_Sample'];
		}

		// Removing unecessary data
		unset($data['action'], $data['Genus_Name'], $data['Code_Sample'], $data['date'], $data['Id_Sample'], $data['Species_Name'], $data['Id_User']);

		$result = $this->cast("coquantchar")->saveQuantChars($sample_id, $data);

    echo json_encode($result);
  }

}
