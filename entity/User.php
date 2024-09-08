<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class User extends Connection {
    public function __construct() {
        parent::__construct();
    }
   
    public function checkLogin($email, $password) {
        $password = md5($password);

        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $query = $this->connection->query($sql);
 
        if($query->num_rows > 0) {
            $row = $query->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }
       
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $query = $this->connection->query($sql);
       
        $row = $query->fetch_all(MYSQLI_ASSOC);
           
        return $row;      
    }
}