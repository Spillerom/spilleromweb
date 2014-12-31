<?php
    class MySqlDB {
        //////////////////////////////////////////////////////////////////////////////
		function __construct() {
		}

        //////////////////////////////////////////////////////////////////////////////
        function Connect($sqlserver, $sqluser, $sqlpassword, $database) {
            $this->db = new mysqli($sqlserver, $sqluser, $sqlpassword, $database);

            if( $this->db->connect_errno > 0 ) {
                return 'Unable to connect to database [' . $db->connect_error . ']';
            }
            return $this->db;
        }

        //////////////////////////////////////////////////////////////////////////////
        function Error() {
            return $this->db->error;
        }

        //////////////////////////////////////////////////////////////////////////////
        function Query($query) {
            if( !$this->result = $db->query($query) ) {
                return 'There was an error running the query [' . $db->error . ']';
            }
            return $this->result;
        }

        //////////////////////////////////////////////////////////////////////////////
        function GetNumRows() {
            return $this->db->num_rows;
        }

        //////////////////////////////////////////////////////////////////////////////
        function FetchRow() {
            if( $this->result ) {
                return $this->result->fetch_array();
            }
        }    

        //////////////////////////////////////////////////////////////////////////////
        function GetAffectedRows() {
            return $this->db->affected_rows;
        }

        //////////////////////////////////////////////////////////////////////////////
        function GetLastInsertedID() {
			return mysqli_insert_id();
        }

        //////////////////////////////////////////////////////////////////////////////
        function Close() {
            if($this->db) {
                $this->db->close;
            }
        }

    }
?>