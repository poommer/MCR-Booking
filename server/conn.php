<?php
try {
  $dbHost = getenv('DB_HOST') ?: 'localhost';
  $dbUser = getenv('DB_USER') ?: 'root';
  $dbPass = getenv('DB_PASS');
  if ($dbPass === false) {
    $dbPass = '';
  }
  $dbName = getenv('DB_NAME') ?: 'mcr_booking';

  $conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
  if (!$conn) {
    throw new mysqli_sql_exception('Database connection failed');
  }

  $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
  http_response_code(500);
  die('Database connection error');
}
?>