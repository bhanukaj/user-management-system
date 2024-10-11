<?php
include_once(sprintf('%s/config/Connection.php', dirname(__DIR__)));
 
class District extends Connection {
    public function __construct() {
        parent::__construct();
    }
       
    public function getAllDistrictsByProvinceId($provinceId) {
        $sql = "SELECT * FROM districts WHERE province_id = :provinceId";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':provinceId', $provinceId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }    
}