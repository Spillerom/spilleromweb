<?php
//
$path = "../";
require_once $path."set_env.php";

//
echo json_encode(array('SETTINGS' => $settings, 'LOCALIZED_STRINGS' => $localizedStrings));
?>