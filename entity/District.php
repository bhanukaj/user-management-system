<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class District extends Connection {
    public function __construct() {
        parent::__construct();
    }
       
    public function getAllDistrictsByProvinceId($provinceId) {
        $sql = "SELECT * FROM districts WHERE province_id = '$provinceId'";
        $query = $this->connection->query($sql);
       
        $row = $query->fetch_all(MYSQLI_ASSOC);
           
        return $row;
    }
}