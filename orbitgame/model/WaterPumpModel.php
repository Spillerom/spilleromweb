<?php

// 
class Level {
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
		
	// Set / get "planets"
	private $planets;
	function SetPlanets($value) {
		$this->planets = $value;
	}
	function GetPlanets() {
		return $this->planets;
	}
	
	// Set / get "serial number"
	private $startPos;
	function SetStartPos($value) {
		$this->startPos = $value;
	}
	function GetStartPos() {
		return $this->startPos;
	}
}
?>