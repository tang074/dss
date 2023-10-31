<?php
    session_start();
    require_once "config/server.php";
    

    if (isset($_POST['submit'])){
        $upload_date = $_POST['upload_date'];
        $start_date  = $_POST['start_date'];
        $end_date  = $_POST['end_date'];
        $heading  = $_POST['heading'];
        $img       = $_FILES['img'];
    }

    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode(".", $img['name']);
    $fileActExt = strtolower(end($extension));
    $fileNew = rand() . "." . $fileActExt;
    $filePath = "upload/images/" . $fileNew;


    if(in_array($fileActExt, $allow)){
        if($img['size']>0 && $img['error']==0){
            
            if(move_uploaded_file($img['tmp_name'], $filePath)){
            $sql = "INSERT INTO news_image (upload_date, start_date, end_date, heading, news) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $upload_date, $start_date, $end_date, $heading, $fileNew);
            $stmt->execute();

                if($sql){
                    $_SESSION['success']="Data has been inserted successfully";
                    header("location: addimage.php");
                }else{
                    $_SESSION['error']="Data has not been inserted successfully";
                    header("location: addimage.php");
                }
            }
        }
    }
?>