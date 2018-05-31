<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>County</title>
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
	</head>
	<body>
<?php 
include('../config/dbconfig_reportengine.php');
include('../config/functions.php');
$evidenceaction = new EvidenceAction();
$tablename = 'county_table';
$fields = 'county';
$where = '1=1';
$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
//echo '<pre>';print_r($insertformdata);echo '</pre>';?>
<div class="secol">
Select County :: <select onchange="$('#secheck').css('display','block');$('#reportschart').html('');$('#container').html('');$('#containerbar').html('');" id="selectcounty" name="selectcounty">
<option value="">Choose County</option>
<?php 
foreach($insertformdata as $insertformdatacab){?>
	<option value="<?php echo $insertformdatacab['county'];?>"><?php echo $insertformdatacab['county'];?></option>
<?php }?>
</select>
</div>
<div class="secheck" id="secheck" style="display: none;">
<div class="subbutcheck">
Choose options to display
<input type="checkbox" name="enrolled_treated" id="enrolled_treated" value="enrolled_treated" class="checkval" />Enrolled Treated
<input type="checkbox" name="schools_treated" id="schools_treated" value="schools_treated" class="checkval" />Schools Treated
<input type="checkbox" name="non_enrolled_treated" id="non_enrolled_treated" value="non_enrolled_treated" class="checkval" />Non Enrolled Treated
<input type="checkbox" name="under_5_treated" id="under_5_treated"  value="under_5_treated" class="checkval" />Under 5 Treated
<input type="checkbox" name="adults_treated" id="adults_treated" value="adults_treated" class="checkval" />Adults Treated
<input type="checkbox" name="females_treated" id="females_treated" value="females_treated" class="checkval" />Females Treated
<!--<input type="checkbox" name="total_child" id="total_child" value="total_child" class="checkval" />Total Child-->
<input type="checkbox" name="children_treated" id="children_treated" value="children_treated" class="checkval" />Children Treated
<!--<input type="checkbox" name="total_non_enrolled" id="total_non_enrolled" value="total_non_enrolled" class="checkval" />Total Non Enrolled-->
</div>
<div class="subbut"><input  type="button" onclick="selectcounty();" value="Generate Report"/></div>
<div id="reportschart"></div>
</div>
	</body>
</html>
<script>
	function selectcounty(){
		var urlmn = '?checkval=county_table_pdf&county='+$("#selectcounty").val();
		if($("#enrolled_treated").is(":checked")==true){
			var enrolled_treated = $("#enrolled_treated").val(); 
			urlmn += '&enrolled_treated=enrolled_treated';
		}else{
			var enrolled_treated = '';
		}
		if($("#schools_treated").is(":checked")==true){
			var schools_treated = $("#schools_treated").val();
			urlmn += '&schools_treated=schools_treated';
		}else{
			var schools_treated = '';
		}
		if($("#non_enrolled_treated").is(":checked")==true){
			var non_enrolled_treated = $("#non_enrolled_treated").val(); 
			urlmn += '&non_enrolled_treated=non_enrolled_treated';
		}else{
			var non_enrolled_treated = '';
		}
		if($("#under_5_treated").is(":checked")==true){
			var under_5_treated = $("#under_5_treated").val(); 
			urlmn += '&under_5_treated=under_5_treated';
		}else{
			var under_5_treated = '';
		}
		if($("#adults_treated").is(":checked")==true){
			var adults_treated = $("#adults_treated").val(); 
			urlmn += '&adults_treated=adults_treated';
		}else{
			var adults_treated = '';
		}
		if($("#females_treated").is(":checked")==true){
			var females_treated = $("#females_treated").val(); 
			urlmn += '&females_treated=females_treated';
		}else{
			var females_treated = '';
		}
		if($("#total_child").is(":checked")==true){
			var total_child = $("#total_child").val();
			urlmn += '&total_child=total_child'; 
		}else{
			var total_child = '';
		}
		if($("#children_treated").is(":checked")==true){
			var children_treated = $("#children_treated").val(); 
			urlmn += '&children_treated=children_treated';
		}else{
			var children_treated = '';
		}
		if($("#total_non_enrolled").is(":checked")==true){
			var total_non_enrolled = $("#total_non_enrolled").val(); 
			urlmn += '&total_non_enrolled=total_non_enrolled';
		}else{
			var total_non_enrolled = '';
		}
	$.post('ajax.php', {checkval:'county_table',county:$("#selectcounty").val(),enrolled_treated:enrolled_treated,schools_treated:schools_treated,non_enrolled_treated:non_enrolled_treated,under_5_treated:under_5_treated,adults_treated:adults_treated,females_treated:females_treated,total_child:total_child,children_treated:children_treated,total_non_enrolled:total_non_enrolled}).done(function(data) {
			$('#reportschart').html(data);//alert(data);
			$('#downid').attr('href','generate_report_pdf.php'+urlmn);
		}); 	
}
</script>	
<script src="js/highcharts.js"></script>
<!--<script src="js/modules/exporting.js"></script>-->
<div id="container" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>
<script src="js/modules/data.js"></script>
<script src="js/modules/drilldown.js"></script>
<div id="containerbar" style="min-width: 1010px; height: 400px; margin: 0 auto"></div>
<!-- Data from www.netmarketshare.com. Select Browsers => Desktop share by version. Download as tsv. -->
<a id="downid" style="display: none;">Download PDF</a>	