<?php
/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data
 
  /**
 * check for POST request 
 */
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];
 
    // include db handler
    require_once 'user_functions.php';
    require_once 'team_functions.php';
    $db = new UserFunctions();
    $db2 = new TeamFunctions();
 
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        // check for user
        $user = $db->getUserByEmailAndPassword($email, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["uid"] = $user["unique_id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    } else if ($tag == 'register') {
        // Request type is Register new user
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        // check if user is already existed
        if ($db->isUserExisted($email)) {
            // user is already existed - error response
            $response["error"] = 2;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
        } else {
            // store user
            $user = $db->storeUser($name, $email, $password);
            if ($user) {
                // user stored successfully
                $response["success"] = 1;
                $response["uid"] = $user["unique_id"];
                $response["user"]["name"] = $user["name"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["created_at"] = $user["created_at"];
                $response["user"]["updated_at"] = $user["updated_at"];
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "Error occured in Registartion";
                echo json_encode($response);
            }
        }
    } else if ($tag == 'add_team') {
        $name = $_POST['name'];
        $created_by = $_POST['created_by'];
        
        // check team doesnt already exist
        if ($db2->teamNameExists($name)) {
            // team name is already taken - error response
            $response["error"] = 1;
            $response["error_msg"] = "Team name already taken";
            echo json_encode($response);
        } else {
            $team = $db2->storeTeam($name, $created_by);
            if ($team) {
                // team stored successfully
                $response["success"] = 1;
                $response["id"] = $team["id"];
                $response["team"]["name"] = $team["name"];
                $response["team"]["code"] = $team["code"];
                $response["team"]["creator"] = $team["created_by"];
                $response["team"]["created_at"] = $team["created_at"];
                echo json_encode($response);
            } else {
                // failure in storing team
                $response["error"] = 2;
                $response["error_msg"] = "Error occurred while adding team";
                echo json_encode($response);
            }
        }
    }
    else {
        echo "Invalid Request";
    }
} else {
    echo "Access Denied";
}
?>