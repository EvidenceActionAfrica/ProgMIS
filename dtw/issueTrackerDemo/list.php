<?php
  require_once ('includes/auth.php');
  require_once ('../includes/config.php');
  require_once ("../includes/functions.php");
  require_once ("../includes/form_functions.php");
  require_once ("../includes/function_convert_number_to_words.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?>  
    <link href="css/bootstrap-responsive.min.css" type="text/css" rel="stylesheet">   
    <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">   
    <link href="css/default.css" type="text/css" rel="stylesheet">   
  </head>

  <body>

    <!-- header start -->
    <div class="header clearfix">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>

    <!-- content body -->
    <div class="contentMain clearFix">

      <!-- <div class="contentLeft"><?php //require_once("includes/menuLeftBar-Settings.php"); ?></div> -->
      
      <div class="container">

        <h1 style="text-align: center; margin-top: 0px">Issue Tracking</h1>
        <div class="row">
          
          <div class="col-md-2">

            <h4>Issue Categories</h4>
            
            <ul class="nav nav-pills nav-stacked">
              <li><a href="#">Inadequate Drugs</a></li>
              <li><a href="#">Funds Disbursment</a></li>
              <li><a href="#">Forms Returns</a></li>
            </ul>

          </div>
          
          <div class="col-md-9">    

            <div class="clearfix">            

              <ul class="nav nav-pills pull-left">
                <li><a href="index.php">Map View</a></li>
                <li class="active"><a href="list.php">List View</a></li>
              </ul>
              
              <a href="new-issue.php" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Raise New Issue</a>

            </div>
            <br><br>

            <div id="issue-list">

              <table class="table table-hover table-striped" >
                <thead>
                  <tr>
                    <th>Issue Category</th>
                    <th>Location</th>
                    <th>Date Raised</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><a href="issue-single.php" >Inadequate Drugs</a></td>
                    <td><a href="issue-single.php" >Bondo County</a></td>
                    <td><a href="issue-single.php" >25-06-2014</a></td>
                    <td><a href="issue-single.php" >Paul Nyaga</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-minus-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Funds Disbursement</a></td>
                    <td><a href="issue-single.php" >Nyahururu District</a></td>
                    <td><a href="issue-single.php" >21-06-2014</a></td>
                    <td><a href="issue-single.php" >John Doe</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-exclamation-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Forms Returns</a></td>
                    <td><a href="issue-single.php" >Bomet County</a></td>
                    <td><a href="issue-single.php" >19-06-2014</a></td>
                    <td><a href="issue-single.php" >Jane Dean</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-ok-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Inadequate Drugs</a></td>
                    <td><a href="issue-single.php" >Bondo County</a></td>
                    <td><a href="issue-single.php" >25-06-2014</a></td>
                    <td><a href="issue-single.php" >Paul Nyaga</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-minus-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Funds Disbursement</a></td>
                    <td><a href="issue-single.php" >Nyahururu District</a></td>
                    <td><a href="issue-single.php" >21-06-2014</a></td>
                    <td><a href="issue-single.php" >John Doe</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-exclamation-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Forms Returns</a></td>
                    <td><a href="issue-single.php" >Bomet County</a></td>
                    <td><a href="issue-single.php" >19-06-2014</a></td>
                    <td><a href="issue-single.php" >Jane Dean</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-ok-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Inadequate Drugs</a></td>
                    <td><a href="issue-single.php" >Bondo County</a></td>
                    <td><a href="issue-single.php" >25-06-2014</a></td>
                    <td><a href="issue-single.php" >Paul Nyaga</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-minus-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Funds Disbursement</a></td>
                    <td><a href="issue-single.php" >Nyahururu District</a></td>
                    <td><a href="issue-single.php" >21-06-2014</a></td>
                    <td><a href="issue-single.php" >John Doe</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-exclamation-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Forms Returns</a></td>
                    <td><a href="issue-single.php" >Bomet County</a></td>
                    <td><a href="issue-single.php" >19-06-2014</a></td>
                    <td><a href="issue-single.php" >Jane Dean</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-ok-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Inadequate Drugs</a></td>
                    <td><a href="issue-single.php" >Bondo County</a></td>
                    <td><a href="issue-single.php" >25-06-2014</a></td>
                    <td><a href="issue-single.php" >Paul Nyaga</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-minus-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Funds Disbursement</a></td>
                    <td><a href="issue-single.php" >Nyahururu District</a></td>
                    <td><a href="issue-single.php" >21-06-2014</a></td>
                    <td><a href="issue-single.php" >John Doe</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-exclamation-sign"></span></a></td>
                  </tr>
                  <tr>
                    <td><a href="issue-single.php" >Forms Returns</a></td>
                    <td><a href="issue-single.php" >Bomet County</a></td>
                    <td><a href="issue-single.php" >19-06-2014</a></td>
                    <td><a href="issue-single.php" >Jane Dean</a></td>
                    <td><a href="issue-single.php" ><span class="glyphicon glyphicon-ok-sign"></span></a></td>
                  </tr>
                </tbody>

              </table>

            </div>



      </div><!--end of content body -->

    </div><!--end of content Main -->

    <!--jQuery Include-->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

    <!--Bootstrap3 Js Include-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>