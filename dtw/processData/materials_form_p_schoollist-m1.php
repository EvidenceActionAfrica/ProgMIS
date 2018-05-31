<?php
require_once ('../includes/auth.php');
require_once ('../includes/config.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");

require_once('../includes/db_functions.php');
$evidenceaction = new EvidenceAction();

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_login_forms_reverse = $row['priv_login_forms_reverse'];
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
      .fc{
        background-color: #fcfcfc !important;
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
        <?php require_once ("includes/menuLeftBar-Materials.php"); ?>
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
          $selecteddivision = $_POST['selectdivision'];

          //get division IDs
          $resD = mysql_query("SELECT * FROM divisions WHERE district_name='$selecteddistrict' AND  division_name='$selecteddivision' ");
          while ($row = mysql_fetch_array($resD)) {
            $district_id = $row["district_id"];
            $division_id = $row["division_id"];
          }

          //get mt_sesssions
          $res_mt = mysql_query("SELECT * FROM form_mt WHERE district_name='$selecteddistrict'  ");
          while ($row = mysql_fetch_array($res_mt)) {
            $mt_sessions = $row["mt_sessions"];
          }
        }
        ?>
		
		<!-- ramadhan's added code -->
		<?php
		if($_SESSION['database'] != 'evidence_action_year4'){
		?>
        <!-- /ramadhan's added code -->
		
		<form method="post" action="form_p.php#selectDistrictFormD">
          <div id="divData" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
            <!--header-->
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
                  <td><img src="../images/pill.png" height="50px"/></td>
                  <td align="center">
                    <b style="font-size: 19px; ">FORM P: WARD PLANNING </b> <br/>
                    <b style="font-size: 16px; ">(School List)</b><br/>
                  </td>
                  <td align="right"><b style="font-size: 60px">P</b></td>
                </tr>
              </table>
              <br/>
              <table style="width: 100%">
                <tr>
                  <td><b>1. SUB-COUNTY : </b><input type="text" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; width: 40%;  background: #fcfcfc" readonly/></td>
                  <td><b>SUB-COUNTY ID: </b><input type="text" name="district_id" value="<?php echo $district_id; ?>" style="border: none; border-bottom: 2px dotted #000; width: 30%;  background: #fcfcfc" readonly/></td>
                  <td><b>WARD NAME: </b><input type="text" name="division" value="<?php echo $selecteddivision; ?>" style="border: none; border-bottom: 2px dotted #000; width: 40%;  background: #fcfcfc" readonly/></td>
                  <td><b>WARD ID: </b><input type="text" name="division_id" value="<?php echo $division_id; ?>" style="border: none; border-bottom: 2px dotted #000;  width: 30%; background: #fcfcfc" readonly/></td>
                </tr>
              </table>
              <br/>
            </div>
            <!--top part - text-->
            <div style="width: 100%; padding-left: 3%; font-size: 11px; ">
              • Review the list of public and private primary schools below. Complete the enrolment data and tablet calculations carefully and neatly<br/><br/>
              • Indicate if any school has closed with a &radic; in the “closed�? column<br/><br/>
              <font style="float: left">• Strike off any closed schools and do not complete the table for them. Example : </font>
              <table border="2" width="400px" style="float: left">
                <tr>
                  <td><strike>Hope Primary</strike></td>
                  <td><strike>001-001-HQ05</strike></td>
                  <td><strike>Public</strike></td>
                  <td>&radic;</td>
                </tr>
              </table>
              <br/><br/>
              <div style="clear: both"></div>
              <font style="float: left"> • Add new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of school name. Example:<br/> </font>
              <table border="2" width="200px" style="float: left">
                <tr>
                  <td>BARACK P.S.</td>
                  <td>001-001- <font style="font-size: 8px">BA</font> 50</td>
                </tr>
              </table>
            </div>
            <br/>
            <br/>


            <!-- Section 1 =============-->
            <table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
              <tr>
                <td rowspan="2" align="center" valign="bottom" ><b>No.</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 30%"><b>School Name</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 15%"><b>Programme Assigned School ID</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 15%"><b>MOE CODE</b></td>
                <td rowspan="2" align="center">
                  <b>School Type<br/><br/>
                    (Public/ private/ other)
                  </b>
                </td>
                <td rowspan="2" align="center" style="width: 05%"><b>School Closed?</b></td>
                <td colspan="2" align="center"><b>Enrolment in this school (children in register book) including attached ECD</b></td>
                <td rowspan="2" align="center"><b>No. of stand- alone ECD centres in School Catchment Area</b></td>
                <td rowspan="2" align="center"><b>Estimated enrolment in stand- alone ECD centres. <br/><br/>(C) </b></td>
                <td rowspan="2" align="center"><b>Calculate number of ALB tablets needed <br/><br/> (A+B+C) +15% </b></td>
                <td rowspan="2" align="center"><b> School treating for Bilharzia?<br/><br/> (Yes/No)<br/><br/></b></td>
                <td rowspan="2" align="center"><b>Total Enrollment <br/><br/>(A+B+C)<br/><br/> </b></td>
              </tr>
              <tr>
                <td align="center">Primary school enrolment <br/><br/> (A) </td>
                <td align="center">ECD attached enrolment <br/><br/> (B)</td>
              </tr>

              <style>
                .noPadding{
                  padding: 0px; margin: 0px; height: 2px;
                }
              </style>

              <?php
              $count = 1;
              $result_st = mysql_query("SELECT * FROM schools WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' AND division_name ='$selecteddivision' ORDER BY school_name ASC");
              while ($row = mysql_fetch_array($result_st)) {
                ?>
                <tr class="noPadding">
                  <td class="noPadding" align="center"><?php echo $count; ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $row['school_name'] ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $school_id = $row['school_id'] ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $row['moe_code'] ?></td>
                  <td class="noPadding" style="padding-left: 2px">
                    <?php
                    if ($row['school_type'] == 'Missing')
                      echo '';
                    else
                      echo $row['school_type'];
                    ?>
                  </td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding" style="padding-left: 20px;"><?php
                    if (($row['treatment_type']) == "STH/Schisto") {
                      echo "Yes";
                    } else {
                      echo "No";
                    }
                    ?></td>
                  <td align="center"></td>
                </tr>
                <?php
                $count++;
              }

              //get district and division id substring
              $id_substring = substr($school_id, 0, 8);

              //extra schools spaces
              for ($newCt = 51; $newCt <= 60; $newCt++) {
                ?>
                <tr>
                  <td class="noPadding" align="center"><?php echo $count; ?></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $id_substring . '___' . $newCt ?></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td align="center"></td>
                </tr>
                <?php
                $count++;
              }
              ?>
              

            </table>
            <table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
            <tr>
          <td align="center" valign="bottom" style="width: 20%"><font style="font-size: 18px"><b>3. Total this sheet</b></font></td>
          <td align="left" valign="top" style="width: 29%"><b>Total no. of schools: (do not count closed)</b></td>
          <td align="left" valign="top" style="width: 6.7%"><b>Count</b></td>
          <td align="left" valign="top" style="width: 6.8%"><b>Sum:</b></td>
          <td align="left" valign="top" style="width: 7.6%"><b>Sum:</b></td>
          <td align="left" valign="top" style="width: 7.8%"><b>Sum:</b></td>
          <td align="left" valign="top" style="width: 7%"><b>Sum:</b></td>
          <td align="left" valign="top" style="width: 7.3%"><b>Count yes:</b></td>
          <td align="left" valign="top"><b>Sum:</b></td>
        </tr>
      </table>

            <br/>
            <br/>
          </div>
          <br/>
          <br/>
          <br/>
          <br/>






          <div id="divData2" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
            <table style="width: 100%">
              <tr>
                <td align="left" style="width: 200px">
                  <div style="border: 1px solid grey; height: 65px">
                    <font style="vertical-align: top; color: grey; font-size: 10px">Do not write on this space</font>
                  </div>
                </td>
                <td align="left" style="width: 80px"><img src="../images/pill.png" height="50px"/></td>
                <td align="center">
                  <b style="font-size: 28px; ">FORM P: WARD Planning</b> <br/>
                  <b style="font-size: 18px; ">(Programme Activities)</b><br/>
                </td>
                <td align="right"><b style="font-size: 70px">P</b></td>
              </tr>
            </table>
            <center>
              <font style="font-size: 13px">Using Form P (school list) please complete the planning exercise below for your Ward.</font>
            </center>
            <br/>
            <table border="1" style="border: 3px solid black">
              <tr><td colspan="9"><b style="font-size: 14px">1. Ward Summary: Please add up all Form P sheet totals to give a summary for this Ward</b></td></tr>
              <tr height="50px" style="font-size: 12px">
                <th rowspan="2" style="width: 5%">Ward Name:</th>
                <th rowspan="2" style="width: 2%">Total Number Primary Schools</th>
                <th colspan="2" style="width: 5%">Enrolment in schools</th>
                <th rowspan="2" style="width: 2%">Total No. of Stand-alone centres</th>
                <th rowspan="2" style="width: 2%">Total Enrolment in stand-alone ECD centres</th>
                <th rowspan="2" style="width: 2%">No. of ALB tablets needed</th>
                <th rowspan="2" style="width: 2%">No. Bilharzia Schools</th>
                <th rowspan="2" style="width: 2%">No. of PZQ tablets needed</th>
              </tr>
              <tr style="font-size: 12px">
                <th>Primary</th>
                <th>ECD</th>
              </tr>
              <tr height="50px" align="left" style="font-size: 12px; font-weight: normal">
                <th align="center"><font style="font-size: 15px"><?php echo $selectedWard; ?></font></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </table>
            <br/>
            <!--22222222222222222222222222222222222222222-->
            <table  style="border: 3px solid black; font-weight: normal; width: 100%">
              <tr><td style="border-bottom: 1px solid black"><b style="font-size: 14px">2. Number of Training Sessions:</b></td></tr>
              <tr><td><b style="font-size: 12px">Based on the programme in your Ward last year the total number of teacher training sessions allocated this year is: <u style="font-size: 15px"><?php echo $mt_sessions; ?></u></b></td></tr>
              <tr height="50px"><td><font style="font-size: 12px">This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session. Please speak with a Master Trainer if you think the number of teacher training sessions should be revised.</font></td></tr>
            </table>
            <br/>
            <!--333333333333333333333333333333333333333333-->
            <table border="1" style="border: 3px solid black; font-weight: normal; width: 100%">
              <tr><td colspan="8"><b style="font-size: 14px">3. Plan scheduling and select venues for teacher training:</b></td></tr>
              <tr><td colspan="8"><i style="font-size: 12px">As a Ward plan the teacher training sessions according to the number needed<br/>Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</i></td></tr>
              <tr height="60px" style="font-size: 12px">
                <th rowspan="2" style="width: 1%"></th>
                <th rowspan="2" style="width: 10%">Training Venue</th>
                <th rowspan="2" style="width: 2%">Estimated Training date<br/><br/>(DD/MM/YY)</th>
                <th colspan="2" style="width: 20%">Assigned Responsible MOE and MoH Officer</th>
                <th colspan="3" style="width: 10%">No. of Schools Attending</th>
              </tr>
              <tr style="font-size: 12px">
                <th style="width: 10%">Name</th>
                <th>Phone Number</th>
                <th style="width: 2%">Non-<br/>Bilharzia<br/>(A)</th>
                <th style="width: 2%">Bilharzia<br/>(B)</th>
                <th style="width: 2%">Total<br/>(A+B)</th>
              </tr>
              <?php
              for ($count = 1; $count <= 10; $count++) {
                ?>
                <tr height="15px" align="left" style="font-size: 12px; font-weight: normal">
                  <th rowspan="2" align="center"><?php echo $count; ?></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                  <th></th>
                  <th></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                </tr>
                <tr height="15px" align="left" style="font-size: 12px; font-weight: normal">
                  <th></th>
                  <th></th>
                </tr>
              <?php } ?>
            </table>
            <br/>
            <!--44444444444444444444444444444-->
            <table align="left" border="1" style="border: 3px solid black; font-weight: normal; width: 100%;">
              <tr><td colspan="3" style="border-bottom: 1px solid black"><b style="font-size: 14px">4. As a Sub-County please agree on and record the following dates:</b></td></tr>
              <tr style="height: 30px">
                <th align="left"><b>Event</b></th>
                <th><b>Guidance on Date</b> (As agreed by County)</th>
                <th><b style="font-size: 9px">Agreed Date<br/>(DD/MM/YY)</b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>Deworming Day</b></th>
                <th>About 1 week after teacher training</th>
                <th><b style="font-size: 15px">_____/_____/ 18 </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>Return Form S to CSO</b></th>
                <th>About 1 week after deworming day</th>
                <th><b style="font-size: 15px">_____/_____/ 18 </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>CSO Returns Form S and A to SCDE</b></th>
                <th>About 2 weeks after deworming day</th>
                <th><b style="font-size: 15px">_____/_____/ 18 </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>SCDE returns S,A, and D to national team</b></th>
                <th>About 3 weeks after deworming day</th>
                <th><b style="font-size: 15px">_____/_____/ 18 </b></th>
              </tr>
            </table>
            <br/>
            <br/>
            Thank You Officers. Please make sure the SCDE,SCMOH and Master Trainer(MT) and all people conducting a TT session have a copy of correctly filled Form P including School List. Please give the original copy to a Master Trainer. Please use Form P to prefill Form A and AP with school names,IDs and EMIS Codes for each ward.
            <br/>
            <br/>
          </div>










          <br/>
          <!--<input type="submit" name="generatePDF" value="Generate PDF" class="btn-custom-pink"/>-->
          <a href="../tcpdf/examples/form_p_schoollist.php?county=<?php echo $selectedcounty; ?>&district=<?php echo $selecteddistrict; ?>&district_id=<?php echo $district_id; ?>&division=<?php echo $selecteddivision; ?>&division_id=<?php echo $division_id; ?>&mt_sessions=<?php echo $mt_sessions; ?>" class="btn-custom-pink" style="text-decoration: none;">Generate PDF</a>
        </form>
		
		<!-- ramadhan's added code -->
			<?php
				}
			else{
			?>
		<!-- /ramadhan's added code -->
				
		<form method="post" action="form_p.php#selectDistrictFormD">
          <div id="divData" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
			  
            <div style="width: 100%;">
              <table style="width: 100%">
                <tr>
                  <td><img src="../images/pill.png" height="50px"/></td>
                  <td align="center">
                    <b style="font-size: 19px; ">FORM P: WARD PLANNING</b> <br/>
                    <b style="font-size: 16px; ">(School List)</b><br/>
                  </td>
                  <td align="right"><b style="font-size: 60px">P</b></td>
                </tr>
              </table>
              <br/>
              <table style="width: 100%">
                <tr>
                  <td><b>1. SUB-COUNTY : </b><input type="text" name="district" value="<?php echo $selecteddistrict; ?>" style="border: none; border-bottom: 2px dotted #000; width: 40%;  background: #fcfcfc" readonly/></td>
                  <td><b>SUB-COUNTY ID: </b><input type="text" name="district_id" value="<?php echo $district_id; ?>" style="border: none; border-bottom: 2px dotted #000; width: 30%;  background: #fcfcfc" readonly/></td>
                  <td><b>WARD NAME: </b><input type="text" name="division" value="<?php echo $selecteddivision; ?>" style="border: none; border-bottom: 2px dotted #000; width: 40%;  background: #fcfcfc" readonly/></td>
                  <td><b>WARD ID: </b><input type="text" name="division_id" value="<?php echo $division_id; ?>" style="border: none; border-bottom: 2px dotted #000;  width: 30%; background: #fcfcfc" readonly/></td>
                </tr>
              </table>
              <br/>
            </div>
            <!--top part - text-->
            <div style="width: 100%; padding-left: 3%; font-size: 11px; ">
              • Review the list of public and private primary schools below. Complete the enrolment data carefully and neatly<br/><br/>
              • Indicate if any school has closed with a <b style="font-size: 14px">&radic;</b> in the "closed" column<br/><br/>
              <font style="float: left">• Strike off any closed schools and do not complete the table for them. Example: </font>
              <table border="2" width="400px" style="float: left">
                <tr>
                  <td><strike>Hope Primary</strike></td>
                  <td><strike>001-001-HQ05</strike></td>
                  <td><strike>Public</strike></td>
                  <td><b>&radic;</b></td>
                </tr>
              </table>
              <br/><br/>
              <div style="clear: both"></div>
              <font style="float: left"> • Add new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of school name. Example:<br/> </font>
              <table border="2" width="200px" style="float: left">
                <tr>
                  <td>BARACK P.S.</td>
                  <td>001-001-BA <font style="font-size: 8px"></font> 50</td>
                </tr>
              </table>
            </div>
            <br/>
            <br/>
			<font style="float: left"><b>2. SCHOOL LIST</b></font>

            <!-- Section 1 =============-->
            <table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
              <tr>
                <td rowspan="2" align="center" valign="bottom" ><b>No.</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 35%"><b>School Name</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 15%"><b>Programme Assigned School ID</b></td>
                <td rowspan="2" align="center" valign="bottom" style="width: 15%"><b>School EMIS Code</b></td>
                <td rowspan="2" align="center">
                  <b>School Status<br/><br/>
                    (Public or private)
                  </b>
                </td>
                <td rowspan="2" align="center" style="width: 05%"><b>CLOSED (Tick if closed)</b><br><br><b style="font-size: 14px">&radic;</b></td>
                <td colspan="2" align="center"><b>Total school enrolment  (children in register book) including attached ECD</b></td>
                <td rowspan="2" align="center"><b>No. of stand- alone ECD centres in School Catchment Area</b></td>
                <td rowspan="2" align="center"><b>Estimated enrolment in <u>stand- alone</u> ECD centres <br/><br/>(C) </b></td>
                <!--<td rowspan="2" align="center"><b>Calculate number of ALB tablets needed <br/><br/> (A+B+C) +15% </b></td>-->
                <td rowspan="2" align="center"><b>School treating for Bilharzia? <br/><br/><br/><br/> (Yes/No)<br/><br/></b></td>
                <td rowspan="2" align="center"><b>Total Enrollment <br/><br/>(A+B+C)<br/><br/></b></td>
              </tr>
              <tr>
                <td align="center">Primary school enrolment <br/><br/> <b>(A)</b> </td>
                <td align="center">ECD attached enrolment <br/><br/> <b>(B)</b></td>
              </tr>


              <style>
                .noPadding{
                  padding: 0px; margin: 0px; height: 2px;
                }
              </style>

              <?php
              $count = 1;
              $result_st = mysql_query("SELECT * FROM schools WHERE county='$selectedcounty' AND district_name ='$selecteddistrict' AND division_name ='$selecteddivision' ORDER BY school_name ASC");
              while ($row = mysql_fetch_array($result_st)) {
                ?>
                <tr class="noPadding">
                  <td class="noPadding" align="center"><?php echo $count; ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $row['school_name'] ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $school_id = $row['school_id'] ?></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $row['moe_code'] ?></td>
                  <td class="noPadding" style="padding-left: 2px">
                    <?php
                    if ($row['school_type'] == 'Missing')
                      echo '';
                    else
                      echo $row['school_type'];
                    ?>
                  </td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <!--<td class="noPadding"></td>-->
                  <td class="noPadding" style="padding-left: 30px;"><?php
                    if (($row['treatment_type']) == "STH/Schisto") {
                      echo "Yes";
                    } else {
                      echo "No";
                    }
                    ?></td>
                  <td align="center"></td>
                </tr>
                <?php
                $count++;
              }

              //get district and division id substring
              $id_substring = substr($school_id, 0, 8);

              //extra schools spaces
              for ($newCt = 51; $newCt <= 60; $newCt++) {
                ?>
                <tr>
                  <td class="noPadding" align="center"><?php echo $count; ?></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding" style="padding-left: 2px"><?php echo $id_substring . '___' . $newCt ?></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding" style="padding-left: 2px"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <td class="noPadding"></td>
                  <!--<td class="noPadding"></td>-->
                  <td class="noPadding"></td>
                  <td align="center"></td>
                </tr>
                <?php
                $count++;
              }
              ?>


            </table>
			
			<!--ramadhan's added code -->
			<br>
			<table border="1" align="center" cellpadding="5" style="width: 100%; border: 2px solid black; font-size: 11px">
				<tr>
					<td align="center" valign="bottom" style="width: 25%"><font style="font-size: 18px"><b>3. Total this sheet</b></font></td>
					<td align="left" valign="top" style="width: 25%"><b>Total no. of schools: (do not count closed)</b></td>
					<td align="left" valign="top" style="width: 5.9%"><b>Count</b></td>
					<td align="left" valign="top" style="width: 6.7%"><b>Sum:</b></td>
					<td align="left" valign="top" style="width: 6.8%"><b>Sum:</b></td>
					<td align="left" valign="top" style="width: 7.7%"><b>Sum:</b></td>
					<td align="left" valign="top" style="width: 7.6%"><b>Sum:</b></td>
					<td align="left" valign="top" style="width: 7.3%"><b>Count yes:</b></td>
					<td align="left" valign="top"><b>Sum:</b></td>
				</tr>
			</table>
			<!--/ramadhan's added code -->
			
            <br/>
            <br/>
          </div>
          <br/>
          <br/>
          <br/>
          <br/>






          <div id="divData2" style="padding-left: 3%; padding-right: 5%; background-color: #FCFCFC">
            <table style="width: 100%">
              <tr>
                <td align="left" style="width: 200px">
                  <div style="border: 1px solid grey; height: 65px">
                    <font style="vertical-align: top; color: grey; font-size: 10px">Do not write on this space</font>
                  </div>
                </td>
                <td align="left" style="width: 80px"><img src="../images/pill.png" height="50px"/></td>
                <td align="center">
                  <b style="font-size: 28px; ">FORM P: WARD Planning</b> <br/>
                  <b style="font-size: 18px; ">(Programme Activities)</b><br/>
                </td>
                <td align="right"><b style="font-size: 70px">P</b></td>
              </tr>
            </table>
            <center>
              <font style="font-size: 13px">Using Form P (school list) please complete the planning exercise below for your Ward.</font>
            </center>
            <br/>
            <table border="1" style="border: 3px solid black">
              <tr><td colspan="9"><b style="font-size: 14px">1. Ward Summary: Please add up all Form P sheet totals to give a summary for this Ward</b></td></tr>
              <tr height="50px" style="font-size: 12px">
                <th rowspan="2" style="width: 5%">Ward Name:</th>
                <th rowspan="2" style="width: 2%">Total Number Primary Schools</th>
                <th colspan="2" style="width: 5%">Enrolment in schools</th>
                <th rowspan="2" style="width: 2%">Total No. of Stand-alone centres</th>
                <th rowspan="2" style="width: 2%">Total Enrolment in stand-alone ECD centres<br>(C)</th>
                <!--<th rowspan="2" style="width: 2%">No. of ALB tablets needed</th>-->
                <th rowspan="2" style="width: 2%">No. Bilharzia Schools</th>
                <th rowspan="2" style="width: 2%">Total Enrolment (A+B+C)</th>
              </tr>
              <tr style="font-size: 12px">
                <th>Primary<br>(A)</th>
                <th>ECD<br>(attached)<br>(B)</th>
              </tr>
              <tr height="50px" align="left" style="font-size: 12px; font-weight: normal">
                <th align="center"><font style="font-size: 15px"><?php echo $selectedWard; ?></font></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
              </tr>
            </table>
            <br/>
            <!--22222222222222222222222222222222222222222-->
            <table  style="border: 3px solid black; font-weight: normal; width: 100%">
              <tr><td style="border-bottom: 1px solid black"><b style="font-size: 14px">2. Number of Training Sessions:</b></td></tr>
              <tr><td><b style="font-size: 12px">Based on the programme in your ward last year the total number of teacher training sessions allocated to your Ward this year is: <u style="font-size: 15px"><?php echo $mt_sessions; ?></u></b></td></tr>
              <tr height="50px"><td><font style="font-size: 12px">This should allow 2 teachers from every school to be trained with a maximum of 20 schools per teacher training session (40 pax). Please speak with your Master Trainer if you think the number of teacher training sessions should be revised.</font></td></tr>
            </table>
            <br/>
            <!--333333333333333333333333333333333333333333-->
            <table border="1" style="border: 3px solid black; font-weight: normal; width: 100%">
              <tr><td colspan="8"><b style="font-size: 14px">3. Plan scheduling and select venues for teacher training:</b></td></tr>
              <tr><td colspan="8"><i style="font-size: 12px">As a ward, plan the teacher training sessions according to the number needed<br/>Discuss which schools may attend each training and provide an approximate number of schools expected at each TT session.</i></td></tr>
              <tr height="60px" style="font-size: 12px">
                <th rowspan="2" style="width: 1%"></th>
                <th rowspan="2" style="width: 10%">Training Venue</th>
                <th rowspan="2" style="width: 2%">Estimated Training date<br/><br/>(DD/MM/YY)</th>
                <th colspan="2" style="width: 20%">Assigned Responsible Officer MOE or MoH</th>
                <th colspan="3" style="width: 10%">No. of Schools Attending</th>
              </tr>
              <tr style="font-size: 12px">
                <th style="width: 10%">Name</th>
                <th>Phone Number</th>
                <th style="width: 2%">Non-<br/>Bilharzia<br/>(A)</th>
                <th style="width: 2%">Bilharzia<br/>(B)</th>
                <th style="width: 2%">Total<br/>(A+B)</th>
              </tr>
              <?php
              for ($count = 1; $count <= 10; $count++) {
                ?>
                <tr height="15px" align="left" style="font-size: 12px; font-weight: normal">
                  <th rowspan="2" align="center"><?php echo $count; ?></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                  <th></th>
                  <th></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                  <th rowspan="2"></th>
                </tr>
                <tr height="15px" align="left" style="font-size: 12px; font-weight: normal">
                  <th></th>
                  <th></th>
                </tr>
              <?php } ?>
            </table>
            <br/>
            <!--44444444444444444444444444444-->
            <table align="left" border="1" style="border: 3px solid black; font-weight: normal; width: 100%;">
              <tr><td colspan="3" style="border-bottom: 1px solid black"><b style="font-size: 14px">4. As a Sub-County please agree on and record the following dates:</b></td></tr>
              <tr style="height: 30px">
                <th align="left"><b>Event</b></th>
                <th><b>Guidance on Date</b> (As agreed by County)</th>
                <th><b style="font-size: 9px">Agreed Date<br/>(DD/MM/YY)</b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>Deworming Day</b></th>
                <th>About 1 week after teacher training</th>
                <th><b style="font-size: 15px">____/____/____ </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>Return MOH 517C (School Summary) to CSO</b></th>
                <th>About 1 week after deworming day</th>
                <th><b style="font-size: 15px">____/____/____ </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>CSO Returns MOH 517C and MOH 517D (Ward summary) to SCDE</b></th>
                <th>About 2 weeks after deworming day</th>
                <th><b style="font-size: 15px">____/____/____ </b></th>
              </tr>
              <tr style="height: 30px">
                <th align="left"><b>SCDE returns MOH 517C, MOH 517D and MOH 517E (Sub-County Summary)<br>to National Secretariat (Evidence Action)</b></th>
                <th>About 3 weeks after deworming day</th>
                <th><b style="font-size: 15px">____/____/____ </b></th>
              </tr>
            </table>
            <br/>
            <br/>
            <b>Thank You Ward Officers.</b> Please make sure the CSO, SCDE, Master Trainer and all people conducting a Teacher Training session have a copy of correctly filled Form P including School List. Please give the original to a Master Trainer. Please use Form P to prefill Form <b>MOH 517D</b> (Ward summary) with school names and IDs for each Ward.
            <br/>
            <br/>
          </div>










          <br/>
          <!--<input type="submit" name="generatePDF" value="Generate PDF" class="btn-custom-pink"/>-->
          <a href="../tcpdf/examples/+form_p_schoollist_y4.php?county=<?php echo $selectedcounty; ?>&district=<?php echo $selecteddistrict; ?>&district_id=<?php echo $district_id; ?>&division=<?php echo $selecteddivision; ?>&division_id=<?php echo $division_id; ?>&mt_sessions=<?php echo $mt_sessions; ?>" class="btn-custom-pink" style="text-decoration: none;">Generate PDF</a>
        </form>
				
		<!-- ramadhan's added code -->		
		<?php } ?>
		<!-- /ramadhan's added code -->			
					
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









<!--===== Modal Select Sub-County ===========================-->
<div id="selectDivisionFormP" class="modalDialog">
  <div style="width: 500px">
    <a href="#close" title="Close" class="close">X</a>
    <div >
      <h1 class="form-title">Select Sub-County </h1><br/>
    </div>
    <?php
    $cmdAdd = filter_input(INPUT_POST, "addNewForm");
    if ($cmdAdd) {
      $count = 1;
      $sql = "INSERT INTO `form_d`(`SCDE_name`, `county`, `district`, `phone_number`)";
      $sql.=" VALUES ('$SCDEName','$county','$district','$phoneNumber')";

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

      echo "<div style='text-align:center;width:auto;margin:0 auto;padding:5px;border:1px solid #3eda00;background-color:#a2ff7e;'>
               Record Added Successfully <br/> Select Sub-County below to add another record
            </div>";
    }
    ?>
    <!--======================-->
    <form method="POST" action="materials_form_p_schoollist.php">
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
              <td>Sub-County</td>
              <td>
                <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select">
                  <option value="">Choose Sub-County</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Ward</td>
              <td>
                <select  id="selectdivision" name="selectdivision" class="input_select">
                  <option value="">Choose Ward</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
      </center>
      <br/>
      <center>
        <div>
          <input type="submit" name="selectDistrictFormD" value="Select" class="btn-custom-pink"/>
          <a href="../processData" class="btn-custom-pink" > Cancel</a>
        </div>
      </center>
    </form>
    <div class="vclear"></div>
  </div>


  <script>
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






  <?php
  error_reporting(0);

  function generatePDF_quotation($quotation) {


// always load alternative config file for examples
    require_once('tcpdf/examples/config/tcpdf_config_alt.php');

// Include the main TCPDF library (search the library on the following directories).
    $tcpdf_include_dirs = array(realpath('tcpdf/tcpdf.php'), '/usr/share/php/tcpdf/tcpdf.php', '/usr/share/tcpdf/tcpdf.php', '/usr/share/php-tcpdf/tcpdf.php', '/var/www/tcpdf/tcpdf.php', '/var/www/html/tcpdf/tcpdf.php', '/usr/local/apache2/htdocs/tcpdf/tcpdf.php');
    foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
      if (@file_exists($tcpdf_include_path)) {
        require_once($tcpdf_include_path);
        break;
      }
    }

//===================================
// Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF {

      //Page header
      public function Header() {
        if ($this->getPage() == 1) {
          // Logo
          $image_file = K_PATH_IMAGES . 'evidence-action.jpg';
          // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
          $this->Image($image_file, 50, 10, 100, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          // Set font
          $this->SetFont('helvetica', 'B', 20);
          // Title
          // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
      }

      // Page footer
      public function Footer() {
        if ($this->getPage() == 2) {
          // Logo
          $image_file = K_PATH_IMAGES . 'letterhead-footer.jpg';
          // Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false);
          $this->Image($image_file, 30, 280, 150, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          // ... footer for the normal page ...
        }
      }

    }

// create new PDF document
    $pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Cube Movers');
    $pdf->SetTitle('Quotation');
    $pdf->SetSubject('Quotation');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT); // left = 2.5 cm, top = 4 cm, right = 2.5cm
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(900);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
      require_once(dirname(__FILE__) . '/lang/eng.php');
      $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------
//// set font
//  $pdf->SetFont('verdana', 'BI', 12);
// add a page
// $pdf->AddPage();
// set some text to print
    $txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// add a page
    $pdf->AddPage();


// create some HTML content
    $html = $quotation;
//    $html = $quotation
//            . '<center><img src="' . $signatureurl . '"  width="140" border="0" /></center>'
//            . $signature;
// get the first array. This will be make part of the name of pdf
    $pdf_name = 'Quotation_.pdf';

// output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------
//Close and output PDF document
// anything between ob_start and ob_end_clean will not be returned to ajax success message
    //ob_start();
//to save to a directory, just add the path before the name of the pdf.
    $pdf->Output('pdf/' . $pdf_name, 'FD');
//  $pdf->Output('Form_P_SchoolList.pdf', 'I');
//    ob_end_clean();

    return $pdf_name;
  }
  ?>