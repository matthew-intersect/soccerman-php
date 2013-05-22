<?php
 
class MatchFunctions {
 
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
     * Stores new match
     * returns match details
     */
    public function storeMatch($team, $opponent, $venue, $time) {
        $result = mysql_query("INSERT INTO matches(team, opponent, location, game_time) VALUES('$team', '$opponent', '$venue', '$time')");
        if ($result) {
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM matches WHERE id = $id");
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
}

?>