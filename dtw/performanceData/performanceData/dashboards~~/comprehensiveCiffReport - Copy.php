<!--================================================-->
<div id="dashboard">

  <div id="indicator">

    <div class="dashboard_menu">
      <div class="dashboard_export">
        <?php if ($priv_ciff_report >= 1) { ?>
          <a  href="exportExcelCiffReportKpi.php" class="btn btn-primary btn-small pink-color">Export To Excel</a>

          <a class="btn btn-primary btn-small pink-color" href="exportPdfCiffReport.php" target="_blank">Export To PDF</a>
        <?php } ?>
      </div>
      <div class="vclear"></div>
      <div class="dashboard_title">

        <h2>CIFF REPORT</h2>	

      </div>



    </div>

    <table id="hor-minimalist-b">

      <th scope="col">Indicator</th>

      <th scope="col">Total</th>
      
      <tr class="hilighter_tr">
        <td>
          No. of  children dewormed for STH once
        </td>
        <td class="td-left"><?php echo $row15 = number_format(sumSTH()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of districts covered for STH
        </td>
        <td class="td-left"><?php echo $row1 = number_format(numDistinctPlain('district_id', 'a_bysch')) ?></td>
      </tr>
      <tr>
        <td>
          No. of divisions covered for STH
        </td>
        <td class="td-left"><?php echo $row2 = number_format(numDistinctPlain('division_id', 'a_bysch')) ?></td>
      </tr>	
      <tr >
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row22 = number_format(sumArgs('a_bysch', 'a_trt_m', 'a_trt_f')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row23 = number_format(sumPlain('a_trt_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row24 = number_format(sumPlain('a_trt_f', 'a_bysch')); ?></td>

      </tr>
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row25 = number_format(sumNonEnrolled6andover('STH')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row26 = number_format(sumNonEnrolled6andoverMale('STH')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row27 = number_format(sumNonEnrolled6andoverFemale('STH')); ?></td>

      </tr>
      <tr>
        <td>
          No. of U5 children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row19 = number_format(sumUnder5()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row20 = number_format(sumUnder5Male()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row21 = number_format(sumUnder5Female()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of ALB estimated for STH
        </td>
        <td class="td-left"><?php echo $row14 = number_format(sumPlain('p_alb', 'p_bysch')) ?></td>

      </tr>	
      <tr>
      <tr class="hilighter_tr">
        <td>
        No. of children dewormed for Schisto once
        </td>
        <td class="td-left"><?php echo $row56 = number_format(sumSHISTO()) ?></td>

      </tr>
      <tr>
        <td>
          No. of divisions covered for Schisto
        </td>
        <td class="td-left"><?php echo $row44 = number_format(numDistinct('division_id', 'a_bysch', 'Yes')); ?></td>

      </tr>      
      <tr>
        <td>
          No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row59 = number_format(sumArgs('a_bysch', 'ap_trt_m', 'ap_trt_f', 'ap_ecd_f', 'ap_ecd_m')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row60 = number_format(sumArgs('a_bysch', 'ap_trt_m', 'ap_ecd_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row61 = number_format(sumArgs('a_bysch', 'ap_trt_f', 'ap_ecd_f')); ?></td>

      </tr>
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row63 = number_format(sumNonEnrolled6andover('SHISTO')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row64 = number_format(sumNonEnrolled6andoverMale('SHISTO')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row65 = number_format(sumNonEnrolled6andoverFemale('SHISTO')); ?></td>

      </tr>
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row22 = number_format(sumArgs('a_bysch', 'a_trt_m', 'a_trt_f')); ?></td>

      </tr>	
      <tr>
        <td>
          Estimated target population of STH
        </td>
        <td class="td-left"><?php echo $row10 = number_format(EstimatedTotalSTH()) ?></td>
      </tr>
      <tr>
        <td>
          Estimated No. of 'Enrolled Primary School' children for STH
        </td>
        <td class="td-left"><?php echo $row11 = number_format(sumPlain('p_pri_enroll', 'p_bysch')) ?></td>
      </tr>	
      <tr>
        <td>
          Estimated No. of 'Enrolled ECD' children for STH
        </td>
        <td class="td-left"><?php echo $row12 = number_format(sumPlain('p_ecd_enroll', 'p_bysch')) ?></td>
      </tr>
      <tr>
        <td>
          <!-- #CORRECT : all the schools are targeted for STH -->
          No. of schools targeted for STH
        </td>
        <td class="td-left"><?php echo $row4 = number_format(num('p_sch_id', 'p_bysch')) ?></td>
      </tr>	
      <tr>
        <td>
          No. of public schools for STH 
        </td>
        <td class="td-left"><?php echo $row5 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Public')); ?></td>
      </tr>	
      <tr>
        <td>
          No. of private schools for STH
        </td>
        <td class="td-left"><?php echo $row6 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Private')); ?></td>
      </tr>	
      <tr>
        <td>
          No. of 'other' schools for STH
        </td>
        <td class="td-left"><?php echo $row7 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'Other')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of 'no school type' schools for STH
        </td>
        <td class="td-left"><?php echo $row8 = number_format(numFlexible('s_prog_sch_id', 's_bysch', 's1_school_type', 'None')); ?></td>
      </tr>
      <tr>
        <td>
          No. of Enrolled Primary School Aged (including ECD) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row59 = number_format(sumArgs('a_bysch', 'ap_trt_m', 'ap_trt_f', 'ap_ecd_f', 'ap_ecd_m')); ?></td>

      </tr>  
      <tr>
        <td>
          Estimated target population of Schisto
        </td>
        <td class="td-left"><?php echo $row52 = number_format(EstimatedTotalSHISTO()); ?></td>

      </tr>     
      <tr>
        <td>
          Estimated No. of 'Enrolled Primary School' children for SCHISTO
        </td>
        <td class="td-left"><?php echo $row53 = number_format(sumEstimated('p_pri_enroll', 'Y')) ?></td>

      </tr>	     
      <tr>
        <td>
          Estimated No. of 'Enrolled ECD' children for SCHISTO
        </td>
        <td class="td-left"><?php echo $row54 = number_format(sumEstimated('p_ecd_enroll', 'Y')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of districts planned for SCHISTO
        </td>
        <td class="td-left"><?php echo $row50 = number_format(numDistinctP('district_id', 'Y')) ?></td>

      </tr>
      <tr>
        <td>
          No. of schools covered for Schisto
        </td>
        <td class="td-left"><?php echo $row45 = number_format(numDistinct('school_id', 'a_bysch', 'Yes')); ?></td>

      </tr>
      <tr>
        <td>
          No. of public schools for SCHISTO
        </td>
        <td class="td-left"><?php echo $row46 = number_format(numSchoolTypeS('Public', 'Yes')) ?></td>

      </tr>
      <tr>
        <td>
          No. of private schools for SCHISTO
        </td>
        <td class="td-left"><?php echo $row47 = number_format(numSchoolTypeS('Private', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of 'other' schools for SCHISTO
        </td>
        <td class="td-left"><?php echo $row48 = number_format(numSchoolTypeS('Other', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of 'no school type' schools for SCHISTO
        </td>
        <td class="td-left"><?php echo $row49 = number_format(numSchoolTypeS('Not specified', 'Yes')) ?></td>

      </tr>
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row25 = number_format(sumNonEnrolled6andover('STH')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row26 = number_format(sumNonEnrolled6andoverMale('STH')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 6-18) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row27 = number_format(sumNonEnrolled6andoverFemale('STH')); ?></td>

      </tr>      
      <tr>
        <td>
          No. of Non-enrolled (age 6-10) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row28 = number_format(sumNonEnrolledGender('a_6', 'a_bysch')) ?></td>

      </tr>      
      <tr>
        <td>
          No. of Non-enrolled (age 11-14) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row31 = number_format(sumNonEnrolledGender('a_11', 'a_bysch')) ?></td>

      </tr>     
      <tr>
        <td>
          No. of Non-enrolled (age 15-18) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row34 = number_format(sumNonEnrolledGender('a_15', 'a_bysch')) ?></td>

      </tr>	      
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row63 = number_format(sumNonEnrolled6andover('SHISTO')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row64 = number_format(sumNonEnrolled6andoverMale('SHISTO')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row65 = number_format(sumNonEnrolled6andoverFemale('SHISTO')); ?></td>

      </tr>
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row66 = number_format(sumNonEnrolledGender('ap_6', 'a_bysch')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row69 = number_format(sumNonEnrolledGender('ap_11', 'a_bysch')) ?></td>

      </tr>
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row72 = number_format(sumNonEnrolledGender('ap_15', 'a_bysch')) ?></td>

      </tr>      
      <tr>
        <td>
          No. of U5 children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row19 = number_format(sumUnder5()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row20 = number_format(sumUnder5Male()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row21 = number_format(sumUnder5Female()); ?></td>

      </tr>     
      <tr>
        <td>
          No. of ECD children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row40 = number_format(sumArgs('a_bysch', 'a_ecd_m', 'a_ecd_f')); ?></td>

      </tr>	     
      <tr>
        <td>
          No. target schools attending teacher training sessions
        </td>
        <td class="td-left"><?php echo $row123 = $placeholder ?></td>

      </tr>	
      <tr>
        <td>
          <!-- #CORRECT : all the schools are targeted for STH -->
          No. of schools targeted for STH
        </td>
        <td class="td-left"><?php echo $row4 = number_format(num('p_sch_id', 'p_bysch')) ?></td>
      </tr>     
      <tr>
        <td>
          No. of TTs with requiered drugs
        </td>
        <td class="td-left">
          <?php echo $row127 = number_format(numFlexible('attnt_id', 'attnt_bysch', 'attnt_total_drugs', '1')) ?>
        </td>

      </tr>      
      <tr>
        <td>
          No. of schools attending teacher training
        </td>
        <td class="td-left">
          <?php echo $row124 = number_format(num('school_id', 'attnt_bysch')) ?>
        </td>
      </tr>     
      <tr>
        <td>
          No. of schools with critical materials present
        </td>
        <td class="td-left">
          <?php echo $row125 = number_format(attntWithCriticalMaterials()) ?>
        </td>

      </tr>	      
      <tr class="hilighter_tr">
        <td>
          % divisions correctly (+/- 10%) reporting on school level coverage of total children dewormed.
        </td>
        <td class="td-left"> <?php echo $row129 = $placeholder; ?></td>

      </tr>	
     <tr class="hilighter_tr">
        <td>
          % districts correctly (+/- 10%) reporting on school-level coverage of total children dewormed.
        </td>
        <td class="td-left"> <?php echo $row130 = $placeholder; ?></td>

      </tr>	      
      <tr class="hilighter_tr">
        <td>
          % Districts submitting forms S,A,and D to National level within three months of deworming day
        </td>
        <td class="td-left"> <?php echo $row128 = $placeholder; ?></td>

      </tr>	















      <tr>
        <td>
          <!-- #correct : all the schoolls are treated for STH -->
          No. of schools treated for STH
        </td>
        <td class="td-left"><?php echo $row3 = number_format(num('school_id', 'a_bysch')) ?></td>
      </tr>	

      <tr>
        <td>
          No. of schools  reporting to deworming on designated county deworming day
        </td>
        <td class="td-left"><?php echo $row9 = $placeholder ?></td>

      </tr>	


      <tr>
        <td>
          Estimated No. of 'Stand-alone ECD' children for STH
        </td>
        <td class="td-left"><?php echo $row13 = number_format(sumPlain('p_ecd_sa_enroll', 'p_bysch')) ?></td>

      </tr>	


      <tr>
        <td>
          No. of children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row16 = number_format(sumMaleFormA()) ?></td>
      </tr>	
      <tr>
        <td>
          No. of children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row17 = number_format(sumFemaleFormA()) ?></td>

      </tr>	
      <tr>
        <td>
          No. of children 6 and over receiving STH treatment
        </td>
        <td class="td-left"><?php echo $row18 = number_format(sum6andOverFormA()); ?></td>

      </tr>	




      <tr>
        <td>
          No. of Non-enrolled (age 6-10) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row29 = number_format(sumPlain('a_6_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 6-10) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row30 = number_format(sumPlain('a_6_f', 'a_bysch')); ?></td>

      </tr>	

      <tr>
        <td>
          No. of Non-enrolled (age 11-14) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row32 = number_format(sumPlain('a_11_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 11-14) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row33 = number_format(sumPlain('a_11_f', 'a_bysch')); ?></td>

      </tr>	

      <tr>
        <td>
          No. of Non-enrolled (age 15-18) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row35 = number_format(sumPlain('a_15_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non-enrolled (age 15-18) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row36 = number_format(sumPlain('a_15_f', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH
        </td>
        <td class="td-left"><?php echo $row37 = number_format(sumNonEnrolledGender('a_2', 'a_bysch')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row38 = number_format(sumPlain('a_2_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row39 = number_format(sumPlain('a_2_f', 'a_bysch')); ?></td>

      </tr>	

      <tr>
        <td>
          No. of ECD children dewormed for STH (male)
        </td>
        <td class="td-left"><?php echo $row41 = number_format(sumPlain('a_ecd_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH (female)
        </td>
        <td class="td-left"><?php echo $row42 = number_format(sumPlain('a_ecd_f', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of districts covered for Schisto
        </td>
        <td class="td-left"><?php echo $row43 = number_format(numDistinct('district_id', 'a_bysch', 'Yes')); ?></td>

      </tr>	





      <tr>
        <td>
          No. of schools planned (baseline) for SCHISTO
        </td>
        <td class="td-left"><?php echo $row51 = number_format(numDistinctP('p_sch_id', 'Y')); ?></td>

      </tr>	



      <tr>
        <td>
          Estimated No. of 'Stand-alone ECD' children for SCHISTO
        </td>
        <td class="td-left"><?php echo $row55 = number_format(sumEstimated('p_ecd_sa_enroll', 'Y')) ?></td>

      </tr>	

      <tr>
        <td>
          No. of children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row57 = number_format(sumMaleFormAP()); ?></td>

      </tr>	
      <tr>
        <td>
          No. of children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row58 = number_format(sumFemaleFormAP()); ?></td>

      </tr>	


      <tr>
        <td>
          No. of ECD children dewormed for Schisto
        </td>
        <td class="td-left"><?php echo $row62 = number_format(sumArgs('a_bysch', 'ap_ecd_f', 'ap_ecd_m')); ?></td>


      </tr>	


      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row67 = number_format(sumPlain('ap_6_m', 'a_bysch')); ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row68 = number_format(sumPlain('ap_6_f', 'a_bysch')); ?></td>


      </tr>	

      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row70 = number_format(sumPlain('ap_11_m', 'a_bysch')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row71 = number_format(sumPlain('ap_11_f', 'a_bysch')); ?></td>

      </tr>	

      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)
        </td>
        <td class="td-left"><?php echo $row73 = number_format(sumPlain('ap_15_m', 'a_bysch')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)
        </td>
        <td class="td-left"><?php echo $row74 = number_format(sumPlain('ap_15_f', 'a_bysch')) ?></td>

      </tr>	
      <tr>

        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row75 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_trt_m', 'a_trt_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row76 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_trt_f', 'a_trt_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row77 = number_format(sum('a_trt_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row78 = number_format(sumNonEnrolled6andoverByTreatment('STH')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row79 = number_format(sumNonEnrolled6andoverMaleByTreatment('shisto')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row80 = number_format(sumNonEnrolled6andoverFemaleShistoSchool('SHISTO', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row81 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_6_m', 'a_6_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row82 = number_format(sum('a_6_m', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row83 = number_format(sum('a_6_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row84 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_11_m', 'a_11_f')) ?></td>


      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row85 = number_format(sum('a_11_m', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row86 = number_format(sum('a_11_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row87 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_15_m', 'a_15_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row88 = number_format(sum('a_15_m', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row89 = number_format(sum('a_15_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row90 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_m', 'a_2_f', 'a_ecd_m', 'a_ecd_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in Schisto School(Male)
        </td>
        <td class="td-left"><?php echo $row91 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_m', 'a_ecd_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in Schisto School(Female)
        </td>
        <td class="td-left"><?php echo $row92 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_f', 'a_ecd_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row93 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_2_m', 'a_2_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)
        </td>
        <td class="td-left"><?php echo $row94 = number_format(sum('a_2_m', 'a_bysch', 'Yes')) ?></td>


      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)
        </td>
        <td class="td-left"><?php echo $row95 = number_format(sum('a_2_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH in Schisto School
        </td>
        <td class="td-left"><?php echo $row96 = number_format(sumArgsByTreatment('a_bysch', 'Yes', 'a_ecd_m', 'a_ecd_f')) ?></td>

      </tr>

      <tr>
        <td>
          No. of ECD children dewormed for STH in Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row97 = number_format(sum('a_ecd_m', 'a_bysch', 'Yes')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH in Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row98 = number_format(sum('a_ecd_f', 'a_bysch', 'Yes')) ?></td>

      </tr>	

      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row99 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_trt_m', 'a_trt_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row100 = number_format(sum('a_trt_m', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row101 = number_format(sum('a_trt_f', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row102 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_f', 'a_6_m', 'a_11_f', 'a_11_m', 'a_15_f', 'a_15_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row103 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_m', 'a_11_m', 'a_15_m')) ?></td>


      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row104 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_f', 'a_11_f', 'a_15_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row105 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_6_m', 'a_6_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row106 = number_format(sum('a_6_m', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row107 = number_format(sum('a_6_f', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row108 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_11_m', 'a_11_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row109 = number_format(sum('a_11_m', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row110 = number_format(sum('a_11_f', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row111 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_15_m', 'a_15_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row112 = number_format(sum('a_15_m', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row113 = number_format(sum('a_15_f', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row114 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_ecd_f', 'a_2_f', 'a_2_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in non-Schisto School(Male)
        </td>
        <td class="td-left"><?php echo $row115 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_2_m')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of U5 children dewormed for STH in non-Schisto School(Female)
        </td>
        <td class="td-left"><?php echo $row116 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_f', 'a_2_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row117 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_2_m', 'a_2_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)
        </td>
        <td class="td-left"><?php echo $row118 = number_format(sum('a_2_m', 'a_bysch', 'No')) ?></td>


      </tr>	
      <tr>
        <td>
          No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)
        </td>
        <td class="td-left"><?php echo $row119 = number_format(sum('a_2_f', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH in non-Schisto School
        </td>
        <td class="td-left"><?php echo $row120 = number_format(sumArgsByTreatment('a_bysch', 'No', 'a_ecd_m', 'a_ecd_f')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH in non-Schisto School (Male)
        </td>
        <td class="td-left"><?php echo $row121 = number_format(sum('a_ecd_m', 'a_bysch', 'No')) ?></td>

      </tr>	
      <tr>
        <td>
          No. of ECD children dewormed for STH in non-Schisto School (Female)
        </td>
        <td class="td-left"><?php echo $row122 = number_format(sum('a_ecd_f', 'a_bysch', 'No')) ?></td>

      </tr>	



      <tr>
        <td>
          No. of schools with no critical materials present
        </td>
        <td class="td-left">
          <?php echo $row126 = number_format(attntNoCriticalMaterials()) ?>
        </td>

      </tr>	






    </table>

  </div>

</div>

