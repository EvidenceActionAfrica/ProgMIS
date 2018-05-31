//==============================  Num-only ===============================
//add class="num-only" 
$(document).find("input.num-only").keydown(function (e) {
  // Allow: backspace, delete, tab, escape, enter and .
  if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	   // Allow: Ctrl+A
	  (e.keyCode == 65 && e.ctrlKey === true) || 
	   // Allow: home, end, left, right
	  (e.keyCode >= 35 && e.keyCode <= 39)) {
		   // let it happen, don't do anything
		   return;
  }
  // Ensure that it is a number and stop the keypress
  if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	  e.preventDefault();
  }
});


//==============================  block return key from submitting form ===============================
 document.onkeypress = function(e)  {
    e = e || window.event;
    if (typeof e != 'undefined') {
      var tgt = e.target || e.srcElement;
      if (typeof tgt != 'undefined' && /input/i.test(tgt.nodeName))
        return (typeof e.keyCode != 'undefined') ? e.keyCode != 13 : true;
    }
  }
  
