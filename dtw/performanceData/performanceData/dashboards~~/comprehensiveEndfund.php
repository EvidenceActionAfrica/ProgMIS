
        <!--================================================-->

        	<div id="dashboard">

				<div id="indicator">
				
					<div class="dashboard_menu">
						<div class="dashboard_export">
						<?php if($priv_end_fund>=1){?>
							<a class="btn btn-primary btn-small pink-color" href="exportExcelEndfund.php">Export To Excel</a>
						<?php }if($priv_end_fund>=1){?>

							<a class="btn btn-primary btn-small pink-color" href="exportPdfEndfundKpi.php" target="_blank">Export To PDF</a>
						<?php }?>

						</div>
						<div class="vclear"></div>
						<div class="dashboard_title">

							<h3>ENDFUND REPORT</h3>	

						</div>

						

					</div>

					<table id="hor-minimalist-b">

						<th scope="col">Indicator</th>

						<th scope="col">Total</th>
						


						<tr>
							<td>
								No. of districts covered for STH
							</td>
							<td class="td-left"><?php echo number_format(numDistinctPlain('district_id','a_bysch')) ?></td>
						</tr>
						<tr>
							<td>
								No. of divisions covered for STH
							</td>
							<td class="td-left"><?php echo number_format(numDistinctPlain('division_id','a_bysch')) ?></td>
						</tr>	
						<tr>
							<td>
								No. of schools treated for STH
							</td>
							<td class="td-left"><?php echo number_format(num('school_id','a_bysch')) ?></td>
						</tr>	
						<tr>
							<td>
								No. of schools targeted for STH
							</td>
							<td class="td-left"><?php echo number_format(num('p_sch_id','p_bysch')) ?></td>
						</tr>	
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

	



