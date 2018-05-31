<!-- <html>
<head> -->
     <!-- <title>jQuery UI Accordion - Default functionality</title> -->
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"> -->
  <!-- // <script src="js/jquery-1.10.2.js"></script> -->
  <script src="js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#accordion" ).accordion({ header: "h3" });
  });
  </script>

  <?php 

//   require_once ('../../includes/config.php'); // use root
// include "queryFunctions.php";

 ?>
<!-- </head>
<body> -->
    <div id="accordion">


    <div class="row_s">
        <h3>No. of divisions covered for STH</h3>
        <div>
            <p><?php echo number_format(numDistinctPlain('division_id','a_bysch')) ?></p>
        </div>
        <hr>
    </div>
    <div class="row_s">
        No. of schools treated for STH
        <div>
        <p><?php echo number_format(num('school_id','a_bysch')) ?></p>
        </div>
    </div>
    <hr>
   <div class="row_s">
        Estimated target population of STH
        <div>
            <p><?php echo number_format(EstimatedTotalSTH()) ?></p>
        </div>
   </div>


    <h3>STH TREATMENT</h3>
    <div class="row_s">
        <span>
            No. of  children dewormed for STH once
            <div>
            <p><?php echo number_format(sumSTH()); ?></p>
            </div>
        </span>

        No. of children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumMaleFormA()) ?></p>
        </div>
         
        
        
        No. of children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumFemaleFormA()) ?></p>
        </div>
        <HR>
    </div>
 
         


    <div class="row_s">
        No. of children 6 and over receiving STH treatment
        <div>
        <p><?php echo number_format(sum6andOverFormA()); ?></p>
        </div>
    </div>
 
    <h3>Children Under 5 for STH</h3>
    <div class="row_s">
        No. of U5 children dewormed for STH
        <div>
        <p><?php echo number_format(sumUnder5()); ?></p>
        </div>
         
        No. of U5 children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumUnder5Male()); ?></p>
        </div>
         
        No. of U5 children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumUnder5Female()); ?></p>
        </div>
    </div>
    
    <h3>No. of Enrolled Primary School Aged children dewormed for STH</h3>
    <div class="row_s">
        No. of Enrolled Primary School Aged children dewormed for STH
        <div>
        <p><?php echo number_format(sumArgs('a_bysch','a_trt_m','a_trt_f')); ?></p>
        </div>
         
        No. of Enrolled Primary School Aged children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_trt_m','a_bysch')) ;?></p>
        </div>
         
        No. of Enrolled Primary School Aged children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_trt_f','a_bysch')) ;?></p>
        </div>
    </div>
    
    <h3>No. of Non-enrolled (age 6-18) children  for STH</h3>
    <div class="row_s">
        No. of Non-enrolled (age 6-18) children dewormed for STH
        <div>
        <p><?php echo number_format(sumNonEnrolled6andover('STH'));?></p>
        </div>
         
        No. of Non-enrolled (age 6-18) children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumNonEnrolled6andoverMale('a_bysch')); ?></p>
        </div>
         
        No. of Non-enrolled (age 6-18) children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumNonEnrolled6andoverFemale('a_bysch')); ?></p>
        </div>
    </div>
 
    <h3>No. of Non-enrolled (age 6-10) children dewormed for STH</h3>
    <div class="row_s">
        No. of Non-enrolled (age 6-10) children dewormed for STH
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('a_6','a_bysch')) ?></p>
        </div>
         
        No. of Non-enrolled (age 6-10) children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_6_m','a_bysch')); ?></p>
        </div>
         
        No. of Non-enrolled (age 6-10) children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_6_f','a_bysch')); ?></p>
        </div>
    </div>


    <h3>No. of Non-enrolled (age 11-14) children dewormed for STH</h3>
    <div>
        No. of Non-enrolled (age 11-14) children dewormed for STH
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('a_11','a_bysch'))  ?></p>
        </div>
         
        No. of Non-enrolled (age 11-14) children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_11_m','a_bysch')); ?></p>
        </div>
         
        No. of Non-enrolled (age 11-14) children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_11_f','a_bysch')); ?></p>
        </div>
    </div>
    
    <h3>No. of Non-enrolled (age 15-18) children dewormed for STH</h3>
    <div class="row_s">
        No. of Non-enrolled (age 15-18) children dewormed for STH
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('a_15','a_bysch')) ?></p>
        </div>
         
        No. of Non-enrolled (age 15-18) children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_15_m','a_bysch')); ?></p>
        </div>
         
        No. of Non-enrolled (age 15-18) children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_15_f','a_bysch')); ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 2-5) children dewormed for STH</h3>
    <div class="row_s">
        No. of Non Enrolled (age 2-5) children dewormed for STH
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('a_2','a_bysch')) ?></p>
        </div>
         
        No. of Non Enrolled (age 2-5) children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_2_m','a_bysch')); ?></p>
        </div>
         
        No. of Non Enrolled (age 2-5) children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_2_f','a_bysch')); ?></p>
        </div>
    </div>


    <h3>No. of ECD children dewormed for STH</h3>
    <div class="row_s">
        No. of ECD children dewormed for STH
        <div>
        <p><?php echo number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f')); ?></p>
        </div>
         
        No. of ECD children dewormed for STH (male)
        <div>
        <p><?php echo number_format(sumPlain('a_ecd_m','a_bysch')); ?></p>
        </div>
         
        No. of ECD children dewormed for STH (female)
        <div>
        <p><?php echo number_format(sumPlain('a_ecd_f','a_bysch')); ?></p>
        </div>
    </div>

    <div class="row_s">
        No. of districts covered for Schisto
        <div>
        <p><?php echo number_format(numDistinct('district_id','a_bysch','Yes')); ?></p>
        </div>
    </div>
     
    <div class="row_s">
        No. of divisions covered for Schisto
        <div>
        <p><?php echo number_format(numDistinct('division_id','a_bysch','Yes')); ?></p>
        </div>
    </div>
 
    <div class="row_s">
        No. of schools covered for Schisto
        <div>
        <p><?php echo number_format(numDistinct('school_id','a_bysch','Yes')); ?></p>
        </div>
    </div>

    <div class="row_s">
        Estimated target population of Schisto
        <div>
        <p><?php echo number_format(EstimatedTotalSHISTO()); ?></p>
        </div>
    </div>

    <h3>No. of children dewormed for Schisto once</h3>
    <div class="row_s">
        No. of children dewormed for Schisto once
        <div>
        <p><?php echo number_format(sumSHISTO()) ?></p>
        </div>
         
        No. of children dewormed for Schisto (Male)
        <div>
        <p><?php echo number_format(sumMaleFormAP()); ?></p>
        </div>
         
        No. of children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumFemaleFormAP()); ?></p>
        </div>
    </div>

    <h3>No. of ECD children dewormed for Schisto</h3>
    <div class="row_s">
        No. of ECD children dewormed for Schisto
        <div>
        <p><?php echo number_format(sumArgs('a_bysch','ap_ecd_f','ap_ecd_m')); ?></p>
        </div>
         
        No. of ECD children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumPlain('ap_ecd_f','a_bysch')) ?></p>
        </div>
    </div>

    <h3>No. of Non Enrolled (age 6-18) children dewormed for Schisto</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-18) children dewormed for Schisto
        <div>
        <p><?php echo number_format(sumNonEnrolled6andover('SHISTO')); ?></p>
        </div>
         
        No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)
        <div>
        <p><?php echo number_format(sumNonEnrolled6andoverMale('SHISTO')); ?></p>
        </div>
         
        No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumNonEnrolled6andoverFemale('SHISTO')); ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 6-10) children dewormed for Schisto</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-10) children dewormed for Schisto
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('ap_6','a_bysch')) ?></p>
        </div>
        No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)
        <div>
        <p><?php echo number_format(sumPlain('ap_6_m','a_bysch')); ?></p>
        </div>
         
        No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumPlain('ap_6_f','a_bysch')); ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 11-14) children dewormed for Schisto</h3>
    <div class="row_s">
        No. of Non Enrolled (age 11-14) children dewormed for Schisto
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('ap_11','a_bysch')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)
        <div>
        <p><?php echo number_format(sumPlain('ap_11_m','a_bysch')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumPlain('ap_11_f','a_bysch')); ?></p>
        </div>
    </div>
 
    <h3>No. of Non Enrolled (age 15-18) children dewormed for Schisto</h3>
    <div class="row_s">
        No. of Non Enrolled (age 15-18) children dewormed for Schisto
        <div>
        <p><?php echo number_format(sumNonEnrolledGender('ap_15','a_bysch')) ?></p>
        </div>
         
        No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)
        <div>
        <p><?php echo number_format(sumPlain('ap_15_m','a_bysch')) ?></p>
        </div>
         
        No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)
        <div>
        <p><?php echo number_format(sumPlain('ap_15_f','a_bysch')) ?></p>
        </div>
    </div>

    <h3>No. of Enrolled Primary School Aged children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Enrolled Primary School Aged children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_m','a_trt_f')) ?></p>
        </div>
         
        No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_f','a_trt_m')) ?></p>
        </div>
         
        No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_trt_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sum('a_6_18_total','a_bysch','Yes')) ?></p>
        </div>
           
        No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo  number_format(sumNonEnrolled6andoverMaleByTreatment('shisto')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_6_18_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_6_m','a_6_f')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_6_m','a_bysch','Yes')) ?></p>
        </div>
        No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_6_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_11_m','a_11_f')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_11_m','a_bysch','Yes')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_11_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_15_m','a_15_f')) ?></p>
        </div>
         
        No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_15_m','a_bysch','Yes')) ?></p>
        </div>
         
        No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_15_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of U5 children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of U5 children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_f','a_ecd_m','a_ecd_f')) ?></p>
        </div>
         
        No. of U5 children dewormed for STH in Schisto School(Male)
        <div>
        <p><?php echo number_format(sum('a_u5_m','a_bysch','Yes')) ?></p>
        </div>
         
        No. of U5 children dewormed for STH in Schisto School(Female)
        <div>
        <p><?php echo number_format(sum('a_u5_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_m')) ?></p>
        </div>
         
        No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)
        <div>
        <p><?php echo number_format(sum('a_2_m','a_bysch','Yes')) ?></p>
        </div>
         
        No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)
        <div>
        <p><?php echo number_format(sum('a_2_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of ECD children dewormed for STH in Schisto School</h3>
    <div class="row_s">
        No. of ECD children dewormed for STH in Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','Yes','a_ecd_m','a_ecd_f')) ?></p>
        </div>
        No. of ECD children dewormed for STH in Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_ecd_m','a_bysch','Yes')) ?></p>
        </div>
         
        No. of ECD children dewormed for STH in Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_ecd_f','a_bysch','Yes')) ?></p>
        </div>
    </div>
    
    <h3>No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School</h3>
    <div class="row_s">
        No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_trt_m','a_trt_f')) ?></p>
        </div>
        No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_trt_m','a_bysch','No')) ?></p>
        </div>
         
        No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_trt_f','a_bysch','No')) ?></p>
        </div>
    </div>  
    
    <h3>No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_6_m','a_11_f','a_11_m','a_15_f','a_15_m')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)
        <div>
        <p><?php echo  number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_11_m','a_15_m')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_11_f','a_15_f')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_6_f')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_6_m','a_bysch','No')) ?></p>
        </div>
         
        No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_6_f','a_bysch','No')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_11_m','a_11_f')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_11_m','a_bysch','No')) ?></p>
        </div>
         
        No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_11_f','a_bysch','No')) ?></p>
        </div>
    </div>
 
    <div class="row_s">
        No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_15_m','a_15_f')) ?></p>
        </div>
           
        No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)
        <div>
        <p><?php echo number_format(sum('a_15_m','a_bysch','No')) ?></p>
        </div>
         
        No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)
        <div>
        <p><?php echo number_format(sum('a_15_f','a_bysch','No')) ?></p>
        </div>
    </div>
    
    <h3>No. of U5 children dewormed for STH in non-Schisto School(Male)</h3>
    <div class="row_s">
        No. of U5 children dewormed for STH in non-Schisto School(Male)
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_2_m')) ?></p>
        </div>
         
        No. of U5 children dewormed for STH in non-Schisto School(Female)
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_ecd_f','a_2_f')) ?></p>
        </div>
    </div>
    
    <h3>No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School</h3>
    <div class="row_s">
        No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School
        <div>
        <p><?php echo number_format(sumArgsByTreatment('a_bysch','No','a_2_f','a_2_m')) ?></p>
        </div>
         
        No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)
        <div>
        <p><?php echo number_format(sum('a_2_m','a_bysch','No')) ?></p>
        </div>
           
        No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)
        <div>
        <p><?php echo number_format(sum('a_2_f','a_bysch','No')) ?></p>
        </div>
    </div>

    <div class="row_s">
        No. of Adult Treated for STH
        <div>
        <p><?php echo number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9')) ?></p>
        </div>
        No. of Adult Treated for Schisto
        <div>
        <p><?php echo number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9')) ?></p>
        </div>
    </div>
</div> <!--End accordion-->
<!-- </body>
</html> -->
  <script src="js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  // $(function() { 
  //   $( "#accordion" ).accordion({ header: "h3" });
  // });
  </script>

  <script>
    $(document).on('ready', function(){
        $("#accordion").accordion({ header: "h3" });
    });
</script>