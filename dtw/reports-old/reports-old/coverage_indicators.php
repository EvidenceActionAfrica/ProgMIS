<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Coverage Indicators</title>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<?php $zero      = 111;     $one       = 13393;   $two        = 6349420; $three     = 5568959; $four      = 50171;   $fifth       = 148065;  
      $sixth     = 6196;    $seventh   = 4804203; $eighth     = 1029625; $ninth     = 522567;  $tenth     = 507058;  $eleventh    = 3774578; 
	  $twelth    = 1888609; $thirth    = 1885969; $fourteenth = 4340818; $fifteenth = 2345411; $sixteenth = 1995407; $seventeenth = 764756;
	  $eigteenth = 449653;  $ninteenth = 227695; $twintyth   = 221958; $twintonth = 315103; $twinttwth = 110010; $twintthreth = 205093;
	  $twintfoth = 780461;
		$keysum = ($zero+$one+$two+$three+$four+$fifth+$sixth+$seventh+$eighth+$ninth+$tenth+$eleventh+$twelth+$thirth+$fourteenth+$fifteenth+$sixteenth+$seventeenth+$eigteenth+$ninteenth+$twintyth+$twintonth+$twinttwth+$twintthreth+$twintfoth);	
$arrbn = array(
					   '0'   => array('indicator'=>'No. of districts covered','percentage'=>(($zero*100)/$keysum)),
					   '1'   => array('indicator'=>'No. of schools covered','percentage'=>(($one*100)/$keysum)),
					   '2'   => array('indicator'=>'No. dewormed (children + adults)','percentage'=>(($two*100)/$keysum)),
					   '3'   => array('indicator'=>'No. of children dewormed','percentage'=>(($three*100)/$keysum)),
					   '4'   => array('indicator'=>'Average children dewormed per district','percentage'=>(($four*100)/$keysum)),
					   '5'   => array('indicator'=>'Range of district coverage (max district average)','percentage'=>(( $fifth*100)/$keysum)),
					   '6'   => array('indicator'=>'Range of district coverage (min district average)','percentage'=>(($sixth*100)/$keysum)),
					   '7'   => array('indicator'=>'No. of \'Enrolled Primary + Enrolled ECD\' children dewormed','percentage'=>(($seventh*100)/$keysum)),
					   '8'   => array('indicator'=>'No. of \'ECD\' children dewormed','percentage'=>(($eighth*100)/$keysum)),
					   '9'   => array('indicator'=>'No. of ECD Male children dewormed','percentage'=>(($ninth*100)/$keysum)),
					   '10'   => array('indicator'=>'No. of ECD Female children dewormed','percentage'=>(($tenth*100)/$keysum)),
					   '11'   => array('indicator'=>'No. of \'Primary\' children dewormed','percentage'=>(($eleventh*100)/$keysum)),
					   '12'   => array('indicator'=>'No. of Primary Male children dewormed','percentage'=>(($twelth*100)/$keysum)),
					   '13'   => array('indicator'=>'No. of Primary Female children dewormed','percentage'=>(($thirth*100)/$keysum)),
					   '14'   => array('indicator'=>'No. of Primary children registered','percentage'=>(($fourteenth*100)/$keysum)),
					   '15'   => array('indicator'=>'No. of Male Primary children registered','percentage'=>(($fifteenth*100)/$keysum)),
					   '16'   => array('indicator'=>'No. of Female Primary children registered','percentage'=>(($sixteenth*100)/$keysum)),
					   '17'   => array('indicator'=>'No. of \'Non Enrolled\' children dewormed','percentage'=>(($seventeenth*100)/$keysum)),
					   '18'   => array('indicator'=>'No. of children aged two to five dewormed','percentage'=>(($eigteenth*100)/$keysum)),
					   '19'   => array('indicator'=>'No. of male children aged two to five years dewormed','percentage'=>(($ninteenth*100)/$keysum)),
					   '20'   => array('indicator'=>'No. of female children aged two to five years dewormed','percentage'=>(( $twintyth*100)/$keysum)),
					   '21'   => array('indicator'=>'No. of children aged six plus years dewormed','percentage'=>(($twintonth*100)/$keysum)),
					   '22'   => array('indicator'=>'No. of male children aged six plus years dewormed','percentage'=>(($twinttwth*100)/$keysum)),
					   '23'   => array('indicator'=>'No. of female children aged six plus years dewormed','percentage'=>(($twintthreth*100)/$keysum)),
					   '24'   => array('indicator'=>'No. of adults dewormed','percentage'=>(($twintfoth*100)/$keysum))
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
            text: 'Coverage Indicators :: Pie Chart'
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
                    text: 'Coverage Indicators :: Line Graph'
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
<pre id="tsv" style="display:none">	Coverage Indicators	
<?php foreach($arrbn as $arrbnval){
	echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
 }?>
</pre>
<?php 
	echo "<a href='coverage_indicators_pdf.php' id='downid' style='display:none;'>Download PDF</a>";?>
	</body>
</html>
