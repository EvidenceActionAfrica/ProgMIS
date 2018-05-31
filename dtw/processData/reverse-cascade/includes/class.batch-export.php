<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class batchExport extends evidenceAction
	{
		Public $db;  

		Public $hello="Hello";

		private $table_name ="reverse_batch_export";

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
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4],
							':arg_list_5'=>$arg_list[5],
							':arg_list_6'=>$arg_list[6] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_batch_export";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_batch_export";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'date_sent' =>$row['date_sent'],
								'type_of_form' =>$row['type_of_form'],
								'batch' =>$row['batch'],
								'num_sent' =>$row['num_sent'],
								'batch_range' =>$row['batch_range'],
								'end_date' =>$row['end_date']
								);	
			}


			return $data;
		}

		public function getWarning($end_date){
			$one_week=604800; // number of seconds in a week
			$two_weeks=$one_week * 2; 
			$after_two_weeks = $two_weeks + $end_date;
			$now=time();

			if ($after_two_weeks > $now) {
				echo '<span title="Should happen two weeks after district training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
			}else{
				echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
			}
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_batch_export WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'date_sent' =>$row['date_sent'],
								'type_of_form' =>$row['type_of_form'],
								'batch' =>$row['batch'],
								'batch_range' =>$row['batch_range'],
								'num_sent' =>$row['num_sent']
								);
			    }

			    return $data;
		}

		public function getByFormType($type_of_form){
			$sql="SELECT * FROM reverse_batch_export WHERE type_of_form=:type_of_form";
			   $params = array(':type_of_form' => $type_of_form);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   $data = array();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'date_sent' =>$row['date_sent'],
								'type_of_form' =>$row['type_of_form'],
								'batch' =>$row['batch'],
								'batch_range' =>$row['batch_range'],
								'num_sent' =>$row['num_sent'],
								'end_date' =>$row['end_date']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();


		    $sql="UPDATE reverse_batch_export SET
						date_sent   =:date_sent,
						batch 		=:batch,
						batch_range =:batch_range,
						num_sent 	=:num_sent
						WHERE id 	=:id";

			$params = array(
				':id' => $arg_list[0],
				':date_sent' =>$arg_list[1],	
				':batch' =>$arg_list[2],
				':num_sent' =>$arg_list[3],
				':batch_range' =>$arg_list[4]
				);

			//execute the update
			$d=$this->exec($sql,$params);
			// echo "<pre>";var_dump($d);echo "</pre>";


			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}



		public function updateDates(){
			$command = "SELECT activity_type,activity_venu,start_date, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_type=4  GROUP BY activity_venu";
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
		public function getRolloutData(){
			$sql = "SELECT activity_type,activity_venu,start_date, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND activity_type=4  GROUP BY activity_venu";
			$this->exec($sql);
			$rows = $this->resultset();

			$null="---";
			$null_date="---";
			$form_type = self::form_types();
			// echo "<pre>";var_dump($form_type);echo "</pre>";

			// foreach ($form_type as $value) {
			// 	echo $value;
			// 	echo "<br>";
			// }$up
			// exit();
			foreach ($rows as $row){

				// get the district id from the name
				$district_id=$this->getDistID($row['activity_venu']);

				foreach ($form_type as $value) {
					$end_date = $row['end_date']; // end date
					if ($this->checkDistrict($district_id,$value)==0) {

						//insert data to return from table if its not there
						// use district
						$this->create($district_id, $null_date, $value, $null, $null,$null, $end_date);
					}
				}


			} // end foreach

			// update the stuff
			$this->updateDates();

		}

		// check whether rollout id exists
		public function checkDistrict($district_id,$form_type){
			$sql="SELECT district_id FROM $this->table_name WHERE district_id='$district_id' AND type_of_form ='$form_type'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}




	}// end class




	

	

 ?>