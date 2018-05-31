<?php

class fieldoffice extends Controller {

    public function index($table = null) {

        if ($table == null) {
            $table = 'chlorine_inventory';
        }

        require 'application/views/_templates/header.php'; //Because of the country session to filter data

        $index_model = $this->loadModel('fieldofficemodel');
        $fields = $index_model->getFields($table);
        $data = $index_model->getData($table);

        require 'application/views/dispenserparts/sidebar.php';
        require 'application/views/dispenserparts/fieldoffice/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function add($table = null) {

        if ($table == null) {
            $table = 'chlorine_inventory';
        }

        $add_model = $this->loadModel('fieldofficemodel');
        unset($_POST['add-dispenser-data']);
        $add_model->addData('chlorine_inventory', $_POST);

        header('Location:' . URL . 'fieldoffice/');
    }

    public function edit($id, $table = null) {

        if ($table == null) {
            $table = 'chlorine_inventory';
        }

        require 'application/views/_templates/header.php'; //Because of the country session to filter data

        $edit_model = $this->loadModel('fieldofficemodel');

        if (isset($_POST['update-dispenser-data'])) {

            unset($_POST['update-dispenser-data']);
            $edit_model->editData('chlorine_inventory', $_POST, $params = array('id' => $id));
        }

        $fields = $edit_model->getFields('chlorine_inventory');
        $record = $edit_model->getSingleRecord('chlorine_inventory', $id)[0];

        require 'application/views/dispenserparts/sidebar.php';
        require 'application/views/dispenserparts/fieldoffice/edit.php';
        require 'application/views/_templates/footer.php';
    }

    public function delete($id, $confirm = null, $table = null) {

        $delete_model = $this->loadModel('fieldofficemodel');

        if ($confirm == null) {

            require 'application/views/_templates/header.php'; //Because of the country session to filter data
            require 'application/views/dispenserparts/sidebar.php';

            $record = $delete_model->getSingleRecord('chlorine_inventory', $id)[0];

            require 'application/views/dispenserparts/fieldoffice/delete.php';
            require 'application/views/_templates/footer.php';
        } else {

            if ($table == null) {
                $table = 'chlorine_inventory';
            }
            $delete_model->deleteData($table, $params = array('id' => $id));
            header('Location:' . URL . 'fieldoffice/');
        }
    }

}

?>