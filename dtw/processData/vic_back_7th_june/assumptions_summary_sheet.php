<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ('../includes/form_functions.php');
require_once('assumptions.func.php');
// require_once ('../includes/db_functions.php');
//$evidenceaction = new EvidenceAction();
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php
    require_once ("../includes/meta-link-script.php");
    ?>
    <script src="../js/jquery.min.js"></script>
  </head>
  <body onload="document.getElementById('imgLoading').style.visibility = 'hidden';">
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
      <div class="contentLeft">
        <?php
        require_once ("includes/menuLeftBar-Drugs.php");
        ?>
      </div>
      <div class="contentBody" >
        
        <!--<h1 >School List</h1>-->
        <form action="#">
          <!-- <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus /> -->
          <img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <!-- <a class="btn-custom-small" href="PHPExcel/AdminData/schools.php?searchQuery=<?php echo $searchQuery; ?>">Export to Excel</a> -->
          <b style="text-align: center; margin-top: 0px; font-size: 22px; margin-left: 100px ">Assumption Summary Sheet</b>
          <!--<a class="btn-custom-small" href="#addSchool">Add School</a>-->
        </form>

          <?php $data = rand(0,9); ?>
          <!-- <div style="width:4500px; height:450px; overflow-y: scroll; "> -->
          <table border=1>
            <tr>
              <td></td>
              <td></td>
              <td colspan="3">Required in 2014 programme</td>
              <td>Total Available in Ministry for 2014 programme</td>
              <td colspan="3">To be requisitioned</td>
            </tr>

            <tr>
              <td></td>
              <td>Treatments</td>
              <td>Before March</td>
              <td>Before August</td>
              <td>Total</td>
              <td>Total</td>
              <td>Before March</td>
              <td>Before August</td>
              <td>Total</td>
            </tr>
            <tr>
              <td>Albendazole</td>
              <td><?php echo summary_sheet_alb_treatment(); ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
            </tr>
            <tr>
              <td>Praziquantel</td>
              <td><?php echo summary_sheet_pzq_treatment(); ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
              <td><?php echo $data ?></td>
            </tr>
          </table>
    <!--  ============================================-->
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
    $.post('../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
      $('#selectdistrict').html(data);//alert(data);
    });
  }
  //GET divisions
  function get_division(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
      $('#selectdivision').html(data);//alert(data);
    });
  }
  //GET Schools
  function get_school(txt) {
    $.post('../ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
      $('#selectschool').html(data);//alert(data);
    });
  }

</script>


