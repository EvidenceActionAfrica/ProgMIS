<?php

class caumanager extends Controller {

    public function index($admin_territory_id = null) {

        require 'application/views/_templates/header.php';

        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories=$generaldata_model->getSidebarData("staff_category");

        $geography_model = $this->loadModel('caumanagermodel');
        $highestlevel = $geography_model->getHighestLevel($_SESSION['country']);

        if ( $admin_territory_id == null ) {
            $admin_territory_id = $highestlevel;
        } else {
            $admin_territory_id = $admin_territory_id;
        }

        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);
        $meta = $geography_model->getTerritorryMeta($admin_territory_id,$_SESSION['country']);
        $data = $geography_model->getTerritorryDetails($admin_territory_id,$_SESSION['country']);
        $parents = $geography_model->getTerritorryParents($admin_territory_id,$_SESSION['country']);

        require 'application/views/adminData/sidebar.php';
        require 'application/views/caumanager/index.php';
        require 'application/views/_templates/footer.php';
    }

    public function import() {

        require 'application/views/_templates/header.php';

        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories=$generaldata_model->getSidebarData("staff_category");

        $geography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $geography_model->getSidebarTerritorries($_SESSION['country']);

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

        if (isset($_POST['import-cau'])) {

            if (isset($_FILES['cau-csv-file'])) {

                $file = $_FILES['cau-csv-file']['tmp_name'];
                $csv = array_map('str_getcsv', file($file));

                $geography_model->importTerritorryDetails($csv);

            }

        }

        require 'application/views/adminData/sidebar.php';
        require 'application/views/caumanager/import.php';
        require 'application/views/_templates/footer.php';
    }

    public function add() {

        $addgeography_model = $this->loadModel('caumanagermodel');

        if ( isset($_POST['add-territory']) ) {

        	unset($_POST['add-territory']);
        	$_POST['id'] = null;

        	$addgeography_model->addTerritorry($_POST);

        	header('Location:'.URL.'caumanager/index/'.$_POST['admin_territory_id'].'');

        }
    }  

    public function edit($admin_territory_id, $id) {

        require 'application/views/_templates/header.php';

        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories=$generaldata_model->getSidebarData("staff_category");

        $editgeography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $editgeography_model->getSidebarTerritorries($_SESSION['country']);
        $meta = $editgeography_model->getTerritorryMeta($admin_territory_id,$_SESSION['country']);
        $data = $editgeography_model->geteditData($id);
        $parents = $editgeography_model->getParentSiblings($id);

        if ( isset( $_POST['edit_admin_territorry'] ) ) {

            unset($_POST['edit_admin_territorry']);

            $editgeography_model->editTerritorry($_POST,array('id'=>$id) );
            header('Location:'.URL.'caumanager/index/'.$admin_territory_id.'');

        } else {

            require 'application/views/adminData/sidebar.php';
            require 'application/views/caumanager/edit.php';
            require 'application/views/_templates/footer.php';

        }
    }    

    public function delete($admin_territory_id, $id, $confirm = null) {

        require 'application/views/_templates/header.php';

        $generaldata_model = $this->loadModel('generalmodel');
        $fleetCategories = $generaldata_model->getSidebarData("fleet_category");
        $contactCategories = $generaldata_model->getSidebarData("contact_category");
        $staffCategories=$generaldata_model->getSidebarData("staff_category");

        $delgeography_model = $this->loadModel('caumanagermodel');
        $sidebarterritories = $delgeography_model->getSidebarTerritorries($_SESSION['country']);
        $meta = $delgeography_model->getTerritorryMeta($admin_territory_id,$_SESSION['country']);

        if ( $confirm != null) {

            $delgeography_model->delTerritorry($id);
            header('Location:'.URL.'caumanager/index/'.$admin_territory_id.'');

        } else {

            require 'application/views/adminData/sidebar.php';
            require 'application/views/caumanager/delete.php';
            require 'application/views/_templates/footer.php';  

        }
    }


}

?>