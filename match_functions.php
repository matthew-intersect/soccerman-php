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
    public function storeMatch($team, $opponent, $venue, $home, $time) {
        $result = mysql_query("INSERT INTO matches(team, opponent, location, home_away, game_time) VALUES('$team', '$opponent', '$venue', '$home', '$time')");
        if ($result) {
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM matches WHERE id = $id");
            return mysql_fetch_array($result);
        } else {
            return false;
        }
    }
    
    /**
     * Gets all matches for a team
     */
    public function getMatches($team, $res) {
        $result = mysql_query("SELECT * FROM matches WHERE team = $team");
        if ($result) {
            while ($row = mysql_fetch_array($result)) {
                $res['matches'][] = array('id' => $row['id'], 'team' => $row['team'], 'opponent' => $row['opponent'], 
                        'venue' => $row['location'], 'home' => $row["home_away"], 'time' => $row['game_time']);
            }
        }
        if (mysql_num_rows($result) > 0) {
            $res['success'] = 1;
        }
        return $res;
    }
    
    /**
     * Adds player's attendance to a match
     */
    public function addAttendance($player, $match, $attend) {
        $result = mysql_query("SELECT * FROM attendance WHERE player_id = $player and match_id = $match");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) { // update required rather than add
            $update = mysql_query("UPDATE attendance SET attendance = $attend WHERE player_id = $player and match_id = $match");
            if ($update) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            $add = mysql_query("INSERT INTO attendance(player_id, match_id, attendance) VALUES('$player', '$match', '$attend')");
            if ($add) {
                return true;
            }
            else {
                return false;
            }
        }
    }
    
    /**
     * Gets all the player attendances for a match
     */
     public function getAttendance($res, $match) {
        $team = mysql_result(mysql_query("SELECT team FROM matches WHERE id = $match"),0);
        $players = mysql_query("SELECT users.id, users.name FROM users INNER JOIN team_players ON users.id=team_players.player_id WHERE team_players.team_id = $team");
        
        if ($players) {
            while ($row = mysql_fetch_array($players)) {
                $idd = $row['id'];
                $attendance = mysql_query("SELECT * FROM attendance WHERE player_id = $idd and match_id = $match");
                $no_of_rows = mysql_num_rows($attendance);
                if ($no_of_rows > 0) {
                    $attend_response = mysql_fetch_array($attendance);
                    $res['attendances'][] = array('player_id' => $row['id'], 'player_name' => $row['name'], 'attendance' => $attend_response['attendance']);
                }
                else {
                    $res['attendances'][] = array('player_id' => $row['id'], 'player_name' => $row['name'], 'attendance' => -1);
                }
            }
        }
        if (mysql_num_rows($players) > 0) {
            $res['success'] = 1;
        }
        return $res;
    }
    
    public function getPlayerAttendance($match, $player, $res) {
        $attendance = mysql_query("SELECT * FROM attendance WHERE player_id = $player and match_id = $match");
        if ($attendance) {
            if (mysql_num_rows($attendance) > 0) {
                $row = mysql_fetch_array($attendance);
                $res['attendance'] = $row['attendance'];
                return $res;
            }
        }
        $res['attendance'] = "-1";
        return $res;
    }
}

?>