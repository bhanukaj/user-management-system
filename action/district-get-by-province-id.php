<?php
//start session
session_start();
 
include_once('../entity/District.php');
 
$district = new District();
 
if(isset($_GET['provinceId']) === true) {
   $districts = $district->getAllDistrictsByProvinceId($_GET['provinceId']);

   echo json_encode($districts);
}
?>