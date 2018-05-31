<?php include_once('phpToPDF.php') ;
    //Code to generate PDF file from specified URL
    phptopdf_url('http://maestros-ites.com/testserver1/evidence_action/reports/supply_estimation_indicators.php','pdf/', 'supply_estimation_indicators.pdf');
	header('location:pdf/supply_estimation_indicators.pdf');
	?>