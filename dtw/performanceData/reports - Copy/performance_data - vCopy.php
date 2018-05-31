<?php
require_once ('../includes/config.php');
require_once ('../includes/auth.php');
require_once ("../includes/functions.php");
require_once ("../includes/form_functions.php");
$level = $_SESSION['level'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
  <head>
    <title>Evidence Action</title>
    <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="../css/vstyle.css"/>
    <!-- Victor -->
    <!-- <link rel="stylesheet" type="text/css" href="css/vstyle.css"> --><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="js/custom.js"></script>
  </head>
  <body>
    <!---------------- header start ------------------------>
    <div class="header">
      <div style="float: left">  <img src="../images/logo.png" />  </div>
      <div class="menuLinks">

        <nav>
          <ul>
            <li><a href="../home.php">HOME</a></li>
            <li><a href="../schools.php">ADMIN DATA</a></li>
            <li><a href="../form_s.php">PROCESS DATA</a></li>
            <li> <a href="../performanceData.php">PERFORMANCE DATA</a>  </li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="clearFix"></div>
    <!---------------- content body ------------------------>
    <div class="contentMain">
      <div class="contentLeft">
        <h3>Standard Reports</h3>
        <ul>
          <a href="national_reports.php"><li>Standardized Reports</li></a>
        </ul>
        <br/>
        <h3>On Demand</h3>
        <ul>
          <a href="performance_data.php"><li>Generate report</li></a>
        </ul>
        <br/>
        <h3>Dash-Boards</h3>
        <ul>
          <a href="../dashboard_forms.php"><li>Form S</li></a>
          <a href="../dashboard_mtp.php"><li>MT-P</li></a>
          <a href="../dashboard_attnt.php"><li>ATTNT</li></a>
        </ul>
      </div>
      <div class="contentBody">
        <!--================================================-->



 









        <?php
        require_once('config/include.php');
        $evidenceaction = new EvidenceAction();
        //	  $evidenceaction->checksession();
        //print_r($_SESSION);
        ?>
        <head>
          <?php include('config/head.php'); ?>
          <title>Evidence Action :: Performance Data</title>
        </head>
        <body>
          <div class="wrapperNwp">

            <!---------------- body start ------------------------>
            <div class="rstBdy">
              <div class="inside">
                <div class="selSec">
                  <label>Choose a Level</label>
                  <select onchange="if ($('#selectlevel').val() == 'County') {
                        $('#sevlevel').css('display', 'block');
                      }
                      if ($('#selectlevel').val() == 'National') {
                        $('#sevlevel').css('display', 'none');
                      }" id="selectlevel" name="selectlevel">
                    <option value="County">County</option>
                    <option value="National">National</option>
                  </select>
                </div>
                <div class="secol" id="sevlevel">
                  <p class="hthtxt">Select the specific option</p>
                  <div class="selSec">
                    <?php
                    $tablename = 'county_table';
                    $fields = 'id, county';
                    $where = '1=1';
                    $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                    ?>
                    <ul>
                      <li>
                        <label>Country</label>
                        <select onchange="get_district(this.value);" id="selectcounty" name="selectcounty">
                          <option value="">Choose County</option>
                          <?php foreach ($insertformdata as $insertformdatacab) { ?>
                            <option value="<?php
                            echo 'COUN';
                            if ($insertformdatacab['id'] < 10) {
                              echo '0' . $insertformdatacab['id'];
                            } else {
                              echo $insertformdatacab['id'];
                            }
                            ?>"><?php echo $insertformdatacab['county']; ?></option>
                                  <?php } ?>
                        </select>
                      </li>
                      <li>
                        <label>District</label>
                        <select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict">
                          <option value="">Choose District</option></select>
                      </li>
                      <li>
                        <label>Division</label>
                        <select id="selectdivision" name="selectdivision" onchange="get_school(this.value);">
                          <option value="">Choose Division</option>
                        </select>
                      </li>
                      <li>
                        <label>School</label>
                        <select id="selectschool" name="selectschool">
                          <option value="">Choose School</option>
                        </select>
                      </li>
                    </ul>

                  </div>
                </div>
                <p class="hthtxt">Number of Dewormed</p>
                <div class="chckSec">
                  <ul>
                    <li>
                      <label>Select Gender</label>
                      <span>Male <input type="checkbox" name="male" id="male" value="Male" class="checkval" /></span>
                      <span>Female <input type="checkbox" name="female" id="female" value="Female" class="checkval" /></span>
                    </li>
                    <li>
                      <label>Check the Age Group</label>
                      <span>2 - 5 yrs <input name="years_2_5" id="years_2_5" type="checkbox" value="years_2_5_male,years_2_5_female" /></span>
                      <span>6 - 10 yrs <input name="years_6_10" id="years_6_10" type="checkbox" value="years_6_10_male,years_6_10_female" /></span>
                      <span>11 - 14yrs <input name="years_11_14" id="years_11_14" type="checkbox" value="years_11_14_male,years_11_14_female" /></span>
                      <span>15 - 18 yrs <input name="years_15_18" id="years_15_18" type="checkbox" value="years_15_18_male,years_15_18_female" /></span>
                    </li>
                    <li>
                      <label>Dewormed status</label>
                      <span>Enrolled <input name="enrolled" id="enrolled" type="checkbox" value="enrolled" /></span>
                      <span>Non-Enrolled <input name="nonenrolled" id="nonenrolled" type="checkbox" value="nonenrolled" /></span>
                    </li>
                  </ul>
                </div>
                <p class="hthtxt">Number of Schools</p>
                <div class="chckSec">
                  <ul>
                    <li>
                      <label>Choose School Category</label>
                      <span>Private <input name="" type="checkbox" value="" /></span>
                      <span>Public <input name="public" type="checkbox" value="public" /></span>
                      <span>Others <input name="" type="checkbox" value="" /></span>
                    </li>
                    <li>
                      <label>Select Treatment</label>
                      <span>SDH <input name="" type="checkbox" value="" /></span>
                      <span>Shisto <input name="" type="checkbox" value="" /></span>
                    </li>
                    <li>
                      <label>Choose School's status</label>
                      <span>Treated <input name="" type="checkbox" value="" /></span>
                      <span>Non treated <input name="" type="checkbox" value="" /></span>
                      <span>Trained <input name="" type="checkbox" value="" /></span>
                      <span>Non trained <input name="" type="checkbox" value="" /></span>
                      <span>Planned <input name="" type="checkbox" value="" /></span>
                      <span>Non planned <input name="" type="checkbox" value="" /></span>
                    </li>
                  </ul>
                </div>
                <div class="selSec">
                  <ul>
                    <li>
                      <label class="dischrt">Select your display chart</label>
                      <!--onchange="$('.chartdraw').css('height','0px');$('.chartdraw').html('');if($('#selectchart').val()=='Line'){$('#containerbar').css('height','400px');}if($('#selectchart').val()=='Pie'){$('#container').css('height','400px');}"-->
                      <select id="selectchart" name="selectchart" onchange="$('.chartdraw').html('');">
                        <option value="pie">Pie Chart</option>
                        <option value="line">Line Graph</option>
                        <option value="bar">Bar Graph</option>
                        <option value="column">Plain tables</option>
                      </select>
                    </li>
                  </ul>

                </div>
                <input name="generate_report" type="button" value="Generate Report" class="genBtn" onclick="selectcounty();" />
                <!--<p class="hthtxt cnts">Country Indicators : Pie Chart</p>
                <div class="chrtSec"><img src="images/pieChrt.jpg" alt="" /></div>-->
                <div id="reportschart"></div>
              </div>
            </div>
            <!---------------- body end ------------------------>
          </div>
        </body>
        </html>
        <script>
                    //GET district
                    function get_district(txt) {
                      $.post('report_ajax.php', {checkval: 'district', county: txt}).done(function(data) {
                        $('#selectdistrict').html(data);//alert(data);
                      });
                    }
                    function get_division(txt) {
                      $.post('report_ajax.php', {checkval: 'division', district: txt}).done(function(data) {
                        $('#selectdivision').html(data);//alert(data);
                      });
                    }
                    function get_school(txt) {
                      $.post('report_ajax.php', {checkval: 'school', division: txt}).done(function(data) {
                        $('#selectschool').html(data);//alert(data);
                      });
                    }
                    function selectcounty() {
                      //var urlmn = '?checkval=form_s_pdf';
                      //alert($("#selectdistrict").val());
                      if ($("#selectdistrict").val() != '') {
                        var selectdistrict = $("#selectdistrict").val();
                        //urlmn += '&selectdistrict=selectdistrict';
                      } else {
                        var selectdistrict = '';
                      }
                      if ($("#selectdivision").val() != '') {
                        var selectdivision = $("#selectdivision").val();
                        //urlmn += '&selectdivision=selectdivision';
                      } else {
                        var selectdivision = '';
                      }
                      if ($("#selectschool").val() != '') {
                        var selectschool = $("#selectschool").val();
                        //urlmn += '&selectschool=selectschool';
                      } else {
                        var selectschool = '';
                      }
                      if ($("#male").is(":checked") == true) {
                        var male = $("#male").val();
                        //urlmn += '&male=male';
                      } else {
                        var male = '';
                      }
                      if ($("#female").is(":checked") == true) {
                        var female = $("#female").val();
                        //urlmn += '&female=female';
                      } else {
                        var female = '';
                      }
                      if ($("#years_2_5").is(":checked") == true) {
                        var years_2_5 = $("#years_2_5").val();
                        //urlmn += '&female=female';
                      } else {
                        var years_2_5 = '';
                      }
                      if ($("#years_6_10").is(":checked") == true) {
                        var years_6_10 = $("#years_6_10").val();
                        //urlmn += '&female=female';
                      } else {
                        var years_6_10 = '';
                      }
                      if ($("#years_11_14").is(":checked") == true) {
                        var years_11_14 = $("#years_11_14").val();
                        //urlmn += '&female=female';
                      } else {
                        var years_11_14 = '';
                      }
                      if ($("#years_15_18").is(":checked") == true) {
                        var years_15_18 = $("#years_15_18").val();
                        //urlmn += '&female=female';
                      } else {
                        var years_15_18 = '';
                      }
                      if ($("#enrolled").is(":checked") == true) {
                        var enrolled = $("#enrolled").val();
                        //urlmn += '&female=female';
                      } else {
                        var enrolled = '';
                      }
                      if ($("#nonenrolled").is(":checked") == true) {
                        var nonenrolled = $("#nonenrolled").val();
                        //urlmn += '&female=female';
                      } else {
                        var nonenrolled = '';
                      }
                      if ($("#selectchart").val() != '') {
                        var selectchart = $("#selectchart").val();
                        //urlmn += '&selectdivision=selectdivision';
                      } else {
                        var selectchart = '';
                      }
                      $.post('report_ajax.php', {checkval: 'form_s', selectdistrict: selectdistrict, selectdivision: selectdivision, selectschool: selectschool, male: male, female: female, years_2_5: years_2_5, years_6_10: years_6_10, years_11_14: years_11_14, years_15_18: years_15_18, enrolled: enrolled, nonenrolled: nonenrolled, selectchart: selectchart}).done(function(data) {
                        $('#reportschart').html(data);//alert(data);
                        //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
                      });
                    }
        </script>
        <script src="js/highcharts.js"></script>
        <script src="js/modules/exporting.js"></script>
        <script src="js/modules/data.js"></script>
        <script src="js/modules/drilldown.js"></script>
        <div id="container" style="margin: 0 auto;min-width: 300px;" class="chartdraw"></div>
        <!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
        <!--<a id="downid" style="display: none;">Download PDF</a>-->






















        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>



