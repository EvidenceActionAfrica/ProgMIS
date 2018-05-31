$( document ).ready(function() {
	console.log("inside");
	// adds the active link for navigation
	// $('.navbar-nav a').click(function(){
	// 	console.log("clicked");
 //        // $(this).addClass('selected');
 //        // $(this).siblings().removeClass('selected');
	// });

	// $('#myModal2').modal('show');

	$('.edit-stuff').click(function(){
		console.log("edit clicked");
		// get the id of the element clicked
		var id = $(this).attr('id');	
		console.log("id= "+id);
		
		var tdid =$(this).closest('tr').attr('id'); // id tro be removed
		console.log(tdid);

		//get the classes from the clicked element
		var myClass = $(this).attr("class");
		console.log(myClass);

		// get the last chaaracter of the classes
		// is the the count of all the records
		var lastChar = myClass.substr(myClass.length - 1); // => "1"

		console.log(lastChar);

		for (var i = 8; i >= 1; i--) {
			console.log('asset_td_'+[i]);
			var c = $('#asset_td_'+[i]+'_'+id).html();
			console.log(c);
		};

		// loop through the 
		// var classes = $(tdid).attr('class');

		// for(var i = 0; i < classes.length; i++) {
		//   console(classes[i]);
		// }
	});
});