<?php
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php');
 // privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_demand= $row['priv_demand'];
}

if($priv_demand>=1){
 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">

  <head>

    <title>Evidence Action :: Performance Data</title>
    <?php require_once ("includes/meta-link-script.php"); ?>

    <!-- <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" /> -->

    <!-- <link rel="stylesheet" type="text/css" href="../css/vstyle.css"/> -->

    <!-- Victor -->

    <!-- <link rel="stylesheet" type="text/css" href="css/vstyle.css"> --><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script src="js/custom.js"></script>

  </head>

  <body>

    <!---------------- header start ------------------------>

    <div class="header">

      <div style="float: left"><img src="../../images/logo.png" />  </div>

      <div class="menuLinks">

        <!-- <nav>

          <ul>

            <li><a href="../home.php">HOME</a></li>

            <li><a href="../schools.php">ADMIN DATA</a></li>

            <li><a href="../form_s.php">PROCESS DATA</a></li>

            <li> <a href="../performanceData.php">PERFORMANCE DATA</a>  </li>

          </ul>

        </nav> -->
        <?php
        require_once ("includes/menuNav.php");
        ?>

      </div>

    </div>

    <div class="clearFix"></div>

    <!---------------- content body ------------------------>

    <div class="contentMain">

      <div class="contentLeft">

        <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>

      </div>

      <div class="contentBody">

        <!--================================================-->



        <?php
        require_once ('config/include.php');

        $evidenceaction = new EvidenceAction();
        ?>

        <?php include ('config/head.php'); ?>


        <div class="wrapperNwp">

          <!---------------- body start ------------------------>

          <div class="rstBdy">

            <div class="inside">
              <h1 style="text-align: center; padding: 5px">On Demand </h1>
              <div id="step1">
                <h3 class="fill">Step 1</h3>
                <div class="selSec">
                  <p class="hthtxt" style="float: left; margin-right: 10px;">Geography</p>
                  <div class="vclear"></div>

                  <label>Level</label>

                  <select onchange="if ($('#selectlevel').val() == 'county') {

                        $('#county_info').css('display', 'block');

                      } else {

                        $('#county_info').css('display', 'none');

                      }

                      //if ($('#selectlevel').val() == 'national') {

                      // $('#sevlevel').css('display', 'none');

                      //}" id="selectlevel" name="selectlevel">

                    <option value="county">County</option>

                    <option value="national">National</option>

                  </select>
                  <hr>
                </div>

                <div class="secol" id="sevlevel">

                    <!-- <p class="hthtxt">Select the specific option</p> -->

                  <div class="selSec" id="county_info">

                    <?php
                    $tablename = 'county_table';

                    $fields = 'id, county';

                    $where = '1=1';

                    $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                    ?>

                    <ul>

                      <li>

                        <label>County</label>

                        <select onchange="get_district();" id="selectcounty" name="selectcounty">

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

              </div> <!-- end step1 -->
              <div id="step2">
                <h3 class="fill">Step 2</h3>
                <div class="selSec">

                  <ul>

                    <li>

                    <!-- <p class="hthtxt" style="float: left; margin-right: 10px;">Select your display chart</p> -->
                      <!-- <label class="vfloatleft custom-label ">Select chart</label>   -->
                      <label>Select Chart</label>

                      <!--onchange="$('.chartdraw').css('height','0px');$('.chartdraw').html('');if($('#selectchart').val()=='Line'){$('#containerbar').css('height','400px');}if($('#selectchart').val()=='Pie'){$('#container').css('height','400px');}"-->



                      <select id="selectchart" name="selectchart" onchange="$('.chartdraw').html('');">

                        <option value="pie">Pie Chart</option>

                        <option value="horizontal_bar">Horizontal Bar</option>

                        <option value="vertical_bar">Vertical Bar</option>

                        <option value="line_graph">Line Graph</option>

                        <option value="tables">Tables</option>

                      </select>

                    </li>

                  </ul>

                </div>
              </div><!-- end step2 -->
              <div id="step3">
                <h3 class="fill">Step 3</h3>
                <div class="selSec">

                  <ul>

                    <li>

                        <!-- <p class="hthtxt" >Level</p> -->
                      <label>Level</label>

                      <select  id="select_level" name="select_level" onchange="changeLevel(this.value);">

                        <option value="schools">No. of Schools</option>

                        <option value="children">No. of Children</option>

                      </select>

                      <script>

                    function changeLevel(value) {

                      if (value == 'schools') {

                        $('#treated_container').css('display', 'block');

                        $('#gender_container').css('display', 'none');

                        $('#age_container').css('display', 'none');

                        $('#enrollment_container').css('display', 'none');

                        $('#gender_filter').css('display', 'none');

                        $('#age_filter').css('display', 'none');

                        $('#enrollment_filter').css('display', 'none');

                      } else {

                        $('#treated_container').css('display', 'none');

                        $('#gender_container').css('display', 'block');

                        $('#age_container').css('display', 'block');

                        $('#enrollment_container').css('display', 'block');

                        $('#gender_filter').css('display', 'table-row');

                        $('#age_filter').css('display', 'table-row');

                        $('#enrollment_filter').css('display', 'table-row');

                      }

                    }

                      </script>

                    </li>

                  </ul>

                </div>
              </div><!-- end step 3 -->
              <div id="step4">
                <h3 class="fill">Step 4</h3>
                <div class="selSec">

                  <ul>

                    <li>

                      <p class="hthtxt" style="margin-right: 10px;">Category By:</p> <br />

                      <!-- <label style="float: left; font-weight: bold;">By:</label> -->

                      <!-- <br /><br /> -->

                      <div class="category_tile" id="gender_container" style="display: none;">

                        <label class="category-td" >Gender</label>

                        <input type="checkbox" name="category_by_gender" id="category_by_gender" value="gender" onchange="toggleFilter(this.value, this.checked);"/></span>

                      </div>

                      <div class="category_tile" id="age_container" style="display: none;">

                        <label class="category-td label_custom" >Age</label>

                        <input type="checkbox" name="category_by_age" id="category_by_age" value="age" onchange="toggleFilter(this.value, this.checked);"/></span>

                      </div>

                      <div class="category_tile" id="enrollment_container" style="display: none;">

                        <label class="label_custom category-td" >Enrollment</label>

                        <input type="checkbox" name="category_by_enrollment" id="category_by_enrollment" value="enrollment" onchange="toggleFilter(this.value, this.checked);"/></span>

                      </div>

                      <div class="category_tile">

                        <label class="label_custom category-td" >School type</label>

                        <input type="checkbox" name="category_by_school_type" id="category_by_school_type" value="school_type" onchange="toggleFilter(this.value, this.checked);"/></span>

                      </div>

                      <div class="category_tile">

                        <label class="label_custom category-td" >Treatment type</label>

                        <input type="checkbox" name="category_by_treatment_type" id="category_by_treatment_type" value="treatment_type" onchange="toggleFilter(this.value, this.checked);"/></span>

                      </div>

                      <div class="chckSec">

              <!-- <table> -->

                <!-- <tr>

                  <td style ="height: 35px;"> -->
                        <div class="category_tile">
                          <label class="category-td" >Geography</label>



                          <select  name="category_by_geography" id="category_by_geography">

                            <option>County</option>

                            <option>District</option>

                            <option>Division</option>

                          </select>
                        </div>  
                        <!-- </td> -->

                        <!-- </tr> -->

                        <!-- </table> -->

                        <div id="treated_container">

                          <label class="category-td">Treated</label>

                          <select  id="category_by_treated" name="category_by_treated">

                            <option value="planned_untreated">Planned, not treated </option>

                            <option value="planned_treated">Planned and treated </option>

                            <option value="unplanned_treated">Unplanned and treated </option>

                          </select>

                        </div>

                    </li>

                  </ul>

                </div>
              </div> <!--end step 4-->
              <div id="step5">
                <h3 class="fill">Step 5</h3>
                <script>

                    function toggleFilter(value, checked) {

                      if (value == 'gender') {

                        $('#gender_filter').css('display', checked ? 'none' : 'table-row');

                        return;

                      }

                      if (value == 'age') {

                        $('#age_filter').css('display', checked ? 'none' : 'table-row');

                        return;

                      }

                      if (value == 'enrollment') {

                        $('#enrollment_filter').css('display', checked ? 'none' : 'table-row');

                        return;

                      }

                      if (value == 'school_type') {

                        $('#school_type_filter').css('display', checked ? 'none' : 'table-row');

                        return;

                      }

                      if (value == 'treatment_type') {

                        $('#treatment_type_filter').css('display', checked ? 'none' : 'table-row');

                        return;

                      }

                    }

                </script>

                <div class="selSec">

                  <ul>

                    <li>

                      <!-- <label style="font-weight: bold; margin-left: 20px;">Filter:</label> -->
                      <p class="hthtxt" style="margin-right: 10px;">Filter By:</p> <br />

                      <div class="chckSec">

                        <table id="category">

                          <tr style="height: 35px; display: none;" id="gender_filter" >

                            <td class="category-td">

                              <label style="width: 100%; text-align: left;">Gender</label>

                            </td>

                            <td style="width: 240px;">

                              <span style="font-weight: bold;"><input type="checkbox" name="filter_male" id="filter_male" value="filter_male" class="checkval" />Male</span>

                              <span style="font-weight: bold; margin-left: 73px;"><input type="checkbox" name="filter_female" id="filter_female" value="filter_female" class="checkval" />Female </span>

                            </td>

                          </tr>

                          <tr style="height: 35px; display: none;" id="age_filter">

                            <td class="category-td">

                              <label style="width: 100%; text-align: left;">Age</label>

                            </td>

                            <td>

                              <span style="font-weight: bold;"><input name="filter_under_5" id="filter_under_5" type="checkbox" value="filter_under_5" />5 and under</span>

                              <span style="font-weight: bold; margin-left: 20px;"><input name="filter_over_5" id="filter_over_5" type="checkbox" value="filter_over_5" />Over 5</span>

                            </td>

                          </tr>

                          <tr style="height: 35px; display: none;" id="enrollment_filter">

                            <td class="category-td">

                              <label style="width: 100%; text-align: left;">Enrollment</label>

                            </td>

                            <td>

                              <span style="font-weight: bold;"><input name="filter_enrolled" id="filter_enrolled" type="checkbox" value="filter_enrolled" />Enrolled </span>

                              <span style="font-weight: bold; margin-left: 48px;"><input name="filter_non_enrolled" id="filter_non_enrolled" type="checkbox" value="filter_non_enrolled" />Non-Enrolled </span>

                            </td>

                          </tr>

                          <tr style="height: 35px;" id="school_type_filter">

                            <td class="category-td">

                              <label style="text-align: left;" >School type</label>

                            </td>

                            <td>

                              <span style="font-weight: bold;"><input name="filter_school_public" type="checkbox" value="filter_school_public" id="filter_school_public" />Public</span>

                              <span style="font-weight: bold; margin-left: 65px;"><input name="filter_school_private" type="checkbox" value="filter_school_private" id="filter_school_private"/>Private</span>

                            </td>

                            <td>

                              <span style="font-weight: bold; margin-left: 15px;"><input name="filter_school_other" type="checkbox" value="filter_school_other" id="filter_school_other" />Other</span>

                            </td>

                          </tr>

                          <tr style="height: 35px;" id="treatment_type_filter">

                            <td class="category-td">

                              <label style="text-align: left;">Treatment type</label>

                            </td>

                            <td>

                              <select style="width: 145px;" name="treatment_type" id="treatment_type">

                                <option name="filter_treatment_sth" value="filter_treatment_sth">STH only</option>

                                <option name="filter_treatment_both" value="filter_treatment_both">STH and Schisto</option>

                              </select>

                            </td>

                          </tr>

                        </table>	              

                      </div>

                    </li>

                  </ul>

                </div>

              </div>
            </div><!--end step5-->
            <div class="vclear"></div>
            <input class="btn-custom-small" name="generate_report" type="button" value="Generate Report" class="genBtn" onclick="generateReport();" />

                <!--<p class="hthtxt cnts">Country Indicators : Pie Chart</p>

                <div class="chrtSec"><img src="images/pieChrt.jpg" alt="" /></div>-->

            <div id="reportschart"></div>

          </div>

        </div>

        <!---------------- body end ------------------------>

      </div>

      <!-- content main -->
    </div>

  </body>

</html>

<script>

                    //GET district

                    function generateReport() {

                      // get the geography

                      var geography = $('#selectlevel option:selected').val();

                      // get the chart type

                      var chartType = $('#selectchart option:selected').val();

                      // get the level

                      var level = $('#select_level option:selected').val();



                      // get the category options

                      // BY

                      var by_gender = $('#category_by_gender').prop('checked');

                      var by_age = $('#category_by_age').prop('checked');

                      var by_enrollment = $('#category_by_enrollment').prop('checked');

                      var by_school_type = $('#category_by_school_type').prop('checked');

                      var by_treatment_type = $('#category_by_treatment_type').prop('checked');

                      var by_geography = $('#category_by_geography').val();

                      var by_treated = level == 'schools' ? $('#category_by_treated').val() : '';



                      // FILTER

                      var filter_gender = '';

                      if (!by_gender) {

                        var male = $('#filter_male').prop('checked');

                        filter_gender = addToList(filter_gender, male, 'male');

                        var female = $('#filter_female').prop('checked');

                        filter_gender = addToList(filter_gender, female, 'female');

                      } else {

                        filter_gender = 'male, female';

                      }



                      var filter_age = '';

                      if (!by_age) {

                        var under5 = $('#filter_under_5').prop('checked');

                        filter_age = addToList(filter_age, under5, 'under_5');

                        var over5 = $('#filter_over_5').prop('checked');

                        filter_age = addToList(filter_age, over5, 'over_5');

                      } else {

                        filter_age = 'under_5, over_5';

                      }



                      var filter_enrollment = '';

                      if (!by_enrollment) {

                        var enrolled = $('#filter_enrolled').prop('checked');

                        filter_enrollment = addToList(filter_enrollment, enrolled, 'enrolled');

                        var non_enrolled = $('#filter_non_enrolled').prop('checked');

                        filter_enrollment = addToList(filter_enrollment, non_enrolled, 'non_enrolled');

                      } else {

                        filter_enrollment = 'enrolled, non_enrolled';

                      }



                      var filter_school_type = '';

                      if (!by_school_type) {

                        var pub = $('#filter_school_public').prop('checked');

                        filter_school_type = addToList(filter_school_type, pub, 'public');

                        var pri = $('#filter_school_private').prop('checked');

                        filter_school_type = addToList(filter_school_type, pri, 'private');

                        var other = $('#filter_school_other').prop('checked');

                        filter_school_type = addToList(filter_school_type, other, 'other');

                      } else {

                        filter_school_type = 'public, private, other';

                      }



                      var filter_treatment_type = '';

                      if (!by_treatment_type) {

                        filter_treatment_type = $('#treatment_type option:selected').val();

                      } else {

                        filter_treatment_type = 'filter_treatment_both';

                      }



                      // query generation

                      if (geography == 'national') {

                        // query schools data only

                        if (level == 'schools') {

                          if (filter_school_type == '') {

                            alert('Please select a school type');

                            return;

                          }



                          // post the info to the server

                          $.post("report_ajax2.php", {
                            retrieve_data: 'retrieve_data',
                            data_flag: 'national_schools_schooltype_treatmenttype',
                            geo: geography,
                            lev: level,
                            school_type: filter_school_type,
                            treatment_type: filter_treatment_type

                          }).done(function(data) {

                            alert(data);

                          });

                        }

                      }

                    }



                    function addToList(list, condition, value) {

                      if (condition == true) {

                        if (list == '') {

                          return value;

                        } else {

                          return list + ', ' + value;

                        }

                      } else {

                        return list;

                      }

                    }



                    function get_district() {

                      var county_data = $('#selectcounty option:selected').text().trim();

                      var value = $('#selectcounty option:selected').val().trim();

                      if (value == '')
                        return;

                      $.post("report_ajax.php", {
                        checkval: 'district',
                        county: county_data

                      }).done(function(data) {

                        $('#selectdistrict').html(data);

                        // alert(data);

                      });

                    }



                    function get_division(txt) {

                      $.post('report_ajax.php', {
                        checkval: 'division',
                        district: txt

                      }).done(function(data) {

                        $('#selectdivision').html(data);

                        //alert(data);

                      });

                    }



                    function get_school(txt) {

                      $.post('report_ajax.php', {
                        checkval: 'school',
                        division: txt

                      }).done(function(data) {

                        $('#selectschool').html(data);

                        // alert(data);

                      });

                    }



                    function selectcounty() {

                      // build the query

                      /*
                       
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
                       
                       $.post('report_ajax.php', {
                       
                       checkval : 'form_s',
                       
                       selectdistrict : selectdistrict,
                       
                       selectdivision : selectdivision,
                       
                       selectschool : selectschool,
                       
                       male : male,
                       
                       female : female,
                       
                       years_2_5 : years_2_5,
                       
                       years_6_10 : years_6_10,
                       
                       years_11_14 : years_11_14,
                       
                       years_15_18 : years_15_18,
                       
                       enrolled : enrolled,
                       
                       nonenrolled : nonenrolled,
                       
                       selectchart : selectchart
                       
                       }).done(function(data) {
                       
                       $('#reportschart').html(data);
                       
                       //alert(data);
                       
                       //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
                       
                       });
                       
                       */

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

<?php
}else{
  header("Location:../../home.php");
}
ob_flush();
?>





