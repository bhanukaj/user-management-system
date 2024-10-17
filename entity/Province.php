<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class Province extends Connection {
    public function __construct() {
        parent::__construct();
    }
       
    public function getAllProvinces() {
        $sql = "SELECT * FROM provinces";
        
        // Prepare and execute the query
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        
        // Fetch all the results as an associative array
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $row;
    }
}