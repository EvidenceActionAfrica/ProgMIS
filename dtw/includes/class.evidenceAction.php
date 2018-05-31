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

			echo "<pre>";var_dump($data);echo "</pre>";
			exit();
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

		/**
		* Description : get number of schools in district.
		*
		* @param $district_id
		* @return int $row['schools_count']
		*/
		
		public function getNoOfSchoolsPerDistrict($district_id){
			$command="SELECT COUNT(school_id) AS schools_count FROM schools WHERE district_id ='$district_id'";
			$this->exec($command);
			$row = $this->single();

			return $row ['schools_count'];

			
		}

		public function getNoOfDivisonsPerDistict($district_id){
			$command="SELECT COUNT(division_id) AS div_count FROM divisions WHERE district_id ='$district_id'";
			$this->exec($command);
			$row = $this->single();
			
			return $row ['div_count'];
		}

		// get all the districts
		// if division given it seraches the divions table
		//the flowing is the markup for dropdown
		// the snippet is select_district
		/*	
			 foreach ($districts as $key => $value) {
	            echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
	          }
         */
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
				$sql="SELECT * FROM districts";

				$this->exec($sql);
				$rows = $this->resultset();

				$data=array();
				foreach ($rows as $row){
					$data[]=array(
						'district_id'=>$row['district_id'],
						'district_name'=>$row['district_name'],
						'county'=>$row['county'],
						'county_id'=>$row['county_id']
					);
				}

				return $data;
			}
			
		}

		public function getDivisions($district_id=false){

			if ($district_id==true) {
				$sql="SELECT division_id,division_name  FROM divisions WHERE district_id =:district_id";
				$params = array(':district_id' => $district_id);
				$this->exec($sql,$params);
				$rows = $this->resultset();

				$data=array();
				foreach ($rows as $row){
					$data[]=array(
						'division_id'=>$row['division_id'],
						'division_name'=>$row['division_name']
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
						'division_id'=>$row['division_id'],
						'division_name'=>$row['division_name']
					);
				}

				return $data;
			}
			
		}

		// if empty make none
		public static function replace_null($value) {
		 	if (!$value) {
		 		return "no data";
		 	}
	    }

	    /**
	    * Desctiprion: returns 0 for NULL values.
	    *
	    * @param $value
	    * @return int
	    */
	    
		public static function checkIfNull($value) {
		 	if ($value == NULL) {
		 		return 0;
		 	}
	    }

	    //form for 
	    public static function form_types(){
	    	$forms = array('A', 'P', 'MT', 'ATTNT', 'ATTNSC', 'ATTNC', 'D', 'S');

	    	return $forms;
	    }

	    public function getDivName($div_id){
			$sql="SELECT division_name  FROM divisions WHERE division_id =:division_id";
			$params = array(':division_id' => $div_id);
			$this->exec($sql,$params);
			$name = $this->single();


			return $name['division_name'];
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
				return "N/A";
			}else{
				return $name['district_name'];
			}

			 
			
	    }

	    public function getCountyName($county_id){
			$sql="SELECT county  FROM counties WHERE county_id =:county_id";
			$params = array(':county_id' => $county_id);
			$this->exec($sql,$params);
			$name = $this->single();


			return $name['county'];
	    }

	    public function getCountyId($county_name){
			$sql="SELECT county_id  FROM counties WHERE county =:county";
			$params = array(':county' => $county_name);
			$this->exec($sql,$params);
			$name = $this->single();


			return $name['county_id'];
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

	     public function getDistID($dist_name){
			$sql="SELECT district_id  FROM districts WHERE district_name =:district_name";
			$params = array(':district_name' => $dist_name);
			$this->exec($sql,$params);
			$name = $this->single();


			return $name['district_id'];
	    }

	    /**
	    * Desctiprion: Gets all districts
	    *
	    * @return mixed.
	    */
	    public function getAllDistricts(){
	    	// get the districts
			$sql="SELECT DISTINCT(district_id) FROM districts";
			$this->exec($sql);
			$rows = $this->resultset();

			return $rows;
	    }

	    /**
	    * Desctiprion: Gets all shisto districts
	    *
	    * @return mixed.
	    */
	    public function getAllPZQDistricts(){
	    	// get the PZQ districts
			$sql="SELECT DISTINCT(d.district_id) FROM districts AS d
					LEFT JOIN a_bysch AS a
					ON d.district_id = a.district_id
					WHERE a.ap_attached = 'Yes'
				";
			$this->exec($sql);
			$rows = $this->resultset();

			return $rows;
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



         #************************************************#                                
         #     _       _        _                     _   #                               
         #   _| | ___ | |_  ___| |_  ___  ___  _ _  _| |  #                               
         #  / . |<_> || . |<_-<| . \/ . \<_> || '_>/ . |  #                               
         #  \___|<___||_|_|/__/|___/\___/<___||_|  \___|  #                               
         #                                                #                               
         #*************************************************



	    /**
		* Description : get enrolled primary sum form a_bysch
		*
		* @return int $row['pri_sum']
		*/
		
		public function sumEnrolledPriSTH(){
			$command="SELECT SUM(a_trt_m) + SUM(a_trt_f) AS pri_sum FROM a_bysch";
			$this->exec($command);
			$row = $this->single();
			return $row['pri_sum'];
		}


		/**
		* treatment : none*
		* table : any s_bysch
		* no. of parameters : many
		* description : sum up all the adults in s_bysch
		* Note : could modify this to look for Shisto too
		*					 
		*/
		function sumAdultsFormS(){

			$ecd_adult=sumArgs('s_bysch','s_ecd_treated_adult');
			$non_enrolled_adults=sumArgs('s_bysch','s_nonenroll_treated_adult');
			$enrolled_adults=sumArgs(
										's_bysch',
										's_adult_treated1', 's_adult_treated2','s_adult_treated3',
										's_adult_treated4', 's_adult_treated5', 's_adult_treated6', 
										's_adult_treated7', 's_adult_treated8', 's_adult_treated9'
									);			
			
			$total = $ecd_adult+ $non_enrolled_adults+ $enrolled_adults;
			return $total;

		}


		/**
		* treatment : sth and shisto
		* table : any table
		* no. of parameters : 2
		* description: sum the given field for the given table
		*/
		function sumPlain($field,$table){
			$command="SELECT SUM($field) AS dewormed FROM $table";
			$this->exec($command);
			$row = $this->single();
			
			return $row ['dewormed'];
		}



		/**
		* treatment : none
		* table : any table
		* no. of parameters : many
		* description : get the values and add them. 
		*               first parameter is the table.
		*					 
		*/
		function sumArgs(){
			
			$args=func_get_args(); // get the args

			$table=array_shift($args); // get and remove the table

			$size=sizeof($args); // get number of items in array
			$total=0;
			for ($i=0; $i < $size; $i++) { 
				$total+=sumPlain($args[$i],$table);
			}

			return $total;
		}



		/**
		* Description : Sum ECD from table a_bysch.
		*
		* @return int row['ecd_sum']
		*/
		
		public function sumEcdSTH(){
			$command="SELECT SUM(a_ecd_m) + SUM(a_ecd_f) AS ecd_sum FROM a_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['ecd_sum'];
		}

		public function sumNonenrollSTH(){
			$command="  SELECT SUM(a_2_f)+ SUM(a_2_f)+SUM(a_6_f)+ SUM(a_11_f)+ SUM(a_15_f)+ SUM(a_6_m)+ SUM(a_11_m)+ SUM(a_15_m) AS nonenrolled_sum FROM a_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['nonenrolled_sum'];
		}

		/**
		* sum all the STH dewormed children in form A
		*
		*@return mixed
		*/
		
		public function sumSTH(){
			$ecd_sql=$this->sumEcdSTH();

			$pri_sql=$this->sumEnrolledPriSTH();

			$unenrolled_sql=$this->sumNonenrollSTH();

			$total = $ecd_sql+ $pri_sql+ $unenrolled_sql;

			return $total;

		}

		/**
		* Description Sum non enrolled above 6yrs:
		*
		* @return int $row['above_6']
		*/
		
		public function sumNonemrolledAbove6STH(){
			$command="SELECT SUM(a_6_f)+ SUM(a_11_f)+ SUM(a_15_f)+ SUM(a_6_m)+ SUM(a_11_m)+ SUM(a_15_m) AS above_6 FROM a_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['above_6'];
		}


		/**
		* Description : Sums up under 5 children for STH form table a_bysch
		*
		* @return int
		*/
		
		public function u5STH(){
			$command="SELECT SUM(a_ecd_f)+ SUM(a_ecd_m)+ SUM(a_2_f)+ SUM(a_2_m) AS sumUnder5 FROM a_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['sumUnder5'];
		}

		/**
		* Description : sum the primary dewormed kids form table a_bysch.
		*
		* @return int $row['pri_sum']
		*/
		
		public function sumPriPZQ(){
			$command="SELECT SUM(a_trt_m) + SUM(a_trt_f) AS pri_sum FROM a_bysch WHERE ap_attached='Yes'";
			$this->exec($command);
			$row = $this->single();

			return $row['pri_sum'];

		}

		/**
		* Description : Sum non enrolled kids form table a_bysch.
		*
		* @return int $row['nonenrolled_sum']
		*/
		
		public function sumNonenrolledPZQ(){
			$command="  SELECT SUM(a_2_f)+ SUM(a_2_f)+SUM(a_6_f)+ SUM(a_11_f)+ SUM(a_15_f)+ SUM(a_6_m)+ SUM(a_11_m)+ SUM(a_15_m) AS nonenrolled_sum FROM a_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['nonenrolled_sum'];

		}

		/**
		* Description : sum all the dewormed for PZQ form table a_bysch.
		*
		* @return int
		*/
		
		public function sumPZQ(){
			
			$pri = $this->sumPriPZQ();
			$non = $this->sumNonenrolledPZQ();

			$total = $pri + $non;

			return $total;
		}

		/**
		* Description : Sum up the non enrolled kids above 6yrs from table a_bysch.
		*
		* @return int row['nonenroll'] 
		*/
		
		public function sumNonEnrolledAbove6PZQ(){
			$sql="SELECT SUM(a_6_f)+ SUM(a_11_f)+ SUM(a_15_f)+ SUM(a_6_m)+ SUM(a_11_m)+ SUM(a_15_m) AS nonenroll FROM a_bysch";
			$this->exec($sql);
			$row = $this->single();

			return $row['nonenroll'];
		}


		public function sumPbyschSTH(){
				$command="SELECT SUM(p_pri_enroll) + SUM(p_ecd_enroll) + SUM(p_ecd_sa) AS sum_sth FROM p_bysch";
				$this->exec($command);
				$row = $this->single();

				return $row['sum_sth'];
		}

		public function sumUnder5PbyschSTH(){
				$command="SELECT SUM(p_ecd_enroll) + SUM(p_ecd_sa) AS sum_sth FROM p_bysch";
				$this->exec($command);
				$row = $this->single();

				return $row['sum_sth'];
		}


		/**
		* Description : Sum the enrolled primary kids for form p_bysch.
		*
		* @return int $row['pri']
		*/
		
		public function sumEnrolledPriPbysch(){
			$command="SELECT SUM(p_pri_enroll) AS pri FROM p_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['pri'];
		}

		/**
		* Description : Sum enrolled primary kids in table p_bysch for PZQ.
		*
		* @return int $row['pri']
		*/
		
		public function sumEnrolledPriPbyschPZQ(){
			$command="SELECT SUM(p_pri_enroll) AS pri FROM p_bysch WHERE p_sch_bilharzia = 'Y'";
			$this->exec($command);
			$row = $this->single();

			return $row['pri'];
		}

		/**
		* Description : Sume all schools in table p_bysch.
		*
		* @return nt $row['sum_schools']
		*/
		
		public function sumBaselineSchoolsPbysch(){
			$command="SELECT COUNT('p_sch_id') AS sum_schools FROM p_bysch";
			$this->exec($command);
			$row = $this->single();

			return $row['sum_schools'];
		}

		/**
		* Description : Caclulates the percentatge of two products.
		*
		* @param int  $numerator
		* @param int  $denominatior
		* @return string $percentage
		*/
		
		public function calulatePercentage($numerator,$denominatior){
			$val = ($numerator / $denominatior) * 100;

			$percentage = round($val)."%";

			return $percentage;
		}
             
        /**
           * Description : Check privilages for give pages.
           *
           * @param string  $priv_email
           * @return mixed  $data
           */
              
		public function checkPrivilege(){
			$priv_email = $_SESSION['staff_email'];
			$command="SELECT * FROM staff where staff_email='$priv_email'";
			$this->exec($command);
			$rows = $this->resultset();

			$data=array();
			foreach ($rows as $row){
				$data[]=array(
							'priv_requisition' => $row['priv_requisition'],
							'priv_dispatch' => $row['priv_dispatch'],
							'priv_dnote' => $row['priv_dnote'],
							'priv_tab_pickup' => $row['priv_tab_pickup'],
							'priv_shortfall' => $row['priv_shortfall'],
							'priv_tab_return' => $row['priv_tab_return'],
							'priv_forms_attnt_s' => $row['priv_forms_attnt_s'],
							'priv_rap' => $row['priv_rap'],
							'priv_mt' => $row['priv_mt'],
							'priv_materials_edit' => $row['priv_materials_edit'],
							'priv_materials_assumptions' => $row['priv_materials_assumptions'],
							'priv_district_budget' => $row['priv_district_budget'],
							'priv_imp_requests' => $row['priv_imp_requests'],
							'priv_cheque_requests' => $row['priv_cheque_requests'],
							'priv_reconciliation_return' => $row['priv_reconciliation_return'],
							'priv_login_forms_reverse' => $row['priv_login_forms_reverse'],
							'priv_log_forms' => $row['priv_log_forms'],
							'priv_log_forms_analysed' => $row['priv_log_forms_analysed'],
							'priv_standard_reports' => $row['priv_standard_reports'],
							'priv_ciff_kpi' => $row['priv_ciff_kpi'],
							'priv_ciff_report' => $row['priv_ciff_report'],
							'priv_end_fund' => $row['priv_end_fund'],
							'priv_ntd' => $row['priv_ntd'],
							'priv_usaid' => $row['priv_usaid'],
							'priv_who' => $row['priv_who'],
							'priv_demand' => $row['priv_demand'],
							'priv_diagnostics' => $row['priv_diagnostics']
				);
			}

			return $data;
			


		}

	    















	} // end class

 ?>	