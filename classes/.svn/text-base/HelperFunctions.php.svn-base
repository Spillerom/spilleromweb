<?php

/////////////////////////////
function GetFlagStatus($bool) {
	if( $bool ) {
		echo "_unlit";
	}
}

/////////////////////////////
function GetPostVar($value) {
	$retval = "";
	if( isset($_POST[$value]) ) {
		$retval = $_POST[$value];
	}
	return $retval;
}

/////////////////////////////
function GetUrlVar($value) {
	$retval = null;
	if( isset($_GET[$value]) ) {
		$retval = $_GET[$value];
	}
	return $retval;
}

/////////////////////////////
function LocalizedString($value) {
	global $localizedStrings;
	echo $localizedStrings[$value];
}


?>