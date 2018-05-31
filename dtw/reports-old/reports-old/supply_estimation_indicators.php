<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Supply Estimation Indicators</title>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<?php $zero      = 1172536;     $one       = 8973495;   $two        = 7521956; $three     = 1451539; //$four      = 50171;   $fifth       = 148065;
//Ratio of tablets used to supplied	0.84
//Ratio of tablets spolit to tablets supplied	0.13
		$keysum = ($zero+$one+$two+$three);	
$arrbn = array(
					   '0'   => array('indicator'=>'No. of tablets spoilt','percentage'=>(($zero*100)/$keysum)*7),
					   '1'   => array('indicator'=>'No. of tablets supplied','percentage'=>(($one*100)/$keysum)*7),
					   '2'   => array('indicator'=>'No. of tablets used (includes tablets given to children and adults and tablets spoilt)','percentage'=>(($two*100)/$keysum)*7),
					   '3'   => array('indicator'=>'No. of tablets returned','percentage'=>(($three*100)/$keysum)*7)
					   );
//echo '<pre>';print_r($arrbn);echo '</pre>';
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
            text: 'Supply Estimation Indicators :: Pie Chart'
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
                    text: 'Supply Estimation Indicators :: Line Graph'
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
<script src="js/highcharts.js"></script>
<!--<script src="js/modules/exporting.js"></script>-->

<div id="container" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>

<script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script>

<div id="containerbar" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">	Supply Estimation Indicators	
<?php foreach($arrbn as $arrbnval){
	echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
 }?>
</pre>
<?php 
	echo "<a href='supply_estimation_indicators_pdf.php' id='downid' style='display:none;'>Download PDF</a>";?>
	</body>
</html>