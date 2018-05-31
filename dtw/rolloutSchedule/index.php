<?php
    ob_start();
    require_once('../includes/auth.php');
	require_once('../includes/config.php');
    require_once ('../includes/logTracker.php');
	require_once("../includes/functions.php");
	require_once("../includes/form_functions.php");

	date_default_timezone_set('Africa/Nairobi');
	include('includes/rollout.class.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

<head>
    <title>Evidence Action</title>
    <!--lawrence header-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="css/default.css" type="text/css" rel="stylesheet"/>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!--Datepicker CSS files-->
    <link rel="stylesheet" type="text/css" href="../calendar/jquery-ui.css.css"/>
    <link rel="stylesheet" type="text/css" href="../calendar/datepicker.css"/>
    <!--textext CSS-->
    <link rel="stylesheet" type="text/css" href="../css/textext.core.css">
    <link rel="stylesheet" type="text/css" href="../css/textext.plugin.tags.css">
    <link rel="stylesheet" type="text/css" href="../css/textext.plugin.autocomplete.css">

    <?php require_once("includes/meta-link-script.php"); ?>
</head>

<body>

<!-- header start -->
<div class="header clearfix">
    <div style="float: left"><img src="../images/logo.png"/></div>
    <div class="menuLinks">
        <?php require_once("includes/menuNav.php"); ?>
    </div>
</div>

<!-- content body -->
<div class="contentMain">

<!--- <div class="contentLeft"> <?php //require_once("includes/menuLeftBar-Rollout.php"); ?> </div> -->

<div class="contentBody" style="margin-left:10%;"> 

<h1 style="text-align: center; margin-top: 0px">Roll out schedule</h1>

<?php

    //Call global $database variable for PDO
    global $database;

    $priv_email = $_SESSION['staff_email'];
    $database->query('SELECT priv_rap,priv_mt FROM staff where staff_email=:staff_email',
        array(
            ':staff_email' => $priv_email
        )
    );
    $prevs = $database->statement->fetch(PDO::FETCH_ASSOC);

    $priv_rap = $prevs['priv_rap'];
    $priv_mt = $prevs['priv_mt'];

    if($priv_rap<=0 && $priv_mt<=0){
        header("Location:../home.php");
    }

    //Get total number of Deworming Waves in the Database
    $database->query("SELECT * FROM deworming_waves");
    $count = $database->count();

    //Get requested page view and set default page view if not set
    if (isset($_GET['act'])) {
        $action = $_GET['act'];
    } else {
        $action = 'timeline';
    }

    //allwaves  - the view to view all deworming waves
    //addwave   - the view to add a new deworming wave
    //editwave  - guess, just guess what this is for...
    //delwave   - the view to delete a deworming wave

    if ($action == 'allwaves') { ?>
        <div class="row">
            <a href="index.php?act=timeline" class="btn btn-primary btn-lg">Timeline Calendar</a>
 
            <div class="col-md-11">
                <?php if ($count != 0) { ?>
                    <div class="clearfix">
                        <h2 class="pull-left">Deworming Waves</h2>
                        <?php 
                        if($priv_rap>=2){ ?>
                            <h2 class="pull-right" ><a href="?act=addwave" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Deworming Wave</a></h2>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="data-table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>County</th>
                                <th>sub county</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            <?php  if($priv_rap>=4){?>
                                <th>&nbsp;</th>
                            <?php } ?>
                            <?php  if($priv_rap>=3){?>
                                <th>&nbsp;</th>
                            <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                            foreach ($results as $result) { 
                                $database->query('SELECT DISTINCT activity_venu FROM rollout_activity WHERE wave_id = :wave_id',
                                    array(
                                        ':wave_id' => $result['id']
                                    )
                                );
                                $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                ?>
                                <tr>
                                    <td><?php echo $result['deworming_wave']; ?></td>
                                    <td><?php echo $result['county']; ?></td>
                                    <td><?php if (!empty($districts)) foreach($districts as $key => $value) {echo $value['activity_venu'].", ";} else { echo '<p class="text-muted"><small><em>No Districts Selected</em></small></p>';} ?></td>
                                    <td align="center"><a href="?act=timeline&amp;waveid=<?php echo $result['id']; ?>" alt="Timeline Calendar"  title="Timeline Calendar"><span class="glyphicon glyphicon-list-alt"></span> Timeline Calendar</a></td> 
                                    <td align="center"><a href="?act=activity&amp;waveid=<?php echo $result['id']; ?>" alt="Activities Planner"tile="Activities Planner"><span class="glyphicon glyphicon-tasks"></span> Activities Planner</a></td>
                                    <td align="center"><a href="?act=trainers&amp;waveid=<?php echo $result['id']; ?>" alt="Master Trainer Assignment"title="Master Trainer Assignment"><span class="glyphicon glyphicon-user"></span> Master Trainers</a></td> 
                                   <?php 
                                if($priv_rap>=4){?>
                                    <td align="center"><a href="?act=delwave&amp;waveid=<?php echo $result['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>
                            <?php }
                                if($priv_rap>=3){ ?>
                                    <td align="center"><a href="?act=editwave&amp;waveid=<?php echo $result['id']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <?php } ?>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>

                    <p class="text-center">There are currently <?php echo $count; ?> waves, <a href="?act=addwave"class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add New Deworming Wave</a></p> <?php } ?>
           
            </div>
        </div>
    <?php } else if ($action == 'addwave') {
        if (isset($_POST['add_wave'])) {

            $action = 'addwave';

            include('includes/gump.class.php');
            $gump = new GUMP();

            $gump->validation_rules(array(
                'deworming_wave_title' => 'required'
            ));

            $validated_data = $gump->run($_POST);

            if ( $validated_data === false || empty($_POST['cty']) || !$_POST['cty'] ) {
               //$msg = $gump->get_readable_errors(true);
               $msg = '<span class="error-message">You Must Enter Wave Title AND Select Counties to participate in this Deworming Wave</span>';
            } else {

                // Enter Action Log
                quickFuncLog(
                    $ArrayData = array(
                      0 => 3,
                      1 => 'Added deworming wave',
                      2 => 'Added '.$_POST['deworming_wave_title'].' deworming wave'
                    )
                );

                $rollOut->addWave($validated_data);
                header("Location:index.php?act=allwaves");
            }

        } ?>
        <div class="row">
            <div class="col-md-7 col-md-offset-2">

                <div class="bg-info dialog-container">                    

                    <h3>Add New Deworming Wave</h3>

                    <?php if ( isset($msg) ) { echo $msg; } ?>

                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>Deworming Wave Title:</label>
                                    <input class="form-control input_select" type="text" name="deworming_wave_title"
                                        <?php
                                            if (isset($_POST['wave_title'])) {
                                                echo 'value="' . $_POST['wave_title'] . '"';
                                            }
                                        ?>
                                    />   
                                </div>                             
                            </div>
                        <!--<div class="col-md-5">  
                                <div class="form-group">                              
                                    <label>County:</label>
                                    <select onchange="get_deworming_districts(this.value);" id="selectcounty" name="selectcounty" class="form-control">
                                    <select id="selectcounty" name="county" class="form-control"> 
                                        <option value="">Select County</option>
                                        <?php
                                            /*$database->query("SELECT county FROM counties");
                                            $insertformdata = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                            foreach ($insertformdata as $insertformdatacab) { ?>
                                                <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option> 
                                        <?php }*/ ?>
                                    </select>                                
                                </div>
                            </div>-->
                        </div>
                        <div class="form-group">
                            <label>Deworming Wave Counties:</label>
                            <p class="text-muted"><small><em>Select Counties to participate in this Deworming Wave</em></small></p>
                        </div>
                        <div class="form-group">
                            <div id="deworming_districts">
                                <ul class="row list-unstyled">
                                <?php

                                    global $database;
                                    $database->query("SELECT DISTINCT county FROM counties");
                                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                    foreach ($results as $key => $value) { ?>

                                        <li class="col-md-3">
                                            <div class="checkbox">
                                              <label>
                                                <input type="checkbox" value="<?php echo $value['county']; ?>" name="cty[]"><?php echo $value['county']; ?>
                                              </label>
                                            </div>
                                        </li>

                                    <?php }

                                ?>
                                <ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="add_wave">Save</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>        
    <?php } else if ($action == 'editwave') {
        global $database;
        $database->query("SELECT * FROM deworming_waves WHERE id = :id",
            array(
                ':id' => $_GET['waveid']
            )
        );
        $results = $database->statement->fetch(PDO::FETCH_ASSOC);

        if (isset($_POST['edit_wave'])) {
            $action = 'addwave';

            include('includes/gump.class.php');
            $gump = new GUMP();
            //$_POST = $gump->sanitize($_POST);

            $gump->validation_rules(array(
                'deworming_wave_title' => 'required'
            ));

            $validated_data = $gump->run($_POST);

            if ( $validated_data === false || empty($_POST['cty']) || !$_POST['cty'] ) {
               $msg = '<span class="error-message">You Must Enter Wave Title AND Select Counties to participate in this Deworming Wave</span>';
            } else {

                // Enter Action Log
                quickFuncLog(
                    $ArrayData = array(
                      0 => 3,
                      1 => 'Edited deworming wave',
                      2 => 'edited '.$_POST['deworming_wave_title'].' deworming wave'
                    )
                );
                $rollOut->editWave($validated_data);
            }

        } ?>

        <div class="row">
            <div class="col-md-7 col-md-offset-2">

                <div class="dialog-container">                    

                    <h3>Edit This Deworming Wave</h3>

                    <?php if ( isset($msg) ) { echo $msg; } ?>

                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label>Deworming Wave Title:</label>
                                    <input class="form-control input_select" type="text" name="deworming_wave_title"
                                        <?php echo 'value="' . $results['deworming_wave'] . '"'; ?>
                                    />   
                                </div>                             
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deworming Wave Counties:</label>
                            <p class="text-muted"><small><em>Edit Counties to participate in this Deworming Wave</em></small></p>
                        </div>
                        <div class="form-group">
                            <div id="deworming_districts">
                                <ul class="row list-unstyled">
                                    <?php

                                        $counties = explode(',', $results['county'] );

                                        foreach ($counties as $key => $value) { ?>

                                            <li class="col-md-3">
                                                <div class="checkbox">
                                                  <label>
                                                    <input type="checkbox" value="<?php echo $value; ?>" name="cty[]" checked><?php echo $value; ?>
                                                  </label>
                                                </div>
                                            </li>

                                        <?php }

                                        $countArray = implode("','", $counties);

                                        $database->query("SELECT DISTINCT county FROM counties WHERE county NOT IN('$countArray')");
                                        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                        foreach ($results as $key => $value) { ?>

                                            <li class="col-md-3">
                                                <div class="checkbox">
                                                  <label>
                                                    <input type="checkbox" value="<?php echo $value['county']; ?>" name="cty[]"><?php echo $value['county']; ?>
                                                  </label>
                                                </div>
                                            </li>

                                    <?php } ?>
                                <ul>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="edit_wave">Save</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    <?php } else if ($action == 'delwave') {
        if (isset($_REQUEST['waveid'])) {

            $database->query("SELECT * FROM deworming_waves WHERE id =  " . $_REQUEST['waveid'] . "");
            $result = $database->statement->fetch(PDO::FETCH_ASSOC);

            if (isset($_REQUEST['confirm'])) {

                $confirmed = $_REQUEST['confirm'];

                if ($confirmed == 1) {

                    // Enter Action Log
                    quickFuncLog(
                        $ArrayData = array(
                          0 => 3,
                          1 => 'Deleted deworming wave',
                          2 => 'Deleted '.$result['deworming_wave'].' deworming wave'
                        )
                    );

                    $rollOut->removeWave($_REQUEST['waveid']);
                }
            } else { ?>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        <div class="bg-warning text-center">
                            <br>

                            <p>You are about to Delete <code><?php echo $result['deworming_wave']; ?></code></p>

                            <div class="clearfix" style="width:30%;margin:auto;">

                                <p class="pull-left"><a href="?act=allwaves" class="btn btn-default">Cancel</a></p>

                                <p class="pull-right"><a
                                        href="?act=delwave&amp;waveid=<?php echo $result['id']; ?>&amp;confirm=1"
                                        class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                                </p>

                            </div>
                            <br>
                        </div>

                    </div>
                </div>

            <?php }

        } else {

            header("Location: index.php");

        }
    } else if ($action == 'activity') {

        if (isset($_REQUEST['waveid'])) {

            $database->query("SELECT * FROM deworming_waves WHERE id =  " . $_REQUEST['waveid'] . "");
            $wave_result = $database->statement->fetch(PDO::FETCH_ASSOC);

            if (isset($_REQUEST['add_rollout_activity'])) {

                if (isset($_POST['counties'])) {
                    $data = array();
                    foreach ($_POST['activity_type_id'] as $key => $value) {
                       $data[$key]['activity_type_id'] =  $_POST['activity_type_id'][$key];
                       $data[$key]['activity_start'] =  $_POST['activity_start'][$key];
                       $data[$key]['activity_end'] =  $_POST['activity_end'][$key];
                    }

                    // Enter Action Log
                    quickFuncLog(
                        $ArrayData = array(
                          0 => 3,
                          1 => 'Added rollout activity',
                          2 => 'Added rollout activity to '.$_POST['counties'].''
                        )
                    );

                    $rollOut->addcountyActivity($data,$_POST['counties'],$_GET['waveid']); 
                } else {
                    $msg = array('type' => 0, 'txt' => 'Please Select Counties To Set Events Dates');
                }

            }

            if (isset($_REQUEST['bulk_district_dates'])) {

                if (isset($_POST['districts'])) {
                    $data = array();
                    foreach ($_POST['activity_type_id'] as $key => $value) {
                        $data[$key]['activity_type_id'] = $_POST['activity_type_id'][$key];
                        $data[$key]['activity_start'] = $_POST['activity_start'][$key];
                        $data[$key]['activity_end'] = $_POST['activity_end'][$key];
                    }

                    // Enter Action Log
                    quickFuncLog(
                        $ArrayData = array(
                          0 => 3,
                          1 => 'Added sub counties to deworming wave',
                          2 => 'dded sub counties to deworming wave'
                        )
                    );

                    $rollOut->bulkAddDistricts($data,$_POST['districts'],$_GET['waveid']);                    
                } else {
                    $msg = array('type' => 0, 'txt' => 'Please Select Sub-Counties To Set Events Dates');
                }

            }

        ?>

        <div class="row">

            <div class="col-md-11">

                <a href="index.php?act=allwaves" class="btn btn-primary">Back To Deworming waves</a>
                <h3>Deworming Wave: <?php echo $wave_result['deworming_wave']; ?></h3>
                <div id="messageBox"><?php if (isset($msg)) {echo '<p class="error-message">'.$msg['txt'].'</p>'; } ?></p></div>
                <hr>

                <ul id="myTab" class="nav nav-tabs">
                  <li class="active"><a href="#tab-1" data-toggle="tab">County Activities</a></li>
                  <li><a href="#tab-2" data-toggle="tab">Sub-County Activities</a></li>
                </ul>

                <div id="myTabContent" class="tab-content">

                    <div class="tab-pane fade in active" id="tab-1">

                        <h5>County Activities</h5>

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                            <div id="add-rollout-activity-table" class="table-responsive rollout-activity">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <!--<th>County</th> 
                                            <th>District</th>-->
                                            <?php
                                                $database->query("SELECT activity_type_id,activity_type FROM rollout_activitytype ORDER BY activity_type_id ASC");
                                                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                                foreach ($results as $result) {
                                                    echo '<th>' . $result['activity_type'] . '</th>';
                                                }  
                                            ?>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php 
                                                foreach ($results as $result) {
                                                    echo  '<td class="datepicker_input">
                                                            <input type="hidden" name="activity_type_id[]" value="' . $result['activity_type_id'] . '" />
                                                            <input name="activity_start[]" id="activity_' . $result['activity_type_id'] . '_start" type="text" placeholder="Start Date"/>
                                                            <input name="activity_end[]" id="activity_' . $result['activity_type_id'] . '_end" type="text" placeholder="End Date"/>
                                                          </td>';
                                                }
                                                unset($results);
                                            ?>
                                            <td>
                                                <input type="text" value="<?php echo $_REQUEST['waveid'] ?>" name="wave_id" hidden/>
                                                <button type="submit" class='btn btn-primary' name="add_rollout_activity"><span class="glyphicon glyphicon-floppy-disk"></span></button> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive rollout-activity">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>County</th>
                                            <th>County Meetings</th>
                                            <?php
                                                $database->query("SELECT activity_type_id,activity_type FROM rollout_activitytype WHERE activity_type_id != 1 ORDER BY activity_type_id ASC");
                                                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                                foreach ($results as $result) {
                                                    echo '<th>' . $result['activity_type'] . '</th>';
                                                }  
                                            ?>
                                            <th>&nbsp;</th>
                                            <th><input type="checkbox" name="selectAllCounty" id="selectAllCounty" /></th>
                                        </tr>
                                    </thead>    
                                    <tbody>
                                        <?php
                                            $counties = explode(',', $wave_result['county']);
                                            foreach ($counties as $key => $value) { ?>
                                                <tr>
                                                    <td><?php echo $value; ?></td> 
                                                    <?php
                                                        $database->query('SELECT * FROM rollout_activity WHERE wave_id = :wave_id AND actyvity_county = :actyvity_county GROUP BY actyvity_county',
                                                            array(
                                                                ':wave_id' => $_REQUEST['waveid'],
                                                                ':actyvity_county' => $value
                                                            )
                                                        );
                                                        $results = $database->statement->fetch(PDO::FETCH_ASSOC);
                                                    ?>
                                                    <!-- <td class="datepicker_input">
                                                        <input type="hidden" name="county[]" value="<?php //echo $value; ?>">
                                                        <input name="activity_1_start[]" id="activity_start<?php //echo $key+1; ?>" type="text" placeholder="Start Date" class="date" <?php //if(!empty($results['start_date'])) { ?> value="<?php //echo date('d-m-Y',$results['start_date']); ?>" <?php //} ?> />
                                                        <input name="activity_1_end[]" id="activity_end<?php //echo $key+1; ?>" type="text" placeholder="End Date" class="date" <?php // if(!empty($results['end_date'])) { ?> value="<?php //echo date('d-m-Y',$results['end_date']); ?>" <?php // } ?> />
                                                    </td> -->
                                                    <?php
                                                        $database->query("SELECT actyvity_county,activity_type,start_date,end_date FROM rollout_activity WHERE activity_venu = :activity_venu AND wave_id = :wave_id ORDER BY activity_type ASC", 
                                                            array(
                                                                ':activity_venu' => $results["activity_venu"],
                                                                ':wave_id' => $_REQUEST['waveid']
                                                            )
                                                        );
                                                        $acivityDates = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                                        foreach ($acivityDates as $acivityDate) {

                                                            if (!isset($acivityDate['start_date']) || empty($acivityDate['start_date']) ||  $acivityDate['start_date'] == 0 || $acivityDate['start_date'] == NULL ) {
                                                                echo '<td><small><em>Activity Dates Not Set</em></small></td>';
                                                            } else {
                                                                $start_date = date('d-m-Y', $acivityDate['start_date']);
                                                                if (isset($acivityDate['end_date'])) {
                                                                    $end_date = date('d-m-Y', $acivityDate['end_date']);
                                                                } else {
                                                                    $end_date = $start_date;
                                                                }
                                                                echo '<td><p>' . $start_date . '</p><p>' . $end_date . '</p></td>';
                                                            }
                                                        }
                                                    ?>
                                                    <td class="activity-status">
                                                        <?php
                                                            foreach ($acivityDates as $key => $value) {
                                                                ${'activity_'.$value['activity_type'].'_start'} = $value['start_date'];
                                                                ${'activity_'.$value['activity_type'].'_end'} = $value['end_date'];
                                                            }

                                                            $status = 3;
                                                            if ( !empty($activity_1_end) && !empty($activity_2_start) ) {

                                                                $diff = abs($activity_1_end - $activity_2_start);
                                                                if ( $diff > 604800 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_2_end) && !empty($activity_3_start) && $status != 2 ) {

                                                                $diff = abs($activity_2_end - $activity_3_start);
                                                                if ( $diff > 1209600 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_4_end) && !empty($activity_5_start) && $status != 2 ) {

                                                                $diff = abs($activity_4_end - $activity_5_start);
                                                                if ( $diff > 1209600 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_5_end) && !empty($activity_6_start) && $status != 2 ) {

                                                                $diff = abs($activity_4_end - $activity_5_start);
                                                                if ( $diff < 604800 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            }

                                                            if ( $status == 1 ) {
                                                                echo '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" data-placement="top" title="Everything is OK"></span>';
                                                            } else if ( $status == 2 ) {
                                                                echo '<span class="glyphicon glyphicon-exclamation-sign" data-toggle="tooltip" data-placement="top" title="Event Constraint Violations"></span>';
                                                            } else if ( $status == 3 ) {
                                                                echo '<span class="glyphicon glyphicon-minus-sign" data-toggle="tooltip" data-placement="top" title="Activity Not set"></span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php // if( $priv_rap >=2 ) { ?>
                                                    <!-- <td>
                                                        <a href="?act=editactivity&amp;wave=<?php //echo $result['wave_id']; ?>&amp;loc=<?php//echo urlencode($result['actyvity_county']); ?>"class='btn btn-default'><span class="glyphicon glyphicon-pencil"></span></a> 
                                                    </td> -->
                                                    <?php // } ?>
                                                    <td class="countycheck" >
                                                        <input type="checkbox" value="<?php print $value['actyvity_county']; ?>" name="counties[]">
                                                    </td> 
                                                </tr>
                                        <?php } ?>
                                        <?php // if( $priv_rap >=2 ) { ?>
                                            <!-- <tr>
                                                <td></td>
                                                <td><button type="submit" name="save_county_planning" class="btn btn-primary">Save</button></td>
                                                <td colspan="6" ></td>
                                            </tr> -->
                                        <?php // } ?>
                                        <?php unset($results); ?>                                        
                                    </tbody>          
                                </table>
                            </div>
                        </form>

                        <script type="text/JavaScript" >
                            $('#selectAllCounty').click (function () {
                                var checkedStatus = this.checked;
                                $('td.countycheck :checkbox').each(function () {
                                    $(this).prop('checked', checkedStatus);
                                });
                            });
                        </script>

                    </div>

                    <div class="tab-pane fade" id="tab-2">

                        <h5>Sub-County Activities</h5>
                        <form method="post" action="<?php echo basename( $_SERVER['REQUEST_URI'] ) ?>">
                            <div id="add-rollout-activity-table" class="table-responsive rollout-activity">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <!--<th>County</th> 
                                            <th>District</th>-->
                                            <?php
                                                $database->query("SELECT activity_type_id,activity_type FROM rollout_activitytype WHERE activity_type_id NOT IN('1','2','3') ORDER BY activity_type_id ASC");
                                                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                                foreach ($results as $result) {
                                                    echo '<th>' . $result['activity_type'] . '</th>';
                                                }  
                                            ?>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <?php 
                                                foreach ($results as $result) {
                                                    echo  '
                                                            <td class="datepicker_input">
                                                                <input type="hidden" name="activity_type_id[]" value="' . $result['activity_type_id'] . '" />
                                                                <input name="activity_start[]" id="activity_' . $result['activity_type_id'] . '_start2" type="text" placeholder="Start Date" class="date" />
                                                                &nbsp;-&nbsp;
                                                                <input name="activity_end[]" id="activity_' . $result['activity_type_id'] . '_end2" type="text" placeholder="End Date" class="date" />
                                                            </td>
                                                        ';
                                                }
                                                unset($results);
                                            ?>
                                            <td>                                                
                                                <input type="hidden" value="<?php echo $_REQUEST['waveid'] ?>" name="wave_id" />
                                                <button type="submit" class='btn btn-primary' name="bulk_district_dates"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            <div class="table-responsive rollout-activity">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>County</th>
                                            <th>Sub County</th>
                                            <?php
                                                $database->query("SELECT activity_type FROM rollout_activitytype WHERE activity_type_id NOT IN('1','2','3') ORDER BY activity_type_id ASC");
                                                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                                foreach ($results as $result) {
                                                    echo '<th>' . $result['activity_type'] . '</th>';
                                            }
                                            if ($priv_rap >= 2 ) { ?>
                                            <?php } ?>
                                            <td>&nbsp;</td>
                                            <th>&nbsp;</th>
                                            <td><input type="checkbox" name="selectAllDistrict" id="selectAllDistrict" /></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $database->query("SELECT * FROM rollout_activity WHERE wave_id = " . $_REQUEST['waveid'] . " GROUP BY activity_venu");
                                            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                            $i=1; foreach ($results as $result) { ?>
                                                <tr>
                                                    <?php

                                                        $database->query("SELECT actyvity_county,activity_type,start_date,end_date FROM rollout_activity WHERE activity_type NOT IN('1','2','3') AND  activity_venu = :activity_venu AND wave_id = :wave_id ORDER BY activity_type ASC", 
                                                            array(
                                                                ':activity_venu' => $result["activity_venu"],
                                                                ':wave_id' => $_REQUEST['waveid']
                                                            )
                                                        );
                                                        $acivityDates = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                                        echo '<td>' . $result['actyvity_county'] . '</td>';
                                                        echo '<td>' . $result['activity_venu'] . '</td>';

                                                        foreach ($acivityDates as $acivityDate) {

                                                            if (!isset($acivityDate['start_date']) || empty($acivityDate['start_date']) ||  $acivityDate['start_date'] == 0 || $acivityDate['start_date'] == NULL ) {
                                                                echo '<td><small><em>Activity Dates Not Set</em></small></td>';
                                                            } else {
                                                                $start_date = date('d-m-Y', $acivityDate['start_date']);
                                                                if (isset($acivityDate['end_date'])) {
                                                                    $end_date = date('d-m-Y', $acivityDate['end_date']);
                                                                } else {
                                                                    $end_date = $start_date;
                                                                }
                                                                echo '<td><p>' . $start_date . '</p><p>' . $end_date . '</p></td>';
                                                            }
                                                        }
                                                    ?>
                                                    <td class="activity-status">
                                                        <?php
                                                            foreach ($acivityDates as $key => $value) {
                                                                ${'activity_'.$value['activity_type'].'_start'} = $value['start_date'];
                                                                ${'activity_'.$value['activity_type'].'_end'} = $value['end_date'];
                                                            }

                                                            $status = 3;
                                                            if ( !empty($activity_1_end) && !empty($activity_2_start) ) {

                                                                $diff = abs($activity_1_end - $activity_2_start);
                                                                if ( $diff > 604800 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_2_end) && !empty($activity_3_start) && $status != 2 ) {

                                                                $diff = abs($activity_2_end - $activity_3_start);
                                                                if ( $diff > 1209600 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_4_end) && !empty($activity_5_start) && $status != 2 ) {

                                                                $diff = abs($activity_4_end - $activity_5_start);
                                                                if ( $diff > 1209600 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            } if ( !empty($activity_5_end) && !empty($activity_6_start) && $status != 2 ) {

                                                                $diff = abs($activity_4_end - $activity_5_start);
                                                                if ( $diff < 604800 ) {
                                                                    $status = 2;
                                                                } else {                                                    
                                                                    $status = 1;
                                                                }

                                                            }

                                                            if ( $status == 1 ) {
                                                                echo '<span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" data-placement="top" title="Everything is OK"></span>';
                                                            } else if ( $status == 2 ) {
                                                                echo '<span class="glyphicon glyphicon-exclamation-sign" data-toggle="tooltip" data-placement="top" title="Event Constraint Violations"></span>';
                                                            } else if ( $status == 3 ) {
                                                                echo '<span class="glyphicon glyphicon-minus-sign" data-toggle="tooltip" data-placement="top" title="Activity Not set"></span>';
                                                            }
                                                        ?>
                                                    </td>
                                                    <?php if( $priv_rap >=2 ) { ?>
                                                        <td>
                                                            <a href="?act=editactivity&amp;wave=<?php echo $result['wave_id']; ?>&amp;loc=<?php echo urlencode($result['activity_venu']); ?>"class='btn btn-default'><span class="glyphicon glyphicon-pencil"></span></a> 
                                                        </td>
                                                    <?php } ?>
                                                    <td class="districtselect" >
                                                        <input type="checkbox" value="<?php echo $result['activity_venu']; ?>" name="districts[]">
                                                    </td> 
                                                </tr>
                                        <?php $i++;} ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <script type="text/JavaScript" >
                            $('#selectAllDistrict').click (function () {
                                var checkedStatus = this.checked;
                                $('td.districtselect :checkbox').each(function () {
                                    $(this).prop('checked', checkedStatus);
                                });
                            });
                        </script>

                    </div>

                </div>

            </div>

        </div>

        <?php }
    } else if ($action == 'timeline') {?>
        <a href="index.php?act=allwaves" class="btn btn-primary">Deworming waves</a>
        <br>        
        <div class="row">
            
            <div class="col-md-11">
                <?php

                    if (isset($_REQUEST['waveid'])) { 

                        $database->query('SELECT * FROM deworming_waves WHERE id = :id',
                            array(
                                ':id' => $_REQUEST['waveid']
                            )
                        );

                    } else { 

                        $database->query("SELECT * FROM deworming_waves");

                    }
                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

                    <div id="activity-color-key-container" class-"clearfix">
                        <p class="pull-left" ><strong>Activity Color Key:</strong>&nbsp;</p>
                        <ul class="list-unstyled list-inline pull-left" id="activity-color-key">
                            <li><span class="key-box activity-type-1"></span> - County Meetings</li>
                            <li><span class="key-box activity-type-2"></span> - Stakeholders Meeting</li>
                            <li><span class="key-box activity-type-3"></span> - 1st Sub-County Committee</li>
                            <li><span class="key-box activity-type-4"></span> - Sub-County Training</li>
                            <li><span class="key-box activity-type-5"></span> - 2nd Sub-County Committee</li>
                            <li><span class="key-box activity-type-6"></span> - CHEW Forum</li>
                            <li><span class="key-box activity-type-7"></span> - Teacher Training</li>
                            <li><span class="key-box activity-type-8"></span> - 3rd Sub-County Committee</li>
                            <li><span class="key-box activity-type-9"></span> - Deworming Day</li>
                            <li><span class="key-box activity-type-10"></span> - 4th Sub-County Committee</li>
                        </ul>
                    </div>

                    <br>

                    <div id="filter-container">

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                            <div class="form-group">

                                <div class="row">

                                    <div class="col-md-2">
                                        <label>Filter Sub County<p class="text-muted"><small><em>Type In sub county to Filter</em></small></p></label>
                                    </div>

                                    <div class="col-md-7">
                                        
                                        <textarea id="filter-districts" name="filter-districts" class="form-control"></textarea>

                                    </div>

                                    <div class="col-md-2">
                                        
                                        <button type="submit" name="btn-filter-districts" class="btn btn-lg btn-primary"><span class="glyphicon glyphicon-filter" ></span> Filter</button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                    <!-- <div class="clearfix">
                        <div class="btn-group">
                            <a href="index.php?cview=1" class="btn btn-small" <?php // if(  $_REQUEST['cview'] == 1 ) { echo 'disabled'; } ?> >Days</a>
                            <a href="index.php?cview=2" class="btn btn-small" <?php // if(  $_REQUEST['cview'] == 2 ) { echo 'disabled'; } ?> >Weeks</a>
                            <a href="index.php?cview=3" class="btn btn-small" <?php // if(  $_REQUEST['cview'] == 3 ) { echo 'disabled'; } ?> >Months</a>
                        </div>
                    </div> -->
                    <div id="activity-calendar-container"> 

                        <table id="activity-calendar-header" class="activity-calendar table">
                            <tr>
                                <?php if (!isset($_GET['waveid'])) { ?>
                                    <td class="wave_title"><span class="spacer"></span></td>
                                <?php } ?>
                                    <td class="head-col"></td>
                                <?php

                                    if ( isset( $_REQUEST['cview']) ) {
                                        $cview = $_REQUEST['cview'];                                        
                                    } else {
                                        $cview = 1;   
                                    }

                                    $database->query("SELECT MIN(start_date), MAX(end_date) FROM rollout_activity");
                                    $range = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                    $start_month = explode('-', date('m-d-Y', $range[0]['MIN(start_date)']))[0];
                                    $start_year = explode('-', date('m-d-Y', $range[0]['MIN(start_date)']))[2];

                                    if (isset($range[0]['MAX(end_date)'])) {
                                        $end_month = explode('-', date('m-d-Y', $range[0]['MAX(end_date)']))[0];
                                        $end_year = explode('-', date('m-d-Y', $range[0]['MAX(end_date)']))[2];
                                    } else {
                                        $end_month = $start_month;
                                        $end_year = $start_year;
                                    }

                                    if ($end_month < $start_month) {
                                        $end_month = 12;
                                    }

                                    $j = $start_year; $i = $start_month;
                                    while ($i <= $end_month && $j <= $end_year) {
                                        echo $rollOut->build_calendar($month = $i, $year = $j, $dateArray = NULL, $header = 1, $waveData = NULL, $cView = $cview );
                                        $start_month = $start_month + 1;
                                        if ($i == $end_month) {
                                            $i = 0; $j++; 
                                        }
                                        $i++;
                                    }
                                ?>
                            </tr>
                        </table>

                        <?php 
                            if(isset($_POST['btn-filter-districts'])) { 
                                $districtFilterArray = json_decode($_POST['filter-districts']);
                                $districtFilterArray = join("', '", $districtFilterArray);
                            }
                        ?>


                        <?php foreach ($results as $key => $value) { ?>

                            <table class="activity-calendar activity-calendar-days table table-hover">

                                <?php

                                    if (isset($districtFilterArray) && !empty($districtFilterArray)) {

                                        $database->query("SELECT DISTINCT activity_venu,wave_id FROM rollout_activity WHERE activity_venu IN ('$districtFilterArray') AND wave_id =" . $value['id'] . "  ");
                                    
                                    } else {

                                        $database->query("SELECT DISTINCT activity_venu,wave_id FROM rollout_activity WHERE wave_id =" . $value['id'] . "");
                                    
                                    }

                                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                    $count = $database->count(); 

                                    if ( $count > 0 ) {

                                        $rows = count($results);$i=1;
                                        foreach ($results as $result) { ?>

                                            <tr>

                                                <?php if ($i==1) {
                                                	if (!isset($_GET['waveid'])) { ?>

	                                                <td class="wave_title" rowspan="<?php echo $rows; ?>"><a href="index.php?act=activity&amp;waveid=<?php echo $value['id']; ?>"><?php echo $value['deworming_wave']; ?></a></td>

	                                                <?php }
	                                            } ?>

                                                <td class="head-col"><span><?php echo $result['activity_venu']; ?></span></td>

                                                <?php

                                                    $database->query("SELECT start_date,end_date,activity_type,wave_id FROM rollout_activity WHERE activity_venu = :activity_venu AND wave_id= :wave_id", array(
                                                            ':activity_venu' => $result['activity_venu'],
                                                            ':wave_id' => $result['wave_id']
                                                        )
                                                    );
                                                    $activityData = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                                    //$dateArray = array();
                                                    foreach ($activityData as $key => $value) {

                                                        if ($value['start_date'] != NULL) {
                                                            $start_date = $value['start_date'];
                                                            if ($value['end_date'] == NULL) {
                                                                $end_date = $start_date;
                                                            } else {
                                                                $end_date = $value['end_date'];
                                                            }

                                                            if ($start_date == $end_date) {

                                                            //array_push($dateArray, date('d-m-Y', $start_date));
                                                            $dateArray[] = array(
                                                                'date' => date('d-m-Y', $start_date),
                                                                'activity' => $value['activity_type']
                                                            );
                                                            } else if ($end_date > $start_date) {

                                                                $numDays = ($end_date - $start_date) / 86400;

                                                                while ($start_date <= $end_date) {
                                                                    //array_push($dateArray, date('d-m-Y', $start_date));
                                                                    $dateArray[] = array(
                                                                        'date' => date('d-m-Y', $start_date),
                                                                        'activity' => $value['activity_type']
                                                                    );
                                                                    $start_date = $start_date + 86400;
                                                                }
                                                            }
                                                        }
                                                    }

                                                    $start_month = explode('-', date('m-d-Y', $range[0]['MIN(start_date)']))[0];

                                                    $waveData = array('wave'=> $result['wave_id'],'loc'=>$result['activity_venu']);

                                                    if (!empty($dateArray)) {
                                                        $j = $start_year; $i = $start_month;
                                                        while ($i <= $end_month && $j <= $end_year) {
                                                            echo $rollOut->build_calendar($month = $i, $year = $j, $dateArray = $dateArray, $header = 0, $waveData = $waveData, $cView = $cview );
                                                            $start_month = $start_month + 1;
                                                            if ($i == $end_month) {
                                                                $i = 0;
                                                                $j++;
                                                            }
                                                            $i++;
                                                        }
                                                        unset($dateArray);                                                        
                                                    }


                                                ?>
                                            </tr>

                                        <?php $i++;} 

                                    } ?>

                            </table>

                        <?php } ?>

                    </div>

            </div>

        </div>
    <?php } else if ($action == 'editactivity') {
        if (isset($_REQUEST['save_activity'])) {

            include('includes/gump.class.php');
            $gump = new GUMP();
            $_POST = $gump->sanitize($_POST);

            $gump->validation_rules(array(
                'activity_3_start' => 'required'
            ));

            $validated_data = $gump->run($_POST);

            if ($validated_data === false) {
                $msg = array('type' => 0, 'txt' => $gump->get_readable_errors(true));
            } else {
                // Enter Action Log
                quickFuncLog(
                    $ArrayData = array(
                      0 => 3,
                      1 => 'Edited deworming wave activity',
                      2 => 'Edited deworming wave activity'
                    )
                );
                $rollOut->editWaveActivity($_POST, $_REQUEST['wave']);
            }

        }

        if (isset($_REQUEST['wave']) && isset($_REQUEST['loc'])) {

            $database->query("SELECT activity_type_id,activity_type FROM rollout_activitytype ORDER BY activity_type_id ASC");
            $activityTypeArray = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $database->query("SELECT * FROM rollout_activity WHERE wave_id = :wave_id AND activity_venu = :activity_venu ORDER BY activity_type ASC", array(
                    ':wave_id' => $_REQUEST['wave'],
                    ':activity_venu' => urldecode($_REQUEST['loc'])
                )
            );
            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
        ?>
            <a href="index.php?act=activity&amp;waveid=<?php echo $_REQUEST['wave']; ?>" class="btn btn-primary" >Back To Activity Planner</a>

            <h3>Activities For <?php echo urldecode($_REQUEST['loc']); ?></h3>

            <div class="row">

                <div class="col-md-7">

                    <div id="edit-activity-container" class="clearfix">
                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                            <?php
                                $i = 0;
                                foreach ($results as $result) {  ?>
                                    <div class='form-group clearfix'>
                                        <label for='activity_<?php echo $result['activity_type']; ?>_start' class='col-md-4 control-label'><?php echo $activityTypeArray[$i]['activity_type']; ?></label>
                                        <div class='col-md-6'>
                                            <input 
                                                name='activity_<?php echo $result['activity_type']; ?>_start' 
                                                id='activity_<?php echo $result['activity_type']; ?>_start' 
                                                value='<?php if (!empty($result['start_date'])) echo date('d-m-Y', $result['start_date']); ?>' 
                                                type='text' 
                                                <?php if ( $result['activity_type'] == 1 || $result['activity_type'] == 2 || $result['activity_type'] == 3) { echo 'disabled'; } ?> 
                                            />
                                            &nbsp;-&nbsp;
                                            <input 
                                                name='activity_<?php echo $result['activity_type']; ?>_end' 
                                                id='activity_<?php echo $result['activity_type']; ?>_end' 
                                                value='<?php if (!empty($result['end_date'])) echo date('d-m-Y', $result['end_date']); ?>' 
                                                type='text'
                                                <?php if ( $result['activity_type'] == 1 || $result['activity_type'] == 2 || $result['activity_type'] == 3) { echo 'disabled'; } ?> 
                                            />
                                        </div>
                                    </div>
                                <?php $i++; }
                            
                            if($priv_rap>=2){ ?>                            
                                <div class='form-group'>
                                    <button type="submit" name="save_activity" class="btn btn-lg btn-primary btn-block">Save</button>
                                </div>
                            <?php }?>
                        </form>

                    </div>

                </div>

                <div class="col-md-4">

                    <div id="activity-constraints-container">

                        <h5>Activity Constraint Violations</h5>

                        <?php                                    

                            $database->query('SELECT activity_type,start_date,end_date FROM rollout_activity WHERE activity_venu = :activity_venu AND wave_id = :wave_id ORDER BY activity_type ASC', 
                                array(
                                    ':activity_venu' => urldecode($_REQUEST["loc"]),
                                    ':wave_id' => $_REQUEST['waveid']
                                )
                            );
                            $acivityDates = $database->statement->fetchall(PDO::FETCH_ASSOC);


                            foreach ($results as $key => $value) {
                                ${'activity_'.$value['activity_type'].'_start'} = $value['start_date'];
                                ${'activity_'.$value['activity_type'].'_end'} = $value['end_date'];
                            }
                            
                            $status = 3;
                            if ( !empty($activity_1_end) && !empty($activity_2_start) ) {

                                $diff = abs($activity_1_end - $activity_2_start);
                                if ( $diff > 604800 ) {
                                    $status = 2;
                                    echo '<p class="bg-warning text-warning constraint"><span class="glyphicon glyphicon-exclamation-sign"></span> The period between end of County meetings and Stakeholder meeting should not be more than 1 week</p>';
                                } else if ( $status != 2 ) {                                                    
                                    $status = 1;
                                }

                            } if ( !empty($activity_2_end) && !empty($activity_3_start) ) {

                                $diff = abs($activity_2_end - $activity_3_start);
                                if ( $diff > 1209600 ) {
                                    $status = 2;
                                    echo '<p class="bg-warning text-warning constraint"><span class="glyphicon glyphicon-exclamation-sign"></span> The period between end of Stakeholder meetings and CSHCC should not be more than 2 weeks</p>';
                                } else if ( $status != 2 ) {                                                    
                                    $status = 1;
                                }

                            } if ( !empty($activity_4_end) && !empty($activity_5_start) ) {

                                $diff = abs($activity_4_end - $activity_5_start);
                                if ( $diff > 1209600 ) {
                                    $status = 2;
                                    echo '<p class="bg-warning text-warning constraint"><span class="glyphicon glyphicon-exclamation-sign"></span> The period between end of District training and start of teacher training should not be more than 2 weeks</p>';
                                } else if ( $status != 2 ) {                                                    
                                    $status = 1;
                                }

                            } if ( !empty($activity_5_end) && !empty($activity_6_start) ) {

                                $diff = abs($activity_4_end - $activity_5_start);
                                if ( $diff < 604800 ) {
                                    $status = 2; 
                                    echo '<p class="bg-warning text-warning constraint"><span class="glyphicon glyphicon-exclamation-sign"></span> The period between end of Teacher training and Deworming day should not be less than 1 Week</p>';
                                } else if ( $status != 2 ) {                                                    
                                    $status = 1;
                                }

                            }

                            if ( $status == 1 || $status == 3 ) {

                                echo '<p class="bg-success text-success constraint"><span class="glyphicon glyphicon-ok-sign"></span>  There are no Activity Constraint Violations</p>';

                            }


                        ?>

                    </div>

                </div>

            </div>

        <?php } else {

            header("Location:index.php");

        }
    } else if ($action == 'delactivity') {
        if (isset($_REQUEST['wave']) && isset($_REQUEST['loc'])) {

            $database->query("SELECT * FROM deworming_waves WHERE id = " . $_REQUEST['wave'] . "");
            $result = $database->statement->fetch(PDO::FETCH_ASSOC);

            if (isset($_REQUEST['confirm'])) {

                $confirmed = $_REQUEST['confirm'];

                if ($confirmed == 1) {
                    // Enter Action Log
                    quickFuncLog(
                        $ArrayData = array(
                          0 => 3,
                          1 => 'Deleted deworming wave activity',
                          2 => 'Deleted deworming wave activity'
                        )
                    );

                    $rollOut->removeactivity($_REQUEST['wave'], $_REQUEST['loc']);
                }

            } else { ?>

                <div class="row">

                    <div class="col-md-6 col-md-offset-3">

                        <div class="bg-warning text-center">

                            <br>

                            <p>You are about to Delete activities for <code><?php echo urldecode($_REQUEST['loc']); ?></code></p>

                            <div class="clearfix" style="width:30%;margin:auto;">

                                <p class="pull-left"><a href="?act=allwaves" class="btn btn-default">Cancel</a></p>

                                <p class="pull-right"><a href="?act=delactivity&amp;wave=<?php echo $result['id']; ?>&amp;loc=<?php echo urldecode($_REQUEST['loc']); ?>&amp;confirm=1" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a> </p>

                            </div>

                            <br>

                        </div>

                    </div>

                </div>

            <?php }

        } else {

            header('Location:index.php');

        }
    } else if ($action == 'trainers') {?>
        <div class="clearfix">
            <a href="index.php?act=allwaves" class="btn btn-primary">Back to Deworming waves</a>
            <button class="btn btn-primary" id="btnExport"  onclick="tableToExcel('mt_table', 'Master Trainer Assignment')">Export Excel</button>
        </div>
        <br>
        <?php
            if ( isset($_REQUEST['waveid']) ) {

                $database->query("SELECT DISTINCT activity_venu FROM rollout_activity WHERE wave_id = :wave_id ORDER BY activity_venu",
                    array(
                        'wave_id' => $_REQUEST['waveid']
                    )
                );           
                $results = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>             

                    <table id="mt_table" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sub County</th>  
                                <th>Full Name</th>  
                                <th>Ministry</th> 
                                <th>Station</th> 
                                <th>County</th> 
                                <th>Phone Number</th>                                               
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                                foreach ($results as $key => $value) {

                                    $theDistrict = $value['activity_venu'];

                                    $database->query('SELECT * FROM rollout_master_trainers WHERE district = :district AND wave = :wave', array(
                                            ':district' => $value['activity_venu'],
                                            ':wave' => $_REQUEST['waveid']
                                        )
                                    );
                                    $count = $database->count();

                                    if ($count == 0) { ?>

                                        <tr>
                                            <?php if ($priv_mt>=2){ ?>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><?php echo $value["activity_venu"]; ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><em><small>Master Trainers Not Assigned</small></em></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><em><small>Master Trainers Not Assigned</small></em></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><em><small>Master Trainers Not Assigned</small></em></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><em><small>Master Trainers Not Assigned</small></em></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>"><em><small>Master Trainers Not Assigned</small></em></a></td>
                                            <?php } ?>
                                        </tr> 

                                    <?php } else {

                                        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                        foreach ($results as $key => $value) {

                                            $database->query('SELECT * FROM master_trainers WHERE mtid = :mtid', array(
                                                    ':mtid' => $value['mt_id']
                                                )
                                            );
                                            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);                        

                                            $database->query("SELECT leader FROM rollout_master_trainers WHERE mt_id = :mt_id AND wave = :wave AND district = :district", 
                                            array(
                                                ':mt_id' => $results[0]['mtid'],
                                                ':wave'=> $_REQUEST['waveid'],
                                                ':district'=> $theDistrict,
                                                )
                                            );
                                            $leader = $database->statement->fetch(PDO::FETCH_ASSOC); ?>

                                            <tr <?php if ($leader['leader'] == 1) { echo 'class="success"'; } ?>>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $theDistrict ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $results[0]['full_name'] ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $results[0]['ministry'] ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $results[0]['posting_station'] ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $results[0]['county'] ?></a></td>
                                                <td><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($theDistrict); ?>"><?php echo $results[0]['phone_number'] ?></a></td>
                                            </tr>
                                                
                                        <?php } 
                                    }

                                } ?>                                             
                        
                        </tbody>

                    </table>

            <?php } else {

                $database->query("SELECT 
                    DISTINCT rollout_activity.wave_id, 
                    rollout_activity.wave_id, 
                    deworming_waves.deworming_wave
                    FROM rollout_activity 
                    JOIN deworming_waves ON rollout_activity.wave_id = deworming_waves.id
                    ORDER BY deworming_waves.deworming_wave");
           
                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                foreach ($results as $key => $value1) {

                    echo '<h2>'.ucwords($value1['deworming_wave']).'</h2>';

                    $database->query("SELECT DISTINCT activity_venu FROM rollout_activity WHERE wave_id = :wave_id ORDER BY wave_id",
                        array(
                            'wave_id' => $value1['wave_id']
                        )
                    );
               
                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                    foreach ($results as $key => $value) {

                        $theDistrict = $value['activity_venu']; ?>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4"><h5> <?php echo $theDistrict; ?> </h5></th>
                                    <th><a href="?act=addtrainers&amp;waveid=<?php echo $value1['wave_id']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>" class="btn pull-right"><span class="glyphicon glyphicon-pencil"></span></a></th>
                                </tr>
                                <tr>
                                    <th>Full Name</th>  
                                    <th>Ministry</th> 
                                    <th>Station</th> 
                                    <th>County</th> 
                                    <th>Phone Number</th>                                               
                                </tr>
                            </thead>

                            <tbody>

                                <?php 

                                $database->query('SELECT * FROM rollout_master_trainers WHERE district = :district AND wave = :wave', array(
                                        ':district' => $value['activity_venu'],
                                        ':wave' => $value1['wave_id']
                                    )
                                );
                                $count = $database->count();

                                if ($count == 0) { ?>

                                    <tr>
                                        <td><?php echo $theDistrict; ?></td>
                                        <td colspan="3">No Master Trainers Assigned to <?php echo $value['activity_venu']; ?> yet. </td>
                                        <td colspan="1" ><a class="btn btn-primary"  href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urlencode($value["activity_venu"]); ?>">Assign Master Trainers</a></td>
                                    </tr>   

                                <?php } else {

                                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                    foreach ($results as $key => $value) {

                                        $database->query('SELECT * FROM master_trainers WHERE mtid = :mtid', array(
                                                ':mtid' => $value['mt_id']
                                            )
                                        );
                                        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);                                    

                                        $database->query("SELECT leader FROM rollout_master_trainers WHERE mt_id = :mt_id AND wave = :wave AND district = :district", 
                                        array(
                                            ':mt_id' => $results[0]['mtid'],
                                            ':wave'=> $value1['wave_id'],
                                            ':district'=> $theDistrict,
                                            )
                                        );
                                        $leader = $database->statement->fetch(PDO::FETCH_ASSOC); ?>

                                        <tr <?php if ($leader['leader'] == 1) { echo 'class="success"'; } ?>>
                                            <td><?php echo $results[0]['full_name'] ?></td>
                                            <td><?php echo $results[0]['ministry'] ?></td>
                                            <td><?php echo $results[0]['posting_station'] ?></td>
                                            <td><?php echo $results[0]['county'] ?></td>
                                            <td><?php echo $results[0]['phone_number'] ?></td>
                                        </tr>
                                            
                                    <?php }  

                                    } ?>    

                            </tbody>

                        </table>

                    <?php }



                 }
        }
    } else if ($action == 'addtrainers') { ?>
        <div id="add-trainers-container">

            <a href="index.php?act=trainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>" class="btn btn-primary">Back to All Master Trainers</a>

            <?php

                $database->query("SELECT start_date FROM rollout_activity WHERE wave_id = :wave_id AND activity_venu = :activity_venu AND activity_type = :activity_type", 
                    array(
                        ':wave_id'      => $_REQUEST['waveid'],
                        ':activity_venu'  => urldecode($_REQUEST['loc']),
                        ':activity_type' => 4
                    )
                );
                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                if ( !empty($results[0]['start_date']) || $results[0]['start_date'] != NULL ) {

                    if (isset($_REQUEST['trainersData'])) {
                        // Enter Action Log
                        quickFuncLog(
                            $ArrayData = array(
                              0 => 3,
                              1 => 'Added master trainers',
                              2 => 'Added master trainers'
                            )
                        );
                        $rollOut->addMasterTrainers(explode(",", $_REQUEST['trainersData'])); 
                    }
                    if (isset($_POST['submit_leader'])) {$rollOut->masterTrainersLeader($_POST['leader-radio']); }

                    $database->query("SELECT mt_id FROM rollout_master_trainers WHERE wave = :wave AND district = :district", 
                        array(
                            ':wave'      => $_REQUEST['waveid'],
                            ':district'  => urldecode($_REQUEST['loc'])
                        )
                    );
                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                    $count = $database->count();

                    $existingTrainers = array();

                    foreach ($results as $key => $value) {
                        array_push($existingTrainers, $value['mt_id']);
                    }

                    if ($count > 0 ) { ?>

                        <h3><?php echo $_REQUEST['loc']; ?> Master Trainers</h3>

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post" >
                            <table class="table table-responsive table-condensed table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Ministry</th>
                                        <th>Station</th>
                                        <th>County</th>
                                        <th>Phone Number</th>
                                        <!--<th>Status</th>-->
                                        <th>Team Leader</th>
                                        <th></th>
                                        <th class="mtid"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        foreach ($results as $key => $value) {

                                            $database->query("SELECT * FROM master_trainers WHERE mtid = :mtid", 
                                            array(
                                                ':mtid' => $value['mt_id']
                                                )
                                            );
                                            $mtData = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                            foreach ($mtData as $key => $value) {

                                                if (isset($value['phone_number'])) {
                                                    $phone = $value['phone_number'];
                                                } else {
                                                    if (isset($value['phone_number2'])) {
                                                        $phone = $value['phone_number2'];
                                                    } else {
                                                        $phone = '<p><small><em>No Phone Number</em></small></p>';
                                                    }
                                                }

                                                $database->query("SELECT leader FROM rollout_master_trainers WHERE mt_id = :mt_id AND wave = :wave", 
                                                array(
                                                    ':mt_id' => $value['mtid'],
                                                    ':wave'=> $_REQUEST['waveid']
                                                    )
                                                );
                                                $leader = $database->statement->fetch(PDO::FETCH_ASSOC); ?>       

                                                <tr>
                                                    <td><?php echo $value['full_name']; ?></td>
                                                    <td><?php echo $value['ministry']; ?></td>
                                                    <td><?php echo $value['posting_station']; ?></td>
                                                    <td><?php echo $value['county']; ?></td>
                                                    <td><?php echo $phone; ?></td>
                                                    <!--<td><?php //echo $value['status']; ?></td>-->
                                                    <td><input type="radio" name="leader-radio" id="radio-<?php echo $value['mtid']; ?>" value="<?php echo $value['mtid']; ?>" <?php if($leader['leader'] == 1){ echo 'checked';} ?> ></td>
                                                    <td><a href="?act=removetrainer&amp;mtid=<?php echo $value['mtid']; ?>&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo $_REQUEST['loc']; ?>" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></a></td>
                                                    <td class="mtid"><?php echo $value['mtid']; ?></td>
                                                </tr>

                                            <?php } 

                                         } ?>                       

                                            <tr>
                                                <td colspan="5"></td>
                                                <td><button type="submit" class="btn btn-default" name="submit_leader">Submit Leader</button></td>
                                                <td colspan="2"></td>
                                            </tr>
                               </tbody>
                            </table>             
                        </form>

                    <?php } ?>

                    <h3>Assign Master Trainers to <?php echo $_REQUEST['loc'] ?></h3>

                    <table class="table table-responsive table-condensed table-hover table-bordered select" id="data-table">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Ministry</th>
                                <th>Station</th>
                                <th>County</th>
                                <th>Phone Number</th>
                                <!--<th>Status</th>-->
                                <th class="mtid"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php

                                $database->query("SELECT * FROM master_trainers WHERE mtid NOT IN ('".implode("','",$existingTrainers)."')");
                                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                foreach ($results as $key => $value) {

                                    if (isset($value['phone_number'])) {
                                        $phone = $value['phone_number'];
                                    } else {
                                        if (isset($value['phone_number2'])) {
                                            $phone = $value['phone_number2'];
                                        } else {
                                            $phone = '<p><small><em>No Phone Number</em></small></p>';
                                        }
                                    } ?>

                                    <tr>
                                        <td><?php echo $value['full_name']; ?></td>
                                        <td><?php echo $value['ministry']; ?></td>
                                        <td><?php echo $value['posting_station']; ?></td>
                                        <td><?php echo $value['county']; ?></td>
                                        <td><?php echo $phone; ?></td>
                                        <!--<td><?php //echo $value['status']; ?></td>-->
                                        <td class="mtid"><?php echo $value['mtid']; ?></td>
                                    </tr>

                            <?php } ?>

                        </tbody>
                    </table>

                    <button id="assign_trainers" class="btn btn-primary btn-lg pull-right" onclick="fnGetSelected('#data-table')"> Assign Selected Trainers To <?php echo $_REQUEST['loc']; ?></button> <br><br>

                <?php } else { ?>

                    <h5 class="bg-info big-info clearfix" style="padding:20px;"> The District Training Date For This District <u>MUST</u> Be Set Before You Can Assign Master Trainers. <a href="?act=editactivity&amp;wave=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo urldecode($_REQUEST['loc']); ?>" class="btn btn-primary pull-right" >Set District Training Date</a></h5>

                <?php } ?>
        </div>
    <?php } else if ($action == 'removetrainer') {

        if (isset($_REQUEST['mtid'])) {

            $database->query('SELECT full_name FROM master_trainers WHERE mtid = :mtid',
                array (
                    ':mtid' => $_REQUEST['mtid']
                )
            );
            $result = $database->statement->fetch(PDO::FETCH_ASSOC);

            if (isset($_REQUEST['confirm'])) {

                $confirmed = $_REQUEST['confirm'];

                if ($confirmed == 1) {

                    $mtData = array('mtid'=>$_REQUEST['mtid'],'loc'=>urldecode($_REQUEST['loc']),'waveid'=>$_REQUEST['waveid']);
                        // Enter Action Log
                        quickFuncLog(
                            $ArrayData = array(
                              0 => 3,
                              1 => 'Deleted master trainers',
                              2 => 'Deleted master trainers'
                            )
                        );

                    $rollOut->removeMasterTrainer($mtData);

                }

            } else { ?>

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        <div class="bg-warning text-center">
                            <br>

                            <p>You are about to Remove <code><?php echo $result['full_name']; ?></code> From This Master Trainer's List </p>

                            <div class="clearfix" style="width:30%;margin:auto;">

                                <p class="pull-left"><a href="?act=addtrainers&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo $_REQUEST['loc']; ?>" class="btn btn-default">Cancel</a></p>
                                <p class="pull-right"><a href="?act=removetrainer&amp;mtid=<?php echo $_REQUEST['mtid']; ?>&amp;waveid=<?php echo $_REQUEST['waveid']; ?>&amp;loc=<?php echo $_REQUEST['loc']; ?>&amp;confirm=1"class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Remove</a> </p>

                            </div>
                            <br>
                        </div>

                    </div>
                </div>

            <?php }
            
        }
    }

?>

<!--================================================-->
</div>
<!--end of content Main -->
</div>

<div class="clearFix"></div>
<!-- Footer -->
<!--<div class="footer">  </div>-->

<!--jQuery Include-->
<script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

<!--Bootstrap Js Include-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<!--Chained Select Box for County and District select box-->
<script type="text/javascript">
    //GET district
    function get_district(txt) {
        $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function (data) {
            $('#selectdistrict').html(data);
            console.log(data);
        });
    }
</script>

<!--Chained Select Box for County and Deworming Wave Districts select box-->
<script type="text/javascript">
    //GET deworming district
   /* function get_deworming_districts(txt) {
        $.post('ajax_dropdown.php', {checkval: 'deworming_districts', county: txt}).done(function (data) {
            $('#deworming_districts').html(data);
            console.log(data);
        });
    }*/
</script>

<!--textext Auto-Complete, suggestions, tags, filter-->
<script type="text/javascript" src="../js/textext.core.js"></script>
<script type="text/javascript" src="../js/textext.plugin.autocomplete.js"></script>
<script type="text/javascript" src="../js/textext.plugin.tags.js"></script>
<script type="text/javascript" src="../js/textext.plugin.suggestions.js"></script>
<script type="text/javascript" src="../js/textext.plugin.filter.js"></script>
<script type="text/javascript">
    <?php            
        global $database;
        $database->query("SELECT DISTINCT activity_venu FROM rollout_activity");
        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

        $suggestions = array();

        foreach ($results as $key => $value) {
            array_push($suggestions, $value['activity_venu']);
        }

        $suggestions = join("', '", $suggestions);
    ?>
    var suggestion = ['<?php echo $suggestions ?>'];

    $('#filter-districts').textext({
      plugins: 'autocomplete suggestions tags filter',
      suggestions: suggestion
    });
</script>

<!--Datepicker Javascript-->
<script type="text/javascript" src="../calendar/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        function initDatepicker(input) {
            var inputId = '#' + input.attr('id');
            $(inputId).datepicker({
                dateFormat: 'dd-mm-yy',
                showOn: 'focus',
                buttonImageOnly: true,
                buttonImage: '../calendar/cal.gif',
                buttonText: 'Pick a date', 
                onSelect: function(dateText,inst) { 
                    var nextId = '#'+input.next().attr('id');
                    $(nextId).datepicker("option", "minDate",dateText); 
                }
            });         
        }

        $('td.datepicker_input').each(function () {

            $(this).find('input').each(function () {

                initDatepicker($(this));

            });

        });

        // $('#edit-activity-container input').each( function() {

        //      initDatepicker($(this));

        // });

        $('input.date').datepicker({
            dateFormat: 'dd-mm-yy',
            showOn: 'focus',
            buttonImageOnly: false,
            buttonImage: '../calendar/cal.gif',
            buttonText: 'Pick a date',
            onClose: function (dateText, inst) {
                //$("#EndDate").val($("#proposedmovedate").val());
            }
        });   

    });
</script>

<!--Activity Status Tooltip-->
<script type="text/javascript"> $('.activity-status .glyphicon').tooltip();</script>

<!--jQuery Data Tables-->
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    /* Define two custom functions (asc and desc) for string sorting */
    jQuery.fn.dataTableExt.oSort['string-case-asc'] = function (x, y) {
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['string-case-desc'] = function (x, y) {
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    };

    $(document).ready(function () {
        /* Build the DataTable with third column using our custom sort functions */
        $('#data-table, #mt_table').dataTable({
            "aaSorting": [
                [0, 'asc'],
                [1, 'asc']
            ],
            "aoColumnDefs": [
                {"sType": 'string-case', "aTargets": [2]}
            ]
        });

        /* Add/remove class to a row when clicked on */
        $('#data-table.select tbody').on('click', 'tr', function () {
            $(this).toggleClass('info');
        });

        /* Init the table */
        var oTable = $('#data-table').dataTable();
    });


    //JavaScript post request like a form submit
    function post_to_url(path, params, method) {
	    method = method || "post";

	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", path);

	    for(var key in params) {
	        if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

	            form.appendChild(hiddenField);
	         }
	    }

	    document.body.appendChild(form);
	    form.submit();
	}

    function fnGetSelected(oTableLocal) {
        var selected = $(oTableLocal + ' tr.info'),
            trainersArray = [];

        $(selected).each(function () {
            trainersArray.push($(this).find('.mtid').text());
        });

        console.log(trainersArray);

        if (trainersArray.length > 0) {
        	post_to_url(document.URL, {trainersData: trainersArray});
    	};

    }
</script>

<script type='text/javascript'>
    //<![CDATA[
        var tableToExcel = (function() {
          var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
          return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var Tcontents = table.innerHTML;

            var ctx = {worksheet: name || 'Worksheet', table: Tcontents}
            window.location.href = uri + base64(format(template, ctx))
          }
        })()
    //]]> 
</script>

<!-- 
Version 1.0
7/2011
Written by David Votrubec (davidjs.com) and
Michal Tehnik (@Mictech) for ST-Software.com  
-->
<script type="text/javascript">
    (function ($) {
        $.fn.rotateTableCellContent = function (options) {
            var cssClass = ((options) ? options.className : false) || "vertical";
     
            var cellsToRotate = $('.' + cssClass, this);
     
            var betterCells = [];
            cellsToRotate.each(function () {
                var cell = $(this),
                newText = cell.text(),
                height = cell.height(),
                width = cell.width(),
                newDiv = $('<div>', { height: width, width: height }),
                newInnerDiv = $('<div>', { text: newText, 'class': 'rotated' });     
                newDiv.append(newInnerDiv);     
                betterCells.push(newDiv);
            });
     
            cellsToRotate.each(function (i) {
                $(this).html(betterCells[i]);
            });
        };
    })(jQuery);
</script>
<script type="text/javascript">
    //specify class name of cell you want to rotate
    $('.activity-calendar-days').rotateTableCellContent({className: 'wave_title'});
</script>

</body>
</html>