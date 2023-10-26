<?php
session_start(); // ประกาศใช้ session
require_once './config/server.php'; // เชื่อมต่อกับฐานข้อมูล
//header('Location: login.php'); // Logout เรียบร้อยและกระโดดไปหน้าตามที่ต้องการ
echo $_SESSION['login_datetime'];

// ตรวจสอบว่ามีค่า session 'id' หรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $login_datetime=$_SESSION['login_datetime'];
    
    // เก็บเวลาเมื่อผู้ใช้ออกจากรระบบ
    $usersTimezone = 'Asia/Bangkok';
    $userTimezone = new DateTimeZone($usersTimezone);
    $currentDate = new DateTime('now', $userTimezone);
    $currentDateString = $currentDate->format('Y-m-d H:i:s'); // แปลง DateTime ให้อยู่ในรูปแบบของสตริง
    
    $updateStatusSQL = "UPDATE user SET login_status = 0 WHERE user_id = $user_id";  // คำสั่ง SQL สำหรับอัปเดตสถานะการเข้าสู่ระบบ
    // ทำการอัปเดตสถานะการเข้าสู่ระบบ
    $result1 = mysqli_query($conn, $updateStatusSQL);
        if ($result1) {
            echo "อัปเดตสถานะการเข้าสู่ระบบสำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตสถานะการเข้าสู่ระบบ: " . mysqli_error($conn);
        }

    $updateLoginlogSQL = "UPDATE loginlog  SET logout_datetime = '" . $currentDateString . "' 
                        WHERE login_datetime = '" . $_SESSION['login_datetime'] . "'
                        AND user_id = " . $_SESSION['user_id']; // คำสั่ง SQL สำหรับบันทึกเวลาออกจากระบบ
    // ทำการอัปเดต logout_datetime
    $result2 = mysqli_query($conn, $updateLoginlogSQL);   
        if ($result2) {
            echo "อัปเดต logout_datetime สำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดต logout_datetime: " . mysqli_error($conn);
        }


    if (!$conn) {
        die("การเชื่อมต่อกับฐานข้อมูลล้มเหลว: " . mysqli_connect_error());}
    

    session_destroy();
    
    // ปิดการเชื่อมต่อกับฐานข้อมูล
    mysqli_close($conn);
    

    
} else {
    // หากไม่มีค่า session 'id' ในระบบ ให้ Redirect ไปหน้า login.php โดยไม่ต้องอัปเดตสถานะ
    header('Location: login.php');
    exit;
}
?>
