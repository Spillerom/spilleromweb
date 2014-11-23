<?php

$path = "../";
require_once $path."set_env.php";

// 
$name = GetPostVar("name");
$from = GetPostVar("email");
$message = GetPostVar("message");

// Generate the subject from the message
$strippedMessage = str_replace("\n", "", $message);
$strippedMessage = str_replace("\r", "", $strippedMessage);
$subject  = substr($strippedMessage, 0, min(20, strlen($strippedMessage)))."..";

$headers = "From: ".$name." <".$from.">\r\n";

$to = "contact@spillerom.no";

// 
if( $message != '' ) {
	// 
	if (@mail($to, $subject, $message, $headers)) {
    	echo "ok";
	} else {
    	echo "send-error";
	}
} else {
	echo "empty-field-error";
}
?>