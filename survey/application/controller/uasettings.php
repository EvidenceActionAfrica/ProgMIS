<?php
	
	class uasettings extends Controller {
		
		public $model;
		
		public function index() {
			
			require 'application/views/_templates/header.php'; //Because of the country session to filter data
			require 'application/views/uas/sidebar.php';
			$table = "staff_list";
			
			$tableName = str_replace("_", " ", $table);
			$tableName = ucwords($tableName);
			$generaldata_model = $this->loadModel('uasmodel');
			// echo "<h1>The Field array is</h1> ".$fieldsArray;
			$fieldsArray = Array('id', 'country', 'employee_id', 'full_name', 'email', 'phone');
			$data = $generaldata_model->getData($table, $fieldsArray);
			$fieldsArray = Array('id', 'country', 'employee_id', 'full_name', 'position', 'phone', 'email', 'office_location');
			
			$fields = $generaldata_model->getFields($table, $fieldsArray);
			
			require 'application/views/uas/uas.php';
			require 'application/views/_templates/footer.php';
		}
		
		/**
			* Description : give an associative array and turn into serial indexed array.
			*
			* @param mixed  $single_record
			* @return mixed $single_record
		*/
		public function serializeArray($single_record) {
			$i = 0;
			foreach ($single_record as $key => $value) {
				unset($single_record[$key]);
				$single_record[$i] = $value;
				$i++;
			}
			
			return $single_record;
		}
		
		public function add($table) {
			
			if (isset($_POST["add-uas-data"])) {
				
				$generaldata_model = $this->loadModel('uasmodel');
				$dd = $generaldata_model->addData($table, $_POST);
				
				$insertData = array(
                'id' => '',
                'country' => $_SESSION["country"],
                'user_name' => $_SESSION["full_name"],
                'email' => $_SESSION["email"],
                'action' => 'record added on Staff List',
                'description' => 'name ' . $_POST['full_name'],
                'unused' => ''
				);
				$generaldata_model->addData('user_log_record', $insertData);
			}
			
			// where to go after add
			header('location: ' . URL . 'uasettings/index/');
		}
		
		public function setPassword($staffId = false) {
						
			$table = "staff_list";
			$tableName = str_replace("_", " ", $table);
			$tableName = ucwords($tableName);
			$uas_model = $this->loadModel('uasmodel');
			// $fieldsArray = array('full_name','employee_id','country','position','office_location','phone','email','password','priv_kenya','priv_malawi','priv_uganda','priv_asset_list_kenya','priv_asset_list_malawi','priv_asset_list_uganda','priv_fleet_list_kenya','priv_fleet_list_malawi','priv_fleet_list_uganda','priv_staff_list_kenya','priv_staff_list_malawi','priv_staff_list_uganda','priv_waterpoint_list_kenya','priv_waterpoint_list_malawi','priv_waterpoint_list_uganda','priv_chlorine_inventory_kenya','priv_chlorine_inventory_malawi','priv_chlorine_inventory_uganda','priv_chlorine_planning_kenya','priv_chlorine_planning_malawi','priv_chlorine_planning_uganda','priv_chlorine_tracking_kenya','priv_chlorine_tracking_malawi','priv_chlorine_tracking_uganda','priv_fleet_manager_planning_kenya','priv_fleet_manager_planning_malawi','priv_fleet_manager_planning_uganda','priv_fleet_manager_tracking_kenya','priv_fleet_manager_tracking_malawi','priv_fleet_manager_tracking_uganda','priv_fleet_manager_tracking_uganda','priv_promoter_engagement_kenya','priv_promoter_engagement_malawi','priv_promoter_engagement_uganda','priv_dispenser_kenya','priv_dispenser_malawi','priv_dispenser_uganda','priv_issue_tracker_kenya','priv_issue_tracker_malawi','priv_issue_tracker_uganda','priv_evaluation_kenya','priv_evaluation_malawi','priv_evaluation_uganda','priv_expansion_kenya','priv_expansion_malawi','priv_expansion_uganda','priv_on_demand_kenya','priv_on_demand_malawi','priv_on_demand_uganda','priv_other_kenya','priv_other_malawi','priv_other_uganda','priv_standard_reports_kenya','priv_standard_reports_malawi','priv_standard_reports_uganda','priv_diagnostic_kenya','priv_diagnostic_malawi','priv_diagnostic_uganda');
			$fieldsArray = array('id', 'employee_id', 'country', 'full_name Ascending', 'position', 'office_location', 'phone', 'email', 'password', 'priv_kenya', 'priv_malawi', 'priv_uganda', 'priv_asset_list_kenya', 'priv_asset_list_malawi', 'priv_asset_list_uganda', 'priv_fleet_list_kenya', 'priv_fleet_list_malawi', 'priv_fleet_list_uganda', 'priv_staff_list_kenya', 'priv_staff_list_malawi', 'priv_staff_list_uganda', 'priv_village_list_kenya', 'priv_village_list_uganda', 'priv_village_list_malawi', 'priv_waterpoint_list_kenya', 'priv_waterpoint_list_malawi', 'priv_waterpoint_list_uganda', 'priv_chlorine_inventory_kenya', 'priv_chlorine_inventory_malawi', 'priv_chlorine_inventory_uganda', 'priv_chlorine_planning_kenya', 'priv_chlorine_planning_malawi', 'priv_chlorine_planning_uganda', 'priv_chlorine_tracking_kenya', 'priv_chlorine_tracking_malawi', 'priv_chlorine_tracking_uganda', 'priv_fleet_manager_planning_kenya', 'priv_fleet_manager_planning_malawi', 'priv_fleet_manager_planning_uganda', 'priv_fleet_manager_tracking_kenya', 'priv_fleet_manager_tracking_malawi', 'priv_fleet_manager_tracking_uganda', 'priv_promoter_engagement_kenya', 'priv_promoter_engagement_malawi', 'priv_promoter_engagement_uganda', 'priv_dispenser_kenya', 'priv_dispenser_malawi', 'priv_dispenser_uganda', 'priv_issue_tracker_kenya', 'priv_issue_tracker_malawi', 'priv_issue_tracker_uganda', 'priv_evaluation_kenya', 'priv_evaluation_malawi', 'priv_evaluation_uganda', 'priv_expansion_kenya', 'priv_expansion_malawi', 'priv_expansion_uganda', 'priv_on_demand_kenya', 'priv_on_demand_malawi', 'priv_on_demand_uganda', 'priv_other_kenya', 'priv_other_malawi', 'priv_other_uganda', 'priv_standard_reports_kenya', 'priv_standard_reports_malawi', 'priv_standard_reports_uganda', 'priv_diagnostic_kenya', 'priv_diagnostic_malawi', 'priv_diagnostic_uganda', 'priv_survey_tracker_kenya', 'priv_survey_tracker_malawi', 'priv_survey_tracker_uganda');
			
			//  $fieldsArray = array('id', 'employee_id', 'country', 'full_name Ascending', 'position', 'office_location', 'phone', 'email', 'password', 'priv_kenya', 'priv_malawi', 'priv_uganda', 'priv_asset_list_kenya', 'priv_asset_list_malawi', 'priv_asset_list_uganda', 'priv_fleet_list_kenya', 'priv_fleet_list_malawi', 'priv_fleet_list_uganda', 'priv_staff_list_kenya', 'priv_staff_list_malawi', 'priv_staff_list_uganda', 'priv_waterpoint_list_kenya', 'priv_waterpoint_list_malawi', 'priv_waterpoint_list_uganda', 'priv_chlorine_inventory_kenya', 'priv_chlorine_inventory_malawi', 'priv_chlorine_inventory_uganda', 'priv_chlorine_planning_kenya', 'priv_chlorine_planning_malawi', 'priv_chlorine_planning_uganda', 'priv_chlorine_tracking_kenya', 'priv_chlorine_tracking_malawi', 'priv_chlorine_tracking_uganda', 'priv_fleet_manager_planning_kenya', 'priv_fleet_manager_planning_malawi', 'priv_fleet_manager_planning_uganda', 'priv_fleet_manager_tracking_kenya', 'priv_fleet_manager_tracking_malawi', 'priv_fleet_manager_tracking_uganda', 'priv_promoter_engagement_kenya', 'priv_promoter_engagement_malawi', 'priv_promoter_engagement_uganda', 'priv_dispenser_kenya', 'priv_dispenser_malawi', 'priv_dispenser_uganda', 'priv_issue_tracker_kenya', 'priv_issue_tracker_malawi', 'priv_issue_tracker_uganda', 'priv_evaluation_kenya', 'priv_evaluation_malawi', 'priv_evaluation_uganda', 'priv_expansion_kenya', 'priv_expansion_malawi', 'priv_expansion_uganda', 'priv_on_demand_kenya', 'priv_on_demand_malawi', 'priv_on_demand_uganda', 'priv_other_kenya', 'priv_other_malawi', 'priv_other_uganda', 'priv_standard_reports_kenya', 'priv_standard_reports_malawi', 'priv_standard_reports_uganda', 'priv_diagnostic_kenya', 'priv_diagnostic_malawi', 'priv_diagnostic_uganda');
			
			if ($_SESSION['priv_staff_list_' . strtolower($_SESSION['countryName'])] >= 4 || $_SESSION['id'] == $staffId) {
				
				
				if (isset($_POST["update-password-data"])) {
					
					//load model, perform an action on the model
					//  echo $table;
					
					/* <ramadhan's added code> */
					if ($_POST["currentPassword"] == MD5($_POST["oldPassword"]) && $_POST["password"] == $_POST["confirmPassword"]) {
					/* </ramadhan's added code> */	
						
						$button = $_POST["update-password-data"];
						
						unset($_POST["currentPassword"]);
						unset($_POST["oldPassword"]);
						unset($_POST["confirmPassword"]);
						unset($_POST["update-password-data"]);
						$_POST["update-password-data"] = $button;
						
						/* <ramadhan's added code> */
						$arrayData = array(
							'password' => MD5($_POST["password"])
						);
						
						$stffWrite = $uas_model->updateField('staff_list', $arrayData, $_POST['id']);
						/* </ramadhan's added code> */
						
						$full_name = $uas_model->getByPK($table, $_POST['id'], array('full_name'));
						
						$insertData = array(
                        'id' => '',
                        'country' => $_SESSION["country"],
                        'user_name' => $_SESSION["full_name"],
                        'email' => $_SESSION["email"],
                        'action' => 'Password set on Staff List',
                        'description' => 'name ' . $full_name[0]['full_name'],
                        'unused' => ''
						);
						$uas_model->addData('user_log_record', $insertData);
						
						$message = "Password Changed";
						$redirectURL = URL . 'uasettings/';
						} else {
						echo $_POST["country"];
						$message = "Password Mismatched";
					}
					
					// where to go after add
					//     header('location: ' . URL . 'uasettings/setPassword/'.$_POST["id"]);
				}
			} else {
				$message = urlencode('You lack the privilege to perform such action');
				header('Location:' . URL . 'home/?message=' . $message);
			}
			if ($staffId != false) {
				
				$single_record = $uas_model->getByPK($table, $staffId, $fieldsArray);
				//do some cleaning // its assiciative // make it serial
				$single_record = $single_record[0];
				$single_record = $this->serializeArray($single_record);
			}
			
			$fields = $uas_model->getFields($table);
			
			
			$dd = $uas_model->getByPK($table, $staffId, $fieldsArray);
			
			require 'application/views/_templates/header.php'; //Because of the country session to filter data
			require 'application/views/uas/sidebar.php';
			require 'application/views/uas/passwordSet.php';
			require 'application/views/_templates/footer.php';
		
		}
		
		public function setPrivilege($staffId = false) {
			$table = "staff_list";
			$tableName = str_replace("_", " ", $table);
			$tableName = ucwords($tableName);
			$uas_model = $this->loadModel('uasmodel');
			// $fieldsArray = array('full_name','employee_id','country','position','office_location','phone','email','password','priv_kenya','priv_malawi','priv_uganda','priv_asset_list_kenya','priv_asset_list_malawi','priv_asset_list_uganda','priv_fleet_list_kenya','priv_fleet_list_malawi','priv_fleet_list_uganda','priv_staff_list_kenya','priv_staff_list_malawi','priv_staff_list_uganda','priv_waterpoint_list_kenya','priv_waterpoint_list_malawi','priv_waterpoint_list_uganda','priv_chlorine_inventory_kenya','priv_chlorine_inventory_malawi','priv_chlorine_inventory_uganda','priv_chlorine_planning_kenya','priv_chlorine_planning_malawi','priv_chlorine_planning_uganda','priv_chlorine_tracking_kenya','priv_chlorine_tracking_malawi','priv_chlorine_tracking_uganda','priv_fleet_manager_planning_kenya','priv_fleet_manager_planning_malawi','priv_fleet_manager_planning_uganda','priv_fleet_manager_tracking_kenya','priv_fleet_manager_tracking_malawi','priv_fleet_manager_tracking_uganda','priv_fleet_manager_tracking_uganda','priv_promoter_engagement_kenya','priv_promoter_engagement_malawi','priv_promoter_engagement_uganda','priv_dispenser_kenya','priv_dispenser_malawi','priv_dispenser_uganda','priv_issue_tracker_kenya','priv_issue_tracker_malawi','priv_issue_tracker_uganda','priv_evaluation_kenya','priv_evaluation_malawi','priv_evaluation_uganda','priv_expansion_kenya','priv_expansion_malawi','priv_expansion_uganda','priv_on_demand_kenya','priv_on_demand_malawi','priv_on_demand_uganda','priv_other_kenya','priv_other_malawi','priv_other_uganda','priv_standard_reports_kenya','priv_standard_reports_malawi','priv_standard_reports_uganda','priv_diagnostic_kenya','priv_diagnostic_malawi','priv_diagnostic_uganda');
			$fieldsArray = array('id', 'employee_id', 'country', 'full_name Ascending', 'position', 'office_location', 'phone', 'email', 'password', 'priv_kenya', 'priv_malawi', 'priv_uganda', 'priv_asset_list_kenya', 'priv_asset_list_malawi', 'priv_asset_list_uganda', 'priv_fleet_list_kenya', 'priv_fleet_list_malawi', 'priv_fleet_list_uganda', 'priv_staff_list_kenya', 'priv_staff_list_malawi', 'priv_staff_list_uganda', 'priv_village_list_kenya', 'priv_village_list_uganda', 'priv_village_list_malawi', 'priv_waterpoint_list_kenya', 'priv_waterpoint_list_malawi', 'priv_waterpoint_list_uganda', 'priv_chlorine_inventory_kenya', 'priv_chlorine_inventory_malawi', 'priv_chlorine_inventory_uganda', 'priv_chlorine_planning_kenya', 'priv_chlorine_planning_malawi', 'priv_chlorine_planning_uganda', 'priv_chlorine_tracking_kenya', 'priv_chlorine_tracking_malawi', 'priv_chlorine_tracking_uganda', 'priv_fleet_manager_planning_kenya', 'priv_fleet_manager_planning_malawi', 'priv_fleet_manager_planning_uganda', 'priv_fleet_manager_tracking_kenya', 'priv_fleet_manager_tracking_malawi', 'priv_fleet_manager_tracking_uganda', 'priv_promoter_engagement_kenya', 'priv_promoter_engagement_malawi', 'priv_promoter_engagement_uganda', 'priv_dispenser_kenya', 'priv_dispenser_malawi', 'priv_dispenser_uganda', 'priv_issue_tracker_kenya', 'priv_issue_tracker_malawi', 'priv_issue_tracker_uganda', 'priv_evaluation_kenya', 'priv_evaluation_malawi', 'priv_evaluation_uganda', 'priv_expansion_kenya', 'priv_expansion_malawi', 'priv_expansion_uganda', 'priv_on_demand_kenya', 'priv_on_demand_malawi', 'priv_on_demand_uganda', 'priv_other_kenya', 'priv_other_malawi', 'priv_other_uganda', 'priv_standard_reports_kenya', 'priv_standard_reports_malawi', 'priv_standard_reports_uganda', 'priv_diagnostic_kenya', 'priv_diagnostic_malawi', 'priv_diagnostic_uganda', 'priv_survey_tracker_kenya', 'priv_survey_tracker_malawi', 'priv_survey_tracker_uganda');
			if (isset($_POST["update-uas-data"])) {
				
				//load model, perform an action on the model
				//  echo $table;
				
				$dd = $uas_model->updateData($_POST, $_POST['id'], $table);
				$full_name = $uas_model->getByPK($table, $_POST['id'], array('full_name'));
				
				$insertData = array(
                'id' => '',
                'country' => $_SESSION["country"],
                'user_name' => $_SESSION["full_name"],
                'email' => $_SESSION["email"],
                'action' => 'Privilege set on Staff List',
                'description' => 'name ' . $full_name[0]['full_name'],
                'unused' => ''
				);
				$uas_model->addData('user_log_record', $insertData);
				$message = "User Information Has been Updated.";
				// where to go after add
				//   header('location: ' . URL . 'uasettings/index/');
				$redirectURL = URL . 'uasettings/index';
			}
			
			
			if ($staffId != false) {
				
				$single_record = $uas_model->getByPK($table, $staffId, $fieldsArray);
				//do some cleaning // its assiciative // make it serial
				$single_record = $single_record[0];
				$single_record = $this->serializeArray($single_record);
			}
			
			$fields = $uas_model->getFields($table);
			
			$dd = $uas_model->getByPK($table, $staffId, $fieldsArray);
			
			require 'application/views/_templates/header.php'; //Because of the country session to filter data
			require 'application/views/uas/sidebar.php';
			require 'application/views/uas/edituas.php';
			require 'application/views/_templates/footer.php';
		}
		
	public function delete($table, $id) {
	// echo 'table ='.$table;
	// echo "<br>";
	// echo 'id ='.$id;
	// exit();
	$this->model = $this->loadModel('uasmodel');
	if (isset($id)) {
	$full_name = $this->model->getByPK($table, $id, array('full_name'));
	$this->model->deleteData($table, $id);
	
	
	$insertData = array(
	'id' => '',
	'country' => $_SESSION["country"],
	'user_name' => $_SESSION["full_name"],
	'email' => $_SESSION["email"],
	'action' => 'record deleted on Staff List',
	'description' => 'name ' . $full_name[0]['full_name'],
	'unused' => ''
	);
	$this->model->addData('user_log_record', $insertData);
	}
	
	header('location: ' . URL . 'uasettings/index/' . $table . '');
    }
	
    public function update($table, $edit = false) {
	// load the model
	$this->model = $this->loadModel('uasmodel');
	
	//update table
	if (isset($_POST['update-uas-data'])) {
	
	
	$this->model->updateData($_POST, $_POST['id'], $table);
	
	// redirect after update
	header('location: ' . URL . 'uasettings/index/');
	}
	
	date_default_timezone_set("Africa/Nairobi");
	// needed here tp access the session
	require 'application/views/_templates/header.php';
	
	$fieldsArray = $this->fieldsArray($table);
	
	$data = $this->model->getData($table, $fieldsArray);
	
	// change table name to proper case
	$tableName = str_replace("_", " ", $table);
	$tableName = ucwords($tableName);
	// $country = "Kenya";
	// if edit
	if ($edit != false) {
	
	$single_record = $this->model->getByPK($table, $edit, $fieldsArray);
	//do some cleaning // its assiciative // make it serial
	$single_record = $single_record[0];
	$single_record = $this->serializeArray($single_record);
	}
	
	$fields = $this->model->getFields($table);
	require 'application/views/uas/uas.php';
	require 'application/views/_templates/footer.php';
    }
	
	}
	
	// end class
	?>	