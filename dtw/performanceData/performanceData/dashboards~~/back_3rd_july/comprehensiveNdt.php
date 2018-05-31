
<div id="dashboard">

	<div id="indicator">

		<div class="dashboard_menu">
			<div class="dashboard_export">

				<a class="btn btn-primary" href="exportExcelNdtKpi.php">Export To Excel</a>

				<a class="btn btn-primary" href="exportPdfNdtKpi.php" target="_blank">Export To PDF</a>

			</div>
			<div class="vclear"></div>
			<div class="dashboard_title">

				<h2>NDT REPORT</h2>	

			</div>

		</div>

			<table id="hor-minimalist-b">

<th scope="col">Indicator</th>

<th scope="col">Total</th>



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
Estimated target population of STH
</td>
<td class="td-left"><?php echo number_format(EstimatedTotalSTH()) ?></td>
</tr>
<tr>
<td>
No. of  children dewormed for STH once
</td>
<td class="td-left"><?php echo number_format(sumSTH()); ?></td>

</tr>	

<tr>
<td>
No. of children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumMaleFormA()) ?></td>
</tr>	
<tr>
<td>
No. of children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumFemaleFormA()) ?></td>

</tr>	
<tr>
<td>
No. of children 6 and over receiving STH treatment
</td>
<td class="td-left"><?php echo number_format(sum6andOverFormA()); ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumUnder5()); ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumUnder5Male()); ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumUnder5Female()); ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumArgs('a_bysch','a_trt_m','a_trt_f')); ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_trt_m','a_bysch')) ;?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_trt_f','a_bysch')) ;?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-18) children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andover('STH'));?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-18) children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andoverMale('a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-18) children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andoverFemale('a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-10) children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('a_6','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-10) children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_6_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 6-10) children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_6_f','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 11-14) children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('a_11','a_bysch'))  ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 11-14) children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_11_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 11-14) children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_11_f','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 15-18) children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('a_15','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 15-18) children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_15_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non-enrolled (age 15-18) children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_15_f','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('a_2','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_2_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_2_f','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of ECD children dewormed for STH
</td>
<td class="td-left"><?php echo number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f')); ?></td>

</tr>	
<tr>
<td>
No. of ECD children dewormed for STH (male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_ecd_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of ECD children dewormed for STH (female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('a_ecd_f','a_bysch')); ?></td>

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
Estimated target population of Schisto
</td>
<td class="td-left"><?php echo number_format(EstimatedTotalSHISTO()); ?></td>
</tr>
<tr>
<td>
No. of children dewormed for Schisto once
</td>
<td class="td-left"><?php echo number_format(sumSHISTO()) ?></td>

</tr>	
<tr>
<td>
No. of children dewormed for Schisto (Male)
</td>
<td class="td-left"><?php echo number_format(sumMaleFormAP()); ?></td>

</tr>	
<tr>
<td>
No. of children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumFemaleFormAP()); ?></td>

</tr>	
<!-- <tr>
<td>
No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
</td>
<td><?php echo sumEnrolled('form_ap') ;?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Male)
</td>
<td><?php echo sumEnrolledGenderSHISTO('male'); ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Female)
</td>
<td><?php echo sumEnrolledGenderSHISTO('male'); ?></td>

</tr>	 -->
<tr>
<td>
No. of ECD children dewormed for Schisto
</td>
<td class="td-left"><?php echo number_format(sumArgs('a_bysch','ap_ecd_f','ap_ecd_m')); ?></td>


</tr>	
<tr>
<td>
No. of ECD children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_ecd_f','a_bysch')) ?></td>
</tr>
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for Schisto
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andover('SHISTO')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andoverMale('SHISTO')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolled6andoverFemale('SHISTO')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for Schisto
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('ap_6','a_bysch')) ?></td>

</tr>
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_6_m','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_6_f','a_bysch')); ?></td>


</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for Schisto
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('ap_11','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_11_m','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_11_f','a_bysch')); ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for Schisto
</td>
<td class="td-left"><?php echo number_format(sumNonEnrolledGender('ap_15','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_15_m','a_bysch')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)
</td>
<td class="td-left"><?php echo number_format(sumPlain('ap_15_f','a_bysch')) ?></td>

</tr>
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_m','a_trt_f')) ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_f','a_trt_m')) ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_trt_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sum('a_6_18_total','a_bysch','Yes')) ?></td>

</tr>		
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo  number_format(sumNonEnrolled6andoverMaleByTreatment('shisto')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_6_18_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_6_m','a_6_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_6_m','a_bysch','Yes')) ?></td>

</tr>
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_6_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_11_m','a_11_f')) ?></td>


</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_11_m','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_11_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_15_m','a_15_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_15_m','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_15_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_f','a_ecd_m','a_ecd_f')) ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH in Schisto School(Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_u5_m','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH in Schisto School(Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_u5_f','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_m')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_2_m','a_bysch','Yes')) ?></td>


</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_2_f','a_bysch','Yes')) ?></td>

</tr>		
<tr>
<td>
No. of ECD children dewormed for STH in Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_ecd_m','a_ecd_f')) ?></td>

</tr>

<tr>
<td>
No. of ECD children dewormed for STH in Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_ecd_m','a_bysch','Yes')) ?></td>

</tr>	
<tr>
<td>
No. of ECD children dewormed for STH in Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_ecd_f','a_bysch','Yes')) ?></td>

</tr>	

<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_trt_m','a_trt_f')) ?></td>

</tr>
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_trt_m','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_trt_f','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_6_m','a_11_f','a_11_m','a_15_f','a_15_m')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)
</td>
<td class="td-left"><?php echo  number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_11_m','a_15_m')) ?></td>


</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_11_f','a_15_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_6_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_6_m','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_6_f','a_bysch','No')) ?></td>

</tr>		
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_11_m','a_11_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_11_m','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_11_f','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_15_m','a_15_f')) ?></td>

</tr>		
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_15_m','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_15_f','a_bysch','No')) ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH in non-Schisto School(Male)
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_2_m')) ?></td>

</tr>	
<tr>
<td>
No. of U5 children dewormed for STH in non-Schisto School(Female)
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_ecd_f','a_2_f')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School
</td>
<td class="td-left"><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_2_f','a_2_m')) ?></td>

</tr>	
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)
</td>
<td class="td-left"><?php echo number_format(sum('a_2_m','a_bysch','No')) ?></td>


</tr>		
<tr>
<td>
No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)
</td>
<td class="td-left"><?php echo number_format(sum('a_2_f','a_bysch','No')) ?></td>
</tr>
<tr>
<td>
No. of Adult Treated for STH
</td>
<td class="td-left"><?php echo number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9')) ?></td>
</tr>
<tr>
<td>
No. of Adult Treated for Schisto
</td>
<td class="td-left"><?php echo number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9')) ?></td>
</tr>






			</table>

</div>

</div>


