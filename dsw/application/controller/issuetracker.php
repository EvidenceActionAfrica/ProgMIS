<?php

class issuetracker extends Controller {

    public $model;

    public function index() {
        header('location: ' . URL . 'issuetracker/tracker');
    }

    /**
     * The Issue Tracker Is Primarily used by the Promoter thus you see promoterId & message as the parameters.
     * With The other users these parameters are automatically null.
     * The Parameters are used to fill in 
     * @param type $created_by:The AAc/CSA/Staff Who is currently logged in
     * @param type $message:Their Remarks saved in the Call/Sms logs
     * @param type $activeDate:The Date Selected In the Call log/Sms Log
     * @param type $waterpoint:The Current Waterpoint With issue
     */
    public function tracker($created_by = null, $message = null, $activeDate = null, $waterpoint = null) {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        $table = "issues";

        switch ($table) {
            case 'issues_category':
                $fieldsArray = null;

                break;
            case 'issues':
                $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');
                $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'date_created', 'issue_remarks', 'issue_status');

                break;

            default:
                $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks');
                $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'category', 'date_created', 'issue_remarks');
                break;
        }

        $tableName = ucwords(str_replace("_", " ", $table));
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $data = $generaldata_model->getData("issues", $fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray2);

        if (isset($created_by)) {

            $created_by = $_SESSION["full_name"];
            $message = urldecode($message);
            $activeDate = urldecode($activeDate);
            $waterpoint = urldecode($waterpoint);
        }
        $issueState = "All Pending";


        //Drop Downs

        $staffDropDown = $generaldata_model->getStaffDropDown();
        $smsDropDown = $generaldata_model->getSmsDropDown();
        $categoryDropDown = $generaldata_model->getCategoryDropDown();
        $officeLocationDropDown = $generaldata_model->getOfficeLocationDropDown();
        $issueStatus = $generaldata_model->getIssueStatusDropDown();
        if (isset($_GET['handled_by'])) {
            $recepientDetails = $generaldata_model->getStaffInfo($_GET['handled_by']);
            $recepientNumber = '+' . $recepientDetails[0]["phone"];
            $recepientEmail = $recepientDetails[0]["email"];
        } else {
            $recepientNumber = null;
            $recepientEmail = null;
        }

        // $fields=array('id','country','district','county','subject','description','raisedby','handledby','status');
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/issuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function completelyApproved() {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        $table = "issues";

        $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');
        $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'category', 'date_created', 'issue_remarks', 'issue_status', 'completed_by');


        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('issuetrackermodel');

        $data = $generaldata_model->getCompleted("issues", $fieldsArray);
        $issueState = "Completed ";

        $fields = $generaldata_model->getFields($table, $fieldsArray2);
        $staffDropDown = $generaldata_model->getStaffDropDown();
        $smsDropDown = $generaldata_model->getSmsDropDown();
        $categoryDropDown = $generaldata_model->getCategoryDropDown();
        $officeLocationDropDown = $generaldata_model->getOfficeLocationDropDown();

        // $fields=array('id','country','district','county','subject','description','raisedby','handledby','status');
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/issuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function complete($issueId, $complete = 0) {

        $generaldata_model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');

        //Update The Status Of The Issue:Normally Set By AC/AAC

        $query = 'update issues set complete=' . $complete . ',completed_by="' . $_SESSION["full_name"] . '",approved="YES" WHERE id=' . $issueId;        
        $generaldata_model->runRawQuery($query);

        if ($complete == 1) {
            $logs_model->insertLogIssuesTrackerApprove('issues', $issueId,'approved');
            header('location: ' . URL . 'issuetracker/completelyApproved/');
        } else {
//            $logs_model->insertLogIssuesTrackerApprove('issues', $issueId,'disapproved');
            header('location: ' . URL . 'issuetracker/viewApproved/Yes');
        }
    }

    public function viewApproved($approved = "No", $status = null) {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        $table = "issues";

        $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');


        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('issuetrackermodel');


        if ($approved == "Yes") {
            $issueState = "Approved ";
            $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'date_created', 'issue_remarks', 'issue_status', 'approved_by');
        } else if ($approved == "redo") {
            $issueState = "Disapproved ";
            $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'date_created', 'issue_remarks', 'issue_status', 'disapproved_by');
        } else if ($approved == "No" && $status == 2) {
            $issueState = "Resolved & Unapproved";
            $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'date_created', 'issue_remarks', 'issue_status');
        } else {
            $issueState = "Pending";
            $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'date_created', 'issue_remarks', 'issue_status');
        }

        $staffDropDown = $generaldata_model->getStaffDropDown();
        $smsDropDown = $generaldata_model->getSmsDropDown();
        $categoryDropDown = $generaldata_model->getCategoryDropDown();
        $officeLocationDropDown = $generaldata_model->getOfficeLocationDropDown();
        $issueStatus = $generaldata_model->getIssueStatusDropDown();

        $data = $generaldata_model->getApprovedData("issues", $fieldsArray, $approved, $status);
        $fields = $generaldata_model->getFields($table, $fieldsArray2);
        
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/issuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function disapproved($approved = "redo") {

        $generaldata_model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');

        //Update The 'approved' Of The Issue:Normally Set By AC/AAC

        if (isset($_POST["disapprove-issue"])) {
            $query = 'update issues set approved="No"' .
                    ',disapproved_by="' . $_POST["disapproved_by"]
                    . '",solution="' . $_POST["solution"]
                    . '",reason_disapproved="' . $_POST["reason_disapproved"]
                    . '",previously_assigned=full_name'
                    . ',full_name=' . $_POST["reassigned_to"]
                    . ',complete=""'
                    . ',issue_status=1 '
                    . ' WHERE id=' . $_POST["id"];

            $generaldata_model->runRawQuery($query);
            $logs_model->insertLogIssuesTrackerApprove('issues', $_POST["id"],'disapproved');
        }

        header('location: ' . URL . 'issuetracker/viewApproved/No/1');
    }

    public function updateApproval($issueId, $approved) {

        $generaldata_model = $this->loadModel('issuetrackermodel');

        //Update The Status Of The Issue:Normally Set By AC/AAC


        $query = 'update issues set approved="' . $approved . '",approved_by="' . $_SESSION["full_name"] . '" WHERE id=' . $issueId;

        $generaldata_model->runRawQuery($query);

        if ($approved != "Yes") {
            header('location: ' . URL . 'issuetracker/viewApproved/No');
        } else {
            header('location: ' . URL . 'issuetracker/viewApproved/Yes');
        }
    }

    public function viewCat($table = "issues_category") {
        date_default_timezone_set("Africa/Nairobi");

        require 'application/views/_templates/header.php';

        switch ($table) {
            case 'issues_category':
                $fieldsArray = null;
                $fieldsArray2 = null;

                break;
            case 'issues':
                //    $fieldsArray2 = array('id', 'timestamp', 'country', 'county', 'district', 'division', 'issue_category', 'subject', 'description', 'raisedby', 'full_name', 'actionstaken', 'status');
                //   $fieldsArray = array('id', 'country', 'district', 'county', 'subject', 'description', 'raisedby', 'status');
                $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');
                $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');

                break;

            default:
                $fieldsArray2 = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks');
                $fieldsArray = array('id', 'country', 'waterpoint_id', 'office_location', 'full_name', 'category', 'sub_category', 'date_created', 'issue_remarks');
                break;
        }

        $tableName = ucwords(str_replace("_", " ", $table));

        $generaldata_model = $this->loadModel('issuetrackermodel');

        $data = $generaldata_model->getCategoryData($table);


        $fields = $generaldata_model->getFields($table, $fieldsArray2);
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/issuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function edittracker($edit = false) {
        date_default_timezone_set("Africa/Nairobi");
        require 'application/views/_templates/header.php';

        $table = "issues";
        $tableName = ucwords(str_replace("_", " ", $table));

        $fieldsArray = array('id', 'country', 'office_location', 'waterpoint_id', 'full_name', 'raised_by', 'category', 'sub_category', 'date_created', 'issue_remarks', 'issue_status');

        $generaldata_model = $this->loadModel('issuetrackermodel');
        $data = $generaldata_model->getData($table, $fieldsArray);

        //if edit
        // if edit
        if ($edit != false) {
            $this->model = $generaldata_model;
            $single_record = $this->model->getByPK($edit, $fieldsArray);

            //do some cleaning 
            // its assiciative
            // make it serial
            $single_record = $single_record[0];
            $i = 0;
            foreach ($single_record as $key => $value) {
                unset($single_record[$key]);
                $single_record[$i] = $value;
                $i++;
            }

            // echo "<pre>";var_dump($single_record);echo "</pre>";
            // exit();
        }

        $fields = $generaldata_model->getFields($table, $fieldsArray);
        $staffDropDown = $generaldata_model->getStaffDropDown();
        $smsDropDown = $generaldata_model->getSmsDropDown();
        $categoryDropDown = $generaldata_model->getCategoryDropDown();
        $officeLocationDropDown = $generaldata_model->getOfficeLocationDropDown();

        // $fields=array('id','country','district','county','subject','description','raisedby','handledby','status');

        require 'application/views/issuetracker/editissuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function issuesaction($dataId) {
        require 'application/views/_templates/header.php';
        $table = "issues_actions";
        $tableName = str_replace("_", " ", "Log Action(s) Taken");
        $tableName = ucwords($tableName);
        $fieldsArray = array('issue_id', 'country', 'action_taken', 'staff', 'timeframe', 'response', 'issue_status');

        $generaldata_model = $this->loadModel('issuetrackermodel');
        $data = $generaldata_model->getSpecificData($table, $fieldsArray, $dataId);
        $fields = $generaldata_model->getFields($table);
        $staffDropDown = $generaldata_model->getStaffDropDown();
        $smsDropDown = $generaldata_model->getSmsDropDown();
        $categoryDropDown = $generaldata_model->getCategoryDropDown();
        $officeLocationDropDown = $generaldata_model->getOfficeLocationDropDown();

        $issueId = $dataId;
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/issuetracker.php';
        require 'application/views/_templates/footer.php';
    }

    public function contacttype() {
        //      require 'application/views/_templates/header.php';


        require 'application/views/_templates/email/class.phpmailer.php';

        if (isset($_POST["add-sendSms-data"])) {

            $table = "comm_sms";
           
            require 'application/libs/app.php';
            $message = new SMSRequest();
            //$message->senderAddress = 'EVIDENCE_ACTION';
            $message->senderAddress = 21036;
            $message->address =$_POST["recipient_number"];
           // $message->message ='start';
            $message->message =$_POST["sms_body"];
            $smsClient = new SmsClient(USERNAME, PASSWORD);
            $result = $smsClient->sendSMS($message);


            $issueStatus = $_POST['issue_status'];
            unset($_POST['issue_status']);
            $generaldata_model = $this->loadModel('issuetrackermodel');
            $logs_model = $this->loadModel('logsmodel');
            $generaldata_model->addData($table, $_POST);
            $logs_model->insertLogIssuesTrackerCommunication($table, $_POST["recipient_number"]);
            unset($_POST);
            $_POST["issue_status"] = $issueStatus;
            $_POST['id'] = $_GET['id'];

            $dd = $generaldata_model->updateDB("issues", $_POST, $_POST['id']);

            if ($issueStatus > 2) {
                $issueStatus = 2;
            }
            header('location: ' . URL . 'issuetracker/viewApproved/No/' . $issueStatus);
        }

        if (isset($_POST["add-sendMail-data"])) {

            $sender = $_POST['sender'];
            $recipient_name = $_POST['recipient_name'];
            $recipient_email = $_POST['recipient_email'];
            $subject = $_POST['subject'];
            $email_body = $_POST['email_body'];

            //Clean Data
            $sender = addslashes(trim($sender));
            $recipient_name = addslashes(trim($recipient_name));
            $recipient_email = addslashes(trim($recipient_email));
            $subject = addslashes(trim($subject));
            $email_body = addslashes(trim($email_body));

            //log entry
            $staff_email = $_SESSION['email'];
            $table = "comm_emails";
            $full_name = $_SESSION['full_name'];

            $issueStatus = $_POST['issue_status'];
            unset($_POST['issue_status']);

            $generaldata_model = $this->loadModel('issuetrackermodel');
            $logs_model = $this->loadModel('logsmodel');
            $generaldata_model->addData($table, $_POST);
            $logs_model->insertLogIssuesTrackerCommunication($table, $_POST["recipient_email"]);


            unset($_POST);
            $_POST["issue_status"] = $issueStatus;
            $_POST['id'] = $_GET['email'];
            $dd = $generaldata_model->updateDB("issues", $_POST, $_POST['id']);

            //send Email to client ============================================

            try {
                $mail = new PHPMailer(true); //New instance, with exceptions enabled
                $mail->IsSendmail();  // tell the class to use Sendmail
                $mail->AddReplyTo($staff_email, $full_name);
                $mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
                $mail->FromName = $full_name; //"Evidence Action";
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

        if ($issueStatus > 2) {
            $issueStatus = 2;
        }
        header('location: ' . URL . 'issuetracker/viewApproved/No/' . $issueStatus);
    }

    public function add($table = "issues") {
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        //Check if waterpoint id exists

        if (isset($_POST["add-issues-data"])) {

            if ($table == "issues_actions") {
                $query = "update issues set approved='No',issue_status=" . $_POST["issue_status"] . " WHERE id='" . $_POST["issue_id"] . "'";

                $generaldata_model->runRawQuery($query);
            }

            if ($table == 'issues') {
                $waterpointArr = $generaldata_model->checkWaterpointId($_POST['waterpoint_id']);
                $waterpointCheck = $waterpointArr[0]['exist'];
                $waterpointCheckCountry = $waterpointArr[0]['country'];
                if ($waterpointCheck == 1) {
                    if ($waterpointCheckCountry == $_SESSION["country"]) {
                    $generaldata_model->addData($table, $_POST);
                    $logs_model->insertLogIssuesTracker($table, $_POST['waterpoint_id']);
                    $message = 'Issue  Saved.';
                    }else{
                      $message = 'Error, This Waterpoint Id does not Exist in this country. Issue Not Saved.';  
                    }
                } else if (isset($_POST["add-issues-data"]) && $waterpointCheck > 1) {
                    $message = 'Error.This Waterpoint Id Is Not Unique.Issue Not Saved.';
                } else if (isset($_POST["add-issues-data"]) && $waterpointCheck == 0) {
                    $message = 'Error.This Waterpoint Id does not Exist.Issue Not Saved.';
                }
            } else {
                $generaldata_model->addData($table, $_POST);
                $message = 'Issue  Saved.';
            }
        }

        // where to go after add
        header('location: ' . URL . 'issuetracker/tracker/?message=' . urlencode($message));
    }

    public function update($table) {        
        $adminData_model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        // give post data, post ID and table name
        $logs_model->insertLogIssuesTrackerEdit($table, $_POST['waterpoint_id']);
        $dd = $adminData_model->updateData($_POST, $_POST['id'], $table);
        // where to go after edit
        header('location: ' . URL . 'issuetracker/tracker');
    }

    public function delete($table, $id) {
        
        $this->model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        if (isset($id)) {
            $logs_model->insertLogIssuesTrackerDelet($table, $id);
            $this->model->deleteData($table, $id);
        }

        header('location: ' . URL . 'issuetracker/tracker');
    }
    
    public function message_template ($table) {
        require 'application/views/_templates/header.php';       
        $fieldsArray = array('id', 'template_name', 'message');
        $tableName = ucwords(str_replace("_", " ", $table));
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $data = $generaldata_model->getData2($table, $fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        
        
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/message_template.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function messageAdd($table) {
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        //Check if waterpoint id exists

        if (isset($_POST["add_issue"])) {
                    $generaldata_model->addData($table, $_POST);
                    $logs_model->insertLogIssuesTracker($table, $_POST['template_name']);
                    $message = 'Record  Saved.';                
        }
        require 'application/views/_templates/header.php';       
        $fieldsArray = array('id', 'template_name', 'message');
        $tableName = ucwords(str_replace("_", " ", $table));
        $data = $generaldata_model->getData2($table, $fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray);        
        
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/message_template.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function messageDelet($table, $id) {
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $this->model = $this->loadModel('issuetrackermodel');
        $logs_model = $this->loadModel('logsmodel');
        if (isset($id)) {
            $logs_model->insertLogIssuesTrackerDelet($table, $id);
            $this->model->deleteData($table, $id);
            $message = 'Record  Deleted.';  
        }

        require 'application/views/_templates/header.php';       
        $fieldsArray = array('id', 'template_name', 'message');
        $tableName = ucwords(str_replace("_", " ", $table));
        $data = $generaldata_model->getData2($table, $fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray);        
        
        require 'application/views/issuetracker/sidebar.php';
        require 'application/views/issuetracker/message_template.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * This Method is used by Jquery Load method in DSW To Load data from the Db to a specific element
     * Without Loading Page
     * @param type $table Contains the data needed
     * @param type $field The column being referenced
     * @param type $criteria what column to filter the data
     * @param type $value the value that should be in that column filtering
     */
    public function ajax_call($table, $field, $criteria, $value) {

        $generaldata_model = $this->loadModel('issuetrackermodel');
        //echo $value;

        $value = isset($_GET['cat']) ? $_GET['cat'] : $value; //$_GET['cat'] contains variables with possible issues and should be manually defined if such a possibility occurs

        $query = 'SELECT id,' . $field . ' from ' . $table . ' WHERE ' . $criteria . ' like "%' . $value . '%"';
        // echo  $query;
        $data = $generaldata_model->runRawQuery($query);
        if ($data == null && strlen($value) > 5) {

            // $value=substr($value,$counter,+($limit-$counter));
            $query = 'SELECT id,' . $field . ' from ' . $table . ' WHERE  trim(' . $criteria . ')= "' . $value . '"';
            //  echo $query;
            $data = $generaldata_model->runRawQuery($query);
        }
        echo $data = json_encode($data);
    }

    /*
      For Sms and Email
     */

    public function ajax_staff_details($required) {

        $info = $_GET['info'];
        $generaldata_model = $this->loadModel('issuetrackermodel');

        $query = 'SELECT phone,email from staff_list WHERE  full_name like"%' . $info . '%"';
        $data = $generaldata_model->runRawQuery($query);

        echo $data = json_encode($data);
    }   
    
    public function ajax_sms_details($required) {

        $info = $_GET['info'];
        $generaldata_model = $this->loadModel('issuetrackermodel');
        $query = 'SELECT message from issue_message_templates WHERE template_name like"%' . $info . '%"';
        $data = $generaldata_model->runRawQuery($query);

        echo $data = json_encode($data);
    }

    /**
     * Description : export to CSV.
     *
     * @param int $inventory_type 
     */
    public function export($table) {
        // load the model
        $this->model = $this->loadModel('issuetrackermodel');

        // get the fields array
        $fieldsArray = $this->fieldsArray($table);

        //start the session because the method getData() 
        //needs the country session in the query
        session_start();
        // perform the query
        $sheet = $this->model->getData($table, $fieldsArray);

        // get the inventory name
        $csv_name = str_replace("_", " ", $table);
        $csv_name = ucwords($csv_name);


        $this->model = $this->loadModel('csvmodel');

        // create the header.
        $header = $this->model->replace_upper($fieldsArray);

        // send these data to export model
        $this->model->export($sheet, $header, $csv_name);
    }

}

?>