<?php
//start session
session_start();
 
include_once('../entity/User.php');
 
$user = new User();
 
if(isset($_POST['email']) === true && isset($_POST['password']) === true) {
   $auth = $user->checkLogin($_POST['email'], $_POST['password']);

   if($auth === false) {
      $_SESSION['message'] = 'Invalid username or password';
      header('location:../index.php');
   } else {
      $_SESSION['user'] = $auth;
      header('location:../pages/admin/dashboard.php');
   }
} else {
   $_SESSION['message'] = 'You need to login first';
   header('location:../index.php');
}
?>