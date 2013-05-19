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
     * Adds player to team
     */
    public function joinTeam($code, $player) {
        $team = $this->getTeamIdFromCode($code);
        $result = mysql_query("INSERT INTO team_players(team_id, player_id) VALUES('$team', '$player')");
        if ($result) {
            $result = mysql_query("SELECT * FROM team_players WHERE team_id = $team AND player_id = $player");
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
    /**
     * Gets all teams of a player
     */
    public function getPlayersTeams($res, $player) {
        $result = mysql_query("SELECT teams.id, teams.name, users.name as 'manager' FROM teams INNER JOIN team_players ON teams.id=team_players.team_id
        INNER JOIN users on team_players.player_id = users.id WHERE team_players.player_id = $player OR teams.created_by = $player");
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $res['teams'][] = array('id' => $row['id'], 'name' => $row['name'], 'manager' => $row['manager']);
            }
        }
        if (mysql_num_rows($result) > 0) {
            $res['success'] = 1;
        }
        return $res;
    }
    
    public function playerInTeam($team, $player) {
        $result = mysql_query("SELECT * from team_players WHERE team_id = '$team' AND player_id = '$player'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getTeamIdFromCode($code) {
        $result = mysql_query("SELECT id from teams WHERE code = '$code'");
        $row = mysql_fetch_array($result);
        return $row['id'];
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