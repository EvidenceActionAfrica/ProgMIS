<?php 
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class SADReturns extends evidenceAction
	{
		Public $db;

		Public $hello="Hello";

		private $table_name="reverse_sad_returns";

		function __construct(){
			$this->connDB(); //make db connection
		}



		public function create(){
			// get the args into an array
			$arg_list = func_get_args();

			// echo "<pre>";var_dump($arg_list);echo "</pre>";
			// exit();

		    $id="";

			$sql="INSERT INTO $this->table_name VALUES(
							:id,
							:district_id,
							:forms,
							:district_training_end_date,
							:teacher_training_end_date,
							:deworming_day_training_end_date)";

			$params = array(':id'=>$id,
							':district_id'=>$arg_list[0],
							':forms'=>$arg_list[1],
							':district_training_end_date'=>$arg_list[2],
							':teacher_training_end_date'=>$arg_list[3],
							':deworming_day_training_end_date'=>$arg_list[4] );

			//execute the insert
			$this->exec($sql,$params);
			// exit();	
		}

		/**
		* Description : run through the distircts in the table, get the dates from rollout_activity table and update the data.
		*
		*/
		
		public function updateEndDatesStage1(){
			// @todo get all the districts run them through
			$command="SELECT district_id FROM $this->table_name";
			$this->exec($command);
			$rows = $this->resultset();
			
			$data=array(); //create the array
			foreach ($rows as $key => $row) {
					// get the district name
					$district_name = $this->getDistName($row['district_id']);
					// get the training dates
					$district_training_end_date      = $this->getTrainingEndDates($district_name,4);
					$teacher_training_end_date       = $this->getTrainingEndDates($district_name,5);
					$deworming_day_training_end_date = $this->getTrainingEndDates($district_name,6);

					// update the training dates
					$this->	updateEndDatesStage2(   $row['district_id'],
													$district_training_end_date, 
													$teacher_training_end_date, 
													$deworming_day_training_end_date
												);
			}
			
		}

		/**
		* Description : get the data from $this->updateEndDatesStage1 and upddate $this->tablename.
		*
		* @param int $district_id
		* @param string $district_training_end_date
		* @param string $teacher_training_end_date
		* @param string $deworming_day_training_end_date
		*/
		
		public function updateEndDatesStage2($district_id,$district_training_end_date, $teacher_training_end_date, $deworming_day_training_end_date){

			$sql="UPDATE $this->table_name SET
					district_training_end_date      = :district_training_end_date,
					teacher_training_end_date       = :teacher_training_end_date,
					deworming_day_training_end_date = :deworming_day_training_end_date
					WHERE district_id               = :district_id";

			$params = array(
				':district_training_end_date' => $district_training_end_date,
				':teacher_training_end_date' => $teacher_training_end_date,
				':deworming_day_training_end_date' => $deworming_day_training_end_date,
				':district_id'=>$district_id
			);
			//execute the update
			$this->exec($sql,$params);


		}


		public function getAll(){
			// @todo update the end dates
			// @todo task
			$sql = "SELECT * FROM $this->table_name";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
					'district_id'=>$row['district_id'],
					'forms'=>$row['forms'],
					'id'=> $row['id'],
					'district_training_end_date'=> $row['district_training_end_date'],
					'teacher_training_end_date'=> $row['teacher_training_end_date'],
					'deworming_day_training_end_date'=> $row['deworming_day_training_end_date']
				);	
			}


			return $data;
		}

		public function formsReturned($district_id,$activity_type){
			// $activity_type = (int)$activity_type
			// @todo check is p.MT and attnta
			$command="SELECT forms FROM $this->table_name WHERE district_id='$district_id'";
			$this->exec($command);
			$row = $this->single();
			
			$form=explode(",", $row['forms']);
			// planning
			$p     =$form[0];
			$mt    =$form[1];
			$attnt =$form[2];
			// training
			$attnc  =$form[3];
			$attnr  =$form[4];
			// treatment
			$s =$form[5];
			$a =$form[6];
			$d =$form[7];

			if ($activity_type == 4) {
				if ($p=='Y' && $mt == 'Y' && $attnt == 'Y') {
					return 1;
				}else{
					return 0;
				}
			}

			if ($activity_type == 5) {
				if ($attnc=='Y' && $attnr == 'Y') {
					return 1;
				}else{
					return 0;
				}
			}

			if ($activity_type == 6) {
				if ($s=='Y' && $a == 'Y' && $d == 'Y') {
					return 1;
				}else{
					return 0;
				}
			}
		}


		public function getSADWarning($district_id,$end_date,$activity_type){
			$one_week=604800; // number of seconds in a week
			$two_weeks=$one_week * 2; 
			$three_weeks=$one_week * 3; // number of seconds in a week
			$one_month=2628000; // number of seconds in a month

			$after_one_week = $one_week + $end_date;
			$after_two_weeks = $two_weeks + $end_date;
			$after_three_weeks = $three_weeks + $end_date;
			$after_one_month = $one_month + $end_date;
			$now=time();

			$forms_status=$this->formsReturned($district_id,$activity_type);
			
			if ($end_date !='---') {
			
				// exit();
				if ($activity_type == 4) {
					// check if all the forms are yes
					if ($forms_status==0) {
						if ($after_one_week > $now) {
							echo '<span title="Should happen one week after district training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
						}else{	
							echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
						}
					}else{
						echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
					}

					// exit();
				}

				if ($activity_type == 5) {
					
					if ($forms_status==0) {
						if ($after_two_weeks > $now) {
						echo '<span title="Should happen two weeks after teacher training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
						}else{	
							echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
						}
					}else{
						echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
					}
				}

				if ($activity_type == 6) {
					if ($forms_status==0) {
						if ($after_three_weeks > $now) {
						echo '<span title="Should happen three weeks after deworming day" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
						}else{	
							echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
						}
					}else{
						echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
					}
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
						'district_name'=>$row['district_name'],
						'wave'=>$row['wave'],
						'forms'=>$row['forms'],
						'id'=> $row['id']
					);	
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE $this->table_name SET
						forms = :forms
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'forms' =>$arg_list[1]
			);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}

		/**
		* Desctiprion: Delete record.
		*
		* @param int  $id
		*/

		public function delete($id){
			$sql="DELETE FROM $this->table_name WHERE id ='$id'";
			$this->exec($sql);
		}

		public function getTrainingEndDates($activity_venu,$activity_type){
			$command="SELECT end_date FROM rollout_activity where activity_venu ='$activity_venu' AND activity_type ='$activity_type' AND end_date IS NOT NULL";
			$this->exec($command);
			$row = $this->single();
			
			// check if it returned any row
			$count = $this->rowCount();

			if ($count > 0) {
				return $row ['end_date'];
			}else{
				return "---";
			}
		}

		/**
		* Description : get the data from rollout and insert into $this->tablename. Then update the $this->tablename
		*
		*/
		
		public function getRolloutData(){
			$sql = "SELECT activity_type,activity_venu,start_date, end_date FROM rollout_activity WHERE end_date IS NOT NULL AND (activity_type=4 OR activity_type=5 OR  activity_type=6)  GROUP BY activity_venu";
			$this->exec($sql);
			$rows = $this->resultset();
			$null_date="N/A";
			$null_forms="N,N,N,N,N,N,N,N";
			foreach ($rows as $row){
				// get the district id from the name
				$district_id=$this->getDistID($row['activity_venu']);

				$end_date = $row['end_date'];

				// get the end dates
				// switch ($row['activity_type']) {
				// 	case 4:
				// 		$district_training_end_date =$this->getTrainingEndDates($row['activity_venu'],4);
				// 		break;

				// 	case 5:
				// 		$teacher_training_end_date =$this->getTrainingEndDates($row['activity_venu'],5);
				// 		break;

				// 	case 6:
				// 		$deworming_day_training_end_date =$this->getTrainingEndDates($row['activity_venu'],6);
				// 		break;
					
				// }
				$district_training_end_date =$this->getTrainingEndDates($row['activity_venu'],4);
				$teacher_training_end_date =$this->getTrainingEndDates($row['activity_venu'],5);
				$deworming_day_training_end_date =$this->getTrainingEndDates($row['activity_venu'],6);

				// if the district doe not exists
				// add it
				if ($this->checkDistrict($district_id)==0) {

					//insert data to return from table if its not there
					// use uniqueid
					$this->create($district_id, $null_forms, $district_training_end_date, $teacher_training_end_date, $deworming_day_training_end_date);

				}


			}

			// run through the $this->tablename and save update any new data
			$this->updateEndDatesStage1();


		}


		// check whether rollout id exists
		public function checkDistrict($district_id){
			$sql="SELECT district_id FROM $this->table_name WHERE district_id='$district_id'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}


























	}// end class




	

	

 ?>