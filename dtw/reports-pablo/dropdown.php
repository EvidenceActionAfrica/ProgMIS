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
                  
        </script>
         


















        <!--================================================-->
      </div><!--end of content Main -->
    </div>
    <div class="clearFix"></div>
    <!---------------- Footer ------------------------>
    <!--<div class="footer">  </div>-->
  </body>
</html>



