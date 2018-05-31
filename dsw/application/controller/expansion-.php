<?php

class expansion extends Controller {

    public $model;

    public function index() {
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/index.php';
        require 'application/views/_templates/footer.php';
    }

    private function fieldsArray($tableCall) {

        switch ($tableCall) {
            case 'lsmCall':
                return $fieldsArray = array('id', 'country', 'lsm_title', 'meeting_date', 'meeting_time', 'location');

            case 'dutiesLsm':
                return $fieldsArray = array('id', 'lsm_id', 'full_name', 'duties');
            case 'budget_lsm':
                return $fieldsArray = array('id', 'lsm_id', 'item', 'cost');
            case 'site_verify':
                return $fieldsArray = array('id', 'country', 'program', 'no_of_field_officers', 'no_of_verifications_per_day', 'verification_start_date', 'total_expected_verification', 'funds_given_per_fo_per_day', 'approximate_no_of_waterpoints_per_village');
            case 'fo_verify':
                return $fieldsArray = array('id', 'program', 'field_officer');
            case "waterpoint":
                return $fieldsArray = array('id', 'country', 'program', 'waterpoint_name', 'waterpoint_id', 'verification_id', 'dispenser_barcode', 'village', 'number_of_hhs', 'water_source_type', 'nearest_type', 'nearest_market', 'market_days', 'directions', 'land_owner_name', 'land_owner_contact', 'nearest_boma', 'boma_contact', 'activities', 'activity_days', 'nearest_mama', 'mama_contact', 'neighbor_name', 'neighbor_contact', 'installation_date', 'notes', 'latitude', 'longitude');
            case "vcs_schedule":
                return $fieldsArray = array('id', 'country', 'program', 'no_of_field_officers', 'no_of_vcs_per_day_per_fo', 'funds_given_per_fo_per_day', 'start_date');
            case "vcs_meeting":
                return $fieldsArray = array('id', 'country', 'program', 'field_officer');
            case "program_setup":
                return $fieldsArray = array('id', 'country', 'program');
            case "message_template";
                return $fieldsArray = array('id', 'template_name', 'message');
            case "dispenserInstallSchedule";
                return $fieldsArray = array('id', 'country', 'program', 'no_of_field_officers', 'no_of_installations_per_day', 'no_of_cems_per_fo_per_day', 'no_of_vehicles', 'no_of_field_officers_assigned_per_vehicle', 'installation_start_date', 'cem_start_date', 'cost_associated_with_each_cem', 'funds_given_per_fo_per_day', 'vehicle_cost_per_day');
            case "dispenserInstallSchedule2";
                return $fieldsArray = array('id', 'country', 'program', 'no_of_field_officers', 'no_of_installations_per_day', 'no_of_vehicles', 'no_of_field_officers_assigned_per_vehicle', 'installation_start_date', 'funds_given_per_fo_per_day', 'vehicle_cost_per_day');
            case 'view_cem':
                return $fieldsArray = array('id', 'country', 'program', 'no_of_field_officers', 'no_of_cems_per_fo_per_day', 'cem_start_date', 'cost_associated_with_each_cem', 'funds_given_per_fo_per_day');
            case "dispenser_material":
                return $fieldsArray = array('id', 'program', 'material', 'quantity');
            case "dispenser_installation_field_officers";
                return $fieldsArray = array('id', 'program', 'field_officer');
            case "cem_material":
                return $fieldsArray = array('id', 'program', 'material', 'quantity');
            case "cem_field_officers":
                return $fieldsArray = array('id', 'program', 'field_officer');
            case 'verify_tracking':
                return $fieldsArray = array('id', 'country', 'program', 'village_name', 'field_officer', 'date_survey_completed', 'waterpoint_name', 'verification_id', 'status', 'reason_for_fail');
            case 'vcsTracking':
                return $fieldsArray = array('id', 'program', 'village_name', 'date', 'time', 'venue', 'field_officer_responsible', 'initial_status', 'final_status', 'population', 'quorum', 'prize_quorum', 'people_present', 'elder_name', 'elder_contact', 'chw_name', 'chw_contacts', 'mycyl_allocated', 'directions', 'notes');
            case 'tid':
                return $fieldsArray = array('id', 'program', 'waterpoint_id', 'installation_date', 'csa_responsible', 'field_officer', 'was_it_installed', 'were_materials_mobilized', 'problems_with_installation');
            case 'tracking_waterpoint_data':
                return $fieldsArray = array('id', 'country', 'program', 'village', 'waterpoint_name', 'waterpoint_id', 'land_owner_name', 'land_owner_contact', 'neighbor_name', 'neighbor_contact', 'number_of_hhs');
            case 'tracking_village_data':
                return $fieldsArray = array('program', 'village_name', 'village_elder', 'elder_contact', 'chw_name', 'chw_contact');
            case 'cem_track':
                return $fieldsArray = array('id', 'program', 'waterpoint_id', 'cem_schedule_date', 'cem_time', 'field_officer', 'status', 'why_failed', 'attendance', 'date_rescheduled', 'rescheduled_time', 'rescheduled_field_officer_responsible', 'date_completed', 'rescheduled_attendance', 'comment');
            case 'site_v_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'field_officer_assigned', 'allowance', 'date');
            case 'vcs_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'field_officer_assigned', 'allowance', 'date');
            case 'dispenser_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'waterpoint_name', 'field_officer_assigned', 'installation_allowance', 'installation_date', 'cem_allowance', 'cem_date');
            case 'cem_gen_schedule':
                return $fieldsArray = array('id', 'program', 'village_name', 'waterpoint_name', 'field_officer_assigned', 'allowance', 'date');
            case 'verification_temp':
                return $fieldsArray = array('id', 'country', 'program', 'waterpoint_name', 'waterpoint_id', 'verification_id', 'status', 'dispenser_barcode', 'village', 'all_cau', 'number_of_hhs', 'water_source_type', 'nearest_type', 'nearest_market', 'market_days', 'directions', 'land_owner_name', 'land_owner_contact', 'nearest_boma', 'boma_contact', 'activities', 'activity_days', 'nearest_mama', 'mama_contact', 'neighbor_name', 'neighbor_contact', 'installation_date', 'notes', 'latitude', 'longitude');
            default:
                return $fieldsArray = null;
        }
    }

    /*
     * **************************************************************
     *             LSM SECTION                                     *
     *                                                             *
     *                                                             *
     * **************************************************************
     */

    public function lsmAjaxCall($table, $lsm_id, $column) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getExpansionAJaxData($table, $column, $lsm_id);
        echo $data = json_encode($data);
    }

    /**
     * This Method is designed to loop through the contacts as it sends messages either as sms or email   
     */
    public function messageDelivery($type, $WHERE) {

        //First We need to Retrieve all the officials Info

        $generaldata_model = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $lsmDistrictData = $generaldata_model->getWHEREData("lsm_details", 'officials', 'id', $WHERE);
        require_once('application/views/process/promoter/AfricasTalkingGateway.php');
        $username = "beanco";
        $apiKey = "7e264ef92d19ffd294f8bdafa5f126c7193c4bfd5bf5a9fb2151d605b5079fa4";
        if (isset($_POST["send-sms-message"])) {
            foreach ($lsmDistrictData as $key => $value) {

                $officialsArray = unserialize($value['officials']);

                foreach ($officialsArray as $key => $value) {
                    $recipients = $value['phone'];
                    $message = $_POST["message"];
                    $gateway = new AfricaStalkingGateway($username, $apiKey);
                    $send_sms_feedback = $gateway->sendMessage($recipients, $message);
                }
            }
            $logs_model->insertLogDataMessage('lsm_details', $WHERE, 'Sms');
        }

        if (isset($_POST["send-email-message"])) {
            require 'application/views/_templates/email/class.phpmailer.php';
            foreach ($lsmDistrictData as $key => $value) {

                $officialsArray = unserialize($value['officials']);

                foreach ($officialsArray as $key => $value) {



                    $sender = $_SESSION['full_name'] . ':' . $_SESSION['positionName'];
                    $recipient_name = $value['official'];
                    $recipient_email = $value['email'];
                    $subject = 'LSM Meeting';
                    $email_body = $_POST['message'];
                    $senderMail = filter_var($_POST['staff'], FILTER_VALIDATE_EMAIL) ? $_POST['staff'] : "mail@evidenceaction.com";
                    //Clean Data
                    $sender = addslashes(trim($sender));
                    $recipient_name = addslashes(trim($recipient_name));
                    $subject = addslashes(trim($subject));
                    $email_body = addslashes(trim($email_body));


                    //send Email to client ============================================

                    try {
                        $mail = new PHPMailer(true); //New instance, with exceptions enabled
                        $mail->IsSendmail();  // tell the class to use Sendmail
                        $mail->AddReplyTo($senderMail, $sender);
                        $mail->From = isset($senderMail) ? $senderMail : "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
                        $mail->FromName = $sender; //"Evidence Action";
                        $to = $recipient_email;
                        $mail->AddAddress($to);
                        $mail->Subject = $subject; //"Scheduled Pre-Survey";
                        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                        $mail->WordWrap = 80; // set word wrap
                        $mail->IsHTML(true);
                        $mail->Body = $email_body;
                        $mail->AddAttachment('public/img/logo.jpg');
                        $mail->Send();
                    } catch (phpmailerException $e) {
                        echo $e->errorMessage();
                    }
                }
            }
            $logs_model->insertLogDataMessage('lsm_details', $WHERE, 'Email');
        }

        $message = 'Message Sent';
        header('Location:' . URL . 'expansion/viewLSM/?tabActive=tab2');
    }

    /*  LSM CRUD */
    /*
      The Sequence of tables called in lsm is similar thus the
      code  was refractored into a method of its own
     */

    public function normalLSMLoad() {
        $generaldata_model = $this->loadModel('expansionmodel');


        /*   Cau Select    */

        $cauSelect = $generaldata_model->loadAllTerritories();

        if ($cauSelect == null) {
            $message = urlencode("<b>Unable to fetch Country Admin Units.</b><br/>This is only possible if you have not done one of the following:<br/>1.Set The Cau To Check in Lsm.<br/>2.There are no Country Admin Units for the Selected C.A.U in the Settings");
            header("Location:" . URL . "expansion/displaySet/lsm_default_check/?message=" . $message);
            exit();
        }

        $territory = isset($_GET['territory']) ? $_GET['territory'] : null;

        if ($territory != null) {
            /* District Officials */
            $territoryArray = array('territory_id', 'name', 'title', 'phone', 'email');
            $territoryData = $generaldata_model->getOfficialsWHEREData("officials_contacts", $territoryArray, $territory);
        } else {
            $territoryData = null;
        }

        $staffArray = array('id', 'full_name', 'country');
        $staffData = $generaldata_model->getData("staff_list", $staffArray);


        /* To Be Used For Viewing Existing LSM Meetings */
        $lsmDetailsArray = array('id', 'lsm_title', 'meeting_date', 'meeting_time', 'location');
        $WHERE = isset($_GET['meetingId']) ? urldecode($_GET['meetingId']) : null;
        if ($WHERE != null) {
            $lsmofficialsData = $generaldata_model->getWHEREData("lsm_details", 'id', $WHERE);
        } else {
            $lsmofficialsData = null;
        }
        $lsmData = $generaldata_model->getData("lsm_details", $lsmDetailsArray);

        /* To Be Used For Viewing Existing LSM Budget Data */
        $lsmBudgetDetails = array('id', 'lsm_id', 'item', 'cost');
        $tabActive = isset($_GET['tabActive']) ? $_GET['tabActive'] : 'tab1';
        $lsmBudgetData = null;
        if (isset($_GET['activeLsm'])) {
            $lsmBudgetData = $generaldata_model->getExpansionData("lsm_budget_details", $lsmBudgetDetails, 'lsm_id', $_GET['activeLsm']);
            $tabActive = $_GET['tabActive'];
        }

        /* Load all the staff and their duties */
        $lsmDutyDetails = array('id', 'lsm_id', 'full_name', 'duties');
        $lsmDutyData = null;
        if (isset($_GET['activeLsm'])) {
            //echo $_GET['activeLsm'];
            $lsmDutyData = $generaldata_model->getDutiesExpansionData("lsm_duties_details", $lsmDutyDetails, 'lsm_id', $_GET['activeLsm']);
            $tabActive = $_GET['tabActive'];
        }
        /* Load All Message Templates for sms & Email Messaging

         */

        $lsmMessagesArray = array('id', 'template_name', 'message');
        $lsmMessageData = $generaldata_model->getNonCountryData("message_templates", $lsmMessagesArray);

        /*
          Load Cau titles for lsm Title
         */
        $meetingTitlesArray = $generaldata_model->getMeetingTerritories();
        $meetingTitles = array();
        foreach ($meetingTitlesArray as $key => $value) {

            array_push($meetingTitles, $value["territory_name"] . ' meeting');
        }


        return $returnArray = array(
            'territoryData' => $territoryData,
            'lsmData' => $lsmData,
            'lsmBudgetData' => $lsmBudgetData,
            'lsmMessageData' => $lsmMessageData,
            'lsmofficialsData' => $lsmofficialsData,
            'lsmDutyData' => $lsmDutyData,
            'staffData' => $staffData,
            'meetingTitles' => $meetingTitles,
            'cauSelect' => $cauSelect,
            'tabActive' => $tabActive
        );
    }

    public function viewLSM($districtSelected = null) {
        require 'application/views/_templates/header.php';
        $tabActive = 'tab1';

        $returnArray = $this->normalLSMLoad();
        //The variables below are neccessary for a proper load of lsm
        $territoryData = $returnArray['territoryData'];
        $lsmData = $returnArray['lsmData'];
        $lsmofficialsData = $returnArray['lsmofficialsData'];
        $staffData = $returnArray['staffData'];
        $lsmDutyData = $returnArray['lsmDutyData'];
        $lsmBudgetData = $returnArray['lsmBudgetData'];
        $lsmMessageData = $returnArray['lsmMessageData'];
        $meetingTitles = $returnArray['meetingTitles'];
        $cauSelect = $returnArray['cauSelect'];
        $lsmOptionsData = $returnArray['tabActive'] ? $returnArray['tabActive'] : 'tab2';
        $tabActive = $lsmOptionsData;
        //End of the main lsm variables
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/index.php';
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

    public function viewCompleteLSM() {

        $table = 'lsm_details';
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('lsmCall');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getData($table, $fieldsArray);


        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/viewLsm.php';
        require 'application/views/_templates/footer.php';
    }

    public function lsmAdd($table = 'lsm_details') {

        $generaldata_model = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        if (isset($_POST['create-selected-officials'])) {
            $counter = 1;
            $officialsArray = array();

            while (isset($_POST["territory" . $counter])) {



                $officialsArray[$counter] = array(
                    'territory' => $_POST["territory" . $counter],
                    'phone' => $_POST["phone" . $counter],
                    'email' => $_POST["email" . $counter],
                    'official' => $_POST["official" . $counter]
                );
                unset($_POST["territory" . $counter]);
                unset($_POST["phone" . $counter]);
                unset($_POST["email" . $counter]);
                unset($_POST["official" . $counter]);
                ++$counter;
            }
            $officials = serialize($officialsArray);
        } else if (isset($_POST['create-lsm-meeting'])) {

            unset($_POST['create-lsm-meeting']);
            $dd = $generaldata_model->addData($table, $_POST);
            $logs_model->insertLogData($table, $_POST['territory_id'], 'territory_name');
            header('Location:' . URL . 'expansion/viewLSM/?tabActive=tab2');
            $message = "LSM Meeting Details Saved";
        } else if (isset($_POST['save-item-expense'])) {

            if ($_POST['item'] == '' || !intval($_POST['cost'])) {
                $message = "Error.Budgeted item Is Incomplete.";
            } else {
                unset($_POST['save-item-expense']);
                $dd = $generaldata_model->addData($table, $_POST);
                $logs_model->insertLogData($table, $_POST['item'], 'item_name');
                $message = "Budgeted item Saved";
            }

            $tabActive = "tab3";
        } else if (isset($_POST['save-staff-duties'])) {

            if ($_POST['full_name'] == '' || $_POST['duties'] == "") {
                $message = "Error. Data is incomplete";
            } else {
                unset($_POST['save-staff-duties']);
                $dd = $generaldata_model->addData($table, $_POST);
                $logs_model->insertLogData($table, $_POST['full_name'], 'staff_name');
                $message = "LSM Staff & their Duties have Been Saved";
            }

            $tabActive = "tab4";
        } else {
            $tabActive = 'tab1';
        }

        $returnArray = $this->normalLSMLoad();
        $territoryData = $returnArray['territoryData'];
        $lsmData = $returnArray['lsmData'];
        $lsmBudgetData = $returnArray['lsmBudgetData'];
        $lsmDutyData = $returnArray['lsmDutyData'];
        $staffData = $returnArray['staffData'];
        $lsmMessageData = $returnArray['lsmMessageData'];
        $meetingTitles = $returnArray['meetingTitles'];
        $cauSelect = $returnArray['cauSelect'];
        $lsmOptionsData = $returnArray['tabActive'] ? $returnArray['tabActive'] : 'tab2';
        $tabActive = $lsmOptionsData;

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function lsmDelete($table, $lsm_id) {
        $this->model = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        require 'application/views/_templates/header.php';
        if (isset($lsm_id)) {
            $logs_model->insertLogDataOnDelet($table, $lsm_id, 'territory_name');
            $this->model->deleteData($table, $lsm_id);

            $tabActive = 'tab2';
            $returnArray = $this->normalLSMLoad();
            $territoryData = $returnArray['territoryData'];
            $lsmData = $returnArray['lsmData'];
            $lsmDutyData = $returnArray['lsmDutyData'];
            $lsmBudgetData = $returnArray['lsmBudgetData'];
            $lsmMessageData = $returnArray['lsmMessageData'];
            $cauSelect = $returnArray['cauSelect'];
            $lsmOptionsData = isset($_GET['tabActive']) ? $_GET['tabActive'] : 'tab2';
            $tabActive = $lsmOptionsData;
            $message = "Record Deleted";
            header(URL . 'expansion/viewLSM/');
        }
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function lsmDelete2($table, $lsm_id) {
        $this->model = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        if (isset($lsm_id)) {
            $logs_model->insertLogDataOnDelet($table, $lsm_id, 'territory_name');
            $this->model->deleteData($table, $lsm_id);
            $fieldsArray = $this->fieldsArray('lsmCall');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $this->model->getData($table, $fieldsArray);
            $message = "Record Deleted";
            header(URL . 'expansion/viewLSM/');
        }
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/viewLsm.php';
        require 'application/views/_templates/footer.php';
    }

    public function updateBudgetDuties($table, $activeLsm, $edit = false) {

        // load the model
        $this->model = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        //update table
        if (isset($_POST['update-lsm'])) {

            $this->model->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogDataOnEdit($table, $_POST, 'item_name');
            // redirect after update
            header('location: ' . URL . 'expansion/viewLsm/?tabActive=tab2&activeLsm=' . $activeLsm);
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';

        $fieldsArray = null;

        $data = $this->model->getNonCountryData($table);

        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        if ($edit != false) {

            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }

        $fields = $this->model->getFields($table);
        $EditLsm = $activeLsm;

        require 'application/views/process/expansion/lsm/editLsmBudgetDuties.php';
        require 'application/views/_templates/footer.php';
    }

    public function updateLsm($table, $edit = false, $complete = null) {

        // load the model
        $logs_model = $this->loadModel('logsmodel');
        $this->model = $this->loadModel('expansionmodel');
        $territoryselected = $this->model->TerritoriesSelected('expansionmodel');
        $returnArray = $this->normalLSMLoad();
        $cauSelect = $returnArray['cauSelect'];

        //update table
        if (isset($_POST['update-lsm'])) {

            $this->model->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogDataOnEdit($table, $_POST['territory_id'], 'territory_name');
            if ($complete == null) {
                header('location: ' . URL . 'expansion/viewLsm/?tabActive=tab2');
            } else {
                header('location: ' . URL . 'expansion/viewCompleteLsm/');
            }
        }


        $extraUrl = $complete != null ? $complete : "";
        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';

        $fieldsArray = null;

        $data = $this->model->getNonCountryData($table);

        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        //  $country = "Kenya";
        $editLsm = $edit;
        if ($edit != false) {

            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }

        $fields = $this->model->getFields($table);


        require 'application/views/process/expansion/lsm/editLsm.php';
        require 'application/views/_templates/footer.php';
    }

    /*
     * ***************************************************************
     *         LSM-VERIFICATION TRANSITION                          *
     *                                                              *
     * ***************************************************************

     */

    public function lsmTransition2() {

        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getLsmTransitData();
        $pageTitle = 'List Of Lsms & Their Programs';
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/transitions/lsm_transition.php';
        require 'application/views/_templates/footer.php';
    }

    public function LsmTransition($table, $expectedController, $previousStage) {

        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getProgramDropDown();
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/transitions/verification_transition.php';
        require 'application/views/_templates/footer.php';
    }

    /*
     * **************************************************************
     *            SITE VERIFICATION SECTION                        *
     *                                                             *
     *                                                             *
     * **************************************************************
     */

    public function siteVerification() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('site_verify');
        $table = 'site_verification';
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
        foreach ($data as $key => $value) {

            if ($value['program']) {
                $programId = $expansionmodel->getProgramId($value['program']);
                $data[$key]["programId"] = $programId[0]["id"];
            }
        }
        $villageArr = $this->territoryCall();
        if (isset($_GET['tabActive'])) {
            $tabActive = $_GET['tabActive'];
        }
        if (isset($_GET['addVillageFor'])) {

            $tabActive = 'tab2';
        }
        $fields = $expansionmodel->getFields($table, $fieldsArray);
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        if (isset($_GET['viewOfficersFor'])) {
            $tabActive = 'tab2';
            $siteId = $_GET['viewOfficersFor'];
            $table2 = 'waterpoint_verification';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);
        } else if (isset($_GET['viewVillageFor'])) {

            $tabActive = 'tab2';
            $ProgramId = $_GET['viewVillageFor'];
            $villageDetails = $expansionmodel->getVillageswithProgram($ProgramId);
        } else if (isset($_GET['addOfficersFor'])) {
            $tabActive = 'tab3';
            $siteId = $_GET['addOfficersFor'];
            $table2 = 'waterpoint_verification';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);

            $positions = null;
            if ($fieldOfficersArray == null) {
                $exceptions = null;
            } else {
                $exceptions = $fieldOfficersArray;
            }

            $fieldOfficers = $expansionmodel->getVerificationOfficers('staff_list', $positions, $exceptions);
        }
        $lsmTerritories = $expansionmodel->getLsmTerritories();
        if ($lsmTerritories != null) {
            $firstKey = current(array_keys($lsmTerritories));
        }
        if (isset($_POST['nextPhase'])) {

            if (isset($_POST['data-table2_length'])) {
                unset($_POST['data-table2_length']);
            }
            $territoryCounter = 1;
            $territoryArray = array();
            $looptimes = sizeof($lsmTerritories);
            while ($looptimes >= 0) {
                if (isset($_POST['territoryId' . $territoryCounter]) > 0) {
                    array_push($territoryArray, $_POST['territoryId' . $territoryCounter]);
                }
                ++$territoryCounter;
                --$looptimes;
            }
            $territoryArray = json_encode($territoryArray);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/waterpoint_v/planVerification.php';
        require 'application/views/_templates/footer.php';
    }

    public function sVerificationAdd($table) {

        $logs_model = $this->loadModel('logsmodel');
        if (isset($_POST['add-verification-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $programExist = $this->checkProgram($table, $_POST['program']);
            $anotherProgrExist = $this->checkProgram('dsw_programs', $_POST['program']);

            if ($programExist == 0) {

                //Get the villages of the respective territories and add them to Cau Programs

                $villageDetails = $expansionmodel->getAllVillages($_POST['territories']);
                if ($villageDetails == null) {
                    $message = 'Error Creating Verification.No Villages Found.';
                    header('Location:' . URL . 'expansion/siteVerification/?message=' . urlencode($message));
                    exit();
                } else {
                    //Add The new program to dsw_programs  
                    $dswArr = array(
                        "id" => '',
                        "program" => $_POST['program']
                    );
                    if ($anotherProgrExist == 0) {
                        $newDswProgram = $expansionmodel->addData('dsw_programs', $dswArr);
                    }

                    $newDswProgramId = $expansionmodel->getProgramId($_POST['program'])[0]['id'];
                }
                ///make sure the villages don't have a program assigned to them already.
                //if not add them to C.A.U programs table
                $rejectCounter = 0;
                $allCounter = 0;
                foreach ($villageDetails as $key => $value) {

                    $villageCheck = $expansionmodel->checkVillage($value['id']);

                    if ($villageCheck == null) {
                        $newArray = array(
                            "program" => $newDswProgramId,
                            "country" => $_SESSION['country'],
                            "territory_id" => $value['id']
                        );
                        $expansionmodel->addData('cau_programs', $newArray);
                    } else {
                        ++$rejectCounter;
                    }
                    ++$allCounter;
                }

                unset($_POST['add-verification-data']);

                if ($rejectCounter == 0) {
                    $dd = $expansionmodel->addData($table, $_POST);
                    $logs_model->insertLogData($table, $_POST['program'], 'program_name');
                    $message = 'Verification Created. Click On Field Officer To continue';
                } else if ($rejectCounter == $allCounter) {
                    $message = 'Verification Was Not Created. All villages from the territories you selected were rejected because they <br/> have a program assigned to them.';
                    $expansionmodel->deleteData('dsw_programs', $newDswProgramId);
                } else {
                    $message = 'Verification Was Created But ' . $rejectCounter . ' out of ' . $allCounter . ' villages from the territories you selected were rejected because they <br/> have a program assigned to them.<br/>
               To View the villages that Passed  click on the view button under the territory column.';
                    $dd = $expansionmodel->addData($table, $_POST);
                    $logs_model->insertLogData($table, $_POST['program'], 'program_name');
                }

                $tabActive = 'tab2';
            } else {
                $message = 'Error Creating Verification.This Program Already Exists.';
                $tabActive = 'tab2';
            }
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'site_verification';
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/planVerification.php';
            require 'application/views/_templates/footer.php';
        } else if (isset($_POST['add-FO-data'])) {

            $expansionmodel = $this->loadModel('expansionmodel');

            unset($_POST['add-FO-data']);
            $dd = $expansionmodel->addData($table, $_POST);
            $message = 'Field Officer Schedule Added. Click On Field Officer To continue';
            $tabActive = 'tab2';
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'site_verification';
            $tableName = str_replace("_", " ", $table);
            $programDropDown = $this->getProgramDropDown();
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getSiteVerification($table, $fieldsArray);

            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/planVerification.php';
            require 'application/views/_templates/footer.php';
        } else {
            $this->siteVerification();
        }
    }

    public function verificationOfficialsAdd($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];

        while (strpos($fieldOfficers, ',') != false && $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);
                $expansionmodel->addOfficialExpansion('waterpoint_verification', $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            }
        }

        if (strpos($fieldOfficers, ',') == false && $fieldOfficers != '' && strlen($fieldOfficers) > 3) {
            $data = $expansionmodel->addOfficialExpansion('waterpoint_verification', $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        $logs_model->insertLogData('waterpoint_verification', $program, 'Official(s) added');
        $_GET['message'] = 'Official(s) Added';
        $_GET['addOfficersFor'] = $program;
        $this->siteVerification();
    }

    public function verificationOfficialsDelete($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];
        $logs_model->insertLogDataOnDelet('waterpoint_verification', $program, 'Official(s)');

        while (strpos($fieldOfficers, ',') != false || $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);

                $expansionmodel->removeOfficialExpansion('waterpoint_verification', $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            }
            if (strpos($fieldOfficers, ',') == false) {
                $data = $expansionmodel->removeOfficialExpansion('waterpoint_verification', $program, $fieldOfficers);
                $fieldOfficers = '';
            }
        }
        if (strpos($fieldOfficers, ',') == false) {
            $data = $expansionmodel->removeOfficialExpansion('waterpoint_verification', $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        $_GET['viewMessage'] = 'Official(s) Removed';
        $_GET['viewOfficersFor'] = $program;
        $this->siteVerification();
    }

    public function villageCauDelete($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $villages = $_POST['villagesArray'];
        $logs_model->insertLogDataOnDelet('cau_programs', $program, 'Village(s)');
        while (strpos($villages, ',') != false || $villages != '') {
            $lim = strpos($villages, ',');
            if ($lim != false) {
                $village = substr($villages, 0, $lim);

                $expansionmodel->removeVillageExpansion('cau_programs', $program, $village);
                ++$lim;
                $villages = substr($villages, $lim);
            }
            if (strpos($villages, ',') == false) {
                $data = $expansionmodel->removeVillageExpansion('cau_programs', $program, $villages);
                $villages = '';
            }
        }
        if (strpos($villages, ',') == false) {
            $data = $expansionmodel->removeVillageExpansion('cau_programs', $program, $villages);
            $villages = '';
        }
        $_GET['viewMessage'] = 'Village(s) Removed';
        $_GET['viewVillageFor'] = $program;
        $this->siteVerification();
    }

    public function territoryCall() {

        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getTerritoryInfo();
        return $data;
    }

    public function cauProgramsAdd($table = 'cau_programs', $programId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $villageCheck = $expansionmodel->checkVillage($programId);
        if ($villageCheck == null) {
            $newArray = array(
                "program" => $programId,
                "country" => $_SESSION['country'],
                "territory_id" => $_POST['territory_id']
            );
            $expansionmodel->addData('cau_programs', $newArray);
            $logs_model->insertLogData($table, $_POST['territory_id'], $programId);
            $message = 'Village Added Successfully';
        } else {
            $message = 'Unable to add. This Village already has a program assigned to it';
        }


        header("Location:" . URL . "expansion/siteVerification/?message=" . urlencode($message));
    }

    public function sVerificationUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogDataOnEdit('lsm_tracking', 'edit', 'edit');
            $message = 'Verification Details Updated.';
            $tabActive = 'tab2';
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'site_verification';
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/planVerification.php';
            require 'application/views/_templates/footer.php';
        } else {
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/waterpoint_v/editsV.php';
            require 'application/views/_templates/footer.php';
        }
    }

    private function deleteAllCau($programId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $deleteD = $expansionmodel->getAllVillagesWithProgram($programId);
        foreach ($deleteD as $key => $value) {
            $expansionmodel->deleteData('cau_programs', $value['id']);
        }
        $expansionmodel->deleteData('dsw_programs', $programId);
        return null;
    }

    public function ajaxChildCau($childCAU, $parentClassCAU, $parentCau) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getChildrenCau($childCAU, $parentClassCAU, $parentCau);
        echo $data = json_encode($data);
    }

    public function sVerificationDelete($table, $verificationId, $programId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        if (isset($verificationId)) {

            $expansionmodel->deleteData($table, $verificationId);
            $logs_model->insertLogDataOnDelet($table, $programId, ' program_name');
            $this->deleteAllCau($programId);

            $tabActive = 'tab2';
            $message = "Record Deleted";
            header('Location:' . URL . 'expansion/siteVerification/?message=' . urlencode($message) . '&tabActive=' . urlencode($tabActive));
        }
    }

    //This is for flipping existing elements.
    private function flipArrayElements($array, $elementBefore, $element) {
        if ($array != null) {
            foreach ($array as $key => $value) {
                $size = sizeof($array[$key]);
                $firstKey = key($array[$key]);
                $i = array_search($elementBefore, array_keys($array[$key]));
                $array2 = array_splice($array[$key], $i + 1, $size);
                $array1 = array_splice($array[$key], 0, $i + 1);

                if (isset($array2[$element])) {
                    $elementValue = $array2[$element];
                    unset($array2[$element]);
                    $array1[$element] = $elementValue;
                    foreach ($array2 as $key2 => $value2) {
                        $array1[$key2] = $value2;
                        unset($array2[$key2]);
                    }
                } else {
                    $elementValue = $array1[$element];
                    unset($array1[$element]);
                    $array1[$element] = $elementValue;
                    foreach ($array2 as $key2 => $value2) {
                        $array1[$key2] = $value2;
                        unset($array2[$key2]);
                    }
                }


                foreach ($array1 as $key3 => $value3) {
                    $array[$key][$key3] = $value3;
                    unset($array[$key3]);
                }
            }
            return $array;
        } else {
            return null;
        }
    }

    //This function is alot like the other above only instead of taking $elementBefore(a string),
    // it takes the index of the element before its position.
    private function flipIndexArrayElements($array, $i, $element) {

        foreach ($array as $key => $value) {
            $size = sizeof($array[$key]);
            //$firstKey=key($array[$key]);
            // $i = array_search($elementBefore, array_keys($array[$key]));
            $array2 = array_splice($array[$key], $i + 1, $size);
            $array1 = array_splice($array[$key], 0, $i + 1);

            $elementValue = isset($array2[$element]) ? $array2[$element] : $array1[$element];
            if (isset($array2[$element])) {
                unset($array2[$element]);
                $array1[$element] = $elementValue;
                foreach ($array2 as $key2 => $value2) {
                    $array1[$key2] = $value2;
                    unset($array2[$key2]);
                }
            } else {
                unset($array1[$element]);
                $array1[$element] = $elementValue;
                foreach ($array2 as $key2 => $value2) {
                    $array1[$key2] = $value2;
                    unset($array2[$key2]);
                }
            }

            foreach ($array1 as $key3 => $value3) {
                $array[$key][$key3] = $value3;
                unset($array[$key3]);
            }
        }
        return $array;
    }

    public function siteVerificationComplete() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('site_verify');
        $table = 'site_verification';
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
        $fields = $expansionmodel->getFields($table);


        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/waterpoint_v/verification.php';
        require 'application/views/_templates/footer.php';
    }

    public function siteVerificationTrack() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('site_verify');
        $table = 'site_verification';
        $tableName = str_replace("_", " ", "waterpoint_verification");
        $tableName = ucwords($tableName);

        $data = $expansionmodel->getSiteVerification($table, $fieldsArray);

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/waterpoint_v/verfication_tracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function trackVerification($program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('verify_tracking');
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[2];
        $table = 'verification_track';
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $uncheckedData = $expansionmodel->getVerificationWHEREData($table, $fieldsArray, 'program', $program);

        $fields = $expansionmodel->getFields($table, $fieldsArray);
        $programDropDown = $this->getProgramDropDown();
        $staffDropDown = $this->getStaffDropDown();
        //$villageDropDown = $this->getVillageDropDown();
        $data1 = $this->integrityChecks($uncheckedData);

        $data = $this->flipArrayElements($data1, 'waterpoint_name', 'Duplicate');


        $odkData = $expansionmodel->getOdkData('odk_verification', $program);

        $scheduleModel = $this->loadModel('schedulemodel');
        $cauManage = $scheduleModel->checkSelectedCau('site_v_schedule');
        $cauList = $expansionmodel->getRequiredCau();

        $ListedCaus = array();
        $i = 0;
        foreach ($cauList as $key => $value) {
            // echo $value['territory_name'].'<br/>';
            if ($i < 1 || strpos($value['territory_name'], 'village') !== false) {
                $retrivedTerritories = $expansionmodel->getCauList($value['id']);
                $j = 0;
                foreach ($retrivedTerritories as $key2 => $value2) {
                    $ListedCaus[$value['territory_name']][$j] = array(
                        "id" => $value2["id"],
                        "territory_name" => $value2["admin_territory_name"]
                    );
                    $j++;
                }
                ++$i;
            } else {
                continue;
            }
        }
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/waterpoint_v/verfication_tracker2.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * It checks for 1. Duplicates 2. Verification Id 3. Verfication Id Match 4. Overall Consistency(Matching district,waterpoint and village names)
     */
    public function duplicateCheck($verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $duplicate1 = $expansionmodel->getWHEREStrictData('waterpoint_details', 'verification_id', $verificationId);
        $duplicate2 = $expansionmodel->getWHEREStrictData('verification_track', 'verification_id', $verificationId);

        $duplicate = (sizeof($duplicate1) + sizeof($duplicate2));

        if (sizeof($duplicate2) > 1) {
            $duplicate+=2;
        }
        return $duplicate - 2;
    }

    public function verificationMatch($program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $match = $expansionmodel->getOdkData('odk_verification', $program);

        return $match;
    }

    private function integrityChecks($uncheckedData) {

        foreach ($uncheckedData as $key => $value) {

            $duplicate = $this->duplicateCheck($value['verification_id']);

            $uncheckedData[$key]["Duplicate"] = $duplicate;

            $match = $this->verificationMatch($value['program']);

            $odkarraywaterpoint = $this->verificationCheck($value['verification_id'], $value['program']);



            if (is_array($odkarraywaterpoint) && sizeof($odkarraywaterpoint) > 0) {

                $uncheckedData[$key]['verification_id_present_on_odk'] = "YES";

                if (isset($odkarraywaterpoint[0])) {

                    if ($odkarraywaterpoint[0]['second_value'] == '1') {
                        $check_value_pass = 'PASS';
                    } else {
                        $check_value_pass = 'FAIL';
                    }
                } else {
                    if ($odkarraywaterpoint['second_value'] == '1') {
                        $check_value_pass = 'PASS';
                    } else {
                        $check_value_pass = 'FAIL';
                    }
                }

                if ($check_value_pass == $value['status']) {
                    $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "YES";
                    $uncheckedData[$key]['reverification'] = "NO";
                } else {
                    $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                    $uncheckedData[$key]['reverification'] = "YES";
                }
            } else if ($odkarraywaterpoint == "401y") {
                $uncheckedData[$key]['verification_id_present_on_odk'] = "ODK VerificationID Not Found";
                $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                $uncheckedData[$key]['reverification'] = "YES";
                unset($uncheckedData[$key]['Match']);
            } else if (sizeof($odkarraywaterpoint) == 0) {

                $uncheckedData[$key]['verification_id_present_on_odk'] = "ODK Link Not Found";
                $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                $uncheckedData[$key]['reverification'] = "YES";
            } else if ($odkarraywaterpoint == "404x") {

                $uncheckedData[$key]['verification_id_present_on_odk'] = "ODK Column Not Specified";
                $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                $uncheckedData[$key]['reverification'] = "YES";

                unset($uncheckedData[$key]['Match']);
            } else if ($odkarraywaterpoint == "401x") {

                $uncheckedData[$key]['verification_id_present_on_odk'] = "ODK Column Not Found";
                $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                $uncheckedData[$key]['reverification'] = "YES";

                unset($uncheckedData[$key]['Match']);
            } else {

                $uncheckedData[$key]['verification_id_present_on_odk'] = "NO";
                $uncheckedData[$key]['activity_tracker_and_odk_data_agree'] = "NO";
                $uncheckedData[$key]['reverification'] = "YES";
                unset($uncheckedData[$key]['Match']);
            }
        }
        return $uncheckedData;
    }

    public function testOdkCalls() {

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/transitions/sampleOdk.php';
        if (isset($_POST['spreadsheet_key'])) {

            $this->odkDataCall2($_POST['spreadsheet_key'], $_POST['column_to_use'], $_POST['waterpoint_id']);
        }
        echo '</div>';
        require 'application/views/_templates/footer.php';
    }

    public function verificationCheck($checkValue, $program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $checkdataarray = $expansionmodel->getOdkDataRetrieve('odk_data_verification', $program);

        for ($i = 0; $i < sizeof($checkdataarray); $i++) {

            if ($checkValue == $checkdataarray[$i]['waterpoint_id']) {

                $waterpoint_id = $checkdataarray[$i]['waterpoint_id'];
                $waterpoint_pass = $checkdataarray[$i]['waterpoint_pass'];

                $Arraywaterpointcheck = array(
                    "first_value" => $waterpoint_id,
                    "second_value" => $waterpoint_pass
                );

                return $Arraywaterpointcheck;
            } elseif (sizeof($checkdataarray) == $i + 1 && $checkValue != $checkdataarray[$i]['waterpoint_id']) {

                return "401y";
            }
        }
    }

    public function vcsCheck($checkValue, $program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $checkdataarray = $expansionmodel->getOdkDataRetrieve('odk_data_vcs', $program);

        for ($i = 0; $i < sizeof($checkdataarray); $i++) {

            if ($checkValue == $checkdataarray[$i]['village_name']) {

                $village_name = $checkdataarray[$i]['village_name'];
                $Arraywaterpointcheck = array(
                    "village" => $village_name
                );
                return $Arraywaterpointcheck;
            } elseif (sizeof($checkdataarray) == $i + 1 && $checkValue != $checkdataarray[$i]['village_name']) {

                return "401y";
            }
        }
    }

    public function cem_installationCheck($checkValue, $program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $checkdataarray = $expansionmodel->getOdkDataRetrieve('odk_data_vcs', $program);

        for ($i = 0; $i < sizeof($checkdataarray); $i++) {

            if ($checkValue == $checkdataarray[$i]['village_name']) {

                $village_name = $checkdataarray[$i]['village_name'];
                $Arraywaterpointcheck = array(
                    "village" => $village_name
                );
                return $Arraywaterpointcheck;
            } elseif (sizeof($checkdataarray) == $i + 1 && $checkValue != $checkdataarray[$i]['village_name']) {

                return "401y";
            }
        }
    }

    private function odkDataCall($spreadsheet_key, $column_to_use, $program, $table) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $column_to_use_UPPER = strtoupper($column_to_use);
        $column_to_use_lower = strtolower($column_to_use);

        if (empty($column_to_use)) {
            return "404x";
        }

        $file = 'https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq';
        $file_headers = @get_headers($file);

        if (($file_headers[0] == 'HTTP/1.0 404 Not Found') || ($file_headers[0] == 'HTTP/1.1 404 Not Found')) {
            return 0;
        } else {

            if (empty($column_to_use)) {

                $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq');
            } else {

                $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq=select+' . $column_to_use_UPPER . '');
            }

            $json_google = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:json&tq=select+' . $column_to_use_UPPER . '');
            $json_google = str_replace("google.visualization.Query.setResponse(", "", "$json_google");
            $json_google = str_replace(");", "", "$json_google");

            // Convert JSON string to Array
            $someArray = json_decode($json_google, true);

            if (!isset($someArray['table']['rows'])) {
                return 0;
            } else {
                $numberOfRows = sizeof($someArray['table']['rows']);

                if (isset($someArray['table']['rows'][0]['c']['0']['v'])) {

                    if ($table == 'odk_verification') {
                        $expansionmodel->deleteProg('odk_data_verification', $program);

                        for ($i = 0; $i < $numberOfRows; $i++) {
                            if ($someArray['table']['rows'][$i]['c']['0']['v'] == '') {
                                $someArray['table']['rows'][$i]['c']['0']['v'] = '.';
                            }
                            if ($someArray['table']['rows'][$i]['c']['1']['v'] == '') {
                                $someArray['table']['rows'][$i]['c']['1']['v'] = '.';
                            }
                            $data = array(
                                "id" => null,
                                "country" => $_SESSION['country'], "program" => $program, "waterpoint_id" => $someArray['table']['rows'][$i]['c']['0']['v'],
                                "waterpoint_pass" => $someArray['table']['rows'][$i]['c']['1']['v']
                            );

                            $expansionmodel->addData('odk_data_verification', $data);
                        }
                    } else if ($table == 'odk_vcs') {

                        $expansionmodel->deleteProg('odk_data_vcs', $program);

                        for ($i = 0; $i < $numberOfRows; $i++) {
                            if ($someArray['table']['rows'][$i]['c']['0']['v'] == '') {
                                $someArray['table']['rows'][$i]['c']['0']['v'] = '.';
                            }
                            $data = array(
                                "id" => null,
                                "country" => $_SESSION['country'], "program" => $program, "village_name" => $someArray['table']['rows'][$i]['c']['0']['v']
                            );
                            $expansionmodel->addData('odk_data_vcs', $data);
                        }
                    } else if ($table == 'odk_cem') {

                        $expansionmodel->deleteProg('odk_data_cem', $program);

                        for ($i = 0; $i < $numberOfRows; $i++) {
                            if ($someArray['table']['rows'][$i]['c']['0']['v'] == '') {
                                $someArray['table']['rows'][$i]['c']['0']['v'] = '.';
                            }
                            $data = array(
                                "id" => null,
                                "country" => $_SESSION['country'], "program" => $program, "waterpoint_id" => $someArray['table']['rows'][$i]['c']['0']['v']
                            );
                            $expansionmodel->addData('odk_data_cem', $data);
                        }
                    } else if ($table == 'odk_installation') {

                        $expansionmodel->deleteProg('odk_data_installation', $program);

                        for ($i = 0; $i < $numberOfRows; $i++) {
                            if ($someArray['table']['rows'][$i]['c']['0']['v'] == '') {
                                $someArray['table']['rows'][$i]['c']['0']['v'] = '.';
                            }
                            $data = array(
                                "id" => null,
                                "country" => $_SESSION['country'], "program" => $program, "waterpoint_id" => $someArray['table']['rows'][$i]['c']['0']['v']
                            );
                            $expansionmodel->addData('odk_data_installation', $data);
                        }
                    }
                }

//                else {
//                    return "401x";
//                }
                return 0;
            }
        }
    }

    public function odkDataCall2($spreadsheet_key, $column_to_use, $checkValue) {
        $return_value = 0;

        $column_to_use_UPPER = strtoupper($column_to_use);
        $column_to_use_lower = strtolower($column_to_use);


        //display table
        if (empty($column_to_use)) {
            $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq');
        } else {
            $html_spreadsheet = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:html&tq=select+' . $column_to_use_UPPER . '');
        }
        echo $html_spreadsheet;

        $json_google = file_get_contents('https://docs.google.com/spreadsheets/d/' . $spreadsheet_key . '/gviz/tq?tqx=out:json&tq=select+' . $column_to_use_UPPER . '');

        echo "<br/><br/>";
        echo '---------------------------------------------------------------------------------------------------------------<br/>';


        $json_google = str_replace("google.visualization.Query.setResponse(", "", "$json_google");
        $json_google = str_replace(");", "", "$json_google");

        // Convert JSON string to Array
        $someArray = json_decode($json_google, true);
        if (!isset($someArray['table']['rows'])) {
            return 0;
        } else {
            $numberOfRows = sizeof($someArray['table']['rows']);
            if (isset($someArray['table']['rows'][0]['c']['0']['v'])) {
                for ($i = 0; $i < $numberOfRows; $i++) {
                    if ($checkValue == $someArray['table']['rows'][$i]['c']['0']['v']) {
                        $return_value+=1;
                    }
                }
                echo "matches found: " . $return_value;
            } else {
                echo "Column Specified not Found";
            }

            //return $responseData;
        }
    }

    public function verificationODKAdd($table, $program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        if (isset($_POST['column2'])) {

            $_POST['column'] = $_POST['column'] . "," . $_POST['column2'];
        }

        $odkArray = array(
            "id" => '',
            "api_key" => $_POST['apiKey'],
            "column_name" => $_POST['column'],
            "program" => $_POST['program']
        );
        $verificationIdArr = $expansionmodel->getOdkData($table, $_POST['program']);

        if (isset($verificationIdArr)) {
            $verificationId = $verificationIdArr[0]['id'];
            $expansionmodel->deleteData($table, $verificationId);
        }

        unset($_POST['add-verification-data']);

        $dd = $expansionmodel->addData($table, $odkArray);
        $this->odkDataCall($_POST['apiKey'], $_POST['column'], $_POST['program'], $table);
        $message = 'ODK Link Added.';

        if ($table == 'odk_vcs') {
            header('Location:' . URL . 'expansion/vcsVerificationMeetingsTrack/' . rawurlencode($_POST['program']) . '/?message=' . urlencode($message));
        } else if ($table == 'odk_verification') {
            header('Location:' . URL . 'expansion/trackVerification/' . rawurlencode($_POST['program']) . '/?message=' . urlencode($message));
        } else if ($table == 'odk_cem' || $table == 'odk_installation') {
            header('Location:' . URL . 'expansion/dispenserInstallTrackAll/' . rawurlencode($_POST['program']) . '/' . $table . '/?message=' . urlencode($message));
        } else {
            header('Location:' . URL . 'expansion/?message= Fail to upload ODK link');
        }
    }

    public function verificationTrackAdd($table, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');

        if (isset($_POST['add-verification-data'])) {

            unset($_POST['add-verification-data']);
            $cauList = $expansionmodel->getRequiredCau();
            foreach ($cauList as $key => $value) {
                if ($value['territory_name'] == 'village') {
                    $_POST['village_name'] = $_POST['village'];
                }
                unset($_POST[$value['territory_name']]);
            }
            $logs_model = $this->loadModel('logsmodel');
            $siteverificationId = explode('/', $_GET['url']);
            $program = $siteverificationId[3];

            $dd = $expansionmodel->addData($table, $_POST);
            $logs_model->insertLogVerfication($table, $_POST);
            $message = 'Waterpoint Verification Added.';
            header('Location:' . URL . 'expansion/trackVerification/' . $program . '?message=' . urlencode($message));
        }
    }

    public function verificationTrackUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $cauList = $expansionmodel->getRequiredCau();

        //update table
        if (isset($_POST['update-tracking'])) {
            foreach ($cauList as $key => $value) {
                if ($value['territory_name'] == 'village') {
                    $_POST['village_name'] = $_POST['village'];
                }
                unset($_POST[$value['territory_name']]);
            }

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogVerficationOnEdit($table, $_POST);
            $message = 'Verification Details Updated.';
            header('Location:' . URL . 'expansion/trackVerification/' . $_POST['program'] . '/?message=' . urlencode($message));
            exit();
        } else {

            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fieldsArray = $this->fieldsArray('verify_tracking');
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            //$programDropDown = $this->getProgramDropDown();
            $staffDropDown = $this->getStaffDropDown();
            //$villageDropDown = $this->getVillageDropDown();
            $program = $data[0]['program'];

            $ListedCaus = array();
            $i = 0;
            foreach ($cauList as $key => $value) {
                // echo $value['territory_name'].'<br/>';
                if ($i < 1 || strpos($value['territory_name'], 'village') !== false) {
                    $retrivedTerritories = $expansionmodel->getCauList($value['id']);
                    $j = 0;
                    foreach ($retrivedTerritories as $key2 => $value2) {
                        $ListedCaus[$value['territory_name']][$j] = array(
                            "id" => $value2["id"],
                            "territory_name" => $value2["admin_territory_name"]
                        );
                        $j++;
                    }
                    ++$i;
                }
            }

            require 'application/views/process/expansion/waterpoint_v/editVTrack.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function verificationTrackDelete($table, $verificationId, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        if (isset($verificationId)) {
            $siteverificationId = explode('/', $_GET['url']);

            $logs_model->insertLogVerficationOnDelet($table, $program, '');
            $expansionmodel->deleteData($table, $verificationId);

            $message = "Record Deleted";
            header('Location:' . URL . 'expansion/trackVerification/' . $siteverificationId[4] . '/?message=' . urlencode($message));
            exit();
        }
    }

    public function sVerificationCompleteUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogDataOnEdit($table, $_POST['program'], ' program_name');
            $message = 'Verification Details Updated.';
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'site_verification';
            $tableName = str_replace("_", " ", "waterpoint_verification");
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/verification.php';
            require 'application/views/_templates/footer.php';
        } else {

            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/waterpoint_v/editVComplete.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function sVerificationCompleteDelete($table, $verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        if (isset($verificationId)) {
            // insertLogDataOnEdit
            $logs_model->insertLogDataOnDelet($table, $_POST['program'], ' program_name');
            $expansionmodel->deleteData($table, $verificationId);
            $tabActive = 'tab2';
            $message = "Record Deleted";
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'site_verification';
            $tableName = str_replace("_", " ", "waterpoint_verification");
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getSiteVerification($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/verification.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function sVerificationUpload() {
        $table = 'verification_temp';
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('verification_temp');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $cauList = $expansionmodel->getAllTerrritoriesForVerification();

        $data = $expansionmodel->getData($table, $fieldsArray);
        //  echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit();
        $fields = $expansionmodel->getFields($table);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/waterpoint_v/upload.php';
        require 'application/views/_templates/footer.php';
    }

    public function sVerificationUploadUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $cauList = $expansionmodel->getAllTerrritories();
        //update table
        if (isset($_POST['update'])) {
            //We Need to recombine the cau data into all_cau column and unset their values on the $_POST.Village is the exception
            $i = sizeof($cauList);
            $j = 0;
            $allCau = array();


            while ($j < $i) {
                if ($cauList[$j]['territory_name'] != "village") {
                    array_push($allCau, $_POST[$cauList[$j]['territory_name']]);
                    unset($_POST[$cauList[$j]['territory_name']]);
                }
                ++$j;
            }
            unset($_POST['update']);
            //Turn $allCau array into a serialized $_POST array
            $_POST["all_cau"] = serialize($allCau);
            $_POST['update'] = '';

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $message = 'Verfication Details Updated.';
            $fieldsArray = $this->fieldsArray('site_verify');
            $table = 'verification_temp';
            $expansionmodel = $this->loadModel('expansionmodel');
            $fieldsArray = $this->fieldsArray('verification_temp');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $cauList = $expansionmodel->getAllTerrritoriesForVerification();

            $data = $expansionmodel->getData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/upload.php';
            require 'application/views/_templates/footer.php';
        } else {
            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = $this->fieldsArray($table);
            $data = $expansionmodel->getNonCountryData($table);
            $villageDropDown = $expansionmodel->getVillageDropDown();
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }
            $ListedCaus = array();
            $i = 0;
            foreach ($cauList as $key => $value) {
                // echo $value['territory_name'].'<br/>';
                $retrivedTerritories = $expansionmodel->getCauList($value['id']);
                $j = 0;
                foreach ($retrivedTerritories as $key2 => $value2) {
                    $ListedCaus[$value['territory_name']][$j] = array(
                        "id" => $value2["id"],
                        "territory_name" => $value2["admin_territory_name"]
                    );
                    $j++;
                }
                ++$i;
            }
            // echo '<pre>';
            // print_r($ListedCaus);
            // echo '</pre>';
            // exit();
            $activeVillage = '';
            $fields = $expansionmodel->getFields($table, $fieldsArray);


            require 'application/views/process/expansion/waterpoint_v/editUpload.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function sVerificationUploadDelete($table, $verificationId) {
        $expansionmodel = $this->loadModel('expansionmodel');
        if (isset($verificationId)) {

            $expansionmodel->deleteData($table, $verificationId);

            $message = "Waterpoint Deleted";
            $table = 'verification_temp';
            $fieldsArray = $this->fieldsArray('verification_temp');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $cauList = $expansionmodel->getAllTerrritoriesForVerification();

            $data = $expansionmodel->getData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/waterpoint_v/upload.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function uploadPasslist($table) {
        ini_set('max_execution_time', 3000);
        $villageStatus = 'unknown';

        if (isset($_POST['upload-verification'])) {
            if ($_FILES["file"]["error"] > 0) {
                $status = 'G';

                // header('Location:'.URL.'expansion/sVerificationUpload/?status='.$status);
            } else {
                $temp = $_FILES["file"]["tmp_name"];
                $filename = $this->upload_image($temp);
                //$this->insertFile($filename, $table);
                $this->setCsv($filename, $table);
                $status = 'U';
            }
        }

        if (isset($_POST['confirmWaterpoints']) || isset($_POST['updateWaterpoints'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $fieldsArray = $this->fieldsArray($table);
            $data = $expansionmodel->getData($table, $fieldsArray);

            foreach ($data as $key => $value) {

                $status = $value['status'];

                $villageId = $expansionmodel->getVillageId($value['village'], $value['all_cau']);

                $villageId = isset($villageId[0]["id"]) ? $villageId[0]["id"] : null;

                $villageStatus = $villageId ? 'Ok' : 'Villages not found in Village List.';

                if (strtolower($status) =='pass' && $value['waterpoint_id'] != '' && $villageId != null) {

                    $data3 = array(
                        "id" => null,
                        "country" => $value['country'], "program" => $value['program'], "waterpoint_name" => $value['waterpoint_name'], "waterpoint_id" => $value['waterpoint_id'],
                        "verification_id" => $value['verification_id'], "dispenser_barcode" => $value['dispenser_barcode'], "village" => $villageId, "number_of_hhs" => $value['number_of_hhs'],
                        "water_source_type" => $value['water_source_type'], "nearest_type" => $value['nearest_type'], "nearest_market" => $value['nearest_market'], "market_days" => $value['market_days'],
                        "directions" => $value['directions'], "land_owner_name" => $value['land_owner_name'], "land_owner_contact" => $value['land_owner_contact'], "nearest_boma" => $value['nearest_boma'],
                        "boma_contact" => $value['boma_contact'], "activities" => $value['activities'], "activity_days" => $value['activity_days'], "nearest_mama" => $value['nearest_mama'],
                        "mama_contact" => $value['mama_contact'], "neighbor_name" => $value['neighbor_name'], "neighbor_contact" => $value['neighbor_contact'], "installation_date" => $value['installation_date'],
                        "notes" => $value['notes'], "latitude" => $value['latitude'], "longitude" => $value['longitude'], "active" => 1
                    );


                    $rowCount = $expansionmodel->getRowNo('waterpoint_details', 'waterpoint_id', $value['waterpoint_id']);

                    if (isset($_POST['confirmWaterpoints'])) {
                        if ($rowCount == 0) {
                            $dataU = $expansionmodel->updateVerification($data3);
                            $expansionmodel->deleteData($table, $value['id']);
                        } else {
                            $duplicates = 'Unfortunately some Waterpoints sharing the same waterpoint Id(s) have been detected in the waterpoint list.';
                        }
                    } else {
                        if ($rowCount > 0) {
                            $dataU = $expansionmodel->updateVerification2($data3);
                            $expansionmodel->deleteData($table, $value['id']);
                        } else {
                            $duplicates = 'Unfortunately some Waterpoints Id do not exist';
                        }
                    }
                } else {
                    $status = 'S';
                }
            }
            if ($status != 'S') {
                $status = 'P';
            }
        }


        if (isset($_POST['clearWaterpoints'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $fieldsArray = $this->fieldsArray($table);
            $expansionmodel->getTruncated($table);

            $status = 'D';
        }
        if (isset($duplicates)) {
            header('Location:' . URL . 'expansion/sVerificationUpload/?status=' . urlencode($status) . '&villageStatus=' . urlencode($villageStatus) . '&duplicate=' . urlencode($duplicates));
        } else {
            header('Location:' . URL . 'expansion/sVerificationUpload/?status=' . urlencode($status) . '&villageStatus=' . urlencode($villageStatus));
        }
    }

    public function upload_image($image_temp) {
        $album_name = substr(sha1(uniqid('moreentropyhere')), 0, 10);

        $image_file = $album_name . '.csv';
        $path = __DIR__ . '/upload/ ' . $image_file;
        //$path = str_replace('//', '////', $path);
        move_uploaded_file($image_temp, $path);
        return $path;
    }

    public function setCsv($filename, $tableName) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray($tableName);
        //echo $filename;
        $handle = fopen($filename, "r");
        $counter = 0;
        $cauList = $expansionmodel->getAllTerrritoriesForVerification();
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            //Expected csv size is 29 + total CAU's excluding all_caus' column
            //Then minus 1 because its an array
            $expectedCsvSize = (29 + sizeof($cauList)) - 1;
            // echo 'CSV SIZE IS'.sizeof($data);
            // echo '<br/>'.'Expected CSV size is'.$expectedCsvSize;
            if (sizeof($data) == ($expectedCsvSize + 1)) {
                $cauAll = array();
                $i = sizeof($cauList);
                $j = 0;
                while ($j < $i) {
                    array_push($cauAll, $data[8 + $j]);

                    $j++;
                }
                $cauAll = serialize($cauAll);


                $data3 = array(
                    "id" => $data[0],
                    "country" => $_SESSION['country'], "program" => $data[2], "waterpoint_name" => $data[3], "waterpoint_id" => $data[4],
                    "verification_id" => $data[5], "status" => $data[6], "dispenser_barcode" => $data[7], "village" => $data[$expectedCsvSize - 20], "all_cau" => $cauAll, "number_of_hhs" => $data[$expectedCsvSize - 19],
                    "water_source_type" => $data[$expectedCsvSize - 18], "nearest_type" => $data[$expectedCsvSize - 17], "nearest_market" => $data[$expectedCsvSize - 16], "market_days" => $data[$expectedCsvSize - 15],
                    "directions" => $data[$expectedCsvSize - 14], "land_owner_name" => $data[$expectedCsvSize - 13], "land_owner_contact" => $data[$expectedCsvSize - 12], "nearest_boma" => $data[$expectedCsvSize - 11],
                    "boma_contact" => $data[$expectedCsvSize - 10], "activities" => $data[$expectedCsvSize - 9], "activity_days" => $data[$expectedCsvSize - 8], "nearest_mama" => $data[$expectedCsvSize - 7],
                    "mama_contact" => $data[$expectedCsvSize - 6], "neighbor_name" => $data[$expectedCsvSize - 5], "neighbor_contact" => $data[$expectedCsvSize - 4], "installation_date" => $data[$expectedCsvSize - 3],
                    "notes" => $data[$expectedCsvSize - 2], "latitude" => $data[$expectedCsvSize - 1], "longitude" => $data[$expectedCsvSize]
                );

                // echo '<pre>';
                // print_r($data3);
                // echo '</pre>';

                if ($counter != 0) {//IGNORE THE FIRST LINE
                    $expansionmodel->insertdDB('verification_temp', $data3);
                }
                ++$counter;
            } else {
                $_GET['status'] = 'F';

                $this->sVerificationUpload();
                exit();
            }
        }

        fclose($handle);
    }

    /*
      This function is repeatedly re-used in the expansion module.
      It should run everytime a new VCS,Dispenser Installation,CEM is created to make sure

     */

    public function checkProgram($table, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->checkProgram($table, $program);
        $programExist = sizeof($data);
        return $programExist;
    }

    public function checkTerritories($teritoryArray) {
        //unserialize your array
        $territories = json_decode($teritoryArray);
        $expansionmodel = $this->loadModel('expansionmodel');
        $verificationArray = $expansionmodel->readAllVerifications();

        foreach ($territories as $key => $value) {

            foreach ($verificationArray as $key2 => $value2) {

                $territoriesFound = strpos($value2["territories"], $value);
                if (strpos($value2["territories"], $value) != false) {
                    
                }
            }
        }
    }

    /*
     * **************************************************************
     *            SITE VERIFICATION TRANSITION                     *
     * **************************************************************
     */

    public function Transition($table, $expectedController, $previousStage) {

        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getActivePrograms($table);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/transitions/verification_transition.php';
        require 'application/views/_templates/footer.php';
    }

    /*
     * **************************************************************
     *            VCS SECTION                                      *
     * **************************************************************
     */

    public function vcsVerification() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'vcs_schedule';
        $fieldsArray = $this->fieldsArray('vcs_schedule');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $programDropDown = $this->getProgramDropDown();
        $data = $expansionmodel->getVcsData($table, $fieldsArray);
        foreach ($data as $key => $value) {

            if ($value['program']) {

                $programId = $expansionmodel->getProgramId($value['program']);
                $data[$key]["programId"] = $programId[0]["id"];
            }
        }
        $fields = $expansionmodel->getFields($table, $fieldsArray);

        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        if (isset($_GET['viewOfficersFor'])) {
            $tabActive = 'tab2';
            $siteId = str_replace(' ', '', $_GET['viewOfficersFor']);
            $table2 = 'vcs_meeting';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);
        } else if (isset($_GET['addOfficersFor'])) {
            $tabActive = 'tab3';
            $siteId = str_replace(' ', '', $_GET['addOfficersFor']);
            $table2 = 'vcs_meeting';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);

            $positions = null;
            if ($fieldOfficersArray == null) {
                $exceptions = null;
            } else {
                $exceptions = $fieldOfficersArray;
            }

            $fieldOfficers = $expansionmodel->getVerificationOfficers('staff_list', $positions, $exceptions);
        }


        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/vcs/planVcs.php';
        require 'application/views/_templates/footer.php';
    }

    public function vcsVerificationAdd($table) {

        if (isset($_POST['add-verification-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $logs_model = $this->loadModel('logsmodel');
            $programExist = $this->checkProgram($table, $_POST['program']);
            if ($programExist == 0) {
                unset($_POST['add-verification-data']);
                $dd = $expansionmodel->addData($table, $_POST);
                $logs_model->insertLogVerfication($table, $_POST['program']);
                $message = 'VCS Created. Click On Field Officer To continue';
                $tabActive = 'tab2';
            } else {
                $message = 'Error Creating a VCS.A VCs For this Program Has Already been Created.';
                $tabActive = 'tab1';
            }
            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray('vcs_schedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();

            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/planVcs.php';
            require 'application/views/_templates/footer.php';
        } else if (isset($_POST['add-FO-data'])) {

            $expansionmodel = $this->loadModel('expansionmodel');

            unset($_POST['add-FO-data']);
            $dd = $expansionmodel->addData($table, $_POST);
            $message = 'Field Officer Added. Click On Field Officer To continue';
            $tabActive = 'tab2';
            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray('vcs_schedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();

            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/planVcs.php';
            require 'application/views/_templates/footer.php';
        } else {
            $this->vcsVerification();
        }
    }

    public function vcsOfficialsAdd($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];
        $table = 'vcs_meeting';
        while (strpos($fieldOfficers, ',') != false && $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);
                $expansionmodel->addOfficialExpansion($table, $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            }
        }
        if (strpos($fieldOfficers, ',') == false) {
            $data = $expansionmodel->addOfficialExpansion($table, $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        $logs_model->insertLogVerfication($table, $program);
        $_GET['message'] = 'Official(s) Added';
        $_GET['addOfficersFor'] = $program;
        $this->vcsVerification();
    }

    public function vcsOfficialsDelete($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];
        $table = 'vcs_meeting';

        while (strpos($fieldOfficers, ',') != false || $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);

                $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            }
            if (strpos($fieldOfficers, ',') == false) {
                $data = $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficers);
                $fieldOfficers = '';
            }
        }
        if (strpos($fieldOfficers, ',') == false) {
            $data = $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        $logs_model->insertLogVerficationOnDelet($table, $program, '');
        $_GET['viewMessage'] = 'Official(s) Removed';
        $_GET['viewOfficersFor'] = $program;
        $this->vcsVerification();
    }

    public function vcsVerificationUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogVerficationOnEdit($table, $_POST['program']);
            $message = 'VCS Details Updated.';
            $tabActive = 'tab2';
            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray('vcs_schedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/planVcs.php';
            require 'application/views/_templates/footer.php';
        } else {


            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);
            $programDropDown = $this->getProgramDropDown();


            require 'application/views/process/expansion/vcs/editVcs.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function vcsVerificationDelete($table, $verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $logs_model->insertLogVerficationOnDelet($table, $verificationId, 'none');

        if (isset($verificationId)) {
            $expansionmodel->deleteData($table, $verificationId);
            $message = "Record Deleted";
            $tabActive = 'tab2';
            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray('vcs_schedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/planVcs.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function vcsVerificationComplete() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'vcs_schedule';
        $fieldsArray = $this->fieldsArray($table);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getVcsData($table, $fieldsArray);

        $fields = $expansionmodel->getFields($table);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';

        require 'application/views/process/expansion/vcs/vcs.php';
        require 'application/views/_templates/footer.php';
    }

    public function vcsVerificationCompleteUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogVerficationOnEdit($table, $_POST['program']);
            $message = 'VCS Details Updated.';
            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray($table);
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/vcs.php';
            require 'application/views/_templates/footer.php';
        } else {


            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/vcs/editVcsComplete.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function vcsVerificationCompleteDelete($table, $verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');

        if (isset($verificationId)) {
            $logs_model->insertLogVerficationOnDelet($table, $verificationId, 'none');
            $expansionmodel->deleteData($table, $verificationId);

            $message = "Record Deleted";

            $table = 'vcs_schedule';
            $fieldsArray = $this->fieldsArray('vcs_schedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getVcsData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/vcs/vcs.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function vcsVerificationTrack() {

        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'vcs_schedule';
        $fieldsArray = $this->fieldsArray($table);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getVcsData($table, $fieldsArray);


        $fields = $expansionmodel->getFields($table);

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/vcs/vcsTrack.php';
        require 'application/views/_templates/footer.php';
    }

    public function vcsVerificationMeetingsTrack($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'vcs_meetings_tracker';
        $fieldsArray = $this->fieldsArray('vcsTracking');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        //deprecated
        //$programDropDown = $this->getProgramDropDown();
        $staffDropDown = $this->getstaffDropDown();
        //$villageDropDown = $expansionmodel->getVillageDropDown();
        $scheduleModel = $this->loadModel('schedulemodel');
        $cauManage = $scheduleModel->checkSelectedCau('vcs_gen_schedule');
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[2];
        $data = $expansionmodel->getVcsWHEREData($table, $fieldsArray, 'program', $program);
        $data = $this->flipArrayElements($data, 'people_present', 'won_present');
        $data = $this->getVcsOdkResult($data, $program);
        //For the add modal
        $cauList = $expansionmodel->getRequiredCau();

        $ListedCaus = array();
        $i = 0;
        foreach ($cauList as $key => $value) {
            // echo $value['territory_name'].'<br/>';
            if ($i < 1 || strpos($value['territory_name'], 'village') !== false) {
                $retrivedTerritories = $expansionmodel->getCauList($value['id']);
                $j = 0;
                foreach ($retrivedTerritories as $key2 => $value2) {
                    $ListedCaus[$value['territory_name']][$j] = array(
                        "id" => $value2["id"],
                        "territory_name" => $value2["admin_territory_name"]
                    );
                    $j++;
                }
                ++$i;
            }
        }
        $fields = $expansionmodel->getFields($table, $fieldsArray);
        $odkData = $expansionmodel->getOdkData('odk_vcs', $program);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/vcs/vcsTrack2.php';
        require 'application/views/_templates/footer.php';
    }

    private function getVcsOdkResult($data, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $result = $expansionmodel->getOdkData('odk_vcs', $program);
        if (isset($result) && $data != '') {

            foreach ($data as $key => $value) {
                $odkarrayvillage = $this->vcsCheck($value['village'], $value['program']);

                if (is_array($odkarrayvillage) && sizeof($odkarrayvillage) > 0) {
                    $data[$key]["vcs_odk_on_server"] = 'YES';
                } else if (sizeof($odkarrayvillage) == 0) {
                    $data[$key]["vcs_odk_on_server"] = 'ODK Link Not Found';
                } else if (sizeof($odkarrayvillage) == "401y") {
                    $data[$key]["vcs_odk_on_server"] = 'Village Not Found';
                } else if ($odkarrayvillage == "401x") {
                    $data[$key]["vcs_odk_on_server"] = 'Column Not Found';
                } else if ($odkarrayvillage == "404x") {
                    $data[$key]["vcs_odk_on_server"] = 'Column Not Specified';
                } else {
                    $data[$key]["vcs_odk_on_server"] = 'No';
                }
            }
        }
        return $data;
    }

    public function vcsVerificationTrackingAdd($table) {
        $expansionmodel = $this->loadModel('expansionmodel');

        if (isset($_POST['add-vcs-data'])) {
            $cauList = $expansionmodel->getRequiredCau();
            foreach ($cauList as $key => $value) {
                if ($value['territory_name'] == 'village') {
                    $_POST['village_name'] = $_POST['village'];
                }
                unset($_POST[$value['territory_name']]);
            }

            $logsmodel = $this->loadModel('logsmodel');
            unset($_POST['add-vcs-data']);
            $dd = $expansionmodel->addData($table, $_POST);
            $logsmodel->insertLogVerfication($table, $_POST['program']);
            $message = 'VCS Meeting Created.';
            header('Location:' . URL . 'expansion/vcsVerificationMeetingsTrack/' . $_POST['program'] . '?message=' . urlencode($message));
        }
    }

    public function vcsVerificationTrackingUpdate($table, $edit = false, $progCarry = null) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logsmodel = $this->loadModel('logsmodel');
        $cauList = $expansionmodel->getRequiredCau();


        //update table
        if (isset($_POST['update-vcs_track'])) {
            foreach ($cauList as $key => $value) {
                if ($value['territory_name'] == 'village') {
                    $_POST['village_name'] = $_POST['village'];
                }
                unset($_POST[$value['territory_name']]);
            }

            unset($_POST['update-vcs_track']);
            $_POST['update-vcs_track'] = '';
            //We do this because the crud fxns perform an array_pop of the last element in the array passed in them before
            //the crud is performed

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logsmodel->insertLogVerficationOnEdit($table, $_POST['program']);
            $message = 'VCS Meeting Details Updated.';
            $message = urlencode($message);

            $program = $_POST['program'];
            header("Location:" . URL . "expansion/vcsVerificationMeetingsTrack/" . $program . "?message=" . $message);
        } else {
            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }
            $fields = $expansionmodel->getFields($table);
            $program = $progCarry;
            $staffDropDown = $this->getstaffDropDown();
            //$villageDropDown = $expansionmodel->getVillageDropDown();
            //For the add modal
            $ListedCaus = array();
            $i = 0;
            foreach ($cauList as $key => $value) {
                // echo $value['territory_name'].'<br/>';
                if ($i < 1 || strpos($value['territory_name'], 'village') !== false) {
                    $retrivedTerritories = $expansionmodel->getCauList($value['id']);
                    $j = 0;
                    foreach ($retrivedTerritories as $key2 => $value2) {
                        $ListedCaus[$value['territory_name']][$j] = array(
                            "id" => $value2["id"],
                            "territory_name" => $value2["admin_territory_name"]
                        );
                        $j++;
                    }
                    ++$i;
                }
            }

            require 'application/views/process/expansion/vcs/editVcsTrack.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function vcsVerificationTrackingDelete($table, $verificationId, $program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logsmodel = $this->loadModel('logsmodel');
        $siteverificationId = explode('/', $_GET['url']);

        if (isset($verificationId)) {
            $logsmodel->insertLogVerficationOnDelet($table, $verificationId, '');
            $expansionmodel->deleteData($table, $verificationId);
            $message = "VCS Meeting Deleted";
            header("Location:" . URL . "expansion/vcsVerificationMeetingsTrack/" . $siteverificationId[4] . "?message=" . $message);
        }
    }

    /*
     * **************************************************************
     *            DISPENSER INSTALLATION SECTION                   *
     * **************************************************************
     */

    public function ajax_call($table, $field, $criteria, $value) {

        $expansion_model = $this->loadModel('expansionmodel');
        //echo $value;

        $value = isset($_GET['cat']) ? $_GET['cat'] : $value; //$_GET['cat'] contains variables with possible issues and should be manually defined if such a possibility occurs
///installation_date/waterpoint_id
        $query = 'SELECT ' . $field . ' from tracking_installed_dispensers WHERE ' . $criteria . ' = "' . $value . '"';
        // echo  $query;
        $array = $expansion_model->runRawQuery($query);
        if (sizeof($array) > 0) {
            $data_val = strtotime($array[0]["installation_date"]) + (86400 * 3);
            if (date('D', $data_val) == "Sun") {
                $data_val = $data_val + 86400;
            }
            $data_array = date('d-m-Y', $data_val);
        } else {
            $data_array = 'No Installation date';
        }
        echo $data = json_encode($data_array);
    }

    public function ajaxCem($table, $value) {

        $generaldata_model = $this->loadModel('issuetrackermodel');
        //echo $value;

        $value = isset($_GET['value']) ? $_GET['value'] : $value; //$_GET['cat'] contains variables with possible issues and should be manually defined if such a possibility occurs

        $query = 'SELECT cem_schedule_date from ' . $table . ' WHERE waterpoint_id = "' . $value . '"';
        // echo  $query;
        $data = $generaldata_model->runRawQuery($query);

        echo $data = json_encode($data);
    }

    public function dispenserInstall($Deployment = null, $verificationId = null) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'dispenser_installation_schedule';
        $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
        $data = $this->checkVcsStatus($uncheckedData);

        foreach ($data as $key => $value) {

            if ($value['program']) {

                $programId = $expansionmodel->getProgramId($value['program']);
                $data[$key]["programId"] = $programId[0]["id"];
            }
        }
        $fields = $expansionmodel->getFields($table, $fieldsArray);
        $programDropDown = $this->getProgramDropDown();

        if ($Deployment == "dispenser_material" && $verificationId != null) {
            $fieldsArray = $this->fieldsArray($Deployment);
            $Fodata = $expansionmodel->getdMaterialData($Deployment, $fieldsArray, $verificationId);
            $FOfields = $expansionmodel->getFields($Deployment);
            $tabActive = $_GET['tabActive'];
        }

        // ADD OFFICIALS CODE

        if (isset($_GET['message'])) {
            $message = $_GET['message'];
        }
        if (isset($_GET['viewOfficersFor'])) {
            $tabActive = 'tab2';
            $siteId = str_replace(' ', '', $_GET['viewOfficersFor']);

            $table2 = 'dispenser_installation_field_officers';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);
        } else if (isset($_GET['addOfficersFor'])) {
            $tabActive = 'tab3';
            $siteId = str_replace(' ', '', $_GET['addOfficersFor']);
            $table2 = 'dispenser_installation_field_officers';
            $fieldOfficersArray = $expansionmodel->getSiteVerificationOfficers($table2, $siteId);

            $positions = null;
            if ($fieldOfficersArray == null) {
                $exceptions = null;
            } else {
                $exceptions = $fieldOfficersArray;
            }

            $fieldOfficers = $expansionmodel->getVerificationOfficers('staff_list', $positions, $exceptions);
        }
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/dispenser.php';
        require 'application/views/_templates/footer.php';
    }

    public function dispenserOfficialsAdd($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];
        $table = 'dispenser_installation_field_officers';
        while (strpos($fieldOfficers, ',') != false && $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);
                $expansionmodel->addOfficialExpansion($table, $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            } else {
                $data = $expansionmodel->addOfficialExpansion($table, $program, $fieldOfficers);
                $fieldOfficers = '';
            }
        }
        if (strpos($fieldOfficers, ',') == false) {
            $data = $expansionmodel->addOfficialExpansion($table, $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        //print_r($_POST);
        $logs_model->insertLogDispenser($table, '');
        $message = 'Official(s) Added';
        $_GET['addOfficersFor'] = $program;
        $this->dispenserInstall();
    }

    public function dispenserOfficialsDelete($program) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        $fieldOfficers = $_POST['officialsArray'];
        $table = 'dispenser_installation_field_officers';

        while (strpos($fieldOfficers, ',') != false || $fieldOfficers != '') {
            $lim = strpos($fieldOfficers, ',');
            if ($lim != false) {
                $fieldOfficer = substr($fieldOfficers, 0, $lim);

                $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficer);
                ++$lim;
                $fieldOfficers = substr($fieldOfficers, $lim);
            } else {

                $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficers);
                $fieldOfficers = '';
            }
        }

        if (strpos($fieldOfficers, ',') == false) {
            $data = $expansionmodel->removeOfficialExpansion($table, $program, $fieldOfficers);
            $fieldOfficers = '';
        }
        $logs_model->insertLogDispenserOnDelet($table, '');
        $message = 'Official(s) Removed';
        $_GET['viewOfficersFor'] = $program;
        $this->dispenserInstall();
    }

    public function dispenserInstallAdd($table) {
        $logsmodel = $this->loadModel('logsmodel');
        if (isset($_POST['add-dInstall-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $programExist = $this->checkProgram($table, $_POST['program']);
            if ($programExist == 0) {
                unset($_POST['add-dInstall-data']);
                $cemDate = date('d-m-Y', strtotime($_POST['installation_start_date'] . '+ 3 day'));
                $_POST['cem_start_date'] = $cemDate;
                $dd = $expansionmodel->addData($table, $_POST);
                $logsmodel->insertLogDispenser($table, $_POST['program']);
                $message = 'Installation Schedule Created. Click On Field Officer To continue';
                $tabActive = 'tab2';
            } else {
                $message = 'Error Creating Installation Schedule.An Installation Schedule for this Program Already Exists.';
                $tabActive = 'tab1';
            }

            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $data = $this->checkVcsStatus($uncheckedData);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $programDropDown = $this->getProgramDropDown();
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/dispenser.php';
            require 'application/views/_templates/footer.php';
        }

        if (isset($_POST['add-Material-data'])) {

            unset($_POST['add-Material-data']);
            $expansionmodel = $this->loadModel('expansionmodel');

            $data = array();
            foreach ($_POST['program'] as $key => $value) {

                $data['program'] = $_POST['program'][$key];
                $data['material'] = $_POST['material'][$key];
                $data['quantity'] = $_POST['quantity'][$key];
                $dd = $expansionmodel->addData($table, $data);
                $logsmodel->insertLogDispenser($table, $data['program']);
            }

            $message = 'Material Added. Click On Materials To continue';
            $tabActive = 'tab2';
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $data = $this->checkVcsStatus($uncheckedData);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/dispenser.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserInstallUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logsmodel = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update-dInstall'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logsmodel->insertLogDispenserOnEdit($table, $_POST['program']);
            $message = 'Installation Details Updated.';
            $tabActive = 'tab2';
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $data = $this->checkVcsStatus($uncheckedData);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/dispenser.php';
            require 'application/views/_templates/footer.php';
        } else {

            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/dispenser/editDInstall.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserUtilitesUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logsmodel = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update-dInstall'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logsmodel->insertLogDispenserOnEdit($table, $_POST['program']);
            $message = 'Installation Details Updated.';
            $tabActive = 'tab2';
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $data = $this->checkVcsStatus($uncheckedData);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/dispenser.php';
            require 'application/views/_templates/footer.php';
        } else {
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/dispenser/editDInstall.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserInstallDelete($table, $verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logsmodel = $this->loadModel('logsmodel');
        if (isset($verificationId)) {
            $logsmodel->insertLogDispenserOnDelet($table, $verificationId);
            $expansionmodel->deleteData($table, $verificationId);
            $message = "Record Deleted";
            $tabActive = 'tab2';
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $programDropDown = $this->getProgramDropDown();
            $uncheckedData = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $data = $this->checkVcsStatus($uncheckedData);
            foreach ($data as $key => $value) {

                if ($value['program']) {

                    $programId = $expansionmodel->getProgramId($value['program']);
                    $data[$key]["programId"] = $programId[0]["id"];
                }
            }
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/dispenser.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserInstallComplete() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'dispenser_installation_schedule';
        $fieldsArray = $this->fieldsArray('dispenserInstallSchedule2');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
        $fields = $expansionmodel->getFields($table, $fieldsArray);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/plannedInstall.php';
        require 'application/views/_templates/footer.php';
    }

    public function dispenserCompleteUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        //update table
        if (isset($_POST['update-dInstall'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $logs_model->insertLogDispenserOnEdit($table, $_POST['program']);
            $message = 'Installation Details Updated.';
            $expansionmodel = $this->loadModel('expansionmodel');
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/plannedInstall.php';
            require 'application/views/_templates/footer.php';
        } else {



            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);

            require 'application/views/process/expansion/dispenser/editDInstallComplete.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserCompleteDelete($table, $verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $logs_model = $this->loadModel('logsmodel');
        if (isset($verificationId)) {
            $logs_model->insertLogDispenserOnDelet($table, $verificationId);
            $expansionmodel->deleteData($table, $verificationId);
            $message = "Installation Schedule Deleted";
            $table = 'dispenser_installation_schedule';
            $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/plannedInstall.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserInstallTrack() {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'dispenser_installation_schedule';
        $fieldsArray = $this->fieldsArray('dispenserInstallSchedule');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getDispenserInstallData($table, $fieldsArray);
        $fields = $expansionmodel->getFields($table, $fieldsArray);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/plannedInstallTracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function dispenserInstallTrackAll($program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $table = 'tracking_installed_dispensers';

        $fieldsArray = $this->fieldsArray('tid');
        $table3 = 'cem_tracker';
        $fieldsArray2 = $this->fieldsArray('cem_track');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $table1 = 'waterpoint_details';
        $table2 = 'tracking_installed_dispensers';
        $fieldsArray3 = $this->fieldsArray('tracking_waterpoint_data');
        $fieldsArray4 = $this->fieldsArray('tid');
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[2];
        $uncheckedData = $expansionmodel->getAllTrackableData($table1, $fieldsArray3, $table2, $fieldsArray4, $program);
        $data = $this->runConstraints($uncheckedData);
        $data = $this->flipArrayElements($data, 'village', 'land_owner_name');
        $data = $this->flipArrayElements($data, 'land_owner_name', 'land_owner_contact');
        $data = $this->flipArrayElements($data, 'land_owner_contact', 'neighbor_name');
        $data = $this->flipArrayElements($data, 'neighbor_name', 'neighbor_contact');
        //  $data = $this->flipArrayElements($data, 'neighbor_contact', 'village_elder_name');
        // $data = $this->flipArrayElements($data, 'village_elder_name', 'village_elder_contact');
        // $data = $this->flipArrayElements($data, 'village_elder_contact', 'chw_name');
        // $data = $this->flipArrayElements($data, 'chw_name', 'chw_contact');
        //  $data = $this->flipArrayElements($data, 'verification_id', 'PASS/FAIL');
        // $data = $this->flipArrayElements($data, 'PASS/FAIL', 'waterpoint_id');
        //   $data = $this->flipArrayElements($data, 'number_of_hhs', 'quorum');
        // $data = $this->flipArrayElements($data, 'quorum', 'prize_quorum');
        //  $data = $this->flipArrayElements($data, 'prize_quorum', 'won_present');
        //  $data = $this->flipArrayElements($data, 'PASS/FAIL', 'waterpoint_id');

        $programDropDown = $this->getProgramDropDown();
        $staffDropDown = $this->getStaffDropDown();
        $scheduleModel = $this->loadModel('schedulemodel');
        $cauManage = $scheduleModel->checkSelectedCau('dispenser_gen_schedule');

        $fields = $expansionmodel->getFields($table, $fieldsArray);
        $fields2 = $expansionmodel->getFields($table3, $fieldsArray2);
        $odkDataCEM = $expansionmodel->getOdkData('odk_cem', $program);
        $odkDataInstallation = $expansionmodel->getOdkData('odk_installation', $program);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/plannedInstalls.php';
        require 'application/views/_templates/footer.php';
    }

    private function runConstraints($uncheckedData) {
        $expansionmodel = $this->loadModel('expansionmodel');
        foreach ($uncheckedData as $key => $value) {


//            $villageInfo = $this->getVillageInfo($value['village_name']);
//
//            if ($villageInfo != null) {
//                $uncheckedData[$key]['village_elder_name'] = $villageInfo[0]['village_elder'];
//                $uncheckedData[$key]['village_elder_contact'] = $villageInfo[0]['elder_contact'];
//                $uncheckedData[$key]['chw_contact'] = $villageInfo[0]['chw_contact'];
//                $uncheckedData[$key]['chw_name'] = $villageInfo[0]['chw_name'];
//            } else {
//                $uncheckedData[$key]['village_elder_name'] = "";
//                $uncheckedData[$key]['village_elder_contact'] = "";
//                $uncheckedData[$key]['chw_contact'] = "";
//                $uncheckedData[$key]['chw_name'] = "";
//            }
//            foreach ($value as $key2 => $value2) {
//                $duplicate = $this->duplicateCheck($value['verification_id']);
//                $uncheckedData[$key]["Duplicate"] = $duplicate;
//                if ($value['verification_id'] != '' && $value['verification_id'] != null && $value['verification_id'] != 0) {
//                    $status = 'PASS';
//                } else {
//                    $status = 'FAIL';
//                }
//                $uncheckedData[$key]["PASS/FAIL"] = $status;
//            }
//            $quorum = $this->quorumCheck($value['program'], $value['village_name']);
//
//            if ($quorum != null) {
//                $uncheckedData[$key]["quorum"] = $quorum[0]['quorum'];
//                $uncheckedData[$key]['prize_quorum'] = $quorum[0]['prize_quorum'];
//                $uncheckedData[$key]['won_present'] = $quorum[0]['quorum'] - $quorum[0]['prize_quorum'];
//            } else {
//                $uncheckedData[$key]["quorum"] = "";
//                $uncheckedData[$key]['prize_quorum'] = "";
//                $uncheckedData[$key]['won_present'] = "";
//            }
            $OdkInstallationTrackingData = $expansionmodel->getOdkCemInstallationTrackingData('odk_data_installation', $value['program'], $value['waterpoint_id']);
            if ($OdkInstallationTrackingData != null) {
                $uncheckedData[$key]["Installation_on_server"] = "Yes";
            } else {
                $uncheckedData[$key]["Installation_on_server"] = "No";
            }
            $CemTrackingData = $this->trackingCemDataCheck($value['program'], $value['waterpoint_id']);
            if ($CemTrackingData != null) {
                $uncheckedData[$key]["cem_schedule_date"] = $CemTrackingData[0]['cem_schedule_date'];
                $uncheckedData[$key]["cem_time"] = $CemTrackingData[0]['cem_time'];
                $uncheckedData[$key]["cem_field_officer"] = $CemTrackingData[0]['field_officer'];
                $uncheckedData[$key]["did_it_occur"] = $CemTrackingData[0]['status'];
                $uncheckedData[$key]["why_not"] = $CemTrackingData[0]['why_failed'];
                $uncheckedData[$key]["attendance"] = $CemTrackingData[0]['attendance'];
                $uncheckedData[$key]["date_completed"] = $CemTrackingData[0]['date_completed'];
            } else {
                $uncheckedData[$key]["cem_schedule_date"] = "";
                $uncheckedData[$key]["cem_time"] = "";
                $uncheckedData[$key]["cem_field_officer"] = "";
                $uncheckedData[$key]["did_it_occur"] = "";
                $uncheckedData[$key]["why_not"] = "";
                $uncheckedData[$key]["attendance"] = "";
                $uncheckedData[$key]["date_completed"] = "";
            }
            $OdkCemTrackingData = $expansionmodel->getOdkCemInstallationTrackingData('odk_data_cem', $value['program'], $value['waterpoint_id']);
            if ($OdkCemTrackingData != null) {
                $uncheckedData[$key]["CEM_on_server"] = "Yes";
            } else {
                $uncheckedData[$key]["CEM_on_server"] = "No";
            }
        }
        return $uncheckedData;
    }

    private function getVillageInfo($villageId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getVillageInfo($villageId);
        return $data;
    }

    public function duplicateCheckTracker($verificationId) {

        $expansionmodel = $this->loadModel('expansionmodel');
        $duplicate1 = $expansionmodel->getWHEREData('waterpoint_details', 'verification_id', $verificationId);
        $duplicate2 = $expansionmodel->getWHEREData('verification_track', 'verification_id', $verificationId);
        $duplicate3 = $expansionmodel->getWHEREData('tracking_installed_dispensers', 'verification_id', $verificationId);
        $duplicate = sizeof($duplicate1) + sizeof($duplicate2) + sizeof($duplicate3);
        return $duplicate - 3;
    }

    private function retrieveVillageName($waterpointId) {
        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getWHEREData('waterpoint_details', 'waterpoint_id', $waterpointId);
        return $data[0]['village'];
    }

    private function checkVcsStatus($uncheckedData) {
        $expansionmodel = $this->loadModel('expansionmodel');
        foreach ($uncheckedData as $key => $value) {

            foreach ($value as $key2 => $value2) {
                $vcsStatus = $expansionmodel->verifyVcsStatus($value['program']);
                $uncheckedData[$key]["vcs_status"] = $vcsStatus;
            }
        }

        return $uncheckedData;
    }

    private function quorumCheck($program, $village) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $data = $expansionmodel->getQuorum($program, $village);
        return $data;
    }

    private function trackingDataCheck($program, $waterpointId, $verificationId) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('tid');
        $data = $expansionmodel->getTrackingData($program, $fieldsArray, $waterpointId, $verificationId);
        return $data;
    }

    private function trackingCemDataCheck($program, $waterpointId) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray('cem_track');
        $data = $expansionmodel->getCemTrackingData($program, $fieldsArray, $waterpointId);
        return $data;
    }

    public function trackerData($table, $id, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        if ($table == 'tracking_installed_dispensers') {
            $fieldsArray = $this->fieldsArray('tid');
        } else if ($table == 'cem_tracker') {
            $fieldsArray = $this->fieldsArray('cem_track');
        }
        $siteverificationId = explode('/', $_GET['url']);
        $program = $siteverificationId[4];
        $tableName = str_replace("_", " ", $table);
        $tableName = str_replace("tracking", " ", $tableName);
        $tableName = str_replace("tracker", " ", $tableName);
        $tableName = ucwords($tableName);


        $data = $expansionmodel->getTrackedData($table, $fieldsArray, $program);
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/trackerData.php';
        require 'application/views/_templates/footer.php';
    }

    public function trackerDataUpdate($table, $edit = false, $program = null) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        //update table
        if (isset($_POST['update-dInstall'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            if ($table == 'tracking_installed_dispensers') {
                $fieldsArray = $this->fieldsArray('tid');
            } else if ($table == 'cem_tracker') {
                $fieldsArray = $this->fieldsArray('cem_track');
            }
            $tableName = str_replace("_", " ", $table);
            $tableName = str_replace("tracking", " ", $tableName);
            $tableName = str_replace("tracker", " ", $tableName);
            $tableName = ucwords($tableName);
            $message = $tableName . " Record Updated";
            $scheduleModel = $this->loadModel('schedulemodel');
            $cauManage = $scheduleModel->checkSelectedCau('dispenser_gen_schedule');

            $program = $_POST['program'];
            $data = $expansionmodel->getTrackedData($table, $fieldsArray, $_POST['program']);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/trackerData.php';
            require 'application/views/_templates/footer.php';
        } else {
            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);
            $programName = $program;
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }
            $programDropDown = $this->getProgramDropDown();
            $staffDropDown = $this->getStaffDropDown();

            $fields = $expansionmodel->getFields($table);
            require 'application/views/process/expansion/dispenser/editTrackerData.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function trackerCemDelete($table, $verificationId, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        if (isset($verificationId)) {
            $expansionmodel->deleteData($table, $verificationId);

            if ($table == 'tracking_installed_dispensers') {
                $fieldsArray = $this->fieldsArray('tid');
            } else if ($table == 'cem_tracker') {
                $fieldsArray = $this->fieldsArray('cem_track');
            }
            $tableName = str_replace("_", " ", $table);
            $tableName = str_replace("tracking", " ", $tableName);
            $tableName = str_replace("tracker", " ", $tableName);
            $tableName = ucwords($tableName);
            $message = $tableName . " Record Deleted";
            $data = $expansionmodel->getTrackedData($table, $fieldsArray, $program);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/trackerData.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function dispenserInstallTrackAdd($table) {
        if (isset($_POST['add-dInstall-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $logs_model = $this->loadModel('logsmodel');


            $programExist = $expansionmodel->getRowNo($table, 'waterpoint_id', $_POST['waterpoint_id']);
            $waterpointExist = $expansionmodel->confirmWaterpointId('waterpoint_details', $_POST['waterpoint_id'], $_POST['program']);
            if ($programExist == 0 && $waterpointExist == 1) {
                unset($_POST['add-dInstall-data']);
                $dd = $expansionmodel->addData($table, $_POST);
                $logs_model->insertLogDispenser($table, $_POST['program']);
                $message = 'New Record Created Successfully';
            } else if ($waterpointExist != 1) {
                $message = 'Error Creating tracking Data. Waterpoint Id Has An Error.Check in waterpoints(Admin Module)';
            } else {
                $message = 'Error Creating tracking Data. Waterpoint Selected Already Exists.';
            }
            $table = 'tracking_installed_dispensers';
            $fieldsArray = $this->fieldsArray('tid');
            $table3 = 'cem_tracker';
            $fieldsArray2 = $this->fieldsArray('cem_track');
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            $program = $_POST['program'];

            $table1 = 'waterpoint_details';
            $table2 = 'tracking_installed_dispensers';
            $fieldsArray3 = $this->fieldsArray('tracking_waterpoint_data');
            $fieldsArray4 = $this->fieldsArray('tid');
            $uncheckedData = $expansionmodel->getAllTrackableData($table1, $fieldsArray3, $table2, $fieldsArray4, $program);
            // $data=$this->runConstraints($stage1data);


            $data = $this->runConstraints($uncheckedData);
            $fields = $expansionmodel->getFields($table, $fieldsArray);
            $fields2 = $expansionmodel->getFields($table3, $fieldsArray2);
            $programDropDown = $this->getProgramDropDown();
            $staffDropDown = $this->getStaffDropDown();
            $scheduleModel = $this->loadModel('schedulemodel');
            $cauManage = $scheduleModel->checkSelectedCau('dispenser_gen_schedule');

            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/dispenser/plannedInstalls.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function trackingInstallUpload($program) {

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/dispenser/uploadDetails.php';
        require 'application/views/_templates/footer.php';
        exit();
    }

    public function uploadInstallationTracking($table, $program) {
        ini_set('max_execution_time', 300);
        if (isset($_POST['upload-verification'])) {
            if ($_FILES["file"]["error"] > 0) {
                $status = 'Upload Failed';
            } else {
                $temp = $_FILES["file"]["tmp_name"];
                $filename = $this->upload_image($temp);
                $status = $this->setInstallationCsv($filename, $table, $program);
            }
        }

        header('Location:' . URL . 'expansion/dispenserInstallTrackAll/' . $program . '?message=' . urlencode($status));
    }

    public function setInstallationCsv($filename, $tableName, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');

        $handle = fopen($filename, "r");
        $counter = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (sizeof($data) == 10) {
                $data3 = array(
                    "id" => "",
                    "program" => $program, "waterpoint_id" => $data[2],
                    "verification_id" => $data[3], "installation_date" => $data[4],
                    "csa_responsible" => $data[5], "field_officer" => $data[6],
                    "was_it_installed" => $data[7], "were_materials_mobilized" => $data[8],
                    "problems_with_installation" => $data[9]
                );

                if ($counter != 0) {//IGNORE THE FIRST LINE
                    $expansionmodel->insertdDB($tableName, $data3);
                }
                ++$counter;

                $status = 'Upload Passed';
            } else {
                $status = 'Upload Failed.Check the structure of your data';
                break;
            }
        }
        fclose($handle);
        return $status;
    }

    /*
     * **************************************************************
     *            CEM SECTION Start                                *
     * **************************************************************
     */

    private function runCEMconstraint($uncheckedData) {
        $expansionmodel = $this->loadModel('expansionmodel');
        foreach ($uncheckedData as $key => $value) {


            $Cemstats = $this->checkDates($value['installation_start_date']);
            $uncheckedData[$key]['Cem_date'] = $Cemstats['Cem_Date'];
        }
        return $uncheckedData;
    }

    private function checkDates($date) {

        $Cemstats['Cem_Date'] = date('d-m-Y', strtotime($date . '+ 3 day'));

        $currentDate = date('d-m-Y');

        $difference = strtotime($Cemstats['Cem_Date']) - strtotime($currentDate);
        $currentD = abs($difference) / 60 / 60 / 24;

        return $Cemstats;
    }

    public function viewCemComplete() {
        $expansionmodel = $this->loadModel('expansionmodel');

        $fieldsArray = $this->fieldsArray('view_cem');
        $table = 'dispenser_installation_schedule';
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getDispenserInstallData($table, $fieldsArray);

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/cem/plannedCem.php';
        require 'application/views/_templates/footer.php';
    }

    public function CEMCompleteUpdate($table, $edit = false) {
        // load the model
        $expansionmodel = $this->loadModel('expansionmodel');
        //update table
        if (isset($_POST['update-dInstall'])) {

            $expansionmodel->updateData($_POST, $_POST['id'], $table);
            $message = 'Community Education Meeting Updated.';
            $expansionmodel = $this->loadModel('expansionmodel');
            $tabActive = 'tab2';
            $fieldsArray = $this->fieldsArray('view_cem');
            $table = 'community_education';
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getCEMData($fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/cem/plannedCem.php';
            require 'application/views/_templates/footer.php';
        } else {



            // needed here tp access the session
            require 'application/views/_templates/header.php';
            $fieldsArray = null;
            $data = $expansionmodel->getNonCountryData($table);

            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);

            if ($edit != false) {

                $single_record = $expansionmodel->getByPK($table, $edit, $fieldsArray);
                //do some cleaning // its assiciative // make it serial
                $single_record = $single_record[0];
                $single_record = $this->serializeArray($single_record);
            }

            $fields = $expansionmodel->getFields($table);


            require 'application/views/process/expansion/cem/editCemComplete.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function trackingCemUpload($program) {

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/cem/uploadCEM.php';
        require 'application/views/_templates/footer.php';
        exit();
    }

    public function uploadCemTracking($table, $program) {
        ini_set('max_execution_time', 300);
        if (isset($_POST['upload-verification'])) {
            if ($_FILES["file"]["error"] > 0) {
                $status = 'Upload Failed';
            } else {
                $temp = $_FILES["file"]["tmp_name"];
                $filename = $this->upload_image($temp);

                $status = $this->setCemCsv($filename, $table, $program);
            }
        }

        header('Location:' . URL . 'expansion/dispenserInstallTrackAll/' . $program . '?message=' . urlencode($status));
    }

    public function setCemCsv($filename, $tableName, $program) {
        $expansionmodel = $this->loadModel('expansionmodel');
        $handle = fopen($filename, "r");
        $counter = 0;
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (sizeof($data) == 15) {
                $data3 = array(
                    "id" => "",
                    "program" => $program, "waterpoint_id" => $data[2],
                    "cem_schedule_date" => $data[3], "cem_time" => $data[4],
                    "field_officer" => $data[5], "status" => $data[6],
                    "why_failed" => $data[7], "attendance" => $data[8],
                    "date_rescheduled" => $data[9], "rescheduled_time" => $data[10],
                    "rescheduled_field_officer_responsible" => $data[11],
                    "date_completed" => $data[12], "rescheduled_attendance" => $data[13],
                    "comment" => $data[14]
                );

                if ($counter != 0) {//IGNORE THE FIRST LINE
                    $expansionmodel->insertdDB($tableName, $data3);
                    $status = 'Upload Passed';
                }
                ++$counter;
            } else {
                $status = 'Upload Failed.Check the structure of your data';
                break;
            }
        }

        fclose($handle);
        return $status;
    }

    /*
     * **************************************************************
     *            SETTINGS SECTION                                 *
     * **************************************************************
     */

    public function programSet($table) {
        //Also Applies for Message Template
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray($table);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getNonCountryData($table, $fieldsArray);
        $fields = $expansionmodel->getFields($table);

        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/expansion.php';
        require 'application/views/_templates/footer.php';
    }

    public function programAdd($table) {


        if (isset($_POST['add-program-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            unset($_POST['add-program-data']);
            $dd = $expansionmodel->addData($table, $_POST);
            $message = 'New Record Added';
            $fieldsArray = $this->fieldsArray($table);
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getNonCountryData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/expansion.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function programDelete($table, $verificationId) {
        $expansionmodel = $this->loadModel('expansionmodel');
        if (isset($verificationId)) {
            $expansionmodel->deleteData($table, $verificationId);
            $message = "Record Deleted";
            $fieldsArray = $this->fieldsArray($table);
            $tableName = str_replace("_", " ", $table);
            $tableName = ucwords($tableName);
            $data = $expansionmodel->getNonCountryData($table, $fieldsArray);
            $fields = $expansionmodel->getFields($table);
            require 'application/views/_templates/header.php';
            require 'application/views/process/expansion/sidebar.php';
            require 'application/views/process/expansion/expansion.php';
            require 'application/views/_templates/footer.php';
        }
    }

    public function DisplaySet($table) {
        //Also Applies for Message Template
        $expansionmodel = $this->loadModel('expansionmodel');
        $fieldsArray = $this->fieldsArray($table);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $data = $expansionmodel->getData($table, $fieldsArray);
        $fields = $expansionmodel->getFields($table);
        $territory = $expansionmodel->getTerritories();
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/display.php';
        require 'application/views/_templates/footer.php';
    }

    public function displayAdd($table) {


        if (isset($_POST['add-program-data'])) {
            $expansionmodel = $this->loadModel('expansionmodel');
            $param2 = isset($_POST["assign_field_officers_per"]) ? $_POST["assign_field_officers_per"] : $_POST["territory_name"];

            $repeatCheck = $expansionmodel->confirmDisplayAdd($table, $_POST["stage"], $param2);



            if ($repeatCheck == null) {
                unset($_POST['add-program-data']);
                $dd = $expansionmodel->addData($table, $_POST);
                $message = urlencode('New Record Added');
            } else {
                $message = urlencode("It already Exists.Record Not Added");
            }
            header('Location:' . URL . 'expansion/DisplaySet/' . $table . '/?message=' . $message);
        }
    }

    public function displayDelete($table, $verificationId) {
        $expansionmodel = $this->loadModel('expansionmodel');
        if (isset($verificationId)) {
            $expansionmodel->deleteData($table, $verificationId);
            $message = "Record Deleted";
        } else {
            $message = 'Record Not Deleted';
        }
        header('Location:' . URL . 'expansion/DisplaySet/' . $table . '/?message=' . $message);
    }

    private function getProgramDropDown() {
        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getProgramDropDown();
        return $data;
    }

    private function getStaffDropDown() {
        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getStaffDropDown();
        return $data;
    }

    private function getVillageDropDown() {
        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getVillageDropDown();
        return $data;
    }

    /*
     * **************************************************************
     *            LSM TRACKING                                      *
     * **************************************************************
     */

    public function lsmtracking() {

        require 'application/views/_templates/header.php';

        $lsmtracking_model = $this->loadModel('expansiontrackingmodel');
        $logs_model = $this->loadModel('logsmodel');
        $trackingdata = $lsmtracking_model->getlsmTrackingdata();

        if (isset($_POST['edit-lsmdetails'])) {
            $editable = true;
        }

        if (isset($_POST['save-lsmdetails'])) {

            foreach ($_POST['id'] as $key => $value) {

                $data = array(
                    'lsm_details_id' => $_POST['id'][$key],
                    'status' => $_POST['status'][$key],
                    'next_meeting_date' => $_POST['next_meeting_date'][$key],
                    'no_of_villages' => $_POST['no_of_villages'][$key],
                    'actual_no_of_people_present' => $_POST['actual_no_of_people_present'][$key],
                    'estimated_reimbursement' => $_POST['estimated_reimbursement'][$key],
                    'actual_reimbursement' => $_POST['actual_reimbursement'][$key],
                    'no_of_nominated_wps' => $_POST['no_of_nominated_wps'][$key],
                    'no_of_eligible_wps' => $_POST['no_of_eligible_wps'][$key],
                    'notes' => $_POST['notes'][$key]
                );

                $lsmtracking_model->updatelsmtracking('lsm_tracking', $data);
            }
            $logs_model->insertLogDataOnEdit('lsm_tracking', 'edit', 'edit');
            header('Location:' . URL . 'expansion/lsmtracking');
        }

        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/lsmtracking.php';
        require 'application/views/_templates/footer.php';
    }

    public function timeslotstracking() {

        require 'application/views/_templates/header.php';

        $timeslotstracking_model = $this->loadModel('expansiontrackingmodel');
        $trackingdata = $timeslotstracking_model->getlsmTrackingdata();

        require 'application/views/process/expansion/sidebar.php';
        require 'application/views/process/expansion/lsm/timeslotstracking.php';
        require 'application/views/_templates/footer.php';
    }

    public function pdfLSM($LsmId) {
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('Summary of LSM Meeting');
        $pdf->SetSubject('Lsm Meeting Details');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


        $pdf->SetY(100);
        $header = '<div>';

        $title = '<h1 id="headerH1">Lsm Meeting Details</h1>';

        $expansionmodel = $this->loadModel('expansionmodel');



        $sql = 'SELECT * from lsm_details WHERE id=' . $LsmId;

        $data = $expansionmodel->runRawQuery($sql);

        $title2 = '<br/><br/>
                <h3 id="headerH1">Title: ' . $data[0]['lsm_title'] . '</h3>

                          <h4>Meeting Date: ' . $data[0]['meeting_date'] . '</h4><h4> Meeting Time: ' . $data[0]['meeting_time'] . '</h4>
                          <h4>Location: ' . $data[0]['location'] . '</h4>

                ';
        $pdf->writeHTML($title . $title2, true, false, true, false, 'C');
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);

        $body = ' <h4><u>Officials Expected To Attend</u></h4>';
        $officials = unserialize($data[0]['officials']);
        $counter = 1;
        foreach ($officials as $key => $value) {

            $body.=$counter . '. ' . $value['official'] . '<br/>';
            ++$counter;
        }


        $pdf->writeHTML($body, true, false, true, false, 'L');

        $title3 = '<h3>Budget Details For ' . $data[0]['lsm_title'] . '</h3>';

        $Tabledata = $expansionmodel->getWHEREData('lsm_budget_details', 'lsm_id', $LsmId);
        // Table header 
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetXY(80, 70);

        if (empty($Tabledata)) {
            $comment = 'No Budget Has Been Set<br/></div>';

            $pdf->writeHTML($title3 . $comment, true, false, true, false, 'C');
        } else {
            $tableHeader = '<table style="border:1px solid #333333; font-size: 11px;">';
            $tableHeader.= '<tr>';
            $tableHeader.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $tableHeader.= '<td style="border:1px solid #333333;" ><b>Item Name</b></td>';
            $tableHeader.= '<td style="border:1px solid #333333;" ><b>Cost</b></td>';
            $tableHeader .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table = '';
            $counter = 1;
            $total = 0;
            foreach ($Tabledata as $key => $value) {

                $table .= '<tr>';
                $table.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                $table .= '<td style="border:1px solid #333333;" >' . $value['item'] . '</td>';
                $table.= '<td style="border:1px solid #333333;" >' . $value['cost'] . '</td>';

                $table .= '</tr>';
                $total+=$value['cost'];
                ++$counter;
            }
            $table.='<tr><td style="border:1px solid #333333;text-align:center;" colspan="2"><b>Total Cost</b></td><td style="border:1px solid #333333;" ><b>' . $total . '</b></td></tr>';
            $table .= '</table><br/>';



            $pdf->writeHTML($title3 . $tableHeader . $table, true, false, true, false, 'L');
        }


        $title4 = '<h3>Duties Allocated For ' . $data[0]['lsm_title'] . '</h3>';
        $fieldsArray = $this->fieldsArray('dutiesLsm');

        $Tabledata2 = $expansionmodel->getDUTIESWHEREData('lsm_duties_details', 'lsm_id', $LsmId, $fieldsArray);
        // Table header 
        $pdf->SetFont('helvetica', '', 11);


        if (empty($Tabledata2)) {
            $comment = 'No Duties have been Set<br/></div>';

            $pdf->writeHTML($title4 . $comment, true, false, true, false, 'C');
        } else {
            $tableHeader2 = '<table style="border:1px solid #333333; font-size: 11px;">';
            $tableHeader2.= '<tr>';
            $tableHeader2.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $tableHeader2.= '<td style="border:1px solid #333333;" ><b>Staff Name</b></td>';
            $tableHeader2.= '<td style="border:1px solid #333333;" ><b>Duty</b></td>';
            $tableHeader2 .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table2 = '';
            $counter = 1;
            $total = 0;
            foreach ($Tabledata2 as $key => $value) {

                $table2 .= '<tr>';
                $table2.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                $table2 .= '<td style="border:1px solid #333333;" >' . $value['full_name'] . '</td>';
                $table2.= '<td style="border:1px solid #333333;" >' . $value['duties'] . '</td>';

                $table2 .= '</tr>';

                ++$counter;
            }
            $table2 .= '</table>';



            $pdf->writeHTML($title4 . $tableHeader2 . $table2, true, false, true, false, 'L');
        }

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($data[0]['lsm_title'] . '.pdf', 'I');
    }

    public function pdfLSMBudget($LsmId) {
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('Summary of LSM Meeting');
        $pdf->SetSubject('Lsm Meeting Details');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


        $pdf->SetY(100);
        $header = '<div>';

        $title = '<h1 id="headerH1">Lsm Meeting Details</h1>';

        $expansionmodel = $this->loadModel('expansionmodel');



        $sql = 'SELECT * from lsm_details WHERE id=' . $LsmId;

        $data = $expansionmodel->runRawQuery($sql);

        $title2 = '<br/><br/>
              <h3 id="headerH1">Title: ' . $data[0]['lsm_title'] . '</h3>

                        <h4>Meeting Date: ' . $data[0]['meeting_date'] . '</h4><h4> Meeting Time: ' . $data[0]['meeting_time'] . '</h4>
                        <h4>Location: ' . $data[0]['location'] . '</h4>

              ';
        $pdf->writeHTML($title . $title2, true, false, true, false, 'C');
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


        $title3 = '<h3>Budget Details For ' . $data[0]['lsm_title'] . '</h3>';


        // $Tabledata = $expansionmodel->getVcsMeetingData('vcs_meeting',$fieldsArray,$program,'village_name');
        $Tabledata = $expansionmodel->getWHEREData('lsm_budget_details', 'lsm_id', $LsmId);
        // Table header 
        $pdf->SetFont('helvetica', '', 11);
        $pdf->SetY(30);

        if (empty($Tabledata)) {
            $comment = 'No Budget Has Been Set<br/></div>';

            $pdf->writeHTML($title3 . $comment, true, false, true, false, 'C');
        } else {
            $tableHeader = '<table style="border:1px solid #333333; font-size: 11px;">';
            //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
            $tableHeader.= '<tr>';
            $tableHeader.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $tableHeader.= '<td style="border:1px solid #333333;" ><b>Item Name</b></td>';
            $tableHeader.= '<td style="border:1px solid #333333;" ><b>Cost</b></td>';
            $tableHeader .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table = '';
            $counter = 1;
            $total = 0;
            foreach ($Tabledata as $key => $value) {

                $table .= '<tr>';
                $table.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                $table .= '<td style="border:1px solid #333333;" >' . $value['item'] . '</td>';
                $table.= '<td style="border:1px solid #333333;" >' . $value['cost'] . '</td>';

                $table .= '</tr>';
                $total+=$value['cost'];
                ++$counter;
            }
            $table.='<tr><td style="border:1px solid #333333;text-align:center;" colspan="2"><b>Total Cost</b></td><td style="border:1px solid #333333;" ><b>' . $total . '</b></td></tr>';
            $table .= '</table><br/>';



            $pdf->writeHTML($title3 . $tableHeader . $table, true, false, true, false, 'L');
        }



        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($data[0]['lsm_title'] . '.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfLSMDuty($LsmId) {
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('Summary of LSM Meeting');
        $pdf->SetSubject('Lsm Meeting Details');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


        $pdf->SetY(100);
        $header = '<div>';

        $title = '<h1 id="headerH1">Lsm Meeting Details</h1>';

        $expansionmodel = $this->loadModel('expansionmodel');



        $sql = 'SELECT * from lsm_details WHERE id=' . $LsmId;

        $data = $expansionmodel->runRawQuery($sql);

        $title2 = '<br/><br/>
              <h3 id="headerH1">Title: ' . $data[0]['lsm_title'] . '</h3>

                        <h4>Meeting Date: ' . $data[0]['meeting_date'] . '</h4><h4> Meeting Time: ' . $data[0]['meeting_time'] . '</h4>
                        <h4>Location: ' . $data[0]['location'] . '</h4>

              ';
        $pdf->writeHTML($title . $title2, true, false, true, false, 'C');
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);
        $pdf->SetY(30);
        $title4 = '<h3>Duties Allocated For ' . $data[0]['lsm_title'] . '</h3>';
        $fieldsArray = $this->fieldsArray('dutiesLsm');

        $Tabledata2 = $expansionmodel->getDUTIESWHEREData('lsm_duties_details', 'lsm_id', $LsmId, $fieldsArray);
        // Table header 
        $pdf->SetFont('helvetica', '', 11);


        if (empty($Tabledata2)) {
            $comment = 'No Duties have been Set<br/></div>';

            $pdf->writeHTML($title4 . $comment, true, false, true, false, 'C');
        } else {
            $tableHeader2 = '<table style="border:1px solid #333333; font-size: 11px;">';
            //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
            $tableHeader2.= '<tr>';
            $tableHeader2.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $tableHeader2.= '<td style="border:1px solid #333333;" ><b>Staff Name</b></td>';
            $tableHeader2.= '<td style="border:1px solid #333333;" ><b>Duty</b></td>';
            $tableHeader2 .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table2 = '';
            $counter = 1;
            $total = 0;
            foreach ($Tabledata2 as $key => $value) {

                $table2 .= '<tr>';
                $table2.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                $table2 .= '<td style="border:1px solid #333333;" >' . $value['full_name'] . '</td>';
                $table2.= '<td style="border:1px solid #333333;" >' . $value['duties'] . '</td>';

                $table2 .= '</tr>';

                ++$counter;
            }
            $table2 .= '</table>';



            $pdf->writeHTML($title4 . $tableHeader2 . $table2, true, false, true, false, 'L');
        }

        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output($data[0]['lsm_title'] . '.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfSiteVerification($siteverificationId) {
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('Waterpoint Verification Budget Schedule');
        $pdf->SetSubject('Waterpoint Verification Budget Schedule');
        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Waterpoint Verification Schedule</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        // $siteverificationId=urldecode($siteverificationId);
        //   $siteverificationId=trim($siteverificationId," ");
        //   $siteverificationId=str_replace(' ','',$siteverificationId);
        $sql = 'SELECT * from site_verification WHERE program="' . $siteverificationId[2] . '"';

        $data = $expansionmodel->runRawQuery($sql);

        $AmountPerDay = ($data[0]['funds_given_per_fo_per_day']) * ($data[0]['no_of_field_officers']);
        $total = $data[0]['funds_given_per_fo_per_day'] * $data[0]['no_of_field_officers'] * ($data[0]['total_expected_verification'] / $data[0]['no_of_verifications_per_day']);
        $villageData = 'site_v_schedule';

        $fieldsArray = $this->fieldsArray($villageData);
        $Tabledata = $expansionmodel->getpdfInfoCau($villageData, $fieldsArray, $siteverificationId[2]);


        $title2 = '<span id="headerH1" >Start Date: &nbsp; ' . $data[0]['verification_start_date'] . '</span><br/>
                            <span>Total Number Of Field Officers: &nbsp;' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Total Number Of Villages:&nbsp; ' . sizeof($Tabledata) . '</span><br/>
                            <span>Number Of Verifications Per F.O Per Day:&nbsp;' . $data[0]['no_of_verifications_per_day'] . '</span><br/>
                            <span>Total Expected Verifications:&nbsp; ' . $data[0]['total_expected_verification'] . '</span><br/>
                            <span>Total Allowance Per Field Officer Per Day:&nbsp; ' . number_format($data[0]['funds_given_per_fo_per_day']) . '</span><br/>
                            <span>Approximate No Of Waterpoints Per Village:&nbsp; ' . $data[0]['approximate_no_of_waterpoints_per_village'] . '</span><br/>
                                  
                ';
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');
        $fieldsArray = $this->fieldsArray('fo_verify');


        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $message = 'No Schedule has been generated for this Program.Click On Populate Schedule then try again';
            $message = urlencode($message);
            header('Location:' . URL . 'scheduler/planSchedule/site_v_schedule/' . $siteverificationId[2] . '/?message=' . $message);
        } else {

            // Table header 
            $pdf->SetFont('helvetica', '', 11);


            $title3 = '<h3 >Schedule Details </h3>';
            $tableHeader3 = '<table style=" font-size: 11px;">';
            $tableHeader3.= '<tr>';
            $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';

            $query = 'SELECT id
                           FROM admin_territory
                           WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                             ';
            $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

            $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id < ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $ancestors = $expansionmodel->selectDBraw($query);
            $ancestors = array_reverse($ancestors);
            $cauManage = $expansionmodel->checkSelectedCau('site_v_schedule');
            foreach ($ancestors as $key => $ancestor) {
                //if(in_array($ancestor['territory_name'], $cauManage)){
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                // array_push($expectedCau, $ancestor['territory_name']);
                //  }
            }

            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Elder</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Elder Contact</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Health Worker Name</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Health Worker Contact</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Date</b></td>';
            $tableHeader3.= '</tr>';


            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table3 = '';
            $counter = 1;
            $counter2 = 0;
            $totalAllowance = 0;

            $pdf->writeHTML($header . $title3, true, false, true, false, '');
            // echo '<pre>';
            // print_r($ancestors);
            // echo '</pre>';
            // exit();
            foreach ($Tabledata as $key => $value) {


                $table3.= '<tr>';
                $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                foreach ($ancestors as $key => $ancestor) {
                    // if(in_array($ancestor['territory_name'], $cauManage)){
                    $table3 .='<td style="border:1px solid #333333;" >' . $value[$ancestor['territory_name']] . '</td>';
                    //  }
                }

                $table3.= '<td style="border:1px solid #333333; ">' . $value['village'] . '</td>';
                // $table3.=  '<td style="border:1px solid #333333;" >'.$value['village_elder'].'</td>';
                // $table3.=  '<td style="border:1px solid #333333;" >'.$value['elder_contact'].'</td>';
                // $table3.=  '<td style="border:1px solid #333333;" >'.$value['chw_name'].'</td>';
                // $table3.=  '<td style="border:1px solid #333333;" >'.$value['chw_contact'].'</td>';

                $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['date'] . '</td>';


                $table3.= '</tr>';

                ++$counter;
                if ($counter % 30 == 0 && $counter > 29) {

                    $table3 .= '</table>';
                    $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                    $table3 = '';

                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                    continue;
                }
            }

            $table3 .= '</table></div>';



            $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
        }



        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('waterpoint_verification_schedule.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfVillageVerification($siteverificationId) {
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('Waterpoint Verification Budget Schedule');
        $pdf->SetSubject('Waterpoint Verification Budget Schedule');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Waterpoint Verification Budget</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        // $siteverificationId=urldecode($siteverificationId);
        //   $siteverificationId=trim($siteverificationId," ");
        //   $siteverificationId=str_replace(' ','',$siteverificationId);
        $sql = 'SELECT * from site_verification WHERE program="' . $siteverificationId[2] . '"';


        // $sql='SELECT * from vcs_schedule WHERE program="'.$program.'"';

        $data = $expansionmodel->runRawQuery($sql);
        $AmountPerDay = ($data[0]['funds_given_per_fo_per_day']) * ($data[0]['no_of_field_officers']);
        $total = $data[0]['funds_given_per_fo_per_day'] * $data[0]['no_of_field_officers'] * ($data[0]['total_expected_verification'] / $data[0]['no_of_verifications_per_day']);

        $villageData = 'site_v_schedule';

        $fieldsArray = $this->fieldsArray($villageData);
        $Tabledata = $expansionmodel->getpdfInfoCau($villageData, $fieldsArray, $siteverificationId[2]);

        $title2 = '<span id="headerH1" >Start Date: &nbsp; ' . $data[0]['verification_start_date'] . '</span><br/>
                            <span>Total Number Of Field Officers: &nbsp;' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Total Number Of Villages:&nbsp; ' . sizeof($Tabledata) . '</span><br/>
                            <span>Total Number Of Verifications:&nbsp;' . $data[0]['no_of_verifications_per_day'] . '</span><br/>
                            <span>Total Expected Verifications:&nbsp; ' . $data[0]['total_expected_verification'] . '</span><br/>
                            <span>Total Allowance Per Field Officer Per Day:&nbsp; ' . number_format($data[0]['funds_given_per_fo_per_day']) . '</span><br/>
                            <span>Approximate No Of Waterpoints Per Village:&nbsp; ' . $data[0]['approximate_no_of_waterpoints_per_village'] . '</span><br/>
                                  
                ';
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');
        $fieldsArray = $this->fieldsArray('fo_verify');

        // $Tabledata = $expansionmodel->getPdfFoVerification('vcs_meeting',$fieldsArray,$siteverificationId);
        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $comment = 'No Field Officers Have Been Scheduled For Site Verification</div>';
            header('Location:' . URL . 'scheduler/site_verification/' . $siteverificationId[2]);
            // $pdf->writeHTML($header.$comment, true, false, true, false, 'C');
        } else {



            // Table header 
            $pdf->SetFont('helvetica', '', 11);

            $title3 = '<h3 >Budget Details </h3>';
            $tableHeader3 = '<table style=" font-size: 11px;">';
            //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
            $tableHeader3.= '<tr>';
            $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $query = 'SELECT id
                    FROM admin_territory
                    WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

            $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id < ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $ancestors = $expansionmodel->selectDBraw($query);
            $cauManage = $expansionmodel->checkSelectedCau('site_v_schedule');
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $key => $ancestor) {
                if (in_array($ancestor['territory_name'], $cauManage)) {
                    $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                }
            }
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Funds Given Per F.O</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Date</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Distance</b></td>';

            $tableHeader3 .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table3 = '';
            $counter = 1;
            $counter2 = 0;
            $totalAllowance = 0;

            $pdf->writeHTML($header . $title3, true, false, true, false, '');
            foreach ($Tabledata as $key => $value) {

                $table3.= '<tr>';
                $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                foreach ($ancestors as $key => $ancestor) {
                    if (in_array($ancestor['territory_name'], $cauManage)) {
                        $table3.= '<td style="border:1px solid #333333; ">' . $value[$ancestor['territory_name']] . '</td>';
                    }
                }
                if ($value['allowance'] == null || empty($value['allowance'])) {
                    $value['allowance'] = 0;
                }
                $table3.= '<td style="border:1px solid #333333; ">' . $value['village'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['allowance'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['date'] . '</td>';
                $table3.= '</tr>';
                $totalAllowance+=$value['allowance'];
                ++$counter;
                if ($counter % 30 == 0 && $counter > 29) {

                    $table3 .= '</table>';
                    $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                    $table3 = '';

                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                    continue;
                }
            }
            $table3.='<tr>';
            $table3.='<td style="border:1px solid #333333;"></td>';
            foreach ($ancestors as $key => $ancestor) {
                if (in_array($ancestor['territory_name'], $cauManage)) {
                    $table3.='<td style="border:1px solid #333333;"></td>';
                }
            }
            $table3.='<td style="border:1px solid #333333;"></td>';
            $table3.='<td style="border:1px solid #333333;"><b>Total</b></td><td style="border:1px solid #333333;"><b>' . number_format($totalAllowance) . '</b></td><td style="border:1px solid #333333;"></td></tr>';
            $table3 .= '</table></div>';



            $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
        }



        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('waterpoint_verification_schedule.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfVcsFo($program) {

        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('F.O Vcs Schedule');
        $pdf->SetSubject('Field Officers VCS Schedule');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Community Sensitization (VCS) Schedule</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        // $siteverificationId=urldecode($siteverificationId);
        //   $siteverificationId=trim($siteverificationId," ");
        //   $siteverificationId=str_replace(' ','',$siteverificationId);
        $sql = 'SELECT * from vcs_schedule WHERE program="' . $siteverificationId[2] . '"';


        // $sql='SELECT * from vcs_schedule WHERE program="'.$program.'"';

        $data = $expansionmodel->runRawQuery($sql);
        $averageTotal = $data[0]['no_of_vcs_per_day_per_fo'] * $data[0]['no_of_field_officers'];
        $vcsDays = $data[0]['no_of_villages'] / $data[0]['no_of_vcs_per_day_per_fo'];
        $totalAllowance = $data[0]['funds_given_per_fo_per_day'] * $vcsDays;

        $title2 = '<span id="headerH1">Start Date: ' . $data[0]['start_date'] . '</span><br/>

                            <span>Total Number Of Field Officers: ' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Total Number Of Villages:' . $data[0]['no_of_villages'] . '</span><br/>
                            <span>Number Of VCS Per Day Per F.O:' . $data[0]['no_of_vcs_per_day_per_fo'] . '</span><br/>
                            <span>Average Total Number Of VCS Per Day:' . $averageTotal . '</span><br/>
                            <span>Transport Allowance Per F.O Per Day:' . $data[0]['funds_given_per_fo_per_day'] . '</span><br/>
                            <span>Total Transport Allowance:' . $totalAllowance . '</span><br/>

                ';
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');



        $fieldsArray = $this->fieldsArray('vcs_gen_schedule');
        $Tabledata = $expansionmodel->getpdfInfoCau('vcs_gen_schedule', $fieldsArray, $siteverificationId[2]);

        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $_GET['message'] = 'No Schedule has been generated.';
            header('Location:' . URL . 'scheduler/planSchedule/vcs_gen_schedule/' . $siteverificationId[2]);


            // $pdf->writeHTML($header.$comment, true, false, true, false, 'C');
        } else {


            $title3 = '<h3 >VCS Details </h3>';
            $tableHeader3 = '<table style=" font-size: 11px;">';
            //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
            $tableHeader3.= '<tr>';
            $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';


            $query = 'SELECT id
                           FROM admin_territory
                           WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                             ';
            $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

            $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $ancestors = $expansionmodel->selectDBraw($query);
            $ancestors = array_reverse($ancestors);

            foreach ($ancestors as $key => $ancestor) {
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                // array_push($expectedCau, $ancestor['territory_name']);
            }

            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Date</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Distance</b></td>';

            $tableHeader3 .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table3 = '';
            $counter = 1;
            $counter2 = 0;

            $pdf->writeHTML($header . $title3, true, false, true, false, '');
            foreach ($Tabledata as $key => $value) {

                $table3.= '<tr>';
                $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';

                foreach ($ancestors as $key => $ancestor) {
                    // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>'.ucwords(str_replace('_',' ',$value[$ancestor['territory_name']])).'</b></td>';
                    $table3.= '<td style="border:1px solid #333333; ">' . $value[$ancestor['territory_name']] . '</td>';
                }
                // $table3.=  '<td style="border:1px solid #333333; ">'.$value['village_name'].'</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['date'] . '</td>';

                $table3.= '</tr>';

                ++$counter;
                if ($counter % 30 == 0 && $counter > 29) {

                    $table3 .= '</table>';
                    $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                    $table3 = '';

                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                    continue;
                }
            }
            $table3 .= '</table></div>';



            $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
        }



        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('FO_VCS_schedule.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfVcs($program) {

        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        // Include the main TCPDF library (search for installation path).

        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('F.O Vcs Schedule');
        $pdf->SetSubject('Field Officers VCS Schedule');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Community Sensitization (VCS) Schedule</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        // $siteverificationId=urldecode($siteverificationId);
        //   $siteverificationId=trim($siteverificationId," ");
        //   $siteverificationId=str_replace(' ','',$siteverificationId);
        $sql = 'SELECT * from vcs_schedule WHERE program="' . $siteverificationId[2] . '"';


        // $sql='SELECT * from vcs_schedule WHERE program="'.$program.'"';

        $data = $expansionmodel->runRawQuery($sql);
        $averageTotal = $data[0]['no_of_vcs_per_day_per_fo'] * $data[0]['no_of_field_officers'];
        $vcsDays = $data[0]['no_of_villages'] / $data[0]['no_of_vcs_per_day_per_fo'];
        $totalAllowance = $data[0]['funds_given_per_fo_per_day'] * $vcsDays;

        $title2 = '<span id="headerH1">Start Date: ' . $data[0]['start_date'] . '</span><br/>

                            <span>Total Number Of Field Officers: ' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Total Number Of Villages:' . $data[0]['no_of_villages'] . '</span><br/>
                            <span>Number Of VCS Per Day Per F.O:' . $data[0]['no_of_vcs_per_day_per_fo'] . '</span><br/>
                            <span>Average Total Number Of VCS Per Day:' . $averageTotal . '</span><br/>
                            <span>Transport Allowance Per F.O Per Day:' . $data[0]['funds_given_per_fo_per_day'] . '</span><br/>
                           

                ';
        // <span>Total Transport Allowance:'.$totalAllowance.'</span><br/>
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');


        $fieldsArray = $this->fieldsArray('vcs_gen_schedule');
        $Tabledata = $expansionmodel->getpdfInfoCau('vcs_gen_schedule', $fieldsArray, $siteverificationId[2]);


        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $_GET['message'] = 'No Schedule has been generated.';
            header('Location:' . URL . 'scheduler/planSchedule/vcs_gen_schedule/' . $siteverificationId[2]);


            // $pdf->writeHTML($header.$comment, true, false, true, false, 'C');
        } else {


            $title3 = '<h3 >VCS Details </h3>';
            $tableHeader3 = '<table style=" font-size: 11px;">';
            //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
            $tableHeader3.= '<tr>';
            $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';
            $query = 'SELECT id
                    FROM admin_territory
                    WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

            $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
            $ancestors = $expansionmodel->selectDBraw($query);
            //$expectedCau=array();
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $key => $ancestor) {
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                //array_push($expectedCau, $ancestor['territory_name']);
            }
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Funds Given Per F.O</b></td>';
            $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Date</b></td>';
            // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Distance</b></td>';

            $tableHeader3 .= '</tr>';
            // Table content beings here 
            $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


            $table3 = '';
            $counter = 1;
            $counter2 = 0;
            $totalAllowance = 0;
            $pdf->writeHTML($header . $title3, true, false, true, false, '');
            foreach ($Tabledata as $key => $value) {

                $table3.= '<tr>';
                $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                foreach ($ancestors as $key => $ancestor) {
                    $table3.= '<td style="border:1px solid #333333; ">' . $value[$ancestor['territory_name']] . '</td>';
                }
                //   $table3.=  '<td style="border:1px solid #333333; ">'.$value['village_name'].'</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['allowance'] . '</td>';
                $table3.= '<td style="border:1px solid #333333;" >' . $value['date'] . '</td>';
                $table3.= '</tr>';

                ++$counter;
                if ($counter % 30 == 0 && $counter > 31) {

                    $table3 .= '</table>';
                    $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                    $table3 = '';

                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                    continue;
                }
                $totalAllowance+=$value['allowance'];
            }
            $table3.='<tr><td style="border:1px solid #333333;"></td>';
            foreach ($ancestors as $key => $ancestor) {
                $table3.= '<td style="border:1px solid #333333; "></td>';
            }
            $table3.='<td style="border:1px solid #333333;"><b>Total</b></td><td style="border:1px solid #333333;"><b>' . number_format($totalAllowance) . '</b></td><td style="border:1px solid #333333;"></td></tr>';
            $table3 .= '</table></div>';
            $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
        }



        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('FO_VCS_schedule.pdf', 'I');
        //$pdf->Output('example_036.pdf', 'I');
    }

    public function pdfDispenserFo($program) {
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        // Include the main TCPDF library (search for installation path).
        ini_set('max_execution_time', 300);
        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('F.O Installation-CEM Schedule');
        $pdf->SetSubject('Field Officers Installation-CEM Schedule');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Dispenser Installation & Cem  Schedule</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        // $siteverificationId=urldecode($siteverificationId);
        //   $siteverificationId=trim($siteverificationId," ");
        //   $siteverificationId=str_replace(' ','',$siteverificationId);
        $sql = 'SELECT * from dispenser_installation_schedule WHERE program="' . $siteverificationId[2] . '"';


        // $sql='SELECT * from vcs_schedule WHERE program="'.$program.'"';

        $data = $expansionmodel->runRawQuery($sql);
        $totalAllowance = $data[0]['no_of_field_officers'] * $data[0]['funds_given_per_fo_per_day'];
        $title2 = '<span id="headerH1">Installation Start Date: ' . $data[0]['installation_start_date']
                . '<br/> Cem Start Date: ' . $data[0]['cem_start_date']
                . '</span><br/>

                            <span>Total Number Of Field Officers: ' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Number Of Installations Per Day:' . $data[0]['no_of_installations_per_day'] . '</span><br/>
                            <span>Number Of Cems Per Day:' . $data[0]['no_of_cems_per_fo_per_day'] . '</span><br/>
                            
                            <span>Number Of Vehicles: ' . $data[0]['no_of_vehicles'] . '</span><br/>
                            <span>Number Of Field Officers Assigned Per Vehicle: ' . $data[0]['no_of_field_officers_assigned_per_vehicle'] . '</span><br/>
                            <span>Vehicle Cost Per Day:' . number_format($data[0]['vehicle_cost_per_day']) . '</span><br/>
                            <span>Field Officer Cost Per Day:' . number_format($data[0]['funds_given_per_fo_per_day']) . '</span><br/>
                            <span>Cost Associated With each Cem:' . $data[0]['cost_associated_with_each_cem'] . '</span><br/>
                ';
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');


        $fieldsArray = $this->fieldsArray('dispenser_gen_schedule');

        $Tabledata = $expansionmodel->getDispenserOfficerData('dispenser_gen_schedule', $fieldsArray, $siteverificationId[2]);


        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $comment = 'No Field Officers Have Been Scheduled For Dispenser Installation & Cem</div>';

            $pdf->writeHTML($header . $comment, true, false, true, false, 'C');
        } else {

            $fieldsArray = $this->fieldsArray('dispenser_material');

            $TabledataM = $expansionmodel->getdMaterialData('dispenser_material', $fieldsArray, $program);


            if (empty($TabledataM)) {
                $comment = 'No Materials have been set For Dispenser Installation & Cem</div>';

                $pdf->writeHTML($header . $comment, true, false, true, false, 'C');
            } else {
                $tableHeader = '<h4>Dispenser Installation Materials & Cem</h4>';
                $tableHeader.= '<table style="border:1px solid #333333; font-size: 11px;">';
                //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
                $tableHeader.= '<tr>';
                $tableHeader.='<td style="border:1px solid #333333;width:30px;">No</td>';

                $tableHeader.= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
                $tableHeader.= '<td style="border:1px solid #333333;" ><b>Quantity</b></td>';

                $tableHeader .= '</tr>';
                // Table content beings here 
                $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


                $table = '';
                $counter = 1;

                foreach ($TabledataM as $key => $value) {

                    $table .= '<tr>';
                    $table .= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                    $table .= '<td style="border:1px solid #333333;" >' . $value['material'] . '</td>';
                    $table .= '<td style="border:1px solid #333333;" >' . $value['quantity'] . '</td>';
                    $table .= '</tr>';
                    ++$counter;
                }
                $table .= '</table>';



                $pdf->writeHTML($tableHeader . $table, true, false, true, false, '');
            }
            $fieldsArray = $this->fieldsArray('dispenser_gen_schedule');
            $Tabledata = $expansionmodel->getpdfInfoCau('dispenser_gen_schedule', $fieldsArray, $siteverificationId[2]);

            // Table header 
            $pdf->SetFont('helvetica', '', 11);

            if (empty($Tabledata)) {
                $_GET['message'] = 'No Schedule has been generated.';
                header('Location:' . URL . 'scheduler/planSchedule/dispenser_gen_schedule/' . $siteverificationId[2]);


                // $pdf->writeHTML($header.$comment, true, false, true, false, 'C');
            } else {


                $title3 = '<h3 >Dispenser Details </h3>';
                $tableHeader3 = '<table style=" font-size: 11px;">';
                //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
                $tableHeader3.= '<tr>';
                $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';
                $query = 'SELECT id
                    FROM admin_territory
                    WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
                $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

                $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
                $ancestors = $expansionmodel->selectDBraw($query);
                //$expectedCau=array();
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $key => $ancestor) {
                    $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                    //array_push($expectedCau, $ancestor['territory_name']);
                }
                //$tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Waterpoint Name</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Installation Date</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Cem Date</b></td>';
                // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Distance</b></td>';

                $tableHeader3 .= '</tr>';
                // Table content beings here 
                $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


                $table3 = '';
                $counter = 1;
                $counter2 = 0;

                $pdf->writeHTML($header . $title3, true, false, true, false, '');
                foreach ($Tabledata as $key => $value) {

                    $table3.= '<tr>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                    // $table3.=  '<td style="border:1px solid #333333; ">'.$value['village_name'].'</td>';
                    foreach ($ancestors as $key => $ancestor) {
                        // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>'.ucwords(str_replace('_',' ',$value[$ancestor['territory_name']])).'</b></td>';
                        $table3.= '<td style="border:1px solid #333333; ">' . $value[$ancestor['territory_name']] . '</td>';
                    }
                    $table3.= '<td style="border:1px solid #333333; ">' . $value['waterpoint_name'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['installation_date'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['cem_date'] . '</td>';
                    $table3.= '</tr>';

                    ++$counter;
                    if ($counter % 30 == 0 && $counter > 29) {

                        $table3 .= '</table>';
                        $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                        $table3 = '';

                        $pdf->SetFont('helvetica', '', 11);
                        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                        continue;
                    }
                }
                $table3 .= '</table></div>';



                $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
            }
        }

        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('FO_Dispenser_Installation_schedule.pdf', 'I');
    }

    public function pdfDispenser($program) {
        ini_set('max_execution_time', 300);
        date_default_timezone_set("Africa/Nairobi");
        // Include the main TCPDF library (search for installation path).
        ini_set('max_execution_time', 300);
        require_once('application/libs/tcpdf/tcpdf_include.php');

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['full_name']);
        $pdf->SetTitle('F.O Installation-CEM Schedule');
        $pdf->SetSubject('Field Officers Installation-CEM Schedule');


        // remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists('application/libs/tcpdf/tcpdf/lang/eng.php')) {
            require_once('application/libs/tcpdf/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('helvetica', '', 12, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);



        $header = '<div>';

        $title = '<h1 id="headerH1">Dispenser Installation & Cem Schedule</h1><br/><br/>';

        $expansionmodel = $this->loadModel('expansionmodel');


        $siteverificationId = explode('/', $_GET['url']);
        $sql = 'SELECT * from dispenser_installation_schedule WHERE program="' . $siteverificationId[2] . '"';


        // $sql='SELECT * from vcs_schedule WHERE program="'.$program.'"';

        $data = $expansionmodel->runRawQuery($sql);
        $totalAllowance = $data[0]['no_of_field_officers'] * $data[0]['funds_given_per_fo_per_day'];
        $title2 = '<span id="headerH1">Installation Start Date: ' . $data[0]['installation_start_date']
                . '<br/> Cem Start Date: ' . $data[0]['cem_start_date']
                . '</span><br/>

                            <span>Total Number Of Field Officers: ' . $data[0]['no_of_field_officers'] . '</span><br/>
                            <span>Number Of Installations Per Day:' . $data[0]['no_of_installations_per_day'] . '</span><br/>
                            <span>Number Of Cems Per Day:' . $data[0]['no_of_cems_per_fo_per_day'] . '</span><br/>
                            
                            <span>Number Of Vehicles: ' . $data[0]['no_of_vehicles'] . '</span><br/>
                            <span>Number Of Field Officers Assigned Per Vehicle: ' . $data[0]['no_of_field_officers_assigned_per_vehicle'] . '</span><br/>
                            <span>Vehicle Cost Per Day:' . number_format($data[0]['vehicle_cost_per_day']) . '</span><br/>
                            <span>Field Officer Cost Per Day:' . number_format($data[0]['funds_given_per_fo_per_day']) . '</span><br/>
                            <span>Cost Associated With each Cem:' . $data[0]['cost_associated_with_each_cem'] . '</span><br/>
                ';
        $pdf->writeHTML($title, true, false, true, false, 'C');
        $pdf->writeHTML($title2, true, false, true, false, 'L');


        $fieldsArray = $this->fieldsArray('dispenser_gen_schedule');

        $Tabledata = $expansionmodel->getDispenserOfficerData('dispenser_gen_schedule', $fieldsArray, $siteverificationId[2]);


        // Table header 
        $pdf->SetFont('helvetica', '', 11);

        if (empty($Tabledata)) {
            $comment = 'No Field Officers Have Been Scheduled For Dispenser Installation & Cem</div>';

            $pdf->writeHTML($header . $comment, true, false, true, false, 'C');
        } else {

            $fieldsArray = $this->fieldsArray('dispenser_material');

            $TabledataM = $expansionmodel->getdMaterialData('dispenser_material', $fieldsArray, $program);


            if (empty($TabledataM)) {
                $comment = 'No Materials have been set For Dispenser Installation & Cem</div>';

                $pdf->writeHTML($header . $comment, true, false, true, false, 'C');
            }

            $fieldsArray = $this->fieldsArray('dispenser_gen_schedule');
            $Tabledata = $expansionmodel->getpdfInfoCau('dispenser_gen_schedule', $fieldsArray, $siteverificationId[2]);

            // Table header 
            $pdf->SetFont('helvetica', '', 11);

            if (empty($Tabledata)) {
                $_GET['message'] = 'No Schedule has been generated.';
                header('Location:' . URL . 'scheduler/planSchedule/dispenser_gen_schedule/' . $siteverificationId[2]);


                // $pdf->writeHTML($header.$comment, true, false, true, false, 'C');
            } else {


                $title3 = '<h3 >Installation/Cem budget Details </h3>';
                $tableHeader3 = '<table style=" font-size: 11px;">';
                //$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
                $tableHeader3.= '<tr>';
                $tableHeader3.='<td style="border:1px solid #333333;width:30px;">No</td>';
                $query = 'SELECT id
                    FROM admin_territory
                    WHERE territory_name = "village" AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
                $admin_territory_id = $expansionmodel->selectDBraw($query)[0]['id'];

                $query = 'SELECT id,
                    territory_name, 
                    territory_level
                    FROM admin_territory
                    WHERE id <= ' . $admin_territory_id . ' AND country_id = ' . $_SESSION['country'] . ' ORDER BY territory_level DESC
                ';
                $ancestors = $expansionmodel->selectDBraw($query);
                //$expectedCau=array();
                $ancestors = array_reverse($ancestors);
                foreach ($ancestors as $key => $ancestor) {
                    $tableHeader3.= '<td style="border:1px solid #333333;" ><b>' . ucwords(str_replace('_', ' ', $ancestor['territory_name'])) . '</b></td>';
                    //array_push($expectedCau, $ancestor['territory_name']);
                }
                //$tableHeader3.= '<td style="border:1px solid #333333;" ><b>Village Name</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Waterpoint Name</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Field Officer Assigned</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Installation Date</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Installation Allowance</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Cem Date</b></td>';
                $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Cem Allowance</b></td>';
                // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>Distance</b></td>';

                $tableHeader3 .= '</tr>';
                // Table content beings here 
                $pdf->SetFont('helvetica', '', 9);  // two parameters accept font-family and style. Passing blank sets default values


                $table3 = '';
                $counter = 1;
                $counter2 = 0;

                $pdf->writeHTML($header . $title3, true, false, true, false, '');
                $totalInstallationAllowance = 0;
                $totalCemAllowance = 0;
                foreach ($Tabledata as $key => $value) {

                    $table3.= '<tr>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $counter . '</td>';
                    // $table3.=  '<td style="border:1px solid #333333; ">'.$value['village_name'].'</td>';
                    foreach ($ancestors as $key => $ancestor) {
                        // $tableHeader3.= '<td style="border:1px solid #333333;" ><b>'.ucwords(str_replace('_',' ',$value[$ancestor['territory_name']])).'</b></td>';
                        $table3.= '<td style="border:1px solid #333333; ">' . $value[$ancestor['territory_name']] . '</td>';
                    }
                    $table3.= '<td style="border:1px solid #333333; ">' . $value['waterpoint_name'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['field_officer_assigned'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['installation_date'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['installation_allowance'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['cem_date'] . '</td>';
                    $table3.= '<td style="border:1px solid #333333;" >' . $value['cem_allowance'] . '</td>';
                    $table3.= '</tr>';

                    ++$counter;
                    if ($counter % 30 == 0 && $counter > 29) {

                        $table3 .= '</table>';
                        $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
                        $table3 = '';

                        $pdf->SetFont('helvetica', '', 11);
                        $pdf->AddPage("P", "mm", "A4", true, "UTF-8", false);


                        continue;
                    }
                    if ($value['installation_allowance'] >= 0) {
                        $totalInstallationAllowance+=$value['installation_allowance'];
                        $totalCemAllowance+=$value['cem_allowance'];
                    }
                }


                $table3.='<tr><td style="border:1px solid #333333;"></td>';
                foreach ($ancestors as $key => $ancestor) {
                    $table3.= '<td style="border:1px solid #333333; "></td>';
                }
                $table3.='<td style="border:1px solid #333333;"></td><td style="border:1px solid #333333;"></td><td style="border:1px solid #333333;"><b>Total install Cost</b></td><td style="border:1px solid #333333;"><b>' . number_format($totalInstallationAllowance) . '</b></td><td style="border:1px solid #333333;"><b>Total Cem cost</b></td><td style="border:1px solid #333333;">' . number_format($totalCemAllowance) . '</td></tr>';
                $table3 .= '</table></div>';
                $pdf->writeHTML($tableHeader3 . $table3, true, false, true, false, '');
            }
        }

        ob_clean();
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        $pdf->Output('FO_Dispenser_Installation_schedule.pdf', 'I');
    }

}

?>