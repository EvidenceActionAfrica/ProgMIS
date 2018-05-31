<?php

class sms {

  private $sms;

  public function sendSMS($recepient, $text) {
    require_once('application/views/issueTracker/InfobipGateway.php');
    $username = "EvidenceAc";
    $apiKey = "7e264ef92d19ffd294f8bdafa5f126c7193c4bfd5bf5a9fb2151d605b5079fa4";
	

    $recipients = "$recepient";
    $message = "$text";
    $gateway = new InfobipGateway($username, $apiKey);
    $send_sms_feedback = $gateway->sendMessage($recipients, $message);
	echo $send_sms_feedback;
  }

}

?>
