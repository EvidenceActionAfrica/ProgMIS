<div id="dashboard">
	<div id="indicator">
		<div class="dashboard_menu">
			<div class="dashboard_export">
			<?php if($priv_usaid>=1){?>
				<a class="btn btn-primary pink-color" href="exportExcelWhoKpi.php">Export To Excel</a>
				<a class="btn btn-primary pink-color" href="exportPdfWhoKpi.php" target="_blank">Export To PDF</a>
			<?php }?>
			</div>
			<div class="vclear"></div>
			<div class="dashboard_title">
				<h3>WHO REPORT</h3>	
			</div>
		</div>
			<table id="hor-minimalist-b" />
<th scope="col">Indicator</th>
<th scope="col">Total</th>
<tr>
<td>
No. of teachers trained
</td>
<td class="td-left"><?php echo $row1=number_format(NotEmpty('t1_name','attnt_bysch')+NotEmpty('t2_name','attnt_bysch')) ?></td>
</tr>
<tr>
<td>
No. of schools attending teacher training
</td>
<td class="td-left"><?php echo $row2=number_format(numDistinctPlain('school_id','attnt_bysch')) ?></td>
</tr>
<tr>
<td>
No. of schools with critical materials present
</td>
<td class="td-left"><?php echo $row3=number_format(attntWithCriticalMaterials()) ?></td>
</tr>
<tr>
<td>
No. of schools with no critical materials present
</td>
<td class="td-left"><?php echo $row4=number_format(attntNoCriticalMaterials()) ?></td>
</tr>
<tr>
<td>
No. of TTs with requiered drugs
</td>
<td class="td-left">
<?php echo $row5=number_format(attntWithCriticalMaterials('attnt_id')) ?>
</td>
</tr>
<tr>
<td>
No. of district returning form ATTNR
</td>
<td><?php echo $row6=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form ATTNT
</td>
<td><?php echo $row7=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form S
</td>
<td class="td-left"><?php echo $row8=number_format(returnedForms('s_district_id')) ?></td>
</tr>
<tr>
<td>
No. of district returning form A
</td>
<td class="td-left"><?php echo  $row9=number_format(returnedFormA('district_id'))?></td>
</tr>
<tr>
<td>
No. of district returning form D
</td>
<td><?php echo $row10=$placeholder ?></td>
</tr>
<tr>
<td>
No. of district returning form Tabs
</td>
<td><?php echo $row11=$placeholder ?></td>
</tr>
			</table>
	</div>
</div>
