<?php
session_start();
require_once './config/server.php'; // เชื่อมฐานข้อมูล
$conn = mysqli_connect($host, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("การเชื่อมต่อกับ MySQL ล้มเหลว: " . mysqli_connect_error());
}

// Create (เพิ่มข้อมูล)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $upload_date = $_POST['upload_date'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $heading = $_POST['heading'];
    $image_path = $_FILES['image']['name'];

    // เตรียมคำสั่ง SQL
    $insert_query = "INSERT INTO news_image (upload_date, start_date, end_date, heading, ) VALUES ('$upload_date', '$start_date', '$end_date', '$heading', '$image_path')";

    // ทำการเรียกคำสั่ง SQL
    if (mysqli_query($conn, $insert_query)) {
        // Upload รูปภาพไปยังโฟลเดอร์ที่คุณต้องการ
        move_uploaded_file($_FILES['image']['tmp_name'], 'upload/' . $image_path);

        //header('Location: index.php'); // ไปยังหน้ารายการหลักหลังจากเพิ่มข้อมูล
        exit();
    } else {
        echo "การเพิ่มข้อมูลล้มเหลว: " . mysqli_error($conn);
    }
}

// Read (อ่านข้อมูล)
$select_query = "SELECT * FROM news_image";
$result = mysqli_query($conn, $select_query);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Update (แก้ไขข้อมูล)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $upload_date = $_POST['upload_date'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $heading = $_POST['heading'];

    // เตรียมคำสั่ง SQL
    $update_query = "UPDATE news_image SET upload_date = '$upload_date', start_date = '$start_date', end_date = '$end_date', heading = '$heading' WHERE id = $id";

    // ทำการเรียกคำสั่ง SQL
    if (mysqli_query($connection, $update_query)) {
        //header('Location: index.php'); // ไปยังหน้ารายการหลักหลังจากแก้ไขข้อมูล
        exit();
    } else {
        echo "การแก้ไขข้อมูลล้มเหลว: " . mysqli_error($connection);
    }
}

// Delete (ลบข้อมูล)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // เตรียมคำสั่ง SQL
    $delete_query = "DELETE FROM your_table_name WHERE id = $id";

    // ทำการเรียกคำสั่ง SQL
    if (mysqli_query($conn, $delete_query)) {
       // header('Location: index.php'); // ไปยังหน้ารายการหลักหลังจากลบข้อมูล
        exit();
    } else {
        echo "การลบข้อมูลล้มเหลว: " . mysqli_error($connection);
    }
}

// ปิดการเชื่อมต่อ MySQL
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD ข้อมูล</title>
</head>
<body>
    <h1>CRUD ข้อมูล</h1>

    <!-- แบบฟอร์มสำหรับเพิ่มข้อมูล -->
    <h2>เพิ่มข้อมูล</h2>
    <form method="POST" action="index.php" enctype="multipart/form-data">
        <label for="upload_date">Upload Date:</label>
        <input type="date" name="upload_date" required><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" required><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" required><br>

        <label for="heading">Heading:</label>
        <input type="text" name="heading" required><br>

        <label for="image">Image:</label>
        <input type="file" name="image" required><br>

        <button type="submit" name="submit">เพิ่ม</button>
    </form>

    <!-- แสดงข้อมูล -->
    <h2>รายการข้อมูล</h2>
    <table>
        <tr>
            <th>Upload Date</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Heading</th>
            <th>Image</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo $row['upload_date']; ?></td>
                <td><?php echo $row['start_date']; ?></td>
                <td><?php echo $row['end_date']; ?></td>
                <td><?php echo $row['heading']; ?></td>
                <td><img src="upload/<?php echo $row['image_path']; ?>" style="max-width: 100px;"></td>
                <td><a href="edit.php?id=<?php echo $row['id']; ?>">แก้ไข</a></td>
                <td><a href="index.php?delete=<?php echo $row['id']; ?>">ลบ</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
