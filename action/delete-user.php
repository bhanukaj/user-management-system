<?php
// Start the session
session_start();

// Check if the user is logged in and authorized
if (isset($_SESSION['user']) === false || (trim($_SESSION['user']) === '')) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

// Include the User class
include_once('../entity/User.php');

$user = new User();

// Get the user ID from the request
$id = $_POST['id'] ?? null;

// Check if the ID is valid
if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit();
}

// Attempt to delete the user
$success = $user->deleteUser($id);

if ($success) {
    echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
}
