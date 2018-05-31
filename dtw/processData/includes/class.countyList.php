<?php 

require "../includes/class.evidenceAction.php";

/**
* 
*/
class CountyList extends connDB
{
	private $table_name = 'assumptions_county_alb_list';
	function __construct()
	{
		$this->connDB(); //make db connection
	}

	/**
	* Description : counts the districts in a county form schools table.
	*
	* @param string  $county_id
	* @return int $row ['district_num']
	*/
	
	function numberOfDistricts($county_id){
		// get the district assumption table
		$table= $this->getCurrentDistrictTable();
		$command="SELECT district_id as district_num FROM $table WHERE county_id='$county_id'";
		$this->exec($command);
		$count = $this->rowCount();
		
		return $count;
	}


	/**
	* Description : counts the schools in a county form current district assumption table table.
	*
	* @param string  $county_id
	* @return int row ['num_of_schools']
	*/
	
	function numberOfSChoolsCounty($county_id){
		// get the district assumption table
		$table= $this->getCurrentDistrictTable();

		$command="SELECT SUM(numberOfSChools) AS num_of_schools FROM $table WHERE county_id='$county_id' ";
		$this->exec($command);
		$row = $this->single();	
		
		return $row ['num_of_schools'];
	}

	/**
	* Description : Get the childrred treated form current schools assumptions list.
	*
	* @param string  $county_id
	* @return int $row['children'] or 0
	*/
	
	function total_children_to_treat($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(totalChildrenTreated) AS children FROM $table WHERE county_id='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['children'];
	}


	/**
	* Description : sum the total adults treated from current assumption schoo list.
	*
	* @param string  $county_id
	* @return int $row ['adults']
	*/
	
	function total_adults_to_treat($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(total_adults) AS adults FROM $table WHERE county_id = '$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return round($row ['adults']);
	}

	/**
	* Description : sum up the add_for_spoilage in current assumption school list.
	*
	* @param string  $county_id
	* @return int $row ['spoilage']
	*/
	
	function county_alb_tabs_for_spoilage($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(add_for_spoilage) AS spoilage FROM $table WHERE county_id = '$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['spoilage'];
	}


	/**
	* Description : sum up the county_alb_tabs_round_up in current assumption school list.
	*
	* @param string  $county_id
	* @return int $row ['tabs_round_up']
	*/
	function county_alb_tabs_round_up(){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(tabs_round_up) AS tabs_round_up FROM $table WHERE county_id = '$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return round($row ['tabs_round_up']);
	}


	/**
	* Description : sum up the district_extra_alb in current assumption district list.
	*
	* @param string  $county_id
	* @return int $row ['district_extra_alb']
	*/
	public function county_district_extra_alb($county_id){
		$table = $this->getCurrentDistrictTable();
		$command="SELECT SUM(district_extra_alb) AS district_extra_alb FROM $table WHERE county_id = '$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['district_extra_alb'];
	}


	/**
	* Description : add the given values.
	*
	* @param mixed args()
	* @return int $total
	*/
	

	public function addValues(){
		// get the args into an array
		$arg_list = func_get_args();

		// find number of values in array
	    $numargs = func_num_args();
	  	
	  	// add all the values together in the array
	    $total=0;
	    for ($i = 0; $i < $numargs; $i++) {
	        $total+=$arg_list[$i] ;
	    }

	    return $total;
	}


	/**
	* Description : Get the current assumption id.
	*
	* @return int $current_id
	*/
	
	public function getCurrentStatus(){
		// get the current assumption id
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		return $current_id=$row ['id'];
	}


	/**
	* Description : get the current assumption table.
	*
	* @return string $table
	*/
	
	public function getCurrentAssumptionTable(){
		$current_id=$this->getCurrentStatus();
		
		$table= "assumption_school_list_version_".$current_id;

		return $table;
	}


	/**
	* Description : get the current district assumption table.
	*
	* @return string $table
	*/
	public function getCurrentDistrictTable(){
		$current_id=$this->getCurrentStatus();
		
		$table= "assumptions_district_list_version_".$current_id;

		return $table;
	}

	/**
	* Description : Add values into the county_alb_table.
	*
	* @param mixed $args()
	*/
	
	// function create_county_alb_list(){

	// 	// get the args into an array
	// 	$arg_list = func_get_args();

	// 	// find number of values in array
	//     $numargs = func_num_args();
	  	
	//     $id="";

	// 	$sql="INSERT INTO assumptions_county_alb_list VALUES(
	// 					'$id',
	// 					'$arg_list[0]',
	// 					'$arg_list[1]',
	// 					'$arg_list[2]',
	// 					'$arg_list[3]',
	// 					'$arg_list[4]',
	// 					'$arg_list[5]',
	// 					'$arg_list[6]',
	// 					'$arg_list[7]',
	// 					'$arg_list[8]',
	// 					'$arg_list[9]',
	// 					'$arg_list[9]'
	// 					)";
	// $result=mysql_query($sql)or die("<h1>function : create_county_alb_list <br/>Cannot insert</h1>".mysql_error());
	// // echo "sucess";
	// }

	public function create(){
		 // truncate the table
		// $this->truncateTable();
		
	  	// add all the values together in the array
	    $arg_list = func_get_args();

	    // echo "<pre>";var_dump($arg_list);echo "</pre>";
	    // die();

	    // get the table
		// $table =array_shift($arg_list);


	    $id="";

		$sql="INSERT INTO $this->table_name VALUES(
						:id,
						:county_name,
						:county_alb_number_of_districts,
						:county_alb_number_of_schools,
						:county_alb_total_children_to_treat,
						:county_alb_total_adults_to_treat,
						:county_tabs_for_children,
						:county_tabs_for_adults,
						:county_alb_tabs_for_spoilage,
						:county_alb_tabs_round_up,
						:county_district_extra_alb,
						:county_alb_total_tabs

					)";

		$params = array(':id'=>$id,
						':county_name' =>$arg_list[0],
						':county_alb_number_of_districts' =>$arg_list[1],
						':county_alb_number_of_schools' =>$arg_list[2],
						':county_alb_total_children_to_treat' =>$arg_list[3],
						':county_alb_total_adults_to_treat' =>$arg_list[4],
						':county_tabs_for_children' =>$arg_list[5],
						':county_tabs_for_adults' =>$arg_list[6],
						':county_alb_tabs_for_spoilage' =>$arg_list[7],
						':county_alb_tabs_round_up' =>$arg_list[8],
						':county_district_extra_alb' =>$arg_list[9],
						':county_alb_total_tabs' =>$arg_list[10]

						);


		//execute the insert
		$this->exec($sql,$params);

		   // $sql = "SELECT * FROM $this->table_name";
		   // $this->exec($sql);
		   // $row = $this->single();

		   // echo "<pre>";var_dump($row);echo "</pre>";

	

	}

	public function truncateTable(){
		$command="TRUNCATE TABLE $this->table_name";
		$this->exec($command);
	}

	/**
	* Description : get all data from current assumption list.
	*
	* @return mixed $data
	*/
	
	public function getAllCurrentDistrictAssumptionList(){
		$table=$this->getCurrentDistrictTable();
		$command="SELECT county_name,district_id, county_id FROM $table GROUP BY county_id";
		$this->exec($command);
		$rows = $this->resultset();
		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
					'district_id'=>$row['district_id'],
					'county_name'=>$row['county_name'],
					'county_id'=>$row['county_id']
			);
		}
		
		return $data;
	}


	public function getCounties(){
		$command="SELECT county,county_id FROM counties";
		$this->exec($command);
		$rows = $this->resultset();
		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
				'county' => $row['county'], 
				'county_id' => $row['county_id']
			);
		}
		
		return $data;
	}

	public function getDistricts($county_id=false){

		if ($county_id==true) {
			$sql="SELECT district_id,district_name  FROM districts WHERE county_id ='$county_id'";

			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();
			foreach ($rows as $row){
				$data[]=array(
					'district_id'=>$row['district_id'],
					'district_name'=>$row['district_name']
				);
			}

			return $data;
		}else{
			$sql="SELECT district_id, district_name FROM districts";

			$this->exec($sql);
			$rows = $this->resultset();

			$data=array();
			foreach ($rows as $row){
				$data[]=array(
					'district_id'=>$row['district_id'],
					'district_name'=>$row['district_name']
				);
			}

			return $data;
		}
		
	}

	public function search($district_id=false,$county_id){
		$table=$this->getCurrentTable();
		if ($district_id==false) {
			$command="SELECT * FROM $table WHERE county_id = '$county_id'";
			
		}else{
			$command="SELECT * FROM $table WHERE district_id = '$district_id' AND county_id = '$county_id'";
		}
		
		$this->exec($command);
		$rows = $this->resultset();

		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
						'county_name' => $row['county_name'],
						'county_id' => $row['county_id'],
						'district_name' => $row['district_name'],
						'district_id' => $row['district_id'],
						'numberOfSChools' => $row['numberOfSChools'],
						'numberOfShistoSchools' => $row['numberOfShistoSchools'],
						'pzqAmount' => $row['pzqAmount'],
						'alb_amount' => $row['alb_amount'],
						'district_extra_alb' => $row['district_extra_alb'],
						'extra_pzq' => $row['extra_pzq'],
						'total_alb' => $row['total_alb'],
						'total_pzq' => $row['total_pzq'],
						'next_treatment' => $row['next_treatment'],
						'shistoDistrict' => $row['shistoDistrict']
				);
		}
		
		return $data;
	}















} // end class