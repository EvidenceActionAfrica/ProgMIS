<?php
  ob_start();
  require_once ('includes/auth.php');
  require_once ('../includes/config.php');
  require_once ('../includes/logTracker.php');
  require_once ("../includes/functions.php");
  require_once ("../includes/form_functions.php");
  require_once ("../includes/function_convert_number_to_words.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>  
    <link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
    <!-- Modal CSS -->
    <link href="../css/modal.css" type="text/css" rel="stylesheet">   
  </head>

  <body>

    <!-- header start -->
    <div class="header clearfix">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">  <?php require_once ("includes/menuNav.php"); ?> </div>
    </div>

    <!-- content body -->
    <div class="contentMain clearFix">

      <div class="contentLeft"><?php require_once("includes/menuLeftBar-Settings.php"); ?></div>

      <div class="contentBody">

        <h1 style="text-align: center; margin-top: 0px">Finance And Budgeting</h1>

        <?php

          date_default_timezone_set('Africa/Nairobi');      
          require_once('includes/finance.class.php');

          global $database;
          $priv_email = $_SESSION['staff_email'];
          $database->query('SELECT priv_district_budget,priv_imp_requests,priv_cheque_requests,priv_reconciliation_return FROM staff where staff_email=:staff_email',
              array(
                  ':staff_email' => $priv_email
              )
          );
          $prevs = $database->statement->fetchall(PDO::FETCH_ASSOC)[0];

          // Get requested page view and set default page view if not set
          if (isset($_REQUEST['view'])) { $view = $_REQUEST['view']; } else {$view = 'budget'; }

          if ($view == 'budget') {

            if (isset($_REQUEST['cat'])) {
              $budget_cat = $_REQUEST['cat'];
            } else {
              $budget_cat = 'county';
            }

            if ( $budget_cat == 'county' ) {

              $budget_category = 1;

              $database->query('SELECT * FROM fin_budget_type WHERE category = :category',
                array(
                  ':category'=> $budget_category
                )
              );
              $budget_types = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

              <h2>County Budgets</h2>                

              <div class="alert alert-block">
                <button type="button" class="close pull-right" data-dismiss="alert">×</button>
                <strong>Note!</strong> County Budgets Only Exists for Counties That have been schedulled to take part in a Deworming Wave (Rollout Schedule Module)
              </div>

              <div class="bs-docs-example">

                <ul id="myTab" class="nav nav-tabs commpressed">

                  <?php if($prevs['priv_district_budget']>=3){ ?>

                  <li style="width:9%;"><a href="#tab-0" data-toggle="tab" style="min-height:50px;" >County Budgets Assumptions</a></li>

                  <?php } ?>

                  <?php 

                    $i = 1;
                    foreach ($budget_types as $budget_type) { ?>

                      <li <?php if ($i ==1 ) { echo 'class="active"';} ?> style="width:9%;min-height:50px;"><a href="#tab-<?php echo $i; ?>" data-toggle="tab" style="min-height:50px;"><?php echo $budget_type['budget_type'] ?></a></li>

                    <?php $i++; }

                  ?>

                </ul>

                <div id="myTabContent" class="tab-content">

                  <?php if($prevs['priv_district_budget']>=3){ ?>

                  <div class="tab-pane fade in" id="tab-0">

                    <h3>County Budgets Assumptions</h3>

                      <?php

                        $database->query("SELECT id FROM fin_budget_type WHERE category = :category", array(
                                ':category' => $budget_category
                            )
                        );
                        $budget_type = $database->statement->fetchall(PDO::FETCH_ASSOC);

                        $budgetTypeArray;$i=1;
                        foreach ($budget_type as $key => $value) {
                          if ($i == 1) {
                            $budgetTypeArray .= $value['id'];
                          } else {
                            $budgetTypeArray .= ','.$value['id'];
                          }
                          $i++;
                        }

                        $database->query("SELECT
                          fin_budget_jnk_item_cat_item_desc.id,
                          fin_budget_item_cat.item_cat,
                          fin_budget_jnk_item_cat_item_desc.item_desc,
                          fin_budget_jnk_item_cat_item_desc.units,
                          fin_budget_jnk_item_cat_item_desc.days,
                          fin_budget_jnk_item_cat_item_desc.ttsessions,
                          fin_budget_jnk_item_cat_item_desc.unit_cost
                          FROM fin_budget_jnk_item_cat_item_desc
                          JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id 
                          WHERE
                            fin_budget_jnk_item_cat_item_desc.budget_type
                          IN('$budgetTypeArray')");
                        $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                        $database->query("SELECT id,budget_type FROM fin_budget_type WHERE category = :category", array(
                            ':category' => $budget_category
                          )
                        );
                        $budget_type = $database->statement->fetchall(PDO::FETCH_ASSOC); 

                      ?>

                      <div class="bs-docs-example">

                        <ul class="nav nav-tabs commpressed">

                          <?php

                            $i=1;
                            foreach ($budget_type as $key => $value) { ?>

                              <li <?php if ($i==1) { echo 'class="active"'; } ?> style="width:10%;" ><a href="#inner-tab-<?php echo $value['id']; ?>" data-toggle="tab" style="min-height: 46px;" ><?php echo $value['budget_type']; ?> Assumptions</a></li>

                            <?php $i++;} ?>

                        </ul>

                        <div class="tab-content">

                          <?php
                            $i=1;
                            foreach ($budget_type as $key => $value) { ?>

                              <div class="tab-pane fade in <?php if ($i==1) { echo 'active'; } ?>" id="inner-tab-<?php echo $value['id']; ?>">

                                <?php

                                    $database->query("SELECT
                                      fin_budget_jnk_item_cat_item_desc.budget_type,
                                      fin_budget_item_cat.item_cat,
                                      fin_budget_jnk_item_cat_item_desc.item_desc,
                                      fin_budget_jnk_item_cat_item_desc.id,
                                      fin_budget_jnk_item_cat_item_desc.units,
                                      fin_budget_jnk_item_cat_item_desc.days,
                                      fin_budget_jnk_item_cat_item_desc.distance,
                                      fin_budget_jnk_item_cat_item_desc.unit_cost,
                                      fin_budget_jnk_item_cat_item_desc.unit_description
                                      FROM fin_budget_jnk_item_cat_item_desc
                                      JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id 
                                      WHERE fin_budget_jnk_item_cat_item_desc.budget_type = :budgettype",
                                        array(
                                          ':budgettype' => $value['id']
                                        )
                                      );
                                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                    if ( isset( $_POST['update_budget_assumptions'] ) ) {

                                      foreach($_POST['id'] as $key => $value_) {

                                        $item = $key;

                                        $data = array(
                                          'id' => $value_, 
                                          'units' => $_POST['units'][$item], 
                                          'days' => $_POST['days'][$item], 
                                          'unit_cost' => $_POST['unit_cost'][$item], 
                                          'distance' => $_POST['distance'][$item], 
                                          'unit_description' => $_POST['unit_description'][$item], 
                                        );

                                        $financeClass->updateCountyAssumptions($data);

                                      }
                                  
                                    }

                                ?>

                                <div id="budget-form-container">

                                  <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                                    <table id="budget-assumption-rorm" class="table table-bordered table-condensed">
                                      <thead>
                                        <tr>
                                          <th>Item Description</th>
                                          <th class="units">P<sub/>a&#x25;</sub><br>/Units</th>
                                          <th class="days">Days</th>
                                          <?php if ( $results[0]['budget_type'] == 9 || $results[0]['budget_type'] == 10) { ?> <th class="ttsessions">Distance</th> <?php } ?>
                                          <th class="unit_cost">Unit<br>Cost</th>
                                          <th>Description</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      <?php foreach ($results as $key => $valu) { ?>
                                        <tr>
                                          <td><?php echo $valu['item_desc']; ?></td>
                                          <td class="hidden"><input type="text" name="id[]" value="<?php echo $valu['id'] ?>" class="num-only"/></td>
                                          <td><input type="text" name="units[]" value="<?php echo $valu['units']; ?>" class="num-only"/></td>
                                          <td><input type="text" name="days[]" value="<?php echo $valu['days']; ?>" class="num-only"/></td>
                                          <td class="<?php if($valu['budget_type'] != 9 && $valu['budget_type'] != 10) { echo 'hidden'; } ?>"><input type="text" name="distance[]" value="<?php echo $valu['distance']; ?>" class="num-only"/></td> 
                                          <td><input type="text" name="unit_cost[]" value="<?php echo $valu['unit_cost']; ?>" class="num-only"/></td>
                                          <td><input type="text" name="unit_description[]" value="<?php echo $valu['unit_description']; ?>"/></td>
                                        </tr>
                                      <?php } ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="7"><button type="submit" name="update_budget_assumptions" class="btn-primary pull-right">Update Assumptions</button></td>
                                        </tr>
                                      </tfoot>
                                    </table>

                                  </form>

                                </div>

                              </div>

                            <?php $i++;} ?>

                        </div>

                      </div>

                  </div>

                  <?php } ?>

                  <?php 

                    $j = 1;
                    foreach ($budget_types as $budget_type) { ?>

                      <div class="tab-pane fade in<?php if ($j==1) { echo ' active';} ?>" id="tab-<?php echo $j; ?>">

                        <h3><?php echo $budget_type['budget_type']; ?></h3>

                        <?php

                          $database->query('SELECT  
                            districts.county,
                            districts.district_name,
                            rollout_activity.activity_venu,
                            rollout_activity.wave_id 
                            FROM rollout_activity 
                            JOIN districts ON districts.district_name = rollout_activity.activity_venu 
                            GROUP BY districts.county,rollout_activity.wave_id');
                          $count = $database->count();

                          if ( $count > 0 ) {

                            $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                            ?>

                            <table class="table table-bordered table-hover">

                              <thead>
                                <tr>
                                  <!-- <th>Budget</th> -->
                                  <th>County</th>
                                  <th>Deworming Wave</th>
                                  <th>Budget Total (KSH)</th>
                                </tr>
                              </thead>

                              <tbody>

                                <?php

                                  foreach ($results as $key => $value) {

                                    $database->query('SELECT * FROM deworming_waves WHERE id = :id',
                                      array(
                                        ':id'=>$value['wave_id']
                                      )
                                    );
                                    $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                                    $database->query('SELECT county FROM districts WHERE district_name = :district_name',
                                      array(
                                        ':district_name'=>$value['activity_venu']
                                      )
                                    );
                                    $county = $database->statement->fetch(PDO::FETCH_ASSOC);

                                    $database->query('SELECT SUM(total) AS budget_total FROM fin_budget_cat_county WHERE wave = :wave AND county = :county AND budget_cat = :budget_cat AND budget_type = :budget_type',
                                      array(
                                        ':wave'=>$value['wave_id'],
                                        ':county' => $county['county'],
                                        ':budget_cat' => $budget_category,
                                        ':budget_type' => $budget_type['id']
                                      )
                                    );
                                    $total = $database->statement->fetch(PDO::FETCH_ASSOC);
                                    $hyperlink = 'view=budget-single&wave='.$value['wave_id'].'&type='.$budget_type['id'].'&cat='.$budget_category.'&loc='.urlencode($county['county']).'';

                                  ?>

                                  <tr>

                                    <!-- <td><a href="?<?php //echo $hyperlink; ?>"><?php //echo $budget_type['budget_type']; ?></a></td> -->
                                    <td><a href="?<?php echo $hyperlink; ?>"><?php echo $county['county'] ;?></a></td>
                                    <td><a href="?<?php echo $hyperlink; ?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                                    <th><a href="?<?php echo $hyperlink; ?>"><?php if ( $total['budget_total'] != NULL ) { echo number_format($total['budget_total']); } else { echo '<small class="muted"><i>Budget Not Prepared</i></small>'; } ?></a></th>
                                   
                                  </tr>
                                
                                <?php } ?>

                              </tbody>

                            </table>

                          <?php } ?>

                      </div>

                    <?php $j++; }

                  ?>

                </div>

              </div>

            <?php } else {

              switch ($budget_cat) {
                case 'chew':
                  $budget_category = 3;$title = 'CHEW Budgets';
                  break;
                case 'teacher':
                  $budget_category = 4;$title = 'Teacher Training Budgets';
                  break;
                case 'dday':
                  $budget_category = 5;$title = 'Deworming Day Budgets';
                  break;   
                case 'mt':
                  $budget_category = 6;$title = 'MT Training';
                  break;             
                default:
                  $budget_category = 2;$title = 'Sub-County Training Budgets';
                  break;
              }    

              $database->query('SELECT * FROM fin_budget_type WHERE category = :category',
                array(
                  ':category'=> $budget_category
                )
              );
              $budget_types = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

              <h2><?php echo $title; ?></h2>                

              <div class="alert alert-block">
                <button type="button" class="close pull-right" data-dismiss="alert">×</button>
                <strong>Note!</strong> <?php echo $title; ?> Only Exists for Sub-Counties That have been schedulled to take part in a Deworming (Rollout Schedule Module)
              </div>

              <?php if (!empty($budget_types)) { ?>

                <div class="bs-docs-example">

                  <ul id="myTab" class="nav nav-tabs">

                    <li><a href="#tab-0" data-toggle="tab"><?php echo $title; ?> Assumptions</a></li>

                    <?php 

                      $i = 1;
                      foreach ($budget_types as $budget_type) { ?>

                        <li <?php if ($i ==1 ) { echo 'class="active"';} ?> ><a href="#tab-<?php echo $i; ?>" data-toggle="tab"><?php echo $budget_type['budget_type'] ?></a></li>

                      <?php $i++; }                             

                    ?>                        

                  </ul>

                  <div id="myTabContent" class="tab-content">

                    <div class="tab-pane fade in" id="tab-0">

                      <h3><?php echo $title; ?> Assumptions</h3>

                      <?php

                        $database->query("SELECT id,budget_type FROM fin_budget_type WHERE category = :category", array(
                            ':category' => $budget_category
                          )
                        );
                        $budget_type = $database->statement->fetchall(PDO::FETCH_ASSOC); 

                      ?>

                      <div class="bs-docs-example">

                        <ul class="nav nav-tabs">

                          <?php

                            $i=1;
                            foreach ($budget_type as $key => $value) { ?>

                              <li <?php if ($i==1) { echo 'class="active"'; } ?>><a href="#inner-tab-<?php echo $value['id']; ?>" data-toggle="tab"><?php echo $value['budget_type']; ?> Assumptions</a></li>

                            <?php $i++; } 

                          ?>

                        </ul>

                        <div class="tab-content">

                          <?php $i=1; foreach ($budget_type as $key => $value) { ?>

                            <?php if ($value['id'] == 19) { ?>

                              <div class="tab-pane fade in <?php if ($i==1) { echo 'active'; } ?>" id="inner-tab-<?php echo $value['id']; ?>">

                                  <?php

                                    $database->query("SELECT
                                      fin_budget_item_cat.item_cat,
                                      fin_budget_jnk_item_cat_item_desc.item_desc,
                                      fin_budget_jnk_item_cat_item_desc.unit_cost,
                                      fin_budget_mt_params.id,
                                      fin_budget_mt_params.unit_key_1,
                                      fin_budget_mt_params.unit_value_1,
                                      fin_budget_mt_params.unit_key_2,
                                      fin_budget_mt_params.unit_value_2,
                                      fin_budget_mt_params.unit_key_3,
                                      fin_budget_mt_params.unit_value_3,
                                      fin_budget_mt_params.unit_key_4,
                                      fin_budget_mt_params.unit_value_4
                                      FROM fin_budget_jnk_item_cat_item_desc
                                      JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id
                                      JOIN fin_budget_mt_params ON fin_budget_jnk_item_cat_item_desc.id = fin_budget_mt_params.item_desc
                                      WHERE fin_budget_jnk_item_cat_item_desc.budget_type = :budgettype",
                                          array(
                                            ':budgettype' => $value['id']
                                          )
                                      );
                                    $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                    $new_results = array();
                                    foreach ($results as $key => $result) {
                                      $item_cat = $result['item_cat'];
                                      $new_results[$item_cat][$key] = array(
                                        'id'           => $result['id'],
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

                                    if ( isset( $_POST['update_budget_assumptions'] ) ) {

                                      foreach($_POST['id'] as $key => $value) {

                                        $data = array(
                                          'id'           => $value,
                                          'unit_key_1'   => $_POST['unit_key_1'][$key],
                                          'unit_value_1' => $_POST['unit_value_1'][$key],
                                          'unit_key_2'   => $_POST['unit_key_2'][$key],
                                          'unit_value_2' => $_POST['unit_value_2'][$key],
                                          'unit_key_3'   => $_POST['unit_key_3'][$key],
                                          'unit_value_3' => $_POST['unit_value_3'][$key],
                                          'unit_key_4'   => $_POST['unit_key_4'][$key],
                                          'unit_value_4' => $_POST['unit_value_4'][$key],
                                        );
                                        $financeClass->updateMtAssumptions($data);

                                      }
                                  
                                    }                              

                                  ?>

                                  <div id="budget-form-container">

                                    <form action="<?php echo basename( $_SERVER['REQUEST_URI'] ); ?>" method="post">

                                      <table id="budget-assumption-rorm" class="table table-bordered table-condensed" cellpadding="10">
                                        <thead>
                                          <tr>
                                            <th width="200px"><small>Item Description</small></th>
                                            <th><small>Unit #</small></th>
                                            <th><small>Unit type</small></th>
                                            <th><small>Unit #</small></th>
                                            <th><small>Unit Type</small></th>
                                            <th><small>Unit #</small></th>
                                            <th><small>Unit Type</small></th>
                                            <th><small>Unit #</small></th>
                                            <th><small>Unit Type</small></th>
                                            <th><small>Unit Cost (Ksh)</small></th>
                                            <th width="100px"><small>Total Cost (Ksh)</small></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <?php $total_array = array(); foreach ($new_results as $key => $new_result) { ?>
                                            <tr>
                                              <td colspan="11"><small><b><?php echo $key;?></b></small></td>
                                            </tr>
                                            <?php $sub_total_array = array(); foreach ($new_result as $key => $value) { 

                                              if ( $value['unit_cost']    == '' || $value['unit_cost'] == 'NULL' )    { $unit_cost    = 1; } else { $unit_cost    = $value['unit_cost']; }
                                              if ( $value['unit_value_1'] == '' || $value['unit_value_1'] == 'NULL' ) { $unit_value_1 = 1; } else { $unit_value_1 = $value['unit_value_1']; }
                                              if ( $value['unit_value_2'] == '' || $value['unit_value_2'] == 'NULL' ) { $unit_value_2 = 1; } else { $unit_value_2 = $value['unit_value_2']; }
                                              if ( $value['unit_value_3'] == '' || $value['unit_value_3'] == 'NULL' ) { $unit_value_3 = 1; } else { $unit_value_3 = $value['unit_value_3']; }
                                              if ( $value['unit_value_4'] == '' || $value['unit_value_4'] == 'NULL' ) { $unit_value_4 = 1; } else { $unit_value_4 = $value['unit_value_4']; }
                                              
                                              $row_total = $unit_cost*$unit_value_1*$unit_value_2*$unit_value_3*$unit_value_4;
                                              array_push($sub_total_array, $row_total);

                                              ?>
                                              <input type="hidden" name="id[]" value="<?php echo $value['id']; ?>">
                                              <tr>
                                                <td><?php echo $value['item_desc']; ?></td>
                                                <td><?php echo $value['unit_cost']; ?></td>
                                                <td><input type="text" name="unit_key_1[]"   value="<?php echo $value['unit_key_1']; ?>"   style="width:100%;" /></td>
                                                <td><input type="text" name="unit_value_1[]" value="<?php echo $value['unit_value_1']; ?>" style="width:100%;" /></td>
                                                <td><input type="text" name="unit_key_2[]"   value="<?php echo $value['unit_key_2']; ?>"   style="width:100%;" /></td>
                                                <td><input type="text" name="unit_value_2[]" value="<?php echo $value['unit_value_2']; ?>" style="width:100%;" /></td>
                                                <td><input type="text" name="unit_key_3[]"   value="<?php echo $value['unit_key_3']; ?>"   style="width:100%;" /></td>
                                                <td><input type="text" name="unit_value_3[]" value="<?php echo $value['unit_value_3']; ?>" style="width:100%;" /></td>
                                                <td><input type="text" name="unit_key_4[]"   value="<?php echo $value['unit_key_4']; ?>"   style="width:100%;" /></td>
                                                <td><input type="text" name="unit_value_4[]" value="<?php echo $value['unit_value_4']; ?>" style="width:100%;" /></td>
                                                <td align="right"><b><?php echo number_format($row_total); ?></b></td>
                                              </tr>
                                            <?php } ?>
                                            <tr>
                                              <td><small><em>Sub-Total</em></small></td>
                                              <td colspan="9">&nbsp;</td>
                                              <td><b> 
                                                  <?php 
                                                    $sub_total = array_sum($sub_total_array); 
                                                    echo number_format($sub_total);
                                                    array_push($total_array, $sub_total); 
                                                  ?>
                                                  </b>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="11">&nbsp;</td>
                                            </tr>
                                          <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              <td><small><b>TOTAL</b></small></td>
                                              <td colspan="9">&nbsp;</td>
                                              <td><b><?php echo $total = number_format( array_sum($total_array) ); ?></b></td>
                                            </tr>
                                            <tr>
                                              <td colspan="11"><button type="submit" name="update_budget_assumptions" class="btn-primary pull-right">Update Assumptions</button></td>
                                            </tr>
                                        </tfoot>
                                      </table>

                                    </form>

                                  </div>

                              </div>

                            <?php } else {?>

                              <div class="tab-pane fade in <?php if ($i==1) { echo 'active'; } ?>" id="inner-tab-<?php echo $value['id']; ?>">

                                  <?php

                                      $database->query("SELECT
                                        fin_budget_jnk_item_cat_item_desc.budget_type,
                                        fin_budget_jnk_item_cat_item_desc.id,
                                        fin_budget_item_cat.item_cat,
                                        fin_budget_jnk_item_cat_item_desc.item_desc,
                                        fin_budget_jnk_item_cat_item_desc.units,
                                        fin_budget_jnk_item_cat_item_desc.days,
                                        fin_budget_jnk_item_cat_item_desc.ttsessions,
                                        fin_budget_jnk_item_cat_item_desc.distance,
                                        fin_budget_jnk_item_cat_item_desc.unit_cost,
                                        fin_budget_jnk_item_cat_item_desc.unit_description
                                        FROM fin_budget_jnk_item_cat_item_desc
                                        JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id
                                        WHERE fin_budget_jnk_item_cat_item_desc.budget_type = :budgettype",
                                            array(
                                              ':budgettype' => $value['id']
                                            )
                                        );
                                      $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                                      if ( isset( $_POST['update_budget_assumptions'] ) ) {

                                        foreach($_POST['id'] as $key => $value) {

                                          $item = $key;

                                          $data = array(
                                            'id' => $value, 
                                            'units' => $_POST['units'][$item], 
                                            'days' => $_POST['days'][$item], 
                                            'distance' => $_POST['distance'][$item], 
                                            'ttsessions' => $_POST['ttsessions'][$item], 
                                            'unit_cost' => $_POST['unit_cost'][$item], 
                                            'unit_description' => $_POST['unit_description'][$item], 
                                          );

                                          $financeClass->updateAssumptions($data);

                                        }
                                    
                                      }                              

                                  ?>

                                  <div id="budget-form-container">

                                    <form action="<?php echo basename( $_SERVER['REQUEST_URI'] ); ?>" method="post">

                                      <table id="budget-assumption-rorm" class="table table-bordered table-condensed">
                                        <thead>
                                          <tr>
                                            <!-- <th>Item Category</th> -->
                                            <th>Item Description</th>
                                            <th class="units">P<sub/>a&#x25;</sub><br>/Units</th>
                                            <th class="days">Days</th>
                                            <?php if ( $_REQUEST['cat'] == 'teacher' ) { ?> <th class="ttsessions">TT<br>Sessions</th> <?php } ?>
                                            <?php if ( $results[0]['budget_type'] == 9 || $results[0]['budget_type'] == 10) { ?> <th class="ttsessions">Distance</th> <?php } ?>
                                            <th class="unit_cost">Unit<br>Cost</th>
                                            <th>Description</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($results as $key => $value) { ?>
                                          <tr>
                                            <!-- <td><?php // echo $value['item_cat']; ?></td> -->
                                            <td><?php echo $value['item_desc']; ?></td>
                                            <td class="hidden"><input type="text" name="id[]" value="<?php echo $value['id'] ?>" class="num-only"/></td>
                                            <td><input type="text" name="units[]" value="<?php echo $value['units']; ?>" class="num-only" <?php if(!is_numeric($value['units'])) { echo 'readonly'; } ?> /></td>
                                            <td><input type="text" name="days[]" value="<?php echo $value['days']; ?>" class="num-only"/></td>
                                            <td class="<?php if ( $_REQUEST['cat'] != 'teacher' ) { echo 'hidden'; } ?>"><input type="text" name="ttsessions[]" value="<?php echo $value['ttsessions']; ?>" class="num-only" <?php if(!is_numeric($value['ttsessions'])) { echo 'ttsessions'; } ?> /></td> 
                                            <td class="<?php if ( $value['budget_type'] != 9 && $value['budget_type'] != 10 ) { ?> hidden <?php } ?>"><input type="text" name="distance[]" value="<?php echo $value['distance']; ?>" class="num-only" <?php if ( $editable != true  ) { echo 'readonly'; } ?>/></td>                                            
                                            <td><input type="text" name="unit_cost[]" value="<?php echo $value['unit_cost']; ?>" class="num-only"/></td>
                                            <td><input type="text" name="unit_description[]" value="<?php echo $value['unit_description']; ?>"/></td>
                                          </tr>
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <td colspan="<?php if($_REQUEST['cat']=='teacher') { echo "7"; } else { echo "6"; } ?>"><button type="submit" name="update_budget_assumptions" class="btn-primary pull-right">Update Assumptions</button></td>
                                          </tr>
                                        </tfoot>
                                      </table>

                                    </form>

                                  </div>

                              </div>

                            <?php } ?>

                          <?php $i++;} ?>

                        </div>

                      </div>

                    </div>

                    <?php 

                      $j = 1;
                      foreach ($budget_types as $budget_type) { ?>

                        <div class="tab-pane fade in<?php if ($j ==1) { echo ' active';} ?>" id="tab-<?php echo $j; ?>">

                          <h3><?php echo $budget_type['budget_type']; ?></h3>

                          <?php

                              if ($budget_cat == 'dday' && ( $budget_type['budget_type'] == 'MoH-SCHISTO' || $budget_type['budget_type'] == 'MoH-STH' ) ) {

                                if ($budget_type['budget_type'] == 'MoH-SCHISTO') {
                                  $treatment_type = 'STH/Schisto';

                                } else if ($budget_type['budget_type'] == 'MoH-STH') {
                                   $treatment_type = 'STH';
                                }

                                $database->query('SELECT 
                                  DISTINCT rollout_activity.activity_venu,
                                  districts.treatment_type,
                                  districts.county,
                                  rollout_activity.wave_id FROM rollout_activity
                                  JOIN districts ON districts.district_name = rollout_activity.activity_venu
                                  WHERE districts.treatment_type = :treatment_type AND  ', 
                                  array(
                                    ':treatment_type' => $treatment_type
                                  )
                                );

                              } else if ($budget_cat == 'mt') {

                                $database->query('SELECT 
                                  DISTINCT rollout_activity.activity_venu,
                                  districts.treatment_type,
                                  rollout_activity.wave_id FROM rollout_activity
                                  JOIN districts ON districts.district_name = rollout_activity.activity_venu
                                  WHERE districts.treatment_type = :treatment_type AND districts.county = :county ', 
                                  array(
                                    ':treatment_type' => $treatment_type,
                                    ':county' => 'Nairobi'
                                  )
                                );

                              } else {

                                $database->query('SELECT DISTINCT activity_venu,wave_id FROM rollout_activity');

                              }
                              $count = $database->count();

                            if ( $count > 0 ) {

                              $results = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

                              <table class="table table-bordered table-hover">

                                <thead>
                                  <tr>
                                    <!-- <th>Budget</th> -->
                                    <th>Sub-County</th>
                                    <th>Deworming Wave</th>
                                    <th>Budget Total (KSH)</th>
                                  </tr>
                                </thead>

                                <tbody>

                                <?php

                                  foreach ($results as $key => $value) {

                                    $database->query('SELECT * FROM deworming_waves WHERE id = :id',
                                      array(
                                        ':id'=>$value['wave_id']
                                      )
                                    );
                                    $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                                    $database->query('SELECT SUM(total) AS budget_total FROM fin_budget_cat_districts WHERE wave = :wave AND district = :district AND budget_cat = :budget_cat AND budget_type = :budget_type',
                                      array(
                                        ':wave'=>$value['wave_id'],
                                        ':district' => urldecode($value['activity_venu']),
                                        ':budget_cat' => $budget_category,
                                        ':budget_type' => $budget_type['id']

                                      )
                                    );
                                    $total = $database->statement->fetch(PDO::FETCH_ASSOC);

                                    $hyperlink = 'view=budget-single&wave='.$value['wave_id'].'&cat='.$budget_category.'&type='.$budget_type['id'].'&loc='.urlencode($value['activity_venu']).'';

                                    ?>

                                    <tr>

                                      <!-- <td><a href="?<?php //echo $hyperlink; ?>"><?php //echo $budget_type['budget_type']; ?></a></td> -->
                                      <td><a href="?<?php echo $hyperlink; ?>"><?php echo $value['activity_venu'] ;?></a></td>
                                      <td><a href="?<?php echo $hyperlink; ?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                                      <th><a href="?<?php echo $hyperlink; ?>"><?php if ( $total['budget_total'] != NULL ) { echo number_format($total['budget_total']); } else { echo '<small class="muted"><i>Budget Not Prepared</i></small>'; } ?></a></th>
                                     
                                    </tr>
                                  
                                  <?php } ?>

                                </tbody>

                              </table>

                            <?php } ?>

                        </div>

                      <?php $j++; } ?>

                  </div>

                </div>

              <?php } else { ?>

                <table class="table table-bordered table-hover">

                    <thead>
                      <tr>
                        <th>Sub-County</th>
                        <th>Deworming Wave</th>
                        <th>Budget Total (KSH)</th>
                      </tr>
                    </thead>

                    <tbody>

                      <?php

                        $database->query('SELECT DISTINCT activity_venu,wave_id FROM rollout_activity WHERE activity_venu');
                        $count = $database->count();

                        if ( $count != 0 ) {

                          $results = $database->statement->fetchall(PDO::FETCH_ASSOC);

                          foreach ($results as $key => $value) {

                            $database->query('SELECT * FROM deworming_waves WHERE id = :id',
                              array(
                                ':id'=>$value['wave_id']
                              )
                            );
                            $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                            $database->query('SELECT SUM(total) AS budget_total FROM fin_budget_cat_districts WHERE wave = :wave AND district = :district AND budget_cat = :budget_cat AND budget_type = :budget_type',
                              array(
                                ':wave'=>$value['wave_id'],
                                ':district' => urldecode($value['activity_venu']),
                                ':budget_cat' => $budget_category,
                                ':budget_type' => 0
                              )
                            );
                            $total = $database->statement->fetch(PDO::FETCH_ASSOC);

                            $hyperlink = 'view=budget-single&cat='.$budget_category.'&wave='.$value['wave_id'].'&type='.$budget_type['id'].'&loc='.urlencode($value['activity_venu']).'';

                            ?> 
                            <tr>

                              <td><a href="?<?php echo $hyperlink; ?>"><?php echo $value['activity_venu'] ;?></a></td>
                              <td><a href="?<?php echo $hyperlink; ?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                              <th><a href="?<?php echo $hyperlink; ?>"><?php if ( $total['budget_total'] != NULL ) { echo number_format($total['budget_total']); } else { echo '<small class="muted"><i>Budget Not Prepared</i></small>'; } ?></a></th>
                             
                            </tr>
                              
                          <?php }

                         }

                      ?>

                    </tbody>

                </table>

              <?php } ?>

            <?php }

          } else if ($view == 'budget-single') {

            if ($_GET['cat'] == 1) {

              $database->query('SELECT 
                fin_budget_cat_county.record_id AS id,
                fin_budget_cat_county.county,
                fin_budget_cat_county.wave,
                fin_budget_cat_county.budget_cat,
                fin_budget_cat_county.budget_type,
                fin_budget_cat_county.item_desc AS unique_item_desc,
                fin_budget_cat_county.acc_form AS unique_acc_form,
                fin_budget_cat_county.units,
                fin_budget_cat_county.distance,
                fin_budget_cat_county.unit_cost,
                fin_budget_cat_county.days,
                fin_budget_cat_county.total,
                fin_budget_cat_county.recepient as unique_recepient,
                fin_budget_cat_county.unit_description,
                fin_budget_cat_county.accounting AS unique_accounting,
                fin_budget_cat_county.forms_recepients AS unique_forms_recepients,
                (
                  SELECT SUM(total) FROM fin_budget_cat_county WHERE 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type 
                ) AS budget_total,
                (
                  SELECT fin_budget_item_cat.item_cat 
                  FROM fin_budget_jnk_budget_type_item_cat 
                  JOIN fin_budget_item_cat ON fin_budget_jnk_budget_type_item_cat.fk_item_cat = fin_budget_item_cat.id
                  WHERE fin_budget_jnk_budget_type_item_cat.id = fin_budget_jnk_item_cat_item_desc.item_cat 
                ) AS item_cat,
                fin_budget_jnk_item_cat_item_desc.recepient,
                fin_budget_jnk_item_cat_item_desc.accounting,
                fin_budget_jnk_item_cat_item_desc.forms_recepients,
                fin_budget_jnk_item_cat_item_desc.item_desc,
                fin_budget_jnk_item_cat_item_desc.acc_form,
                fin_budget_type.budget_type,
                fin_budget_category.category
                FROM fin_budget_cat_county
                JOIN fin_budget_jnk_item_cat_item_desc ON fin_budget_cat_county.record_id = fin_budget_jnk_item_cat_item_desc.id
                JOIN fin_budget_type ON fin_budget_cat_county.budget_type = fin_budget_type.id
                JOIN fin_budget_category ON fin_budget_cat_county.budget_cat = fin_budget_category.id
                WHERE 
                  fin_budget_cat_county.county = :county AND 
                  fin_budget_cat_county.wave = :wave AND 
                  fin_budget_cat_county.budget_cat = :budget_cat AND 
                  fin_budget_cat_county.budget_type = :budget_type 
                ', 
                array(
                  ':county' => urldecode($_REQUEST['loc']),
                  ':wave' => $_REQUEST['wave'],
                  ':budget_cat' => $_REQUEST['cat'],
                  ':budget_type' => $_REQUEST['type']
                )
              );
              $count = $database->count();

            } else {

              if ($_GET['type'] == 19) {

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

              } else {

                $database->query('SELECT 
                  fin_budget_cat_districts.record_id AS id,
                  fin_budget_cat_districts.district,
                  fin_budget_cat_districts.wave,
                  fin_budget_cat_districts.budget_cat,
                  fin_budget_cat_districts.budget_type,
                  fin_budget_cat_districts.item_desc AS unique_item_desc,
                  fin_budget_cat_districts.acc_form AS unique_acc_form,
                  fin_budget_cat_districts.units,
                  fin_budget_cat_districts.ttsessions,
                  fin_budget_cat_districts.unit_cost,
                  fin_budget_cat_districts.days,
                  fin_budget_cat_districts.total,
                  fin_budget_cat_districts.recepient as unique_recepient,
                  fin_budget_cat_districts.unit_description,
                  fin_budget_cat_districts.accounting AS unique_accounting,
                  fin_budget_cat_districts.forms_recepients AS unique_forms_recepients,
                  (
                    SELECT SUM(total) FROM fin_budget_cat_districts WHERE 
                      fin_budget_cat_districts.district = :district AND 
                      fin_budget_cat_districts.wave = :wave AND 
                      fin_budget_cat_districts.budget_cat = :budget_cat AND 
                      fin_budget_cat_districts.budget_type = :budget_type 
                  ) AS budget_total,
                  (
                    SELECT fin_budget_item_cat.item_cat 
                    FROM fin_budget_jnk_budget_type_item_cat JOIN fin_budget_item_cat ON fin_budget_jnk_budget_type_item_cat.fk_item_cat = fin_budget_item_cat.id
                    WHERE fin_budget_jnk_budget_type_item_cat.id = fin_budget_jnk_item_cat_item_desc.item_cat 
                  ) AS item_cat,
                  fin_budget_jnk_item_cat_item_desc.recepient,
                  fin_budget_jnk_item_cat_item_desc.accounting,
                  fin_budget_jnk_item_cat_item_desc.forms_recepients,
                  fin_budget_jnk_item_cat_item_desc.item_desc,
                  fin_budget_jnk_item_cat_item_desc.acc_form,
                  fin_budget_type.budget_type,
                  fin_budget_category.category
                  FROM fin_budget_cat_districts
                  JOIN fin_budget_jnk_item_cat_item_desc ON fin_budget_cat_districts.record_id = fin_budget_jnk_item_cat_item_desc.id
                  JOIN fin_budget_type ON fin_budget_cat_districts.budget_type = fin_budget_type.id
                  JOIN fin_budget_category ON fin_budget_cat_districts.budget_cat = fin_budget_category.id
                  WHERE 
                    fin_budget_cat_districts.district = :district AND 
                    fin_budget_cat_districts.wave = :wave AND 
                    fin_budget_cat_districts.budget_cat = :budget_cat AND 
                    fin_budget_cat_districts.budget_type = :budget_type 
                  ', 
                  array(
                    ':district' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['cat'],
                    ':budget_type' => $_REQUEST['type']
                  )
                );
                $count = $database->count();                

              }

            }

            if ( $count > 0 ) {

              $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
              $budget_total = $results[0]['budget_total'];
              $budget_saved = true;

            } else {

              if ($_GET['type'] == 19) {

                $database->query("SELECT
                  fin_budget_item_cat.item_cat,
                  fin_budget_jnk_item_cat_item_desc.id AS record_id,
                  fin_budget_jnk_item_cat_item_desc.item_desc,
                  fin_budget_jnk_item_cat_item_desc.unit_cost,
                  fin_budget_mt_params.id,
                  fin_budget_mt_params.unit_key_1,
                  fin_budget_mt_params.unit_value_1,
                  fin_budget_mt_params.unit_key_2,
                  fin_budget_mt_params.unit_value_2,
                  fin_budget_mt_params.unit_key_3,
                  fin_budget_mt_params.unit_value_3,
                  fin_budget_mt_params.unit_key_4,
                  fin_budget_mt_params.unit_value_4
                  FROM fin_budget_jnk_item_cat_item_desc
                  JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id
                  JOIN fin_budget_mt_params ON fin_budget_jnk_item_cat_item_desc.id = fin_budget_mt_params.item_desc
                  WHERE fin_budget_jnk_item_cat_item_desc.budget_type = :budgettype",
                      array(
                        ':budgettype' => $_GET['type']
                      )
                  );
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

                $budget_saved = false;

              } else {

                $database->query('SELECT
                  fin_budget_type.budget_type,
                  fin_budget_type.category,
                  fin_budget_type.budget_forms_receipts,
                  fin_budget_category.category,
                  fin_budget_item_cat.id,
                  fin_budget_item_cat.item_cat,
                  fin_budget_jnk_item_cat_item_desc.id,
                  fin_budget_jnk_item_cat_item_desc.days,
                  fin_budget_jnk_item_cat_item_desc.units,
                  fin_budget_jnk_item_cat_item_desc.distance,
                  fin_budget_jnk_item_cat_item_desc.ttsessions,
                  fin_budget_jnk_item_cat_item_desc.unit_cost,
                  fin_budget_jnk_item_cat_item_desc.total,
                  fin_budget_jnk_item_cat_item_desc.recepient,
                  fin_budget_jnk_item_cat_item_desc.unit_description,
                  fin_budget_jnk_item_cat_item_desc.accounting,
                  fin_budget_jnk_item_cat_item_desc.forms_recepients,
                  fin_budget_jnk_item_cat_item_desc.item_desc,
                  fin_budget_jnk_item_cat_item_desc.acc_form
                  FROM fin_budget_jnk_item_cat_item_desc
                  JOIN fin_budget_type ON fin_budget_jnk_item_cat_item_desc.budget_type = fin_budget_type.id
                  JOIN fin_budget_category ON fin_budget_type.category = fin_budget_category.id
                  JOIN fin_budget_item_cat ON fin_budget_jnk_item_cat_item_desc.item_cat = fin_budget_item_cat.id 
                  WHERE
                    fin_budget_jnk_item_cat_item_desc.budget_type = :budget_type
                  ',
                  array(
                    ':budget_type' => $_GET['type']
                  )
                );
                $results = $database->statement->fetchall(PDO::FETCH_ASSOC);
                $budget_total = $results[0]['budget_total'];
                $budget_saved = false;                

              }

            }

            $database->query('SELECT budget_data,budget_note,verified_by,approval_notice FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
              array(
                'location' => $_GET['loc'],
                'wave' => $_GET['wave'],
                'budget_cat' => $_GET['cat'],
                'budget_type' => $_GET['type']
              )
            );
            $budget_meta = $database->statement->fetch(PDO::FETCH_ASSOC);

            $database->query('SELECT deworming_wave FROM deworming_waves WHERE id = :id',
              array(
                ':id'=>$_REQUEST['wave']
              )
            );
            $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

            $budget_data = unserialize($budget_meta['budget_data']);
            $the_data = array();

            $approverArray = array(1,46,7,4,5,8);
            $database->query("SELECT staff_id,staff_name FROM staff WHERE staff_id IN ('".implode("','", $approverArray)."')");
            $budget_approvers = $database->statement->fetchall(PDO::FETCH_ASSOC);

            if ( $_GET['cat'] == 1 ) {

              if ( $_GET['type']==7 || $_GET['type']==8 || $_GET['type']==9 || $_GET['type'] ==10 ) {

                $database->query('SELECT count(district_name) AS subcountiesCount FROM districts WHERE county = :county',
                  array(
                    ':county'=> urldecode( $_GET['loc'] )
                  )
                );
                $subcountiesCount = $database->statement->fetch(PDO::FETCH_ASSOC)['subcountiesCount'];

                $database->query('SELECT count(district_name) AS schistosubcounties FROM districts WHERE county = :county AND treatment_type = :treatment_type',
                  array(
                    ':county'=> urldecode( $_GET['loc'] ),
                    ':treatment_type' => 'STH/Schisto'
                  )
                );
                $schistosubcounties = $database->statement->fetch(PDO::FETCH_ASSOC)['schistosubcounties'];

                $the_data['Number of Sub-Counties'] = $subcountiesCount;
                $the_data['Number of CDE\'s'] = '1';
                $the_data['Number of DEO\'s'] = $subcountiesCount*1;
                $the_data['No of SCMOH\'s'] = $subcountiesCount*1;
                $the_data['Schisto Sub-Counties'] = $schistosubcounties;

                $kilometeres_to_kemsa_depot = $budget_data['kilometeres_to_kemsa_depot'];
                $number_of_tsc_reps = $budget_data['number_of_tsc_reps'];

              } else {

                $total_number_of_county_officials = $budget_data['total_number_of_county_officials'];
                $number_of_county_officials_education = $budget_data['number_of_county_officials_education'];
                $number_of_county_officials_health = $budget_data['number_of_county_officials_health'];

              }

            } else {

              if ( $_GET['type'] == 19 ) {

                $counties_mts = $budget_data['counties_mts'];
                $dtw_staff = $budget_data['dtw_staff'];
                $government_facilitators = $budget_data['government_facilitators'];
                $total_gok_facilitations = $budget_data['total_gok_facilitations'];
                $total_dtw_staff_attendance = $budget_data['total_dtw_staff_attendance'];

              } else {

                $database->query('SELECT count(division_name) AS wardsCount FROM divisions WHERE district_name = :district_name',
                  array(
                    ':district_name'=> urldecode( $_GET['loc'] )
                  )
                );
                $wardsCount = $database->statement->fetch(PDO::FETCH_ASSOC)['wardsCount'];

                $database->query('SELECT count(school_name) AS schoolsCount FROM schools WHERE district_name = :district_name',
                  array(
                    ':district_name'=> urldecode( $_GET['loc'] )
                  )
                );
                $schoolsCount = $database->statement->fetch(PDO::FETCH_ASSOC)['schoolsCount'];

                $database->query('SELECT count(school_name) AS schistoschoolsCount FROM schools WHERE district_name = :district_name AND treatment_type = :treatment_type',
                  array(
                    ':district_name'=> urldecode( $_GET['loc'] ),
                    ':treatment_type' => 'STH/Schisto'
                  )
                );
                $schistoschoolsCount = $database->statement->fetch(PDO::FETCH_ASSOC)['schistoschoolsCount'];

                $teachersCount   = $schoolsCount*2;
                $ttsessionsCount = ceil($schoolsCount/20);
                $chewsCount      = ceil($ttsessionsCount*2);

                $the_data['Number of Wards'] = $wardsCount;
                $the_data['Total Number of Primary Schools'] = $schoolsCount;
                $the_data['Number of Teachers'] = $teachersCount;
                $the_data['Number of Teacher Training Sessions'] = $ttsessionsCount;
                $the_data['Number of CHEWS'] = $chewsCount;
                $the_data['Number of Schisto Schools'] = $schistoschoolsCount;

                $kilometeres_to_kemsa_depot =  $budget_data['kilometeres_to_kemsa_depot'];

              }

            }

            $docTitle =  $results[0]['category'].' '.$results[0]['budget_type'].' Budget for '.$_GET['loc'].' for Deworming Wave '.$deworming_wave['deworming_wave'].''; ?>   

            <?php if( $_GET['type'] == 19 ) { ?>

              <div id="budget-form-container"> 

                <h3>Master Trainers Training Budget for <?php echo $_GET['loc']; ?></h3>
                <h3>Deworming Wave:  <?php echo $deworming_wave['deworming_wave']; ?> </h3>

                <?php

                  if ( isset($_POST['save-budget-1']) ) {

                    foreach($_POST['id'] as $key => $value) {
                      $data = array(
                        'record_id'    => $_POST['record_id'][$key],
                        'unit_key_1'   => $_POST['unit_key_1'][$key],
                        'unit_value_1' => $_POST['unit_value_1'][$key],
                        'unit_key_2'   => $_POST['unit_key_2'][$key],
                        'unit_value_2' => $_POST['unit_value_2'][$key],
                        'unit_key_3'   => $_POST['unit_key_3'][$key],
                        'unit_value_3' => $_POST['unit_value_3'][$key],
                        'unit_key_4'   => $_POST['unit_key_4'][$key],
                        'unit_value_4' => $_POST['unit_value_4'][$key],
                      );

                      // Create PDF
                      $pdfmeta = array(
                        'budget_type' => 'MT Training',
                        'location' => urldecode($_GET['loc']),
                        'deworming_wave' => $deworming_wave['deworming_wave']
                      );
                      $financeClass->createMtBudgetPDF($pdfmeta);
                      $financeClass->saveMtBudget($data);
                      $financeClass->saveBudgetMeta($_POST['budget-note']);

                    }

                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Prepared Budget',
                        2 => 'Prepared '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );

                  }

                  if ( isset($_POST['edit-budget-1']) ) {
                    $editable = true;
                  }

                  if ( isset($_POST['restore-budget-1']) ) {

                    $financeClass->restoreMtBudget($_GET['loc'], $_GET['wave'], $_GET['cat'], $_GET['type']);

                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Restored Budget',
                        2 => 'Restored '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );

                  }

                  if ( isset($_POST['send-approval-1']) && $_POST['approver_id'] != '' ) {
                    $approver = $_POST['approver_id'];
                    $financeClass->pleaseApprove($docTitle, $approver);
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Sent approval request for budget',
                        2 => 'Sent approval request for '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).' to User Id:'.$approver.''
                      )
                    );
                  }

                  if ( isset($_POST['verify-budget-1']) ) {
                    $financeClass->verifyBudget();
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Verified budget',
                        2 => 'Verified '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );
                  }

                  if ( isset($_POST['reset-budget-1']) ) {
                    $financeClass->verifyBudget(1);
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Reset budget',
                        2 => 'Reset '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );
                  }

                  $doc_title = 'budget_mt_training_'. str_replace(' ', '_', strtolower(urldecode($_GET['loc']) ) ).'_'. str_replace(' ', '_', strtolower($deworming_wave['deworming_wave'] ) );


                ?>

                <ul class="nav nav-tabs">
                  <li><a href="#tab-1" data-toggle="tab"><?php echo urldecode($_GET['loc']); ?> Data</a></li>
                  <li class="active"><a href="#tab-2" data-toggle="tab"><?php echo urldecode($_GET['loc']); ?> Budget</a></li>
                </ul>

                <div class="tab-content">

                  <div class="tab-pane fade" id="tab-1">

                    <?php 

                      if (isset($_POST['save_this_data'])) {

                        if (!empty($_POST)) {

                          unset($_POST['save_this_data']);
                          $savebudgetData = serialize($_POST);

                          $database->query('UPDATE fin_budget_meta SET budget_data = :budget_data WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                            array(
                              ':budget_data'  => $savebudgetData,
                              ':location'     => urldecode($_GET['loc']), 
                              ':wave'         => $_GET['wave'], 
                              ':budget_cat'   => $_GET['cat'], 
                              ':budget_type'  => $_GET['type']
                            )
                          );
                          $updated = $database->statement->rowCount();

                          if ($updated < 1 ) {
                            $database->query('INSERT INTO fin_budget_meta (budget_data,location,wave,budget_cat,budget_type) VALUES (:budget_data,:location,:wave,:budget_cat,:budget_type)',
                              array(
                                ':budget_data'  => $savebudgetData,
                                ':location'     => urlencode($_GET['loc']), 
                                ':wave'         => $_GET['wave'], 
                                ':budget_cat'   => $_GET['cat'], 
                                ':budget_type'  => $_GET['type']
                              )
                            );
                          }
                        }
                        // Enter Action Log
                        quickFuncLog(
                          $ArrayData = array(
                            0 => 4,
                            1 => 'Updated budget assumptions',
                            2 => 'Updated  '.$results[0]['budget_type'].' Budget Assumptions for '.urldecode($_GET['loc']).''
                          )
                        );
                        header('Location:'.basename($_SERVER['REQUEST_URI']));
                      } 

                    ?>

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Variable</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        <form method="post" action="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
                          <tr>
                            <td>Counties MTs</td>
                            <td>
                              <input type="text" name="counties_mts" value="<?php if ( isset( $counties_mts ) ) { echo $counties_mts; } ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td>DtW staff (in residence)</td>
                            <td>
                              <input type="text" name="dtw_staff" value="<?php if ( isset( $dtw_staff ) ) { echo $dtw_staff; } ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td>Government Facilitators</td>
                            <td>
                              <input type="text" name="government_facilitators" value="<?php if ( isset( $government_facilitators ) ) { echo $government_facilitators; } ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td>Total GoK Facilitations</td>
                            <td>
                              <input type="text" name="total_gok_facilitations" value="<?php if ( isset( $total_gok_facilitations ) ) { echo $total_gok_facilitations; } ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td>Total DtW Staff Attendance</td>
                            <td>
                              <input type="text" name="total_dtw_staff_attendance" value="<?php if ( isset( $total_dtw_staff_attendance ) ) { echo $total_dtw_staff_attendance; } ?>" />
                            </td>
                          </tr>
                          <tr>
                            <td></td><td><button class="btn btn-primary" type="submit" name="save_this_data" >Save</button></td>
                          </tr>
                        </form>
                      </tbody>
                    </table>              

                  </div>

                  <div class="tab-pane fade active" id="tab-2">

                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                      <div class="clearfix">

                        <h3 class="pull-left"><?php if (!empty($budget_meta['verified_by'])) { ?> <span class="label label-success">Verified</span> <?php } ?></h3>

                        <ul class="list-unstyled pull-right clearix">
                            <?php if ( $budget_total > 0 ) {
                              if (in_array($_SESSION['staff_id'], $approverArray)) {
                                if (empty($budget_meta['verified_by'])) { ?> 
                                  <li class="pull-left"><button type="submit" class="btn btn-success" name="verify-budget-1" <?php //if ( $editable != true  ) { echo 'disabled'; } ?> >Verify Budget</button></li>
                                <?php } else { ?>
                                  <li class="pull-left"><button type="submit" class="btn btn-warning" name="reset-budget-1" <?php //if ( $editable != true  ) { echo 'disabled'; } ?> >Reset Budget</button></li>
                                <?php } 
                              }
                            } ?>
                            <li class="pull-left">&nbsp;</li>                          
                            <?php if($prevs['priv_district_budget'] >= 3) { ?>
                              <?php if ( $budget_saved == true ) { ?>
                                <li class="pull-left">
                                  <?php if ($budget_meta['approval_notice'] == 1) { ?> 
                                    <button type="button" class="btn btn-primary" >Approval Notification Sent</button> 
                                  <?php } else { ?> 
                                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                                        <select name="approver_id">
                                          <option value="">Select Budget Approver</option>
                                          <?php foreach ($budget_approvers as $key => $budget_approver) { ?>
                                            <option value="<?php echo $budget_approver['staff_id']; ?>"><?php echo $budget_approver['staff_name']; ?></option>
                                          <?php } ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm" name="send-approval-1" <?php if ( $editable ) { echo 'disabled'; } ?> > Send Approval Request</button>
                                    </form>                                  
                                  <?php } ?> 
                                </li>
                                <li class="pull-left">&nbsp;</li>  
                              <?php } ?>        
                              <?php if ( $budget_saved == false ) { ?>
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="edit-budget-1" <?php if ( $editable ) { echo 'disabled'; } ?> >Edit Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="save-budget-1" <?php if ( $editable != true  ) { echo 'disabled'; } ?> >Save Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                              <?php } else { ?> 
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="restore-budget-1" ?> Restore Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                              <?php } ?>
                            <?php } ?>
                            <?php if ( $budget_saved == true ) { ?>
                              <li class="pull-left">
                                <a href="pdf_budget_forms/<?php echo $doc_title; ?>.pdf" target="blank" class="btn btn-primary <?php if($editable == true) { echo 'disabled';} ?>"  >Export PDF</a>
                              </li>
                            <?php } ?>
                          <li class="pull-left">&nbsp;</li>
                        </ul>             

                      </div> 

                      <br>  

                      <div class="table-responsive">

                        <table id="budget-table" class="table table-bordered table-condensed" cellpadding="10">
                          <thead>
                            <tr>
                              <th width="200px"><small>Item Description</small></th>
                              <th><small>Unit #</small></th>
                              <th><small>Unit type</small></th>
                              <th><small>Unit #</small></th>
                              <th><small>Unit Type</small></th>
                              <th><small>Unit #</small></th>
                              <th><small>Unit Type</small></th>
                              <th><small>Unit #</small></th>
                              <th><small>Unit Type</small></th>
                              <th><small>Unit Cost (Ksh)</small></th>
                              <th width="100px"><small>Total Cost (Ksh)</small></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $total_array = array(); foreach ($new_results as $key => $new_result) { ?>
                              <tr>
                                <td colspan="11"><small><b><?php echo $key;?></b></small></td>
                              </tr>
                              <?php $sub_total_array = array(); foreach ($new_result as $key => $value) { 

                                if ( $value['unit_cost']    == '' || $value['unit_cost'] == 'NULL' )    { $unit_cost    = 1; } else { $unit_cost    = $value['unit_cost']; }
                                if ( $value['unit_value_1'] == '' || $value['unit_value_1'] == 'NULL' ) { $unit_value_1 = 1; } else { $unit_value_1 = $value['unit_value_1']; }
                                if ( $value['unit_value_2'] == '' || $value['unit_value_2'] == 'NULL' ) { $unit_value_2 = 1; } else { $unit_value_2 = $value['unit_value_2']; }
                                if ( $value['unit_value_3'] == '' || $value['unit_value_3'] == 'NULL' ) { $unit_value_3 = 1; } else { $unit_value_3 = $value['unit_value_3']; }
                                if ( $value['unit_value_4'] == '' || $value['unit_value_4'] == 'NULL' ) { $unit_value_4 = 1; } else { $unit_value_4 = $value['unit_value_4']; }
                                
                                $row_total = $unit_cost*$unit_value_1*$unit_value_2*$unit_value_3*$unit_value_4;
                                array_push($sub_total_array, $row_total);

                                ?>
                                <input type="hidden" name="id[]" value="<?php echo $value['id']; ?>">
                                <input type="hidden" name="record_id[]" value="<?php echo $value['record_id']; ?>">
                                <tr>
                                  <td><?php echo $value['item_desc']; ?></td>
                                  <td><?php echo $value['unit_cost']; ?></td>
                                  <td><input type="text" name="unit_key_1[]"   value="<?php echo $value['unit_key_1']; ?>"   style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_value_1[]" value="<?php echo $value['unit_value_1']; ?>" style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_key_2[]"   value="<?php echo $value['unit_key_2']; ?>"   style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_value_2[]" value="<?php echo $value['unit_value_2']; ?>" style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_key_3[]"   value="<?php echo $value['unit_key_3']; ?>"   style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_value_3[]" value="<?php echo $value['unit_value_3']; ?>" style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_key_4[]"   value="<?php echo $value['unit_key_4']; ?>"   style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td><input type="text" name="unit_value_4[]" value="<?php echo $value['unit_value_4']; ?>" style="width:100%;" <?php if ( $editable != true ) { echo 'readonly'; } ?> /></td>
                                  <td align="right"><b><?php echo number_format($row_total); ?></b></td>
                                </tr>
                              <?php } ?>
                              <tr>
                                <td><small><em>Sub-Total</em></small></td>
                                <td colspan="9">&nbsp;</td>
                                <td><b> 
                                    <?php 
                                      $sub_total = array_sum($sub_total_array); 
                                      echo number_format($sub_total);
                                      array_push($total_array, $sub_total); 
                                    ?>
                                    </b>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="11">&nbsp;</td>
                              </tr>
                            <?php } ?>
                          </tbody>
                          <tfoot>
                              <tr>
                                <td><small><b>TOTAL</b></small></td>
                                <td colspan="9">&nbsp;</td>
                                <td><b><?php echo $total = number_format( array_sum($total_array) ); ?></b></td>
                              </tr>
                              <tr>
                                <td><small>Cost  per master trainer (Incidentals, Accomodation, Conference and Transport)</small></td>
                                <td colspan="9">&nbsp;</td>
                                <td><b><?php echo number_format($cost_per_mt); ?></b></td>
                              </tr>
                              <tr>
                                <td colspan="11">&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="11"><b>Notes:</b></td>
                              </tr>
                              <tr>
                                <td colspan="11"><textarea name="budget-note" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php echo $budget_note; ?></textarea></td>
                              </tr>
                          </tfoot>
                        </table>

                      </div> 

                    </form>                   
                    
                  </div>

                </div>

              </div>

            <?php } else { ?>

              <div id="budget-form-container"> 

                <h3><?php if ( $_REQUEST['cat'] != 1 ) { echo $results[0]['category']; } echo ' '.$results[0]['budget_type']; ?> Budget for <?php echo $_GET['loc']; ?></h3>
                <h3>Deworming Wave:  <?php echo $deworming_wave['deworming_wave']; ?> </h3>

                <?php

                  if ( isset($_POST['save-budget-1'])  || isset($_POST['update-ttsessions']) || $_POST['update-distance'] ) {

                    // Create PDF
                    $c = count($results); $pdfdata = array();
                    for ($i=0; $i < $c; $i++) {

                        if(!empty($_POST['unique_item_desc'][$i])) {
                          $item_description = $_POST['unique_item_desc'][$i];
                        } else {
                          $item_description = $results[$i]['item_desc'];
                        }

                        if (empty($results[$i]['acc_form'])) {
                          $accountability_form = $_POST['unique_acc_form'][$i];
                        } else {
                          $accountability_form = $results[$i]['acc_form'];
                        }

                        if (!empty($_POST['unique_recepient'][$i])) {
                          $recepient = $_POST['unique_recepient'][$i];
                        } else {
                          $recepient = $results[$i]['recepient'];
                        }

                        if (!empty($_POST['unique_accounting'][$i])) {
                          $accounting = $_POST['unique_accounting'][$i];
                        } else {
                          $accounting = $results[$i]['accounting'];
                        }

                        if (empty($results[$i]['forms_recepients'])) {
                          $forms_recepients = $_POST['unique_forms_recepients'][$i];
                        } else {
                          $forms_recepients = $results[$i]['forms_recepients'];
                        }
                      array_push($pdfdata, array(
                          'item_description' => $item_description,
                          'accountability_form' => $accountability_form,
                          'units' => $_POST['units'][$i],
                          'days' => $_POST['days'][$i],
                          'ttsessions' => $_POST['ttsessions'][$i],
                          'distance' => $_POST['distance'][$i],
                          'unit_cost' => $_POST['unit_cost'][$i],
                          'total' => $_POST['total'][$i],
                          'recepient' => $recepient,
                          'description' => $results[$i]['unit_description'],
                          'accounting' => $accounting,
                          'receipts' => $forms_recepients
                        )
                      );
                    } 

                    $the_budget_total;
                    foreach ($pdfdata as $key => $pdfdatum) {
                      $the_budget_total = $the_budget_total + $pdfdatum['total'];
                    }

                    $pdfmeta = array(
                      'doc_title' => $docTitle,
                      'location' => urldecode($_GET['loc']),
                      'deworming_wave' => $deworming_wave['deworming_wave'],
                      'budget_type' => $results[0]['budget_type'],
                      'budget_cat' => $results[0]['category'],
                      'budget_total' => $the_budget_total,
                      'budget_note' => $budget_meta['budget_note'],
                      'budget_forms_receipts' => $results[0]['budget_forms_receipts']
                    );
                    $financeClass->createBudgetPDF($pdfmeta, $pdfdata); 

                    // Create Reconcilliation return
                    $reconmeta = array(
                      'budget_type' => $results[0]['budget_type'],
                      'budget_cat' => $results[0]['category'],
                      'location' => urldecode($_GET['loc']),
                      'dewormin_wave' => $deworming_wave['deworming_wave'],
                      'budget_total' => $budget_total
                    );

                    $recondata = array();
                    foreach($_POST['id'] as $key => $value) {
                      $Variance = '';
                      array_push($recondata, array(
                          'recepient' => $_POST['recepient'][$key],
                          'advanced' => $_POST['total'][$key],
                          'spent' => '',
                          'variance' => ''
                        )
                      );
                    }
                    $financeClass->createreconPDF($reconmeta, $recondata);

                    foreach($_POST['id'] as $key => $value) {

                      $item = $key;
                      if ( isset($_POST['update-ttsessions']) ) {
                        if ($_POST['ttsessions'][$item] != 1 ) { $TTsessions = $_POST['update-ttsessions']; } else {$TTsessions = 1 ; }
                      } else { $TTsessions = $_POST['ttsessions'][$item]; }
                      if ( isset($_POST['update-distance']) ) {
                        if ($_POST['distance'][$item] != 1 ) { $distance = $_POST['update-distance']; } else {$distance = 1 ; }
                      } else { $distance = $_POST['distance'][$item]; }

                      $data = array(
                        'record_id'        => $value, 
                        'loc'              => urldecode($_REQUEST['loc']),
                        'wave'             => $_REQUEST['wave'],
                        'budget_cat'       => $_REQUEST['cat'],
                        'budget_type'      => $_REQUEST['type'],
                        'item_desc'        => $_POST['unique_item_desc'][$item],
                        'acc_form'         => $_POST['unique_acc_form'][$item], 
                        'units'            => $_POST['units'][$item], 
                        'days'             => $_POST['days'][$item], 
                        'ttsessions'       => $TTsessions,
                        'distance'         => $distance, 
                        'unit_cost'        => $_POST['unit_cost'][$item],
                        'total'            => $_POST['total'][$item],
                        'unit_description' => $_POST['unit_description'][$item],
                        'recepient'        => $_POST['unique_recepient'][$item],
                        'accounting'       => $_POST['unique_accounting'][$item],
                        'forms_recepients' => $_POST['unique_forms_recepients'][$item]
                      );

                      if ($_REQUEST['cat'] == 1) {
                        $financeClass->saveCountyBudget($data);
                      } else {
                        $financeClass->saveBudget($data);
                      }
                      $financeClass->saveBudgetMeta($_POST['budget-note']);

                    }

                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Prepared Budget',
                        2 => 'Prepared '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );

                  }

                  if ( isset($_POST['edit-budget-1']) ) {
                    $editable = true;
                  }

                  if ( isset($_POST['restore-budget-1']) ) {
                    if ( $_GET['cat']==1 ) { 
                      $financeClass->restoreCountyBudget($_GET['loc'], $_GET['wave'], $_GET['cat'], $_GET['type']);
                    } else {
                      $financeClass->restoreBudget($_GET['loc'], $_GET['wave'], $_GET['cat'], $_GET['type']);                    
                    }   

                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Restored Budget',
                        2 => 'Restored '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );

                  }

                  if ( isset($_POST['send-approval-1']) && $_POST['approver_id'] != '' ) {
                    $approver = $_POST['approver_id'];
                    $financeClass->pleaseApprove($docTitle, $approver);
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Sent approval request for budget',
                        2 => 'Sent approval request for '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).' to User Id:'.$approver.''
                      )
                    );
                  }

                  if ( isset($_POST['verify-budget-1']) ) {
                    $financeClass->verifyBudget();
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Verified budget',
                        2 => 'Verified '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );
                  }

                  if ( isset($_POST['reset-budget-1']) ) {
                    $financeClass->verifyBudget(1);
                    // Enter Action Log
                    quickFuncLog(
                      $ArrayData = array(
                        0 => 4,
                        1 => 'Reset budget',
                        2 => 'Reset '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                      )
                    );
                  }

                ?>

                <ul class="nav nav-tabs">
                  <li><a href="#tab-1" data-toggle="tab"><?php echo urldecode($_GET['loc']); ?> Data</a></li>
                  <li class="active"><a href="#tab-2" data-toggle="tab"><?php echo urldecode($_GET['loc']); ?> Budget</a></li>
                </ul>

                <div class="tab-content">

                  <div class="tab-pane fade" id="tab-1">

                    <?php 

                      if (isset($_POST['save_this_data'])) {

                        if (!empty($_POST)) {

                          unset($_POST['save_this_data']);
                          $savebudgetData = serialize($_POST);

                          $database->query('UPDATE fin_budget_meta SET budget_data = :budget_data WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                            array(
                              ':budget_data'  => $savebudgetData,
                              ':location'     => urldecode($_GET['loc']), 
                              ':wave'         => $_GET['wave'], 
                              ':budget_cat'   => $_GET['cat'], 
                              ':budget_type'  => $_GET['type']
                            )
                          );
                          $updated = $database->statement->rowCount();

                          if ($updated < 1 ) {
                            $database->query('INSERT INTO fin_budget_meta (budget_data,location,wave,budget_cat,budget_type) VALUES (:budget_data,:location,:wave,:budget_cat,:budget_type)',
                              array(
                                ':budget_data'  => $savebudgetData,
                                ':location'     => urlencode($_GET['loc']), 
                                ':wave'         => $_GET['wave'], 
                                ':budget_cat'   => $_GET['cat'], 
                                ':budget_type'  => $_GET['type']
                              )
                            );
                          }
                        }
                        // Enter Action Log
                        quickFuncLog(
                          $ArrayData = array(
                            0 => 4,
                            1 => 'Updated budget assumptions',
                            2 => 'Updated  '.$results[0]['budget_type'].' Budget Assumptions for '.urldecode($_GET['loc']).''
                          )
                        );
                        header('Location:'.basename($_SERVER['REQUEST_URI']));
                      } 

                    ?>

                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Variable</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        <form method="post" action="<?php echo basename($_SERVER['REQUEST_URI']); ?>">
                          <?php
                            if ( $_GET['cat']==1 ) {

                              if ( $_GET['type']==7 || $_GET['type']==8 || $_GET['type']==9 || $_GET['type'] ==10 ) {

                                foreach ($the_data as $key => $value) {
                                  echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
                                } ?>
                                <tr>
                                  <td>Distance to Materials picking point (Kms)</td>
                                  <td>
                                    <input type="text" name="kilometeres_to_kemsa_depot" value="<?php if ( isset( $kilometeres_to_kemsa_depot ) ) { echo $kilometeres_to_kemsa_depot; } ?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td>Number of TSC Reps</td>
                                  <td>
                                    <input type="text" name="number_of_tsc_reps" value="<?php if ( isset( $number_of_tsc_reps ) ) { echo $number_of_tsc_reps; } ?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td></td><td><button class="btn btn-primary" type="submit" name="save_this_data" >Save</button></td>
                                </tr>

                              <?php } else {  ?>

                                <tr>
                                  <td>Total Number of County Officials</td>
                                  <td>
                                    <input type="text" name="total_number_of_county_officials" value="<?php if ( isset( $total_number_of_county_officials ) ) { echo $total_number_of_county_officials; } ?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td>Number of County Officials -Education</td>
                                  <td>
                                    <input type="text" name="number_of_county_officials_education" value="<?php if ( isset( $number_of_county_officials_education ) ) { echo $number_of_county_officials_education; } ?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td>Number of County Officials - Health</td>
                                  <td>
                                    <input type="text" name="number_of_county_officials_health" value="<?php if ( isset( $number_of_county_officials_health ) ) { echo $number_of_county_officials_health; } ?>" />
                                  </td>
                                </tr>
                                <tr>
                                  <td></td><td><button class="btn btn-primary" type="submit" name="save_this_data" >Save</button></td>
                                </tr>

                              <?php }

                            } else {

                              foreach ($the_data as $key => $value) {
                                echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
                              } ?>
                              <tr>
                                <td>Kilometeres To Kemsa Depot</td>
                                <td>
                                  <input type="text" name="kilometeres_to_kemsa_depot" value="<?php if ( isset( $kilometeres_to_kemsa_depot ) ) { echo $kilometeres_to_kemsa_depot; } ?>" />
                                </td>
                              </tr>
                              <tr>
                                <td></td><td><button class="btn btn-primary" type="submit" name="save_this_data" >Save</button></td>
                              </tr>

                            <?php } ?>
                        </form>
                      </tbody>
                    </table>              

                  </div>

                  <div class="tab-pane fade active" id="tab-2">

                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                      <div class="clearfix">

                        <h3 class="pull-left">Budget Total : <?php echo number_format($budget_total);  if (!empty($budget_meta['verified_by'])) { ?> <span class="label label-success">Verified</span> <?php } ?></h3>

                        <ul class="list-unstyled pull-right clearix">
                            <?php if ( $budget_total > 0 ) {
                              if (in_array($_SESSION['staff_id'], $approverArray)) {
                                if (empty($budget_meta['verified_by'])) { ?> 
                                  <li class="pull-left"><button type="submit" class="btn btn-success" name="verify-budget-1" <?php //if ( $editable != true  ) { echo 'disabled'; } ?> >Verify Budget</button></li>
                                <?php } else { ?>
                                  <li class="pull-left"><button type="submit" class="btn btn-warning" name="reset-budget-1" <?php //if ( $editable != true  ) { echo 'disabled'; } ?> >Reset Budget</button></li>
                                <?php } 
                              }
                            } ?>
                            <li class="pull-left">&nbsp;</li>                          
                            <?php if($prevs['priv_district_budget'] >= 3) { ?>
                              <?php if ( $budget_total > 0 ) { ?>
                                <li class="pull-left">
                                  <?php if ($budget_meta['approval_notice'] == 1) { ?> 
                                    <button type="button" class="btn btn-primary" >Approval Notification Sent</button> 
                                  <?php } else { ?> 
                                    <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">
                                        <select name="approver_id">
                                          <option value="">Select Budget Approver</option>
                                          <?php foreach ($budget_approvers as $key => $budget_approver) { ?>
                                            <option value="<?php echo $budget_approver['staff_id']; ?>"><?php echo $budget_approver['staff_name']; ?></option>
                                          <?php } ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm" name="send-approval-1" <?php if ( $editable ) { echo 'disabled'; } ?> > Send Approval Request</button>
                                    </form>                                  
                                  <?php } ?> 
                                </li>
                                <li class="pull-left">&nbsp;</li>  
                              <?php } ?>        
                              <?php if ( $budget_saved == false ) { ?>
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="edit-budget-1" <?php if ( $editable ) { echo 'disabled'; } ?> >Edit Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="save-budget-1" <?php if ( $editable != true  ) { echo 'disabled'; } ?> >Save Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                              <?php } else { ?> 
                                <li class="pull-left"><button type="submit" class="btn btn-primary" name="restore-budget-1" ?> Restore Budget</button></li>
                                <li class="pull-left">&nbsp;</li>
                              <?php } ?>        
                              <?php //if ( $_REQUEST['cat'] == 4 ) { ?>
                              <!--<li class="pull-left"><sup>#</sup>TTSessions = &nbsp;<input type="text" value="<?php // echo $results[3]['ttsessions']; ?>" name="update-ttsessions" size="2" <?php // if ( $editable != true  ) { echo 'disabled'; } ?> />&nbsp;<button type="submit" class="btn btn-primary" name="ttsession-update" <?php // if ( $editable != true  ) { echo 'disabled'; } ?> >Update TTsessions</button></li>
                              <li class="pull-left">&nbsp;</li>-->
                              <?php //} ?>
                              <?php // if ( $_REQUEST['type'] == 9 || $_REQUEST['type'] == 10 ) { ?>
                              <!-- <li class="pull-left">Distance = &nbsp;<input type="text" value="<?php // echo $results[3]['distance']; ?>" name="update-distance" size="2" <?php // if ( $editable != true  ) { echo 'disabled'; } ?> />&nbsp;<button type="submit" class="btn btn-primary" name="distance-update" <?php // if ( $editable != true  ) { echo 'disabled'; } ?> >Update Distance</button></li> -->
                              <!-- <li class="pull-left">&nbsp;</li> -->
                              <?php // } ?>
                            <?php } ?>
                            <?php if ( $budget_total > 0 ) {
                                if ($_GET['cat']==1) {
                                  $doc_title = 'budget_'.str_replace(' ', '_', strtolower( $results[0]['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($_GET['loc'] ) ).'_'. str_replace(' ', '_', strtolower($deworming_wave['deworming_wave'] ) );
                                } else {
                                  $doc_title = 'budget_'.str_replace(' ', '_', strtolower( $results[0]['category'] ) ).'_'.str_replace(' ', '_', strtolower( $results[0]['budget_type'] ) ).'_'. str_replace(' ', '_', strtolower($_GET['loc'] ) ).'_'. str_replace(' ', '_', strtolower($deworming_wave['deworming_wave']) );
                                } ?>
                              <li class="pull-left">
                                <a href="pdf_budget_forms/<?php echo $doc_title; ?>.pdf" target="blank" class="btn btn-primary <?php if($editable == true) { echo 'disabled';} ?>"  >Export PDF</a>
                              </li>
                            <?php } ?>
                          <li class="pull-left">&nbsp;</li>
                        </ul>             

                      </div> 

                      <br>  

                      <div class="table-responsive">

                        <table id="budget-table" class="table table-bordered table-condensed">
                          <thead>
                            <tr>
                              <th class="hidden" ></th>
                              <th class="hidden" ></th>
                              <?php if ($_GET['cat'] != 1) { ?>
                                <th>Item Category</th>
                              <?php } ?>
                              <th>Item Description</th>
                              <th>Accountability Form</th>
                              <th class="units">P<sub/>a&#x25;</sub><br>/Units</th>
                              <th class="days">Days</th>
                              <?php if ( $_GET['cat'] == 4 ) { ?> <th class="ttsessions">TT<br>Sessions</th> <?php } ?>
                              <?php if ( $_GET['type'] == 9 || $_GET['type'] == 10) { ?> <th class="ttsessions">Distance</th><?php } ?>
                              <th class="unit_cost">Unit<br>Cost</th>
                              <th class="total">Total</th>
                              <th>Recepient</th>
                              <th>Description</th>
                              <th>Accounting </th>
                              <?php if ( $_GET['type'] != 16 && $_GET['type'] != 17 ) { ?> <th>Forms/Receipts</th> <?php } ?>
                            </tr>
                          </thead>  
                          <tbody>
                            <?php
                              $budget_total = 0;
                              $i=0;

                              foreach ($results as $key => $value) {

                                if (is_numeric($value['units'])) {
                                  $units = $value['units'];                                
                                } else {
                                  $units = @eval("return ${value['units']};" );
                                }

                                if (is_numeric($value['days'])) {
                                  $days = $value['days'];                                
                                } else {
                                  $days = @eval("return ${value['days']};" );
                                }

                                if (is_numeric($value['ttsessions'])) {
                                  $ttsessions = $value['ttsessions'];                                
                                } else {
                                  $ttsessions = @eval("return ${value['ttsessions']};" );
                                }

                                if (is_numeric($value['distance'])) {
                                  $distance = $value['distance'];                                
                                } else {
                                  $distance = @eval("return ${value['distance']};" );
                                }

                                if (is_numeric($value['unit_cost'])) {
                                  $unit_cost = $value['unit_cost'];                                
                                } else {
                                  $unit_cost = @eval("return ${value['unit_cost']};" );
                                }
                                $total = @eval("return ${value['total']};" );
                                $budget_total += $total;
                            ?>
                            <tr>
                              <td class="hidden"><input type="hidden" name="id[]" value="<?php echo $value['id']; ?>" class="num-only"/></td>
                              <td class="hidden"><input type="hidden" name="recepient[]" value="<?php echo $value['recepient']; ?>"/></td>
                              <?php if ($_GET['cat'] != 1) { ?>
                                <td rowspan="1" ><p class="text-vertical"><?php echo $value['item_cat']; ?></p></td>
                              <?php } ?>
                              <td>
                                <?php if (!empty($value['unique_item_desc'])) { ?>
                                  <input type="text" name="unique_item_desc[<?php echo $i; ?>]" value="<?php echo $value['unique_item_desc']; ?>" <?php if ( $editable != true ) { echo 'readonly'; } ?> />
                                <?php } else { ?>
                                  <input type="text" name="unique_item_desc[<?php echo $i; ?>]" value="<?php echo $value['item_desc']; ?>" <?php if ( $editable != true ) { echo 'readonly'; } ?> />
                                <?php } ?>
                              </td>
                              <td><b>
                                <?php if (empty($value['acc_form'])) { ?> 
                                  <input type="text" name="unique_acc_form[<?php echo $i; ?>]" value="<?php echo $value['unique_acc_form']; ?>" <?php if ( $editable != true ) { echo 'readonly'; } ?> />
                                <?php } else {
                                    echo $value['acc_form'];
                                } ?>
                              </b></td>
                              <td class="units">
                                <input type="text" name="units[]" value="<?php echo $units; ?>" class="num-only" <?php if ( $editable != true || !is_numeric($value['units']) ) { echo 'readonly'; } ?> />
                              </td>
                              <td class="days">
                                <input type="text" name="days[]" value="<?php echo $days; ?>" class="num-only" <?php if ( $editable != true || !is_numeric($value['days']) ) { echo 'readonly'; } ?> />
                              </td>
                              <td class="ttsessions<?php if ( $_GET['cat'] != 4 ) { ?> hidden<?php } ?>">
                                <input type="text" name="ttsessions[]" value="<?php echo $ttsessions; ?>" class="num-only" <?php if ( $editable != true || !is_numeric($value['ttsessions']) ) { echo 'readonly'; } ?> />
                              </td>
                              <td class="distance<?php if ( $_GET['type'] != 9 && $_GET['type'] != 10 ) { ?> hidden <?php } ?>">
                                <input type="text" name="distance[]" value="<?php echo $distance; ?>" class="num-only" <?php if ( $editable != true || !is_numeric($value['distance']) ) { echo 'readonly'; } ?>/>
                              </td>
                              <td class="unit_cost">
                                <input type="text" name="unit_cost[]"  value="<?php echo $unit_cost; ?>" class="num-only" <?php if ( $editable != true || !is_numeric($value['unit_cost']) ) { echo 'readonly'; } ?> />
                              </td>
                              <td class="total">
                                <input type="text" name="total[]" value="<?php echo $total; ?>" class="num-only" readonly />
                              </td>
                              <td>
                                <?php if (!empty($value['unique_recepient'])) { ?>
                                  <input type="text" name="unique_recepient[<?php echo $i; ?>]"  value="<?php echo $value['unique_recepient']; ?>" <?php if ( $editable != true ) { echo 'readonly'; } ?> />
                                <?php } else { ?>
                                  <input type="text" name="unique_recepient[<?php echo $i; ?>]"  value="<?php echo $value['recepient']; ?>" <?php if ( $editable != true ) { echo 'readonly'; } ?> />
                                <?php } ?>
                              </td>
                              <td>
                                  <textarea name="unit_description[]" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php echo $value['unit_description']; ?></textarea>
                              </td>
                              <td>
                                <?php if (!empty($value['unique_accounting'])) { ?>
                                  <textarea name="unique_accounting[<?php echo $i; ?>]" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php echo $value['unique_accounting']; ?></textarea>
                                <?php } else { ?>
                                  <textarea name="unique_accounting[<?php echo $i; ?>]" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php echo $value['accounting']; ?></textarea>
                                <?php }?>
                              </td>
                              <?php if ( $_GET['type'] != 16 && $_GET['type'] != 17 ) { ?> 
                                <td>
                                  <?php if (empty($value['forms_recepients'])) { ?>
                                    <textarea name="unique_forms_recepients[<?php echo $i; ?>]" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php echo $value['unique_forms_recepients']; ?></textarea>
                                  <?php } else {
                                    echo $value['forms_recepients']; 
                                  }?>
                                </td> 
                              <?php } ?>
                            </tr> 
                            <?php $i++;} ?>
                          </tbody> 
                          <tfoot>
                            <tr>
                                <?php if ($_GET['cat'] != 1) { ?>
                                  <th>&nbsp;</th>
                                <?php } ?>
                                <th colspan="<?php if( $_GET['cat'] == 4 || $_GET['type'] == 9 || $_GET['type'] == 10 ) { echo "6"; } else { echo "5"; } ?>" class="budget-total"> Budget Total</th>
                                <th class="budget-total"> <?php echo number_format($budget_total); ?> </th>
                                <th colspan="3"><textarea rows="7" name="budget-note" placeholder="Budget Note:" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php if (!empty($budget_meta['budget_note'])) {echo $budget_meta['budget_note'];} ?></textarea></th>
                                <?php if ( $_GET['type'] != 16 && $_GET['type'] != 17 ) { ?> <td><?php echo $results[0]['budget_forms_receipts']; ?></td>  <?php } ?>
                            </tr>                      
                          </tfoot>       
                        </table>

                      </div> 

                    </form>                   
                    
                  </div>

                </div>

              </div>

            <?php } ?>

          <?php } else if ($view == 'budget-form') {

            $formtype = $_REQUEST['form-type'];

            switch ($formtype) {
              case 'recon':
                echo '<h2>Reconcilliation Return Forms</h2>';
                break;
              case 'cheque':
                echo '<h2>Cheque Request Forms</h2>';
                break;              
              default:
                echo '<h2>Imprest Request Forms</h2>';
                break;
            }

            $database->query('SELECT 
              district AS location,
              wave,
              budget_cat,
              budget_type, 
              SUM(total) AS budget_total 
              FROM fin_budget_cat_districts
              GROUP BY location,wave,budget_cat,budget_type HAVING SUM(total) != 0') ;
            $count1 = $database->count();
            $results1 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $database->query('SELECT 
              county AS location,
              wave,
              budget_cat,
              budget_type, 
              SUM(total) AS budget_total 
              FROM fin_budget_cat_county
              GROUP BY location,wave,budget_cat,budget_type HAVING SUM(total) != 0') ;
            $count2 = $database->count();
            $results2 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            if ( $count1 != 0 || $count2 != 0 ) {

               $results = array_merge($results1, $results2);

              //$results = $database->statement->fetchall(PDO::FETCH_ASSOC); ?>

              <table class="table table-bordered form-list-table table-hover" id="data-table">

                <thead>
                  <tr>
                    <th>Budget Category</th>
                    <th>Budget Type</th>
                    <th>Location</th>
                    <th>Deworming Wave</th>
                  </tr>
                </thead>

                <tbody>

                  <?php  

                    foreach ($results as $key => $value) {

                      $href = 'index.php?view=budget-form-single&form-type='.$_REQUEST['form-type'].'&budget-cat='.$value['budget_cat'].'&budget-total='.$value['budget_total'].'&wave='.$value['wave'].'&budget-type='.$value['budget_type'].'&loc='.urlencode($value['location']).'';

                      $database->query('SELECT budget_type FROM fin_budget_type WHERE id = :id', array(
                        ':id' => $value['budget_type']
                        )
                      ) ;
                      $budget_type = $database->statement->fetch(PDO::FETCH_ASSOC);             

                      $database->query('SELECT category FROM fin_budget_category WHERE id = :id', array(
                        ':id' => $value['budget_cat']
                        )
                      ) ;
                      $budget_cat = $database->statement->fetch(PDO::FETCH_ASSOC);

                      $database->query('SELECT deworming_wave FROM deworming_waves WHERE id = :id', array(
                        ':id' => $value['wave']
                        )
                      ) ;
                      $deworming_wave = $database->statement->fetch(PDO::FETCH_ASSOC);

                    ?>

                    <tr>
                      <td><a href="<?php echo $href;?>"><?php echo $budget_cat['category'] .' Budget'; ?></a></td>
                      <td><a href="<?php echo $href;?>"><?php echo $budget_type['budget_type']; ?></a></td>
                      <td><a href="<?php echo $href;?>"><?php echo $value['location']; ?></a></td>
                      <td><a href="<?php echo $href;?>"><?php echo $deworming_wave['deworming_wave']; ?></a></td>
                    </tr>
                      
                  <?php } ?>

                </tbody>

              </table>

            <?php } else { ?>

              <div class="alert alert-block">
                <strong>Note!</strong> Each Budget Must have been prepared In Order To View their respective Imprest Request, Cheque Request and Reconcilliation Returns Forms
              </div>

            <?php } ?>

          <?php } else if ($view == 'budget-form-single') {

            $formtype = $_REQUEST['form-type'];

            if ($_REQUEST['budget-cat']==1) {
              $database->query('SELECT
                  fin_budget_cat_county.record_id AS id,
                  fin_budget_cat_county.budget_cat,
                  fin_budget_cat_county.budget_type,
                  fin_budget_cat_county.total,
                  fin_budget_cat_county.item_desc AS unique_item_desc,
                  fin_budget_cat_county.recepient AS unique_recepient,
                  fin_budget_cat_county.total_spent,
                  fin_budget_category.category AS budget_category,
                  fin_budget_type.budget_type AS budget_type,
                  fin_budget_meta.prepared_by,
                  (
                    SELECT fin_budget_item_cat.item_cat 
                    FROM fin_budget_jnk_budget_type_item_cat JOIN fin_budget_item_cat ON fin_budget_jnk_budget_type_item_cat.fk_item_cat = fin_budget_item_cat.id
                    WHERE fin_budget_jnk_budget_type_item_cat.id = fin_budget_jnk_item_cat_item_desc.item_cat 
                  ) AS item_cat,
                  fin_budget_jnk_item_cat_item_desc.item_desc,
                  fin_budget_jnk_item_cat_item_desc.recepient,
                  deworming_waves.deworming_wave
                  FROM fin_budget_cat_county
                  JOIN fin_budget_jnk_item_cat_item_desc ON fin_budget_cat_county.record_id = fin_budget_jnk_item_cat_item_desc.id
                  JOIN fin_budget_category ON fin_budget_cat_county.budget_cat = fin_budget_category.id
                  JOIN fin_budget_type ON fin_budget_cat_county.budget_type = fin_budget_type.id
                  JOIN fin_budget_meta ON fin_budget_cat_county.budget_type = fin_budget_meta.budget_type AND 
                                          fin_budget_cat_county.budget_cat = fin_budget_meta.budget_cat AND
                                          fin_budget_cat_county.wave = fin_budget_meta.wave AND
                                          fin_budget_cat_county.county = fin_budget_meta.location
                  JOIN deworming_waves ON fin_budget_cat_county.wave = deworming_waves.id
                  WHERE 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type
                  ', 
                  array(
                    ':county' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['budget-cat'],
                    ':budget_type' => $_REQUEST['budget-type']
                  )
                );
            } else {
              $database->query('SELECT 
                fin_budget_cat_districts.record_id AS id,
                fin_budget_cat_districts.budget_cat,
                fin_budget_cat_districts.budget_type,
                fin_budget_cat_districts.total,
                fin_budget_cat_districts.item_desc AS unique_item_desc,
                fin_budget_cat_districts.recepient AS unique_recepient,
                fin_budget_cat_districts.total_spent,
                fin_budget_category.category AS budget_category,
                fin_budget_type.budget_type AS budget_type,
                fin_budget_meta.prepared_by,
                (
                  SELECT fin_budget_item_cat.item_cat 
                  FROM fin_budget_jnk_budget_type_item_cat JOIN fin_budget_item_cat ON fin_budget_jnk_budget_type_item_cat.fk_item_cat = fin_budget_item_cat.id
                  WHERE fin_budget_jnk_budget_type_item_cat.id = fin_budget_jnk_item_cat_item_desc.item_cat 
                ) AS item_cat,
                fin_budget_jnk_item_cat_item_desc.item_desc,
                fin_budget_jnk_item_cat_item_desc.recepient,
                deworming_waves.deworming_wave
                FROM fin_budget_cat_districts
                JOIN fin_budget_jnk_item_cat_item_desc ON fin_budget_cat_districts.record_id = fin_budget_jnk_item_cat_item_desc.id
                JOIN fin_budget_category ON fin_budget_cat_districts.budget_cat = fin_budget_category.id
                JOIN fin_budget_type ON fin_budget_cat_districts.budget_type = fin_budget_type.id
                JOIN fin_budget_meta ON fin_budget_cat_districts.budget_type = fin_budget_meta.budget_type AND 
                                        fin_budget_cat_districts.budget_cat = fin_budget_meta.budget_cat AND
                                        fin_budget_cat_districts.wave = fin_budget_meta.wave AND
                                        fin_budget_cat_districts.district = fin_budget_meta.location
                JOIN deworming_waves ON fin_budget_cat_districts.wave = deworming_waves.id
                WHERE 
                  fin_budget_cat_districts.district = :district AND 
                  fin_budget_cat_districts.wave = :wave AND 
                  fin_budget_cat_districts.budget_cat = :budget_cat AND 
                  fin_budget_cat_districts.budget_type = :budget_type
                ', 
                array(
                  ':district' => urldecode($_REQUEST['loc']),
                  ':wave' => $_REQUEST['wave'],
                  ':budget_cat' => $_REQUEST['budget-cat'],
                  ':budget_type' => $_REQUEST['budget-type']
                )
              );          
            }

            $BudgetResults = $database->statement->fetchall(PDO::FETCH_ASSOC);
            $budget_total  = $_REQUEST['budget-total'];
            $projectClasses = array('DTW MGMNT','DTW TRAIN','DTW MONEVAL','DTW POLICY','DTW DRUGS','DTW PREVSURV','DTW AWARE');  
            $donors = array('CIFF DtWI','END-FUND');

            if ($_GET['budget-cat']==1) {

              if ( $_GET['budget-type']==7 || $_GET['budget-type']==9 || $_GET['budget-type']==12 || $_GET['budget-type']==14  || $_GET['budget-type']==17 ) {
                $database->query('SELECT bank_account_name, bank_account_number, bank_name, bank_branch FROM county_contacts WHERE county = :county AND title = :title',
                  array(
                    ':county' => urldecode($_GET['loc']),
                    ':title' => 'CDE'
                  )
                );
              } else if (  $_GET['budget-type']==16 || $_GET['budget-type']==10 || $_GET['budget-type']==8 ) {
                $database->query('SELECT bank_account_name, bank_account_number, bank_name, bank_branch FROM county_contacts WHERE county = :county AND title = :title',
                  array(
                    ':county' => urldecode($_GET['loc']),
                    ':title' => 'CHC'
                  )
                );
              } else {
                $database->query('SELECT bank_account_name, bank_account_number, bank_name, bank_branch FROM county_contacts WHERE county = :county AND title = :title',
                  array(
                    ':county' => urldecode($_GET['loc']),
                    ':title' => 'CDH'
                  )
                );
              }
            } else {

              if ( $_GET['budget-type']==2 || $_GET['budget-type']==4 || $_GET['budget-type']==6 || $_GET['budget-type']==11) {
                $database->query('SELECT dmoh_bank_name as bank_name, dmoh_bank_branch as bank_branch, dmoh_bank_account as bank_account_name, dmoh_account_number as bank_account_number FROM health_contacts WHERE district = :district',
                  array(
                    ':district' => urldecode($_GET['loc'])
                  )
                );                  
              } else {
                $database->query('SELECT deo_bank_name as bank_name, deo_bank_branch as bank_branch, deo_bank_account as bank_account_name, deo_account_number as bank_account_number FROM education_contacts WHERE district = :district',
                  array(
                    ':district' => urldecode($_GET['loc'])
                  )
                );             
              }
            }
            $bank_details = $database->statement->fetch(PDO::FETCH_ASSOC);

            if ($budget_total <= 100000) {
              $approverArray = "'5','8','4','7','35','46'";
            } else if ($budget_total <= 300000) {
              $approverArray = "'4','7','35'";
            } else if ($budget_total <= 500000) {
              $approverArray = "'7','35'";
            } else if ($budget_total > 500000) {
              $approverArray = "'35'";
            }

            $database->query('SELECT staff_name FROM staff WHERE staff_id = :staff_id',
              array(
                ':staff_id' => $BudgetResults[0]['prepared_by']
              )
            );
            $budget_prepared = $database->statement->fetch(PDO::FETCH_ASSOC);

            if ( isset($_POST['edit-form'] ) ) { $editable = true; } else { $editable = false; }

            if (isset($_POST['save-form'])) {
              unset($_POST['save-form']); 
              $formData = serialize($_POST); 
              $financeClass->saveBudgetFormData($formData);
            }

            if ( $formtype == 'recon' ) {

              $database->query('SELECT recon_data as form_data FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                array(
                  ':location'   => urldecode($_GET['loc']), 
                  ':wave'     => $_GET['wave'], 
                  ':budget_cat' => $_GET['budget-cat'], 
                  ':budget_type'  => $_GET['budget-type']
                )
              );
              $formResults = $database->statement->fetch(PDO::FETCH_ASSOC);
              $form_data = unserialize($formResults['form_data']);

              $doc_heading = 'Financial Reconcilliation Return Form';
              $docTitle = $doc_title = urldecode($_GET['loc']).' '.$BudgetResults[0]['budget_category'].' Budget ('.$BudgetResults[0]['budget_type'].') Wave: '.$BudgetResults[0]['deworming_wave'].'';

              if ( isset($_POST['save-reconsiliation-form']) ) {

                // Enter Action Log
                quickFuncLog(
                  $ArrayData = array(
                    0 => 4,
                    1 => 'Updated Financial Reconcilliation Return Form',
                    2 => 'Updated Financial Reconcilliation Return Form for '.$BudgetResults[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                  )
                );

                $meta = array(
                  'budget_type' => $BudgetResults[0]['budget_type'],
                  'budget_cat' => $BudgetResults[0]['budget_category'],
                  'location' => urldecode($_GET['loc']),
                  'dewormin_wave' => $BudgetResults[0]['deworming_wave'],
                  'budget_total' => $budget_total
                );

                $data = array();
                foreach($_POST['id'] as $key => $value) {
                  if (empty($_POST['spent'][$key])) {
                    $Variance = '';
                  } else {
                    $Variance = $_POST['advanced'][$key] - $_POST['spent'][$key];
                  }
                  array_push($data, array(
                      'recepient' => $_POST['recepient'][$key],
                      'advanced' => $_POST['advanced'][$key],
                      'spent' => $_POST['spent'][$key],
                      'variance' => $Variance
                    )
                  );
                }
                $financeClass->createreconPDF($meta, $data);

                foreach($_POST['id'] as $key => $value) {
                  $item = $key;
                  $data = array(
                    'id' => $value,
                    'total_spent' => $_POST['spent'][$item]
                  );
                  $financeClass->addreconsiliationData($data);
                }

                $formData = array(
                  'remarks'       => $_POST['remarks'],
                  'prepared_by'   => $_POST['prepared_by'],
                  'prepared_date' => $_POST['prepared_date'],
                  'approved_by'   => $_POST['approved_by'],
                  'approved_date' => $_POST['approved_date']
                );

                $formData = serialize($formData);
                $financeClass->saveBudgetFormData($formData);
              }

              if ( isset($_POST['export-reconsiliation-form']) ) {
                $meta = array(
                  'budget_type' => $BudgetResults[0]['budget_type'],
                  'budget_cat' => $BudgetResults[0]['budget_category'],
                  'location' => urldecode($_GET['loc']),
                  'dewormin_wave' => $BudgetResults[0]['deworming_wave'],
                  'budget_total' => $budget_total
                );

                $data = array();
                foreach($_POST['id'] as $key => $value) {
                  if (empty($_POST['spent'][$key])) {
                    $Variance = '';
                  } else {
                    $Variance = $_POST['advanced'][$key] - $_POST['spent'][$key];
                  }
                  array_push($data, array(
                      'recepient' => $_POST['recepient'][$key],
                      'advanced' => $_POST['advanced'][$key],
                      'spent' => $_POST['spent'][$key],
                      'variance' => $Variance
                    )
                  );
                }
                $financeClass->createreconPDF($meta, $data);
              } 

                if ($_GET['cat'] ==1 || $_GET['budget-cat'] ==1 ) {
                  $file = 'reconciliation_'.str_replace(' ', '_', strtolower($BudgetResults[0]['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower(urldecode($_GET['loc']) ) ).'_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['deworming_wave'] ) );
                } else {
                  $file = 'reconciliation_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['budget_cat'] ) ).'_'.str_replace(' ', '_', strtolower($BudgetResults[0]['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower( urldecode($_GET['loc']) ) ).'_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['deworming_wave'] ) );
                }

              ?>

              <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">
                <ul class="list-unstyled clearfix">
                  <?php if($prevs['priv_reconciliation_return']>=3) { ?>
                    <li class="pull-left"><button type="submit" name="edit-form" class="btn btn-primary" <?php if ( $editable == true ) { ?> disabled <?php } ?> >Edit</button></li>
                    <li class="pull-left">&nbsp;</li>
                    <li class="pull-left"><button type="submit" name="save-reconsiliation-form" class="btn btn-primary" <?php if ( $editable != true ) { ?> disabled <?php } ?> >Save</button></li><li class="pull-left">&nbsp;</li>
                  <?php } ?>
                  <li class="pull-left"><a href="<?php echo 'pdf_budget_forms/'.$file.'.pdf'; ?>" class="btn btn-primary <?php if ( $editable == true ) { ?> disabled <?php } ?>" target="new">Export PDF</a></li>
                  <li class="pull-left">&nbsp;</li>
                </ul> 

                <br>

                <div id="budget-form-container" class="form-budget">

                  <div id="budget-form-recon">

                    <div id="budget-form-header">

                      <img src="../images/logo.png"/>

                      <h2><?php echo $doc_heading; ?></h2>
                      <h3><?php echo $doc_title; ?></h3><br>

                      <div id="budget-form-header-meta">

                        <p class="meta"><span class="meta-label">Name: </span> <?php echo $BudgetResults[0]['budget_type']; ?></p>
                        <!-- <p class="meta"><span class="meta-label">Date: </span> </p> -->
                        <p class="meta"><span class="meta-label">Amount (Words):</span> <?php echo '<em>'.ucwords(convert_number_to_words($budget_total)).' Only </em>'; ?></p> 

                        <h5>Notes:</h5>
                        <p class="notes"> If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                        <p class="notes">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>       

                      </div>                  

                    </div>  

                    <div id="budget-form-body">
                        <table class="table table-bordered" id="recon-table">
                          <thead>
                            <tr class="compress">
                              <th>Unit Description</th>
                              <th>Amount Advanced (Ksh)</th>
                              <th>Amount Spent (Including Other Allowed Costs)</th>
                              <th>Variance between Advanced &amp; Amount Spent</th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <td><b>Amount forwarded to your Sub-County</b></td>
                                <td><b><?php echo number_format($budget_total); ?></b></td>
                                <td class="disabled"></td>
                                <td class="disabled"></td>
                              </tr>
                              <?php
                                foreach ($BudgetResults as $key => $value) {
                                  $total_spent = $value['total_spent'] ? $value['total_spent'] : ''; ?>
                                    <tr class="data-row">
                                      <td>
                                        <?php if (empty( $value['item_desc'])) {
                                            echo $value['unique_item_desc']; if ( $value['unique_recepient'] ) { ?> For <?php  } echo $value['unique_recepient'];
                                          } else {
                                            echo $value['item_desc']; if ( $value['recepient'] ) { ?> For <?php  } echo $value['recepient'];
                                          } ?>
                                      </td>
                                      <td class="hidden"><input type="text" name="id[]" value="<?php echo $value['id']; ?>"/></td>
                                      <td class="hidden"><input type="text" name="recepient[]" value="<?php echo $value['item_desc']; if ( $value['recepient'] ) { ?> For <?php  } echo $value['recepient']; ?>"/></td>
                                      <td class="advanced"><input type="text" name="advanced[]" value="<?php echo $value['total']; ?>" readonly/></td>
                                      <td class="spent"><input type="text" name="spent[]" value="<?php echo $total_spent; ?>" class="num-only" <?php if ( $editable != true ) { ?> readonly <?php } ?> /></td>
                                      <td class="variance"><input type="text" value="" disabled/></td>
                                    </tr>
                              <?php } ?>
                              <tr>
                                <td><b>Amount forwarded to your Sub-County</b></td>
                                <td><b><?php echo number_format($budget_total); ?></b></td>
                                <td class="disabled"></td>
                                <td class="disabled"></td>
                              </tr>
                              <tr>
                                <td><b>Total Amount Spent</b></td>
                                <td class="disabled"></td>
                                <td id="spent-total"></td>
                                <td class="disabled"></td>
                              </tr>
                              <tr>
                                <td><b>Amount Currently Held In Sub-County Account</b></td>
                                <td class="disabled"></td>
                                <td class="disabled"></td>
                                <td id="variance-total"></td>
                              </tr>
                              <tr>
                                <td colspan="5" id="remarks"><textarea name="remarks" placeholder="Remarks" <?php if ( $editable != true ) { echo 'readonly'; } ?> ><?php if(!empty($form_data['remarks'])) { echo $form_data['remarks']; } ?></textarea></td>
                              </tr>
                          </tbody>
                        </table>

                    </div>

                    <div id="budget-form-footer">
                      <div class="clearfix">
                        <div class="pull-left">
                          <p><b>Prepared By: </b> <input type="text" name="prepared_by" value="<?php echo $_SESSION['staff_name']; ?>" readonly> </p>
                          <p><b>Date: </b> <input type="date" name="prepared_date" <?php if ( $editable != true ) { echo 'readonly'; } ?> value="<?php if(!empty($form_data['prepared_date'])) { echo $form_data['prepared_date']; } ?>" ></p>
                          <p><b>Signature: </b></p>
                        </div>
                        <div class="pull-right">
                          <p><b>Approved By: </b>                     
                              <select name="approved_by" <?php if ( $editable != true ) { echo 'readonly'; } ?> >
                                <?php 
                                  $database->query('SELECT staff_name FROM staff');
                                  $staff = $database->statement->fetchall(PDO::FETCH_ASSOC);
                                  foreach ($staff as $key => $value) { ?>
                                    <option value="<?php echo $value['staff_name']; ?>" <?php if ( $value['staff_name'] == $form_data['approved_by'] ) { echo ' selected'; } ?> ><?php echo $value['staff_name']; ?></option>
                                  <?php } ?>
                              </select></p>
                          <p><b>Date: </b> <input type="date" name="approved_date" <?php if ( $editable != true ) { echo 'readonly'; } ?> value="<?php if(!empty($form_data['approved_date'])) { echo $form_data['approved_date']; } ?>" > </p>
                          <p><b>Signature: </b></p>
                        </div>
                    </div>

                  </div>

                </div>

              </form>

            <?php } else if ( $formtype == 'imprest' ) {

              $database->query('SELECT imprest_data as form_data FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                array(
                  ':location'   => urldecode($_GET['loc']), 
                  ':wave'     => $_GET['wave'], 
                  ':budget_cat' => $_GET['budget-cat'], 
                  ':budget_type'  => $_GET['budget-type']
                )
              );
              $formResults = $database->statement->fetch(PDO::FETCH_ASSOC);
              $form_data = unserialize($formResults['form_data']);

              if ($_GET['budget-type'] == 8) {

                $database->query('SELECT SUM(total) AS drug_collection
                  FROM fin_budget_cat_county
                  WHERE 
                    fin_budget_cat_county.record_id IN("124","125","126") AND 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type
                  ', 
                  array(
                    ':county' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['budget-cat'],
                    ':budget_type' => $_REQUEST['budget-type']
                  )
                );
                $drugCollection = $database->statement->fetch(PDO::FETCH_ASSOC);
                $drugCollection = $drugCollection['drug_collection'];
                $countyBudget = $budget_total - $drugCollection;

              } else if ($_GET['budget-type'] == 10) {

                $database->query('SELECT SUM(total) AS drug_collection
                  FROM fin_budget_cat_county
                  WHERE 
                    fin_budget_cat_county.record_id IN("152","153","154") AND 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type
                  ', 
                  array(
                    ':county' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['budget-cat'],
                    ':budget_type' => $_REQUEST['budget-type']
                  )
                );
                $drugCollection = $database->statement->fetch(PDO::FETCH_ASSOC);
                $drugCollection = $drugCollection['drug_collection'];
                $countyBudget = $budget_total - $drugCollection;

              } else {

                $countyBudget = $budget_total;

              }

              $docTitle = 'Imprest Request Form '.$BudgetResults[0]['budget_type'].'For Deworming Wave: '.$BudgetResults[0]['deworming_wave'];

              if ( isset($_POST['save-imprest-form']) ) { 
                // Enter Action Log
                quickFuncLog(
                  $ArrayData = array(
                    0 => 4,
                    1 => 'Updated Imprest Request Form',
                    2 => 'Updated Imprest Request Return Form for '.$BudgetResults[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                  )
                );

                //Create PDF
                $meta = array(
                  'budget_prepared' => $budget_prepared['staff_name'],
                  'budget_type'     => $BudgetResults[0]['budget_type'],
                  'budget_cat'      => $BudgetResults[0]['budget_category'],
                  'location'        => urldecode($_GET['loc']),
                  'dewormin_wave'   => $BudgetResults[0]['deworming_wave'],
                  'budget_total'    => $budget_total,
                  'bank_details'    => $bank_details
                );

                $financeClass->createimprestPDF($meta, $_POST);
                $formData = serialize($_POST); 
                $financeClass->saveBudgetFormData($formData);

              }

              ?>

              <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">

                <ul class="list-unstyled clearfix">
                  <?php if($prevs['priv_imp_requests']>=3){ ?>
                    <li class="pull-left"><button type="submit" class="btn btn-primary" name="save-imprest-form" <?php if ( !$editable ) { echo 'disabled'; } ?> >Save</button></li>
                    <li class="pull-left">&nbsp;</li>   
                    <li class="pull-left"><button type="submit" class="btn btn-primary" name="edit-form" <?php if ( $editable ) { echo 'disabled'; } ?> >Edit</button></li>
                    <li class="pull-left">&nbsp;</li>   
                  <?php } ?>
                  <?php if (!empty($form_data)) { ?>
                    <li class="pull-left"><a href="<?php echo 'pdf_budget_forms/imprest_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['budget_category'] ) ).'_budget_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['budget_type'] ) ).'_'.str_replace(' ', '_', strtolower( urldecode($_GET['loc'] ) ) ).'_'.str_replace(' ', '_', strtolower( $BudgetResults[0]['deworming_wave'] ) ).'.pdf'; ?>" target="_blank" class="btn btn-primary">Export to PDF</a></li>
                    <li class="pull-left">&nbsp;</li>
                  <?php } ?>
                </ul>
                <br>

                <div id="budget-form-container" class="form-budget">

                  <div id="budget-form-header">

                    <img src="../images/logo.png"/>

                    <h2>Imprest Request Form</h2>
                    <h3><?php echo urldecode($_GET['loc']).' '.$BudgetResults[0]['budget_category'].' Budget ('.$BudgetResults[0]['budget_type'] .') For Deworming Wave: '.$BudgetResults[0]['deworming_wave'].''; ?></h3><br>

                    <div id="budget-form-header-meta">

                      <p class="meta"><span class="meta-label">Prepared By: </span><?php echo $budget_prepared['staff_name']; ?></p>
                      <p class="meta"><span class="meta-label">Signature:</span></p>
                      <p class="meta" style="float:left;display:inline;width:50%"><span class="meta-label">Date Request Is Made:</span> <input type="text" name="date_made" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['date_made']) && !empty($form_data['date_made']) ) { echo $form_data['date_made']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?> /></p> 
                      <p class="meta" style="float:left;display:inline;width:50%"><span class="meta-label">Date Request Is Required:</span> <input type="text" name="date_required" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['date_required']) && !empty($form_data['date_required'])  ) { echo $form_data['date_required']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?>/></p>
                      <p class="meta"><span class="meta-label">Amount (Words):</span> <?php echo '<em>'.ucwords(convert_number_to_words($budget_total)).' Only </em>'; ?></p>
                      <h5>Notes:</h5>
                      <p class="notes"> If you make any alterations to this return document, please cancel the original notation and counter-sign against the alteration. Do not use white-out.</p>     
                      <p class="notes">Allowable costs MUST be approved by Innovations for Poverty Action before being incurred. Please contact us for approval. Once approved, indicate the specific nature of those expenses in the Remarks Section.</p>       

                    </div>                  

                  </div>  

                  <div id="budget-form-body">
                    <table class="table table-bordered" id="imprest">
                      <thead>
                        <tr>
                          <th>Pariculars</th>
                          <th>Project Class</th>
                          <th>Amount (Ksh)</th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr>
                            <td><b>Amount forwarded to your Sub-County</b></td>
                            <td>      
                                <?php if ( $editable == true ) { ?>
                                  <select name="project_class"  >
                                    <option value="">Select Project</option>
                                    <?php
                                      foreach ($projectClasses as $key => $projectclass) { ?>
                                        <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                    <?php } ?>
                                  </select>
                                <?php } else {
                                    if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                                } ?>
                            </td>
                            <td><b><?php echo number_format($countyBudget); ?></b></td>
                          </tr> 
                          <?php if ($_GET['budget-type'] == 8 ) { ?>
                            <tr>
                              <td><b>Drug Collection</b></td>
                              <td>      
                                  <?php if ( $editable == true ) { ?>
                                    <select name="project_class"  >
                                      <option value="">Select Project</option>
                                      <?php
                                        foreach ($projectClasses as $key => $projectclass) { ?>
                                          <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                      <?php } ?>
                                    </select>
                                  <?php } else {
                                      if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                                  } ?>
                              </td>
                              <td><b><?php echo number_format($drugCollection); ?></b></td>
                            </tr> 
                          <?php } else if ( $_GET['budget-type'] == 10 ) { ?>
                            <tr>
                              <td><b>Radio Engagement</b></td>
                              <td>      
                                  <?php if ( $editable == true ) { ?>
                                    <select name="project_class"  >
                                      <option value="">Select Project</option>
                                      <?php
                                        foreach ($projectClasses as $key => $projectclass) { ?>
                                          <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                      <?php } ?>
                                    </select>
                                  <?php } else {
                                      if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                                  } ?>
                              </td>
                              <td><b><?php echo number_format($drugCollection); ?></b></td>
                            </tr> 
                          <?php } ?>
                          <?php for ($i=0; $i < 10; $i++) { ?>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr> 
                          <?php } ?>
                          <tr>
                            <td colspan="5" id="remarks">
                              <b>Please Pay: <?php echo $bank_details['bank_account_name']; ?> <br> 
                              <?php echo $bank_details['bank_account_number'].' '.$bank_details['bank_name'].' '.$bank_details['bank_branch']; ?></b>
                            </td>
                          </tr>
                      </tbody>
                    </table>

                  </div>

                  <div id="budget-form-footer">
                    <p>
                      <b>Authorized By: </b> 
                      <?php if ($editable == true) { ?>
                        <select name="authorized_by" >
                          <?php 
                            $database->query("SELECT staff_name FROM staff WHERE staff_id IN($approverArray)");
                            $staff = $database->statement->fetchall(PDO::FETCH_ASSOC);                          
                            foreach ($staff as $key => $value) { ?>                              
                                <option value="<?php echo $value['staff_name']; ?>" <?php if ( isset($form_data['authorized_by']) && $form_data['authorized_by'] == $value['staff_name'] ) { echo 'selected'; } ?> > <?php echo $value['staff_name']; ?></option>
                              <?php } ?>
                        </select>
                      <?php } else {
                        if (isset($form_data['authorized_by'])) { echo $form_data['authorized_by']; }
                      } ?>
                    </p>
                    <p><b>Date: </b> <input type="text" name="date_authorized" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['date_authorized']) && !empty($form_data['date_authorized'])  ) { echo $form_data['date_authorized']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?>/></p>
                    <p><b>Signature: </b></p>

                  </div>

                </div>

              </form>

            <?php } else if ( $formtype == 'cheque' ) { 

              $database->query('SELECT cheque_data as form_data FROM fin_budget_meta WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                array(
                  ':location'   => urldecode($_GET['loc']), 
                  ':wave'     => $_GET['wave'], 
                  ':budget_cat' => $_GET['budget-cat'], 
                  ':budget_type'  => $_GET['budget-type']
                )
              );
              $formResults = $database->statement->fetch(PDO::FETCH_ASSOC);
              $form_data = unserialize($formResults['form_data']);

              if ($_GET['budget-type'] == 8) {

                $database->query('SELECT SUM(total) AS drug_collection
                  FROM fin_budget_cat_county
                  WHERE 
                    fin_budget_cat_county.record_id IN("124","125","126") AND 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type
                  ', 
                  array(
                    ':county' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['budget-cat'],
                    ':budget_type' => $_REQUEST['budget-type']
                  )
                );
                $drugCollection = $database->statement->fetch(PDO::FETCH_ASSOC);
                $drugCollection = $drugCollection['drug_collection'];
                $countyBudget = $budget_total - $drugCollection;

              } else if ($_GET['budget-type'] == 10) {

                $database->query('SELECT SUM(total) AS drug_collection
                  FROM fin_budget_cat_county
                  WHERE 
                    fin_budget_cat_county.record_id IN("152","153","154") AND 
                    fin_budget_cat_county.county = :county AND 
                    fin_budget_cat_county.wave = :wave AND 
                    fin_budget_cat_county.budget_cat = :budget_cat AND 
                    fin_budget_cat_county.budget_type = :budget_type
                  ', 
                  array(
                    ':county' => urldecode($_REQUEST['loc']),
                    ':wave' => $_REQUEST['wave'],
                    ':budget_cat' => $_REQUEST['budget-cat'],
                    ':budget_type' => $_REQUEST['budget-type']
                  )
                );
                $drugCollection = $database->statement->fetch(PDO::FETCH_ASSOC);
                $drugCollection = $drugCollection['drug_collection'];
                $countyBudget = $budget_total - $drugCollection;

              } else {

                $countyBudget = $budget_total;

              }

              $docTitle = 'Cheque Request Form '.urldecode($_GET['loc']).' Deworming_wave '.$BudgetResults[0]['deworming_wave'].'';

              if ( isset($_POST['save-cheque-form']) ) {

                // Enter Action Log
                quickFuncLog(
                  $ArrayData = array(
                    0 => 4,
                    1 => 'Updated Cheque Request Form',
                    2 => 'Updated Cheque Request Return Form for '.$BudgetResults[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                  )
                );

                //Create PDF
                $meta = array(
                  'budget_prepared' => $budget_prepared['staff_name'],
                  'budget_type'     => $BudgetResults[0]['budget_type'],
                  'budget_cat'      => $BudgetResults[0]['budget_category'],
                  'location'        => urldecode($_GET['loc']),
                  'dewormin_wave'   => $BudgetResults[0]['deworming_wave'],
                  'budget_total'    => $budget_total
                );

                // $financeClass->createchequePDF($meta, $_POST);
                $formData = serialize($_POST); 
                $financeClass->saveBudgetFormData($formData);

              }

              ?>

              <form method="post" action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>">

                <ul class="list-unstyled clearfix">
                  <?php if($prevs['priv_cheque_requests']>=3){ ?>
                  <li class="pull-left"><button type="submit" name="edit-form" class="btn btn-primary" <?php if ( $editable == true ) { ?> disabled <?php } ?> >Edit</button></li>
                  <li class="pull-left">&nbsp;</li>
                  <li class="pull-left"><button type="submit" name="save-cheque-form" class="btn btn-primary" <?php if ( $editable != true ) { ?> disabled <?php } ?> >Save</button></li>
                  <li class="pull-left">&nbsp;</li>
                  <?php } ?>
                  <?php if (!empty($form_data)) { ?>
                    <li class="pull-left"><a href="pdf_budget_forms/financial_reconciliation_return_form_garissa_county_budget_(county_meeting_budget-moest)_for_deworming_wave__moses_test_3.pdf" target="_blank" class="btn btn-primary">Export to PDF</a></li>
                  <?php } ?>
                </ul>
                <br><br>

                <div id="budget-form-container" class="form-budget cheque-request">

                  <h3 class="clearfix"><span class="pull-right">NUMBER:<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span></h3>

                  <div id="budget-form-header">
                    
                    <img src="../images/logo.png"/>
                    <h2>Cheque Request Form</h2>
                    <h4><?php echo urldecode($_GET['loc']).' '.$BudgetResults[0]['budget_category'].' Budget ('.$BudgetResults[0]['budget_type'] .') For Deworming Wave: '.$BudgetResults[0]['deworming_wave'].''; ?></h4><br>

                  </div>

                  <div id="budget-form-body">

                    <table class="table">
                      <tr style="background-color: #eaeaea">
                        <th colspan="3">SECTION 1: To be filled by the manager requesting payment by cheque</th>
                      </tr>
                      <tr>
                        <th>Payee Name:</th>
                        <td> <?php echo $bank_details['bank_account_name']; ?></td>
                        <td class="helper"><span class="pull-right"><small><em>Exactly as it should appear on the cheque</em></small></span></td>
                      </tr>
                      <tr>
                        <th>Memo:</th>
                        <td><?php echo $BudgetResults[0]['budget_type']; ?></td>
                        <td> </td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <th>Project Class:</th>
                        <td>     
                            <?php if ( $editable == true ) { ?>
                              <select name="project_class"  >
                                <option value="">Select Project</option>
                                <?php
                                  foreach ($projectClasses as $key => $projectclass) { ?>
                                    <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                <?php } ?>
                              </select>
                            <?php } else {
                                if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                            } ?>
                        </td>
                        <td class="helper"><span class="pull-right"><small><em>Include sub-class if relevant</em></small></span></td>
                      </tr>
                      <?php if ($_GET['budget-type'] == 8 ) { ?>
                        <tr>
                          <th>Project Class (Drug Collection)</th>
                          <td>      
                              <?php if ( $editable == true ) { ?>
                                <select name="project_class"  >
                                  <option value="">Select Project</option>
                                  <?php
                                    foreach ($projectClasses as $key => $projectclass) { ?>
                                      <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                  <?php } ?>
                                </select>
                              <?php } else {
                                  if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                              } ?>
                          </td>
                          <td class="helper"><span class="pull-right"><small><em>Include sub-class if relevant</em></small></span></td>
                        </tr> 
                      <?php } else if ( $_GET['budget-type'] == 10 ) { ?>
                        <tr>
                          <th>Billing Details</th>
                          <td>      
                              <?php if ( $editable == true ) { ?>
                                <select name="project_class"  >
                                  <option value="">Select Project</option>
                                  <?php
                                    foreach ($projectClasses as $key => $projectclass) { ?>
                                      <option value="<?php echo $projectclass; ?>" <?php if ( isset($form_data['project_class'] ) && ( $projectclass == $form_data['project_class'] ) ) { echo 'selected'; } ?> > <?php echo $projectclass; ?></option>
                                  <?php } ?>
                                </select>
                              <?php } else {
                                  if ( isset($form_data['project_class']) && !empty($form_data['project_class']) ) { echo $form_data['project_class']; } 
                              } ?>
                          </td>
                          <td class="helper"><span class="pull-right"><small><em>Include sub-class if relevant</em></small></span></td>
                        </tr> 
                      <?php } ?>
                      <tr>
                        <th>Donor:</th>
                        <td>     
                            <?php if ( $editable == true ) { ?>
                              <select name="donor"  >
                                <option value="">Select Donor</option>
                                <?php
                                  foreach ($donors as $key => $donor) { ?>
                                    <option value="<?php echo $donor; ?>" <?php if ( isset($form_data['donor'] ) && ( $donor == $form_data['donor'] ) ) { echo 'selected'; } ?> > <?php echo $donor; ?></option>
                                <?php } ?>
                              </select>
                            <?php } else {
                                if ( isset($form_data['donor']) && !empty($form_data['donor']) ) { echo $form_data['donor']; } 
                            } ?>
                          </td>
                        <td class="helper"><span class="pull-right"><small><em>Include  grant if relevant</em></small></span></td>
                      </tr>
                      <tr>
                        <th>Amount(Words):</th>
                        <td colspan="2"><?php echo '<em>'.ucwords(convert_number_to_words($budget_total)).' Only </em>'; ?></td>
                      </tr>
                      <tr>
                        <th>Kshs:</th>
                        <td colspan="2"><?php echo number_format($_REQUEST['budget-total']); ?> </td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <td><b>Prepared By:</b> <?php echo $budget_prepared['staff_name']; ?> </td>
                        <td><b>Signature:</b> </td>

                        <td><b>Date:</b> <input type="text" name="date_prepared" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['date_prepared']) && !empty($form_data['date_prepared'])  ) { echo $form_data['date_prepared']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?>/></td>
                      </tr>
                      <tr>
                        <td>
                          <b>Approved By:</b>
                            <?php if ($editable == true) { ?>
                              <select name="approved_by" >
                                <?php 
                                  $database->query("SELECT staff_name FROM staff WHERE staff_id IN($approverArray)");
                                  $staff = $database->statement->fetchall(PDO::FETCH_ASSOC);                          
                                  foreach ($staff as $key => $value) { ?>                              
                                      <option value="<?php echo $value['staff_name']; ?>" <?php if ( isset($form_data['approved_by']) && $form_data['approved_by'] == $value['staff_name'] ) { echo 'selected'; } ?> > <?php echo $value['staff_name']; ?></option>
                                    <?php } ?>
                              </select>
                            <?php } else {
                              if (isset($form_data['approved_by'])) { echo $form_data['approved_by']; }
                            } ?>
                        </td>
                        <td><b>Signature:</b> </td>
                        <td><b>Date:</b> <input type="text" name="date_approved" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['date_approved']) && !empty($form_data['date_approved'])  ) { echo $form_data['date_approved']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?>/></td>
                      </tr>
                      <tr>
                        <td>
                          <b>Final Approved By: </b>                 
                            <?php if ($editable == true) { ?>
                              <select name="final_approved_by" >
                                <?php 
                                  $database->query("SELECT staff_name FROM staff WHERE staff_id IN($approverArray)");
                                  $staff = $database->statement->fetchall(PDO::FETCH_ASSOC);                          
                                  foreach ($staff as $key => $value) { ?>                              
                                      <option value="<?php echo $value['staff_name']; ?>" <?php if ( isset($form_data['final_approved_by']) && $form_data['final_approved_by'] == $value['staff_name'] ) { echo 'selected'; } ?> > <?php echo $value['staff_name']; ?></option>
                                    <?php } ?>
                              </select>
                            <?php } else {
                              if (isset($form_data['final_approved_by'])) { echo $form_data['final_approved_by']; }
                            } ?>
                          
                        </td>
                        <td><b>Signature:</b> </td>
                        <td><b>Date:</b> <input type="text" name="final_date_approved" class="<?php if ( $editable == true ) { echo 'date'; } ?>" value="<?php if ( isset($form_data['final_date_approved']) && !empty($form_data['final_date_approved'])  ) { echo $form_data['final_date_approved']; } ?>" <?php if ( $editable == false ) { echo 'readonly'; } ?>/></td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr style="background-color: #eaeaea">
                        <th colspan="3">SECTION 2:  To be filled by the Accounts Office.</th>
                      </tr>
                      <tr>
                        <th>Category:</th>
                        <th> </td>
                        <th>Invoice#: </td>
                      </tr>
                      <tr>
                        <th>Cheque Number:</th>
                        <th></td>
                        <th>Bank A/C:</td>
                      </tr>
                      <tr>
                        <td colspan="3">&nbsp;</td>
                      </tr>
                      <tr>
                        <th>Final Approved By:</th>
                        <th>Signature: </td>
                        <th>Date: </td>
                      </tr>
                      <tr>
                        <td colspan="3"><b><small><em>All payments by cheque require final approval by the DCD, CD, OM.</em></small></b></td>
                      </tr>
                      <tr>
                        <th>Verified By:</th>
                        <th>Signature: </td>
                        <th>Date: </td>
                      </tr>
                      <tr>
                        <td colspan="3"><b><small><em>All payments by cheque are verified by the Senior Accountant before disbursement.</em></small></b></td>
                      </tr>                  

                    </table>

                  </div>

                </div>

              </form>

            <?php }

          } else if ($view == 'cheque-tracking') {

            $database->query('SELECT 
              fin_budget_cat_districts.district AS location,
              fin_budget_cat_districts.wave AS wave_id,
              fin_budget_cat_districts.budget_cat AS budget_cat_id,
              fin_budget_cat_districts.budget_type AS budget_type_id,
              fin_budget_category.category AS budget_cat,
              fin_budget_type.budget_type,
              deworming_waves.deworming_wave,
              SUM(fin_budget_cat_districts.total) AS budget_total,
              education_contacts.deo_email,
              education_contacts.deo_email2,
              education_contacts.deo_phone,
              education_contacts.deo_phone2,
              health_contacts.dmoh_email,
              health_contacts.dmoh_email2,
              health_contacts.dmoh_phone,
              health_contacts.dmoh_phone2
              FROM fin_budget_cat_districts
              JOIN education_contacts ON education_contacts.district = fin_budget_cat_districts.district
              JOIN fin_budget_category ON fin_budget_category.id = fin_budget_cat_districts.budget_cat
              JOIN fin_budget_type ON fin_budget_type.id = fin_budget_cat_districts.budget_type
              JOIN health_contacts ON health_contacts.district = fin_budget_cat_districts.district            
              JOIN deworming_waves ON deworming_waves.id = fin_budget_cat_districts.wave            
              GROUP BY 
              fin_budget_cat_districts.district,
              fin_budget_cat_districts.wave,
              fin_budget_cat_districts.budget_cat,
              fin_budget_cat_districts.budget_type 
              HAVING SUM(fin_budget_cat_districts.total) != 0') ;
            $results1 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $database->query('SELECT 
              fin_budget_cat_county.county AS location,
              fin_budget_cat_county.wave AS wave_id,
              fin_budget_cat_county.budget_cat AS budget_cat_id,
              fin_budget_cat_county.budget_type AS budget_type_id,               
              fin_budget_category.category AS budget_cat,
              fin_budget_type.budget_type,
              deworming_waves.deworming_wave,
              SUM(fin_budget_cat_county.total) AS budget_total,
              (
                SELECT county_contacts.phone 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDE" LIMIT 1
              ) AS cde_phone,
              (
                SELECT county_contacts.phone2 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDE" LIMIT 1
              ) AS cde_phone2,
              (
                SELECT county_contacts.phone 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDH" LIMIT 1
              ) AS cdh_phone,
              (
                SELECT county_contacts.phone2 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDH" LIMIT 1
              ) AS cdh_phone2,
              (
                SELECT county_contacts.email 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDE" LIMIT 1
              ) AS cde_email,
              (
                SELECT county_contacts.email2 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDE" LIMIT 1
              ) AS cde_email2,
              (
                SELECT county_contacts.email 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDH" LIMIT 1
              ) AS cdh_email,
              (
                SELECT county_contacts.email2 
                FROM county_contacts
                WHERE county_contacts.county = fin_budget_cat_county.county AND title = "CDH" LIMIT 1
              ) AS cdh_email2
              FROM fin_budget_cat_county
              JOIN county_contacts ON county_contacts.county = fin_budget_cat_county.county  
              JOIN fin_budget_category ON fin_budget_category.id = fin_budget_cat_county.budget_cat
              JOIN fin_budget_type ON fin_budget_type.id = fin_budget_cat_county.budget_type
              JOIN deworming_waves ON deworming_waves.id = fin_budget_cat_county.wave
              GROUP BY 
              fin_budget_cat_county.county,
              fin_budget_cat_county.wave,
              fin_budget_cat_county.budget_cat,
              fin_budget_cat_county.budget_type 
              HAVING SUM(fin_budget_cat_county.total) != 0') ;
            $results2 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $results = array_merge($results1, $results2);
            if (isset($_POST['save-return-tracking']) ) {

              // Enter Action Log
              quickFuncLog(
                $ArrayData = array(
                  0 => 4,
                  1 => 'Updated Returns tracking',
                  2 => 'Updated Returns tracking for '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                )
              );

              foreach($_POST['wave'] as $key => $value) {

                $data = array(
                  'wave' => $_POST['wave'][$key], 
                  'budget_cat' => $_POST['budget_cat'][$key],
                  'budget_type' => $_POST['budget_type'][$key],
                  'location' => $_POST['location'][$key],
                  'prepared' => $_POST['prepared'][$key],
                  'reviewed' => $_POST['reviewed'][$key], 
                  'printed' => $_POST['printed'][$key], 
                  'approved' => $_POST['approved'][$key],
                  'disbursed' => $_POST['disbursed'][$key]
                );
                $financeClass->saveRequestTracking($data);                  

              }
              //header('Location:'.basename($_SERVER['REQUEST_URI']));

            } 

            if (isset($_POST['approval-notification']) || isset($_POST['disbursement-notification']) ) {

              if (!empty($_POST['id'])) {

                $data = array();$i=1;
                foreach ($_POST['id'] as $key => $value) {
                  $data[$i] = array(
                    'record_id' => $_POST['id'][$key],
                    'recepient_email' => $_POST['recepient_email'][$key],
                    'budget_type' => $_POST['budget_type_'][$key],
                    'budget_type_id' => $_POST['budget_type'][$key],
                    'budget_cat' => $_POST['budget_cat_'][$key],
                    'budget_cat_id' => $_POST['budget_cat'][$key],
                    'location' => $_POST['location'][$key],
                    'deworming_wave' => $_POST['wave_'][$key]
                  );
                  $i++;
                }
                if (isset($_POST['approval-notification'])) {

                  // Enter Action Log
                  quickFuncLog(
                    $ArrayData = array(
                      0 => 4,
                      1 => 'Sent budget approval notification',
                      2 => 'Sent budget approval notification to '.urldecode($_GET['loc']).' officials for '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                    )
                  );

                  $financeClass->sendNotification($data,'approval');                    
                } else if (isset($_POST['disbursement-notification'])) {
                  $financeClass->sendNotification($data,'disbursement');

                  // Enter Action Log
                  quickFuncLog(
                    $ArrayData = array(
                      0 => 4,
                      1 => 'Sent funds disbursement notification',
                      2 => 'Sent funds disbursement notification to '.urldecode($_GET['loc']).' officials for '.$results[0]['budget_type'].' Budget for '.urldecode($_GET['loc']).''
                    )
                  );
                }

              }

            }

            ?>

            <h2>Request Tracking</h2>

            <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post" >

              <div class="clearfix">

                <?php if($prevs['priv_cheque_requests']>=3){ ?>
                  <ul class="list-unstyled pull-left">
                    <li class="pull-left" ><button class="btn btn-primary" type="submit" name="approval-notification" <?php if (isset($_POST['edit-return-tracking'])) {?> disabled <?php } ?> >Send Approval Notification</button></li>
                    <li class="pull-left" >&nbsp;</li>
                    <li class="pull-left" ><button class="btn btn-primary" type="submit" name="disbursement-notification" <?php if (isset($_POST['edit-return-tracking'])) {?> disabled <?php } ?>  >Send Disbursement Notification</button></li>
                    <li class="pull-left" >&nbsp;</li>
                  </ul>
                  <ul class="list-unstyled pull-right">
                    <?php if (!isset($_POST['edit-return-tracking'])) {?>
                    <li class="pull-left" ><button class="btn btn-primary" type="submit" name="edit-return-tracking">Edit</button></li>
                    <?php } ?>
                    <li class="pull-left" >&nbsp;</li>
                    <?php if (isset($_POST['edit-return-tracking'])) {?>
                    <li class="pull-left" ><button class="btn btn-primary" type="submit" name="save-return-tracking">save</button></li>
                    <?php } ?>
                  </ul>
                <?php } ?>

              </div><br>

              <table class="table table-bordered form-list-table table-hover">

                <thead>
                  <tr>
                    <th>Cheque Request</th>
                    <th>wave</th>
                    <th>Prepared</th>
                    <th>Reviewed</th>
                    <th>Printed</th>
                    <th>Approved</th>
                    <th>Disbursed</th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                    $i=1;
                    foreach ($results as $key => $value) { ?>

                        <input type="hidden" name="recepient_email[<?php echo $i;?>]" value="<?php if($value['budget_cat_id'] == 1 ) {if ($value['budget_type_id'] == 7 || $value['budget_type_id'] == 9) {if (!empty($value['cdh_email'])) {echo $value['cdh_email']; } if (!empty($value['cdh_email2'])) {echo ','.$value['cdh_email2']; } } else if ($value['budget_type_id'] == 8 || $value['budget_type_id'] == 10) {if (!empty($value['cde_email'])) {echo $value['cde_email']; } if (!empty($value['cde_email2'])) {echo ','.$value['cde_email2']; } } } else {if ($value['budget_type_id'] == 2 || $value['budget_type_id'] == 4 || $value['budget_type_id'] == 6 || $value['budget_type_id'] == 11) {if (!empty($value['dmoh_email'])) {echo $value['dmoh_email']; } if (!empty($value['dmoh_email2'])) {echo ','.$value['dmoh_email2']; } } else if ($value['budget_type_id'] == 1 || $value['budget_type_id'] == 3 || $value['budget_type_id'] == 5) {if (!empty($value['deo_email'])) {echo $value['deo_email']; } if (!empty($value['deo_email2'])) {echo ','.$value['deo_email2']; } } } ?>">
                        <input type="hidden" name="budget_type_[<?php echo $i;?>]" value="<?php echo $value['budget_type'] ?>">
                        <input type="hidden" name="budget_cat_[<?php echo $i;?>]" value="<?php echo $value['budget_cat'] ?>">
                        <input type="hidden" name="wave_[<?php echo $i;?>]" value="<?php echo $value['deworming_wave'] ?>">

                        <input type="hidden" name="wave[<?php echo $i;?>]" value="<?php echo $value['wave_id'] ?>" >
                        <input type="hidden" name="budget_cat[<?php echo $i;?>]" value="<?php echo $value['budget_cat_id'] ?>" >
                        <input type="hidden" name="budget_type[<?php echo $i;?>]" value="<?php echo $value['budget_type_id'] ?>" >
                        <input type="hidden" name="location[<?php echo $i;?>]" value="<?php echo $value['location'] ?>" >

                      <?php $database->query('SELECT * FROM fin_req_tracking WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                        array(
                          ':location'   => $value['location'],
                          ':wave'     => $value['wave_id'], 
                          ':budget_cat' => $value['budget_cat_id'], 
                          ':budget_type'  => $value['budget_type_id']
                        )
                      );
                      $thetData = $database->statement->fetch(PDO::FETCH_ASSOC); ?>

                    <tr>
                      <td><?php echo $value['budget_cat'] .' Budget '.$value['budget_type']; ?></td>
                      <td><?php echo $value['location'].' '; if ($value['budget_cat_id'] == 1) { echo 'County'; } else { echo 'Sub-County'; } ?></td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <input type="hidden" name="prepared[<?php echo $i;?>]" value="N"> 
                            <label><input type="checkbox" name="prepared[<?php echo $i;?>]" value="Y" <?php if ( isset($thetData['prepared']) && $thetData['prepared'] == 'Y' ) { echo 'checked'; } ?> ></label>
                          <?php } else { if(isset($thetData['prepared'])) { echo $thetData['prepared']; } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <input type="hidden" name="reviewed[<?php echo $i;?>]" value="N"> 
                            <label><input type="checkbox" name="reviewed[<?php echo $i;?>]" value="Y" <?php if ( isset($thetData['reviewed']) && $thetData['reviewed'] == 'Y' ) { echo 'checked'; } ?> ></label>
                          <?php } else { if(isset($thetData['reviewed'])) { echo $thetData['reviewed']; } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <input type="hidden" name="printed[<?php echo $i;?>]" value="N"> 
                            <label><input type="checkbox" name="printed[<?php echo $i;?>]" value="Y" <?php if ( isset($thetData['printed']) && $thetData['printed'] == 'Y' ) { echo 'checked'; } ?> ></label>
                          <?php } else { if(isset($thetData['printed'])) { echo $thetData['printed']; } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <input type="hidden" name="approved[<?php echo $i;?>]" value="N"> 
                            <label><input type="checkbox" name="approved[<?php echo $i;?>]" value="Y" <?php if ( isset($thetData['approved']) && $thetData['approved'] == 'Y' ) { echo 'checked'; } ?> ></label>
                          <?php } else { if( isset($thetData['approved']) && $thetData['approved'] == 'Y' ) { if ( $thetData['approved_notif'] == 0 ) { ?><label class="btn btn-default btn-small"><input type="checkbox" value="<?php echo $thetData['id']; ?>" name="id[<?php echo $i;?>]"> Send Notification</label> <?php } else if ( $thetData['approved_notif']==1 ) { ?> <span class="label label-success">Notification Sent</span> <?php } } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <input type="hidden" name="disbursed[<?php echo $i;?>]" value="N"> 
                            <label><input type="checkbox" name="disbursed[<?php echo $i;?>]" value="Y" <?php if ( isset($thetData['disbursed']) && $thetData['disbursed'] == 'Y' ) { echo 'checked'; } ?> ></label>
                          <?php } else { if( isset($thetData['disbursed']) && $thetData['disbursed'] == 'Y' ) { if ( $thetData['disbursed_notif'] == 0 ) { ?> <label class="btn btn-default btn-small"><input type="checkbox" value="<?php echo $thetData['id']; ?>" name="id[<?php echo $i;?>]"> Send Notification </label> <?php } else if ( $thetData['disbursed_notif']==1 ) { ?> <span class="label label-success">Notification Sent</span> <?php } } else { echo "N"; } } ?>
                      </td>
                    </tr>
                      
                  <?php $i++;} ?>

                </tbody>

              </table>

            </form>

          <?php } else if ($view == 'recon-tracking') {

            $database->query('SELECT 
              district AS location,
              wave,
              budget_cat,
              budget_type, 
              SUM(total) AS budget_total 
              FROM fin_budget_cat_districts
              GROUP BY location,wave,budget_cat,budget_type HAVING SUM(total) != 0') ;
            $results1 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $database->query('SELECT 
              county AS location,
              wave,
              budget_cat,
              budget_type, 
              SUM(total) AS budget_total 
              FROM fin_budget_cat_county
              GROUP BY location,wave,budget_cat,budget_type HAVING SUM(total) != 0') ;
            $results2 = $database->statement->fetchall(PDO::FETCH_ASSOC);

            $results = array_merge($results1, $results2); 

            if ( isset($_POST['save-return-tracking']) ) {

              foreach($_POST['wave'] as $key => $value) {
                $data = array(
                  'wave' => $_POST['wave'][$key], 
                  'budget_cat' => $_POST['budget_cat'][$key],
                  'budget_type' => $_POST['budget_type'][$key],
                  'location' => $_POST['location'][$key],
                  'received' => $_POST['received'][$key],
                  'processed' => $_POST['processed'][$key], 
                  'finalized' => $_POST['finalized'][$key], 
                  'approved' => $_POST['approved'][$key]
                );

                // Enter Action Log
                quickFuncLog(
                  $ArrayData = array(
                    0 => 4,
                    1 => 'Saved returns tracking',
                    2 => 'Saved returns tracking for '.$_POST['budget_type_name'].' Budget for '.$_POST['location'][$key].''
                  )
                );

                $financeClass->saveReturnsTracking($data);                  

              }
             // header('Location:'.basename($_SERVER['REQUEST_URI']));

            }

            ?>

            <h2>Returns Tracking</h2>

            <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post" >

              <div class="clearfix">

                <?php if($prevs['priv_reconciliation_return']>=3){ ?>
                  <ul class="list-unstyled pull-right">
                    <?php if (!isset($_POST['edit-return-tracking'])) {?>
                    <li class="pull-left" ><button class="btn btn-primary" type="subit" name="edit-return-tracking">Edit</button></li>
                    <?php } ?>
                    <li class="pull-left" >&nbsp;</li>
                    <?php if (isset($_POST['edit-return-tracking'])) {?>
                    <li class="pull-left" ><button class="btn btn-primary" type="subit" name="save-return-tracking">save</button></li>
                    <?php } ?>
                  </ul>
                <?php } ?>

              </div>

              <table class="table table-bordered form-list-table table-hover">

                <thead>
                  <tr>
                    <th>Reconsilliation Return Form</th>
                    <th>Location</th>
                    <th>Received</th>
                    <th>Processed</th>
                    <th>Finalized</th>
                    <th>Approval</th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                    foreach ($results as $key => $value) {

                      $database->query('SELECT * FROM fin_ret_tracking WHERE location = :location AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                        array(
                          ':location'   => $value['location'],
                          ':wave'     => $value['wave'], 
                          ':budget_cat' => $value['budget_cat'], 
                          ':budget_type'  => $value['budget_type']
                        )
                      );
                      $thetData = $database->statement->fetch(PDO::FETCH_ASSOC);

                      $database->query('SELECT budget_type FROM fin_budget_type WHERE id = :id', array(
                        ':id' => $value['budget_type']
                        )
                      ) ;
                      $budget_type = $database->statement->fetch(PDO::FETCH_ASSOC);             

                      $database->query('SELECT category FROM fin_budget_category WHERE id = :id', array(
                        ':id' => $value['budget_cat']
                        )
                      );
                      $budget_cat = $database->statement->fetch(PDO::FETCH_ASSOC); ?>

                    <tr>
                      <?php if (isset($_POST['edit-return-tracking'])) { ?>
                        <input type="hidden" name="wave[]" value="<?php echo $value['wave'] ?>" >
                        <input type="hidden" name="budget_cat[]" value="<?php echo $value['budget_cat'] ?>" >
                        <input type="hidden" name="budget_type[]" value="<?php echo $value['budget_type'] ?>" >
                        <input type="hidden" name="budget_type_name[]" value="<?php echo $budget_type['budget_type'] ?>" >
                        <input type="hidden" name="location[]" value="<?php echo $value['location'] ?>" >
                      <?php } ?>
                      <td>
                        <?php echo $budget_cat['category'] .' Budget '.$budget_type['budget_type']; ?></td>
                      <td>
                        <?php echo $value['location']; ?></td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <label><input type="checkbox" name="received[]" value="Y" <?php if ( isset($thetData['received']) && $thetData['received'] == 'Y' ) { echo 'checked'; } ?> ></label>
                            <input type="hidden" name="received[]" value="N"> 
                          <?php } else { if(isset($thetData['received'])) { echo $thetData['received']; } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <label><input type="checkbox" name="processed[]" value="Y" <?php if ( isset($thetData['processed']) && $thetData['processed'] == 'Y' ) { echo 'checked'; } ?> ></label>
                            <input type="hidden" name="processed[]" value="N"> 
                          <?php } else { if (isset($thetData['processed'])) { echo $thetData['processed']; } else { echo "N"; } } ?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <label><input type="checkbox" name="finalized[]" value="Y" <?php if ( isset($thetData['finalized']) && $thetData['finalized'] == 'Y' ) { echo 'checked'; } ?> ></label>
                            <input type="hidden" name="finalized[]" value="N"> 
                          <?php } else { if(isset($thetData['finalized'])) { echo $thetData['finalized']; } else { echo "N"; } }?>
                      </td>
                      <td>
                        <?php 
                          if (isset($_POST['edit-return-tracking'])) {?>
                            <label><input type="checkbox" name="approved[]" value="Y" <?php if ( isset($thetData['approved']) && $thetData['approved'] == 'Y' ) { echo 'checked'; } ?> ></label>
                            <input type="hidden" name="approved[]" value="N"> 
                          <?php } else { if(isset($thetData['approved'])) { echo $thetData['approved']; } else { echo "N"; } } ?>
                      </td>
                    </tr>
                      
                  <?php } ?>

                </tbody>

              </table>      

            </form>

          <?php } else if ($view == 'recon-report') { ?>

            <h2>Reconsiliation Returns Report</h2>

            <div class="bs-example bs-example-tabs">

              <ul id="myTab" class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#home" role="tab" data-toggle="tab">Sub-County Reconcilliation Returns Reports</a></li>
                <li><a href="#profile" role="tab" data-toggle="tab">County Reconcilliation Returns Reports</a></li>
              </ul>

              <div id="myTabContent" class="tab-content">

                <div class="tab-pane fade in active" id="home">

                  <div class="ret-report-container table-responsive">

                    <?php

                      $database->query('SELECT 
                        fin_budget_type.id as budget_type_id,
                        fin_budget_type.budget_type,
                        fin_budget_category.id as budget_category_id,
                        fin_budget_category.category
                        FROM fin_budget_type 
                        JOIN fin_budget_category ON fin_budget_type.category = fin_budget_category.id
                        WHERE fin_budget_type.category != 1 ORDER BY fin_budget_type.id ASC');
                      $budgetTypes = $database->statement->fetchall(PDO::FETCH_ASSOC);

                      $database->query('SELECT 
                        fin_budget_cat_districts.district,
                        fin_budget_cat_districts.wave as wave_id,
                        deworming_waves.deworming_wave,
                        districts.county
                        FROM fin_budget_cat_districts 
                        JOIN deworming_waves ON fin_budget_cat_districts.wave = deworming_waves.id
                        JOIN districts ON fin_budget_cat_districts.district = districts.district_name
                        GROUP BY district,wave'
                      );
                      $returnsData = $database->statement->fetchall(PDO::FETCH_ASSOC);     

                    ?>     
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th colspan="3"></th>
                          <?php foreach ($budgetTypes as $key => $value) { ?>
                              <th colspan="3"><?php echo $value['category'].' '.$value['budget_type'] ?></th>
                           <?php } ?>                      
                        </tr>
                        <tr>
                          <th>County</th>
                          <th>Sub County</th>
                          <th>Deworming Wave</th>
                          <?php foreach ($budgetTypes as $key => $value) { ?>
                              <th>Disbursed (KES)</th>
                              <th>Returns (KES)</th>
                              <th>Variance (KES)</th>
                          <?php } ?>
                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach ($returnsData as $key => $value) {?>
                          <tr>
                            <td><?php echo $value['county']; ?></td>
                            <td><?php echo $value['district']; ?></td>
                            <td><?php echo $value['deworming_wave']; ?></td>
                            <?php foreach ($budgetTypes as $key1 => $value1) {  
                              $database->query('SELECT 
                                SUM(fin_budget_cat_districts.total) as amount_disbursed,
                                SUM(fin_budget_cat_districts.total_spent) as returns
                                FROM fin_budget_cat_districts 
                                WHERE district = :district AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                                array(
                                  ':district' => $value['district'],
                                  ':wave' => $value['wave_id'],
                                  ':budget_cat' => $value1['budget_category_id'],
                                  ':budget_type' => $value1['budget_type_id']
                                )
                              );
                              $data = $database->statement->fetch(PDO::FETCH_ASSOC);
                              ?>
                              <td><?php if (!empty($data['amount_disbursed'])) { echo '<b>'.number_format($data['amount_disbursed']).'</b>'; } else { echo '<em><small>Budget Not Prepared</small></em>'; } ?></td>
                              <td><?php if (!empty($data['returns'])) { echo '<b>'.number_format($data['returns']).'</b>'; } else { echo '<em><small>No Returns Received</small></em>'; } ?></td>
                              <td><?php if (!empty($data['returns'])) { echo '<b>'.number_format($data['amount_disbursed'] - $data['returns']).'</b>'; } else { echo '<em><small>N/A</small></em>'; } ?></td>
                            <?php } ?>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div>

                </div>

                <div class="tab-pane fade" id="profile">
                  
                  <div class="ret-report-container table-responsive">

                    <?php                       
                      $database->query('SELECT 
                        fin_budget_type.id as budget_type_id,
                        fin_budget_type.budget_type,
                        fin_budget_category.id as budget_category_id,
                        fin_budget_category.category
                        FROM fin_budget_type 
                        JOIN fin_budget_category ON fin_budget_type.category = fin_budget_category.id
                        WHERE fin_budget_type.category = 1 ORDER BY fin_budget_type.id ASC');
                      $budgetTypes = $database->statement->fetchall(PDO::FETCH_ASSOC);

                      $database->query('SELECT 
                        fin_budget_cat_county.county,
                        fin_budget_cat_county.wave as wave_id,
                        deworming_waves.deworming_wave
                        FROM fin_budget_cat_county 
                        JOIN deworming_waves ON fin_budget_cat_county.wave = deworming_waves.id
                        GROUP BY county,wave'
                      );
                      $returnsData = $database->statement->fetchall(PDO::FETCH_ASSOC);     
                    ?>       
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th colspan="2"></th>
                          <?php foreach ($budgetTypes as $key => $value) { ?>
                              <th colspan="3"><?php echo $value['category'].' '.$value['budget_type'] ?></th>
                           <?php } ?>                      
                        </tr>
                        <tr>
                          <th>County</th>
                          <th>Deworming Wave</th>
                          <?php foreach ($budgetTypes as $key => $value) { ?>
                              <th>Disbursed (KES)</th>
                              <th>Returns (KES)</th>
                              <th>Variance (KES)</th>
                          <?php } ?>
                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach ($returnsData as $key => $value) {?>
                          <tr>
                            <td><?php echo $value['county']; ?></td>
                            <td><?php echo $value['deworming_wave']; ?></td>
                            <?php foreach ($budgetTypes as $key1 => $value1) {  
                              $database->query('SELECT 
                                SUM(fin_budget_cat_county.total) as amount_disbursed,
                                SUM(fin_budget_cat_county.total_spent) as returns
                                FROM fin_budget_cat_county 
                                WHERE county = :county AND wave = :wave AND budget_cat = :budget_cat AND budget_type = :budget_type',
                                array(
                                  ':county' => $value['county'],
                                  ':wave' => $value['wave_id'],
                                  ':budget_cat' => $value1['budget_category_id'],
                                  ':budget_type' => $value1['budget_type_id']
                                )
                              );
                              $data = $database->statement->fetch(PDO::FETCH_ASSOC);
                              ?>
                              <td><?php if (!empty($data['amount_disbursed'])) { echo '<b>'.number_format($data['amount_disbursed']).'</b>'; } else { echo '<em><small>Budget Not Prepared</small></em>'; } ?></td>
                              <td><?php if (!empty($data['returns'])) { echo '<b>'.number_format($data['returns']).'</b>'; } else { echo '<em><small>No Returns Received</small></em>'; } ?></td>
                              <td><?php if (!empty($data['returns'])) { echo '<b>'.number_format($data['amount_disbursed'] - $data['returns']).'</b>'; } else { echo '<em><small>N/A</small></em>'; } ?></td>
                            <?php } ?>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>

                  </div>   

                </div>

              </div>

            </div>

          <?php } else if ($view == 'refund-tracking') { ?>

            <h2>Refunds Tracking</h2>

            <div class="bs-example bs-example-tabs">

              <ul id="myTab" class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Sub County Refunds</a></li>
                <li><a href="#tab-2" role="tab" data-toggle="tab">County Refunds</a></li>
              </ul>

              <div id="myTabContent" class="tab-content">

                <div class="tab-pane fade in active" id="tab-1">

                  <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#tab-1-moh" role="tab" data-toggle="tab">MOH</a></li>
                    <li><a href="#tab-1-moest" role="tab" data-toggle="tab">MOEST</a></li>
                  </ul>

                  <div class="tab-content">

                    <div class="tab-pane fade in active" id="tab-1-moh">

                      <?php 

                        $database->query("SELECT 
                          fin_budget_cat_districts.district,
                          fin_budget_cat_districts.wave AS deworming_wave_id,
                          deworming_waves.deworming_wave,
                          districts.county
                          FROM fin_budget_cat_districts 
                          JOIN deworming_waves ON fin_budget_cat_districts.wave = deworming_waves.id
                          JOIN districts ON fin_budget_cat_districts.district = districts.district_name
                          WHERE fin_budget_cat_districts.budget_type IN ('2','4','6','8','10','11','13','15','16')
                          GROUP BY fin_budget_cat_districts.district, fin_budget_cat_districts.wave ASC");
                        $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

                        if ( isset($_POST['save-district-refunds']) || isset($_POST['save-county-refunds']) ) {

                          foreach($_POST['dewormin_wave'] as $key => $value) {

                            $data = array(
                              'dewormin_wave' => $_POST['dewormin_wave'][$key], 
                              'location'      => $_POST['location'][$key],
                              'location_type' => $_POST['location_type'][$key],
                              'paid'          => $_POST['paid'][$key],
                              'received'      => $_POST['received'][$key]
                            );
                            $financeClass->saveRefundsData($data);
                          }

                        }

                      ?>

                      <div class="table-responsive ref-table-container">

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                          <?php if ($prevs['priv_reconciliation_return'] >= 3 ) { ?>
                            <ul class="pull-right">
                              <?php if (isset($_POST['edit-district-refunds']) ) { ?>
                              <li><button type="submit" name="save-district-refunds" class="btn btn-primary">Save</button></li>
                              <?php } 
                              if (!isset($_POST['edit-district-refunds']) ) { ?>
                              <li><button type="submit" name="edit-district-refunds" class="btn btn-primary">Edit</button></li> 
                              <?php } ?>
                            </ul>
                          <?php } ?>
                          <br>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>County</th>
                                <th>Sub County</th>
                                <th>Deworming Wave</th>
                                <th>Amount Disbursed</th>
                                <th>Amount Spent</th>
                                <th>Variance</th>
                                <th>Refund Paid</th>
                                <th>Refund Received</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($districts as $key => $value) { 
                                $database->query("SELECT 
                                  SUM(fin_budget_cat_districts.total) AS total_disbursed,
                                  SUM(fin_budget_cat_districts.total_spent) AS total_spent
                                  FROM fin_budget_cat_districts 
                                  WHERE fin_budget_cat_districts.budget_type IN ('2','4','6','8','10','11','13','15','16')
                                  AND fin_budget_cat_districts.district = :district",
                                  array(
                                    ':district' => $value['district']
                                  )
                                );
                                $results = $database->statement->fetch(PDO::FETCH_ASSOC); 

                                $database->query('SELECT refund_paid,refund_received
                                  FROM fin_budget_refunds WHERE location = :location AND location_type = :location_type AND wave = :wave',
                                    array(
                                      ':location' => $value['district'],
                                      ':location_type' => 2,
                                      ':wave' => $value['deworming_wave_id']
                                    )
                                  );
                                $refunds = $database->statement->fetch(PDO::FETCH_ASSOC);

                              ?>                      
                              <input type="hidden" name="dewormin_wave[]" value="<?php echo $value['deworming_wave_id']; ?>">
                              <input type="hidden" name="location[]" value="<?php echo $value['district']; ?>">
                              <input type="hidden" name="location_type[]" value="2">
                              <tr>
                                <td><?php echo $value['county']; ?></td>
                                <td><?php echo $value['district']; ?></td>
                                <td><?php echo $value['deworming_wave']; ?></td>
                                <td><?php echo number_format($results['total_disbursed']); ?></td>
                                <td>
                                  <?php 
                                    if (!empty($results['total_spent'])) { 
                                      echo number_format($results['total_spent']); 
                                    } else { 
                                      echo '<em><small>No Returns Received</small></em>';  
                                    } 
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if (!empty($results['total_spent'])) { 
                                      echo number_format($results['total_disbursed']-$results['total_spent']); 
                                    } else { 
                                      echo '<em><small>No Returns Received</small></em>';  
                                    } 
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) { 
                                      if ( $results['total_spent'] > $results['total_disbursed']) { ?>
                                        <input type="text" name="paid[]" class="num-only" <?php if( !isset($_POST['edit-district-refunds']) ) { echo 'disabled'; } ?> value="<?php if (!empty($refunds['refund_paid'])) { echo $refunds['refund_paid']; } ?>" />
                                      <?php } else { ?>
                                        <input type="hidden" name="received[]" value="NULL" />
                                        <em><small>N/A</small></em>
                                      <?php }
                                    } else {
                                      echo '<em><small>No Returns Received</small></em>';
                                    } ?>
                                </td>
                                <td>
                                  <?php 
                                    if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) {
                                      if ( $results['total_spent'] < $results['total_disbursed']) { ?>
                                        <input type="text" name="received[]" class="num-only" <?php if( !isset($_POST['edit-district-refunds']) ) { echo 'disabled'; }?>  value="<?php if (!empty($refunds['refund_received'])) { echo $refunds['refund_received']; } ?>" />
                                      <?php } else { ?>                                    
                                        <input type="hidden" name="paid[]" value="NULL" />
                                        <em><small>N/A</small></em>
                                      <?php } 
                                    } else {
                                      echo '<em><small>No Returns Received</small></em>';
                                    } ?>
                                </td>
                              </tr>                          
                              <?php } ?>

                            </tbody>

                          </table>

                        </form>

                      </div>                  

                    </div>

                    <div class="tab-pane fade" id="tab-1-moest">

                      <?php 

                        $database->query("SELECT 
                          fin_budget_cat_districts.district,
                          fin_budget_cat_districts.wave AS deworming_wave_id,
                          deworming_waves.deworming_wave,
                          districts.county
                          FROM fin_budget_cat_districts 
                          JOIN deworming_waves ON fin_budget_cat_districts.wave = deworming_waves.id
                          JOIN districts ON fin_budget_cat_districts.district = districts.district_name
                          WHERE fin_budget_cat_districts.budget_type IN ('1','3','5','7','9','12','14','17')
                          GROUP BY fin_budget_cat_districts.district, fin_budget_cat_districts.wave ASC");
                        $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

                        if ( isset($_POST['save-district-refunds']) || isset($_POST['save-county-refunds']) ) {

                          foreach($_POST['dewormin_wave'] as $key => $value) {

                            $data = array(
                              'dewormin_wave' => $_POST['dewormin_wave'][$key], 
                              'location'      => $_POST['location'][$key],
                              'location_type' => $_POST['location_type'][$key],
                              'paid'          => $_POST['paid'][$key],
                              'received'      => $_POST['received'][$key]
                            );
                            $financeClass->saveRefundsData($data);
                          }

                        }

                      ?>

                      <div class="table-responsive ref-table-container">

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                          <?php if ($prevs['priv_reconciliation_return'] >= 3 ) { ?>
                            <ul class="pull-right">
                              <?php if (isset($_POST['edit-district-refunds']) ) { ?>
                              <li><button type="submit" name="save-district-refunds" class="btn btn-primary">Save</button></li>
                              <?php } 
                              if (!isset($_POST['edit-district-refunds']) ) { ?>
                              <li><button type="submit" name="edit-district-refunds" class="btn btn-primary">Edit</button></li> 
                              <?php } ?>
                            </ul>
                          <?php } ?>
                          <br>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>County</th>
                                <th>Sub County</th>
                                <th>Deworming Wave</th>
                                <th>Amount Disbursed</th>
                                <th>Amount Spent</th>
                                <th>Variance</th>
                                <th>Refund Paid</th>
                                <th>Refund Received</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($districts as $key => $value) { 
                                $database->query("SELECT 
                                  SUM(fin_budget_cat_districts.total) AS total_disbursed,
                                  SUM(fin_budget_cat_districts.total_spent) AS total_spent
                                  FROM fin_budget_cat_districts 
                                  WHERE fin_budget_cat_districts.budget_type IN ('1','3','5','7','9','12','14','17')
                                  AND fin_budget_cat_districts.district = :district",
                                  array(
                                    ':district' => $value['district']
                                  )
                                );
                                $results = $database->statement->fetch(PDO::FETCH_ASSOC); 

                                $database->query('SELECT refund_paid,refund_received
                                  FROM fin_budget_refunds WHERE location = :location AND location_type = :location_type AND wave = :wave',
                                    array(
                                      ':location' => $value['district'],
                                      ':location_type' => 2,
                                      ':wave' => $value['deworming_wave_id']
                                    )
                                  );
                                $refunds = $database->statement->fetch(PDO::FETCH_ASSOC);

                              ?>                      
                              <input type="hidden" name="dewormin_wave[]" value="<?php echo $value['deworming_wave_id']; ?>">
                              <input type="hidden" name="location[]" value="<?php echo $value['district']; ?>">
                              <input type="hidden" name="location_type[]" value="2">
                              <tr>
                                <td><?php echo $value['county']; ?></td>
                                <td><?php echo $value['district']; ?></td>
                                <td><?php echo $value['deworming_wave']; ?></td>
                                <td><?php echo number_format($results['total_disbursed']); ?></td>
                                <td>
                                  <?php 
                                    if (!empty($results['total_spent'])) { 
                                      echo number_format($results['total_spent']); 
                                    } else { 
                                      echo '<em><small>No Returns Received</small></em>';  
                                    } 
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if (!empty($results['total_spent'])) { 
                                      echo number_format($results['total_disbursed']-$results['total_spent']); 
                                    } else { 
                                      echo '<em><small>No Returns Received</small></em>';  
                                    } 
                                  ?>
                                </td>
                                <td>
                                  <?php 
                                    if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) { 
                                      if ( $results['total_spent'] > $results['total_disbursed']) { ?>
                                        <input type="text" name="paid[]" class="num-only" <?php if( !isset($_POST['edit-district-refunds']) ) { echo 'disabled'; } ?> value="<?php if (!empty($refunds['refund_paid'])) { echo $refunds['refund_paid']; } ?>" />
                                      <?php } else { ?>
                                        <input type="hidden" name="received[]" value="NULL" />
                                        <em><small>N/A</small></em>
                                      <?php }
                                    } else {
                                      echo '<em><small>No Returns Received</small></em>';
                                    } ?>
                                </td>
                                <td>
                                  <?php 
                                    if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) {
                                      if ( $results['total_spent'] < $results['total_disbursed']) { ?>
                                        <input type="text" name="received[]" class="num-only" <?php if( !isset($_POST['edit-district-refunds']) ) { echo 'disabled'; }?>  value="<?php if (!empty($refunds['refund_received'])) { echo $refunds['refund_received']; } ?>" />
                                      <?php } else { ?>                                    
                                        <input type="hidden" name="paid[]" value="NULL" />
                                        <em><small>N/A</small></em>
                                      <?php } 
                                    } else {
                                      echo '<em><small>No Returns Received</small></em>';
                                    } ?>
                                </td>
                              </tr>                          
                              <?php } ?>

                            </tbody>

                          </table>

                        </form>

                      </div>    

                    </div>

                  </div>

                </div>

                <div class="tab-pane fade" id="tab-2">

                  <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#tab-2-moh" role="tab" data-toggle="tab">MOH</a></li>
                    <li><a href="#tab-2-moest" role="tab" data-toggle="tab">MOEST</a></li>
                  </ul>

                  <div class="tab-content">

                    <div class="tab-pane fade in active" id="tab-2-moh">

                      <?php 

                        $database->query("SELECT 
                        fin_budget_cat_county.county,
                        fin_budget_cat_county.wave AS deworming_wave_id,
                        deworming_waves.deworming_wave
                        FROM fin_budget_cat_county 
                        JOIN deworming_waves ON fin_budget_cat_county.wave = deworming_waves.id
                        WHERE fin_budget_cat_county.budget_type IN ('2','4','6','8','10','11','13','15','16')
                        GROUP BY fin_budget_cat_county.county, fin_budget_cat_county.wave");
                        $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

                      ?>

                      <div class="table-responsive ref-table-container">

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                          <ul class="pull-right">
                            <?php if ($prevs['priv_reconciliation_return'] >= 3) { ?>
                              <?php if (isset($_POST['edit-county-refunds']) ) { ?>
                                <li><button type="submit" name="save-county-refunds" class="btn btn-primary">Save</button></li>
                              <?php } 
                              if (!isset($_POST['edit-county-refunds']) ) { ?>
                                <li><button type="submit" name="edit-county-refunds" class="btn btn-primary">Edit</button></li> 
                              <?php } ?>
                            <?php } ?>
                          </ul>
                          <br>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>County</th>
                                <th>Deworming Wave</th>
                                <th>Amount Disbursed</th>
                                <th>Amount Spent</th>
                                <th>Variance</th>
                                <th>Refund Paid</th>
                                <th>Refund Received</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($districts as $key => $value) { 

                                $database->query("SELECT 
                                  SUM(fin_budget_cat_county.total) AS total_disbursed,
                                  SUM(fin_budget_cat_county.total_spent) AS total_spent
                                  FROM fin_budget_cat_county 
                                  WHERE fin_budget_cat_county.budget_type IN ('2','4','6','8','10','11','13','15','16') AND
                                  fin_budget_cat_county.county = :county",
                                  array(
                                    ':county' => $value['county']
                                  )
                                );
                                $results = $database->statement->fetch(PDO::FETCH_ASSOC); 

                                $database->query('SELECT refund_paid,refund_received
                                  FROM fin_budget_refunds WHERE location = :location AND location_type = :location_type AND wave = :wave',
                                    array(
                                      ':location' => $value['county'],
                                      ':location_type' => 1,
                                      ':wave' => $value['deworming_wave_id']
                                    )
                                  );
                                $refunds_county = $database->statement->fetch(PDO::FETCH_ASSOC);

                              ?>

                              <input type="hidden" name="dewormin_wave[]" value="<?php echo $value['deworming_wave_id']; ?>">
                              <input type="hidden" name="location[]" value="<?php echo $value['county']; ?>">
                              <input type="hidden" name="location_type[]" value="1">
                                <tr>
                                  <td><?php echo $value['county']; ?></td>
                                  <td><?php echo $value['deworming_wave']; ?></td>
                                  <td><?php echo number_format($results['total_disbursed']); ?></td>
                                  <td>
                                    <?php 
                                      if (!empty($results['total_spent'])) { 
                                        echo number_format($results['total_spent']); 
                                      } else { 
                                        echo '<em><small>No Returns Received</small></em>';  
                                      } 
                                    ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if (!empty($results['total_spent'])) { 
                                        echo number_format($results['total_disbursed']-$results['total_spent']); 
                                      } else { 
                                        echo '<em><small>No Returns Received</small></em>';  
                                      } 
                                    ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) { 
                                        if ( $results['total_spent'] > $results['total_disbursed']) { ?>
                                          <input type="text" name="paid[]" class="num-only" <?php if( !isset($_POST['edit-county-refunds']) ) { echo 'disabled'; }?> value="<?php if (!empty($refunds_county['refund_paid'])) { echo $refunds_county['refund_paid']; } ?>"/>
                                        <?php } else {
                                          echo '<em><small>N/A</small></em>';
                                        }
                                      } else {
                                        echo '<em><small>No Returns Received</small></em>';
                                      } ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) {
                                        if ( $results['total_spent'] < $results['total_disbursed']) { ?>
                                          <input type="text" name="received[]" class="num-only" <?php if( !isset($_POST['edit-county-refunds']) ) { echo 'disabled'; }?> value="<?php if (!empty($refunds_county['refund_received'])) { echo $refunds_county['refund_received']; } ?>" />
                                        <?php } else {
                                          echo '<em><small>N/A</small></em>';
                                        } 
                                      } else {
                                        echo '<em><small>No Returns Received</small></em>';
                                      } ?>
                                  </td>
                                </tr>                          
                              <?php } ?>

                            </tbody>
                          </table>

                        </form>

                      </div>

                    </div>

                    <div class="tab-pane fade" id="tab-2-moest">
                    
                      <?php 

                        $database->query("SELECT 
                          fin_budget_cat_county.county,
                          fin_budget_cat_county.wave AS deworming_wave_id,
                          deworming_waves.deworming_wave
                        FROM fin_budget_cat_county 
                        JOIN deworming_waves ON fin_budget_cat_county.wave = deworming_waves.id
                        WHERE fin_budget_cat_county.budget_type IN ('1','3','5','7','9','12','14','17')
                        GROUP BY fin_budget_cat_county.county, fin_budget_cat_county.wave");
                        $districts = $database->statement->fetchall(PDO::FETCH_ASSOC);

                      ?>

                      <div class="table-responsive ref-table-container">

                        <form action="<?php basename( $_SERVER['REQUEST_URI'] ) ?>" method="post">

                          <ul class="pull-right">
                            <?php if ($prevs['priv_reconciliation_return'] >= 3) { ?>
                              <?php if (isset($_POST['edit-county-refunds']) ) { ?>
                                <li><button type="submit" name="save-county-refunds" class="btn btn-primary">Save</button></li>
                              <?php } 
                              if (!isset($_POST['edit-county-refunds']) ) { ?>
                                <li><button type="submit" name="edit-county-refunds" class="btn btn-primary">Edit</button></li> 
                              <?php } ?>
                            <?php } ?>
                          </ul>
                          <br>
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>County</th>
                                <th>Deworming Wave</th>
                                <th>Amount Disbursed</th>
                                <th>Amount Spent</th>
                                <th>Variance</th>
                                <th>Refund Paid</th>
                                <th>Refund Received</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($districts as $key => $value) { 

                                $database->query("SELECT 
                                  SUM(fin_budget_cat_county.total) AS total_disbursed,
                                  SUM(fin_budget_cat_county.total_spent) AS total_spent
                                  FROM fin_budget_cat_county
                                  WHERE fin_budget_cat_county.budget_type IN ('1','3','5','7','9','12','14','17') AND
                                  fin_budget_cat_county.county = :county",
                                  array(
                                    ':county' => $value['county']
                                  )
                                );
                                $results = $database->statement->fetch(PDO::FETCH_ASSOC); 

                                $database->query('SELECT refund_paid,refund_received
                                  FROM fin_budget_refunds WHERE location = :location AND location_type = :location_type AND wave = :wave',
                                    array(
                                      ':location' => $value['county'],
                                      ':location_type' => 1,
                                      ':wave' => $value['deworming_wave_id']
                                    )
                                  );
                                $refunds_county = $database->statement->fetch(PDO::FETCH_ASSOC);

                              ?>

                              <input type="hidden" name="dewormin_wave[]" value="<?php echo $value['deworming_wave_id']; ?>">
                              <input type="hidden" name="location[]" value="<?php echo $value['county']; ?>">
                              <input type="hidden" name="location_type[]" value="1">
                                <tr>
                                  <td><?php echo $value['county']; ?></td>
                                  <td><?php echo $value['deworming_wave']; ?></td>
                                  <td><?php echo number_format($results['total_disbursed']); ?></td>
                                  <td>
                                    <?php 
                                      if (!empty($results['total_spent'])) { 
                                        echo number_format($results['total_spent']); 
                                      } else { 
                                        echo '<em><small>No Returns Received</small></em>';  
                                      } 
                                    ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if (!empty($results['total_spent'])) { 
                                        echo number_format($results['total_disbursed']-$results['total_spent']); 
                                      } else { 
                                        echo '<em><small>No Returns Received</small></em>';  
                                      } 
                                    ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) { 
                                        if ( $results['total_spent'] > $results['total_disbursed']) { ?>
                                          <input type="text" name="paid[]" class="num-only" <?php if( !isset($_POST['edit-county-refunds']) ) { echo 'disabled'; }?> value="<?php if (!empty($refunds_county['refund_paid'])) { echo $refunds_county['refund_paid']; } ?>"/>
                                        <?php } else {
                                          echo '<em><small>N/A</small></em>';
                                        }
                                      } else {
                                        echo '<em><small>No Returns Received</small></em>';
                                      } ?>
                                  </td>
                                  <td>
                                    <?php 
                                      if ( !empty($results['total_spent']) && !empty($results['total_disbursed']) ) {
                                        if ( $results['total_spent'] < $results['total_disbursed']) { ?>
                                          <input type="text" name="received[]" class="num-only" <?php if( !isset($_POST['edit-county-refunds']) ) { echo 'disabled'; }?> value="<?php if (!empty($refunds_county['refund_received'])) { echo $refunds_county['refund_received']; } ?>" />
                                        <?php } else {
                                          echo '<em><small>N/A</small></em>';
                                        } 
                                      } else {
                                        echo '<em><small>No Returns Received</small></em>';
                                      } ?>
                                  </td>
                                </tr>                          
                              <?php } ?>

                            </tbody>
                          </table>

                        </form>

                      </div>

                    </div>

                  </div>



                </div>

              </div>

            </div>

          <?php }

        ?>

      </div><!--end of content body -->

    </div>
    <!--end of content Main -->

    <!--jQuery Include-->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

    <!--Bootstrap3 Js Include-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
      $('#myTab a').click(function (e) {
          e.preventDefault();
          $(this).tab('show');
      });

      // store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
          var id = $(e.target).attr("href").substr(1);
          window.location.hash = id;
      });

      // on load of the page: switch to the currently selected tab
      var hash = window.location.hash;
      $('#myTab a[href="' + hash + '"]').tab('show');
    </script>

    <!-- combine identical dimension fields in product data tables -->
    <script type="text/javascript">
      $('#budget-table').each(function () {
       
          var dimension_cells = new Array();
          var dimension_col = null;
       
          var i = 1;
          // First, scan first row of headers for the "Dimensions" column.
          $(this).find('th').each(function () {
              if ($(this).text() == 'Item Category') {
                  dimension_col = i;
              }
              i++;
          });
       
          // first_instance holds the first instance of identical td
          var first_instance = null;
          // iterate through rows
          $(this).find('tr').each(function () {
       
              // find the td of the correct column (determined by the dimension_col set above)
              var dimension_td = $(this).find('td:nth-child(' + dimension_col + ')');

              if (first_instance == null) {
                  // must be the first row
                  first_instance = dimension_td;
              } else if (dimension_td.text() == first_instance.text()) {
                  console.log(first_instance.text());
                  // the current td is identical to the previous
                  // remove the current td
                  dimension_td.remove();
                  // increment the rowspan attribute of the first instance
                  first_instance.attr('rowspan', parseFloat(first_instance.attr('rowspan')) + parseFloat(1));
              } else {
                  // this cell is different from the last
                  first_instance = dimension_td;
              }
       
          });
      });
    </script>

    <!-- jQuery Data Tables -->
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        var table = $('#data-table').DataTable();
      });
    </script>

    <!--Auto Fill reconsiliation variance fields-->
    <script type="text/javascript">
      function autoFillFields(parent) {
        var advanced = parent.find('td.advanced input').val(),
            spent = parent.find('td.spent input').val(); 

        if (spent) {

          var variance = advanced - spent;
          parent.find('td.variance input').attr('value',variance);

          var spentArray = [];

          $('#recon-table').find('td.spent input').each(function () {
            spentArray.push($(this).val());
          });

          var spentTotal = 0;
          $.each(spentArray,function() {
              spentTotal = Number(this) + Number(spentTotal);
          });
          $('td#spent-total').html('<b>'+spentTotal+'<b>');
          $('td#variance-total').html('<b>'+(<?php echo $budget_total; ?> - spentTotal)+'<b>');

        }

      }

      $('#recon-table').find('tr.data-row').each(function() {
        autoFillFields($(this));
      }).on('change', $(this).find('td.spent input'), function() {
        autoFillFields($(this));
      });        
    </script>

    <!--Auto Calculate Butdget Item total-->
    <script type="text/javascript">
      $('#budget-form-container').find('table tr').on( 'change', $('.units input,.days input,.unit_cost input'), function(){

          var value_1 = $(this).find('.units input').val(),
              value_2 = $(this).find('.days input').val(),
              value_3 = $(this).find('.unit_cost input').val(),
              prod    = value_1 * value_2 * value_3;

          $(this).find('.total input').attr('value',prod);

        });
    </script>

    <!--Prevent Entry of non numericals in selected fields-->
    <script type="text/javascript">
      $(document).find("input.num-only").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
              // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
              // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
              // let it happen, don't do anything
              return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });
    </script>

    <!-- prevent form submit on pressing enter -->
    <script type="text/javascript">
      $(document).keypress(
          function(event){
           if (event.which == '13') {
              event.preventDefault();
            }
      });
    </script>

    <!--Datepicker Javascript-->
    <script type="text/javascript" src="../calendar/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

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

  </body>

</html>