<?php 

	/**
	* 
	*/
	class Education 
	{
		
		function __construct()
		{
			
		}

		public function create(){

		}

		public function getEducation(){
			$data=array();

			$result_set = mysql_query("SELECT * FROM divisions ORDER BY division_name ASC")or die(mysql_error());
		   // mysql_fetch_array($result_set);
		    while ($row = mysql_fetch_array($result_set)) {
		    	$data[]=array(
					'id'=>$row['id'],
		            'district_id'  => $row['district_id'],
		            'division_id'  => $row['division_id'],
		            'division_name'  => $row['division_name'],
		            'county_id'  => $row['county_id'],
		            'wave_assigned'  => $row['wave_assigned']

		    		);
	         return $data;  
	                
			}
	}


}//end class

 ?>