<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class User extends Connection {

    public function __construct() {
        parent::__construct();
    }
   
    public function checkLogin($email, $password) {
        $sql = "SELECT * FROM users WHERE email = :email";
        
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if the user exists and verify the password
        if ($user && md5($password) === $user['password']) {
            // If the password is correct, return the user's ID
            return $user['id'];
        } else {
            // If login fails, return false
            return false;
        }
    }
    
       
    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        
        // Prepare and execute the query
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        
        // Fetch all the results as an associative array
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $row;
    }
    
    
    public function addUser($data) {
        $sql = "INSERT INTO users (name, role, email, district_id) 
                VALUES (:name, :role, :email, :district_id)";
    
        // Prepare the SQL statement
        $stmt = $this->connection->prepare($sql);
    
        // Execute the statement with the provided data (correct array syntax)
        $result = $stmt->execute(array(
            ':name'        => $data['name'],
            ':role'        => $data['role'],
            ':email'       => $data['email'],
            ':district_id' => $data['district_id'],
        ));
    
        // Return true if execution is successful, false otherwise
        return $result;
    }      
}