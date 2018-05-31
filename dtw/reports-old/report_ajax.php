<?php
include('config/dbconfig_reportengine.php');
include('config/functions.php');
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
	if($_REQUEST['checkval']=='district'){
		$tablename = 'districts';
		$fields = 'district_id, district_name';
		$where = 'county_id="'.$_POST['county'].'"';
		$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);?>
		<option value="">Choose District</option>
		<?php 
		foreach($insertformdata as $insertformdatav){?>
			<option value="<?php echo $insertformdatav['district_id'];?>"><?php echo $insertformdatav['district_name'];?></option>
		<?php }
		die();
	}
	if($_REQUEST['checkval']=='division'){
		$tablename = 'form_a';
		$fields = 'division';
		$where = 'district="'.$_REQUEST['district'].'"';
		$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		?>
		<option value="">Choose Division</option>
		<?php 
		foreach($insertformdata as $insertformdatav){
			$tablenamed = 'divisions';
		$fieldsd = 'division_id, division_name';
		//$district = explode('+++==+++',$_REQUEST['district']);
		$whered = 'division_id="'.$insertformdatav['division'].'"';
		$insertformdatad = $evidenceaction->selectrow($tablenamed, $fieldsd, $whered);
		//print_r($insertformdatad);?>
			<option value="<?php echo $insertformdatad['division_id'];?>"><?php echo $insertformdatad['division_name'];?></option>
		<?php }
		die();
	}
	if($_REQUEST['checkval']=='school'){
		$tablename = 'form_a';
		$fields = 'school_name';
		$where = 'division="'.$_REQUEST['division'].'"';
		$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		?>
		<option value="">Choose School</option>
		<?php 
		foreach($insertformdata as $insertformdatav){
			$tablenames = 'schools';
		$fieldss = 'school_id, p_orig_schname';
		//$district = explode('+++==+++',$_REQUEST['district']);
		$wheres = 'school_id="'.$insertformdatav['school_name'].'"';
		$insertformdatas = $evidenceaction->selectrow($tablenames, $fieldss, $wheres);?>
			<option value="<?php echo $insertformdatas['school_id'];?>"><?php echo $insertformdatas['p_orig_schname'];?></option>
		<?php }
		die();
	}
	if($_REQUEST['checkval']=='form_s'){
		$tablename = 'form_a';
		$fields = 'id';
		if(isset($_REQUEST['male']) && !empty($_REQUEST['male']) && ($_REQUEST['male']=='Male')){
			$fields .= ', ecd_treated_male, years_2_5_male, years_6_10_male, years_11_14_male, years_15_18_male, enrolled_male';
		}
		if(isset($_REQUEST['female']) && !empty($_REQUEST['female']) && ($_REQUEST['female']=='Female')){
			$fields .= ', ecd_treated_female, years_2_5_female, years_6_10_female, years_11_14_female, years_15_18_female, enrolled_female';
		}
		if(isset($_REQUEST['years_2_5']) && !empty($_REQUEST['years_2_5']) && ($_REQUEST['years_2_5']=='years_2_5_male,years_2_5_female')){
			$fields .= ', years_2_5_male,years_2_5_female';
		}
		if(isset($_REQUEST['years_6_10']) && !empty($_REQUEST['years_6_10']) && ($_REQUEST['years_6_10']=='years_6_10_male,years_6_10_female')){
			$fields .= ', years_6_10_male,years_6_10_female';
		}
		if(isset($_REQUEST['years_11_14']) && !empty($_REQUEST['years_11_14']) && ($_REQUEST['years_11_14']=='years_11_14_male,years_11_14_female')){
			$fields .= ', years_11_14_male,years_11_14_female';
		}
		if(isset($_REQUEST['years_15_18']) && !empty($_REQUEST['years_15_18']) && ($_REQUEST['years_15_18']=='years_15_18_male,years_15_18_female')){
			$fields .= ', years_15_18_male,years_15_18_female';
		}
		if(isset($_REQUEST['enrolled']) && !empty($_REQUEST['enrolled']) && ($_REQUEST['enrolled']=='enrolled')){
			$fields .= ', total_enrolled_in_register,enrolled_male,enrolled_female,enrolled_treated_total';
		}
		if(isset($_REQUEST['nonenrolled']) && !empty($_REQUEST['nonenrolled']) && ($_REQUEST['nonenrolled']=='nonenrolled')){
			$fields .= ', non_enrolled_total';
		}
		$where = '1=1';
		//echo $_REQUEST['selectdistrict'];
		if(isset($_REQUEST['selectdistrict']) && !empty($_REQUEST['selectdistrict'])){
			//$selectdistrict = explode('+++==+++',$_REQUEST['selectdistrict']);
			$where .= ' AND district="'.$_REQUEST['selectdistrict'].'"';
		}
		if(isset($_REQUEST['selectdivision']) && !empty($_REQUEST['selectdivision'])){
			//$selectdivision = explode('+++==+++',$_REQUEST['selectdivision']);
			$where .= ' AND division="'.$_REQUEST['selectdivision'].'"';
		}
		if(isset($_REQUEST['selectschool']) && !empty($_REQUEST['selectschool'])){
			//$selectschool = explode('+++==+++',$_REQUEST['selectschool']);
			$where .= ' AND school_name="'.$_REQUEST['selectschool'].'"';
		}
		$insertformdatav = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		/*echo '<pre>';
		print_r($insertformdatav);
		echo '</pre>';*/
		//echo $_REQUEST['female'];
		//die();
		//$keysum = 0;
		$arrbn = array();
		$ecd_treated_male = 0;
		$years_2_5_male = 0;
		$years_6_10_male = 0;
		$years_11_14_male = 0;
		$years_15_18_male = 0;
		$enrolled_male = 0;
		$ecd_treated_female = 0;
		$years_2_5_female = 0;
		$years_6_10_female = 0;
		$years_11_14_female = 0;
		$years_15_18_female = 0;
		$enrolled_female = 0;
		$total_enrolled_in_register = 0;
		$enrolled_treated_total = 0;
		$non_enrolled_total = 0;
		if(count($insertformdatav)>0){
		foreach($insertformdatav as $insertformdata){
				if(isset($insertformdata['ecd_treated_male']) && !empty($insertformdata['ecd_treated_male'])){
					$ecd_treated_male = $ecd_treated_male+$insertformdata['ecd_treated_male'];
				}
				if(isset($insertformdata['years_2_5_male']) && !empty($insertformdata['years_2_5_male'])){
					$years_2_5_male = $years_2_5_male + $insertformdata['years_2_5_male'];
				}
				if(isset($insertformdata['years_6_10_male']) && !empty($insertformdata['years_6_10_male'])){
					$years_6_10_male = $years_6_10_male + $insertformdata['years_6_10_male'];
				}
				if(isset($insertformdata['years_11_14_male']) && !empty($insertformdata['years_11_14_male'])){
					$years_11_14_male = $years_11_14_male + $insertformdata['years_11_14_male'];
				}
				if(isset($insertformdata['years_15_18_male']) && !empty($insertformdata['years_15_18_male'])){
					$years_15_18_male = $years_15_18_male + $insertformdata['years_15_18_male'];
				}
				if(isset($insertformdata['enrolled_male']) && !empty($insertformdata['enrolled_male'])){
						$enrolled_male = $enrolled_male + $insertformdata['enrolled_male'];
				}
				if(isset($insertformdata['ecd_treated_female']) && !empty($insertformdata['ecd_treated_female'])){
					$ecd_treated_female = $ecd_treated_female+$insertformdata['ecd_treated_female'];
				}
				if(isset($insertformdata['years_2_5_female']) && !empty($insertformdata['years_2_5_female'])){
					$years_2_5_female = $years_2_5_female + $insertformdata['years_2_5_female'];
				}
				if(isset($insertformdata['years_6_10_female']) && !empty($insertformdata['years_6_10_female'])){
					$years_6_10_female = $years_6_10_female + $insertformdata['years_6_10_female'];
				}
				if(isset($insertformdata['years_11_14_female']) && !empty($insertformdata['years_11_14_female'])){
					$years_11_14_female = $years_11_14_female + $insertformdata['years_11_14_female'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$years_15_18_female = $years_15_18_female + $insertformdata['years_15_18_female'];
				}
				if(isset($insertformdata['enrolled_female']) && !empty($insertformdata['enrolled_female'])){
						$enrolled_female = $enrolled_female + $insertformdata['enrolled_female'];
				}
				if(isset($insertformdata['total_enrolled_in_register']) && !empty($insertformdata['total_enrolled_in_register'])){
						$total_enrolled_in_register = $total_enrolled_in_register + $insertformdata['total_enrolled_in_register'];
				}
				if(isset($insertformdata['enrolled_treated_total']) && !empty($insertformdata['enrolled_treated_total'])){
						$enrolled_treated_total = $enrolled_treated_total + $insertformdata['enrolled_treated_total'];
				}
				if(isset($insertformdata['non_enrolled_total']) && !empty($insertformdata['non_enrolled_total'])){
						$non_enrolled_total = $non_enrolled_total + $insertformdata['non_enrolled_total'];
				}
		}
		//if(isset($_REQUEST['male']) && !empty($_REQUEST['male']) && ($_REQUEST['male']=='Male')){
			$chart_total = $ecd_treated_male + $years_2_5_male + $years_6_10_male + $years_11_14_male + $years_15_18_male + $enrolled_male + $ecd_treated_female + $years_2_5_female + $years_6_10_female + $years_11_14_female + $years_15_18_female + $enrolled_female + $total_enrolled_in_register + $enrolled_treated_total + $non_enrolled_total;
		//if(isset($male_total) && !empty($male_total)){
			if(isset($ecd_treated_male) && !empty($ecd_treated_male)){
				$arrbn[] = array('indicator'=>'ECD Treated Male',
								 'percentage'=>(($ecd_treated_male/$chart_total)*100),
								 'mainval'=>$ecd_treated_male,
								 'mainvaltot'=>$chart_total);
			}
			if(isset($years_2_5_male) && !empty($years_2_5_male)){
				$arrbn[] = array('indicator'=>'Years Two - Five Male',
								 'percentage'=>(($years_2_5_male/$chart_total)*100),
								 'mainval'=>$years_2_5_male,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_6_10_male) && !empty($years_6_10_male)){
				$arrbn[] = array('indicator'=>'Years Six - Ten Male',
								 'percentage'=>(($years_6_10_male/$chart_total)*100),
								 'mainval'=>$years_6_10_male,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_11_14_male) && !empty($years_11_14_male)){
				$arrbn[] = array('indicator'=>'Years Eleven - Fourteen Male',
								 'percentage'=>(($years_11_14_male/$chart_total)*100),
								 'mainval'=>$years_11_14_male,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_15_18_male) && !empty($years_15_18_male)){
				$arrbn[] = array('indicator'=>'Years Fifteen - Eighteen Male',
								 'percentage'=>(($years_15_18_male/$chart_total)*100),
								 'mainval'=>$years_15_18_male,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($enrolled_male) && !empty($enrolled_male)){
				$arrbn[] = array('indicator'=>'Enrolled Male',
								 'percentage'=>(($enrolled_male/$chart_total)*100),
								 'mainval'=>$enrolled_male,
								 'mainvaltot'=>$chart_total);
				}
			//}
		//}
		//if(isset($_REQUEST['female']) && !empty($_REQUEST['female']) && ($_REQUEST['female']=='Female')){
			//$female_total = $ecd_treated_female + $years_2_5_female + $years_6_10_female + $years_11_14_female + $years_15_18_female + $enrolled_female;
		//if(isset($female_total) && !empty($female_total)){
			if(isset($ecd_treated_female) && !empty($ecd_treated_female)){
				$arrbn[] = array('indicator'=>'ECD Treated Female',
								 'percentage'=>(($ecd_treated_female/$chart_total)*100),
								 'mainval'=>$ecd_treated_female,
								 'mainvaltot'=>$chart_total);
			}
			if(isset($years_2_5_female) && !empty($years_2_5_female)){
				$arrbn[] = array('indicator'=>'Years Two - Five Female',
								 'percentage'=>(($years_2_5_female/$chart_total)*100),
								 'mainval'=>$years_2_5_female,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_6_10_female) && !empty($years_6_10_female)){
				$arrbn[] = array('indicator'=>'Years Six - Ten Female',
								 'percentage'=>(($years_6_10_female/$chart_total)*100),
								 'mainval'=>$years_6_10_female,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_11_14_female) && !empty($years_11_14_female)){
				$arrbn[] = array('indicator'=>'Years Eleven - Fourteen Female',
								 'percentage'=>(($years_11_14_female/$chart_total)*100),
								 'mainval'=>$years_11_14_female,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($years_15_18_female) && !empty($years_15_18_female)){
				$arrbn[] = array('indicator'=>'Years Fifteen - Eighteen Female',
								 'percentage'=>(($years_15_18_female/$chart_total)*100),
								 'mainval'=>$years_15_18_female,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($enrolled_female) && !empty($enrolled_female)){
				$arrbn[] = array('indicator'=>'Enrolled Female',
								 'percentage'=>(($enrolled_female/$chart_total)*100),
								 'mainval'=>$enrolled_female,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($total_enrolled_in_register) && !empty($total_enrolled_in_register)){
				$arrbn[] = array('indicator'=>'Total Enrolled in Register',
								 'percentage'=>(($total_enrolled_in_register/$chart_total)*100),
								 'mainval'=>$total_enrolled_in_register,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($enrolled_treated_total) && !empty($enrolled_treated_total)){
				$arrbn[] = array('indicator'=>'Enrolled Treated Total',
								 'percentage'=>(($enrolled_treated_total/$chart_total)*100),
								 'mainval'=>$enrolled_treated_total,
								 'mainvaltot'=>$chart_total);
				}
			if(isset($non_enrolled_total) && !empty($non_enrolled_total)){
				$arrbn[] = array('indicator'=>'Non Enrolled Total',
								 'percentage'=>(($non_enrolled_total/$chart_total)*100),
								 'mainval'=>$non_enrolled_total,
								 'mainvaltot'=>$chart_total);
				}
			//}
			
		//}
		
		//echo '<pre>';print_r($insertformdata);echo '</pre>';
?>
		<script type="text/javascript">
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
$(function () {
	$('body').mouseenter(function(){
		$('#downid').css('display','block');
	});
Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {
var b = columns[2];
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
                    //name = name.split('sdfsdfsdfsdfsdfsdfsd')[0];

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

            $.each(brands, function (name, y, b) {
				name1 = name.split('++==')[0];
				name2 = name.split('++==')[1];
				//name3 = decode_base64(name2);
				name4 = name.split('++==')[2];
				name5 = name.split('++==')[3];
				//name5 = decode_base64(name4);
				//alert(name5);
                brandsData.push({ 
                    name: name1, 
					 name2: name2,
					 name5: name4, 
					 name6: name5, 
                    y: y,
                    drilldown: name
                });
            });
          /*  $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });*/
			var lgrk = '';
			<?php if($_REQUEST['selectchart']=='pie'){?>
				lgrk = 'Pie Chart';
			<?php }else if($_REQUEST['selectchart']=='line'){?>
				lgrk = 'Line Graph';
			<?php }else if($_REQUEST['selectchart']=='bar'){?>
				lgrk = 'Bar Graph';
			<?php }else if($_REQUEST['selectchart']=='column'){?>
				lgrk = 'Plain tables';
			<?php }?>

            // Create the chart
            $('#container').highcharts({
                chart: {
                    type: '<?php echo $_REQUEST['selectchart'];?>'
                },
                title: {
                    text: lgrk
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
                            format: '{point.name} ({point.y:.2f}%)'
                        }
                    }
                },

                tooltip: {
					/*headerFormat: '{series.name}',*/
                    pointFormat: 'Number :: <span style="color:{point.color}">{point.name6}</span><br />Total :: <span style="color:{point.color}">{point.name5}</span><br />Percentage :: {point.y:.1f}%</b> of total</span>'
                }, 

                series: [{
                    name: 'Number',
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
<pre id="tsv" style="display: none;">	Line	
<?php foreach($arrbn as $arrbnval){
	$valk = $arrbnval['indicator'].'++=='.$arrbnval['mainval'].'++=='.$arrbnval['mainvaltot'].'++=='.$arrbnval['mainval'];
	echo $valk.'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
	//echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x09;'.$arrbnval['mainval'].'&#x0A;';
 }?>
</pre>
<?php
	}else{ echo '<div style="color:red;text-align: center;font-weight:bold;">No Result Found</div>';}	die();
	}
	if($_REQUEST['checkval']=='standardized_report_enrolled'){
		$tablename = 'form_a';
		$fields = 'id';
		$fields .= ', ecd_treated_children_total, total_enrolled_in_register, non_enrolled_total';
		$where = '1=1';
		//echo $_REQUEST['selectdistrict'];
		if(isset($_REQUEST['selectdistrict']) && !empty($_REQUEST['selectdistrict'])){
			//$selectdistrict = explode('+++==+++',$_REQUEST['selectdistrict']);
			$where .= ' AND district="'.$_REQUEST['selectdistrict'].'"';
		}
		$insertformdatav = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		/*echo '<pre>';
		print_r($insertformdatav);
		echo '</pre>';*/
		//echo $_REQUEST['female'];
		//die();
		//$keysum = 0;
		$arrbn = array();
		$enrolled_total = 0;
		$non_enrolled_total = 0;
		if(count($insertformdatav)>0){
		foreach($insertformdatav as $insertformdata){
				if(isset($insertformdata['ecd_treated_children_total']) && !empty($insertformdata['ecd_treated_children_total'])){
					$enrolled_total = $enrolled_total+$insertformdata['ecd_treated_children_total'];
				}
				if(isset($insertformdata['total_enrolled_in_register']) && !empty($insertformdata['total_enrolled_in_register'])){
					$enrolled_total = $enrolled_total + $insertformdata['total_enrolled_in_register'];
				}
				if(isset($insertformdata['non_enrolled_total']) && !empty($insertformdata['non_enrolled_total'])){
					$non_enrolled_total = $non_enrolled_total + $insertformdata['non_enrolled_total'];
				}
		}
		$chart_total = $enrolled_total + $non_enrolled_total;
		if(isset($enrolled_total) && !empty($enrolled_total)){
				$arrbn[] = array('indicator'=>'Enrolled',
								 'percentage'=>(($enrolled_total/$chart_total)*100),
								 'mainval'=>$enrolled_total,
								 'mainvaltot'=>$chart_total);
			}
			if(isset($non_enrolled_total) && !empty($non_enrolled_total)){
				$arrbn[] = array('indicator'=>'Non Enrolled',
								 'percentage'=>(($non_enrolled_total/$chart_total)*100),
								 'mainval'=>$non_enrolled_total,
								 'mainvaltot'=>$chart_total);
				}
		
		//echo '<pre>';print_r($arrbn);echo '</pre>';
		
		$_REQUEST['selectchart'] ='pie';
		
?>
		<script type="text/javascript">
$(function () {
//alert(document.getElementById('tsv').innerHTML);
Highcharts.data({
        csv: document.getElementById('tsvenrolled').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {
var b = columns[2];
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
                    //name = name.split('sdfsdfsdfsdfsdfsdfsd')[0];

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

            $.each(brands, function (name, y, b) {
				name1 = name.split('++==')[0];
				name2 = name.split('++==')[1];
				//name3 = decode_base64(name2);
				name4 = name.split('++==')[2];
				name5 = name.split('++==')[3];
				//name5 = decode_base64(name4);
				//alert(name5);
                brandsData.push({ 
                    name: name1, 
					 name2: name2,
					 name5: name4, 
					 name6: name5, 
                    y: y,
                    drilldown: name
                });
            });
          /*  $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });*/
			var lgrk = '';
			<?php if($_REQUEST['selectchart']=='pie'){?>
				lgrk = 'Enrollment Status';
			<?php }else if($_REQUEST['selectchart']=='line'){?>
				lgrk = 'Line Graph';
			<?php }else if($_REQUEST['selectchart']=='bar'){?>
				lgrk = 'Bar Graph';
			<?php }else if($_REQUEST['selectchart']=='column'){?>
				lgrk = 'Plain tables';
			<?php }?>

            // Create the chart
            $('#containerenrolled').highcharts({
                chart: {
                    type: '<?php echo $_REQUEST['selectchart'];?>'
                },
                title: {
                    text: lgrk
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
                            format: '{point.name} ({point.y:.2f}%)'
                        }
                    }
                },

                tooltip: {
					/*headerFormat: '{series.name}',*/
                    pointFormat: 'Number :: <span style="color:{point.color}">{point.name6}</span><br />Total :: <span style="color:{point.color}">{point.name5}</span><br />Percentage :: {point.y:.1f}%</b> of total</span>'
                }, 

                series: [{
                    name: 'Number',
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
<pre id="tsvenrolled" style="display: none;">	Line	
<?php foreach($arrbn as $arrbnval){
	$valk = $arrbnval['indicator'].'++=='.$arrbnval['mainval'].'++=='.$arrbnval['mainvaltot'].'++=='.$arrbnval['mainval'];
	echo $valk.'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
	//echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x09;'.$arrbnval['mainval'].'&#x0A;';
 }?>
</pre>
<?php
	}else{ echo '<div style="color:red;text-align: center;font-weight:bold;">No Result Found</div>';}	die();
	}
	if($_REQUEST['checkval']=='standardized_report_age'){
		$tablename = 'form_a';
		$fields = 'id';
		$fields .= ', years_2_5_male,years_2_5_female,years_6_10_male,years_6_10_female,years_11_14_male,years_11_14_female,years_15_18_male,years_15_18_female';
		$where = '1=1';
		//echo $_REQUEST['selectdistrict'];
		if(isset($_REQUEST['selectdistrict']) && !empty($_REQUEST['selectdistrict'])){
			//$selectdistrict = explode('+++==+++',$_REQUEST['selectdistrict']);
			$where .= ' AND district="'.$_REQUEST['selectdistrict'].'"';
		}
		$insertformdatav = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		/*echo '<pre>';
		print_r($insertformdatav);
		echo '</pre>';*/
		//echo $_REQUEST['female'];
		//die();
		//$keysum = 0;
		$arrbn = array();
		$child_under_5 = 0;
		$child_over_5 = 0;
		if(count($insertformdatav)>0){
		foreach($insertformdatav as $insertformdata){
				if(isset($insertformdata['years_2_5_male']) && !empty($insertformdata['years_2_5_male'])){
					$child_under_5 = $child_under_5+$insertformdata['years_2_5_male'];
				}
				if(isset($insertformdata['years_2_5_female']) && !empty($insertformdata['years_2_5_female'])){
					$child_under_5 = $child_under_5+$insertformdata['years_2_5_female'];
				}
				if(isset($insertformdata['years_6_10_male']) && !empty($insertformdata['years_6_10_male'])){
					$child_over_5 = $child_over_5+$insertformdata['years_6_10_male'];
				}
				if(isset($insertformdata['years_6_10_female']) && !empty($insertformdata['years_6_10_female'])){
					$child_over_5 = $child_over_5+$insertformdata['years_6_10_female'];
				}
				if(isset($insertformdata['years_11_14_male']) && !empty($insertformdata['years_11_14_male'])){
					$child_over_5 = $child_over_5+$insertformdata['years_11_14_male'];
				}
				if(isset($insertformdata['years_11_14_female']) && !empty($insertformdata['years_11_14_female'])){
					$child_over_5 = $child_over_5+$insertformdata['years_11_14_female'];
				}
				if(isset($insertformdata['years_15_18_male']) && !empty($insertformdata['years_15_18_male'])){
					$child_over_5 = $child_over_5+$insertformdata['years_15_18_male'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$child_over_5 = $child_over_5+$insertformdata['years_15_18_female'];
				}
		}
		$chart_total = $child_under_5 + $child_over_5;
		if(isset($child_under_5) && !empty($child_under_5)){
				$arrbn[] = array('indicator'=>'Children under 5',
								 'percentage'=>(($child_under_5/$chart_total)*100),
								 'mainval'=>$child_under_5,
								 'mainvaltot'=>$chart_total);
			}
			if(isset($child_over_5) && !empty($child_over_5)){
				$arrbn[] = array('indicator'=>'Children over 5 ',
								 'percentage'=>(($child_over_5/$chart_total)*100),
								 'mainval'=>$child_over_5,
								 'mainvaltot'=>$chart_total);
				}
		
		//echo '<pre>';print_r($arrbn);echo '</pre>';
		$_REQUEST['selectchart'] ='pie';
?>
		<script type="text/javascript">
$(function () {
//alert(document.getElementById('tsv').innerHTML);
Highcharts.data({
        csv: document.getElementById('tsvage').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {
var b = columns[2];
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
                    //name = name.split('sdfsdfsdfsdfsdfsdfsd')[0];

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

            $.each(brands, function (name, y, b) {
				name1 = name.split('++==')[0];
				name2 = name.split('++==')[1];
				//name3 = decode_base64(name2);
				name4 = name.split('++==')[2];
				name5 = name.split('++==')[3];
				//name5 = decode_base64(name4);
				//alert(name5);
                brandsData.push({ 
                    name: name1, 
					 name2: name2,
					 name5: name4, 
					 name6: name5, 
                    y: y,
                    drilldown: name
                });
            });
          /*  $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });*/
			var lgrk = '';
			<?php if($_REQUEST['selectchart']=='pie'){?>
				lgrk = 'Age Bracket';
			<?php }else if($_REQUEST['selectchart']=='line'){?>
				lgrk = 'Line Graph';
			<?php }else if($_REQUEST['selectchart']=='bar'){?>
				lgrk = 'Bar Graph';
			<?php }else if($_REQUEST['selectchart']=='column'){?>
				lgrk = 'Plain tables';
			<?php }?>

            // Create the chart
            $('#containerage').highcharts({
                chart: {
                    type: '<?php echo $_REQUEST['selectchart'];?>'
                },
                title: {
                    text: lgrk
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
                            format: '{point.name} ({point.y:.2f}%)'
                        }
                    }
                },

                tooltip: {
					/*headerFormat: '{series.name}',*/
                    pointFormat: 'Number :: <span style="color:{point.color}">{point.name6}</span><br />Total :: <span style="color:{point.color}">{point.name5}</span><br />Percentage :: {point.y:.1f}%</b> of total</span>'
                }, 

                series: [{
                    name: 'Number',
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
<pre id="tsvage" style="display: none;">	Line	
<?php foreach($arrbn as $arrbnval){
	$valk = $arrbnval['indicator'].'++=='.$arrbnval['mainval'].'++=='.$arrbnval['mainvaltot'].'++=='.$arrbnval['mainval'];
	echo $valk.'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
	//echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x09;'.$arrbnval['mainval'].'&#x0A;';
 }?>
</pre>
<?php
	}else{ echo '<div style="color:red;text-align: center;font-weight:bold;">No Result Found</div>';}	die();
	}
	if($_REQUEST['checkval']=='standardized_report_sex'){
		$tablename = 'form_a';
		$fields = 'id';
		$fields .= ', ecd_treated_male,ecd_treated_female,years_2_5_male,years_2_5_female,years_6_10_male,years_6_10_female,years_11_14_male,years_11_14_female,years_15_18_male,years_15_18_female,enrolled_male,enrolled_female';
		$where = '1=1';
		//echo $_REQUEST['selectdistrict'];
		if(isset($_REQUEST['selectdistrict']) && !empty($_REQUEST['selectdistrict'])){
			//$selectdistrict = explode('+++==+++',$_REQUEST['selectdistrict']);
			$where .= ' AND district="'.$_REQUEST['selectdistrict'].'"';
		}
		$insertformdatav = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		/*echo '<pre>';
		print_r($insertformdatav);
		echo '</pre>';*/
		//echo $_REQUEST['female'];
		//die();
		//$keysum = 0;
		$arrbn = array();
		$male = 0;
		$female = 0;
		if(count($insertformdatav)>0){
		foreach($insertformdatav as $insertformdata){
				if(isset($insertformdata['ecd_treated_male']) && !empty($insertformdata['ecd_treated_male'])){
					$male = $male+$insertformdata['ecd_treated_male'];
				}
				if(isset($insertformdata['years_2_5_male']) && !empty($insertformdata['years_2_5_male'])){
					$male = $male+$insertformdata['years_2_5_male'];
				}
				if(isset($insertformdata['years_6_10_male']) && !empty($insertformdata['years_6_10_male'])){
					$male = $male+$insertformdata['years_6_10_male'];
				}
				
				if(isset($insertformdata['years_11_14_male']) && !empty($insertformdata['years_11_14_male'])){
					$male = $male+$insertformdata['years_11_14_male'];
				}
				if(isset($insertformdata['years_15_18_male']) && !empty($insertformdata['years_15_18_male'])){
					$male = $male+$insertformdata['years_15_18_male'];
				}
				if(isset($insertformdata['enrolled_male']) && !empty($insertformdata['enrolled_male'])){
					$male = $male+$insertformdata['enrolled_male'];
				}
				
				
				if(isset($insertformdata['ecd_treated_female']) && !empty($insertformdata['ecd_treated_female'])){
					$female = $female+$insertformdata['ecd_treated_female'];
				}
				if(isset($insertformdata['years_2_5_female']) && !empty($insertformdata['years_2_5_female'])){
					$female = $female+$insertformdata['years_2_5_female'];
				}
				if(isset($insertformdata['years_6_10_female']) && !empty($insertformdata['years_6_10_female'])){
					$female = $female+$insertformdata['years_6_10_female'];
				}
				if(isset($insertformdata['years_11_14_female']) && !empty($insertformdata['years_11_14_female'])){
					$female = $female+$insertformdata['years_11_14_female'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$female = $female+$insertformdata['years_15_18_female'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$female = $female+$insertformdata['years_15_18_female'];
				}
		}
		$chart_total = $male + $female;
		if(isset($male) && !empty($male)){
				$arrbn[] = array('indicator'=>'Male',
								 'percentage'=>(($male/$chart_total)*100),
								 'mainval'=>$male,
								 'mainvaltot'=>$chart_total);
			}
			if(isset($female) && !empty($female)){
				$arrbn[] = array('indicator'=>'Female',
								 'percentage'=>(($female/$chart_total)*100),
								 'mainval'=>$female,
								 'mainvaltot'=>$chart_total);
				}
		
		//echo '<pre>';print_r($arrbn);echo '</pre>';
		$_REQUEST['selectchart'] ='pie';
?>
		<script type="text/javascript">
$(function () {
//alert(document.getElementById('tsv').innerHTML);
Highcharts.data({
        csv: document.getElementById('tsvsex').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {
var b = columns[2];
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
                    //name = name.split('sdfsdfsdfsdfsdfsdfsd')[0];

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

            $.each(brands, function (name, y, b) {
				name1 = name.split('++==')[0];
				name2 = name.split('++==')[1];
				//name3 = decode_base64(name2);
				name4 = name.split('++==')[2];
				name5 = name.split('++==')[3];
				//name5 = decode_base64(name4);
				//alert(name5);
                brandsData.push({ 
                    name: name1, 
					 name2: name2,
					 name5: name4, 
					 name6: name5, 
                    y: y,
                    drilldown: name
                });
            });
          /*  $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });*/
			var lgrk = '';
			<?php if($_REQUEST['selectchart']=='pie'){?>
				lgrk = 'Sex';
			<?php }else if($_REQUEST['selectchart']=='line'){?>
				lgrk = 'Line Graph';
			<?php }else if($_REQUEST['selectchart']=='bar'){?>
				lgrk = 'Bar Graph';
			<?php }else if($_REQUEST['selectchart']=='column'){?>
				lgrk = 'Plain tables';
			<?php }?>

            // Create the chart
            $('#containersex').highcharts({
                chart: {
                    type: '<?php echo $_REQUEST['selectchart'];?>'
                },
                title: {
                    text: lgrk
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
                            format: '{point.name} ({point.y:.2f}%)'
                        }
                    }
                },

                tooltip: {
					/*headerFormat: '{series.name}',*/
                    pointFormat: 'Number :: <span style="color:{point.color}">{point.name6}</span><br />Total :: <span style="color:{point.color}">{point.name5}</span><br />Percentage :: {point.y:.1f}%</b> of total</span>'
                }, 

                series: [{
                    name: 'Number',
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
<pre id="tsvsex" style="display: none;">	Line	
<?php foreach($arrbn as $arrbnval){
	$valk = $arrbnval['indicator'].'++=='.$arrbnval['mainval'].'++=='.$arrbnval['mainvaltot'].'++=='.$arrbnval['mainval'];
	echo $valk.'&#x09;'.$arrbnval['percentage'].'%&#x0A;';
	//echo $arrbnval['indicator'].'&#x09;'.$arrbnval['percentage'].'%&#x09;'.$arrbnval['mainval'].'&#x0A;';
 }?>
</pre>
<?php
	}else{ echo '<div style="color:red;text-align: center;font-weight:bold;">No Result Found</div>';}	die();
	}
	if($_REQUEST['checkval']=='standardized_report_stats'){
		$tablename = 'form_a';
		$fields = 'id';
		$fields .= ', ecd_treated_male,ecd_treated_female,ecd_treated_children_total,years_2_5_male,years_2_5_female,years_6_10_male,years_6_10_female,years_11_14_male,years_11_14_female,years_15_18_male,years_15_18_female,non_enrolled_total,total_enrolled_in_register,enrolled_male,enrolled_female,enrolled_treated_total';
		$where = '1=1';
		//echo $_REQUEST['selectdistrict'];
		if(isset($_REQUEST['selectdistrict']) && !empty($_REQUEST['selectdistrict'])){
			//$selectdistrict = explode('+++==+++',$_REQUEST['selectdistrict']);
			$where .= ' AND district="'.$_REQUEST['selectdistrict'].'"';
		}
		$insertformdatav = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
		
		$arrbn = array();
		$children_dewormed = 0;
		$enrolled_children_dewormed = 0;
		$non_enrolled_children_dewormed = 0;		
		$children_5_and_under_dewormed = 0;		
		$children_over_5_dewormed = 0;		
		$male_children_dewormed = 0;
		$female_children_dewormed = 0;
		
		if(count($insertformdatav)>0){
		foreach($insertformdatav as $insertformdata){
				if(isset($insertformdata['ecd_treated_children_total']) && !empty($insertformdata['ecd_treated_children_total'])){
					$children_dewormed = $children_dewormed+$insertformdata['ecd_treated_children_total'];
				}
				if(isset($insertformdata['non_enrolled_total']) && !empty($insertformdata['non_enrolled_total'])){
					$children_dewormed = $children_dewormed+$insertformdata['non_enrolled_total'];
				}
				if(isset($insertformdata['enrolled_treated_total']) && !empty($insertformdata['enrolled_treated_total'])){
					$children_dewormed = $children_dewormed+$insertformdata['enrolled_treated_total'];
				}
				
				
				
				if(isset($insertformdata['ecd_treated_children_total']) && !empty($insertformdata['ecd_treated_children_total'])){
					$enrolled_children_dewormed = $enrolled_children_dewormed+$insertformdata['ecd_treated_children_total'];
				}
				if(isset($insertformdata['enrolled_treated_total']) && !empty($insertformdata['enrolled_treated_total'])){
					$enrolled_children_dewormed = $enrolled_children_dewormed+$insertformdata['enrolled_treated_total'];
				}
				
				
				
				
				
				
				if(isset($insertformdata['non_enrolled_total']) && !empty($insertformdata['non_enrolled_total'])){
					$non_enrolled_children_dewormed = $non_enrolled_children_dewormed+$insertformdata['non_enrolled_total'];
				}
				
				
				
				
				
				
				if(isset($insertformdata['years_2_5_male']) && !empty($insertformdata['years_2_5_male'])){
					$children_5_and_under_dewormed = $children_5_and_under_dewormed+$insertformdata['years_2_5_male'];
				}
				if(isset($insertformdata['years_2_5_female']) && !empty($insertformdata['years_2_5_female'])){
					$children_5_and_under_dewormed = $children_5_and_under_dewormed+$insertformdata['years_2_5_female'];
				}
				
				
				
				
				if(isset($insertformdata['years_6_10_male']) && !empty($insertformdata['years_6_10_male'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_6_10_male'];
				}
				if(isset($insertformdata['years_6_10_female']) && !empty($insertformdata['years_6_10_female'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_6_10_female'];
				}
				if(isset($insertformdata['years_11_14_male']) && !empty($insertformdata['years_11_14_male'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_11_14_male'];
				}
				if(isset($insertformdata['years_11_14_female']) && !empty($insertformdata['years_11_14_female'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_11_14_female'];
				}
				if(isset($insertformdata['years_15_18_male']) && !empty($insertformdata['years_15_18_male'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_15_18_male'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$children_over_5_dewormed = $children_over_5_dewormed+$insertformdata['years_15_18_female'];
				}
				
				
				
				
				
				
				
				if(isset($insertformdata['ecd_treated_male']) && !empty($insertformdata['ecd_treated_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['ecd_treated_male'];
				}	
				if(isset($insertformdata['years_2_5_male']) && !empty($insertformdata['years_2_5_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['years_2_5_male'];
				}						
				if(isset($insertformdata['years_6_10_male']) && !empty($insertformdata['years_6_10_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['years_6_10_male'];
				}
				if(isset($insertformdata['years_11_14_male']) && !empty($insertformdata['years_11_14_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['years_11_14_male'];
				}
				if(isset($insertformdata['years_15_18_male']) && !empty($insertformdata['years_15_18_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['years_15_18_male'];
				}
				if(isset($insertformdata['enrolled_male']) && !empty($insertformdata['enrolled_male'])){
					$male_children_dewormed = $male_children_dewormed+$insertformdata['enrolled_male'];
				}
				
				
				if(isset($insertformdata['ecd_treated_female']) && !empty($insertformdata['ecd_treated_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['ecd_treated_female'];
				}	
				if(isset($insertformdata['years_2_5_female']) && !empty($insertformdata['years_2_5_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['years_2_5_female'];
				}
				if(isset($insertformdata['years_6_10_female']) && !empty($insertformdata['years_6_10_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['years_6_10_female'];
				}	
				if(isset($insertformdata['years_11_14_female']) && !empty($insertformdata['years_11_14_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['years_11_14_female'];
				}
				if(isset($insertformdata['years_15_18_female']) && !empty($insertformdata['years_15_18_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['years_15_18_female'];
				}
				if(isset($insertformdata['enrolled_female']) && !empty($insertformdata['enrolled_female'])){
					$female_children_dewormed = $female_children_dewormed+$insertformdata['enrolled_female'];
				}
				
				
				
		}
	
				
		echo '<table border="1" cellpadding="1" cellspacing="1" width="50%" align="center">
					<tr>
						<td colspan="2">District Deworming Facts at a Glance</td>						
					</tr>
					<tr>
						<td width="80%">Children dewormed</td>
						<td width="20%">'.$children_dewormed.'</td>
					</tr>
					<tr>
						<td>Enrolled children dewormed</td>
						<td>'.$enrolled_children_dewormed.'</td>
					</tr>
					<tr>
						<td>Non-enrolled children dewormed</td>
						<td>'.$non_enrolled_children_dewormed.'</td>
					</tr>
					<tr>
						<td>Children 5 and under dewormed</td>
						<td>'.$children_5_and_under_dewormed.'</td>
					</tr>
					<tr>
						<td>Children over 5 dewormed</td>
						<td>'.$children_over_5_dewormed.'</td>
					</tr>
					<tr>
						<td>Male children dewormed</td>
						<td>'.$male_children_dewormed.'</td>
					</tr>
					<tr>
						<td>Female children dewormed</td>
						<td>'.$female_children_dewormed.'</td>
					</tr>
					
				</table>';
		
		
?>

<?php
	}else{ echo '<div style="color:red;text-align: center;font-weight:bold;">No Result Found</div>';}	die();
	}
}
?>