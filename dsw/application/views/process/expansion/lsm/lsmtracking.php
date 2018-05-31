<div class="col-md-9">

	<h3>Local Stakeholder Meeting</h3>

	<div class="table-responsive">

		<?php // if(isset($trackingdata)) { ?>

			<form action="<?php echo URL; ?>expansion/lsmtracking/" method="post">

				<div class="btn-group">
					<button type="submit" class="btn btn-default" name="edit-lsmdetails" <?php if(isset($editable) && $editable==true) { echo 'disabled'; } ?> >Edit</button>
					<button type="submit" class="btn btn-default" name="save-lsmdetails" <?php if(!isset($editable) || $editable==false) { echo 'disabled'; } ?> >Save</button>
				</div>

				<br>
				<br>
			
				<table class="table table-striped table-hover table-bordered" id="data-table">
					<thead>
						<tr>
							<th></th>
							<!-- <th>Sub Location</th>
							<th>Asst. Chief Name</th>
							<th>Asst. Chief Contacts</th>
							<th>DSW Staff Assigned</th> -->
							<th>LSM Title</th>
							<th>DSW Staff Assigned</th>
							<th>Venue</th>
							<th>Date</th>
							<th>Time</th>
							<th>Status</th>
							<th>Next Meeting Date</th>
							<th>No of Villages</th>
							<th>Expected No of People</th>
							<th>Actual No of People Present</th>
							<th>Estimated Reimbursement</th>
							<th>Actual Reimbursement</th>
							<th>No. of Nominated Wps</th>
							<th>No. of Eligible Wps</th>
							<th>Notes</th>
						</tr>
					</thead>
					<tbody>

						<?php $i=1; foreach ($trackingdata as $key => $value) { ?>	
							<tr>
								<td><?php echo $i; ?><input type="hidden" name="id[]" value="<?php echo $value['id']; ?>" ></td>
								<!-- <td></td>
								<td></td>
								<td></td>
								<td></td> -->
								<td><?php echo $value['lsm_title']; ?></td>
								<td>
									<?php 
										$officialArray = unserialize($value['officials']); 
										foreach ($officialArray as $key => $official) {
											 echo $official['official'].',';
										}
									?>
								</td>
								<td><?php echo $value['location']; ?></td>
								<td><?php echo $value['meeting_date']; ?></td>
								<td><?php echo $value['meeting_time']; ?></td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
											<select name="status[]" style="width:50px;">
												<option value="">Set Status</option>
												<option value="0">Incomplete</option>
												<option value="1">Complete</option>
											</select>
										<?php } else {
											if ($value['status']==0) {
												echo 'Incomplete';
											} else {
												echo 'Complete';
											}
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="next_meeting_date[]" value="<?php echo $value['next_meeting_date']; ?>" class="datepicker">
										<?php } else {
											echo $value['next_meeting_date'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="no_of_villages[]" value="<?php echo $value['no_of_villages']; ?>" >
										<?php } else {
											echo $value['no_of_villages'];
										} 
									?>
								</td>
								<td><?php echo sizeof(unserialize($value['officials'])); ?></td>
								<!-- <td><?php //echo $value['actual_no_of_people_present']; ?></td> -->
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="actual_no_of_people_present[]" value="<?php echo $value['actual_no_of_people_present']; ?>" >
										<?php } else {
											echo $value['actual_no_of_people_present'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="estimated_reimbursement[]" value="<?php echo $value['estimated_reimbursement']; ?>" >
										<?php } else {
											echo $value['estimated_reimbursement'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="actual_reimbursement[]" value="<?php echo $value['actual_reimbursement']; ?>" >
										<?php } else {
											echo $value['actual_reimbursement'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="no_of_nominated_wps[]" value="<?php echo $value['no_of_nominated_wps']; ?>" >
										<?php } else {
											echo $value['no_of_nominated_wps'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="no_of_eligible_wps[]" value="<?php echo $value['no_of_eligible_wps']; ?>" >
										<?php } else {
											echo $value['no_of_eligible_wps'];
										} 
									?>
								</td>
								<td>
									<?php
										if (isset($editable) && $editable == true) { ?>
										<input type="text" name="notes[]" value="<?php echo $value['notes']; ?>" >
										<?php } else {
											echo $value['notes'];
										} 
									?>
								</td>
							</tr>
						<?php $i++;} ?>

					</tbody>

				</table>

			</form>

		<?php //} else { ?>

			<!-- <p><strong>No Data Found</strong></p> -->

		<?php //} ?>

	</div>

</div>

<script type="text/javascript">
	$(document).ready(function() {
	  $('#data-table').dataTable({
	      "scrollY": "500px",	      
	      "scrollX": "500px",	   
	      "paging": false,  
	      "scrollCollapse": true,
		      "dom": 'T<"clear">lfrtip',
        	  "tableTools": {
            		"sSwfPath": "<?php echo URL; ?>public/swf/copy_csv_xls_pdf.swf",
            		"aButtons": [ "xls", "pdf" ]
        		}
		});
	});
</script>