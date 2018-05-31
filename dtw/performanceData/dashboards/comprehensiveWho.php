<?php
ob_start();
// require_once ('includes/config.php');
// require_once ('includes/auth.php');
// require_once ("includes/functions.php");
// require_once ("includes/form_functions.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once ("../../includes/auth.php"); //use root
require_once ('../../includes/config.php'); // use root
$placeholder = "N/A";
$tabActive = "tab1"; //wierdness
$placeholder = "No Data";
// include "kpiFunctionsCiff.php";
include "queryFunctions.php";

// this is for district ntd
// include "includes/class.ntd.pzq.php";
// $ntdPZQ=new ntdPZQ;
// $data=$ntdPZQ->getAll();

include "includes/class.ntd.php";
$ntd = new ntd;

$data = $ntd->getAll();
$dataPZQ = $ntd->getAllPZQ();


// privileges check.DO NOT TOUCH
$priv_email = $_SESSION['staff_email'];
$resPriv = mysql_query("SELECT * FROM staff where staff_email='$priv_email' ");
while ($row = mysql_fetch_array($resPriv)) {

    $priv_ciff_kpi = $row['priv_ciff_kpi'];
    $priv_ciff_report = $row['priv_ciff_report'];
    $priv_end_fund = $row['priv_end_fund'];
    $priv_ntd = $row['priv_ntd'];
    $priv_usaid = $row['priv_usaid'];
    $priv_who = $row['priv_who'];
}
if ($priv_ciff_kpi == 0 && $priv_ciff_report == 0 && $priv_end_fund == 0 && $priv_ntd == 0 && $priv_usaid == 0 && $priv_who == 0) {

    header("Location:../../home.php");
} else {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
        <head>
            <title>Evidence Action</title>
            <?php require_once ("includes/meta-link-script.php"); ?>
            <script type="text/javascript">
                $(window).load(function() {
                    $('#loading').hide();
                });

            </script>

            <style type="text/css">
                #loading {
                    width: 100%;
                    height: 100%;
                    top: 0px;
                    left: 0px;
                    position: fixed;
                    display: block;
                    opacity: 0.4;
                    background-color: #fff;
                    z-index: 99;
                    text-align: center;
                }

                #loading-image {
                    position: absolute;
                    top: 300px;
                    left: 600px;
                    z-index: 100;
                    width: 50px;
                }
            </style>
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery(".content00").hide();
                    //toggle the componenet with class msg_body
                    jQuery(".heading00").click(function()
                    {
                        jQuery(this).next(".content00").slideToggle(300);
                    });
                });
            </script>
        </head>
        <body>
            <!---------------- header start ------------------------>
            <div class="header vnav_100px">
                <div style="float: left">  <img src="../../images/logo.png" />  </div>
                <div class="menuLinks">
                    <?php require_once ("includes/menuNav.php"); ?> 
                    <?php //require_once ("includes/loginInfo.php");  ?> 
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
                    <div id="loading">
                        <img id="loading-image" src="../../images/loading.gif" alt="Loading..." />
                    </div>

                  <?php require_once "includes/reporting-menu-tabs.php"; ?>

<div id="dashboard">
	<div id="indicator">
		<div class="dashboard_menu">
			<div class="dashboard_export">
			<?php if($priv_usaid>=1){?>
				<a class="btn btn-primary pink-color" href="exportExcelWhoKpi.php">Export To Excel</a>
				<a class="btn btn-primary pink-color" href="exportPdfWhoKpi.php" target="_blank">Export To PDF</a>
			<?php }?>
			</div>
			<div class="vclear"></div>
			<div class="dashboard_title">
				<h3>WHO REPORT</h3>	
			</div>
		</div>
			<table id="hor-minimalist-b" />
<th scope="col">Indicator</th>
<th scope="col">Total</th>
<tr>
<td>
No. of teachers trained
</td>
<td class="td-left"><?php echo $row1=number_format(NotEmpty('t1_name','attnt_bysch')+NotEmpty('t2_name','attnt_bysch')) ?></td>
</tr>
<tr>
<td>
No. of schools attending teacher training
</td>
<td class="td-left"><?php echo $row2=number_format(numDistinctPlain('school_id','attnt_bysch')) ?></td>
</tr>
<tr>
<td>
No. of schools with critical materials present
</td>
<td class="td-left"><?php echo $row3=number_format(attntWithCriticalMaterials()) ?></td>
</tr>
<tr>
<td>
No. of schools with no critical materials present
</td>
<td class="td-left"><?php echo $row4=number_format(attntNoCriticalMaterials()) ?></td>
</tr>
<tr>
<td>
No. of TTs with requiered drugs
</td>
<td class="td-left">
<?php echo $row5=number_format(attntWithCriticalMaterials('attnt_id')) ?>
</td>
</tr>
<tr>
<td>
No. of district returning form ATTNR
</td>
<td><?php echo $row6=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form ATTNT
</td>
<td><?php echo $row7=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form S
</td>
<td class="td-left"><?php echo $row8=number_format(returnedForms('s_district_id')) ?></td>
</tr>
<tr>
<td>
No. of district returning form A
</td>
<td class="td-left"><?php echo  $row9=number_format(returnedFormA('district_id'))?></td>
</tr>
<tr>
<td>
No. of district returning form D
</td>
<td><?php echo $row10=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form Tabs
</td>
<td><?php echo $row11=$placeholder ?></td>
</tr>
			</table>
	</div>
</div>

</div> <!-- end content body-->





                <!--================================================-->
            </div><!--end of content Main -->
            </div>
            <div class="clearFix"></div>
            <!---------------- Footer ------------------------>
            <!--<div class="footer">  </div>-->
        </body>
    </html>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

        <script type="text/javascript">
            $(document).ready(function() {
                $('#data-table').dataTable();

            });
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('table.display').dataTable();
            })
        </script>

        <?php
    }
    ob_flush();
    ?>

