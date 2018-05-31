<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class processdata extends Controller {

    public $model;

    public function index() {
        require 'application/views/_templates/header.php';
        require 'application/views/process/index.php';
         require 'application/views/_templates/footer.php';
    }
    public function viewFlagged(){
      
        date_default_timezone_set("Africa/Nairobi");
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $table="promoter_details";
         $fieldsArray = array('id', 'country', 'program' ,'waterpoint_id', 'promoter_name', 'promoter_gender','promoter_contact', 'promoter_language','assistant_promoter_name','assistant_promoter_gender','assistant_promoter_contact','assistant_promoter_language');
        
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $generaldata_model = $this->loadModel('processmodel');
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
        $lastMonthToday = time() - (30 * 24 * 60 * 60);
        $flagged="Flagged Waterpoints";
        $progDropDown=$generaldata_model->getProgramDropDown();
          
        if(isset($_POST['program'])){
         $data = $generaldata_model->getFlaggedPromoterData($table,$fieldsArray,$_POST['program']);
        }
         $fields = $generaldata_model->getFields($table, $fieldsArray);
         $noWaterpoints = $generaldata_model->getWaterpointData($lastMonthToday);
         require 'application/views/process/promoter/promoter.php';
         require 'application/views/_templates/footer.php';
    }

    public function promoter($table = "promoter_details") {
        
        date_default_timezone_set("Africa/Nairobi");
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $tableCategory = $table;
        $fieldsArray = array('id', 'country', 'program' ,'waterpoint_id', 'promoter_name', 'promoter_gender','promoter_contact', 'promoter_language','assistant_promoter_name','assistant_promoter_gender','assistant_promoter_contact','assistant_promoter_language');
      
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $generaldata_model = $this->loadModel('processmodel');
        $progDropDown = $generaldata_model->getProgramDropDown();
          
        if(isset($_POST['program'])){
          $uncheckedData = $generaldata_model->getPromoterData($table,$fieldsArray,$_POST['program']);
          $data=$this->AddWaterpoint($uncheckedData);
        }
        
        $fields = $generaldata_model->getFields($table, $fieldsArray);
     
     // The Following Code is for determining the last 30 days to assist flag All Waterpoints Without Contact over the 
       //     Past month
        $lastMonthToday = time() - (30 * 24 * 60 * 60);
      
       // $lastMonthToday;
        //now We need To Query Through All The Waterpoints recorded With the Promoters that have no logs over the Past Month    
        $noWaterpoints = $generaldata_model->getWaterpointData($lastMonthToday);
            
            
     require 'application/views/process/promoter/promoter.php';
     require 'application/views/_templates/footer.php';
    }

  
    public function AddWaterpoint($datasource){
        $processmodel = $this->loadModel('processmodel');
        $data=array();
        foreach ($datasource as $key => $value) {
            
            $waterpointName=$processmodel->getWaterpointName($value['waterpoint_id']);
           
            if(!empty($waterpointName)){
                $datasource[$key]["waterpoint_name"]=$waterpointName[0]['waterpoint_name'];
            }else{
                $datasource[$key]["waterpoint_name"]="<i style='color:rgb(255,0,0);'>Waterpoint Not Found</i>";
            }

        }

        return $datasource;
    }
    public function fieldsArray($table) {
           switch ($table) {

                  case 'promoter_details':
                     $fieldsArray = array('id', 'country', 'program','waterpoint_id', 'promoter_name', 'promoter_gender','promoter_contact', 'promoter_language','assistant_promoter_name','assistant_promoter_gender','assistant_promoter_contact','assistant_promoter_language');
                     break;
           
                case 'chlorine_inventory':
                    return $fieldsArray =array('id','country', 'inventory_id', 'item', 'description', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received', 'expiry_date');
                    break;

                case 'chlorine_other_inventory':
                    return $fieldsArray =array('id', 'inventory_id', 'item', 'description', 'inventory_condition', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'date_received');
                    break;
               
                case "promoter_call_log":
                   return $fieldsArray =array('id', 'date', 'promoter_id', 'promoter_name', 'promoter_contact','call_to_or_from', 'message', 'issue_name', 'created_by');
                    break;
               
             
                case "dispenser_installation_schedule":
                    return $fieldsArray = array('id','country', 'program','no_of_field_officers','no_of_installations_per_day','total_no_of_installations','total_no_of_vehicles','total_no_of_field_officers_assigned_vehicles','start_date','vehicle_cost_per_day','field_officer_allowance');
                   break;

                 default:
                 $fieldsArray =null;
                break;
    
            }
    }
    public function update($table, $edit = false) {
        // load the model
        $this->model = $this->loadModel('processmodel');

        //update table
        if (isset($_POST['update'])) {

            $this->model->updateData($_POST, $_POST['id'], $table);

            // redirect after update
            header('location: ' . URL . 'processdata/promoter/');
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
        if($table=='program_setup' || $table=='message_templates'){
        require 'application/views/process/expansion/editSettings.php';
        }else{
        require 'application/views/process/promoter/editpromoterlog.php';
        }
        require 'application/views/_templates/footer.php';
    }
 
    public function performCalllog($table, $promoterId) {
        // load the model
        $generaldata_model=$this->model = $this->loadModel('processmodel');
        $logs_model= $this->loadModel('logsmodel');
       
       
        //update table
        if (isset($_POST['add-callLog-data'])) {
            $dd = $generaldata_model->addData('promoter_call_log', $_POST);
//            $logs_model->insertLogOnPromoterCall('promoter_call_log', $_POST);
            // redirect after update
            $timeStampToday=time();
            //Update the timestamp column in promoter_details(It acts as last date Modified which is
            // used to flag waterpoints that have not been contacted in 30 days
           $query="update promoter_details set unix_timestamp=".$timeStampToday." WHERE id=".$_POST['promoter_id'];
            $result=$generaldata_model->runRawQuery($query);
            if($_POST["issue_type"]==1 || $_POST["issue_type"]==2){ 
                header('location: ' . URL . 'processdata/promoter/');
            }else{
                
                 header('location: ' . URL . 'issuetracker/tracker/'.$_POST["caller"].'/'.  urlencode($_POST["message"]).'/'.  urlencode($_POST["last_call_date"]).'/'. urlencode($_POST["waterpoint_id"]));
            }
            
            
        }
     

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        //THIS WILL LOAD THE PROMOTER INFO ON THE call log FILE AS IT GENERATES
         $data=$this->model->getByID($promoterId);
         
       // echo '<pre>';
       // print_r($data);
       // echo '</pre>';
       
        $promoter_name=$data[0]["promoter_name"];
        $promoter_contact=$data[0]["promoter_contact"];
        $promoterId=$data[0]["id"];
        $waterpointId=$data[0]["waterpoint_id"];
        
         
        //Calling the call_log table fields. The Promoter information is in the three variables above
        $fields = $this->model->getFields($table);
        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
       
       
        require 'application/views/process/promoter/call_log.php';
        require 'application/views/_templates/footer.php';
    }
    public function callupdate($table, $promoterId){

       $generaldata_model=$this->model = $this->loadModel('processmodel');
       $logs_model = $this->loadModel('logsmodel');
       $data=$this->model->getByID($promoterId);
         
       
        //update table
        if (isset($_POST['add-callLog-data'])) {
          
            if(strtolower($_POST['call_to_or_from'])=="main promoter"){
                $_POST['promoter_name']=$data[0]["promoter_name"];
                $_POST['promoter_contact']=$data[0]["promoter_contact"];
            }else{
                $_POST['promoter_name']=$data[0]["assistant_promoter_name"];
                $_POST['promoter_contact']=$data[0]["assistant_promoter_contact"]; 
            }

            $dd = $generaldata_model->addData('promoter_call_log', $_POST);
            $logs_model->insertLogOnPromoterCall('promoter_call_log', $_POST['waterpoint_id']);
            // redirect after update
            $timeStampToday=time();
            //Update the timestamp column in promoter_details(It acts as last date Modified which is
            // used to flag waterpoints that have not been contacted in 30 days
           $query="update promoter_details set unix_timestamp=".$timeStampToday." WHERE id=".$_POST['promoter_id'];
            $result=$generaldata_model->runRawQuery($query);
            if($_POST["issue_type"]==1 || $_POST["issue_type"]==2){ 
                header('location: ' . URL . 'processdata/promoter/');
            }else{
                
                 header('location: ' . URL . 'issuetracker/tracker/'.$_POST["caller"].'/'.  urlencode($_POST["message"]).'/'.  urlencode($_POST["last_call_date"]).'/'. urlencode($_POST["waterpoint_id"]));
            }
            
            
        }
     

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        //THIS WILL LOAD THE PROMOTER INFO ON THE call log FILE AS IT GENERATES
            //Calling the call_log table fields. The Promoter information is in the three variables above
         $promoterId=$data[0]["id"];
        $waterpointId=$data[0]["waterpoint_id"];
        $fields = $this->model->getFields($table);
       
   
         // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
       
        require 'application/views/process/promoter/call_log.php';
        require 'application/views/_templates/footer.php';

    }
    public function smsupdate($table, $promoterId) {
        // load the model
        $generaldata_model=$this->model = $this->loadModel('processmodel');
        $logs_model= $this->loadModel('logsmodel');
         $data=$this->model->getByID($promoterId);
           
             if (isset($_POST['add-sms-data'])) {

             if(strtolower($_POST['call_to_or_from'])=="main promoter"){
                $_POST['promoter_name']=$data[0]["promoter_name"];
                $_POST['promoter_contact']=$data[0]["promoter_contact"];
                $recipients=$data[0]["promoter_contact"];
               // $recipients='+254719726507';
            }else{
                $_POST['promoter_name']=$data[0]["assistant_promoter_name"];
                $_POST['promoter_contact']=$data[0]["assistant_promoter_contact"]; 
                $recipients=$data[0]["assistant_promoter_contact"];
               // $recipients='+254719726507'; 
            }
          
            $dd = $generaldata_model->addData('promoter_sms_log', $_POST);
            $logs_model->insertLogOnPromoterCall('promoter_sms_log', $_POST['waterpoint_id']);
            // redirect after update
          $timeStampToday=time();
            //Update the timestamp column in promoter_details(It acts as last date Modified which is
            // used to flag waterpoints that have not been contacted in 30 days
           $query="update promoter_details set unix_timestamp=".$timeStampToday." WHERE id=".$_POST['promoter_id'];
          
           $result=$generaldata_model->runRawQuery($query);
            
               require_once('application/views/process/promoter/AfricasTalkingGateway.php');
            $username = "beanco";
            $apiKey = "7e264ef92d19ffd294f8bdafa5f126c7193c4bfd5bf5a9fb2151d605b5079fa4";
       
            //$recipients = $_POST["promoter_contact"];
            
            $message = $_POST["message"];
            $gateway = new AfricaStalkingGateway($username, $apiKey);
            $send_sms_feedback = $gateway->sendMessage($recipients, $message);

                 if($_POST["issue_type"]==1 || $_POST["issue_type"]==2){ 
                header('location: ' . URL . 'processdata/promoter/');
            }else{
                header('location: ' . URL . 'issuetracker/tracker/'.$_POST["caller"].'/'.  urlencode($_POST["message"]).'/'.  urlencode($_POST["last_call_date"]).'/'.  urlencode($_POST["waterpoint_id"]));
            }
            
        }
       

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        //THIS WILL LOAD THE PROMOTER INFO ON THE call log FILE AS IT GENERATES
        
        $promoterId=$data[0]["id"];
        $waterpointId=$data[0]["waterpoint_id"];
         
        //Calling the call_log table fields. The Promoter information is in the three variables above
        $fields = $this->model->getFields($table);
        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
       
        $issue_model = $this->loadModel('issuetrackermodel');
     
       
        require 'application/views/process/promoter/sms_log.php';
        require 'application/views/_templates/footer.php';
    }
    public function viewLogs($table="promoter_call_log"){
        
        require 'application/views/_templates/header.php'; //Because of the country session to filter data;
        
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $generaldata_model = $this->loadModel('processmodel');
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
         $fields = $generaldata_model->getFields($table);
       
        $fieldsArray=array('id','waterpoint_id','promoter_name','promoter_contact','call_to_or_from','last_call','caller','position','last_call_date','message');
        $data = $generaldata_model->getLogData($table,$fieldsArray);
        require 'application/views/process/promoter/viewLogs.php';
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

    public function add($table,$category) {

        if(isset($_POST)){

          
            $generaldata_model = $this->loadModel('processmodel');
            $dd = $generaldata_model->addData($table, $_POST);
          
            if (isset($_POST["add-process-data"])) {
              header('location: ' . URL . 'processdata/promoter/' . $table . '');
            }else{
              header('location: ' . URL . 'processdata/');
            }
        }
    }
    public function delete($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->deleteData($table, $id);
        }
        header('location: ' . URL . 'processdata/promoter/' . $table . '');
    }
   
    public function contacttype() {

        if (isset($_POST["add-sendSms-data"])) {
            $table = "comm_sms";
            require_once('application/views/process/promoter/AfricasTalkingGateway.php');
            $username = "beanco";
            $apiKey = "7e264ef92d19ffd294f8bdafa5f126c7193c4bfd5bf5a9fb2151d605b5079fa4";
            // $username = "Cubemovers";
            // $apiKey = "bf84a2f1c0026af8dca58a08da84d7d838cb366c7305663f895df136eac4b0f5";

            $recipients = $_POST["recipient_number"];
            $message = $_POST["sms_body"];
            $gateway = new AfricaStalkingGateway($username, $apiKey);
            $send_sms_feedback = $gateway->sendMessage($recipients, $message);


            $generaldata_model = $this->loadModel('issuetrackermodel');
            $generaldata_model->addData($table, $_POST);
            // $send_sms_feedback;

            header('location: ' . URL . 'processdata/promoter/');
        }
    }
    public function promoteredit() {
        require 'application/views/_templates/header.php';
        require 'application/views/general/editpromoterlog.php';
        require 'application/views/_templates/footer.php';
    }
    public function expansionIndex(){
        require 'application/views/_templates/header.php';
        require 'application/views/process/expansion/index.php';
        require 'application/views/_templates/footer.php';
    }



 
}

// end class
?>