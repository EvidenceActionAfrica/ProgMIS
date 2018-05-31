<?php 
	/**
	* 
	*/ 
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	 

	class returnStatus extends evidenceAction
	{
		Public $db;  

		Public $hello="Hello";

		private $table_name ="reverse_return_status";


		function __construct()
		{
			$this->connDB(); //make db connection
		}


		public function create(){
			// get the args into an array
			$arg_list = func_get_args();

			// find number of values in array
		    $numargs = func_num_args();
		  	
		  	// add all the values together in the array
		    $arg_list = func_get_args();
		    $id="";

			$sql="INSERT INTO $this->table_name VALUES(
							:id,
							:district_id,
							:regional_training_end,
							:rt_moe_recieved,
							:rt_mophs_recieved,
							:tts_moe_recieved,
							:tts_mophs_recieved,
							:dd_moe_recieved,
							:dd_mophs_recieved
					)";

			$params = array(':id'=>$id,
							':district_id' => $arg_list[0],
							':regional_training_end' => $arg_list[1],
							':rt_moe_recieved' => $arg_list[2],
							':rt_mophs_recieved' => $arg_list[3],
							':tts_moe_recieved' => $arg_list[4],
							':tts_mophs_recieved' => $arg_list[5],
							':dd_moe_recieved' => $arg_list[6],
							':dd_mophs_recieved' => $arg_list[7]

						 );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM $this->table_name";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM $this->table_name";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'regional_training_end' =>$row['regional_training_end'],
								'rt_moe_recieved' =>$row['rt_moe_recieved'],
								'rt_mophs_recieved' =>$row['rt_mophs_recieved'],
								'tts_moe_recieved' =>$row['tts_moe_recieved'],
								'tts_mophs_recieved' =>$row['tts_mophs_recieved'],
								'dd_moe_recieved' =>$row['dd_moe_recieved'],
								'dd_mophs_recieved' =>$row['dd_mophs_recieved']
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
		
		public function formsReturned($district_id){
			$command="SELECT * FROM $this->table_name WHERE district_id = '$district_id' ";
			$this->exec($command);
			$row = $this->single();

			$rt_moe_recieved 		= $row['rt_moe_recieved'];
			$rt_mophs_recieved 		= $row['rt_mophs_recieved'];
			$tts_moe_recieved		= $row['tts_moe_recieved'];
			$tts_mophs_recieved 	= $row['tts_mophs_recieved'];
			$dd_moe_recieved 		= $row['dd_moe_recieved'];
			$dd_mophs_recieved 		= $row['dd_mophs_recieved'];

			if ($rt_moe_recieved =='Y' && $rt_mophs_recieved =='Y' && $tts_moe_recieved =='Y' && $tts_mophs_recieved =='Y' && $dd_moe_recieved =='Y' && $dd_mophs_recieved =='Y') {
				return 1;
			}else{
				return 0;
			}

		}


		public function getWarning($district_id,$end_date){
			// $two_weeks=strtotime("+2 week");
			// $after_two_weeks = $two_weeks + $end_date;
			// $now=time();

			// if ($after_two_weeks > $now) {
			// 	echo '<span title="Not OK" class="glyphicon glyphicon-exclamation-sign"></span>';
			// }else{
			// 	echo '<span title="OK" class="glyphicon glyphicon-ok-sign"></span>';
			// }

			$one_week=604800; // number of seconds in a week
			$two_weeks=$one_week * 2; 
			$after_two_weeks = $two_weeks + $end_date;
			$now=time();
			// IF end date is not there 
			// it has not been planned
			if ($end_date !='---') {
				if ($this->formsReturned($district_id) == 0) {
					if ($after_two_weeks > $now) {
						echo '<span title="Should happen two weeks after teacher training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
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
			$sql="SELECT * FROM $this->table_name WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'regional_training_end' =>$row['regional_training_end'],
								'rt_moe_recieved' =>$row['rt_moe_recieved'],
								'rt_mophs_recieved' =>$row['rt_mophs_recieved'],
								'tts_moe_recieved' =>$row['tts_moe_recieved'],
								'tts_mophs_recieved' =>$row['tts_mophs_recieved'],
								'dd_moe_recieved' =>$row['dd_moe_recieved'],
								'dd_mophs_recieved' =>$row['dd_mophs_recieved']
								);
			    }

			    return $data;
		}

		public function getByFormType($type_of_form){
			$sql="SELECT * FROM $this->table_name WHERE form_type=:type_of_form";
			   $params = array(':type_of_form' => $type_of_form);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   $data = array();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'regional_training_end' =>$row['regional_training_end'],
								'rt_moe_recieved' =>$row['rt_moe_recieved'],
								'rt_mophs_recieved' =>$row['rt_mophs_recieved'],
								'tts_moe_recieved' =>$row['tts_moe_recieved'],
								'tts_mophs_recieved' =>$row['tts_mophs_recieved'],
								'dd_moe_recieved' =>$row['dd_moe_recieved'],
								'dd_mophs_recieved' =>$row['dd_mophs_recieved']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();
			// echo "<pre>";var_dump($arg_list);echo "</pre>";
			// exit();

		    $sql="UPDATE reverse_return_status SET
						rt_moe_recieved = :rt_moe_recieved,
						rt_mophs_recieved = :rt_mophs_recieved,
						tts_moe_recieved = :tts_moe_recieved,
						tts_mophs_recieved = :tts_mophs_recieved,
						dd_moe_recieved = :dd_moe_recieved,
						dd_mophs_recieved = :dd_mophs_recieved
						WHERE id=:id";

			$params = array(
				':id' => $arg_list[0],
				':rt_moe_recieved' => $arg_list[1],
				':rt_mophs_recieved' => $arg_list[2],
				':tts_moe_recieved' => $arg_list[3],
				':tts_mophs_recieved' => $arg_list[4],
				':dd_moe_recieved' => $arg_list[5],
				':dd_mophs_recieved' => $arg_list[6]
			);

			// echo "<pre>";var_dump($params);echo "</pre>";
			// exit();
			//execute the update
			$dd=$this->exec($sql,$params);

			// echo "<pre>";var_dump($dd);echo "</pre>";


		}


		public function updateDates(){
			$command = "SELECT activity_type,activity_venu,start_date, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_type='3' GROUP BY activity_venu";
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
							regional_training_end = :end_date
							WHERE district_id=:district_id";

				$params = array(
					':end_date' => $value['end_date'],
					':district_id' =>$this->getDistID($value['activity_venu'])
					);
				//execute the update
				$d=$this->exec($sql,$params);
			}
			
		}

		
		//gets data from roll out module
		/*
			The folowing is the column order for return status table
			- district_id
			- regional_training_end
			- rt_moe_recieved
			- rt_mophs_recieved
			- tts_moe_recieved
			- tts_mophs_recieved
			- dd_moe_recieved
			- dd_mophs_recieved

		*/



		


		public function getRolloutData(){
			//$sql = "SELECT activity_venu, activity_venu,start_date, max(end_date) as end_date, activity_type, actyvity_county FROM rollout_activity 
					//WHERE activity_type = 3 AND activity_type IS NOT NULL GROUP BY actyvity_county";

			$sql = "SELECT activity_type,activity_venu,start_date, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND  AND activity_type='3' GROUP BY activity_venu";
			$this->exec($sql);
			$rows = $this->resultset();

			$null="N";
			$null_date="N";

			foreach ($rows as $row){

				// get the district id from the name
				$district_id=$this->getDistID($row['activity_venu']);

				if ($this->checkDistrict($district_id)==0) {

					//insert data to return from table if its not there
					// use uniqueid
					$this->create($district_id, $row['end_date'], $null, $null, $null, $null, $null, $null);
				}

			}

			// update the stuff
			$this->updateDates();
		}


		// check whether rollout id exists
		public function checkDistrict($district_id){
			$sql="SELECT district_id FROM $this->table_name WHERE district_id='$district_id'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}

		/**
		* Desctiprion: Delete record.
		*
		* @param int  $id
		*/

		private function delete($id){
			$sql="DELETE FROM $this->table_name WHERE id ='$id'";
			$this->exec($sql);
		}
		

	}// end class





	

	





	

	

 ?>