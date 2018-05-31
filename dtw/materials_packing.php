<?php
ob_start();
date_default_timezone_set("Africa/Nairobi");
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('pdf/materials_summary.php');
$level = $_SESSION['level'];
$testdata = 'testdata';
$tabActive = 'tab1';
$updateResult="";

require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();
  if(isset($_GET['printPdf'])){
    //It Simply mean a pdf was selected for download

    if($_GET['printPdf']=='summary'){

      createpackagingSummary();
     
    }
    if($_GET['printPdf']=='box_summary' && isset($_GET['package_id'])){
      createBoxSummary($_GET['package_id']);
    }
  }

  if(isset($_GET["tab"])){

    $tabActive="tab".$_GET["tab"];
    $county=$_GET["countyName"];
    $district=$_GET["districtName"];

}
if(isset($_GET["unpackVendor"])==1){
    $sql="UPDATE materials_printlist_history SET packaged=0 WHERE status=1";
    mysql_query($sql);
    header("Location:materials_packing.php#addDistrict");
}
if(isset($_GET["action"])=="add"){
  $tabActive = 'tab3';

  //$sql="UPDATE materials_packaging_history set dtb_quantites='' WHERE printlist_id='$printlistId'";
  //$sql.=" AND countyName='$county' AND districtName='$district'";
  //mysql_query($sql) or die(mysql_error());

}

  if(isset($_GET["materialsContentDelete"])){
  	$tabActive = 'tab2';
  }

$sql="select * from materials_printlist_history where status=1";

$resultA=mysql_query($sql);
while($row=mysql_fetch_array($resultA)){

	$printlistId=$row["id"];
}

if(isset($_POST["savePackages"])){
    $tabActive = 'tab1';
}

  if(isset($_GET["deletePackageId"])){
    $tabActive = 'tab2';
    $packageId=$_GET["deletePackageId"];
    $sql="DELETE from materials_packaging_history_data where package_id='$packageId'";
    mysql_query($sql);


  }




  
      ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>  
  
   <link href="css/materials.css" rel="stylesheet" type="text/css"/> 
  </head>


  <!-- Modal includes -->
  <link rel="stylesheet" type="text/css" href="css/modal.css"/>

  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
                <?php
                  if(stristr($_SESSION['staff_role'],'vendor') ){
                      require_once ("includes/menuNav_strict.php"); 
                  }else{
                      require_once ("includes/menuNav.php"); 
                    }

                 ?>
        <?php  // require_once ("includes/menuNav.php");  ?>
    <link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
   
      </div>
    </div>
 <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
                <?php
                  if(stristr($_SESSION['staff_role'],'Vendor') ){
                     // require_once ("includes/menuNav_strict.php"); 
                  }else{
                      require_once ("includes/menuLeftBar-Materials.php");
                    }

                 ?>
       </div>
      <div class="contentBody" >
          <h2 align="center">Vendor Packing</h2>
           <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">
               
				<h4 class="text-center">Warning!</h4>
				   This Form will only display data from the active printlist order.Before you continue, make sure the active printlist 
				   is the one agreed upon.
   		   </div>
      
        <div class="tabbable" >
          <ul class="nav nav-tabs">

           
     <li <?php if ($tabActive == 'tab1') echo "class='active'" ?>><a href="#tab1" data-toggle="tab">General Packaging Information</a></li>
     <li <?php if ($tabActive == 'tab2') echo "class='active'" ?>><a href="#tab2" data-toggle="tab">Boxes Package Details</a></li>
               
         
      <!---      <li <?php if ($tabActive == 'tab3') echo "class='active'" ?>><a href="#tab3" data-toggle="tab">District Training Boxes</a></li>
             <li <?php if ($tabActive == 'tab4') echo "class='active'" ?>><a href="#tab4" data-toggle="tab">Teacher Training Boxes</a></li>
         -->
          </ul>
          <div class="tab-content">
            
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
            
  				<?php  require_once("materials_general.php");   ?>

            </div>

		 	<div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>" id="tab3">
          <?php require_once("materials_DTB.php"); ?>
      </div>

      <div class="tab-pane <?php if ($tabActive == 'tab4') echo 'active'; ?>" id="tab4">
          <?php require_once("materialsAddBox.php"); ?>
        </div>
       <div class="tab-pane <?php if ($tabActive == 'tab5') echo 'active'; ?>" id="tab5">
          <?php require_once("materialsEditBox.php"); ?>
        </div>


      <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
          <?php require_once('materials_distribution.php'); ?>
      </div>





        </div>
    </div>
   </div>


</body>

<div id="editTotal" class="modalDialog" style="width:120%;margin-left:-5%; ">
  <div >
    <div>
    <a href="materials_packing.php" title="Close" class="close">X</a>
    <!-- ================= -->
    <?php

if(isset($_POST["updateTotalBoxes"])){
  $noBox=$_POST["noBox"];
  $districtNameId=$_POST["districtNameId"];
  $sql="UPDATE materials_packaging_history set noBox='$noBox' WHERE id='$districtNameId'";
 
  mysql_query($sql);
$updateResult="Total Boxes Updated";
}







$printlist_id=$_GET["printlistId"];
$countyName=$_GET["countyName"];
 $districtName=$_GET["districtName"];

 $sql="select noBox,id from materials_packaging_history where countyName='$countyName' AND districtName='$districtName' AND";
 $sql.=" printlist_id='$printlist_id'";
 $resultS=mysql_query($sql);
while($row=mysql_fetch_array($resultS)){
  $noBox=$row["noBox"];
  $districtNameId=$row["id"];

    ?>
                <form  method="POST" style="margin-left:2%;">

    <?php echo "<h3 class='text-center' style='background:#bada66;color:#FFFF;'>".$updateResult."</h3>"; ?>

                              <div style="margin-left:10%;">

                                <img style="width:10%;" src="../images/gklogo.png"/>
                  <b>Kenya National School-Based Deworming Programme</b>
                                <img style="width:10%;" src="../images/kwaAfya.png"/>
                              <hr style="font-weight:bolder;color:#EEEE;"/>
                                </div>   
                      <h4 style="margin-left:20%;">Number of boxes</h4>
                     
                    <table class="table table-bordered table-condensed table-striped table-hover"> 
                        <tr>
                         <th>County</th>
                          <th>Sub-County</th>
                          <th>Number Of Boxes</th>
                        </tr>
                        <tr>
                          <td><?php echo $countyName; ?></td>
                          <td><?php echo $districtName; ?></td>
                          <td><input type="text" class="num-only " name="noBox" value="<?php echo $noBox; ?>" /></td>
                        
                        </tr>

                    </table>
                   <input type="hidden" name="districtNameId" value="<?php echo $districtNameId; ?>" />
                    <input type="submit" style="margin-left:30%;" class="btn btn-info" name="updateTotalBoxes" value="Update Details" />
                </form>
<?php
}
?>
    </div>
  </div>
</div>
    <!-- ================= -->
<?php
$result = mysql_query("SELECT DiSTINCT a.county_name,a.district_name FROM a_bysch as a,rollout_activity as r  where a.district_name=r.activity_venu ORDER BY a.county_name");
   $num_rows=mysql_affected_rows();
if(isset($_POST["addDistrict"])){
        $num_rows=mysql_num_rows($result);
        $count=1;
        $districtArr=array();
        while($count<=$num_rows){
 //    echo "District ".$_POST["district".$count]."Selected<br/>".$_POST["selection".$count];
    if($_POST["district".$count] !=null){        
        //  echo $_POST["selection".$count];
          $selection=isset($_POST["selection".$count])?$_POST["selection".$count]:"NO";
        //  echo $selection."<br/>";
          $county=isset($_POST["county".$count])?$_POST["county".$count]:"";
          $district=isset($_POST["district".$count])?$_POST["district".$count]:"";
          if($selection=="YES"){
            array_push($districtArr,$district);
          }
    }
     ++$count;
     }

      
       $districtArr=serialize($districtArr);
       $sql="UPDATE materials_printlist_history SET districts='$districtArr' where status=1";
       $resultP=mysql_query($sql);
     
      

}


?>
 <!-- Add District Modal-->
 <div id="addDistrict" class="modalDialog" >
    
  <div >
         <a href="materials_packing.php" title="Close" class="close">X</a>

    <div  style="max-height:450px; overflow:scroll;">
             <div style="margin-left:0%;margin-top:0%;" class="alert alert-block">
               
				<h4 class="text-center">Warning!</h4>
				 This Violates the Sub-County set For Your Print Order.
   		   </div>
        
<form  action='materials_packing.php' method="post">
  <h2 style="margin-left:30%;"><u>Set Sub-County for Packaging.</u></h2>
  <h2 id="h2info"style="background:#bada66;text-align:center;"><?php echo $updateResult; $updateResult=""; ?></h2>
 <a style=" appearance:hyperlink;" class="btn" onclick="checkAll();"/>CHECK ALL </a> &nbsp; <a  class="btn" onclick="uncheckAll();">UNCHECK ALL</a><br/>
 
  <table class="table table-bordered table-condensed table-striped table-hover">
    <thead>
        <tr>
          <th>Number</th>
          <th>County</th>
          <th>Sub-County</th>
          <th>Select</th>
        </tr>
      </thead>
      <style>
          .texte{
              width:100%;
              border:0px solid rgb(255,255,255);
              background:rgba(0,0,0,.8);
              height:100%;
          }
      </style>
      <?php
 
   $count=1;
  
    while($row=mysql_fetch_array($result)){

      echo "<tr>";
      echo "<td>".$count."</td><td><input class='texte' type='text' value='".$row["county_name"]."' readonly name='county".$count."' /></td><td><input class='texte' type='text' readonly  value='".$row["district_name"]."' name='district".$count."' /></td><td><input type='checkbox' class='checkers' name='selection".$count."' value='YES' checked='checked' /></td>";
      echo "</tr>";
      ++$count;
    }
    echo "Total Sub-Counties: ".$num_rows;
 ?>
  </table>
  <?php if($priv_materials_edit>=2){ ?>
  <input type="submit" name="addDistrict" class="btn-custom" style="margin-left:30%;" value="Set Sub-Counties" />
  <?php } ?>
</form>

    </div>
  </div>
</div>
 

<script>

      $(document).find("input.num-only").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
               // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
               // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                   // let it happen, don't do anything
                   return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });


function checkAll(){
    
     $(".checkers").prop("checked", true);
}
function uncheckAll(){
     $(".checkers").prop("checked", false);
}
</script>
</html>
