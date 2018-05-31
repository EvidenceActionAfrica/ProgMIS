	<?php

	 function createtemplate($box_type) {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Training Boxes Templates');
				$pdf->SetSubject('Details of the Training Boxes');
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
				
				$title= '<h1 id="headerH1">Kenya National School Based<br/> Deworming Programme</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				$pdf->Image(dirname(__FILE__).'/../../images/kwaAfya.png',210, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
				$sql='SELECT name from training_box_categories WHERE acronymn="'.$box_type.'"';
					$boxResults=mysql_query($sql);
					$counter=1;
					while($box=mysql_fetch_array($boxResults)){
						$boxname=$box['name'];
						
					}
				$title2= '<h1>Distributing Training materials provided for '.str_replace('Training Boxes','',$boxname).' Training</h1>';
				$pdf->writeHTML($title2, true, false, true, false, 'C');
				
				

				$title3= '<h1>Box Labelled "'.$boxname.' "</h1>';
				$pdf->writeHTML($title3, true, false, true, false, 'C');
				
				
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
				$pdf->SetXY(80,70);		
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader.='<td style="border:1px solid #333333;width:30px;">No</td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Instructions</b></td>';
				$tableHeader .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

				$packetRec=array();
				$packetArray=array();

					$sqlPacket='SELECT * from packet_category';
					$packetResult=mysql_query($sqlPacket);
				while($packetRow=mysql_fetch_array($packetResult)){
						$packetRec=(array(
								'packet'=>$packetRow['packet'],
								'packet_desc'=>$packetRow['packet_desc']
								));
						
						array_push($packetArray,$packetRec);
					}
					$table='';
					$counter=1;
					foreach ($packetArray as $key => $value) {
						
					
					$sql='SELECT * from materials_desc WHERE training_box="'.$box_type.'" AND packet="'.$value["packet"].'" ORDER by packet ASC';
					 
					$boxResults=mysql_query($sql);
					$affected=mysql_affected_rows();
					if($affected>=1){
					$oldpacket=null;
					$table.='<tr style="background-color:#FF6600">';
					$table .= '<td colspan="2" style="border:1px solid #333333;text-align:center;" >'.$value["packet"].'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$value["packet_desc"].'</td>';
					$table.='</tr>';
					}	
					while($boxData=mysql_fetch_array($boxResults)){
						$Material=$boxData['materials'];
						$Desc=$boxData['formula_desc'];
						$packet=$boxData['packet'];
						if(isset($oldpacket)){
							if($oldpacket==$packet){
									$table .= '<tr>';
									$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
									$table .= '<td style="border:1px solid #333333;" >'.$Material.'</td>';
									$table .= '<td style="border:1px solid #333333;" >'.$Desc.'</td>';
									$table .= '</tr>';		 
								++$counter;
							}else{
								$oldpacket=$packet;
								$table.='<tr>';
								$table.='<td style="border:1px solid #333333;" ></td>';
								$table.='<td style="border:1px solid #333333;" >'.$Material.'</td>';
								$table.='<td style="border:1px solid #333333;" >'.$Desc.'</td>';
							
								$table .= '</tr>';	
							}
						}else{
								$oldpacket=$packet;
								$table .= '<tr>';
								$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
								$table .= '<td style="border:1px solid #333333;" >'.$Material.'</td>';
								$table .= '<td style="border:1px solid #333333;" >'.$Desc.'</td>';
								$table .= '</tr>';		 
								++$counter;
							}

					}
				}
					$table .= '</table>';
				
					
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/'.$boxname.' Template.pdf', 'FD');
		}
	

	
	

?>