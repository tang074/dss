
<?php
    session_start();
    require_once "config/server.php";
    //ลบ
    if (isset($_GET['delete'])){ 
        $delete_id = $_GET['delete'];
        $deletestmt = $conn->query("DELETE FROM news_image WHERE id = $delete_id");
       

        if ($deletestmt){
            echo "<script>alert('Data has been deleted successfully');</script>";
            $_SESSION['success']="Data has been deleted successfully";
            header("refresh:1; url=upload.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD Image</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>
<body>
    
    
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Image</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="insert.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="heading" class="col-form-label">heading:</label>
                        <input type="text" require class="form-control" name="heading">
                    </div>
                    <div class="mb-3">
                        <label for="img" class="col-form-label">Image:</label>
                        <input type="file" require class="form-control" id="imgInput" name="img">
                        <img width="100%" id="previewImg" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
            
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Add Image</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">Add Image</button>
            </div>
        </div>
        <hr>
        <?php if (isset($_SESSION['success'])){ ?>
            <div class="alert alert-success">
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger">
                <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php } ?>
        
        <!-- User Data -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">upload_date</th>
                    <th scope="col">start_date</th>
                    <th scope="col">end_date</th>
                    <th scope="col">heading</th>
                    <th scope="col">news</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT * FROM news_image");
                $stmt->execute();
                $result = $stmt->get_result(); // ดึงผลลัพธ์เป็นรูปแบบของ mysqli_result

                if ($result->num_rows === 0){
                    echo "<tr><td colspan='7' class='text-center'>No users found</td></tr>";
                } else {
                    while ($news = $result->fetch_assoc())  {
                        ?>
                        <tr>
                            <th scope="row"><?= $news['id']; ?></th>
                            <td><?= $news['upload_date']; ?></td>
                            <td><?= $news['start_date']; ?></td>
                            <td><?= $news['end_date']; ?></td>
                            <td><?= $news['heading']; ?></td>
                            <td width="250px"><img width="100%" src="upload/<?= $news['news']; ?>" class="rounded" alt=""></td>
                            <td>
                                <a href="edit.php?id=<?= $news['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="?delete=<?= $news['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
                            </td>
                        </tr>
                    <?php 
                    }
                }
                ?>
            </tbody>
        </table>


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