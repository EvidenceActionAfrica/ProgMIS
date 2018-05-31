<?php

class issuetrackermodel extends Database {

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
            /*
              $query .= 'admin_countries.country AS country,staff_list.full_name As raisedby,staff_list.full_name As handledby
              FROM '.$table.'
              JOIN admin_countries ON '.$table.'.country = admin_countries.id'.
              ' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';

             */
            $query .= 'admin_countries.country AS country,staff_list.full_name as full_name,issues_category.category as category,
                issues_category.sub_category as sub_category,field_office.office_location as office_location,issue_status.issue_status as issue_status
                ,waterpoint_details.waterpoint_name as waterpoint_name, waterpoint_details.program as program           
            
             FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' JOIN issues_category ON ' . $table . '.sub_category = issues_category.id '
                    . '  JOIN waterpoint_details ON ' . $table . '.waterpoint_id=waterpoint_details.waterpoint_id'
                    . ' JOIN field_office ON ' . $table . '.office_location = field_office.id'
                    . ' JOIN issue_status ON ' . $table . '.issue_status = issue_status.id'
                    . ' WHERE complete !=1'
                    . ' AND '
                    . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id  ASC';


            //	.' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';
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

    public function getCompleted($table = "issues", $fieldsArray) {

        $query = 'SELECT ';

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
            }
            /*
              $query .= 'admin_countries.country AS country,staff_list.full_name As raisedby,staff_list.full_name As handledby
              FROM '.$table.'
              JOIN admin_countries ON '.$table.'.country = admin_countries.id'.
              ' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';

             */
            $query .= 'admin_countries.country AS country,staff_list.full_name as full_name,issues_category.category as category,
                issues_category.sub_category as sub_category,field_office.office_location as office_location,issue_status.issue_status as issue_status
					       ,waterpoint_details.waterpoint_name as waterpoint_name, waterpoint_details.program as program
          FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' JOIN issues_category ON ' . $table . '.sub_category = issues_category.id '
                    . ' JOIN waterpoint_details ON ' . $table . '.waterpoint_id = waterpoint_details.waterpoint_id'
                    . ' JOIN field_office ON ' . $table . '.office_location = field_office.id'
                    . ' JOIN issue_status ON ' . $table . '.issue_status = issue_status.id'
                    . ' WHERE complete=1'
                    . ' AND '
                    . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id  ASC';


            //	.' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';
        } else {
            $query = 'SELECT * from ' . $table . ' WHERE ' . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id ';
        }
        // echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getApprovedData($table, $fieldsArray = null, $approved = "No", $status = null) {

        $query = 'SELECT ';
        $assigned = ""; //Used in Assigning staff_list name to Previously Assigned if displayed

        if (!empty($fieldsArray)) {

            foreach ($fieldsArray as $key => $value) {
                $query .= $table . "." . $value . ',';
                if ($value == "previously_assigned") {
                    //This is To Help Turn Previously Assigned from An integer in issues To a Name 
                    $assigned = true;
                }
            }
            /*
              $query .= 'admin_countries.country AS country,staff_list.full_name As raisedby,staff_list.full_name As handledby
              FROM '.$table.'
              JOIN admin_countries ON '.$table.'.country = admin_countries.id'.
              ' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';

             */
            $query .= 'admin_countries.country AS country,staff_list.full_name as full_name,issues_category.category as category,
                issues_category.sub_category as sub_category,field_office.office_location as office_location,issue_status.issue_status as issue_status,
                waterpoint_details.waterpoint_name as waterpointName, waterpoint_details.program as program';

            if ($assigned == true) {
                $query.=',staff_list.full_name as previously_assigned ';
            }
            $query.='  FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id '
                    . ' JOIN staff_list ON ' . $table . '.full_name = staff_list.id '
                    . ' JOIN issues_category ON ' . $table . '.sub_category = issues_category.id '
                    . ' JOIN field_office ON ' . $table . '.office_location = field_office.id'
                    . ' JOIN waterpoint_details ON ' . $table . '.waterpoint_id = waterpoint_details.waterpoint_id'
                    . ' JOIN issue_status ON ' . $table . '.issue_status = issue_status.id';
            if ($approved != "Yes" && $approved != "redo") {
                $query.=' WHERE approved !="Yes"';
            } else if ($approved == "redo") {
                $query.=' WHERE approved ="redo"';
            } else {
                $query.=' WHERE approved ="Yes"';
            }
            if ($status != null) {
                switch ($status) {

                    case 1:
                        $query.=" AND issues.issue_status =" . $status;
                        break;
                    case 2:
                        $query.=" AND issues.issue_status !=1";
                        break;
                    case 3:
                        $query.=" AND issues.issue_status !=1";
                        break;
                    case 4:
                        $query.=" AND issues.issue_status !=1";
                        break;
                    default:
                        $query.=" AND issues.issue_status =" . $status;
                        break;
                }
            }
            $query.=' AND '
                    . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id  ASC';


            //	.' JOIN staff_list ON '.$table.'.raisedby = staff_list.id';
        } else {
            $query = 'SELECT * from ' . $table . ' WHERE ' . $table . '.country=' . $_SESSION["country"] . ' ORDER BY ' . $table . '.id ';
        }
        // echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getCategoryData($table) {

        $query = 'SELECT * from ' . $table . ' ORDER BY ' . $table . '.id ';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function updateStatus($issueStatus, $issueId) {
        $query = 'SELECT * from ' . $table . ' ORDER BY ' . $table . '.id ';
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function getStaffDropDown() {
        $query = 'SELECT id,full_name from staff_list WHERE country=' . $_SESSION['country'] . ' ORDER by full_name';
        $data = $this->selectDBraw($query);
        return $data;
    }
    
    public function getSmsDropDown() {
        $query = 'SELECT id,template_name from issue_message_templates  ORDER by template_name';
        $data = $this->selectDBraw($query);
        return $data;
    }  
    
    public function getStaffInfo($staffName) {
        $query = 'SELECT phone,email from staff_list WHERE full_name="' . $staffName . '" AND country=' . $_SESSION['country'] . ' ORDER by full_name';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getCategoryDropDown() {
        $query = 'SELECT  id,category from issues_category  GROUP BY category ORDER by category';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getOfficeLocationDropDown() {
        $query = 'SELECT id,office_location from field_office WHERE country=' . $_SESSION['country'] . ' ORDER by office_location';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getIssueStatusDropDown() {
        $query = 'SELECT id,issue_status from issue_status';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function checkWaterpointId($waterpointId) {

        $query = 'SELECT count(waterpoint_id) as exist, country from waterpoint_details WHERE waterpoint_id="' . $waterpointId . '"';
        $data = $this->selectDBraw($query);
        return $data;
    }

    public function getSpecificData($table, $fieldsArray = null, $dataId) {

        $query = 'SELECT ';
        if (!empty($fieldsArray)) {
            foreach ($fieldsArray as $key => $value) {
                $query .=$table . "." . $value . ',';
            }
            $query .= 'admin_countries.country AS country,issue_status.issue_status as issue_status
          FROM ' . $table
                    . ' JOIN admin_countries ON ' . $table . '.country = admin_countries.id'
                    . ' JOIN issue_status ON ' . $table . '.issue_status = issue_status.id  WHERE ' . $table . '.issue_id=' . $dataId
                    . ' AND admin_countries.id=' . $_SESSION["country"];
        } else {
            $query = "SELECT * from " . $table . " WHERE issue_id=" . $dataId . ' AND country=' . $_SESSION["country"];
        }
        //    echo $query;
        $data = $this->selectDBraw($query);

        return $data;
    }

    public function addData($table, $data) {

        array_pop($data);

        $dd = $this->insertdDB($table, $data);
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
                $table = 'issues', $filds = $fieldsArray, $params = array('id' => $id)
        );
        return $dd;
    }

    public function deleteData($table, $id) {
        // echo $id;
        // $query="DELETE FROM admin_assets WHERE id ='$id'";
        // $this->deleteDB($query,$id,'admin_assets');
        $dd = $this->deleteDB($table, $id);
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

    // public function getIssueStatId($status){
    //     $query='SELECT id from issue_status WHERE issue_status="'.$status.'" LIMIT 1';
    //     $data=$this->selectDBraw($query);
    //     if($data !=null){
    //     return $data[0]['id'];
    //   }else{
    //     return false;
    //   }
    // }
}

?>