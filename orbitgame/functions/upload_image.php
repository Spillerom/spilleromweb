<?php
// 
$UPLOAD_MAX_SIZE = 1000000000;
$uploadFolder = 'uploaded_receipts/';
$images = array("receipt-upload-file");
$imageIndex = 0;
$fileUploadError = "";


	// 
foreach( $images as $name ) {
	// 
	$originalFilename = $_FILES[$name]["name"];

	// 
	$filetype = strtolower($_FILES[$name]["type"]);

	// 
	switch( $filetype ) {
		case "application/pdf":
		case "image/pdf":
			$filetype = ".pdf";
			break;

		case "image/psd":
			$filetype = ".psd";
			break;

		case "image/png":
		case "image/x-png":
			$filetype = ".png";
			break;

		case "image/jpeg":
		case "image/pjpeg":
		case "image/jpg":
			$filetype = ".jpg";
			break;

		case "image/tiff":
			$filetype = ".tiff";
			break;

		case "image/bmp":
			$filetype = ".bmp";
			break;

		case "image/tga":
			$filetype = ".tga";
			break;

		case "image/gif":
			$filetype = ".gif";
			break;

		default:
			//LocalizedString('UPLOADED_IMAGE_FORMAT_UNKNOWN').", filetype: ".$filetype;
			$fileUploadError = $localizedStrings['UPLOADED_IMAGE_FORMAT_UNKNOWN']." (".$filetype.").";
	}

	// CHECK FILE SIZE:
	if( ($_FILES[$name]["size"] > $UPLOAD_MAX_SIZE ) ) {
		// LocalizedString('UPLOADED_IMAGE_TOO_LARGE');
		$fileUploadError = $localizedStrings['UPLOADED_IMAGE_TOO_LARGE'];
	}

	// CHECK ERRORS:
	if( $_FILES[$name]["error"] > 0 ) {
		// echo $_FILES[$name]["error"];
		$fileUploadError = $_FILES[$name]["error"];
	} else {

		$complaint->SetReceiptUrl($uploadFolder."receipt_".$complaint->GetID()."_".$imageIndex.$filetype);
		if( move_uploaded_file($_FILES[$name]['tmp_name'], $complaint->GetReceiptUrl() ) ) {
			$imageIndex++;
		} else {
			if( strcmp($fileUploadError, "") == 0 ) {
				$fileUploadError = $_FILES[$name]["error"];
			}
		}
		
	}
}


?>