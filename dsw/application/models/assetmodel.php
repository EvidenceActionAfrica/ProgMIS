<?php

class AssetModel extends Database {

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

    public function getData($inventory_type, $fieldsArray) {

        $query = 'SELECT ';
        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .= 'admin_assets.' . $value . ',';
            }
        }
        $query .= 'admin_countries.country AS country,field_office.office_location as office_location
        FROM admin_assets 
        JOIN admin_countries ON admin_assets.country = admin_countries.id
        JOIN field_office ON admin_assets.office_location = field_office.id
        WHERE admin_assets.inventory_type = ' . $inventory_type . ' AND admin_countries.id=' . $_SESSION["country"];

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function addData($data) {
        $dd = $this->insertdDB('admin_assets', $data);
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'Asset data added';
        $id = $data['inventory_type'];
        $query = 'SELECT inventory_type FROM admin_inventory_type WHERE id = ' . $id . '';
        $descrip = $this->selectDBraw($query)[0]['inventory_type'];
        $check_serial = $data['serial_no'];
        if($check_serial != ''){
           $serial_no =  'serialNo: '.$check_serial;
        }else{
            $serial_no = 'invoiceNo: '.$data['invoice_number'];
        }
        $description = ' asset name ' . $descrip. ' and '.$serial_no;
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function deleteData($inventory_type_id, $id, $serial_no, $inventory_type) {
        $dd = $this->deleteDB('admin_assets', array('id' => $id));
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'Asset data deleted';
        $description = ' asset name ' . $inventory_type. ' and '. $serial_no;
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function getCountryName($id) {
        $query = 'SELECT country
        FROM admin_countries 
        WHERE id = ' . $id;
        $data = $this->selectDBraw($query);

        return $data[0]['country'];
    }

    public function updateData($data, $id, $table) {
        $this->updateDB('admin_assets', $data, $id);
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = 'Asset data edited';
        $id_inv = $data['inventory_type'];
        $query = 'SELECT inventory_type FROM admin_inventory_type WHERE id = ' . $id_inv . '';
        $descrip = $this->selectDBraw($query)[0]['inventory_type'];
        $check_serial = $data['serial_no'];
        if($check_serial != ''){
           $serial_no =  'serialNo: '.$check_serial;
        }else{
            $serial_no = 'invoiceNo: '.$data['invoice_number'];
        }
        $description = ' asset name ' . $descrip. ' and '.$serial_no;
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function getFields($table, $fieldsArray = null) {
        $fields = $this->getColMeta($table, $fieldsArray);
        return $fields;
    }

    public function get_inventory_type($inventory_type) {
        $query = 'SELECT inventory_type
        FROM admin_inventory_type 
        WHERE id = ' . $inventory_type;
        $data = $this->selectDBraw($query);

        return $data[0]['inventory_type'];
    }

    public function getByPK($id, $fieldsArray) {
        $dd = $this->selectDB(
                $table = 'admin_assets', $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

}

?>