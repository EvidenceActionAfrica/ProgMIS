<?php

	 function printTabPickup() {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Tab Pickup Summary');
				$pdf->SetSubject('Summary Of TabPickup');
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

				$pdf->SetXY(10, 5);
				
				$header.= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/gklogo.png", 35, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
				$title= '<h1 id="headerH1">Kenya National School Based<br/> Deworming Programme</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				$pdf->Image(dirname(__FILE__).'/../../images/kwaAfya.png',210, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 40);


				$title2= '<h1>TabPickup Summary</h1>';
				$pdf->writeHTML($title2, true, false, true, false, 'C');
		
				
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Sub-County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Status</b></td>';
				
				$tableHeader .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					 $sql='SELECT distinct(activity_venu),actyvity_county from rollout_activity';   
                 $rolloutResult=mysql_query($sql);
                  $counter=1;
                  $table='';
		            while($row=mysql_fetch_array($rolloutResult)){
                   	$sql2='SELECT district_name from drugs_tablet_pickup_form WHERE district_name="'.$row['activity_venu'].'"';
                    $result=mysql_query($sql2);
                    $numRows=mysql_num_rows($result);
                    if($counter==35 ){
                    	if($counter==38){
                    		
                    	}else{
                    	
                    	$table.='<tr>';
						$table.= '<td style="border:1px solid #333333;" ><b>Id</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>County</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>Sub-County</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>Status</b></td>';
						$table .= '</tr>';
                    	}
                    }
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$row['actyvity_county'].'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$row['activity_venu'].'</td>';
				
   					if($numRows>=1){
                        $table.= '<td style="border:1px solid #333333;font-style:italic;">'.$numRows.' Picked Up</td>';
                        }else{
                        $table.= '<td style="border:1px solid #333333;"><i style="color:rgb(255,0,0);">Not Picked up</i></td>';
                      }

					$table .= '</tr>';		 
					++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/tabPickupSummary.pdf', 'FD');
		}
	 function printTabReturn() {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Tab Return Form Summary');
				$pdf->SetSubject('Summary Of TabReturn');
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

				$pdf->SetXY(10, 5);
				
				$header.= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/gklogo.png", 35, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
				$title= '<h1 id="headerH1">Kenya National School Based<br/> Deworming Programme</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				$pdf->Image(dirname(__FILE__).'/../../images/kwaAfya.png',210, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 40);


				$title2= '<h1>Tab Return Summary</h1>';
				$pdf->writeHTML($title2, true, false, true, false, 'C');
		
				
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Sub-County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Status</b></td>';
				
				$tableHeader .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					 $sql='SELECT distinct(activity_venu),actyvity_county from rollout_activity';   
                 $rolloutResult=mysql_query($sql);
                  $counter=1;
                  $table='';
		            while($row=mysql_fetch_array($rolloutResult)){
                   	$sql2='SELECT distinct(district_name) from drugs_tab_return_form WHERE district_name="'.$row['activity_venu'].'"';
                    $result=mysql_query($sql2);
                    $numRows=mysql_num_rows($result);
                    if($counter==35 ){
                    	if($counter==38){
                    		
                    	}else{
                    	
                    	$table.='<tr>';
						$table.= '<td style="border:1px solid #333333;" ><b>Id</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>County</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>Sub-County</b></td>';
						$table.= '<td style="border:1px solid #333333;" ><b>Status</b></td>';
						$table .= '</tr>';
                    	}
                    }
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$row['actyvity_county'].'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$row['activity_venu'].'</td>';
				
   					if($numRows>=1){
                        $table.= '<td style="border:1px solid #333333;font-style:italic;">Returned</td>';
                        }else{
                        $table.= '<td style="border:1px solid #333333;"><i style="color:rgb(255,0,0);">Not Returned</i></td>';
                      }

					$table .= '</tr>';		 
					++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/TabReturn Form Summary.pdf', 'FD');
		}
?>