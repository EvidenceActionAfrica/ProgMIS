<?php require_once('config/include.php');
	  $evidenceaction = new EvidenceAction();
	  $evidenceaction->checksession();
	  //print_r($_SESSION);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include('config/head.php');?>
<title>Evidence Action :: Performance Data</title>
</head>
<body>

<div class="wrapperNwp">
	<!---------------- header start ------------------------>
    
    <?php include('config/header.php');?>
    
    <!---------------- header end ------------------------>
    
    <!---------------- body start ------------------------>
    
    <div class="bdyPrt">
<?php 
$tablename = 'county_table';
$fields = 'id, county';
$where = '1=1';
$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
//echo '<pre>';print_r($insertformdata);echo '</pre>';?>
<div class="secol">
Choose a Level:: <select onchange="if($('#selectlevel').val()=='County'){$('#sevlevel').css('display','block');}" id="selectlevel" name="selectlevel">
<option value="">Choose a Level</option>
<option value="National">National</option>
<option value="County">County</option>
</select>
</div>
<div class="secol" id="sevlevel" style="display: none;">
<div>
County :: <select onchange="get_district(this.value)" id="selectcounty" name="selectcounty">
<option value="">Choose County</option>
<?php 
foreach($insertformdata as $insertformdatacab){?>
	<option value="<?php echo 'COUN';if($insertformdatacab['id']<10){echo '0'.$insertformdatacab['id'];}else{echo $insertformdatacab['id'];}?>"><?php echo $insertformdatacab['county'];?></option>
<?php }?>
</select>
</div>
<div>
District :: <select onchange="get_division(this.value)" id="selectdistrict" name="selectdistrict">
<option value="">Choose District</option></select>
</div>
<div>
Division :: <select onchange="get_school(this.value)" id="selectdivision" name="selectdivision">
	<option value="">Choose Division</option>
</select>
</div>
<div>
School :: <select id="selectschool" name="selectschool">
	<option value="">Choose School</option>
</select>
</div>
</div>
<div class="secheck" id="secheck">
<div class="subbutcheck">
Select gender
Male <input type="checkbox" name="male" id="male" value="Male" class="checkval" />
Female <input type="checkbox" name="female" id="female" value="Female" class="checkval" />
</div>
<div class="subbutcheck">
Check the Age Group
2 - 4 yrs <input type="checkbox" name="twofouryrs" id="twofouryrs" value="Two - Four yrs" class="checkval" />
5 - 10 yrs <input type="checkbox" name="fivetenyrs" id="fivetenyrs" value="Five - Ten yrs" class="checkval" />
11 - 15 yrs <input type="checkbox" name="elevenfifyrs" id="elevenfifyrs" value="Eleven - Fifteen yrs" class="checkval" />
16 - 18 yrs <input type="checkbox" name="sixeightyrs" id="sixeightyrs"  value="Sixteen - Eighteen yrs" class="checkval" />
Adults <input type="checkbox" name="adults" id="adults" value="Adults" class="checkval" />
</div>
<div class="subbutcheck">
Dewormed status
Enrolled <input type="checkbox" name="enrolled" id="enrolled" value="Enrolled" class="checkval" />
Non-Enrolled <input type="checkbox" name="nonenrolled" id="nonenrolled" value="Non-Enrolled" class="checkval" />
</div>
<div class="subbutcheck">
Choose School Category
Private <input type="checkbox" name="private" id="private" value="Private" class="checkval" />
Public <input type="checkbox" name="public" id="public" value="Public" class="checkval" />
Other <input type="checkbox" name="other" id="other" value="Other" class="checkval" />
</div>
<div class="subbutcheck">
Select Treatment
SDH <input type="checkbox" name="sdh" id="sdh" value="SDH" class="checkval" />
Shisto <input type="checkbox" name="shisto" id="shisto" value="Shisto" class="checkval" />
</div>
<div class="subbutcheck">
Choose school's status
Treated <input type="checkbox" name="treated" id="treated" value="Treated" class="checkval" />
Not treated <input type="checkbox" name="nottreated" id="nottreated" value="Not treated" class="checkval" />
Trained <input type="checkbox" name="nonenrolled" id="nonenrolled" value="Non-Enrolled" class="checkval" />
Non trained <input type="checkbox" name="trained" id="trained" value="Trained" class="checkval" />
Planned <input type="checkbox" name="planned" id="planned" value="Planned" class="checkval" />
Not planned <input type="checkbox" name="notplanned" id="notplanned" value="Not planned" class="checkval" />
</div>
<div class="subbutcheck">
Select your display chart
<select id="selectchart" name="selectchart">
<option value="">Choose Chart</option>
<option value="Pie Chart">Pie Chart</option>
<option value="Line Graph">Line Graph</option>
</select>
</div>
<div class="subbutcheck" style="display: none;">
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
	//GET district
	function get_district(txt){
		$.post('report_ajax.php', {checkval:'district',county:txt}).done(function(data) {
			$('#selectdistrict').html(data);//alert(data);
		}); 
	}
	function get_division(txt){
		$.post('report_ajax.php', {checkval:'division',district:txt}).done(function(data) {
			$('#selectdivision').html(data);//alert(data);
		}); 
	}
	function get_school(txt){
		$.post('report_ajax.php', {checkval:'school',division:txt}).done(function(data) {
			$('#selectschool').html(data);//alert(data);
		}); 
	}
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
	$.post('report_ajax.php', {checkval:'county_table',county:$("#selectcounty").val(),enrolled_treated:enrolled_treated,schools_treated:schools_treated,non_enrolled_treated:non_enrolled_treated,under_5_treated:under_5_treated,adults_treated:adults_treated,females_treated:females_treated,total_child:total_child,children_treated:children_treated,total_non_enrolled:total_non_enrolled}).done(function(data) {
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