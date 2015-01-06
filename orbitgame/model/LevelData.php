<?php

// 
class LevelData {
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
	
	// Set / get "name"
	private $name;
	function SetName($value) {
		$this->name = $value;
	}
	function GetName() {
		return $this->name;
	}
	
	// Set / get "universe"
	private $universe;
	function SetUniverse($value) {
		$this->universe = $value;
	}
	function GetUniverse() {
		return $this->universe;
	}
	
	// Set / get "creator"
	private $creator;
	function SetCreator($value) {
		$this->creator = $value;
	}
	function GetCreator() {
		return $this->creator;
	}		
	// Set / get "planets"
	private $data;
	function SetData($value) {
		$this->data = $value;
	}
	function GetData() {
		return $this->planets;
	}
}
?>