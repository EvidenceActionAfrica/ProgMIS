<?php

class AssetData extends Controller {

    public $model;
    public $table = 'admin_assets';

    public function index() {
        require 'application/views/_templates/header.php';
        require 'application/views/assetData/index.php';
        require 'application/views/_templates/footer.php';
    }
 
    public function asset($inventory_type = 1, $edit = false) {
        require 'application/views/_templates/header.php'; //Because of the country session to filter data
         $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

        // $country-$_SESSION['country'];
        $inventory_type_id = $inventory_type;

        // get the fields array
        $fieldsArray = $this->fieldsArray($inventory_type);

        $adminData_model = $this->loadModel('AssetModel');

        // if edit
        if ($edit != false) {
            $this->model = $adminData_model;
            $single_record = $this->model->getByPK($edit, $fieldsArray);

            // do some cleaning 
            // its assiciative
            // make it serial
            $single_record = $single_record[0];
            $i = 0;
            foreach ($single_record as $key => $value) {
                unset($single_record[$key]);
                $single_record[$i] = $value;
                $i++;
            }
        }

        $data = $adminData_model->getData($inventory_type, $fieldsArray);
        $fields = $adminData_model->getFields('admin_assets', $fieldsArray);
        $inventory_type = $adminData_model->get_inventory_type($inventory_type);

        /** Side Bar Data */
         $generaldata_model = $this->loadModel('generalmodel');
         $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
         $contactCategories = $generaldata_model->getSidebarData("contact_category");
         $staffCategories=$generaldata_model->getSidebarData("staff_category");
        require 'application/views/adminData/sidebar.php';

        require 'application/views/assetData/asset.php';
        require 'application/views/_templates/footer.php';
    }

    /**
     * Description : Get the fields depending on the number given.
     *
     * @param int  $inventory_type
     * @return mixed $fieldsArray
    */
    public function fieldsArray($inventory_type) {
        switch ($inventory_type) {
            //Phones
            case '1':
                return $fieldsArray = array('id', 'inventory_type', 'country','office_location', 'model', 'serial_no', 'person_responsible', 'quantity', 'purchase_date', 'invoice_number', 'purchase_price_local', 'purchase_price_usd', 'project', 'phone_imei', 'battery_serial', 'simcard_number','insurance','warranty');
                break;
            //Computer
            case '2':
                return $fieldsArray = array('id', 'inventory_type', 'country','office_location', 'model', 'serial_no', 'inventory_tag', 'person_responsible', 'purchase_date', 'invoice_number', 'purchase_price_local', 'purchase_price_usd', 'project','insurance','warranty');
                break;
            //Batteries
            case '3':
                return $fieldsArray = array('id', 'inventory_type', 'country','office_location', 'model', 'serial_no', 'person_responsible', 'quantity', 'invoice_number', 'purchase_price_local', 'purchase_price_usd', 'total_usd', 'project','insurance');
                break;
            //Vehicles
            case '4':
                return $fieldsArray = array('id', 'inventory_type', 'country', 'office_location','item_desc', 'person_responsible', 'quantity', 'invoice_number', 'purchase_price_local', 'purchase_price_usd', 'purchase_date', 'deprecation_period', 'project','insurance');
                break;
            //Equipment   
            case '5':
                return $fieldsArray = array('id', 'inventory_type', 'country','office_location', 'item_desc', 'person_responsible', 'quantity', 'purchase_date', 'invoice_number', 'purchase_price_local', 'purchase_price_usd','insurance');
                break;
            //Furniture
            case '7':
                return $fieldsArray = array('id', 'inventory_type', 'country','office_location', 'inventory_tag', 'model', 'serial_no', 'person_responsible', 'invoice_number', 'purchase_price_local', 'purchase_price_usd', 'purchase_date', 'project','insurance');
                break;
            //Other (6)   
            default:
                return $fieldsArray = null;
                break;
        }
    }

    public function add() {

        if (isset($_POST["add-admin-data"])) {

            unset($_POST["add-admin-data"]);

            $inventory_type = $_POST['inventory_type'];
            $adminData_model = $this->loadModel('AssetModel');
            $adminData_model->addData($_POST);
        }

        // where to go after add
        header('location: ' . URL . 'assetData/asset/' . $inventory_type);
    }

    public function update($inventory_type = false, $id = false) {

        // update the model
        if (isset($_POST['update'])) {

            unset($_POST['update']);

            $adminData_model = $this->loadModel('AssetModel');
            $adminData_model->updateData($_POST, $_POST['id'], $this->table);
           
            $inventory_type = $_POST['inventory_type'];
            header('location: ' . URL . 'assetData/asset/' . $inventory_type);
        }

        // display the selecetd data
        $this->model = $this->loadModel('AssetModel');

        $fieldsArray = $this->fieldsArray($inventory_type); // get the table columns

        $single_record = $this->model->getByPK($id, $fieldsArray); // get thesingel record
        //do some cleaning // its assiciative // make it serial
        $single_record = $single_record[0];

        $fields = $this->model->getFields('admin_assets', $fieldsArray);

        // add the variable id so not to conlfict
        // the $inventory_id is used in the  cancel link button
        $inventory_type_id = $inventory_type;
        // change the inventory type number to a table
        $inventory_type = $this->model->get_inventory_type($inventory_type);

        // render the view
        require 'application/views/_templates/header.php';
        require 'application/views/assetData/edit.php';
        require 'application/views/_templates/footer.php';
    }

    public function delete($inventory_type_id, $id, $serial_no, $inventory_type) {

        $this->model = $this->loadModel('AssetModel');
        if (isset($id)) {
            $this->model->deleteData($inventory_type_id, $id, $serial_no, $inventory_type);
            $message=urlencode('Record Deleted');
        }else{
             $message=urlencode('Record Not Deleted');
        }
        header('location: ' . URL . 'assetData/asset/' . $inventory_type_id.'/?message='.$message);
    }

    /**
     * Description : export to CSV.
     *
     * @param int $inventory_type 
     */
    public function export($inventory_type) {
        // load the model
        $this->model = $this->loadModel('AssetModel');

        // get the fields array
        $fieldsArray = $this->fieldsArray($inventory_type);

        //start the session because the method getData() 
        //needs the country session in the query
        session_start();
        // perform the query
        $sheet = $this->model->getData($inventory_type, $fieldsArray);
        // echo "<pre>";var_dump($fieldsArray);echo "</pre>";
        // echo "<pre>";var_dump($sheet);echo "</pre>";
        // exit();
        // get the inventory name
        $csv_name = $this->model->get_inventory_type($inventory_type);
        $csv_name = $csv_name . " Inventory";

        $this->model = $this->loadModel('csvmodel');

        // create the header.
        $header = $this->relace_upper($fieldsArray);
        // echo "<pre>";var_dump($header);echo "</pre>";
        // exit();
        // send these data to export model
        $this->model->export($sheet, $header, $csv_name);
    }

    /**
     * Description : Replace the underscore with spaces and mail(to, subject, message)ake the strings uppercase.
     *
     * @param string  $header
     * @return mixed  $data
     *
     */
    public function relace_upper($header) {
        $data = array();
        // $data[]="ID"; // this will the first title
        foreach ($header as $key => $value) {
            $string1 = str_replace("_", " ", $value);
            $string2 = strtoupper($string1);
            $data[] = $string2;
        }

        return $data;
    }

}

// end class
?>