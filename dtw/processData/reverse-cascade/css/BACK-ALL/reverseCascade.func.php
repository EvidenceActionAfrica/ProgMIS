<?php 
	/**
	* 
	*/
	require "global.php";
	// require "../../includes/db_conf.php"; require "../../includes/db_class.php";
	

	class reverseCascade extends connDB
	{
		Public $db;

		Public $hello="Hello";

		function __construct()
		{
			// echo $this->hello;
			$this->connDB();
			// $this->db = new connDB();
		}

		public function getDivisions($district_id=false){
			
			if ($district_id==true) {
				$query="SELECT division_id, division_name  FROM divisions WHERE district_id ='$district_id'";

				$result=mysql_query($query) or die("<h1>function name: getDivisions <br>Cannot get divisions</h1>".mysql_error());

				$data=array();
				while ($row=mysql_fetch_assoc($result)) {
					$data[]=array(
						'division_id'=>$row['division_id'],
						'division_name'=>$row['division_name']
					);
				}

				return $data;
			}else{
				$query="SELECT division_id AS div_id FROM divisions";

				$result=mysql_query($query) or die("<h1>function name: getDivisions <br>Cannot get divisions</h1>".mysql_error());

				$data=array();
				while ($row=mysql_fetch_assoc($result)) {
					$data[]=array(
						'division_id'=>$row['div_id']
					);
				}

				return $data;
			}
		}


		// get all the districts
		// if division given it seraches the divions table
		public function getDistricts($county_id=false){

			if ($county_id==true) {
				$query="SELECT district_id,district_name  FROM districts WHERE county_id ='$county_id'";

				$result=mysql_query($query) or die("<h1>function name: getDistricts <br>Cannot get districts</h1>".mysql_error());

				$data=array();
				while ($row=mysql_fetch_assoc($result)) {	
					$data[]=array(
						'district_id'=>$row['district_id'],
						'district_name'=>$row['district_name']
					);
				}

				return $data;
			}else{
				$query="SELECT district_id, district_name FROM districts";

				$result=mysql_query($query) or die("<h1>function name: getDistricts <br>Cannot get districts</h1>".mysql_error());

				$data=array();
				while ($row=mysql_fetch_assoc($result)) {
					$data[]=array(
						'district_id'=>$row['district_id'],
						'district_name'=>$row['district_name']
					);
				}

				return $data;
			}
			
		}

		public function getCounties(){
			$query="SELECT county_id,county  FROM counties";

			$result=mysql_query($query) or die("<h1>function name: getCounties <br>Cannot get counties</h1>".mysql_error());

			$data=array();
			while ($row=mysql_fetch_assoc($result)) {
				$data[]=array(
					'county_id'=>$row['county_id'],
					'county_name'=>$row['county']
				);
			}

			return $data;
		}

		public function smallDB(){
			$hostname = 'localhost';
			
			$username = 'root';
			
			$password = '';
			
			$database="evidence_action";
			
			mysql_connect($hostname,$username,$password);
			
			mysql_select_db($database);
		}

		public function createReturnStatus(){
			// get the args into an array
			$arg_list = func_get_args();

			// find number of values in array
		    $numargs = func_num_args();
		  	
		  	// add all the values together in the array
		    $arg_list = func_get_args();
		    $id="";

			$sql="INSERT INTO reverse_cascade_return_status VALUES(
							:1d,
							:arg_list_0,
							:arg_list_1,
							:arg_list_2,
							:arg_list_3,
							:arg_list_4,
							:arg_list_5,
							:arg_list_6,
							:arg_list_7,
							:arg_list_8,
							:arg_list_9,
							:arg_list_10 )";

			$params = array(':1d'=>$id,
							':arg_list_0'=>$arg_list[0],
							':arg_list_1'=>$arg_list[1],
							':arg_list_2'=>$arg_list[2],
							':arg_list_3'=>$arg_list[3],
							':arg_list_4'=>$arg_list[4],
							':arg_list_5'=>$arg_list[5],
							':arg_list_6'=>$arg_list[6],
							':arg_list_7'=>$arg_list[7],
							':arg_list_8'=>$arg_list[8],
							':arg_list_9'=>$arg_list[9],
							':arg_list_10'=>$arg_list[10] );

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM reverse_cascade_return_status";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		echo "done";
		}


		public function getAllReturnStatus(){

			$sql = "SELECT * FROM reverse_cascade_return_status";
			$this->exec($sql);
			$rows = $this->resultset();

			foreach ($rows as $row){
				$data[] = array(
						'id'=>$row['id'],
						'district_name' => $row['district_name'],
						'wave' => $row['wave'],
						'regional_training_end' => $row['regional_training_end'],
						'rt_moe_recieved' => $row['rt_moe_recieved'],
						'rt_mophs_recieved' => $row['rt_mophs_recieved'],
						'tts_end_mt' => $row['tts_end_mt'],
						'tts_moe_recieved' => $row['tts_moe_recieved'],
						'tts_mophs_recieved' => $row['tts_mophs_recieved'],
						'district_deworming_day' => $row['district_deworming_day'],
						'dd_moe_recieved' => $row['dd_moe_recieved'],
						'dd_mophs_recieved' => $row['dd_mophs_recieved']
					);	
			}


			return $data;
		}

		public function get_return_status_byId($id){
			(int)$id;
			$sql="SELECT * FROM reverse_cascade_return_status WHERE id=:id";
			   $params = array(':id' => $id);
			   $this->exec($sql, $params);
			   $rows = $this->resultset();
			   foreach ($rows as $row){
		           $data[] = array(
		           		'id'=>$row['id'],
						'district_name' => $row['district_name'],
						'wave' => $row['wave'],
						'regional_training_end' => $row['regional_training_end'],
						'rt_moe_recieved' => $row['rt_moe_recieved'],
						'rt_mophs_recieved' => $row['rt_mophs_recieved'],
						'tts_end_mt' => $row['tts_end_mt'],
						'tts_moe_recieved' => $row['tts_moe_recieved'],
						'tts_mophs_recieved' => $row['tts_mophs_recieved'],
						'district_deworming_day' => $row['district_deworming_day'],
						'dd_moe_recieved' => $row['dd_moe_recieved'],
						'dd_mophs_recieved' => $row['dd_mophs_recieved']
					);	
			    }

			    return $data;
		}


		public function update_return_status(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE reverse_cascade_return_status SET
					district_name = :district_name,
					wave = :wave,
					regional_training_end = :regional_training_end,
					rt_moe_recieved = :rt_moe_recieved,
					rt_mophs_recieved = :rt_mophs_recieved,
					tts_end_mt = :tts_end_mt,
					tts_moe_recieved = :tts_moe_recieved,
					tts_mophs_recieved = :tts_mophs_recieved,
					district_deworming_day = :district_deworming_day,
					dd_moe_recieved = :dd_moe_recieved WHERE id=:id";

			$params = array(
					'id' => $arg_list[0],
					'district_name' => $arg_list[1],
					'wave' => $arg_list[2],
					'regional_training_end' => $arg_list[3],
					'rt_moe_recieved' => $arg_list[4],
					'rt_mophs_recieved' => $arg_list[5],
					'tts_end_mt' => $arg_list[6],
					'tts_moe_recieved' => $arg_list[7],
					'tts_mophs_recieved' => $arg_list[8],
					'district_deworming_day' => $arg_list[9],
					'dd_moe_recieved' => $arg_list[10]
					);
			$this->exec($sql,$params);

					

			// $sql = "UPDATE < table > SET < column_1 > = :valuename_1 WHERE < column_2 > = :valuename_2";
			// $params = array(':valuename_1' => 'value', ':valuename_2' => 'value');
			// $db->exec($sql, $params);
		}




	}// end class




	

	$Cascade = New reverseCascade();

	// this is to check for the drop down value
	if (isset($_REQUEST['checkval'])) {
		if ($_REQUEST['checkval']=='district') {
			$Cascade->smallDB();
			$county_id=$_POST['county'];

			$data=$Cascade->getDistricts($county_id);

			?>
			<option value="">Choose District</option>
			<?php 
			foreach($data as $data){?>
				<option value="<?php echo $data['district_id'];?>"><?php echo $data['district_name'];?></option>
			<?php }
			die();
		}
	}
	
	if (isset($_REQUEST['checkval'])) {
		if ($_REQUEST['checkval']=='division') {
			$Cascade->smallDB();
			$district_id=$_POST['district'];

			$data=$Cascade->getDivisions($district_id);

			?>
			<option value="">Choose Division</option>
			<?php 
			foreach($data as $data){?>
				<option value="<?php echo $data['division_id'];?>"><?php echo $data['division_name'];?></option>
			<?php }
			die();
		}
	}
	

 ?>