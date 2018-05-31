<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.log-export.php");
require_once("../../includes/logTracker.php");
$M_module =6;

//instaciate class
$logExport = new logExport;

//get districts
$districts = $logExport->getDistricts();

// $form_type = $logExport->form_types();
$logExport->getRolloutData();
$form_type = $logExport::form_types();

if (isset($_GET['log'])) {
    $data= $logExport->getByFormType($_GET['log']);
}else{
  // get all data
  $data= $logExport->getAll();
}

// $log = new logExport;
  if (isset($_REQUEST['checkval'])) {

    if ($_REQUEST['checkval']=='division') {
      // $Cascade->smallDB();
      $district_id=$_POST['district'];

      // $data=$Cascade->getDivisions($district_id);

      $data=$logExport->getDivisions($district_id);

      ?>
      <option value="">Choose Division</option>
      <?php 
      foreach($data as $data){?>
        <option value="<?php echo $data['division_id'];?>"><?php echo $data['division_name'];?></option>
      <?php }
      die();
    }
  }
  


//update the data
if (isset($_POST['update-log-submit'])) {
  $id=$_POST['id'];
  $stamp_range = $_POST['stamp_range'];
  // $district_id = $_POST['district_id'];
  // $division_id = $_POST['division_id'];
  $recieved = $_POST['recieved']; // number recieved
  $date_recieved = $_POST['date_recieved']; // date recieved

  $stamp_range = $_POST['stamp_range'];
  // we do not update the district or geography
  // echo $district_id = $_POST['district_id'];
  // echo $division_id = $_POST['division_id'];

  // get the form type from the url
  $form_type = $_GET['log'];

  $expected=$logExport->calculateExpecetd($form_type,$district_id);
  //logs
  $districtId='';
  foreach ($data as $key => $value) {
    if($value["id"]==$id){
      $districtId=$value['district_id'];
    }
  }
  $action="Log ".$_GET['log']. " : Log in Forms";
  $newDistrict=$logExport->getDistName($districtId);
 
  $description="The sub-county ".$newDistrict." has been updated.The updates are: ";
  $description.='Date received set to '.$date_recieved;
  $description.=',Stamp range set to '.$stamp_range;
  $description.=',Expected set to '.$expected;
  //end f part 1 logs

  //handle the checkboxes

  if (isset($_POST['scrutiny'])) {
    $scrutiny='Y';
  }else{
    $scrutiny="N";
  }
  $description.=',Scrutinzed set to '.$scrutiny;
  if (isset($_POST['scanning'])) {
    $scanning='Y';
  }else{
    $scanning="N";
  }
  $description.=',Scanning set to '.$scanning;
  // if date is empty set as "N/A"
  if (empty($_POST['courier']) || $_POST['courier']=="") {
    $courier='N/A';
  }else{
      $courier=$_POST['courier'];
  }
  $description.=',Couriered set to '.$courier;

  $logExport->update(
                      $id,
                      $expected,
                      $recieved,
                      $stamp_range,
                      $scrutiny,
                      $scanning,
                      $courier,
                      $date_recieved
    );
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
  header("Location:log-export.php?log=".$form_type."&saved=1&#close");


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
        <!-- <form action="#">
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form> -->
        <div id="data-table-container">
          <div id="data-table-manger">
            
            <div class="col-md-4">
              <?php   
              if (isset($_GET['saved'])) {
                ?>
                  <div class="alert alert-success saved-info">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Success!</strong> Data has been updated.
                </div>  
                <div class="vclear"></div>

                <?php
              }
             ?>
            </div>
            <div class="small-heading col-md-5"><?php echo $_GET['log'] ?> LOG FORMS</div>
                      <div>   <?php if( $priv_log_forms>=1){?> <span class=""></span><a class="pink-button" href="exportExcelLog.php?log=<?php echo $_GET['log']?>"> Export To Excel</a>   <?php }?>  </div>
           <div class="clearfix"></div>
            <hr>
          </div>

      




      <!-- display the data -->

      <div class="panel panel-default"> 
        <!-- Default panel contents -->
        <br>
        <div class="panel-heading">Batch Form Records</div>


        <table id="data-table" class="log-export row-border">
          <thead>
            <tr>
              <th>Sub-County</th>
              <th>Expected</th>
              <th>Recieved</th>
              <th>Variance</th>
              <th>Date Recieved</th>
              <th>Stamp Range</th>
              <th>Scrutiny</th>
              <th>Scanned</th>
              <th>Couriered</th>
              <th>Flag</th>
              <?php if( $priv_log_forms>=3){?> 
              <th>Edit</th>
              <?php }?> 
            </tr>
          </thead>
          <tbody>
            <?php 
            $i=1;
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr id=tr-".$i.">";
                      echo "<td id='district_id_td".$i."'>".$logExport->getDistName($value['district_id'])."</td>";
                      //echo "<td id='division_id_td".$i."'>".$logExport->getDivName($value['division_id'])."</td>";
                      // echo "<td id='end_date_td".$i."'>". date('F j, Y', strtotime($value['end_date']))."</td>";

                      //calculate the expected value
                      if (isset($_GET['log'])) {
                        $expected_value=$logExport->calculateExpecetd($_GET['log'],$value['district_id']);
                         // echo "<td>".$expected_value."</td>";
                        echo "<td title='".$logExport->expected_note($_GET['log'])."' class='hand align-td' id='expected_td".$i."'>".$expected_value."</td>";
                      }
                     
                      // echo "<td>".$value['expected']."</td>";
                      echo "<td class='align-td' id='received_td".$i."'>".$value['received']."</td>";
                      // variance
                      $variance = $logExport->variance($expected_value,$value['received']);

                      echo "<td class='align-td' id='variance_td".$i."'>".$variance."</td>";
                      echo "<td class='align-td' id='date_recieved_td".$i."'>".$value['date_recieved']."</td>";
                      echo "<td class='align-td' id='stamp_range_td".$i."'>".$value['stamp_range']."</td>";
                      echo "<td class='align-td' id='scrutiny_td".$i."'>".$value['scrutiny']."</td>";
                      echo "<td class='align-td' id='scanning_td".$i."'>".$value['scanning']."</td>";
                      echo "<td class='align-td' id='courier_td".$i."'>".$value['courier']."</td>";
                      ?>
                      
                      <!-- flag -->
                      <td class='align-td' > <?php echo $logExport->getWarning($value['end_date'],$value['district_id'],$value['form_type']) ?> </td>

                      <input type="hidden" id="form_type_td<?php echo $i;?>" value="<?php echo $value['form_type'] ?>"/>
                      <input type="hidden" name="id" id="id-td<?php echo $i;?>" value="<?php echo $value['id'] ?>"/>

                      <?php if( $priv_log_forms>=3){?> 
                        <td id="<?php echo $i;?>" title="edit" class="edit-log-export align-td">
                          <a  href="#edit-export"><img src="../../images/icons/edit2.png"></a>
                        </td>
                      <?php } 
                    echo "</tr>";
                    $i++;
                  }
                }else{
                  // echo '<p class="bg-primary">No data to display</p>';
                }
            ?>
          </tbody>
        </table>
      </div>

    </div> <!---w->
     <!--==== Modal EDIT ======-->
      <div id="edit-export" class="modalDialog">
        <div>
          <a href="<?php echo 'log-export.php?log='.$_GET['log'];?>" title="Close" class="modalclose">X</a>
            <div id="data-table-manger">
              <div class="col-md-3">
                <span title="Add"class="" id="show-form"></span>
              </div>
              <div class="small-heading col-md-6"><?php echo $_GET['log'] ?> LOG FORMS</div>
             <div class="clearfix"></div>
              <hr>
              </div>

              <div style="clear:both"></div>
            <div id="hor-form2">
             
              <form action="" method="post" class="form-horizontal" role="form">

                <!-- GEOGRAPHY -->
                  <div class="form-group">
                    <span class="col-md-1 control-label">Geography</span>
                      <label for="district_id" class="col-md-1 control-label">Sub-County</label>
                        <div class="col-md-2">
                          <input type="text" id="district_input"class="form-control " name="district_input" disabled >
                        </div>

                    <!--   <label for="end_date" class="col-md-2  control-label">End Date</label>
                        <div class="col-md-2">
                            <input type="text" id="end_date_input"class="form-control hor-sm " name="end_date_input" disabled >
                        </div> -->
                  </div>


                  <!-- STAGE 1 -->
                  <div class="form-group">

                    <span class="col-md-1 control-label">Stage 1</span>

                    <label for="recieved" class="col-md-1 control-label update-select">Expected</label>
                      <div class="col-md-2 update-select">
                          <input type="text" class="form-control " name="expected" id="expected_input" disabled>
                      </div>

                    <label for="recieved" class="col-md-2  control-label">No. Received</label>
                      <div class="col-md-2">
                          <input type="number" class="form-control " name="recieved" id="recieved_input" >
                      </div>

                    <!-- <label for="stamp_range" class="col-md-1  control-label">Stamp Range</label>
                      <div class="col-md-2">
                        <input type="text" class="form-control hor-sm" name="stamp_range" id="stamp_range_input" >
                      </div> -->

                  </div> 

                  <!-- STAGE 2 -->
                  <div class="form-group">
                    <span class="col-md-1 control-label">Stage 2</span>

                    <label for="scrutiny" class="col-md-1 control-label">Scrutinzed</label>
                      <div class="col-md-2">
                        <label class="checkbox-inline">
                          <input type="checkbox" id="scrutiny_checkbox" name="scrutiny"> 
                        </label>
                      </div>

                    <label for="scanning" class="col-md-2  control-label">Scanned</label>
                      <div class="col-md-2">
                        <label class="checkbox-inline">
                          <input type="checkbox" id="scanning_checkbox" name="scanning"> 
                        </label>
                      </div>

                    <!-- <label for="courier" class="col-md-1 control-label">Couriered</label>
                      <div class="col-md-1">
                          <input type="number" class="form-control hor-sm" name="courier" id="courier_checkbox" >
                      </div> -->


                  </div> 

                  <div class="form-group">
                    <span class="col-md-1 control-label"></span>
                    <label for="courier" class="col-md-1 control-label">Couriered</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="courier" id="courier_date" >
                      </div>

                    <label for="courier" class="col-md-2 control-label">Date Recieved</label>
                      <div class="col-md-2">
                          <input type="date" class="form-control " name="date_recieved" id="date_recieved_input" >
                      </div>


                  </div>


                  <div class="form-group">
                    <span class="col-md-1 control-label"></span>
                    <label for="stamp_range" class="col-md-1  control-label">Stamp Range</label>
                      <div class="col-md-2">
                        <textarea class="form-control" cols="5" name="stamp_range" id="stamp_range_input" >

                        </textarea>
                        <!-- <input type="text" class="form-control hor-sm" name="stamp_range" id="stamp_range_input" > -->
                      </div>

                  </div>

                  <!-- STAGE 3 -->
                  <div class="form-group">

                   <!-- hidden id field -->

                  <input type="hidden" name="id" id="form_id" >
                  <input type="hidden" name="form_type" id="form_type_input" >
                     <!-- <div class="col-md-5"></div> -->
                    <label for="attnc_recieved" class="col-md-2 control-label"> 
                     <div class="col-md-1">
                         <?php if( $priv_log_forms>=2){?> 
                       <button type="submit" name="update-log-submit"  class="update-log-submit btn btn-primary">Save</button>
                       <!-- <button type="submit" name="create-log-submit"  class="create-log-submit btn btn-primary">Create</button> -->
                         <?php }?> 
                     </div>
                  </label>
                   

                  </div>




                  <!-- <button type="submit" name="log-submit" class="btn btn-default">Submit</button> -->

              </form> <hr>
            </div>
         
        </div>
      </div>



      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>

<!--jQuery Data Tables-->

  <!-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script> -->
<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>
<script type="text/javascript">
 //GET divisions
  function get_division(txt) {
  console.log(txt);

    $.post('log-export.php', {checkval: 'division', district: txt}).done(function(data) {
      console.log(data);
      $('#selectdivision').html(data);//alert(data);
    });
  }
  </script>



