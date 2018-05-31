<?php include_once('phpToPDF.php') ;
    //Code to generate PDF file from specified URL
	//echo $_SERVER['QUERY_STRING'];
	//die();
    phptopdf_url('http://maestros-ites.com/testserver1/evidence_action/reports/ajax.php?'.$_SERVER['QUERY_STRING'],'pdf/', $_REQUEST['checkval'].'.pdf');
	header('location:pdf/'.$_REQUEST['checkval'].'.pdf');
	?>