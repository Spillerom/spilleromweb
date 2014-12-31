<?php

class SqlManager {

	// 
	protected $mySql;
	
	protected $tableName;
	
	//
	protected $error = "";
	public function GetLastError() {
		return $error;
	}
	
	/////////////////////////////
	function __construct($mySql, $tableName) {
		$this->mySql = $mySql;
		$this->tableName = $tableName;
		
		//echo "__constructL: tableName: ".$this->tableName."<br>";
	}
	
	/////////////////////////////
	function AddNewElement($query) {
		$queryResult = $this->mySql->Query($query);
	
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return 'ERROR='.$error;
		}
	
		return 'ADDED_NEW='.$this->mySql->GetLastInsertedID();
	}
	
	/////////////////////////////
	function UpdateElement($query, $element) {
		//
		$queryResult = $this->mySql->Query($query);
	
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return 'ERROR='.$error;
		}
	
		//
		return "MODIFYED_EXISTING=".$element->GetID();
	}
	
	/////////////////////////////
	function FetchElement($query) {
		$element = NULL;
	
		$queryResult = $this->mySql->Query($query);
	
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return 'ERROR='.$error;
		}
	
		$numRows = $this->mySql->GetNumRows($queryResult);
	
		if( $numRows != 0 ) {
			$fetchResult = $this->mySql->FetchRow($queryResult);
			$element = $this->GetData($fetchResult);
		}
				
		return $element;
	}
	
	/////////////////////////////
	function FetchElements($query) {
		//
		$elements[] = array();
		array_pop($elements);
	
		//
		$queryResult = $this->mySql->Query($query);
	
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return 'ERROR='.$error;
		}
	
		$numRows = $this->mySql->GetNumRows($queryResult);
	
		if( !is_null($queryResult) && !empty($queryResult) ) {
			while ($fetchResult = mysqli_fetch_assoc($queryResult)) {
				$element = $this->GetData($fetchResult);
				array_push($elements, $element);
			}
		}
		return $elements;
	}	
	
	/////////////////////////////
	function GetData($fetchResult) { /* THIS FUNCTION IS DEFINED IN EACH CHILDCLASS */ }

	/////////////////////////////
	function GetAll() {
		$query = "SELECT * FROM ".$this->tableName;
		return self::FetchElements($query);
	}

	/////////////////////////////
	function GetByID($id) {
		$query = "SELECT * FROM ".$this->tableName." WHERE id = '$id'";
		return self::FetchElement($query);
	}
 
	/////////////////////////////
	function GetBy($column, $value) {
		$query = "SELECT * FROM ".$this->tableName." WHERE ".$column." = '$value'";
		return self::FetchElement($query);
	}
 
	/////////////////////////////
	function GetAllBy($column, $value) {
		$query = 'SELECT * FROM '.$this->tableName.' WHERE '.$column.' = "'.$value.'"';
		return self::FetchElements($query);
	}
 
	/////////////////////////////
	function Num() {
		// 
		$queryResult = $this->mySql->Query("SELECT * FROM ".$tableName);
		
		if ( !$queryResult ) {
			$error = $this->mySql->Error();
			return "ERROR=".$error;
		}
		
		$numRows = $this->mySql->GetNumRows($queryResult);
		
		return $numRows;	
	}

	/////////////////////////////
	function DeleteByID($id) {
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