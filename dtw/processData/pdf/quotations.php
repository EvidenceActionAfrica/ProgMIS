	<?php

	 function vendorQuotation() {

				// Include the main TCPDF library (search for installation path).
				//require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');
				//		require_once(dirname(__FILE__).'/../../tcpdf/examples/tcpdf_include.php');
			    require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				
				$pdf->SetAuthor('Evidence Action');
				$pdf->SetTitle('Materials Quote');
				$pdf->SetSubject('Vendor Quote');
				$pdf->SetKeywords('evidence-action, PDF, quote, Vendor, pricing');
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
				  //Page header
			
				
				
				$header= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/logo.png", 120, 5,'45','15', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 25);
				$title= '<h1 id="headerH1">Vendor Quote</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;width:10%;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Price</b></td>';
				$tableHeader .='</tr>';
				
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					$sql="select id from materials_printlist_history where status=1";
					$table='';
		              $resultA=mysql_query($sql);
		              while($row=mysql_fetch_array($resultA)){

		                $printlistId=$row["id"];
		               }

		              $sql="select * from materials_printlist_history_data where printlist_id='".$printlistId."'";
		              $resultA=mysql_query($sql);
		              $counter=1;
				      while($row=mysql_fetch_array($resultA)){
		               
		                $material=$row["material"];
		                $print_order_quantity=$row["print_order_quantity"];
		             
			
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$material.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" ></td>';
					$table .= '<td style=";border:1px solid #333333;" ></td>';
					
					$table .= '</tr>';		 
				++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/vendor_quote.pdf', 'FD');
		}
	 function vendorQuotationCreate() {

				// Include the main TCPDF library (search for installation path).
				//require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');
					require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');
				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				
				$pdf->SetAuthor('Evidence Action');
				$pdf->SetTitle('Materials Quote');
				$pdf->SetSubject('Vendor Quote');
				$pdf->SetKeywords('evidence-action, PDF, quote, Vendor, pricing');
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
				  //Page header
			
				
				
				$header= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/logo.png", 120, 5,'45','15', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 25);
				$title= '<h1 id="headerH1">Vendor Quote</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;width:10%;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Price</b></td>';
				$tableHeader .='</tr>';
				
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					$sql="select id from materials_printlist_history where status=1";
					$table='';
		              $resultA=mysql_query($sql);
		              while($row=mysql_fetch_array($resultA)){

		                $printlistId=$row["id"];
		               }

		              $sql="select * from materials_printlist_history_data where printlist_id='".$printlistId."'";
		              $resultA=mysql_query($sql);
		              $counter=1;
				      while($row=mysql_fetch_array($resultA)){
		               
		                $material=$row["material"];
		                $print_order_quantity=$row["print_order_quantity"];
		             
			
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$material.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" ></td>';
					$table .= '<td style=";border:1px solid #333333;" ></td>';
					
					$table .= '</tr>';		 
				++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/vendor_quote.pdf', 'F');
		}
	function completeVendorQuote(){

		// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				
				$pdf->SetAuthor('Evidence Action');
				$pdf->SetTitle('Materials Quote');
				$pdf->SetSubject('Vendor Quote');
				$pdf->SetKeywords('evidence-action, PDF, quote, Vendor, pricing');
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
				  //Page header
			
				
				
				$header= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/logo.png", 120, 5,'45','15', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 25);
				$title= '<h1 id="headerH1">Vendor Quote</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;width:10%;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Print Order Price</b></td>';


				$tableHeader .='</tr>';
				
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					$sql="select id from materials_printlist_history where status=1";
					$table='';
		              $resultA=mysql_query($sql);
		              while($row=mysql_fetch_array($resultA)){

		                $printlistId=$row["id"];
		               }

		              $sql="select * from materials_vendor_quote_history where printlist_id='".$printlistId."'";
		              $resultA=mysql_query($sql);
		              $counter=1;
				      while($row=mysql_fetch_array($resultA)){
		               
		                $materials=$row["materials"];
		                $print_order_quantity=$row["print_order_quantity"];
		             	$print_order_unit_price=$row["print_order_unit_price"];
		             	$print_order_price=$row["print_order_price"];
		             	$updated_print_order_quantity=$row["updated_print_order_quantity"];
		             	$updated_print_order_unit_price=$row["updated_print_order_unit_price"];
		             	$updated_print_order_price=$row["updated_print_order_price"];
			
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$materials.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_unit_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_unit_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_price.'</td>';
					
					
					$table .= '</tr>';		 
				++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/Confirmed_vendor_quote.pdf', 'FD');
		}
	function completeVendorQuoteCreate(){

		// Include the main TCPDF library (search for installation path).
				require_once(dirname(__FILE__).'/../../finance/includes/tcpdf/tcpdf_include.php');

				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				
				$pdf->SetAuthor('Evidence Action');
				$pdf->SetTitle('Materials Quote');
				$pdf->SetSubject('Vendor Quote');
				$pdf->SetKeywords('evidence-action, PDF, quote, Vendor, pricing');
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
				  //Page header
			
				
				
				$header= '<div>';
				$pdf->Image(dirname(__FILE__)."/../../images/logo.png", 120, 5,'45','15', 'PNG','','', false, 300, '', false, false, 0, false, false, false);
				$pdf->SetXY(10, 25);
				$title= '<h1 id="headerH1">Vendor Quote</h1>';
				$pdf->writeHTML($title, true, false, true, false, 'C');

				// Table header 
				$pdf->SetFont( 'helvetica', '', 11);
						
				$tableHeader = '<table style="border:1px solid #333333; font-size: 11px; width: 100%;">';
				//$tableHeader.=  '<tr><td colspan="8"><h3>Packing Summary</h3></center></td></tr>';
				$tableHeader.=	'<tr>';
				$tableHeader .= '<td style="border:1px solid #333333;width:10%;" ><b>Id</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Material</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Print Order Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Print Order Quantity</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Unit Price</b></td>';
				$tableHeader .= '<td style="border:1px solid #333333;" ><b>Updated<br/>Print Order Price</b></td>';


				$tableHeader .='</tr>';
				
					// Table content beings here 
				$pdf->SetFont( 'helvetica', '', 9 );  // two parameters accept font-family and style. Passing blank sets default values

					$sql="select id from materials_printlist_history where status=1";
					$table='';
		              $resultA=mysql_query($sql);
		              while($row=mysql_fetch_array($resultA)){

		                $printlistId=$row["id"];
		               }

		              $sql="select * from materials_vendor_quote_history where printlist_id='".$printlistId."'";
		              $resultA=mysql_query($sql);
		              $counter=1;
				      while($row=mysql_fetch_array($resultA)){
		               
		                $materials=$row["materials"];
		                $print_order_quantity=$row["print_order_quantity"];
		             	$print_order_unit_price=$row["print_order_unit_price"];
		             	$print_order_price=$row["print_order_price"];
		             	$updated_print_order_quantity=$row["updated_print_order_quantity"];
		             	$updated_print_order_unit_price=$row["updated_print_order_unit_price"];
		             	$updated_print_order_price=$row["updated_print_order_price"];
			
					$table .= '<tr>';
					$table .= '<td style="border:1px solid #333333;" >'.$counter.'</td>';
					$table .= '<td style="border:1px solid #333333;" >'.$materials.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_unit_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$print_order_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_quantity.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_unit_price.'</td>';
					$table .= '<td style=";border:1px solid #333333;" >'.$updated_print_order_price.'</td>';
					
					
					$table .= '</tr>';		 
				++$counter;
		 		} 
				
					$table .= '</table>';
				//	$table.='Hello World NiggaRo';
					$pdf->writeHTML($header.$tableHeader.$table, true, false, true, false, '');

					
					ob_clean();
					// Close and output PDF document
					// This method has several options, check the source code documentation for more information.
					$pdf->Output('pdf/Confirmed_vendor_quote.pdf', 'F');
		}
?>