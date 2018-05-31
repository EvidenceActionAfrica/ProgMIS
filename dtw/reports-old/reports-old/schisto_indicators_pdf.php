<?php include_once('phpToPDF.php') ;
    //Code to generate PDF file from specified URL
    phptopdf_url('http://maestros-ites.com/testserver1/evidence_action/reports/schisto_indicators.php','pdf/', 'schisto_indicators.pdf');
	header('location:pdf/schisto_indicators.pdf');
	?>