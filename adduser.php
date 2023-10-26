<?php
// เริ่ม session
session_start();

// ข้อมูลการเชื่อมต่อกับ MySQL
require_once './config/server.php';

// รับข้อมูลจากฟอร์ม (สมมุติว่าคุณมีฟอร์มที่ให้ผู้ใช้ป้อนข้อมูลผู้ใช้ใหม่)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUserID = $_POST["new_user_id"];
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newEmail = $_POST["new_email"];
    $newFullname = $_POST["new_fullname"];
    $newUsertype = $_POST["new_usertype_id"];

    // สร้างการเชื่อมต่อกับ MySQL
    $conn = new mysqli($host, $username, $password, $database);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }

    // คำสั่ง SQL เพื่อเพิ่มผู้ใช้ใหม่
    $sql = "INSERT INTO user (user_id, user_name, password, email, fullname, usertype_id) VALUES ('$newUserID', '$newUsername', '$newPassword', '$newEmail', '$newFullname', '$newUsertype')";
    if ($conn->query($sql) === TRUE) {
        // เพิ่มผู้ใช้เรียบร้อยแล้ว
        echo "เพิ่มผู้ใช้เรียบร้อยแล้ว";

        // เริ่ม session สำหรับผู้ใช้ใหม่
        $_SESSION['id'] = $conn->insert_id; // เก็บค่า user_id ใน session
        $_SESSION['username'] = $newUsername; // เก็บชื่อผู้ใช้ใน session
        $_SESSION['email'] = $newEmail; // เก็บอีเมลใน session
        $_SESSION['fullname'] = $newFullname;

        //$newUsertypeString = strval($newUsertype);
        // คำสั่ง SQL เพื่ออัปเดตข้อมูลในตาราง "usertype"
        /*$insertUsertypeSQL = "INSERT INTO usertype (usertype_name, id) VALUES ('$newUsertypeString', " . $_SESSION['id'] . ")";

        if ($conn->query($insertUsertypeSQL) === TRUE) {
            echo "อัปเดต usertype สำเร็จ";
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดต usertype: " . $conn->error;
        }*/
    } else {
        echo "เกิดข้อผิดพลาดในการเพิ่มผู้ใช้: " . $conn->error;
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $conn->close();
}
?>
