<?php

class sms {

  private $sms;

  public function sendSMS($recepient, $text) {
 			require 'application/libs/app.php';
            $message = new SMSRequest();
            $message->senderAddress = 21036;
            $message->address =$recipients;
            $message->message =$_POST["message"];
            $smsClient = new SmsClient(USERNAME, PASSWORD);
            $result = $smsClient->sendSMS($message);
   // $username = "Cubemovers";
   // $apiKey = "bf84a2f1c0026af8dca58a08da84d7d838cb366c7305663f895df136eac4b0f5";
	

    $recipients = "$recepient";
    $message = "$text";
    //$gateway = new AfricaStalkingGateway($username, $apiKey);
    //$send_sms_feedback = $gateway->sendMessage($recipients, $message);
	//echo $send_sms_feedback;
  }

}

?>
