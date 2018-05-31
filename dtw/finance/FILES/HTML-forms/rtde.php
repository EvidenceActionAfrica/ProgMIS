<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once("../includes/function_convert_number_to_words.php");
$tabActive = "tab1";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("includes/meta-link-script.php");
    ?>  
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">   
      <link href="css/default.css" type="text/css" rel="stylesheet">   
        </head>
        <body>
          <!---------------- header start ------------------------>
          <div class="header">
            <div style="float: left">  <img src="../images/logo.png" />  </div>
            <div class="menuLinks">
              <?php
              require_once ("includes/menuNav.php");
              ?>
            </div>
          </div>
          <div class="clearFix"></div>
          <!---------------- content body ------------------------>
          <div class="contentMain">
            <div class="contentLeft">
              <?php require_once ("includes/menuLeftBar-Settings.php"); ?>
            </div>
            <div class="contentBody">




              <div class="tabbable" >
                <ul class="nav nav-tabs">
                  <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Section 1: Add CHEQUE request Form</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab2') echo 'active'; ?>" href="#tab2" data-toggle="tab">Section 2:Filled By Accounts</a></li>
                  <li><a  class="<?php if ($tabActive == 'tab3') echo 'active'; ?>" href="#tab3" data-toggle="tab">Section 3:Delivery Confirmation</a></li>                   
                </ul>
                <div class="tab-content">
                  <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>"  id="tab1">
                    fffff
                  </div>
                  <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>"  id="tab2">
                    dddd
                  </div>
                  <div class="tab-pane <?php if ($tabActive == 'tab3') echo 'active'; ?>"  id="tab3">
                    eeeeeee
                  </div>
                </div>
              </div>
            </div>
          </div>
        </body>
        </html>


        <!--filter includes-->
        <script type="text/javascript" src="../css/filter-as-you-type/jquery.min.js"></script>
        <script type="text/javascript" src="../css/filter-as-you-type/jquery.quicksearch.js"></script>
        <script type="text/javascript">
          $(function() {
            $('input#id_search').quicksearch('table tbody tr');
          });
        </script>
        <script>
          function show_confirm(deleteid) {
            if (confirm("Are you sure you want to delete?")) {
              location.replace('?deleteid=' + deleteid);
            } else {
              return false;
            }
          }

        </script>
        <div id="openModal" class="modalDialog">
          <div style="width:80%;margin-top:1%;">

          </div>
        </div>
