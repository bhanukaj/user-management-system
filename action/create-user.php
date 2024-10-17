<?php

session_start();

if (isset($_SESSION['user']) === false || (trim($_SESSION['user']) === '')) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

include_once('../entity/User.php');

$user = new User();

$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$districtId = $_POST['district'] ?? null;
$role = $_POST['role'] ?? null;

if (!$name || !$email || !$districtId || !$role) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit();
}

$success = $user->createUser([
    'name' => $name,
    'role' => $role,
    'email' => $email,
    'district_id' => $districtId,
]);

if ($success) {
    echo json_encode(['status' => 'success', 'message' => 'User added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add user']);
}
