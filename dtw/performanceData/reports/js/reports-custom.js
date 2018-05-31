$(document).ready(function(){

	console.log("Cows");

	function vzoom(z,w){
		document.getElementById("national_report_container").style.zoom=z;
		// document.getElementById("national_report_container").style['MozTransform']="scale("+z+")";
		document.getElementById("national_report_container").style.width=w;
		document.getElementById("national_report_container").style.margin="0 auto";

		// document.getElementById("report_container").style.zoom=z;
		// // document.getElementById("report_container").style['MozTransform']="scale("+z+")";
		// document.getElementById("report_container").style.width=w;
		// document.getElementById("report_container").style.margin="0 auto";
	}

	function vzoomcc(z,w){

		console.log("Cars");
		document.getElementById("report_container").style.zoom=z;
		// document.getElementById("report_container").style['MozTransform']="scale("+z+")";
		document.getElementById("report_container").style.width=w;
		document.getElementById("report_container").style.margin="0 auto";
	}



});//end document ready