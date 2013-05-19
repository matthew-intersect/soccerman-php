<?php
 
class TeamFunctions {
 
    private $db;
 
    //put your code here
    // constructor
    function __construct() {
        require_once 'connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
    
    /**
     * Storing new team
     * returns team details
     */
    public function storeTeam($name, $created_by) {
        $code = substr(uniqid(rand(10,1000),false),rand(0,10),6);
        while($this->codeExists($code)) {
            $code = substr(uniqid(rand(10,1000),false),rand(0,10),6);
        }
        $result = mysql_query("INSERT INTO teams(name, code, created_by, created_at) VALUES('$name', '$code', '$created_by', NOW())");
        // check for successful store
        if ($result) {
            // get team details 
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM teams WHERE id = $id");
            // return team details
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
    
    /**
     * Check whether team name exists or not
     */
    public function teamNameExists($name) {
        $result = mysql_query("SELECT name from teams WHERE name = '$name'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Check whether team code exists or not
     */
    public function codeExists($code) {
        $result = mysql_query("SELECT code from teams WHERE code = '$code'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
}
 
?>