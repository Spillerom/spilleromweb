<?php

// TODO: THIS MUST REFLECT THE USERS TIMEZONE:
date_default_timezone_set('Europe/Amsterdam');


// 
class Environment {
	const LOCALHOST = 1;
	const STAGE = 2;
	const PROD = 3;
}


//
$environment = Environment::LOCALHOST;
//$environment = Environment::STAGE;
//$environment = Environment::PROD;

// REPORT ALL PHP ERRORS IF ON LOCALHOST:
if( (Environment::LOCALHOST == $environment) ) {
	ini_set ("display_errors", "1");
	error_reporting(E_ALL);
}

// 
$debugging = true;

##
## This file sets up the environoment for each page
##

if( !isset($path) ) {
	$path = "";
}

// Include files
require_once $path.'model/MySqli_proc_DB.php';
require_once $path.'model/WaterPumpModelManager.php';

##
## SET UP SESSIONS
##
//session_start();

##
## Initialize and connect to the MySqlDB class
##

switch( $environment ) {
	
	// 
	case Environment::LOCALHOST:
		// SET UP DB CONNECTION:
		$appDBHost = '';
		$appDBUser = '';
		$appDBPass = '';
		$appDBName = '';
		
		// 
		//$sessionKey = md5("WATER_PUMP_COMPLAINT_LOCALHOST");
	break;
	
	// 
	case Environment::STAGE:
		// SET UP DB CONNECTION:
		$appDBHost = '';
		$appDBUser = '';
		$appDBPass = '';
		$appDBName = '';
		
		//
		//$sessionKey = md5("WATER_PUMP_COMPLAINT_STAGE");
	break;
	
	// 
	case Environment::PROD:
		// SET UP DB CONNECTION:
		$appDBHost = '';
		$appDBUser = '';
		$appDBPass = '';
		$appDBName = '';
		
		//
		//$sessionKey = md5("WATER_PUMP_COMPLAINT_PROD");
	break;
}

// 
$appDB = new MySqlDB();
$appDB->Connect($appDBHost, $appDBUser, $appDBPass, $appDBName);
$appDB->Query('SET NAMES utf8');

##
## Initialize the "WaterPumpModel Manager" class
##
$waterPumpModelManager = new WaterPumpModelManager($appDB);


##
## HANDLE LANGUAGE
##

// TODO: READ THIS FROM THE USERS SETTINGS
$language = "no";

// 
require_once $path.'language/'.$language.'/localizedStrings.php';

// 
$stdPassword = md5("12345678");


// 
$date = date("d.m.Y H.i");
$dateMySql = date("Y-m-d H.i");


// 
$UPLOAD_MAX_SIZE = 1000000000;
$uploadFolder = 'uploads/';


##
## HELPER FUNCTIONS:
##

//
require_once $path.'functions/helper_functions.php';

?>