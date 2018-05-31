<?php
ob_start();
require_once ("../../includes/auth.php");
require_once ('../../includes/config.php');
// require_once ('config/config.php');
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
  $priv_standard_reports = $row['priv_standard_reports'];
}
if ($priv_standard_reports >= 1) {
  ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <title>Evidence Action</title>
      <?php require_once ("includes/meta-link-script.php"); ?>
    </head>
    <body>
      <!-- header start-->
      <div class="header">
        <div style="float: left">  <img src="../../images/logo.png" />  </div>
        <div class="menuLinks">
          <?php require_once ("includes/menuNav.php"); ?>
        </div>
      </div>
      <div class="clearFix"></div>
      <!-- content body-->
      <div class="contentMain">
        <div class="contentLeft">
          <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?>
        </div>
        <div class="contentBody">
          <div class="wrapperNwp">
            <div id="vzoom">
              <!-- <button class="vzoom-level btn-custom-small" onclick="vzoom('0.3','1516px');">40% zoom</button> -->
              <!-- <button class="vzoom-level btn btn-primary" onclick="zoom_national_report('0.4','50%');">40% zoom</button>
              <button class="vzoom-level btn btn-primary" onclick="zoom_national_report('0.6','70%');">50% Zoom</button>
              <button class="vzoom-level btn btn-primary" onclick="zoom_national_report('0.7','80%');">70% Zoom</button> -->
              <script type="text/javascript">
                // function zoom_national_report(z,w){
                // document.getElementById("national_report_container").style.zoom=z;
                // // document.getElementById("national_report_container").style['MozTransform']="scale("+z+")";
                // document.getElementById("national_report_container").style.width=w;
                // document.getElementById("national_report_container").style.margin="0 auto";
                // }
              </script>
              <div class="vclear"></div>
              <div id="donor-form">
                <form action="national_donor_report.php" method="get">
                  <select id="donor-dropdown" name="donor">
                    <option value="CIFF">ALL</option>
                    <option value="CIFF">CIFF</option>
                    <option value="END">END FUND</option>
                  </select>
                  <input type="hidden" id="donor_value" name="donor_value" value="<?php
                  if (isset($_GET['donor'])) {
                    echo $_GET['donor'];
                  } else {
                    echo 'CIFF';
                  }
                  ?>">
                  <input id="donor-submit"class="btn btn-primary"type="submit" name="donor_submit" value="CHOOSE DONOR" >
                </form>
              </div>

              <!--End donor form-->
            </div>
            <div class="vclear"></div>
            <div class="rstBdy-national">
              <div class="inside-national">
                <div id="national_report_container">
                  <?php include("report_national_header.php") ?>
                  <p class="section_header">
                    Programme Coverage Summary for Soil-Transmitted Helminths (STH) Treatment
                  </p>
                  <div id="top_line_container">
                    <p class="line_text">
                      100%
                    </p>
                    <div id="top_line_mark" style="display: block"></div>
                  </div>
                  <div class="national_section_row_container">
                    <div class="column_left">
                      <div id="sth1_percentage_container">
                        <div id="sth1_percentage_value"></div>
                      </div>
                    </div>
                    <div class="national_column">
                      <div class="info_container">
                        <ul>
                          <li id="sth1_info_title"></li>
                          <li id="sth1_info_title_sub"></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="national_section_row_container">
                    <div class="column_left">
                      <div id="sth2_percentage_container">
                        <div id="sth2_percentage_value"></div>
                      </div>
                    </div>
                    <div class="national_column">
                      <div class="info_container">
                        <ul>
                          <li id="sth2_info_title"></li>
                          <li id="sth2_info_title_sub"></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="national_section_row_container">
                    <div class="column_left">
                      <div id="sth3_percentage_container">
                        <div id="sth3_percentage_value"></div>
                      </div>
                    </div>
                    <div class="national_column">
                      <div class="info_container">
                        <ul>
                          <li id="sth3_info_title">
                          <li id="sth3_info_title_sub"></li>
                          <!-- 112 districts successfully completed the program, -->
                          </li>
                          <li id="sth3_info_title_sub">
                            <!-- surpassing our target of 110 districts. -->
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <p class="section_header">
                    Programme Coverage Summary for Schistosomiasis Treatment
                  </p>
                  <div id="bottom_line_container">
                    <p class="line_text">
                      100%
                    </p>
                    <div id="bottom_line_mark"></div>
                  </div>
                  <div class="national_section_row_container">
                    <div class="column_left">
                      <div id="sth4_percentage_container">
                        <div id="sth4_percentage_value"></div>
                      </div>
                    </div>
                    <div class="national_column">
                      <div class="info_container">
                        <ul>
                          <li id="sth4_info_title">
                            191,318 children were dewormed
                          </li>
                          <li id="sth4_info_title_sub">
                            targeted 196,198 children
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="national_section_row_container">
                    <div class="column_left">
                      <div id="sth5_percentage_container">
                        <div id="sth5_percentage_value"></div>
                      </div>
                    </div>
                    <div class="national_column">
                      <div class="info_container">
                        <ul>
                          <li id="sth5_info_title">
                            14 districts successfully completed the programme,
                          </li>
                          <li id="sth5_info_title_sub">
                            surpassing our target of 12 districts.
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div id="content_left" class="content">
                    <p class="section_header">
                      STH Treatment Analysis
                    </p>
                    <div id="sth_pie_container">
                      <div id="sth_enrollment_container" class="sth_pie_style"></div>
                      <canvas width="180" height="400" id="sth_enrollment_container_canvas" class="sth_canvas_style"></canvas>
                      <div id="sth_age_container" class="sth_pie_style" ></div>
                      <canvas width="180" height="400" id="sth_age_container_canvas" class="sth_canvas_style"></canvas>
                      <div id="sth_sex_container" class="sth_pie_style"></div>
                      <canvas width="180" height="400"id="sth_sex_container_canvas" class="sth_canvas_style"></canvas>
                    </div>
                  </div>
                  <div id="chart_separator"></div>
                  <div id="content_right" class="content">
                    <p class="section_header">
                      Schistosomiasis Treatment Analysis 
                    </p>
                    <div id="schi_pie_container">
                      <div id="schi_enrollment_container" class="schi_pie_style"></div>
                      <canvas width="200" height="400" id="schi_enrollment_container_canvas" class="schi_canvas_style"></canvas>
                      <div id="schi_sex_container" class="schi_pie_style"></div>
                      <canvas width="200" height="400" id="schi_sex_container_canvas" class="schi_canvas_style"></canvas>
                    </div>
                  </div>
                  <p class="section_header">
                    National Deworming Facts at a Glance
                  </p>
                  <div id="table_holder"></div>
                  <div id="editor"></div>
                  <button name="export" class="genBtn" value="export" id="export_button" onclick="exportOutput();">
                    Preview PDF Report
                  </button>
                </div>
                <!--================================================-->
              </div>
            </div>
          </div><!--end of content body -->
        </div><!--end of wrapperNwp -->
      </div><!--end of content Main -->
      <div class="clearFix"></div>
      <!---------------- Footer ------------------------>
      <!--<div class="footer">  </div>-->
    </body>
  </html>
  <script>
                function svgToCanvas(container) {
                  // get the highcharts svg content
                  var svg = $('#' + container + ' .highcharts-container').html();
                  // get the canvas
                  var canvas = document.getElementById(container + '_canvas').getContext('2d');
                  // draw the svg to the screen
                  canvas.drawSvg(svg);
                  // show the canvas and hide the svg
                  $('#' + container + '_canvas').css('display', 'block');
                  $('#' + container + '_canvas').css('float', 'left');
                  $('#' + container).css('display', 'none');
                }
                function exportOutput() {
                  // victor
                  // return to original zoom
                  document.getElementById("national_report_container").style.zoom = "1";
                  document.getElementById("national_report_container").style.width = "100%";
                  // hide the dashes for the bar chart
                  $('#top_line_mark').hide();
                  $('#bottom_line_mark').hide();
                  
                  // hide the button
                  $('#export_button').css('display', 'none');
                  svgToCanvas('sth_enrollment_container');
                  svgToCanvas('sth_age_container');
                  $('#sth_age_container_canvas').css('margin-top', '0px');
                  svgToCanvas('sth_sex_container');
                  svgToCanvas('schi_enrollment_container');
                  svgToCanvas('schi_sex_container');
                  // change the widths of the top and bottom line marks
                  // $('#top_line_mark').css('border', '1px dashed blue');
                  // $('#bottom_line_mark').css('border', '1px dashed blue');
                  html2canvas($('#national_report_container'), {
                    onrendered: function(canvas) {
                      var canvasImg = canvas.toDataURL("image/jpeg");
                      var doc = new jsPDF('portrait', 'mm', 'a3');
                      doc.addImage(canvasImg, 'JPEG', 5, 0, 284, 417);
                      doc.output('dataurlnewwindow');
                    }
                  });
                }
                $(document).ready(function() {
                  // show the column classes
                  $('.column_left').css('visibility', 'visible');
                  // create school participated data
                  $.post("national_ajax.php", {
                    national_bar_data: 'bar_data',
                    info_type: 'schools_participated'
                  }).done(function(data) {
                    console.log(data);
                    var contents = data.split(",");
                    if (contents.length == 2) {
                      var clause = 'out of our goal of ' + contents[1] + ' schools.';
                      if (+contents[0] > +contents[1]) {
                        clause = 'surpassing out goal of ' + contents[1] + ' schools!';
                      }
                      createBar('#sth1_percentage_container', '#sth1_percentage_value', contents[0], contents[0] + ' schools participated,', '#sth1_info_title', contents[1], clause, '#sth1_info_title_sub');
                    }
                  });
                  // create dewormed data
                  $.post("national_ajax.php", {
                    national_bar_data: 'bar_data',
                    info_type: 'children_dewormed'
                  }).done(function(data) {
                    var contents = data.split(",");
                    if (contents.length == 2) {
                      var clause = ' our goal of ' + contents[1] + ' children';
                      if (+contents[0] > +contents[1]) {
                        clause = ' surpassing' + clause + '!';
                      } else {
                        clause = clause + '.';
                      }
                      createBar('#sth2_percentage_container', '#sth2_percentage_value', contents[0], contents[0] + ' children were dewormed,', '#sth2_info_title', contents[1], clause, '#sth2_info_title_sub');
                    }
                  });
                  // create district bar data
                  $.post("national_ajax.php", {
                    national_bar_data: 'bar_data',
                    info_type: 'districts_completed'
                  }).done(function(data) {
                    var contents = data.split(",");
                    if (contents.length == 2) {
                      var clause = 'out of our target of ' + contents[1] + ' districts';
                      if (+contents[0] > +contents[1]) {
                        clause = ' surpassing our goal of ' + contents[1] + ' districts!';
                      } else {
                        clause = clause + '.';
                      }
                      createBar('#sth3_percentage_container', '#sth3_percentage_value', contents[0], contents[0] + ' districts were dewormed,', '#sth3_info_title', contents[1], clause, '#sth3_info_title_sub');
                    }
                  });
                  // create bar 4 data
                  $.post("national_ajax.php", {
                    national_bar_data: 'bar_data',
                    info_type: 'children_dewormed_schi'
                  }).done(function(data) {
                    var contents = data.split(",");
                    if (contents.length == 2) {
                      var clause = 'out of ' + contents[1] + ' targeted children.';
                      if (+contents[0] > +contents[1]) {
                        clause = ' surpassing our target of ' + contents[1] + ' children!';
                      }
                      createBar('#sth4_percentage_container', '#sth4_percentage_value', contents[0], contents[0] + ' children were dewormed,', '#sth4_info_title', contents[1], clause, '#sth4_info_title_sub');
                    }
                  });

                  // create bar 4 data
                  $.post("national_ajax.php", {
                    national_bar_data: 'bar_data',
                    info_type: 'districts_completed_schi'
                  }).done(function(data) {
                    var contents = data.split(",");
                    if (contents.length == 2) {
                      var clause = 'out of ' + contents[1] + ' targeted children.';
                      if (+contents[0] > +contents[1]) {
                        clause = ' surpassing our target of ' + contents[1] + ' districts!';
                      }
                      createBar('#sth5_percentage_container', '#sth5_percentage_value', contents[0], contents[0] + ' districts were dewormed,', '#sth5_info_title', contents[1], clause, '#sth5_info_title_sub');
                      // setBar('#sth5_percentage_container', '#sth5_percentage_value', 117);
                    }
                  });
                  // set the pie charts data
                  // STH Treatment Analysis
                  // enrollment status
                  $.post("national_ajax.php", {
                    national_data: 'national_data',
                    data_type: 'sth_enrollment'
                  }).done(function(data) {
                    createChart('#sth_enrollment_container', 'Enrollment', 'Enrolled', 'Non-enrolled', data, 'sth');
                  });

                  // age bracket
                  $.post("national_ajax.php", {
                    national_data: 'national_data',
                    data_type: 'sth_age'
                  }).done(function(data) {
                    createChart('#sth_age_container', 'Age Bracket', '5 and under', 'Over 5', data, 'sth');
                  });
                  // sex
                  $.post("national_ajax.php", {
                    national_data: 'national_data',
                    data_type: 'sth_sex'
                  }).done(function(data) {
                    createChart('#sth_sex_container', 'Sex', 'Male Gender', 'Female Gender', data, 'sth');
                  });

                  // Schistosomiasis Treatment Analysis
                  // enrollment status
                  $.post("national_ajax.php", {
                    national_data: 'national_data',
                    data_type: 'schi_enrollment'
                  }).done(function(data) {
                    createChart('#schi_enrollment_container', 'Enrollment', 'Enrolled', 'Non-enrolled', data, 'schi');
                  });

                  // sex
                  $.post("national_ajax.php", {
                    national_data: 'national_data',
                    data_type: 'schi_sex'
                  }).done(function(data) {
                    createChart('#schi_sex_container', 'Sex', 'Male Gender', 'Female Gender', data, 'schi');
                    $('#schi_sex_container').css('margin-top', '0px');
                  });

                  // setBar('#sth2_percentage_container', '#sth2_percentage_value', 119);
                  // setBar('#sth3_percentage_container', '#sth3_percentage_value', 102);
                  // setBar('#sth4_percentage_container', '#sth4_percentage_value', 98);
                  // setBar('#sth5_percentage_container', '#sth5_percentage_value', 117);
                  $.post("national_ajax.php", {
                    national_table_data: "national"
                  }).done(function(data) {
                    // alert(data);
                    $('#table_holder').html(data);
                    $('#export_button').css('display', 'inline-block');
                  });
                });
                function createChart(container, title, label1, label2, data, treatment) {
                  var contents = data.split(",");
                  if (contents.length != 2) {
                    $(container).html('<h3 id="data_error">No data found</h3>');
                    return;
                  }

                  var chartWidth = 190;
                  var chartHeight = 300;

                  if (treatment == 'schi') {
                    var chartWidth = 200;
                    var chartHeight = 300;
                  }

                  var data1 = +contents[0];
                  var data2 = +contents[1];
                  var total = data1 + data2;

                  if (total == 0) {
                    $(container).html('<h3 id="data_error">No data found</h3>');
                    return;
                  }

                  data1 = (data1 / total * 100.0).toFixed(0);
                  data2 = (data2 / total * 100.0).toFixed(0);

                  $(container).highcharts({
                    // legend: {
                    //           align: 'right',
                    //           verticalAlign: 'top',
                    //           x: 0,
                    //           y: 100
                    //       },
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      width: chartWidth,
                      height: chartHeight
                    },
                    title: {
                      text: title
                    },
                    colors: ["#F58427", "#FABF8F"],
                    tooltip: {
                      formatter: function() {
                        var value = (this.percentage / 100 * total).toFixed(0);
                        return '<b style="font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number: <b>' + value + '</b><br />Total: <b>' + total + '</b>';
                        // return this.series.name + '<b>' + (names.toFixed(1)) + '</b> ';
                      },
                      // pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
                      backgroundColor: '#FFF',
                      borderColor: '#000',
                      hideDelay: 0
                    },
                    xAxis: {
                      categories: [label1, label2]
                    },
                    exporting: {
                      enabled: false
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          distance: -35,
                          color: 'black',
                          format: '<b style="font-weight: normal; font-size: 1.2em;">{point.y:.0f}%</b>'
                        },
                        showInLegend: true
                      }
                    },
                    series: [{
                        type: 'pie',
                        name: title,
                        data: [[label1, +data1], [label2, +data2]]
                      }]
                  });
                }
                function createBar(percentageContainer, percentageValue, data1, label1, holder1, data2, label2, holder2) {
                  var barPercentage = (data1 / data2 * 100.0).toFixed(0);
                  setBar(percentageContainer, percentageValue, barPercentage);
                  $(holder1).html(label1);
                  $(holder2).html(label2);
                }
                function setBar(mainContainer, percentageContainer, percentage) {
                  $(mainContainer).css('visibility', 'visible');
                  // var newWidth = parseInt(percentage  / $(mainContainer).width()  * 100.0);
                  var divWidth = percentage;
                  if (divWidth > 100) {
                    divWidthExcess = divWidth - 100;
                    divWidthExcessDivided = divWidthExcess / 10;
                    divWidth = 100 + divWidthExcessDivided;
                  }

                  $(percentageContainer).animate({
                    width: divWidth + '%'
                  }, 500);
                  $(percentageContainer).html(percentage + '%');
                }
  </script>
  <?php
} else {
  header("Location:../../home.php");
}
ob_flush();
?>