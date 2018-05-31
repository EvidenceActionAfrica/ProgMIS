$(document).ready(function(){


// alert("working");
	console.log("working");

// on key down add fields

// this function adds ecd male and female
function add_ecd(){
	// get value of ids
	var treated_male=parseInt($("#FormS_ecd_treated_male").val(),10);
	var treated_female=parseInt($("#FormS_ecd_treated_female").val(),10);

	// parse them into numbers. otherwise you will just concatnate them
	// var treated_male=parseInt(treated_male,10)
	// var treated_female=parseInt(treated_female,10)

	var treated_total=treated_male+treated_female;
	// NaN is give the other value is null
	if (isNaN(treated_total)) {
		treated_total=0;
	};
	console.log(treated_total);
	$("#FormS_ecd_treated_children_total").val(treated_total);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );

}

function add_non_enrolled(){
	// get value of ids
	var years_2_5_male=parseInt($("#FormS_years_2_5_male").val(),10);
	var years_2_5_female=parseInt($("#FormS_years_2_5_female").val(),10);
	var years_6_10_male=parseInt($("#FormS_years_6_10_male").val(),10);
	var years_6_10_female=parseInt($("#FormS_years_6_10_female").val(),10);
	var years_11_14_male=parseInt($("#FormS_years_11_14_male").val(),10);
	var years_11_14_female=parseInt($("#FormS_years_11_14_female").val(),10);
	var years_15_18_male=parseInt($("#FormS_years_15_18_male").val(),10);
	var years_15_18_female=parseInt($("#FormS_years_15_18_female").val(),10);

	// parse them into numbers. otherwise you will just concatnate them
	// var treated_male=parseInt(treated_male,10)
	// var treated_female=parseInt(treated_female,10)

	var treated_total=years_2_5_male+
						years_2_5_female+
						years_6_10_male+
						years_6_10_female+
						years_11_14_male+
						years_11_14_female+
						years_15_18_male+
						years_15_18_female;
	// NaN is give the other value is null
	if (isNaN(treated_total)) {
		treated_total=0;
	};
	console.log(treated_total);
	$("#FormS_non_enrolled_total").val(treated_total);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );

}

function section5_children(){
	// get value of ids
	var treated_male=parseInt($("#FormS_ecd_treated_male").val(),10);
	var treated_female=parseInt($("#FormS_ecd_treated_female").val(),10);

	// parse them into numbers. otherwise you will just concatnate them
	// var treated_male=parseInt(treated_male,10)
	// var treated_female=parseInt(treated_female,10)

	var treated_total=treated_male+treated_female;
	// NaN is give the other value is null
	if (isNaN(treated_total)) {
		treated_total=0;
	};
	console.log(treated_total);
	$("#FormS_ecd_treated_children_total").val(treated_total);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );
}

$( "#FormS_ecd_treated_male ,#FormS_ecd_treated_female" ).keyup(function() {
	add_ecd();
});

$( "#FormS_years_2_5_male,#FormS_years_2_5_female,#FormS_years_6_10_male,#FormS_years_6_10_female,#FormS_years_11_14_male,#FormS_years_11_14_female,#FormS_years_15_18_male,#FormS_years_15_18_female" ).keyup(function() {
	add_non_enrolled();
});


$( "#text_survey_id" ).keyup(function() {
	text_survey_id();
});

$( "#text_sheet_number" ).keyup(function() {
	//text_sheet_number();
});

$( "#text_aeo_name" ).keyup(function() {
	text_aeo_name();
});

$( "#text_aeo_phone_number" ).keyup(function() {
	text_aeo_phone_number();
});

$( "#text_district" ).keyup(function() {
	text_district();
});

$( "#text_division" ).keyup(function() {
	text_division();
});

// this runs the function iside whenever the page loads
// for formA hidden fields
$(getFormAText());



function getFormAText(){
	text_division();
	text_survey_id();
	text_sheet_number();
	text_aeo_name();
	text_aeo_phone_number();
	text_district();
}

function text_survey_id(){
	// get value of ids
	var text_survey_id=$("#text_survey_id").val();
	$(".survey_id").val(text_survey_id);
	
}

function text_sheet_number(){
	// get value of ids
	var text_survey_id=$("#text_sheet_number").val();
	$(".sheet_number").val(text_survey_id);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );
}

function text_aeo_name(){
	// get value of ids
	var text_survey_id=$("#text_aeo_name").val();
	$(".aeo_name").val(text_survey_id);

	// for form D
	var text_survey_id=$("#text_deo_name").val();
	$(".deo_name").val(text_survey_id);
	
}

function text_aeo_phone_number(){
	// get value of ids
	var text_survey_id=$("#text_aeo_phone_number").val();
	$(".aeo_phone_number").val(text_survey_id);
	
	var text_survey_id=$("#text_deo_phone_number").val();
	$(".deo_phone_number").val(text_survey_id);
}

function text_district(){
	// get value of ids
	var text_survey_id=$("#text_district").val();
	$(".district").val(text_survey_id);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );
}

function text_division(){
	// get value of ids
	var text_survey_id=$("#text_division").val();
	$(".division").val(text_survey_id);
	// alert(treated_total);
  // alert( "Handler for .keydown() called." );
}




// show grand totals when clicked
$(".show_grand_totals").click(function(){
	$(".grand_totals").show();
});


$( ".Ajax" ).click(function() {
	alert("fdds");
	 var string=$(".survey_id").val();
})






	

			$(document).ready(function(){
			    var next = 1;
			    $(".add-more").click(function(e){
			        e.preventDefault();
			        var addto = "#field" + next;
			        next = next + 1;
			         var formD_survey_id=' echo $formD_survey_id?>';
			        var formD_sheet_number=' echo $formD_sheet_number?>';
			        var newIn = '<tr id="field'+ next + '" name="field' + next + '"><div class="conatiner four columns vfloatleft"> <input type="hidden" name="survey_id[]" class="survey_id" placeholder="survey_id" value="<?php'+formD_survey_id+'"> </div> <div class="conatiner four columns vfloatleft"> <input type="hidden" name="sheet_number[]" class="sheet_number" placeholder="sheet_number" value="<?php'+formD_sheet_number+'"> </div> <div class="vclear"></div> <div class="conatiner four columns vfloatleft"> <input type="hidden" name="deo_name[]" class="deo_name" placeholder="deo_name" value=""> </div> <div class="conatiner four columns vfloatleft"> <input type="hidden" name="district[]" class="district" placeholder="district" value=""> </div> <div class="vclear"></div> <div class="conatiner four columns vfloatleft"> <input type="hidden" name="deo_phone_number[]" class="deo_phone_number" placeholder="deo_phone_number" value=""> </div> <div class="vclear"></div> <td>'+next+'</td> <td> <div class="rowdz"> <input type="text" name="division[]" placeholder="division" value="division"> </div> </td> <div class="rowdz"> <input type="text" name="date_form_a_recieved[]" placeholder="date_form_a_recieved" value="date_form_a_recieved"> </div> </td> <td> <div class="rowdz"> <input type="text" name="date_form_a_recieved[]" placeholder="date_form_a_recieved" value="date_form_a_recieved"> </div> </td> <td> <div class="rowd"> <input type="text" name="ecd_treated_male[]" placeholder="ecd_treated_male" value="ecd_treated_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="ecd_treated_female[]" placeholder="ecd_treated_female" value="ecd_treated_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="ecd_treated_children_total[]" placeholder="ecd_treated_children_total" value="ecd_treated_children_total"> </div> </td> <td> <div class="rowd"> <input type="text" name="total_enrolled_in_register[]" placeholder="total_enrolled_in_register" value="total_enrolled_in_register"> </div> </td> <td> <div class="rowd"> <input type="text" name="enrolled_male[]" placeholder="enrolled_male" value="enrolled_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="enrolled_female[]" placeholder="enrolled_female" value="enrolled_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="enrolled_treated_total[]" placeholder="enrolled_treated_total" value="enrolled_treated_total"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_2_5_male[]" placeholder="years_2_5_male" value="years_2_5_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_2_5_female[]" placeholder="years_2_5_female" value="years_2_5_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_6_10_male[]" placeholder="years_6_10_male" value="years_6_10_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_6_10_female[]" placeholder="years_6_10_female" value="years_6_10_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_11_14_male[]" placeholder="years_11_14_male" value="years_11_14_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_11_14_female[]" placeholder="years_11_14_female" value="years_11_14_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_15_18_male[]" placeholder="years_15_18_male" value="years_15_18_male"> </div> </td> <td> <div class="rowd"> <input type="text" name="years_15_18_female[]" placeholder="years_15_18_female" value="years_15_18_female"> </div> </td> <td> <div class="rowd"> <input type="text" name="non_enrolled_total[]" placeholder="non_enrolled_total" value="non_enrolled_total"> </div> </td> </tr> '; var newInput = $(newIn);
			        $(addto).after(newInput);
			        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
			        $("#count").val(next);  
			    });
			});








});//end document ready