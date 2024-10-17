<?php
class Connection {

    private $host = 'localhost';
    private $username = 'root';
    private $password = '1234';
    private $database = 'ums';

    protected $connection;

    public function __construct() {
        if (!isset($this->connection)) {
            try {
                $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
                // Set error mode to exception for better error handling
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                exit;
            }
        }

        return $this->connection;
    }
}
?>
