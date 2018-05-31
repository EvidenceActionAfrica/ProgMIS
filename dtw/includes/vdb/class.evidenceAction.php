<?php 

	/**
	* 
	*/
	require "db_class.php";
	class evidenceAction extends connDB
	{
		
		function __construct()
		{
			// $this->connDB(); //make db connection
		}

		// gets all the counties
		public function getCounties(){
			$sql="SELECT county_id,county  FROM counties";

			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();
			foreach ($rows as $row){
				$data[]=array(
					'county_id'=>$row['county_id'],
					'county'=>$row['county']
				);
			}

			return $data;
		}

		// gets all the schools
		public function getSchools(){
			$sql="SELECT school_id,school_name  FROM schools";

			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();
			foreach ($rows as $row){
				$data[]=array(
					'school_id'=>$row['school_id'],
					'school_name'=>$row['school_name']
				);
			}

			return $data;
		}

		// get all the districts
		// if division given it seraches the divions table
		public function getDistricts($county_id=false){

			if ($county_id==true) {
				$sql="SELECT district_id,district_name  FROM districts WHERE county_id ='$county_id'";

				$this->exec($sql);
				$rows = $this->resultset();

				$data=array();
				foreach ($rows as $row){
					$data[]=array(
						'district_id'=>$row['district_id'],
						'district_name'=>$row['district_name']
					);
				}

				return $data;
			}else{
				$sql="SELECT district_id, district_name FROM districts";

				$this->exec($sql);
				$rows = $this->resultset();

				$data=array();
				foreach ($rows as $row){
					$data[]=array(
						'district_id'=>$row['district_id'],
						'district_name'=>$row['district_name']
					);
				}

				return $data;
			}
			
		}














	} // end class

 ?>