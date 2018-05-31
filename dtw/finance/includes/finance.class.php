<?php

include('db.class.php'); 

Class FinanceModule {

	public function saveBudgetMeta($data) {

		global $database;

		$database->query('SELECT id FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
	  		':location' 	=> urldecode($_GET['loc']), 
	  		':wave'			=> $_GET['wave'], 
	  		':budget_cat'	=> $_GET['cat'], 
	  		':budget_type'	=> $_GET['type']
			)
		);
		$count = $database->count();

		if ($count != 0) {
			$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
			$database->query('UPDATE fin_budget_meta SET budget_note = :budget_note, prepared_by = :prepared_by WHERE id = :id', 
				array(
			  		':budget_note' 	=> $data,
			  		':prepared_by' 	=> $_SESSION['staff_id'],
			  		':id'			=> $theId['id']
				)
			);
	      	$updated = $database->statement->rowCount();
		} else {
			$database->query('INSERT INTO fin_budget_meta (id, location, wave, budget_cat, budget_type, budget_note, prepared_by) VALUES(NULL, :location, :wave, :budget_cat, :budget_type, :budget_note, :prepared_by)',
				array(
			  		':location' 	=> urldecode($_GET['loc']), 
			  		':wave'			=> $_GET['wave'], 
			  		':budget_cat'	=> $_GET['cat'], 
			  		':budget_type'	=> $_GET['type'], 
	  				':budget_note' 	=> $data,
	  				':prepared_by' 	=> $_SESSION['staff_id']
				)
			);
	      	$added = $database->statement->rowCount();
      	}

	}

	public function verifyBudget($reset = null) {

		global $database;

		if ($reset == null) {		
			$val = $_SESSION['staff_id'];
		} else if ($reset == 1) {
			$val = null;
			$database->query('UPDATE fin_budget_meta SET approval_notice = :approval_notice WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type', 
				array(
					':approval_notice'	=> 0,
					':location'			=> urldecode($_GET['loc']),
					':wave'				=> $_GET['wave'],
					':budget_cat'		=> $_GET['cat'],
					':budget_type'		=> $_GET['type']
				)
			);

		}
		$database->query('UPDATE fin_budget_meta SET verified_by = :verified_by WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type', 
			array(
		  		':location' 	=> urldecode($_GET['loc']), 
		  		':wave'			=> $_GET['wave'], 
		  		':budget_cat'	=> $_GET['cat'], 
		  		':budget_type'	=> $_GET['type'],
		  		':verified_by' 	=> $val
			)
		);
		$updated = $database->count();
		if ($updated!=1) {
			$database->query('INSERT INTO fin_budget_meta (verified_by) VALUES (:verified_by) WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type', 
				array(
			  		':location' 	=> urldecode($_GET['loc']), 
			  		':wave'			=> $_GET['wave'],
			  		':budget_cat'	=> $_GET['cat'],
			  		':budget_type'	=> $_GET['type'],
			  		':verified_by' 	=> $val
				)
			);
		}
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function saveBudgetFormData($data) {

		if ($_GET['form-type']=='imprest') {
			$form_type = 'imprest_data';
		} else if ($_GET['form-type']=='cheque') {
			$form_type = 'cheque_data';
		} else if ($_GET['form-type']=='recon') {
			$form_type = 'recon_data';
		}

		global $database;

		$database->query('SELECT id FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
				':location' 	=> urldecode($_GET['loc']), 
				':wave'			=> $_GET['wave'], 
				':budget_cat'	=> $_GET['budget-cat'], 
				':budget_type'	=> $_GET['budget-type']
			)
		);
		$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
		$database->query('UPDATE fin_budget_meta SET '.$form_type.' = :form_type WHERE id = :id', 
			array(
		  		':form_type'	=> $data,
		  		':id'			=> $theId['id']
			)
		);
      	$updated = $database->statement->rowCount();      	
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function updateAssumptions($data) {

		global $database;
		$database->query('UPDATE fin_budget_jnk_item_cat_item_desc SET units = :units, days = :days, distance = :distance, unit_cost = :unit_cost, unit_description = :unit_description WHERE id = :id', 
	        array(
	        	':units' => $data['units'],
	        	':days' => $data['days'],
	        	':distance' => $data['distance'],
	        	':unit_cost' => $data['unit_cost'],
	        	':unit_description' => $data['unit_description'],
	          	':id' => $data['id']
	        )
      	);
        header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function updateMtAssumptions($data) {

		global $database;
		$database->query('UPDATE fin_budget_mt_params SET unit_key_1 = :unit_key_1, unit_value_1 = :unit_value_1, unit_key_2 = :unit_key_2, unit_value_2 = :unit_value_2, unit_key_3 = :unit_key_3, unit_value_3 = :unit_value_3, unit_key_4 = :unit_key_4, unit_value_4 = :unit_value_4 WHERE id = :id', 
	        array(
              ':id'           => $data['id'],
              ':unit_key_1'   => $data['unit_key_1'],
              ':unit_value_1' => $data['unit_value_1'],
              ':unit_key_2'   => $data['unit_key_2'],
              ':unit_value_2' => $data['unit_value_2'],
              ':unit_key_3'   => $data['unit_key_3'],
              ':unit_value_3' => $data['unit_value_3'],
              ':unit_key_4'   => $data['unit_key_4'],
              ':unit_value_4' => $data['unit_value_4'],
	        )
      	);
        header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function updateCountyAssumptions($data) {

		global $database;
		$database->query('UPDATE fin_budget_jnk_item_cat_item_desc SET units = :units, days = :days, distance = :distance, unit_cost = :unit_cost, unit_description = :unit_description WHERE id = :id', 
	        array(
	        	':units' => $data['units'],
	        	':days' => $data['days'],
	        	':distance' => $data['distance'],
	        	':unit_cost' => $data['unit_cost'],
	        	':unit_description' => $data['unit_description'],
	          	':id' => $data['id']
	        )
      	);
		header('Location:'.basename($_SERVER['REQUEST_URI']));
 	}

	public function addreconsiliationData($data) {

		if ($_GET['budget-cat'] == 1 ) {
			$dbTable = 'fin_budget_cat_county';
		} else {
			$dbTable = 'fin_budget_cat_districts';
		}

		global $database;
	 	$database->query('UPDATE '.$dbTable.' SET total_spent = :total_spent WHERE record_id = :record_id', 
		    array(
		      ':record_id' 	 => $data['id'],
		      ':total_spent' => $data['total_spent']
		    )
		 );
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function saveBudget($data) {

		$data = array($data);
		foreach ($data as $key => $value) {
			global $database;
			$database->query('SELECT id FROM fin_budget_cat_districts WHERE district = :district AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type AND record_id = :record_id',
				array(
			  		':record_id' 		=> $value['record_id'],
			  		':district' 		=> $value['loc'], 
			  		':wave'				=> $value['wave'], 
			  		':budget_cat'		=> $value['budget_cat'], 
			  		':budget_type'		=> $value['budget_type']
				)
			);
			$count = $database->count();

			if ($count != 0) {
				$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
				$database->query('UPDATE fin_budget_cat_districts SET item_desc = :item_desc, acc_form = :acc_form, units = :units, days = :days, ttsessions = :ttsessions, unit_cost = :unit_cost, total = :total, unit_description = :unit_description, recepient = :recepient, accounting = :accounting, forms_recepients = :forms_recepients WHERE id = :id', 
					array(
				  		':item_desc' 		=> $value['item_desc'],
				  		':acc_form' 		=> $value['acc_form'],
				  		':units' 			=> $value['units'],
				  		':days' 			=> $value['days'],
				  		':ttsessions' 		=> $value['ttsessions'],
				  		':unit_cost' 		=> $value['unit_cost'],
				  		':total' 			=> $value['units'] * $value['days'] * $value['ttsessions'] * $value['unit_cost'],
				  		':unit_description' => $value['unit_description'],
				  		':recepient'        => $value['recepient'],
						':accounting'       => $value['accounting'],
						':forms_recepients' => $value['forms_recepients'],
				  		':id'				=> $theId['id']
					)
				);
		      	$updated = $database->statement->rowCount();
			} else {
				$database->query('INSERT INTO fin_budget_cat_districts (id, record_id, district, wave, budget_cat, budget_type, item_desc, acc_form, units, ttsessions, days, unit_cost, total, unit_description, recepient, accounting, forms_recepients, total_spent) VALUES(:id, :record_id, :district, :wave, :budget_cat, :budget_type, :item_desc, :acc_form, :units, :ttsessions, :days, :unit_cost, :total, :unit_description, :recepient, :accounting, :forms_recepients, :total_spent)',
					array(
						':id'				=> NULL,
				  		':record_id'		=> $value['record_id'],
				  		':district' 		=> $value['loc'], 
				  		':wave'				=> $value['wave'], 
				  		':budget_cat'		=> $value['budget_cat'], 
				  		':budget_type'		=> $value['budget_type'],
				  		':item_desc' 		=> $value['item_desc'],
				  		':acc_form' 		=> $value['acc_form'],
				  		':units' 			=> $value['units'],
				  		':days' 			=> $value['days'],
				  		':ttsessions' 		=> $value['ttsessions'],
				  		':unit_cost' 		=> $value['unit_cost'],
				  		':total' 			=> $value['units'] * $value['days'] * $value['ttsessions'] * $value['unit_cost'],
				  		':unit_description'	=> $value['unit_description'],
				  		':recepient'        => $value['recepient'],
						':accounting'       => $value['accounting'],
						':forms_recepients' => $value['forms_recepients'],
				  		':total_spent' 		=> NULL,
					)
				);
		      	$added = $database->statement->rowCount();
	  	    	} 

		}

		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function saveCountyBudget($data) {

		$data = array($data);
        
		foreach ($data as $key => $value) {

			global $database;
			$database->query('SELECT id FROM fin_budget_cat_county WHERE county = :county AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type AND record_id = :record_id',
				array(
			  		':record_id' 		=> $value['record_id'],
			  		':county' 			=> $value['loc'],
			  		':wave'				=> $value['wave'],
			  		':budget_cat'		=> $value['budget_cat'], 
			  		':budget_type'		=> $value['budget_type']
				)
			);
			$count = $database->count();

			if ($count != 0) {
				$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
				$database->query('UPDATE fin_budget_cat_county SET item_desc = :item_desc, acc_form = :acc_form, units = :units, days = :days, distance = :distance, unit_cost = :unit_cost, total = :total, unit_description = :unit_description, recepient = :recepient, accounting = :accounting, forms_recepients = :forms_recepients WHERE id = :id', 
					array(
				  		':item_desc' 		=> $value['item_desc'],
				  		':acc_form' 		=> $value['acc_form'],
				  		':units' 			=> $value['units'],
				  		':days' 			=> $value['days'],
				  		':distance' 		=> $value['distance'],
				  		':unit_cost' 		=> $value['unit_cost'],
				  		':total' 			=> $value['total'],
				  		':unit_description' => $value['unit_description'],
				  		':recepient'        => $value['recepient'],
						':accounting'       => $value['accounting'],
						':forms_recepients' => $value['forms_recepients'],
				  		':id'				=> $theId['id']
					)
				);
		      	$updated = $database->statement->rowCount();
			} else {
				$database->query('INSERT INTO fin_budget_cat_county (id, record_id, county, wave, budget_cat, budget_type, item_desc, acc_form, units, distance, days, unit_cost, total, unit_description, recepient, accounting, forms_recepients, total_spent ) VALUES(:id, :record_id, :county, :wave, :budget_cat, :budget_type, :item_desc, :acc_form, :units, :distance, :days, :unit_cost, :total, :unit_description, :recepient, :accounting, :forms_recepients, :total_spent)',
					array(
						':id'				=> NULL,
				  		':record_id'		=> $value['record_id'],
				  		':county' 			=> $value['loc'],
				  		':wave'				=> $value['wave'], 
				  		':budget_cat'		=> $value['budget_cat'], 
				  		':budget_type'		=> $value['budget_type'],
				  		':item_desc' 		=> $value['item_desc'],
				  		':acc_form' 		=> $value['acc_form'],
				  		':units' 			=> $value['units'],
				  		':days' 			=> $value['days'],
				  		':distance'			=> $value['distance'],
				  		':unit_cost'		=> $value['unit_cost'],
				  		':total' 			=> $value['total'],
				  		':unit_description'	=> $value['unit_description'],
				  		':recepient'        => $value['recepient'],
						':accounting'       => $value['accounting'],
						':forms_recepients' => $value['forms_recepients'],
				  		':total_spent'		=> NULL,
					)
				);
		      	$added = $database->statement->rowCount();
	  	    } 

		}

		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function saveMtBudget($data) {

		$data = array($data);
		foreach ($data as $key => $value) {
			global $database;
			$database->query('SELECT id FROM fin_budget_mt WHERE record_id = :record_id AND sub_county	= :sub_county AND wave = :wave',
				array(
			  		':record_id' 		=> $value['record_id'], 
			  		':sub_county' 		=> $_GET['loc'], 
			  		':wave'				=> $_GET['wave']
				)
			);
			$count = $database->count();

			if ($count != 0) {
				$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
				$database->query('UPDATE fin_budget_mt SET unit_key_1 = :unit_key_1, unit_value_1 = :unit_value_1, unit_key_2 = :unit_key_2, unit_value_2 = :unit_value_2, unit_key_3 = :unit_key_3, unit_value_3 = :unit_value_3, unit_key_4 = :unit_key_4, unit_value_4 = :unit_value_4 WHERE id = :id',
					array(
		                ':unit_key_1'   => $value['unit_key_1'],
		                ':unit_value_1' => $value['unit_value_1'],
		                ':unit_key_2'   => $value['unit_key_2'],
		                ':unit_value_2' => $value['unit_value_2'],
		                ':unit_key_3'   => $value['unit_key_3'],
		                ':unit_value_3' => $value['unit_value_3'],
		                ':unit_key_4'   => $value['unit_key_4'],
		                ':unit_value_4' => $value['unit_value_4'],
				  		':id'			=> $theId['id']
					)
				);
		      	$updated = $database->statement->rowCount();
			} else {
				$database->query('INSERT INTO fin_budget_mt (id, record_id, sub_county, wave, unit_key_1, unit_value_1, unit_key_2, unit_value_2, unit_key_3, unit_value_3, unit_key_4, unit_value_4) VALUES(:id, :record_id, :sub_county, :wave, :unit_key_1, :unit_value_1, :unit_key_2, :unit_value_2, :unit_key_3, :unit_value_3, :unit_key_4, :unit_value_4)',
					array(
						':id'				=> NULL,
						':record_id'		=> $value['record_id'],
				  		':sub_county' 		=> $_GET['loc'], 
				  		':wave'				=> $_GET['wave'],
		                ':unit_key_1'   	=> $value['unit_key_1'],
		                ':unit_value_1' 	=> $value['unit_value_1'],
		                ':unit_key_2'   	=> $value['unit_key_2'],
		                ':unit_value_2' 	=> $value['unit_value_2'],
		                ':unit_key_3'   	=> $value['unit_key_3'],
		                ':unit_value_3' 	=> $value['unit_value_3'],
		                ':unit_key_4'   	=> $value['unit_key_4'],
		                ':unit_value_4' 	=> $value['unit_value_4'],
					)
				);
		      	$added = $database->statement->rowCount();
	  	    } 

		}

		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function restoreBudget($subCounty, $wave, $budget_cat, $budget_type) {

		global $database;
		$database->query('DELETE FROM fin_budget_cat_districts WHERE district = :district AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
		  		':district' 		=> $subCounty,
		  		':wave'				=> $wave,
		  		':budget_cat'		=> $budget_cat, 
		  		':budget_type'		=> $budget_type
			)
		);
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function restoreMtBudget($subCounty, $wave, $budget_cat, $budget_type) {

		global $database;
		$database->query('DELETE FROM fin_budget_mt WHERE sub_county = :sub_county AND wave = :wave',
			array(
		  		':sub_county' 	=> $subCounty,
		  		':wave'				=> $wave
			)
		);
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function restoreCountyBudget($county, $wave, $budget_cat, $budget_type) {
		
		global $database;
		$database->query('DELETE FROM fin_budget_cat_county WHERE county = :county AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
		  		':county' 			=> $county,
		  		':wave'				=> $wave,
		  		':budget_cat'		=> $budget_cat, 
		  		':budget_type'		=> $budget_type
			)
		);
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function pleaseApprove($docTitle, $approvers) {

		global $database;

	    $sender = $_SESSION['staff_email'];
	    $staff_id = $_SESSION['staff_id'];
	    $staff_email = $_SESSION['staff_email'];
	    $staff_name = $_SESSION['staff_name'];

	    if ( is_array($approvers) ) {

			$database->query("SELECT staff_email FROM staff WHERE staff_id IN ('".implode("','", $approvers)."')");
			$recepientEmails =  $database->statement->fetchall(PDO::FETCH_ASSOC); 

			$recepients;$i=1;$c = count($recepientEmails);
			foreach ($recepientEmails as $key => $recepientEmail) {
				if ($c==$i) {
					$recepients .= $recepientEmail['staff_email'];
				} else {
					$recepients .= $recepientEmail['staff_email'].',';				
				}
			$i++;}

	    } else {

			$database->query("SELECT staff_email FROM staff WHERE staff_id = ".$approvers."");
			$recepientEmail =  $database->statement->fetch(PDO::FETCH_ASSOC); 
			$recepients = $recepientEmail['staff_email'];
	    }

		require_once('../email/class.phpmailer.php');
		$mail = new PHPMailer(true);
			$subject = 'Budget Approval';
			$recipient_email = $recepients;
			$email_body = 'This is to inform you that '.$docTitle.' has been prepared and is pending approval.';
		    //Clean Data
		    $sender = addslashes(trim($sender));
		    $recipient_email = addslashes(trim($recipient_email));
		    $subject = addslashes(trim($subject));
		    $email_body = addslashes(trim($email_body));
		    //send Email to client ============================================
		    try {
				$mail->IsSendmail();  // tell the class to use Sendmail
				$mail->AddReplyTo($staff_email, $staff_name);
				$mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
				$mail->FromName = $staff_name; //"Evidence Action";
				$to = $recipient_email;	    	
				if (strpos($to,',') !== false) {					
					 $to = explode(',', $to);
					foreach ($to as $key => $value) {
						$mail->AddAddress($value);
					}
				} else {
					$mail->AddAddress($to);
				}
				$mail->Subject = $subject;
				//$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				$mail->WordWrap = 80; // set word wrap
				$mail->IsHTML(true);
				$mail->Body = $email_body;
				// $mail->AddAttachment('../images/logo.jpg');
				// $mail->AddAttachment('pdf_budget_forms/'.$recon.'.pdf');
				// $mail->AddAttachment('pdf_budget_forms/'.$budget.'.pdf');
				$mail->Send();

				$database->query('UPDATE fin_budget_meta SET approval_notice = :approval_notice WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type', 
					array(
						':approval_notice'	=> 1,
						':location'			=> urldecode($_GET['loc']),
						':wave'				=> $_GET['wave'],
						':budget_cat'		=> $_GET['cat'],
						':budget_type'		=> $_GET['type']
					)
				);
				header('Location:'.basename($_SERVER['REQUEST_URI']));
		    } catch (phpmailerException $e) {
		      echo $e->errorMessage();
		    }
	}

	public function saveReturnsTracking($data) {

		global $database;

		$database->query('SELECT id FROM fin_ret_tracking WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
	  		':wave'			=> $data['wave'], 
	  		':budget_cat'	=> $data['budget_cat'], 
	  		':budget_type'	=> $data['budget_type'],
	  		':location' 	=> $data['location']
			)
		);
		$count = $database->count();

		if ($count != 0) {
			$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
			$database->query('UPDATE fin_ret_tracking SET received = :received, processed = :processed, finalized = :finalized, approved = :approved WHERE id = :id', 
				array(
                  'received' => $data['received'],
                  'processed' => $data['processed'], 
                  'finalized' => $data['finalized'], 
                  'approved' => $data['approved'],
                  ':id' => $theId['id']
				)
			);
	      	$updated = $database->statement->rowCount();
		} else {
			$database->query('INSERT INTO fin_ret_tracking (id, wave, budget_cat, budget_type, location, received, processed, finalized, approved) VALUES(NULL, :wave, :budget_cat, :budget_type, :location, :received, :processed, :finalized, :approved)',
				array(
			  		':wave' => $data['wave'], 
			  		':budget_cat' => $data['budget_cat'], 
			  		':budget_type' => $data['budget_type'], 
			  		':location'	=> $data['location'], 
	  				':received' => $data['received'],
	  				':processed' => $data['processed'],
	  				':finalized' => $data['finalized'],
	  				':approved' => $data['approved']
				)
			);
	      	$added = $database->statement->rowCount();
      	}
	}

	public function saveRequestTracking($data) {

		global $database;

		$database->query('SELECT id FROM fin_req_tracking WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
			array(
	  		':wave'			=> $data['wave'], 
	  		':budget_cat'	=> $data['budget_cat'], 
	  		':budget_type'	=> $data['budget_type'],
	  		':location' 	=> $data['location']
			)
		);
		$count = $database->count();

		if ($count != 0) {
			$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
			$database->query('UPDATE fin_req_tracking SET prepared = :prepared, reviewed = :reviewed, printed = :printed, approved = :approved, disbursed = :disbursed WHERE id = :id', 
				array(
                  'prepared' => $data['prepared'],
                  'reviewed' => $data['reviewed'], 
                  'printed' => $data['printed'], 
                  'approved' => $data['approved'],
                  'disbursed' => $data['disbursed'],
                  ':id' => $theId['id']
				)
			);
	      	$updated = $database->statement->rowCount();
		} else {
			$database->query('INSERT INTO fin_req_tracking (id, wave, budget_cat, budget_type, location, prepared, reviewed, printed, approved, disbursed) VALUES(NULL, :wave, :budget_cat, :budget_type, :location, :prepared, :reviewed, :printed, :approved, :disbursed)',
				array(
			  		':wave' => $data['wave'], 
			  		':budget_cat' => $data['budget_cat'], 
			  		':budget_type' => $data['budget_type'], 
			  		':location'	=> $data['location'], 
	  				':prepared' => $data['prepared'],
	  				':reviewed' => $data['reviewed'],
	  				':printed' => $data['printed'],
	  				':approved' => $data['approved'],
	  				':disbursed' => $data['disbursed']
				)
			);
	      	$added = $database->statement->rowCount();
      	}
	}

	public function saveRefundsData($data) {

		global $database;

		$database->query('SELECT id FROM fin_budget_refunds WHERE location = :location AND location_type = :location_type AND wave = :wave',
			array(
				':location' 		=> $data['location'], 
				':location_type'	=> $data['location_type'],
				':wave'				=> $data['dewormin_wave']
			)
		);
		$count = $database->count();

		if ($count != 0) {
			$theId = $database->statement->fetch(PDO::FETCH_ASSOC);
			$database->query('UPDATE fin_budget_refunds SET refund_paid = :paid, refund_received = :received WHERE id = :id', 
				array(
					':paid'		=> $data['paid'],
			  		':received' => $data['received'],
			  		'id'		=> $theId['id']
				)
			);
	      	$updated = $database->statement->rowCount();
		} else {
			$database->query('INSERT INTO fin_budget_refunds (id, location, location_type, wave, refund_paid, refund_received) VALUES(:id, :location, :location_type, :wave, :paid, :received)',
				array(
					':id'				=> NULL,
					':location'			=> $data['location'], 
					':location_type'	=> $data['location_type'],
					':wave'				=> $data['dewormin_wave'],					
					':paid'				=> $data['paid'],
			  		':received'			=> $data['received']
				)
			);
	      	$added = $database->statement->rowCount();
      	}
		//header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function sendNotification($data, $notification) {

		global $database;

	    $sender = $_SESSION['staff_email'];
	    $staff_id = $_SESSION['staff_id'];
	    $staff_email = $_SESSION['staff_email'];
	    $staff_name = $_SESSION['staff_name'];

		require_once('../email/class.phpmailer.php');
		$mail = new PHPMailer(true);

		  foreach ($data as $key => $value) {

			$database->query('SELECT approved_notif,disbursed_notif FROM fin_req_tracking WHERE id = :id',
				array(
		  			':id'	=> $value['record_id']
				)
			);
			$status = $database->statement->fetch(PDO::FETCH_ASSOC);

		    if ($notification =='approval') {
		    	$approved_notif = 1;
		    	$disbursed_notif = $status['disbursed_notif'];
		    } else if ($notification =='disbursement') {
		    	$disbursed_notif = 1;
		    	$approved_notif = $status['approved_notif'];
		    }
			$database->query('UPDATE fin_req_tracking SET approved_notif = :approved_notif, disbursed_notif = :disbursed_notif WHERE id = :id', 
				array(
					':approved_notif'	=> $approved_notif,
			  		':disbursed_notif'	=> $disbursed_notif,
			  		':id'				=> $value['record_id']
				)
			);

			if ($value['budget_cat_id'] == 1) {
				if ($value['budget_type_id'] == 7 || $value['budget_type_id'] == 9 || $value['budget_type_id'] == 12 || $value['budget_type_id'] == 14 || $value['budget_type_id'] == 17) {
					$database->query('SELECT email FROM county_contacts WHERE county = :county AND title = :title LIMIT 1',
						array(
				  			':county'	=> $value['location'],
				  			':title'	=> 'CDE'
						)
					);
					$recipient_email = $database->statement->fetch(PDO::FETCH_ASSOC);					
				} else {
					$database->query('SELECT email FROM county_contacts WHERE county = :county AND title = :title LIMIT 1',
						array(
				  			':county'	=> $value['location'],
				  			':title'	=> 'CDH'
						)
					);
					$recipient_email = $database->statement->fetch(PDO::FETCH_ASSOC);	
				}				
			} else {
				if ($value['budget_type_id'] == 2 || $value['budget_type_id'] == 4 || $value['budget_type_id'] == 6 || $value['budget_type_id'] == 11 || $value['budget_type_id'] == 18) {
					$database->query('SELECT dmoh_email as email FROM health_contacts WHERE district = :district LIMIT 1',
						array(
				  			':district'	=> $value['location']
						)
					);
					$recipient_email = $database->statement->fetch(PDO::FETCH_ASSOC);					
				} else {
					$database->query('SELECT deo_email as email FROM education_contacts WHERE district = :district LIMIT 1',
						array(
				  			':district'	=> $value['location']
						)
					);
					$recipient_email = $database->statement->fetch(PDO::FETCH_ASSOC);	
				}	
			}

			$recipient_email = $recipient_email['email'];

			if ($notification =='approval') {
			    if ($value['budget_cat_id'] == 1) {
			    	$subject = $value['budget_type'].' Budget For '.$value['location'];
			    } else {
			    	$subject = $value['budget_cat'].' Budget ('.$value['budget_type'].') For '.$value['location'];	    	
			    }				
			} else if ($notification =='disbursement') {
			    if ($value['budget_cat_id'] == 1) {
			    	$subject = $value['budget_type'].' Funds For '.$value['location'].' Disbursed';
			    } else {
			    	$subject = $value['budget_cat'].' Budget ('.$value['budget_type'].') Funds For '.$value['location'].' Disbursed';	    	
			    }
			}

		    if ($notification =='approval') {
			    $email_body = 'Find attached the final approved Budget and respective Reconciliation Returns Form for '.$value['location'].'. You are required to acknowledge receipt of this message by replying to this email.';
		    } else if ($notification =='disbursement') {
			    $email_body = 'This is to inform you that funds for '.$value['location'].' have been disbursed to your bank account. Please acknowledge receipt of the funds by replying to this message.';
		    }

		    //Clean Data
		    $sender = addslashes(trim($sender));
		    //$recipient_name = addslashes(trim($recipient_name));
		    $recipient_email = addslashes(trim($recipient_email));
		    $subject = addslashes(trim($subject));
		    $email_body = addslashes(trim($email_body));
			if ($value['budget_cat_id'] == 1){

				$recon = 'reconciliation_'.str_replace(' ', '_', strtolower($value['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($value['location'] ) ).'_'.str_replace(' ', '_', strtolower($value['deworming_wave'] ) );
				$budget = 'budget_'.str_replace(' ', '_', strtolower( $value['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($value['location'] ) ).'_'. str_replace(' ', '_', strtolower($value['deworming_wave'] ) );

			} else {

				$recon = 'reconciliation_'.str_replace(' ', '_', strtolower($value['budget_cat'] ) ).'_'.str_replace(' ', '_', strtolower($value['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($value['location'] ) ).'_'.str_replace(' ', '_', strtolower($value['deworming_wave'] ) );
				$budget = 'budget_'.str_replace(' ', '_', strtolower($value['budget_cat'] ) ).'_'.str_replace(' ', '_', strtolower( $value['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($value['location'] ) ).'_'. str_replace(' ', '_', strtolower($value['deworming_wave'] ) );

			}
		    //send Email to client ============================================
		    try {
				$mail->IsSendmail();  // tell the class to use Sendmail
				$mail->AddReplyTo($staff_email, $staff_name);
				$mail->From = "mail@evidenceaction.com"; //$staff_email;   //$sess_email;
				$mail->FromName = $staff_name; //"Evidence Action";
				$to = $recipient_email;	    	
				if (strpos($to,',') !== false) {					
					 $to = explode(',', $to);
					foreach ($to as $key => $value) {
						$mail->AddAddress($value);
					}
				} else {
					$mail->AddAddress($to);
				}
				$mail->Subject = $subject;
				//$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
				$mail->WordWrap = 80; // set word wrap
				$mail->IsHTML(true);
				$mail->Body = $email_body;
				if ($notification =='approval') {
					// $mail->AddAttachment('../images/logo.jpg');
					$mail->AddAttachment('pdf_budget_forms/'.$recon.'.pdf');
					$mail->AddAttachment('pdf_budget_forms/'.$budget.'.pdf');					
				}
				$mail->Send();
		    } catch (phpmailerException $e) {
		      echo $e->errorMessage();
		    }

		  }
	}

	public function createreconPDF($meta, $data) {

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($_SESSION['staff_name']);
		$pdf->SetTitle($meta['doc_heading']);
		$pdf->SetSubject($meta['doc_title']);
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
			require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 12, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$pdf->setHtmlVSpace($tagvs);

		$pdf->SetXY(10, 5);
		$header = '<div style="text-align:center"><img src="'.dirname(__FILE__).'../../../images/logo.jpg" width="140" height="100" border="0" />';
		$header .= '<h3>Financial Reconciliation Return Form</h3>';
		$header .= '<h4>'.ucwords($meta['budget_type']).', '.ucwords($meta['location']).', Deworming Wave:'.ucwords($meta['dewormin_wave']).'</h4></div>';
		$header .= '<div style="text-align:left">
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Name: </p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Amount (Words):<em>'.ucwords(convert_number_to_words($budget_total)).'</em></p>
                        <h6>Notes:</h6>
                        <p style="font-size:10px;font-weight:bold;">If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                        <p style="font-size:10px;font-weight:bold;">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>    
                     </div>';
		$pdf->writeHTML($header, true, false, true, false, '');

		// ---------------------------------------------------------

		$col = 30; // Column size		 
		$wideCol = 3 * $col;  // Description Column		 
		$line = 8;  // Line height

		$pdf->SetY(115);

		// Table header 
		$pdf->SetFont( 'helvetica', '', 10);
		foreach ($data[0] as $key => $value) {
			if ( $key == 'recepient' ) {
				$pdf->Cell( $wideCol, $line, ucfirst($key), 1, 0, 'C' );
			} else {
				$pdf->Cell( $col, $line, ucfirst($key), 1, 0, 'C' );
			}
		}
		$pdf->Ln(); // Adds Line break

		// Table content beings here 
		$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values
		 
		foreach( $data as $key => $value ) {

			$pdf->MultiCell( $wideCol, $line, $value['recepient'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, $value['advanced'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
			$pdf->Cell( $col, $line, $value['spent'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );			 
			$pdf->Cell( $col, $line, $value['variance'], array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' ); 			 
			$pdf->Ln();
		 
		}
			$pdf->SetFillColor($col1 = 215, $col2 = 215, $col3 = 215);

			$pdf->MultiCell( $wideCol, $line, 'Amount forwarded to your district', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, $meta['budget_total'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L');	
			$pdf->Cell( $col, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' , $fill = true );			 
			$pdf->Cell( $col, $line, '', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L', $fill = true ); 			 
			$pdf->Ln();			

			$pdf->MultiCell( $wideCol, $line, 'Total Amount Spent', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L', $fill = true);	
			$pdf->Cell( $col, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L'  );			 
			$pdf->Cell( $col, $line, '', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L', $fill = true ); 			 
			$pdf->Ln();			

			$pdf->MultiCell( $wideCol, $line, 'Amount Currently Held In District Account', array('LTB' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, '', array('LTB' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L', $fill = true);	
			$pdf->Cell( $col, $line, '', array('LTB' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' , $fill = true );			 
			$pdf->Cell( $col, $line, '', array('LTBR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' ); 			 
			$pdf->Ln();

		$footer = '<br><br><table><tr><td><b>Prepared By:</b></td> <td><b>Approved By:</b></td></tr>';
		$footer .= '<tr><td><b>Date:</b></td> <td><b>Date:</b></td></tr>';
		$footer .= '<tr><td><b>Signature:</b></td> <td><b>Signature:</b></td></tr></table>';

		$pdf->writeHTML($footer, true, false, true, false, '');

		ob_clean();

		// reset pointer to the last page
		$pdf->lastPage();

		if ($_GET['cat'] ==1 || $_GET['budget-cat'] ==1 ) {
			$doc_title = 'reconciliation_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		} else {
			$doc_title = 'reconciliation_'.str_replace(' ', '_', strtolower( $meta['budget_cat'] ) ).'_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		}
		

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('pdf_budget_forms/'.$doc_title.'.pdf', 'F');
	}

	public function createimprestPDF($meta, $data) {

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($_SESSION['staff_name']);
		$pdf->SetTitle($meta['doc_heading']);
		$pdf->SetSubject($meta['doc_title']);
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
			require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 12, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$pdf->setHtmlVSpace($tagvs);

		$pdf->SetXY(10, 5);
		$header = '<div style="text-align:center"><img src="'.dirname(__FILE__).'../../../images/logo.jpg" width="140" height="100" border="0" />';
		$header .= '<h3>Imprest Request Form</h3>';
		$header .= '<h4>'.ucwords($meta['budget_type']).', '.ucwords($meta['location']).', Deworming Wave:'.ucwords($meta['dewormin_wave']).'</h4></div>';
		$header .= '<div style="text-align:left">
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Prepared By: '.$meta['budget_prepared'].'</p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Signature: </p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Date Request Is Made: '.$data['date_made'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Request Is Required: '.$data['date_required'].'</p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Amount (Words):<em>'.ucwords(convert_number_to_words($meta['budget_total'])).'</em></p>
                        <h6>Notes:</h6>
                        <p style="font-size:10px;font-weight:bold;">If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                        <p style="font-size:10px;font-weight:bold;">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>    
                     </div>';
		$pdf->writeHTML($header, true, false, true, false, '');

		// ---------------------------------------------------------

		$col = 36; // Column size		 
		$wideCol = 3 * $col;  // Description Column		 
		$line = 8;  // Line height

		$pdf->SetY(130);

		// Table header 
		$pdf->SetFont( 'helvetica', 'B', 10);
		$pdf->MultiCell( $wideCol, $line, 'Pariculars', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, 'Project Class', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, 'Amount (Ksh)', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );
		$pdf->Ln(); // Adds Line break

		// Table content beings here 
		$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values
		 
		// foreach( $data as $key => $value ) {

		$pdf->MultiCell( $wideCol, $line, 'Amount forwarded to your Sub-County', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, $data['project_class'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, number_format($meta['budget_total']), array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();
		 
		// }

		for ($i=0; $i < 9; $i++) { 
			$pdf->MultiCell( $wideCol, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
			$pdf->Cell( $col, $line, '', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
			$pdf->Ln();
		}

		$pdf->MultiCell( $wideCol, $line, 'Please pay: '.$meta['bank_details']['bank_account_name'].' '.$meta['bank_details']['bank_account_number'].' '.$meta['bank_details']['bank_name'].' '.$meta['bank_details']['bank_branch'].'', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, '', array('TR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();

		$pdf->MultiCell( $wideCol, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();

		$footer = '<br><br><table><tr><td><b>Authorized By:</b> '.$data['authorized_by'].'</td></tr>';
		$footer .= '<tr><td><b>Date:</b> '.$data['date_authorized'].'</td></tr>';
		$footer .= '<tr><td><b>Signature:</b></td></tr></table>';

		$pdf->writeHTML($footer, true, false, true, false, '');

		ob_clean();

		// reset pointer to the last page
		$pdf->lastPage();

		// if ($_GET['cat'] ==1 || $_GET['budget-cat'] ==1 ) {
		// 	$doc_title = 'imprest_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		// } else {
			$doc_title = 'imprest_'.str_replace(' ', '_', strtolower( $meta['budget_cat'] ) ).'_budget_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		// }
		

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('pdf_budget_forms/'.$doc_title.'.pdf', 'F');
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function createchequePDF($meta, $data) {

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($_SESSION['staff_name']);
		$pdf->SetTitle($meta['doc_heading']);
		$pdf->SetSubject($meta['doc_title']);
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
			require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 12, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		$tagvs = array('p' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n' => 0)));
		$pdf->setHtmlVSpace($tagvs);

		$pdf->SetXY(10, 5);
		$header = '<div style="text-align:center"><img src="'.dirname(__FILE__).'../../../images/logo.jpg" width="140" height="100" border="0" />';
		$header .= '<h3>Imprest Request Form</h3>';
		$header .= '<h4>'.ucwords($meta['budget_type']).', '.ucwords($meta['location']).', Deworming Wave:'.ucwords($meta['dewormin_wave']).'</h4></div>';
		$header .= '<div style="text-align:left">
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Prepared By: '.$meta['budget_prepared'].'</p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Signature: </p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Date Request Is Made: '.$data['date_made'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date Request Is Required: '.$data['date_required'].'</p><br>
                        <p style="border-bottom:1px solid #000;font-size:12px;font-weight:bold;">Amount (Words):<em>'.ucwords(convert_number_to_words($meta['budget_total'])).'</em></p>
                        <h6>Notes:</h6>
                        <p style="font-size:10px;font-weight:bold;">If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                        <p style="font-size:10px;font-weight:bold;">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>    
                     </div>';
		$pdf->writeHTML($header, true, false, true, false, '');

		// ---------------------------------------------------------

		$col = 36; // Column size		 
		$wideCol = 3 * $col;  // Description Column		 
		$line = 8;  // Line height

		$pdf->SetY(130);

		// Table header 
		$pdf->SetFont( 'helvetica', 'B', 10);
		$pdf->MultiCell( $wideCol, $line, 'Pariculars', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, 'Project Class', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, 'Amount (Ksh)', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );
		$pdf->Ln(); // Adds Line break

		// Table content beings here 
		$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values
		 
		// foreach( $data as $key => $value ) {

		$pdf->MultiCell( $wideCol, $line, 'Amount forwarded to your Sub-County', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, $data['project_class'], array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, number_format($meta['budget_total']), array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();
		 
		// }

		for ($i=0; $i < 9; $i++) { 
			$pdf->MultiCell( $wideCol, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
			$pdf->Cell( $col, $line, '', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
			$pdf->Cell( $col, $line, '', array('LTR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
			$pdf->Ln();
		}

		$pdf->MultiCell( $wideCol, $line, 'Please pay: '.$meta['bank_details']['bank_account_name'].' '.$meta['bank_details']['bank_account_number'].' '.$meta['bank_details']['bank_name'].' '.$meta['bank_details']['bank_branch'].'', array('LT' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, '', array('TR' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();

		$pdf->MultiCell( $wideCol, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 'L','',0);		 
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );	
		$pdf->Cell( $col, $line, '', array('T' => array('width' => 0.26, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(58, 58, 58))), 0, 'L' );		 
		$pdf->Ln();

		$footer = '<br><br><table><tr><td><b>Authorized By:</b> '.$data['authorized_by'].'</td></tr>';
		$footer .= '<tr><td><b>Date:</b> '.$data['date_authorized'].'</td></tr>';
		$footer .= '<tr><td><b>Signature:</b></td></tr></table>';

		$pdf->writeHTML($footer, true, false, true, false, '');

		ob_clean();

		// reset pointer to the last page
		$pdf->lastPage();

		// if ($_GET['cat'] ==1 || $_GET['budget-cat'] ==1 ) {
		// 	$doc_title = 'imprest_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		// } else {
			$doc_title = 'imprest_'.str_replace(' ', '_', strtolower( $meta['budget_cat'] ) ).'_budget_'.str_replace(' ', '_', strtolower($meta['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower($meta['location'] ) ).'_'.str_replace(' ', '_', strtolower($meta['dewormin_wave'] ) );
		// }
		

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('pdf_budget_forms/'.$doc_title.'.pdf', 'F');
		header('Location:'.basename($_SERVER['REQUEST_URI']));
	}

	public function createBudgetPDF($meta, $data) {

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($_SESSION['staff_name']);
		$pdf->SetTitle($meta['doc_heading']);
		$pdf->SetSubject($meta['doc_title']);
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
			require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 9, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage("L","mm","A4",true,"UTF-8",false);

		$pdf->SetXY(0, 1.5);
		$header = '<div style="text-align:center"><img src="'.dirname(__FILE__).'../../../images/logo.jpg" width="100" height="80" border="0" />';
		$header .= '<h2>'.ucwords($meta['budget_type']).' Budget For '.ucwords($meta['location']).', Deworming Wave: '.ucwords($meta['deworming_wave']).'</h2>';

		$tableHeader = '<table style="border:0.5px solid #333333; font-size: 10px; width: 100%;"><tr>';
		$tableHeader .= '<td style="height:25px;width:7.12%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'item_description')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:6.82%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'accountability_form')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'units')).'</b></td>';
		if ( $_GET['cat'] == 4 ) {
			$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'ttsessions')).'</b></td>';
		}
		if ( $_GET['type'] == 9 || $_GET['type'] == 10 ) {
			$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'distance')).'</b></td>';
		}
		$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'days')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'unit_cost')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:4.47%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'total')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:11.72%;border:0.5px solid #333333;text-align:left;" ><b>'. ucwords(str_replace('_', ' ', 'recepient')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:25%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'description')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:19.59%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'accounting')).'</b></td>';
		$tableHeader .= '<td style="height:25px;width:9.30%;border:0.5px solid #333333;" ><b>'. ucwords(str_replace('_', ' ', 'receipts')).'</b></td>';
		$tableHeader .= '</tr>';

		// Table content beings here 
		foreach( $data as $key => $value ) {
			if (!empty($value["item_description"])) {
				$table .= '<tr>';
				$table .= '<td style="width:7.12%;border:0.5px solid #333333;" >'.$value["item_description"].'</td>';
				$table .= '<td style="width:6.82%;border:0.5px solid #333333;" >'.$value['accountability_form'].'</td>';
				$table .= '<td style="width:4.47%;border:0.5px solid #333333;" >'.$value['units'].'</td>';
				$table .= '<td style="width:4.47%;border:0.5px solid #333333;" >'.$value['days'].'</td>';
				if ( $_GET['cat'] == 4 ) {
					$table .= '<td style="width:4.47%;border:0.5px solid #333333;" ><b>'.$value['ttsessions'].'</b></td>';
				}
				if ( $_GET['type'] == 9 || $_GET['type'] == 10 ) {
					$table .= '<td style="width:4.47%;border:0.5px solid #333333;" ><b>'.$value['distance'].'</b></td>';
				}
				$table .= '<td style="width:4.47%;border:0.5px solid #333333;" >'.$value['unit_cost'].'</td>';
				$table .= '<td style="width:4.47%;border:0.5px solid #333333;" ><b>'.number_format($value['total']).'</b></td>';
				$table .= '<td style="width:11.72%;border:0.5px solid #333333;text-align:left;" >'.$value['recepient'].'</td>';
				$table .= '<td style="width:25%;border:0.5px solid #333333;text-align:left;">'.$value['description'].'</td>';
				$table .= '<td style="width:19.59%;border:0.5px solid #333333;text-align:left;">'.$value['accounting'].'</td>';
				$table .= '<td style="width:9.30%;border:0.5px solid #333333;text-align:left;" >'.$value['receipts'].'</td>';
				$table .= '</tr>';
			}	 
		}

		$table .= '<tr>';
		$table .= '<td style="width:7.12%;border:0.5px solid #333333;height:50px;" >&nbsp;</td>';
		if ( $_GET['cat'] == 4 || $_GET['type'] == 9 ) {
			$table .= '<td style="width:24.7%;border:0.5px solid #333333;text-align:right;height:50px;" colspan="6"><b>Budget Total</b></td>';
		} else {
			$table .= '<td style="width:20.23%;border:0.5px solid #333333;text-align:right;height:50px;" colspan="5"><b>Budget Total</b></td>';
		}
		$table .= '<td style="width:4.47%;border:0.5px solid #333333;height:50px;" ><b>'.number_format($meta['budget_total']).'</b></td>';
		$table .= '<td style="width:56.31%;border:0.5px solid #333333;text-align:left;height:50px;" colspan="3">'.$meta['budget_note'].'</td>';
		$table .= '<td style="width:9.30%;border:0.5px solid #333333;text-align:left;height:50px;" >'.$meta['budget_forms_receipts'].'</td>';
		$table .= '</tr>';	

		$table .= '</table>';

		$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

		ob_clean();

		if ($_GET['cat']==1) {
			$doc_title = 'budget_'.str_replace(' ', '_', strtolower( $meta['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($meta['location'] ) ).'_'. str_replace(' ', '_', strtolower($meta['deworming_wave'] ) );
		} else {
			$doc_title = 'budget_'.str_replace(' ', '_', strtolower( $meta['budget_cat'] ) ).'_'.str_replace(' ', '_', strtolower( $meta['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($meta['location'] ) ).'_'. str_replace(' ', '_', strtolower($meta['deworming_wave'] ) );
		}

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('pdf_budget_forms/'.$doc_title.'.pdf', 'F');

	}

	public function createMtBudgetPDF($meta) {

		global $database;
        $database->query("SELECT
          fin_budget_item_cat.item_cat,
          fin_budget_jnk_item_cat_item_desc.item_desc,
          fin_budget_jnk_item_cat_item_desc.unit_cost,
          fin_budget_mt.id,
          fin_budget_mt.unit_key_1,
          fin_budget_mt.unit_value_1,
          fin_budget_mt.unit_key_2,
          fin_budget_mt.unit_value_2,
          fin_budget_mt.unit_key_3,
          fin_budget_mt.unit_value_3,
          fin_budget_mt.unit_key_4,
          fin_budget_mt.unit_value_4
        FROM fin_budget_mt
        JOIN fin_budget_jnk_item_cat_item_desc ON fin_budget_jnk_item_cat_item_desc.id = fin_budget_mt.record_id
        JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id
        WHERE
        fin_budget_mt.sub_county = :sub_county AND 
        fin_budget_mt.wave = :wave",
            array(
            ':sub_county' => urldecode($_REQUEST['loc']),
            ':wave' => $_REQUEST['wave'],
            )
        );
        $count = $database->count();
        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

        $new_results = array();
        foreach ($results as $key => $result) {
          $item_cat = $result['item_cat'];
          $new_results[$item_cat][$key] = array(
            'id'           => $result['id'],
            'record_id'    => $result['record_id'],
            'item_desc'    => $result['item_desc'],
            'unit_cost'    => $result['unit_cost'],
            'unit_key_1'   => $result['unit_key_1'],
            'unit_value_1' => $result['unit_value_1'],
            'unit_key_2'   => $result['unit_key_2'],
            'unit_value_2' => $result['unit_value_2'],
            'unit_key_3'   => $result['unit_key_3'],
            'unit_value_3' => $result['unit_value_3'],
            'unit_key_4'   => $result['unit_key_4'],
            'unit_value_4' => $result['unit_value_4']
          );
        }

        $database->query("SELECT unit_value_1*unit_value_2*unit_value_3*unit_value_4 AS row_total FROM fin_budget_mt
          WHERE sub_county = :sub_county AND wave = :wave AND record_id IN ('328', '324', '320' , '323')",
              array(
                ':sub_county' => $_GET['loc'],
                ':wave' => $_GET['wave']
              )
          );
        $cost_per_mt = $database->statement->fetchall(PDO::FETCH_ASSOC);


        $total_of_sum = array();
        foreach ($cost_per_mt as $key => $value) {
          array_push($total_of_sum, $value['row_total'] );
        }

        $cost_per_mt = floor(array_sum($total_of_sum)/54 );

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf/tcpdf_include.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($_SESSION['staff_name']);
		$pdf->SetTitle($meta['doc_heading']);
		$pdf->SetSubject($meta['doc_title']);
		//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
			require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('helvetica', '', 9, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage("L","mm","A4",true,"UTF-8",false);

		$pdf->SetXY(0, 1.5);
		$header = '<div style="text-align:center"><img src="'.dirname(__FILE__).'../../../images/logo.jpg" width="100" height="80" border="0" />';
		$header .= '<h2>MT TRaining Budget For '.ucwords($meta['location']).', Deworming Wave: '.ucwords($meta['deworming_wave']).'</h2>';

		$tableHeader = '
			<table style="border:0.5px solid #333333; font-size: 10px; width: 100%;">
	        <tr>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Item Description</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit #</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit type</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit #</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit Type</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit #</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit Type</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit #</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit Type</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Unit Cost (Ksh)</small></th>
	          <th align="left" style="height:25px;border:0.5px solid #333333;" ><small>Total Cost (Ksh)</small></th>
	        </tr>
	        ';

		// Table content beings here 
        $total_array = array();
        foreach ($new_results as $key => $new_result) {

          $table .= '<tr><td colspan="11" align="left" style="height:25px;border:0.5px solid #333333;" ><b>'.$key.'</b></td></tr>';

          $sub_total_array = array(); 
          foreach ($new_result as $key => $value) { 

            if ( $value['unit_cost']    == '' || $value['unit_cost'] == 'NULL' )    { $unit_cost    = 1; } else { $unit_cost    = $value['unit_cost']; }
            if ( $value['unit_value_1'] == '' || $value['unit_value_1'] == 'NULL' ) { $unit_value_1 = 1; } else { $unit_value_1 = $value['unit_value_1']; }
            if ( $value['unit_value_2'] == '' || $value['unit_value_2'] == 'NULL' ) { $unit_value_2 = 1; } else { $unit_value_2 = $value['unit_value_2']; }
            if ( $value['unit_value_3'] == '' || $value['unit_value_3'] == 'NULL' ) { $unit_value_3 = 1; } else { $unit_value_3 = $value['unit_value_3']; }
            if ( $value['unit_value_4'] == '' || $value['unit_value_4'] == 'NULL' ) { $unit_value_4 = 1; } else { $unit_value_4 = $value['unit_value_4']; }
            
            $row_total = $unit_cost*$unit_value_1*$unit_value_2*$unit_value_3*$unit_value_4;
            array_push($sub_total_array, $row_total);
            $table .= '<tr>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['item_desc'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_cost'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_key_1'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_value_1'].'	</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_key_2'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_value_2'].'	</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_key_3'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_value_3'].'	</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_key_4'].'		</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. $value['unit_value_4'].'	</td>
              <td align="left" style="height:25px;border:0.5px solid #333333;" >'. number_format($row_total).'</td>
            </tr>';
          }
          $sub_total = array_sum($sub_total_array); 
          array_push($total_array, $sub_total);

          $table .= '<tr> 
          	<td align="left" ><em>Sub-Total</em></td> 
          	<td align="left"  colspan="9">&nbsp;</td> 
          	<td>'.number_format($sub_total).'</td> 
          </tr>';
      	}

		$table .= '
          <tr>
            <td colspan="11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" colspan="10" align="left" style="height:25px;border:0.5px solid #333333;" ><b>TOTAL</b></td>
            <td align="left" style="height:25px;border:0.5px solid #333333;" ><b>'.number_format( array_sum($total_array) ).'</b></td>
          </tr>
          <tr>
            <td align="left" colspan="10" align="left" style="height:25px;border:0.5px solid #333333;">Cost  per master trainer (Incidentals, Accomodation, Conference and Transport)</td>
            <td align="left" style="height:25px;border:0.5px solid #333333;"><b>'.number_format($cost_per_mt).'</b></td>
          </tr>
          <tr>
            <td colspan="11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" colspan="11"><b>Notes:</b></td>
          </tr>
          <tr>
            <td colspan="11"></td>
          </tr></table>';

		$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

		ob_clean();
		$doc_title = 'budget_'.str_replace(' ', '_', strtolower( $meta['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($meta['location'] ) ).'_'. str_replace(' ', '_', strtolower($meta['deworming_wave'] ) );

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('pdf_budget_forms/'.$doc_title.'.pdf', 'F');

	}


}

$financeClass = new FinanceModule();

?>