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
    <!-- <link rel="stylesheet" type="text/css" href="css/vstyle.css"> -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
          <a href="standardized_reports.php"><li>Standardized Reports</li></a>
          <a href="#"><li>National Reports</li></a>
          <a href="#"><li>District Reports</li></a>
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
        <h3>Export Data</h3>
        <ul>
          <a href="#"><li>Link 1</li></a>
          <a href="#"><li>Link 2</li></a>
          <a href="#"><li>Link 3</li></a>
        </ul>
      </div>
      <div class="contentBody">
        <!--================================================-->















        <?php
        require_once('config/include.php');
        $evidenceaction = new EvidenceAction();
//$evidenceaction->checksession();
//print_r($_SESSION);
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <?php include('config/head.php'); ?>
            <title>Evidence Action :: Standardized Report</title>
          </head>
          <body>

            <div class="wrapperNwp">

              <!---------------- body start ------------------------>

              <div class="rstBdy">
                <div class="inside">
                  <div class="selSec">
                    <label>Choose a District</label>
                    <?php
                    $tablename = 'districts';
                    $fields = 'id, district_name, district_id';
                    $where = '1=1 AND id!=1 ORDER BY district_name asc';
                    $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                    ?>
                    <select id="selectdistrict" name="selectdistrict">
                      <option value="2012004">Bomet</option>
                      <?php foreach ($insertformdata as $insertformdatacab) { ?>
                        <option value="<?php echo $insertformdatacab['district_id']; ?>"><?php echo $insertformdatacab['district_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <input name="generate_report" type="button" value="Generate Report" class="genBtn" onclick="selectcounty();" />
                  <!--<p class="hthtxt cnts">Country Indicators : Pie Chart</p>
                  <div class="chrtSec"><img src="images/pieChrt.jpg" alt="" /></div>-->

                  <div id="reportschart" style="float:left"></div>
                  <div id="reportschartage" style="float:left"></div>
                  <div id="reportschartsex" style="float:left"></div>
                  <!--<div id="reportschartstats" style="float:left"></div>-->
                </div>
              </div>
              <!---------------- body end ------------------------>
            </div>
          </body>
        </html>
        <script>
            //GET district
            function selectcounty() {
              $('#reportschart').html('');
              $('#reportschartage').html('');
              //var urlmn = '?checkval=form_s_pdf';
              //alert($("#selectdistrict").val());
              if ($("#selectdistrict").val() != '') {
                var selectdistrict = $("#selectdistrict").val();
                //urlmn += '&selectdistrict=selectdistrict';
              } else {
                var selectdistrict = '';
              }
              $.post('report_ajax.php', {checkval: 'standardized_report_enrolled', selectdistrict: selectdistrict}).done(function(data) {
                $('#reportschart').html(data);//alert(data);
                //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
              });
              $.post('report_ajax.php', {checkval: 'standardized_report_age', selectdistrict: selectdistrict}).done(function(data) {
                $('#reportschartage').html(data);//alert(data);
                //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
              });
              $.post('report_ajax.php', {checkval: 'standardized_report_sex', selectdistrict: selectdistrict}).done(function(data) {
                $('#reportschartsex').html(data);//alert(data);
                //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
              });
              $.post('report_ajax.php', {checkval: 'standardized_report_stats', selectdistrict: selectdistrict}).done(function(data) {
                $('#reportschartstats').html(data);//alert(data);
                //$('#downid').attr('href','generate_report_pdf.php'+urlmn);
              });
            }
        </script>	
        <script src="js/highcharts.js"></script>
        <script src="js/modules/exporting.js"></script>
        <script src="js/modules/data.js"></script>
        <script src="js/modules/drilldown.js"></script>
        <div id="containerenrolled" style="margin: 0 auto;min-width: 300px;" class="chartdraw"></div>
        <div id="containerage" style="margin: 0 auto;min-width: 300px;" class="chartdraw"></div>
        <div id="containersex" style="margin: 0 auto;min-width: 300px;" class="chartdraw"></div>
        <div id="reportschartstats" style="margin: 0 auto;min-width: 300px;" class="chartdraw"></div>
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



