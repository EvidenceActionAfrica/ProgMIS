<?php
require_once ("../../includes/auth.php");
require_once ('../../includes/config.php');
require_once ("includes/include.php"); //includes the class EvidenceAction

$evidenceaction = new EvidenceAction();

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_standard_reports = $row['priv_standard_reports'];
}

if ($priv_standard_reports >= 1) {
    ?>

    <!DOCTYPE html>
    <head>
        <title>Evidence Action</title>
        <?php require_once ("includes/meta-link-script.php"); ?> </head>
    <body>
        <!---------------- header start ------------------------>
        <div class="header">
            <div style="float: left">
                <img src="../../images/logo.png" />
            </div>
            <div class="menuLinks">
                <?php require_once ("includes/menuNav.php"); ?>
            </div>
        </div>
        <div class="clearFix"></div>
        <!---------------- content body ------------------------>
        <div class="contentMain">
            <div class="contentLeft">
                <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?> </div>
            <div class="contentBody">
                <!--================================================-->
                <div class="contentMain">
                    <div class="contentBody">
                        <!--================================================-->
                        <div class="wrapperNwp">
                            <div id="vzoom">
                                <!-- <button class="vzoom-level btn-custom-small" onclick="vzoom('0.3','1516px');">40% zoom</button> -->
                                <!-- <button class="vzoom-level btn btn-primary" onclick="zoom_district_report('0.4','50%');">Normal</button>
                                <button class="vzoom-level btn btn-primary" onclick="zoom_district_report('0.6','70%');">50% Zoom</button>
                                <button class="vzoom-level btn btn-primary" onclick="zoom_district_report('0.7','80%');">70% Zoom</button> -->
                            </div>	

                            <script type="text/javascript">

                                function zoom_district_report(z, w) {
                                    document.getElementById("report_container").style.zoom = z;
                                    // document.getElementById("national_report_container").style['MozTransform']="scale("+z+")";
                                    document.getElementById("report_container").style.width = w;
                                    document.getElementById("report_container").style.margin = "0 auto";
                                }

                            </script>

                            <div class="vclear"></div>
                            <div id="rstBdy" class="rstBdy">
                                <div class="inside" style="overflow: auto; margin-bottom: 20px;">
                                    <div class="alert alert-danger" >
                                        Reload the page <a href="" class="bold-undeline">HERE</a> before generating a new report.
                                    </div>
                                    <div class="selSec">
                                        <label>Sub-County</label>
                                        <?php
                                        $tablename = 'districts';
                                        $fields = 'id, district_name, district_id';
                                        $where = '1=1 AND id!=1 ORDER BY district_name ASC';
                                        $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                                        ?>
                                        <select id="selectdistrict" name="selectdistrict" onChange="loadCountyName();">
                                            <option value="">-----------</option>
                                            <?php
                                            foreach ($insertformdata as $insertformdatacab) {
                                                echo "<option value=\"$insertformdatacab[district_id]\">$insertformdatacab[district_name]</option>";
                                            }
                                            ?>                                            
                                        </select>

                                        <input type="text" id="county_name" style="visibility: hidden; width: 2px"/>

                                        <label id="treatment_container">Select treatment</label>
                                        <select id="treatment_type" name="treatment_type">
                                            <option value="albe">Albendazole </option>
                                            <option value="schisto">Praziquantel</option>
                                        </select>
                                        <input style="background: #F14E6C;" id="generate_button" name="generate_repor" type="button" value="Generate Report" class="btn btn-primary" onClick="selectcounty();" />
                                    </div>

                                    <div class="vclear"></div>
                                    <div id="append-here"></div>
                                    <div id="warning_no_data">
                                        <div class="alert info"><span class="icon"></span><span class="hide">x</span><strong>Information</strong> No treatment data available currently. Please check with MLIS team.</div>
                                        <p></p>
                                    </div>
                                    <div id="report_container"> <!-- #add here-->
                                        <?php include("report_district_header.php") ?>
                                        <div class="section_header" id="programme_title"></div>

                                        <div id="top_line_container_county">
                                            <p class="line_text">
                                                100%
                                            </p>
                                            <div id="top_line_mark_county" style="display: block"></div>
                                        </div>


                                        <div class="section_row_container">
                                            <div class="column">
                                                <div id="dewormed_percentage_container">
                                                    <div id="dewormed_percentage_value"></div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="info_container" style="height: 70px">
                                                    <ul>
                                                        <li id="dewormed_info_title"> 25,588 children were dewormed </li>
                                                        <li id="dewormed_info_title_sub">  out of 33,340 targeted.  </li>
                                                        <li id="dewormed_info_subtitle">
                                                            70% of enrolled primary children were treated
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="section_row_container">
                                            <div class="column">
                                                <div id="treated_percentage_container">
                                                    <div id="treated_percentage_value"></div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="info_container" style="height: 70px">
                                                    <ul>
                                                        <li id="treated_info_title">65 primary schools were treated  </li>
                                                        <li id="treated_info_title_sub"> out of 65 targeted. </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div id="bypassme"></div>
                                        <div class="section_header" id="analysis_title"></div>
                                        <div id="containerenrolled" class="chartdraw"></div>
                                        <div id="containerage"  class="chartdraw"></div>
                                        <div id="containersex" class="chartdraw"></div>
                                        <div id="pi_container">
                                            <div id="reportschart_enrolled" class="report_style"></div>
                                            <canvas id="reportschart_enrolled_canvas" class="report_canvas_style" width="270" height="400" style="padding-left: 13px; display: none;"></canvas>
                                            <div id="reportschart_age" class="report_style"></div>
                                            <canvas id="reportschart_age_canvas" class="report_canvas_style" width="270" height="400" style="padding-left: 13px; display: none;"></canvas>
                                            <div id="reportschart_sex" class="report_style"></div>
                                            <canvas id="reportschart_sex_canvas"  class="report_canvas_style" width="270" height="400" style="padding-left: 13px; display: none;"></canvas>
                                        </div>
                                        <div class="section_header">
                                            Sub-County Deworming Facts at a Glance
                                        </div>
                                        <div id="reportschartstats" class="chartdraw"></div>
                                        <br/>
                                        <div id="output"></div>
                                        <button name="export" class="genBtn" value="export" id="export_button" onClick="exportOutput();">
                                            Preview PDF Report
                                        </button>
                                        <br><br>

                                        <div style="font-size: 25px; color:#205677; padding: 20px 20px 20px 20px; font-style: italic ">
                                            Kwa Afya na Elimu Bora, Tuangamize Minyoo!</div>
                                        In partnership with:<br><!--<img src="images/logofooter1.jpg" alt="footer logo" height="50px" style="margin-left: 50px">-->
                                        <img src="images/logofooter2.png" alt="footer logo" height="50px" style="margin-left: 50px">
                                        <img src="images/logofooter3.jpg" alt="footer logo" height="50px" style="margin-left: 190px">
                                        <img src="images/logofooter4.jpg" alt="footer logo" height="50px" style="margin-left: 120px">                                    </div>

                                </div>
                            </div>
                        </div>
                    </div><!--end of content Main -->
                </div>
                <!--================================================-->
            </div><!--end of content Main -->
        </div>
        <div class="clearFix"></div>
        <!---------------- Footer ------------------------->
        <!--<div class="footer"></div>-->
    </body>
    </html>

    <!-------------------------------------- js codez -------------------------------->
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
                                    document.getElementById("report_container").style.zoom = "1";
                                    document.getElementById("report_container").style.width = "100%";
                                    // document.getElementById("rstBdy").style.width="120%";

                                    //convert each chart to canvas
                                    $('#export_button').css('display', 'none');

                                    // hide the age when rendering the pdf
                                    var treatment_type = $('#treatment_type').val();
                                    if (treatment_type == 'albe') {
                                        svgToCanvas('reportschart_age');
                                    }
                                    ;
                                    svgToCanvas('reportschart_enrolled');
                                    svgToCanvas('reportschart_sex');

                                    html2canvas($('#report_container'), {
                                        onrendered: function(canvas) {
                                            var canvasImg = canvas.toDataURL("image/jpeg");
                                            var doc = new jsPDF('portrait', 'mm', 'a4');
                                            doc.addImage(canvasImg, 'JPEG', 3, 5, 204, 260);
                                            doc.output('dataurlnewwindow');
                                        }
                                    });
                                }


                                //GET district
                                function selectcounty() {
                                    var selectdistrict = $("#selectdistrict").val(); //get the district selected
                                    var treatment_type = $('#treatment_type').val(); //get the treatement gottten
                                    console.log("selectdistrict = ".selectdistrict);
                                    //check if what has been gotten is in the database
                                    // if not display the warning info
                                    $.post("func.DistrictReport.php", {
                                        check_district: 'check_district',
                                        district_id: selectdistrict,
                                        treatment: treatment_type
                                    }).done(function(data) {
                                        console.log(data);
                                        console.log("Happy Cow");

                                        if (data == 0) {
                                            console.log("hidden");
                                            //if no data hide the chart div and show the warning div
                                            $('#report_container').hide();
                                            $('#warning_no_data').show();

                                        } else {

                                            // hide the warning data if it was displayed
                                            $('#warning_no_data').hide();
                                            var district_name = $('#selectdistrict option:selected').text().trim();
                                            var county_name = document.getElementById('county_name').value;

                                            if (treatment_type == 'albe') {
                                                $('#report_subtitle_treatment1').html('Sub-County Soil-Transmitted Helminthes Treatment Results');
                                                $('#report_subtitle_treatment').html(district_name + ' Sub-County, ' + county_name + ' County');
                                                // $('#report_subtitle_name').html( district_name+' District');
                                                // set the programme 
                                                $('#programme_title').html('Programme Coverage Summary for STH Treatment');
                                                $('#analysis_title').html('STH Treatment Analysis');
                                                $('#report_subtitle_treatment_sumary').html('Annual coverage report for the treatment of soil-transmitted helminthiases (STH or common worms) with Albendazole at Kenyan primary schools between April 2014 and June 2015');

                                            } else {
                                                $('#report_subtitle_treatment1').html('Sub-County Schistosomiasis Treatment Results');
                                                $('#report_subtitle_treatment').html(district_name + ' Sub-County, ' + county_name + ' County');
                                                // $('#report_subtitle_name').html( district_name+' District');
                                                // set the programme 
                                                $('#programme_title').html('Programme Coverage Summary for Schistosomiasis Treatment');
                                                $('#analysis_title').html('Schistosomiasis Treatment Analysis');
                                                $('#report_subtitle_treatment_sumary').html('Annual coverage report for the treatment of schistosomiasis with praziquantel at Kenyan primary schools between April 2014 and June 2015');
                                                
                                            }


                                            var treatment = $('#treatment_type option:selected').text();
                                            var selectdistrict = $("#selectdistrict").val();
                                            $('#report_container').fadeIn(400);

                                            if (selectdistrict != '') {
                                                $('#reportschart_enrolled').html('');
                                                $('#reportschart_age').html('');
                                                $('#reportschart_sex').html('');
                                                $('.column').css('visibility', 'hidden');

                                                // set the programme and analysis titles text

                                                $('#dewormed_percentage_container').css('visibility', 'hidden');
                                                $('#treated_percentage_container').css('visibility', 'hidden');
                                                $('#dewormed_percentage_value').css('visibility', 'hidden');
                                                $('#treated_percentage_value').css('visibility', 'hidden');

                                                $('#report_container').css('visibility', 'visible');
                                                $('#report_container').hide().fadeIn(400);

                                                $.post("district_ajax.php", {
                                                    progress_data: 'dewormed',
                                                    district_id: selectdistrict,
                                                    treatment: treatment_type
                                                }).done(function(data) {
                                                    // alert(data);
                                                    setDewormed(data);
                                                });


                                                $.post("district_ajax.php", {
                                                    progress_data: 'treated',
                                                    district_id: selectdistrict,
                                                    treatment: treatment_type
                                                }).done(function(data) {
                                                    setTreated(data);
                                                    $('.column').css('visibility', 'visible');
                                                });

                                                // request enrolled information
                                                $.post("district_ajax.php", {
                                                    request_data: 'request',
                                                    data_type: 'enrolled',
                                                    district_id: selectdistrict,
                                                    treatment: treatment_type
                                                }).done(function(data) {
                                                    // alert(data);
                                                    createChart(data, 'reportschart_enrolled', '#reportschart_enrolled', treatment_type);
                                                });


                                                if (treatment_type == 'albe') {
                                                    $.post("district_ajax.php", {
                                                        request_data: 'request',
                                                        data_type: 'age',
                                                        district_id: selectdistrict,
                                                        treatment: treatment_type
                                                    }).done(function(data) {
                                                        // alert(data);
                                                        createChart(data, 'age', '#reportschart_age', treatment_type);
                                                    });
                                                }

                                                $.post("district_ajax.php", {
                                                    request_data: 'request',
                                                    data_type: 'sex',
                                                    district_id: selectdistrict,
                                                    treatment: treatment_type
                                                }).done(function(data) {
                                                    createChart(data, 'sex', '#reportschart_sex', treatment_type);
                                                    // alert(data);
                                                });

                                                $.post("district_ajax.php", {
                                                    tag_get_data: 'get_data',
                                                    district_id: selectdistrict,
                                                    district_name: district_name,
                                                    treatment: treatment_type
                                                }).done(function(data) {
                                                    // alert(data);
                                                    $('#reportschartstats').html(data);
                                                    $('#export_button').css('visibility', 'visible');
                                                });
                                            } // end select district
                                        }
                                        ;
                                    }); //end ajacx to check district
                                }

                                function createChart(data, chart_type, container, treatment_type) {
                                    // in the format
                                    // title, label1, label2, data1, data2, total
                                    var contents = data.split(",");

                                    var title = contents[0];
                                    var label1 = contents[1];
                                    var label2 = contents[2];
                                    var data1 = parseInt(contents[3]).toFixed(1);
                                    var data2 = parseInt(contents[4]).toFixed(1);
                                    var total = parseInt(contents[5]);

                                    if (contents.length != 6) {
                                        $(container).html('<h3 id="data_error">No data found</h3>');
                                        $(container).css('width', '31%');
                                        return;
                                    }

                                    if (treatment_type == 'schisto') {
                                        $(container).css('width', '25%');
                                        $(container).css('padding-left', '6%');
                                    } else {
                                        $(container).css('width', '25%');
                                        $(container).css('padding-left', '2%');
                                    }

                                    $(container).highcharts({
                                        chart: {
                                            plotBackgroundColor: null,
                                            plotBorderWidth: null,
                                            plotShadow: false,
                                            width: 220,
                                            height: 380
                                        },
                                        title: {
                                            text: title
                                        },
                                        colors: ["#F58427", "#FABF8F"],
                                        tooltip: {
                                            formatter: function() {
                                                var value = (this.percentage / 100 * total).toFixed(0);
                                                return '<b style="font-size: 1.2em; font-weight: bold;">' + this.point.name + '</b><br /><br />Number:<b>' + value + '</b><br />Total: <b>' + total + '</b>';
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
                                        plotOptions: {
                                            pie: {
                                                allowPointSelect: true,
                                                cursor: 'pointer',
                                                dataLabels: {
                                                    enabled: true,
                                                    distance: -40,
                                                    color: 'black',
                                                    format: '{point.y:.0f}%'
                                                },
                                                showInLegend: true
                                            }
                                        },
                                        series: [{
                                                type: 'pie',
                                                name: chart_type,
                                                data: [[label1, +data1], [label2, +data2]]
                                            }]
                                    });
                                }

                                // function to add commas to numbers
                                function commaSeparateNumber(val) {
                                    while (/(\d+)(\d{3})/.test(val.toString())) {
                                        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ',' + '$2');
                                    }
                                    return val;
                                }


                                function setDewormed(value) {
                                    var contents = value.split(",");
                                    var percentage = (parseInt(contents[0]) / parseInt(contents[1]) * 100).toFixed(0);
                                    var newWidth = parseInt($('#dewormed_percentage_container').width() * percentage / 100.0);
                                    
                                    var divWidth = percentage;
                                   
                                     if (divWidth > 100) {
                                        divWidthExcess = divWidth - 100;
                                        divWidthExcessDivided = divWidthExcess / 10;
                                        divWidth = 100 + divWidthExcessDivided;
                                      }

                                    $('#dewormed_percentage_value').animate({
                                        width: divWidth + '%'
                                    }, 500);
                                    var dewormed = commaSeparateNumber(parseInt(contents[0]));
                                    $('#dewormed_info_title').html(dewormed + ' children dewormed');
                                    $('#dewormed_percentage_value').html(percentage + '%');
                                    $('#dewormed_info_title_sub').html('out of ' + commaSeparateNumber(contents[1]) + ' planned children in the Sub-County.');

                                    $('#dewormed_info_subtitle').html(commaSeparateNumber(parseFloat(contents[2]).toFixed(0)) + '% of enrolled primary children were dewormed');

                                    $('#dewormed_percentage_value').css('visibility', 'visible');
                                    $('#dewormed_percentage_container').css('visibility', 'visible');
                                }

                                function setTreated(value) {
                                    var contents = value.split(",");

                                    var participated = parseInt(contents[0]);
                                    var targeted = parseInt(contents[1]);

                                    var percentage = participated / targeted * 100;
                                    var divWidth = percentage;
                                   
                                     if (divWidth > 100) {
                                        divWidthExcess = divWidth - 100;
                                        divWidthExcessDivided = divWidthExcess / 10;
                                        divWidth = 100 + divWidthExcessDivided;
                                      }

                                    // var newWidth = parseInt($('#treated_percentage_container').width() * percentage / 100.0);
                                    $('#treated_percentage_value').animate({
                                        width: divWidth + '%'
                                    }, 500);

                                    $('#treated_percentage_value').html(percentage.toFixed(0) + '%');

                                    $('#treated_info_title').html(commaSeparateNumber(participated) + ' schools reached ');
                                    $('#treated_info_title_sub').html('out of ' + commaSeparateNumber(targeted) + ' planned schools.');
                                    $('#treated_percentage_value').css('visibility', 'visible');
                                    $('#treated_percentage_container').css('visibility', 'visible');
                                }
                                //                PABLO ==========================================
                                //load subject template============================================================================
                                function loadCountyName() {
                                    var district_id = document.getElementById("selectdistrict").value;

                                    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                                        xmlhttp = new XMLHttpRequest();
                                    }
                                    else {// code for IE6, IE5
                                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                                    }
                                    xmlhttp.onreadystatechange = function() {
                                        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                            document.getElementById("county_name").value = xmlhttp.responseText;
                                        }
                                    }
                                    // load the assumption to be used
                                    xmlhttp.open("GET", "ajax_load_county_name.php?district_id=" + district_id, true);
                                    xmlhttp.send();
                                }
    </script>
    <?php
} else {
    header("Location:../../home.php");
}
ob_flush();
?>
