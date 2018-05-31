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
				$validate = $this->model->validate($_POST['email'], MD5($_POST['password']), $_POST["country"], 1);
				
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
		
		/* <ramadhan's added code> */
		public function passReset() {
			$modPass = $this->loadModel('passwordReset');
			require 'application/views/login/+reset.php';
			
			/* This statement must be added before the statements that use it. It cannot be added in the requirements at the bottom. Views however can be added last - because they're loaded last. */
			require 'application/views/_templates/email/class.phpmailer.php';
			
			if(isset($_GET['btnReset'])) {
				$EMail = $_GET['txtEmail'];
				$stffDtls = $modPass->getByEmail($EMail);
				
				if(sizeof($stffDtls)>=1) {
					$stffID = $stffDtls[0]['id'];
					$stffPass = rand(9999,99999);
					$arrayData = array(
						'password' => MD5($stffPass)
					);
					$stffWrite = $modPass->updateField('staff_list', $arrayData, $stffID);

					try {
						$mail = new PHPMailer(true);
						$mail->IsSendmail();
						$mail->From = "mail@evidenceaction.com";
						$mail->FromName = "Evidence Action";
						$mail->AddAddress($EMail);
						$mail->Subject = "DSW Password Reset";
						$mail->AltBody = "To view the message, please use a HTML compatible email viewer!";
						$mail->WordWrap = 80;
						$mail->IsHTML(true);
						$mail->Body = "Your password has been successfully reset to <b>" . $stffPass . "</b>.<br/>Please change it as soon as you log back into the system.<br/>In case of any problems or further assistance, please contact your local administrator.";
						$mail->AddAttachment('public/img/logo.jpg');
						$mail->Send();
					} catch (phpmailerException $e) {
						echo $e->errorMessage();
					}
					$message = "Your password has been successfully reset and sent to your email.\\nPlease check your inbox for new mail that contains your reset password.";
					echo '<script type="text/javascript">alert("' . $message . '")</script>';
				} else {
					$message = "The Email address provided as '" . $EMail . "' is not present in the server.\\nPlease contact your local administrator for further assistance.";
					echo '<script type="text/javascript">alert("' . $message . '")</script>';
				}
			}
		}
		/* </ramadhan's added code> */
		
		public function logout() {
			// destroy the session
			session_start();
			session_destroy();
			
			// redirect to login page
			header("Location:" . URL . "LoginForm");
		}
		
		}
		
?>