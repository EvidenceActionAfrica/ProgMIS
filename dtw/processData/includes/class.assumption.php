<?php 

require "../includes/class.evidenceAction.php";

/**
* 
*/
class Assumptions extends connDB
{
	private $table_name = 'assumptions';

	function __construct()
	{
		$this->connDB(); //make db connection
	}

	/**
	* Description : Create an assumption.
	*
	* @param mixed func_get_args()
	*/
	
	public function create(){

	  	// add all the values together in the array
	    $arg_list = func_get_args();

	    $id="";
	    $status=0;

		$sql="INSERT INTO $this->table_name VALUES(
						:id,
						:dateSaved,
						:aChildrenTreatedPerAdult,
						:pChildrenTreatedPerAdult,
						:aNonEnrolledPerSchool,
						:pNonEnrolledPerSchool,
						:aUnderFivesTreated,
						:pUnderFivesTreated,
						:aPopulationGrowthAnnual,
						:pPopulationGrowthAnnual,
						:aSpoilage,
						:pSpoilage,
						:aTinSize,
						:pTinSize,
						:aAverageChildDose,
						:pAverageChildDose,
						:aAdultDose,
						:pAdultDose,
						:aMaxDrugShortagePermittedKids,
						:pMaxDrugShortagePermittedKids,
						:aExtraSchoolsPerDistrict,
						:pExtraSchoolsPerDistrict,
						:aAssumedSchoolSize,
						:pAssumedSchoolSize,
						:aMaxDrugShortagePermittedDrugs,
						:pMaxDrugShortagePermittedDrugs,
						:aAverageDrugNeed,
						:pAverageDrugNeed,
						:aAverageTinsNeededPerSchools,
						:pAverageTinsNeededPerSchools,
						:aCalcDrugsPerSchool,
						:pCalcDrugsPerSchool,
						:aTreatYear,
						:pTreatYear,
						:areaAssumptions,
						:status

						)";

		$params = array(':id'=>$id,
						':dateSaved' => $arg_list[0],
						':aChildrenTreatedPerAdult' => $arg_list[1],
						':pChildrenTreatedPerAdult' => $arg_list[2],
						':aNonEnrolledPerSchool' => $arg_list[3],
						':pNonEnrolledPerSchool' => $arg_list[4],
						':aUnderFivesTreated' => $arg_list[5],
						':pUnderFivesTreated' => $arg_list[6],
						':aPopulationGrowthAnnual' => $arg_list[7],
						':pPopulationGrowthAnnual' => $arg_list[8],
						':aSpoilage' => $arg_list[9],
						':pSpoilage' => $arg_list[10],
						':aTinSize' => $arg_list[11],
						':pTinSize' => $arg_list[12],
						':aAverageChildDose' => $arg_list[13],
						':pAverageChildDose' => $arg_list[14],
						':aAdultDose' => $arg_list[15],
						':pAdultDose' => $arg_list[16],
						':aMaxDrugShortagePermittedKids' => $arg_list[17],
						':pMaxDrugShortagePermittedKids' => $arg_list[18],
						':aExtraSchoolsPerDistrict' => $arg_list[19],
						':pExtraSchoolsPerDistrict' => $arg_list[20],
						':aAssumedSchoolSize' => $arg_list[21],
						':pAssumedSchoolSize' => $arg_list[22],
						':aMaxDrugShortagePermittedDrugs' => $arg_list[23],
						':pMaxDrugShortagePermittedDrugs' => $arg_list[24],
						':aAverageDrugNeed' => $arg_list[25],
						':pAverageDrugNeed' => $arg_list[26],
						':aAverageTinsNeededPerSchools' => $arg_list[27],
						':pAverageTinsNeededPerSchools' => $arg_list[28],
						':aCalcDrugsPerSchool' => $arg_list[29],
						':pCalcDrugsPerSchool' => $arg_list[30],
						':aTreatYear' => $arg_list[31],
						':pTreatYear' => $arg_list[32],
						':areaAssumptions' => $arg_list[33],
						':status' =>$status

						);

		//execute the insert
		$this->exec($sql,$params);

		// $sql = "SELECT * FROM $this->table_name";
		// $this->exec($sql);
		// $row = $this->single();

		// echo "<pre>";var_dump($row);echo "</pre>";

		// get the las id inserted
		$last_id = $this->getLastID();

		//update the status field
		$this->updateStatus($last_id);

		$this->createSqlTable($last_id);
	}

	/**
	* Description : check if the assumption version table exists.
	*
	* @param string $end.
	* @return boolean
	*/
	
	public function checkIfTableExists($end){

		$table="assumption_school_list_version_".$end;
		$command="SHOW TABLES LIKE '$table'";

		$this->exec($command);

		return $count = $this->rowCount();

		// $tableExists;

	}

	/**
	* Description : Update the status column. Set the old one to 0 and new one to 1
	*
	* @param mixed  variable to display with var_dump()
	*/
	
	public function updateStatus($id){
		// get the current assumption id
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		$current_id=$row ['id'];

		// update it to 0
		$command="UPDATE assumptions SET status=0 WHERE id='$current_id'";
		$this->exec($command);

		//update to the latest
		$command="UPDATE assumptions SET status=1 WHERE id='$id'";
		$this->exec($command);

		// echo "Updated";
		// $sql = "SELECT * FROM $this->table_name WHERE id='$id'";
		// $this->exec($sql);
		// $row = $this->single();

		// echo "<pre>";var_dump($row);echo "</pre>";

		
		
	}

	/**
	* Description : Delete an asumption and update the status of latest assumption to 1. 
	*
	* @param int $id
	*/
	

	public function deleteAssumption($id){
		// @todo check if its the current id
		$current_id = $this->getCurrentID();

		// if the to be deleted id is the current assumption then 
		// move the status to the max id or second last
		// else just delete the id
		if ($current_id == $id) {
			// @todo get max id, or lesser
			$max_id=$this->getLastID();

			//compare the two
			// if they are the same get the second last id
			if ($max_id == $id) {
				$max_id=$this->getSecondLastID();
			}

			// @todo update the previous to status 1
			$this->updateStatus($max_id);
		}
		
		// @todo delete the selected id
		$command="DELETE FROM assumptions WHERE id ='$id'";
		$this->exec($command);
	}

	/**
	* Description : get the current assumption id.
	*
	* @return int $row ['id']
	*/

	public function getCurrentID(){
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['id'];
	}
	

	/**
	* Description : Create the assumption_school_list vesrion table.
	*
	* @param int $id
	*/
	
	public function createSqlTable($id){
		// check if table exists
		// $tableExists=$this->checkIfTableExists($id);

		$table= "assumption_school_list_version_".$id;

		$command ='CREATE TABLE '.$table.'(
			school_id_part2 VARCHAR (50),
			district_id_part2 VARCHAR (50),
			county_id VARCHAR (50),
			estimatePopGrowth VARCHAR (50),
			estimateNonenroll VARCHAR (50),
			estimateU5 VARCHAR (50),
			totalChildrenTreated VARCHAR (50),
			total_adults VARCHAR (50),
			total_drug_use VARCHAR (50),
			tins VARCHAR (50),
			tin_round_up VARCHAR (50),
			tabs_round_up VARCHAR (50),
			spoilage_calc VARCHAR (50),
			spoilage_gap VARCHAR (50),
			add_for_spoilage VARCHAR (50),
			alb_requisition VARCHAR (50),
			estimate_shisto VARCHAR (50),
			estimate_non_enrolled_shisto VARCHAR (50),
			total_children_treated_shisto VARCHAR (50),
			total_tabs_for_children_shisto VARCHAR (50),
			total_adults_to_treat_shisto VARCHAR (50),
			total_tabs_for_adults_shisto VARCHAR (50),
			total_drugs_use_shisto VARCHAR (50),
			tins_shisto VARCHAR (50),
			round_up_tins_shisto VARCHAR (50),
			tabs_in_tin_shisto VARCHAR (50),
			spoilage_calc_shisto VARCHAR (50),
			spoilage_gap_shisto VARCHAR (50),
			to_add_spoilage_gap_shisto VARCHAR (50),
			pzq_requsition VARCHAR (50)

		); ';
		
		$this->exec($command);

	
		

		$this->insertIntoSql($table);




	}

	/**
	* Description : Copy data from the view to the new table.
	*
	* @param string  $table
	*/

	public function insertIntoSql($table){
		$command="INSERT INTO $table SELECT * FROM view_school_list_part_2";
		$this->exec($command);
	}
	

	/**
	* Description : Get the last inseted id in assumptions.
	*
	* @return int $row ['last_id']
	*/
	
	public function getLastID(){
		$command="SELECT MAX(id) AS last_id from assumptions ";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['last_id'];
	}

	/**
	* Description : get the second id after max id.
	*
	* @return int $row['id']
	*/

	public function getSecondLastID(){
		$command="SELECT id FROM assumptions ORDER BY id DESC LIMIT 1,1";
		$this->exec($command);
		$row = $this->single();
		
		return $row ['id'];
	}
	

	//district part
	public function createDistrictList(){
		 // truncate the table
		// $this->truncateTable();
		

	  	// add all the values together in the array
	    $arg_list = func_get_args();

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


	public function getCurrentStatusDistrictList(){
		// get the current assumption id
		$command="SELECT id FROM assumptions WHERE status = 1";
		$this->exec($command);
		$row = $this->single();
		return $current_id=$row ['id'];
	}

	/**
	* Description : Create the assumption_school_list vesrion table.
	*
	* @param int $id
	*/
	
	public function createSqlTableDistrictList(){
		// check if table exists
		// $tableExists=$this->checkIfTableExists($id);
		$current_id=getCurrentStatusDistrictList();
		$table= "assumptions_district_list_version_".$current_id;

		$command ='CREATE TABLE '.$table.'(
					id   INT      NOT NULL AUTO_INCREMENT,
					county_name  VARCHAR (50)
					county_id  VARCHAR (50)
					district_name  VARCHAR (50)
					district_id  VARCHAR (50)
					numberOfSChools  VARCHAR (50)
					numberOfShistoSchools  VARCHAR (50)
					pzqAmount  VARCHAR (50)
					alb_amount  VARCHAR (50)
					district_extra_alb  VARCHAR (50)
					extra_pzq  VARCHAR (50)
					total_alb  VARCHAR (50)
					total_pzq  VARCHAR (50)
					next_treatment  VARCHAR (50)
					shistoDistrict  VARCHAR (50)
					PRIMARY KEY (id)
					);

		); ';
		
		$this->exec($command);



		// $this->createSqlTable($last_id);

		$table= "assumptions_district_list_version_".$last_id;
		return $table;

	}

	/**
	* Description : Get All asumptions.
	*
	* @return mixed $data
	*/
	
	public function getAll(){
		$command="SELECT * FROM $this->table_name ORDER BY id DESC";
		$this->exec($command);
		$rows = $this->resultset();
		
		$data=array(); //create the array
		foreach ($rows as $key => $row) {
			$data[] = array(
				'id' => $row['id'],
				'dateSaved' =>$row['dateSaved'],
				'aChildrenTreatedPerAdult' =>$row['aChildrenTreatedPerAdult'],
				'pChildrenTreatedPerAdult' =>$row['pChildrenTreatedPerAdult'],
				'aNonEnrolledPerSchool' =>$row['aNonEnrolledPerSchool'],
				'pNonEnrolledPerSchool' =>$row['pNonEnrolledPerSchool'],
				'aUnderFivesTreated' =>$row['aUnderFivesTreated'],
				'pUnderFivesTreated' =>$row['pUnderFivesTreated'],
				'aPopulationGrowthAnnual' =>$row['aPopulationGrowthAnnual'],
				'pPopulationGrowthAnnual' =>$row['pPopulationGrowthAnnual'],
				'aSpoilage' =>$row['aSpoilage'],
				'pSpoilage' =>$row['pSpoilage'],
				'aTinSize' =>$row['aTinSize'],
				'pTinSize' =>$row['pTinSize'],
				'aAverageChildDose' =>$row['aAverageChildDose'],
				'pAverageChildDose' =>$row['pAverageChildDose'],
				'aAdultDose' =>$row['aAdultDose'],
				'pAdultDose' =>$row['pAdultDose'],
				'aMaxDrugShortagePermittedKids' =>$row['aMaxDrugShortagePermittedKids'],
				'pMaxDrugShortagePermittedKids' =>$row['pMaxDrugShortagePermittedKids'],
				'aExtraSchoolsPerDistrict' =>$row['aExtraSchoolsPerDistrict'],
				'pExtraSchoolsPerDistrict' =>$row['pExtraSchoolsPerDistrict'],
				'aAssumedSchoolSize' =>$row['aAssumedSchoolSize'],
				'pAssumedSchoolSize' =>$row['pAssumedSchoolSize'],
				'aMaxDrugShortagePermittedDrugs' =>$row['aMaxDrugShortagePermittedDrugs'],
				'pMaxDrugShortagePermittedDrugs' =>$row['pMaxDrugShortagePermittedDrugs'],
				'aAverageDrugNeed' =>$row['aAverageDrugNeed'],
				'pAverageDrugNeed' =>$row['pAverageDrugNeed'],
				'aAverageTinsNeededPerSchools' =>$row['aAverageTinsNeededPerSchools'],
				'pAverageTinsNeededPerSchools' =>$row['pAverageTinsNeededPerSchools'],
				'aCalcDrugsPerSchool' =>$row['aCalcDrugsPerSchool'],
				'pCalcDrugsPerSchool' =>$row['pCalcDrugsPerSchool'],
				'aTreatYear' =>$row['aTreatYear'],
				'pTreatYear' =>$row['pTreatYear'],
				'areaAssumptions' =>$row['areaAssumptions'],
				'status' =>$row['status']
			);
		}
		
		return $data;
	}

	// @todo get only the given attibutes	
	public function getFew(){

	}





} // end class

// only we need to create the table after the assumptions create
// otherwise we just change the current status in the assumptions table
// the district list will choose the id with the current status as 1