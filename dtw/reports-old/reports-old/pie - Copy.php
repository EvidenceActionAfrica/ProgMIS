<?php
include('../config/dbconfig_report.php');
include('../config/functions.php');
$evidenceaction = new EvidenceAction();
$tablename = 'schools';
$fields = '*';
$where = '1=1';
$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
$countryarr = array();
foreach($insertformdata as $insertformdatacab){
	$countryar[$insertformdatacab['county']][]=$insertformdatacab['school_id'];
}
//echo '<pre>';print_r($countryar);echo '</pre>';
//session_destroy(); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link href="styles.css" rel="stylesheet" />
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/knockout-3.0.0.js"></script>
		<script src="js/globalize.min.js"></script>
		<script src="js/dx.chartjs.js"></script>
                                      
	</head>
	<body>
		<script>
			$(function ()  
				{
   
var dataSource = [
   <?php foreach($countryar as $keyv => $countryarval){?>
    { country: "<?php echo $keyv;?>", area: <?php echo number_format((count($countryar[$keyv])*100/count($insertformdata)),2);?> },
   <?php }?>
];

$("#chartContainer").dxPieChart({
    size:{ 
        width: 1500
    },
    dataSource: dataSource,
    series: [
        {
            argumentField: "country",
            valueField: "area",
            label:{
                visible: true,
                connector:{
                    visible:true,           
                    width: 1
                }
            }
        }
    ],
    title: "Area of Countries"
});
}

			);
		</script>
		<div class="line"></div>		
		<div class="title">
			<h1>Pie</h1>&nbsp;&nbsp;&nbsp;<h2>Simple</h2>
		</div>
		<div class="content">
			<div class="pane">
				<div class="long-title"><h3></h3></div>
				<div id="chartContainer" style="width: 100%; height: 100%;"></div>
			</div>
		</div>
	</body>
</html>