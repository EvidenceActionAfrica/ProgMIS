<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.logattntc.php");

//instaciate class
$log_attnt_c = new log_attnt_c();

//get districts
$districts = $log_attnt_c->getDistricts();

// get all data
$data= $log_attnt_c->getAll();

//save the data
if (isset($_POST['log-submit'])) {

  echo $wave_assigned = $_POST['wave_assigned'];
  echo $district_name = $_POST['district_name'];
  echo $division_name = $_POST['division_name'];
  echo $attnt_received = $_POST['attnt_received'];
  echo $attnt_stamp_range = $_POST['attnt_stamp_range'];
  echo $attnc_recieved = $_POST['attnc_recieved'];
  echo $attnc_stamp_range = $_POST['attnc_stamp_range'];
  echo $total_schools_trained = $_POST['total_schools_trained'];

  $log_attnt_c->create(
                    $wave_assigned,
                    $district_name,
                    $division_name,
                    $attnt_received,
                    $attnt_stamp_range,
                    $attnc_recieved,
                    $attnc_stamp_range,
                    $total_schools_trained
    );

  header("Location:log-attnt-c.php");


}


//update the data
if (isset($_POST['log_attnt_c'])) {

  $wave_assigned = $_POST['wave_assigned'];
  $district_name = $_POST['district_name'];
  $division_name = $_POST['division_name'];
  $attnt_received = $_POST['attnt_received'];
  $attnt_stamp_range = $_POST['attnt_stamp_range'];
  $attnc_recieved = $_POST['attnc_recieved'];
  $attnc_stamp_range = $_POST['attnc_stamp_range'];
  $total_schools_trained = $_POST['total_schools_trained'];

  $log_attnt_c->update(
                      $id,
                      $wave_assigned,
                      $district_name,
                      $division_name,
                      $attnt_received,
                      $attnt_stamp_range,
                      $attnc_recieved,
                      $attnc_stamp_range,
                      $total_schools_trained
    );

  header("Location:log-attnt-c.php");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$log_attnt_c->getById($id);
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
        <center>
          <h1>LOG ATTNT & C</h1>
        </center>
        <!-- <form action="#">
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form> -->
        <div id="data-table-container">
             <div>
            <button class="btn btn-primary" id="show-form">+</button>
          </div>
        <div id="hor-form">
         
          <form action="" method="post" class="form-horizontal" role="form">
              <div class="form-group">
                <span class="col-md-1 control-label">Geography</span>
                <label for="district_name" class="col-md-2 control-label">District Name</label>
                <div class="col-md-1">
                  <select name ="district_name" class="form-control">
                    <?php 
                      foreach ($districts as $key => $value) {
                        echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                      }
                    ?>
                  </select>
                    <!-- <input type="text" class="form-control hor-sm" name="district_name" id="district_name" placeholder="Type"> -->
                </div>  
              <label for="division_name" class="col-md-2 control-label">Division Name</label>
              <div class="col-md-1">
                  <select name ="division_name" class="form-control">
                    <?php 
                      foreach ($districts as $key => $value) {
                        echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                      }
                    ?>
                  </select>
                    <!-- <input type="text" class="form-control hor-sm" name="district_name" id="district_name" placeholder="Type"> -->
                </div>

              </div>

               <div class="form-group">
                <span class="col-md-1 control-label">ATTNT</span>
                <label for="attnt_received" class="col-md-2 control-label">#ATTNT Received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control hor-sm" name="attnt_received" id="attnt_received" placeholder="Type">
                </div>
                <label for="attnt_stamp_range" class="col-md-2 control-label">ATTNT Stamp Range</label>
                <div class="col-md-1">
                    <input type="text" class="form-control hor-sm" name="attnt_stamp_range" id="attnt_stamp_range" placeholder="Type">
                </div>
                 <label for="wave_assigned" class="col-md-1  control-label">Wave</label>
                <div class="col-md-1">
                    <input type="number" class="form-control hor-sm" name="wave_assigned" id="wave_assigned" placeholder="Type">
                </div>

              </div> 
              <div class="form-group">
                <span class="col-md-1 control-label">ATTNT c</span>
                <label for="attnc_recieved" class="col-md-2 control-label">#ATTNC Recieved</label>
                <div class="col-md-1">
                    <input type="number" class="form-control hor-sm" name="attnc_recieved" id="attnc_recieved" placeholder="Type">
                </div>
                <label for="attnc_stamp_range" class="col-md-2 control-label">ATTNC Stamp Range</label>
                <div class="col-md-1">
                    <input type="text" class="form-control hor-sm" name="attnc_stamp_range" id="attnc_stamp_range" placeholder="Type">
                </div>  
                <label for="total_schools_trained" class="col-md-1   control-label">Schools</label>
                <div class="col-md-1">
                    <input type="number" class="form-control hor-sm" name="total_schools_trained" id="total_schools_trained" placeholder="Type">
                </div>

              </div> 

              <div class="form-group"
>                <!-- <span class="col-md-1 control-label">ATTNT c</span> -->
                <label for="attnc_recieved" class="col-md-2 control-label"> 
                 <div class="col-md-1">
                   <button type="submit" id="log-submit" name="log-submit" class="btn btn-primary">Add</button>
                </div>
              </label>
               

              </div>


              <!-- <button type="submit" name="log-submit" class="btn btn-default">Submit</button> -->

          </form> <hr>
        </div>





      <!-- display the data -->

      <div class="panel panel-default"> 
        <!-- Default panel contents -->
        <br>
        <div class="panel-heading">List of all</div>


        <table id="data-table" class="display">
          <thead>
            <tr>
              <th>Wave</th>
              <th>District</th>
              <th>Division</th>
              <th>ATTNT Received</th>
              <th>ATTNT Stamp Range</th>
              <th>ATTNC recieved</th>
              <th>ATTNC Samp Range</th>
              <th>Total Schools Trained</th>
            </tr>
          </thead>
          <tbody>
            <?php 
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr>";
                      echo "<td>".$value['wave_assigned']."</td>";
                      echo "<td>".$value['district_name']."</td>";
                      echo "<td>".$value['division_name']."</td>";
                      echo "<td>".$value['attnt_received']."</td>";
                      echo "<td>".$value['attnt_stamp_range']."</td>";
                      echo "<td>".$value['attnc_recieved']."</td>";
                      echo "<td>".$value['attnc_stamp_range']."</td>";
                      echo "<td>".$value['total_schools_trained']."</td>";
                    echo "</tr>";
                  }
                }else{
                  echo '<p class="bg-primary">No data to display</p>';
                }
            ?>
          </tbody>
        </table>
      </div>

    </div> <!---w->




      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>

<!--jQuery Data Tables-->

  // <!-- <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script> -->
<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>



