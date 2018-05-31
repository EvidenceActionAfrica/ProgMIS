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
        <div class="header">
            <div style="float: left">  <img src="../../images/logo.png" />  </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <div class="contentLeft"><h3>On demand</h3>
                <ul>
                    <a href="form_attnt_on_demand.php"><li>Form Attnt</li></a>
                    <a href="form_s_on_demand.php"><li>Form P</li></a>
                    <a href="form_p_on_demand.php"><li>Form S</li></a>
                </ul>
            </div>
            <center>
                <div class="contentBody">

                    <h1 style="text-align: center; margin-top: 40px" class="padding-bottom-10  ">On Demand</h1>
                    
                    <div class="dashboardMenu2" style="width: 86%;">

                        <a href="form_attnt_on_demand.php"><div class="menuTile menu-tile-longest" style="background-color: #C4546A; width: 29%" onMouseOut="this.style.backgroundColor = '#C4546A'" onMouseOver="this.style.backgroundColor = '#C4546A'">
                                Form Attnt<br/><br/>
                                <img align="middle" src="../../images/files2.png" height="100px"/>
                            </div> </a>
                        <a href="form_p_on_demand.php"><div class="menuTile menu-tile-longer" style="background-color: #2A4E5C; width: 29%;" onMouseOut="this.style.backgroundColor = '#2A4E5C'" onMouseOver="this.style.backgroundColor = '#305968'">
                                Form P<br/><br/>
                                <img align="middle" src="../../images/files2.png" height="100px"/>
                            </div> </a>
                        <a href="form_s_on_demand.php"><div class="menuTile menu-tile-longest" style="background-color: #606060; width: 28%" onMouseOut="this.style.backgroundColor = '#606060'" onMouseOver="this.style.backgroundColor = '#606060'">
                                Form S<br/><br/>
                                <img align="middle" src="../../images/files2.png" height="100px"/>
                            </div> </a>
                    </div>

                    <!--================================================-->
                </div> </center><!--end of content Main -->
        </div>
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------>
        <!--<div class="footer">  </div>-->

    </body>
</html>












