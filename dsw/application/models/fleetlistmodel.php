<?php

class fleetlistmodel extends Database {

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

    public function getFleet($table, $fieldsArray = null, $WHERE = NULL) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'admin_countries.country AS country,color_category.color as color,fleet_category.type as type,field_office.office_location
					FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN color_category ON ' . $table . '.color = color_category.id'
                    . ' JOIN field_office ON ' . $table . '.office_location = field_office.id'
                    . ' JOIN fleet_category ON ' . $table . '.type = fleet_category.id';
            if ($WHERE == NULL) {
                $query.= ' AND ' . $table . '.country=' . $_SESSION["country"];
            } else {
                $query.=' WHERE ' . $table . '.type=' . $WHERE;
                $query.= ' AND ' . $table . '.country=' . $_SESSION["country"];
            }
        } else {
            $query = 'SELECT * from ' . $table;
        }

        $data = $this->selectDBraw($query);


        return $data;
    }

    public function getLogMaintenance($log, $Maintenance) {

        $query = 'SELECT ';

        foreach ($log as $key => $value) {
            $query .= "log_record." . $value . ',';
            if ($value == 'odometer_previous_reading') {
                $query.='(log_record.odometer_current_reading-log_record.odometer_previous_reading) as kilometers_covered,';
                $query.='((log_record.odometer_current_reading-log_record.odometer_previous_reading)/log_record.fuel_quantity) AS kilometer_per_litre,';
            }
            if ($value == 'fuel_cost') {
                
            }
        }

        foreach ($Maintenance as $key => $value) {
            $query .= "fleet_maintenance." . $value . ',';
        }
        $query.=' fleet_list.reg_no as reg_no,staff_list.full_name as authorizing_person';

        $query.=' from log_record';
        $query.=' JOIN fleet_list On log_record.reg_no=fleet_list.id';
        $query.= ' JOIN staff_list On log_record.authorizing_person=staff_list.id';
        $query.=' JOIN fleet_maintenance On log_record.reg_no=fleet_maintenance.reg_no';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getRegNo() {
        $query = 'SELECT id,reg_no from fleet_list WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getLogData($table, $fieldsArray = null, $WHERE = NULL) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }

            $query .= 'fleet_list.reg_no as reg_no
					FROM ' . $table
                    . ' JOIN fleet_list ON ' . $table . '.reg_no = fleet_list.id';
        }
        $query.=' WHERE fleet_list.country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function runRaw($query) {
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getData($table, $fieldsArray = null, $WHERE = NULL) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            $i = 1;
            $c = count($fieldsArray);
            foreach ($fieldsArray as $key => $value) {
                if ($i == $c) {
                    $query .= $table . "." . $value;
                } else {
                    $query .= $table . "." . $value . ',';
                }
                $i++;
            }
            $query .= '	FROM ' . $table;
        } else {
            $query.=' * from ' . $table;
        }
        $query.=' WHERE country=' . $_SESSION['country'];
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getFleetTypeId($type) {

        $query = " SELECT id from fleet_category WHERe type like '%" . $type . "%' LIMIT 1";
        $data = $this->selectDBraw($query);


        return $data[0]["id"];
    }

    public function getFleetColor($color) {


        $query = " SELECT id from color_category WHERe color like '%" . $color . "%' LIMIT 1";
        $data = $this->selectDBraw($query);

        return $data[0]["id"];
    }

    public function getOfficeLoc($office) {

        $query = " SELECT id from field_office WHERe office_location like '%" . $office . "%' AND country=" . $_SESSION['country'] . "  LIMIT 1";
        $data = $this->selectDBraw($query);
        if (!isset($data)) {
            $data[0]["id"] = null;
        }

        return $data[0]["id"];
    }

    public function getSidebarData($tableCategory) {

        $query = "SELECT * from " . $tableCategory;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function addData($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        if (!isset($_POST['update'])) {
            $action = ucwords(str_replace('_', ' ', $table)) . ' added';
        } else {
            $action = ucwords(str_replace('_', ' ', $table)) . ' edited';
        }
        if ($table == 'fleet_list') {
            $description = ' Reg. Number is ' . $data['reg_no'];
        } else {
            $description = ' detail ** unknown ';
        }
        $insertData = array(
            'id' => '',
            'country' => $country,
            'user_name' => $user_name,
            'email' => $email,
            'action' => $action,
            'description' => $description
        );
        array_pop($data);
        if (!isset($_POST['update'])) {
            $dd = $this->insertdDB($table, $data);
        }
        $this->insertdDB('admin_log_record', $insertData);
    }

    public function addDataondelete($table, $data) {
        $country = $_SESSION["country"];
        $user_name = $_SESSION["full_name"];
        $email = $_SESSION["email"];
        $action = ucwords(str_replace('_', ' ', $table)) . ' deleted';
        $description = ' Reg. Number is ' . $data;
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

    public function getByPK($table, $id, $fieldsArray) {
        $dd = $this->selectDB(
                $table, $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function deleteData($table, $id) {
        $dd = $this->deleteDB($id, $table);
    }

    public function getOffices() {

        $query = 'SELECT distinct id,office_location from field_office WHERE country=' . $_SESSION['country'] . ' ORDER BY office_location ASC';

        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getLastURL($url) {
        $tokens = explode('/', $url);
        return $tokens[sizeof($tokens) - 1];
    }

    public function getRegNum() {
        $query = 'SELECT DISTINCT reg_no from fleet_list WHERE country=' . $_SESSION['country'] . ' ORDER BY reg_no ASC';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getRegNumLog() {
        $query = 'SELECT DISTINCT RegNum from fleet_log_view WHERE country=' . $_SESSION['country'] . ' ORDER BY RegNum ASC';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDataLog($data) {
        $query = 'SELECT * from fleet_log_view WHERE RegNum="' . $data['RegNum'] . '" ORDER BY Date DESC LIMIT 6';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDataMaint($data) {
        $query = 'SELECT * from fleet_maintenance WHERE RegNum="' . $data['RegNum'] . '" ORDER BY Date DESC LIMIT 6';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDataLogTotal($data) {
        $query = 'SELECT * from fleet_log_view WHERE RegNum="' . $data['RegNum'] . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDataMaintTotal($data) {
        $query = 'SELECT * from fleet_maintenance WHERE RegNum="' . $data['RegNum'] . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDateYearLogMaint($categ) {
        $query = '(SELECT DISTINCT Year FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '")
            UNION (SELECT DISTINCT Year FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '") ORDER BY Year';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getDateDayLogMaint($categ, $week, $month, $year) {
        $query = '(SELECT DISTINCT Day FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $week . $month . $year . ')
            UNION (SELECT DISTINCT Day FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $week . $month . $year . ') ORDER BY Day';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getOffDayLogMaint($week, $month, $year) {
        $query = '(SELECT DISTINCT Day FROM fleet_log_view WHERE country=' . $_SESSION['country'] . $week . $month . $year . ')
            UNION (SELECT DISTINCT Day FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . $week . $month . $year . ') ORDER BY Day';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getDateWeekLogMaint($categ, $year) {
        $query = '(SELECT DISTINCT Week FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $year . ')
            UNION (SELECT DISTINCT Week FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $year . ') ORDER BY Week';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getOffWeekLogMaint($year) {
        $query = '(SELECT DISTINCT Week FROM fleet_log_view WHERE country=' . $_SESSION['country'] . $year . ')
            UNION (SELECT DISTINCT Week FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . $year . ') ORDER BY Week';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getOffYearLogMaint() {
        $query = '(SELECT DISTINCT Year FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ')
            UNION (SELECT DISTINCT Year FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ') ORDER BY Year';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getRegLogMaint($categ, $day, $week, $month, $year) {
        $query = '(SELECT DISTINCT RegNum FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $day . $week . $month . $year . ') UNION
                  (SELECT DISTINCT RegNum FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '"' . $day . $week . $month . $year . $day . ')  ORDER BY RegNum';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getOffLogMaint($day, $week, $month, $year) {
        $query = '(SELECT DISTINCT office_location FROM fleet_log_view WHERE country=' . $_SESSION['country'] . $day . $week . $month . $year . ') UNION
                  (SELECT DISTINCT office_location FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . $day . $week . $month . $year . ')  ORDER BY office_location';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getDataMaintOnly($categ, $day, $week, $month, $year, $RegNum) {
        $query = '(SELECT SUM(MaintCost) as total_maint FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '" AND RegNum = "' . $RegNum . '" ' . $day . $week . $month . $year . ') ';
        $data= $this->selectDBraw($query);
        return $data;
    }

    public function getDataLogOnly($categ, $day, $week, $month, $year, $RegNum) {
        $query = '(SELECT SUM(FuelCost) as total_Fuel,
            SUM(KilometerCov) as total_Kilometer,
            SUM(FuelQuant) as total_FuelQuant
            FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND type = "' . $categ . '" AND RegNum = "' . $RegNum . '" ' . $day . $week . $month . $year . ') ';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getDataMaintCum($day, $week, $month, $year, $Office) {
        $query = '(SELECT SUM(MaintCost) as sum_maint_cost FROM fleet_maintenance_view WHERE country=' . $_SESSION['country'] . ' AND office_location = "' . $Office . '" ' . $day . $week . $month . $year . ') ';
        $data= $this->selectDBraw($query);
        return $data;
    }

    public function getDataLogCum($day, $week, $month, $year, $Office) {
        $query = '(SELECT SUM(FuelCost) as sum_fuel_cost FROM fleet_log_view WHERE country=' . $_SESSION['country'] . ' AND office_location = "' . $Office . '" ' . $day . $week . $month . $year . ') ';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getPriv() {
        $column_priv = 'priv_fleet_list_' . strtolower($_SESSION['countryName']);
        $query = 'SELECT ' . $column_priv . ' FROM staff_list WHERE email ="' . $_SESSION["email"] . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function AddEditDelete($data, $table) {
        if (!isset($_POST['delete'])) {
            if ($table == 'fleet_log') {
                if ($data['fuel_quant'] == 0 || $data['fuel_quant'] == '') {
                    $Kilometer_p_Liter = 'Unknown';
                } else {
                    $Kilometer_p_Liter = ($data['cur_fuel_read'] - $data['prev_fuel_read']) / $data['fuel_quant'];
                }
                $dataInsert = array(
                    "ID" => "",
                    "RegNum" => $data['RegNum'],
                    "Date" => date('Y-m-d', strtotime($data['date'])),
                    "FuelQuant" => $data['fuel_quant'],
                    "CurrentFuelRead" => $data['cur_fuel_read'],
                    "PreviousFuelRead" => $data['prev_fuel_read'],
                    "KilometerCov" => $data['cur_fuel_read'] - $data['prev_fuel_read'],
                    "Kilometer_p_Liter" => $Kilometer_p_Liter,
                    "FuelCost" => $data['fuel_cost'],
                    "AuthPerson" => $data['auth_person'],
                    "AuthSigne" => $data['auth_signe'],
                    "Rider" => $data['rider'],
                    "Comment" => $data['comment']
                );
            } else {
                $dataInsert = array(
                    "ID" => "",
                    "RegNum" => $data['RegNum'],
                    "Date" => date('Y-m-d', strtotime($data['date'])),
                    "Category" => $data['category'],
                    "Description" => $data['description'],
                    "TotalCost" => $data['total_cost'],
                    "OutMater_indicate" => $data['outsource_materials'],
                    "OutMater_TCost" => $data['out_source_materials_cost'],
                    "OutLabour" => $data['out_source_labour_cost'],
                    "Out_work_performed" => $data['description__work_perf'],
                    "OdometerReading" => $data['odometer_reading']
                );
            }
        }
        if (isset($_POST['add'])) {
            $verbaction = 'added';
            unset($_POST['add']);
            $this->insertdDB($table, $dataInsert);
        } else if (isset($_POST['edit'])) {
            $verbaction = 'edited';
            unset($_POST['edit']);
            $params = array(
                "ID" => $data['edit_RegNum']
            );
            $this->updateDBparams($table, $dataInsert, $params);
        } else if (isset($_POST['delete'])) {
            $params = array(
                "ID" => $data['Delete_RegNum']
            );

            $this->deleteDB($table, $params);
        }
        if (!isset($_POST['delete'])) {
            $country = $_SESSION["country"];
            $user_name = $_SESSION["full_name"];
            $email = $_SESSION["email"];
            $data_reg = $data['RegNum'];
            $action = ucwords(str_replace('_', ' ', $table)) . ' ' . $verbaction;
            $description = ' Reg. Number is ' . $data_reg;
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
    }

}

?>