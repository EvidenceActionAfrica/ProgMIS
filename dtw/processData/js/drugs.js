$(document).ready(function(){

	console.log("You are in drugs.js in process data");

	// update the assumption status
	$('.update-assumption-status').click(function(){

		console.log("update-assumption-status clicked");
		// var id = $(this).val();
		var id = $(this).attr('id');
		console.log(id);
	    $.post('assumptions.php', {checkval: 'update_status', id: id}).done(function(data) {
	      console.log(data);
	    });

	});

	// delete the selected assumption



	/**
	                      )      )                    )                        )  
	          (     )  ( /(   ( /( (      (     )  ( /(    )      (         ( /(  
	  (      ))\ ( /(  )\())  )\()))(    ))\ ( /(  )\())  (      ))\  (     )\()) 
	  )\ )  /((_))\())(_))/  (_))/(()\  /((_))(_))(_))/   )\  ' /((_) )\ ) (_))/  
	 _(_/( (_)) ((_)\ | |_   | |_  ((_)(_)) ((_)_ | |_  _((_)) (_))  _(_/( | |_   
	| ' \))/ -_)\ \ / |  _|  |  _|| '_|/ -_)/ _` ||  _|| '  \()/ -_)| ' \))|  _|  
	|_||_| \___|/_\_\  \__|   \__||_|  \___|\__,_| \__||_|_|_| \___||_||_|  \__|  
	                                                                              
	*/
	// hide 

	$('.add-treatment').click(function(){
		$('.add-treatment-form').toggle('slow');
		// $('.white-out').addClass('grey-out');

		// $('#hor-form').toggle('slow',function(){
		// 	// $('#show-form').text(
		//       // $('#hor-form').is(':visible') ? "-" : "+"
		//       $('#hor-form').is(':visible') ? "-" : $('#show-form').hide()
		//     // );
		// });	


	});




});//end document ready