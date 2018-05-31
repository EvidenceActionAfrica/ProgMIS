<?php

class sms {

  private $sms;

  public function sendSMS($recepient, $text) {
    require_once('application/views/issueTracker/AfricasTalkingGateway.php');
    $username = "beanco";
    $apiKey = "7e264ef92d19ffd294f8bdafa5f126c7193c4bfd5bf5a9fb2151d605b5079fa4";
   // $username = "Cubemovers";
   // $apiKey = "bf84a2f1c0026af8dca58a08da84d7d838cb366c7305663f895df136eac4b0f5";
	

    $recipients = "$recepient";
    $message = "$text";
    $gateway = new AfricaStalkingGateway($username, $apiKey);
    $send_sms_feedback = $gateway->sendMessage($recipients, $message);
	echo $send_sms_feedback;
  }

}

?>
