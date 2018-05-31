<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class countyReturn extends evidenceAction
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

			$sql="INSERT INTO reverse_county_returns VALUES(
							:1d,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6  )";

			$params = array(':1d'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4],
							':arg_list_5'=>$arg_list[5],
							':arg_list_6'=>$arg_list[6]	);

			//execute the insert
			$this->exec($sql,$params);

			   $sql = "SELECT * FROM reverse_cascade_return_status";
			   $this->exec($sql);
			   $row = $this->single();

			   echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_county_returns";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
					'id'=> $row['id'],
					'county_id' => $row['county_id'],
					'wave' => $row['wave'],
					'moe_monitoring' => $row['moe_monitoring'],
					'moe_meeting' => $row['moe_meeting'],
					'mophs_community' => $row['mophs_community'],
					'mophs_monitoring' => $row['mophs_monitoring'],
					'mophs_meeting' => $row['mophs_meeting']
					);	
			}


			return $data;
		}

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_county_returns WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           		'id'=> $row['id'],
						'county_id' => $row['county_id'],
						'wave' => $row['wave'],
						'moe_monitoring' => $row['moe_monitoring'],
						'moe_meeting' => $row['moe_meeting'],
						'mophs_community' => $row['mophs_community'],
						'mophs_monitoring' => $row['mophs_monitoring'],
						'mophs_meeting' => $row['mophs_meeting']
					);	
			    }

			    return $data;
		}


		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_county_returns SET
					    county_id = :county_id,
						wave = :wave,
						moe_monitoring = :moe_monitoring,
						moe_meeting = :moe_meeting,
						mophs_community = :mophs_community,
						mophs_monitoring = :mophs_monitoring,
						mophs_meeting = :mophs_meeting
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'county_id' =>$arg_list[1],
				'wave' =>$arg_list[2],
				'moe_monitoring' =>$arg_list[3],
				'moe_meeting' =>$arg_list[4],
				'mophs_community' =>$arg_list[5],
				'mophs_monitoring' =>$arg_list[6],
				'mophs_meeting' =>$arg_list[7]
			);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>