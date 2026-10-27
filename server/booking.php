<?php
require('conn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

if (!isset($_SESSION['user_ID'])) {
    header('Location: ../index.php');
    exit;
}

$id = trim($_POST['id'] ?? '');
$title = trim($_POST['title'] ?? '');
$attendee = trim($_POST['attendee'] ?? '');
$date = trim($_POST['date'] ?? '');
$stTime = trim($_POST['stTime'] ?? '');
$endTime = trim($_POST['endTime'] ?? '');
$note = trim($_POST['note'] ?? '');
$userID = (string)$_SESSION['user_ID'];

if ($id === '' || $title === '' || $attendee === '' || $date === '' || $stTime === '' || $endTime === '') {
    $_SESSION['msg_err'] = 'กรุณากรอกข้อมูลให้ครบถ้วน';
    header('Location: ../index.php');
    exit;
}

$dateObject = DateTime::createFromFormat('Y-m-d', $date);
$startTimeObject = DateTime::createFromFormat('H:i', $stTime);
$endTimeObject = DateTime::createFromFormat('H:i', $endTime);

if (!$dateObject || !$startTimeObject || !$endTimeObject || $stTime >= $endTime) {
    $_SESSION['msg_err'] = 'วันหรือเวลาไม่ถูกต้อง';
    header('Location: ../index.php');
    exit;
}

$roomSql = "SELECT `room_id` FROM `room` WHERE `room_id` = ? AND `status` = 1 LIMIT 1";
$roomStmt = $conn->prepare($roomSql);
$roomStmt->bind_param('s', $id);
$roomStmt->execute();
$roomExists = $roomStmt->get_result()->num_rows === 1;

if (!$roomExists) {
    $_SESSION['msg_err'] = 'ห้องไม่พร้อมให้บริการ';
    header('Location: ../index.php');
    exit;
}

$overlapSql = "SELECT 1 FROM `booking`
               WHERE `bk_roomID` = ?
                 AND `bk_date` = ?
                 AND `bk_timeStart` < ?
                 AND `bk_timeEnd` > ?
               LIMIT 1";
$overlapStmt = $conn->prepare($overlapSql);
$overlapStmt->bind_param("ssss", $id, $date, $endTimeObject->format('H:i:s'), $startTimeObject->format('H:i:s'));
$overlapStmt->execute();
$hasOverlap = $overlapStmt->get_result()->num_rows > 0;

if ($hasOverlap) {
    $_SESSION['msg_err'] = 'ช่วงเวลานี้มีผู้จองแล้ว';
    header('Location: ../index.php');
    exit;
}

$booking_ID = $id . $dateObject->format('ymd') . $startTimeObject->format('Hi') . $endTimeObject->format('Hi');

$sql = "INSERT INTO `booking`(`bk_id`, `bk_userID`, `bk_roomID`, `bk_date`, `bk_timeStart`, `bk_timeEnd`, `bk_title`, `bk_attendee`, `bk_note`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$startTime = $startTimeObject->format('H:i:s');
$endTime = $endTimeObject->format('H:i:s');
$stmt->bind_param("sssssssss", $booking_ID, $userID, $id, $date, $startTime, $endTime, $title, $attendee, $note);
$result = $stmt->execute();

if ($result) {
    $_SESSION['msg_success'] = 'จองห้องประชุมแล้ว';
} else {
    $_SESSION['msg_err'] = 'เกิดข้อผิดพลาด กรุณาลองอีกครั้ง';
}

header('Location: ../index.php');
exit;
?>
