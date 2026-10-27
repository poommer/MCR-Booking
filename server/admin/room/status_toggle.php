<?php
require('../../conn.php');
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['user_ID'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$csrfToken = $_POST['csrf_token'] ?? '';
if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $csrfToken)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$statusRaw = $_POST['status'] ?? null;
$id = trim($_POST['id'] ?? '');

if (($statusRaw !== '0' && $statusRaw !== '1' && $statusRaw !== 0 && $statusRaw !== 1) || $id === '') {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit;
}

$status = (int)$statusRaw;

$roomCheckSql = "SELECT 1 FROM `room` WHERE `room_id` = ? LIMIT 1";
$roomCheckStmt = $conn->prepare($roomCheckSql);
$roomCheckStmt->bind_param('s', $id);
$roomCheckStmt->execute();
$roomExists = $roomCheckStmt->get_result()->num_rows === 1;

if (!$roomExists) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Room not found']);
    exit;
}

$sql = "UPDATE `room` SET `status` = ? WHERE `room_id` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $status, $id);
$result = $stmt->execute();

if (!$result) {
    http_response_code(500);
}

echo json_encode([
    'success' => (bool)$result
]);
?>
