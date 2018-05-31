<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class logSA extends evidenceAction
	{
		Public $db;

		Public $hello="Hello";

		private $table_name="reverse_sad_returns";

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

			$sql="INSERT INTO reverse_log_s_a VALUES(
							:id,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6,
							:arg_list_7,
							:arg_list_8,
							:arg_list_9 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4], 
							':arg_list_5'=>$arg_list[5], 
							':arg_list_6'=>$arg_list[6], 
							':arg_list_7'=>$arg_list[7], 
							':arg_list_8'=>$arg_list[8], 
							':arg_list_9'=>$arg_list[9] );

			//execute the insert
			$this->exec($sql,$params);

			   $sql = "SELECT * FROM reverse_log_s_a";
			   $this->exec($sql);
			   $row = $this->single();

			   echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_s_a";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'division_id' =>$row['division_id'],
								's_expected' =>$row['s_expected'],
								's_received' =>$row['s_received'],
								'sp_expected' =>$row['sp_expected'],
								'sp_received' =>$row['sp_received'],
								's_stamp_range' =>$row['s_stamp_range'],
								'a_received' =>$row['a_received'],
								'ap_expected' =>$row['ap_expected'],
								'ap_received' =>$row['ap_received'],
								'a_stamp_range' =>$row['a_stamp_range']
								);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_s_a WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'division_id' =>$row['division_id'],
								's_expected' =>$row['s_expected'],
								's_received' =>$row['s_received'],
								'sp_expected' =>$row['sp_expected'],
								'sp_received' =>$row['sp_received'],
								's_stamp_range' =>$row['s_stamp_range'],
								'a_received' =>$row['a_received'],
								'ap_expected' =>$row['ap_expected'],
								'ap_received' =>$row['ap_received'],
								'a_stamp_range' =>$row['a_stamp_range']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_log_s_a SET
						division_id :division_id,
						s_expected :s_expected,
						s_received :s_received,
						sp_expected :sp_expected,
						sp_received :sp_received,
						s_stamp_range :s_stamp_range,
						a_received :a_received,
						ap_expected :ap_expected,
						ap_received :ap_received,
						a_stamp_range :a_stamp_range
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'division_id' =>$arg_list[1],
				's_expected' =>$arg_list[2],
				's_received' =>$arg_list[3],
				'sp_expected' =>$arg_list[4],
				'sp_received' =>$arg_list[5],
				's_stamp_range' =>$arg_list[6],
				'a_received' =>$arg_list[7],
				'ap_expected' =>$arg_list[8],
				'ap_received' =>$arg_list[9],
				'a_stamp_range' =>$arg_list[10] 	);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}

		public function getRolloutData(){
			$sql = "SELECT activity_type,activity_venu,unique_id,start_date, end_date FROM rollout_activity WHERE start_date AND end_date IS NOT NULL GROUP BY activity_venu";
			$this->exec($sql);
			$rows = $this->resultset();

			$null="N";
			$null_forms="N,N,N,N,N,N,N,N";
			foreach ($rows as $row){

				// get the district id from the name
				$district_id=$this->getDistID($row['activity_venu']);

				// if the district doe not exists
				// add it
				if ($this->checkDistrict($district_id)==0) {

					//insert data to return from table if its not there
					// use uniqueid
					$this->create($district_id,$null, $null_forms);
				}


			}


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