<?php 

	/**
	* 
	*/
	// require "../../includes/class.evidenceAction.php";
	// require "../../includes/db_class.php";

	require "../../includes/class.evidenceAction.php";

	// class ntd extends connDB
	class ntd extends evidenceAction
	{
		private $table_name='dashboard_district_ntd_sth';
		private $table_name_pzq='dashboard_district_ntd_pzq';
		private $table_name_apendix = 'dashboard_appendix_kpi';

		function __construct()
		{
			$this->connDB(); //make db connection
		}

		/**
		* treatment : all
		* table : any
		* no. of parameters : 2
		* description : counts the distinct given field 
		*/
		function numDistinctPlain($field,$table){
			$command="SELECT DISTINCT($field) FROM $table";

			$this->exec($command);
			$count = $this->rowCount();

			return $count;

		}

		/**
		* Description : Get the districts treated for STH.
		*
		* @return mixed $data
		*/
		
		public function getDistrictsTreatedForSTH(){
			$command="SELECT district_id,district_name,county_name FROM a_bysch GROUP BY district_id";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'district_id' => $row['district_id'], 
					'district_name' => $row['district_name'],
					'county_name' => $row['county_name']
				);
			}
			
			return $data;
		}



		/**
		* Description : Get the districts treated for STH.
		*
		* @return mixed $data
		*/
		
		public function getDivisionsTreatedForSTH(){
			$command="SELECT division_name,district_name,county_name FROM a_bysch GROUP BY division_id";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'division_name' => $row['division_name'], 
					'district_name' => $row['district_name'],
					'county_name' => $row['county_name']
				);
			}
			
			return $data;
		}

		/**
		* Description : Get the schools treated for STH. WHich are all the schools in abysch
		*
		* @return mixed $data
		*/
		
		public function getSchoolsTreatedForSTH(){
			$command="SELECT a_school_name, division_name,district_name,county_name FROM a_bysch";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'a_school_name' => $row['a_school_name'], 
					'division_name' => $row['division_name'], 
					'district_name' => $row['district_name'],
					'county_name' => $row['county_name']
				);
			}
			
			return $data;
		}

		/**
		* Description : Get the schools planned for STH. WHich are all the schools in abysch
		*
		* @return mixed $data
		*/
		
		public function getSchoolsPLannedForSTH(){
			$command="SELECT p_sch_name, division_name,district_name,county_name FROM p_bysch";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'p_sch_name' => $row['p_sch_name'], 
					'division_name' => $row['division_name'], 
					'district_name' => $row['district_name'],
					'county_name' => $row['county_name']
				);
			}
			
			return $data;
		}


		/**
		* Description : Sum estimated population.
		*
		* @return int $row ['EstimatedTotalSTH']
		*/
		
		function global_EstimatedTotalSTH(){
			$command="SELECT 
					SUM(p_pri_enroll)+
					SUM(p_ecd_enroll)+
					SUM(p_ecd_sa_enroll) as EstimatedTotalSTH FROM p_bysch";
			$this->exec($command);
			$row = $this->single();
			
			return $row ['EstimatedTotalSTH'];

		}

		/**
		* Description : Get the list of all schools in p
		*
		* @return int $row ['EstimatedTotalSTH']
		*/
		
		function global_EstimatedTotalSTH_list(){
			$command="SELECT p_pri_enroll, p_ecd_enroll, p_ecd_sa_enroll FROM p_bysch";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'p_sch_name' => $row['p_sch_name'], 
					'division_name' => $row['division_name'], 
					'district_name' => $row['district_name'],
					'county_name' => $row['county_name'],
					'p_pri_enroll' =>$row['p_pri_enroll'],
					'p_ecd_enroll' =>$row['p_ecd_enroll'],
					'p_ecd_sa_enroll' =>$row['p_ecd_sa_enroll']
				);
			}
			
			return $data;

		}





		/**
		* Count the number of any field
		* Takes in a field and table
		*/
		function global_num($field,$table){
			$command="SELECT $field FROM $table";
			// $result=mysql_query($query) or die("<h1>Cannot get ".$field."</h1>".mysql_error());

			// $num= mysql_num_rows($result);

			// return $num;

			$this->exec($command);
			$count = $this->rowCount();

			return $count;
		}



		public function numDistinctFlexible($field,$table,$where,$value){
			$sql="SELECT DISTINCT($field) FROM $table WHERE $where = '$value'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

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
		* Count the number of any field
		*
		* @param $field
		* @param $table
		* @param district_id
		*/
		public function num($field,$table,$district_id){
			$sql="SELECT COUNT($field) AS counted FROM $table WHERE district_id ='$district_id'";
			$this->exec($sql);
			$row = $this->single();
			return $row['counted'];

		}


		/**
		* Adds up all children under five for STH
		*
		* @param district_id
		* @return int
		*/
		
		public function sumUnder5($district_id){
		
			// removed to make query fast
			//$sql="SELECT sum(a_ecd_f) + sum(a_ecd_m) + sum(a_2_f) + sum(a_2_m) AS sumUnder5 FROM a_bysch WHERE district_id = '$district_id'";

			$sql="SELECT sum(a_u5_total) AS sumUnder5 FROM a_bysch WHERE district_id = '$district_id'";
			$this->exec($sql);
			$row = $this->single();
			return $row['sumUnder5'];

		}

		/**
		* description: sum the given field for the given table 
		* treatment : sth or shisto
		*
		* @param  $field
		* @param $table - any table
		* 
		*/
		function sumPlain($field,$table,$district_id){
			$sql="SELECT SUM($field) AS dewormed FROM $table WHERE district_id = '$district_id'";

			// for form s
			if ($field=='s_adult_total') {
				$sql="SELECT SUM($field) AS dewormed FROM $table WHERE s_district_id = '$district_id'";
			}
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
		function sumPlainFormS($field,$district_id){
			$sql="SELECT SUM($field) AS dewormed FROM s_bysch WHERE s_district_id = '$district_id'";
			$this -> exec($sql);
			$row = $this->single();
			return $row['dewormed'];
		}

		/**
		* Description : add male under 5
		*
		* @return int $row
		*/
		
		public function sumUnder5Male($district_id){
			//removed to make query fast 
			// $sql="SELECT SUM(a_ecd_m)+ SUM(a_2_m) AS sumUnder5Male FROM a_bysch WHERE district_id = '$district_id'";

			$sql="SELECT SUM(a_u5_m) AS sumUnder5Male FROM a_bysch WHERE district_id = '$district_id'";
			$this->exec($sql);
			$row = $this->single();
			return $row['sumUnder5Male'];

		}


		/**
		* Description : add female under 5
		*
		* @return int $row
		*/
		
		public function sumUnder5Female($district_id){
			// removed to make query fast 
			//$sql="SELECT SUM(a_ecd_f)+ SUM(a_2_f) AS sumUnder5Female FROM a_bysch WHERE district_id = '$district_id'";
			$sql="SELECT SUM(a_u5_f) AS sumUnder5Female FROM a_bysch WHERE district_id = '$district_id'";
			$this->exec($sql);
			$row = $this->single();
			return $row['sumUnder5Female'];

		}

		/**
		* description : get the values and add them. first parameter is the table.
		*
		* @param $table
		* @param $district_id
		* @param $fields
		* @return int $total
		*/
		function sumArgs(){
			
			$args=func_get_args(); // get the args

			$table=array_shift($args); // get and remove the table

			$district_id=array_shift($args); // get and remove the table

			$size=sizeof($args); // get number of items in array
			$total=0;
			for ($i=0; $i < $size; $i++) { 
				$total+=$this->sumPlain($args[$i],$table,$district_id);
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
		function sumArgsFormS(){
			
			$args=func_get_args(); // get the args

			$table=array_shift($args); // get and remove the table

			$district_id=array_shift($args); // get and remove the table

			$size=sizeof($args); // get number of items in array
			$total=0;
			for ($i=0; $i < $size; $i++) { 
				$total+=$this->sumPlainFormS($args[$i],$district_id);
			}

			return $total;
		}




		/**
		* Description : sum up all the adults in s_bysch. This is because adults are not in a bysch
		*
		* @param $district_id
		*/
		public function sumAdultsFormS($district_id){

			$ecd_adult= $this->sumArgsFormS('s_bysch',$district_id,'s_ecd_treated_adult');
			$non_enrolled_adults= $this->sumArgsFormS('s_bysch',$district_id,'s_nonenroll_treated_adult');
			$enrolled_adults= $this->sumArgsFormS(
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
		public function sumEstimated($field,$district_id){
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

		// ///////////////////////


		


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


		// ################################################################
		#		                                       _ _        _  _______   
		#     /\                              | (_)       | |/ /  __ \_   _| 
		#    /  \   _ __  _ __   ___ _ __   __| |___  __  | ' /| |__) || |   
		#   / /\ \ | '_ \| '_ \ / _ \ '_ \ / _` | \ \/ /  |  < |  ___/ | |   
		#  / ____ \| |_) | |_) |  __/ | | | (_| | |>  <   | . \| |    _| |_  
		# /_/    \_\ .__/| .__/ \___|_| |_|\__,_|_/_/\_\  |_|\_\_|   |_____| 
		#          | |   | |                                                 
		#          |_|   |_|                                                
		#
		####################################################################

		

		public function runKPIQuery(){
			// # of children receiving STH treatment once planning
			$sth_pbysch= $this->sumPbyschSTH();
			// # of children receiving STH treatment once
			$sth_abysch = $this->sumSTH();

			// # of children receiving Schisto treatment once planning
			$pzq_pbysch = $this->sumEnrolledPriPbyschPZQ();
			// # of children receiving Schisto treatment once
			$pzq_abysch = $this->sumPZQ();

			// # enrolled children (aged 6+)* receiving STH Treatment Once planning
			$sth_over6_pbysch = $this->sumEnrolledPriPbysch();
			// # enrolled children (aged 6+)* receiving STH Treatment Once
			$sth_over6_abysch = $this->sumNonemrolledAbove6STH();

			// % enrolled children (aged 6+)* receiving STH treatment once planning
			$sth_over6_pbysch_percentage = 0;
			// % enrolled children (aged 6+)* receiving STH treatment once
			// php shor hand. If denominator is not 0 do the calculation. Otherwise return  0
			$sth_over6_abysch_percentage = $sth_over6_pbysch > 0 ? $this->calulatePercentage($sth_over6_abysch ,$sth_over6_pbysch) : 0;

			// # enrolled children (aged 6+)* receiving schistosomias Treatment Once planning
			$pzq_over6_pbysch = $this->sumEnrolledPriPbyschPZQ();
			// # enrolled children (aged 6+)* receiving schistosomias Treatment Once
			$pzq_over6_abysch=$this->sumNonEnrolledAbove6PZQ();

			// % enrolled children (aged 6+) receiving schistosomias Treatment Once planning
			$pzq_over6_pbysch_percentage = 0;
			// % enrolled children (aged 6+) receiving schistosomias Treatment Once
			// php shor hand. If denominator is not 0 do the calculation. Otherwise return  0
			$pzq_over6_abysch_percentage = $pzq_over6_pbysch > 0 ? $this->calulatePercentage($pzq_over6_abysch,$pzq_over6_pbysch) : 0;

			// No. of non-enrolled children (aged 6+) dewormed for STH planning
			$sth_nonenrolled_over6Pbysch =0;

			// No. of non-enrolled children (aged 6+) dewormed for STH form a_bysch
			$sth_nonenrolled_over6 = $this->sumNonemrolledAbove6STH();


			// % increase in # non-enrolled children (aged 6+) dewormed for STH compared to year one of programme
			// % increase in # non-enrolled children (aged 6+) dewormed for STH compared to year one of programme


			// No. of non-enrolled children (aged 6+) dewormed for Schistosomiasis planning
			// because there are no 
			$pzq_nonenrolled_pbysch = 0;
			// No. of non-enrolled children (aged 6+) dewormed for Schistosomiasis
			$pzq_nonenrolledover6_abysch = $this->sumNonEnrolledAbove6PZQ();


			// % increase in # non-enrolled children (aged 6+) dewormed for Schistosomiasis compared to year one of programme
			$pzq_non_enrolled_over6_percentage_increase_from_revious_year = 0;
			// # children aged 5 and under receiving treatment for STH planning
			$sumUnder5PbyschSTH = $this->u5STH();
			// # children aged 5 and under receiving treatment for STH
			$sth_under5 = $this->u5STH();

			// % increase in children aged 5 and under receiving treatment for STH
			$sth_under5_percentage_increase_from_previous_year = 0;

			// @todo 
			// % target schools attending teacher training sessions_planing
			$target_school_attending_tt_planning = 0;
			// % target schools attending teacher training sessions
			$target_school_attending_tt = 0;

			// % TT sessions where albendazole (and praziquantel if necessary) are available on the day of training_planing
			$tt_alb_pzq_available_day_of_training_planning = 0;
			// % TT sessions where albendazole (and praziquantel if necessary) are available on the day of training
			$tt_alb_pzq_available_day_of_training = 0;

			// % schools attending teacher trainings receiving all critical materials for deworming day at teacher trainings. (critical is defined as: drugs, poles, monitoring forms)_planing
			$schools_with_critical_tt_materials_planning = 0;
			// % schools attending teacher trainings receiving all critical materials for deworming day at teacher trainings. (critical is defined as: drugs, poles, monitoring forms)
			$schools_with_critical_tt_materials = 0;

			// % parents interviewed who were aware of deworming day prior to the event_planing
			$percentage_parents_inteviwed_aeare_of_dd_planning = 0;
			// % parents interviewed who were aware of deworming day prior to the event
			$percentage_parents_inteviwed_aeare_of_dd = 0;

			// % standalone ECD centres who were aware about deworming day prior to the event_planing
			$percentage_ecd_centers_aware_about_dd_planning = 0;
			// % standalone ECD centres who were aware about deworming day prior to the event
			$percentage_ecd_centers_aware_about_dd = 0;

			// % schools performing deworming on designated County deworming day_planing
			$percentage_schools_dewormed_on_designated_dd_planning=0;
			// % schools performing deworming on designated County deworming day
			$percentage_schools_dewormed_on_designated_dd=0;

			// % Districts submitting forms S,A,and D to National level within three months of deworming day_planing
			$percentage_districts_submitting_SAD_within_3months_planning = 0;
			// % Districts submitting forms S,A,and D to National level within three months of deworming day
			$percentage_districts_submitting_SAD_within_3months = 0;

			// % divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed._planing
			$percentage_div_reporting_children_dewormed_planning = 0;
			// % divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.
			$percentage_div_reporting_children_dewormed = 0;

			// % districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed._planing
			$percentage_districts_reporting_children_dewormed_planning = 0;
			// % districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed.
			$percentage_districts_reporting_children_dewormed = 0;



			// echo "<br>sth_pbysch = ".$sth_pbysch;
			// echo "<br>sth_abysch = ".$sth_abysch;
			// echo "<br>pzq_pbysch = ".$pzq_pbysch;
			// echo "<br>pzq_abysch = ".$pzq_abysch;
			// echo "<br>sth_over6_pbysch = ".$sth_over6_pbysch;
			// echo "<br>sth_over6_abysch = ".$sth_over6_abysch;
			// echo "<br>sth_over6_pbysch_percentage = ".$sth_over6_pbysch_percentage;
			// echo "<br>sth_over6_abysch_percentage = ".$sth_over6_abysch_percentage;
			// echo "<br>pzq_over6_pbysch = ".$pzq_over6_pbysch;
			// echo "<br>pzq_over6_abysch = ".$pzq_over6_abysch;
			// echo "<br>pzq_over6_pbysch_percentage = ".$pzq_over6_pbysch_percentage;
			// echo "<br>pzq_over6_abysch_percentage = ".$pzq_over6_abysch_percentage;
			// echo "<br>sth_ninenrolled_pbysch = ".$sth_ninenrolled_pbysch;
			// echo "<br>pzq_nonenrolled_abysch = ".$pzq_nonenrolled_abysch;
			// echo "<br>pzq_nonenrolledover6_abysch = ".$pzq_nonenrolledover6_abysch;
			// $data=array();
			// prepare array for insertion
			$date =date('m-d-y');
			$progress = 0;
			$data = array(
				'date' => $date,
				'progress'=>$progress,
				'sth_pbysch' => $sth_pbysch,
				'sth_abysch' => $sth_abysch,
				'pzq_pbysch' => $pzq_pbysch,
				'pzq_abysch' => $pzq_abysch,

				'sth_over6_pbysch' => $sth_over6_pbysch,
				'sth_over6_abysch' => $sth_over6_abysch,
				'sth_over6_pbysch_percentage' => $sth_over6_pbysch_percentage,
				'sth_over6_abysch_percentage' => $sth_over6_abysch_percentage,

				'pzq_over6_pbysch' => $pzq_over6_pbysch,
				'pzq_over6_abysch' => $pzq_over6_abysch,
				'pzq_over6_pbysch_percentage' => $pzq_over6_pbysch_percentage,
				'pzq_over6_abysch_percentage' => $pzq_over6_abysch_percentage,

				'sth_nonenrolled_over6Pbysch' =>$sth_nonenrolled_over6Pbysch,
				'sth_nonenrolled_over6' =>$sth_nonenrolled_over6,

				//does not need two. just the planned part
				'pzq_non_enrolled_over6_percentage_increase_from_revious_year' =>$pzq_non_enrolled_over6_percentage_increase_from_revious_year,

				'pzq_nonenrolled_pbysch' => $pzq_nonenrolled_pbysch,
				'pzq_nonenrolledover6_abysch' => $pzq_nonenrolledover6_abysch,
				// hust one. the planning column
				'sth_under5_percentage_increase_from_previous_year' =>$sth_under5_percentage_increase_from_previous_year,

				'sumUnder5PbyschSTH' => $sumUnder5PbyschSTH,
				'sth_under5' => $sth_under5,

				'target_school_attending_tt_planning' => $target_school_attending_tt_planning,
				'target_school_attending_tt' => $target_school_attending_tt,

				'tt_alb_pzq_available_day_of_training_planning' => $tt_alb_pzq_available_day_of_training_planning,
				'tt_alb_pzq_available_day_of_training' => $tt_alb_pzq_available_day_of_training,

				'schools_with_critical_tt_materials_planning' => $schools_with_critical_tt_materials_planning,
				'schools_with_critical_tt_materials' => $schools_with_critical_tt_materials,

				'percentage_parents_inteviwed_aeare_of_dd_planning' => $percentage_parents_inteviwed_aeare_of_dd_planning,
				'percentage_parents_inteviwed_aeare_of_dd' => $percentage_parents_inteviwed_aeare_of_dd,

				'percentage_ecd_centers_aware_about_dd_planning' => $percentage_ecd_centers_aware_about_dd_planning,
				'percentage_ecd_centers_aware_about_dd' => $percentage_ecd_centers_aware_about_dd,

				'percentage_schools_dewormed_on_designated_dd_planning' => $percentage_schools_dewormed_on_designated_dd_planning,
				'percentage_schools_dewormed_on_designated_dd' => $percentage_schools_dewormed_on_designated_dd,

				'percentage_districts_submitting_SAD_within_3months_planning' => $percentage_districts_submitting_SAD_within_3months_planning,
				'percentage_districts_submitting_SAD_within_3months' => $percentage_districts_submitting_SAD_within_3months,

				'percentage_div_reporting_children_dewormed_planning' => $percentage_div_reporting_children_dewormed_planning,
				'percentage_div_reporting_children_dewormed' => $percentage_div_reporting_children_dewormed,

				'percentage_districts_reporting_children_dewormed_planning' => $percentage_districts_reporting_children_dewormed_planning,
				'percentage_districts_reporting_children_dewormed' => $percentage_districts_reporting_children_dewormed



				);

echo "<pre>";var_dump($data);echo "</pre>";
// exit();

				// create the data

				$this->createApendix($data);








		}
		/**
		* Desctiprion: insert data for the method runQuery.
		* 
		* @param mixed.
		*/
		
		public function createApendix($data=array()){
		  	
		    $id=""; //set the id

			$sql="INSERT INTO $this->table_name_apendix VALUES(
								:id,
								:date,
								:progress,
								:sth_pbysch,
								:sth_abysch,
								:pzq_pbysch,
								:pzq_abysch,
								:sth_over6_pbysch,
								:sth_over6_abysch,
								:sth_over6_pbysch_percentage,
								:sth_over6_abysch_percentage,
								:pzq_over6_pbysch,
								:pzq_over6_abysch,
								:pzq_over6_pbysch_percentage,
								:pzq_over6_abysch_percentage,
								:sth_nonenrolled_over6Pbysch,
								:sth_nonenrolled_over6,
								:pzq_non_enrolled_over6_percentage_increase_from_revious_year,
								:pzq_nonenrolled_pbysch,
								:pzq_nonenrolledover6_abysch,
								:sth_under5_percentage_increase_from_previous_year,
								:sumUnder5PbyschSTH,
								:sth_under5,
								:target_school_attending_tt_planning,
								:target_school_attending_tt,
								:tt_alb_pzq_available_day_of_training_planning,
								:tt_alb_pzq_available_day_of_training,
								:schools_with_critical_tt_materials_planning,
								:schools_with_critical_tt_materials,
								:percentage_parents_inteviwed_aeare_of_dd_planning,
								:percentage_parents_inteviwed_aeare_of_dd,
								:percentage_ecd_centers_aware_about_dd_planning,
								:percentage_ecd_centers_aware_about_dd,
								:percentage_schools_dewormed_on_designated_dd_planning,
								:percentage_schools_dewormed_on_designated_dd,
								:percentage_districts_submitting_SAD_within_3months_planning,
								:percentage_districts_submitting_SAD_within_3months,
								:percentage_div_reporting_children_dewormed_planning,
								:percentage_div_reporting_children_dewormed,
								:percentage_districts_reporting_children_dewormed_planning,
								:percentage_districts_reporting_children_dewormed
					 )";
			$params = array(':id'=>$id,
							':date' => $data['date'],
							':progress' => $data['progress'],
							':sth_pbysch' => $data['sth_pbysch'],
							':sth_abysch' => $data['sth_abysch'],
							':pzq_pbysch' => $data['pzq_pbysch'],
							':pzq_abysch' => $data['pzq_abysch'],
							':sth_over6_pbysch' => $data['sth_over6_pbysch'],
							':sth_over6_abysch' => $data['sth_over6_abysch'],
							':sth_over6_pbysch_percentage' => $data['sth_over6_pbysch_percentage'],
							':sth_over6_abysch_percentage' => $data['sth_over6_abysch_percentage'],
							':pzq_over6_pbysch' => $data['pzq_over6_pbysch'],
							':pzq_over6_abysch' => $data['pzq_over6_abysch'],
							':pzq_over6_pbysch_percentage' => $data['pzq_over6_pbysch_percentage'],
							':pzq_over6_abysch_percentage' => $data['pzq_over6_abysch_percentage'],
							':sth_nonenrolled_over6Pbysch' => $data['sth_nonenrolled_over6Pbysch'],
							':sth_nonenrolled_over6' => $data['sth_nonenrolled_over6'],
							':pzq_non_enrolled_over6_percentage_increase_from_revious_year' => $data['pzq_non_enrolled_over6_percentage_increase_from_revious_year'],
							':pzq_nonenrolled_pbysch' => $data['pzq_nonenrolled_pbysch'],
							':pzq_nonenrolledover6_abysch' => $data['pzq_nonenrolledover6_abysch'],
							':sth_under5_percentage_increase_from_previous_year' => $data['sth_under5_percentage_increase_from_previous_year'],
							':sumUnder5PbyschSTH' => $data['sumUnder5PbyschSTH'],
							':sth_under5' => $data['sth_under5'],
							':target_school_attending_tt_planning' => $data['target_school_attending_tt_planning'],
							':target_school_attending_tt' => $data['target_school_attending_tt'],
							':tt_alb_pzq_available_day_of_training_planning' => $data['tt_alb_pzq_available_day_of_training_planning'],
							':tt_alb_pzq_available_day_of_training' => $data['tt_alb_pzq_available_day_of_training'],
							':schools_with_critical_tt_materials_planning' => $data['schools_with_critical_tt_materials_planning'],
							':schools_with_critical_tt_materials' => $data['schools_with_critical_tt_materials'],
							':percentage_parents_inteviwed_aeare_of_dd_planning' => $data['percentage_parents_inteviwed_aeare_of_dd_planning'],
							':percentage_parents_inteviwed_aeare_of_dd' => $data['percentage_parents_inteviwed_aeare_of_dd'],
							':percentage_ecd_centers_aware_about_dd_planning' => $data['percentage_ecd_centers_aware_about_dd_planning'],
							':percentage_ecd_centers_aware_about_dd' => $data['percentage_ecd_centers_aware_about_dd'],
							':percentage_schools_dewormed_on_designated_dd_planning' => $data['percentage_schools_dewormed_on_designated_dd_planning'],
							':percentage_schools_dewormed_on_designated_dd' => $data['percentage_schools_dewormed_on_designated_dd'],
							':percentage_districts_submitting_SAD_within_3months_planning' => $data['percentage_districts_submitting_SAD_within_3months_planning'],
							':percentage_districts_submitting_SAD_within_3months' => $data['percentage_districts_submitting_SAD_within_3months'],
							':percentage_div_reporting_children_dewormed_planning' => $data['percentage_div_reporting_children_dewormed_planning'],
							':percentage_div_reporting_children_dewormed' => $data['percentage_div_reporting_children_dewormed'],
							':percentage_districts_reporting_children_dewormed_planning' => $data['percentage_districts_reporting_children_dewormed_planning'],
							':percentage_districts_reporting_children_dewormed' => $data['percentage_districts_reporting_children_dewormed']

					 );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_sad_returns";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}

		public function getAllApendix(){
			$command="SELECT * FROM $this->table_name_apendix";
			$this->exec($command);
			$rows = $this->resultset();
			foreach ($rows as $key => $row) {
				$data[] = array(
					'date' => $row['date'],
					'progress'=>$row['progress'],
					'sth_pbysch' => $row['sth_pbysch'],
					'sth_abysch' => $row['sth_abysch'],
					'pzq_pbysch' => $row['pzq_pbysch'],
					'pzq_abysch' => $row['pzq_abysch'],
					'sth_over6_pbysch' => $row['sth_over6_pbysch'],
					'sth_over6_abysch' => $row['sth_over6_abysch'],
					'sth_over6_pbysch_percentage' => $row['sth_over6_pbysch_percentage'],
					'sth_over6_abysch_percentage' => $row['sth_over6_abysch_percentage'],
					'pzq_over6_pbysch' => $row['pzq_over6_pbysch'],
					'pzq_over6_abysch' => $row['pzq_over6_abysch'],
					'pzq_over6_pbysch_percentage' => $row['pzq_over6_pbysch_percentage'],
					'pzq_over6_abysch_percentage' => $row['pzq_over6_abysch_percentage'],
					'sth_nonenrolled_over6Pbysch' =>$row['sth_nonenrolled_over6Pbysch'],
					'sth_nonenrolled_over6' =>$row['sth_nonenrolled_over6'],
					'pzq_non_enrolled_over6_percentage_increase_from_revious_year' =>$row['pzq_non_enrolled_over6_percentage_increase_from_revious_year'],
					'pzq_nonenrolled_pbysch' => $row['pzq_nonenrolled_pbysch'],
					'pzq_nonenrolledover6_abysch' => $row['pzq_nonenrolledover6_abysch'],
					'sth_under5_percentage_increase_from_previous_year' =>$row['sth_under5_percentage_increase_from_previous_year'],
					'sumUnder5PbyschSTH' => $row['sumUnder5PbyschSTH'],
					'sth_under5' => $row['sth_under5'],
					'target_school_attending_tt_planning' => $row['target_school_attending_tt_planning'],
					'target_school_attending_tt' => $row['target_school_attending_tt'],
					'tt_alb_pzq_available_day_of_training_planning' => $row['tt_alb_pzq_available_day_of_training_planning'],
					'tt_alb_pzq_available_day_of_training' => $row['tt_alb_pzq_available_day_of_training'],
					'schools_with_critical_tt_materials_planning' => $row['schools_with_critical_tt_materials_planning'],
					'schools_with_critical_tt_materials' => $row['schools_with_critical_tt_materials'],
					'percentage_parents_inteviwed_aeare_of_dd_planning' => $row['percentage_parents_inteviwed_aeare_of_dd_planning'],
					'percentage_parents_inteviwed_aeare_of_dd' => $row['percentage_parents_inteviwed_aeare_of_dd'],
					'percentage_ecd_centers_aware_about_dd_planning' => $row['percentage_ecd_centers_aware_about_dd_planning'],
					'percentage_ecd_centers_aware_about_dd' => $row['percentage_ecd_centers_aware_about_dd'],
					'percentage_schools_dewormed_on_designated_dd_planning' => $row['percentage_schools_dewormed_on_designated_dd_planning'],
					'percentage_schools_dewormed_on_designated_dd' => $row['percentage_schools_dewormed_on_designated_dd'],
					'percentage_districts_submitting_SAD_within_3months_planning' => $row['percentage_districts_submitting_SAD_within_3months_planning'],
					'percentage_districts_submitting_SAD_within_3months' => $row['percentage_districts_submitting_SAD_within_3months'],
					'percentage_div_reporting_children_dewormed_planning' => $row['percentage_div_reporting_children_dewormed_planning'],
					'percentage_div_reporting_children_dewormed' => $row['percentage_div_reporting_children_dewormed'],
					'percentage_districts_reporting_children_dewormed_planning' => $row['percentage_districts_reporting_children_dewormed_planning'],
					'percentage_districts_reporting_children_dewormed' => $row['percentage_districts_reporting_children_dewormed']

				);

			}

			return $data;
		}





















	} //end class
 ?>