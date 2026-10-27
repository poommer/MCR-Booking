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
    <title>จองห้อง</title>
</head>
<body>
    <div class="container background-booking">
    <a href="../index.php" class="btn-back" style="background-color:#8030F5; box-shadow: -3px 3px 0 5px #CAB3FF; color:#fff;">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF"><path d="m313-440 224 224-57 56-320-320 320-320 57 56-224 224h487v80H313Z"/></svg>
                BACK
</a>

        <div class="booking-container">
            <h1>จองห้อง</h1>
            <form action="../server/booking.php" method="post" class="booking-form">
                <?php 
                require('../server/conn.php');
                session_start();
                $id = $_GET['id'];

                $sql = "SELECT `room_name` FROM `room` WHERE  `room_id`= ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $id);

                $result = $stmt->execute();

                $result = $stmt->get_result();

                $row = $result->fetch_assoc();

                ?>

            <div class="booking-row">
                    <div class="group-inp" style="width:100%;">
                        <label for="room_name">ห้องประชุม</label>
                        <input type="text" name="room_name" id="room_name" style="width:100%;" class="read-only" value="<?php echo $row['room_name'] ?>" readonly>
                        <input type="hidden" name="id" id="id" style="width:100%;" value="<?php echo $id ?>" readonly>
                    </div>


            </div>
            <?php ?>

            <div class="booking-row">
                    <div class="group-inp" style="width:50%;">
                        <label for="name">ชื่อ - นามสกุลผู้จอง</label>
                        <input type="text" name="name" id="name" style="width:100%;" class="read-only" value="<?php echo $_SESSION['user_name'] ?>" readonly>
                    </div>
                    <div class="group-inp" style="width:50%;">
                        <label for="dep">แผนก</label>
                        <input type="text" name="dep" id="dep" style="width:100%;" class="read-only" value="<?php echo $_SESSION['user_dep'] ?>" readonly>
                    </div>


            </div>

            

            <hr class="booking-divider">
            <div class="booking-row">
                    <div class="group-inp" style="width:65%;">
                        <label for="title">หัวข้อการประชุม/กิจกรรม</label>
                        <input type="text" name="title" id="title" style="width:100%;">
                    </div>
                    <div class="group-inp" style="width:35%;">
                        <label for="attendee">จำนวนผู้เข้าร่วม</label>
                        <input type="text" name="attendee" id="attendee" style="width:100%;">
                    </div>


            </div>
            <div class="booking-row">
                    <div class="group-inp" style="width:33.33%;">
                        <label for="date">วันที่</label>
                        <input type="date" name="date" id="date" style="width:100%;">
                    </div>
                    <div class="group-inp" style="width:33.33%;">
                        <label for="stTime">เวลาเริ่ม</label>
                        <input type="time" name="stTime" id="stTime" style="width:100%;">
                    </div>
                    <div class="group-inp" style="width:33.33%;">
                        <label for="endTime">เวลาสิ้นสุด</label>
                        <input type="time" name="endTime" id="endTime" style="width:100%;">
                    </div>


            </div>

            <div class="booking-row">
                    <div class="group-inp" style="width:100%; height:10rem;">
                        <label for="note">บันทึกเพิ่มเติม</label>
                        <textarea  name="note" id="note" style="resize: none;height:10rem;"></textarea>
                    </div>


            </div>
            <div class="booking-actions">
                <a href="../index.php" class="btn-light">ยกเลิก</a>
                <button type="submit" class="btn">เพิ่ม</button>
            </div>

            </form>
        </div>

        <div style="width: 100%; display:flex; align-items:center; justify-content:center; margin-top:2rem;">
            <img src="../static/img1.png" alt="">
        </div>
    </div>
</body>
</html>