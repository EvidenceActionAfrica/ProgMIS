<?php
ob_start();
// require_once ('includes/config.php');
// require_once ('includes/auth.php');
// require_once ("includes/functions.php");
// require_once ("includes/form_functions.php");
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
error_reporting(E_ALL);
ini_set('display_errors', '1');
$placeholder="N/A";
$tabActive = "tab1"; //wierdness
$placeholder="No Data";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

// this is for district ntd
// include "includes/class.ntd.pzq.php";
// $ntdPZQ=new ntdPZQ;

// $data=$ntdPZQ->getAll();

include "includes/class.ntd.php";
$ntd=new ntd;

$data=$ntd->getAll();
$dataPZQ=$ntd->getAllPZQ();


 // privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  
  $priv_ciff_kpi= $row['priv_ciff_kpi'];
  $priv_ciff_report= $row['priv_ciff_report'];
  $priv_end_fund= $row['priv_end_fund'];
  $priv_ntd= $row['priv_ntd'];
  $priv_usaid= $row['priv_usaid'];
  $priv_who= $row['priv_who'];



}
if($priv_ciff_kpi==0 && $priv_ciff_report==0 && $priv_end_fund==0 && $priv_ntd==0 && $priv_usaid==0 && $priv_who==0){
 
  header("Location:../../home.php");
}else{

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>
    <script type="text/javascript">
     $(window).load(function() {
    $('#loading').hide();
  });

    </script>

    <style type="text/css">
      #loading {
  width: 100%;
  height: 100%;
  top: 0px;
  left: 0px;
  position: fixed;
  display: block;
  opacity: 0.4;
  background-color: #fff;
  z-index: 99;
  text-align: center;
}

#loading-image {
  position: absolute;
  top: 300px;
  left: 600px;
  z-index: 100;
  width: 50px;
}
    </style>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header vnav_100px">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?> 
        <?php //require_once ("includes/loginInfo.php"); ?> 
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
      </div>
      <div class="contentBody">
        <!--================================================-->
        <div id="loading">
  <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
</div>

			<div class="tabbable" >
  
        <!-- <ul class="nav nav-pills nav-pills-background "> -->
        <ul class="nav nav-tabs nav-pill-background">
          <li class= "<?php if ($tabActive == 'CIFF') echo 'pactive'; ?>"><a href="#CIFF" data-toggle="tab">CIFF</a></li>
          <li class= "<?php if ($tabActive == 'End') echo 'a'; ?>"><a href="#End" data-toggle="tab">End Fund</a></li>
          <li class= "<?php if ($tabActive == 'NTD_STH') echo 'apctive'; ?>"><a href="#NTD_STH" data-toggle="tab">NTD ALB</a></li>
          <li class= "<?php if ($tabActive == 'NTD_PZQ') echo 'apctive'; ?>"><a href="#NTD_PZQ" data-toggle="tab">NTD PZQ</a></li>
          <li class= "<?php if ($tabActive == 'USAID') echo 'pactive'; ?>"><a href="#USAID" data-toggle="tab">USAID</a></li>
          <li class= "<?php if ($tabActive == 'WHO') echo 'pactive'; ?>"><a href="#WHO" data-toggle="tab">WHO</a></li>
          
        </ul>
        <div class="tab-content">
           <!--tab 3-->
          <div class="tab-pane <?php if ($tabActive == 'CIFF') echo 'active'; ?>" id="CIFF">
            <?php include "comprehensiveCiffReport.php" ?>
          </div>
          <!--tab 1-->
          <div class="tab-pane <?php if ($tabActive == 'End') echo 'active'; ?>" id="End">
            <?php include "comprehensiveEndFund.php"; ?>
          </div>
          <!--tab 2-->
          <div class="tab-pane <?php if ($tabActive == 'NTD_STH') echo 'active'; ?>" id="NTD_STH">
            <?php include "district-report-ntd-sth.php"; ?>
             
          </div>

          <!--tab 2-->
          <div class="tab-pane <?php if ($tabActive == 'NTD_PZQ') echo 'active'; ?>" id="NTD_PZQ">
            <?php include "district-report-ntd-pzq.php"; ?>
             
          </div>
          <!--tab 3-->
          <div class="tab-pane <?php if ($tabActive == 'USAID') echo 'active'; ?>" id="USAID">
            <?php include "comprehensiveUSAID.php" ?>
          </div>

          <!--tab 3-->
          <div class="tab-pane <?php if ($tabActive == 'WHO') echo 'active'; ?>" id="WHO">
            <?php include "comprehensiveWho.php" ?>
          </div>
          
          
        </div>
      </div>
     
	  </div> <!-- end content body-->





        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable();

  } );
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('table.display').dataTable();
} )
</script>

<?php
}
ob_flush();
?>


