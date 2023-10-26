<?php
session_start();
require_once './config/server.php'; // เชื่อมฐานข้อมูล
$conn = mysqli_connect($host, $username, $password, $database); // เชื่อมต่อกับ MySQL

// ตรวจสอบว่ามีการส่งค่าฟอร์มมาหรือไม่
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user_name'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user
            WHERE  user_name='" . $username . "'
            AND  password='" . $password . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_name'] = $username; // เก็บชื่อผู้ใช้ใน session
        $_SESSION['fullname'] = $row['fullname'];

        // อัปเดตสถานะการเข้าสู่ระบบ
        $updateStatusSQL = "UPDATE user SET login_status = 1 
                        WHERE user_id = " . $row['user_id'];

        if (mysqli_query($conn, $updateStatusSQL)) {
            // เก็บเวลา login ของ user
            $usersTimezone = 'Asia/Bangkok';
            $userTimezone = new DateTimeZone($usersTimezone);
            $currentDate = new DateTime('now', $userTimezone);
            $currentDateString = $currentDate->format('Y-m-d H:i:s');
            $_SESSION['login_datetime'] = $currentDateString;

            // เพิ่มบันทึกการเข้าสู่ระบบ
            $insertLoginlogSQL = "INSERT INTO loginlog (login_datetime, user_id) 
                            VALUES('" . $currentDateString . "', " . $_SESSION['user_id'] . ")";

            if (mysqli_query($conn, $insertLoginlogSQL)) {
                header("Location: welcome.php");
                exit; // สิ้นสุดการประมวลผลสคริปต์หลังจากการเปลี่ยนเส้นทาง
            } else {
                $error_message = "มีข้อผิดพลาดในการอัปเดตสถานะการเข้าสู่ระบบ: " . mysqli_error($conn);
            }
        }
    } 
    else {
        $error_message = "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>เข้าสู่ระบบ</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>เข้าสู่ระบบ</h2>
    <?php
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post">
        <label for="user_name">ชื่อผู้ใช้งาน:</label>
        <input type="text" id="user_name" name="user_name" required><br><br>

        <label for="password">รหัสผ่าน:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">เข้าสู่ระบบ</button>
    </form>
</body>
</html>
