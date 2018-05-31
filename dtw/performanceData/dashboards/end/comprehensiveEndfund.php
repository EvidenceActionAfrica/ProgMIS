
        <!--================================================-->

        	<div id="dashboard">

				<div id="indicator">
				
					<div class="dashboard_menu">
						<div class="dashboard_export">
						<?php if($priv_end_fund>=1){?>
							<a class="btn btn-primary btn-small" href="exportExcelEndfund.php">Export To Excel</a>
						<?php }if($priv_end_fund>=1){?>

							<a class="btn btn-primary btn-small" href="exportPdfEndfundKpi.php" target="_blank">Export To PDF</a>
						<?php }?>

						</div>
						<div class="vclear"></div>
						<div class="dashboard_title">

							<h3>ENDFUND REPORT</h3>	

						</div>

						

					</div>

					<div class="bs-example">
					    <div class="panel-group" id="accordion">
						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <div data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
						        	<span class="col-md-6 indicator">No. of districts covered for STH </span>
						        	<span class="col-md-3 result">
						        	<?php echo number_format($ntd->numDistinctPlain('district_id','a_bysch')) ?>
						        	</span>
						        </div>
						      </h4>
						    </div>
						    <div id="collapseOne" class="panel-collapse collapse in">
						      <div class="panel-body">
									<table class="display" cellspacing="0" width="100%">
										<thead>
											<th>District Name</th>
											<th>County Name</th>
										</thead>
										<tbody>
						      	<?php 
						      		foreach ($ntd->getDistrictsTreatedForSTH() as $key => $value) {
						      			?>

				      					<tr>
				      						<td><?php  echo $value['district_name'];?></td>
				      						<td><?php  echo $value['county_name'];?></td>
				      					</tr>
						      			<?php
						      		}
						      	 ?>
						      	 		</tbody>
						      		</table>
						      </div>
						    </div>
						  </div>

						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
						        	<span class="col-md-6 indicator">No. of divisions covered for STH </span>
						        	<span class="col-md-3 result">
						        	<?php echo number_format($ntd->numDistinctPlain('division_id','a_bysch')) ?>
						        	</span>

						        	</a>
						      </h4>
						    </div>
						    <div id="collapseTwo" class="panel-collapse collapse">
						      <div class="panel-body">
						      	<table class="display" cellspacing="0" width="100%">
										<thead>
											<th>Division Name</th>
											<th>District Name</th>
											<th>County Name</th>
										</thead>
										<tbody>
						      	<?php 
						      		foreach ($ntd->getDivisionsTreatedForSTH() as $key => $value) {
						      			?>

				      					<tr>
				      						<td><?php  echo $value['division_name'];?></td>
				      						<td><?php  echo $value['district_name'];?></td>
				      						<td><?php  echo $value['county_name'];?></td>
				      					</tr>
						      			<?php
						      		}
						      	 ?>
						      	 		</tbody>
						      		</table>
						      </div>
						    </div>
						  </div>



						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
						        	<span class="col-md-6 indicator">No. of schools treated for STH </span>
						        	<span class="col-md-3 result">
						        	<?php echo number_format($ntd->global_num('school_id','a_bysch')) ?>
						        	</span>

						        	</a>
						      </h4>
						    </div>
						    <div id="collapseThree" class="panel-collapse collapse">
						      <div class="panel-body">
						      	<table class="display" cellspacing="0" width="100%">
										<thead>
											<th>School Name</th>
											<th>Division Name</th>
											<th>District Name</th>
											<th>County Name</th>
										</thead>
										<tbody>
						      	<?php 
						      		if (isset($_POST['table3'])) {
						      			echo "here";
						      			foreach ($ntd->getSchoolsTreatedForSTH() as $key => $value) {
							      			?>

					      					<tr>
					      						<td><?php  echo $value['a_school_name'];?></td>
					      						<td><?php  echo $value['division_name'];?></td>
					      						<td><?php  echo $value['district_name'];?></td>
					      						<td><?php  echo $value['county_name'];?></td>
					      					</tr>
							      			<?php
							      		}
						      		}
						      	 ?>
						      	 		</tbody>
						      		</table>
						      </div>
						    </div>
						  </div>


						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
						        	<span class="col-md-6 indicator">No. of schools targeted for STH</span>
						        	<span class="col-md-3 result">
						        	<?php echo number_format($ntd->global_num('p_sch_id','p_bysch')) ?>
						        	</span>

						        	</a>
						      </h4>
						    </div>
						    <div id="collapse4" class="panel-collapse collapse">
						      <div class="panel-body">
						      	<table class="display" cellspacing="0" width="100%">
										<thead>
											<th>School Name</th>
											<th>Division Name</th>
											<th>District Name</th>
											<th>County Name</th>
										</thead>
										<tbody>
						      	<?php 
						      		if (isset($_POST['table4'])) {
						      			echo "sdcsdcs";
						      			foreach ($ntd->getSchoolsPLannedForSTH() as $key => $value) {
						      			?>

				      					<tr>
				      						<td><?php  echo $value['p_sch_name'];?></td>
				      						<td><?php  echo $value['division_name'];?></td>
				      						<td><?php  echo $value['district_name'];?></td>
				      						<td><?php  echo $value['county_name'];?></td>
				      					</tr>
						      			<?php
						      		}
						      		}
						      	 ?>
						      	 		</tbody>
						      		</table>
						      </div>
						    </div>
						  </div>

						   <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" id="tar" data-parent="#accordion" href="#collapse5">
						        	<span class="col-md-6 indicator">Estimated target population of STH</span>
						        	<span class="col-md-3 result">
						        	<?php echo number_format($ntd->global_EstimatedTotalSTH()) ?>
						        	</span>

						        	</a>
						      </h4>
						    </div>
						    <div id="collapse5" class="panel-collapse collapse">
						      <div class="panel-body">
						      	<table class="display" cellspacing="0" width="100%">
										<thead>
											<th>School Name</th>
											<th>Division Name</th>
											<th>District Name</th>
											<th>County Name</th>
											<th>Enrolled Pri</th>
											<th>Enrolled ECD</th>
											<th>Enrolled ECD SA</th>
										</thead>
										<tbody>
											<div id="here"></div>
						      	<?php 

						      	if (isset($_POST['table'])) {
						      		echo "ows";
						      		foreach ($ntd->global_EstimatedTotalSTH_list() as $key => $value) {
						      			?>

				      					<tr>
				      						<td><?php  echo $value['p_sch_name'];?></td>
				      						<td><?php  echo $value['division_name'];?></td>
				      						<td><?php  echo $value['district_name'];?></td>
				      						<td><?php  echo $value['county_name'];?></td>
											<td><?php echo $value['p_pri_enroll']; ?></td>
											<td><?php echo $value['p_ecd_enroll']; ?></td>
											<td><?php echo $value['p_ecd_sa_enroll']; ?></td>
				      					</tr>
						      			<?php
						      		}
						      	}
						      		
						      	 ?>
						      	 		</tbody>
						      		</table>
						      </div>
						    </div>
						  </div>

						</div>
					</div> <!--End bs-example-->


<!-- end -->

					<table id="hor-minimalist-b">

						<th scope="col">Indicator</th>

						<th scope="col">Total</th>
						


						<!-- <tr>
							<td>
								No. of districts covered for STH
							</td>
							<td class="td-left"><?php echo number_format(numDistinctPlain('district_id','a_bysch')) ?></td>
						</tr> -->
						<!-- <tr>
							<td>
								No. of divisions covered for STH
							</td>
							<td class="td-left"><?php echo number_format(numDistinctPlain('division_id','a_bysch')) ?></td>
						</tr>	 -->
						<!-- <tr>
							<td>
								No. of schools treated for STH
							</td>
							<td class="td-left"><?php echo number_format(num('school_id','a_bysch')) ?></td>
						</tr>	 -->
						<!-- <tr>
							<td>
								No. of schools targeted for STH
							</td>
							<td class="td-left"><?php echo number_format(num('p_sch_id','p_bysch')) ?></td>
						</tr>	 -->
						<tr>
							<td>
								Estimated target population of STH
							</td>
							<td class="td-left"><?php echo number_format(EstimatedTotalSTH()) ?></td>
						</tr>
						<tr>
							<td>
								No. of districts covered for Schisto
							</td>
							<td class="td-left"><?php echo number_format(numDistinct('district_id','a_bysch','Yes')); ?></td>
						</tr>
						<tr>
							<td>
								No. of divisions covered for Schisto
							</td>
							<td class="td-left"><?php echo number_format(numDistinct('division_id','a_bysch','Yes')); ?></td>

						</tr>	
						<tr>
							<td>
								No. of schools covered for Schisto
							</td>
							<td class="td-left"><?php echo number_format(numDistinct('school_id','a_bysch','Yes')); ?></td>

						</tr>
						<tr>
							<td>
								No. of districts planned for SCHISTO
							</td>
							<td class="td-left"><?php echo number_format(numDistinctP('district_id','Y')) ?></td>
						</tr>
						<tr>
							<td>
								No. of schools planned (baseline) for SCHISTO
							</td>
							<td class="td-left"><?php echo number_format(numDistinctP('p_sch_id','Y')); ?></td>
						</tr>
						<tr>
							<td>
								No. of Adult Treated for STH
							</td>
							<td class="td-left"><?php echo number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9')); ?></td>
						</tr>
						<tr>
							<td>
								No. of Adult Treated for Schisto
							</td>
							<td class="td-left"><?php echo number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9')) ?></td>
						</tr>
						<tr>
							<td>
								No. of teachers trained
							</td>
							<td class="td-left"><?php echo $placeholder ?></td>
						</tr>
						<tr>
							<td>
								No. of schools attending teacher training
							</td>
							<td class="td-left"><?php echo number_format(num('school_id','attnt_bysch')) ?></td>
						</tr>
						<tr>
							<td>
								No. of TTs with requiered drugs
							</td>
							<td class="td-left"><?php echo number_format(attntWithCriticalMaterials('attnt_id')) ?></td>
						</tr>
						<tr>
							<td>
								No. of Gok district personnel at regional training
							</td>
							<td class="td-left"><?php echo $placeholder ?></td>
						</tr>
						<tr>
							<td>
								No. of Gok divisional personnel at regional training
							</td>
							<td class="td-left"><?php echo $placeholder ?></td>
						</tr>
							

					</table>

				</div>

			</div>

	



