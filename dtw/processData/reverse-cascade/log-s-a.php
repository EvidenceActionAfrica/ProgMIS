<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.log-s-a.php");

//instaciate class
$logSA = new logSA();

//get districts
$districts = $logSA->getDistricts();

// get all data
$data= $logSA->getAll();

//save the data
if (isset($_POST['log-submit'])) {

        $division_id = (int)$_POST['district_id'];
        $s_expected = (int)$_POST['s_expected'];
        $s_received = (int)$_POST['s_received'];
        $sp_expected = (int)$_POST['sp_expected'];
        $sp_received = (int)$_POST['sp_received'];
        $s_stamp_range = $_POST['s_stamp_range'];
        $a_received = (int)$_POST['a_received'];
        $ap_expected = (int)$_POST['ap_expected'];
        $ap_received = (int)$_POST['ap_received'];
        $a_stamp_range = $_POST['a_stamp_range'];


  $logSA->create(
              $division_id,
              $s_expected,
              $s_received,
              $sp_expected,
              $sp_received,
              $s_stamp_range,
              $a_received,
              $ap_expected,
              $ap_received,
              $a_stamp_range
        );

  header("Location:log-s-a.php");


}


//update the data
if (isset($_POST['logSA'])) {

    $division_id = (int)$_POST['division_id'];
    $s_expected = (int)$_POST['s_expected'];
    $s_received = (int)$_POST['s_received'];
    $sp_expected = (int)$_POST['sp_expected'];
    $sp_received = (int)$_POST['sp_received'];
    $s_stamp_range = $_POST['s_stamp_range'];
    $a_received = (int)$_POST['a_received'];
    $ap_expected = (int)$_POST['ap_expected'];
    $ap_received = (int)$_POST['ap_received'];
    $a_stamp_range = $_POST['a_stamp_range'];

  $logSA->update(
            $id,
            $division_id,
            $s_expected,
            $s_received,
            $sp_expected,
            $sp_received,
            $s_stamp_range,
            $a_received,
            $ap_expected,
            $ap_received,
            $a_stamp_range
       );

  header("Location:log-s-a.php");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$logSA->getById($id);
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
          <h1>LOG S & A</h1>
        </center>
        <!-- <form action="#">
          <a class="btn btn-primary" href="#addCounty">Add Return Status</a>
        </form> -->


       <form action="" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <span class="col-md-1 control-label">Geography</span>
            <label for="district_id" class="col-md-1 control-label">District Name</label>
            <div class="col-md-1">
              <select name ="district_id" class="form-control">
                <?php 
                  foreach ($districts as $key => $value) {
                    echo '<option value="'.$value['district_id'].'"">'.$value['district_name'].'</option>';
                  }
                ?>
              </select>
                <!-- <input type="text" class="form-control input-sm" name="district_id" id="district_id" placeholder="Type"> -->
            </div>

            <label for="district_id" class="col-md-1 control-label">Division Name</label>
            <div class="col-md-1">
              <select name ="district_id" class="form-control">
                <?php 
                  foreach ($districts as $key => $value) {
                    echo '<option value="'.$value['district_id'].'"">'.$value['district_id'].'</option>';
                  }
                ?>
              </select>
                <!-- <input type="text" class="form-control input-sm" name="district_id" id="district_id" placeholder="Type"> -->
            </div>  

          </div>

           <div class="form-group">
            <span class="col-md-1 control-label">Forms S</span>
            <label for="s_expected" class="col-md-1 control-label">#S Expected</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="s_expected" id="s_expected" placeholder="Type">
            </div>
            <label for="s_received" class="col-md-1 control-label">#S Received</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="s_received" id="s_received" placeholder="Type">
            </div>
            <label for="sp_expected" class="col-md-1 control-label">SP Expected</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="sp_expected" id="sp_expected" placeholder="Type">
            </div> 
            <label for="sp_received" class="col-md-1 control-label">SP Received</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="sp_received" id="sp_received" placeholder="Type">
            </div>

          </div> 
           <div class="form-group">
                <span class="col-md-1 control-label">Forms A</span>
                <label for="a_received" class="col-md-1 control-label">#A Expected</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="a_received" id="a_received" placeholder="Type">
                </div>
                <label for="ap_expected" class="col-md-1 control-label">#AP Expected</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="ap_expected" id="ap_expected" placeholder="Type">
                </div>
                <label for="ap_received" class="col-md-1 control-label">AP Recieved</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="ap_received" id="ap_received" placeholder="Type">
                </div> 
               <!--  <label for="sp_received" class="col-md-1 control-label">SP Received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="sp_received" id="sp_received" placeholder="Type">
                </div> -->

            </div>
            <div class="form-group">
                <span class="col-md-1 control-label">Stamp Range</span>
                <label for="s_stamp_range" class="col-md-1 control-label">S stamp range</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="s_stamp_range" id="s_stamp_range" placeholder="Type">
                </div>
                <label for="a_stamp_range" class="col-md-1 control-label">A stamp range</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="a_stamp_range" id="a_stamp_range" placeholder="Type">
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
            <th>Division Name</th>
            <th>S Expected</th>
            <th>S Received</th>
            <th>S-P Expected</th>
            <th>S-P Received</th>
            <th>S stamp range</th>
            <th>A Received</th>
            <th>A-P expected</th>
            <th>A-P Received</th>
            <th>A stamp range</th>

          </thead>
          <tbody>
            <?php 
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr>";
                      echo "<td>".$value['division_id']."</td>";
                      echo "<td>".$value['s_expected']."</td>";
                      echo "<td>".$value['s_received']."</td>";
                      echo "<td>".$value['sp_expected']."</td>";
                      echo "<td>".$value['sp_received']."</td>";
                      echo "<td>".$value['s_stamp_range']."</td>";
                      echo "<td>".$value['a_received']."</td>";
                      echo "<td>".$value['ap_expected']."</td>";
                      echo "<td>".$value['ap_received']."</td>";
                      echo "<td>".$value['a_stamp_range']."</td>";
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





