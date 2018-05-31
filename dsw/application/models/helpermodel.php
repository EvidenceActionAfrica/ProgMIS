<?php

class helpermodel extends Database {

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

    /**
     * Description : get the columns of a table.
     *
     * @param  string  	$table
     * @param  mixed  	$fieldsArray
     * @return mixed 	$fields
     */
    public function getFields($table, $fieldsArray = null) {
        $fields = $this->getColMeta($table, $fieldsArray);
        return $fields;
    }

    /**
     * Description : adds data to the db.
     *
     * @param string  $table
     * @param mixed  $data
     */
    public function addData($table, $data) {
        // echo "<pre>";var_dump($data);echo "</pre>";
        array_pop($data);
        $dd = $this->insertdDB($table, $data);
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
    public function getPending(){


          $query = 'SELECT issues.issue_status,waterpoint_details.waterpoint_id  from issues ' 
        .' JOIN waterpoint_details ON waterpoint_details.waterpoint_id=issues.waterpoint_id '
        . ' WHERE full_name=' .$_SESSION["id"].' AND complete=0';
        $issues = $this->selectDBraw($query);
        $issueSize=sizeof($issues);
        return $issueSize;
    }

    /**
     * Description : Replace the underscore with spaces and mail(to, subject, message)ake the strings uppercase.
     *
     * @param string  $header
     * @return mixed  $data
     *
     */
    public function relace_upper($header) {
        $data = array();
        // $data[]="ID"; // this will the first title
        foreach ($header as $key => $value) {
            $string1 = str_replace("_", " ", $value);
            $string2 = strtoupper($string1);
            $data[] = $string2;
        }

        return $data;
    }

    public static function replace_upper_string($string) {
        $string = str_replace("_", " ", $string);
        $string = ucwords($string);

        return $string;
    }

    /*
     * This function Assigns the active Privilege To be Checked
     * NB:Requires Revision Later,Mosttly because its manual & general & process controllers
     * serve more than one table.
     * For Those representing more than one table, 
     * Privileges are assigned according to the table(parameter) passed.
     * 
     * Possible Revision Changes would be
     * 1. Rename All the controllers to have the same name as the privilege so as
     *  to generate the privilege automatically.
     */

    public function accessAssigner($controller, $country) {
        
        // echo "<pre>";var_dump($controller[0]);echo "</pre>";
        // exit();
        switch ($controller[0]) {
            case "adminData":
                $privCheck = "priv_asset_list_" . $country;
                return $privCheck;
            case "caumanager":
                $privCheck = "priv_asset_list_" . $country;
                return $privCheck;              
            case "assetData":
                $privCheck = "priv_asset_list_" . $country;
                return $privCheck;
             case "workshop":
                $privCheck = "priv_asset_list_" . $country;
                return $privCheck;
            case "contactList":
                $privCheck = "priv_asset_list_" . $country;
                return $privCheck;
            case "generalclass":

                 if(isset($controller[1])=="villageContacts"){
                        $privCheck = "priv_village_list_" . $country;
                      //echo $_SESSION[$privCheck];
                    }

                if(isset($controller[2])){
                    if($controller[2]=="fleet_list"){
                        $privCheck = "priv_fleet_list_" . $country;
                   
                    }else if($controller[2]=="waterpoints"){
                        $privCheck = "priv_waterpoint_list_" . $country;

                    }else if($controller[2]=="staff_list"){
                        $privCheck = "priv_staff_list_" . $country;

                    }else if($controller[2]=="issues_categories"){
                        $privCheck = "priv_issue_tracker_" . $country;

                    }else if($controller[2]=="promoter_details"){
                        $privCheck = "priv_promoter_engagement_" . $country;

                    }else if($controller[2]=="assistant_promoter_details"){
                        $privCheck = "priv_promoter_engagement_" . $country;

                    }else if($controller[2]=="village_details"){
                         $privCheck = "priv_village_list_" . $country;

                    }else{
                        $privCheck = "priv_staff_list_" . $country;
                    }

                }else{
                    //echo "False";
                     $privCheck = "priv_staff_list_" . $country;
               }

                return $privCheck;
            case "fleetclass":
                     $privCheck = "priv_fleet_manager_planning_" . $country;
                return $privCheck;
           
            case "home":
                $privCheck = "priv_" . $country;
                return $privCheck;
            case "issuetracker":
                $privCheck = "priv_issue_tracker_" . $country;
                return $privCheck;
            case "chlorineclass":
                $privCheck = "priv_chlorine_inventory_" . $country;
                return $privCheck;
            case "cdelivery":
                $privCheck = "priv_chlorine_inventory_" . $country;
             return $privCheck;
            case "uasettings":
                $privCheck = "priv_staff_list_" . $country;
                return $privCheck;
            case "expansion":
                $privCheck = "priv_expansion_" . $country;
                return $privCheck;
            case "scheduler":
                $privCheck = "priv_expansion_" . $country;
                return $privCheck;
            case "processdata":
                if(isset($controller[2])){
                    if($controller[2]=="promoter_details"){
                        $privCheck = "priv_promoter_engagement_" . $country;
                    }else if($controller[2]=="promoter_call_log"){
                        $privCheck = "priv_promoter_engagement_" . $country;
                   
                    }else if($controller[2]=="promoter_sms_log"){
                        $privCheck = "priv_promoter_engagement_" . $country;
                   
                    }else{
                        $privCheck = "priv_staff_list_" . $country;
                    }
                                       
                    }else{
                        $privCheck = "priv_staff_list_" . $country;
                    }

                    return $privCheck;
            case "importclass":
                if(isset($controller[2])){

                    if($controller[2]=="promoter_details"){
                        $privCheck = "priv_promoter_engagement_" . $country;
                      }

                    if($controller[2]=="fleet_list"){
                        $privCheck = "priv_fleet_list_" . $country;
                   
                    }else if($controller[2]=="waterpoints"){
                        $privCheck = "priv_waterpoint_list_" . $country;

                    }else if($controller[2]=="staff_list"){
                        $privCheck = "priv_staff_list_" . $country;

                    }else if($controller[2]=="issues_categories"){
                        $privCheck = "priv_issue_tracker_" . $country;

                    }else if($controller[2]=="verification_track"){
                        $privCheck = "priv_expansion_" . $country;
                    }else if($controller[2]=="vcs_meetings_tracker"){
                        $privCheck = "priv_expansion_" . $country;
                    }else if($controller[2]=="village_details"){
                        $privCheck = "priv_expansion_" . $country;
                    }else if($controller[2]=="village_details2"){
                        $privCheck = "priv_village_list_" . $country;
                    }else if($controller[2]=="admin_assets"){
                         $privCheck = "priv_asset_list_" . $country;
                    }else if($controller[2]=="cau_programs"){
                         $privCheck = "priv_village_list_" . $country;
                    }else if($controller[2]=="chlorine_inventory"){
                         $privCheck = "priv_chlorine_inventory_" . $country;
                    }else if($controller[2]=="fleet_maintenance"){
                         $privCheck = "priv_fleet_manager_planning_" . $country;
                    }else if($controller[2]=="fleet_log"){
                         $privCheck = "priv_fleet_manager_planning_" . $country;
                    }


                }else{
                  $privCheck = "priv_staff_list_" . $country;;
                }
                return $privCheck;
           
            default:
                $privCheck = "priv_" . $country;
                return $privCheck;
       

        }
    }

    public function zeroAccess($privCheck, $relocation) {

        if (!isset($_SESSION["email"])) {

            session_start();
        }
        // echo $privCheck;
        // echo $relocation;
        // echo $destination;
        // exit();

        if ($privCheck <=0) {
        
            $message=urlencode('You lack the privilege to perform such action');
            header('Location:'.URL.'home/?message='.$message);
            exit();
        }
    }

    public function addAccess($privCheck, $relocation) {
       // exit();
        $this->zeroAccess($privCheck, $relocation);
        if (!isset($_SESSION["email"])) {

            session_start();
        }
        // echo $privCheck;
        // echo $relocation[1];
        // echo $destination;
        // exit();

        if ($privCheck >= 2 && $privCheck!=0) {
            
        } else {
        //      echo $privCheck;
        // echo $relocation[1];
        // echo $destination;
        // exit();
           //$path= $relocation[0];
            //unset($relocation);
            $message=urlencode('You lack the privilege to perform such action');
            header('Location:'.URL.'home/?message='.$message);
            exit();
        }
    } 

    public function editAccess($privCheck, $relocation) {
        $this->zeroAccess($privCheck, $relocation);
        if (!isset($_SESSION["email"])) {

            session_start();
        }
         //echo $privCheck;
        
        // echo $destination;
        // exit();

        if ($privCheck>=3 && $privCheck!=0) {
        
          }else{ // unset($relocation[1]);
         
             $message=urlencode('You lack the privilege to perform such action.');
            header('Location:'.URL.'home/?message='.$message);
          
        }
    }

    public function deleteAccess($privCheck, $relocation) {
        $this->zeroAccess($privCheck, $relocation);
        if (!isset($_SESSION["email"])) {

            session_start();
        }
        // echo $privCheck;
        // echo $relocation;
        // echo $destination;
        // exit();

        if ($privCheck >= 4) {
            
        } else {
            unset($relocation[1]);
             $message=urlencode('You lack the privilege to perform such action');
            header('Location:'.URL.'home/?message='.$message);
            exit();
        }
    }


    public function getSidebarData($tableCategory) {


        $query = "SELECT * from ".$tableCategory;
        
        $data = $this->selectDBraw($query);

        return $data;
    }

}

// end class
