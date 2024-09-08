<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class Province extends Connection {
    public function __construct() {
        parent::__construct();
    }
       
    public function getAllProvinces() {
        $sql = "SELECT * FROM provinces";
        $query = $this->connection->query($sql);
       
        $row = $query->fetch_all(MYSQLI_ASSOC);
           
        return $row;      
    }
}