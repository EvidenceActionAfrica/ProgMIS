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

		private $table_name ="reverse_county_returns";
		

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

		    $id="";

			$sql="INSERT INTO $this->table_name VALUES(
							:id,
							:county_id,
							:moe_monitoring,
							:moe_meeting,
							:mophs_community,
							:mophs_monitoring,
							:mophs_meeting,
							:end_date  )";

			$params = array(
				'id' => $id,
				'county_id' =>$arg_list[0],
				'moe_monitoring' =>$arg_list[1],
				'moe_meeting' =>$arg_list[2],
				'mophs_community' =>$arg_list[3],
				'mophs_monitoring' =>$arg_list[4],
				'mophs_meeting' =>$arg_list[5],
				'end_date' =>$arg_list[6]
			);

			//execute the insert
			$this->exec($sql,$params);

			   // $sql = "SELECT * FROM $this->table_name";
			   // $this->exec($sql);
			   // $row = $this->single();

			   // echo "<pre>";var_dump($row);echo "</pre>";

		}


		public function getAll(){

			$sql = "SELECT * FROM $this->table_name";
			$this->exec($sql);
			$rows = $this->resultset();

			$data = array();
			foreach ($rows as $row){
				$data[] = array(
					'id'=> $row['id'],
					'county_id' => $row['county_id'],
					'moe_monitoring' => $row['moe_monitoring'],
					'moe_meeting' => $row['moe_meeting'],
					'mophs_community' => $row['mophs_community'],
					'mophs_monitoring' => $row['mophs_monitoring'],
					'mophs_meeting' => $row['mophs_meeting'],
					'end_date' => $row['end_date']
					);	
			}


			return $data;
		}


		/**
		* Description : this checks whether all documents have been recieved.
		*
		* @param string  $form_type
		* @param int  $district_id
		*/
		
		public function formsReturned($county_id){
			$command="SELECT * FROM $this->table_name WHERE county_id = '$county_id' ";
			$this->exec($command);
			$row = $this->single();

			$county_id 			=$row['county_id'];
			$moe_monitoring 	=$row['moe_monitoring'];
			$moe_meeting 		=$row['moe_meeting'];
			$mophs_community 	=$row['mophs_community'];
			$mophs_monitoring 	=$row['mophs_monitoring'];
			$mophs_meeting 		=$row['mophs_meeting'];
			// $end_date 			=$row['end_date'];

			if ($moe_monitoring =='Y' && $moe_meeting =='Y' && $mophs_community =='Y' && $mophs_monitoring =='Y' && $mophs_meeting =='Y') {
				return 1;
			}else{
				return 0;
			}

		}



		public function getWarning($county_id,$end_date){
			// $two_weeks=strtotime("+2 week");
			// $after_two_weeks = $two_weeks + $end_date;
			// $now=time();

			// if ($after_two_weeks > $now) {
			// 	echo '<span title="Not OK" class="glyphicon glyphicon-exclamation-sign"></span>';
			// }else{
			// 	echo '<span title="OK" class="glyphicon glyphicon-ok-sign"></span>';
			// }


			$one_week=604800; // number of seconds in a week
			$two_weeks=$one_week * 2; 
			$after_two_weeks = $two_weeks + $end_date;
			$now=time();
			// IF end date is not there 
			// it has not been planned
			if ($end_date !='---') {
				if ($this->formsReturned($county_id) == 0) {

					if ($after_two_weeks > $now) {
						echo '<span title="Should happen two weeks after district training" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-exclamation-sign warning"></span>';
					}else{
						echo '<span title="OK" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign glyphicon-ok-sign-blue warning"></span>';
					}
				}else{
					echo '<span title="OK. All forms Recieved" data-toggle="tooltip" data-placement="left" class="glyphicon glyphicon-ok-sign warning"></span>';
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


		/**
		* Desscription :Update the $this->tablename
		*/
		
		public function update(){

			// get the args into an array
			$arg_list = func_get_args();

		    $sql="UPDATE $this->table_name SET
						moe_monitoring = :moe_monitoring,
						moe_meeting = :moe_meeting,
						mophs_community = :mophs_community,
						mophs_monitoring = :mophs_monitoring,
						mophs_meeting = :mophs_meeting
						WHERE id=:id";

			$params = array(
				'id' => $arg_list[0],
				'moe_monitoring' =>$arg_list[1],
				'moe_meeting' =>$arg_list[2],
				'mophs_community' =>$arg_list[3],
				'mophs_monitoring' =>$arg_list[4],
				'mophs_meeting' =>$arg_list[5]
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


		public function updateDates(){
			$command = "SELECT activity_venu, max(end_date) as end_date,activity_type FROM rollout_activity 
						INNER JOIN districts ON rollout_activity.activity_venu=districts.district_name
						WHERE activity_type=2 GROUP BY districts.county_id";

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
							WHERE county_id=:county_id";

				$params = array(
					':end_date' => $value['end_date'],
					':district_id' =>$this->getDistrictCounty($this->getDistID($value['activity_venu']),'id')
					);
				//execute the update
				$d=$this->exec($sql,$params);
			}
			
		}

		/**
		* Description : Get data from rollout. Get the data and group by county. Only this is needed.
		* 
		*/
		
		public function getRolloutData(){

			// join with the districts table and group by districts.county id 
			// we need to join because rollout_activity does not have a county column 
			// we take max end date because we are grouping by county, which has many districts in it
			// so we need to take the maximum end date

			$sql = "SELECT activity_venu, max(end_date) as end_date, activity_type, actyvity_county FROM rollout_activity 
					WHERE activity_type = 2 AND activity_type IS NOT NULL GROUP BY actyvity_county";

			$this->exec($sql);
			$rows = $this->resultset();
			

			$null="N";
			$null_date="N";

			// check if the distircts county is already in the county return table
			foreach ($rows as $row){

				// get the county id
				$county_id=$this->getCountyId($row['actyvity_county']);

				$end_date=$row['end_date'];
				
				// if the county id does not exists
				// insert data
				if ($this->checkDistrict($county_id)==0) {
					
					//insert data to return from table if its not there
					$this->create($county_id, $null, $null, $null, $null, $null, $end_date);
				}


			}

			// update the the $this->tablename 
			// to check for any changes in dates
			// $this->updateDates();
		}


		// check whether  exists
		public function checkDistrict($county_id){
			$sql="SELECT county_id FROM $this->table_name WHERE county_id='$county_id'";
			$this->exec($sql);
			$count = $this->rowCount();

			return $count;

		}
		




	}// end class




	

	

 ?>