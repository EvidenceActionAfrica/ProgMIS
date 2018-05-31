<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");

require_once('../includes/db_functions.php');
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
    <?php require_once ("includes/meta-link-script.php"); ?>

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
    </style>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">
        <?php require_once ("includes/menuNav.php"); ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once ("includes/menuLeftBar-ProcessData.php"); ?>
      </div>

      <div class="contentBody">
        <!--================================================-->
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

        <div id="divData" style="padding-left: 3%; padding-right: 5%">
          <form method="post" action="form_d.php#selectDistrictFormD">
            <!--header-->
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
          <!--         <td width="70px">
                   <div style="border: 1px solid black; padding: 10px">
                      Survey_ID <br/>  <input type="text" size="9" name="survey_id" value="000174"/><br/>
                    </div>
                  </td>-->
                  <td><img src="../images/pill.png" height="50px"/></td>
                  <td align="center">
                    <b style="font-size: 17px; ">FORM D : DISTRICT REPORT ALBENDAZOLE<br/></b>
                  </td>
                  <td><b style="font-size: 60px">D</b></td>
                </tr>
              </table>
            </div> 
            <!--top part - text-->
            <div style="width: 100%; padding-left: 3%; font-size: 11px; ">
              <ul style="list-style: disc; line-height: 1px;">
                <li>For completion in full by the District Education Officer</li>
                <li>Please return to the national office with all Forms S and A for your district. Forms S, A and D are due to the National team within 1 month of deworming day. Please send to:</li>
              </ul>
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
                    <b>Name of DEO : </b> <input type="text" size="9" name="deoName"  style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 250px" required/><br/>
                  </td>
                  <td>
                    <b>District Name : </b>  <input type="text" size="9" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; background: #E7E3E0;width: 250px " readonly/><br/>
                  </td>
                </tr>
                <tr>
                  <td >
                    <b>Phone Num. DEO : </b> <input class="num-only" type="text" size="9" name="phoneNumber" style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 250px" required/><br/>
                  </td>
                  <td>
                    <b>County Name : </b>  <input type="text" size="9" name="county" size="500" value="<?php echo $selectedcounty; ?>" style="border: none; border-bottom: 2px dotted #000; background: #E7E3E0;width: 250px" readonly/><br/>
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
                <td colspan="3">
                  <b>Enrolled ECD Children</b>
                </td>
                <td colspan="4">
                  <b>Enrolled School Age Children</b>
                </td>
                <td colspan="9">
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
                    <input class="txtTableForm num-only"  type="text" name="division<?php echo $count; ?>" value="<?php echo $row['division_name'] ?>" readonly />
                  </td>
                  <td class="tdCompact"> <!-- date -->
                    <input class="txtTableForm myDatePicker" type="text" name="formA<?php echo $count; ?>" required/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="ecdMaleTotal<?php echo $count; ?>" id="ecdMaleTotal<?php echo $count; ?>" onblur="sum_ecd();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="ecdFemaleTotal<?php echo $count; ?>" id="ecdFemaleTotal<?php echo $count; ?>" onblur="sum_ecd();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="ecdTotal<?php echo $count; ?>" id="ecdTotal<?php echo $count; ?>" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text"name="esctRegistered<?php echo $count; ?>" id="esctRegistered<?php echo $count; ?>"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="esctTreatedMale<?php echo $count; ?>" id="esctTreatedMale<?php echo $count; ?>" onblur="sum_esct();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="esctTreatedFemale<?php echo $count; ?>" id="esctTreatedFemale<?php echo $count; ?>" onblur="sum_esct();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="esctTreatedTotal<?php echo $count; ?>" id="esctTreatedTotal<?php echo $count; ?>" readonly/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_2_5_Male<?php echo $count; ?>" id="years_2_5_Male<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_2_5_Female<?php echo $count; ?>" id="years_2_5_Female<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_6_10_Male<?php echo $count; ?>" id="years_6_10_Male<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_6_10_Female<?php echo $count; ?>" id="years_6_10_Female<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_11_14_Male<?php echo $count; ?>" id="years_11_14_Male<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_11_14_Female<?php echo $count; ?>" id="years_11_14_Female<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_15_18_Male<?php echo $count; ?>" id="years_15_18_Male<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="years_15_18_Female<?php echo $count; ?>" id="years_15_18_Female<?php echo $count; ?>" onblur="sum_years();"/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text"name="yearsTotal<?php echo $count; ?>" id="yearsTotal<?php echo $count; ?>"/>
                  </td>
                </tr>
                <?php
                $count++;
              }
              ?>

              <tr style="border: 2px solid black; padding: 0px; margin: 0px">
                <td colspan="2"><b>2. DISTRICT TOTAL </b></td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="ecd_treated_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="ecd_treated_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="ecd_treated_children_total_total" value=""/>
                </td>
                <td class="tdCompact"  style="background-color: #C3CACC !important;" >
                  <input class="txtTableForm num-only" style="background-color: #C3CACC !important;" type="text" name="total_enrolled_in_register_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="enrolled_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="enrolled_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="enrolled_treated_total_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_2_5_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_2_5_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_6_10_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_6_10_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_11_14_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_11_14_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_15_18_male_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="years_15_18_female_total" value=""/>
                </td>
                <td class="tdCompact">
                  <input class="txtTableForm num-only" type="text" name="non_enrolled_total_total" value=""/>
                </td>
              </tr>
            </table>
            <br/>
            <br/>
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
                    <td><img src="../images/pill.png" height="50px"/></td>
                    <td align="center">
                      <b style="font-size: 17px; ">FORM D : DISTRICT REPORT ALBENDAZOLE<br/></b>
                    </td>
                    <td><b style="font-size: 60px">DP</b></td>
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
                  <td colspan="3">
                    <b>Enrolled ECD Children</b>
                  </td>
                  <td colspan="4">
                    <b>Enrolled School Age Children</b>
                  </td>
                  <td colspan="7">
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
                $count = 1;
                $result_st = mysql_query("SELECT * FROM divisions WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' ");
                while ($row = mysql_fetch_array($result_st)) {
                  ?>
                  <tr style="padding: 0px; margin: 0px">
                    <td class="tdCompact"><!-- division -->
                      <input class="txtTableForm num-only"  type="text" name="dp_division<?php echo $count; ?>" value="<?php echo $row['division_name'] ?>" readonly/>
                    </td>
                    <td class="tdCompact"> <!-- date -->
                      <input class="txtTableForm myDatePicker" type="text" name="dp_formA<?php echo $count; ?>" required/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_ecdMaleTotal<?php echo $count; ?>" id="dp_ecdMaleTotal<?php echo $count; ?>" onblur="sum_enrolled_ecd(this.id);"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_ecdFemaleTotal<?php echo $count; ?>" id="dp_ecdFemaleTotal<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_ecdTotal<?php echo $count; ?>" id="dp_ecdTotal<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text"name="dp_esctRegistered<?php echo $count; ?>" id="dp_esctRegistered<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text" name="dp_esctTreatedMale<?php echo $count; ?>" id="dp_esctTreatedMale<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_esctTreatedFemale<?php echo $count; ?>" id="dp_esctTreatedFemale<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text" name="dp_esctTreatedTotal<?php echo $count; ?>" id="dp_esctTreatedTotal<?php echo $count; ?>"/>
                    </td>
                   <!-- <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_2_5_Male<?php echo $count; ?>" id="dp_years_2_5_Male<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_2_5_Female<?php echo $count; ?>" id="dp_years_2_5_Female<?php echo $count; ?>"/>
                    </td>-->
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_6_10_Male<?php echo $count; ?>" id="dp_years_6_10_Male<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_6_10_Female<?php echo $count; ?>" id="dp_years_6_10_Female<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_11_14_Male<?php echo $count; ?>" id="dp_years_11_14_Male<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_11_14_Female<?php echo $count; ?>" id="dp_years_11_14_Female<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_15_18_Male<?php echo $count; ?>" id="dp_years_15_18_Male<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text"name="dp_years_15_18_Female<?php echo $count; ?>" id="dp_years_15_18_Female<?php echo $count; ?>"/>
                    </td>
                    <td class="tdCompact">
                      <input class="txtTableForm num-only" type="text" name="dp_yearsTotal<?php echo $count; ?>" id="dp_yearsTotal<?php echo $count; ?>"/>
                    </td>
                  </tr>
                  <?php
                  $count++;
                }
                ?>

                <tr style="border: 2px solid black; padding: 0px; margin: 0px">
                  <td colspan="2"><b>4. DISTRICT TOTAL </b></td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_ecd_treated_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_ecd_treated_female_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_ecd_treated_children_total_total" value=""/>
                  </td>
                  <td class="tdCompact"  style="background-color: #C3CACC !important;" >
                    <input class="txtTableForm num-only"  style="background-color: #C3CACC !important;" type="text" name="dp_total_enrolled_in_register_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_enrolled_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_enrolled_female_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_enrolled_treated_total_total" value=""/>
                  </td>
  <!--                <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="years_2_5_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="years_2_5_female_total" value=""/>
                  </td>-->
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_6_10_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_6_10_female_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_11_14_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_11_14_female_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_15_18_male_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_years_15_18_female_total" value=""/>
                  </td>
                  <td class="tdCompact">
                    <input class="txtTableForm num-only" type="text" name="dp_non_enrolled_total_total" value=""/>
                  </td>
                </tr>
              </table>
            <?php } //end if STH/Schisto District ?>
            <br/>
            <input type="submit" name="addNewForm" value="Save & Submit" class="btn-custom"/>
          </form>
        </div>
        <br/>
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
    <script type="text/javascript" src="../js/keydown_events.js"></script>
    <script type="text/javascript" src="../js/block-return-key.js"></script>

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

    <script type="text/javascript" src="js/tableExport.js"></script>
    <script type="text/javascript" src="js/jquery.base64.js"></script>
    <script type="text/javascript">
      $('#export-button').click(function() {
        $('#data-table').tableExport({
          type: 'excel',
          escape: 'false',
          consoleLog: 'true',
          ignoreColumn: [6, 7, 8],
          htmlContent: 'true'
        });
      });

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
  <div>
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
          <a href="../processData" class="btn-custom" > Cancel</a>
        </div>
      </center>
    </form>
    <div class="vclear"></div>
  </div>




  <script>
      function sum_ecd() {
        document.getElementById('ecdTotal1').value = (document.getElementById('ecdMaleTotal1').value) * 1 + (document.getElementById('ecdFemaleTotal1').value) * 1;
        document.getElementById('ecdTotal2').value = (document.getElementById('ecdMaleTotal2').value) * 1 + (document.getElementById('ecdFemaleTotal2').value) * 1;
        document.getElementById('ecdTotal3').value = (document.getElementById('ecdMaleTotal3').value) * 1 + (document.getElementById('ecdFemaleTotal3').value) * 1;
        document.getElementById('ecdTotal4').value = (document.getElementById('ecdMaleTotal4').value) * 1 + (document.getElementById('ecdFemaleTotal4').value) * 1;
        document.getElementById('ecdTotal5').value = (document.getElementById('ecdMaleTotal5').value) * 1 + (document.getElementById('ecdFemaleTotal5').value) * 1;
        document.getElementById('ecdTotal6').value = (document.getElementById('ecdMaleTotal6').value) * 1 + (document.getElementById('ecdFemaleTotal6').value) * 1;
        document.getElementById('ecdTotal7').value = (document.getElementById('ecdMaleTotal7').value) * 1 + (document.getElementById('ecdFemaleTotal7').value) * 1;
      }
      function sum_esct() {
        document.getElementById('esctTreatedTotal1').value = (document.getElementById('esctTreatedMale1').value) * 1 + (document.getElementById('esctTreatedFemale1').value) * 1;
        document.getElementById('esctTreatedTotal2').value = (document.getElementById('esctTreatedMale2').value) * 1 + (document.getElementById('esctTreatedFemale2').value) * 1;
        document.getElementById('esctTreatedTotal3').value = (document.getElementById('esctTreatedMale3').value) * 1 + (document.getElementById('esctTreatedFemale3').value) * 1;
        document.getElementById('esctTreatedTotal4').value = (document.getElementById('esctTreatedMale4').value) * 1 + (document.getElementById('esctTreatedFemale4').value) * 1;
        document.getElementById('esctTreatedTotal5').value = (document.getElementById('esctTreatedMale5').value) * 1 + (document.getElementById('esctTreatedFemale5').value) * 1;
        document.getElementById('esctTreatedTotal6').value = (document.getElementById('esctTreatedMale6').value) * 1 + (document.getElementById('esctTreatedFemale6').value) * 1;
        document.getElementById('esctTreatedTotal7').value = (document.getElementById('esctTreatedMale7').value) * 1 + (document.getElementById('esctTreatedFemale7').value) * 1;
      }
      function sum_years() {
        document.getElementById('yearsTotal1').value = (document.getElementById('years_2_5_Male1').value) * 1 + (document.getElementById('years_2_5_Female1').value) * 1+ (document.getElementById('years_6_10_Male1').value) * 1+ (document.getElementById('years_6_10_Female1').value) * 1+ (document.getElementById('years_11_14_Male1').value) * 1+ (document.getElementById('years_11_14_Female1').value) * 1+ (document.getElementById('years_15_18_Male1').value) * 1+ (document.getElementById('years_15_18_Female1').value) * 1;
        document.getElementById('yearsTotal2').value = (document.getElementById('years_2_5_Male2').value) * 1 + (document.getElementById('years_2_5_Female2').value) * 1+ (document.getElementById('years_6_10_Male2').value) * 1+ (document.getElementById('years_6_10_Female2').value) * 1+ (document.getElementById('years_11_14_Male2').value) * 1+ (document.getElementById('years_11_14_Female2').value) * 1+ (document.getElementById('years_15_18_Male2').value) * 1+ (document.getElementById('years_15_18_Female2').value) * 1;
        document.getElementById('yearsTotal3').value = (document.getElementById('years_2_5_Male3').value) * 1 + (document.getElementById('years_2_5_Female3').value) * 1+ (document.getElementById('years_6_10_Male3').value) * 1+ (document.getElementById('years_6_10_Female3').value) * 1+ (document.getElementById('years_11_14_Male3').value) * 1+ (document.getElementById('years_11_14_Female3').value) * 1+ (document.getElementById('years_15_18_Male3').value) * 1+ (document.getElementById('years_15_18_Female3').value) * 1;
        document.getElementById('yearsTotal4').value = (document.getElementById('years_2_5_Male4').value) * 1 + (document.getElementById('years_2_5_Female4').value) * 1+ (document.getElementById('years_6_10_Male4').value) * 1+ (document.getElementById('years_6_10_Female4').value) * 1+ (document.getElementById('years_11_14_Male4').value) * 1+ (document.getElementById('years_11_14_Female4').value) * 1+ (document.getElementById('years_15_18_Male4').value) * 1+ (document.getElementById('years_15_18_Female4').value) * 1;
        document.getElementById('yearsTotal5').value = (document.getElementById('years_2_5_Male5').value) * 1 + (document.getElementById('years_2_5_Female5').value) * 1+ (document.getElementById('years_6_10_Male5').value) * 1+ (document.getElementById('years_6_10_Female5').value) * 1+ (document.getElementById('years_11_14_Male5').value) * 1+ (document.getElementById('years_11_14_Female5').value) * 1+ (document.getElementById('years_15_18_Male5').value) * 1+ (document.getElementById('years_15_18_Female5').value) * 1;
        document.getElementById('yearsTotal6').value = (document.getElementById('years_2_5_Male6').value) * 1 + (document.getElementById('years_2_5_Female6').value) * 1+ (document.getElementById('years_6_10_Male6').value) * 1+ (document.getElementById('years_6_10_Female6').value) * 1+ (document.getElementById('years_11_14_Male6').value) * 1+ (document.getElementById('years_11_14_Female6').value) * 1+ (document.getElementById('years_15_18_Male6').value) * 1+ (document.getElementById('years_15_18_Female6').value) * 1;
        document.getElementById('yearsTotal7').value = (document.getElementById('years_2_5_Male7').value) * 1 + (document.getElementById('years_2_5_Female7').value) * 1+ (document.getElementById('years_6_10_Male7').value) * 1+ (document.getElementById('years_6_10_Female7').value) * 1+ (document.getElementById('years_11_14_Male7').value) * 1+ (document.getElementById('years_11_14_Female7').value) * 1+ (document.getElementById('years_15_18_Male7').value) * 1+ (document.getElementById('years_15_18_Female7').value) * 1;
      }


      //== dropdown select ===============================================================
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

  </script>