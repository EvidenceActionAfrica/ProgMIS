	<?php

	 function createpackagingSummary() {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Packaging Summary');
				$pdf->SetSubject('Summary Of Materials Packaged');
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


				$title2= '<h1>Packing Summary</h1>';
				$pdf->writeHTML($title2, true, false, true, false, 'C');
		
				
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Sub-County</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Total Boxes</b></td>';
				//Dynamic generation of columns depending on the types of training boxes available
			    $sql='SELECT * from training_box_categories ORDER BY name ASC';
			    $resultTB=mysql_query($sql);

			    //The Array below will take the training box names to the tbody for the correct filter of box types to take place.
			    $trainingBoxArray=array();
			    while($rowTB=mysql_fetch_array($resultTB)){
			   	$tableHeader .= '<td style="border:1px solid #333333;" ><b>'. $rowTB["name"].'</b></td>';

			      array_push($trainingBoxArray,$rowTB['acronymn']);
			    }
		        $tableHeader .= '<td style="border:1px solid #333333;" ><b>Status</b></td>';
		     
		        $tableHeader .= '<td style="border:1px solid #333333;" ><b>Box Id(s)</b></td>';
		              
				$tableHeader .= '</tr>';
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					$sql="select * from materials_printlist_history where status=1";
					$table='';
		              $resultA=mysql_query($sql);
		              while($row=mysql_fetch_array($resultA)){

		                $printlistId=$row["id"];
		               }

		              $sql="select * from materials_packaging_history where printlist_id='".$printlistId."'";
		              $resultA=mysql_query($sql);
		              $counter=1;
				      while($row=mysql_fetch_array($resultA)){
		                $id=$row["id"];
		                $countyName=$row["countyName"];
		                $districtName=$row["districtName"];
		                $noBox=$row["noBox"];
		                //This variable represents the total no.of boxes found to have been created for respective county & district.
		               $totaltb=0;
		               $boxType='';
		               //This empties the variable that will take the results from searching individual. 
		               //Counts of boxes types per county & district. All Box types will be represent by this variable.Check Below
		      			$allBoxIds='';
		      			 //This is used to carry all the box ids to the table
		                //For Each Training Box type Found in the training_boxes_desc table we look for the boxes created REF:Columns above
		                foreach ($trainingBoxArray as $key => $value) {
		                  $sql='SELECT count(box_type) as '.$value.' from materials_packaging_history_data WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_type="'.$value.'"';
		                 // echo $sql;
		                   $resultQ=mysql_query($sql);
		                    while($row2=mysql_fetch_array($resultQ)){
		                          $tb=isset($row2[$value])?$row2[$value]:0;
		                          $totaltb+=$tb;
		                     
		                  }
		                  $sqlBoxIds='Select box_id from materials_packaging_history_data WHERE county_name="'.$countyName.'" AND district_name="'.$districtName.'" AND box_type="'.$value.'"';
		                    
		                  $BoxIdResults=mysql_query($sqlBoxIds)or die(mysql_error().' Unable to Retrieve box Ids');
		                  
		                  while($boxIdRow=mysql_fetch_array($BoxIdResults)){
		                        if($allBoxIds==''){
		                            $allBoxIds.=$boxIdRow['box_id'];
		                        }else{
		                          $allBoxIds.=','.$boxIdRow['box_id'];
		                        }
		                      }
		                
		            	$boxType.= '<td style="border:1px solid #333333;" ><b>'. $tb.'</b></td>';

		                }
		                
		              
		                $diff=$noBox-$totaltb;
		                if($diff==0){
		                    $status="OK";
		                }else if($diff>0){
		                    $status="Missing Boxes";
		                }else if($diff<0){
		                    $status="Extra Boxes Found";
		                }
		                
		              
		            
			
			
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$countyName.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$districtName.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$noBox.'</td>';
					$table .= $boxType;
					$table .= '<td style="border:1px solid #333333;" >'.$status.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$allBoxIds.'</td>';
					$table .= '</tr>';		 
				++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/packing_summary.pdf', 'FD');
		}
	
	 function createBoxSummary($packageId) {

				// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($_SESSION['staff_name']);
				$pdf->SetTitle('Packaging Summary');
				$pdf->SetSubject('Summary Of Materials Packaged');
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
				
				$header= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/gklogo.png", 35, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				
				$title= '<h1 id="headerH1">Kenya National School Based<br/> Deworming Programme</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				$pdf->Image(dirname(__FILE__).'/../../images/kwaAfya.png',210, 5, '50', '20', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 40);


				$sqlBox='SELECT * from materials_packaging_history_data WHERE package_id='.$packageId;
				$resultBox=mysql_query($sqlBox);
				$boxContent='';
				while($row=mysql_fetch_array($resultBox)){

					$countyName=$row['county_name'];
					$districtName=$row['district_name'];
					$boxtype=$row['box_type'];
					$materials=unserialize($row['material']);
					foreach ($materials as $key => $value) {
						$boxContent.='<tr>';
						$boxContent.='<td style="border:1px solid #333333;">'.str_replace('_',' ',$key).'</td>';
						$boxContent.='<td style="border:1px solid #333333;">'.$value.'</td>';
						$boxContent.='</tr>';
							
					}
					
				}
				$sqlType='SELECT name from training_box_categories WHERE acronymn="'.$boxtype.'"';
				
				$boxTypeResult=mysql_query($sqlType);
				while($rowType=mysql_fetch_array($boxTypeResult)){

					$boxType=$rowType['name'];
				}

				$county= '<h3>County:'.$countyName.'</h3>';
				$pdf->writeHTML($county, true, false, true, false, 'C');

				$district= '<h3>Sub-County:'.$districtName.'</h3>';
				$pdf->writeHTML($district, true, false, true, false, 'C');

				$type= '<h3>Box Type:'.$boxType.'</h3>';
				$pdf->writeHTML($type, true, false, true, false, 'C');

				$title2= '<br/><h1>Box Summary</h1>';
				$pdf->writeHTML($title2, true, false, true, false, 'C');
			
				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Document</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Quantity</b></td>';
				$tableHeader .='</tr>';
			
		
				$table = $boxContent;
				$table .= '</table>';
				$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');
				ob_clean();
				// Close and output PDF document
				// This method has several options, check the source code documentation for more information.
				$pdf->Output('pdf/box_summary.pdf', 'FD');
		}
	
	

?>