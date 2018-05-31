<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class logExport extends evidenceAction
	{
		Public $db;  

		Public $hello="Hello";

		Public $expected_MT   = '1'; 
		// Public $expected_P_note = '1 per division';
		Public $expected_ATTNR = '---';
		Public $expected_ATTNT = '---';
		// Public $expected_ATTNC = '---';
		// Public $expected_D = '1 per district';
		Public $expected_D = '1';

		public $table_name ="reverse_log_export";
		public $table_rollout ="rollout_activity";

		Public $no_data= 'N/A';

		/**
		* Description : Expected form S = no. of schoolsin dostrict.
		*
		* @param int $district_id
		* @return int $school_count
		*/
		
		public function expected_s($district_id){

			$school_count = $this->getNoOfSchoolsPerDistrict($district_id);

			// return $school_count." Per District";
			return $school_count;
		}

		public function expected_ATTNT($district_id){

			$school_count = $this->getNoOfSchoolsPerDistrict($district_id);

			// return $school_count." Per District";
			$expected = round($school_count / 20);

			return $expected;
		}

		/**
		* Description : expected form A's = number of divisions in district.
		*
		* @param int $district_id
		* @return int $div_count
		*/
		
		public function expected_A($district_id){
			$div_count = $this->getNoOfDivisonsPerDistict($district_id);

			// return $div_count." Per District";
			return $div_count;
		}


		function __construct(){
			$this->connDB(); //make db connection
		}


		public function create(){
		  	
		  	// add all the values together in the array
		    $arg_list = func_get_args();
		    $id="";

			$sql="INSERT INTO $this->table_name VALUES(
							:id,
							:district_id,
							:end_date,
							:expected,
							:recieved,
							:stamp_range,
							:scrutiny,
							:scanning,
							:courier,
							:date_recieved,
							:form_type )";

			$params = array(':id'=>$id,
							':district_id' 		=> $arg_list[0],
							':end_date' 		=> $arg_list[1],
							':expected' 		=> $arg_list[2],
							':recieved' 		=> $arg_list[3],
							':stamp_range' 		=> $arg_list[4],
							':scrutiny' 		=> $arg_list[5],
							':scanning' 		=> $arg_list[6],
							':courier' 			=> $arg_list[7],
							':date_recieved' 	=> $arg_list[8],
							':form_type' 		=> $arg_list[9] );


			//execute the insert
			$this->exec($sql,$params);

			   $sql = "SELECT * FROM reverse_log_export";
			   $this->exec($sql);
			   $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_export";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'			=> $row['id'],
								'district_id' 	=>$row['district_id'],
								'end_date' 		=>$row['end_date'],
								'expected' 		=>$row['expected'],
								'received' 		=>$row['received'],
								'stamp_range' 	=>$row['stamp_range'],
								'scrutiny' 		=> $row['scrutiny'],
								'scanning'		=> $row['scanning'],
								'courier' 		=> $row['courier'],
								'date_recieved' => $row['date_recieved'],
								'form_type' 	=>$row['form_type']
								);	
			}


			return $data;
		}

		/**
		* Description : this checks whether all documents have been recieved.
		*
		* @param string  $form_type
		* @param int  $district_id
		*/
		
		public function formsReturned($district_id,$form_type){
			$command="SELECT * FROM $this->table_name WHERE district_id = '$district_id' AND form_type = '$form_type'";
			$this->exec($command);
			$row = $this->single();

			$expected= $row['expected'];
			$received= $row['received'];
			$stamp_range= $row['stamp_range'];
			$scrutiny= $row['scrutiny'];
			$scanning= $row['scanning'];
			$courier= $row['courier'];

			$variance=$expected-$received;

			if ($variance==0 && $stamp_range != 'N' && $scrutiny == 'Y' && $scanning == 'Y' && $courier != 'N') {
				return 1;
			}else{
				return 0;
			}

		}

		public function getWarning($end_date,$district_id,$form_type){
			$one_week=604800; // number of seconds in a week
			$two_weeks=$one_week * 2; 
			$after_two_weeks = $two_weeks + $end_date;
			$now=time();
			// IF end date is not there 
			// it has not been planned
			if ($end_date !='---') {
				if ($this->formsReturned($district_id,$form_type) == 0) {
					if ($after_two_weeks > $now) {
						echo '<span title="Should happen two weeks after district training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
					}else{
						echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign glyphicon-ok-sign-blue warning"></span>';
					}
				}else{
					echo '<span title="OK. All forms Recieved" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
				}
			}else{
				echo '<span data-toggle="tooltip" data-placement="left" title="End date has not been set" class="glyphicon glyphicon-minus-sign warning"></span>';
			}
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_export WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'end_date' =>$row['end_date'],
								'expected' =>$row['expected'],
								'received' =>$row['received'],
								'stamp_range' =>$row['stamp_range'],
								'form_type' =>$row['form_type']
								);
			    }

			    return $data;
		}

		public function getByFormType($type_of_form){
			$sql="SELECT * FROM reverse_log_export WHERE form_type=:type_of_form";
			   $params = array(':type_of_form' => $type_of_form);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   $data = array();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'			=> $row['id'],
								'district_id' 	=>$row['district_id'],
								'end_date' 		=>$row['end_date'],
								'expected' 		=>$row['expected'],
								'received' 		=>$row['received'],
								'stamp_range' 	=>$row['stamp_range'],
								'scrutiny' 		=> $row['scrutiny'],
								'scanning' 		=> $row['scanning'],
								'courier' 		=> $row['courier'],
								'date_recieved' => $row['date_recieved'],
								'form_type' 	=>$row['form_type']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE $this->table_name SET
						scrutiny 		= :scrutiny,
						scanning 		= :scanning,
						expected 		= :expected,
						received 		= :received,
						stamp_range 	= :stamp_range,
						courier 		= :courier,
						date_recieved 	= :date_recieved
						WHERE id 		=:id ";

			$params = array(
				'id' 			=>$arg_list[0],
				'expected' 		=>$arg_list[1],
				'received' 		=>$arg_list[2],
				'stamp_range' 	=>$arg_list[3],
				'scrutiny' 		=>$arg_list[4],
				'scanning' 		=>$arg_list[5],
				'courier' 		=>$arg_list[6],
				'date_recieved' =>$arg_list[7]
				);
			//execute the update
			$d=$this->exec($sql,$params);

			// check if it suceeded
			// if ($d==false) {
			// 	die("did not insert");
			// }
			// echo "<pre>";var_dump($d);echo "</pre>";
			// die();
		}

		public function expected_P($district_id){
			$num=$this->getNoOfDivisonsPerDistict($district_id);
			return $num;
		}

		/**
		* Description : Caculate the expected no.of form packets back.
		*
		* @param string  $log. This is the form type
		* @param int  $i this is the div id number 
		* @param int $district_id
		* @return string. HTML table data row
		*/
		
		public function calculateExpecetd($log,$district_id=false){
			switch ($log) {
              case 'MT':
                $expected_value = $this->expected_MT;
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'P':
                $expected_value = $this->expected_P($district_id);
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'ATTNSC':
                $expected_value = $this->expected_ATTNSC();
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'ATTNT':
                $expected_value = $this->expected_ATTNT($district_id);
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'ATTNC':
                $expected_value = $this->expected_ATTNC();
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'D':
                $expected_value = $this->expected_D;
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'S':
                $expected_value = $this->expected_s($district_id);
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              case 'A':
                $expected_value = $this->expected_A($district_id);
                // echo "<td id='expected_td".$i."'>".$expected_value."</td>";
                return $expected_value;
                break;
              default:
              return $this->no_data;
                break;
            }
		}

		public function expected_ATTNSC(){
			//one per district
			return 4;
		}

		public function expected_ATTNC(){
				//one per district
				return 1;
		}

		public function expected_note($log){
			switch ($log) {
              case 'MT':
                return '1';
                break;
              case 'P':
                return '1 per division';
                break;
              case 'ATTNSC':
				return '4 per district';
                break;
              case 'ATTNT':
                return 'schools divided by 20. Rounded off.';
                break;
              case 'ATTNC':
                return '1 per district';
                break;
              case 'D':
                return '1 per district';
                break;
              case 'S':
                return '1 per school';
                break;
              case 'A':
                return '-----';
                break;
              default:
              return $this->no_data;
                break;
            }
		}

		public function delete($id){
			$command="DELETE FROM $this->table_name WHERE id ='$id'";
			$this->exec($command);
		}

		public function updateDates(){
			$command = "SELECT activity_venu, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_type='2' GROUP BY activity_venu";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
				$data[] = array(
					'activity_venu' => $row['activity_venu'], 
					'end_date' => $row['end_date']
				);
			}


			//update
			foreach ($data as $key => $value) {
				
			    $sql="UPDATE $this->table_name SET
							end_date = :end_date
							WHERE district_id=:district_id";

				$params = array(
					':end_date' => $value['end_date'],
					':district_id' =>$this->getDistID($value['activity_venu'])
					);
				//execute the update
				$d=$this->exec($sql,$params);
			}
			
		}

		/**
		* Description : get data from rollout activity that has been planned and inseet into $this->tablename.
		*
		*/
		public function getRolloutData(){
			$sql = "SELECT activity_venu, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_type='2' GROUP BY activity_venu";
			$this->exec($sql);
			$rows = $this->resultset();

			$null="N";
			$null_date="N";
			$form_type = self::form_types();

			foreach ($rows as $row){

				// get the district id from the name
				$district_id=$this->getDistID($row['activity_venu']);
				if ($row['end_date']==NULL) {
					$row['end_date']="---";
					// exit();
				}
				foreach ($form_type as $value) {
					# code...
				
					if ($this->checkDistrict($district_id,$value)==0) {

						//insert data to return from table if its not there
						// use uniqueid
						$this->create($district_id, $row['end_date'], $null, $null, $null, $null, $null, $null,  $null,$value);
					}
				}


			} // end foreach

			$this->updateDates();
		}

		// check whether rollout id exists
		public function checkDistrict($district_id,$form_type){
			$sql="SELECT district_id FROM $this->table_name WHERE district_id='$district_id' AND form_type ='$form_type'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}

		/**
		* Description : minus between expected and recieved.
		*
		* @param int   $expected,$recieved
		* @return int $variance
		*/
		
		public function variance($expected,$recieved){
			// chec if they are integers
			if (is_numeric($expected) && is_numeric($recieved) ) {
				$variance = $expected - $recieved;

				return $variance;
			}else{
				return $expected;
			}
		}




	}// end class





	

	





	

	

 ?>