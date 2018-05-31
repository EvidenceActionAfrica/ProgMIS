<?php

class chlorineclass extends Controller {

    public $model;

    public function index() {

       $this->chlorine();
    }

    public function import($table = "chlorine_inventory") {

        require 'application/views/_templates/header.php';
        
        $chlorine_model = $this->loadModel('chlorinemodel');

        if (isset($_POST['import-chlorine-data'])) {

            if (isset($_FILES['chlorine-csv-file'])) {

                $file = $_FILES['chlorine-csv-file']['tmp_name'];
                $csv = array_map('str_getcsv', file($file));


                switch ($table) {

                    case "chlorine_inventory":
                        $inventory_type_table = 'chlorine_inventory_type';
                        break;

                    case "dispenser_spare_parts":
                        $inventory_type_table = 'dispenser_inventory_type';
                        break;
                }

                $chlorine_model->importChlorineDetails($csv,$table,$inventory_type_table);

            }

        }

        header('Location:'.URL.'chlorineclass/chlorine');

    }

    public function chlorine($table = "chlorine_inventory", $WHERE = NULL) {

        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        //    $tableCategory = $table;
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

        switch ($table) {

            case "chlorine_inventory":
                $fieldsArray = array('id', 'country', 'batch_no','vehicle_reg_number', 'inventory_type', 'description', 'unit_price','invoice_number','quantity_received', 'quantity_used', 'quantity_spoilt', 'quantity_received-(quantity_used+quantity_spoilt) AS quantity_stocked','storage_location', 'date_received', 'expiry_date','last_update');
                $inventory_type_table = 'chlorine_inventory_type';
                break;

            case "dispenser_spare_parts":
                $fieldsArray = array('id', 'country', 'batch_no', 'inventory_type', 'description', 'inventory_condition', 'unit_price', 'invoice_number', 'quantity_received', 'quantity_used', 'quantity_spoilt', 'quantity_received-(quantity_used+quantity_spoilt) AS quantity_stocked','storage_location', 'date_received','last_update');
                $inventory_type_table = 'dispenser_inventory_type';
                break;

            default:
                $fieldsArray = array('id', 'country', 'batch_no', 'inventory_type', 'description', 'unit_price', 'invoice_number', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received', 'expiry_date','last_update');
                break;
        }


        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
        $chlorine_model = $this->loadModel('chlorinemodel');
        // if($table == "chlorine_inventory"){
        //     $data = $chlorine_model->getData($table, $fieldsArray, $WHERE, $inventory_type_table);        
        // } else {            
        //     $data = $chlorine_model->getNormalData($table, $fieldsArray);        
        // }
        $data = $chlorine_model->getData($table, $fieldsArray, $WHERE, $inventory_type_table);        
        $fields = $chlorine_model->getFields($table, $fieldsArray, $WHERE);

        $generaldata_model = $this->loadModel('generalmodel');
       
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories=$generaldata_model->getSidebarData("staff_category");

        function return_bytes($val) {
            $val = trim($val);
            $last = strtolower($val[strlen($val)-1]);
            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }
            return $val;
        }
        $post_max_size = return_bytes(ini_get('post_max_size'));

        require 'application/views/adminData/sidebar.php';

        // $fields = $generaldata_model->getFields($table, $fieldsArray);
        require 'application/views/process/chlorine/index.php';
        require 'application/views/_templates/footer.php';
    }

    /*
     * Report method will take in three parameters
     * 1. The Period being queried i.e $period.It can be monthly or yearly
     * 2. The Fleet type Id. REFERENCE chlorine_category table
     * 3. Type Of Report -Aggregate,Cumilative,Fuel Consumption
     * 
     * Soln:I decide to place different code in a switch statement depending 
     * on the type of report being queried.
     * 
    */
    public function update($table, $edit = false) {
        // load the model
        $this->model = $this->loadModel('chlorinemodel');

        //update table
        if (isset($_POST['update-chlorine-data'])) {

            unset($_POST['update-chlorine-data']);
            $_POST['last_update'] = date("Y-m-d H:i:s");
            //The Contact Lists have first,middle & Last Names that don't exist in the db, so when the post is made
            //we search for the first,middle & last names in order to concantenate them to the existing field in the db
            //which is full_name so far

            $this->model->updateChlorineData($_POST, $_POST['id'], $table);
            // re;direct after update
            header('location: ' . URL . 'chlorineclass/chlorine/');
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';

        switch ($table) {

            case "chlorine_inventory":
                $inventory_type_table = 'chlorine_inventory_type';
                break;

            case "dispenser_spare_parts":
                $inventory_type_table = 'dispenser_inventory_type';
                break;
        }

        $data = $this->model->getData($table, NULL, NULL,$inventory_type_table);

        // change table name to proper case
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);

        // if edit
        if ($edit != false) {
            $fieldsArray = NULL;
            $single_record = $this->model->getByPK($table, $edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $this->serializeArray($single_record);
        }

        $fields = $this->model->getFields($table);


        require 'application/views/process/chlorine/editchlorine.php';
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

        if (isset($_POST["add-chlorine-data"])) {
            $chlorine_model = $this->loadModel('chlorinemodel');
            $dd = $chlorine_model->addData($table, $_POST);
        }

        if ($table == 'dispenser_spare_parts') {
            header('location: ' . URL . 'chlorineclass/chlorine/'.$table.'');
        } else {
            header('location: ' . URL . 'chlorineclass/chlorine/');
        } 
        
    }

    public function delete($table, $id, $deletDetail) {
        $this->model = $this->loadModel('chlorinemodel');
        if (isset($id)) {
            $this->model->deleteData($table, $id, $deletDetail);
        }
        header('location: ' . URL . 'chlorineclass/chlorine/');
    }

    // public function fieldsArray($table) {
        
    //     switch ($table) {
    //         case 'chlorine_inventory':
    //             return $fieldsArray = array('id', 'country', 'batch_no','vehicle_reg_number', 'inventory_type', 'description', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received', 'expiry_date');
    //             break;

    //         case 'dispenser_spare_parts':
    //             return $fieldsArray = array('id', 'country', 'batch_no', 'description', 'inventory_condition', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received');
    //             break;

    //         default:
    //             return $fieldsArray = array('id', 'country', 'batch_no', 'inventory_type', 'description', 'inventory_condition', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received', 'expiry_date');
    //             break;
    //     }
    // }

   

}

?>