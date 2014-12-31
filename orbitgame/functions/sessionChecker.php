<?php
if( $environment == Environment::PROD ) {
	if( isset($_COOKIE["inverter_email"]) ) {
		// 
		$loginEmail = $_COOKIE["inverter_email"];
		$generalAdministrator = $generalAdministratorManager->GetByEmail($loginEmail);
	} else {
		header('location: login_error.php');
	}
}
?>