<?php
// 
require_once "LevelData.php";
require_once "SqlManager.php";

// 
class LevelDataManager extends SqlManager {
	
	/////////////////////////////
	function __construct($mySql) {
		parent::__construct($mySql, "level_data");
	}

	/////////////////////////////
	function GetLevelData($fetchResult) {
		// 
		parent::GetData($fetchResult);

		$element = new WaterPumpModel();
		
		$element->SetID($fetchResult['id']);
		$element->SetName($fetchResult['name']);
		$element->SetUniverse($fetchResult['universe']);
		$element->SetCreator($fetchResult['creator']);
		$element->SetData($fetchResult['data']);
		
		// 
		return $element;
	}
	
 	/////////////////////////////
	function AddLevelData($element) {
		// 
		$query = "INSERT INTO ".$this->tableName." (name, universe, creator, data) VALUES ('".$element->GetName()."', '".$element->GetUniverse()."', '".$element->GetCreator()."', '".$element->GetData()."')";
		
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
	function UpdateLevelData($element) {
		// 
		$query = "UPDATE ".$this->tableName." SET name='".$element->GetName()."', universe='".$element->GetUniverse()."', creator='".$element->GetCreator()."', data='".$element->GetData()."' WHERE id='".$element->GetID()."'";
		
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
	function DeleteLevelData($id) {
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
}
	
?>