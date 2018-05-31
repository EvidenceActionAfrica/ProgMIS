<?php

require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder="N/A";
$tabActive = "tab1"; //wierdness
$data="No Data";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";
// $level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        <?php require_once ("includes/menuNav.php"); ?> 
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
<!-- Nav tabs -->
<ul class="nav nav-pills">
  <li class="active"><a href="#endfund" data-toggle="tab">End Fund</a></li>
  <li><a href="#profile" data-toggle="tab">NTD</a></li>
  <li><a href="#messages" data-toggle="tab">USAID</a></li>
  <li><a href="#messages" data-toggle="tab">WHO</a></li>
  <li><a href="#messages" data-toggle="tab">CIFF</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane active" id="endfund"> <?php include "comprehensiveEndFund.php"; ?> </div>
  <div class="tab-pane" id="profile">..profile.</div>
  <div class="tab-pane" id="messages">.messages..</div>
  <div class="tab-pane" id="settings">...</div>
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



