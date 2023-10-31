<?php

    session_start();
    require_once "config/server.php";

    if (isset($_POST['update'])){
        $id = $_POST['id'];
        $heading = $_POST['heading'];
        $news = $_FILES['news']; // เปลี่ยนจาก 'img' เป็น 'news'

        $img2 = $_POST['img2'];
        $upload = $_FILES['news']['name']; // เปลี่ยนจาก 'img' เป็น 'news'

        if ($upload != ''){
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode(".", $news['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = "upload/images/" . $fileNew;

            if (in_array($fileActExt, $allow)){
                if ($news['size'] > 0 && $news['error'] == 0){
                    move_uploaded_file($news['tmp_name'], $filePath);
                }
            }
        } else {
            $fileNew = $img2;
        }

        // สร้างคำสั่ง SQL สำหรับอัปเดตข้อมูล
        $updateSql = "UPDATE news_image SET heading = ?, news = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            // ผูกพารามิเตอร์
            $stmt->bind_param("ssi", $heading, $fileNew, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['success'] = "Data has been updated successfully";
                header("location: addimage.php");
            } else {
                $_SESSION['error'] = "Data has not been updated successfully";
                header("location: addimage.php");
            }

            // ปิดคำสั่ง SQL
            $stmt->close();
        }
    }
?>


    


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PDO and Bootstrap5</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        .container {
            max-width: 550px;
        }
    </style>
</head>
<body> 

    <div class="container mt-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="edit.php" method="post" enctype="multipart/form-data">
            <?php  
                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    $query = "SELECT * FROM news_image WHERE id = $id";
                    $result = mysqli_query($conn, $query);
    
                    if ($result) {
                        $data = mysqli_fetch_assoc($result);
                    }
                }
            ?>
            <div class="mb-3">
                <input type="text" readonly value="<?=$data['id']; ?>" require class="form-control" name="id">
                <label for="heading" class="col-form-label">Heading:</label>
                <input type="text" value="<?=$data['heading']; ?>" require class="form-control" name="heading">
            
            </div>
        
            <div class="mb-3">
                <label for="news" class="col-form-label">Image:</label>
                <input type="file" class="form-control" id="imgInput" name="news">
                <img width="100%" src="upload/images/<?=$data['news']; ?>" id="previewImg" alt="">
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="addimage.php">Go back</a>
                <button type="submit" name="update" class="btn btn-success">Update</button>
            </div>
        </form>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt =>{
            const [file] = imgInput.files;
            if (file){
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>

</body>
</html>