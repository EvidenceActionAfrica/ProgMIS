<?php

class systemsetting extends Controller {

    public $model;

    public function index($table) {

        require 'application/views/_templates/header.php'; 
        require 'application/views/systemsetting/sidebar.php';
        

        $tableName = str_replace("_", " ", $table);
        $tableName = ucwords($tableName);
        $generaldata_model = $this->loadModel('systemsettingmodel');
        $fieldsArray = Array('id','country', 'user_name', 'email', 'qction', 'description', 'date');
        $data = $generaldata_model->getData($table, $fieldsArray);
        $fields = $generaldata_model->getFields($table, $fieldsArray);
        require 'application/views/systemsetting/index.php';
        require 'application/views/_templates/footer.php';
    }

}
?>