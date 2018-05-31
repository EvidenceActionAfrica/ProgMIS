<div class="col-md-9">

	<h3>Edit CSA Amount Per Day</h3>

	<div class="col-md-5">

		<form method="post" action="<?php echo URL; ?>cdelivery/editexpenditure/<?php echo $amount.'/'.$csa.'/'.$date ?>">
		
			
			<div class="form-group">
				<label>Edit amount received by (<?php echo $csa; ?>) on (<?php echo $date; ?>)  </label>
				<input type="text" name="amount" value="<?php echo $amount ?>" class="form-control" />
			</div>
			<div class="form-group">
				<button type="submit" name="save" class=" btn btn-default btn-primary btn-block" >Save</button>
			</div>
		</form>

	</div>

</div>