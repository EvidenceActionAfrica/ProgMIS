<!-- <br> -->
<hr>
<form action="" method="get" class="form-horizontal col-md-11" role="form">

	<div class="form-group">

		<div class="col-md-2">
			<select name="donor" class="form-control" required>
				<option value="ALL"  <?php if (strpos($url,'comprehensiveAll.php') !== false) { echo "selected";} ?>>All</option>
				<option value="CIFF" <?php if (strpos($url,'comprehensiveCiffReport.php') !== false) { echo "selected";} ?>>CIFF</option>
				<option value="END" <?php if (strpos($url,'comprehensiveEndfund.php') !== false) { echo "selected";} ?>>END FUND</option>
			</select>
		</div>
		<div class="col-md-2">
			<input type="submit" name="submit-donor" value="CHOOSE DONOR" class="btn btn-default">
		</div>
	</div>
</form>
<div class="clearfix"></div>