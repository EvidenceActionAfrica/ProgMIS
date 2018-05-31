<?php

class fleetclass extends Controller {

    public $model;

    public function index() {

        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $table = "fleet_list";

        $fieldsArray = array('id', 'country', 'type', 'make', 'model', 'color', 'purchase_date', 'buying_price', 'chassis_no', 'engine_no', 'reg_no', 'office_location');

        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $fleetlist_model = $this->loadModel('fleetlistmodel');
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
        $data = $fleetlist_model->getData($table, $fieldsArray);
        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';


        $fields = $fleetlist_model->getFields($table, $fieldsArray);
        require 'application/views/fleet/fleet.php';
        require 'application/views/_templates/footer.php';
    }

    public function fieldsArray($table) {
        //    $tableCategory = $table;
        switch ($table) {

            case 'fleet_list':
                $fieldsArray = array('id', 'country', 'type', 'make', 'model', 'color', 'purchase_date', 'buying_price', 'chassis_no', 'engine_no', 'reg_no', 'office_location');

                break;
            case 'log_record':
                $fieldsArray = array('id', 'reg_no', 'fuel_quantity', 'odometer_current_reading', 'odometer_previous_reading', 'fuel_cost', 'duration_start', 'date_refilled', 'authorizing_person', 'rider');
                //  $fieldsArray = NULL;
                break;
            case 'fleet_category':
                $fieldsArray = array('id', 'type');
                //  $fieldsArray = NULL;
                break;
            case 'fleet_maintenance':
                $fieldsArray = array('id', 'reg_no', 'date', 'category', 'description', 'total_cost', 'outsource_material', 'outsource_material_cost', 'outsource_labor_cost', 'description_of_outsource_work', 'odometer_reading');
                //  $fieldsArray = NULL;
                break;


            default:
                // $fieldsArray = array('id', 'country', 'merchandise', 'make', 'model', 'color', 'purchase_date', 'buying_price', 'chassis_no', 'engine_no', 'reg_no', 'office_locations');
                $fieldsArray = null;

                break;
        }
        return $fieldsArray;
    }

    public function fleet($table = "fleet_list", $WHERE = NULL) {


        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $fieldsArray = $this->fieldsArray($table);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
        $fleetlist_model = $this->loadModel('fleetlistmodel');
        if ($table == "fleet_list") {
            $data = $fleetlist_model->getFleet($table, $fieldsArray, $WHERE);
            $officeLocations = $this->getOfficeLocations();
        } else if ($table == "fleet_maintenance") {
            $data = $fleetlist_model->getLogData($table, $fieldsArray);
        } else if ($table == "log_record") {
            $data = $fleetlist_model->getLogData($table, $fieldsArray);
        } else if ($table == "fleet_category") {
            $data = $fleetlist_model->getData($table, $fieldsArray);
        } else {
            $data = $fleetlist_model->getData($table, $fieldsArray);
        }

        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';

        $fields = $fleetlist_model->getFields($table, $fieldsArray);


        // $fields = $generaldata_model->getFields($table, $fieldsArray);
        require 'application/views/fleet/fleet.php';
        require 'application/views/_templates/footer.php';
    }

    /*
     * Report method will take in three parameters
     * 1. The Period being queried i.e $period.It can be monthly or yearly
     * 2. The Fleet type Id. REFERENCE fleet_category table
     * 3. Type Of Report -Aggregate,Cumilative,Fuel Consumption
     * 
     * Soln:I decide to place different code in a switch statement depending 
     * on the type of report being queried.
     * 
     */

    public function fleetcombined($table=null, $regnum=null) {

        $fleetlistmodel = $this->loadModel('fleetlistmodel');
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $column_priv = 'priv_fleet_list_' . strtolower($_SESSION['countryName']);
        $datapriv = $fleetlistmodel->getPriv();
        $priv = $datapriv[0][$column_priv];
        $RegNumLog = $fleetlistmodel->getRegNumLog();
        $RegNumPopup = $fleetlistmodel->getRegNum();
        if (isset($_POST['submit_reg_num']) && $_POST['RegNum'] != '') {

            unset($_POST['submit_reg_num']);
            $datalog = $fleetlistmodel->getDataLog($_POST);
            $datalogtotal = $fleetlistmodel->getDataLogTotal($_POST);
            $dataMaint = $fleetlistmodel->getDataMaint($_POST);
            $dataMaintTotal = $fleetlistmodel->getDataMaintTotal($_POST);
            $reg_no = $_POST['RegNum'];
            $office_location = $datalog[0]['office_location'];
        } else if (isset($_POST['add']) || isset($_POST['edit']) || isset($_POST['delete'])) {
            if (isset($_POST['delete'])) {
                $fleetlistmodel->addDataondelete($table, $regnum);
            }
            $fleetlistmodel->AddEditDelete($_POST, $table);
            $datalog = $fleetlistmodel->getDataLog($_POST);
            $datalogtotal = $fleetlistmodel->getDataLogTotal($_POST);
            $dataMaint = $fleetlistmodel->getDataMaint($_POST);
            $dataMaintTotal = $fleetlistmodel->getDataMaintTotal($_POST);
            $reg_no = $_POST['RegNum'];
            if (sizeof($datalog) != 0) {
                $office_location = $datalog[0]['office_location'];
            } else {
                $office_location = 'Office Unknown';
            }
        } else {
            $datalog = array();
            $datalogtotal = array();
            $dataMaint = array();
            $dataMaintTotal = array();
            $reg_no = '';
            $office_location = 'None';
        }
        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';
        require 'application/views/fleet/fleetcombined.php';
        require 'application/views/_templates/footer.php';
    }

    public function fleetcombinedAdd() {

        $fleetlistmodel = $this->loadModel('fleetlistmodel');

        if (isset($_POST['add-fleet-Combined-data'])) {

            $logRecord = array(
                "id" => "",
                "reg_no" => $_POST['reg_no'],
                "fuel_quantity" => $_POST['fuel_quantity'],
                "odometer_previous_reading" => $_POST['odometer_previous_reading'],
                "odometer_current_reading" => $_POST["odometer_current_reading"],
                "fuel_cost" => $_POST["fuel_cost"],
                "duration_start" => $_POST["duration_start"],
                "date_refilled" => $_POST["date_refilled"],
                "authorizing_person" => $_SESSION["id"],
                "rider" => $_POST["rider"],
                "extra" => $_POST['add-fleet-Combined-data']
            );

            $dd = $fleetlistmodel->addData('log_record', $logRecord);

            $maintenanceRecord = array(
                "id" => "",
                "reg_no" => $_POST['reg_no'],
                "date" => $_POST["service_date"],
                "category" => $_POST["category"],
                "description" => $_POST["description"],
                "total_cost" => $_POST["total_cost"],
                "outsource_material" => $_POST["outsource_materials"],
                "outsource_material_cost" => $_POST["out_source_materials_cost"],
                "outsource_labor_cost" => $_POST["out_source_labour_cost"],
                "description_of_outsource_work" => $_POST["description_of_outsource_work_performance"],
                "odometer_reading" => $_POST["odometer_previous_reading"],
                "extra" => $_POST['add-fleet-Combined-data']
            );

            $dd = $fleetlistmodel->addData('fleet_maintenance', $maintenanceRecord);

            header('location: ' . URL . 'fleetclass/fleetcombined/?message=' . $status);
        }

        header('location: ' . URL . 'fleetclass/fleetcombined/');
    }

    public function reports($category = "Cycle", $WHERE = NULL) {

        $fleetlistmodel = $this->loadModel('fleetlistmodel');
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        if ($category == "Vehicle" || $category == "Cycle") {
            
        if ($category == "Vehicle") {
            $categ = 1;
        } else if ($category == "Cycle") {
            $categ = 2;
        }
        }
        if (isset($_GET["submit_year"]) ||isset($_GET["alter_week"]) ||isset($_GET["alter_month"])) {
            $year = $_GET['choose_year'];
            $week = 'all';
            $month = 'all';
            $dayComplex = '';
            $weekComplex = '';
            $monthComplex = '';
            $yearComplex = ' AND Year = "' . $year . '" ';
            if ($year == 'all'){
              $yearComplex = '';  
            }
        } else if (isset($_GET["submit_month"])) {
            $month = $_GET['choose_month'];
            $weekComplex = '';
            $monthComplex = ' AND Month = "' . $month . '" ';
            if ($month == 'all'){
              $monthComplex = '';  
            }
            $year = $_GET['choose_year'];
            $yearComplex = ' AND Year = "' . $year . '" ';
            if (isset($_GET['choose_day']) && $_GET['choose_day'] !='all') {
                $day = $_GET['choose_day'];
                $dayComplex = ' AND Day = "' . $day . '" ';
            } else {
                $day = 'all'; 
                $dayComplex = '';
            }
        } else if (isset($_GET["submit_week"])) {
            $week = $_GET['choose_week'];
            $weekComplex = ' AND Week = "' . $week . '" '; 
            if ($week == 'all'){
              $weekComplex = '';  
            }
            $monthComplex = '';
            $year = $_GET['choose_year'];
            $yearComplex = ' AND Year = "' . $year . '" ';
            if (isset($_GET['choose_day']) && $_GET['choose_day'] !='all') {
                $day = $_GET['choose_day'];
                $dayComplex = ' AND Day = "' . $day . '" ';
            } else {
                $day = 'all'; 
                $dayComplex = '';
            }
        } else {
            $year = 'all';
            $yearComplex = '';
            $monthComplex = '';
            $weekComplex = '';
            $dayComplex = '';
        }  
        
        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';
        if ($category == "Vehicle" || $category == "Cycle") {
            $dataYearLogMaint = $fleetlistmodel->getDateYearLogMaint($categ);
            $dataWeekLogMaint = $fleetlistmodel->getDateWeekLogMaint($categ, $yearComplex);
            $dataDayLogMaint = $fleetlistmodel->getDateDayLogMaint($categ, $weekComplex, $monthComplex, $yearComplex);
            $data = $fleetlistmodel->getRegLogMaint($categ, $dayComplex, $weekComplex, $monthComplex, $yearComplex);
            require 'application/views/fleet/fleet_report_aggre.php';
        }
        if ($category == "Cumilative") {
            $dataOffYearLogMaint = $fleetlistmodel->getOffYearLogMaint();
            $dataWeekOffMaint = $fleetlistmodel->getOffWeekLogMaint($yearComplex);
            $dataDayOffMaint = $fleetlistmodel->getOffDayLogMaint($weekComplex, $monthComplex, $yearComplex);
            $data = $fleetlistmodel->getOffLogMaint($dayComplex, $weekComplex, $monthComplex, $yearComplex);
            require 'application/views/fleet/fleet_report_cum.php';
        }
        require 'application/views/_templates/footer.php';
    }

    public function report_analysis($category = "Cycle", $WHERE = NULL) {

        $fleetlistmodel = $this->loadModel('fleetlistmodel');
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $regNo = $fleetlistmodel->getRegNo();
        if ($category == "Vehicle") {
            $categ = 1;
        } else if ($category == "Cycle") {
            $categ = 2;
        }
        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';
        if ($category == "Vehicle" || $category == "Cycle") {
            require 'application/views/fleet/fleet_report_aggre.php';
        }
        if ($category == "Cumilative") {
            require 'application/views/fleet/fleet_report_analysis.php';
        }
        require 'application/views/_templates/footer.php';
    }

    public function report($period = "month", $fleet = 1, $type = "Aggregate") {

        require 'application/views/_templates/header.php'; //Because of the country session to filter data
        //  SELECT sum(fm.oil_lubricant_total_cost) as maintenance,sum(lr.fuel_cost) as fuelCost,sum(fm.oil_lubricant_total_cost+lr.fuel_cost) as TotalCost,sum(lr.odometer_current_reading-lr.odometer_previous_reading) as Distance,fl.reg_no from fleet_list as fl ,fleet_maintenance as fm,log_record as lr WHERE fl.id=lr.reg_no AND lr.reg_no=fm.reg_no AND fm.reg_no=fl.id AND fl.type=2

        switch ($type) {
            case "Aggregate":
                $fields = 'fl.reg_no,sum(distinct(fm.oil_lubricant_total_cost)) as maintenance,sum(distinct(lr.fuel_cost)) as fuelCost,';
                $fields.='(sum(distinct(fm.oil_lubricant_total_cost))+sum(distinct(lr.fuel_cost))) as TotalCost,(sum(distinct(lr.odometer_current_reading))-sum(distinct(lr.odometer_previous_reading))) as Distance';

                $query = 'SELECT  ';
                $query.=$fields;
                $query.=' from fleet_list as fl';
                $query.=' ,fleet_maintenance as fm,log_record as lr';
                $query.=' WHERE  fl.id=lr.reg_no';
                $query.=' AND lr.reg_no=fm.reg_no';
                $query.=' AND fm.reg_no=fl.id';
                $query.=' AND fl.type=' . $fleet;
                $query.=' AND fl.country=' . $_SESSION['country'];
                $query.=' GROUP BY fl.id';
                //  $query.=' AND fl.reg_no=lr.reg_no=fm.reg_no';

                break;

            case "Cumilative":
                $fields = 'field_office.office_location as office_location,fl.reg_no,sum(distinct(fleet_maintenance.oil_lubricant_total_cost)) as maintenance,sum(distinct(log_record.fuel_cost)) as fuelCost,';
                $fields.='(sum(distinct(fleet_maintenance.oil_lubricant_total_cost))+sum(distinct(log_record.fuel_cost))) as TotalCost,(sum(distinct(log_record.odometer_current_reading))-sum(distinct(log_record.odometer_previous_reading))) as Distance';

                $query = 'SELECT  ';
                $query.=$fields;
                $query.=' from fleet_list as fl';
                // $query.=' ,fleet_maintenance as fm';
                $query.=' JOIN field_office ON fl.office_location = field_office.id';
                $query.=' JOIN log_record ON log_record.reg_no=fl.id';
                // $query.=' AND lr.reg_no=fm.reg_no'
                $query.=' JOIN fleet_maintenance on fleet_maintenance.reg_no=fl.id';
                $query.=' WHERE fl.type=' . $fleet;
                $query.=' AND fl.country=' . $_SESSION['country'];
                $query.=' GROUP BY fl.reg_no';
                //  $query.=' AND fl.reg_no=lr.reg_no=fm.reg_no';
                //echo $query;
                break;

            default:
                $fields = 'sum(distinct(fm.oil_lubricant_total_cost)) as maintenance,sum(distinct(lr.fuel_cost)) as fuelCost,';
                $fields.='(sum(distinct(fm.oil_lubricant_total_cost))+sum(distinct(lr.fuel_cost))) as TotalCost,(sum(distinct(lr.odometer_current_reading))-sum(distinct(lr.odometer_previous_reading))) as Distance,fl.reg_no';

                $query = 'SELECT  ';
                $query.=$fields;
                $query.=' from fleet_list as fl';
                $query.=' ,fleet_maintenance as fm,log_record as lr';
                $query.=' WHERE  fl.id=lr.reg_no';
                $query.=' AND lr.reg_no=fm.reg_no';
                $query.=' AND fm.reg_no=fl.id';
                $query.=' AND fl.type=' . $fleet;
                $query.=' AND fl.country=' . $_SESSION['country'];
                $query.=' GROUP BY fl.id';
                //  $query.=' AND fl.reg_no=lr.reg_no=fm.reg_no';

                break;
        }
        $table = $type . " Report Summary";
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $fleetlist_model = $this->loadModel('fleetlistmodel');
        // echo "<h1>The Field array is</h1> ".$fieldsArray;
        $data = $fleetlist_model->runRaw($query);

        /** Side Bar Data */
        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories = $generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';



        //   $fields = $fleetlist_model->getFields("fleet_list", $fieldsArray);
        require 'application/views/fleet/fleet_report.php';
        require 'application/views/_templates/footer.php';
    }

    public function update($table, $edit = false) {
        // load the model
        $this->model = $this->loadModel('fleetlistmodel');
        if ($table == "fleet_list") {
            $officeLocations = $this->getOfficeLocations();
        }

        //update table
        if (isset($_POST['update'])) {
            //The Contact Lists have first,middle & Last Names that don't exist in the db, so when the post is made
            //we search for the first,middle & last names in order to concantenate them to the existing field in the db
            //which is full_name so far

            $this->model->updateData($_POST, $_POST['id'], $table);
            $this->model->addData($table, $_POST);

            // redirect after update
            header('location: ' . URL . 'fleetclass/fleet/' . $table . '');
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';

        $data = $this->model->getData($table);

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


        require 'application/views/fleet/editfleet.php';
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

        if (isset($_POST["add-fleet-data"])) {
            $_POST["authorizing_person"] = $_SESSION["id"];
            unset($_POST["add-fleet-data"]);
            $generaldata_model = $this->loadModel('fleetlistmodel');
            $dd = $generaldata_model->addData($table, $_POST);
            //echo $table;
        }

        // where to go after add
        header('location: ' . URL . 'fleetclass/fleet/' . $table . '');
    }

    public function delete($table, $id, $regnum) {
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->deleteData($table, $id);
            $fleetlistmodel = $this->loadModel('fleetlistmodel');
            $fleetlistmodel->addDataondelete($table, $regnum);
        }
        header('location: ' . URL . 'fleetclass/fleet/' . $table . '');
    }

    private function getOfficeLocations() {
        $fleetlistmodel = $this->loadModel('fleetlistmodel');
        $officeLocations = $fleetlistmodel->getOffices();
        return $officeLocations;
    }

    public function import($table) {

        $importmodel = $this->loadModel('expansionmodel');
        $status = $this->upload($table);
        header("Location:" . URL . "fleetclass/fleet/" . $table . "/?message=" . urlencode($status));
    }

    public function upload($table) {
        ini_set('max_execution_time', 3000);

        if ($_FILES["file"]["error"] > 0) {
            $status = 'Failed Upload';
        } else {
            $temp = $_FILES["file"]["tmp_name"];
            $filename = $this->upload_image($temp);
            $this->setCsv($filename, $table);
            $status = 'Upload Successful';
        }

        return $status;
    }

    public function upload_image($image_temp) {
        $album_name = substr(sha1(uniqid('moreentropyhere')), 0, 10);

        $image_file = $album_name . '.csv';
        $path = __DIR__ . '/upload/' . $image_file;
       // $path = str_replace('\\', '\\\\', $path);
        move_uploaded_file($image_temp, $path);
        return $path;
    }

    public function setCsv($filename, $tableName) {
        $importmodel = $this->loadModel('fleetlistmodel');

        $handle = fopen($filename, "r");
        $counter = 0;
        //$fieldNo=sizeof($fieldsArray);
        $counter1 = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            if (sizeof($data) == 12) {
                // echo $data[$counter1];


                $type = $importmodel->getFleetTypeId($data[2]);
                $type = isset($type) ? $type : $importmodel->getFleetTypeId("unknown");

                $activeColor = $importmodel->getFleetColor($data[5]);
                $activeColor = isset($activeColor) ? $activeColor : $importmodel->getFleetColor("unknown");

                $office = $importmodel->getOfficeLoc($data[11]);
                $office = isset($office) ? $office : $importmodel->getOfficeLoc("unknown");




                $data3 = array(
                    "id" => "",
                    "country" => $_SESSION['country'],
                    "type" => $type,
                    "make" => $data[3],
                    "model" => $data[4],
                    "color" => $activeColor,
                    "purchase_date" => $data[6],
                    "buying_price" => $data[7],
                    "chassis_no" => $data[8],
                    "engine_no" => $data[9],
                    "reg_no" => $data[10],
                    "office_location" => $office
                );
            }
            $counter1 = 0;

            if ($counter != 0) {

                $importmodel->insertdDB($tableName, $data3);
            }
            ++$counter;
        }

        fclose($handle);
    }

}

// end class
?>