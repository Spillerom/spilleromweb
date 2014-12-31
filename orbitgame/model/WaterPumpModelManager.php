<?php
// 
require_once "WaterPumpModel.php";
require_once "SqlManager.php";

// 
class WaterPumpModelManager extends SqlManager {
	
	/////////////////////////////
	function __construct($mySql) {
		parent::__construct($mySql, "complaint_waterpumpmodel");
	}

	/////////////////////////////
	function GetData($fetchResult) {
		// 
		parent::GetData($fetchResult);

		$element = new WaterPumpModel();
		
		$element->SetID($fetchResult['id']);
		$element->SetComplaintId($fetchResult['complaintId']);
		$element->SetType($fetchResult['type']);
		$element->SetModelNumber($fetchResult['modelNumber']);
		$element->SetSerialNumber($fetchResult['serialNumber']);
		
		// 
		return $element;
	}
	
 	/////////////////////////////
	function AddWaterPumpModel($element) {
		// 
		$query = "INSERT INTO ".$this->tableName." (complaintId, type, modelNumber, serialNumber) VALUES ('".$element->GetComplaintId()."', '".$element->GetType()."', '".$element->GetModelNumber()."', '".$element->GetSerialNumber()."')";
		
		// 
		$queryResult = $this->mySql->Query($query);
		
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return "ERROR=".$error;
		}
		
		// 
		return "ADDED_NEW=".$this->mySql->GetLastInsertedID();
	}
	
 	/////////////////////////////
	function UpdateWaterPumpModel($element) {
		// 
		$query = "UPDATE ".$this->tableName." SET complaintId='".$element->GetComplaintId()."', type='".$element->GetType()."', modelNumber='".$element->GetModelNumber()."', serialNumber='".$element->GetSerialNumber()."' WHERE id='".$element->GetID()."'";
		
		// 
		$queryResult = $this->mySql->Query($query);
		
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return "ERROR=".$error;
		}
		
		// 
		return "MODIFYED_EXISTING=".$element->GetID();
	}
	
	/////////////////////////////
	function DeleteWaterPumpModelByID($id) {
		// 
		$query = "DELETE FROM ".$this->tableName." WHERE id = ".$id;
		
		// 
		$queryResult = $this->mySql->Query($query);
		
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return "ERROR=".$error;
		}
		
		// 
		return "REMOVED_ENTRY=".$id;
	}

	
	/////////////////////////////
	function GetFirstWaterPumpByComplaintId($complaintId) {
		$query = "SELECT * FROM ".$this->tableName." WHERE complaintId='".$complaintId."' ORDER BY id";
		return self::FetchElement($query);
	}
	
	/////////////////////////////
	function GetFirstOutdoorWaterPumpByComplaintId($complaintId) {
		$query = "SELECT * FROM ".$this->tableName." WHERE type='".WaterPumpModelType::OUTDOOR."' AND complaintId='".$complaintId."' ORDER BY id";
		return self::FetchElement($query);
	}

	/////////////////////////////
	function GetOutdoorWaterPumpByComplaintId($complaintId) {
		$query = "SELECT * FROM ".$this->tableName." WHERE type='".WaterPumpModelType::OUTDOOR."' AND complaintId='".$complaintId."' ORDER BY id";
		return self::FetchElements($query);
	}
	
	/////////////////////////////
	function GetFirstIndoorWaterPumpByComplaintId($complaintId) {
		$query = "SELECT * FROM ".$this->tableName." WHERE type='".WaterPumpModelType::INDOOR."' AND complaintId='".$complaintId."' ORDER BY id";
		return self::FetchElement($query);
	}
		
	/////////////////////////////
	function GetIndoorWaterPumpByComplaintId($complaintId) {
		$query = "SELECT * FROM ".$this->tableName." WHERE type='".WaterPumpModelType::INDOOR."' AND complaintId='".$complaintId."' ORDER BY id";
		return self::FetchElements($query);
	}	
}
	
?>