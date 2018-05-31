<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();
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
      <div class="contentBody">
        <!--================================================-->
        <?php
        //Delete
        if (isset($_GET['deleteid'])) {
          $deleteid = $_GET['deleteid'];
          $query = "DELETE FROM divisions WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          //header("Location:masterTrainerView.php?status=deleted&mstatus=mt");
        }

        // number of shcools in division
        function numberOfSchools($division_name) {
          $query = "SELECT * FROM schools WHERE division_name='$division_name'";
          $result = mysql_query($query) or die("<h1>Cant get schools</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }

        // search the attnt table
        if (isset($_POST['search_table'])) {
          $attnt_school_name = $_POST['attnt_school_name'];
          $attnt_district_name = $_POST['attnt_district_name'];
          $attnt_division_name = $_POST['attnt_division_name'];
          $training_venue = $_POST['training_venue'];
          $number_received_alb = $_POST['number_received_alb'];
          $number_received_pzq = $_POST['number_received_pzq'];
          $searchQuery = "SELECT * FROM attnt_bysch WHERE attnt_school_name LIKE '%$attnt_school_name%'
              AND attnt_district_name LIKE '%$attnt_district_name%'
              AND attnt_division_name LIKE '%$attnt_division_name%' 
              AND training_venue LIKE '%$training_venue%' 
              AND number_received_alb LIKE '%$number_received_alb%'
              AND number_received_pzq LIKE '%$number_received_pzq%'
              ORDER BY attnt_school_name,attnt_district_name,attnt_division_name ASC   LIMIT 50 ";
          $result_set = mysql_query($searchQuery);
        } else {
          // if nthing is searched display everything
          $result_set = mysql_query("SELECT * FROM attnt_bysch LIMIT 50");
        }
        ?>
        <!--<h1><u>Attnt List</u></h1>-->
        <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <img src="../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 10px; visibility: visible"/>
          <a class="btn-custom-small" href="PHPExcel/AdminData/divisions.php?searchQuery=<?php echo $searchQuery; ?>">Export to Excel</a>
          
        </form>
        <br/>
        <div style=" margin-right: 20px">
          <form method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="border: 1px solid #B4B5B0;">
                 
                  <th align="center" width="10%">
                    <select name="attnt_district_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($attnt_district_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT DISTINCT(attnt_district_name) FROM attnt_bysch ORDER BY attnt_district_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['attnt_district_name']; ?>"<?php
                        if ($attnt_district_name == $rows['attnt_district_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['attnt_district_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="10%">
                    <select name="attnt_division_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($attnt_division_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT DISTINCT(attnt_division_name) FROM attnt_bysch WHERE attnt_district_name LIKE '%$attnt_district_name%' ORDER BY attnt_division_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['attnt_division_name']; ?>"<?php
                        if ($attnt_division_name == $rows['attnt_division_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['attnt_division_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="10%">
                    <select name="training_venue"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($training_venue == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT distinct(training_venue) FROM attnt_bysch WHERE attnt_district_name LIKE '%$attnt_division_name%' AND attnt_division_name LIKE '%$attnt_district_name%' ORDER BY training_venue ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['training_venue']; ?>"<?php
                        if ($training_venue == $rows['training_venue']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['training_venue']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                   <th align="center" width="10%">
                    <select name="attnt_school_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($attnt_school_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT distinct(attnt_school_name) FROM attnt_bysch WHERE attnt_district_name LIKE '%$attnt_division_name%' AND attnt_division_name LIKE '%$attnt_district_name%' AND training_venue LIKE '%$training_venue%' ORDER BY attnt_school_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['attnt_school_name']; ?>"<?php
                        if ($attnt_school_name == $rows['attnt_school_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['attnt_school_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="10%"><input type="text" style="width: 98%" name="division_id"  value="<?php echo $division_id ?>"/></th>
                  <th align="center" width="7%"><input type="text" style="width: 98%" name=""  value="" readonly/></th>
                  <th align="center" width="10%" colspan="3"><input type="submit" class='btn-filter' id="btnSearchSubmit" style="width: 98%" value="Search" name="search_table"  /></th>
                </tr>
                <tr style="border: 1px solid #B4B5B0;">
                  
                  <th align="Left" width="15%">District</th>
                  <th align="Left" width="15%">Division</th>
                  <th align="Left" width="15%">Training Venue</th>
                  <th align="Left" width="15%">School</th>
                  <th align="Left" width="10%">Alb</th>
                  <th align="Left" width="10%">PZQ</th>

                  <th align="center" width="4%">View</th>
                  <th align="center" width="4%">Edit</th>
                  <th align="center" width="4%">Del</th>
                </tr>
              </thead>
            </table>
          </form>
        </div>

        <div style="width:100%; height:450px; overflow-x: visible; overflow-y: scroll; ">
          <table width="100%" border="0" frame="box" align="center" cellspacing="1" cellpadding="0" class="table-hover">
            <tbody>

              <?php
              while ($row = mysql_fetch_array($result_set)) {
                // $id = $row['id'];
                // $county = $row['county'];
                // $district_name = $row['district_name'];
                // $division_name = $row['division_name'];
                // $division_id = $row['division_id'];
                // $wave = $row['wave'];
                
                $attnt_district_name = $row['attnt_district_name'];
                $attnt_division_name = $row['attnt_division_name'];
                $training_venue = $row['training_venue'];
                $attnt_school_name = $row['attnt_school_name'];
                $number_received_alb = $row['number_received_alb'];
                $number_received_pzq = $row['number_received_pzq'];
                ?>
                <tr style="border-bottom: 1px solid #B4B5B0;">

                  <!-- <td align="left" width="15%"> <?php echo $county; ?>  </td>
                  <td align="left" width="15%"> <?php echo $district_name; ?> </td>
                  <td align="left" width="15%"> <?php echo $division_name; ?> </td>
                  <td align="left" width="15%"> <?php echo $division_id; ?> </td>
                  <td align="left" width="10%"> <?php echo numberOfSchools($division_name); ?>  </td> -->

                  
                  <td align="left" width="15%"><?php echo $attnt_district_name ?></td>
                  <td align="left" width="15%"><?php echo $attnt_division_name ?></td>
                  <td align="left" width="15%"><?php echo $training_venue ?></td>
                  <td align="left" width="15%"><?php echo $attnt_school_name ?></td>
                  <td align="left" width="15%"><?php echo $number_received_alb ?></td>
                  <td align="left" width="15%"><?php echo $number_received_pzq ?></td>


                  <!--view button-->
                  <form method="POST" action="#viewDivision">
                 <!--    <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                    <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                    <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                    <input type="hidden" name="division_id" value="<?php echo $division_id; ?>"/>
                    <input type="hidden" name="wave" value="<?php echo $wave; ?>"/> -->
                    
                    <input type="hidden" name="attnt_district_name" value="<?php echo $attnt_district_name; ?>"/>
                    <input type="hidden" name="attnt_division_name" value="<?php echo $attnt_division_name; ?>"/>
                    <input type="hidden" name="training_venue" value="<?php echo $training_venue; ?>"/>
                    <input type="hidden" name="attnt_school_name" value="<?php echo $attnt_school_name; ?>"/>
                    <input type="hidden" name="number_received_alb" value="<?php echo $number_received_alb; ?>"/>
                    <input type="hidden" name="number_received_pzq" value="<?php echo $number_received_pzq; ?>"/>

                    <td align="center" width="4%"><input type="submit" name="viewDetails" value="" style="background: url(../images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    <!--<td align="center" width="4%"><a href="#viewDivision"><img src="../images/icons/view.png" height="20px"></a></td>-->
                  </form>

                  <!--edit button-->
                  <form method="POST" action="#editDivision">
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                    <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                    <input type="hidden" name="division_name" value="<?php echo $division_name; ?>"/>
                    <input type="hidden" name="division_id" value="<?php echo $division_id; ?>"/>
                    <input type="hidden" name="wave" value="<?php echo $wave; ?>"/>
                    <td align="center" width="4%"><input type="submit" name="editDetails" value="" style="background: url(../images/icons/edit2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/></td>
                    <!--<td align="center" width="4%"><a href="schoolsEdit.php?id=<?php echo $data['id']; ?>"><img src="../images/icons/edit.png" height="20px"></a></td>-->
                  </form>

                  <td align="center" width="4%"><a href="javascript:void(0)" onclick='show_confirm(<?php echo $id; ?>)' ><img src="../images/icons/delete.png" height="20px"></a></td>
                </tr>
              </tbody>
            <?php } ?>
          </table>
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