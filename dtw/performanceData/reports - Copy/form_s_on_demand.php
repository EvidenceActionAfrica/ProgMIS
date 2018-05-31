<?php
//require_once ("../../includes/auth.php"); 
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
    <head>
        <title>Evidence Action</title>
        <?php
        require_once ("includes/meta-link-script.php");
        ?>
    </head>
    <body>
        <!---------------- header start ------------------------>
        <div class="header" >
            <div style="float: left; margin-bottom: -40%;">  <img src="../../images/logo.png" />  </div>
            <div class="menuLinks" >
                <?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        
        <div class="clearFix" ></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
<!--            <div class="dashboard_menu" style="padding-bottom: 10px;">
            <center><?php //require_once "includes/on-demand-menu-tabs.php"; ?></center>
            </div>-->
            <iframe src="http://64.91.229.62:3838/Form_S/" width="100%" height="1400px" frameborder="0">
                <p>Your browser does not support i frames.</p>
            </iframe>
            <!--================================================-->
        </div> </center><!--end of content Main -->
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->

    </body>
</html>












