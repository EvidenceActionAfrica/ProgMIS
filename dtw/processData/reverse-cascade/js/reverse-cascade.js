$(document).ready(function(){
	// initiate the tool tip
	$('.warning').tooltip();
	//not in use
	$( "p" ).dblclick(function() {
		alert( "Hello World!" );
	});

	// initiate data-tables
	$('#data-table').dataTable({
		"scrollY": "300px",
		// "scrollX": "100%",
		"scrollCollapse": true,
		"oLanguage": {
			"sSearch": "Filter: "
		  }
	});

	// remove the save info after saved
	setTimeout(function() {
		$(".saved-info").hide('slow	');
	}, 2000);



	$('#log-submit').click(function(){
		$('#hor-form').hide();
	});

	$('#show-form').click(function(){
		// show the form
		$('#hor-form').toggle('slow',function(){
			// $('#show-form').text(
		      // $('#hor-form').is(':visible') ? "-" : "+"
		      $('#hor-form').is(':visible') ? "-" : $('#show-form').hide()
		    // );
		});	
		
		// when the plus is cicked
		// show the create button and hide the update button
		// $('.update-log-submit').hide();
		// $('.create-log-submit').show();

		//show the option for the select 
		// hide the update text box 

		// $('.update-select').hide();
		// $('.create-select').show();
	});

		// $('#hor-form').toggle('slow',function(){
		// 		 $('update-log-submit').hide();
		// 	    $('create-log-submit').show();
		// 	});

	//$('.editc').click(function(){
	$(".return-status").on('click','td',function(){
			// for effect hide then show
			$('#hor-form').hide();
			$('#hor-form').show("slow");

			 // $('update-log-submit').hide();
			 //    $('create-log-submit').show();

			//get the id of the clicked element
			//its a number
			//append this to the id's to get correct specific table clicked
			var id = $(this).attr('id');	
			//get the data  from the table
			var form_id=document.getElementById('id-td'+id).value;

			var district_name =$('#district_name-td'+id).html();
			// var regional_training_end = $('#regional_training_end-td'+id).html();
			var rt_moe_recieved = $('#rt_moe_recieved-td'+id).html();
			var rt_mophs_recieved = $('#rt_mophs_recieved-td'+id).html();
			// var tts_end_mt = $('#tts_end_mt-td'+id).html();
			var tts_moe_recieved = $('#tts_moe_recieved-td'+id).html();
			var tts_mophs_recieved = $('#tts_mophs_recieved-td'+id).html();
			// var district_deworming_day = $('#district_deworming_day-td'+id).html();
			var dd_moe_recieved = $('#dd_moe_recieved-td'+id).html();
			var dd_mophs_recieved = $('#dd_mophs_recieved-td'+id).html();

			//clear the checkboxes
			//clear_return_form_checkboxes();

			//SET THE DATA IN THE FROM

			//set the hidden id field
			document.getElementById('form_id').value=form_id;
			console.log("id="+form_id);

			//set the dates
			// regional training date removed
			// document.getElementById('regional_training_end_input').value=regional_training_end;
			document.getElementById('district_name_input').value=district_name;

			document.getElementById('rt_moe_recieved_input').value = rt_moe_recieved;
			document.getElementById('rt_mophs_recieved_input').value = rt_mophs_recieved;
			document.getElementById('tts_moe_recieved_input').value = tts_moe_recieved;
			document.getElementById('tts_mophs_recieved_input').value = tts_mophs_recieved;
			document.getElementById('dd_moe_recieved_input').value = dd_moe_recieved;
			document.getElementById('dd_mophs_recieved_input').value = dd_mophs_recieved;
			

			// hide the 
		});

		//##################county return form ##############################

	//$('.edit-return-county').click(function(){
	$(".return-county").on('click','td',function(){
		//hide create button and show update button
		$('.create-log-submit').hide();
		$('.update-log-submit').show();
		// show the form
		// for effect hide then show
		$('#hor-form').hide();
		$('#hor-form').show("slow");
		//get the id of the clicked element
		//its a number from a loop
		//append this to the id's to get correct specific table clicked
		var id = $(this).attr('id');	
		//get the data  from the table
		var form_id = document.getElementById('id-td'+id).value;
		var county_id = $('#county_id-td'+id).html();
		//var wave = $('#wave-td'+id).html();
		var moe_financial_returns_received = $('#moe_financial_returns_received-td'+id).html();
		var moe_attnc_received = $('#moe_attnc_received-td'+id).html();
		var moe_attnc_couriered = $('#moe_attnc_couriered-td'+id).html();
		var moh_financial_returns_received = $('#moh_financial_returns_received-td'+id).html();
		var moh_attnc_received = $('#moh_attnc_received-td'+id).html();
		var moh_attnc_couriered = $('#moh_attnc_couriered-td'+id).html();
		var moh_cd_recording_received= $('#moh_cd_recording_received-td'+id).html();
		var moh_cd_recording_couriered = $('#moh_cd_recording_couriered-td'+id).html();


		//SET THE DATA IN THE FROM

		//set the hidden id field
		document.getElementById('form_id').value=form_id;
		//console.log("id="+form_id);

		// set the textbox
		document.getElementById('county_name_input').value = county_id;
		console.log("qwertyttttttttttttttttttt"+county_id);

		document.getElementById('moe_financial_returns_received_input').value = moe_financial_returns_received;
		document.getElementById('moe_attnc_received_input').value = moe_attnc_received;
		document.getElementById('moe_attnc_couriered_input').value = moe_attnc_couriered;
		document.getElementById('moh_financial_returns_received_input').value = moh_financial_returns_received;
		document.getElementById('moh_attnc_received_input').value = moh_attnc_received;
		document.getElementById('moh_attnc_couriered_input').value = moh_attnc_couriered;
		document.getElementById('moh_cd_recording_received_input').value = moh_cd_recording_received;
		document.getElementById('moh_attnc_received_input').value = moh_attnc_received;			


	});

	//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-return-county').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'return-county.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});

	
	/**********************************************************************************
		                  ,--.                    ,--.                                 
		 ,---.  ,--,--. ,-|  |    ,--.--. ,---. ,-'  '-.,--.,--.,--.--.,--,--,  ,---.  
		(  .-' ' ,-.  |' .-. |    |  .--'| .-. :'-.  .-'|  ||  ||  .--'|      \(  .-'  
		.-'  `)\ '-'  |\ `-' |    |  |   \   --.  |  |  '  ''  '|  |   |  ||  |.-'  `) 
		`----'  `--`--' `---'     `--'    `----'  `--'   `----' `--'   `--''--'`----'  
                                                                               
	*************************************************************************************/
	//$('.edit-sad-returns').click(function(){
		$(".return-sad").on('click','td',function(){
		//hide the create button and show the save button
		$('.create-log-submit').hide();
		$('.update-log-submit').show();

		// show the form
		// for effect,  hide then show
		$('#hor-form').hide();
		$('#hor-form').show("slow");
		//get the id of the clicked element
		//its a number from a loop
		//append this to the id's to get correct specific table clicked
		var id = $(this).attr('id');	
		//get the data  from the table
		var form_id=document.getElementById('id-td'+id).value;


		// var return_date = $('#return_date_td'+id).html();
		var district_id = $('#district_id_td'+id).html();
		var form_p_td = $('#form_p_td'+id).html();
		var form_mt_td = $('#form_mt_td'+id).html();
		var form_attnt_td = $('#form_attnt_td'+id).html();
		var form_attnc_td = $('#form_attnc_td'+id).html();
		var form_attnr_td = $('#form_attnr_td'+id).html();
		var form_s_td = $('#form_s_td'+id).html();
		var form_a_td = $('#form_a_td'+id).html();
		var form_d_td = $('#form_d_td'+id).html();


		clear_sad_returns_checkboxes();


		//SET THE DATA IN THE FROM

		//set the hidden id field
		document.getElementById('form_id').value=form_id;
		//set id name
		console.log(district_id);
		// district name
		document.getElementById('district_name_input').value=district_id;
		// set the return date
		// document.getElementById('return_date_input').value=return_date;

		console.log("id="+form_id);
		//set the checkboxes
		//use if statement. 


		if(form_p_td=='Y'){
			document.getElementById('form_p_checkbox').checked=true;
		}
		if(form_mt_td=='Y'){
			document.getElementById('form_mt_checkbox').checked=true;
		}
		if(form_attnt_td=='Y'){
			document.getElementById('form_attnt_checkbox').checked=true;
		}
		if(form_attnc_td=='Y'){
			document.getElementById('form_attnc_checkbox').checked=true;
		}
		if(form_attnr_td=='Y'){
			document.getElementById('form_attnr_checkbox').checked=true;
		}
		if(form_s_td=='Y'){
			document.getElementById('form_s_checkbox').checked=true;
		}
		if(form_a_td=='Y'){
			document.getElementById('form_a_checkbox').checked=true;
		}
		if(form_d_td=='Y'){
			document.getElementById('form_d_checkbox').checked=true;
		}



		//function clear the checkboxes
		function clear_sad_returns_checkboxes(){
			document.getElementById('form_p_checkbox').checked=false;
			document.getElementById('form_mt_checkbox').checked=false;
			document.getElementById('form_attnt_checkbox').checked=false;
			document.getElementById('form_attnc_checkbox').checked=false;
			document.getElementById('form_attnr_checkbox').checked=false;
			document.getElementById('form_s_checkbox').checked=false;
			document.getElementById('form_a_checkbox').checked=false;
			document.getElementById('form_d_checkbox').checked=false;

		}

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-return-sad').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'return-sad.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});


	/**********************************************************************************
				 (                                               )  
				 )\      (  (        (     )             (    ( /(  
				((_) (   )\))( ___  ))\ ( /( `  )    (   )(   )\()) 
				 _   )\ ((_))\|___|/((_))\())/(/(    )\ (()\ (_))/  
				| | ((_) (()(_)   (_)) ((_)\((_)_\  ((_) ((_)| |_   
				| |/ _ \/ _` |    / -_)\ \ /| '_ \)/ _ \| '_||  _|  
				|_|\___/\__, |    \___|/_\_\| .__/ \___/|_|   \__|  
				        |___/               |_|                     
	*************************************************************************************/
	//$('.edit-log-export').click(function(){
	$( ".log-export" ).on("click","td",function(){
		// show the form
		// for effect,  hide then show
		// $('#hor-form').hide();
		// $('#hor-form').show("slow");

		// show the close button
		// $('#show-form').show();
		// show the form
		// $( '#show-form' ).addClass( "glyphicon glyphicon-minus" );



		//get the id of the clicked element
		//its a number from a loop
		//append this to the id's to get correct specific table clicked
		var id = $(this).attr('id');	

		//get the data  from the table
		//andput theminvariables

		//this is the id column for the record
		var form_id=document.getElementById('id-td'+id).value;
		// rest of the record
		var county_id_td = $('#county_id_td'+id).html();
		var district_id_td = $('#district_id_td'+id).html();
		var division_id_td = $('#division_id_td'+id).html();
		console.log("qwertyttttttttttttttttttt"+district_id_td);


		// var end_date_td = $('#end_date_td'+id).html();
		var expected_td = $('#expected_td'+id).html();
		console.log("expected_td = "+expected_td);

		var received_td = $('#received_td'+id).html();
		var received_moe_td = $('#received_moe_td'+id).html();
		var received_moh_td = $('#received_moh_td'+id).html();
		var stamp_range_td = $('#stamp_range_td'+id).html();
		var scrutiny_td = $('#scrutiny_td'+id).html();
		var scanning_td = $('#scanning_td'+id).html();
		var courier_td = $('#courier_td'+id).html();
		var date_recieved_td = $('#date_recieved_td'+id).html();
		var date_couriered_td = $('#date_couriered_td'+id).html();
		var date_couriered_moh_td = $('#date_couriered_moh_td'+id).html();
		var date_couriered_moe_td = $('#date_couriered_moe_td'+id).html();
		var form_type_td = $('#form_type_td'+id).html();

		clear_log_export_checkboxes();

		//SET THE DATA IN THE FROM

		//set the hidden id field in the form
		document.getElementById('form_id').value=form_id;
		//set id name
		console.log(expected_td);
		// document.getElementById('district_name_input').value=district_id;
		console.log("id="+form_id);
		//set the checkboxes
		//use if statement.
		// console.log(district_id_td);
		document.getElementById('county_input').value = county_id_td;
		document.getElementById('district_input').value = district_id_td;
		document.getElementById('division_input').value = division_id_td;
		document.getElementById('date_couriered_moh_input').value = date_couriered_moh_td;
		document.getElementById('date_couriered_moe_input').value = date_couriered_moe_td;
		// document.getElementById('end_date_input').value = end_date_td;
		document.getElementById('recieved_input').value = received_td;
		document.getElementById('expected_input').value = expected_td;
		document.getElementById('stamp_range_input').value = stamp_range_td;
		document.getElementById('form_type_input').value = form_type_td;
		// document.getElementById('scrutiny_checkbox').value = scrutiny_td;
		// document.getElementById('scanning_checkbox').value = scanning_td;
		document.getElementById('courier_date').value = courier_td;
		document.getElementById('date_recieved_input').value = date_recieved_td;
		document.getElementById('date_couriered_input').value = date_couriered_td;
		document.getElementById('date_recieved_moe_input').value = date_recieved_moe_td;
		document.getElementById('date_recieved_moh_input').value = date_recieved_moh_td;


		// if (scrutiny_td=='Y') {
		// 	console.log(scrutiny_td);
		// 	document.getElementById('scrutiny_checkbox').checked=true;
		// };
		// if (scanning_td=='Y') {
		// 	document.getElementById('scanning_checkbox').checked=true;
		// };

		// //function clear the checkboxes
		// function clear_log_export_checkboxes(){
		// 	document.getElementById('scrutiny_checkbox').checked=false;
		// 	document.getElementById('scanning_checkbox').checked=false;

		// }

			console.log('edit-log-export good to go');

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-log-export').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'log-export.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});



	/**********************************************************************************
				 (                                               )  
				 )\      (  (        (     )             (    ( /(  
				((_) (   )\))( ___  ))\ ( /( `  )    (   )(   )\()) 
				 _   )\ ((_))\|___|/((_))\())/(/(    )\ (()\ (_))/  
				| | ((_) (()(_)   (_)) ((_)\((_)_\  ((_) ((_)| |_   =====PLANNING
				| |/ _ \/ _` |    / -_)\ \ /| '_ \)/ _ \| '_||  _|  
				|_|\___/\__, |    \___|/_\_\| .__/ \___/|_|   \__|  
				        |___/               |_|                     
	*************************************************************************************/
	//$('.edit-log-export').click(function(){
	$( ".log-export-planning" ).on("click","td",function(){

		var id = $(this).attr('id');	

		//get the data  from the table
		//andput theminvariables

		//this is the id column for the record
		var form_id=document.getElementById('id-td'+id).value;
				//var county_id = $('#county_id-td'+id).html();

		// rest of the record
		
		var district_id_td = $('#district_id-td'+id).html();
		var division_id_td = $('#division_id-td'+id).html();
		var p_received_id_td = $('#p_received-td'+id).html();
		var p_couriered_id_td = $('#p_couriered-td'+id).html();
		var mt_received_id_td = $('#mt_received-td'+id).html();
		var mt_couriered_id_td = $('#mt_couriered-td'+id).html();
		var attsc_moe_received_id_td = $('#attsc_moe_received-td'+id).html();
		var attsc_moe_qty_id_td = $('#attsc_moe_qty-td'+id).html();
		var attsc_moe_couriered_id_td = $('#attsc_moe_couriered-td'+id).html();
		var attsc_moh_received_id_td = $('#attsc_moh_received-td'+id).html();
		var attsc_moh_qty_id_td = $('#attsc_moh_qty-td'+id).html();
		var attsc_moh_couriered_id_td = $('#attsc_moh_couriered-td'+id).html();

		//console.log("qwertyttttttttttttttttttt"+district_id_td);
		//var form_type_td = $('#form_type_td'+id).html();


		//set the hidden id field in the form
		document.getElementById('form_id').value=form_id;
		//set id name
		// document.getElementById('district_name_input').value=district_id;
		console.log("id="+form_id);
		//set the checkboxes
		//use if statement.
		//console.log(district_id_td);


		document.getElementById('district_input').value = district_id_td;
		document.getElementById('division_input').value = division_id_td;
		document.getElementById('p_received_input').value = p_received_id_td;
		document.getElementById('p_couriered_input').value = p_couriered_id_td;
		document.getElementById('mt_received_input').value = mt_received_id_td;
		document.getElementById('mt_couriered_input').value = mt_couriered_id_td;
		document.getElementById('attsc_moe_received_input').value = attsc_moe_received_id_td;
		document.getElementById('attsc_moe_qty_input').value = attsc_moe_qty_id_td;
		document.getElementById('attsc_moe_couriered_input').value = attsc_moe_couriered_id_td;
		document.getElementById('attsc_moh_received_input').value = attsc_moh_received_id_td;
		document.getElementById('attsc_moh_qty_input').value = attsc_moh_qty_id_td;
		document.getElementById('attsc_moh_couriered_input').value = attsc_moh_couriered_id_td;

				//console.log("qwkkkkkkkkkkkkkktttttttttttttttttt"+attsc_moh_couriered_id_td);

	

			console.log('log-export-planning good to go');

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-log-export').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'log-export-planning.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});


/**********************************************************************************
				 (                                               )  
				 )\      (  (        (     )             (    ( /(  
				((_) (   )\))( ___  ))\ ( /( `  )    (   )(   )\()) 
				 _   )\ ((_))\|___|/((_))\())/(/(    )\ (()\ (_))/  
				| | ((_) (()(_)   (_)) ((_)\((_)_\  ((_) ((_)| |_   =====Training
				| |/ _ \/ _` |    / -_)\ \ /| '_ \)/ _ \| '_||  _|  
				|_|\___/\__, |    \___|/_\_\| .__/ \___/|_|   \__|  
				        |___/               |_|                     
	*************************************************************************************/
	//$('.edit-log-export').click(function(){
	$( ".log-export-training" ).on("click","td",function(){

		var id = $(this).attr('id');	

		//get the data  from the table
		//andput theminvariables

		//this is the id column for the record
		var form_id=document.getElementById('id-td'+id).value;
				//var county_id = $('#county_id-td'+id).html();

		// rest of the record
		
		var district_id_td = $('#district_id-td'+id).html();
		var division_id_td = $('#division_id-td'+id).html();
		var ttrb_qty_id_td = $('#ttrb_qty-td'+id).html();
		var ttrb_received_id_td = $('#ttrb_received-td'+id).html();
		var ttrb_couriered_id_td = $('#ttrb_couriered-td'+id).html();
		
		console.log("qwertyttttttttttttttttttt"+ttrb_received_id_td);
		//var form_type_td = $('#form_type_td'+id).html();


		//set the hidden id field in the form
		document.getElementById('form_id').value=form_id;
		//set id name
		// document.getElementById('district_name_input').value=district_id;
		console.log("id="+form_id);
		//set the checkboxes
		//use if statement.
		//console.log(district_id_td);
		document.getElementById('district_input').value = district_id_td;
		document.getElementById('division_input').value = division_id_td;
		document.getElementById('ttrb_qty_input').value = ttrb_qty_id_td;
		document.getElementById('ttrb_received_input').value = ttrb_received_id_td;
		document.getElementById('ttrb_couriered_input').value = ttrb_couriered_id_td;

		console.log("pppppppppppppppppqweeeeeeeeee"+ttrb_received_id_td);

			console.log('log-export-planning good to go');

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-log-export').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'log-export-training.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});

	/**********************************************************************************
				 (                                               )  
				 )\      (  (        (     )             (    ( /(  
				((_) (   )\))( ___  ))\ ( /( `  )    (   )(   )\()) 
				 _   )\ ((_))\|___|/((_))\())/(/(    )\ (()\ (_))/  
				| | ((_) (()(_)   (_)) ((_)\((_)_\  ((_) ((_)| |_   =====Treatment
				| |/ _ \/ _` |    / -_)\ \ /| '_ \)/ _ \| '_||  _|  
				|_|\___/\__, |    \___|/_\_\| .__/ \___/|_|   \__|  
				        |___/               |_|                     
	*************************************************************************************/
	//$('.edit-log-export').click(function(){
	$( ".log-export-treatment" ).on("click","td",function(){

		var id = $(this).attr('id');	

		//get the data  from the table
		//andput theminvariables

		//this is the id column for the record
		var form_id=document.getElementById('id-td'+id).value;
				//var county_id = $('#county_id-td'+id).html();

		// rest of the record
		
		var district_id_td = $('#district_id-td'+id).html();
		
		var moh_517c_received_id_td = $('#moh_517c_received-td'+id).html();
		var moh_517c_couriered_id_td = $('#moh_517c_couriered-td'+id).html();
		var moh_517d_received_id_td = $('#moh_517d_received-td'+id).html();
		var moh_517d_couriered_id_td = $('#moh_517d_couriered-td'+id).html();
		var moh_517e_received_id_td = $('#moh_517e_received-td'+id).html();
		var moh_517e_qty_id_td = $('#moh_517e_qty-td'+id).html();
		var moh_517e_couriered_id_td = $('#moh_517e_couriered-td'+id).html();
	
		//console.log("qwertyttttttttttttttttttt"+district_id_td);
		//var form_type_td = $('#form_type_td'+id).html();


		//set the hidden id field in the form
		document.getElementById('form_id').value=form_id;
		//set id name
		// document.getElementById('district_name_input').value=district_id;
		console.log("id="+form_id);
		//set the checkboxes
		//use if statement.
		//console.log(district_id_td);moh_517e_


		document.getElementById('district_input').value = district_id_td;
		document.getElementById('moh_517c_received_input').value = moh_517c_received_id_td;
		document.getElementById('moh_517c_couriered_input').value = moh_517c_couriered_id_td;
		document.getElementById('moh_517d_received_input').value = moh_517d_received_id_td;
		document.getElementById('moh_517d_couriered_input').value = moh_517d_couriered_id_td;
		document.getElementById('moh_517e_received_input').value = moh_517e_received_id_td;
		document.getElementById('moh_517e_qty_input').value = moh_517e_qty_id_td;
		document.getElementById('moh_517e_couriered_input').value = moh_517e_couriered_id_td;
	

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-log-export').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'log-export-treatment.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });

		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});






/*

		b)                t)           h)          f)FFF                                    
		b)              t)tTTT         h)         f)                                        
		b)BBBB  a)AAAA    t)    c)CCCC h)HHHH     f)FFF   o)OOO   r)RRR   m)MM MMM   s)SSSS 
		b)   BB  a)AAA    t)   c)      h)   HH    f)     o)   OO r)   RR m)  MM  MM s)SSSS  
		b)   BB a)   A    t)   c)      h)   HH    f)     o)   OO r)      m)  MM  MM      s) 
		b)BBBB   a)AAAA   t)T   c)CCCC h)   HH    f)      o)OOO  r)      m)      MM s)SSSS  
                                                                                    
 */                                                                                




	//$('.edit-batch-export').click(function(){
	$( ".batch-export" ).on("click","td",function(){
		// show the form
		// for effect,  hide then show
		// $('#hor-form').hide();
		// $('#hor-form').show("slow");

		// show the close button
		// $('#show-form').show();
		// show the form
		// $('#show-form').addClass("glyphicon glyphicon-minus");

		//get the id of the clicked element
		//its a number from a loop
		//append this to the id's to get correct specific table clicked
		var id = $(this).attr('id');	

		//get the data  from the table
		//andput theminvariables

		//this is the id column for the record 
		var form_id=document.getElementById('id-td'+id).value;
		// rest of the record
		var district_id_td =$('#district_id_td'+id).html();
		var division_id_td =$('#division_id_td'+id).html();
		var courier_date_td =$('#courier_date_td'+id).html();
		
		var date_sent_td =$('#date_sent_td'+id).html();
		var expected_td = $('#expected_td'+id).html();
		console.log("expected_td = "+expected_td);
		var received_td = $('#received_td'+id).html();
		var courier_td = $('#courier_td'+id).html();
		var batch_td =$('#batch_td'+id).html();
		var num_sent_td =$('#num_sent_td'+id).html();
		var batch_range_td =$('#batch_range_td'+id).html();
		console.log("snippet");
		console.log("district_id_td = "+district_id_td);
		console.log("division_id_td = "+division_id_td);
		console.log("date_sent_td = "+date_sent_td);
		console.log("batch_td = "+batch_td);
		console.log("num_sent_td = "+num_sent_td);
		console.log("batch_range_td = "+batch_range_td);
		console.log("received_td = "+received_td);

		// console.log("expected_td = "+expected_td);

		//SET THE DATA IN THE FROM

		//set the hidden id field in the form
		document.getElementById('form_id').value=form_id;
		//set id name

		// document.getElementById('district_name_input').value=district_id;
		console.log("id="+form_id);
		//set the checkboxes
		//use if statement.
		// console.log(district_id_td);
		document.getElementById('district_id_input').value = district_id_td;
		document.getElementById('division_id_input').value = division_id_td;
		document.getElementById('courier_date_input').value = courier_date__td;
		document.getElementById('date_sent_input').value = date_sent_td;
		document.getElementById('batch_number_input').value = batch_td;
		document.getElementById('num_sent_input').value = num_sent_td;
		document.getElementById('batch_range_input').value = batch_range_td;
		document.getElementById('recieved_input').value = received_td;
		document.getElementById('expected_input').value = expected_td;
		document.getElementById('courier_date').value = courier_td;

	});

//ajax
	//delete return-county record and remove element deleted
	// use dialog to comfirm this
	$('.delete-log-export').click( function() {
		var id = event.target.id;	// gete id of clicked element. which is also id to be deleted

		var myData = "delete_id="+id; // construct the url
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed

		// dialog
		// if yes delete the record and remove the element
		var answer = confirm('Are you sure you want to delete this?');
		if (answer)
		{
	 		$.ajax({
		        url: 'log-export.php',
		        type: 'post',
		        data: myData,
		        success: function(data) {	

	              //$('#'+tdid).remove(); // remove the deleted element
	              $( '#'+tdid ).addClass( "yourClass" );
	              $('#'+tdid).hide(function(){ $('#'+tdid).remove(); });
	              
		        }
		    });
		}
		else
		{
		  console.log('cancel');
		}

	});


});//end document ready