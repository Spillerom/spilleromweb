<?php

##
## This file sets up the environoment for each page
##

require_once $path.'classes/HelperFunctions.php';

// 
$language = GetUrlVar('language');
if( $language == '' ) {
	$language = 'no';
}

require_once $path.'language/'.$language.'/localizedStrings.php';

?>