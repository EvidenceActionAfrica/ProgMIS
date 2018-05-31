<?php
require_once ('../includes/auth.php');
require_once ('../../includes/config.php');
require_once ("../../includes/functions.php");
require_once ("../../includes/form_functions.php");

require_once('../../includes/db_functions.php');
$evidenceaction = new EvidenceAction();

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_counties = $row['priv_counties'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script-pablo.php"); ?>

    <style>
      .txtTableForm {
        background-color: #F2F2F2 /*#E7E3E0*/ !important;
        border: none !important;
        margin: 0px !important;
        padding: 0px !important;
        font-size: 12px !important;
        height: 100% !important;
        width: 99% !important;
      }
      .tdCompact{
        margin: 0px !important;
        padding: 0px !important;
      }
      .fc{
        background-color: #fcfcfc !important;
      }
    </style>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("../includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-Reverse.php"); ?>
      </div>

      <div class="contentBody">
        <!--================================================-->

























        <!--================================================-->
        <?php

        // number of divisions in district
        function numberOfDivisions($district_name) {
          $query = "SELECT * FROM divisions WHERE district_name='$district_name'";
          $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }

        // number of schools in district
        function numberOfSchools($district_name) {
          $query = "SELECT * FROM schools WHERE district_name='$district_name'";
          $result = mysql_query($query) or die("<h1>Cant get divisions</h1>" . mysql_error());
          $num = mysql_num_rows($result);
          return $num;
        }

        //Delete
        if (isset($_GET['deleteid'])) {
          $deleteid = $_GET['deleteid'];
          $query = "DELETE FROM districts WHERE id='$deleteid'";
          $result = mysql_query($query) or die("<h1>Could not delete</h1><br/>" . mysql_error());
          //header("Location:masterTrainerView.php?status=deleted&mstatus=mt");
          //log entry
          $staff_id = $_SESSION['staff_id'];
          $staff_email = $_SESSION['staff_email'];
          $staff_name = $_SESSION['staff_name'];
          $action = "Delete \"district\"";
          $description = "Record ID: " . $deleteid . " deleted";
          $arrLogAdminData = array($staff_id, $staff_email, $staff_name, $action, $description);
          funclogAdminData($arrLogAdminData);
        }

        if (isset($_POST['search_table'])) {
          $county = $_POST['county'];
          $district_name = $_POST['district_name'];
          $district_id = $_POST['district_id'];
          $donor = $_POST['donor'];
          $treatment_type = $_POST['treatment_type'];
          $searchQuery = "SELECT * FROM districts WHERE county LIKE '%$county%'
              AND district_name LIKE '%$district_name%'
              AND donor LIKE '%$donor%'
              AND treatment_type LIKE '%$treatment_type%'
              AND district_id LIKE '%$district_id%'  ORDER BY county,district_name ASC";
          $result_set = mysql_query($searchQuery);
        } else if (isset($_POST['advanced_search_table'])) {

          $countyArray = $_POST;

          $countyArray = join("', '", $countyArray);
          $searchQuery = "SELECT * FROM districts WHERE county IN ('$countyArray')";
          $result_set = mysql_query($searchQuery);
        } else {
          $result_set = mysql_query("SELECT * FROM districts ORDER BY county,district_name ASC");
        }
        ?>

        <form action="#">
          <input type="text" name="search" value="" id="id_search" placeholder="Filter records here" autofocus />
          <img src="../../images/loading.gif" id="imgLoading" height="30px" style="position: relative; left: 10px; top: 0px; visibility: visible"/>
          <b style="margin-left:20%;width: 100px; font-size:1.5em;">Districts List</b>
        </form> 
       <br/>
        <div style="margin-right: 20px" id="search_div">
          <form action="districts.php" method="post">
            <table width="100%" border="0" align="center" cellspacing="1" class="table-hover" >
              <thead>
                <tr style="border: 1px solid #B4B5B0;">
                  <th align="center" width="15%">
                    <select name="county"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($county == '') echo 'selected'; ?> >Select County</option>
                      <?php
                      $sql = "SELECT * FROM counties ORDER BY county ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['county']; ?>"<?php
                        if ($county == $rows['county']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['county']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="15%">
                    <select name="district_name"  style="width: 98%;" onchange="submitForm();">
                      <option value=''<?php if ($district_name == '') echo 'selected'; ?> ></option>
                      <?php
                      $sql = "SELECT * FROM districts WHERE county='$county' ORDER BY district_name ASC";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['district_name']; ?>"<?php
                        if ($district_name == $rows['district_name']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['district_name']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="15%"><input type="text" style="width: 98%" name="district_id" value="<?php echo $district_id ?>"placeholder="District ID"/></th>

                  <th align="center" width="15%">
                    <select name="donor"  style="width: 98%;" onchange="submitForm();">
                      <?php
                      $sql = "SELECT DISTINCT donor FROM districts";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['donor']; ?>"<?php
                        if ($donor == $rows['donor']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['donor']; ?></option>
                              <?php } ?>
                    </select>
                  </th>
                  <th align="center" width="15%">
                    <select name="treatment_type"  style="width: 98%;" onchange="submitForm();">
                      <?php
                      $sql = "SELECT DISTINCT treatment_type FROM districts";
                      $result = mysql_query($sql);
                      while ($rows = mysql_fetch_array($result)) { //loop table rows
                        ?>
                        <option value="<?php echo $rows['treatment_type']; ?>"<?php
                        if ($treatment_type == $rows['treatment_type']) {
                          echo 'selected';
                        }
                        ?>><?php echo $rows['treatment_type']; ?></option>
                              <?php } ?>
                    </select>
                  </th>

                  <th align="center" width="7%"><input type="text" style="width: 98%" readonly/></th>
                  <th align="center" width="7%"><input type="text" style="width: 98%" readonly/></th>
                  <th align="center" width="12%" colspan="3" ><input type="submit" class='btn-filter' style="width: 98%" id="btnSearchSubmit"value="Search" name="search_table"  /></th>
                </tr>
              </thead>
            </table>
          </form>
        </div>

        <div style="margin-right: 20px">
          <table>
            <thead>
              <tr style="border: 1px solid #B4B5B0;">
                <th align="Left" width="15%">County</th>
                <th align="Left" width="15%">District</th>
                <th align="Left" width="15%">District ID</th>
                <th align="Left" width="15%">Donor</th>
                <th align="Left" width="15%">T.Type</th>
                <th align="Left" width="7%">Number of Divisions</th>
                <th align="Left" width="7%">Number of Schools</th>
                <td align="center" width="4%">View</td>
              </tr>
            </thead>
          </table>
        </div>

        <div style="width:100%; height:430px; overflow-x: visible; overflow-y: scroll; ">
          <table width="100%" border="0" frame="box" align="center" cellspacing="1" class="table-hover" id="data-table">
            <tbody>
              <?php
              while ($row = mysql_fetch_array($result_set)) {
                $id = $row['id'];
                $county = $row['county'];
                $district_name = $row['district_name'];
                $district_id = $row['district_id'];
                $donor = $row['donor'];
                $treatment_type = $row['treatment_type'];
                ?>
                <tr style="border-bottom: 1px solid #B4B5B0;">

                  <td align="left" width="15%"> <?php echo $county; ?>  </td>
                  <td align="left" width="15%"> <?php echo $district_name; ?> </td>
                  <td align="left" width="15%"> <?php echo $district_id; ?> </td>
                  <td align="left" width="15%"> <?php echo $donor; ?> </td>
                  <td align="left" width="15%"> <?php echo $treatment_type; ?> </td>
                  <td align="left" width="7%"> <?php echo $numberOfDivisions = numberOfDivisions($district_name); ?> </td>
                  <td align="left" width="7%"> <?php echo $numberOfSchools = numberOfSchools($district_name); ?> </td>

                  <!--view button-->
                  <form method="POST" action="#viewDistrict">
                    <input type="hidden" name="county" value="<?php echo $county; ?>"/>
                    <input type="hidden" name="district_name" value="<?php echo $district_name; ?>"/>
                    <input type="hidden" name="district_id" value="<?php echo $district_id; ?>"/>
                    <input type="hidden" name="donor" value="<?php echo $donor; ?>"/>
                    <input type="hidden" name="treatment_type" value="<?php echo $treatment_type; ?>"/>
                    <input type="hidden" name="numberOfDivisions" value="<?php echo $numberOfDivisions; ?>"/>
                    <input type="hidden" name="numberOfSchools" value="<?php echo $numberOfSchools; ?>"/>

                    <td align="center" width="4%">
                      <?php if ($priv_districts >= 1) { ?>
                        <input type="submit" name="viewDetails" value="" style="background: url(../../images/icons/view2.png); background-position: center center; border: none; background-repeat: no-repeat; width: 30px"/>
                      <?php } ?>
                    </td>
                    <!--<td align="center" width="4%"><a href="#viewDistrict"><img src="images/icons/view.png" height="20px"></a></td>-->
                  </form> 

                </tr>
              </tbody>
            <?php } ?>
          </table>
        </div>


        <!--filter includes-->
        <script type="text/javascript" src="../../css/filter-as-you-type/jquery.min.js"></script>
        <script type="text/javascript" src="../../css/filter-as-you-type/jquery.quicksearch.js"></script>
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






























        <?php
        //ajax dropdown selector
        $tablename = 'counties';
        $fields = 'id, county';
        $where = '1=1';
        $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);

        if (isset($_POST['selectDistrictFormD'])) {
          $selectedcounty = $_POST['selectcounty'];
          $selecteddistrict = $_POST['selectdistrict'];

          //get district treatment type
          $resD = mysql_query("SELECT treatment_type FROM districts WHERE district_name='$selecteddistrict' ");
          while ($row = mysql_fetch_array($resD)) {
            $treatment_type = $row["treatment_type"];
          }
        }




        //Submit buttons
        //$cmdAdd = filter_input(INPUT_POST, "addNewForm");
        $cmdDelete = filter_input(INPUT_POST, "DeleteForm");
        $cmdEdit = filter_input(INPUT_POST, "EditForm"); //Update operation
        $cmdSearch = filter_input(INPUT_POST, "searchForm"); //Probably unneeded

        $formD_Id = filter_input(INPUT_POST, "formD_Id"); ///MOST REQUIRED OR MOST CRUD WON'T WORK
        $count = 0; //Have given it the value of 0 in every operation just incase
        $deoName = filter_input(INPUT_POST, "deoName");
        $county = filter_input(INPUT_POST, "county");
        $district = filter_input(INPUT_POST, "district");
        $phoneNumber = filter_input(INPUT_POST, "phoneNumber");


        if ($cmdEdit) {
          //This will use the same Logic as Add only the queries will be updates where AND id &'formid' instead of insert.
          //Extracting the id will be tricky.i will query for a list of the ids and place them in an array that
          //can be used for reference during the update operation
          //Possible downfall: the data will replace the wrong records
          //Possible upside:despite the possibility of incorrect records being updated,the data will still be correct since the
          //size of the array will be equivalent to the no.of records in the db.
          $count = 0;

          //Extracting Form D array

          $sql = "SELECT id from form_d_data where form_d_id='$formD_Id' AND type='D'";
          $formD_Array = array();
          $resultI = mysql_query($sql);
          $itemCount = 0;
          while ($row = mysql_fetch_array($resultI)) {
            $formD_Array[$itemCount] = $row["id"];
            ++$itemCount;
          }

          //Extracting Form DP Array


          $sql = "SELECT id from form_d_data where form_d_id='$formD_Id' AND type='DP'";
          $formDP_Array = array();
          $resultI = mysql_query($sql);
          $itemCount = 0;
          while ($row = mysql_fetch_array($resultI)) {
            $formDP_Array[$itemCount] = $row["id"];
            ++$itemCount;
          }

          $sql = "UPDATE `form_d` SET `deo_name`='$deoName',`county`='$county',`district`='$district',";
          $sql.="`phone_number`='$phoneNumber' WHERE id='$formId'";

          $resultA = mysql_query($sql) or die(mysql_error());

          //Code for getting the last entry in formd's Id to use as a reference in form_d_data

          $sql = "select id from form_d ORDER by id DESC LIMIT 1";
          $resultB = mysql_query($sql);

          while ($row = mysql_fetch_array($resultB)) {
            $formD_Id = $row["id"];
          }

          //Form D Data for Form D itself.It Will require a while Loop for the table
          //The Table Should loop such that the fields go like
          //divion1,division2,division3---NAME of the fieldsshould go like this.
          //If it does this insert willl work
          $count = 0;
          while (isset($_POST["division" . $count]) != NULL) {
            //This are for form D. Form Dp has the same only all var end with Capital DP then count
            $division = isset($_POST["division" . $count]) ? mysql_real_escape_string($_POST["division" . $count]) : 0;
            $formA = isset($_POST["formA" . $count]) ? mysql_real_escape_string($_POST["formA" . $count]) : 0;
            $ecdMaleTotal = isset($_POST["ecdMaleTotal" . $count]) ? mysql_real_escape_string($_POST["ecdMaleTotal" . $count]) : 0;
            $ecdFemaleTotal = isset($_POST["ecdFemaleTotal" . $count]) ? mysql_real_escape_string($_POST["ecdFemaleTotal" . $count]) : 0;

            $ecdTotal = isset($_POST["ecdTotal" . $count]) ? mysql_real_escape_string($_POST["ecdTotal" . $count]) : 0;
            $esctRegistered = isset($_POST["esctRegistered" . $count]) ? mysql_real_escape_string($_POST["esctRegistered" . $count]) : 0;
            $esctTreatedMale = isset($_POST["esctTreatedMale" . $count]) ? mysql_real_escape_string($_POST["esctTreatedMale" . $count]) : 0;
            $esctTreatedFemale = isset($_POST["esctTreatedFemale" . $count]) ? mysql_real_escape_string($_POST["esctTreatedFemale" . $count]) : 0;
            $esctTreatedTotal = isset($_POST["esctTreatedTotal" . $count]) ? mysql_real_escape_string($_POST["esctTreatedTotal" . $count]) : 0;

            $years_2_5_Male = isset($_POST["years_2_5_Male" . $count]) ? mysql_real_escape_string($_POST["years_2_5_Male" . $count]) : 0;
            $years_2_5_Female = isset($_POST["years_2_5_Female" . $count]) ? mysql_real_escape_string($_POST["years_2_5_Female" . $count]) : 0;
            $years_6_10_Male = isset($_POST["years_6_10_Male" . $count]) ? mysql_real_escape_string($_POST["years_6_10_Male" . $count]) : 0;
            $years_6_10_Female = isset($_POST["years_6_10_Female" . $count]) ? mysql_real_escape_string($_POST["years_6_10_Female" . $count]) : 0;
            $years_11_14_Male = isset($_POST["years_11_14_Male" . $count]) ? mysql_real_escape_string($_POST["years_11_14_Male" . $count]) : 0;
            $years_11_14_Female = isset($_POST["years_11_14_Female" . $count]) ? mysql_real_escape_string($_POST["years_11_14_Female" . $count]) : 0;
            $years_15_18_Male = isset($_POST["years_15_18_Male" . $count]) ? mysql_real_escape_string($_POST["years_15_18_Male" . $count]) : 0;
            $years_15_18_Female = isset($_POST["years_15_18_Female" . $count]) ? mysql_real_escape_string($_POST["years_15_18_Female" . $count]) : 0;
            $yearsTotal = isset($_POST["yearsTotal" . $count]) ? mysql_real_escape_string($_POST["yearsTotal" . $count]) : 0;
            $form_id = $formD_Array[$count];

            //Will use the count to loop through the record ids of the form_d


            $sql = "UPDATE `form_d_data` SET `form_d_id`='$formD_Id',`division_name`='$division',";
            $sql.= "`form_a_date`='$formA',`ecd_male_total`='$ecdMaleTotal',`ecd_female_total`='$ecdFemaleTotal',`esct_registered`='$esctRegistered',";
            $sql.="`esct_treated_male`='$esctTreatedMale',`esct_treated_female`='$esctTreatedFemale',`years_2_5_male`='$years_2_5_Male',";
            $sql.="`years_2_5_female`='$years_2_5_Female',`years_6_10_male`='$years_6_10_Male',`years_6_10_female`='$years_6_10_Female',";
            $sql.="`years_11_14_male`='$years_11_14_Male',`years_11_14_female`='$years_11_14_Female',`years_15_18_male`='$years_15_18_Male',";
            $sql.="`years_15_18_female`='$years_15_18_Female' `ecd_total`='$ecdTotal',`esct_treated_total`='$esctTreatedTotal',`years_total`='$yearsTotal' WHERE `id`='$form_id' AND `type`='D'";

            $resultC = mysql_query($sql) or die(mysql_error());
            ++$count;
          }
          $count = 0;
          while (isset($_POST["dp_division" . $count]) != NULL) {
            //This are for form D. Form Dp has the same only all var end with Capital DP then count
            $dp_division = isset($_POST["dp_division" . $count]) ? mysql_real_escape_string($_POST["dp_division" . $count]) : 0;
            $dp_formA = isset($_POST["dp_formA" . $count]) ? mysql_real_escape_string($_POST["dp_formA" . $count]) : 0;
            $dp_ecdMaleTotal = isset($_POST["dp_ecdMaleTotal" . $count]) ? mysql_real_escape_string($_POST["dp_ecdMaleTotal" . $count]) : 0;
            $dp_ecdFemaleTotal = isset($_POST["dp_ecdFemaleTotal" . $count]) ? mysql_real_escape_string($_POST["dp_ecdFemaleTotal" . $count]) : 0;
            $dp_esctRegistered = isset($_POST["dp_esctRegistered" . $count]) ? mysql_real_escape_string($_POST["dp_esctRegistered" . $count]) : 0;
            $dp_esctTreatedMale = isset($_POST["dp_esctTreatedMale" . $count]) ? mysql_real_escape_string($_POST["dp_esctTreatedMale" . $count]) : 0;
            $dp_esctTreatedFemale = isset($_POST["dp_esctTreatedFemale" . $count]) ? mysql_real_escape_string($_POST["dp_esctTreatedFemale" . $count]) : 0;
            $dp_years_2_5_Male = isset($_POST["dp_years_2_5_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_2_5_Male" . $count]) : 0;
            $dp_years_2_5_Female = isset($_POST["dp_years_2_5_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_2_5_Female" . $count]) : 0;
            $dp_years_6_10_Male = isset($_POST["dp_years_6_10_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_6_10_Male" . $count]) : 0;
            $dp_years_6_10_Female = isset($_POST["dp_years_6_10_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_6_10_Female" . $count]) : 0;
            $dp_years_11_14_Male = isset($_POST["dp_years_11_14_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_11_14_Male" . $count]) : 0;
            $dp_years_11_14_Female = isset($_POST["dp_years_11_14_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_11_14_Female" . $count]) : 0;
            $dp_years_15_18_Male = isset($_POST["dp_years_15_18_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_15_18_Male" . $count]) : 0;
            $dp_years_15_18_Female = isset($_POST["dp_years_15_18_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_15_18_Female" . $count]) : 0;
            $form_id = $formDP_Array[$count];


            $sql = "UPDATE `form_d_data` SET `form_d_id`='$formD_IdDP',`division_name`='$divisionDP',";
            $sql.= "`form_a_date`='$formADP',`ecd_male_total`='$ecdMaleTotalDP',`ecd_female_total`='$ecdFemaleTotalDP',`esct_registered`='$esctRegisteredDP',";
            $sql.="`esct_treated_male`='$esctTreatedMaleDP',`esct_treated_female`='$esctTreatedFemaleDP',`years_2_5_male`='$years_2_5_MaleDP',";
            $sql.="`years_2_5_female`='$years_2_5_FemaleDP',`years_6_10_male`='$years_6_10_MaleDP',`years_6_10_female`='$years_6_10_FemaleDP',";
            $sql.="`years_11_14_male`='$years_11_14_MaleDP',`years_11_14_female`='$years_11_14_FemaleDP',`years_15_18_male`='$years_15_18_MaleDP',";
            $sql.="years_15_18_female`='$years_15_18_FemaleDP' WHERE `id`='$form_idDP' AND `type`='DP'";

            $resultC = mysql_query($sql) or die(mysql_error());
            ++$count;
          }
        }
        //Will Require the form_id to be passed to work
        if ($cmdDelete) {
          $sql = "DELETE from form_d where form_d_id='$formId'";
          mysql_query($sql);

          //Using the same formId as a reference to delete the data in the 2nd table (BOTH D & DP will be AFFECTED)
          $sql = "DELETE from form_d where form_d_id='$formId'";
          mysql_query($sql);
        }

        //NB: If you find an error in Add or Edit you probably have to adjust something in the other operation
        //I.e if you change something in add do th same in edit and viceversa
        //Also the tables should have textfields following that sequence we agreed on
        //Goodluck.
        ?>

        <form method="post" action="form_d.php#selectDistrictFormD">
          <div id="divData" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
            <!--header-->
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
          <!--         <td width="70px">
                   <div style="border: 1px solid black; padding: 10px">
                      Survey_ID <br/>  <input type="text" size="9" name="survey_id" value="000174"/><br/>
                    </div>
                  </td>-->
                  <td><img src="../../images/pill.png" height="50px"/></td>
                  <td align="center">
                    <b style="font-size: 19px; ">FORM D : DISTRICT REPORT ALBENDAZOLE  </b> <br/>
                    <?php
                    if ($treatment_type == 'STH/Schisto') {
                      ?>
                      <b style="font-size: 17px; ">(COMPLETE BOTH SIDES OF THIS FORM)  </b><br/> 
                    <?php } ?> 
                  </td>
                  <td align="right"><b style="font-size: 60px">D</b></td>
                </tr>
              </table>
            </div>
            <!--top part - text-->
            <div style="width: 100%; padding-left: 3%; font-size: 11px; ">
              <?php
              if ($treatment_type == 'STH/Schisto') {
                ?>
                • For completion in full by the District Education Officer.<br/>
                • This is to record treatment with Albendazole recorded on Form A. Please complete sections 3-4 on the other side<br/>
                • This side is for Albendazole<br/>
                • Please return to the national office with all Forms S/SP and A/AP for your district. Forms S/SP, A/AP and D/DP are due to the National team within 1 month of deworming day. Please send to:<br/>
              <?php } else { ?>
                • For completion in full by the District Education Officer.<br/>
                • Please return to the national office with all Forms S and A for your district. Forms S, A and D are due to the National team within 1 month of deworming day. Please send to:<br/>
              <?php } ?>
              <br/>
              <center  style="font-weight: bold">
                Innovations for Poverty Action<br/>
                Jonathan Court, Ngong Road, Next to Coptic Hospital<br/>
                P.O.Box 72427 - 00200 Nairobi<br/>
              </center>
            </div>
            <br/><br/>

            <!--top part - fields -->
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
                  <td>
                    <b>Name of DEO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b> <input type="text" size="9" name="deoName"  style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 250px" required/><br/>
                  </td>
                  <td>
                    <b>District Name : </b>  <input type="text" size="9" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; width: 250px; background: #fcfcfc" readonly/><br/>
                  </td>
                </tr>
                <tr>
                  <td >
                    <b>Phone Num. DEO : </b> <input class="num-only" type="text" size="9" name="phoneNumber" style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 250px; " required/><br/>
                  </td>
                  <td>
                    <b>County Name : </b>  <input type="text" size="9" name="county" size="500" value="<?php echo $selectedcounty; ?>" style="border: none; border-bottom: 2px dotted #000;width: 250px; background: #fcfcfc" readonly/><br/>
                  </td>
                </tr>
              </table>
            </div><br/>
            <!-- Section 1 =============-->
            <table border="2" align="center" cellpadding="5" style="width: 100%; border: 3px solid black; font-size: 11px">
              <tr style="">
                <td colspan="18" style="padding: 5px;"><b>1. Complete for each division using section 5 (Division Total) on Form A to fill the information.</b></td>
              </tr>
              <tr>
                <td rowspan="3" align="center">
                  <b>Division Name</b> <br/><br/> (Please include all divisions in your district)
                </td>
                <td rowspan="3" align="center">
                  <b>Date <br/><br/> Form A <br/><br/> Received <br/>by DEO</b>
                </td>
                <td colspan="3" align="center">
                  <b>Enrolled ECD Children</b>
                </td>
                <td colspan="4" align="center">
                  <b>Enrolled School Age Children</b>
                </td>
                <td colspan="9" align="center">
                  <b>Non Enrolled Children </b>
                </td>
              </tr>
              <tr>
                <td colspan="3" align="center">
                  Total number of children treated
                </td>
                <td  align="center" style="background-color: #C3CACC">
                  Children <br/>in register <br/> book
                </td>
                <td colspan="3" align="center">
                  Total Number of <br/>children treated
                </td>
                <td colspan="2" align="center">2-5 yrs</td>
                <td colspan="2" align="center">6-10 yrs</td>
                <td colspan="2" align="center">11-14yrs</td>
                <td colspan="2" align="center">15-18yrs</td>
                <td rowspan="2" align="center"><b>TOTAL</b></td>
              </tr>
              <tr>
                <td align="center">M</td>
                <td align="center">F</td>
                <td align="center">TOTAL</td>
                <td align="center" style="background-color: #C3CACC">TOTAL</td>
                <td align="center">M</td>
                <td align="center">F</td>
                <td align="center">TOTAL</td>
                <td align="center">M</td>
                <td align="center">F</td>
                <td align="center">M</td>
                <td align="center">F</td>
                <td align="center">M</td>
                <td align="center">F</td>
                <td align="center">M</td>
                <td align="center">F</td>
              </tr>
              <?php
              $count = 1;
              $result_st = mysql_query("SELECT * FROM divisions WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' ");
              while ($row = mysql_fetch_array($result_st)) {
                ?>
                <tr style="padding: 0px; margin: 0px">
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only"  type="text" name="division<?php echo $count; ?>" value="<?php echo $row['division_name'] ?>" readonly />
                  </td>
                  <td class="tdCompact"> <!-- date -->
                    <input class="txtTableForm myDatePicker" type="text" name="formA<?php echo $count; ?>" required/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="ecdMaleTotal<?php echo $count; ?>" id="ecdMaleTotal<?php echo $count; ?>" onkeyup="sum_ecd();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="ecdFemaleTotal<?php echo $count; ?>" id="ecdFemaleTotal<?php echo $count; ?>" onkeyup="sum_ecd();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text"name="ecdTotal<?php echo $count; ?>" id="ecdTotal<?php echo $count; ?>" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text"name="esctRegistered<?php echo $count; ?>" id="esctRegistered<?php echo $count; ?>" onkeyup="sum_all();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="esctTreatedMale<?php echo $count; ?>" id="esctTreatedMale<?php echo $count; ?>" onkeyup="sum_esct();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="esctTreatedFemale<?php echo $count; ?>" id="esctTreatedFemale<?php echo $count; ?>" onkeyup="sum_esct();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text"name="esctTreatedTotal<?php echo $count; ?>" id="esctTreatedTotal<?php echo $count; ?>" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_2_5_Male<?php echo $count; ?>" id="years_2_5_Male<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_2_5_Female<?php echo $count; ?>" id="years_2_5_Female<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_6_10_Male<?php echo $count; ?>" id="years_6_10_Male<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_6_10_Female<?php echo $count; ?>" id="years_6_10_Female<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_11_14_Male<?php echo $count; ?>" id="years_11_14_Male<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_11_14_Female<?php echo $count; ?>" id="years_11_14_Female<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_15_18_Male<?php echo $count; ?>" id="years_15_18_Male<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_15_18_Female<?php echo $count; ?>" id="years_15_18_Female<?php echo $count; ?>" onkeyup="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text"name="yearsTotal<?php echo $count; ?>" id="yearsTotal<?php echo $count; ?>" readonly/>
                  </td>
                </tr>
                <?php
                $count++;
              }
              ?>
              <input type="hidden" id="numberOfDivisions" value="<?php echo $count - 1; ?>" />

              <tr style="border: 2px solid black; padding: 0px; margin: 0px">
                <td colspan="2"><b>2. DISTRICT TOTAL </b></td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="ecd_treated_male_total" id="ecd_treated_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="ecd_treated_female_total" id="ecd_treated_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="ecd_treated_children_total_total" id="ecd_treated_children_total_total" readonly/>
                </td>
                <td class="tdCompact"  style="background-color: #C3CACC !important;" >
                  <input class="txtTableForm num-only" style="background-color: #C3CACC !important;" type="text" name="total_enrolled_in_register_total" id="total_enrolled_in_register_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="enrolled_male_total"  id="enrolled_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="enrolled_female_total" id="enrolled_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="enrolled_treated_total_total" id="enrolled_treated_total_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_2_5_male_total"id="years_2_5_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_2_5_female_total"id="years_2_5_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_6_10_male_total" id="years_6_10_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_6_10_female_total"id="years_6_10_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_11_14_male_total" id="years_11_14_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_11_14_female_total" id="years_11_14_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_15_18_male_total"  id="years_15_18_male_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="years_15_18_female_total" id="years_15_18_female_total" readonly/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm fc num-only" type="text" name="non_enrolled_total_total" id="non_enrolled_total_total" readonly />
                </td>
              </tr>
            </table>
            <br/>
            <br/>


            <!--== Form DP  =================================================================================================================================-->
            <?php
            if ($treatment_type == 'STH/Schisto') {
              ?>

              <!--header-->
              <div style="width: 100%;">
                <table style="width: 100%">
                  <tr>
                 <!--    <td width="70px">
                    <div style="border: 1px solid black; padding: 10px">
                        Survey_ID <br/>  <input type="text" size="9" name="survey_id" value="000174"/><br/>
                      </div>
                    </td>-->
                    <td><img src="../../images/pill.png" height="50px"/></td>
                    <td align="center">
                      <b style="font-size: 17px; ">FORM D : DISTRICT REPORT ALBENDAZOLE<br/></b>
                    </td>
                    <td align="right"><b style="font-size: 60px">DP</b></td>
                  </tr>
                </table>
              </div>

              <!-- Section 1 =============-->
              <table border="2" align="center" cellpadding="5" style="width: 100%; border: 3px solid black; font-size: 11px">
                <tr style="">
                  <td colspan="16" style="padding: 5px;"><b>3. Complete for each division using section 10 (Division Total) on Form AP to fill the information.</b></td>
                </tr>
                <tr>
                  <td rowspan="3" align="center">
                    <b>Division Name</b> <br/><br/> (Please include all divisions in your district)
                  </td>
                  <td rowspan="3" align="center">
                    <b>Date <br/><br/> Form A <br/><br/> Received <br/>by DEO</b>
                  </td>
                  <td colspan="3" align="center">
                    <b>Enrolled ECD Children</b>
                  </td>
                  <td colspan="4" align="center">
                    <b>Enrolled School Age Children</b>
                  </td>
                  <td colspan="7" align="center">
                    <b>Non Enrolled Children </b>
                  </td>
                </tr>
                <tr>
                  <td colspan="3" align="center">
                    Total number of children treated
                  </td>
                  <td  align="center" style="background-color: #C3CACC">
                    Children <br/>in register <br/> book
                  </td>
                  <td colspan="3" align="center">
                    Total Number of <br/>children treated
                  </td>
                  <!--<td colspan="2" align="center">2-5 yrs</td>-->
                  <td colspan="2" align="center">6-10 yrs</td>
                  <td colspan="2" align="center">11-14yrs</td>
                  <td colspan="2" align="center">15-18yrs</td>
                  <td rowspan="2" align="center"><b>TOTAL</b></td>
                </tr>
                <tr>
                  <td align="center">M</td>
                  <td align="center">F</td>
                  <td align="center">TOTAL</td>
                  <td align="center" style="background-color: #C3CACC">TOTAL</td>
                  <td align="center">M</td>
                  <td align="center">F</td>
                  <td align="center">TOTAL</td>
               <!--   <td align="center">M</td>
                  <td align="center">F</td>-->
                  <td align="center">M</td>
                  <td align="center">F</td>
                  <td align="center">M</td>
                  <td align="center">F</td>
                  <td align="center">M</td>
                  <td align="center">F</td>
                </tr>
                <?php
                $count_dp = 1;
                $result_st = mysql_query("SELECT * FROM divisions WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' ");
                while ($row = mysql_fetch_array($result_st)) {
                  ?>
                  <tr style="padding: 0px; margin: 0px">
                    <td class="tdCompact"><!-- division -->
                      <input class="txtTableForm fc num-only"  type="text" name="dp_division<?php echo $count_dp; ?>" value="<?php echo $row['division_name'] ?>" readonly/>
                    </td>
                    <td class="tdCompact"> <!-- date -->
                      <input class="txtTableForm myDatePicker" type="text" name="dp_formA<?php echo $count_dp; ?>" required/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_ecdMaleTotal<?php echo $count_dp; ?>" id="dp_ecdMaleTotal<?php echo $count_dp; ?>" onkeyup="sum_ecd_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_ecdFemaleTotal<?php echo $count_dp; ?>" id="dp_ecdFemaleTotal<?php echo $count_dp; ?>"onkeyup="sum_ecd_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm fc num-only" type="text"name="dp_ecdTotal<?php echo $count_dp; ?>" id="dp_ecdTotal<?php echo $count_dp; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text"name="dp_esctRegistered<?php echo $count_dp; ?>" id="dp_esctRegistered<?php echo $count_dp; ?>"onkeyup="sum_all_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text" name="dp_esctTreatedMale<?php echo $count_dp; ?>" id="dp_esctTreatedMale<?php echo $count_dp; ?>" onkeyup="sum_esct_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_esctTreatedFemale<?php echo $count_dp; ?>" id="dp_esctTreatedFemale<?php echo $count_dp; ?>" onkeyup="sum_esct_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm fc num-only" type="text" name="dp_esctTreatedTotal<?php echo $count_dp; ?>" id="dp_esctTreatedTotal<?php echo $count_dp; ?>"/>
                    </td>
                   <!-- <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_2_5_Male<?php echo $count_dp; ?>" id="dp_years_2_5_Male<?php echo $count_dp; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_2_5_Female<?php echo $count_dp; ?>" id="dp_years_2_5_Female<?php echo $count_dp; ?>"/>
                    </td>-->
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_6_10_Male<?php echo $count_dp; ?>" id="dp_years_6_10_Male<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_6_10_Female<?php echo $count_dp; ?>" id="dp_years_6_10_Female<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_11_14_Male<?php echo $count_dp; ?>" id="dp_years_11_14_Male<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_11_14_Female<?php echo $count_dp; ?>" id="dp_years_11_14_Female<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_15_18_Male<?php echo $count_dp; ?>" id="dp_years_15_18_Male<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_15_18_Female<?php echo $count_dp; ?>" id="dp_years_15_18_Female<?php echo $count_dp; ?>" onkeyup="sum_years_dp();"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm fc num-only" type="text" name="dp_yearsTotal<?php echo $count_dp; ?>" id="dp_yearsTotal<?php echo $count_dp; ?>" readonly/>
                    </td>
                  </tr>
                  <?php
                  $count_dp++;
                }
                ?>
                <input type="hidden" id="numberOfDivisions_dp" value="<?php echo $count_dp - 1; ?>" />

                <tr style="border: 2px solid black; padding: 0px; margin: 0px">
                  <td colspan="2"><b>4. DISTRICT TOTAL </b></td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_ecd_treated_male_total" id="dp_ecd_treated_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_ecd_treated_female_total"id="dp_ecd_treated_female_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_ecd_treated_children_total_total" id="dp_ecd_treated_children_total_total" readonly/>
                  </td>
                  <td class="tdCompact"  style="background-color: #C3CACC !important;" >
                    <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text" name="dp_total_enrolled_in_register_total" id="dp_total_enrolled_in_register_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_enrolled_male_total" id="dp_enrolled_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_enrolled_female_total"id="dp_enrolled_female_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_enrolled_treated_total_total" id="dp_enrolled_treated_total_total" readonly/>
                  </td>
  <!--                <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="years_2_5_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="years_2_5_female_total" readonly/>
                  </td>-->
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_6_10_male_total" id="dp_years_6_10_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_6_10_female_total"id="dp_years_6_10_female_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_11_14_male_total"  id="dp_years_11_14_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_11_14_female_total" id="dp_years_11_14_female_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_15_18_male_total"id="dp_years_15_18_male_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_years_15_18_female_total" id="dp_years_15_18_female_total" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm fc num-only" type="text" name="dp_non_enrolled_total_total" id="dp_non_enrolled_total_total" readonly/>
                  </td>
                </tr>
              </table>
            <?php } //end if STH/Schisto District ?>
            <br/>
          </div>
          <br/>
          <input type="submit" name="addNewForm" value="Save & Submit" class="btn-custom"/>
        </form>
        <br/>
        <br/>
        <br/>


        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->


    <!--keydown event-->
    <script type="text/javascript" src="../../js/keydown_events.js"></script>
    <script type="text/javascript" src="../../js/block-return-key.js"></script>

    <!--Delete dialog-->
    <script>
                      function show_confirm(deleteid) {
                        if (confirm("Are you sure you want to delete?")) {
                          location.replace('?deleteid=' + deleteid);
                        } else {
                          return false;
                        }
                      }
    </script>

    <script type="text/javascript">
      //myDatePicker javascript
      $(document).ready(function() {
        $(".myDatePicker").datepicker({
          dateFormat: 'dd-mm-yy',
          showOn: 'focus',
          buttonImageOnly: true,
          buttonImage: 'calendar/cal.gif',
          buttonText: 'Pick a date',
          onClose: function(dateText, inst) {
            //$("#EndDate").val($("#proposedmovedate").val());
          }
        });
      });
    </script>

  </body>
</html>









<!--===== Modal Select District ===========================-->
<div id="selectDistrictFormD" class="modalDialog">
  <div style="width: 500px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Select District </h1><br/>
    </div>
    <?php
    $cmdAdd = filter_input(INPUT_POST, "addNewForm");
    if ($cmdAdd) {
      $count = 1;
      $sql = "INSERT INTO `form_d`(`deo_name`, `county`, `district`, `phone_number`)";
      $sql.=" VALUES ('$deoName','$county','$district','$phoneNumber')";

      $resultA = mysql_query($sql) or die(mysql_error());

      //Code for getting the last entry in formd's Id to use as a reference in form_d_data

      $sql = "select id from form_d ORDER by id DESC LIMIT 1";
      $resultB = mysql_query($sql);

      while ($row = mysql_fetch_array($resultB)) {
        $formD_Id = $row["id"];
      }

      //Form D Data for Form D itself.It Will require a while Loop for the table
      //The Table Should loop such that the fields go like
      //divion1,division2,division3---NAME of the fieldsshould go like this.
      //If it does this insert willl work
      while (isset($_POST["division" . $count]) != NULL) {
        //This are for form D. Form Dp has the same only all var end with Capital DP then count
        $division = isset($_POST["division" . $count]) ? mysql_real_escape_string($_POST["division" . $count]) : 0;
        $dateSelected = isset($_POST["formA" . $count]) ? mysql_real_escape_string($_POST["formA" . $count]) : 0;
        $formA = date("Y-m-d", strtotime($dateSelected));

        $ecdMaleTotal = isset($_POST["ecdMaleTotal" . $count]) ? mysql_real_escape_string($_POST["ecdMaleTotal" . $count]) : 0;
        $ecdFemaleTotal = isset($_POST["ecdFemaleTotal" . $count]) ? mysql_real_escape_string($_POST["ecdFemaleTotal" . $count]) : 0;
        $ecdTotal = isset($_POST["ecdTotal" . $count]) ? mysql_real_escape_string($_POST["ecdTotal" . $count]) : 0;

        $esctRegistered = isset($_POST["esctRegistered" . $count]) ? mysql_real_escape_string($_POST["esctRegistered" . $count]) : 0;
        $esctTreatedMale = isset($_POST["esctTreatedMale" . $count]) ? mysql_real_escape_string($_POST["esctTreatedMale" . $count]) : 0;
        $esctTreatedFemale = isset($_POST["esctTreatedFemale" . $count]) ? mysql_real_escape_string($_POST["esctTreatedFemale" . $count]) : 0;
        $esctTreatedTotal = isset($_POST["esctTreatedTotal" . $count]) ? mysql_real_escape_string($_POST["esctTreatedTotal" . $count]) : 0;

        $years_2_5_Male = isset($_POST["years_2_5_Male" . $count]) ? mysql_real_escape_string($_POST["years_2_5_Male" . $count]) : 0;
        $years_2_5_Female = isset($_POST["years_2_5_Female" . $count]) ? mysql_real_escape_string($_POST["years_2_5_Female" . $count]) : 0;
        $years_6_10_Male = isset($_POST["years_6_10_Male" . $count]) ? mysql_real_escape_string($_POST["years_6_10_Male" . $count]) : 0;
        $years_6_10_Female = isset($_POST["years_6_10_Female" . $count]) ? mysql_real_escape_string($_POST["years_6_10_Female" . $count]) : 0;
        $years_11_14_Male = isset($_POST["years_11_14_Male" . $count]) ? mysql_real_escape_string($_POST["years_11_14_Male" . $count]) : 0;
        $years_11_14_Female = isset($_POST["years_11_14_Female" . $count]) ? mysql_real_escape_string($_POST["years_11_14_Female" . $count]) : 0;
        $years_15_18_Male = isset($_POST["years_15_18_Male" . $count]) ? mysql_real_escape_string($_POST["years_15_18_Male" . $count]) : 0;
        $years_15_18_Female = isset($_POST["years_15_18_Female" . $count]) ? mysql_real_escape_string($_POST["years_15_18_Female" . $count]) : 0;
        $yearsTotal = isset($_POST["yearsTotal" . $count]) ? mysql_real_escape_string($_POST["yearsTotal" . $count]) : 0;

        $sql = "INSERT INTO `form_d_data`(`form_d_id`,`division_name`, `form_a_date`, `ecd_male_total`, `ecd_female_total`, ";
        $sql.="`esct_registered`, `esct_treated_male`, `esct_treated_female`, `years_2_5_male`,";
        $sql.=" `years_2_5_female`, `years_6_10_male`, `years_6_10_female`, `years_11_14_male`, `years_11_14_female`,";
        $sql.=" `years_15_18_male`, `years_15_18_female`,`type`,`ecd_total`,`esct_treated_total`,`years_total`) VALUES ('$formD_Id','$division','$formA','$ecdMaleTotal','$ecdFemaleTotal','$esctRegistered',";
        $sql.="'$esctTreatedMale','$esctTreatedFemale','$years_2_5_Male','$years_2_5_Female','$years_6_10_Male','$years_6_10_Female','$years_11_14_Male','$years_11_14_Female','$years_15_18_Male', '$years_15_18_Female','D','$ecdTotal','$esctTreatedTotal','$yearsTotal')";
        $sql;
        $resultC = mysql_query($sql) or die(mysql_error());
        ++$count;
      }
      $count = 1;
      while (isset($_POST["dp_division" . $count]) != NULL) {
        //This are for form D. Form Dp has the same only all var end with Capital DP then count
        $dp_division = isset($_POST["dp_division" . $count]) ? mysql_real_escape_string($_POST["dp_division" . $count]) : 0;
        $dateSelected = isset($_POST["dp_formA" . $count]) ? mysql_real_escape_string($_POST["dp_formA" . $count]) : 0;
        $dp_formA = date("Y-m-d", strtotime($dateSelected));

        $dp_ecdMaleTotal = isset($_POST["dp_ecdMaleTotal" . $count]) ? mysql_real_escape_string($_POST["dp_ecdMaleTotal" . $count]) : 0;
        $dp_ecdFemaleTotal = isset($_POST["dp_ecdFemaleTotal" . $count]) ? mysql_real_escape_string($_POST["dp_ecdFemaleTotal" . $count]) : 0;
        $dp_ecdTotal = isset($_POST["dp_ecdTotal" . $count]) ? mysql_real_escape_string($_POST["dp_ecdTotal" . $count]) : 0;

        $dp_esctRegistered = isset($_POST["dp_esctRegistered" . $count]) ? mysql_real_escape_string($_POST["dp_esctRegistered" . $count]) : 0;
        $dp_esctTreatedMale = isset($_POST["dp_esctTreatedMale" . $count]) ? mysql_real_escape_string($_POST["dp_esctTreatedMale" . $count]) : 0;
        $dp_esctTreatedFemale = isset($_POST["dp_esctTreatedFemale" . $count]) ? mysql_real_escape_string($_POST["dp_esctTreatedFemale" . $count]) : 0;
        $dp_esctTreatedTotal = isset($_POST["dp_esctTreatedTotal" . $count]) ? mysql_real_escape_string($_POST["dp_esctTreatedTotal" . $count]) : 0;

        $dp_years_2_5_Male = isset($_POST["dp_years_2_5_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_2_5_Male" . $count]) : 0;
        $dp_years_2_5_Female = isset($_POST["dp_years_2_5_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_2_5_Female" . $count]) : 0;
        $dp_years_6_10_Male = isset($_POST["dp_years_6_10_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_6_10_Male" . $count]) : 0;
        $dp_years_6_10_Female = isset($_POST["dp_years_6_10_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_6_10_Female" . $count]) : 0;
        $dp_years_11_14_Male = isset($_POST["dp_years_11_14_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_11_14_Male" . $count]) : 0;
        $dp_years_11_14_Female = isset($_POST["dp_years_11_14_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_11_14_Female" . $count]) : 0;
        $dp_years_15_18_Male = isset($_POST["dp_years_15_18_Male" . $count]) ? mysql_real_escape_string($_POST["dp_years_15_18_Male" . $count]) : 0;
        $dp_years_15_18_Female = isset($_POST["dp_years_15_18_Female" . $count]) ? mysql_real_escape_string($_POST["dp_years_15_18_Female" . $count]) : 0;
        $dp_yearsTotal = isset($_POST["dp_yearsTotal" . $count]) ? mysql_real_escape_string($_POST["dp_yearsTotal" . $count]) : 0;

        $sql = "INSERT INTO `form_d_data`(`form_d_id`,`division_name`, `form_a_date`, `ecd_male_total`, `ecd_female_total`, ";
        $sql.="`esct_registered`, `esct_treated_male`, `esct_treated_female`, `years_2_5_male`,";
        $sql.=" `years_2_5_female`, `years_6_10_male`, `years_6_10_female`, `years_11_14_male`, `years_11_14_female`,";
        $sql.=" `years_15_18_male`, `years_15_18_female`,`type`,`ecd_total`,`esct_treated_total`,`years_total`) VALUES ('$formD_Id','$dp_division','$dp_formA','$dp_ecdMaleTotal','$dp_ecdFemaleTotal','$dp_esctRegistered',";
        $sql.="'$dp_esctTreatedMale','$dp_esctTreatedFemale','$dp_years_2_5_Male','$dp_years_2_5_Female','$dp_years_6_10_Male','$dp_years_6_10_Female','$dp_years_11_14_Male','$dp_years_11_14_Female','$dp_years_15_18_Male', '$dp_years_15_18_Female','DP','$dp_ecdTotal','$dp_esctTreatedTotal','$dp_yearsTotal')";

        $resultC = mysql_query($sql) or die(mysql_error());
        ++$count;
      }
      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;background-color:#a2ff7e;'>
               Record Added Successfully <br/> Select district below to add another record
            </div>";
    }
    ?>
    <!--======================-->
    <form method="POST" action="form_d.php">
      <center>
        <div style="padding: 5px; margin: 0px auto">
          <table border="0">
            <input type="hidden" name="id" value="<?php echo $id; ?>"/>
            <tr>
              <td>County </td>
              <td>
                <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select">
                  <option value="">Choose County</option>
                  <?php foreach ($insertformdata as $insertformdatacab) { ?>
                    <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>District</td>
              <td>
                <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select">
                  <option value="">Choose District</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
      </center>
      <br/>
      <center>
        <div>
          <input type="submit" name="selectDistrictFormD" value="Select" class="btn-custom"/>
          <a href="../../processData" class="btn-custom" > Cancel</a>
        </div>
      </center>
    </form>
    <div class="vclear"></div>
  </div>




  <script>
      function sum_ecd() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('ecdTotal' + num).value = (document.getElementById('ecdMaleTotal' + num).value) * 1 + (document.getElementById('ecdFemaleTotal' + num).value) * 1;
        }
        sum_all();
      }
      function sum_esct() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('esctTreatedTotal' + num).value = (document.getElementById('esctTreatedMale' + num).value) * 1 + (document.getElementById('esctTreatedFemale' + num).value) * 1;
        }
        sum_all();
      }
      function sum_years() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('yearsTotal' + num).value = (document.getElementById('years_2_5_Male' + num).value) * 1 + (document.getElementById('years_2_5_Female' + num).value) * 1 + (document.getElementById('years_6_10_Male' + num).value) * 1 + (document.getElementById('years_6_10_Female' + num).value) * 1 + (document.getElementById('years_11_14_Male' + num).value) * 1 + (document.getElementById('years_11_14_Female' + num).value) * 1 + (document.getElementById('years_15_18_Male' + num).value) * 1 + (document.getElementById('years_15_18_Female' + num).value) * 1;
        }
        sum_all();
      }
      //====================================
      function sum_ecd_dp() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('dp_ecdTotal' + num).value = (document.getElementById('dp_ecdMaleTotal' + num).value) * 1 + (document.getElementById('dp_ecdFemaleTotal' + num).value) * 1;
        }
        sum_all_dp();
      }
      function sum_esct_dp() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('dp_esctTreatedTotal' + num).value = (document.getElementById('dp_esctTreatedMale' + num).value) * 1 + (document.getElementById('dp_esctTreatedFemale' + num).value) * 1;
        }
        sum_all_dp();
      }
      function sum_years_dp() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        for (var num = 1; num <= numberOfDivisions; num++) {
          document.getElementById('dp_yearsTotal' + num).value = (document.getElementById('dp_years_6_10_Male' + num).value) * 1 + (document.getElementById('dp_years_6_10_Female' + num).value) * 1 + (document.getElementById('dp_years_11_14_Male' + num).value) * 1 + (document.getElementById('dp_years_11_14_Female' + num).value) * 1 + (document.getElementById('dp_years_15_18_Male' + num).value) * 1 + (document.getElementById('dp_years_15_18_Female' + num).value) * 1;
        }
        sum_all_dp();
      }
      //=============================================================

      function sum_all() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        //ecd_treated_male_total---------------------------------------------------
        var added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('ecdMaleTotal' + num).value) * 1);
        }
        document.getElementById('ecd_treated_male_total').value = added_sum;

        //ecd_treated_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('ecdFemaleTotal' + num).value) * 1);
        }
        document.getElementById('ecd_treated_female_total').value = added_sum;

        //ecd_treated_children_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('ecdTotal' + num).value) * 1);
        }
        document.getElementById('ecd_treated_children_total_total').value = added_sum;

        //total_enrolled_in_register_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('esctRegistered' + num).value) * 1);
        }
        document.getElementById('total_enrolled_in_register_total').value = added_sum;

        //enrolled_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('esctTreatedMale' + num).value) * 1);
        }
        document.getElementById('enrolled_male_total').value = added_sum;

        //enrolled_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('esctTreatedFemale' + num).value) * 1);
        }
        document.getElementById('enrolled_female_total').value = added_sum;

        //enrolled_treated_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('esctTreatedTotal' + num).value) * 1);
        }
        document.getElementById('enrolled_treated_total_total').value = added_sum;

        //enrolled_treated_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('esctTreatedTotal' + num).value) * 1);
        }
        document.getElementById('enrolled_treated_total_total').value = added_sum;

        //years_2_5_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_2_5_Male' + num).value) * 1);
        }
        document.getElementById('years_2_5_male_total').value = added_sum;

        //years_2_5_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_2_5_Female' + num).value) * 1);
        }
        document.getElementById('years_2_5_female_total').value = added_sum;

        //years_6_10_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_6_10_Male' + num).value) * 1);
        }
        document.getElementById('years_6_10_male_total').value = added_sum;

        //years_6_10_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_6_10_Female' + num).value) * 1);
        }
        document.getElementById('years_6_10_female_total').value = added_sum;

        //years_11_14_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_11_14_Male' + num).value) * 1);
        }
        document.getElementById('years_11_14_male_total').value = added_sum;

        //years_11_14_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_11_14_Female' + num).value) * 1);
        }
        document.getElementById('years_11_14_female_total').value = added_sum;

        //years_15_18_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_15_18_Male' + num).value) * 1);
        }
        document.getElementById('years_15_18_male_total').value = added_sum;

        //years_15_18_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('years_15_18_Female' + num).value) * 1);
        }
        document.getElementById('years_15_18_female_total').value = added_sum;

        //non_enrolled_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('yearsTotal' + num).value) * 1);
        }
        document.getElementById('non_enrolled_total_total').value = added_sum;
      }

      //===================================================================================
      function sum_all_dp() {
        var numberOfDivisions = document.getElementById('numberOfDivisions').value;
        //ecd_treated_male_total---------------------------------------------------
        var added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_ecdMaleTotal' + num).value) * 1);
        }
        document.getElementById('dp_ecd_treated_male_total').value = added_sum;

        //ecd_treated_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_ecdFemaleTotal' + num).value) * 1);
        }
        document.getElementById('dp_ecd_treated_female_total').value = added_sum;

        //ecd_treated_children_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_ecdTotal' + num).value) * 1);
        }
        document.getElementById('dp_ecd_treated_children_total_total').value = added_sum;

        //total_enrolled_in_register_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_esctRegistered' + num).value) * 1);
        }
        document.getElementById('dp_total_enrolled_in_register_total').value = added_sum;

        //enrolled_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_esctTreatedMale' + num).value) * 1);
        }
        document.getElementById('dp_enrolled_male_total').value = added_sum;

        //enrolled_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_esctTreatedFemale' + num).value) * 1);
        }
        document.getElementById('dp_enrolled_female_total').value = added_sum;

        //enrolled_treated_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_esctTreatedTotal' + num).value) * 1);
        }
        document.getElementById('dp_enrolled_treated_total_total').value = added_sum;

        //enrolled_treated_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_esctTreatedTotal' + num).value) * 1);
        }
        document.getElementById('dp_enrolled_treated_total_total').value = added_sum;

        //years_2_5_male_total---------------------------------------------------
//        added_sum = 0;
//        for (var num = 1; num <= numberOfDivisions; num++) {
//          added_sum += ((document.getElementById('years_2_5_Male' + num).value) * 1);
//        }
//        document.getElementById('years_2_5_male_total').value = added_sum;

        //years_2_5_female_total---------------------------------------------------
//        added_sum = 0;
//        for (var num = 1; num <= numberOfDivisions; num++) {
//          added_sum += ((document.getElementById('years_2_5_Female' + num).value) * 1);
//        }
//        document.getElementById('years_2_5_female_total').value = added_sum;

        //years_6_10_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_6_10_Male' + num).value) * 1);
        }
        document.getElementById('dp_years_6_10_male_total').value = added_sum;

        //years_6_10_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_6_10_Female' + num).value) * 1);
        }
        document.getElementById('dp_years_6_10_female_total').value = added_sum;

        //years_11_14_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_11_14_Male' + num).value) * 1);
        }
        document.getElementById('dp_years_11_14_male_total').value = added_sum;

        //years_11_14_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_11_14_Female' + num).value) * 1);
        }
        document.getElementById('dp_years_11_14_female_total').value = added_sum;

        //years_15_18_male_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_15_18_Male' + num).value) * 1);
        }
        document.getElementById('dp_years_15_18_male_total').value = added_sum;

        //years_15_18_female_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_years_15_18_Female' + num).value) * 1);
        }
        document.getElementById('dp_years_15_18_female_total').value = added_sum;

        //non_enrolled_total_total---------------------------------------------------
        added_sum = 0;
        for (var num = 1; num <= numberOfDivisions; num++) {
          added_sum += ((document.getElementById('dp_yearsTotal' + num).value) * 1);
        }
        document.getElementById('dp_non_enrolled_total_total').value = added_sum;
      }




      //== dropdown select ===============================================================
      //GET district
      function get_district(txt) {
        $.post('../../ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
          $('#selectdistrict').html(data);//alert(data);
        });
      }
      //GET divisions
      function get_division(txt) {
        $.post('../../ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
          $('#selectdivision').html(data);//alert(data);
        });
      }

  </script>