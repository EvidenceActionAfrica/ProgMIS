<div class="col-md-9">

	<h3>Edit Delivery Details</h3>

	<div class="col-md-5">

		<form method="post" action="<?php echo URL; ?>cdelivery/editdelivery">
		<input type="hidden" name="country" value="<?php echo $_SESSION['country'] ?>">
			<div class="form-group">
				<label>Program/Batch Delivery</label>
				<input type="text" name="program" id="program" value="<?php echo explode('/', $_GET['url'])[2]; ?>" class="form-control" readonly/>
			</div>
			<div class="form-group">
				<label>Total Number of Water-points to be Visited</label>
				<input type="text" name="total_waterpoints" id="total_waterpoints" value="<?php echo $totalwaterpoints; ?>" class="form-control" readonly/>
			</div>
			<div class="form-group">
				<label>Number of Water-points per CSA per day</label>
				<input type="text" name="waterpoints_per_csa_per_day" value="<?php if (!empty($programdetails['waterpoints_per_csa_per_day'])) { echo $programdetails['waterpoints_per_csa_per_day']; } ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label>Number of Jerrycans per delivery</label>
				<input type="text" name="jerrycans_per_delivery" value="<?php if (!empty($programdetails['jerrycans_per_delivery'])) { echo $programdetails['jerrycans_per_delivery']; } ?>" class="form-control" />
			</div>
			<div class="form-group">
				<label>Start Date of Deliveries</label>
				<input type="text" name="start_date" value="<?php if (!empty($programdetails['start_date'])) { echo $programdetails['start_date']; } ?>" class="form-control datepicker" />
			</div>
			<div class="form-group">
				<label>Amount of money for fuel per CSA per DAY</label>
				<input type="text" name="fuel_cost_per_csa" value="<?php if (!empty($programdetails['fuel_cost_per_csa'])) { echo $programdetails['fuel_cost_per_csa']; } ?>" class="form-control" />
			</div>
			<div class="form-group">
				<button type="submit" name="save-delivery-details" class=" btn btn-default btn-primary btn-block" >Save Delivery Details</button>
			</div>
		</form>

	</div>

</div>