<?php
// เริ่ม session
session_start();

// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// แสดงข้อมูลผู้ใช้
echo "ยินดีต้อนรับเข้าสู่หน้าแอดมิน, " . $_SESSION['username'];
echo "<br>รหัสผู้ใช้: " . $_SESSION['id'];
?>
