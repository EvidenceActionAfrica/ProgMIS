<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');

require_once("includes/class.tab.php");

//instaciate class
$logTab = new logTab();

//get districts
$districts = $logTab->getDistricts();

// get all data
$data= $logTab->getAll();

//save the data
if (isset($_POST['log-submit'])) {

        $district_id = (int)$_POST['district_id'];
        $pick_up = $_POST['pick_up'];
        $pick_up_stamp = (int)$_POST['pick_up_stamp'];
        $return_status = $_POST['return_status'];
        $return_stamp = (int)$_POST['return_stamp'];
        $alb_received = (int)$_POST['alb_received'];
        $pzq_received = (int)$_POST['pzq_received'];
        $alb_returned = (int)$_POST['alb_returned'];
        $pzq_returned = (int)$_POST['pzq_returned'];


  $logTab->create(
              $district_id,
              $pick_up,
              $pick_up_stamp,
              $return_status,
              $return_stamp,
              $alb_received,
              $pzq_received,
              $alb_returned,
              $pzq_returned
        );

  header("Location:log-tab.php");


}


//update the data
if (isset($_POST['logTab'])) {

        $district_id = (int)$_POST['district_id'];
        $pick_up = $_POST['pick_up'];
        $pick_up_stamp = (int)$_POST['pick_up_stamp'];
        $return_status = $_POST['return_status'];
        $return_stamp = (int)$_POST['return_stamp'];
        $alb_received = (int)$_POST['alb_received'];
        $pzq_received = (int)$_POST['pzq_received'];
        $alb_returned = (int)$_POST['alb_returned'];
        $pzq_returned = (int)$_POST['pzq_returned'];

  $logTab->update(
            $id,
            $district_id,
            $pick_up,
            $pick_up_stamp,
            $return_status,
            $return_stamp,
            $alb_received,
            $pzq_received,
            $alb_returned,
            $pzq_returned
       );

  header("Location:log-tab.php");


}


// data to edit
if (isset($_POST['editDetails'])) {
  $id=$_POST['id'];
  $details=$logTab->getById($id);
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
          <h1>LOG Tab</h1>
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


          </div>

           <div class="form-group">
            <span class="col-md-1 control-label">Pick Up</span>
            <label for="pick_up" class="col-md-1 control-label">Pick Up</label>
            <div class="col-md-1">
                <input type="text" class="form-control input-sm" name="pick_up" id="pick_up" placeholder="Type">
            </div>
            <label for="pick_up_stamp" class="col-md-1 control-label">Pick Up Stamp</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="pick_up_stamp" id="pick_up_stamp" placeholder="Type">
            </div>
            <label for="return_status" class="col-md-1 control-label">Return Status</label>
            <div class="col-md-1">
                <input type="text" class="form-control input-sm" name="return_status" id="return_status" placeholder="Type">
            </div> 
            <label for="return_stamp" class="col-md-1 control-label">Return Stamp</label>
            <div class="col-md-1">
                <input type="number" class="form-control input-sm" name="return_stamp" id="return_stamp" placeholder="Type">
            </div>

          </div> 
           <div class="form-group">
                <span class="col-md-1 control-label">Drugs</span>
                <label for="alb_received" class="col-md-1 control-label">Alb Received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="alb_received" id="alb_received" placeholder="Type">
                </div>
                <label for="pzq_received" class="col-md-1 control-label">PZQ received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="pzq_received" id="pzq_received" placeholder="Type">
                </div>
                <label for="alb_returned" class="col-md-1 control-label">ALB Returned</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="alb_returned" id="alb_returned" placeholder="Type">
                </div> 
                <label for="pzq_returned" class="col-md-1 control-label">PZQ Returned</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="pzq_returned" id="pzq_returned" placeholder="Type">
                </div> 
               <!--  <label for="return_stamp" class="col-md-1 control-label">SP Received</label>
                <div class="col-md-1">
                    <input type="number" class="form-control input-sm" name="return_stamp" id="return_stamp" placeholder="Type">
                </div> -->

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
            <th>District</th>
            <th>Pick Up</th>
            <th>Pick Up Stamp</th>
            <th>Return</th>
            <th>Return Stamp</th>
            <th>Alb Received</th>
            <th>PZQ received</th>
            <th>ALB Returned </th>
            <th>PZQ Returned </th>

          </thead>
          <tbody>
            <?php 
                if ($data) {
                  foreach ($data as $key => $value) {
                    echo "<tr>";
                      echo "<td>".$value['district_id']."</td>";
                      echo "<td>".$value['pick_up']."</td>";
                      echo "<td>".$value['pick_up_stamp']."</td>";
                      echo "<td>".$value['return_status']."</td>";
                      echo "<td>".$value['return_stamp']."</td>";
                      echo "<td>".$value['alb_received']."</td>";
                      echo "<td>".$value['pzq_received']."</td>";
                      echo "<td>".$value['alb_returned']."</td>";
                      echo "<td>".$value['pzq_returned']."</td>";
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





