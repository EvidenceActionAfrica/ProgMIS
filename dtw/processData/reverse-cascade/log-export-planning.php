<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
require_once("includes/class.log-export-planning.php");
require_once("../../includes/logTracker.php");
$M_module =6;

//instaciate class
$logExport = new logExport;

//get districts
$districts = $logExport->getDistricts();

$logExport->getRolloutData();

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


  if (empty($_POST['p_received'])) {
    $p_received ="N";
  }else{
    $p_received = $_POST['p_received'];
  }
  $description.=',Scrutinzed set to '.$p_couriered;
    if (empty($_POST['p_couriered'])) {
    $p_couriered ="N";
  }else{
    
    $p_couriered = $_POST['p_couriered'];
  }
  $description.=',Scrutinzed set to '.$mt_received;
    if (empty($_POST['mt_received'])) {
    $mt_received ="N";
  }else{   
    $mt_received = $_POST['mt_received'];
  }
  $description.=',Scrutinzed set to '.$mt_received;
    if (empty($_POST['mt_couriered'])) {
    $mt_couriered ="N";
  }else{
    
    $mt_couriered = $_POST['mt_couriered'];
  }
  $description.=',Scrutinzed set to '.$mt_couriered;
    if (empty($_POST['attsc_moe_received'])) {
    $attsc_moe_received="N";    
  }else{
    $attsc_moe_received = $_POST['attsc_moe_received'];
  }
  $description.=',Scrutinzed set to '.$attsc_moe_received;
    if (empty($_POST['attsc_moe_couriered'])) {
    $attsc_moe_couriered="N";    
  }else{
    $attsc_moe_couriered=$_POST['attsc_moe_couriered'];
  }
  $description.=',Scrutinzed set to '.$attsc_moe_couriered;

    if (empty($_POST['attsc_moh_received'])) {
      $attsc_moh_received='N';
    
  }else{
    $attsc_moh_received= $_POST['attsc_moh_received'];
    
    
  }
  $description.=',Scrutinzed set to '.$attsc_moh_received;
    if (empty($_POST['attsc_moh_couriered'])) {
    $attsc_moh_couriered="N";
  }else{
    $attsc_moh_couriered= $_POST['attsc_moh_couriered'];
  }
  $description.=',Scrutinzed set to '.$attsc_moh_couriered;

  $attsc_moe_qty = $_POST['attsc_moe_qty'];
  $attsc_moh_qty = $_POST['attsc_moh_qty'];

  $logExport->update(
                      $id,
                      $p_received,
                      $p_couriered,
                      $mt_received,
                      $mt_couriered,
                      $attsc_moe_received,
                      $attsc_moe_qty,
                      $attsc_moe_couriered,
                      $attsc_moh_received,
                      $attsc_moh_qty,
                      $attsc_moh_couriered
    );
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
  header("Location:log-export-planning.php?log=".$form_type."&saved=1&#close");
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
          <div class="small-heading col-md-6">PLANNING RETURN STATUS</div>
          <div>   <span class=""><a class="pink-button" href="exportExcelLog-planning.php"> Export To Excel</a></span>    </div>
         <div class="clearfix"></div>
          <hr>
          </div>

      <div class="panel-heading"><h3>Planning Return Records</h3></div>
        <table id="data-table" class="log-export-planning row-border">
          <thead>
            <tr>
              <th rowspan="1">Subcounty</th>
              <th rowspan="1">Division</th>
              <th style="text-align:center;" colspan="2">P</th>
              <th style="text-align:center;" colspan="2">MT</th>
              <th style="text-align:center;" colspan="3">ATTSC MoE</th>
              <th style="text-align:center;" colspan="3">ATTSC MoH</th>
             <?php //if( $priv_log_forms_analysed>=3){?> 
              <th rowspan="2">Flag</th>
              <th rowspan="2">Edit</th>
              <?php //}?> 
            </tr>          
            <tr > 
              <td ></td>
              <td ></td>
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Qty</td>
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
                    <td id="division_id-td<?php echo $i;?>"><?php echo $logExport->getDivName($value['division_id'])?></td>
                    <td class="align-td" id="p_received-td<?php echo $i;?>"><?php echo $value['p_received'] ?></td>
                    <td class="align-td" id="p_couriered-td<?php echo $i;?>"><?php echo $value['p_couriered'] ?></td>
                    <td class="align-td" id="mt_received-td<?php echo $i;?>"><?php echo $value['mt_received'] ?></td>
                    <td class="align-td" id="mt_couriered-td<?php echo $i;?>"><?php echo $value['mt_couriered'] ?></td>
                    <td class="align-td" id="attsc_moe_received-td<?php echo $i;?>"><?php echo $value['attsc_moe_received']?></td>
                    <td class="align-td" id="attsc_moe_qty-td<?php echo $i;?>"><?php echo $value['attsc_moe_qty'] ?></td>
                    <td class="align-td" id="attsc_moe_couriered-td<?php echo $i;?>"><?php echo $value['attsc_moe_couriered']?></td>
                    <td class="align-td" id="attsc_moh_received-td<?php echo $i;?>"><?php echo $value['attsc_moh_received']?></td>
                    <td class="align-td" id="attsc_moh_qty-td<?php echo $i;?>"><?php echo $value['attsc_moh_qty'] ?></td>
                    <td class="align-td" id="attsc_moh_couriered-td<?php echo $i;?>"><?php echo $value['attsc_moh_couriered']?></td>                                   
                    <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>" hidden/>
                    <!-- flag -->
                    <td class='align-td' > <?php //echo $logExport->getWarning($value['end_date'],$value['district_id'],$value['form_type']) ?> </td>

                    <td id="<?php echo $i;?>" title="edit" class="edit-log-export-planning align-td">
                    <a  href="#edit-log-export-planning"><img src="../../images/icons/edit2.png"></a>                            

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
        <div id="edit-log-export-planning" class="modalDialog">
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
                  <div class="form-group">
                    <label for="division_name" class="col-md-2 control-label">Division</label>
                    <div class="col-md-2">
                      <input type="text" id="division_input"  class="form-control input-sm" name="" disabled>
                    </div>  
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center" ><b>Form P</b><Br/ >
                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="p_received" id="p_received_input">
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="p_couriered" id="p_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center"><b> Form MT</b><Br/ >
                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="mt_received" id="mt_received_input" >
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="mt_couriered" id="mt_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center" sytle="padding-left: 50px;"><b>ATTSC MoE</b><Br/>
                    <label for="courier" class="col-md-2 control-label" >Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="attsc_moe_received" id="attsc_moe_received_input" >
                      </div>

                     <div class="col-md-2">
                          <input type="number" class="form-control input-sm" name="attsc_moe_qty" id="attsc_moe_qty_input" placeholder="Quantity" >
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="attsc_moe_couriered" id="attsc_moe_couriered_input" >
                      </div> 
                  </div>
                  <Br/ ><Br/ >
                  <div class="form-group" align="center"><b>ATTSC MoH</b><Br/ >
                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" name="attsc_moh_received" id="attsc_moh_received_input" >
                      </div>

                     <div class="col-md-2">
                          <input type="number" class="form-control input-sm" name="attsc_moh_qty" id="attsc_moh_qty_input" placeholder="Quantity" required>
                      </div>
                    <label for="courier" class="col-md-1 control-label">Date Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="attsc_moh_couriered" id="attsc_moh_couriered_input" >
                      </div> 
                  </div>

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





