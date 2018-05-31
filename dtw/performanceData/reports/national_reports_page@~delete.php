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



            
            <div style="background: white">
              
              <h2>Kenya National School-Based Deworming Programme</h2>
              
              
              <div style="float: left;">
                <table>
                  
                </table>
              </div>
              
              <div style="float: right">
                rightqwer
              </div>
            </div>
             <div style="clear: both"></div>
            







            <!--
                        <table border="1">
                          <tr>
                            <td>Bomet<td>
                            <td>Bomet<td>
                            <td><td>
                            <td><td>
                          <tr>
                          <tr>
                            <td>Chepalungu<td>
                            <td>Chepalungu<td>
                            <td><td>
                            <td><td>
                          <tr>
                          <tr>
                            <td>Konoin<td>
                            <td>Konoin<td>
                            <td><td>
                            <td><td>
                          <tr>
                          <tr>
                            <td>Sotik<td>
                            <td>Sotik<td>
                            <td><td>
                            <td><td>
                          <tr>
                        </table>-->
            <div style="clear: both"></div>
            <br/>
            <br/>
            <br/>
            <!--=================-->
            <table border="1">
              <tr>
                <td rowspan="4">Bomet</td>
                <td>Bomet</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Chepalungu</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Konoin</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Sotik</td>
                <td></td>
                <td></td>
              </tr>
            </table>
            <br/>
            <!---------------->
            <table border="1">
              <tr>
                <td rowspan="10">Bomet</td>
                <td>Bomet</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Chepalungu</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Konoin</td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Sotik</td>
                <td></td>
                <td></td>
              </tr>
            </table>



            <table class="table table-hover table-stripped">
              <tr>
                <th>County</th>
                <th>District name</th>
                <th>Children Dewormed<br/>STH</th>
                <th>Children Dewormed<br/> (Schisto)</th>
                <th>Deworming date</th>
              </tr>
            </table>



            <table border="1">
              <?php
              $sql = 'SELECT DISTINCT county FROM districts';
              $resultA = mysql_query($sql);
              while ($row = mysql_fetch_array($resultA)) {
                echo $county = $row["county"];
                $resNum = mysql_query("SELECT district_name FROM districts where county = '$county' ");
                $colspan_to_use = mysql_num_rows($resNum);
                ?>
                <tr height="0px">
                  <td rowspan="<?php echo $colspan_to_use+1; ?>"><?php echo $county; ?></td>
                  <td></td>
                  <td></td>
                  <td rowspan="<?php echo $colspan_to_use+1; ?>">3</td>
                  <td></td>
                </tr>

                <?php
                $result2 = mysql_query("SELECT * FROM districts where county = '$county' ");
                while ($row2 = mysql_fetch_array($result2)) {
                  ?>
                  <tr>
                    <td><?php echo $row2["district_name"]; ?></td>
                    <td>23</td>
                    <td>323</td>
                  </tr>

                <?php } ?>

 


                <?php
//              echo "<tr>";
//              echo "<td>" . $county . "</td>";
//              echo "<td>" . $row["district_name"] . "</td>";
//              echo "<td>" . $num_rows . "</td>";
//              echo "<td>" . $row["STH"] . "</td>";
//              echo "<td>" . $row["SCH"] . "</td>";
//              echo "<td>" . $row["s_deworming_day"] . "</td>";
//              echo "</tr>";
              }
              ?>

            </table>










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
      //$('#top_line_mark').hide();
      //$('#bottom_line_mark').hide();

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

      function commaSeparateNumber(val) {
        while (/(\d+)(\d{3})/.test(val.toString())) {
          val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
        }
        return val;
      }
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
          // var clause = 'out of our goal of ' + contents[1] + ' schools.';
          // making it static for now
          var clause = 'out of our target of 11,000‏ schools.';
          if (+contents[0] > +contents[1]) {
            // clause = 'surpassing out goal of ' + contents[1] + ' schools!';
            // clause = 'surpassing out goal of 11,000‏ schools!';
            var clause = 'out of our target of 11,000‏ schools.';
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
          // var clause = ' our goal of ' + contents[1] + ' children';
          var clause = ' out of our target of 5,700,000 children';
          if (+contents[0] > +contents[1]) {
            // clause = ' surpassing 5,700,000 !';
            var clause = ' out of our target of 5,700,000 children';
            // clause = ' surpassing' + clause + '!';
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
          // var clause = 'out of our target of ' + contents[1] + ' districts';
          var clause = 'out of our target of 144 districts';
          if (+contents[0] > +contents[1]) {
            // clause = ' surpassing our goal of 144 districts!';
            var clause = 'out of our target of 144 districts';
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
          // var clause = 'out of ' + contents[1] + ' targeted children.';
          var clause = 'out of 600,000‏ targeted children.';
          if (+contents[0] > +contents[1]) {
            // clause = ' surpassing our target of 600,000‏ children!';
            var clause = 'out of 600,000‏ targeted children.';
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
          // var clause = 'out of ' + contents[1] + ' targeted districts.';
          var clause = 'out of 64 targeted districts.';
          if (+contents[0] > +contents[1]) {
            // clause = ' surpassing our target of ' + contents[1] + ' districts!';
            // clause = ' surpassing our target of 64 districts!';
            var clause = 'out of 64 targeted districts.';
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
        // createChart('#sth_sex_container', 'Sex', 'Male Gender', 'Female Gender', data, 'sth');
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

    function commaSeparateNumber(val) {
      while (/(\d+)(\d{3})/.test(val.toString())) {
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
      }
      return val;
    }

    function createBar(percentageContainer, percentageValue, data1, label1, holder1, data2, label2, holder2) {
      var barPercentage = (data1 / data2 * 100.0).toFixed(0);
      setBar(percentageContainer, percentageValue, barPercentage);
      $(holder1).html(commaSeparateNumber(label1));
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