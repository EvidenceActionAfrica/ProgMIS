<?php 

require "../includes/class.evidenceAction.php";
/**
* 
*/
class districtList extends connDB
{
	private $table_name="assumptions_district_list";
	function __construct()
	{
		$this->connDB(); //make db connection
	}

	public function truncateTable(){
		$command="TRUNCATE TABLE $this->table_name";
		$this->exec($command);
	}

	public function getSchools(){
		$command="SELECT * FROM schools GROUP BY district_id ORDER BY county,district_name";
		$this->exec($command);
		$rows = $this->resultset();
		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
				'county' => $row['county'],
				'county_id' => $row['county_id'],
				'district_name' => $row['district_name'],
				'district_id' => $row['district_id']

			);
		}
		
		return $data;
	}

	/**
	* Description : change unix time stanp to date.
	*
	* @param string  $unix_time
	* @return $date / $unix_time
	*/
	
	public function checkNextTreatment($unix_time){
		if ($unix_time!='N/A') {
			return gmdate("F j, Y", $unix_time);
		}else{
			return $unix_time;
		}
	}

	/**
	* Description : Get the current assumtion. Check the status
	*
	* @return int $row ['status']
	*/
	
	public function getAssumptionID(){
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['id'];
	}



	/**
	* Description : count number of schools in district.
	*
	* @param string $distict_id
	* @return int $row ['num_of_schools']
	*/
	
	public function numberOfSChools($district_id){

		//$command="SELECT COUNT(school_id) as num_of_schools FROM a_bysch  WHERE district_id = '$district_id'";
		$command="SELECT school_id FROM a_bysch  WHERE district_id = $district_id";
		$this->exec($command);
		$count = $this->rowCount();
		
		// return $row ['num_of_schools'];
		return $count;
	}

	/**
	* Description : count number of shisto schools in a district.
	*
	* @param string  $distict_id
	* @return int $row ['num_of_shisto_schools']
	*/
	
	public function numberOfShistoSchools($district_id){

		$command="SELECT COUNT(school_id) as num_of_shisto_schools FROM a_bysch WHERE district_id = '$district_id' AND ap_attached='Yes' ";
		$this->exec($command);
		$row = $this->single();
		
		// echo "<pre>";var_dump($row);echo "</pre>";
		return $row ['num_of_shisto_schools'];
	}


	/**
	* Description : get the alb amount from the current table.
	*
	* @param string  $district_id
	* @return int 
	*/
	
	public function albAmount($district_id){

		$table="assumption_school_list_version_".$this->getAssumptionID();
		$command="SELECT SUM(alb_requisition) AS alb_requisition FROM $table WHERE district_id_part2='$district_id' ";
		$this->exec($command);
		$row = $this->single();
		
		if ($row['alb_requisition']==0) {
			return 0;
		}else{
			return $row['alb_requisition'];
		}
	}


	/**
	* Description : calculate the pzq amount from current assumptions school list.
	*
	* @param string  $distict_id
	* @return mixed ,int,string
	*/
	
	public function pzqAmount($district_id){
		$table="assumption_school_list_version_".$this->getAssumptionID();
		$command="SELECT SUM(pzq_requsition) AS pzq_requsition FROM $table WHERE district_id_part2='$district_id'";
		$this->exec($command);
		$row = $this->single();
		
			if ($row['pzq_requsition']==0) {
				return 0;
			}else{
				return $row['pzq_requsition'];
			}
	}

	/**
	* Description : get the assumption values and multiply.
	*
	* @param string  $a,$b,$c
	* @return int $product
	*/
	
	public function districtAssumptionProduct($a,$b,$c)
	{
		$a=$this->getAssumptionVal($a);
		$b=$this->getAssumptionVal($b);
		$c=$this->getAssumptionVal($c);

		$product=$a*$b*$c;

		return $product;
	}

	/**
	* treatment : none
	* table : assumptions
	* no. of paremeter : assumption
	* description : get the requested assumption value
	*/

	public function getAssumptionVal($assumption){
		$command="SELECT $assumption AS assumption FROM assumptions ORDER BY id DESC LIMIT 0,1";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['assumption'];
	}

	// gets the district extra pzq
	public function ifElseMultiply($value1,$value2,$value3){

		$args=func_get_args(); // get the args

		$value1=array_shift($args); // get and remove the table

		$size=sizeof($args); // get number of items in array
		
		if ($value1==0) {
			return 0;
		}else{
			// get the asumption values and add them into an array
			$data=array();
			for ($i=0; $i < $size; $i++) { 
				$data[]=$this->getAssumptionVal($args[$i]);
			}
			// multiply the values in the array
			$product=array_product($args);
			
			return $product;
		}
	}

	/**
	* treatment : none
	* table : none
	* no. of paremeter : many
	* description : add up the arguments given
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

	public function shistoDistrict($district_id){

		$command="SELECT ap_attached FROM a_bysch WHERE district_id='$district_id'";
		$this->exec($command);
		$row = $this->single();
		
		if ($row ['ap_attached']=='Yes') {
			# code...
			return 1;
		}else{
			return 0;
		}

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

	public function getAssumptionlistCounty(){
		$current_id=$this->getCurrentStatus();

		$table= "assumptions_district_list_version_".$current_id;

		$command="SELECT county_id,county_name,next_treatment FROM $table GROUP BY county_id";
		$this->exec($command);
		$rows = $this->resultset();
		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
				'county_id' => $row['county_id'], 
				'next' => $row['next_treatment'], 
				'county_name' => $row['county_name']
			);
		}
		
		return $data;
		
	}

	public function updateNextTreatment($treatment,$county_id){
		$current_id=$this->getCurrentStatus();
		$table= "assumptions_district_list_version_".$current_id;

		$sql="UPDATE $table SET
				next_treatment = :next
				WHERE county_id=:county_id";

		$params = array(
		'county_id' => $county_id,
		'next' =>$treatment
		);
		//execute the update
		$this->exec($sql,$params);

	}




	public function create(){
		 // truncate the table
		// $this->truncateTable();
		
	  	// add all the values together in the array
	    $arg_list = func_get_args();

	    // get the table
		$table =array_shift($arg_list);


	    $id="";

		$sql="INSERT INTO $table VALUES(
						:id,
						:county_name,
						:county_id,
						:district_name,
						:district_id,
						:numberOfSChools,
						:numberOfShistoSchools,
						:pzqAmount,
						:alb_amount,
						:district_extra_alb,
						:extra_pzq,
						:total_alb,
						:total_pzq,
						:next_treatment,
						:shistoDistrict

					)";

		$params = array(':id'=>$id,
						':county_name' => $arg_list[0],
						':county_id' => $arg_list[1],
						':district_name' => $arg_list[2],
						':district_id' => $arg_list[3],
						':numberOfSChools' => $arg_list[4],
						':numberOfShistoSchools' => $arg_list[5],
						':pzqAmount' => $arg_list[6],
						':alb_amount' => $arg_list[7],
						':district_extra_alb' => $arg_list[8],
						':extra_pzq' => $arg_list[9],
						':total_alb' => $arg_list[10],
						':total_pzq' => $arg_list[11],
						':next_treatment'=> $arg_list[12],
						':shistoDistrict' => $arg_list[13]

						);


		//execute the insert
		$this->exec($sql,$params);

		   $sql = "SELECT * FROM $this->table_name";
		   $this->exec($sql);
		   $row = $this->single();

		   // echo "<pre>";var_dump($row);echo "</pre>";

	

	}


	public function getCurrentStatus(){
		// get the current assumption id
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		return $current_id=$row ['id'];
	}

	/**
	* Description : Create the district_school_list vesrion table.
	*
	* @param int $id
	*/
	
	public function createSqlTable(){
		
		$current_id=$this->getCurrentStatus();

		// check if table exists
		$tableExists=$this->checkIfTableExists($current_id);


		if ($tableExists == 0) {
			$table= "assumptions_district_list_version_".$current_id;

			 $command ='CREATE TABLE '.$table.' (
						id  INT NOT NULL AUTO_INCREMENT,
						county_name  VARCHAR  (50),
						county_id  VARCHAR  (50),
						district_name  VARCHAR  (50),
						district_id  VARCHAR  (50),
						numberOfSChools  VARCHAR  (50),
						numberOfShistoSchools  VARCHAR (50),
						pzqAmount  VARCHAR (50),
						alb_amount  VARCHAR (50),
						district_extra_alb  VARCHAR (50),
						extra_pzq  VARCHAR  (50),
						total_alb  VARCHAR  (50),
						total_pzq  VARCHAR  (50),
						next_treatment  VARCHAR  (50),
						shistoDistrict  VARCHAR  (50),
						PRIMARY KEY (id) ) ';
 // $command ='CREATE TABLE '.$table.' (
	// 					id   INT      NOT NULL AUTO_INCREMENT,
	// 					county_name  VARCHAR  NULL(50),
	// 					county_id  VARCHAR  NULL(50),
	// 					district_name  VARCHAR  NULL(50),
	// 					district_id  VARCHAR  NULL(50),
	// 					numberOfSChools  VARCHAR  NULL(50),
	// 					numberOfShistoSchools  VARCHAR  NULL(50),
	// 					pzqAmount  VARCHAR  NULL(50),
	// 					alb_amount  VARCHAR  NULL(50),
	// 					district_extra_alb  VARCHAR  NULL(50),
	// 					extra_pzq  VARCHAR  NULL(50),
	// 					total_alb  VARCHAR  NULL(50),
	// 					total_pzq  VARCHAR NULL (50),
	// 					next_treatment  VARCHAR  NULL(50),
	// 					shistoDistrict  VARCHAR NULL (50),
	// 					PRIMARY KEY (id) ); ';



// exit();
			
			$this->exec($command);
			// exit();


			// $this->createSqlTable($last_id);
			return $table;
		}else{
			return "exists";
		}

	}

	/**
	* Description : check if the assumption version table exists.
	*
	* @param string $end.
	* @return boolean
	*/
	
	public function checkIfTableExists($end){
		$table="assumptions_district_list_version_".$end;
		$command="SHOW TABLES LIKE '$table'";

		$this->exec($command);

		return $count = $this->rowCount();

		// $tableExists;

	}

	/**
	* Description : get the data from the current assumption. i,e us the id and concatinate it to the end
	*
	* @return mixed 
	*/
	
	public function getAllCurrentList(){
		$current_id=$this->getCurrentStatus();
		
		$table= "assumptions_district_list_version_".$current_id;

		$exists=$this->checkIfTableExists($current_id);

		if ($exists > 0) {
		
			$command="SELECT * FROM $table";
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
		}else{
			// table does not exist
			return 0;
		}
	}	


	public function getCurrentTable(){
		$current_id=$this->getCurrentStatus();
		
		$table= "assumptions_district_list_version_".$current_id;

		return $table;
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







}