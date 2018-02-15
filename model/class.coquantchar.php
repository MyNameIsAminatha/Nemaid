<?php

// This class allows to get information about users

class coquantchar extends main {

	function __construct() {
	    parent::__construct();
	}

	public function getQuantChars() {
		$sql = "SELECT * FROM characters";
		return $this->cast("dbmysql")->query($sql, [], true);
	}

	public function getSampleQuantChars($sample_id) {
		$sql = "SELECT * FROM sample_quant_char_value WHERE Id_Sample = ?";
		return $this->cast("dbmysql")->query($sql, [$sample_id], true);
	}

	public function removeQuantChar($sample_id, $character) {
		$sql = "DELETE FROM sample_quant_char_value WHERE Id_Sample = ? AND Id_Character = ?";
		return $this->cast("dbmysql")->query($sql, [$sample_id, $character]);
	}

	public function saveQuantChars($sample_id, $rawData) {
		$sampleQuantChars = $this->getSampleQuantChars($sample_id);
		$data['Id_Sample'] = $sample_id;
		foreach ($rawData as $key => $singleData) {
			if($singleData != "") {
				$data['Id_Character'] = $key;
				$data['Quant_Char_Value'] = $singleData;
				$this->cast("coresource")->savePost("sample_quant_char_value", $data, false);
			} else {
				//check si la key existe pour le tableau samplequantchars
				$exist = false;
				foreach ($sampleQuantChars as $sampleQuantChar) { // Pour chaque quant char du sample donné
					if($sampleQuantChar['Id_Character'] == $key) $exist = true; // Si le charactère est déja renseigné on met exist à true
				}
				if($exist) { // La clé existe, on va donc supprimer la ligne
					$this->removeQuantChar($sample_id, $key);
				} // Sinon on fait rien on ajoute pas.
			}
		}
	}

}
