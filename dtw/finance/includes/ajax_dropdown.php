<?php
//include('./includes/config.php');
//include('./includes/db_functions.php');
require('includes/db.class.php');

//$evidenceaction = new EvidenceAction();

if(isset($_REQUEST['checkval']) && !empty($_REQUEST['checkval'])){
//===== DISTRICT ==========
	if($_REQUEST['checkval']=='district'){?>
		<option value="">Select District</option>
		<?php
		$database->query('SELECT district_id, district_name FROM districts WHERE county = :county',
				array(
					':county' => $_REQUEST['county']
				));
		$insertformdata = $database->statement->fetchall(PDO::FETCH_ASSOC);	  	
		foreach($insertformdata as $insertformdatav){?>
			<option value="<?php echo $insertformdatav['district_name'];?>"><?php echo $insertformdatav['district_name'];?></option>
		<?php }
		die();
	}
//===== DIVISION ==========
	if($_REQUEST['checkval']=='division'){
		$tablename = 'divisions';
		$fields = 'division_name';
		$where = 'district_name="'.$_REQUEST['district'].'"';
		$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		?>
		<option value="">Choose Division</option>
    <?php 
		foreach($insertformdata as $insertformdatav){?>
			<option value="<?php echo $insertformdatav['division_name'];?>"><?php echo $insertformdatav['division_name'];?></option>
		<?php }
		die();
	}
//===== SCHOOL ==========
	if($_REQUEST['checkval']=='school'){
		$tablename = 'schools';
		$fields = 'school_name';
		$where = 'division_name="'.$_REQUEST['division'].'"';
		$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		?>
		<option value="">Choose School</option>
		<?php 
		foreach($insertformdata as $insertformdatav){?>
			<option value="<?php echo $insertformdatav['school_name'];?>"><?php echo $insertformdatav['school_name'];?></option>
		<?php }
		die();
	}
 
}
?>

