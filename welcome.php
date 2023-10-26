<?php
session_start();
ob_start();
echo $_SESSION['user_id'];// ผลลัพธ์คือแสดงข้อความ 
echo "<br/>";
echo $_SESSION['user_name'];
echo $_SESSION['fullname'];
echo $_SESSION['login_datetime'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>ยินดีต้อนรับ</title>
</head>
<body>
    <h2>ยินดีต้อนรับ!</h2>
    <p>คุณเข้าสู่ระบบเรียบร้อยแล้ว</p>
    <a href="logout.php">ออกจากระบบ</a>
</body>
</html>

