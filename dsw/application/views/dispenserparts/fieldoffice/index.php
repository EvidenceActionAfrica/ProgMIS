<div class="col-md-10">
	<div class="clearfix">
		<h3 class="pull-left">Dispenser Parts Field Office</h3>
		<div class="btn-group pull-right">
			<div class="btn-group">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2">New Dispenser Part Field Office</button>
				<!-- <a class="btn btn-default" href="<?php // echo URL; ?>assetData/export/<?php // echo $inventory_type_id ?>">Export CSV</a> -->
			</div>
		</div>
	</div>

	<hr>

	<?php  if (!empty($data)) { ?>
		<div class="table-responsive">
			<table id="data-table" class="table table-hover">
				<thead>
					<tr>
						<th></th>
						<?php
							foreach ($fields as $key => $value) { 
								if($value['Key']!='PRI') {
									echo '<th>'.ucwords(str_replace('_',' ',$value['Field']) ).'</th>';
								}
							}
						?>
						<th></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i=1;
						foreach ($data as $key => $value) {
							echo '<tr> <td>'.$i.'</td>';
								foreach ($fields as $key => $value_) {
									if($value_['Key']!='PRI') {
										if($value_['Key']=='MUL') {
											foreach ($value_['parents'] as $key => $value__) {
												if ($value__['id'] == $value[$value_['Field']] ) {
													echo '<td>'.$value__[$value_['Field']].'</td>';
												}
											}
										} else {
											echo '<td>'.$value[$value_['Field']].'</td>';
										}
									}
								} ?>
								<td><a href="<?php echo URL; ?>fieldoffice/edit/<?php echo $value['id']; ?>" class="btn btn-default btn-sm">Edit</a></td>
								<td><a href="<?php echo URL; ?>fieldoffice/delete/<?php echo $value['id']; ?>" class="btn btn-default btn-sm">Delete</a></td>
							<?php echo '</tr>';
						$i++; }
					?>
				</tbody>
			</table>
		</div>
	<?php } else { ?>
		<p><b>No Record Found</b></p>
	<?php } ?>

</div>
<script type="text/javascript">
  $(document).ready(function() {
      $('#data-table').dataTable({
          "scrollY": "400px",
          "scrollX": "100%",
          "scrollCollapse": true
  	});
  });
</script>

<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Dispenser Parts Field Office</h4>
				<div id="error-msg"></div>
			</div>
			<form action="<?php echo URL; ?>fieldoffice/add" data-async data-target="myModal" method="post" role="form" id="modal-form">
				<div class="modal-body">
					<div class="row">
				        <div class="col-md-12">
					      	<?php
					      		foreach ($fields as $key => $value) {
									if ( $value['Key'] == 'PRI' ) {
										if (isset($single_record)) {
											echo '<input type="hidden" value="'.$single_record[$x].'" name="'.$value['Field'].'"/>';
										}else{
										echo '<input type="hidden" value="" name="'.$value['Field'].'"/>';
										}
									} else if ( $value['Key'] == 'MUL') {
								         echo '
								         	<div class="form-group">
								            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
												<select name="'.$value['Field'].'" class="form-control input-sm" required><option value="">Select '.ucwords( str_replace('_',' ',$value['Field']) ).'</option>';
													foreach ($value['parents'] as $key => $value_) {
														if ( $value_[$value['Field']] == $inventory_type ){
															echo'<option value="'.$value_['id'].'" selected>'.$value_[$value['Field']].'</option>';
														} else {
															echo'<option value="'.$value_['id'].'" >'.$value_[$value['Field']].'</option>';
														}
															
													}
												echo '</select>
											</div>';
									} else {
										echo '
								            <div class="form-group">
								            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
												<input type="text" name="'.$value['Field'].'" value="" class="form-control input-sm"/>
											</div>
										';
									}
								}
							?>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary" name="add-dispenser-data" id="add-dispenser-data">Save</button>
				</div>
	        </form>
	    </div>
	</div>
</div>
<script type="text/javascript">	
	// arranges the modal into columns
	$('#myModal2').on('show.bs.modal', function (e) {

		autoColumn(3, '#myModal2 .modal-body .row', 'div', 'col-md-4');

	});
</script>
<script type="text/javascript">	

	var userInput = $('input[name="quantity_stocked"],input[name="quantity_used"],input[name="quantity_spoilt"]');
	var recInput = $('input[name="quantity_received"]');

	userInput.attr('readonly','true');

	recInput.change(function() {

		var qtyRec = parseFloat( recInput.val() );
		if ( qtyRec > 0 ) {
			userInput.removeAttr('readonly');
		} else {
			userInput.attr('readonly','true');
		}

		userInput.change(function() {

			var qtyStocked = parseFloat( $('input[name="quantity_stocked"]').val() ),
				qtyUsed = parseFloat( $('input[name="quantity_used"]').val() ),
				qtySpoilt = parseFloat( $('input[name="quantity_spoilt"]').val() ),
				qtyTotal = qtyStocked + qtyUsed + qtySpoilt;

			if (qtyTotal>qtyRec) {
				userInput.css('border-color','red');
				$('#add-dispenser-data').addClass('disabled');
				$('#error-msg').html('<p class="bg-danger text-center text-muted" style="padding:7px 0;"><em>Total quantity stocked,used and spoilt should not be greater that quantity received</em></p>');
			} else {
				userInput.css('border-color','#ccc');
				$('#add-dispenser-data').removeClass('disabled');
				$('#error-msg').html('');
			}

		});

	});
</script>
