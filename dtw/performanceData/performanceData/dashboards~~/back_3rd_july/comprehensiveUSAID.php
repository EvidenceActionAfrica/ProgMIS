<div id="dashboard">
	<div id="indicator">
		<div class="dashboard_menu">
			<div class="dashboard_export">
			<?php if($priv_usaid>=1){?>
				<a class="btn btn-primary pink-color" href="exportExcelUsaidKpi.php">Export To Excel</a>
				<a class="btn btn-primary pink-color" href="exportPdfUsaidKpi.php" target="_blank">Export To PDF</a>
			<?php } ?>
			</div>
			<div class="vclear"></div>
			<div class="dashboard_title">
				<h3>USAID REPORT</h3>	
			</div>
		</div>
			<table id="hor-minimalist-b">
<th scope="col">Indicator</th>
<th scope="col">Total</th>
<tr>
<td>
No. of schools treated for STH
</td>
<td class="td-left"><?php echo $row1=number_format(num('school_id','a_bysch')) ?></td>
</tr>	
<tr>
<td>
No. of schools targeted for STH
</td>
<td class="td-left"><?php echo $row2=number_format(num('p_sch_id','p_bysch')) ?></td>
</tr>	
<tr>
<td>
Estimated target population of STH
</td>
<td class="td-left"><?php echo $row3=number_format(EstimatedTotalSTH()) ?></td>
</tr>
<tr>
<td>
No. of  children dewormed for STH once
</td>
<td class="td-left"><?php echo $row4=number_format(sumSTH()); ?></td>
</tr>
<tr>
<td>
No. of schools attending teacher training
</td>
<td class="td-left"><?php echo $row5=numDistinctPlain('school_id','attnt_bysch')?></td>
</tr>
<tr>
<td>
No. of schools with critical materials present
</td>
<td class="td-left"><?php echo $row6=number_format(attntWithCriticalMaterials()) ?></td>
</tr>
<tr>
<td>
No. of schools with poles
</td>
<td class="td-left"><?php echo $row7=number_format(numFlexible('school_id','attnt_bysch','attnt_total_poles','1')) ?></td>
</tr>
<tr>
<td class="kpi-not-done">
No. of TTs with requiered drugs
</td>
<td class="kpi-not-done"><?php echo $row8=number_format(numFlexible('attnt_id','attnt_bysch','attnt_total_drugs','1')) ?></td>
</tr>
<tr>
<td class="kpi-not-done">
No. of Gok district personnel at regional training
</td>
<td class="kpi-not-done"><?php echo $row9=$placeholder ?></td>
</tr>
<tr>
<td class="kpi-not-done">
No. of Gok divisional personnel at regional training
</td>
<td class="kpi-not-done"><?php echo $row10=$placeholder ?></td>
</tr>
			</table>
	</div>
</div>
