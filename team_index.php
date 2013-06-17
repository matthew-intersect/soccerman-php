<?php

if(isset($_POST['tag']) && $_POST['tag'] != '')
{
    $tag = $_POST['tag'];
 
    require_once 'team_functions.php';
    $db = new TeamFunctions();
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    if($tag == 'add_team')
    {
        $name = $_POST['name'];
        $created_by = $_POST['created_by'];
        $player_manager = $_POST['player_manager'];
        $home_ground = $_POST["home_ground"];
        
        if($db->teamNameExists($name))
        {
            $response["error"] = 1;
            $response["error_msg"] = "Team name already taken";
            echo json_encode($response);
        }
        else
        {
            $team = $db->storeTeam($name, $created_by, $player_manager, $home_ground);
            if($team)
            {
                $response["success"] = 1;
                $response["id"] = $team["id"];
                $response["team"]["name"] = $team["name"];
                $response["team"]["code"] = $team["code"];
                $response["team"]["creator"] = $team["created_by"];
                $response["team"]["creator_role"] = $team["player_manager"];
                $response["team"]["home_ground"] = $team["home_ground"];
                $response["team"]["created_at"] = $team["created_at"];
                echo json_encode($response);
            }
            else
            {
                $response["error"] = 2;
                $response["error_msg"] = "Error occurred while adding team";
                echo json_encode($response);
            }
        }
    }
    else if($tag == 'join_team')
    {
        $code = $_POST['code'];
        $player = $_POST['player'];
        
        if(!$db->codeExists($code))
        {
            $response["error"] = 1;
            $response["error_msg"] = "Team with entered code doesn't exist";
            echo json_encode($response);
        }
        else if($db->playerInTeam($team, $player))
        {
            $response["error"] = 2;
            $response["error_msg"] = "Player already in team";
            echo json_encode($response);
        }
        else
        {
            $team_player = $db->joinTeam($code, $player);
            if($team_player)
            {
                $response["success"] = 1;
                $response["team_id"] = $team_player["team_id"];
                $response["player_id"] = $team_player["player_id"];
                echo json_encode($response);
            }
            else
            {
                $response["error"] = 3;
                $response["error_msg"] = "Error occurred while adding player to team";
                echo json_encode($response);
            }
        }
    }
    else if($tag == 'players_teams')
    {
        $player = $_POST['player'];
        $teams = $db->getPlayersTeams($response, $player);
        echo json_encode($teams);
    }
    else if($tag == 'get_team_players')
    {
        $team = $_POST['team'];
        $players = $db->getTeamPlayers($team, $response);
        echo json_encode($players);
    }
    else if($tag == 'get_team_manager')
    {
        $team = $_POST['team'];
        $manager = $db->getTeamManager($team);
        echo json_encode($manager);
    }
    else if($tag == 'change_team_code')
    {
        $team = $_POST['team'];
        $code = $db->changeTeamCode($team, $response);
        echo json_encode($code);
    }
    else if($tag == 'remove_player')
    {
        $team = $_POST['team'];
        $player = $_POST['player'];
        $removal = $db->removePlayer($team, $player);
        echo json_encode($removal);
    }
    else
    {
        echo "Invalid Request";
    }
}
else
{
    echo "Access Denied";
}

?>