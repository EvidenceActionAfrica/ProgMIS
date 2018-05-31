<?php

class generalclass extends Controller {

    public $model;

    public function fieldsArray($table) {

        switch ($table) {
            case 'hidden_waterpoint_details':
                  return $fieldsArray = array('id','program', 'waterpoint_name', 'waterpoint_id', 'verification_id','active','village', 'number_of_hhs', 'water_source_type', 'land_owner_name', 'land_owner_contact','nearest_boma','boma_contact','activities','activity_days','nearest_mama','mama_contact','neighbor_name','neighbor_contact','installation_date', 'notes', 'latitude', 'longitude');
                //return $fieldsArray = array('id', 'program', 'waterpoint_name', 'waterpoint_id', 'verification_id', 'active');

            case 'village_details':
                return $fieldsArray = array('id', 'country', 'program', 'village_name', 'village_elder', 'elder_contact', 'chw_name', 'chw_contact');
            case 'promoter_details':
                //this fields array is for controlling crud operations
                return $fieldsArray = array('id', 'country', 'program', 'promoter_name', 'waterpoint_id', 'promoter_gender', 'promoter_contact', 'promoter_language', 'assistant_promoter_name', 'assistant_promoter_gender', 'assistant_promoter_contact', 'assistant_promoter_language');
            case 'promoterStruct':
                //Redefines what's to be seen in the table displayed i the admin
                return $fieldsArray = array('id', 'country', 'program', 'waterpoint_id', 'promoter_name', 'promoter_contact', 'assistant_promoter_name', 'assistant_promoter_contact');
            case 'staff_list':
                return $fieldsArray = array('id', 'employee_id', 'country', 'full_name', 'position', 'email', 'phone');
            case 'officials_contacts':
                return $fieldsArray = array('id', 'country', 'name', 'title', 'phone', 'email');
            case 'issues_category':
                return $fieldsArray = null;
            case 'staff_category':
                return $fieldsArray = array('id', 'position');
            case 'contact_category':
                return $fieldsArray = array('id', 'title');
            case 'fleet_category':
                return $fieldsArray = array('id', 'type');
            case 'cau_programs':
                return $fieldsArray = array('id', 'country', 'program', 'territory_id');
            case 'waterpoint_details':
                 // return $fieldsArray = array('id','program', 'waterpoint_name', 'waterpoint_id', 'verification_id','active','village', 'number_of_hhs', 'water_source_type', 'land_owner_name', 'land_owner_contact', 'installation_date', 'notes', 'latitude', 'longitude');
                return $fieldsArray = array('id', 'program', 'waterpoint_name', 'waterpoint_id', 'verification_id', 'active','village');

            default:
                return $fieldsArray = null;
        }
    }

    public function general($table = "fleet_list", $WHERE = NULL) {
       
        $tableCategory = $table;
        $fieldsArray = $this->fieldsArray($table);
        $generaldata_model = $this->loadModel('generalmodel');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        if ($table == "promoter_details") {
            if(isset($_POST['program'])){
                $program=$_POST['program'];
            }else{
                $program=null;
            }
           
            header('Location:'.URL.'generalclass/promoter/'.$program);
            exit();
        } else if ($table == "fleet_category" || $table == "contact_category") {
            $data = $generaldata_model->getNoncountryData($table);
        } else if ($table == 'waterpoint_details') {

            $allFields=$this->fieldsArray('hidden_waterpoint_details');
            if(isset($_POST['program']) !=null && !isset($_POST['editable'])){
                $data = $generaldata_model->getWaterpointDetails($table, $allFields,$_POST['program']);

            }else if(isset($_POST['program']) !=null && isset($_POST['editable'])!=null){
               $data = $generaldata_model->getEditableWaterpointDetails($table, $allFields,$_POST['program']);
  
            }else{
                $data=null;
            }

            $progDropDown=$generaldata_model->getProgramDropDown();
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            
            $cauManage = $generaldata_model->checkSelectedCau($table);
            //  echo '<pre>';
            // print_r($cauManage);
            // echo '</pre>';
            
        } else if ($table == 'staff_category') {
            $data = $generaldata_model->getNoncountryData($table);
        } else {
            $data = $generaldata_model->getData($table, $fieldsArray);
        }

       //Because of the country session to filter data
        require 'application/views/_templates/header.php';
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);


        if ($table == "staff_list") {
            $criteria = 'position';
            $tableCategory = 'staff_category';
            $model = $this->loadModel('stafflistmodel');
            $data = $model->getData($table, $fieldsArray, $tableCategory, $WHERE);
        }

        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        if($table=='issues_category'){
            require 'application/views/issuetracker/sidebar.php';
        }else if(!isset($_POST['editable'])){
             require 'application/views/adminData/sidebar.php';
        }
       

        if ($table != 'waterpoint_details') {
            $fields = $generaldata_model->getFields($table, $fieldsArray);
            require 'application/views/general/general.php';
            require 'application/views/_templates/footer.php';
        } else {

            if(isset($_POST['editable'])){
                $cauList=$generaldata_model->getRequiredCau();
              
                $ListedCaus=array();
                $i=0;
                foreach ($cauList as $key => $value) {
                // echo $value['territory_name'].'<br/>';
                        if($i<1 || strpos($value['territory_name'], 'village') !== false){
                           $retrivedTerritories=$generaldata_model->getCauList($value['id']);
                           $j=0;
                           foreach ($retrivedTerritories as $key2 => $value2) {
                               $ListedCaus[$value['territory_name']][$j]=array(
                                        "id"=>$value2["id"],
                                        "territory_name"=>$value2["admin_territory_name"]

                            );
                               $j++;
                           }
                           
                           ++$i;
                      }  
                    }
            }

            $fields = $generaldata_model->getFields($table);
            //$allFields=$this->fieldsArray('hidden_waterpoint_details');
           // $villages = $generaldata_model->getVillages($_SESSION['country']);

            require 'application/views/general/waterpointDetails.php';
            require 'application/views/_templates/footer.php';
        }
    }
    public function promoter($program=null){
          ini_set('max_execution_time', 3000); 
          $table='promoter_details';
        $siteverificationId = explode('/', $_GET['url']);
    
         
        //Because of the country session to filter data
        require 'application/views/_templates/header.php';
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

        $tableCategory = $table;
        $fieldsArray = $this->fieldsArray($table);
        $generaldata_model = $this->loadModel('generalmodel');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        $fieldsArray2 = $this->fieldsArray('promoterStruct');
        if(isset($_POST['callProgramDetails']) || $program !=null){

            if(isset($_POST['callProgramDetails'])){
                $program=$_POST['program'];
            }else{
               $program = isset($siteverificationId[2])?$siteverificationId[2]:null;
        
            }
           
            $data = $generaldata_model->getPromoterData($table,$fieldsArray2,$program);
        }
       
        $progDropDown=$generaldata_model->getProgramDropDown();
        $waterpoints = $generaldata_model->getWaterpoints($_SESSION['country']);
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        require 'application/views/adminData/sidebar.php';
        require 'application/views/general/promoter.php';
        require 'application/views/_templates/footer.php';  
    }
   public function addPromoter($table) {

        if (isset($_POST["add-promoter-data"])) {
            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
             $message='A record belonging to program '.$program.' has been Added.';
        }else{
             $message='Failed to Save';
        }
             $message=urlencode($message);
        // where to go after add
        header('location: ' . URL . 'generalclass/promoter/' . $_POST['program'] . '/?message='.$message);
   }
   public function deletePromoter($program, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->insertLogContactonDelete('promoter_details', $id);
            $this->model->deleteData('promoter_details', $id);
            $message='A record belonging to program '.$program.' has been deleted.';
        }else{
            $message='Deletion Failed';
        }
        $message=urlencode($message);
        header('location: ' . URL . 'generalclass/promoter/' . $program . '/?message='.$message);
  }
    public function changeStatus($table, $record, $status, $data2) {
        $generaldata_model = $this->loadModel('generalmodel');
        $params = array(
            'id' => $record,
            'country' => $_SESSION['country']
        );
        $message = 'Status Changed';
        if ($status == 0) {
            $data = array(
                "active" => 1
            );
            $value = 'active';
            $result = $generaldata_model->updateDBparams($table, $data, $params);
            $generaldata_model->insertLogContactonWPactive($table, $value, $data2);
        } else {
            $data = array(
                "active" => 0
            );
            $value = 'inactive';
            $result = $generaldata_model->updateDBparams($table, $data, $params);
            $generaldata_model->insertLogContactonWPactive($table, $value, $data2);
        }

        header('Location:' . URL . 'generalclass/general/waterpoint_details/?message=' . $message);
    }

    public function adminModuleManager() {
        $table = 'admin_module_manager';
        require 'application/views/_templates/header.php';
        $generaldata_model = $this->loadModel('generalmodel');

        /*  */
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");

        /* */
        $data = $generaldata_model->getAdminModuleManagerData();
        $tableName =  'Country Admin Unit Display Manager';
        $cauManage = $generaldata_model->getAllCau();

        require 'application/views/adminData/sidebar.php';
        $fields = $generaldata_model->getFields($table);
        require 'application/views/general/admin_module_manager.php';
        require 'application/views/_templates/footer.php';
    }

    public function addAdminModuleManager($table) {

        if (isset($_POST["add-general-data"])) {
            $generaldata_model = $this->loadModel('generalmodel');
            if ($table == 'field_office') {
                $dd = $generaldata_model->addData($table, $_POST);
                $message = 'Record Added Successfully';
                $asssignedUrl = 'generalclass/FieldOffice/';
            } else {
                $checkDuplicate = $generaldata_model->checkAdminModuleDuplicate($_POST['table_name'], $_POST['territory_id']);
                if ($checkDuplicate == null) {
                    $dd = $generaldata_model->addData($table, $_POST);
                    $message = 'Record Added Successfully';
                } else {
                    $message = 'Unable To Add.Such A record Exists';
                }
                $asssignedUrl = 'generalclass/adminModuleManager/';
            }
        }

        $message = urlencode($message);

        // where to go after add
        header('location: ' . URL . $asssignedUrl . '?message=' . $message);
    }

    public function deleteAdminModuleManager($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->insertLogContactonDelete($table, $id);
            $this->model->deleteData($table, $id);
        }
        if ($table == 'field_office') {
            $asssignedUrl = 'generalclass/FieldOffice/';
        } else {
            $asssignedUrl = 'generalclass/adminModuleManager/';
        }

        $message = 'Record Deleted Successfully';

        header('location: ' . URL . $asssignedUrl . $table . '?message=' . urlencode($message));
    }


    public function addCauProgram($table) {
        if (isset($_POST["add-general-data"])) {

            $generaldata_model = $this->loadModel('generalmodel');
            unset($_POST['territory_unknown']);
            $status = $generaldata_model->checkTerritoryExist($_POST['territory_id']);

            if (!isset($status[0]['territory_id'])) {
                $programId = $generaldata_model->checkProgramExist($_POST['program']);
                $_POST['program'] = $programId;
                $dd = $generaldata_model->addData($table, $_POST);
                $message = 'Record Saved';
            } else {
                $message = 'Record Not Saved. The Village has already been assigned.';
            }
        }

        // where to go after add
        header('location: ' . URL . 'generalclass/cauPrograms/?message=' . urlencode($message));
    }

    public function deleteCau($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->deleteData($table, $id);
            $message = 'Record Deleted';
        } else {
            $message = 'Record Not Deleted';
        }
        header('location: ' . URL . 'generalclass/cauPrograms/?message=' . $message);
    }

    public function villageContacts($table = "village_details") {

        //Because of the country session to filter data
        require 'application/views/_templates/header.php';

        $tableCategory = $table;
        $fieldsArray = $this->fieldsArray($table);
        $generaldata_model = $this->loadModel('generalmodel');
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        $data = $generaldata_model->getVillageData($table, $fieldsArray);
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';

        $villages = $generaldata_model->getVillages($_SESSION['country']);
        $cauList=$generaldata_model->getRequiredCau();
 
        $ListedCaus=array();
        $i=0;
        foreach ($cauList as $key => $value) {
        // echo $value['territory_name'].'<br/>';
           if($i<1 || strpos($value['territory_name'], 'village') !== false){
                   $retrivedTerritories=$generaldata_model->getCauList($value['id']);
                   $j=0;
                   foreach ($retrivedTerritories as $key2 => $value2) {
                       $ListedCaus[$value['territory_name']][$j]=array(
                                "id"=>$value2["id"],
                                "territory_name"=>$value2["admin_territory_name"]

                    );
                       $j++;
                   }
                   
                   ++$i;
                }
            }
        // echo '<pre>';
        // print_r($ListedCaus);
        // echo '</pre>';
        // exit();
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        require 'application/views/general/village.php';
        require 'application/views/_templates/footer.php';
    }
    public function ajaxChildCau($childCAU,$parentClassCAU,$parentCau){
        $generaldata_model = $this->loadModel('generalmodel');
        $data=$generaldata_model->getChildrenCau($childCAU,$parentClassCAU,$parentCau);
        echo $data = json_encode($data);
    }
    public function Officials($table = "officials_contacts") {

        //This should display all the officials despite the CAU

        $generaldata_model = $this->loadModel('generalmodel');
        $fieldsArray = $this->fieldsArray($table);

        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        $data = $generaldata_model->getOfficials($table, $fieldsArray);
        $cauDropDown = $generaldata_model->getTerritories();
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");

        require 'application/views/_templates/header.php';
        require 'application/views/adminData/sidebar.php';
        require 'application/views/general/officials.php';
        require 'application/views/_templates/footer.php';
    }

    public function FieldOffice() {

        $table = 'field_office';
        require 'application/views/_templates/header.php';
        $generaldata_model = $this->loadModel('generalmodel');

        /*  */
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");

        /* */
        $data = $generaldata_model->getFieldOffice();
        $tableName = str_replace("_", " ", 'Field Offices Available in ' . $_SESSION['countryName']);

        $tableName = ucwords($tableName);

        require 'application/views/adminData/sidebar.php';
        $fields = $generaldata_model->getFields($table);
        require 'application/views/general/admin_module_manager.php';
        require 'application/views/_templates/footer.php';
    }

    public function territoryCall() {

        $territoryId = $_GET["info"];
        $generaldata_model = $this->loadModel('generalmodel');
        $data = $generaldata_model->getTerritoryInfo($territoryId);

        $data = json_encode($data);
        echo $data;
        exit();
    }

    public function addOfficial($table) {

        if (isset($_POST["add-general-data"])) {

            //load model, perform an action on the model
            if (isset($_POST['first_name'])) {

                if (isset($_POST['name'])) {

                    $_POST['name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
                } else if (isset($_POST['full_name'])) {

                    $_POST['full_name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
                }


                $resetLast = $_POST["add-general-data"]; //This is for the prupose of array pop in libs/db
                //It will remove the last element automatically, which is in most times the button that submitted the data
                //if not, unset then set it again to make sure it is the last one
                unset($_POST['first_name']);
                unset($_POST['middle_name']);
                unset($_POST['last_name']);
                unset($_POST["add-general-data"]);
                $_POST["add-general-data"] = $resetLast; //Return the button as the last element
            }
            unset($_POST['territory_unknown']);

            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
        }
        // where to go after add
        header('location: ' . URL . 'generalclass/Officials/' . $table . '');
    }

    public function updateOfficials($table, $edit = false) {

        $this->model = $this->loadModel('generalmodel');

        //update table
        if (isset($_POST['update'])) {
            //The Contact Lists have first,middle & Last Names that don't exist in the db, so when the post is made
            //we search for the first,middle & last names in order to concantenate them to the existing field in the db
            //which is full_name so far
            if (isset($_POST['first_name'])) {
                $_POST['full_name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
            }
            unset($_POST['territory_unknown']);
            $this->model->updateData($_POST, $_POST['id'], $table);
            $this->model->insertLogContact($table, $_POST);
            // redirect after update
            header('location: ' . URL . 'generalclass/Officials/' . $table);
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        $fieldsArray = array('id', 'country', 'territory_id', 'name', 'title', 'phone', 'email');
        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        // if edit
        if ($edit != false) {

            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }
        $defaultterritories = $this->model->getAllTerritories($edit);
        $cauDropDown = $this->model->getTerritories();

        $fields = $this->model->getFields($table);
        require 'application/views/general/editofficials.php';
        require 'application/views/_templates/footer.php';
    }
    private function updateWptViaAjax($table='waterpoint_details'){
             //update waterpoint table via ajax
        $generaldata_model = $this->loadModel('generalmodel');
        $cauList=$generaldata_model->getRequiredCau();
            
         
                 foreach ($cauList as $key => $value) {
                   if(strpos($value['territory_name'], 'village') !== false && $_POST['village'] !=''){
                        //do not unset village.do nothing                     
                      }else{
                        unset($_POST[$value['territory_name']]);
                      }
                }
           
            unset($_POST['update']);
            $_POST['update']='1';
            unset($_POST['update-ajax']);
            
            $generaldata_model->updateData($_POST, $_POST['id'], $table);
            $generaldata_model->insertLogContact($table, $_POST);
            $_POST['editable']=1;
            
     
        
    }
    public function update($table, $edit = false) {
        // load the model
    
        $this->model = $this->loadModel('generalmodel');
         $cauList=$this->model->getRequiredCau();

        
        //update table
        if (isset($_POST['update'])) {
            //The Contact Lists have first,middle & Last Names that don't exist in the db, so when the post is made
            //we search for the first,middle & last names in order to concantenate them to the existing field in the db
            //which is full_name so far
            if (isset($_POST['first_name'])) {
                $_POST['full_name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
            }
            if($table=='waterpoint_details'){
                 foreach ($cauList as $key => $value) {
                   if(strpos($value['territory_name'], 'village') !== false){
                        //do not unset village.do nothing                     
                      }else{
                        unset($_POST[$value['territory_name']]);
                      }
                }
           
            unset($_POST['update']);
            $_POST['update']='';
            }
       
            $this->model->updateData($_POST, $_POST['id'], $table);
            $this->model->insertLogContact($table, $_POST);
            // redirect after update
            if($table !='promoter_details'){
                header('location: ' . URL . 'generalclass/general/' . $table);
            }else{
                  header('location: ' . URL . 'generalclass/promoter/' . $table);
            }
     
        }
        if(isset($_POST['update-ajax'])){
            $this->updateWptViaAjax();
            exit();
        }
        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        if ($table == "staff_list") {
            $fieldsArray = $this->fieldsArray($table);
            $data = $this->model->getData($table, $fieldsArray);
        } else if ($table == "promoter_details") {
            $fieldsArray = $this->fieldsArray($table);
            $programDropDown = $this->getProgramDropDown();
            $data = $this->model->getPromoterData($table, $fieldsArray);
        } else if ($table == "waterpoint_details") {
            $fieldsArray = array('id', 'country', 'program', 'waterpoint_name', 'waterpoint_id', 'verification_id', 'dispenser_barcode', 'village', 'number_of_hhs', 'water_source_type', 'nearest_type', 'nearest_market', 'market_days', 'directions', 'land_owner_name', 'land_owner_contact', 'nearest_boma', 'boma_contact', 'activities', 'activity_days', 'nearest_mama', 'mama_contact', 'neighbor_name', 'neighbor_contact', 'installation_date', 'notes', 'latitude', 'longitude');
            //$villageDropDown = $this->model->getVillageDropDown();
            $ListedCaus=array();
                $i=0;
                foreach ($cauList as $key => $value) {
                // echo $value['territory_name'].'<br/>';
                  if($i<1 || strpos($value['territory_name'], 'village') !== false){
                       $retrivedTerritories=$this->model->getCauList($value['id']);
                       $j=0;
                       foreach ($retrivedTerritories as $key2 => $value2) {
                           $ListedCaus[$value['territory_name']][$j]=array(
                                    "id"=>$value2["id"],
                                    "territory_name"=>$value2["admin_territory_name"]

                        );
                           $j++;
                       }
                   }
                   ++$i;
                }
        } else {
            $fieldsArray = $this->fieldsArray($table);
        }
        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        // if edit
        if ($edit != false) {

            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }

        $fields = $this->model->getFields($table);

        require 'application/views/general/editgeneral.php';
        require 'application/views/_templates/footer.php';
    }

    public function updateVillage($table, $edit = false) {
        // load the model

        $this->model = $this->loadModel('generalmodel');
        $cauList=$this->model->getRequiredCau();
        //update table
        if (isset($_POST['update'])) {

            foreach ($cauList as $key => $value) {
                if(strpos($value['territory_name'], 'village') !== false){
                    $_POST['village_name']=$_POST['village'];
                }
                unset($_POST[$value['territory_name']]);
            }
           
            unset($_POST['update']);
            $_POST['update']='';
           
            //make sure the button is the last post since the crud operations in the models perform an array pop on it
            $this->model->updateData($_POST, $_POST['id'], $table);
            $this->model->insertLogContact($table, $_POST);

            // redirect after update
            header('location: ' . URL . 'generalclass/villageContacts/' . $table);
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';

        $fieldsArray = $this->fieldsArray($table);

        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        // if edit
        if ($edit != false) {

            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }
        //$villages = $this->model->getVillages($_SESSION['country']);
        
 
        $ListedCaus=array();
        $i=0;
        foreach ($cauList as $key => $value) {
        // echo $value['territory_name'].'<br/>';
          if($i<1 || strpos($value['territory_name'], 'village') !== false){
               $retrivedTerritories=$this->model->getCauList($value['id']);
               $j=0;
               foreach ($retrivedTerritories as $key2 => $value2) {
                   $ListedCaus[$value['territory_name']][$j]=array(
                            "id"=>$value2["id"],
                            "territory_name"=>$value2["admin_territory_name"]

                );
                   $j++;
               }
           }
           ++$i;
        }
        $fields = $this->model->getFields($table);
        require 'application/views/general/editVillage.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * Description : give an associative array and turn into serial indexed array.
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

        if (isset($_POST["add-general-data"])) {


            //load model, perform an action on the model
            //  echo $table;
            if (isset($_POST['first_name'])) {

                if (isset($_POST['name'])) {

                    $_POST['name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
                } else if (isset($_POST['full_name'])) {

                    $_POST['full_name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
                } else if (isset($_POST['promoter_name'])) {

                    $_POST['promoter_name'] = $_POST['first_name'] . " " . $_POST['middle_name'] . " " . $_POST['last_name'];
                }


                $resetLast = $_POST["add-general-data"]; //This is for the prupose of array pop in libs/db
                //It will remove the last element automatically, which is in most times the button that submitted the data
                //if not, unset then set it again to make sure it is the last one
                unset($_POST['first_name']);
                unset($_POST['middle_name']);
                unset($_POST['last_name']);
                unset($_POST["add-general-data"]);
                $_POST["add-general-data"] = $resetLast; //Return the button as the last element
            }

            if(isset($_POST['sms_code'])){
                    $_POST['sms_code']=$_POST['category_id'].''.$_POST['sub_category_id'];
            }

            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
            //echo $table;
        }
        if (isset($_POST["add-waterpoint-data"])) {

            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
        }
        if (isset($_POST["add-village-data"])) {
            $generaldata_model = $this->loadModel('generalmodel');
            unset($_POST["add-village-data"]);
            $_POST['village_name']=$_POST['village'];
            $_POST["add-village-data"]='';
            $cauList=$generaldata_model->getRequiredCau();
            foreach ($cauList as $key => $value) {
                unset($_POST[$value['territory_name']]);
            }
         
            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
            header('location: ' . URL . 'generalclass/villageContacts/' . $table . '');
            exit();
        }
        // where to go after add
        header('location: ' . URL . 'generalclass/general/' . $table . '');
    }

    public function delete($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->insertLogContactonDelete($table, $id);
            $this->model->deleteData($table, $id);
        }
        header('location: ' . URL . 'generalclass/general/' . $table . '');
    }

    public function deleteOfficials($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->insertLogContactonDelete($table, $id);
            $this->model->deleteData($table, $id);
            $message = 'Record Deleted';
        } else {
            $message = 'Error Deleting Record';
        }
        header('location: ' . URL . 'generalclass/Officials/' . $table . '/?message=' . urlencode($message));
    }

    public function deleteVillage($table, $id) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->insertLogContactonDelete($table, $id);
            $this->model->deleteData($table, $id);
        }
        $message = urlencode("Record Deleted");
        header('location: ' . URL . 'generalclass/villageContacts/' . $table . '/?message=' . $message);
    }

    private function getProgramDropDown() {
        $expansionmodel = $this->loadModel('expansionmodel');

        $data = $expansionmodel->getProgramDropDown();
        return $data;
    }

    public function export($table) {

        if (isset($_POST['export'])) {

            $tableName = str_replace("_", " ", $table);
            $file_name = ucwords($tableName);
            $file_name = $_GET['file_name'];
            $table_name = $_GET['table_name'];

            $this->model = $this->loadModel('generalmodel');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $file_name . '.csv');

            //select table to export the data
            $select_table = mysql_query('select * from ' . $table_name . ' ');
            $rows = mysql_fetch_assoc($select_table);

            if ($rows) {
                getcsv(array_keys($rows));
            }
            while ($rows) {
                getcsv($rows);
                $rows = mysql_fetch_assoc($select_table);
            }
        }
    }

}

?>