<?php 

class uasmodel extends Database
{
	
	/**
	* Every model needs a database connection, passed to the model
	* @param object $db A PDO database connection
	*/	
    function __construct($db) {
    	
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

	public function getData($table, $fieldsArray=null) {

		$query = 'SELECT ';

		if ( !empty($fieldsArray) ) {

			foreach ($fieldsArray as $key => $value) {
				$query .= $table.".".$value.',';
			}

			$query .= 'admin_countries.country AS country,staff_category.position as Position
					FROM '.$table
                                .' JOIN admin_countries ON '.$table.'.country = admin_countries.id'
                                .' JOIN staff_category ON '.$table.'.position = staff_category.id'
                                
                                .' AND admin_countries.id='.$_SESSION["country"];
					
		} else {
			$query='SELECT * from '.$table;
		}

        $data = $this->selectDBraw($query);

		return $data;
	}
	
	
	public function addData($table,$data) {
		array_pop($data);
		$dd=$this->insertdDB($table,$data);
		// echo "<pre>";var_dump($dd);echo "</pre>";
		// exit();
	}
	
	/* <ramadhan's added code> */
	public function updateField($table,$data,$id) {
		$dd=$this->updateDB($table,$data,$id);
	}
	/* </ramadhan's added code> */
	
	public function getFields($table, $fieldsArray = null) {
		$fields = $this->getColMeta($table, $fieldsArray);
		
		return $fields;
	}


	public function getAuth($table) {
            $fieldsArray = array('full_name','password');
		$fields = $this->getColMeta($table, $fieldsArray);
		
		return $fields;
	}


	public function getByPK($table,$id,$fieldsArray){
		 $dd=$this->selectDB(
		        $table,
		        $filds=$fieldsArray,
		        $params = array('id'=>$id)
		    );
		return $dd;
       
    }
    
    	public function deleteData($table,$id){
		// echo $id;
		// $query="DELETE FROM admin_assets WHERE id ='$id'";
		// $this->deleteDB($query,$id,'admin_assets');
		$dd=$this->deleteDB($table,$id);
		// echo "<pre>";var_dump($dd);echo "</pre>";
		// exit();
	}


}


?>