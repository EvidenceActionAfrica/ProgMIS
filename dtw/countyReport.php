<?php
require_once ("../../includes/auth.php");
require_once ('../../includes/config.php');
require_once ("includes/include.php"); //includes the class EvidenceAction
//require_once("include")
$evidenceaction = new EvidenceAction();

// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {
    $priv_standard_reports = $row['priv_standard_reports'];
}
if (!isset($_GET["pdfView"])) {
    ?>

    <style>
        table td{
            /*border:0px;*/
            border:1px solid rgb(0,0,0);
        }
    </style>
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
                              
                                <form method="POST">
                                    <label>County</label>
                                    <?php
                                    $tablename = 'counties';
                                    $fields = 'county';
                                    $where = '1=1  ORDER BY county ASC';
                                    $insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
                                    ?>
                                    <select id="selectdistrict" name="county">
                                        <option value=""><?php
                                            if (isset($_POST["county"])) {
                                                echo $_POST["county"];
                                            }
                                            ?></option>
                                        <?php
                                        foreach ($insertformdata as $insertformdatacab) {
                                            echo "<option value=\"$insertformdatacab[county]\">$insertformdatacab[county]</option>";
                                        }
                                        ?>4
                                    </select>

                                    <input style="background: #F14E6C;" id="generate_button" name="generate_repor" type="submit" value="Generate Report" class="btn btn-primary" onclick="selectcounty();" />
                                
                                </form>
                                    <div class="col-md-4 col-md-offset-4">
                                         <?php
                                    if (isset($_POST["county"])) {

                                        echo '<a target="blank" style="margin-top:-5%;float:right;" class="btn-custom-small" href="countyReport.php?pdfView=true&county=' . $_POST["county"] . '">Export To Pdf</a>';
                                             echo '&nbsp; <a class="btn-custom-small" href="">Export To Excel</a>';
                                  
                                        ?>
                                 </div>
                            </div>


                            <div class="dashboard_export col-md-4 col-md-offset-2">  
                                                                  
                                </div><br/><br/> 
                                <div id="dvData">
                                    <table class="table table-hover table-stripped">
                                        <tr>
                                            <th>County</th>
                                            <th>Sub-County name</th>
                                            <th>Children Dewormed<br/>STH</th>
                                            <th>Children Dewormed<br/> (Schisto)</th>
                                            <th> Deworming date</th>

                                        </tr>

                                        <?php
                                        // $sql='SELECT 
                                        // s.s_district_name,
                                        // sum(c.ap_attached="NO") as STH,
                                        // sum(c.ap_attached="YES") as SCH,
                                        // s.s_deworming_day 
                                        // FROM 
                                        // a_bysch as c,
                                        // s_bysch as s 
                                        // WHERE c.district_name=s.s_district_name 
                                        // GROUP by s.s_district_name,c.county_name 
                                        // ORDER BY c.district_name';
                                        //    		$activeCounty=$_POST["district_name"];
                                        // $sql = 'SELECT
                                        // s_bysch.s_district_name,s_bysch.s_division_name,
                                        // a_bysch.ap_attached,
                                        // s_bysch.s_deworming_day,a_bysch.county_name
                                        // FROM s_bysch
                                        // JOIN a_bysch ON s_bysch.s_district_name = a_bysch.district_name
                                        // WHERE s_bysch.s_district_name="'.$activeCounty.'"
                                        // ';
                                        $activeCounty = $_POST["county"];
                                        $sql = 'SELECT
							district_name,
							a_bysch.ap_attached,
							a_bysch.county_name
													
							FROM a_bysch
							WHERE county_name="' . $activeCounty . '" 
							GROUP by district_name
							ORDER by county_name,district_name
							';


                                        $resultA = mysql_query($sql) or die(mysql_error());
                                        //$row=mysql_fetch_array($resultA);


                                        $counter = 1;
                                        $activeCounty = "";
                                        $totalSTHDistricts = 0;
                                        $totalSCHDistricts = 0;
                                        $totalSTHChildren = 0;
                                        $totalSCHChildren = 0;
                                        $totalSCHOOLS = 0;
                                        $actualDeworm = "";
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

                                            $sql2 = 'SELECT sum(a_total_child) as STH FROM a_bysch WHERE district_name="' . $row["district_name"] . '"';

                                            $resultC = mysql_query($sql2);
                                            $totalSTH = "";
                                            while ($row2 = mysql_fetch_array($resultC)) {

                                                $totalSTH+=$row2["STH"];
                                            }

                                            $sql3 = 'SELECT sum(ap_total_child) AS SCH FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES")  AND district_name="' . $row["district_name"] . '"';
                                            //echo $sql3;

                                            $resultD = mysql_query($sql3);
                                            $totalSCH = "";
                                            while ($row3 = mysql_fetch_array($resultD)) {

                                                $totalSCH+=$row3["SCH"];
                                            }


                                            $sql4 = 'SELECT actual_deworming_date  FROM s_bysch WHERE  s_district_name="' . $row["district_name"] . '"';

                                            $resultE = mysql_query($sql4);
                                            $Dewormday = "";
                                            while ($row4 = mysql_fetch_array($resultE)) {

                                                //	$Dewormday=$row4["s_deworming_day"];
                                                $actualDeworm = $row4["actual_deworming_date"];
                                            }
                                            $sql5 = 'SELECT count(a_school_name) as SUMSCH  FROM a_bysch WHERE  district_name="' . $row["district_name"] . '"';

                                            $resultF = mysql_query($sql5);

                                            while ($row5 = mysql_fetch_array($resultF)) {

                                                $SUMSCH = $row5["SUMSCH"];
                                            }
                                            echo "<tr>";
                                            echo "<td ";
                                            if ($county == "") {
                                                echo 'style=border:0px;';
                                            } else {
                                                echo 'style=border-bottom:1px solid rgb(201,201,201);';
                                            }
                                            echo ">" . $county . "</td>";
                                            echo "<td style='text-align:center'>" . $row["district_name"] . "</td>";
                                            echo "<td style='text-align:right' > " . number_format($totalSTH) . "</td>";
                                            echo "<td style='text-align:right'>" . number_format($totalSCH) . "</td>";
                                            //	echo "<td style='text-align:right'>".$Dewormday."</td>";
                                            echo "<td style='text-align:right'>" . $actualDeworm . "</td>";

                                            echo "</tr>";
                                            //if($activeCounty !=""){$activeCounty="";}


                                            if ($totalSTH > 0) {
                                                $totalSTHDistricts+=1;
                                            }

                                            if ($totalSCH > 0) {
                                                $totalSCHDistricts+=1;
                                            }

                                            $totalSTHChildren+=$totalSTH;
                                            $totalSCHChildren+=$totalSCH;
                                            $totalSCHOOLS+=$SUMSCH;
                                        }

                                        echo "<tr>";
                                        echo "<td rowspan='2'  style='text-align:center;font-weight:bolder'><h2>Total</h2></td>";

                                        echo "<td rowspan='2'  style='text-align:center;font-weight:bolder'><h3><u>District <br/>Dewormed</u></h3><br/>

								" . $totalSTHDistricts . "(STH) <br/>" . $totalSCHDistricts . "(Schisto)
							</td>";

                                        echo "<td rowspan='2'><h3><u>Total Schools</u></h3> " . number_format($totalSCHOOLS) . "</td>";
                                        echo "<td rowspan='2' colspan='4' style='text-align:center;font-weight:bolder'><h3><u>Children Dewormed </u></h3><br/>

							" . $totalSTHChildren . "(STH) <br/>" . $totalSCHChildren . "(Schisto)

							</td>";
                                        echo "</tr>";
                                        ?>

                                    </table>
                                <?php }
                                ?>
                            </div>
                        </div>
                    </div>
                    </body>
                    </html>
                    <?php
                } else {
                    if (isset($_GET["county"])) {




                        $data = '<table class="table table-hover table-stripped">
			      	<tr>
			      		<th>County</th>
						<th>Sub-County name</th>
						<th>Children Dewormed<br/>STH</th>
						<th>Children Dewormed<br/> (Schisto)</th>
						<th> Deworming date</th>
						
			      	</tr>';

                        // $sql='SELECT 
                        // s.s_district_name,
                        // sum(c.ap_attached="NO") as STH,
                        // sum(c.ap_attached="YES") as SCH,
                        // s.s_deworming_day 
                        // FROM 
                        // a_bysch as c,
                        // s_bysch as s 
                        // WHERE c.district_name=s.s_district_name 
                        // GROUP by s.s_district_name,c.county_name 
                        // ORDER BY c.district_name';
                        //    		$activeCounty=$_POST["district_name"];
                        // $sql = 'SELECT
                        // s_bysch.s_district_name,s_bysch.s_division_name,
                        // a_bysch.ap_attached,
                        // s_bysch.s_deworming_day,a_bysch.county_name
                        // FROM s_bysch
                        // JOIN a_bysch ON s_bysch.s_district_name = a_bysch.district_name
                        // WHERE s_bysch.s_district_name="'.$activeCounty.'"
                        // ';
                        $activeCounty = $_GET["county"];
                        $sql = 'SELECT
							district_name,
							a_bysch.ap_attached,
							a_bysch.county_name
													
							FROM a_bysch
							WHERE county_name="' . $activeCounty . '" 
							GROUP by district_name
							ORDER by county_name,district_name
							';




                        //echo $sql; 

                        $resultA = mysql_query($sql) or die(mysql_error());
                        //$row=mysql_fetch_array($resultA);


                        $counter = 1;
                        $activeCounty = "";
                        $totalSTHDistricts = 0;
                        $totalSCHDistricts = 0;
                        $totalSTHChildren = 0;
                        $totalSCHChildren = 0;
                        $totalSCHOOLS = 0;
                        $actualDeworm = "";
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
                            $sql2 = 'SELECT sum(a_total_child) as STH FROM a_bysch WHERE district_name="' . $row["district_name"] . '"';

                            $resultC = mysql_query($sql2);
                            $totalSTH = "";
                            while ($row2 = mysql_fetch_array($resultC)) {

                                $totalSTH+=$row2["STH"];
                            }

                            $sql3 = 'SELECT sum(ap_total_child) AS SCH FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES")  AND district_name="' . $row["district_name"] . '"';
                            //echo $sql3;

                            $resultD = mysql_query($sql3);
                            $totalSCH = "";
                            while ($row3 = mysql_fetch_array($resultD)) {

                                $totalSCH+=$row3["SCH"];
                            }
                            $sql4 = 'SELECT s_deworming_day,actual_deworming_date  FROM s_bysch WHERE  s_district_name="' . $row["district_name"] . '"';

                            $resultE = mysql_query($sql4);
                            $sql4 = 'SELECT actual_deworming_date  FROM s_bysch WHERE  s_district_name="' . $row["district_name"] . '"';

                            $resultE = mysql_query($sql4);
                            $Dewormday = "";
                            while ($row4 = mysql_fetch_array($resultE)) {

                                //$Dewormday=$row4["s_deworming_day"];
                                $actualDeworm = $row4["actual_deworming_date"];
                            }
                            $sql5 = 'SELECT count(a_school_name) as SUMSCH  FROM a_bysch WHERE  district_name="' . $row["district_name"] . '"';

                            $resultF = mysql_query($sql5);

                            while ($row5 = mysql_fetch_array($resultF)) {

                                $SUMSCH = $row5["SUMSCH"];
                            }
                            $data.='<tr>';

                            $data.= "<td ";
                            if ($county == "") {
                                $data.='style=border:0px;';
                            } else {
                                $data.='style=border-top:1px;text-align:center';
                            }
                            $data.=">" . $county . "</td>";


                            $data.='<td>' . $row['district_name'] . '</td>';
                            $data.='<td>' . $totalSTH . "</td>";
                            $data.='<td>' . $totalSCH . "</td>";
                            //	$data.='<td>'.$Dewormday.'</td>';
                            $data.="<td style='text-align:right'>" . $actualDeworm . "</td>";


                            $data.='</tr>';
                            //if($activeCounty !=""){$activeCounty="";}


                            if ($totalSTH > 0) {
                                $totalSTHDistricts+=1;
                            }

                            if ($totalSCH > 0) {
                                $totalSCHDistricts+=1;
                            }

                            $totalSTHChildren+=$totalSTH;
                            $totalSCHChildren+=$totalSCH;
                            $totalSCHOOLS+=$SUMSCH;
                        }

                        $data.='<tr>';
                        $data.='<td rowspan=2  style=text-align:center;font-weight:bolder><h2>Total</h2></td>';

                        $data.='<td rowspan=2  style=text-align:center;font-weight:bolder><h3><u>District <br/>Dewormed</u></h3><br/>

								' . $totalSTHDistricts . '(STH) <br/>' . $totalSCHDistricts . '(Schisto)
							</td>';
                        $data.= "<td rowspan='2'><h3><u>Total Schools</u></h3> " . number_format($totalSCHOOLS) . "</td>";


                        $data.='<td rowspan=2 colspan=4 style=text-align:center;font-weight:bolder><h3><u>Children Dewormed </u></h3><br/>

							' . $totalSTHChildren . '(STH) <br/>' . $totalSCHChildren . '(Schisto)

							</td>    	
						</tr>';



                        $data.='	</table>';


//echo $data;
//$_SESSION["tableData"]=$sql;
                        $_SESSION["tableData"] = $data;
                        //$_SESSION["tableData"].="Hello";
                        header("Location:../../tcpdf/examples/dewormingReport.php?pdf=Annual_Programme_Results.pdf");
                        exit();
                    }
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
                                                exportTableToCSV.apply(this, [$('#dvData>table'), 'County Programme Results.csv']);

                                                // IF CSV, don't do event.preventDefault() or return false
                                                // We actually need this to be a typical hyperlink
                                            });
                                        });
                </script>