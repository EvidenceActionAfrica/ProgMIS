<?php

require_once 'sms.php';

echo $fname = $_GET['fname'];
echo $phonenumber = $_GET['phone'];
echo $company = $_GET['company'];
echo $admin= '254721620761';//254717664117';

if (!$fname) {
  $fname = 'Paul';
}
if (!$company) {
  $company = 'bean';
}
if (!$phonenumber) {
  $phonenumber = '254721620761';
  // $phonenumber = '254713309486'; //eve
  //victor	254711641782
  //njeri 	254735996240
  //admin   254717664117
}

$message = ("Hi Martin, " . $fname . " has downloaded your profile from the BEAN Event. Call him back and WOW. His number is " . $phonenumber . " and his company is '" . $company . "'. ");

$sms = new sms();
$recepient = $admin;
$sms->sendSMS($recepient, $message);
?>



<?php

// if (isset($_POST['sendSMS'])) {
// require_once 'sms.php';
// $name= $_GET['name'];
// $phone= $_GET['phone'];
// $message= $_GET['message'];
// $sms = new sms();
// $smsFeedback = $sms->sendSMS($phone, $message);
// }
?>




