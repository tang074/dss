<?php
    session_start();
    require_once "config/server.php";

    if (isset($_POST['update'])){
        //$start_date     = $_POST['start_date'];
        //$end_date       = $_POST['end_date'];
        $id = $_POST['id'];
        $heading        = $_POST['heading'];
        $news           = $_POST['news'];
      

        $updateSql = "UPDATE news_text SET heading = ?, news = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);

        if ($stmt) {
            // ผูกพารามิเตอร์
            $stmt->bind_param("ssi", $heading, $news, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['success'] = "Data has been updated successfully";
                header("location: addtext.php");
            } else {
                $_SESSION['error'] = "Data has not been updated successfully";
                header("location: addtext.php");
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
    <title>Add Text</title>

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
        <form action="edittext.php" method="post" enctype="multipart/form-data">
            <?php  
                if (isset($_GET['id'])){
                    $id = $_GET['id'];
                    $stmt = $conn->query("SELECT * FROM news_text WHERE id = $id");
                    $data = $stmt->fetch_assoc();  // หรือ $data = $stmt->fetch_object(); ตามที่คุณต้องการรับผลลัพธ์
                }                
                
            ?>
            <div class="mb-3">
                    <div class="mb-3">
                    <label for="heading" class="col-form-label">heading:</label>
                    <input type="text" require class="form-control" name="heading">
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                    </div>
            <div class="mb-3">
                    <div class="mb-3">
                    <label for="news" class="col-form-label">Text:</label>
                    <input type="text" require class="form-control" name="news">
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