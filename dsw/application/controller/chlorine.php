<?php

class chlorine extends Controller {

    public $model;

    public function index() {
        require 'application/views/_templates/header.php'; // the session is needed
 
        //create the helper model
        $helper = $this->helper_model;

        //create the model
        $this->model = $this->loadModel('chlorinemodel');

        // get all the data
        $fieldsArray=$this->fieldsArray('chlorine_inventory');
        // echo "<pre>";var_dump($fieldsArray);echo "</pre>";

        // get the data
        $data = $this->model->getData($fieldsArray);

        // get the fields
        $fields=$helper ->getFields('chlorine_inventory',$fieldsArray);

        $table="Chlorine";
        require 'application/views/process/sidebar.php';
        require 'application/views/process/chlorine/index.php';
        require 'application/views/_templates/footer.php';
    }


    public function add(){

    	if (isset($_POST["add-chlorine-inventory"])) {
    		// load the helper model
            $helper = $this->helpermodel();
            $table="chlorine_inventory";	
            // load the chlorine model
            $this->model = $this->chlorineModel();
            // add the data
            $helper->addData($table, $_POST);
        }

        // where to go after add
        header('location: ' . URL . 'chlorine/');
    }



    public function update($table, $edit = false) {
        // load the chlorine model
        $this->model = $this->chlorinemodel();

    	// load the helper model
        $helper = $this->helpermodel();

        //update table if posted
        if (isset($_POST['update-chlorine-data'])) {

        	// exit();
            $this->model->updateData($_POST, $_POST['id'], $table);

            // redirect after update
            header('location: ' . URL . 'chlorine/');
        }

        date_default_timezone_set("Africa/Nairobi");

        // needed here tp access the session
        require 'application/views/_templates/header.php';

        $fieldsArray = $this->fieldsArray($table);

        // if edit
        if ($edit != false) {

            $single_record = $this->model->getByPK($edit, $fieldsArray);
            //do some cleaning // its assiciative // make it serial
            $single_record = $single_record[0];
            $single_record = $helper->serializeArray($single_record);
        }

        // get the fields for the table header
        $fields = $helper->getFields($table,$fieldsArray);


        require 'application/views/process/chlorine/_form.php';
        require 'application/views/_templates/footer.php';
    }

    public function fieldsArray($table) {
           switch ($table) {

            case 'promoter_details':
                $fieldsArray =array('id','promoter_name','promoter_gender','promoter_language','promoter_contact','assistant_promoter_name','assistant_promoter_gender','assistant_promoter_language','assistant_promoter_contact');
                break;

            case 'chlorine_inventory':
                return $fieldsArray =array('id','country', 'inventory_id', 'item', 'description', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'storage_location', 'date_received', 'expiry_date');
                break;

            case 'chlorine_other_inventory':
                return $fieldsArray =array('id', 'inventory_id', 'item', 'description', 'inventory_condition', 'unit_price', 'quantity_received', 'quantity_stocked', 'quantity_used', 'quantity_spoilt', 'date_received');
                break;

             default:
             $fieldsArray =array('id','promoter_name','promoter_gender','promoter_language','promoter_contact','assistant_promoter_name','assistant_promoter_gender','assistant_promoter_language','assistant_promoter_contact');
            break;

      
        }
    }


    /**
    * Description : creates the model.
    *
    */
    
    public function chlorineModel(){
    	return $this->model = $this->loadModel('chlorinemodel');
    }

    /**
    * Description : create helper model.
    *
    */
    
    public function helpermodel(){
    	return $helper = $this->loadModel('helpermodel');
    }


    /**
    * Description : export to CSV.
    *
    * @param int $inventory_type 
    */
    
    public function export($table){
        // load the chorine model
        $this->model = $this->chlorineModel();
        //$helpermodel = $this->helpermodel();
        
        $helpermodel = $this->helper_model;

        // get the fields array
        $fieldsArray = $this->fieldsArray($table);

        //start the session because the method getData() 
        //needs the country session in the query
        session_start();
        // perform the query
        $sheet = $this->model->getData($fieldsArray);
        // echo "<pre>";var_dump($fieldsArray);echo "</pre>";
        // echo "<pre>";var_dump($sheet);echo "</pre>";
        // exit();

        // get the inventory name
		$csv_name = helpermodel::replace_upper_string($table);
        // $csv_name = $this->model->get_inventory_type($inventory_type);
        $csv_name = $csv_name." Inventory";

        $this->model = $this->loadModel('csvmodel');

        // create the header.
        $header = $helpermodel->relace_upper($fieldsArray);
        // echo "<pre>";var_dump($header);echo "</pre>";
        // exit();
        // send these data to export model
        $this->model->export($sheet,$header,$csv_name);
    }


}

// end class
?>