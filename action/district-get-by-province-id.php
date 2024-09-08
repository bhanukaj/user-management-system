<?php
//start session
session_start();
 
include_once('../entity/District.php');
 
$district = new District();
 
if(isset($_GET['provinceId']) === true) {
   $provinceId = $district->escapeString($_GET['provinceId']);

   $districts = $district->getAllDistrictsByProvinceId($provinceId);

   echo json_encode($districts);
}
?>