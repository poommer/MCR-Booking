<?php
require('../server/conn.php');
session_start();

if (!isset($_SESSION['user_ID'])) {
    header('Location: ../index.php');
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    http_response_code(403);
    exit('Forbidden');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../static/logo.png" type="image/x-icon">
     <link rel="stylesheet" href="../style.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../script.js"></script>
    <?php
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    ?>
    <meta name="csrf-token" content="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="head-logo" style="width:100%; border-bottom-right-radius:0 ;">
            <img src="../static/logo.png" alt="" style="width:5rem;">
            <div class="head-text">
                <h2>MCR booking</h2>
                <small>for admin</small>
            </div>
        </div>

        <main>

<?php
    if (isset($_SESSION['msg_err'])) {
echo '
<h3 style="    background: #ffe6e6;color: #b90000;padding: .5rem; border-radius: .5rem;border: solid 1px;display:flex; align-items:center;">
               <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#b90000">
                    <path d="m40-120 440-760 440 760H40Zm138-80h604L480-720 178-200Zm302-40q17 0 28.5-11.5T520-280q0-17-11.5-28.5T480-320q-17 0-28.5 11.5T440-280q0 17 11.5 28.5T480-240Zm-40-120h80v-200h-80v200Zm40-100Z"/>
                </svg> 
                "'.htmlspecialchars((string)$_SESSION["msg_err"], ENT_QUOTES, "UTF-8").'"
                </h3>
                ';
                unset($_SESSION['msg_err']);
    }else if(isset($_SESSION['msg_success'])){
        echo '
        <h3 style="    background: #e9ffe6;color: #0ab900;padding: .5rem; border-radius: .5rem;border: solid 1px;display:flex; align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#0ab900"><path d="M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q133 0 226.5-93.5T800-480q0-18-2-36t-6-35l65-65q11 32 17 66t6 70q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm-56-216L254-466l56-56 114 114 400-401 56 56-456 457Z"/></svg>
                
                '.htmlspecialchars((string)$_SESSION["msg_success"], ENT_QUOTES, "UTF-8").'
            </h3>

';
unset($_SESSION['msg_success']);
    }

    
    ?>
            


            <div class="header-compo">
                <h1>ห้องประชุม</h1>
                <a href="?stt=create" class="btn">เพิ่ม</a>
            </div>
            <hr>

            <div class="show-room">

            <?php

            $sql = 'SELECT * FROM room';
            $result = $conn->query($sql);
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            // print_r($rows);
            function e($value) {
                return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
            }
            foreach($rows as $row) {
                $roomId = (string)$row['room_id'];
                $roomType = (string)$row['room_type'];
                $roomName = (string)$row['room_name'];
                $roomDetail = (string)$row['room_detail'];
                $roomSeats = (string)$row['room_seats'];
                $roomOpeningTime = (string)$row['room_OpeningTime'];
                $statusActive = (int)$row['status'] === 1;
            ?>

                <div class="card-room">
                    <div class="card-room-head"> 
                        
                        <img src="<?php echo '../static/room/' . rawurlencode($roomType) . '/' . rawurlencode($roomId) . '.webp'; ?>"  alt="" style="height: 10rem; object-fit: cover; ">
                        
                    </div>

                    <div class="card-body">
                        <div style="width:100%; display:flex; justify-content:end; align-items:center; ">

                            <div class="<?php echo $statusActive ? 'status-room-active' : 'status-room'; ?>" id="<?php echo 'statusArea' . e($roomId); ?>">
                                <label for="<?php echo e($roomId); ?>">
                                    <div id="btn_status"></div>
                                    <input type="checkbox" id="<?php echo e($roomId); ?>" name="status_room" <?php echo $statusActive ? 'checked' : ''; ?> onchange="status_show(this, '<?php echo e($roomId); ?>')">
                                </label>
                            </div>
                        </div>
                            
                            <div class="title-room">
                            <a href="#"><h2><?php echo e($roomName); ?></h2></a>
                           
                        </div>

                        <div class="content-room">
                            <p style="display:flex; align-items:center; gap:0.25rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2854C5"><path d="M200-120q-17 0-28.5-11.5T160-160v-40q-50 0-85-35t-35-85v-200q0-50 35-85t85-35v-80q0-50 35-85t85-35h400q50 0 85 35t35 85v80q50 0 85 35t35 85v200q0 50-35 85t-85 35v40q0 17-11.5 28.5T760-120q-17 0-28.5-11.5T720-160v-40H240v40q0 17-11.5 28.5T200-120Zm-40-160h640q17 0 28.5-11.5T840-320v-200q0-17-11.5-28.5T800-560q-17 0-28.5 11.5T760-520v160H200v-160q0-17-11.5-28.5T160-560q-17 0-28.5 11.5T120-520v200q0 17 11.5 28.5T160-280Zm120-160h400v-80q0-27 11-49t29-39v-112q0-17-11.5-28.5T680-760H280q-17 0-28.5 11.5T240-720v112q18 17 29 39t11 49v80Zm200 0Zm0 160Zm0-80Z"/></svg>
                            <?php echo e($roomSeats); ?>
                            
                            <span style="display:flex; align-items:center; gap:0.25rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#2854C5"><path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z"/></svg>
                                <?php echo e($roomOpeningTime); ?>
                            </span>
                        </p>
                        <p>
                                <?php echo e($roomDetail); ?>
                                
                            </p>
                        </div>

                        <div class="footer-content">
                            <a href="#">edit</a>
                            <a href="<?php echo  '../server/admin/room/deleteRoom.php?id=' . urlencode($roomId); ?>">delete</a>
                        </div>
                    </div>
                </div>
      
<?php } ?>
            </div>

        
        </main>

      <?php
      if(isset($_GET['stt'])) {
        if($_GET['stt'] == 'create'){
            require('modal/createRoom.php');
        }else if( $_GET['stt'] == 'edit'){
            require('modal/editRoom.php');

        }
    }
      
      ?>
    
        <nav>
            <ul>
                <li><a href="room.php">room</a></li>
                <li><a href="user.php">user</a></li>
                <li><a href="booking.php">booking</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>