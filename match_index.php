<?php

if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
 
    // include db handler
    require_once 'match_functions.php';
    $db = new MatchFunctions();
    
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
    
    if ($tag == 'add_match') {
        $team = $_POST['team'];
        $opponent = $_POST['opponent'];
        $venue = $_POST['venue'];
        $time = $_POST['time'];
        
        $match = $db->storeMatch($team, $opponent, $venue, $time);
        if ($match) {
            $response["success"] = 1;
            $response["match"]["id"] = $match["id"];
            $response["match"]["team"] = $match["team"];
            $response["match"]["opponent"] = $match["opponent"];
            $response["match"]["venue"] = $match["location"];
            $response["match"]["time"] = $match["game_time"];
            echo json_encode($response);
        } else {
            $response["error"] = 1;
            $response["error_msg"] = "Error occurred while adding match";
            echo json_encode($response);
        }
    }
    else if ($tag == 'get_matches') {
        $team = $_POST['team'];
        $matches = $db->getMatches($team);
        echo json_encode($matches);
    }
    else if ($tag == 'add_attendance') {
        $player = $_POST['player'];
        $match = $_POST['match'];
        $attend = $_POST['attend'];
        
        $attendance = $db->addAttendance($player, $match, $attend);
        if ($attendance) {
            $response["success"] = 1;
            echo json_encode($response);
        }
        else {
            $response["error"] = 1;
            $response["error_msg"] = "Error occurred while adding attendance";
            echo json_encode($response);
        }
    }
    else if ($tag == 'get_attendance') {
        $match = $_POST['match'];
        $attendance = $db->getAttendance($response, $match);
        echo json_encode($attendance);
    }
    else {
        echo "Invalid Request";
    }
    
} else {
    echo "Access Denied";
}

?>