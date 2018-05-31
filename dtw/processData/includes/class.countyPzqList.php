<?php 

require "../includes/class.evidenceAction.php";

/**
* 
*/
class CountyPZQList extends connDB
{
	private $table_name = 'assumptions_county_pzq_list';
	private $assumdistrict_table_name = 'assumptions_county_pzq_list';

	function __construct()
	{
		$this->connDB(); //make db connection
	}


	/**
	* Description : Count the shisto disticts from current district assumption list.
	*
	* @param string  $county_id
	* @return int $row ['shistoDistrict']
	*/
	
	public function county_pzq_shisto_districts($county_id){

		$table = $this->getCurrentDistrictTable();
		$command="SELECT SUM(shistoDistrict) AS shistoDistrict FROM $table WHERE county_id ='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['shistoDistrict'];
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
	* Description : Get the current assumption id.
	*
	* @return int $current_id
	*/
	
	private function getCurrentStatus(){
		// get the current assumption id
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		return $current_id=$row ['id'];
	}


	/**
	* Description : get number of shisto schools in a county from current assumption district list.
	*
	* @param string  string to display
	* @param mixed  variable to display with var_dump()
	* @param mixed ,... unlimited OPTIONAL number of additional variables to display with var_dump()
	* @return mixed ,int,string
	*/
	
	public function county_pzq_shisto_schools($county_id){
		$table = $this->getCurrentDistrictTable();
		$command="SELECT SUM(numberOfShistoSchools) AS numberOfShistoSchools FROM $table WHERE county_id ='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['numberOfShistoSchools'];
	}

	/**
	* Description : get the current school list assumption table.
	*
	* @return string $table
	*/
	
	public function getCurrentAssumptionTable(){
		$current_id=$this->getCurrentStatus();
		
		$table= "assumption_school_list_version_".$current_id;

		return $table;
	}

	/**
	* Description : get the shisto childten targeted.
	*
	* @param string  string to display
	* @param mixed  variable to display with var_dump()
	* @param mixed ,... unlimited OPTIONAL number of additional variables to display with var_dump()
	* @return mixed ,int,string
	*/
	
	public function county_pzq_shisto_targeted_children($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(estimate_shisto) AS estimate_shisto FROM $table WHERE county_id ='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return (int)$row ['estimate_shisto'];
	}

	
	/**
	* Description : get the adults treated for shisto from assumption school list.
	*
	* @param string  $county_id
	* @return int $row ['total_adults_to_treat_shisto']
	*/
	
	public function county_pzq_shisto_adults($county_id){

		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(total_adults_to_treat_shisto) AS total_adults_to_treat_shisto FROM $table WHERE county_id ='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['total_adults_to_treat_shisto'];
	}


	/**
	* Description : get thetabs supplied for shisto children per county form current assumptions school list table.
	*
	* @param string  $county_id
	* @return int $row ['total_tabs_for_children_shisto']
	*/
	
	public function county_pzq_shisto_tabs_for_children($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(total_tabs_for_children_shisto) AS total_tabs_for_children_shisto FROM $table WHERE county_id ='$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['total_tabs_for_children_shisto'];

	}

	/**
	* Description : get tabs for adults per county from current assumption school list.
	*
	* @param string  $county_id
	* @return int $row ['total_tabs_for_adults_shisto'];
	*/
	
	public function county_pzq_shisto_tabs_for_adults($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(total_tabs_for_adults_shisto) AS total_tabs_for_adults_shisto FROM $table WHERE county_id ='$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['total_tabs_for_adults_shisto'];
	}

	/**
	* Description : get spoilage per county from assumptions county list.
	*
	* @param string  $county_id
	* @return int $row ['to_add_spoilage_gap_shisto']
	*/
	
	public function county_pzq_shisto_spoilage($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(to_add_spoilage_gap_shisto) AS to_add_spoilage_gap_shisto FROM $table WHERE county_id ='$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['to_add_spoilage_gap_shisto'];
	}


	/**
	* Description : get number of tabs in a tin per county from current assumptions school list.
	*
	* @param string  $county_id
	* @return int $row ['tabs_in_tin_shisto']
	*/
	
	public function county_pzq_shisto_tabs_in_tin($county_id){
		$table = $this->getCurrentAssumptionTable();
		$command="SELECT SUM(tabs_in_tin_shisto) AS tabs_in_tin_shisto FROM $table WHERE county_id ='$county_id' ";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['tabs_in_tin_shisto'];
	}

	/**
	* Description : get extra drugs for districts.
	*
	* @param string  $county_id
	* @return int $row ['extra_pzq']
	*/
	
	function county_pzq_extra_for_districts($county_id){
		$table = $this->getCurrentDistrictTable();
		$command="SELECT SUM(extra_pzq) AS extra_pzq FROM $table WHERE county_id ='$county_id'";
		$this->exec($command);
		$row = $this->single();
		
		return (int) $row ['extra_pzq'];
	}


	function create(){

		// get the args into an array
		$arg_list = func_get_args();

		// find number of values in array
	    $numargs = func_num_args();
	  	
	    $id="";

		$command="INSERT INTO $this->table_name VALUES(
						'$id',
						'$arg_list[0]',
						'$arg_list[1]',
						'$arg_list[2]',
						'$arg_list[3]',
						'$arg_list[4]',
						'$arg_list[5]',
						'$arg_list[6]',
						'$arg_list[7]',
						'$arg_list[8]',
						'$arg_list[9]',
						'$arg_list[10]',
						'$arg_list[11]'
						)";

		$this->exec($command);
		
	}

	function truncateTable(){
		$command = "TRUNCATE TABLE $this->table_name";
		$this->exec($command);

	}

	/**
	* Description : get all data from current district assumption list.
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


















} //  end class