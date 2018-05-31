<?php

class surveytrackermodel extends Database {

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

    public function getData($table, $fieldsArray = null) {

        $query = 'SELECT ';
        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,staff_list.full_name as full_name,survey_category.survey_category as survey_category,survey_status.survey_status as survey_status
                         
            
             FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' JOIN survey_types ON ' . $table . '.survey_type = survey_types.id'
                    . ' JOIN survey_category'
                    . ' JOIN survey_status ON ' . $table . '.survey_status = survey_status.id'
                    . ' AND '
                    . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id  ASC';

        } else {
            $query = 'SELECT * from ' . $table . ' WHERE ' . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id ';
        }
        // echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getData2($table) {

        $query = 'SELECT * from ' . $table . ' ORDER BY template_name';
        $data = $this->selectDBraw($query);

        return $data;
    }




    // public function getCompleted($table = "surveys", $fieldsArray) {

    //     $query = 'SELECT ';

    //     if (!empty($fieldsArray)) {

    //         foreach ($fieldsArray as $key => $value) {
    //             $query .= $table . "." . $value . ',';
    //         }

    //         $query .= 'admin_countries.country AS country,staff_list.full_name as full_name,survey_category.survey_category as survey_category,
    //             survey_status.survey_status as survey_status
					     
    //       FROM ' . $table
    //                 . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id '
    //                 . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
    //                 //. ' JOIN survey_category ON ' . $table . '.category = survey_category.id '
    //                 . ' JOIN survey_category'
    //                 . ' JOIN survey_status ON ' . $table . '.survey_status = survey_status.id'
    //                 . ' WHERE complete=1'
    //                 . ' AND '
    //                 . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id  ASC';


    //         //	.' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';
    //     } else {
    //         $query = 'SELECT * from ' . $table . ' WHERE ' . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id ';
    //     }
    //     // echo $query;
    //     $data = $this->selectDBraw($query);

    //     return $data;
    // }


    public function getStaffInfo($staffName) {
        //$query = 'SELECT phone,email from staff_list WHERE full_name="' . $staffName . '" AND country=' . $_SESSION['country'] . ' ORDER by full_name';
        $query = 'SELECT phone,email from staff_list WHERE full_name="' . $staffName . '"  ORDER by full_name';
        $data = $this->selectDBraw($query);
        return $data;
    }



    public function getSpecificData($table, $fieldsArray = null, $dataId) {

        $query = 'SELECT ';
        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .=$table . "." . $value . ',';
            }
            $query .= 'admin_countries.country AS country,survey_status.survey_status as survey_status
          FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN survey_status ON ' . $table . '.survey_status = survey_status.id WHERE admin_countries.id=' . $_SESSION["country"];
                    
        } else {
            $query = "SELECT * from " . $table . " WHERE issue_id=" . $dataId . ' AND country=' . $_SESSION["country"];
            $query = "SELECT * from " . $table . " WHERE country=" . $_SESSION["country"];
        }
        //    echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function addData($table, $data) {

        array_pop($data);

        $dd = $this->insertdDB($table, $data);
    }

    //Maurice Added Code
    public function addSurvey($data) {

        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $filename = $data[0];
        $filetype = $data[1];
        $category = $data[2];
        $subcategory = $data[3];
        $path = $data[4];

        $insertData =  array(
            //'id' => '',
            'country' => $country,
            'full_name' => $user_name,
            'email' => $email,
            'filename' => $filename,
            'filetype' => $filetype,
            'category' => $category,
            'subcategory' => $subcategory,
            'path' => $path       
        );

        $this->insertdDB('survey', $insertData);
    }
    public function insertLogSurveyTracker($table) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' uploaded';
        $description = 'no description';

        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description,

        );

        $this->insertdDB('survey_log_record', $insertData);
    }
    
    public function getSurvey() {

        $query = 'SELECT id, country, full_name, filename, filetype, category, subcategory, date_created, status from survey WHERE status = 1 ORDER BY date_created desc';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getTrash() {

        $owner = $_SESSION["email"];
        $query = 'SELECT id, country, full_name, filename, filetype, category, subcategory, date_created, status from survey WHERE status = 0 AND email ="'.$owner.'" ORDER BY date_created desc';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getWord() {

        $filetype = 'MS-WORD';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND filetype="'.$filetype.'"  ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getExcel() {

        $filetype = 'MS-EXCEL';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND filetype="'.$filetype.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getmysurveys() {
        $email = $_SESSION["email"];
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND email ="'.$email.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getcategory($category) {
        $query = $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND filename like "%' . $category. '%" ORDER BY date_created desc';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getFields($table, $fieldsArray = null) {
        //  echo "<pre>";
        //  echo $table."<br/>";
        //  print_r($fieldsArray);
        // echo "</pre>";
        // echo $table;
        $fields = $this->getColMeta($table, $fieldsArray);

        return $fields;
    }

    public function getByPK($id, $fieldsArray) {


        $dd = $this->selectDB(
                $table = 'surveys', $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function deleteData($id) {
        // echo $id;
        // $query="DELETE FROM admin_assets WHERE id ='$id'";
        // $this->deleteDB($query,$id,'admin_assets');
        $dd = $this->deleteDB('survey', $id);
        // echo "<pre>";var_dump($dd);echo "</pre>";
        // exit();
    }

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }
    


    public function runRawQuery($query) {


        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getsurveystatId($status){
        $query='SELECT id from survey_status WHERE survey_status="'.$status.'" LIMIT 1';
        $data=$this->selectDBraw($query);
        if($data !=null){
        return $data[0]['id'];
      }else{
        return false;
      }
    }


    //Temporal Code, tobe refactored and shortened
    public function getDTW() {

        $cat = 'DTW';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND category="'.$cat.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getDSW() {

        $cat = 'DSW';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND category="'.$cat.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getBeta() {

        $cat = 'Beta';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 AND category="'.$cat.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }
    public function getOther() {

        $cat = 'UNCLASSIFIED';
        $query = 'SELECT id, full_name, filename, filetype, category, subcategory, date_created, status  from survey WHERE status = 1 category="'.$cat.'" ORDER BY date_created desc ';
        $data = $this->selectDBraw($query);

        return $data;
    }

    


}

?>