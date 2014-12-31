<?php


// 
class WaterPumpModelType {
	const INDOOR = 1;	
	const OUTDOOR = 2;	
}


// 
class WaterPumpModel {
	// Constructor
	function __construct() {
	}
	
	// Set / get id
	private $id;
	function SetID($value) {
		$this->id = $value;
	}
	function GetID() {
		return $this->id;
	}
	
	// Set / get "complaint id"
	private $complaintId;
	function SetComplaintId($value) {
		$this->complaintId = $value;
	}
	function GetComplaintId() {
		return $this->complaintId;
	}
	
	// Set / get "type"
	private $type;
	function SetType($value) {
		$this->type = $value;
	}
	function GetType() {
		return $this->type;
	}
		
	// Set / get "model number"
	private $modelNumber;
	function SetModelNumber($value) {
		$this->modelNumber = $value;
	}
	function GetModelNumber() {
		return $this->modelNumber;
	}
	
	// Set / get "serial number"
	private $serialNumber;
	function SetSerialNumber($value) {
		$this->serialNumber = $value;
	}
	function GetSerialNumber() {
		return $this->serialNumber;
	}
}
?>