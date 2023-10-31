<?php
    session_start();
    require_once "config/server.php";
    

    if (isset($_POST['submit'])){
        $heading  = $_POST['heading'];
        $news  = $_POST['news'];
    } else {
        // ใส่โค้ดที่จะทำเมื่อไม่มีการส่งข้อมูลผ่านแบบฟอร์ม
    }
    
    $usersTimezone = 'Asia/Bangkok';
            $userTimezone = new DateTimeZone($usersTimezone);
            $currentDate = new DateTime('now', $userTimezone);
            $currentDateString = $currentDate->format('Y-m-d H:i:s');
            $_SESSION['upload_date'] = $currentDateString;


    $sql = "INSERT INTO news_text (upload_date, heading, news) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $_SESSION['upload_date'], $heading, $news);
    if ($stmt->execute()){
        $_SESSION['success']="Data has been inserted successfully";
        header("location: addtext.php");
    } else {
        $_SESSION['error']="Data has not been inserted successfully";
        header("location: addtext.php");
    }
    
            
?>