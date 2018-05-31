<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
// include ('../../includes/config.php'); 
include "includes/class.ntd.php";
$ntd=new ntd;

if (isset($_POST['table'])) {
	echo "cows";	
		foreach ($ntd->global_EstimatedTotalSTH_list() as $key => $value) {
			
echo "<tr> <td>".$value['p_sch_name']."</td> <td>".$value['division_name']."</td> <td>".$value['district_name']."</td> <td>".$value['county_name']."</td> <td>".$value['p_pri_enroll']."</td> <td>".$value['p_ecd_enroll']."</td> <td>".$value['p_ecd_sa_enroll']."</td> </tr>";
		}	
	
	
		
		

}  // end if












 ?>