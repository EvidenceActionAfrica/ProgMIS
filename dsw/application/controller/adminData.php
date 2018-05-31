<?php

class adminData extends Controller
{
  
    public function index() {
        require 'application/views/_templates/header.php';
        // require 'application/views/adminData/sidebar.php';
        require 'application/views/adminData/index.php';
        require 'application/views/_templates/footer.php';
    }
    
    public function geography($table="counties"){
        require 'application/views/_templates/header.php';
       
        // $table=$table.'.'.$_SESSION['countryName'];//This is to help differentiate which columns to appear for a specific country
        $generaldata_model = $this->loadModel('generalmodel');
        $fieldsArray=$this->getfieldsArray($table);
        $data=$generaldata_model->getData($table,$fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
       
        
         $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
         $contactCategories = $generaldata_model->getSidebarData("contact_category");
         $staffCategories=$generaldata_model->getSidebarData("staff_category");
         require 'application/views/adminData/sidebar.php';
         require 'application/views/adminData/geographies/geography.php';
         require 'application/views/_templates/footer.php';
    }
    
    public function getfieldsArray($table){
        $country = $_SESSION['country'];
        switch ($table) {
            case "counties":
            return $fieldsArray = array("id","country","county_id","county","county_code");

            case "sub_counties":
                if ($country==1) {
                    $fieldsArray = array("id","country","county_id","county","sub_county_name","sub_county_id");
                } else if ($country==2) {
                    $fieldsArray = array("id","country","county_id","county","sub_county_name","sub_county_id");
                } else if ($country==3) {
                    $fieldsArray = array("id","country","sub_county_name","sub_county_id");
                }
            return $fieldsArray;
            
            case "districts":
                if ($country==1) {
                    $fieldsArray = array("id","country","county_id","county","district_name","district_id");
                } else if ($country==2) {
                    $fieldsArray = array("id","country","county_id","county","district_name","district_id");
                } else if ($country==3) {
                    $fieldsArray = array("id","country","district_name","district_id");
                }
            return $fieldsArray;
            
            case "parish_details":
                if ($country==1) {
                    $fieldsArray = array("id","country","county_id","county","sub_county_name","sub_county_id","parish_name");
                } else if ($country==2) {
                    $fieldsArray = array("id","country","county_id","county","sub_county_name","sub_county_id","parish_name");
                } else if ($country==3) {
                    $fieldsArray = array("id","country","parish_name");
                }
            return $fieldsArray;
         
            default:
            return $fieldsArray=array("id","country","county_id","county_name","county_code");
        }
        return null;
    }

    public function update($table, $edit = false) {
        // load the model
        
        $this->model = $this->loadModel('generalmodel');
        
        //update table
        if (isset($_POST['update-admin-data'])) {
            //The Contact Lists have first,middle & Last Names that don't exist in the db, so when the post is made
            //we search for the first,middle & last names in order to concantenate them to the existing field in the db
            //which is full_name so far
           
            $this->model->updateData($_POST, $_POST['id'], $table);

            // redirect after update
            header('location: ' . URL . 'adminData/geography/' . $table);
        }

        date_default_timezone_set("Africa/Nairobi");
        // needed here tp access the session
        require 'application/views/_templates/header.php';
        
            $fieldsArray=$this->getfieldsArray($table);
            $data = $this->model->getData($table, $fieldsArray);
        
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

        $fields = $this->model->getFields($table,$fieldsArray);
        require 'application/views/adminData/geographies/edit.php';
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

        if (isset($_POST["add-adminData-data"])) {

            //load model, perform an action on the model
            //  echo $table;
           
           // echo "<pre>";
           // var_dump($_POST);
           // echo "</pre>";
            
            $generaldata_model = $this->loadModel('generalmodel');
            $dd = $generaldata_model->addData($table, $_POST);
            //echo $table;
        }
        
        // where to go after add
        header('location: ' . URL . 'adminData/geography/' . $table . '');
    }

    public function delete($table, $id) {
        // echo 'table ='.$table;
        // echo "<br>";
        // echo 'id ='.$id;
        // exit();
        $this->model = $this->loadModel('generalmodel');
        if (isset($id)) {
            $this->model->deleteData($table, $id);
        }
        header('location: ' . URL . 'adminData/geography/' . $table . '');
    }

}


?>