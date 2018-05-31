<?php

class fieldofficemodel extends Database {

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
	public function getData($table, $fieldsArray=null) {
                
		$query = 'SELECT ';

		if ( !empty($fieldsArray) ) {

			foreach ($fieldsArray as $key => $value) {
                               // foreach($value["fieldsArray"] as $key2 => $value2){
                                  $query .= $table.".".$value.',';
			   
                               // }
             
                          }

			$query .= 'admin_countries.country AS country
					FROM '.$table.'
					JOIN admin_countries ON '.$table.'.country = admin_countries.id'.' AND admin_countries.id='.$_SESSION["country"];
			

		} else {
			$query='SELECT * from '.$table.' WHERE country='.$_SESSION['country'];
		}
              
           //  echo $query;   
        $data = $this->selectDBraw($query);

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
		$edited = $this->count();

		return $edited;

	}


}

?>