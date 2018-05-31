<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); //use root
require_once('assumptions.func.php');
include "reverseCascade.func.php";


$Cascade = New reverseCascade();
$divisions=$Cascade->getDivisions();
$districts=$Cascade->getDistricts();
$counties=$Cascade->getCounties();
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>

    <?php
    require_once ("includes/meta-link-script.php");

    ?>

      <link rel="stylesheet" type="text/css" href="css/tabs.css">
   
     <!-- // <script src="../js/jquery.min.js"></script> -->

     <script src='js/customTabs.js'></script>

     <script type="text/javascript">

     // this is for the tabs
     //  only wirks for two tabs
      $(document).ready(function(){

        console.log("ready");
        $("#page2").hide();

        $("#tabHeader_2").click(function(){

          $("#page2").show();
          $("#page1").hide();
          $( "#tabHeader_2" ).addClass( "tabActiveHeader" );
          $( "#tabHeader_1" ).removeClass( "tabActiveHeader" );

        });

        $("#tabHeader_1").click(function(){

          $("#page2").hide();
          $("#page1").show();
          $( "#tabHeader_1" ).addClass( "tabActiveHeader" );
          $( "#tabHeader_2" ).removeClass( "tabActiveHeader" );

        });



      });

</script>
   

  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
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
        <?php
        require_once ("includes/menuLeftBar-Reverse.php");
        ?>
      </div>
      <div class="contentBody" >
        <!--================================================-->
       
       

              <!--tab skeleton-->
        <div class="tabbable" >
          <ul class="nav nav-tabs">
            <li class="<?php if ($tabActive == 'tab1') echo 'active'; ?>"><a href="#tab1" data-toggle="tab">Add Return Form A</a></li>
            <li class="<?php if ($tabActive == 'tab2') echo 'active'; ?>"><a href="#tab2" data-toggle="tab">View Return Form A</a></li>

          </ul>
          <div class="tab-content">
            <div class="tab-pane <?php if ($tabActive == 'tab1') echo 'active'; ?>" id="tab1">
              <form method="post" action="" name="csv_upload_form" id="csv_upload" enctype="multipart/form-data">
                <div class="vspan1 vfloatleft">
                  <label>County</label>
                  <select onchange="get_district(this.value);">
                    <?php
                    foreach ($counties as $key => $value) {
                      echo "<option value=" . $value['county_id'] . ">" . $value['county_name'] . "</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="vspan1 vfloatleft">
                  <label>District</label>
                  <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict">
                    <option value="">Choose District</option></select>



                <!-- <select>
                  <?php
                  foreach ($districts as $key => $value) {
                    echo "<option>" . $value['dis'] . "</option>";
                  }
                  ?>
                </select> -->
                </div>

                <div class="vspan1 vfloatleft">
                  <label>Division</label>
                  <select id="selectdivision" name="selectdivision" onchange="get_school(this.value);">
                    <option value="">Choose Division</option>
                  </select>

                </div>

                <!-- <div class="vclear"></div> -->
                <label for="file">Filename:</label>
                <input type="file" name="file" id="file" required/><br/>
                <div class="vspan1 v-top-margin10 vfloatleft">
                  <input class="btn-custom-tiny" type="submit" name="csv_upload" value="Upload" >
                </div>
              </form>
            </div>
            <!--end tab 1-->

            <div class="tab-pane <?php if ($tabActive == 'tab2') echo 'active'; ?>" id="tab2">
              <?php include "form_attnt.php"; ?>
            </div>

          </div>
        </div>


      
        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--filter includes-->
    <script type="text/javascript" src="css/filter-as-you-type/jquery.min.js"></script>
    <script type="text/javascript" src="css/filter-as-you-type/jquery.quicksearch.js"></script>
    <script type="text/javascript">
    $(function() {
      $('input#id_search').quicksearch('table tbody tr');
    });

    function submitForm() {
      document.getElementById('imgLoading').style.visibility = "visible";
      var selectButton = document.getElementById('btnSearchSubmit');
      selectButton.click();
    }
    </script>
    <!--Delete dialog-->
    <script>
      function show_confirm(deleteid) {
        if (confirm("Are You Sure you want to delete?")) {
          location.replace('?deleteid=' + deleteid);
        } else {
          return false;
        }
      }
    </script>
  </body>
</html>


<script>
  //GET district
  function get_district(txt) {
    $.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }

</script>



 



