<?php
 
class UserFunctions
{
    private $db;

    function __construct()
    {
        require_once 'connect.php';
        $this->db = new DB_Connect();
        $this->db->connect();
    }
 
    function __destruct()
    {
        //destructor     
    }
 
    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($name, $email, $password)
    {
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];
        $result = mysql_query("INSERT INTO users(name, email, encrypted_password, salt, created_at) VALUES('$name', '$email', '$encrypted_password', '$salt', NOW())");
        if($result)
        {
            $id = mysql_insert_id();
            $result = mysql_query("SELECT * FROM users WHERE id = $id");
            return mysql_fetch_array($result);
        }
        else
        {
            return false;
        }
    }
 
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password)
    {
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows > 0)
        {
            $result = mysql_fetch_array($result);
            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            if($encrypted_password == $hash)
            {
                return $result;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Change a user's password
     */
    public function changePassword($id, $password)
    {
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"];
        $salt = $hash["salt"];
        $result = mysql_query("UPDATE users SET encrypted_password = '$encrypted_password', 
            salt = '$salt' WHERE id = $id");
        if($result)
            return true;
        else
            return false;
    }
 
    /**
     * Check user is existed or not
     */
    public function isUserExisted($email)
    {
        $result = mysql_query("SELECT email from users WHERE email = '$email'");
        $no_of_rows = mysql_num_rows($result);
        if($no_of_rows > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password)
    {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password)
    {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
}
 
?>