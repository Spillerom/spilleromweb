<?php

// 
function DebugText($text) {
	echo '<br>';
	echo '<div class="debugtext">'.$text.'</div>';
	echo '<br>';
}

//
function LocalizedString($key) {
	global $localizedStrings;
	echo $localizedStrings[$key];
}

// 
function FixDate($date) {
	$dateComponents = explode('.', $date);
	return date("Y-m-d", strtotime($dateComponents[2].'-'.$dateComponents[1].'-'.$dateComponents[0]));
}

// GET URL VAR VALUE, RETURN AN EMPTY STRING IF NOT SET:
function GetURLVar($name) {
	$retval = '';
	if( isset($_GET[$name]) ) {
		$retval = htmlspecialchars($_GET[$name], ENT_QUOTES);
		
		if( 0 == strcmp($retval, 'null')) $retval = '';
	}
	return $retval;
}

// GET POST VAR VALUE, RETURN AN EMPTY STRING IF NOT SET:
function GetPostVar($name) {
	$retval = '';
	if( isset($_POST[$name]) ) {
		$retval = htmlspecialchars($_POST[$name], ENT_QUOTES);
		
		if( 0 == strcmp($retval, 'null')) $retval = '';
	}
	return $retval;
}

// GET COOKIE VALUE, RETURN AN EMPTY STRING IF NOT SET:
function GetCookie($name) {
	$retval = '';
	if( isset($_COOKIE[$name]) ) {
		$retval = htmlspecialchars($_COOKIE[$name], ENT_QUOTES);
		
		if( 0 == strcmp($retval, 'null')) $retval = '';
	}
	return $retval;
}

// 
function CheckUrlRewriting($s) { 
	// Get the current URL without the query string, with the initial slash 
	$myurl = preg_replace ('/\?.*$/', '', $_SERVER['REQUEST_URI']); 
	//If it is not the same as the desired URL, then redirect 
	if ($myurl != "/$s") {
		Header ("Location: /$s", true, 301);
		exit;
	}
}

?>