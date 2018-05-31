<div class="col-md-10">

	<form action="<?php echo URL; ?>workshop/edit/<?php echo $list; ?>/<?php echo $record['id']; ?>" data-async data-target="myModal" method="post" role="form" id="modal-form">
		<div class="modal-body">
			<div class="row">
		        <div class="col-md-12">
			      	<?php

			      		foreach ($fields as $key => $value) {


							if ( $value['Key'] != 'PRI' ) {

								if ( $value['Key'] == 'MUL') {

						         	echo '<div class="form-group">
						            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
										<select name="'.$value['Field'].'" class="form-control input-sm" required>
											<option value="">Select '.ucwords( str_replace('_',' ',$value['Field']) ).'</option>';
											foreach ($value['parents'] as $key => $value_) {
												if ( $value_['id'] == $record[$value['Field']] ){
													echo'<option value="'.$value_['id'].'" selected>'.$value_[$value['Field']].'</option>';
												} else {
													echo'<option value="'.$value_['id'].'" >'.$value_[$value['Field']].'</option>';
												}													
											}
										echo '</select>
									</div>';

								} else if ( $value['Type'] == 'mediumtext') {

									$child_fields = explode(',', $value['Comment']);
									$child_values = unserialize($record[$value['Field']]);

									foreach ($child_fields as $key => $child_field) {

										echo '
								            <div class="form-group">
								            	<label>'.ucwords( str_replace('_',' ',$child_field ) ).'</label><br>
												<input type="text" name="'.$value['Field'].'['.$child_field.']" value="'.$child_values[$child_field].'" class="form-control input-sm"/>
											</div>
										';
									}

								} else if ( $value['Type'] == 'tinyint(1)') {

									echo '
							            <div class="form-group">
							            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
							            	<select name="'.$value['Field'].'" class="form-control input-sm">
							            		<option value="">True or False</option>
							            		<option value="0">False</option>
							            		<option value="1">True</option>
							            	</select>
										</div>
									';										

								} else if ( $value['Field'] == 'last_modified_on') {

									echo '
							            <div class="form-group">
							            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
											<input type="text" name="'.$value['Field'].'" value="'.$record[$value['Field']].'" class="form-control input-sm datepicker"/>
										</div>
									';										

								} else {

									echo '
							            <div class="form-group">
							            	<label>'.ucwords( str_replace('_',' ',$value['Field']) ).'</label><br>
											<input type="text" name="'.$value['Field'].'" value="'.$record[$value['Field']].'" class="form-control input-sm"/>
										</div>
									';
								}
							}
						}
					?>	
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="<?php echo URL; ?>workshop/index/<?php echo $list; ?>/" class="btn btn-default" data-dismiss="modal">Cancel</a>
			<button type="submit" class="btn btn-primary" name="update-dispenser-data" id="update-dispenser-data">Save</button>
		</div>
    </form>

</div>
<script type="text/javascript">	
	// arranges the modal into columnz
	autoColumn(3, '.modal-body .row', 'div', 'col-md-4');
</script>