<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */


$data ="NA";
include $path.'tcpdf/tcpdf.php';
require_once ($path.'includes/config.php');
include "queryFunctions.php";

// Include the main TCPDF library (search for installation path).
// require_once('tcpdf/examples/tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	// Load table data from file
	public function LoadData($file) {
		// Read file lines
		$lines = file($file);
		$data = array();
		foreach($lines as $line) {
			$data[] = explode(';', chop($line));
		}
		return $data;
	}

	 //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'evidence-action.png';
        $this->Image($image_file, 15, 5, 28, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 15);
        // Title
        $this->Cell(110, 15, 'NDT KPI REPORT', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

	// Colored table
	public function ColoredTable($header,$datatext) {
		$data ="NA";

		// set the variable values
		$row1=number_format(numDistinctPlain('division_id','a_bysch'));
		$row2=number_format(num('school_id','a_bysch'));
		$row3=number_format(EstimatedTotalSTH());
		$row4=number_format(sumSTH());
		$row5=number_format(sumMaleFormA());
		$row6=number_format(sumFemaleFormA());
		$row7=number_format(sum6andOverFormA());
		$row8=number_format(sumUnder5());
		$row9=number_format(sumUnder5Male());
		$row10=number_format(sumUnder5Female());
		$row11=number_format(sumArgs('a_bysch','a_trt_m','a_trt_f'));
		$row12=number_format(sumPlain('a_trt_m','a_bysch')) ;
		$row13=number_format(sumPlain('a_trt_f','a_bysch')) ;
		$row14=number_format(sumNonEnrolled6andover('STH'));
		$row15=number_format(sumNonEnrolled6andoverMale('a_bysch'));
		$row16=number_format(sumNonEnrolled6andoverFemale('a_bysch'));
		$row17=number_format(sumNonEnrolledGender('a_6','a_bysch'));
		$row18=number_format(sumPlain('a_6_m','a_bysch'));
		$row19=number_format(sumPlain('a_6_f','a_bysch'));
		$row20=number_format(sumNonEnrolledGender('a_11','a_bysch')) ;
		$row21=number_format(sumPlain('a_11_m','a_bysch'));
		$row22=number_format(sumPlain('a_11_f','a_bysch'));
		$row23=number_format(sumNonEnrolledGender('a_15','a_bysch'));
		$row24=number_format(sumPlain('a_15_m','a_bysch'));
		$row25=number_format(sumPlain('a_15_f','a_bysch'));
		$row26=number_format(sumNonEnrolledGender('a_2','a_bysch'));
		$row27=number_format(sumPlain('a_2_m','a_bysch'));
		$row28=number_format(sumPlain('a_2_f','a_bysch'));
		$row29=number_format(sumArgs('a_bysch','a_ecd_m','a_ecd_f'));
		$row30=number_format(sumPlain('a_ecd_m','a_bysch'));
		$row31=number_format(sumPlain('a_ecd_f','a_bysch'));
		$row32=number_format(numDistinct('district_id','a_bysch','Yes'));
		$row33=number_format(numDistinct('division_id','a_bysch','Yes'));
		$row34=number_format(numDistinct('school_id','a_bysch','Yes'));
		$row35=number_format(EstimatedTotalSHISTO());
		$row36=number_format(sumSHISTO());
		$row37=number_format(sumMaleFormAP());
		$row38=number_format(sumFemaleFormAP());
		$row39=sumEnrolled('form_ap') ;
		$row40=sumEnrolledGenderSHISTO('male');
		$row41=sumEnrolledGenderSHISTO('male');
		$row42=number_format(sumPlain('ap_ecd_a','a_bysch'));
		$row43=number_format(sumPlain('ap_ecd_f','a_bysch'));
		$row44=number_format(sumNonEnrolled6andover('SHISTO'));
		$row45=number_format(sumNonEnrolled6andoverMale('SHISTO'));
		$row46=number_format(sumNonEnrolled6andoverFemale('SHISTO'));
		$row47=number_format(sumNonEnrolledGender('ap_6','a_bysch'));
		$row48=number_format(sumPlain('ap_6_m','a_bysch'));
		$row49=number_format(sumPlain('ap_6_f','a_bysch'));
		$row50=number_format(sumNonEnrolledGender('ap_11','a_bysch'));
		$row51=number_format(sumPlain('ap_11_m','a_bysch'));
		$row52=number_format(sumPlain('ap_11_f','a_bysch'));
		$row53=number_format(sumNonEnrolledGender('ap_15','a_bysch'));
		$row54=number_format(sumPlain('ap_15_m','a_bysch'));
		$row55=number_format(sumPlain('ap_15_f','a_bysch'));
		$row56=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_m','a_trt_f'));
		$row57=number_format(sumArgsByTreatment('a_bysch','Yes','a_trt_f','a_trt_m'));
		$row58=number_format(sum('a_trt_f','a_bysch','Yes'));
		$row59=number_format(sum('a_6_18_total','a_bysch','Yes'));
		$row60=number_format(sumNonEnrolled6andoverMaleByTreatment('shisto'));
		$row61=number_format(sum('a_6_18_f','a_bysch','Yes'));
		$row62=number_format(sumArgsByTreatment('a_bysch','Yes','a_6_m','a_6_f'));
		$row63=number_format(sum('a_6_m','a_bysch','Yes'));
		$row64=number_format(sum('a_6_f','a_bysch','Yes'));
		$row65=number_format(sumArgsByTreatment('a_bysch','Yes','a_11_m','a_11_f'));
		$row66=number_format(sum('a_11_m','a_bysch','Yes'));
		$row67=number_format(sum('a_11_f','a_bysch','Yes'));
		$row68=number_format(sumArgsByTreatment('a_bysch','Yes','a_15_m','a_15_f'));
		$row69=number_format(sum('a_15_m','a_bysch','Yes'));
		$row70=number_format(sum('a_15_f','a_bysch','Yes'));
		$row71=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_f','a_ecd_m','a_ecd_f'));
		$row72=number_format(sum('a_u5_m','a_bysch','Yes'));
		$row73=number_format(sum('a_u5_f','a_bysch','Yes'));
		$row74=number_format(sumArgsByTreatment('a_bysch','Yes','a_2_m','a_2_m'));
		$row75=number_format(sum('a_2_m','a_bysch','Yes'));
		$row76=number_format(sum('a_2_f','a_bysch','Yes'));
		$row77=number_format(sumArgsByTreatment('a_bysch','Yes','a_ecd_m','a_ecd_f'));
		$row78=number_format(sum('a_ecd_m','a_bysch','Yes'));
		$row79=number_format(sum('a_ecd_f','a_bysch','Yes'));
		$row80=number_format(sumArgsByTreatment('a_bysch','No','a_trt_m','a_trt_f'));
		$row81=number_format(sum('a_trt_m','a_bysch','No'));
		$row82=number_format(sum('a_trt_f','a_bysch','No'));
		$row83=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_6_m','a_11_f','a_11_m','a_15_f','a_15_m'));
		$row84=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_11_m','a_15_m'));
		$row85=number_format(sumArgsByTreatment('a_bysch','No','a_6_f','a_11_f','a_15_f'));
		$row86=number_format(sumArgsByTreatment('a_bysch','No','a_6_m','a_6_f'));
		$row87=number_format(sum('a_6_m','a_bysch','No'));
		$row88=number_format(sum('a_6_f','a_bysch','No'));
		$row89=number_format(sumArgsByTreatment('a_bysch','No','a_11_m','a_11_f'));
		$row90=number_format(sum('a_11_m','a_bysch','No'));
		$row91=number_format(sum('a_11_f','a_bysch','No'));
		$row92=number_format(sumArgsByTreatment('a_bysch','No','a_15_m','a_15_f'));
		$row93=number_format(sum('a_15_m','a_bysch','No'));
		$row94=number_format(sum('a_15_f','a_bysch','No'));
		$row95=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_m','a_2_m'));
		$row96=number_format(sumArgsByTreatment('a_bysch','No','a_ecd_f','a_2_f'));
		$row97=number_format(sumArgsByTreatment('a_bysch','No','a_2_f','a_2_m'));
		$row98=number_format(sum('a_2_m','a_bysch','No'));
		$row99=number_format(sum('a_2_f','a_bysch','No'));
		$row100=number_format(sumArgs('s_bysch','s_adult_treated1','s_adult_treated2','s_adult_treated3','s_adult_treated4','s_adult_treated5','s_adult_treated6','s_adult_treated7','s_adult_treated8','s_adult_treated9'));
		$row101=number_format(sumArgs('s_bysch','sp_adult_treated1','sp_adult_treated2','sp_adult_treated3','sp_adult_treated4','sp_adult_treated5','sp_adult_treated6','sp_adult_treated7','sp_adult_treated8','sp_adult_treated9'));

		// Colors, line width and bold font
		// $this->SetFillColor(249, 113, 139);
		$this->SetFillColor(224, 103, 127);
		$this->SetTextColor(0);
		// $this->SetDrawColor(249, 113, 139);
		$this->SetDrawColor(211, 211, 211);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		$w = array(150, 35, 40, 45);
		$num_headers = count($header);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'L', 1);
		}
		$this->Ln();
		// Color and font restoration
		// $this->SetFillColor(224, 235, 255);
		$this->SetFillColor(247, 217, 223);
		$this->SetTextColor(0);
		// $this->SetFont('');
		// set font sie
		$this->SetFont('helvetica', '', 9);
		// Data
		$fill = 0;
			
		$this->SetFont('helvetica', '', 9);

		$this->cell($w[0], 6,'No. of divisions covered for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row1,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of schools treated for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row2,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'Estimated target population of STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row3,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of  children dewormed for STH once','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row4,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row5,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row6,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of children 6 and over receiving STH treatment','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row7,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row8,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row9,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row10,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row11,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row12,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row13,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-18) children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row14,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-18) children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row15,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-18) children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row16,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-10) children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row17,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-10) children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row18,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 6-10) children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row19,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 11-14) children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row20,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 11-14) children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row21,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 11-14) children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row22,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 15-18) children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row23,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 15-18) children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row24,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non-enrolled (age 15-18) children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row25,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row26,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row27,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row28,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row29,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH (male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row30,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH (female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row31,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of districts covered for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row32,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of divisions covered for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row33,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of schools covered for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6,$row34,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'Estimated target population of Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row35,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of children dewormed for Schisto once','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row36,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of children dewormed for Schisto (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row37,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row38,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		
		$this->cell($w[0], 6,'No. of ECD children dewormed for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row42,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of ECD children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row43,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row44,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for Schisto (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row45,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row46,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row47,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for Schisto (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row48,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row49,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row50,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for Schisto (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row51,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row52,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row53,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for Schisto (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row54,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for Schisto (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row55,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row56,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row57,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row58,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row59,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6,  $row60,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row61,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row62,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row63,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row64,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row65,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row66,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row67,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row68,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row69,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row70,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row71,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH in Schisto School(Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row72,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH in Schisto School(Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row73,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row74,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row75,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in Schisto School(Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row76,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH in Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row77,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH in Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row78,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of ECD children dewormed for STH in Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row79,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row80,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row81,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Enrolled Primary School Aged children dewormed for STH in non-Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row82,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row83,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6,  $row84,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-18) children dewormed for STH in non-Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row85,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row86,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row87,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 6-10) children dewormed for STH in non-Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row88,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row89,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row90,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 11-14) children dewormed for STH in non-Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row91,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row92,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row93,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 15-18) children dewormed for STH in non-Schisto School (Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row94,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH in non-Schisto School(Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row95,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of U5 children dewormed for STH in non-Schisto School(Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row96,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row97,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Male)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row98,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Non Enrolled (age 2-5) children dewormed for STH in non-Schisto School(Female)','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row99,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;
		$this->cell($w[0], 6,'No. of Adult Treated for STH','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row10,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill = 0;
		$this->cell($w[0], 6,'No. of Adult Treated for Schisto','LR', 0, 'L', $fill);
		$this->cell($w[1], 6, $row10,'LR', 0, 'L', $fill);
		$this->Ln();

		$fill=!$fill;









			



		// }
		$this->Cell(array_sum($w), 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 011');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage();

// column titles
$header = array('Indicator', 'Total');

// data loading
$datatext = $pdf->LoadData($path.'tcpdf/examples/data/table_data_demo.txt');

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('NDT KPI REPORT.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
