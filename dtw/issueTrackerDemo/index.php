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
        <?php
          require_once ("includes/menuNav.php");
        ?>
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
                <li class="active"><a href="index.php">Map View</a></li>
                <li><a href="list.php">List View</a></li>
              </ul>
              
              <a href="new-issue.php" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Raise New Issue</a>

            </div>
            <br>

            <div id="projects-map" style="width:100%;height:600px;">&nbsp;</div>

            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script> 
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
            <script type="text/javascript">
            
                $(document).ready(function() {
                    
                    var projects = [
                        ['Bomet',-0.779579, 35.333891, 'bomet'],
                        ['Nyahururu',0.032012, 36.332274,'Nyahururu'],
                        ['Bondo',-0.098984, 34.287104,'Bondo']

                    ];

                    //------- Google Maps ---------//                     
                    // Creating a LatLng object containing the coordinate for the center of the map
                    var latlng = new google.maps.LatLng(0.540725, 37.771767);
                      
                    // Creating an object literal containing the properties we want to pass to the map  
                    var options = {  
                        zoom: 7, // This number can be set to define the initial zoom level of the map
                        center: latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP // This value can be set to define the map type ROADMAP/SATELLITE/HYBRID/TERRAIN
                    };  
                    
                    // Calling the constructor, thereby initializing the map  
                    var map = new google.maps.Map(document.getElementById('projects-map'), options);  
                    // Define Marker properties
                    var image = new google.maps.MarkerImage('http://covaw.sprintwebhosts.com/wp-content/themes/wonderwoman/img/map-marker.png',
                        // This marker is 129 pixels wide by 42 pixels tall.
                        new google.maps.Size(42, 42),
                        // The origin for this image is 0,0.
                        new google.maps.Point(0,0),
                        // The anchor for this image is the base of the flagpole at 18,42.
                        new google.maps.Point(18, 42)
                    );

                    for (var i = 0; i < projects.length; i++) {
                                             
                        // Add Marker(s)   
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(projects[i][1],projects[i][2]), 
                            map: map,
                            slug:projects[i][3]/*,       
                            icon: image // This path is the custom pin to be shown. Remove this line and the proceeding comma to use default pin*/
                        });

                        google.maps.event.addListener(marker, 'click', function() {
                            var url = 'http://xemplar.biz/evidence-action/issueTrackerdemo/issue-single.php', 
                                redirect = url+'?project='+this.slug;
                            window.location.href = redirect;
                        });
                    }
                
                });
            </script>

            </div>



      </div><!--end of content body -->

    </div><!--end of content Main -->

    <!--jQuery Include-->
    <script type="text/javascript" src="js/jquery-1.11.0.min.js"></script>

    <!--Bootstrap3 Js Include-->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

  </body>
</html>