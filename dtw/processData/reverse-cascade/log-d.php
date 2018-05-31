<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.log-d.php");

//instaciate class
$logD = new logD();

//get districts
$districts = $logD->getDistricts();

// get all data
$data= $logD->getAll();

//save the data
if (isset($_POST['log-submit'])) {

        $district_id = (int)$_POST['district_id'];
        $d_received = (int)$_POST['d_received'];
        $dp_received = (int)$_POST['dp_received'];
        $d_stamp_id = (int)$_POST['d_stamp_id'];
        $dp_expected = (int)$_POST['dp_expected'];


  $logD->create(
              $district_id,
              $d_received,
              $dp_received,
              $d_stamp_id,
              $dp_expected
        );

  header("Location:log-d.php");


}


//update the data
if (isset($_POST['logD'])) {

  $district_id = $_POST['district_id'];
  $d_received = $_POST['d_received'];
  $dp_received = $_POST['dp_received'];
  $d_stamp_id = $_POST['d_stamp_id'];
  $dp_expected = $_POST['dp_expected'];


  $logD->update(
            $id,
            $district_id,
            $d_received,
            $dp_received,
            $d_stamp_id,
            $dp_expected
       );

  header("Location:log-d.php");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$logD->getById($id);
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
          <h1>LOG D</h1>
        </center>
        <!-- <form action="#">
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form> -->


       <form action="" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <span class="col-md-1 control-label">Geography</span>
            <label for="district_name" class="col-md-2 control-label">District Name</label>
            <div class="col-md-1">
              <select name ="district_id" class="form-control">
                <?php 
                  foreach ($districts as $key => $value) {
                    echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                  }
                ?>
              </select>
                <!-- <input type="text" class="form-control input-sm" name="district_name" id="district_name" placeholder="Type"> -->
            </div>  

          </div>

           <div class="form-group">
            <span class="col-md-1 control-label">D</span>
            <label for="d_received" class="col-md-2 control-label">#D Received</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="d_received" id="d_received" placeholder="Type">
            </div>
            <label for="d_stamp_id" class="col-md-2 control-label">D Stamp ID</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="d_stamp_id" id="d_stamp_id" placeholder="Type">
            </div>

          </div> 
          <div class="form-group">
            <span class="col-md-1 control-label">DP</span>
            <label for="dp_received" class="col-md-2 control-label">#DP Recieved</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="dp_received" id="dp_received" placeholder="Type">
            </div>
            <label for="dp_expected" class="col-md-2 control-label">DP Expected</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="dp_expected" id="dp_expected" placeholder="Type">
            </div>  

          </div>


          <button type="submit" name="log-submit" class="btn btn-default">Submit</button>

      </form>



      <!-- display the data -->

      <div class="panel panel-default"> 
        <!-- Default panel contents -->
        <!-- <div class="panel-heading">Panel heading</div> -->

        <!-- Table -->
        <table class="table table-responsive table-condensed table-hover table-bordered">
          <thead>
            <th>District Name</th>
            <th>D Received</th>
            <th>D stamp ID</th>
            <th>D-P Received</th>
            <th>DP Expected</th>
          </thead>
          <tbody>
            <?php 
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr>";
                      echo "<td>".$value['district_id']."</td>";
                      echo "<td>".$value['d_received']."</td>";
                      echo "<td>".$value['d_stamp_id']."</td>";
                      echo "<td>".$value['dp_received']."</td>";
                      echo "<td>".$value['dp_expected']."</td>";
                    echo "</td>";
                  }
                }else{
                  echo '<p class="bg-primary">No data to display</p>';
                }
            ?>
          </tbody>
        </table>
      </div>




      </div> <!--end content body-->
        <div class="clearFix"></div>

    </div> <!--end content main-->
  </body>
</html>





