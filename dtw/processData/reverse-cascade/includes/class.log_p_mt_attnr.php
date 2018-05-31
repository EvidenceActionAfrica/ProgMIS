<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class log_p_mt_attnr extends evidenceAction
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

			$sql="INSERT INTO reverse_log_p_mt_attnr VALUES(
							:id,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4],
							':arg_list_5'=>$arg_list[5] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_log_p_mt_attnr";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_p_mt_attnr";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'district_name' => $row['district_name'],
								'no_received_p' => $row['no_received_p'],
								'stamp_id_range' => $row['stamp_id_range'],
								'mt_stamp_id' => $row['mt_stamp_id'],
								'no_attnr_received' => $row['no_attnr_received'],
								'attnr_stamp_range' => $row['attnr_stamp_range']
								);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_p_mt_attnr WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_name' => $row['district_name'],
								'no_received_p' => $row['no_received_p'],
								'stamp_id_range' => $row['stamp_id_range'],
								'mt_stamp_id' => $row['mt_stamp_id'],
								'no_attnr_received' => $row['no_attnr_received'],
								'attnr_stamp_range' => $row['attnr_stamp_range']
								);	
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_log_p_mt_attnr SET
						 district_name : district_name,
						 no_received_p : no_received_p,
						 stamp_id_range : stamp_id_range,
						 mt_stamp_id : mt_stamp_id,
						 no_attnr_received : no_attnr_received,
						 attnr_stamp_range : attnr_stamp_range
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'district_name' => $arg_list[1],
				'no_received_p' => $arg_list[2],
				'stamp_id_range' => $arg_list[3],
				'mt_stamp_id' => $arg_list[4],
				'no_attnr_received' => $arg_list[5],
				'attnr_stamp_range' => $arg_list[6]

			);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>