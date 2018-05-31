<?php 
	/**
	* 
	*/
	// require "global.php";
	require "../../includes/class.evidenceAction.php";
	

	class SADReturns extends evidenceAction
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

			$sql="INSERT INTO reverse_sad_returns VALUES(
							:1d,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2 )";

			$params = array(':1d'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_sad_returns";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM reverse_sad_returns";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
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

		public function getById($id){
			(int)$id;
			$sql="SELECT * FROM reverse_sad_returns WHERE id=:id";
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

		    $sql="UPDATE reverse_sad_returns SET
		    			district_name = :district_name,
						wave = :wave,
						forms = :forms
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'district_name' =>$arg_list[1],
				'wave' =>$arg_list[2],
				'forms' =>$arg_list[3]
			);
			//execute the update
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	

 ?>