<?php

session_start();

if (isset($_SESSION['user']) === false || (trim($_SESSION['user']) === '')) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

include_once('../entity/User.php');

$user = new User();

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit();
}

$data = $user->getUser($id);

if ($data) {
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to get user']);
}
