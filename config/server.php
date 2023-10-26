<?php 

    $host = "localhost"; // โฮสต์ฐานข้อมูล
    $username = "root"; // ชื่อผู้ใช้ MySQL
    $password = ""; // รหัสผ่าน MySQL
    $database = "dss"; // ชื่อฐานข้อมูล

    //Create Connection
    $conn = mysqli_connect($host, $username, $password, $database);

    //Check connention
    if (!$conn){
        die("Connection failed" . mysqli_connect_error());
    }

?>