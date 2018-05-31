<?php

/**
 * 
 */
class LoginForm extends Controller {

    public $model;

    public function index() {

        //check if they are already logged in

        if (!isset($_SESSION['email'])) {

            require 'application/views/_templates/plain_header.php';
            // require 'application/views/assetData/sidebar.php';
            require 'application/views/login/index.php';
            require 'application/views/_templates/footer.php';
        } else {
            //redirect to admin data
            header("Location:" . URL . "home");
        }
    }

    public function login() {
        // get the post

        $this->model = $this->loadModel('login');
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['country'])) {
            //  echo "priv_".$_POST["country"];
            $validate = $this->model->validate($_POST['email'], $_POST[MD5('password')], $_POST["country"], 1);

            if ($validate != 0) {

                // get  all the data
                $data = $this->model->getByID($_POST['email']);

                /*
                  echo "<pre>";
                  var_dump($data);
                  echo "</pre>";
                  exit();

                 */
                // set the session
                session_start();
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['country'] = $data[0]['country'];
                $_SESSION['id'] = $data[0]['id'];
                $_SESSION['full_name'] = $data[0]['full_name'];
                //$_SESSION['country']=$data[0]['country'];
                $_SESSION['countryName'] = ucwords($_POST['country']);
                $_SESSION['issueNo'] = $data[0]['issueNo'];
                $_SESSION['position']= $data[0]['position'];
               $_SESSION['positionName']= $data[0]['positionName'];
               
                /*
                 * Privilege Sesssion settings Start
                 * 
                 */

                $_SESSION["priv_uganda"] = $data[0]['priv_uganda'];
                $_SESSION["priv_malawi"] = $data[0]['priv_malawi'];
                $_SESSION["priv_kenya"] = $data[0]['priv_kenya'];


                $_SESSION["priv_asset_list_kenya"] = $data[0]['priv_asset_list_kenya'];
                $_SESSION["priv_asset_list_malawi"] = $data[0]['priv_asset_list_malawi'];
                $_SESSION["priv_asset_list_uganda"] = $data[0]['priv_asset_list_uganda'];

                $_SESSION["priv_fleet_list_kenya"] = $data[0]['priv_fleet_list_kenya'];
                $_SESSION["priv_fleet_list_malawi"] = $data[0]['priv_fleet_list_malawi'];
                $_SESSION["priv_fleet_list_uganda"] = $data[0]['priv_fleet_list_uganda'];

                $_SESSION["priv_staff_list_kenya"] = $data[0]['priv_staff_list_kenya'];
                $_SESSION["priv_staff_list_malawi"] = $data[0]['priv_staff_list_malawi'];
                $_SESSION["priv_staff_list_uganda"] = $data[0]['priv_staff_list_uganda'];


                $_SESSION["priv_village_list_kenya"] = $data[0]['priv_village_list_kenya'];
                $_SESSION["priv_village_list_malawi"] = $data[0]['priv_village_list_malawi'];
                $_SESSION["priv_village_list_uganda"] = $data[0]['priv_village_list_uganda'];


                $_SESSION["priv_waterpoint_list_kenya"] = $data[0]['priv_waterpoint_list_kenya'];
                $_SESSION["priv_waterpoint_list_malawi"] = $data[0]['priv_waterpoint_list_malawi'];
                $_SESSION["priv_waterpoint_list_uganda"] = $data[0]['priv_waterpoint_list_uganda'];


                $_SESSION["priv_chlorine_inventory_kenya"] = $data[0]['priv_chlorine_inventory_kenya'];
                $_SESSION["priv_chlorine_inventory_malawi"] = $data[0]['priv_chlorine_inventory_malawi'];
                $_SESSION["priv_chlorine_inventory_uganda"] = $data[0]['priv_chlorine_inventory_uganda'];


                $_SESSION["priv_chlorine_planning_kenya"] = $data[0]['priv_chlorine_planning_kenya'];
                $_SESSION["priv_chlorine_planning_malawi"] = $data[0]['priv_chlorine_planning_malawi'];
                $_SESSION["priv_chlorine_planning_uganda"] = $data[0]['priv_chlorine_planning_uganda'];


                $_SESSION["priv_chlorine_tracking_kenya"] = $data[0]['priv_chlorine_tracking_kenya'];
                $_SESSION["priv_chlorine_tracking_malawi"] = $data[0]['priv_chlorine_tracking_malawi'];
                $_SESSION["priv_chlorine_tracking_uganda"] = $data[0]['priv_chlorine_tracking_uganda'];



                $_SESSION["priv_evaluation_kenya"] = $data[0]['priv_evaluation_kenya'];
                $_SESSION["priv_evaluation_malawi"] = $data[0]['priv_evaluation_malawi'];
                $_SESSION["priv_evaluation_uganda"] = $data[0]['priv_evaluation_uganda'];


                $_SESSION["priv_fleet_manager_planning_kenya"] = $data[0]['priv_fleet_manager_planning_kenya'];
                $_SESSION["priv_fleet_manager_planning_malawi"] = $data[0]['priv_fleet_manager_planning_malawi'];
                $_SESSION["priv_fleet_manager_planning_uganda"] = $data[0]['priv_fleet_manager_planning_uganda'];


                $_SESSION["priv_fleet_manager_tracking_kenya"] = $data[0]['priv_fleet_manager_tracking_kenya'];
                $_SESSION["priv_fleet_manager_tracking_malawi"] = $data[0]['priv_fleet_manager_tracking_malawi'];
                $_SESSION["priv_fleet_manager_tracking_uganda"] = $data[0]['priv_fleet_manager_tracking_uganda'];


                $_SESSION["priv_promoter_engagement_kenya"] = $data[0]['priv_promoter_engagement_kenya'];
                $_SESSION["priv_promoter_engagement_malawi"] = $data[0]['priv_promoter_engagement_malawi'];
                $_SESSION["priv_promoter_engagement_uganda"] = $data[0]['priv_promoter_engagement_uganda'];



                $_SESSION["priv_dispenser_kenya"] = $data[0]['priv_dispenser_kenya'];
                $_SESSION["priv_dispenser_malawi"] = $data[0]['priv_dispenser_malawi'];
                $_SESSION["priv_dispenser_uganda"] = $data[0]['priv_dispenser_uganda'];


                $_SESSION["priv_issue_tracker_kenya"] = $data[0]['priv_issue_tracker_kenya'];
                $_SESSION["priv_issue_tracker_malawi"] = $data[0]['priv_issue_tracker_malawi'];
                $_SESSION["priv_issue_tracker_uganda"] = $data[0]['priv_issue_tracker_uganda'];




                $_SESSION["priv_issue_tracker_kenya"] = $data[0]['priv_issue_tracker_kenya'];
                $_SESSION["priv_issue_tracker_malawi"] = $data[0]['priv_issue_tracker_malawi'];
                $_SESSION["priv_issue_tracker_uganda"] = $data[0]['priv_issue_tracker_uganda'];


                $_SESSION["priv_evaluation_kenya"] = $data[0]['priv_evaluation_kenya'];
                $_SESSION["priv_evaluation_malawi"] = $data[0]['priv_evaluation_malawi'];
                $_SESSION["priv_evaluation_uganda"] = $data[0]['priv_evaluation_uganda'];



                $_SESSION["priv_expansion_kenya"] = $data[0]['priv_expansion_kenya'];
                $_SESSION["priv_expansion_malawi"] = $data[0]['priv_expansion_malawi'];
                $_SESSION["priv_expansion_uganda"] = $data[0]['priv_expansion_uganda'];


                $_SESSION["priv_on_demand_kenya"] = $data[0]['priv_on_demand_kenya'];
                $_SESSION["priv_on_demand_malawi"] = $data[0]['priv_on_demand_malawi'];
                $_SESSION["priv_on_demand_uganda"] = $data[0]['priv_on_demand_uganda'];



                $_SESSION["priv_other_kenya"] = $data[0]['priv_other_kenya'];
                $_SESSION["priv_other_malawi"] = $data[0]['priv_other_malawi'];
                $_SESSION["priv_other_uganda"] = $data[0]['priv_other_uganda'];




                $_SESSION["priv_standard_reports_kenya"] = $data[0]['priv_standard_reports_kenya'];
                $_SESSION["priv_standard_reports_malawi"] = $data[0]['priv_standard_reports_malawi'];
                $_SESSION["priv_standard_reports_uganda"] = $data[0]['priv_standard_reports_uganda'];


                $_SESSION["priv_diagnostic_kenya"] = $data[0]['priv_diagnostic_kenya'];
                $_SESSION["priv_diagnostic_malawi"] = $data[0]['priv_diagnostic_malawi'];
                $_SESSION["priv_diagnostic_uganda"] = $data[0]['priv_diagnostic_uganda'];

                /*
                 * Privilege Session End
                 */
                header("Location:" . URL . "home");
            } else {
                header("Location:" . URL . "LoginForm");
            }
        } else {
            // @todo reload login page page
            header("Location:" . URL . "LoginForm");
            // @todo wth appropriate errors
        }
        // use php to check if its an email
        // if not set the errors
        // @todo use model to get dta a from staff and validate
        // @todo if it all succeeds then rdirect
    }

    public function logout() {
        // destroy the session
        session_start();
        session_destroy();

        // redirect to login page
        header("Location:" . URL . "LoginForm");
    }

}

?>