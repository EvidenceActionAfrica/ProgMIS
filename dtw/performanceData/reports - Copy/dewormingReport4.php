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
}?>
<!DOCTYPE html>
<head>
    <title>Evidence Action</title>
    <?php require_once ("includes/meta-link-script.php"); ?> 
    <style> 
        #dvData table {background-color: #fff; }
        #dvData table td,#dvData table th {border:1px solid #E7E3E0; }
        #dvData table th { text-align: center!important; }
    </style> 
</head>
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
            <?php require_once ("includes/menuLeftBar-PerformanceData.php"); ?> 
        </div>
        <div class="contentBody">
            <!--================================================-->
            <div class="contentMain">
                <div class="contentBody">
                    <div class="col-md-12">

                        <div class="col-md-4"> </div> 

                        <?php

                            $results = mysql_query( 'SELECT district_name FROM a_bysch GROUP by district_name ORDER BY county_name,district_name' );
                            $data = array();
                            while ($districts = mysql_fetch_assoc($results)) {

                                $data[$districts['district_name']] = array();

                                $sql = 'SELECT 
                                deworming_date, 
                                county_name, 
                                COUNT(a_school_name) as total_schools, 
                                SUM(a_total_child) AS chdew_STH,
                                (SELECT SUM(ap_total_child) FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES") AND district_name ="'.$districts['district_name'].'") AS chdew_SCH
                                FROM a_bysch
                                WHERE district_name ="'.$districts['district_name'].'"';
                                $results_ = mysql_query($sql);
                                while ($districtsData = mysql_fetch_assoc($results_)) {

                                    $data[$districts['district_name']]['county_name'] = $districtsData['county_name'];
                                    $data[$districts['district_name']]['total_schools'] = $districtsData['total_schools'];
                                    $data[$districts['district_name']]['chdew_STH'] = $districtsData['chdew_STH'];
                                    $data[$districts['district_name']]['chdew_SCH'] = $districtsData['chdew_SCH'];
                                    $data[$districts['district_name']]['deworming_date'] = $districtsData['deworming_date'];
                                    $chdew_planned = mysql_fetch_assoc(mysql_query( 'SELECT ceil((sum(a_bysch.a_total_child)) / ((sum(p_bysch.p_pri_enroll)+ sum(p_bysch.p_ecd_enroll)+ sum(p_bysch.p_ecd_sa_enroll)))*100) AS chdew_planned FROM a_bysch,p_bysch WHERE a_bysch.county_name="'.$districtsData['county_name'].'"'));
                                    $data[$districts['district_name']]['chdew_planned'] = $chdew_planned['chdew_planned'];
                                
                                }

                            }

                            $totalSCHChildren = mysql_fetch_assoc(mysql_query( 'SELECT SUM(ap_total_child) AS totalSCHChildren FROM a_bysch WHERE (ap_attached="Yes" || ap_attached="YES")' ));
                            $totalSTHChildren = mysql_fetch_assoc(mysql_query( 'SELECT SUM(a_total_child) AS totalSTHChildren, COUNT(a_school_name) AS totalSCHOOLS FROM a_bysch' ));
                            $totalSTHDistricts = mysql_fetch_assoc(mysql_query( 'SELECT COUNT(district_name) AS totalSTHDistricts FROM a_bysch GROUP BY county_name,district_name' )); 
                            $totalSCHDistricts = mysql_fetch_assoc(mysql_query( 'SELECT COUNT(district_name) AS totalSCHDistricts FROM a_bysch WHERE (ap_attached = "YES" || ap_attached = "Yes") GROUP BY county_name,district_name' ));
                        
                            $meta = array(
                                'doc_heading' => 'Year 1 National Programme Results: Sub-County Breakdown',
                                'doc_title' => 'National School Based Deworming Programme',
                                'dic_sub_title' => '2012 - 2013 Sub-County Breakdown of STH and Schistosomiasis Treatment'
                            );

                            if (isset($_POST['export_pdf'])) {

                                require_once('../../tcpdf/tcpdf.php');      // create new PDF document
                                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                                // set document information
                                $pdf->SetCreator(PDF_CREATOR);
                                $pdf->SetAuthor($_SESSION['staff_name']);
                                $pdf->SetTitle($meta['doc_heading']);
                                $pdf->SetSubject($meta['doc_title']);
                                //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                                // remove default header/footer
                                $pdf->setPrintHeader(false);
                                $pdf->setPrintFooter(false);

                                // set default monospaced font
                                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                                // set margins
                                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                                // set auto page breaks
                                $pdf->SetAutoPageBreak(TRUE, 10);

                                // sret image scale factor
                                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                                // set some language-dependent strings (optional)
                                if (@file_exists(dirname(__FILE__).'/tcpdf/lang/eng.php')) {
                                    require_once(dirname(__FILE__).'/tcpdf/lang/eng.php');
                                    $pdf->setLanguageArray($l);
                                }

                                function partition( $list, $p ) {
                                    $listlen = count( $list );
                                    $partlen = floor( $listlen / $p );
                                    $partrem = $listlen % $p;
                                    $partition = array();
                                    $mark = 0;
                                    for ($px = 0; $px < $p; $px++) {
                                        $incr = ($px < $partrem) ? $partlen + 1 : $partlen;
                                        $partition[$px] = array_slice( $list, $mark, $incr );
                                        $mark += $incr;
                                    }
                                    return $partition;
                                }

                                // set default font subsetting mode
                                $pdf->setFontSubsetting(true);

                                // Set font
                                // dejavusans is a UTF-8 Unicode font, if you only need to
                                // print standard ASCII chars, you can use core fonts like
                                // helvetica or times to reduce file size.
                                $pdf->SetFont('helvetica', '', 5.5, '', true);

                                // Add a page
                                // This method has several options, check the source code documentation for more information.
                                $pdf->AddPage("P","mm","A4",true,"UTF-8",false);

                                // set color for text
                                $pdf->SetTextColor(73, 73, 73);

                                $docHeader = '
                                            <h1 style="text-align:center;" >'.$meta['doc_heading'].'</h1>
                                            <h4 style="text-align:center;" >'.$meta['doc_title'].'</h4>
                                            <h4 style="text-align:center;" >'.$meta['dic_sub_title'].'</h4>
                                ';

                                $pdf->SetXY(10, 5);
                                $pdf->writeHTML($docHeader, true, false, true, false, '');
                                $pdf->SetY(23);

                                $tableHeader = '
                                            <tr>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">County Name</th>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">Sub-County name</th>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">Total Schools</th>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">Children Dewormed<br/>STH</th>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">Children Dewormed<br/> (Schisto)</th>
                                                <th style="border:1px solid #333333; background-color:#D2D2D2;">Deworming date</th>                                
                                            </tr>
                                ';

                                $tableFooter = '
                                        <tr>
                                            <th style="border:1px solid #333333; background-color:#D2D2D2;">Total</th>
                                            <th style="border:1px solid #333333; background-color:#D2D2D2;"><u>District Dewormed</u><br/> '. number_format($totalSTHDistricts['totalSTHDistricts']).' (STH) <br/>'. number_format($totalSCHDistricts['totalSCHDistricts']).' (Schisto) </th>
                                            <th style="border:1px solid #333333; background-color:#D2D2D2;"><u>Total Schools</u><br/>'. number_format($totalSTHChildren['totalSCHOOLS']).'</th>
                                            <th colspan="3" style="border:1px solid #333333; background-color:#D2D2D2;"><u>Children Dewormed</u> <br/>'. number_format($totalSTHChildren['totalSTHChildren']).' <br/>'. number_format($totalSCHChildren['totalSCHChildren']).' (Schisto) </th>
                                        </tr>
                                ';

                                $data = partition($data, 2);

                                $col_1 = '';
                                foreach ( $data[0] as $key => $value ) {
                                    $col_1 .= '<tr>';
                                    if (isset($prev)) { 
                                        $curr = $value['county_name'];
                                        if ($curr == $prev) {
                                            $col_1 .= '<td style="border-left:1px solid black">&nbsp;</td>';
                                        } else {
                                            $col_1 .= '<td style="border-left:1px solid black; border-top:1px solid black">'.$value['county_name'].'<br>'.$value['chdew_planned'].'% </td>';
                                        }
                                    } else {                                                
                                        $col_1 .= '<td style="border-left:1px solid black; border-top:1px solid black">'.$value['county_name'].'<br>'.$value['chdew_planned'].'% </td>';
                                    }
                                    $col_1 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$key.'</td>';
                                    $col_1 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$value['total_schools'].'</td>';
                                    $col_1 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.number_format($value['chdew_STH']).'</td>';
                                    $col_1 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.number_format($value['chdew_SCH']).'</td>';
                                    $col_1 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$value['deworming_date'].'</td>';
                                    $col_1 .= '</tr>';
                                $prev = $value['county_name']; }
                                $theTable1 = '<table>'.$tableHeader.$col_1.'</table>';

                                $col_2 = '';
                                foreach ( $data[1] as $key => $value ) {
                                    $col_2 .= '<tr>';
                                    if (isset($prev)) { 
                                        $curr = $value['county_name'];
                                        if ($curr == $prev) {
                                            $col_2 .= '<td style="border-left:1px solid black;">&nbsp;</td>';
                                        } else {
                                            $col_2 .= '<td style="border-left:1px solid black; border-top:1px solid black">'.$value['county_name'].'<br>'.$value['chdew_planned'].'% </td>';
                                        }
                                    } else {                                                
                                        $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 0px 0px;">'.$value['county_name'].'<br>'.$value['chdew_planned'].'% </td>';
                                    }
                                    $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$key.'</td>';
                                    $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$value['total_schools'].'</td>';
                                    $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.number_format($value['chdew_STH']).'</td>';
                                    $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.number_format($value['chdew_SCH']).'</td>';
                                    $col_2 .= '<td style="border-color:#333333;border-style:solid;border-width:0px 1px 1px 0px;">'.$value['deworming_date'].'</td>';
                                    $col_2 .= '</tr>';
                                $prev = $value['county_name']; }
                                $theTable2 = '<table>'.$tableHeader.$col_2.$tableFooter.'</table>';

                                // get current vertical position
                                $y = $pdf->getY();

                                // set color for background
                                $pdf->SetFillColor(255, 255, 255);                        

                                // write the first column
                                $pdf->writeHTMLCell(90, '', '', $y, $theTable1, 0, 0, 1, true, 'J', true);

                                // write the second column
                                $pdf->writeHTMLCell(90, '', '', '', $theTable2, 0, 1, 1, true, 'J', true);

                                // reset pointer to the last page
                                $pdf->lastPage();

                                ob_end_clean();

                                $doc_title = str_replace(' ', '_', strtolower( $meta['doc_heading'] ) );
                                // Close and output PDF document
                                // This method has several options, check the source code documentation for more information.
                                $pdf->Output(''.$doc_title.'.pdf', 'D');

                            }

                        ?>

                        <br>
                        
                        <div class="dashboard_export col-md-4 col-md-offset-2">
                            <form method="post" action="<?php echo basename($_SERVER['REQUEST_URI']) ?>" >
                                <a id="btn-custom-small" class="btn-custom-small" href="">Export To Excel</a>
                                <button class="btn-custom-small" type="submit" name="export_pdf">Export To Pdf</button>    
                            </form>                            
                        </div>

                        <div id="dvData">

                            <table class="table table-bordered">
                                    <tr>
                                        <th>County Name</th>
                                        <th>Sub-County Name</th>
                                        <th>Total Schools</th>
                                        <th>Children Dewormed (STH)</th>
                                        <th>Children Dewormed (Schisto)</th>
                                        <th>Deworming Date</th>                                
                                    </tr>

                                    <?php foreach ( $data as $key => $value ) { ?>
                                        <tr> 
                                            <?php
                                                if (isset($prev)) { 
                                                $curr = $value['county_name'];
                                                if ($curr == $prev) { ?>
                                                    <td style="border-bottom: 0px;border-top:0px;"></td>
                                                <?php } else { ?>
                                                    <td style="border-bottom: 0px;"><?php echo $value['county_name'].'<br>'.$value['chdew_planned'].'%'; ?></td>
                                                <?php }
                                            } else { ?>
                                                <td style="border-bottom: 0px;"><?php echo $value['county_name'].'<br>'.$value['chdew_planned'].'%'; ?></td>
                                            <?php } ?>
                                            <td><?php echo $key; ?></td>
                                            <td><?php echo $value['total_schools']; ?></td>
                                            <td><?php echo number_format($value['chdew_STH']); ?></td>
                                            <td><?php if (!empty($value['chdew_SCH'])) { echo number_format($value['chdew_SCH']); } else { echo '0';} ?></td>
                                            <td><?php echo $value['deworming_date']; ?></td>
                                        </tr>
                                    <?php $prev = $value['county_name']; } ?>

                                    <tr>
                                        <th>Total</th>
                                        <th>District Dewormed <?php echo number_format($totalSTHDistricts['totalSTHDistricts']); ?> (STH) <?php echo number_format($totalSCHDistricts['totalSCHDistricts']); ?> (Schisto) </th>
                                        <th>Total Schools <?php echo number_format($totalSTHChildren['totalSCHOOLS']); ?> </th>
                                        <th colspan="3" >Children Dewormed <?php echo number_format($totalSTHChildren['totalSTHChildren']); ?> (STH) <?php echo number_format($totalSCHChildren['totalSCHChildren']); ?> (Schisto) </th>                                   
                                    </tr>                         

                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function() {

        function exportTableToCSV($table, filename) {

            var $rows = $table.find('tr:has(td,th)'),
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
                        $cols = $row.find('td,th');

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

            $(this).attr({
                'download': filename,
                'href': csvData,
                'target': '_blank'
            });
        }

        // This must be a hyperlink
        $("#btn-custom-small").on('click', function(event) {
            // CSV
            exportTableToCSV.apply(this, [$('#dvData>table'), 'National Programme Results.csv']);

            // IF CSV, don't do event.preventDefault() or return false
            // We actually need this to be a typical hyperlink
        });
    });
</script> 
