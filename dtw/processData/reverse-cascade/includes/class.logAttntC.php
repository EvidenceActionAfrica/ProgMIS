<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class log_attnt_c extends evidenceAction
	{
		Public $db;

		Public $hello="Hello";

		function __construct()
		{
			$this->connDB(); //make db connection
		}



		public function smallDB(){
			$hostname = 'localhost';
			
			$username = 'root';
			
			$password = '';
			
			$database="evidence_action";
			
			mysql_connect($hostname,$username,$password);
			
			mysql_select_db($database);
		}

		public function create(){
			// get the args into an array
			$arg_list = func_get_args();

			// find number of values in array
		    $numargs = func_num_args();
		  	
		  	// add all the values together in the array
		    $arg_list = func_get_args();
		    $id="";

			$sql="INSERT INTO reverse_log_attnt_c VALUES(
							:id,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6,
							:arg_list_7 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4],
							':arg_list_5'=>$arg_list[5],
							':arg_list_6'=>$arg_list[6],
							':arg_list_7'=>$arg_list[7] );

			//execute the insert
			$this->exec($sql,$params);

			   $sql = "SELECT * FROM reverse_log_attnt_c";
			   $this->exec($sql);
			   $row = $this->single();

			   echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_attnt_c";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'wave_assigned' => $row['wave_assigned'],
								'district_name' => $row['district_name'],
								'division_name' => $row['division_name'],
								'attnt_received' => $row['attnt_received'],
								'attnt_stamp_range' => $row['attnt_stamp_range'],
								'attnc_recieved' => $row['attnc_recieved'],
								'attnc_stamp_range' => $row['attnc_stamp_range'],
								'total_schools_trained' => $row['total_schools_trained']
								);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_attnt_c WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'wave_assigned' => $row['wave_assigned'],
								'district_name' => $row['district_name'],
								'division_name' => $row['division_name'],
								'attnt_received' => $row['attnt_received'],
								'attnt_stamp_range' => $row['attnt_stamp_range'],
								'attnc_recieved' => $row['attnc_recieved'],
								'attnc_stamp_range' => $row['attnc_stamp_range'],
								'total_schools_trained' => $row['total_schools_trained']
								);	
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_log_attnt_c SET
						wave_assigned :wave_assigned,
						district_name :district_name,
						division_name :division_name,
						attnt_received :attnt_received,
						attnt_stamp_range :attnt_stamp_range,
						attnc_recieved :attnc_recieved,
						attnc_stamp_range :attnc_stamp_range,
						total_schools_trained :total_schools_trained,
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'wave_assigned' =>$arg_lis[1],
				'district_name' =>$arg_lis[2],
				'division_name' =>$arg_lis[3],
				'attnt_received' =>$arg_lis[4],
				'attnt_stamp_range' =>$arg_lis[5],
				'attnc_recieved' =>$arg_lis[6],
				'attnc_stamp_range' =>$arg_lis[7],
				'total_schools_trained' =>$arg_lis[8]

				);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>