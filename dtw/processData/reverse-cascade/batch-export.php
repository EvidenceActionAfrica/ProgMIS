<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.batch-export.php");
require_once("../../includes/logTracker.php");
$M_module =6;

//instaciate class
$batchExport = new batchExport();

//get districts
$districts = $batchExport->getDistricts();

$batchExport->getRolloutData();

// get all data
if (isset($_GET['batch'])) {  
  $form_type=$_GET['batch'];

}else{
  $form_type="none";
}

if ($form_type=="none") {

    $data= $batchExport->getAll($form_type);

}else{
    $data=$batchExport->getByFormType($form_type);
}




//update the data
if (isset($_POST['update-log-submit'])) {
        $type_of_form = $_GET['batch'];
        $id=$_POST['id']; echo "<br/>";
        $batch = $_POST['batch_number']; echo "<br/>";
        $num_sent = $_POST['num_sent']; echo "<br/>";
        $batch_range = $_POST['batch_range']; echo "<br/>";

        $action="Batch Forms  Log ".$_GET['batch']." updated";
        $description=" The following were updated :";
        // if date is empty set as "N/A"
        if (empty($_POST['date_sent']) || $_POST['date_sent'] =="") {
          $date_sent='N/A';
        }else{
            $date_sent=$_POST['date_sent'];
        }
        $description.="Date sent was set to ".$date_sent.".";
        $description.="The Batch was set to".$batch.".";
        $description.="The Batch range set was".$batch_range.".";
        $description.="The number sent was".$num_sent;
  $batchExport->update(
            $id,
            $date_sent,
            $batch,
            $num_sent,
            $batch_range
       );
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
  header("Location:batch-export.php?batch=".$type_of_form."&saved=1&#close");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$batchExport->getById($id);
}
// privileges check.DO NOT TOUCH

$resPriv =$batchExport->checkPrivilege();

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

    <div id="data-table-container">
          <div id="data-table-manger">
            
            
            <div class="col-md-4">
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


            <div class="small-heading col-md-5"><?php echo($form_type); ?> BATCH FORMS </div>
            <div> <?php if( $priv_log_forms>=1){?>  <span class=""></span><a class="pink-button" href="exportExcelBatch.php?batch=<?php echo $_GET['batch']?>"> Export To Excel</a> <?php }?>   </div>
            <div class="clearfix"></div>
            <hr>
          </div>
      


      <!-- display the data -->

      <div class="panel panel-default"> 
        <!-- Default panel contents -->
        <div class="panel-heading">Batch Froms Records</div>

        <!-- Table -->
        <table id="data-table" class="batch-export row-border">
          <thead>
            <th>Sub-County Name</th>
            <th class="">Date Sent</th>
            <th class="">Batch</th>
            <th class="">Range</th>
            <th class="">Number Sent</th>
            <th>Flag</th>
            <?php if( $priv_log_forms>=3){?> 
            <th>Edit</th>
            <?php }?> 
          </thead>
          <tbody>
            <?php 
            $i=1;
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr id=tr-".$i.">";
                      echo "<td id='district_id_td".$i."'>".$batchExport->getDistName($value['district_id'])."</td>";
                      echo "<td class='align-td' id='date_sent_td".$i."'>".$value['date_sent']."</td>";
                      echo "<td class='align-td' id='batch_td".$i."'>".$value['batch']."</td>";
                      echo "<td class='align-td' id='batch_range_td".$i."'>".$value['batch_range']."</td>";
                      echo "<td class='align-td' id='num_sent_td".$i."'>".$value['num_sent']."</td>";

              ?>     
                      <td><?php echo $batchExport->getWarning($value['end_date']) ?></td> 
                      <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>"/>
                      <?php if( $priv_log_forms>=3){?> 
                      <td id="<?php echo $i;?>" title="edit" class="edit-batch-export align-td">
                        <a  href="#edit-batch"><img src="../../images/icons/edit2.png"></a>
                      </td>
                      <?php }?> 
              <?php
                    echo "</td>";
                     $i++;
                  }
                 
                }else{
                  // echo '<p class="bg-primary">No data to display</p>';
                }
            ?>
          </tbody>
        </table>
      </div>
    </div>
     <!--==== Modal EDIT ======-->
      <div id="edit-batch" class="modalDialog">
        <div>
          <a href="#close" title="Close" class="modalclose">X</a>
            <div id="data-table-container">
              <div id="data-table-manger">
                <div class="col-md-4">
                  <span title="hide form"class="hand" id="show-form"></span>
                </div>
                <div class="small-heading col-md-5"><?php echo($form_type); ?> BATCH FORMS </div>
                <div class="clearfix"></div>
                <hr>
              </div>
              <div id="hor-form2">
                <form action="" method="post" class="form-horizontal" role="form">
                  <div class="form-group">
                    <span class="col-md-1 control-label">Geography</span>

                      <label for="district_name" class="col-md-1 control-label">Sub-County</label>
                        <div class="col-md-2 update-select">
                            <input type="text" class="form-control input-sm " name="district_name_input" id="district_id_input" disabled>
                        </div>

                      <label for="date_sent" class="col-md-1 control-label">Date Sent</label>
                        <div class="col-md-2">
                            <input type="date" class="form-control input-sm" name="date_sent" id="date_sent_input" required>
                        </div>

                  </div>

                  <div class="form-group">
                    <span class="col-md-1 control-label">Details</span>

                    <label for="batch" class="col-md-1 control-label">batch</label>
                      <div class="col-md-2">
                          <textarea class="form-control" cols="5" name="batch_number" id="batch_number_input" > </textarea>
                          <!-- <input type="text" class="form-control input-sm" name="batch" id="batch_input" placeholder="Batch"> -->
                      </div>
                      <label for="batch_range" class="col-md-1 control-label">Range</label>
                        <div class="col-md-2">
                          <textarea class="form-control" cols="5" name="batch_range" id="batch_range_input" > </textarea>
                        </div>

                  </div>

                  <div class="form-group">
                    <span class="col-md-1 control-label">Details</span>

                      <label for="num_sent" class="col-md-1 control-label">Number Sent</label>
                      <div class="col-md-2">
                        <input type="number" class="form-control input-sm " id="num_sent_input" name="num_sent">
                      </div>

                     <!-- hidden id field -->
                      <input type="hidden" name="id" id="form_id" >

                  </div>
                  <!-- <div class="col-md-5"></div> -->
                  <div class="form-group">
                    <label for="attnc_recieved" class="col-md-2 control-label"> 
                   <div class="col-md-2">
                        <?php if( $priv_log_forms>=2){?> 
                      <button type="submit" name="update-log-submit"  class="update-log-submit btn pink-button data-saved">Save</button>
                        <?php }?> 
                   </div>
                      
                  </div>
              </form>
          </div>
        </div>
      </div>



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





