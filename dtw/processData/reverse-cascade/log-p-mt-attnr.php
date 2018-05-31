<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.log_p_mt_attnr.php");

//instaciate class
$log_p_mt_attnr = new log_p_mt_attnr();

//get districts
$districts = $log_p_mt_attnr->getDistricts();

// get all data
$data= $log_p_mt_attnr->getAll();

//save the data
if (isset($_POST['log-submit'])) {
  $district_name = log_p_mt_attnr::replace_null($_POST['district_name']);
  $no_received_p = (int)$_POST['no_received_p'];
  $stamp_id_range = $_POST['stamp_id_range'];
  $mt_stamp_id = (int)$_POST['mt_stamp_id'];
  $no_attnr_received = (int)$_POST['no_attnr_received'];
  $attnr_stamp_range = $_POST['attnr_stamp_range'];

  $log_p_mt_attnr->create(
                    $district_name,
                    $no_received_p,
                    $stamp_id_range,
                    $mt_stamp_id,
                    $no_attnr_received,
                    $attnr_stamp_range
    );

  header("Location:log-p-mt-attnr.php");


}


//update the data
if (isset($_POST['log_p_mt_attnr'])) {

  $id=$_POST['id'];
  $district_name = $_POST['district_name'];
  $no_received_p = (int)$_POST['no_received_p'];
  $stamp_id_range = $_POST['stamp_id_range'];
  $mt_stamp_id = (int)$_POST['mt_stamp_id'];
  $no_attnr_received = (int)$_POST['no_attnr_received'];
  $attnr_stamp_range = $_POST['attnr_stamp_range'];

  $log_p_mt_attnr->update(
                    $id,
                    $district_name,
                    $no_received_p,
                    $stamp_id_range,
                    $mt_stamp_id,
                    $no_attnr_received,
                    $attnr_stamp_range
    );

  header("Location:log_p_mt_attnr.php");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$log_p_mt_attnr->getById($id);
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
        <h1>RETURN STATUS</h1>
        <!-- <form action="#">
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form> -->


       <form action="" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <span class="col-md-1 control-label">Form P</span>
            <label for="inputType" class="col-md-1 control-label">District Name</label>
            <div class="col-md-1">
              <select class="form-control">
                <?php 
                  foreach ($districts as $key => $value) {
                    echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                  }
                ?>
              </select>
                <!-- <input type="text" class="form-control input-sm" name="district_name" id="district_name" placeholder="Type"> -->
            </div>
            <label for="inputType" class="col-md-1 control-label">#P Received P</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="no_received_p" id="no_received_p" placeholder="Type">
            </div>
            <label for="inputType" class="col-md-1 control-label">stamp ID range</label>
            <div class="col-md-1">
                <input type="text" class="form-control input-sm" name="stamp_id_range" id="stamp_id_range" placeholder="Type">
            </div>

          </div>

          <div class="form-group">
              <span class="col-md-1 control-label">Form ATTNR</span>
              <label for="inputType" class="col-md-1 control-label">MT stamp ID</label>
                <div class="col-md-1">
                    <input type="number" class="form-control"  name="mt_stamp_id" id="mt_stamp_id" placeholder="Key">
                </div>
                <label for="inputType" class="col-md-1 control-label">#ATTNR Received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control"  name="no_attnr_received" id="no_attnr_received" placeholder="Key">
                </div>
                <label for="inputValue" class="col-md-1 control-label">ATTNR Stamp Range</label>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="attnr_stamp_range" id="attnr_stamp_range" placeholder="Value">
                </div>
          </div>

          <button type="submit" name="log-submit" class="btn btn-default">Submit</button>


          <!-- <div class="form-group">
              <span class="col-md-1 control-label">Metadata</span>
              <div class="col-md-6">
                  <div class="form-group row">
                      <label for="inputKey" class="col-md-1 control-label">Key</label>
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="inputKey" placeholder="Key">
                      </div>
                      <label for="inputValue" class="col-md-1 control-label">Value</label>
                      <div class="col-md-2">
                          <input type="text" class="form-control" id="inputValue" placeholder="Value">
                      </div>
                  </div>
              </div>
          </div> -->
      </form>



      <!-- display the data -->

      <div class="panel panel-default"> 
        <!-- Default panel contents -->
        <div class="panel-heading">Panel heading</div>

        <!-- Table -->
        <table class="table table-responsive table-condensed table-hover table-bordered">
          <thead>
            <th>District Name</th>
            <th>#P Received P</th>
            <th>stamp ID range</th>
            <th>MT stamp ID</th>
            <th>#ATTNR Received</th>
            <th>ATTNR Stamp Range</th>
          </thead>
          <tbody>
            <?php 
                foreach ($data as $key => $value) {
                  echo "<tr>";
                    echo "<td>".$value['district_name']."</td>";
                    echo "<td>".$value['no_received_p']."</td>";
                    echo "<td>".$value['stamp_id_range']."</td>";
                    echo "<td>".$value['mt_stamp_id']."</td>";
                    echo "<td>".$value['no_attnr_received']."</td>";
                    echo "<td>".$value['attnr_stamp_range']."</td>";
                  echo "</td>";
                }
            ?>
            <!-- <tr>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
            </tr>
             <tr>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
            </tr>
             <tr>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
              <td>dscsdc</td>
            </tr> -->
          </tbody>
        </table>
      </div>




      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>




