<?php

class logsmodel extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function insertLogData($table, $data, $type) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'lsm_details') {
            $query = 'SELECT admin_territory_name FROM admin_territory_details WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['admin_territory_name'];
            $description = str_replace('_', ' ', $type) . ' is ' . $descrip;
        } else if ($table == 'lsm_budget_details') {
            $description = str_replace('_', ' ', $type) . ' is ' . $data;
        } else if ($table == 'lsm_duties_details') {
            $query = 'SELECT full_name FROM staff_list WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['full_name'];
            $description = str_replace('_', ' ', $type) . ' is ' . $descrip;
        } else if ($table == 'site_verification') {
            $description = str_replace('_', ' ', $type) . ' is ' . $data;
        } else if ($table == 'cau_programs') {
            $query1 = 'SELECT admin_territory_name FROM admin_territory_details WHERE id = ' . $data . '';
            $descrip1 = $this->selectDBraw($query1)[0]['admin_territory_name'];
            $query2 = 'SELECT program FROM dsw_programs WHERE id = ' . $type . '';
            $descrip2 = $this->selectDBraw($query2)[0]['program'];
            $description = $descrip1 . ' village added to ' . $descrip2 . ' program';
        } else if ($table == 'waterpoint_verification') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = $type . ' ' . $descrip . ' program';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }

    public function insertLogDataOnEdit($table, $data, $type) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        if ($table == 'lsm_details') {
            $query = 'SELECT admin_territory_name FROM admin_territory_details WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['admin_territory_name'];
            $description = str_replace('_', ' ', $type) . ' is ' . $descrip;
        } else if ($table == 'lsm_budget_details') {
            $description = str_replace('_', ' ', $type) . ' is ' . $data['item'];
        } else if ($table == 'lsm_duties_details') {
            $query = 'SELECT full_name FROM staff_list WHERE id = ' . $data['full_name'] . '';
            $descrip = $this->selectDBraw($query)[0]['full_name'];
            $description = 'Staff name is ' . $descrip;
        } else if ($table == 'site_verification') {
            $description = str_replace('_', ' ', $type) . ' is ' . $data;
        } else if ($table == 'lsm_tracking') {
            $description = 'No description';
        } else {
            $description = ' unknown ';
        }

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }
       public function insertLogContactonImport($table) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' data imported';
        $description = 'no description';

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );

        $this->insertdDB('admin_log_record', $insertData);
    }

    //MAURICE ADDED CODE
    public function insertLogSurveyTracker($table) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' survey uploaded';
        $description = 'no description';

        $insertData = array(
            #'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description,

        );

        $this->insertdDB('survey_log_record', $insertData);
    }
    public function deleteLogSurveyTracker($table) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' survey deleted';
        $description = 'no description';

        $insertData = array(
            #'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description,

        );

        $this->insertdDB('survey_log_record', $insertData);
    }

    public function insertLogDataOnDelet($table, $data, $type) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';
        if ($table == 'lsm_details') {
            $query = 'SELECT admin_territory_name FROM admin_territory_details WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['admin_territory_name'];
            $description = str_replace('_', ' ', $type) . ' is ' . $descrip;
        } else if ($table == 'lsm_budget_details') {
            $query = 'SELECT item FROM lsm_budget_details WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['item'];
            $description = 'item name is ' . $descrip;
        } else if ($table == 'lsm_duties_details') {
            $query = 'SELECT full_name FROM staff_list WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['full_name'];
            $description = 'Staff name is ' . $descrip;
        } else if ($table == 'cau_programs') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = $type . ' deleted from ' . $descrip . ' program';
        } else if ($table == 'waterpoint_verification') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = $type . ' deleted from ' . $descrip . ' program';
        } else if ($table == 'site_verification') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'program name is ' . $descrip;
        } else {
            $description = ' unknown ';
        }

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }

    public function insertLogDataMessage($table, $data, $type) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = $type . ' Message Sent';
        if ($table == 'lsm_details') {
            $query = 'SELECT admin_territory_name FROM admin_territory_details WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['admin_territory_name'];
            $description = ' Sent to Officials of ' . $descrip;
        } else {
            $description = ' unknown ';
        }

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }

    public function insertLogVerfication($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'site_v_schedule') {
            $description = 'waterpoint verification added for ' . $data . ' program';
        } else if ($table == 'verification_track') {
            $description = $data['waterpoint_name'] . ' waterpoint added for ' . $data['program'] . ' program';
        } else if ($table == 'vcs_schedule') {
            $description = 'program added is ' . $data;
        } else if ($table == 'vcs_meeting') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'officials added to ' . $descrip.' program';
        } else if ($table == 'vcs_meetings_tracker') {
            $description = 'verification details added to ' . $data.' program';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }

    public function insertLogVerficationOnEdit($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        if ($table == 'verification_track') {
            $description = 'waterpoint verification edited for ' . $data['program'] . ' program';
        } else if ($table == 'site_v_schedule') {
            $description = 'waterpoint verification edited for ' . $data . ' program';
        } else if ($table == 'vcs_schedule') {
            $description = 'program edited is ' . $data;
        } else if ($table == 'vcs_meetings_tracker') {
            $description = 'verification details edited to ' . $data.' program';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }

    public function insertLogVerficationOnDelet($table, $data, $all) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';
        if ($table == 'site_v_schedule') {
            $description = 'waterpoint village deleted for ' . $data . ' program';
            if ($all == 'all') {
                $description = 'entier table emptied';
            }
        } else if ($table == 'verification_track') {
            $description = 'waterpoint verification deleted for ' . $data . ' program';
        } else if ($table == 'vcs_schedule') {
            $query = 'SELECT program FROM vcs_schedule WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'program deleted is ' . $descrip;
        } else if ($table == 'vcs_meeting') {
            $query = 'SELECT program FROM dsw_programs WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'officials deleted to ' . $descrip.' pogram';
        } else if ($table == 'vcs_meetings_tracker') {
            $query = 'SELECT program FROM vcs_meetings_tracker WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'verification details deleted to ' . $descrip.' program';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        if($table!='swf'){
        $this->insertdDB('process_log_record', $insertData);
        }
    }
    
    public function insertLogDispenser($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'dispenser_installation_schedule') {
            $description = 'program added is ' . $data;
        } else if ($table == 'dispenser_material') {
            $description = 'program added to is ' . $data;
        } else if ($table == 'tracking_installed_dispensers') {
            $description = 'program added is ' . $data;
        } else if ($table == 'dispenser_installation_field_officers') {
            $description = 'official(s) added ' ;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }
    
    public function insertLogDispenserOnEdit($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        if ($table == 'dispenser_installation_schedule') {
            $description = 'program edited is ' . $data;
        } else if ($table == 'dispenser_material') {
            $description = 'program added is ' . $data;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }
    
    public function insertLogDispenserOnDelet($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';
        if ($table == 'dispenser_installation_schedule') {
            $query = 'SELECT program FROM dispenser_installation_schedule WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'program deleted is ' . $descrip;
        } else if ($table == 'dispenser_material') {
            $query = 'SELECT program FROM dispenser_material WHERE id = ' . $data . '';
            $descrip = $this->selectDBraw($query)[0]['program'];
            $description = 'program deleted from is ' . $descrip;
        } else if ($table == 'dispenser_installation_field_officers') {
            $description = 'official(s) deleted ' ;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        if($table!='swf'){
        $this->insertdDB('process_log_record', $insertData);
        }
    }
    
    public function insertLogOnPromoterCall($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'promoter_call_log') {
            $description = 'call made for waterpoint ID: ' . $data;
        } else if ($table == 'promoter_sms_log') {
            $description = 'sms sent for waterpoint ID: ' . $data;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }
    
    public function insertLogIssues($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        if ($table == 'promoter_call_log') {
            $description = 'call made for waterpoint ID: ' . $data;
        } else if ($table == 'promoter_sms_log') {
            $description = 'sms sent for waterpoint ID: ' . $data;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('process_log_record', $insertData);
    }
    
    public function insertLogIssuesTracker($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'recorded added on '.ucwords(str_replace('_', ' ', $table)) . ' table';
        if ($table == 'issues') {
            $description = 'waterpoint ID: ' . $data. ' added';
        } else if ($table == 'issue_message_templates') {
            $description = 'message template: ' . $data. ' added';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('issue_tracker_log_record', $insertData);
    }
    
    public function insertLogIssuesTrackerApprove($table, $data, $state) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'recorded edited on '.ucwords(str_replace('_', ' ', $table)) . ' table';
        if ($table == 'issues') {
            $description = 'issue ID: ' . $data. ' '. $state;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('issue_tracker_log_record', $insertData);
    }
    
    public function insertLogIssuesTrackerEdit($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'recorded edited on '.ucwords(str_replace('_', ' ', $table)) . ' table';
        if ($table == 'issues') {
            $description = 'waterpoint ID: ' . $data. ' edited';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('issue_tracker_log_record', $insertData);
    }
    
    public function insertLogIssuesTrackerCommunication($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        
        if ($table == 'comm_sms') {
            $action = 'Sms sent';
            $description = 'recipient number: ' . $data;
        } else if ($table == 'comm_emails') {
            $action = 'Email sent';
            $description = 'recipient email ' . $data;
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('issue_tracker_log_record', $insertData);
    }
    
    public function insertLogIssuesTrackerDelet($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'recorded deleted on '.ucwords(str_replace('_', ' ', $table)) . ' table';
        if ($table == 'issues') {
            $description = 'issue ID: ' . $data. ' deleted';
        } else if ($table == 'issue_message_templates') {
            $description = 'no description';
        } else {
            $description = ' unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('issue_tracker_log_record', $insertData);
    }

}

?>