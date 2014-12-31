<?php
    class MySqlDB {
        //////////////////////////////////////////////////////////////////////////////
		function __construct() {
		}
    		
        //////////////////////////////////////////////////////////////////////////////
        function Connect($sqlserver, $sqluser, $sqlpassword, $database) {
            $this->connect_id = mysql_connect($sqlserver, $sqluser, $sqlpassword);
			
            if($this->connect_id) {
                if (mysql_select_db($database)) {
                    return $this->connect_id;
                } else {
                    return $this->Error();
                }
            } else {
                return $this->Error();
            }
        }		
        //////////////////////////////////////////////////////////////////////////////
        function PConnect($sqlserver, $sqluser, $sqlpassword, $database) {
            $this->connect_id = mysql_pconnect($sqlserver, $sqluser, $sqlpassword);
			
            if($this->connect_id) {
                if (mysql_select_db($database)) {
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
            return mysql_error();
        }

        //////////////////////////////////////////////////////////////////////////////
        function Query($query) {
            if ($query != NULL) {
                $this->query_result = mysql_query($query, $this->connect_id);
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
                $return = mysql_num_rows($this->query_result); 
            } else {
                $return = mysql_num_rows($query_id);
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
                $return = mysql_fetch_array($this->query_result); 
            } else {
                $return = mysql_fetch_array($query_id);
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
                $return = mysql_affected_rows($this->query_result); 
            } else {
                $return = mysql_affected_rows($query_id);
            }
			
            if(!$return) {
                $this->Error();
            } else {
                return $return;
            }
        }

        //////////////////////////////////////////////////////////////////////////////
        function GetLastInsertedID() {
			return mysql_insert_id();
        }

        //////////////////////////////////////////////////////////////////////////////
        function Close() {
            if($this->connect_id) {
                return mysql_close($this->connect_id);
            }
        }

    }

    /*
	// Example:
    $DB = new MySqlDB();
    $DB->Connect('sql_host', 'sql_user', 'sql_password', 'sql_database_name');
    $DB->Query("SELECT * FROM `members`");
    $DB->Close();
	*/
?>