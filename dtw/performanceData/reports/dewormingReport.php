<?php
ob_start();
require_once ("../../includes/auth.php");
require_once ('../../includes/config.php');
require_once ("includes/include.php"); //includes the class EvidenceAction
$evidenceaction = new EvidenceAction();
ini_set("max_execution_time", 9000000000);
// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_standard_reports = $row['priv_standard_reports'];
}
if (!isset($_GET["pdfView"])) {
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
                        <div class="col-md-12">

                            <div class="col-md-4">
                            </div>
                            <div class="dashboard_export col-md-4 col-md-offset-2">
                                <a class="btn-custom-small" href="">Export To Excel</a>
                                <a target="blank" href="dewormingReport.php?pdfView=true" class="btn-custom-small1">Export To Pdf</a>
                            </div><br/><br/>
                            <div id="dvData">
                                <table class="table table-bordered table-condensed table-striped table-hover">
                                    <tr>
                                        <th> County Name</th>
                                        <th>Sub County name</th>
                                        <th>Children Dewormed<br/>STH</th>
                                        <th>Children Dewormed<br/> (Schisto)</th>
                                        <th> Deworming date</th>
                                    </tr>

                                    <?php
                                    //	$sql='SELECT *  from national_program_results ';
                                    //	echo $sql;

                                    $sql = 'SELECT
            							s_bysch.s_district_name,
            							a_bysch.ap_attached,
            							s_bysch.s_deworming_day,a_bysch.county_name
            													
            							FROM s_bysch
            							JOIN a_bysch ON s_bysch.s_district_name = a_bysch.district_name
            							GROUP by s_bysch.s_district_name,a_bysch.district_name
            							ORDER by county_name,s_bysch.s_district_name
            							';

                                    $resultA = mysql_query($sql);


                                    $counter = 1;
                                    $activeCounty = "";
                                    $totalSTHDistricts = 0;
                                    $totalSCHDistricts = 0;
                                    $totalSTHChildren = 0;
                                    $totalSCHChildren = 0;
                                    while ($row = mysql_fetch_array($resultA)) {


                                        if ($activeCounty == $row["county_name"]) {
                                            $county = "";
                                        } else {
                                            $county = $row["county_name"];
                                            $activeCounty = $row["county_name"];
                                        }
                                        if ($counter == 1) {
                                            $activeCounty = $row["county_name"];
                                            $county = $row["county_name"];
                                            $counter = 2;
                                        }

                                        $sql2 = 'SELECT sum(a_total_child) AS STH FROM a_bysch WHERE district_name="' . $row["s_district_name"] . '"';
                                        //echo  $sql2;
                                        $resultC = mysql_query($sql2);
                                        $totalSTH = "";
                                        while ($row2 = mysql_fetch_array($resultC)) {

                                            $totalSTH+=$row2["STH"];
                                        }

                                        $sql3 = 'SELECT sum(ap_total_child) AS SCH FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES") AND a_bysch.district_name="' . $row["s_district_name"] . '"';

                                        $resultD = mysql_query($sql3);
                                        $totalSCH = "";
                                        while ($row3 = mysql_fetch_array($resultD)) {

                                            $totalSCH+=$row3["SCH"];
                                        }


                                        echo "<tr>";
                                        echo "<td>" . $county . "</td>";

                                        echo "<td>" . $row["s_district_name"] . "</td>";
                                        echo "<td>" . number_format($totalSTH) . "</td>";
                                        echo "<td>" . number_format($totalSCH) . "</td>";
                                        echo "<td>" . $row["s_deworming_day"] . "</td>";
                                        echo "</tr>";

                                        if ($totalSTH > 0) {
                                            $totalSTHDistricts+=1;
                                        }

                                        if ($totalSCH > 0) {
                                            $totalSCHDistricts+=1;
                                        }

                                        $totalSTHChildren+=$totalSTH;
                                        $totalSCHChildren+=$totalSCH;
                                    }
                                    echo "<tr>";
                                    echo "<td rowspan='2'  style='text-align:center'><h2>Total</h2></td>";

                                    echo "<td rowspan='2'  style='text-align:center'><h3><u>District <br/>Dewormed</u></h3><br/>

								" . number_format($totalSTHDistricts) . "(STH) <br/>" . number_format($totalSCHDistricts) . "(Schisto)
							</td>";


                                    echo "<td rowspan='2' colspan='3' style='text-align:center'><h3><u>Children Dewormed </u></h3><br/>

							" . number_format($totalSTHChildren) . "(STH) <br/>" . number_format($totalSCHChildren) . "(Schisto)

							</td>";
                                    echo "</tr>";
                                    ?>

                                </table>
                            </div>
                        </div>
                    </div>
                    </body>
                    </html>
                    <?php
                } else {

                    $data = '
	<table class="table table-bordered table-condensed table-striped table-hover">
			      	<tr>
			      		<th> County Name</th>
						<th>Sub County name</th>
						<th>Children Dewormed<br/>STH</th>
						<th>Children Dewormed<br/> (Schisto)</th>
						<th> Deworming date</th>
			      	</tr>
			      	';

                    $sql = 'SELECT
							s_bysch.s_district_name,
							a_bysch.ap_attached,
							s_bysch.s_deworming_day,a_bysch.county_name
													
							FROM s_bysch
							JOIN a_bysch ON s_bysch.s_district_name = a_bysch.district_name
							GROUP by s_bysch.s_district_name,a_bysch.district_name
							ORDER by county_name,s_bysch.s_district_name
							';

                    $resultA = mysql_query($sql);


                    $counter = 1;
                    $activeCounty = "";
                    $totalSTHDistricts = 0;
                    $totalSCHDistricts = 0;
                    $totalSTHChildren = 0;
                    $totalSCHChildren = 0;
                    while ($row = mysql_fetch_array($resultA)) {


                        if ($activeCounty == $row["county_name"]) {
                            $county = "";
                        } else {
                            $county = $row["county_name"];
                            $activeCounty = $row["county_name"];
                        }
                        if ($counter == 1) {
                            $activeCounty = $row["county_name"];
                            $county = $row["county_name"];
                            $counter = 2;
                        }

                        $sql2 = 'SELECT sum(a_total_child) AS STH FROM a_bysch WHERE district_name="' . $row["s_district_name"] . '"';
                        //echo  $sql2;
                        $resultC = mysql_query($sql2);
                        $totalSTH = "";
                        while ($row2 = mysql_fetch_array($resultC)) {

                            $totalSTH+=$row2["STH"];
                        }

                        $sql3 = 'SELECT sum(ap_total_child) AS SCH FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES") AND a_bysch.district_name="' . $row["s_district_name"] . '"';

                        $resultD = mysql_query($sql3);
                        $totalSCH = "";
                        while ($row3 = mysql_fetch_array($resultD)) {

                            $totalSCH+=$row3["SCH"];
                        }
                        if ($county == "") {

                            $style = "style=border:0px solid #FFFFFF;";
                        } else {
                            $style = "";
                        }

                        $data.= "<tr " . $style . ">";
                        $data.= "<td " . $style . ">" . $county . "</td>";

                        $data.= "<td>" . $row["s_district_name"] . "</td>";
                        $data.= "<td>" . number_format($totalSTH) . "</td>";
                        $data.= "<td>" . number_format($totalSCH) . "</td>";
                        $data.= "<td>" . $row["s_deworming_day"] . "</td>";
                        $data.= "</tr>";

                        if ($totalSTH > 0) {
                            $totalSTHDistricts+=1;
                        }

                        if ($totalSCH > 0) {
                            $totalSCHDistricts+=1;
                        }

                        $totalSTHChildren+=$totalSTH;
                        $totalSCHChildren+=$totalSCH;
                    }
                    $data.= "<tr>";
                    $data.= "<td rowspan='2'  style='text-align:center'><h2>Total</h2></td>";

                    $data.= "<td rowspan='2'  style='text-align:center'><h3><u>District <br/>Dewormed</u></h3><br/>

								" . number_format($totalSTHDistricts) . "(STH) <br/>" . number_format($totalSCHDistricts) . "(Schisto)
							</td>";


                    $data.= '<td rowspan="2" colspan="3" style="text-align:center"><h3><u>Children Dewormed </u></h3><br/>

							' . number_format($totalSTHChildren) . '(STH) <br/>' . number_format($totalSCHChildren) . '(Schisto)

							</td>';
                    $data.= "</tr>";
                    $data.="</table>";


                    //  echo $data;
//$_SESSION["tableData"]=$sql;
                    $_SESSION["tableData"] = $data;
                    //$_SESSION["tableData"].="Hello";
                    header("Location:../../tcpdf/examples/dewormingReport.php?pdf=Annual_Programme_Results.pdf");
                    exit();
                }
                ?>
                <script>
                    $(document).ready(function() {

                        function exportTableToCSV($table, filename) {

                            var $rows = $table.find('tr:has(td)'),
                                    // Temporary delimiter characters unlikely to be typed by keyboard
                                    // This is to avoid accidentally splitting the actual contents
                                    tmpColDelim = String.fromCharCode(11), // vertical tab character
                                    tmpRowDelim = String.fromCharCode(0), // null character

                                    // actual delimiter characters for CSV format
                                    colDelim = '","',
                                    rowDelim = '"\r\n"',
                                    // Grab text from table into CSV formatted string
                                    csv = '"' + $rows.map(function(i, row) {
                                var $row = $(row),
                                        $cols = $row.find('td');

                                return $cols.map(function(j, col) {
                                    var $col = $(col),
                                            text = $col.text();

                                    return text.replace('"', '""'); // escape double quotes

                                }).get().join(tmpColDelim);

                            }).get().join(tmpRowDelim)
                                    .split(tmpRowDelim).join(rowDelim)
                                    .split(tmpColDelim).join(colDelim) + '"',
                                    // Data URI
                                    csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                            $(this)
                                    .attr({
                                'download': filename,
                                'href': csvData,
                                'target': '_blank'
                            });
                        }

                        // This must be a hyperlink
                        $(".btn-custom-small").on('click', function(event) {
                            // CSV
                            exportTableToCSV.apply(this, [$('#dvData>table'), 'Programme Results.csv']);

                            // IF CSV, don't do event.preventDefault() or return false
                            // We actually need this to be a typical hyperlink
                        });
                    });
                </script> 
