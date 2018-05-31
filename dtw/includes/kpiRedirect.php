<?php 

if (isset($_GET['kpi'])) {

	switch ($_GET['comprehensive']) {
	

		case "comprehensiveCiffKpi":
		    header("Location:comprehensiveCiffKpi.php");
		    break;

		case "comprehensiveCiffReport":
		    header("Location:comprehensiveCiffReport.php");
		    break;

		case "comprehensiveClaire":
		    header("Location:comprehensiveClaire.php");
		    break;

		case "comprehensiveDistrict":
		    header("Location:comprehensiveDistrict.php");
		    break;

		case "comprehensiveEndfund":
		    header("Location:comprehensiveEndfund.php");
		    break;

		case "comprehensiveNdt":
		    header("Location:comprehensiveNdt.php");
		    break;

		case "comprehensiveProgram":
		    header("Location:comprehensiveProgram.php");
		    break;

		case "comprehensiveUSAID":
		    header("Location:comprehensiveUSAID.php");
		    break;

		case "comprehensiveWho":
		    header("Location:comprehensiveWho.php");
		    break;

	}
}

 ?>