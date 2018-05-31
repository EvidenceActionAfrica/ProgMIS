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


          //handle the checkboxes

          if (isset($_POST['moe_monitoring'])) {
            $moe_monitoring='Y';
          }else{
            $moe_monitoring="N";
          }
          $description.=' The MoEST Monitoring has been set to '.$moe_monitoring.'.';

          if (isset($_POST['moe_meeting'])) {
            $moe_meeting='Y';
          }else{
            $moe_meeting="N";
          }
          $description.=' The MoEST Meeting has been set to '.$moe_meeting.'.';
          if (isset($_POST['mophs_community'])) {
            $mophs_community='Y';
          }else{
            $mophs_community="N";
          }
          $description.=' The MoPHs Community Sensitization has been set to '.$mophs_community.'.';
        
          if (isset($_POST['mophs_monitoring'])) {
            $mophs_monitoring='Y';
          }else{
            $mophs_monitoring="N";
          }
          $description.=' The MoPHs Monitoring has been set to '.$mophs_monitoring.'.';
        
          if (isset($_POST['mophs_meeting'])) {
            $mophs_meeting='Y';
          }else{
            $mophs_meeting="N";
          }
          $description.=' The MoPHs Meeting has been set to '.$mophs_meeting.'.';
        

  $countyReturn->update(
                          $id,
                          $moe_monitoring,
                          $moe_meeting,
                          $mophs_community,
                          $mophs_monitoring,
                          $mophs_meeting
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
          <div>  <?php if( $priv_log_forms_analysed>=3){?> <span class=""><a class="pink-button" href="exportExcelCountyReturn.php"> Export To Excel</a></span>   <?php }?> </div>
         <div class="clearfix"></div>
          <hr>
          </div>

      <div class="panel-heading"><h3>County Return Records</h3></div>
        <table id="data-table" class="return-county row-border">
          <thead>
            <tr>
              <th rowspan="2">County Name</th>
              <th style="text-align:center;" colspan="1">MOE</th>
              <th style="text-align:center;" colspan="2">MOH</th>
              <?php if( $priv_log_forms_analysed>=3){?>
              <th rowspan="2">Flag</th>
              <th rowspan="2">Edit</th>
		<th style="display:none;"></th>
		<th style="display:none;"></th>
		<th style="display:none;"></th>
		
              <?php }?> 
            </tr>

            <tr>
              <!-- hIDING MERGED COLUMNS WITH DISPLAY NONE, THEY PLAY A VITAL ROLE IN THE PREVIOUS YEARS OR CULD BE REDISPLAYED WHEN SYS
              SYSTEM REQUIREMENTS CHANGE -->
              <td style="display:none;">Monitoring</td>
              <td style="display:none;" >Meeting</td>
              <td style="display:none;" >Community Sensitization</td>
              <td style="display:none;">Monitoring</td>
              <td style="display:none;">Meeting</td>
              <td style="width:20%;" >County and CSHCC,  meetings and monitoring</td>
              <td style="width:20%;">County and CSHCC meetings, radio engagement and monitoring</td>
              <td style="width:20%;">Radio recording (Actual disc)</td>
            </tr>
          </thead>
          <tbody>
     

          <?php 
          $i=1;
          if (sizeof($data) > 0) {
            foreach ($data as $key => $value) {
              # code...
              ?>
                  <tr id="tr-<?php echo $i;?>">
                    <td id="county_id-td<?php echo $i;?>"><?php echo $countyReturn->getCountyName($value['county_id']) ?></td>
                    <td class="align-td" id="moe_monitoring-td<?php echo $i;?>"><?php echo $value['moe_monitoring'] ?></td>
                    <td style="display:none;" class="align-td" id="moe_meeting-td<?php echo $i;?>"><?php echo $value['moe_meeting'] ?></td>
                    <td class="align-td" id="mophs_monitoring-td<?php echo $i;?>"><?php echo $value['mophs_monitoring'] ?></td>
                    <td class="align-td" id="mophs_community-td<?php echo $i;?>"><?php echo $value['mophs_community'] ?></td>
                    <td style="display:none;" class="align-td" id="mophs_meeting-td<?php echo $i;?>"><?php echo $value['mophs_meeting'] ?></td>
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
                      <input type="text" class="form-control input-sm" name="" id="county_name_input" disabled>
                    </div>  
                  </div>

                   <div class="form-group">
                    <label class="col-md-2 control-label">MOE</label>

                    <div class="col-md-1">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="moe_monitoring_checkbox" name="moe_monitoring" value=""> County and CSHCC, meetings and monitoring
                      </label>
                    </div>
                    <div class="col-md-1">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="moe_meeting_checkbox" name="moe_meeting" value="" hidden> 
                      </label>
                    </div>

                  </div> 

                   <div class="form-group">
                    <label class="col-md-2 control-label">MOH</label>
                    <div class="col-md-1">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="mophs_monitoring_checkbox" name="mophs_monitoring" val="" >County and CSHCC meetings, radio engagement and monitoring
                      </label>
                    </div>
                    <div class="col-md-1">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="mophs_community_checkbox" name="mophs_community" > Radio recording (Actual disc)
                      </label>
                    </div>
                      
                    <div class="col-md-1">
                      <label class="checkbox-inline">
                        <input type="checkbox" id="mophs_meeting_checkbox" name="mophs_meeting" hidden> 
                      </label>
                    </div>
                  </div> 

                  <!-- hidden id field -->
                  <input type="hidden" name="id" id="form_id" >

                  <?php if( $priv_log_forms_analysed>=2){?>
                  <button type="submit" name="update-log-submit" class="btn btn-default update-log-submit">Save</button>
                  <?php } 
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





