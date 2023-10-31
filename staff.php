<!DOCTYPE html>
<html>
<head>
    <title>เจ้าหน้าที่ประชาสัมพันธ์</title>
</head>
<body>
    <button id="addImage">Add Image</button>
    <button id="addText">Add Text</button>
    <button id="addMessage">Add Message</button>
    <button id="addVideo">Add Video</button>
    <div id="result"></div>

    <script>
        // เมื่อกดปุ่ม Add Image
        document.getElementById("addImage").addEventListener("click", function() {
            // ส่งไปยังหน้าถัดไป (สร้างเชื่อมโยง URL หรือเปลี่ยนหน้า)
            window.location.href = "addimage.php";
            document.getElementById("result").innerHTML = "คุณกดปุ่ม Add Image";
        });

        // เมื่อกดปุ่ม Add Text
        document.getElementById("addText").addEventListener("click", function() {
            // ส่งไปยังหน้าถัดไป
            window.location.href = "addtext.php";
            document.getElementById("result").innerHTML = "คุณกดปุ่ม Add Text";
        });

        // เมื่อกดปุ่ม Add Message
        document.getElementById("addMessage").addEventListener("click", function() {
            // ส่งไปยังหน้าถัดไป
            // ตัวอย่าง: window.location.href = "add_message.php";
            document.getElementById("result").innerHTML = "คุณกดปุ่ม Add Message";
        });

        // เมื่อกดปุ่ม Add Video
        document.getElementById("addVideo").addEventListener("click", function() {
            // ส่งไปยังหน้าถัดไป
            // ตัวอย่าง: window.location.href = "add_video.php";
            document.getElementById("result").innerHTML = "คุณกดปุ่ม Add Video";
        });
    </script>
</body>
</html>
