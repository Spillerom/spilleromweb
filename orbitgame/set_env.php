<?php

// TODO: THIS MUST REFLECT THE USERS TIMEZONE:
date_default_timezone_set('Europe/Amsterdam');


// 
class Environment {
	const OFFLINE = 1;
	const LOCALHOST = 2;
	const STAGE = 3;
	const PROD = 4;
}


//
$environment = Environment::OFFLINE;
//$environment = Environment::LOCALHOST;
//$environment = Environment::STAGE;
//$environment = Environment::PROD;

// REPORT ALL PHP ERRORS IF ON LOCALHOST:
if( (Environment::OFFLINE == $environment) || (Environment::LOCALHOST == $environment) ) {
	ini_set ("display_errors", "1");
	error_reporting(E_ALL);
}


##
## This file sets up the environoment for each page
##

if( !isset($path) ) {
	$path = "";
}

// Include files
require_once $path.'model/MySqli_proc_DB.php';
require_once $path.'model/LevelDataManager.php';

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
		$appDBHost = 'localhost';
		$appDBUser = 'root';
		$appDBPass = 'root';
		$appDBName = 'orbitgame';
		
		// 
		//$sessionKey = md5('Orbitgame - localhost');
	break;
	
	// 
	case Environment::STAGE:
		// SET UP DB CONNECTION:
		$appDBHost = '';
		$appDBUser = '';
		$appDBPass = '';
		$appDBName = '';
		
		//
		//$sessionKey = md5("Orbitgame - STAGE");
	break;
	
	// 
	case Environment::PROD:
		// SET UP DB CONNECTION:
		$appDBHost = '';
		$appDBUser = '';
		$appDBPass = '';
		$appDBName = '';
		
		//
		//$sessionKey = md5("Orbitgame - LIVE");
	break;
}


// 
if( $environment != Environment::OFFLINE ) {
	// 
	$appDB = new MySqlDB();
	$appDB->Connect($appDBHost, $appDBUser, $appDBPass, $appDBName);
	$appDB->Query('SET NAMES utf8');

	##
	## Initialize the "LevelData Manager" class
	##
	$level = new LevelData($appDB);
}


##
## HANDLE LANGUAGE
##

// TODO: READ THIS FROM THE USERS SETTINGS

// 
require_once $path.'settings.php';

// 
require_once $path.'language/'.$settings['LANGUAGE'].'/localizedStrings.php';


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