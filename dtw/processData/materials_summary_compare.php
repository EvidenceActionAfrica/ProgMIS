<?php

date_default_timezone_set("Africa/Nairobi");
//The Materials Module need this because the number of queries performed are many, which may need more time to process
//than assigned by default in the server's config
ini_set('max_execution_time', 300); 
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("class.mathMaterials.php");
require_once("../includes/logTracker.php");

$M_module =2;

if(isset($_POST['confirmIrregular'])){

  $countyName=isset($_POST['countyName'])?mysql_real_escape_string($_POST['countyName']):'';
  $districtName=isset($_POST['districtName'])?mysql_real_escape_string($_POST['districtName']):'';
  $boxId=isset($_POST['boxId'])?mysql_real_escape_string($_POST['boxId']):'';

  $sql='UPDATE materials_packaging_history_data set comparison_status=3 WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_id="'.$boxId.'"';
  mysql_query($sql) or die(mysql_error());
  $action="Box with an id ".$boxId." has been confirmed as irregular";
  $description=" The box has been confirmed as irregular.It is a box for the sub-county ".$districtName.", county ".$countyName;
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);

}
if(isset($_POST['confirm'])){

  $countyName=isset($_POST['countyName'])?mysql_real_escape_string($_POST['countyName']):'';
  $districtName=isset($_POST['districtName'])?mysql_real_escape_string($_POST['districtName']):'';
  $boxId=isset($_POST['boxId'])?mysql_real_escape_string($_POST['boxId']):'';
  
  $sql='UPDATE materials_packaging_history_data set comparison_status=1 WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_id="'.$boxId.'"';
  mysql_query($sql) or die(mysql_error());
  $action="Box with an id ".$boxId." has been confirmed as regular";
  $description=" The box has been confirmed as regular.It is a box for the sub-county ".$districtName.", county ".$countyName;
  $ArrayData = array($M_module, $action, $description);
  quickFuncLog($ArrayData);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
       <link href="css/materials.css" rel="stylesheet" type="text/css"/>
    </head>


  <body>
      <!---------------- header start ------------------------>
      <div class="header">
        <div style="float: left">  <img src="../images/logo.png" />  </div>
        <div class="menuLinks">
          <?php   require_once ("includes/menuNav.php");  ?>
        </div>
      </div>
     <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <a href="materials_officials_Assumptions.php"></a>
          
          <div class="contentLeft">
            <?php
            require_once ("includes/menuLeftBar-Materials.php");
            ?>
          </div>
          <div class="contentBody" >

            <?php 
              if(isset($_GET['box_id'])){

                $boxId=$_GET['box_id'];
                $countyName=$_GET['countyName'];
                $districtName=$_GET['districtName'];

            $sql='SELECT * from materials_packaging_history_data as mpd WHERE  mpd.county_name="'.$countyName.'" AND mpd.district_name="'.$districtName.'" AND mpd.box_id="'.$boxId.'"';
                $resultA=mysql_query($sql)or die(mysql_error());
                $materials='';
                while($row=mysql_fetch_array($resultA)){
                  $materials=unserialize($row['material']);


                }

                echo '<form action="materials_summary_compare.php" method="POST">';
                echo '<input type="hidden" name="districtName" value="'.$districtName.'"/>';
                echo '<input type="hidden" name="boxId" value="'.$boxId.'"/>';
                echo '<input type="hidden" name="countyName" value="'.$countyName.'"/>';
                
                  foreach ($materials as $key => $value) {
                    

                    
                                $mat = substr($key, 0, 20);
                                if (strlen($key) > 20) {
                                    $mat.="..";
                                }
                                $material = ucwords(str_replace('_', ' ', $mat));
                                // $material=$value;

                                echo '                      <div style="margin:0px;margin-left:5%;width:40%;float:left;padding:0px;">
                                                      <label class="showTooltip " data-toggle="tooltip" data-placement="left" title="' . $key . '">' . $material .'(Packed Quantity:'.$value.')</label>
                                                        
                                            </div>
                                   ';
                              



                  }

                  echo '

                    <input type="submit" name="confirm" class="btn-custom-small" value="Confirm Collected Content As Similar"/> &nbsp;
                    <input type="submit" name="confirmIrregular" class="btn-custom-small" value="Confirm Collected Content As Irregular"/>

                  </form>';

              }else{
                ?>
              <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">

                Warning! &nbsp; This Form will only display data of the active Print Order/Vendor.
              </div>

            <h2>Comparison Between Materials Packaged & Materials Collected</h2>
            <br/><h4>NB:Only Confirmed Boxes may undergo comparison</h4>
            <br/>
              <?php
              $sql = "select * from materials_printlist_history where status=1";

              $resultA = mysql_query($sql);
              while ($row = mysql_fetch_array($resultA)) {

                  $printlistId = $row["id"];
              }
                //We Need To Display Boxes That Were Packaged and have been Collected
                //We Then Need To 
              $sql='SELECT * from materials_packaging_history_data as mpd,materials_collection_sms as mps WHERE mpd.box_id=mps.box_id AND mpd.collected=1 AND mps.confirmed=1 AND mpd.printlist_id='.$printlistId;
              $resultA=mysql_query($sql);
              $numRows=mysql_affected_rows();
              if($numRows>=1){
                ?>
                  <table class="table table-bordered table-condensed table-striped table-hover">
                      <tr>
                        <th>County</th>
                        <th>Sub-County</th>
                        <th>Box Id</th>
                        <th>Comparison Status</th>
                        <th>Quantity Check</th>
                      </tr>

                 
                <?php
              while($row=mysql_fetch_array($resultA)){
                  echo '<tr>';
                  echo '<td>'.$row['county_name'].'</td>';
                  echo '<td>'.$row['district_name'].'</td>';
                  echo '<td>'.$row['box_id'].'</td>';

                  if($row['comparison_status']==0){
                    echo '<td>Unconfirmed</td>';
                  }else if($row['comparison_status']==1){
                    echo '<td>OK</td>';
                  }else{
                    echo '<td>Irregular</td>';
                  }
                  
                  echo '<td><a href="materials_summary_compare.php?box_id='.urlencode($row['box_id']).'&countyName='.urlencode($row['county_name']).'&districtName='.urlencode($row['district_name']).'">Check Quantities</a>';
                  echo '</tr>';
                  }
                ?>
                </table>
                <?php
                }else{
                  echo '<h2>No Record Found For Comparison</h2>'; 
                }

              }
                ?>
                
          </div>
        </div> 
  </body>
</html>
