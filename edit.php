<?php
    session_start();
    require_once "config/server.php";

    if (isset($_POST['update'])){
        $upload_date    = $_POST['upload_date'];
        $start_date     = $_POST['start_date'];
        $end_date       = $_POST['end_date'];
        $heading        = $_POST['heading'];
        $news           = $_FILES['img'];

        $img2   = $_POST['img2'];
        $upload = $_FILES['img']['name'];

        if ($upload != ''){
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode(".", $img['name']);
            $fileActExt = strtolower(end($extension));
            $fileNew = rand() . "." . $fileActExt;
            $filePath = "upload/" . $fileNew;

            if(in_array($fileActExt, $allow)){
                if($img['size']>0 && $img['error']==0){
                    move_uploaded_file($img['tmp_name'], $filePath);
                }
            }
        }else{
            $fileNew = $img2;
        }

        $sql = "INSERT INTO news_image (upload_date, start_date, end_date, heading, news) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $upload_date, $start_date, $end_date, $heading, $fileNew);
        $stmt->execute();



        if($sql){
            $_SESSION['success']="Data has been updated successfully";
            header("location: upload.php");
        }else{
            $_SESSION['error']="Data has not been updated successfully";
            header("location: upload.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Image</title>

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
                    $stmt = $conn->query("SELECT * FROM news_image WHERE id = $id");
                    $data = $stmt->fetch_assoc();  // หรือ $data = $stmt->fetch_object(); ตามที่คุณต้องการรับผลลัพธ์
                }                
                
            ?>
            <div class="mb-3">
                    <div class="mb-3">
                    <label for="heading" class="col-form-label">heading:</label>
                    <input type="text" require class="form-control" name="heading">
                    </div>
            <div class="mb-3">
                <label for="img" class="col-form-label">Image:</label>
                <input type="file" class="form-control" id="imgInput" name="img">
                <img width="100%" src="upload/<?=$data['img']; ?>" id="previewImg" alt="">
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="index.php">Go back</a>
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