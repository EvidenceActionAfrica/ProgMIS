<?php 

	/**
	* 
	*/
	// require "../../includes/class.evidenceAction.php";
	require "../../includes/class.evidenceAction.php";
	

	// class ntd extends connDB
	class ntdPZQ extends evidenceAction
	{
		private $table_name_pzq='dashboard_district_ntd_pzq';

		function __construct()
		{
			$this->connDB(); //make db connection
		}

		public function numDistinctFlexiblePZQ($field,$table,$where,$value){
			$sql="SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

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
		* description: sum the given field for the given table 
		* treatment : sth or shisto
		*
		* @param  $field
		* @param $table - any table
		* 
		*/
		function sumPlainPZQ($field,$table,$district_id){
			$sql="SELECT SUM($field) AS dewormed FROM $table WHERE district_id = '$district_id' AND ap_attached='Yes'";
			$this -> exec($sql);
			$row = $this->single();
			return $row['dewormed'];
		}

		/**
		* description: sum the given field for s_bysch
		*
		* @param $field
		* @param  $district_id
		* 
		*/
		function sumPlainFormSPZQ($field,$district_id){
			$sql="SELECT SUM($field) AS dewormed FROM s_bysch WHERE s_district_id = '$district_id' AND sp_attached='Yes'";
			$this -> exec($sql);
			$row = $this->single();
			return $row['dewormed'];
		}


		/**
		* description : get the values and add them. first parameter is the table.
		*
		* @param $table
		* @param $district_id
		* @param $fields
		* @return int $total
		*/
		function sumArgsPZQ(){
			
			$args=func_get_args(); // get the args

			$table=array_shift($args); // get and remove the table

			$district_id=array_shift($args); // get and remove the table

			$size=sizeof($args); // get number of items in array
			$total=0;
			for ($i=0; $i < $size; $i++) { 
				$total+=$this->sumPlainPZQ($args[$i],$table,$district_id);
			}

			return $total;
		}


		/**
		* description : get the values and add them. first parameter is the table.
		*
		* @param $table
		* @param $district_id
		* @param $fields
		* @return int $total
		*/
		function sumArgsFormSPZQ(){
			
			$args=func_get_args(); // get the args

			$table=array_shift($args); // get and remove the table

			$district_id=array_shift($args); // get and remove the table

			$size=sizeof($args); // get number of items in array
			$total=0;
			for ($i=0; $i < $size; $i++) { 
				$total+=$this->sumPlainFormSPZQ($args[$i],$district_id);
			}

			return $total;
		}




		/**
		* Description : sum up all the adults in s_bysch. This is because adults are not in a bysch
		*
		* @param $district_id
		*/
		public function sumAdultsFormSPZQ($district_id){

			$ecd_adult= $this->sumArgsFormSPZQ('s_bysch',$district_id,'s_ecd_treated_adult');
			$non_enrolled_adults= $this->sumArgsFormSPZQ('s_bysch',$district_id,'s_nonenroll_treated_adult');
			$enrolled_adults= $this->sumArgsFormSPZQ(
										's_`bysch',$district_id,
										's_adult_treated1', 's_adult_treated2','s_adult_treated3',
										's_adult_treated4', 's_adult_treated5', 's_adult_treated6', 
										's_adult_treated7', 's_adult_treated8', 's_adult_treated9'
									);			
			
			$total = $ecd_adult+ $non_enrolled_adults+ $enrolled_adults;
			return $total;

		}


		/**
	    * Description: This searches form p. 
	    *
	    * @param $field. 
	    */
		public function sumEstimatedPZQ($field,$district_id){
			$sql="SELECT SUM($field) AS sumEstimated FROM p_bysch WHERE district_id ='$district_id'";
			$this->exec($sql);
			$row = $this->single();
			return $row['sumEstimated'];
		}


		/**
		* Desctiprion: loop through all the districts and perform the provided quries
		*  
		* @return mixed 
		*/
		function runQueryPZQ(){
			//@todo choose only shisto districts
			$rows = $this->getAllPZQDistricts(); // get all distircts

			$data=array(); //create the array

			// loop throgh all the districts
			// do the queries
			foreach ($rows as $key => $value) {
				$schools_treated = $this->numPZQ('school_id','a_bysch',$value['district_id']);
				$sac_treated = 0;
				$over_15_treated = $this->sumArgsPZQ('a_bysch',$value['district_id'],'a_15_m','a_15_f');
				$sac_male_treated = 0;
				$sac_female_treated = 0;
				$over_15_male_treated = $this->sumPlainPZQ('a_15_m','a_bysch',$value['district_id']);
				$over_15_female_treated = $this->sumPlainPZQ('a_15_f','a_bysch',$value['district_id']);
				$adults_treated = $this->sumAdultsFormSPZQ($value['district_id']);
				$target_sac = 0;
				$target_adult = 0;

				// add to $data array
				$data[] = array(
					'district_id' => $value['district_id'], 
					'schools_treated' => $schools_treated,
					'sac_treated' => $sac_treated,
					'over_15_treated' => $over_15_treated,
					'sac_male_treated' => $sac_male_treated,
					'sac_female_treated' => $sac_female_treated,
					'over_15_male_treated' => $over_15_male_treated,
					'over_15_female_treated' => $over_15_female_treated,
					'adults_treated' => $adults_treated,
					'target_sac' => $target_sac,
					'target_adult' => $target_adult

				); 

			}
			
			// truncate the table before
			$this->truncateTable($this->table_name_pzq);

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
		
		public function getAllPZQ(){
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