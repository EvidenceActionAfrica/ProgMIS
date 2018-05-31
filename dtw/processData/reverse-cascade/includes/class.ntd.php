<?php 

	/**
	* 
	*/
	require "../../includes/class.evidenceAction.php";
	// require "../includes/db_class.php";
	

	// class ntd extends connDB
	class ntd extends evidenceAction
	{
		
		function __construct()
		{
			# code...
		}

		public function numDistinctFlexible($field,$table,$where,$value){
			//'school_id','a_bysch','district_id','2012029'
			//$sql="SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
			$sql="SELECT * FROM a_bysch WHERE district_id = '2012029'";
			//$sql="SELECT DISTINCT(:field) FROM :table WHERE :where_ = :value";
			// $params = array(
			// 	':field' => $field,
			// 	':table' => $table,
			// 	':where' => $where,
			// 	':value' => $value

			// 	);
			// $this->exec($sql, $params);
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}
	}
 ?>