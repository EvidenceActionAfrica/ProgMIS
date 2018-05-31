<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
require_once("includes/class.log-export-treatment.php");
require_once("../../includes/logTracker.php");
$M_module =6;

//instaciate class
$logExport = new logExport;

//get districts
$districts = $logExport->getDistricts();

// $form_type = $logExport->form_types();
$logExport->getRolloutData();
$form_type = $logExport::form_types();
$data= $logExport->getAll();
  

//update the data
if (isset($_POST['update-log-submit'])) {
  $id=$_POST['id'];

  $action="Log ".$_GET['log']. " : Log in Forms";
  // $districtId='';
  // foreach ($data as $key => $value) {
  //   if($value["id"]==$id){
  //     $districtId=$value['district_id'];
  //   }
  // }
  //$newDistrict=$logExport->getDistName($districtId); 
  $divisionId='';
  foreach ($data as $key => $value) {
    if($value["id"]==$id){
      $divisionId=$value['division_id'];
    }
  } 
  $newDivision=$logExport->getDivName($divisionId);
  $description="The division ".$newDivision." has been updated.The updates are: ";
 
  //end f part 1 logs

  //handle the checkboxes

  if (empty($_POST['moh_517c_received'])) {
    $moh_517c_received ="N";
  }else{
    $moh_517c_received = $_POST['moh_517c_received'];
  }
  $description.=',Scrutinzed set to '.$moh_517c_received;
  if (empty($_POST['moh_517c_couriered'])) {
    $moh_517c_couriered ="N";
  }else{
    $moh_517c_couriered = $_POST['moh_517c_couriered'];
  }
  $description.=',Scrutinzed set to '.$moh_517c_couriered;
    if (empty($_POST['moh_517d_received'])) {
    $moh_517d_received ="N";
  }else{
    
    $moh_517d_received = $_POST['moh_517d_received'];
  }
  $description.=',Scrutinzed set to '.$moh_517d_received;
    if (empty($_POST['moh_517d_couriered'])) {
    $moh_517d_couriered ="N";
  }else{   
    $moh_517d_couriered = $_POST['moh_517d_couriered'];
  }
  $description.=',Scrutinzed set to '.$moh_517d_couriered;
    if (empty($_POST['moh_517e_received'])) {
    $moh_517e_received ="N";
  }else{
    
    $moh_517e_received = $_POST['moh_517e_received'];
  }
  $description.=',Scrutinzed set to '.$mt_couriered;
    if (empty($_POST['moh_517e_qty'])) {
    $moh_517e_qty="N";    
  }else{
    $moh_517e_qty = $_POST['moh_517e_qty'];
  }
  $description.=',Scrutinzed set to '.$attsc_moe_received;
    if (empty($_POST['moh_517e_couriered'])) {
    $moh_517e_couriered="N";    
  }else{
    $moh_517e_couriered=$_POST['moh_517e_couriered'];
  }
  $description.=',Scrutinzed set to '.$moh_517e__couriered;

  $logExport->update(
                      $id,
                      $moh_517c_received,
                      $moh_517c_couriered,
                      $moh_517d_received,
                      $moh_517d_couriered,
                      $moh_517e_received,
                      $moh_517e_qty,
                      $moh_517e_couriered
    );
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
  header("Location:log-export-treatment.php?log=".$form_type."&saved=1&#close");
}

// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$logExport->getById($id);
}
// privileges check.DO NOT TOUCH

$resPriv =$logExport->checkPrivilege();

foreach ($resPriv as $key => $value) {
  $priv_log_forms=$value['priv_log_forms'];     # code...
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

    <div id="">

             <div id="data-table-manger">

          <div class="col-md-3">
             <?php 
              if (isset($_GET['saved'])) {
                ?>
                  <div class="alert alert-success saved-info">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Success!</strong> Data has been saved.
                </div>  
                <div class="vclear"></div>

                <?php
              }
             ?>
          </div>
          <div class="small-heading col-md-6">TREATMENT RETURN STATUS</div>
          <div>   <span class=""><a class="pink-button" href="exportExcelLog-treatment.php"> Export To Excel</a></span>    </div>
         <div class="clearfix"></div>
          <hr>
          </div>

      <div class="panel-heading"><h3>Treatment Return Records</h3></div>
        <table id="data-table" class="log-export-treatment row-border">
          <thead>
            <tr>
              <th rowspan="1">Subcounty</th>
              <th style="text-align:center;" colspan="2">MoH 517C</th>
              <th style="text-align:center;" colspan="2">MoH 517D</th>
              <th style="text-align:center;" colspan="3">MoH 517E</th>
             <?php //if( $priv_log_forms_analysed>=3){?> 
              <th rowspan="2">Flag</th>
              <th rowspan="2">Edit</th>
              <?php //}?> 
            </tr>          
            <tr > 
              <td ></td>
              
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Qty</td>
              <td>Couriered</td>

            </tr>
          </thead>
          <tbody>
          <?php 
          $i=1;

          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {

              ?>
                  <tr id="tr-<?php echo $i;?>">
                    <td id="district_id-td<?php echo $i;?>"><?php echo $logExport->getDistName($value['district_id'])?></td>
                    <td class="align-td" id="moh_517c_received-td<?php echo $i;?>"><?php echo $value['moh_517c_received'] ?></td>
                    <td class="align-td" id="moh_517c_couriered-td<?php echo $i;?>"><?php echo $value['moh_517c_couriered'] ?></td>
                    <td class="align-td" id="moh_517d_received-td<?php echo $i;?>"><?php echo $value['moh_517d_received'] ?></td>
                    <td class="align-td" id="moh_517d_couriered-td<?php echo $i;?>"><?php echo $value['moh_517d_couriered'] ?></td>
                    <td class="align-td" id="moh_517e_received-td<?php echo $i;?>"><?php echo $value['moh_517e_received']?></td>
                    <td class="align-td" id="moh_517e_qty-td<?php echo $i;?>"><?php echo $value['moh_517e_qty'] ?></td>
                    <td class="align-td" id="moh_517e_couriered-td<?php echo $i;?>"><?php echo $value['moh_517e_couriered']?></td>
                                   
                    <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>" hidden/>
                    <!-- flag -->
                    <td class='align-td' > <?php echo $logExport->getWarning() ?> </td>

                    <td id="<?php echo $i;?>" title="edit" class="edit-log-export-treatment align-td">
                    <a  href="#edit-log-export-treatment"><img src="../../images/icons/edit2.png"></a>                            

                    </td>
                  </tr>
              <?php
              $i++;
            }
          }
           ?>
          </tbody>
        </table>  
       </div>  <!-- End Data table container -->

        <!--==== Modal EDIT ======-->
        <div id="edit-log-export-treatment" class="modalDialog">
          <div>
            <a href="#close" title="Close" class="modalclose">X</a>
              <div id="data-table-manger">
                <div class="col-md-3">
                  <!-- <button title="Add"class="btn btn-primary btn-xs" id="show-form">+</button> -->
                </div>
                <div class="small-heading col-md-6">TRACKING SUBCOUNTY RETURN STATUS</div>
                <div class="clearfix"></div>
                <hr>
                </div>

              
              <div id="hor-form2">
                <form action="" method="post" class="form-horizontal" role="form">
                  <div class="form-group">
                    <label for="district_name" class="col-md-2 control-label">Subcounty</label>
                    <div class="col-md-2">
                      <input type="text" id="district_input"  class="form-control input-sm" name="" disabled>
                    </div>  
                  </div>
                  
                  <Br/ ><Br/ >
                  <div class="form-group" align="center" ><b>MoH 517C</b><Br/ >
                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="moh_517c_received" id="moh_517c_received_input">
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="moh_517c_couriered" id="moh_517c_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center"><b> MoH 517D</b><Br/ >
                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="moh_517d_received" id="moh_517d_received_input" >
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="moh_517d_couriered" id="moh_517d_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center" sytle="padding-left: 50px;"><b>MoH 517E</b><Br/>
                    <label for="courier" class="col-md-2 control-label" >Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="moh_517e_received" id="moh_517e_received_input" >
                      </div>

                     <div class="col-md-2">
                          <input type="number" class="form-control input-sm" name="moh_517e_qty" id="moh_517e_qty_input" placeholder="Quantity" >
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="moh_517e_couriered" id="moh_517e_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  

                  <!-- hidden id field -->
                  <input type="hidden" name="id" id="form_id" >

                  <?php //if( $priv_log_forms_analysed>=2){?>
                  <button type="submit" name="update-log-submit" class="btn btn-default update-log-submit">Save</button>
                  <?php //} 
                  ?>
              </form>
            </div>
          </div>
        </div> <!--end modal-->


      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>
<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>





