<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SCHISTO Indicators</title>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<?php $zero      = 14;     $one       = 351;   $two        = 173695; $three     = 157501; $four      = 149282;   $fifth       = 13936;  
      $sixth     = 135346;    $seventh   = 68554; $eighth     = 66792; $ninth     = 150791;  $tenth     = 8219;  $eleventh    = 16194; 
	  $twelth    = 5777; $thirth    = 560753; $fourteenth = 404889; $fifteenth = 155864;
		$keysum = ($zero+$one+$two+$three+$four+$fifth+$sixth+$seventh+$eighth+$ninth+$tenth+$eleventh+$twelth+$thirth+$fourteenth+$fifteenth);	
$arrbn = array(
					   '0'   => array('indicator'=>'No. of districts covered','percentage'=>(($zero*100)/$keysum)),
					   '1'   => array('indicator'=>'No. of schools covered','percentage'=>(($one*100)/$keysum)),
					   '2'   => array('indicator'=>'No. dewormed (children + adults)','percentage'=>(($two*100)/$keysum)),
					   '3'   => array('indicator'=>'No. of children dewormed','percentage'=>(($three*100)/$keysum)),
					   '4'   => array('indicator'=>'No. of \'Enrolled Primary + Enrolled ECD\' children dewormed','percentage'=>(($four*100)/$keysum)),
					   '5'   => array('indicator'=>'No. of \'ECD\' children dewormed','percentage'=>(($fifth*100)/$keysum)),
					   '6'   => array('indicator'=>'No. of \'Primary\' children dewormed','percentage'=>(($sixth*100)/$keysum)),
					   '7'   => array('indicator'=>'No. of Primary Male children dewormed','percentage'=>(($seventh*100)/$keysum)),
					   '8'   => array('indicator'=>'No. of Primary Female children dewormed','percentage'=>(($eighth*100)/$keysum)),
					   '9'   => array('indicator'=>'No. of Primary children registered','percentage'=>(($ninth*100)/$keysum)),
					   '10'   => array('indicator'=>'No. of \'Non Enrolled\' children dewormed','percentage'=>(($tenth*100)/$keysum)),
					   '11'   => array('indicator'=>'No. of adults dewormed','percentage'=>(($eleventh*100)/$keysum)),
					   '12'   => array('indicator'=>'No. of tablets spoilt','percentage'=>(($twelth*100)/$keysum)),
					   '13'   => array('indicator'=>'No. of tablets supplied','percentage'=>(($thirth*100)/$keysum)),
					   '14'   => array('indicator'=>'No. of tablets used (includes tablets given to children and adults and tablets spoilt)','percentage'=>(($fourteenth*100)/$keysum)),
					   '15'   => array('indicator'=>'No. of tablets returned','percentage'=>(($fifteenth*100)/$keysum))
					   );
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
            text: 'SCHISTO Indicators :: Pie Chart'
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
                    text: 'SCHISTO Indicators :: Line Graph'
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

<div id="container" style="min-width: 1010px; height: 500px; margin: 0 auto"></div>

<script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script>

<div id="containerbar" style="min-width: 1010px; height: 800px; margin: 0 auto"></div>

<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">	SCHISTO Indicators	
<?php foreach($arrbn as $arrbnval){
	echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
 }?>
</pre>
<?php 
	echo "<a href='schisto_indicators_pdf.php' id='downid' style='display:none;'>Download PDF</a>";?>
	</body>
</html>