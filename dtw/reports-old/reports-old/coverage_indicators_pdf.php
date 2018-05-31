<?php include_once('phpToPDF.php') ;
    //Code to generate PDF file from specified URL
    phptopdf_url('http://maestros-ites.com/testserver1/evidence_action/reports/coverage_indicators.php','pdf/', 'coverage_indicators.pdf');
	header('location:pdf/coverage_indicators.pdf');
	?>