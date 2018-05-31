<?php

class scheduler extends Controller {

    public $scheduleModel;

    public function index() {
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/index.php';
        require 'application/views/_templates/footer.php';
    }

    private function fieldsArray($tableCall) {

        switch ($tableCall) {


            case 'site_v_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'field_officer_assigned', 'allowance', 'date');
            case 'vcs_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'field_officer_assigned', 'allowance', 'date');
            case 'dispenser_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'waterpoint_name', 'field_officer_assigned', 'installation_allowance', 'installation_date', 'cem_allowance', 'cem_date');
            case 'cem_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'waterpoint_name', 'field_officer_assigned', 'allowance', 'date');
            case 'village_details':
                return $fieldsArray = array('id', 'country', 'program', 'village_name', 'village_elder', 'elder_contact', 'chw_name', 'chw_contact');
            case 'cau_programs':
                return $fieldsArray = array('id', 'country', 'program', 'territory_id');

            default:
                return $fieldsArray = array('id', 'program', 'village_name', 'village_elder', 'elder_contact', 'chw_name', 'chw_contact', 'field_officer_assigned', 'allowance', 'date');
        }
    }

    private function getStage($table = 'site_v_schedule') {

        switch ($table) {

            case "site_v_schedule":
                return $stage = 'Waterpoint Verification Schedule';
            case "vcs_gen_schedule":
                return $stage = "Vcs Schedule";
            case "dispenser_gen_schedule":
                return $stage = 'Dispenser Schedule';
            case "cem_gen_schedule":
                return $stage = 'CEM Schedule';
            default :
                return $stage = 'Waterpoint Verification Schedule';
        }
    }

    private function getDestinationTable($table = 'site_v_schedule') {

        switch ($table) {

            case "site_v_schedule":
                return $destinationTable = 'site_v_schedule';
            case "vcs_gen_schedule":
                return $destinationTable = 'vcs_gen_schedule';
            case "dispenser_gen_schedule":
                return $destinationTable = 'dispenser_gen_schedule';
            case "cem_gen_schedule":
                return $destinationTable = 'cem_gen_schedule';
            default :
                return $destinationTable = 'site_v_schedule';
        }
    }

    private function getpopulateCategory($table = 'site_v_schedule') {

        switch ($table) {

            case "site_v_schedule":
                return $category = 'populateSvSchedule';
            case "vcs_gen_schedule":
                return $category = 'populateVcsSchedule';
            case "dispenser_gen_schedule":
                return $category = 'populateDispenserSchedule';
            case "cem_gen_schedule":
                return $category = 'populateDispenserSchedule2';
            default :
                return $category = 'populateSvSchedule';
        }
    }

    public function planSchedule($table = null, $program = null) {

        //$table--Source of information
        //$destinationTable --where the data is to be dumped and accessed

        if ($table != null && $program != null) {
            $scheduleModel = $this->loadModel('schedulemodel');
            $fieldsArray = $this->fieldsArray($table);
            $siteverificationId = explode('/', $_GET['url']);
            $program = $siteverificationId[3];
            $data = $scheduleModel->getSchedule($table, $fieldsArray, $program);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            //$fields = $scheduleModel->getFields($table,$fieldsArray);
            $stage = $this->getStage($table);
            $category = $this->getpopulateCategory($table);
            $staffDropDown = $scheduleModel->getStaffDropDown();
            $villageDropDown = $scheduleModel->getVillageDropDown();

            $destinationTable = $this->getDestinationTable($table);
            $cauManage = $scheduleModel->checkSelectedCau($table);

            if ($table != 'cem_gen_schedule') {
                $desiredCau = $scheduleModel->getFieldOfficerAssignement($table);
            } else {
                $desiredCau = $scheduleModel->getFieldOfficerAssignement('dispenser_gen_schedule');
            }
            if ($desiredCau == null) {
                $desiredCauCode = $scheduleModel->getdefaultCauCode();
            } else {
                $desiredCauCode = $desiredCau[0]['assign_field_officers_per'];
            }

            $desiredCauName = $scheduleModel->getCauName($desiredCauCode);
            $cauDropDown = $scheduleModel->getcauDropDown($desiredCauCode);
            $fieldsArray2 = array('id', 'program', 'field_officer_assigned', 'allowance', 'date');
            // Just using the fields from this table to extract array the way i want it. It is similar all scheduling tables
            // The Saving process is quite different.Check the addSchedule Fxn 
            $fields = $scheduleModel->getFields($table, $fieldsArray2);

            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/schedules/index.php';
            require 'application/views/_templates/footer.php';
        } else {
            header('Location:' . URL . 'processdata/expansionIndex');
        }
    }

    public function addSchedule($table) {


        $scheduleModel = $this->loadModel('schedulemodel');
        $fieldsArray = $this->fieldsArray('cau_programs');
        $siteverificationId = explode('/', $_GET['url']);
        if ($table == 'site_v_schedule') {
            $villageDetails = $scheduleModel->getvillageIdDetails('cau_programs', $_POST['program'], $fieldsArray, $_POST['desiredCau']);
        } else {
            $villageDetails = $scheduleModel->getWaterpointvillageIdDetails('waterpoint_details', $_POST['program'], $_POST['desiredCau']);
        }

        $delete = 0;

        $counter = 0;
        $maxCount = sizeof($villageDetails);
        foreach ($villageDetails as $key => $value) {

            if ($delete == 1) {
                unset($villageDetails[$counter - 1]);
                $delete = 0;
            }
            if ($value[$_POST['desiredCau']] != $_POST['territory']) {
                //echo $value[$_POST['desiredCau']];

                $delete = 1;
            }
            if ($counter == 98) {
                $villageDetails[$counter]["last"] = "Go Awat";
            }
            ++$counter;
        }
        if ($delete == 1) {
            array_pop($villageDetails);
        }
        if ($villageDetails == null) {
            $message = urlencode('Villages Not Found');
            header('location: ' . URL . 'scheduler/planSchedule/' . $table . '/' . $_POST['program'] . '/?message=' . $message);
        }

        foreach ($villageDetails as $key => $value) {
            $record = array(
                "village_name" => $value["territory_id"],
                "program" => $_POST["program"],
                "allowance" => round($_POST['allowance'] / sizeof($villageDetails)),
                "field_officer_assigned" => $_POST["field_officer_assigned"],
                "date" => $_POST["date"]
            );
            $record["add-schedule-data"] = '';
            $this->scheduleAddMany($table, $record, $_POST['program']);
            $_GET['message'] = 'F.O Details Added';
            header('location: ' . URL . 'scheduler/planSchedule/' . $table . '/' . $_POST['program']);
        }

        if (isset($_POST['add-schedule-data']) && $villageDetails != null) {
            $logsModel = $this->loadModel('logsmodel');
            $logsModel->insertLogVerfication($table, $_POST['program']);
        }
    }

    public function scheduleAddMany($table, $Record, $program) {
        if (isset($Record["add-schedule-data"])) {

            $scheduleModel = $this->loadModel('schedulemodel');
            unset($Record["add-schedule-data"]);
            $scheduleModel->addData($table, $Record);
        }
    }

    public function populateSvSchedule($table, $program) {
        date_default_timezone_set("Africa/Nairobi");
        // For this to work, it must first find program related data in the schedule table and delete it all
        //Once its done, it can be repopulated/populated 
        $scheduleModel = $this->loadModel('schedulemodel');
        $scheduleModel->deleteProgram('site_v_schedule');
        $siteverificationId = explode('/', $_GET['url']);
        $programArr = $scheduleModel->getProgramId($siteverificationId[3]);
        if (isset($programArr[0]["id"])) {
            $programId = $programArr[0]["id"];
        } else {
            $_GET['message'] = 'Error with Program.';
            $this->planSchedule('site_v_schedule', $siteverificationId[3]);
            exit();
        }
        $sql = 'SELECT * from site_verification WHERE program="' . $siteverificationId[3] . '"';

        $data = $scheduleModel->runRawQuery($sql);

        $assigningCau = $scheduleModel->getAssignedCau($table) ? $scheduleModel->getAssignedCau($table) : "village";
        $fieldsArray = $this->fieldsArray('cau_programs');

        $Tabledata = $scheduleModel->getSiteVerificationOfficers('waterpoint_verification', $programId); //gets field officer
        $Tabledata2 = $scheduleModel->getvillageDetails('cau_programs', $siteverificationId[3], $fieldsArray);

        if (sizeof($Tabledata) != $data[0]['no_of_field_officers']) {
            $_GET['message'] = 'Data Incomplete.The number of Field Officers Selected and<br/> the ones assumed when creating the Waterpoint verification of the Program ' . $siteverificationId[3] . ' do not match.';
            $this->planSchedule('site_v_schedule', $siteverificationId[3]);
            exit();
        }
        $fieldofficerapearencecounter = 0;
        $datecounter = -1;
        $fieldofficerapearence = round(sizeof($Tabledata2) / sizeof($Tabledata));
        $startDate = strtotime($data[0]['verification_start_date']);
        $AllowancePerDay = $data[0]['funds_given_per_fo_per_day'];
        $num_of_verification_per_day = $data[0]['no_of_verifications_per_day'];
        $amount_per_verification = $AllowancePerDay / $num_of_verification_per_day;
        $totalVerificationCount = 0;


        $targetedCau = ""; //The territory being looped through
        $counter = 1; //manages assigment of territories
        $counter2 = 0; //Manages assigning of field officers
        $fieldOfficerAssign = 0; //counts the number of verifications done per loop


        $fieldOfficerArray = array(); //This will be used to check if a field officer was previously assigned
        //the money they needed for a particular date
        $allOfficersPassed = 0;
        if ($Tabledata != null && $Tabledata2 != null) {
            foreach ($Tabledata2 as $key => $value) {


                $record = array(
                    "village_name" => $value['territory_id'],
                    "program" => $siteverificationId[3]
                );

                if ($counter == 1) {
                    $targetedCau = $value[$assigningCau];
                }//If its the first row assign the cau to the variable $targeted Cau

                if (strtolower($targetedCau) != strtolower($value[$assigningCau])) {
                    $fieldOfficerAssign+=1; //a verification has been made for the specified cau
                    $targetedCau = $value[$assigningCau];
                    $totalVerificationCount+=1; //manages setting of dates	        	
                }

                $datecounter++;
                if ($num_of_verification_per_day == $datecounter) {
                    if (strtolower(date('D', $startDate)) == "sat") {
                        $startDate = $startDate + 172800;
                    } else {
                        $startDate = $startDate + 86400;
                    }
                    $datecounter = 0;
                }

                $fieldofficerapearencecounter++;
                if ($fieldofficerapearencecounter == $fieldofficerapearence) {
                    $counter2+=1; //Switch to a new officer
                    $fieldOfficerAssign = 0; //Since its a new officer their assignment is zero unless otherwise.check fieldOfficerArray below	        	
                    $fieldofficerapearencecounter = 0;
                    $datecounter = 0;
                    $startDate = strtotime($data[0]['verification_start_date']);
                }

                $record['field_officer_assigned'] = $Tabledata[$counter2]['field_officer'];
                $record['allowance'] = $amount_per_verification;

                $startDater = date('d-m-Y', $startDate);
                $record['date'] = $startDater;

                $scheduleModel->addData('site_v_schedule', $record);
                ++$counter;
            }
        } else {
            $_GET['message'] = 'Data Incomplete.';
        }
        $this->planSchedule('site_v_schedule', $siteverificationId[3]);
    }

    public function populateVcsSchedule($destinationTable, $program) {
        date_default_timezone_set("Africa/Nairobi");
        // For this to work, it must first find program related data in the schedule table and delete it all
        //Once its done, it can be repopulated/populated 
        $scheduleModel = $this->loadModel('schedulemodel');
        $scheduleModel->deleteProgram('vcs_gen_schedule', $program);
        $siteverificationId = explode('/', $_GET['url']);
        $sql = 'SELECT * from vcs_schedule WHERE program="' . $siteverificationId[3] . '"';
        $programArr = $scheduleModel->getProgramId($siteverificationId[3]);
        $data = $scheduleModel->runRawQuery($sql);
        if (isset($programArr[0]["id"])) {
            $programId = $programArr[0]["id"];
        } else {
            $_GET['message'] = 'Error with Program.';
            $this->planSchedule('vcs_gen_schedule', $siteverificationId[3]);
            exit();
        }
        $assigningCau = $scheduleModel->getAssignedCau('vcs_gen_schedule') ? $scheduleModel->getAssignedCau('vcs_gen_schedule') : "village";

        $Tabledata = $scheduleModel->getSiteVerificationOfficers('vcs_meeting', $programId);
        $Tabledata2 = $scheduleModel->getWaterpointvillageDetails('waterpoint_details', $siteverificationId[3], $assigningCau);
        if (sizeof($Tabledata) != $data[0]['no_of_field_officers']) {
            $_GET['message'] = 'Data Incomplete.The number of Field Officers Selected and<br/> the ones assumed when creating the VCS of the Program ' . $siteverificationId[3] . ' do not match.';
            $this->planSchedule('vcs_gen_schedule', $siteverificationId[3]);
            exit();
        }
        $totalVerifications = $data[0]['no_of_vcs_per_day_per_fo'] * $data[0]['no_of_field_officers'];
        $vcsDays = sizeof($Tabledata2) / $data[0]['no_of_vcs_per_day_per_fo'];
        $data[0]['start_date'];
        $foPerDay = $data[0]['funds_given_per_fo_per_day'] / $data[0]['no_of_vcs_per_day_per_fo'];
        $startDate = strtotime($data[0]['start_date']);
        $targetedCau = "";
        $fieldOfficerAssign = 0;
        $totalVerificationCount = 0;
        $counter2 = 0;
        $amountAllocated = 0;
        $counter = 1;
        if ($Tabledata != null && $Tabledata2 != null) {
            foreach ($Tabledata2 as $key => $value) {


                $record = array(
                    "village_name" => $value['village_name'],
                    "program" => $siteverificationId[3],
                );


                if ($counter == 1) {
                    $targetedCau = $value[$assigningCau];
                }//If its the first row assign the cau to the variable $targeted Cau

                if (strtolower($targetedCau) != strtolower($value[$assigningCau])) {
                    $fieldOfficerAssign+=1; //a verification has been made for the specified cau
                    $targetedCau = $value[$assigningCau];
                    $totalVerificationCount+=1; //manages setting of dates
                }

                if ($fieldOfficerAssign - $data[0]['no_of_vcs_per_day_per_fo'] == 0) {
                    $counter2+=1; //Switch to a new officer
                    $fieldOfficerAssign = 0; //Since its a new officer their assignment is zero unless otherwise.check fieldOfficerArray below
                    $amountAllocated = 0;
                    //If the number of verifications have been reached, it should turn to 0 for a new officer
                }


                if (sizeof($Tabledata) - $counter2 == 0 && $counter != 1) {
                    $counter2 = 0;
                }

                $record['field_officer_assigned'] = $Tabledata[$counter2]['field_officer'];

                ///Funds Algorithm
                if ($amountAllocated == 0) {
                    $record['allowance'] = $data[0]['funds_given_per_fo_per_day'];
                    $amountAllocated+=$data[0]['funds_given_per_fo_per_day'];
                } else {
                    $record['allowance'] = '';
                }

                if ($totalVerificationCount != 0 && $totalVerifications == $totalVerificationCount) {

                    if (strtolower(date('D', $startDate)) == "sun") {
                        $startDate = $startDate + 86400;
                        //
                    } else {
                        $startDate+=86400;
                        if (strtolower(date('D', $startDate)) == "sun") {
                            $startDate+=86400;
                        }
                    }
                    $startDater = date('d-m-Y', $startDate);
                    $record['date'] = $startDater;
                    $totalVerificationCount = 0;
                } else {

                    if (strtolower(date('D', $startDate)) == "sun") {
                        $startDate = $startDate + 86400;
                    }

                    $startDater = date('d-m-Y', $startDate);
                    $record['date'] = $startDater;
                }


                $scheduleModel->addData('vcs_gen_schedule', $record);
                ++$counter;
            }
        } else {
            $_GET['message'] = 'Data Incomplete.';
        }
        $this->planSchedule('vcs_gen_schedule', $siteverificationId[3]);
    }

    public function populateDispenserSchedule($destinationTable, $program) {
        date_default_timezone_set("Africa/Nairobi");
        // For this to work, it must first find program related data in the schedule table and delete it all
        //Once its done, it can be repopulated/populated 
        $scheduleModel = $this->loadModel('schedulemodel');
        $scheduleModel->deleteProgram('dispenser_gen_schedule', $program);
        $siteverificationId = explode('/', $_GET['url']);
        $sql = 'SELECT * from dispenser_installation_schedule WHERE program="' . $siteverificationId[3] . '"';
        $assigningCau = $scheduleModel->getAssignedCau('vcs_gen_schedule') ? $scheduleModel->getAssignedCau('vcs_gen_schedule') : "village";

        $data = $scheduleModel->runRawQuery($sql);
        $programArr = $scheduleModel->getProgramId($siteverificationId[3]);
        if (isset($programArr[0]["id"])) {
            $programId = $programArr[0]["id"];
        } else {
            $_GET['message'] = 'Error with Program.';
            $this->planSchedule('dispenser_gen_schedule', $siteverificationId[3]);
            exit();
        }
        $Tabledata = $scheduleModel->getSiteVerificationOfficers('dispenser_installation_field_officers', $programId);
        $Tabledata2 = $scheduleModel->getWaterpointvillageDetails('waterpoint_details', $siteverificationId[3], $assigningCau);
        $counter2 = 0;
        $counter = 1;
        if (sizeof($Tabledata) != $data[0]['no_of_field_officers']) {
            $_GET['message'] = 'Data Incomplete.The number of Field Officers Selected and<br/> the ones assumed when creating the Installation & Cem of the Program ' . $siteverificationId[3] . ' do not match.';
            $this->planSchedule('dispenser_gen_schedule', $siteverificationId[3]);
            exit();
        }
        $AllowancePerDay = ($data[0]['vehicle_cost_per_day'] + $data[0]['funds_given_per_fo_per_day']);
        $totalVerifications = $data[0]['no_of_installations_per_day'] * $data[0]['no_of_field_officers'];
        $startDate = strtotime($data[0]['installation_start_date']);
        $cemFoPerDay = $AllowancePerDay;
        $cemStartDate = strtotime($data[0]['cem_start_date']);
        $targetedCau = "";
        $fieldOfficerAssign = 0;
        $totalVerificationCount = 0;
        $amountAllocated = 0;
        if ($Tabledata != null && $Tabledata2 != null) {
            foreach ($Tabledata2 as $key => $value) {


                $record = array(
                    "village_name" => $value['village_name'],
                    "waterpoint_name" => $value['waterpoint_name'],
                    "program" => $siteverificationId[3],
                );

                if ($counter == 1) {
                    $targetedCau = $value[$assigningCau];
                }//If its the first row assign the cau to the variable $targeted Cau

                if (strtolower($targetedCau) != strtolower($value[$assigningCau])) {
                    $fieldOfficerAssign+=1; //a verification has been made for the specified cau
                    $targetedCau = $value[$assigningCau];
                    $totalVerificationCount+=1; //manages setting of dates
                }

                if ($fieldOfficerAssign - $data[0]['no_of_installations_per_day'] == 0) {
                    $counter2+=1; //Switch to a new officer
                    $fieldOfficerAssign = 0; //Since its a new officer their assignment is zero unless otherwise.check fieldOfficerArray below
                    $amountAllocated = 0;
                    //If the number of verifications have been reached, it should turn to 0 for a new officer
                }


                if (sizeof($Tabledata) - $counter2 == 0 && $counter != 1) {
                    $counter2 = 0;
                }

                $record['field_officer_assigned'] = $Tabledata[$counter2]['field_officer'];

                ///Funds Algorithm
                if ($amountAllocated == 0) {
                    $record['installation_allowance'] = $AllowancePerDay;
                    $record['cem_allowance'] = $cemFoPerDay;
                    $amountAllocated+=$AllowancePerDay;
                } else {
                    $record['installation_allowance'] = '';
                    $record['cem_allowance'] = '';
                }



                if ($totalVerificationCount != 0 && $totalVerifications == $totalVerificationCount) {

                    if (strtolower(date('D', $startDate)) == "sun") {
                        $startDate = $startDate + 86400;
                    } else {
                        $startDate+=86400;
                        if (strtolower(date('D', $startDate)) == "sun") {
                            $startDate+=86400;
                        }
                    }
                    $startDater = date('d-m-Y', $startDate);
                    $record['installation_date'] = $startDater;
                    $totalVerificationCount = 0;
                } else {

                    if (strtolower(date('D', $startDate)) == "sun") {
                        $startDate = $startDate + 86400;
                    }

                    $startDater = date('d-m-Y', $startDate);
                    $record['installation_date'] = $startDater;
                }
                $cemDate = $startDate + (86400 * 3);
                if (strtolower(date('D', $cemDate)) == "sun") {
                    $cemDate+=86400;
                }
                $cemDater = date('d-m-Y', $cemDate);
                $record['cem_date'] = $cemDater;

                $scheduleModel->addData('dispenser_gen_schedule', $record);



                ++$counter;
            }
        } else {
            $_GET['message'] = 'Data Incomplete.';
        }
        $this->planSchedule('dispenser_gen_schedule', $siteverificationId[3]);
    }

    public function emptySchedule($table, $program) {
        $scheduleModel = $this->loadModel('schedulemodel');
        $logsModel = $this->loadModel('logsmodel');
        $scheduleModel->deleteProgram($table);
        $logsModel->insertLogVerficationOnDelet($table, $program, 'all');
        $siteverificationId = explode('/', $_GET['url']);
        header('Location:' . URL . 'scheduler/planSchedule/' . $table . '/' . $siteverificationId[3]);
        $_GET['message'] = 'Program Schedule Emptied.';
    }

    public function updateSchedule($table, $edit = false, $program) {
        // load the model
        $scheduleModel = $this->loadModel('schedulemodel');
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[4];
        //update table
        if (isset($_POST['update-schedule'])) {
            $scheduleModel->updateData($_POST, $_POST['id'], $table);
            $logsModel = $this->loadModel('logsmodel');
            $logsModel->insertLogVerficationOnEdit($table, $_POST['program']);
            $_GET['message'] = 'F.O Details Updated.';
            $this->planSchedule($table, $program);
        } else {



            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $scheduleModel->getData($table);
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $scheduleModel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $scheduleModel->getFields($table);
            $staffDropDown = $scheduleModel->getStaffDropDown();
            $villageDropDown = $scheduleModel->getVillageDropDown();


            require 'application/views/process/expansion/schedules/editSchedule.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function deleteSchedule($table, $id, $program) {
        $scheduleModel = $this->loadModel('schedulemodel');
        $logsModel = $this->loadModel('logsmodel');
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[4];
        if (isset($id)) {
            $scheduleModel->deleteData($table, $id);
            $logsModel->insertLogVerficationOnDelet($table, $program,'one');
            $_GET['message'] = 'F.O Details Deleted';
        }
        header('location: ' . URL . 'scheduler/planSchedule/' . $table . '/' . rawurlencode($program));
    }

    public function scheduleAdd($table, $program) {

        if (isset($_POST["add-schedule-data"])) {
            $_GET['message'] = 'F.O Details Added';
            $scheduleModel = $this->loadModel('schedulemodel');
            unset($_POST["add-schedule-data"]);
            $scheduleModel->addData($table, $_POST);
            //echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            // exit();
        }

        // where to go after add
        header('location: ' . URL . 'scheduler/planSchedule/' . $table . '/' . $program);
    }

    public function serializeArray($single_record) {
        $i = 0;
        foreach ($single_record as $key => $value) {
            unset($single_record[$key]);
            $single_record[$i] = $value;
            $i++;
        }

        return $single_record;
    }

    /**
     * Description : export to CSV.
     *
     * @param 
     */
    public function export($table) {

        $scheduleModel = $this->loadModel('schedulemodel');

        // get the fields array
        $fieldsArray = $this->fieldsArray($table);
        $sheet = $scheduleModel->getData($table, $fieldsArray);
        $fieldsArray = $fieldsArray;
        $csv_name = str_replace("_", " ", $table);
        $csv_name = ucwords($csv_name);

        $this->model = $this->loadModel('csvmodel');

        $header = $this->model->replace_upper($table);


        // send these data to export model
        $this->model->export($sheet, $header, $csv_name);
    }

}

?>