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
      .solidBorder{
        border: 1px solid black !important;
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
                    <b style="font-size: 19px; ">FORM A : DIVISION TREATMENT REPORT ALBENDAZOLE<br/></b>
                  </td>
                  <td align="right"><b style="font-size: 60px">A</b></td>
                </tr>
              </table>
            </div>


            <!--top part - fields -->
            <div style="width: 100%; font-size: 12px">
              <table style="width: 100%">
                <tr>
                  <td width="220px">
                    <b>For completion by the AEO : </b>
                  </td>
                  <td>
                    <b>Name of DEO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : </b> <input type="text" size="9" name="deoName"  style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 60%" required/><br/>
                  </td>
                  <td>
                    <b>County Name : </b>  <input type="text" size="9" name="county" size="500" value="<?php echo $selectedcounty; ?>" style="border: none; border-bottom: 2px dotted #000;width: 60%; background: #fcfcfc" readonly/><br/>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    <b>Phone Num. DEO : </b> <input class="num-only" type="text" size="9" name="phoneNumber" style="border: none; border-bottom: 2px dotted #000; background: #fff; width: 60%; " required/><br/>
                  </td>
                  <td>
                    <b>District Name : </b>  <input type="text" size="9" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; width: 60%; background: #fcfcfc" readonly/><br/>
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td>
                    <b>Division Name: </b>  <input type="text" size="9" name="county" size="500" value="<?php echo $selectedcounty; ?>" style="border: none; border-bottom: 2px dotted #000;width: 60%; background: #fcfcfc" readonly/><br/>
                  </td>
                </tr>
              </table>
            </div><br/>

            <!--top part - text-->
            <b style="font-size: 12px">
              AEO: Please use Form S’s to complete this form and record treatment with Albendazole. Use as many Form A’s as you need.
            </b><br/><br/>

            
            <!-- Section 1 =============-->
            <table border="1" align="center" cellpadding="5" class="table-hover" style="width: 100%; border: 2px dotted black; font-size: 11px">
              <tr height="60px">
                <td colspan="3" rowspan="4" width="30%" style="border: 2px dotted black;"><b>1. Complete this section at regional training by copying information from Form P (School List).</b></td>
                <td rowspan="4" width="20px"></td>
                <td colspan="17" style="border-left: 1px solid white" ><b>2. Indicate here if Form S has been returned and <u><i>COMPLETE THE AEO SECTION ON EACH FORM S.</i></u></b></td>
              </tr>
              <tr>
                <td colspan="16" class="solidBorder" align="center"><b>3. Fill the information below for each school using the correct sections of Form S</b></td>
              </tr> 



              <tr>
                <td colspan="3" align="center" class="solidBorder">
                  <b>Enrolled ECD Children</b>
                </td>
                <td colspan="4" align="center" class="solidBorder">
                  <b>Enrolled School Age Children</b>
                </td>
                <td colspan="9" align="center" class="solidBorder">
                  <b>Non Enrolled Children </b>
                </td>
              </tr>

              <tr>
                <td colspan="3" align="center" class="solidBorder">
                  Total number of children treated
                </td>
                <td  align="center" class="solidBorder" style="background-color: #C3CACC">
                  Children <br/>in register <br/> book
                </td>
                <td colspan="3" align="center" class="solidBorder">
                  Total Number of <br/>children treated
                </td>
                <td colspan="2" align="center" class="solidBorder">2-5 yrs</td>
                <td colspan="2" align="center" class="solidBorder">6-10 yrs</td>
                <td colspan="2" align="center" class="solidBorder">11-14yrs</td>
                <td colspan="2" align="center" class="solidBorder">15-18yrs</td>
                <td rowspan="2" align="center" class="solidBorder"><b>TOTAL</b></td>
              </tr>

              <tr>
                <td style="padding-left: 2px"><b>No.</b></td>
                <td style="padding-left: 2px"><b>School name in full</b></td>
                <td style="padding-left: 2px"><b>Programme ID</b></td>
                <td align="center" class="solidBorder">√</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
                <td align="center" class="solidBorder">TOTAL</td>
                <td align="center" class="solidBorder"style="background-color: #C3CACC">TOTAL</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
                <td align="center" class="solidBorder">TOTAL</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
                <td align="center" class="solidBorder">M</td>
                <td align="center" class="solidBorder">F</td>
              </tr>

              
              <?php
              $selectedcounty = 'Kericho';
              $selecteddistrict ='Belgut';
              $selecteddivision ='Belgut';
              $count = 1;
              $result_st = mysql_query("SELECT * FROM schools WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' AND division_name ='$selecteddivision' ORDER BY school_name ASC");
              while ($row = mysql_fetch_array($result_st)) {
                ?>
                <tr style="padding: 0px; margin: 0px">
                  <td style="padding-left: 2px"><?php echo $count; ?></td>
                  <td style="padding-left: 2px"><?php echo $row['school_name'] ?></td>
                  <td style="padding-left: 2px"><?php echo $row['school_id'] ?></td>
                  
                  <td align="center" class="solidBorder">
                    <input class="txtTableForm num-only" type="checkbox" name="sReturned<?php echo $count; ?>" id="sReturned<?php echo $count; ?>" />
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
              
              
            </table>
            <br/>
            <br/>


  

 


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