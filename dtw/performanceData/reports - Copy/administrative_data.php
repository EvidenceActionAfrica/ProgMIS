<?php require_once('config/include.php');
$evidenceaction = new EvidenceAction();
$evidenceaction->checksession();
//echo $_SESSION['admin_id'];
	$tablename = 'form_s';
	$fields = '*';
	$where = 'user_id="'.$_SESSION['admin_id'].'"';
	$fetchschoolrecord = $evidenceaction->selectrow($tablename, $fields, $where);
	//print_r($fetchschoolrecord);
	
	$tablename = 'form_s_class';
	$fields = '*';
	$where = 'user_id="'.$_SESSION['admin_id'].'"';
	$fetchclassdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
	//print_r($fetchclassdata);
	
if($_SERVER['REQUEST_METHOD']=='POST'){	
	
	$tablename = 'form_s';
	$fields = 'survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				school_name="'.$_POST['schoolname'].'",
			  	school_type="'.$_POST['schooltype'].'",
				deworming_date="'.$_POST['dt'].'",
				district="'.$_POST['districts'].'",
				division="'.$_POST['division'].'",
				zone="'.$_POST['zone'].'",
				ecd_treated_male="'.$_POST['ecd_treated_male'].'",	
				ecd_treated_female="'.$_POST['ecd_treated_female'].'",
				ecd_treated_children_total="'.$_POST['ecd_treated_total'].'",
				ecd_adults_treated="'.$_POST['ecd_adult_treated'].'",
				ecd_tablets_spoilt="'.$_POST['ecd_tablets_spoiled'].'",
				years_2_5_male="'.$_POST['2_5_yrs_male'].'",	
				years_2_5_female="'.$_POST['2_5_yrs_female'].'",
				years_6_10_male="'.$_POST['6_10_yrs_male'].'",
				years_6_10_female="'.$_POST['6_10_yrs_female'].'",
				years_11_14_male="'.$_POST['11_14_yrs_male'].'",
				years_11_14_female="'.$_POST['11_14_yrs_female'].'",	
				years_15_18_male="'.$_POST['15_18_yrs_male'].'",
				years_15_18_female="'.$_POST['15_18_yrs_female'].'",
				non_enrolled_total="'.$_POST['non_enroll_total'].'",
				non_enrolled_adults_treated="'.$_POST['non_enroll_adult_treated'].'",
				non_enrolled_tablets_spoilt="'.$_POST['non_enroll_tablet_spoiled'].'",	
				albendazole_recieved="'.$_POST['albendazole_receive'].'",
				albendazole_returned="'.$_POST['albendazole_return'].'",
				total_a_b_c="'.$_POST['child_a_b_c'].'",
				total_d_e_f="'.$_POST['adult_d_e_f'].'",
				total_g_h_i="'.$_POST['spoiled_g_h_i'].'",	
				head_teacher="'.$_POST['head_teacher'].'",
				phone_number="'.$_POST['head_ph_no'].'",
				aeo_name="'.$_POST['aeo_name'].'",	
				school_programme_id="'.$_POST['p_assign_school_id'].'",
				aeo_phone_no="'.$_POST['aeo_ph_no'].'"
	';
	if(empty($fetchschoolrecord)){
	$evidenceaction->insert($tablename, $fields);
	}else{		
	$where = 'user_id = "'.$_SESSION['admin_id'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	}
	if(empty($fetchclassdata)){
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_01'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_01'].'",
				number_in_register_female="'.$_POST['tot_reg_female_01'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_01'].'",
				number_treated_male="'.$_POST['tot_treat_male_01'].'",
				number_treated_female="'.$_POST['tot_treat_female_01'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_01'].'",	
				adults_treated="'.$_POST['adults_treated_01'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_01'].'"
	';
	
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_02'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_02'].'",
				number_in_register_female="'.$_POST['tot_reg_female_02'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_02'].'",
				number_treated_male="'.$_POST['tot_treat_male_02'].'",
				number_treated_female="'.$_POST['tot_treat_female_02'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_02'].'",	
				adults_treated="'.$_POST['adults_treated_02'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_02'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_03'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_03'].'",
				number_in_register_female="'.$_POST['tot_reg_female_03'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_03'].'",
				number_treated_male="'.$_POST['tot_treat_male_03'].'",
				number_treated_female="'.$_POST['tot_treat_female_03'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_03'].'",	
				adults_treated="'.$_POST['adults_treated_03'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_03'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_04'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_04'].'",
				number_in_register_female="'.$_POST['tot_reg_female_04'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_04'].'",
				number_treated_male="'.$_POST['tot_treat_male_04'].'",
				number_treated_female="'.$_POST['tot_treat_female_04'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_04'].'",	
				adults_treated="'.$_POST['adults_treated_04'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_04'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_05'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_05'].'",
				number_in_register_female="'.$_POST['tot_reg_female_05'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_05'].'",
				number_treated_male="'.$_POST['tot_treat_male_05'].'",
				number_treated_female="'.$_POST['tot_treat_female_05'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_05'].'",	
				adults_treated="'.$_POST['adults_treated_05'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_05'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_06'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_06'].'",
				number_in_register_female="'.$_POST['tot_reg_female_06'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_06'].'",
				number_treated_male="'.$_POST['tot_treat_male_06'].'",
				number_treated_female="'.$_POST['tot_treat_female_06'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_06'].'",	
				adults_treated="'.$_POST['adults_treated_06'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_06'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_07'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_07'].'",
				number_in_register_female="'.$_POST['tot_reg_female_07'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_07'].'",
				number_treated_male="'.$_POST['tot_treat_male_07'].'",
				number_treated_female="'.$_POST['tot_treat_female_07'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_07'].'",	
				adults_treated="'.$_POST['adults_treated_07'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_07'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_08'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_08'].'",
				number_in_register_female="'.$_POST['tot_reg_female_08'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_08'].'",
				number_treated_male="'.$_POST['tot_treat_male_08'].'",
				number_treated_female="'.$_POST['tot_treat_female_08'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_08'].'",	
				adults_treated="'.$_POST['adults_treated_08'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_08'].'"
	';
	$evidenceaction->insert($tablename, $fields);
	header('Location: /evidence_action/administrative_data.php');
	}else{
		
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_01'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_01'].'",
				number_in_register_female="'.$_POST['tot_reg_female_01'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_01'].'",
				number_treated_male="'.$_POST['tot_treat_male_01'].'",
				number_treated_female="'.$_POST['tot_treat_female_01'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_01'].'",	
				adults_treated="'.$_POST['adults_treated_01'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_01'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_01'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_02'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_02'].'",
				number_in_register_female="'.$_POST['tot_reg_female_02'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_02'].'",
				number_treated_male="'.$_POST['tot_treat_male_02'].'",
				number_treated_female="'.$_POST['tot_treat_female_02'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_02'].'",	
				adults_treated="'.$_POST['adults_treated_02'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_02'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_02'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_03'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_03'].'",
				number_in_register_female="'.$_POST['tot_reg_female_03'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_03'].'",
				number_treated_male="'.$_POST['tot_treat_male_03'].'",
				number_treated_female="'.$_POST['tot_treat_female_03'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_03'].'",	
				adults_treated="'.$_POST['adults_treated_03'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_03'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_03'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_04'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_04'].'",
				number_in_register_female="'.$_POST['tot_reg_female_04'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_04'].'",
				number_treated_male="'.$_POST['tot_treat_male_04'].'",
				number_treated_female="'.$_POST['tot_treat_female_04'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_04'].'",	
				adults_treated="'.$_POST['adults_treated_04'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_04'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_04'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_05'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_05'].'",
				number_in_register_female="'.$_POST['tot_reg_female_05'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_05'].'",
				number_treated_male="'.$_POST['tot_treat_male_05'].'",
				number_treated_female="'.$_POST['tot_treat_female_05'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_05'].'",	
				adults_treated="'.$_POST['adults_treated_05'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_05'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_05'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_06'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_06'].'",
				number_in_register_female="'.$_POST['tot_reg_female_06'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_06'].'",
				number_treated_male="'.$_POST['tot_treat_male_06'].'",
				number_treated_female="'.$_POST['tot_treat_female_06'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_06'].'",	
				adults_treated="'.$_POST['adults_treated_06'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_06'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_06'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_07'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_07'].'",
				number_in_register_female="'.$_POST['tot_reg_female_07'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_07'].'",
				number_treated_male="'.$_POST['tot_treat_male_07'].'",
				number_treated_female="'.$_POST['tot_treat_female_07'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_07'].'",	
				adults_treated="'.$_POST['adults_treated_07'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_07'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_07'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	
	$tablename = 'form_s_class';
	$fields =  'form_s_survey_id="'.$_POST['survey_id'].'",
				user_id="'.$_SESSION['admin_id'].'",
				class="'.$_POST['class_08'].'",
			  	number_in_register_male="'.$_POST['tot_reg_male_08'].'",
				number_in_register_female="'.$_POST['tot_reg_female_08'].'",
				number_in_register_class_total="'.$_POST['tot_reg_total_08'].'",
				number_treated_male="'.$_POST['tot_treat_male_08'].'",
				number_treated_female="'.$_POST['tot_treat_female_08'].'",
				number_treated_total="'.$_POST['tot_treat_male_total_08'].'",	
				adults_treated="'.$_POST['adults_treated_08'].'",
				tablets_spoilt="'.$_POST['tablets_spoilt_08'].'"
	';
	$where = 'user_id = "'.$_SESSION['admin_id'].'" and class="'.$_POST['class_08'].'"';
	$evidenceaction->update($tablename, $fields, $where);
	header('Location: /evidence_action/administrative_data.php');
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include('config/head.php');?>
		<title>
			Evidence Action :: Administrative Data
		</title>
        	<link href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="css/jquery-ui.css" rel="stylesheet">
	<script src="js/calender_js/jquery-1.9.1.js"></script>
	<script src="js/calender_js/jquery-ui-1.10.3.custom.js"></script>
	<script>
	$(function() {	
		$( "#dp" ).datepicker({
			inline: true,
			dateFormat: "yy-mm-dd"
		});
		});
	</script>
	<style>
	/*body{
		font: 62.5% "Trebuchet MS", sans-serif;
		
	}*/
	.demoHeaders {
		margin-top: 2em;
	}
	#dialog-link {
		padding: .4em 1em .4em 20px;
		text-decoration: none;
		position: relative;
	}
	#dialog-link span.ui-icon {
		margin: 0 5px 0 0;
		position: absolute;
		left: .2em;
		top: 50%;
		margin-top: -8px;
	}
	#icons {
		margin: 0;
		padding: 0;
	}
	#icons li {
		margin: 2px;
		position: relative;
		padding: 4px 0;
		cursor: pointer;
		float: left;
		list-style: none;
	}
	#icons span.ui-icon {
		float: left;
		margin: 0 4px;
	}
	.fakewindowcontain .ui-widget-overlay {
		position: absolute;
	}
	</style>
        
	</head>
	<body>
<?php
	require_once('config/include.php');
	  $evidenceaction = new EvidenceAction();
	  $evidenceaction->checksession();
?>
		<div class="wrapperNwp">
			<!---------------- header start ------------------------>

			<?php include('config/header.php');?>

			<!---------------- header end ------------------------>

			<!---------------- body start ------------------------>
<form name="frm_admin_data" method="POST">
			<div class="rstBdy">
				<div class="schDtlFrm">
					<div class="srvyHldr">
						<ul>
							<li>
								<label>	Survey ID :	</label>
								<input name="survey_id" class="inputBox" type="text" value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['survey_id'];}?>" />
							
							</li>
						</ul>
					</div>
					<p class="hdTxt">
						<span>
							Section 1 :
						</span> School Details
					</p>
					
					<?php 
					$tablename = 'schools';
					$fields = 'school_id, p_orig_schname';
					$where = '1=1';
					$kind = 'order by p_orig_schname';
					$fetchschooldata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where, $kind);?>
					
					<?php 
					$tablename = 'districts';
					$fields = 'district_id, district_name';
					$where = '1=1';
					$kind = 'order by district_name';
					$fetchdistrictdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where, $kind);?>
					
					<?php 
					$tablename = 'divisions';
					$fields = 'division_id,division_name';
					$where = '1=1';
					$kind = ' and division_name !="" order by division_name';
					$fetchsdivdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where, $kind);?>
					
						<ul class="selBxSec">
							<li>
								<p>
									School Name
								</p>
								<select class="input" name="schoolname" id="schoolname">
								<?php 
					foreach($fetchschooldata as $fetchschool){?>
						<option value="<?php echo $fetchschool['school_id'];?>"><?php echo $fetchschool['p_orig_schname'];?></option>
					<?php }?>
									
								</select>
							</li>
							<li>
								<p>
									School Type
								</p>
								<select class="input"  name="schooltype" id="schooltype">
									<option value="public">Public</option>
									<option value="private">Private</option>
								</select>
							</li>
							<li>
								<p>
									Deworming Date
								</p>
								<input name="dt" class="onlyinput" type="text" id="dp"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['deworming_date'];}?>" />
                              <!--  <input type="text" name="dt" id="dp">-->
							</li>
							<li>
								<p>
									District
								</p>
								<select class="input"  name="districts" id="districts">
								<?php 
					foreach($fetchdistrictdata as $fetchdistrict){?>
						<option value="<?php echo $fetchdistrict['district_id'];?>"><?php echo $fetchdistrict['district_name'];?></option>
					<?php }?>
					</select>
							</li>
							<li>
								<p>
									Division
								</p>
								<select class="input"  name="division" id="division">
				<?php 
					foreach($fetchsdivdata as $fetchsdiv){?>
						<option value="<?php echo $fetchsdiv['division_id'];?>"><?php echo $fetchsdiv['division_name'];?></option>
					<?php }?>
								</select>
							</li>
							<li>
								<p>
									Zone
								</p>
								<input name="zone" id="zone" class="onlyinput" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['zone'];}?>"/>
							</li>
						</ul>

				
					<p class="hdTxt01">
						<span>
							Section 2:
						</span> Use summary section6 (final summary) of all forms Es for enrolled ECD children to fill
					</p>
					<div class="totalBx">
						<table width="89%" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									Enrolled ECD age Children Recorded on Form Es where box 1 is ticked
								</td>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td colspan="3">
												TOTAL NUMBER OF ECD TREATED
											</td>
										</tr>
										<tr>
											<td colspan="3">&nbsp;
												
											</td>
										</tr>
										<tr>
											<td>
												MALE
											</td>
											<td>
												FEMALE
											</td>
											<td>
												TOTAL
											</td>
										</tr>
									</table>
								</td>
								<td>
									Adults Treated
								</td>
								<td>
									Tablets Spoiled
								</td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;
									
								</td>
							</tr>
							<tr>
								<td width="25%">
									TOTAL
								</td>
								<td width="52%">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<input name="ecd_treated_male" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['ecd_treated_male'];}?>"/>
											</td>
											<td>
												<input name="ecd_treated_female" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['ecd_treated_female'];}?>"/>
											</td>
											<td>
												<input name="ecd_treated_total" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['ecd_treated_children_total'];}?>"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="12%">
									<input name="ecd_adult_treated" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['ecd_adults_treated'];}?>"/>
								</td>
								<td width="11%">
									<input name="ecd_tablets_spoiled" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['ecd_tablets_spoilt'];}?>"/>
								</td>
							</tr>
						</table>

					</div>
					<p class="hdTxt01">
						<span>
							Section 3:
						</span> Use summary section6 (final summary) of all forms Ns to fill below
					</p>
					<div class="totalBx">
					<?php
					if(empty($fetchclassdata)){
						?>
						<table width="90%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
						  	<td colspan="9" align="left" valign="top"><strong>Enrolled Primary School Children</strong> Recorded on form Es</td>
						  </tr>
						  <tr>
						  	<td colspan="9" align="left" valign="top" height="10"></td>
						  </tr>
						  <tr>
							<td width="10%">Class</td>
							<td width="30%" colspan="3">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td colspan="3">TOTAL NO OF CHILDREN IN REGISTER BOOK</td>
								  </tr>
								  <tr>
									<td colspan="3" height="10"></td>
								  </tr>
								  <tr>
									<td>MALE:</td>
									<td>FEMALE:</td>
									<td>TOTAL</td>
								  </tr>
								</table>

							</td>
							<td width="30%" colspan="3">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td colspan="3">TOTAL NO OF CHILDREN TREATED</td>
								  </tr>
								  <tr>
									<td colspan="3" height="10"></td>
								  </tr>
								  <tr>
									<td>MALE:</td>
									<td>FEMALE:</td>
									<td>TOTAL</td>
								  </tr>
								</table>

							</td>
							<td width="10%">Adults Treated:</td>
							<td width="10%">Tablets Spoiled:</td>
						  </tr>
						  <tr>
							<td height="20"></td>
						  </tr>
						  <tr>
							<td><input name="class_01" class="impt02" type="text" value="1" style="text-align:center" readonly="" /></td>
							<td><input name="tot_reg_male_01" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_01" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_01" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_01" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_01" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_01" class="impt01" type="text" /></td>
							<td><input name="adults_treated_01" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_01" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_02" class="impt02" type="text" value="2" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_02" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_02" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_02" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_02" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_02" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_02" class="impt01" type="text" /></td>
							<td><input name="adults_treated_02" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_02" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_03" class="impt02" type="text" value="3" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_03" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_03" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_03" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_03" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_03" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_03" class="impt01" type="text" /></td>
							<td><input name="adults_treated_03" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_03" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_04" class="impt02" type="text" value="4" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_04" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_04" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_04" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_04" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_04" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_04" class="impt01" type="text" /></td>
							<td><input name="adults_treated_04" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_04" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_05" class="impt02" type="text" value="5" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_05" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_05" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_05" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_05" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_05" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_05" class="impt01" type="text" /></td>
							<td><input name="adults_treated_05" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_05" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_06" class="impt02" type="text" value="6" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_06" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_06" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_06" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_06" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_06" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_06" class="impt01" type="text" /></td>
							<td><input name="adults_treated_06" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_06" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_07" class="impt02" type="text" value="7" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_07" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_07" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_07" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_07" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_07" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_07" class="impt01" type="text" /></td>
							<td><input name="adults_treated_07" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_07" class="impt01" type="text" /></td>
						  </tr>
						  <tr>
							<td><input name="class_08" class="impt02" type="text" value="8" style="text-align:center" readonly=""/></td>
							<td><input name="tot_reg_male_08" class="impt02" type="text" /></td>
							<td><input name="tot_reg_female_08" class="impt02" type="text" /></td>
							<td><input name="tot_reg_total_08" class="impt02" type="text" /></td>
							<td><input name="tot_treat_male_08" class="impt01" type="text" /></td>
							<td><input name="tot_treat_female_08" class="impt01" type="text" /></td>
							<td><input name="tot_treat_male_total_08" class="impt01" type="text" /></td>
							<td><input name="adults_treated_08" class="impt01" type="text" /></td>
							<td><input name="tablets_spoilt_08" class="impt01" type="text" /></td>
						  </tr>
						</table>
					<?php 
					}else{?>
					<table width="90%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
						  	<td colspan="9" align="left" valign="top"><strong>Enrolled Primary School Children</strong> Recorded on form Es</td>
						  </tr>
						  <tr>
						  	<td colspan="9" align="left" valign="top" height="10"></td>
						  </tr>
						  <tr>
							<td width="10%">Class</td>
							<td width="30%" colspan="3">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td colspan="3">TOTAL NO OF CHILDREN IN REGISTER BOOK</td>
								  </tr>
								  <tr>
									<td colspan="3" height="10"></td>
								  </tr>
								  <tr>
									<td>MALE:</td>
									<td>FEMALE:</td>
									<td>TOTAL</td>
								  </tr>
								</table>

							</td>
							<td width="30%" colspan="3">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td colspan="3">TOTAL NO OF CHILDREN TREATED</td>
								  </tr>
								  <tr>
									<td colspan="3" height="10"></td>
								  </tr>
								  <tr>
									<td>MALE:</td>
									<td>FEMALE:</td>
									<td>TOTAL</td>
								  </tr>
								</table>

							</td>
							<td width="10%">Adults Treated:</td>
							<td width="10%">Tablets Spoiled:</td>
						  </tr>
						  <tr>
							<td height="20"></td>
						  </tr>
						  <tr>
						  <?php for($i=0;$i<count($fetchclassdata);$i++){
						  	if($fetchclassdata[$i]['class']==1){
								$class_01_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==2){
								$class_02_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==3){
								$class_03_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==4){
								$class_04_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==5){
								$class_05_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==6){
								$class_06_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==7){
								$class_07_val[] = $fetchclassdata[$i];
							}
							if($fetchclassdata[$i]['class']==8){
								$class_08_val[] = $fetchclassdata[$i];
							}
						  }
						  ?>
						  	<td><input name="class_01" class="impt02" type="text" value="1" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_01" class="impt02" type="text"   value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_01" class="impt02" type="text"  value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_01" class="impt02" type="text"  value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_01" class="impt01" type="text"  value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_01" class="impt01" type="text"  value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_01" class="impt01" type="text"  value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_01" class="impt01" type="text"   value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_01" class="impt01" type="text"   value="<?php if(!empty($class_01_val)){echo $class_01_val[0]['tablets_spoilt'];}?>"/></td>
							
						  </tr>
						  <tr>
							<td><input name="class_02" class="impt02" type="text" value="2" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_02" class="impt02" type="text"   value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_02" class="impt02" type="text"  value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_02" class="impt02" type="text"  value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_02" class="impt01" type="text"  value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_02" class="impt01" type="text"  value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_02" class="impt01" type="text"  value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_02" class="impt01" type="text"   value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_02" class="impt01" type="text"   value="<?php if(!empty($class_02_val)){echo $class_02_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  
						  
						  <tr>
							<td><input name="class_03" class="impt02" type="text" value="3" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_03" class="impt02" type="text"   value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_03" class="impt02" type="text"  value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_03" class="impt02" type="text"  value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_03" class="impt01" type="text"  value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_03" class="impt01" type="text"  value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_03" class="impt01" type="text"  value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_03" class="impt01" type="text"   value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_03" class="impt01" type="text"   value="<?php if(!empty($class_03_val)){echo $class_03_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  
						  
						  <tr>
							<td><input name="class_04" class="impt02" type="text" value="4" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_04" class="impt02" type="text"   value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_04" class="impt02" type="text"  value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_04" class="impt02" type="text"  value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_04" class="impt01" type="text"  value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_04" class="impt01" type="text"  value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_04" class="impt01" type="text"  value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_04" class="impt01" type="text"   value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_04" class="impt01" type="text"   value="<?php if(!empty($class_04_val)){echo $class_04_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  
						  <tr>
							<td><input name="class_05" class="impt02" type="text" value="5" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_05" class="impt02" type="text"   value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_05" class="impt02" type="text"  value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_05" class="impt02" type="text"  value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_05" class="impt01" type="text"  value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_05" class="impt01" type="text"  value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_05" class="impt01" type="text"  value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_05" class="impt01" type="text"   value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_05" class="impt01" type="text"   value="<?php if(!empty($class_05_val)){echo $class_05_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  
						  <tr>
							<td><input name="class_06" class="impt02" type="text" value="6" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_06" class="impt02" type="text"   value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_06" class="impt02" type="text"  value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_06" class="impt02" type="text"  value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_06" class="impt01" type="text"  value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_06" class="impt01" type="text"  value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_06" class="impt01" type="text"  value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_06" class="impt01" type="text"   value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_06" class="impt01" type="text"   value="<?php if(!empty($class_06_val)){echo $class_06_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  <tr>
							<td><input name="class_07" class="impt02" type="text" value="7" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_07" class="impt02" type="text"   value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_07" class="impt02" type="text"  value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_07" class="impt02" type="text"  value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_07" class="impt01" type="text"  value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_07" class="impt01" type="text"  value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_07" class="impt01" type="text"  value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_07" class="impt01" type="text"   value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_07" class="impt01" type="text"   value="<?php if(!empty($class_07_val)){echo $class_07_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						  
						  
						  
						  <tr>
							<td><input name="class_08" class="impt02" type="text" value="8" style="text-align:center" readonly /></td>
							<td><input name="tot_reg_male_08" class="impt02" type="text"   value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_in_register_male'];}?>"/></td>
							<td><input name="tot_reg_female_08" class="impt02" type="text"  value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_in_register_female'];}?>" /></td>
							<td><input name="tot_reg_total_08" class="impt02" type="text"  value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_in_register_class_total'];}?>" /></td>
							<td><input name="tot_treat_male_08" class="impt01" type="text"  value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_treated_male'];}?>" /></td>
							<td><input name="tot_treat_female_08" class="impt01" type="text"  value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_treated_female'];}?>" /></td>
							<td><input name="tot_treat_male_total_08" class="impt01" type="text"  value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['number_treated_total'];}?>" /></td>
							<td><input name="adults_treated_08" class="impt01" type="text"   value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['adults_treated'];}?>"/></td>
							<td><input name="tablets_spoilt_08" class="impt01" type="text"   value="<?php if(!empty($class_08_val)){echo $class_08_val[0]['tablets_spoilt'];}?>"/></td>
						  </tr>
						</table>
					<?php
					}?>
					</div>
					<p class="hdTxt01">
						<span>
							Section 4:
						</span> Use summary section6 (final summary) of all forms Ns to fill below
					</p>
					<div class="totalBx">
						<table width="89%" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									Non Enrolled Children recorded on form N
								</td>
								<td>
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr align="center">
											<td>
												&nbsp;&nbsp;2-5 yrs
											</td>
											<td>
												&nbsp;&nbsp;6-10 yrs
											</td>
											<td>
												11-14 yrs
											</td>
											<td>
												15-18 yrs
											</td>
										</tr>
										<tr>
											<td colspan="4">&nbsp;
												
											</td>
										</tr>
									</table>
								</td>
								<td>
									TOTAL
								</td>
								<td>
									Adults Treated
								</td>
								<td>
									Tables Spoilt
								</td>
							</tr>

							<tr>
								<td width="21%">
									TOTAL
								</td>
								<td width="48%">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												<p>
													M
												</p><input name="2_5_yrs_male" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_2_5_male'];}?>"/>
											</td>
											<td>
												<p>
													F
												</p><input name="2_5_yrs_female" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_2_5_female'];}?>"/>
											</td>
											<td>
												<p>
													M
												</p><input name="6_10_yrs_male" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_6_10_male'];}?>"/>
											</td>
											<td>
												<p>
													F
												</p><input name="6_10_yrs_female" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_6_10_female'];}?>"/>
											</td>
											<td>
												<p>
													M
												</p><input name="11_14_yrs_male" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_11_14_male'];}?>"/>
											</td>
											<td>
												<p>
													F
												</p><input name="11_14_yrs_female" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_11_14_female'];}?>"/>
											</td>
											<td>
												<p>
													M
												</p><input name="15_18_yrs_male" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_15_18_male'];}?>"/>
											</td>
											<td>
												<p>
													F
												</p><input name="15_18_yrs_female" class="textfil01" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['years_15_18_female'];}?>"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="11%">
									<p>&nbsp;
										
									</p><input name="non_enroll_total" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['non_enrolled_total'];}?>"/>
								</td>
								<td width="10%">
									<p>&nbsp;
										
									</p><input name="non_enroll_adult_treated" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['non_enrolled_adults_treated'];}?>"/>
								</td>
								<td width="10%">
									<p>&nbsp;
										
									</p><input name="non_enroll_tablet_spoiled" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['non_enrolled_tablets_spoilt'];}?>"/>
								</td>
							</tr>
						</table>

					</div>

					<p class="hdTxt01">
						<span>
							Section 5:
						</span> Calculate all treated (use totals to quide you) and report balance to be returned to AEO
					</p>

					<div class="totalBx">
						<table width="89%" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0">
							<tr>
								<td width="35%">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td>
												Albendazole received
											</td>
											<td>
												<input name="albendazole_receive" class="textfil11" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['albendazole_recieved'];}?>"/>
											</td>
										</tr>
										<tr>
											<td>
												Albendazole retured
											</td>
											<td>
												<input name="albendazole_return" class="textfil11" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['albendazole_returned'];}?>"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="5%">&nbsp;
									
								</td>
								<td width="60%">
									<table width="100%" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td rowspan="2">
												TOTAL treaments: (add each column using letters provided to guide you)
											</td>
											<td valign="top">
												Children A+B+C
											</td>
											<td valign="top">
												Adults D+E+F
											</td>
											<td valign="top">
												Tablets Spoiled G+H+I
											</td>
										</tr>
										<tr>
											<td>
												<input name="child_a_b_c" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['total_a_b_c'];}?>"/>
											</td>
											<td>
												<input name="adult_d_e_f" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['total_d_e_f'];}?>"/>
											</td>
											<td>
												<input name="spoiled_g_h_i" class="textfil" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['total_g_h_i'];}?>"/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>

					</div>

					<div class="headPart">
						<ul>
							<li>
								<label>Head Teacher :</label>
								<input name="head_teacher" class="inputBox" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['head_teacher'];}?>"/>
							</li>
							<li>
								<label>Phone Number :</label>
								<input name="head_ph_no" class="inputBox" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['phone_number'];}?>"/>
							</li>
						</ul>
					</div>
					<div class="thankText">
						THANK YOU HEAD TEACHER PLEASE COPY FORM AND SUPPLY ONE COPY TO AEO
					</div>
					<p class="hdTxt01">
						<span>
							SECTION FOR COMPLETION BY AEO:
						</span> <em>Complete in full . Refer to form A for programme assigned school ID.</em>
					</p>
					<div class="headPart">
						<ul>
							<li>
								<label>	AEO Name :</label>
								<input name="aeo_name" class="inputBox" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['aeo_name'];}?>"/>
							</li>
							<li>
								<label>Programme assigned school ID :</label>
								<input name="p_assign_school_id" class="inputBox" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['school_programme_id'];}?>"/>
							</li>
							<li>
								<label>Phone Number :</label>
								<input name="aeo_ph_no" class="inputBox" type="text"  value="<?php if(!empty($fetchschoolrecord)){echo $fetchschoolrecord['aeo_phone_no'];}?>"/>
							</li>
						</ul>
					</div>
					<div class="creatPart">
						<input name="create" class="createBtn" type="submit" value="Create" />
					</div>
				</div>
			</div>
			</form>
			<!---------------- body end ------------------------>

		</div>
	</body>
</html>
