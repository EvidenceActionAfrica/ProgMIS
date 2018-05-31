<?php
include('../config/dbconfig_reportengine.php');
include('../config/functions.php');
$evidenceaction = new EvidenceAction();
if(isset($_REQUEST['checkval']) && !empty($_REQUEST['checkval'])){
	if($_REQUEST['checkval']=='county_table'){
		$tablename = 'county_table';
		$fields = 'id';
		if(isset($_REQUEST['enrolled_treated']) && !empty($_REQUEST['enrolled_treated']) && ($_REQUEST['enrolled_treated']=='enrolled_treated')){
			$fields .= ', enrolled_treated';
		}
		if(isset($_REQUEST['schools_treated']) && !empty($_REQUEST['schools_treated']) && ($_REQUEST['schools_treated']=='schools_treated')){
			$fields .= ', schools_treated';
		}
		if(isset($_REQUEST['non_enrolled_treated']) && !empty($_REQUEST['non_enrolled_treated']) && ($_REQUEST['non_enrolled_treated']=='non_enrolled_treated')){
			$fields .= ', non_enrolled_treated';
		}
		if(isset($_REQUEST['under_5_treated']) && !empty($_REQUEST['under_5_treated']) && ($_REQUEST['under_5_treated']=='under_5_treated')){
			$fields .= ', under_5_treated';
		}
		if(isset($_REQUEST['adults_treated']) && !empty($_REQUEST['adults_treated']) && ($_REQUEST['adults_treated']=='adults_treated')){
			$fields .= ', adults_treated';
		}
		if(isset($_REQUEST['females_treated']) && !empty($_REQUEST['females_treated']) && ($_REQUEST['females_treated']=='females_treated')){
			$fields .= ', females_treated';
		}
		if(isset($_REQUEST['total_child']) && !empty($_REQUEST['total_child']) && ($_REQUEST['total_child']=='total_child')){
			$fields .= ', total_child';
		}
		if(isset($_REQUEST['children_treated']) && !empty($_REQUEST['children_treated']) && ($_REQUEST['children_treated']=='children_treated')){
			$fields .= ', children_treated';
		}
		if(isset($_REQUEST['total_non_enrolled']) && !empty($_REQUEST['total_non_enrolled']) && ($_REQUEST['total_non_enrolled']=='total_non_enrolled')){
			$fields .= ', total_non_enrolled';
		}
		$where = 'county="'.$_REQUEST['county'].'"';
		$insertformdata = $evidenceaction->selectrow($tablename, $fields, $where);
		//$keysum = 0;
		$arrbn = array();
		if(isset($insertformdata['enrolled_treated']) && !empty($insertformdata['enrolled_treated'])){
			//$keysum = $keysum + $insertformdata['enrolled_treated'];
			$arrbn[] = array('indicator'=>'Enrolled Treated','percentage'=>$insertformdata['enrolled_treated']);
		}
		if(isset($insertformdata['schools_treated']) && !empty($insertformdata['schools_treated'])){
			$arrbn[] = array('indicator'=>'Schools Treated','percentage'=>$insertformdata['schools_treated']);
		}
		if(isset($insertformdata['non_enrolled_treated']) && !empty($insertformdata['non_enrolled_treated'])){
			$arrbn[] = array('indicator'=>'Non Enrolled Treated','percentage'=>$insertformdata['non_enrolled_treated']);
		}
		if(isset($insertformdata['under_5_treated']) && !empty($insertformdata['under_5_treated'])){
			$arrbn[] = array('indicator'=>'Under Five Treated','percentage'=>$insertformdata['under_5_treated']);
		}
		if(isset($insertformdata['adults_treated']) && !empty($insertformdata['adults_treated'])){
			$arrbn[] = array('indicator'=>'Adults Treated','percentage'=>$insertformdata['adults_treated']);
		}
		if(isset($insertformdata['females_treated']) && !empty($insertformdata['females_treated'])){
			$arrbn[] = array('indicator'=>'Females Treated','percentage'=>$insertformdata['females_treated']);
		}
		if(isset($insertformdata['total_child']) && !empty($insertformdata['total_child'])){
			$arrbn[] = array('indicator'=>'Total Child','percentage'=>$insertformdata['total_child']);
		}
		if(isset($insertformdata['children_treated']) && !empty($insertformdata['children_treated'])){
			$arrbn[] = array('indicator'=>'Children Treated','percentage'=>$insertformdata['children_treated']);
		}
		if(isset($insertformdata['total_non_enrolled']) && !empty($insertformdata['total_non_enrolled'])){
			$arrbn[] = array('indicator'=>'Total Non Enrolled','percentage'=>$insertformdata['total_non_enrolled']);
		}
		//echo '<pre>';print_r($insertformdata);echo '</pre>';
?>
		<script type="text/javascript">
$(function () {
	$('body').mouseenter(function(){
		$('#downid').css('display','block');
	});
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
        },
        title: {
            text: 'County Indicators :: Pie Chart'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            data: [
			<?php foreach($arrbn as $arrbnval){?>
				["<?php echo $arrbnval['indicator'];?>",  <?php echo $arrbnval["percentage"];?>],
			<?php }?>
            ]
        }]
    });
Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];
            
            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }
                
            });

            $.each(brands, function (name, y) {
                brandsData.push({ 
                    name: name, 
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart
            $('#containerbar').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'County :: Line Graph'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total Percent Share'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.2f}%'
                        }
                    }
                },

                tooltip: {
                    /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                    pointFormat: ' : <b>{point.y:.2f}%</b> of total<br/>'
                }, 

                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: brandsData
                },
				],
                drilldown: {
                    series: drilldownSeries
                }
            })

        }
    });
});
    

		</script>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">	County	
<?php foreach($arrbn as $arrbnval){
	echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
 }?>
</pre>
<?php
		die();
	}
	if($_REQUEST['checkval']=='county_table_pdf'){
		$tablename = 'county_table';
		$fields = 'id';
		if(isset($_REQUEST['enrolled_treated']) && !empty($_REQUEST['enrolled_treated']) && ($_REQUEST['enrolled_treated']=='enrolled_treated')){
			$fields .= ', enrolled_treated';
		}
		if(isset($_REQUEST['schools_treated']) && !empty($_REQUEST['schools_treated']) && ($_REQUEST['schools_treated']=='schools_treated')){
			$fields .= ', schools_treated';
		}
		if(isset($_REQUEST['non_enrolled_treated']) && !empty($_REQUEST['non_enrolled_treated']) && ($_REQUEST['non_enrolled_treated']=='non_enrolled_treated')){
			$fields .= ', non_enrolled_treated';
		}
		if(isset($_REQUEST['under_5_treated']) && !empty($_REQUEST['under_5_treated']) && ($_REQUEST['under_5_treated']=='under_5_treated')){
			$fields .= ', under_5_treated';
		}
		if(isset($_REQUEST['adults_treated']) && !empty($_REQUEST['adults_treated']) && ($_REQUEST['adults_treated']=='adults_treated')){
			$fields .= ', adults_treated';
		}
		if(isset($_REQUEST['females_treated']) && !empty($_REQUEST['females_treated']) && ($_REQUEST['females_treated']=='females_treated')){
			$fields .= ', females_treated';
		}
		if(isset($_REQUEST['total_child']) && !empty($_REQUEST['total_child']) && ($_REQUEST['total_child']=='total_child')){
			$fields .= ', total_child';
		}
		if(isset($_REQUEST['children_treated']) && !empty($_REQUEST['children_treated']) && ($_REQUEST['children_treated']=='children_treated')){
			$fields .= ', children_treated';
		}
		if(isset($_REQUEST['total_non_enrolled']) && !empty($_REQUEST['total_non_enrolled']) && ($_REQUEST['total_non_enrolled']=='total_non_enrolled')){
			$fields .= ', total_non_enrolled';
		}
		$where = 'county="'.$_REQUEST['county'].'"';
		$insertformdata = $evidenceaction->selectrow($tablename, $fields, $where);
		//$keysum = 0;
		$arrbn = array();
		if(isset($insertformdata['enrolled_treated']) && !empty($insertformdata['enrolled_treated'])){
			//$keysum = $keysum + $insertformdata['enrolled_treated'];
			$arrbn[] = array('indicator'=>'Enrolled Treated','percentage'=>$insertformdata['enrolled_treated']);
		}
		if(isset($insertformdata['schools_treated']) && !empty($insertformdata['schools_treated'])){
			$arrbn[] = array('indicator'=>'Schools Treated','percentage'=>$insertformdata['schools_treated']);
		}
		if(isset($insertformdata['non_enrolled_treated']) && !empty($insertformdata['non_enrolled_treated'])){
			$arrbn[] = array('indicator'=>'Non Enrolled Treated','percentage'=>$insertformdata['non_enrolled_treated']);
		}
		if(isset($insertformdata['under_5_treated']) && !empty($insertformdata['under_5_treated'])){
			$arrbn[] = array('indicator'=>'Under Five Treated','percentage'=>$insertformdata['under_5_treated']);
		}
		if(isset($insertformdata['adults_treated']) && !empty($insertformdata['adults_treated'])){
			$arrbn[] = array('indicator'=>'Adults Treated','percentage'=>$insertformdata['adults_treated']);
		}
		if(isset($insertformdata['females_treated']) && !empty($insertformdata['females_treated'])){
			$arrbn[] = array('indicator'=>'Females Treated','percentage'=>$insertformdata['females_treated']);
		}
		if(isset($insertformdata['total_child']) && !empty($insertformdata['total_child'])){
			$arrbn[] = array('indicator'=>'Total Child','percentage'=>$insertformdata['total_child']);
		}
		if(isset($insertformdata['children_treated']) && !empty($insertformdata['children_treated'])){
			$arrbn[] = array('indicator'=>'Children Treated','percentage'=>$insertformdata['children_treated']);
		}
		if(isset($insertformdata['total_non_enrolled']) && !empty($insertformdata['total_non_enrolled'])){
			$arrbn[] = array('indicator'=>'Total Non Enrolled','percentage'=>$insertformdata['total_non_enrolled']);
		}
		//echo '<pre>';print_r($insertformdata);echo '</pre>';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>County</title>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script src="js/highcharts.js"></script>
		<script src="js/modules/data.js"></script>
		<script src="js/modules/drilldown.js"></script>
		<script type="text/javascript">
$(function () {
	$('body').mouseenter(function(){
		$('#downid').css('display','block');
	});
    $('#container').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
        },
        title: {
            text: 'County Indicators :: Pie Chart'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    color: '#000000',
                    connectorColor: '#000000',
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %'
                }
            }
        },
        series: [{
            type: 'pie',
            name: ' ',
            data: [
			<?php foreach($arrbn as $arrbnval){?>
				["<?php echo $arrbnval['indicator'];?>",  <?php echo $arrbnval["percentage"];?>],
			<?php }?>
            ]
        }]
    });
Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];
            
            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }
                
            });

            $.each(brands, function (name, y) {
                brandsData.push({ 
                    name: name, 
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart
            $('#containerbar').highcharts({
                chart: {
                    type: 'bar'
                },
                title: {
                    text: 'County :: Line Graph'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total Percent Share'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.2f}%'
                        }
                    }
                },

                tooltip: {
                    /*headerFormat: '<span style="font-size:11px">{series.name}</span><br>',*/
                    pointFormat: ' : <b>{point.y:.2f}%</b> of total<br/>'
                }, 

                series: [{
                    name: 'Brands',
                    colorByPoint: true,
                    data: brandsData
                },
				],
                drilldown: {
                    series: drilldownSeries
                }
            })

        }
    });
});
</script>
</head>
<body>
		

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">	County	
<?php foreach($arrbn as $arrbnval){
	echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
 }?>
</pre>

<!--<script src="js/modules/exporting.js"></script>-->
<div id="container" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>

<div id="containerbar" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>
<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<?php
		die();
	}
}
?>