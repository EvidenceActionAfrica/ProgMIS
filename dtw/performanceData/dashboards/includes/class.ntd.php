<?php 

	/**
	* 
	*/
	// require "../../includes/class.evidenceAction.php";
	require "../../includes/db_class.php";

	// class ntd extends connDB
	class ntd extends connDB
	{
		private $table_name='dashboard_district_ntd_sth';
		private $table_name_pzq='dashboard_district_ntd_pzq';
		private $table_name_apendix = 'dashboard_appendix_kpi';

		function __construct()
		{
			$this->connDB(); //make db connection
		}

		/**
	    * Desctiprion: Truncate table.
	    *
	    * @param string  $table_name
	    */
	    public function truncateTable($table_name){
			$sql = "TRUNCATE TABLE $table_name";
			$this->exec($sql);
	    }

		public static function notavailable($v){
	    	if ($v=='') {
	    		// return "<span class='label label-default'>N/A</span>";
	    	}else{;
	    		return $v;
	    	}
	    }

		/**
	    * Desctiprion: Get district name from district id given
	    * @param int $dist_id
	    * @return string $name['district_name']
	    */
	    
		public function getDistName($dist_id){
			$sql="SELECT district_name  FROM districts WHERE district_id =:district_id";
			$params = array(':district_id' => $dist_id);
			$this->exec($sql,$params);
			$name = $this->single();

			if ($name['district_name']===Null) {
				//return "<span style='color:maroon'>Cannot get district</span>";
                           return "NO VALUE";
			}else{
				return $name['district_name'];
			}

	    }

		/**
	    * Desctiprion: return county details of given district_id.
	    * @param string $district_id
	    * @param string $column. Either name of id
	    * @return string 
	    */
	    public function getDistrictCounty($district_id,$column){
	    	$sql="SELECT county, county_id FROM districts WHERE district_id='$district_id'";
	    	$this->exec($sql);
	    	$row = $this->single();

	    	if ($column=='name') {
		    	return $row['county'];
	    	}else{
		    	return $row['county_id'];
	    	}
	    }


		/**
		* Desctiprion: loop through all the districts and perform the provided quries
		*  
		* @return mixed 
		*/
		function runQuery(){
			$data=array(); //create the array

			// loop throgh all the districts
			$command="
						SELECT 
						district_id,
						COUNT(school_id) AS schools_treated,
						SUM(a_u5_total) AS u5_treated,
						SUM(a_6_14_total) AS sac_treated,
						SUM(a_15_total) AS over_15_treated,
						SUM(a_u5_m) AS u5_male_treated,
						SUM(a_u5_f) AS u5_female_treated,
						SUM(a_6_14_m) AS sac_male_treated,
						SUM(a_6_14_f) AS sac_female_treated,
						SUM(a_15_m) AS over_15_male_treated,
						SUM(a_15_F) AS over_15_female_treated

						FROM `a_bysch`

						GROUP BY district_id
				";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'district_id' => $row['district_id'], 
					'schools_treated'=>$row['schools_treated'],
					'u5_treated'=>$row['u5_treated'],
					'sac_treated'=>$row['sac_treated'],
					'over_15_treated'=>$row['over_15_treated'],
					'u5_male_treated'=>$row['u5_male_treated'],
					'u5_female_treated'=>$row['u5_female_treated'],
					'sac_male_treated'=>$row['sac_male_treated'],
					'sac_female_treated'=>$row['sac_female_treated'],
					'over_15_male_treated'=>$row['over_15_male_treated'],
					'over_15_female_treated'=>$row['over_15_female_treated'],
					'adults_treated' =>"n/a",
					'target_u5' =>"n/a",
					'target_sac' =>"n/a",
					'target_adult' =>"n/a"
				);
			}
			
			
			// truncate the table before
			$this->truncateTable($this->table_name);

			// loop through the array and insert data
			for ($i=0; $i < count($data); $i++) { 
				$this->create($data[$i]);
			}
			

		}


		/**
		* Desctiprion: insert data for the method runQuery.
		* 
		* @param mixed.
		*/
		
		public function create($data=array()){
		  	
		    $id=""; //set the id

			$sql="INSERT INTO dashboard_district_ntd_sth VALUES(
								:id,
								:district_id,
								:schools_treated,
								:u5_treated,
								:sac_treated,
								:over_15_treated,
								:u5_male_treated,
								:u5_female_treated,
								:sac_male_treated,
								:sac_female_treated,
								:over_15_male_treated,
								:over_15_female_treated,
								:adults_treated,
								:target_u5,
								:target_sac,
								:target_adult
					 )";

			$params = array(':id'=>$id,
							':district_id' => $data['district_id'], 
							':schools_treated' => $data['schools_treated'],
							':u5_treated' => $data['u5_treated'],
							':sac_treated' => $data['sac_treated'],
							':over_15_treated' => $data['over_15_treated'],
							':u5_male_treated' => $data['u5_male_treated'],
							':u5_female_treated' => $data['u5_female_treated'],
							':sac_male_treated' => $data['sac_male_treated'],
							':sac_female_treated' => $data['sac_female_treated'],
							':over_15_male_treated' => $data['over_15_male_treated'],
							':over_15_female_treated' => $data['over_15_female_treated'],
							':adults_treated' => $data['adults_treated'],
							':target_u5' => $data['target_u5'],
							':target_sac' => $data['target_sac'],
							':target_adult' => $data['target_adult']
					 );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_sad_returns";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		/**
		* Desctiprion: Get all records.
		*
		* @return mixed $data
		*/
		
		public function getAll(){

			// run the query first
			$this->runQuery();
			
			$sql="SELECT * FROM $this->table_name";
			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();

			foreach ($rows as $key => $row) {
				$data[] = array(
					'district_id'=> $row['district_id'],
					'schools_treated' => $row['schools_treated'],
					'u5_treated' => $row['u5_treated'],
					'sac_treated' =>  $row['sac_treated'],
					'over_15_treated' => $row['over_15_treated'],
					'u5_male_treated' =>  $row['u5_male_treated'],
					'u5_female_treated' => $row['u5_female_treated'],
					'sac_male_treated' => $row['sac_male_treated'],
					'sac_female_treated' => $row['sac_female_treated'],
					'over_15_male_treated' => $row['over_15_male_treated'],
					'over_15_female_treated' =>  $row['over_15_female_treated'],
					'adults_treated' =>  $row['adults_treated'],
					'target_u5' =>  $row['target_u5'],
					'target_sac' => $row['target_sac'],
					'target_adult' =>  $row['target_adult']
				 );
			}

			return $data;
		}


		/**
		* Count the number of any field
		*
		* @param $field
		* @param $table
		* @param district_id
		*/
		public function numPZQ($field,$table,$district_id){
			$sql="SELECT COUNT($field) AS counted FROM $table WHERE district_id ='$district_id' AND ap_attached='Yes'";
			$this->exec($sql);
			$row = $this->single();
			return $row['counted'];

		}

		/**
		* Desctiprion: loop through all the districts and perform the provided quries
		*  
		* @return mixed 
		*/
		function runQueryPZQ(){

			// loop throgh all the districts
			$command="
				SELECT 
				district_id,
				COUNT(school_id) AS schools_treated,
				SUM(ap_6_14_total) AS sac_treated,
				SUM(ap_15_total) AS over_15_treated,
				SUM(ap_6_14_m) AS sac_male_treated,
				SUM(ap_6_14_f) AS sac_female_treated,
				SUM(ap_15_m) AS over_15_male_treated,
				SUM(ap_15_F) AS over_15_female_treated

				FROM a_bysch
				WHERE ap_attached='Yes'
				GROUP BY district_id
			";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'district_id' => $row['district_id'], 
					'schools_treated'=>$row['schools_treated'],
					'sac_treated'=>$row['sac_treated'],
					'over_15_treated'=>$row['over_15_treated'],
					'sac_male_treated'=>$row['sac_male_treated'],
					'sac_female_treated'=>$row['sac_female_treated'],
					'over_15_male_treated'=>$row['over_15_male_treated'],
					'over_15_female_treated'=>$row['over_15_female_treated'],
					'adults_treated' =>"n/a",
					'target_sac' =>"n/a",
					'target_adult' =>"n/a"
				);
			}


			// truncate the table before
			$this->truncateTable($this->table_name_pzq);

			// loop through the array and insert data
			for ($i=0; $i < count($data); $i++) { 
				$this->createPZQ($data[$i]);
			}

		}


		/**
		* Desctiprion: insert data for the method runQuery.
		* 
		* @param mixed.
		*/
		
		public function createPZQ($data=array()){
		  	
		    $id=""; //set the id

			$sql="INSERT INTO $this->table_name_pzq VALUES(
								:id,
								:district_id,
								:schools_treated,
								:sac_treated,
								:over_15_treated,
								:sac_male_treated,
								:sac_female_treated,
								:over_15_male_treated,
								:over_15_female_treated,
								:adults_treated,
								:target_sac,
								:target_adult
					 )";

			$params = array(':id'=>$id,
							':district_id' => $data['district_id'], 
							':schools_treated' => $data['schools_treated'],
							':sac_treated' => $data['sac_treated'],
							':over_15_treated' => $data['over_15_treated'],
							':sac_male_treated' => $data['sac_male_treated'],
							':sac_female_treated' => $data['sac_female_treated'],
							':over_15_male_treated' => $data['over_15_male_treated'],
							':over_15_female_treated' => $data['over_15_female_treated'],
							':adults_treated' => $data['adults_treated'],
							':target_sac' => $data['target_sac'],
							':target_adult' => $data['target_adult']
					 );

			//execute the insert
			$this->exec($sql,$params);

		}


		/**
		* Desctiprion: Get all records.
		*
		* @return mixed $data
		*/
		
		public function getAllPZQ(){
			// run the query and insert into $this->table_name_pzq
			$this->runQueryPZQ();

			$sql="SELECT * FROM $this->table_name_pzq";
			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();

			foreach ($rows as $key => $row) {
				$data[] = array(
					'district_id'=> $row['district_id'],
					'schools_treated' => $row['schools_treated'],
					'sac_treated' =>  $row['sac_treated'],
					'over_15_treated' => $row['over_15_treated'],
					'sac_male_treated' => $row['sac_male_treated'],
					'sac_female_treated' => $row['sac_female_treated'],
					'over_15_male_treated' => $row['over_15_male_treated'],
					'over_15_female_treated' =>  $row['over_15_female_treated'],
					'adults_treated' =>  $row['adults_treated'],
					'target_sac' => $row['target_sac'],
					'target_adult' =>  $row['target_adult']
				 );
			}

			return $data;
		}




	} //end class
 ?>