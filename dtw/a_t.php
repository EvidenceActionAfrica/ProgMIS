<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include"includes/auth.php";
include"includes/config.php";

$query="SELECT * FROM view_school_list_part_1";
$result=mysql_query("SELECT * FROM view_school_list_part_2_1") or die(mysql_error());
$data=array();
while($row=mysql_fetch_assoc($result)){

$data[]=array(
'school_id_part2'=>$row['school_id_part2'],
'district_id_part2'=>$row['district_id_part2'],
'county_id'=>$row['county_id'],
'estimatePopGrowth'=>$row['estimatePopGrowth'],
'estimateNonenroll'=>$row['estimateNonenroll'],
'estimateU5'=>$row['estimateU5'],
'totalChildrenTreated'=>$row['totalChildrenTreated'],
'total_adults'=>$row['total_adults'],
'total_drug_use'=>$row['total_drug_use'],
'tins'=>$row['tins'],
'tin_round_up'=>$row['tin_round_up'],
'tabs_round_up'=>$row['tabs_round_up'],
'spoilage_calc'=>$row['spoilage_calc'],
'spoilage_gap'=>$row['spoilage_gap'],
'add_for_spoilage'=>$row['add_for_spoilage'],
'alb_requisition'=>$row['alb_requisition'],
'estimate_shisto'=>$row['estimate_shisto'],
'estimate_non_enrolled_shisto'=>$row['estimate_non_enrolled_shisto'],
'total_children_treated_shisto'=>$row['total_children_treated_shisto'],
'total_tabs_for_children_shisto'=>$row['total_tabs_for_children_shisto'],
'total_adults_to_treat_shisto'=>$row['total_adults_to_treat_shisto'],
'total_tabs_for_adults_shisto'=>$row['total_tabs_for_adults_shisto'],
'total_drugs_use_shisto'=>$row['total_drugs_use_shisto'],
'tins_shisto'=>$row['tins_shisto'],
'round_up_tins_shisto'=>$row['round_up_tins_shisto'],
'tabs_in_tin_shisto'=>$row['tabs_in_tin_shisto'],
'spoilage_calc_shisto'=>$row['spoilage_calc_shisto'],
'spoilage_gap_shisto'=>$row['spoilage_gap_shisto'],
'to_add_spoilage_gap_shisto'=>$row['to_add_spoilage_gap_shisto'],
'pzq_requsition'=>$row['pzq_requsition'] );
}

echo "<pre>";var_dump($data);echo "</pre>";
?>