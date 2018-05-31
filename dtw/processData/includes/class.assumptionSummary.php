<?php  

require "../includes/class.evidenceAction.php";

/**
* 
*/
class AssumptionSummary extends connDB
{
	private $table_name_alb = 'assumptions_county_alb_list';
	private $table_name_pzq = 'assumptions_county_pzq_list';
	
	function __construct()
	{
		$this->connDB(); //make db connection
	}


	/**
	* Description : sum the albtreatment for children and adults.
	*
	* @return int $row ['treatment']
	*/
	
	public function alb_treatment(){
		$command="SELECT SUM(county_alb_total_children_to_treat)+SUM(county_alb_total_adults_to_treat) AS treatment FROM $this->table_name_alb";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['treatment'];
	}


	/**
	* Description : get pzq treatment for children and adults.
	*
	* @return int $row ['treatment']
	*/
	
	public function pzq_treatment(){

		$command="SELECT SUM(county_pzq_shisto_targeted_children)+SUM(county_pzq_shisto_adults) AS treatment FROM $this->table_name_pzq";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['treatment'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function getAlbPart1(){
		$Quater1=strtotime('2014-03-01');

		$table=$this->getCurrentDistrictTable();
		$command="SELECT SUM(total_alb) as total_alb from $table WHERE next_treatment < $Quater1 AND next_treatment !='N/A' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['total_alb'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function getAlbPart2(){
		$Quater2=strtotime('2014-08-01');

		$table=$this->getCurrentDistrictTable();
		$command="SELECT SUM(total_alb) as total_alb from $table WHERE next_treatment < $Quater2 AND next_treatment !='N/A' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['total_alb'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function getPzqPart1(){
		$Quater1=strtotime('2014-03-01');

		$table=$this->getCurrentDistrictTable();
		$command="SELECT SUM(total_pzq) as total_pzq from $table WHERE next_treatment < $Quater1 AND next_treatment !='N/A' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['total_pzq'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function getPzqPart2(){
		$Quater2=strtotime('2014-08-01');

		$table=$this->getCurrentDistrictTable();
		$command="SELECT SUM(total_pzq) as total_pzq from $table WHERE next_treatment < $Quater2 AND next_treatment !='N/A' ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['total_pzq'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function sumCountyAlb($column){

		$table=$this->getCurrentDistrictTable();
		$command="SELECT SUM($column) as amount from assumptions_county_alb_list ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['amount'];
	}

	/**
	* Description : sum total_alb before may .
	*
	* @return mixed ,int,string
	*/

	public function sumCountyPzq($column){

		$command="SELECT SUM($column) as amount from assumptions_county_pzq_list ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['amount'];
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
	



} // end class