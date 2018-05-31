<?php 
/**
* 
*/
// require "global.php";
// require "../includes/class.evidenceAction.php";
require "../includes/db_class.php";

/**
* 
*/
class intakeLog extends connDB
{
	public $table_name="reverse_sad_returns";

	function __construct()
	{
		$this->connDB(); //make db connection
	}

	 public function getDistID3($dist_name){
			$sql="SELECT district_id  FROM districts WHERE district_name =:district_name";
			$params = array(':district_name' => $dist_name);
			$this->exec($sql,$params);
			$name = $this->single();

			return $name['district_id'];
}

	/**
	* Description : update the given form to yes.
	*
	* @param string  $form_type
	* @param int  $district_id
	*/
	
	public function update($district_name,$form_type){
		$district_name=trim($district_name); 			//trim the data

		$district_id=$this->getDistID3($district_name); // get the district id
		
		$forms=$this->getForms($district_id);           // get the forms from the $this->table_name
		
		$pieces=$this->getFormValue($form_type,$forms); // update the form to yes
		
		$forms=implode(',', $pieces);					// change the array to astring delimited with a comma

		$sql="UPDATE $this->table_name SET
					forms = :forms
					WHERE district_id = :district_id";

		$params = array(
			':forms' => $forms,
			':district_id'=>$district_id
		);
		//execute the update
		$this->exec($sql,$params);
	}


	/**
	* Description : change given form type to yes.
	*
	* @param string  $label
	* @param string  $forms
	* @return mixed  $data
	*/
	
	public function getFormValue($label,$forms){
		// convert the form to an array
		$forms=explode(",", $forms);
		
		switch ($label) {
			case 'P';
				$data=$this->addToArray($forms,0);
				return $data;
				break;

			case 'MT';
				$data=$this->addToArray($forms,1);
				return $data;
				break;

			case 'ATTNTSC';
				$data=$this->addToArray($forms,2);
				return $data;
				break;

			case 'ATTNC';
				$data=$this->addToArray($forms,3);
				return $data;
				break;

			case 'ATTNT';
				$data=$this->addToArray($forms,4);
				return $data;
				break;

			case 'S';
				$data=$this->addToArray($forms,5);
				return $data;
				break;

			case 'A';
				$data=$this->addToArray($forms,6);
				return $data;
				break;

			case 'D';
				$data=$this->addToArray($forms,7);
				return $data;
				break;

		}
	}

	/**
	* Description : chnage given form to yes.
	*
	* @param int    $form_key
	* @param mixed  $items
	* @return mixed $data
	*/
	
	public function addToArray(array $items,$form_key){

		foreach ($items as $key => $item) {
			if ($key==$form_key) {
				$item="Y"; // set selected key data to yes
			}
			
			$data[]=$item; // store them back to an array
		}

		return $data;
	}


	/**
	* Description : get the forms field from $this->table_name by distict ID.
	*
	* @param int  $district_id
	* @return mixed $row['forms']
	*/
	
	public function getForms($district_id){
		$sql = "SELECT forms FROM $this->table_name WHERE district_id='$district_id'";
		$this->exec($sql);
		$row = $this->single();

		return $row['forms'];

		// exit();
	}


} // end class







