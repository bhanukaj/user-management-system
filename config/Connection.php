<?php
class Connection {
 
    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $database = 'ums';
   
    protected $connection;
   
    public function __construct() {
        if (!isset($this->connection)) {
           
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
           
            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }
        }    
       
        return $this->connection;
    }
   
    public function escapeString($value) {
        return $this->connection->real_escape_string($value);
    }
}
?>