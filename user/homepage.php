<?php
require('server/conn.php');
// session_start();
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/logo.png" type="image/x-icon">
     <link rel="stylesheet" type="text/css" href="../style.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
    <title>homepage</title>
</head>
<body>
    <div class="container">
        <div class="head-homepage"> 
            <div class="homepage-logo">
                <img src="static/logo.png" alt="logo" width="60px" height="60px">
            </div>
            <div class="homepage-text">
                <h2>MCR BOOKING</h2>
                <p>เอ็มซีอาร์ บุ๊กกิ้ง</p>
            </div>
            <a href="server/logout.php" class="btn-logout">Logout</a>
            <!-- <div class="head-booking">
                <img src="../static/calendar.png" alt="" width="25px" height="25px">
                <a href>การจองของฉัน</a href>
            </div> -->
        </div>
        <?php
    if (isset($_SESSION['msg_err'])) {
echo '
<h3 class="alert-banner error">
               <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#b90000">
                    <path d="m40-120 440-760 440 760H40Zm138-80h604L480-720 178-200Zm302-40q17 0 28.5-11.5T520-280q0-17-11.5-28.5T480-320q-17 0-28.5 11.5T440-280q0 17 11.5 28.5T480-240Zm-40-120h80v-200h-80v200Zm40-100Z"/>
                </svg> 
                "'.e($_SESSION["msg_err"]).'"
                </h3>
                ';
                unset($_SESSION['msg_err']);
    }else if(isset($_SESSION['msg_success'])){
        echo '
        <h3 class="alert-banner success">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0ab900"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-18-2-36t-6-35l65-65q11 32 17 66t6 70q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-56-216L254-466l56-56 114 114 400-401 56 56-456 457Z"/></svg>
                
                '.e($_SESSION["msg_success"]).'
            </h3>

';
unset($_SESSION['msg_success']);
    }

    
    ?>
    
        <div class="homepage-main">
        <div class="homepage-section-head">
            <h2>BOOKING</h2>
        </div>
        <div class="homepage-booking">
        <?php

$sql = 'SELECT * FROM room WHERE status = 1';
$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
// print_r($rows);
foreach($rows as $row) {
    $roomId = (string)$row['room_id'];
    $roomType = (string)$row['room_type'];
?>
            <div class="homepage-room">
            <img src="<?php echo 'static/room/' . rawurlencode($roomType) . '/' . rawurlencode($roomId) . '.webp'; ?>"  alt="" style=" max-width:100%; height: 22rem; object-fit: cover;">
                <div class="homepage-room-content">
                    <div>
                        <a href="<?php echo 'user/room_detail.php?id=' . urlencode($roomId); ?>" class="homepage-room-title"><?php echo e($row['room_name']); ?></a>
                        <p class="homepage-room-meta">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2854C5"><path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z"/></svg>
                            <?php echo e($row['room_seats']); ?>
                            
                            <span style="display:flex; align-items:center; gap:0.25rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2854C5"><path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z"/></svg>
                                <?php echo e($row['room_OpeningTime']); ?>
                            </span>
                        </p>
                    </div>
                 
                    <div style="width:100%; display:flex; justify-content:end;">
                        <?php echo "<a href='user/booking.php?id=" . urlencode($roomId) . "'><img src='static/plus.png' alt='plus' class='plus'></a>"; ?>
                    </div>
                </div>
            </div>
            
      <?php } ?> 
        </div>
        </div>
    </div>
</body>
</html>