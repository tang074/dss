<?php
// เริ่ม session
session_start();

// ข้อมูลการเชื่อมต่อกับ MySQL
require_once './config/server.php';

// รับข้อมูลจากฟอร์ม (สมมุติว่าคุณมีฟอร์มที่ให้ผู้ใช้ป้อนข้อมูลผู้ใช้ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUserID = $_POST["new_user_id"];
    $newFullname = $_POST["new_fullname"];
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newEmail = $_POST["new_email"];
    $newUsertype = $_POST["new_usertype_id"];

    // สร้างการเชื่อมต่อกับ MySQL
    $conn = new mysqli($host, $username, $password, $database);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }

    // คำสั่ง SQL เพื่อเพิ่มผู้ใช้ใหม่
    $sql = "INSERT INTO user (user_id, fullname, user_name, password, email, usertype_id) VALUES ('$newUserID', '$newFullname', '$newUsername', '$newPassword', '$newEmail', '$newUsertype')";
    if ($conn->query($sql) === TRUE) {
        // เพิ่มผู้ใช้เรียบร้อยแล้ว
        echo "เพิ่มผู้ใช้เรียบร้อยแล้ว";
       // header("Location: addminpage.php");
        exit;

        // เริ่ม session สำหรับผู้ใช้ใหม่
        $_SESSION['id'] = $conn->insert_id; // เก็บค่า user_id ใน session
        $_SESSION['fullname'] = $newFullname; // เก็บชื่อ-สกุลใน session
        $_SESSION['username'] = $newUsername; // เก็บชื่อผู้ใช้ใน session
        $_SESSION['email'] = $newEmail; // เก็บอีเมลใน session
        $_SESSION['usertype_id'] = $newUsertype; // เก็บประเภทผู้ใช้ใน session
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มผู้ใช้: " . $conn->error;
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>เพิ่มผู้ใช้ใหม่</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>เพิ่มผู้ใช้ใหม่</h2>
    <form method="POST" action="">
        <label for="new_user_id">User_id :</label>
        <input type="text" name="new_user_id" id="new_user_id" required pattern="\d{13}" title="กรุณากรอก User_id 13 หลัก"><br><br>
        
        <label for="new_fullname">ชื่อ-สกุล:</label>
        <input type="text" name="new_fullname" id="new_fullname" required><br><br>
        
        <label for="new_username">ชื่อผู้ใช้:</label>
        <input type="text" name="new_username" id="new_username" required><br><br>

        <label for="new_password">รหัสผ่าน:</label>
        <input type="password" name="new_password" id="new_password" required><br><br>

        <label for="new_email">อีเมล:</label>
        <input type="email" name="new_email" id="new_email" required><br><br>

        <label for="new_usertype_id">เลือกตำแหน่งงาน:</label>
        <select id="new_usertype_id" name="new_usertype_id">
            <option value="" disabled selected>เลือกตำแหน่งงาน</option>
            <option value="1">ผู้ดูแลระบบ</option>
            <option value="2">หัวหน้าผู้ปฏิบัติการ</option>
            <option value="3">ผู้ปฏิบัติการ</option>
        </select>

        <input type="submit" value="เพิ่มผู้ใช้">
    </form>
</body>
</html>
