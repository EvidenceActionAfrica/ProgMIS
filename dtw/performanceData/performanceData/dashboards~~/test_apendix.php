<?php 

include "includes/class.ntd.php";

$ntd=new ntd;

// $ntd->runKPIQuery();

$dara=$ntd->getAllApendix();
echo "Hello"; 
// echo "<pre>";var_dump($dara);echo "</pre>";
// exit();
foreach ($dara as $key => $value) {
		echo "<br>date = ".$value['date'];
		echo "<br>sth_pbysch = ".$value['sth_pbysch'];
		echo "<br>sth_abysch = ".$value['sth_abysch'];
		echo "<br>pzq_pbysch = ".$value['pzq_pbysch'];
		echo "<br>pzq_abysch = ".$value['pzq_abysch'];
		echo "<br>sth_over6_pbysch = ".$value['sth_over6_pbysch'];
		echo "<br>sth_over6_abysch = ".$value['sth_over6_abysch'];
		echo "<br>sth_over6_pbysch_percentage = ".$value['sth_over6_pbysch_percentage'];
		echo "<br>sth_over6_abysch_percentage = ".$value['sth_over6_abysch_percentage'];
		echo "<br>pzq_over6_pbysch = ".$value['pzq_over6_pbysch'];
		echo "<br>pzq_over6_abysch = ".$value['pzq_over6_abysch'];
		echo "<br>pzq_over6_pbysch_percentage = ".$value['pzq_over6_pbysch_percentage'];
		echo "<br>pzq_over6_abysch_percentage = ".$value['pzq_over6_abysch_percentage'];
		echo "<br>pzq_nonenrolled_pbysch = ".$value['pzq_nonenrolled_pbysch'];
		echo "<br>pzq_nonenrolledover6_abysch = ".$value['pzq_nonenrolledover6_abysch'];
		echo "<br>sumUnder5PbyschSTH = ".$value['sumUnder5PbyschSTH'];
		echo "<br>sth_under5 = ".$value['sth_under5'];
		echo "<br>target_school_attending_tt_planning = ".$value['target_school_attending_tt_planning'];
		echo "<br>target_school_attending_tt = ".$value['target_school_attending_tt'];
		echo "<br>tt_alb_pzq_available_day_of_training_planning = ".$value['tt_alb_pzq_available_day_of_training_planning'];
		echo "<br>tt_alb_pzq_available_day_of_training = ".$value['tt_alb_pzq_available_day_of_training'];
		echo "<br>schools_with_critical_tt_materials_planning = ".$value['schools_with_critical_tt_materials_planning'];
		echo "<br>schools_with_critical_tt_materials = ".$value['schools_with_critical_tt_materials'];
		echo "<br>percentage_parents_inteviwed_aeare_of_dd_planning = ".$value['percentage_parents_inteviwed_aeare_of_dd_planning'];
		echo "<br>percentage_parents_inteviwed_aeare_of_dd = ".$value['percentage_parents_inteviwed_aeare_of_dd'];
		echo "<br>percentage_ecd_centers_aware_about_dd_planning = ".$value['percentage_ecd_centers_aware_about_dd_planning'];
		echo "<br>percentage_ecd_centers_aware_about_dd = ".$value['percentage_ecd_centers_aware_about_dd'];
		echo "<br>percentage_schools_dewormed_on_designated_dd_planning = ".$value['percentage_schools_dewormed_on_designated_dd_planning'];
		echo "<br>percentage_schools_dewormed_on_designated_dd = ".$value['percentage_schools_dewormed_on_designated_dd'];
		echo "<br>percentage_districts_submitting_SAD_within_3months_planning = ".$value['percentage_districts_submitting_SAD_within_3months_planning'];
		echo "<br>percentage_districts_submitting_SAD_within_3months = ".$value['percentage_districts_submitting_SAD_within_3months'];
		echo "<br>percentage_div_reporting_children_dewormed_planning = ".$value['percentage_div_reporting_children_dewormed_planning'];
		echo "<br>percentage_div_reporting_children_dewormed = ".$value['percentage_div_reporting_children_dewormed'];
		echo "<br>percentage_districts_reporting_children_dewormed_planning = ".$value['percentage_districts_reporting_children_dewormed_planning'];
		echo "<br>percentage_districts_reporting_children_deworme = ".$value['percentage_districts_reporting_children_dewormed'];
		echo "<hr>";
}

 ?>