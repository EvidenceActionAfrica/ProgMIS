<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
include "includes/class.CountyReturn.php";
require_once("../../includes/logTracker.php");
$M_module =6;
//instansiate class
$countyReturn = new countyReturn;

$countyReturn->getRolloutData();

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

// get counties
$counties = $countyReturn->getCounties();

// get all county returns data
$data= $countyReturn->getAll();

// get the assumption by ID
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];

  $details=$countyReturn->getById($id);
}

// update
if (isset($_POST['update-log-submit'])) {
          

          $id=$_POST['id'];
          // $county_id = $_POST['county_id'];
          $details=$countyReturn->getById($id);
          $county=$countyReturn->getCountyName($details[0]['county_id']);
          $action="County Return : updated Forms";
          $description="The county ".$county." has been updated.The updates are: ";
          //print_r($_POST['$moe_financial_returns_received']));

          //handle the checkboxes
     

          if (empty($_POST['moe_financial_returns_received'])) {
            $moe_financial_returns_received="N";
          }else{
            $moe_financial_returns_received = $_POST['moe_financial_returns_received'];
            
          }

          $description.=' The  has been set to '.$moe_financial_returns_received.'.';
          if (empty($_POST['moe_attnc_received'])) {
            $moe_attnc_received="N";
          }else{
            
            $moe_attnc_received = $_POST['moe_attnc_received'];
          }
          $description.=' The  has been set to '.$moe_attnc_received.'.';
          
          if (empty($_POST['moe_attnc_couriered'])) {
            $moe_attnc_couriered="N";
            
          }else{
            $moe_attnc_couriered = $_POST['moe_attnc_couriered'];
            
          }
          $description.=' The  has been set to '.$moe_attnc_couriered.'.';
          if (empty($_POST['moh_financial_returns_received'])) {
            $moh_financial_returns_received="N";
            
          }else{
            $moh_financial_returns_received = $_POST['moh_financial_returns_received'];
            
          }
          $description.=' The  has been set to '.$moh_financial_returns_received.'.';
          if (empty($_POST['moh_attnc_received'])) {
            $moh_attnc_received="N";
            
          }else{
            $moh_attnc_received = $_POST['moh_attnc_received'];
          }
          $description.=' The  has been set to '.$moh_attnc_received.'.';
          if (empty($_POST['moh_attnc_couriered'])) {
            $moh_attnc_couriered="N";
          }else{
            
            $moh_attnc_couriered = $_POST['moh_attnc_couriered'];
          }
          $description.=' The  has been set to '.$moh_attnc_couriered.'.';

          if (empty($_POST['moh_cd_recording_received'])) {
            $moh_cd_recording_received="N";
           
          }else{
            $moh_cd_recording_received = $_POST['moh_cd_recording_received'];
          }
          $description.=' The MoEST Meeting has been set to '.$moh_cd_recording_received.'.';

          if (empty($_POST['moh_cd_recording_couriered'])) {
            $moh_cd_recording_couriered="N";  
          }else{
            
            $moh_cd_recording_couriered= $_POST['moh_cd_recording_couriered'];
          }
          $description.=' The MoEST Meeting has been set to '.$moh_cd_recording_couriered.'.';
      

  $countyReturn->update(
                          $id,
                          $moe_financial_returns_received,
                          $moe_attnc_received,
                          $moe_attnc_couriered,
                          $moh_financial_returns_received,
                          $moh_attnc_received,
                          $moh_attnc_couriered,
                          $moh_cd_recording_received,
                          $moh_cd_recording_couriered
                    );
      $ArrayData = array($M_module, $action, $description);
         quickFuncLog($ArrayData);

         
  header("Location:return-county.php?saved=1&#close");
}

// privileges check.DO NOT TOUCH

$resPriv =$countyReturn->checkPrivilege();

foreach ($resPriv as $key => $value) {
  $priv_log_forms_analysed=$value['priv_log_forms_analysed'];     # code...
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
          <div class="small-heading col-md-6">COUNTY RETURN STATUS</div>
          <div>   <span class=""><a class="pink-button" href="exportExcelCountyReturn.php"> Export To Excel</a></span>    </div>
         <div class="clearfix"></div>
          <hr>
          </div>

      <div class="panel-heading"><h3>County Return Records</h3></div>
        <table id="data-table" class="return-county row-border">
          <thead>
            <tr>
              <th rowspan="1">County Name</th>
              <th style="text-align:center;" colspan="3">MOE</th>
              <th style="text-align:center;" colspan="5">MOH</th>
              <th rowspan="2">Flag</th>
              <th rowspan="2">Edit</th>
            </tr>

            <tr>
              <!-- hIDING MERGED COLUMNS WITH DISPLAY NONE, THEY PLAY A VITAL ROLE IN THE PREVIOUS YEARS OR CULD BE REDISPLAYED WHEN SYS
              SYSTEM REQUIREMENTS CHANGE -->
              <td></td>     
              <th colspan="1">Financial Returns</th>
              <th style="text-align:center;" colspan="2" >ATTNC</th>
              <th colspan="1">Financial Returns</th>
              <th style="text-align:center;" colspan="2">ATTNC</th>
              <th colspan="2">CD Recording</th>
           
            </tr>
            <tr > 
              <td ></td>
              <td>Received</td>
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Received</td>
              <td>Couriered</td>
              <td>Received</td>
              <td>Couriered</td>
              <td></td>
              <td></td>          
            </tr>
          </thead>
          <tbody>
          <?php 
          $i=1;
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              ?>
                  <tr id="tr-<?php echo $i;?>">
                    <td id="county_id-td<?php echo $i;?>"><?php echo $countyReturn->getCountyName($value['county_id']) ?></td>
                    <td class="align-td" id="moe_financial_returns_received-td<?php echo $i;?>"><?php echo $value['moe_financial_returns_received'] ?></td>
                    <td class="align-td" id="moe_attnc_received-td<?php echo $i;?>"><?php echo $value['moe_attnc_received'] ?></td>
                    <td class="align-td" id="moe_attnc_couriered-td<?php echo $i;?>"><?php echo $value['moe_attnc_couriered'] ?></td>
                    <td class="align-td" id="moh_financial_returns_received-td<?php echo $i;?>"><?php echo $value['moh_financial_returns_received'] ?></td>
                    <td class="align-td" id="moh_attnc_received-td<?php echo $i;?>"><?php echo $value['moh_attnc_received'] ?></td>
                    <td class="align-td" id="moh_attnc_couriered-td<?php echo $i;?>"><?php echo $value['moh_attnc_couriered'] ?></td>
                    <td class="align-td" id="moh_cd_recording_received-td<?php echo $i;?>"><?php echo $value['moh_cd_recording_received'] ?></td>
                    <td class="align-td" id="moh_cd_recording_couriered-td<?php echo $i;?>"><?php echo $value['moh_cd_recording_couriered'] ?></td>                    
                    <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>" hidden/>
                    <!-- flag -->
                    <td class="align-td"><?php echo $countyReturn->getWarning($value['county_id'],$value['end_date']); ?></td>  
                    <td id="<?php echo $i;?>" title="edit" class="edit-return-county align-td">
                    <a  href="#edit-return-county"><img src="../../images/icons/edit2.png"></a>

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
        <div id="edit-return-county" class="modalDialog">
          <div>
            <a href="#close" title="Close" class="modalclose">X</a>
              <div id="data-table-manger">
                <div class="col-md-3">
                  <!-- <button title="Add"class="btn btn-primary btn-xs" id="show-form">+</button> -->
                </div>
                <div class="small-heading col-md-6">TRACKING COUNTY RETURN STATUS</div>
                <div class="clearfix"></div>
                <hr>
                </div>


              <div id="hor-form2">
                <form action="" method="post" class="form-horizontal" role="form">
                  <div class="form-group">
                    <label for="county_name" class="col-md-2 control-label">County</label>
                    <div class="col-md-2">
                      <input type="text" id="county_name_input"  class="form-control input-sm" name="" disabled>
                    </div>  
                  </div>
                  <div align="center"><b>MOE</b></div>

                  <div class="form-group">
                    <label for="courier" class="col-md-2 control-label">Financial Returns</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="moe_financial_returns_received_input" name="moe_financial_returns_received" placeholder="Date Received"  onfocus="(this.type='date')"  >Received
                      </div>


                    </div> 

                    <div class="form-group">
                    <label for="courier" class="col-md-2 control-label">ATTNC</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="moe_attnc_received_input" name="moe_attnc_received" >Received
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="moe_attnc_couriered_input" name="moe_attnc_couriered" >Couriered
                      </div> 
                    </div>

 
                  <div align="center"><b>MOH</b></div>
                   <div class="form-group">
                    <label for="courier" class="col-md-2 control-label">Financial Returns</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="moh_financial_returns_received_input" name="moh_financial_returns_received" >
                      </div>


                  </div>  

                  <div class="form-group">
                    <label for="courier" class="col-md-2 control-label">ATTNC</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="moh_attnc_received_input" name="moh_attnc_received" >Received
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="moh_attnc_couriered_input" name="moh_attnc_couriered" >Couriered
                      </div> 
                    </div>

                  <div class="form-group">
                    <label for="courier" class="col-md-2 control-label">CD Recording</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control input-sm" id="moh_cd_recording_received_input" name="moh_cd_recording_received" >Received
                      </div>
                    <label for="courier" class="col-md-1 control-label"></label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " id="moh_cd_recording_couriered_input" name="moh_cd_recording_couriered" >Couriered
                      </div> 
                    </div>


                  <!-- hidden id field -->
                  <input type="hidden" name="id" id="form_id" >

                  <button type="submit" name="update-log-submit" class="btn btn-default update-log-submit">Save</button>
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





