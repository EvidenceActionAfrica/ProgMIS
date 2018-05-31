<?php

/**
 * 
 */
class login extends Database {

    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        session_start();
        try {
            $this->db = $db;
            echo "<pre>";
            var_dump($db);
            echo "</pre>";
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function validate() {
        // echo "Validate";
        // exit();
        $arg_list = func_get_args();
        //echo 'priv_'.$arg_list[2];
        $dd = $this->selectDB(
                $table = 'staff_list', $filds = null, $params = array('email' => $arg_list[0], 'password' => $arg_list[1], 'priv_' . $arg_list[2] => $arg_list[3]), $operator = 'AND'
        );

        /*
          echo "<pre>";
          var_dump($dd);
          echo "</pre>";
          exit();
         */
        $count = $this->count();

        return $count;
    }

    public function getByID($email) {
        $rows = $this->selectDB(
                $table = "staff_list", $filds = null, $params = array('email' => $email)
        );

         $query = 'SELECT issues.issue_status,waterpoint_details.waterpoint_id  from issues ' 
        .' JOIN waterpoint_details ON waterpoint_details.waterpoint_id=issues.waterpoint_id '
        . ' WHERE full_name=' . $rows[0]['id'].' AND complete=0';
        $issues = $this->selectDBraw($query);
        $issueSize=sizeof($issues);

        $query = 'SELECT id from admin_countries WHERE country="' . $_POST['country'] . '"';
        //   echo $query;
        $countryIdentity = $this->selectDBraw($query);
        //Position Of The User Logging in
        
        $query='SELECT staff_category.position as position from staff_list JOIN staff_category ON staff_list.position=staff_category.id WHERE staff_list.email="'.$email.'"';
         
        $staffPosition = $this->selectDBraw($query);
        
        
        $data = array(); //create the array
        foreach ($rows as $key => $row) {
            $data[] = array(
                'email' => $row['email'],
                'country' => $countryIdentity[0]["id"],
                'id' => $row['id'],
                'issueNo' => $issueSize,
                'countryName' => $_POST["country"],
                'position' => $row["position"],
                'positionName' => $staffPosition[0]["position"],
                'full_name' => $row['full_name'],
                'priv_kenya' => $row['priv_kenya'],
                'priv_uganda' => $row['priv_uganda'],
                'priv_malawi' => $row['priv_malawi'],
                'priv_asset_list_kenya' => $row['priv_asset_list_kenya'],
                'priv_asset_list_malawi' => $row['priv_asset_list_malawi'],
                'priv_asset_list_uganda' => $row['priv_asset_list_uganda'],
                'priv_fleet_list_kenya' => $row['priv_fleet_list_kenya'],
                'priv_fleet_list_malawi' => $row['priv_fleet_list_malawi'],
                'priv_fleet_list_uganda' => $row['priv_fleet_list_uganda'],
                'priv_staff_list_kenya' => $row['priv_staff_list_kenya'],
                'priv_staff_list_malawi' => $row['priv_staff_list_malawi'],
                'priv_staff_list_uganda' => $row['priv_staff_list_uganda'],
                'priv_village_list_kenya' => $row['priv_village_list_kenya'],
                'priv_village_list_malawi' => $row['priv_village_list_malawi'],
                'priv_village_list_uganda' => $row['priv_village_list_uganda'],
                'priv_waterpoint_list_kenya' => $row['priv_waterpoint_list_kenya'],
                'priv_waterpoint_list_malawi' => $row['priv_waterpoint_list_malawi'],
                'priv_waterpoint_list_uganda' => $row['priv_waterpoint_list_uganda'],
                'priv_chlorine_inventory_kenya' => $row['priv_chlorine_inventory_kenya'],
                'priv_chlorine_inventory_malawi' => $row['priv_chlorine_inventory_malawi'],
                'priv_chlorine_inventory_uganda' => $row['priv_chlorine_inventory_uganda'],
                'priv_chlorine_planning_kenya' => $row['priv_chlorine_planning_kenya'],
                'priv_chlorine_planning_malawi' => $row['priv_chlorine_planning_malawi'],
                'priv_chlorine_planning_uganda' => $row['priv_chlorine_planning_uganda'],
                'priv_chlorine_tracking_kenya' => $row['priv_chlorine_tracking_kenya'],
                'priv_chlorine_tracking_malawi' => $row['priv_chlorine_tracking_malawi'],
                'priv_chlorine_tracking_uganda' => $row['priv_chlorine_tracking_uganda'],
                'priv_evaluation_kenya' => $row['priv_evaluation_kenya'],
                'priv_evaluation_malawi' => $row['priv_evaluation_malawi'],
                'priv_evaluation_uganda' => $row['priv_evaluation_uganda'],
                'priv_fleet_manager_planning_kenya' => $row['priv_fleet_manager_planning_kenya'],
                'priv_fleet_manager_planning_malawi' => $row['priv_fleet_manager_planning_malawi'],
                'priv_fleet_manager_planning_uganda' => $row['priv_fleet_manager_planning_uganda'],
                'priv_fleet_manager_tracking_kenya' => $row['priv_fleet_manager_tracking_kenya'],
                'priv_fleet_manager_tracking_malawi' => $row['priv_fleet_manager_tracking_malawi'],
                'priv_fleet_manager_tracking_uganda' => $row['priv_fleet_manager_tracking_uganda'],
                'priv_promoter_engagement_kenya' => $row['priv_promoter_engagement_kenya'],
                'priv_promoter_engagement_malawi' => $row['priv_promoter_engagement_malawi'],
                'priv_promoter_engagement_uganda' => $row['priv_promoter_engagement_uganda'],
                'priv_dispenser_kenya' => $row['priv_dispenser_kenya'],
                'priv_dispenser_malawi' => $row['priv_dispenser_malawi'],
                'priv_dispenser_uganda' => $row['priv_dispenser_uganda'],
                'priv_issue_tracker_kenya' => $row['priv_issue_tracker_kenya'],
                'priv_issue_tracker_malawi' => $row['priv_issue_tracker_malawi'],
                'priv_issue_tracker_uganda' => $row['priv_issue_tracker_uganda'],
                'priv_evaluation_kenya' => $row['priv_evaluation_kenya'],
                'priv_evaluation_malawi' => $row['priv_evaluation_malawi'],
                'priv_evaluation_uganda' => $row['priv_evaluation_uganda'],
                'priv_expansion_kenya' => $row['priv_expansion_kenya'],
                'priv_expansion_malawi' => $row['priv_expansion_malawi'],
                'priv_expansion_uganda' => $row['priv_expansion_uganda'],
                'priv_on_demand_kenya' => $row['priv_on_demand_kenya'],
                'priv_on_demand_malawi' => $row['priv_on_demand_malawi'],
                'priv_on_demand_uganda' => $row['priv_on_demand_uganda'],
                'priv_other_kenya' => $row['priv_other_kenya'],
                'priv_other_malawi' => $row['priv_other_malawi'],
                'priv_other_uganda' => $row['priv_other_uganda'],
                'priv_standard_reports_kenya' => $row['priv_standard_reports_kenya'],
                'priv_standard_reports_malawi' => $row['priv_standard_reports_malawi'],
                'priv_standard_reports_uganda' => $row['priv_standard_reports_uganda'],
                'priv_diagnostic_kenya' => $row['priv_diagnostic_kenya'],
                'priv_diagnostic_malawi' => $row['priv_diagnostic_malawi'],
                'priv_diagnostic_uganda' => $row['priv_diagnostic_uganda']
            );
        }

        return $data;
    }

}

// end class
?>