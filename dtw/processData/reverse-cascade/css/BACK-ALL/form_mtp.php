<?php
require_once ('includes/auth.php');
require_once ('../includes/config.php');
require_once("includes/functions.php");
require_once("includes/form_functions.php");
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <?php require_once("includes/meta-link-script.php"); ?>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="images/logo.png" />  </div>
      <div class="menuLinks">
       <?php   require_once ("includes/menuNav.php");  ?>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <?php require_once("includes/menuLeftBar.php"); ?>
      </div>
      <div class="contentBody">

        <!-- contents-->
        <div style="width: 100%;margin: 20px auto;">
          <div style="width: 100%;">
            <table style="width: 100%">
              <tr>
                <td width="70px">
                  <div style="border: 1px solid black; padding: 10px">
                    Survey ID <br/>
                    <input type="text" size="9" value="000174"/><br/>
                  </div>
                </td>
                <td><img src="images/ministry_of_education.png"/></td>
                <td align="center">
                  <b style="font-size: 17px; ">FORM MT: <br/>DISTRICT SUMMARY FORM</b>
                </td>
                <td><b style="font-size: 60px">MT</b></td>
              </tr>
            </table>
          </div><br/>
          <!--At Training-->
          <b style="font-size: 12px; ">FOR COMPLETION BY LEAD MASTER TRAINER AT REGIONAL TRAINING SESSION</b>
          <div style="width: 100%; background-color: silver; border: 1px solid black">
            <b>&nbsp;DISTRICT DETAILS</b>
          </div>
          <table border="1" style="width: 100%">
            <tr align="center">
              <td style="padding: 10px">
                District Name (in full):  <input type="text" value="Bomet"/><br/>
                Number of divisions in this district: <input type="text" size="3"/><br/>
              </td>
              <td align="center">
                District ID (refer to the top of Form P-school list) : <br/>
                2014 <input type="text" size="8"/><br/>
              </td>
              <td align="center">
                Finish Date of Regional Training: <br/>
                (dd/mm/yy)<input type="text" size="10" style="width: 100%"/><br/>
              </td>
            </tr>
          </table>
          <br/>
          <div style="width: 100%;">
            <b>GUIDE THE DISTRICT IN THEIR PLANNING : </b> All divisions in a district should deworm on the day selected at the county level. Districts and division to decide other programme activity dates according to the best practice guidance provided below.<br/>
            <b>COLLECT ALL THE FORM Ps SUMMARIZE INFORMATION BELOW: </b> It is the responsibility of the lead Master Trainer to ensure Form P is properly completed for each division. Form P has primary schools only. No ECD center should be listed.
          </div>
          <br/>
          <!-- KEY PLANNING DATES ================-->
          <div style="width: 100%; background-color: silver; border: 1px solid black">
            <b>&nbsp;2. KEY PLANNING DATES : </b><i> Training from Form P (Programme Activities). Ensure lines 1-4 below are the same on all Form Ps � correct on ALL FormPs (including copies being left at district) </i>
          </div>
          <table border="1" style="width: 100%">
            <tr>
              <td align="center" width="3%"></td>
              <td width="50%"><b>EVENT</b></td>
              <td width="10%" align="center">
                <b>DATE</b><br/>
                <b style="font-size: 10px;">(dd/mm/yy)</b>
              </td>
              <td width="30%" align="center"><b>GUIDANCE</b></td>
            </tr>
            <tr>
              <td align="center">1.</td>
              <td><b>Agreed District Deworming Day:</b></td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>As agreed by County, (About 1 week after teacher training)</i></td>
            </tr>
            <tr>
              <td align="center">2.</td>
              <td><b>Agreed </b>Form S/SP to AEO:</td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>About 1 week after deworming day</i></td>
            </tr>
            <tr>
              <td align="center">3.</td>
              <td><b>Agreed </b>AEO returns Forms S/SP and A/AP to DEO :</td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>About 2 weeks after deworming day</i></td>
            </tr>
            <tr>
              <td align="center">4.</td>
              <td><b>Agreed </b>DEO returns Form S/SP, A/AP adn D/DP to Naitonal Team :</td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>About 3 weeks after deworming day</i></td>
            </tr>
            <tr>
              <td align="center">5.</td>
              <td>Teacher Trainings Start:(choose earliest TT session listed on  any form P)</td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>At least 5 days after RT. Latest 1 week before deworming day</i></td>
            </tr>
            <tr>
              <td align="center">6.</td>
              <td>Teacher Trainings End:(choose latest TT session listed on any form P)</td>
              <td><input type="text" size="10" style="width: 100%"/></td>
              <td><i>Latest 1 week before deworming day</i></td>
            </tr>
          </table><br/><br/>
          <!-- DISTRICT SUMMARY ================-->
          <div style="width: 100%; background-color: silver; border: 1px solid black">
            <b>&nbsp;3. DISTRICT SUMMARY : </b><i>Copy form Form P (Programme Activities) </i>
          </div>
          <table border="1" style="width: 100%">
            <tr>
              <td align="center" width="1%"></td>
              <td align="center" width="10%"><b>Division Name</b></td>
              <td align="center" width="10%"><b>Total Number Primary Schools</b></td>
              <!--        <td align="center" width="10%">
                        <div style="border: 1px solid black">Enrollment in schools</div><br/><b>Total Number Primary Schools</b>
                      </td>-->
              <td align="center" width="10%"><b>Enrollment in schools: Primary</b></td>
              <td align="center" width="10%"><b>Enrollment in schools: ECD</b></td>
              <td align="center" width="10%"><b>Total No. ECD Stand alone centers</b></td>
              <td align="center" width="10%"><b>Enrolment in stand alone ECD</b></td>
              <td align="center" width="10%"><b>No. of alb tablets needed</b></td>
              <td align="center" width="10%"><b>No. of Bilhazia Schools</b></td>
              <td align="center" width="10%"><b>No. of PZQ tablets needed</b></td>
              <td align="center" width="10%"><b>Training sessions</b></td>
            </tr>
            <tr>
              <td align="center">1.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">2.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">3.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">4.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">5.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">6.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center"></td>
              <td><b>TOTAL DISTRICT</b></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center"><input type="text" style="width: 100%; font-weight: bold"/></td>
            </tr>
          </table><br/><br/>

          <!--=   MT CHECKLIST ========================-->
          <div style="width: 100%; background-color: silver; border: 1px solid black">
            <b>&nbsp;4. MT CHECKLIST </b>
          </div>
          <table frame="box" style="width: 100%">
            <tr>
              <td width="30%">1. Form P for each division completed and checked</td>
              <td width="15%"><input type="checkbox" name="mt_checklist1" value="1"></td>
              <td width="30%">5. Form P copied and supplied to all division trainers</td>
              <td width="15%"><input type="checkbox" name="mt_checklist5" value="1"></td>
            </tr>
            <tr>
              <td>2. Master Trainer has copy of Form P for every division</td>
              <td><input type="checkbox" name="mt_checklist2" value="1"></td>
              <td>6. Form A/AP school list pre filled by AEO using Form P</td>
              <td><input type="checkbox" name="mt_checklist6" value="1"></td>
            </tr>
            <tr>
              <td>3. Form MT completed </td>
              <td><input type="checkbox" name="mt_checklist3" value="1"></td>
              <td>7. National team informed of any relevant dates</td>
              <td><input type="checkbox" name="mt_checklist7" value="1"></td>
            </tr>
            <tr>
              <td>4. MT and P prepared for submission to national team</td>
              <td><input type="checkbox" name="mt_checklist4" value="1"></td>
              <td></td>
              <td></td>
            </tr>
          </table>
          <div style="border: 1px solid black; padding: 5px">
            Lead Master Trainer Name : <input type="text" name="ee" style="width:200px">
          </div>
          <div style="border: 1px solid black; padding: 5px">
            Name of other Master Trainers : 
            1. <input type="text" name="ee" style="width:200px"/>
            2. <input type="text" name="ee" style="width:200px"/>
          </div>
          <br/>
          Thank you master trainer. Please return Form MT to the Natinal team as soon as possible along with one copy of each Form P. The national team can be reached on 0715-836787
          <br/><br/><br/>
          <div style="height: 10px; background-color: black"></div>

          <!--==================================================================================-->

          <!--header-->
          <div style="width: 100%;">
            <table style="width: 100%">
              <tr>
                <td width="70px">
                  <div style="border: 1px solid black; padding: 10px">
                    Survey ID <br/>
                    <input type="text" size="9" value="00018"/><br/>
                  </div>
                </td>
                <td><img src="images/pill.png"/></td>
                <td align="center">
                  <b style="font-size: 17px; ">FORM P: DIVISION PLANNING <br/> (School List)</b>
                </td>
                <td>
                  <b style="font-size: 60px;">&nbsp;&nbsp;&nbsp;P </b><br/> 
                  <font style="font-size: 20px">Division ID: xxxxx</font><br/> 
                </td>
              </tr>
            </table>
          </div><br/>
          <!--====================================-->
          <table style="width: 100%" frame="box" cellpadding="10px">
            <tr>
              <td>
                <b>DISTRICT NAME :</b><input type="text" value="BOMET"/><br/>
              </td>
              <td>
                <b>DISTRICT ID :</b><input type="text" value="34352"/><br/>
              </td>
              <td>
                <b>DIVISION NAME :</b><input type="text" value="LONGISA"/><br/>
              </td>
              <td>
                <b>DIVISION ID :</b><input type="text" value="3452"/><br/>
              </td>
            </tr>
          </table>
          <br/>
          <ul>
            <li>Review the list of public and private primary schools below. Complete the enrolment date & tablet calculations carefully & neatly</li>
            <li>Indicate if any school has closed with a (tick) in the �closed� column</li>
            <li>Strike off any closed school & do not complete the table for them</li>
            <li>Ass new schools at the end of the form. Complete the programme assigned school ID using the first 2 letters of the school name. </li>
          </ul>
          <br/>
          <b style="font-size: 18px">SCHOOL LIST</b>

          <table border="1" style="width: 100%">
            <tr>
              <td align="center" width="1%"></td>
              <td align="center" width="10%"><b>School Name</b></td>
              <td align="center" width="10%"><b>Programme Assigned School ID</b></td>
              <td align="center" width="10%"><b>School type (Public/Private/other)</b></td>
              <td align="center" width="10%"><b>Closed (Tick if closed)</b></td>
              <td align="center" width="10%"><b>Primary School Enrolment (A)</b></td>
              <td align="center" width="10%"><b>ECD attached Enrolment (B)</b></td>
              <td align="center" width="10%"><b>No. of stand alone ECD centers in School Catchment Area</b></td>
              <td align="center" width="10%"><b>Estimated enrolment in <u>stand alone</u> ECD centers (C)</b></td>
              <td align="center" width="10%"><b>Calculate no. of ALB tablets needed (A+B+C)+20%</b></td>
              <td align="center" width="10%"><b>Bilhazia Schoo?(Yes/No)</b></td>
              <td align="center" width="10%"><b>Calc. No. of PZQ reuqired for Bilhazia Schools ((Ax2.5)+40%)</b></td>
            </tr>
            <tr>
              <td align="center">1.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="checkbox" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <tr>
              <td align="center">2.</td>
              <td><input type="text" /></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="checkbox" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
              <td align="center"><input type="text" style="width: 100%"/></td>
            </tr>
            <!--==-->
            <!--other records to enter here-->
            <!--==-->

            <tr style="border: 2px solid black">
              <td align="center"></td>
              <td><b>3. Total this sheet (Both sides)</b></td>
              <td align="center" style="font-size: 10px">Total no.of schools: (do not count closed)</td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Yes Ct<input type="text" style="width: 100%; font-weight: bold"/></td>
              <td align="center">Sum:<input type="text" style="width: 100%; font-weight: bold"/></td>
            </tr>
          </table><br/><br/>
        </div>
        <!------- end form ------------>


      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
    <script type="text/javascript">
      $(document).ready(function() {
        $("#deworming_date").datepicker({
          dateFormat: 'yy-mm-dd',
          showOn: 'focus',
          buttonImageOnly: true,
          buttonImage: 'calendar/cal.gif',
          buttonText: 'Pick a date',
          onClose: function(dateText, inst) {
            //$("#EndDate").val($("#proposedmovedate").val());
          }
        });
        $('#deworming_date').datepicker("option", 'minDate', new Date($("#deworming_date").datepicker('getDate')));
      });
    </script>
  </body>
</html>



