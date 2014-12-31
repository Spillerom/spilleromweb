<?php
    class MySqlDB {
        //////////////////////////////////////////////////////////////////////////////
		function __construct() {
		}
    		
        //////////////////////////////////////////////////////////////////////////////
        function Connect($sqlserver, $sqluser, $sqlpassword, $database) {
            $this->connect_id = mysqli_connect($sqlserver, $sqluser, $sqlpassword);
			
            if($this->connect_id) {
                if (mysqli_select_db($this->connect_id, $database)) {
                    return $this->connect_id;
                } else {
                    return $this->Error();
                }
            } else {
                return $this->Error();
            }
        }		

        //////////////////////////////////////////////////////////////////////////////
        function Error() {
            return mysqli_error($this->connect_id);
        }

        //////////////////////////////////////////////////////////////////////////////
        function Query($query) {
            if ($query != NULL) {
                $this->query_result = mysqli_query($this->connect_id, $query);
                if(!$this->query_result) {
                    return $this->Error();
                } else {
                    return $this->query_result;
                }
            } else {
                //return '<b>MySQL Error</b>: Empty Query!';
            }
        }

        //////////////////////////////////////////////////////////////////////////////
        function GetNumRows($query_id)
        {
            if( is_null($query_id) ) {
                $return = mysqli_num_rows($this->query_result); 
            } else {
                $return = mysqli_num_rows($query_id);
            }
			
            if(!$return) {
                $this->Error();
            } else {
                return $return;
            }
        }

        //////////////////////////////////////////////////////////////////////////////
        function FetchRow($query_id = "") {
            if($query_id == NULL) {
                $return = mysqli_fetch_array($this->query_result, MYSQLI_ASSOC); 
            } else {
                $return = mysqli_fetch_array($query_id, MYSQLI_ASSOC);
            }
			
            if(!$return) {
                $this->Error();
            } else {
                return $return;
            }
        }    

        //////////////////////////////////////////////////////////////////////////////
        function GetAffectedRows($query_id = "") {
            if($query_id == NULL) {
                $return = mysqli_affected_rows($this->connect_id, $this->query_result); 
            } else {
                $return = mysqli_affected_rows($this->connect_id, $query_id);
            }
			
            if(!$return) {
                $this->Error();
            } else {
                return $return;
            }
        }

        //////////////////////////////////////////////////////////////////////////////
        function GetLastInsertedID() {
			return mysqli_insert_id($this->connect_id);
        }

        //////////////////////////////////////////////////////////////////////////////
        function Close() {
            if($this->connect_id) {
                return mysqli_close($this->connect_id);
            }
        }

    }

    /*
	// Example:
    $DB = new MySqlDB();
    $DB->Connect('sql_host', 'sql_user', 'sql_password', 'sql_database_name');
    $DB->Query("SELECT * FROM `tabe_name`");
    $DB->Close();
	*/
?>