<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class logD extends evidenceAction
	{
		Public $db;

		Public $hello="Hello";

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

			$sql="INSERT INTO reverse_log_d VALUES(
							:id,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_log_d";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_d";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'district_id' => $row['district_id'],
								'd_received' => $row['d_received'],
								'dp_received' => $row['dp_received'],
								'd_stamp_id' => $row['d_stamp_id'],
								'dp_expected' => $row['dp_expected']
								);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_d WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' => $row['district_id'],
								'd_received' => $row['d_received'],
								'dp_received' => $row['dp_received'],
								'd_stamp_id' => $row['d_stamp_id'],
								'dp_expected' => $row['dp_expected']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_log_d SET
						district_id :district_id,
						d_received :d_received,
						dp_received :dp_received,
						d_stamp_id :d_stamp_id,
						dp_expected :dp_expected,
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'district_id' =>$arg_list[1],
				'd_received' =>$arg_list[2],
				'dp_received' =>$arg_list[3],
				'd_stamp_id' =>$arg_list[4],
				'dp_expected' =>$arg_list[5]

				);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>