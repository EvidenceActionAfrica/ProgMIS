//==============================  isBlank ===============================
function isBlank(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue === "") {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                         Please fill this field </b>";
  } else {
    feedback.innerHTML = "";
  }
}
//==============================  dropdown selection =============================== 
function isSelected(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue === "") {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                         Select an option  </b>";
  }else {
    feedback.innerHTML = "";
  }
}
//==============================  isAlphaNumeric ===============================
function isAlphaNumeric(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    var alphaNumExp = /^[0-9 a-zA-Z]+$/;
    if (!inputValue.match(alphaNumExp)) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                            Use only letters & numbers </b>";
    } else {
      feedback.innerHTML = "";
    }
  } else if (inputValue.length === 0) {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                         Please fill this field </b>";
  }
}
//==============================  isAlphabet ===============================
function isAlphabet(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    var alphaExp = /^[a-zA-Z]+$/;
    if (!inputValue.match(alphaExp)) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                            Letters only </b>";
    } else {
      feedback.innerHTML = "";
    }
  } else if (inputValue.length === 0) {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                         Please fill this field </b>";
  }
}
//==============================  isNumeric ===============================
function isNumeric(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    var numericExpression = /^[0-9\.\+\-]+$/;
    if (!inputValue.match(numericExpression)) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                            Numeric values only </b>";
      document.getElementById(element).value = "";
    } else {
      feedback.innerHTML = "";
    }
  }
}
//==============================  isNumericErase ===============================
function isNumericErase(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  if (inputValue !== "") {
    var numericExpression = /^[0-9\.\+\-]+$/;
    if (!inputValue.match(numericExpression)) {
      document.getElementById(element).value = "";
    }
  }
}
//==============================  isCostNum ===============================
function isCostNum(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  if (inputValue !== "") {
    var numericExpression = /^[0-9\.\+\-]+$/;
    if (!inputValue.match(numericExpression)) {
      document.getElementById(element).value = "";
    }
  }
}
//==============================  isPhoneNumber ===============================
function isPhoneNumber(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    var phoneNumber = /^[0-9\.\+]+$/;
    if (!inputValue.match(phoneNumber)) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                            Numeric values only </b>";
      document.getElementById(element).value = "254";
    } else {
      feedback.innerHTML = "";
    }
  }
}
//==============================  emailValid ===============================
function isEmail(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    var emailExp = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([com\co\.\in\co.ke])+$/;
            if (!inputValue.match(emailExp)) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                         Invalid Email address </b>";
    } else {
      feedback.innerHTML = "";
    }
  } else if (inputValue.length === 0) {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                       Please fill this field </b>";
  }
}
//==============================  char length ===============================
function  charlen(element) {
  var inputId = document.getElementById(element);
  var inputValue = inputId.value;
  var chrlen = inputValue.length;
  var feedback = document.getElementById(element + 'Span');
  if (inputValue !== "") {
    if (chrlen < 12) {
      feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                       Input too short </b>";
    } else {
      feedback.innerHTML = "";
    }
  } else if (chrlen === 0) {
    feedback.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                       Please fill this field </b>";
  }
}
//==============================  Password ===============================
function password(element) {
  var pawd1 = document.getElementById('pwd');
  var palt = document.getElementById('pwd1');
  if (pawd1.value.length === 0) {
    palt.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                      Please fill this field </b>";
  }
  else {
    palt.innerHTML = "";
  }
}
//============================== passwordMatch ===============================
function pass(element1, element2) {
  var pawd1 = document.getElementById('pwd');
  var pawdcon2 = document.getElementById('pwd_con');
  var palt = document.getElementById('pwd1');
  var pcalt = document.getElementById('pwdcon1');

  if (pawdcon2.value.length === 0) {
    pcalt.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                      Invalid Password Cofirm </font>";
  }
  else if (pawd1.value !== pawdcon2.value) {
    pcalt.innerHTML = "";
    palt.innerHTML = "<br/><b style='color:white; background-color:red; border-radius:5px; padding:2px;'>\n\
                      Password Mismatch</font>";
  } else {
    palt.innerHTML = "";
    pcalt.innerHTML = "";
  }
}