<?php

if(isset($_POST['tag']) && $_POST['tag'] != '')
{
    $tag = $_POST['tag'];

    require_once 'user_functions.php';
    $db = new UserFunctions();
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
 
    if($tag == 'login')
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        $user = $db->getUserByEmailAndPassword($email, $password);
        if($user != false)
        {
            $response["success"] = 1;
            $response["id"] = $user["id"];
            $response["user"]["name"] = $user["name"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["created_at"] = $user["created_at"];
            $response["user"]["updated_at"] = $user["updated_at"];
            echo json_encode($response);
        }
        else
        {
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    }
    else if($tag == 'register')
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        if($db->isUserExisted($email))
        {
            $response["error"] = 2;
            $response["error_msg"] = "User already existed";
            echo json_encode($response);
        }
        else
        {
            $user = $db->storeUser($name, $email, $password);
            if($user)
            {
                $response["success"] = 1;
                $response["id"] = $user["id"];
                $response["user"]["name"] = $user["name"];
                $response["user"]["email"] = $user["email"];
                $response["user"]["created_at"] = $user["created_at"];
                $response["user"]["updated_at"] = $user["updated_at"];
                echo json_encode($response);
            }
            else
            {
                $response["error"] = 1;
                $response["error_msg"] = "Error occurred in registration";
                echo json_encode($response);
            }
        }
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