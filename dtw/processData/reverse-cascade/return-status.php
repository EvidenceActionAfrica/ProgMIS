<?php

require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
require_once("../../includes/logTracker.php");
$M_module =6;
require_once("includes/class.return-status.php");

// include "returnStatus.func.php";

//instansiate class
$returnStatus = new returnStatus;

//$returnStatus->getRolloutData();
// echo $dd["COUNT(*)"];
// echo "<pre>";var_dump($dd);echo "</pre>";

// get districts
$districts = $returnStatus->getDistricts();

// get all return status data
$data= $returnStatus->getAll();

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$returnStatus->getById($id);
}

// update
if (isset($_POST['update-log-submit'])) {
  $id=$_POST['id'];
    $details=$returnStatus->getById($id);
    $district=$returnStatus->getDistName($details[0]['district_id']);
    

         $action="Sub-County Returns : updated Forms";
         $description="Sub-county ".$district." has been updated.The updates are: ";

          // $district_name = $_POST['district_id'];
          // $regional_training_end = $_POST['regional_training_end'];
          // die();
        // exit();
           //handle the check
         if (empty($_POST['moe_financial_returns_received'])) {
            $moe_financial_returns_received="N";
          }else{
            $moe_financial_returns_received = $_POST['moe_financial_returns_received'];
            
          }



          if (empty($_POST['rt_moe_recieved'])) {
            $rt_moe_recieved = 'N';
       

          }else{
            $rt_moe_recieved = $_POST['rt_moe_recieved'];
          }
      
          $description.=' Regional Training MoEST has been set to '.$rt_moe_recieved.'.';

          if (empty($_POST['rt_mophs_recieved'])) {
            $rt_mophs_recieved = 'N';
            
          }else{
            $rt_mophs_recieved = $_POST['rt_mophs_recieved'];
          }
          $description.=' Regional Training MOH has been set to '.$rt_mophs_recieved.'.';

          if (empty($_POST['dd_moe_recieved'])) {
            $dd_moe_recieved = 'N';
            
          }else{
            $dd_moe_recieved = $_POST['dd_moe_recieved'];
          }
          $description.=' Sub-County DD MOEST has been set to '.$dd_moe_recieved.'.';

       
          if (empty($_POST['dd_mophs_recieved'])) {
            $dd_mophs_recieved = 'N';
            
          }else{
            $dd_mophs_recieved = $_POST['dd_mophs_recieved'];
          }
          $description.=' Sub-County DD MOH has been set to '.$dd_mophs_recieved.'.';

          if (empty($_POST['tts_moe_recieved'])) {
            $tts_moe_recieved = 'N';
            
          }else{
            $tts_moe_recieved = $_POST['tts_moe_recieved'];
          }
          $description.=' Teacher Training MoEST has been set to '.$tts_moe_recieved.'.';

          if (empty($_POST['tts_mophs_recieved'])) {
            $tts_mophs_recieved = 'N';
            
          }else{
            $tts_mophs_recieved = $_POST['tts_mophs_recieved'];
          }
          $description.=' Teacher Training MOPHS has been set to '.$tts_moe_recieved.'.';

  $returnStatus->update(
                          $id,
                          $rt_moe_recieved,
                          $rt_mophs_recieved,
                          $tts_moe_recieved,
                          $tts_mophs_recieved,
                          $dd_moe_recieved,
                          $dd_mophs_recieved

                    );
  // exit();
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);

  header("Location:return-status.php?saved=1&#close");

}



// privileges check.DO NOT TOUCH

$resPriv =$returnStatus->checkPrivilege();

foreach ($resPriv as $key => $value) {
	$priv_log_forms_analysed=$value['priv_log_forms_analysed'];			# code...
			}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
         <?php require_once ("includes/menuLeftBar-Reverse.php"); ?>
      </div>
      <div class="contentBody">
        <!-- <h1>RETURN STATUS</h1> -->
        <form action="#">
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/counties.php">Export to Excel</a> -->
          <!-- <a class="btn btn-primary" href="#addCounty">Add Return Status</a> -->
        </form>

      <div id="data-table-container">

            <div id="data-table-manger">
              

          <div class="col-md-4">
            <!-- <button title="Add"class="btn btn-primary btn-xs" id="show-form">+</button> -->
            <?php 
              if (isset($_GET['saved'])) {
                ?>
                  <div class="alert alert-success saved-info">
                  <!-- <a href="#" class="close" data-dismiss="alert">&times;</a> -->
                  <strong>Success!</strong> Data has been updated.
                </div>  
                <div class="vclear"></div>

                <?php
              }
             ?>
          </div>
          <div class="small-heading col-md-5">FINANCIAL RETURNS</div>
          
          <div>   <?php if( $priv_log_forms_analysed>=1){?><span class=""><a class="pink-button" href="exportExcelReturnStatus.php"> Export To Excel</a></span>   <?php }?> </div>
         <div class="clearfix"></div>
          <hr>
          </div>

 

        <table id="data-table" class="return-status row-border">
          <thead>
          <tr>
            <th rowspan="2">Sub-County Name</th>
            <th colspan="2">S.C.T</th>
            <th colspan="2">TTS</th>
            <th colspan="2">D D</th>
            <th rowspan="2">Flags</th>
            <th rowspan="2">Edit</th>
          </tr>

            <tr>
              <th>MoE</th>
              <th>MoH</th>
              <th>MoE</th>
              <th>MoH</th>
              <th>MoE</th>
              <th>MoH</th>
            </tr>

          </thead>
        

           <tbody>
      
          <?php 
          $i=1;
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              # code...
              ?>
                  <tr>
                    <td class="" id='district_name-td<?php echo $i;?>'><?php echo $returnStatus->getDistName($value['district_id']) ?></td>
                    <!-- <td id='regional_training_end-td<?php echo $i;?>'><?php echo date("F j, Y", strtotime($value['regional_training_end'])) ; ?></td> -->
                    <td class="align-td" id='rt_moe_recieved-td<?php echo $i;?>'><?php echo $value['rt_moe_recieved'] ?></td>
                    <td class="align-td" id='rt_mophs_recieved-td<?php echo $i;?>'><?php echo $value['rt_mophs_recieved'] ?></td>
                    <td class="align-td" id='tts_moe_recieved-td<?php echo $i;?>'><?php echo $value['tts_moe_recieved'] ?></td>
                    <td class="align-td" id='tts_mophs_recieved-td<?php echo $i;?>'><?php echo $value['tts_mophs_recieved'] ?></td>
                    <td class="align-td" id='dd_moe_recieved-td<?php echo $i;?>'><?php echo $value['dd_moe_recieved'] ?></td>
                    <td class="align-td" id='dd_mophs_recieved-td<?php echo $i;?>'><?php echo $value['dd_mophs_recieved'] ?></td>
                    <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>"/>

                    <!-- warning -->
                    <td class="align-td"> <?php echo $returnStatus->getWarning($value['district_id'],$value['regional_training_end']) ?> </td>


                    <td id="<?php echo $i;?>" title="edit" class="editc align-td">
                      <a  href="#editSchool"><img src="../../images/icons/edit2.png"></a>
                    </td>
                  </tr>
              <?php
              $i++;
            } 

          }
            
           ?>
         


          </tbody>

        </table>
      </div>  <!-- End data table container-->



       <!--==== Modal EDIT ======-->
        <div id="editSchool" class="modalDialog">
          <div>
            <a href="#close" title="Close" class="modalclose">X</a>
            <div id="data-table-manger">
              <div class="small-heading col-md-6 col-md-offset-5">EDIT RETURN STATUS</div>
             <div class="clearfix"></div>
              <hr>
            </div>

            <div id="hor-form2" class="col-md-offset-2">
             <form action="" method="post" class="form-horizontal" class="" role="form">

                <!-- GEOGRAPHY -->
                <div class="form-group">
                  <label for="district_name" class="col-md-3 control-label">Sub-Count Name</label>
                  <div class="col-md-3">
                    <input type="text" class="form-control input-sm" name="regional_training_end" id="district_name_input" disabled>
                  </div>  
                </div>

                <!-- REGIONAL TRAINING -->
                <!--<div class="form-group">
                  <label for="regional_training_end" class="col-md-3 control-label">Sub county Training</label><div id="test"></div>
                     <div class="col-md-2">
                        <input type="text" class="form-control input-sm" name="regional_training_end" id="regional_training_end_input" disabled>
                    </div> -->
                  <div class="form-group">
                    <label for="regional_training_end" class="col-md-3 control-label">Regional Training</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="rt_moe_recieved_input" name="rt_moe_recieved" >MOE
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="rt_mophs_recieved_input" name="rt_mophs_recieved"  >MOH
                      </div> 
                    </div>

                <!-- TEACHER TRAINING -->
                <div class="form-group">
                    <label for="regional_training_end" class="col-md-3 control-label">Teacher Training</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="tts_moe_recieved_input" name="tts_moe_recieved" >MOE
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="tts_mophs_recieved_input" name="tts_mophs_recieved" >MOH
                      </div> 
                    </div>


                <!-- DISTRIT DEWORMING -->

                <div class="form-group">
                    <label for="regional_training_end" class="col-md-3 control-label">Sub-County DD</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="dd_moe_recieved_input" name="dd_moe_recieved" >MOE
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="dd_mophs_recieved_input" name="dd_mophs_recieved" >MOH
                      </div> 
                    </div>
                    

                <!-- hidden id field -->
                <input type="hidden" name="id" id="form_id" >

                      <button type="submit" name="update-log-submit" class="btn btn-default col-md-offset-6">Save</button>
              </form>
            </div>
          </div>
        </div>

      </div> <!-- end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>
<!-- <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="css/dataTables.css"> -->

<script type="text/javascript">
  $(document).ready(function() {
  $('#data-table').dataTable();


  } );
</script>



