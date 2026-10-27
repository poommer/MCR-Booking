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
    <title>รายละเอียดห้อง</title>
</head>
<body>
    <div class="container">
        <div class="head-room_detail">
            <a href="../index.php" class="btn-back">
                <img src="https://cdn-icons-png.flaticon.com/128/507/507257.png" alt="" width="30px">
                <p>BACK</p>
            </a>
            <?php
                require('../server/conn.php');
                session_start();
                $id = $_GET['id'];

                $sql = "SELECT * FROM `room` WHERE  `room_id`= ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);

                $result = $stmt->execute();

                $result = $stmt->get_result();

                $row = $result->fetch_assoc();
                // print_r($row)
            ?>
            <h3 style=margin-top:10px><?php echo $row['room_name'] ?></h3>
        </div>
        <div class="room-detail-page">
            <div class="title-room_detail">
                <img src=<?php echo'../static/room/'.$row['room_type'].'/'.$row['room_id'].'.webp'; ?> alt="" width="100%" height="250px" style="object-fit:cover;">
                <h1 style=margin-left:10px;color:#722BC5;><?php echo $row['room_name'] ?></h1>
            </div>
            <div class="room_detail-middle">
                <div class="room_detail-people">
                    <p style="font-size:12px">จำนวนที่นั่ง</p>
                    <img src="../static/user.png" alt="user" width="60px" class="middle">
                    <h3 style="text-align:center;color:#872BF0"><?php echo $row['room_seats'] ?> ที่นั่ง</h3>
                </div>
                <div class="room_detail-people">
                    <p style="font-size:12px">ขนาดพื้นที่</p>
                    <img src="../static/space.png" alt="space" width="60px" class="middle">
                    <h3 style="text-align:center;color:#872BF0"><?php echo $row['room_areaSize'] ?> ตร.ม.</h3>
                </div>
            </div>
            <div class="room_detail-detail">
                <h4 style="background-color:#722BC5;">รายละเอียด</h4>
                <div class="detail">
                    <img src="../static/clock.png" alt="time" width="25px">
                    <h4><?php echo $row['room_OpeningTime'] ?> น.</h4>
                </div>
                <div class="detail">
                    <img src="../static/map.png" alt="map" width="25px">
                    <h4 style="margin:0;"><?php echo $row['room_location'] ?></h4>
                </div>
                <div class="detail">
                    <img src="../static/flag.png" alt="flag" style="max-width: 25px; max-height : 25px;">
                    <h4><?php echo $row['room_detail'] ?></h4>
                </div>
            </div>
            
            <div class="room_detail-detail">
                <h4 style="background-color:#722BC5;">สิ่งอำนวยความสะดวก</h4>
                <?php
                $sql_fac = "SELECT `fac_name` FROM `room` INNER JOIN `facilitate` ON `room_id` = `fac_roomID` AND `room_id` = ?;";
                $stmt_fac = $conn->prepare($sql_fac);
                $stmt_fac->bind_param("s", $id);

                $result_fac = $stmt_fac->execute();

                $result_fac = $stmt_fac->get_result();

                $row_fac = $result_fac->fetch_all(MYSQLI_ASSOC);
                // print_r($row_fac);
                foreach( $row_fac as $row_f ){
            ?>
                    <div class="elec">
                        <img src="../static/correct.png" alt="corrext" width="25px">
                        <h4><?php echo  $row_f['fac_name'] ?></h4>
                    </div>
                    <?php } ?>
            </div>
           
            <div class="room_detail-detail">
                <h4 style="background-color:#722BC5;">ติดต่อสอบถาม</h4>
                <div class="room_detail-contact">
                        <h4>Email:</h4>
                        <p>roombooking@mcr.booking</p>
                    </div>
                    <div class="room_detail-contact">
                        <h4>Line:</h4>
                        <p>@mcr.booking</p>
                    </div>
                    <div class="room_detail-contact">
                        <h4>เบอร์โทร:</h4>
                        <p>02 200 100</p>
                    </div>
            </div>
            
           

                
                </div>


        <div class="room_detail-under-btn">
            <a href="../index.php" class="room_detail-btn">กลับหน้าหลัก</a>
            <a href="<?php echo 'booking.php?id='.$row['room_id']; ?>" class="room_detail-btn-confirm">จองห้องนี้</a>
        </div>
        </div>
        
    </div>
</body>
</html>