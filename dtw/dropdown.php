<?php
require_once ('includes/auth.php');
require_once ('includes/config.php');
require_once ("includes/functions.php");
?>
<script src="js/jquery.min.js"></script>


<?php
require_once('includes/db_functions.php');
$evidenceaction = new EvidenceAction();
?>

<?php
$tablename = 'counties';
$fields = 'id, county';
$where = '1=1';
$insertformdata = $evidenceaction->mysql_fetch_all($tablename, $fields, $where);
?>


<label>Country</label>
<select onchange="get_district(this.value);" id="selectcounty" name="selectcounty" class="input_select">
  <option value="">Choose County</option>
  <?php foreach ($insertformdata as $insertformdatacab) { ?>
    <option value="<?php echo $insertformdatacab['county']; ?>"><?php echo $insertformdatacab['county']; ?></option>
  <?php } ?>
</select>


<label>District</label>
<select onchange="get_division(this.value);" id="selectdistrict" name="selectdistrict" class="input_select">
  <option value="">Choose District</option>
</select>


<label>Division</label>
<select onchange="get_school(this.value);" id="selectdivision" name="selectdivision" class="input_select" >
  <option value="">Choose Division</option>
</select>


<label>School</label>
<select id="selectschool" name="selectschool">
  <option value="">Choose School</option>
</select>

<script>
	  //GET district
	  function get_district(txt) {
		$.post('ajax_dropdown.php', {checkval: 'district', county: txt}).done(function(data) {
		  $('#selectdistrict').html(data);//alert(data);
		});
	  }
	  //GET divisions
	  function get_division(txt) {
		$.post('ajax_dropdown.php', {checkval: 'division', district: txt}).done(function(data) {
		  $('#selectdivision').html(data);//alert(data);
		});
	  }
	  //GET Schools
	  function get_school(txt) {
		$.post('ajax_dropdown.php', {checkval: 'school', division: txt}).done(function(data) {
		  $('#selectschool').html(data);//alert(data);
		});
	  }
</script>



















<!--================================================-->
</div><!--end of content Main -->
</div>
<div class="clearFix"></div>
<!---------------- Footer ------------------------>
<!--<div class="footer">  </div>-->
</body>
</html>



