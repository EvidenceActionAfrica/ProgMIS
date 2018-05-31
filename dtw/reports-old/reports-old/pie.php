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
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Evidence Action Reports :: School count per County (<?php echo count($countryar);?> Counties)</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
function decode_base64(s) {
    var e={},i,k,v=[],r='',w=String.fromCharCode;
    var n=[[65,91],[97,123],[48,58],[43,44],[47,48]];

    for(z in n){for(i=n[z][0];i<n[z][1];i++){v.push(w(i));}}
    for(i=0;i<64;i++){e[v[i]]=i;}

    for(i=0;i<s.length;i+=72){
    var b=0,c,x,l=0,o=s.substring(i,i+72);
         for(x=0;x<o.length;x++){
                c=e[o.charAt(x)];b=(b<<6)+c;l+=6;
                while(l>=8){r+=w((b>>>(l-=8))%256);}
         }
    }
    return r;
    }
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
                   // name = name.split(' -')[0];

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
				name1 = name.split('++==')[0];
				name2 = name.split('++==')[1];
				name3 = decode_base64(name2);
				//alert(name3);
                brandsData.push({ 
                    name: name1, 
					 name2: name3, 
                    y: y,
                    drilldown: name
                });
            });
           /* $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });*/

            // Create the chart
            $('#container').highcharts({
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'School count per County (<?php echo count($countryar);?> Counties)'
                },
                subtitle: {
                    text: ''
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.name} :: {point.y:.1f}%'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="color:{point.color}">{series.name} :: </span>',
                    pointFormat: '<span style="color:{point.color}">{point.name2}<br />{point.name} :: {point.y:.1f}%</b> of total</span>'
                }, 

                series: [{
                    name: 'Schools',
                    colorByPoint: true,
                    data: brandsData
                }],
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
<script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script>
<div id="container" style="min-width: 700px; height: 700px; margin: 0 auto"></div>
<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<pre id="tsv" style="display:none">Browser Version	Total Market Share
<?php foreach($countryar as $keyv => $countryarval){
	//echo count($countryar[$keyv]);
	$valk = $keyv.'++=='.base64_encode(count($countryar[$keyv]));
	echo $valk.'&#x09;'.number_format((count($countryar[$keyv])*100/count($insertformdata)),2).'%&#x0A;';}?>
</pre>

	</body>
</html>
