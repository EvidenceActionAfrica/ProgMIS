<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class logTab extends evidenceAction
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

			$sql="INSERT INTO reverse_log_tab VALUES(
							:id,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6,
							:arg_list_7,
							:arg_list_8 )";

			$params = array(':id'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4], 
							':arg_list_5'=>$arg_list[5], 
							':arg_list_6'=>$arg_list[6], 
							':arg_list_7'=>$arg_list[7], 
							':arg_list_8'=>$arg_list[8] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_log_tab";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_log_tab";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
								'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'pick_up' =>$row['pick_up'],
								'pick_up_stamp' =>$row['pick_up_stamp'],
								'return_status' =>$row['return_status'],
								'return_stamp' =>$row['return_stamp'],
								'alb_received' =>$row['alb_received'],
								'pzq_received' =>$row['pzq_received'],
								'alb_returned' =>$row['alb_returned'],
								'pzq_returned' =>$row['pzq_returned']
								);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_log_tab WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           				'id'=> $row['id'],
								'district_id' =>$row['district_id'],
								'pick_up' =>$row['pick_up'],
								'pick_up_stamp' =>$row['pick_up_stamp'],
								'return_status' =>$row['return_status'],
								'return_stamp' =>$row['return_stamp'],
								'alb_received' =>$row['alb_received'],
								'pzq_received' =>$row['pzq_received'],
								'alb_returned' =>$row['alb_returned'],
								'pzq_returned' =>$row['pzq_returned']
								);
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_log_tab SET
						district_id :district_id,
						pick_up :pick_up,
						pick_up_stamp :pick_up_stamp,
						return_status :return_status,
						return_stamp :return_stamp,
						alb_received :alb_received,
						pzq_received :pzq_received,
						alb_returned :alb_returned,
						pzq_returned :pzq_returned
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'district_id' =>$arg_list[1],
				'pick_up' =>$arg_list[2],
				'pick_up_stamp' =>$arg_list[3],
				'return_status' =>$arg_list[4],
				'return_stamp' =>$arg_list[5],
				'alb_received' =>$arg_list[6],
				'pzq_received' =>$arg_list[7],
				'alb_returned' =>$arg_list[8],
				'pzq_returned' =>$arg_list[9] );
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>