<?php

class workshopmodel extends Database {

	public function addData($table,$data) {

		$this->insertdDB($table,$data);
		$added = $this->count();

		return $added;

	}

	public function getFields($table) {

		$fields = $this->getColMeta($table);
		return $fields;

	}

	public function getAllData($table) {

		$data = $this->selectDB($table);
		return $data;

	}

	public function getSingleRecord($table,$id) {

		$data = $this->selectDB($table = $table, $filds = null, $params = array('id'=>$id) );
		return $data;

	}

	public function editData($table,$data,$params) {

		$this->updateDBparams($table,$data,$params);
		$edited = $this->count();

		return $edited;

	}

	public function deleteData($table,$params) {

		$this->deleteDB($table,$params);
		$deleted = $this->count();

		return $deleted;

	}


}

?>