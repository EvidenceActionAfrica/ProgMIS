	<?php

	 function showFormSummary($collectId) {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Collection Training Form Summary');
				$pdf->SetSubject('Details of the Collection training materials form & the box contents');
				//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

				// remove default header/footer
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);

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
				if (@file_exists(dirname(__FILE__).'/../../tcpdf/lang/eng.php')) {
					require_once(dirname(__FILE__).'/../../tcpdf/lang/eng.php');
					$pdf->setLanguageArray($l);
				}

				// set default font subsetting mode
				$pdf->setFontSubsetting(true);

				// Set font
				// dejavusans is a UTF-8 Unicode font, if you only need to
				// print standard ASCII chars, you can use core fonts like
				// helvetica or times to reduce file size.
				$pdf->SetFont('helvetica', '', 12, '', true);

				// Add a page
				// This method has several options, check the source code documentation for more information.
				$pdf->AddPage("L","mm","A4",true,"UTF-8",false);

			
				
				$header.= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/gklogo.png", 35, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
				$title= '<h1 id="headerH1">Training Materials Collection Summary</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				$pdf->Image(dirname(__FILE__).'/../../images/kwaAfya.png',210, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
					
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
				$pdf->SetXY(80,70);		
				$tableHeader1 = '<table style="border:1px solid #333333; font-size: 11px;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader1.=	'<tr>';
				$tableHeader1.='<td style="border:1px solid #333333;width:30px;">No</td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>Collector</b></td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>Title</b></td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>Ministry</b></td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>Mobile</b></td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>No Of Box</b></td>';
				$tableHeader1 .= '<td style="border:1px solid #333333;" ><b>No Of Poles</b></td>';
				$tableHeader1 .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

				$sql='SELECT * from collect_training_materials WHERE collection_id="'.$collectId.'"';
				$boxResults=mysql_query($sql) or die(mysql_error());
				$table1='';
				$counter=1;
					while($row=mysql_fetch_array($boxResults)){
						$collectorName=$row['name'];
						$ministry=$row['ministry'];
						$title=$row['title'];
						$mobile=$row['phone_no'];
						$noBox=$row['no_of_boxes'];
						$noPoles=$row['no_of_poles'];


						$table1 .= '<tr>';
						$table1.= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
						$table1.= '<td style="border:1px solid #333333;" >'.$collectorName.'</td>';
						$table1 .= '<td style="border:1px solid #333333;" >'.$title.'</td>';
						$table1 .= '<td style="border:1px solid #333333;" >'.$ministry.'</td>';
						$table1 .= '<td style="border:1px solid #333333;" >'.$mobile.'</td>';
						$table1 .= '<td style="border:1px solid #333333;" >'.$noBox.'</td>';
						$table1 .= '<td style="border:1px solid #333333;" >'.$noPoles.'</td>';
						$table1 .= '</tr>';
								
					++$counter;	
					}
						$table1 .= '</table>';

		// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
				$pdf->SetXY(80,70);		
				$tableHeader2 = '
					<h1>Boxes Collected</h1><br/>
				<table style="border:1px solid #333333; font-size: 11px;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader2.=	'<tr>';
				$tableHeader2.='  <td style="border:1px solid #333333;width:30px;">No</td>';
				$tableHeader2 .= '<td style="border:1px solid #333333;" ><b>County Name</b></td>';
				$tableHeader2 .= '<td style="border:1px solid #333333;" ><b>District Name</b></td>';
				$tableHeader2 .= '<td style="border:1px solid #333333;" ><b>Box Id</b></td>';
				$tableHeader2 .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values


				$sql='SELECT * from materials_packaging_history_data WHERE collector_id="'.$collectId.'"';

				$resultMat=mysql_query($sql);
					$counter=1;
					$table2='';

					while($row=mysql_fetch_array($resultMat)){
									$countyName=$row['county_name'];
									$districtName=$row['district_name'];
									$boxId=$row['box_id'];
									$table2 .= '<tr>';
									$table2 .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
									$table2 .= '<td style="border:1px solid #333333;" >'.$countyName.'</td>';
									$table2 .= '<td style="border:1px solid #333333;" >'.$districtName.'</td>';
									$table2 .= '<td style="border:1px solid #333333;" >'.$boxId.'</td>';
									$table2 .= '</tr>';		 
									++$counter;
					}

						$table2 .= '</table>';

			
			
					$pdf->writeHTML($header.$tableHeader1.$table1.$tableHeader2.$table2, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/Collection Form Summary.pdf', 'FD');
		}
	

	
	

?>