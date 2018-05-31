<?php
require_once ('../includes/auth.php');
// require_once ('../includes/config.php');
// require_once ("../includes/functions.php");
// require_once ('../includes/form_functions.php');
// require_once('assumptions.func.php');

require_once "includes/class.districtList.php";
$ClassDistrictList = new districtList;

error_reporting(E_ALL);
ini_set('display_errors', '1');
// get counties
$counties=$ClassDistrictList->getAssumptionlistCounty();

if (isset($_POST['add-treatment'])) {
  echo $treatment = $_POST['date'];
  echo $county_id = $_POST['county_id'];  

  // exit();

  $ClassDistrictList->updateNextTreatment($treatment,$county_id);
}


// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();
    ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/drugs-meta-link-script.php");
    ?>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >
        
         <form action="" method="post" class="form-horizontal" role="form">
          <div class="form-group">
            <!-- <span class="col-md-2 control-label">County</span> -->
            <label for="county_name" class="col-md-2 control-label">County</label>
            
            <div class="col-md-2">
             
              <select name ="county_id" id="county_select" class="form-control">
                <?php 
                  foreach ($counties as $key => $value) {
                    echo '<option value="'.$value['county_id'].'"">'.$value['county_name'].'</option>';
                  }
                ?>
              </select> 
            </div>  

            <div class="col-md-2">
               <input type="date" class="form-control input-sm" name="date" id="county_name_input" >
            </div>
          <button type="submit" name="add-treatment" class="btn btn-default update-log-submit">Save</button>

          </div>
        </form>

          <?php 
            foreach ($counties as $key => $value) {
              echo "<br>".$value['county_name'].$value['next'];
            }
         ?>

          </div>


        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


  </body>
</html>



<script type="text/javascript">
 //GET divisions
  function get_district(txt) {
  console.log(txt);

    $.post('districtList.php', {checkval: 'district', district: txt}).done(function(data) {
      // console.log(data);
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  </script>

  <!-- <script type="text/javascript" charset="utf8" src="js/jquery.dataTables.js"></script> -->
<link rel="stylesheet" type="text/css" href="css/dataTables.css">
<!-- <script src="//code.jquery.com/jquery-1.10.2.min.js"></script> -->
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script src="js/jquery.floatThead.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();
  } );
</script>




