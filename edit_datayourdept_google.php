<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <?php
    // เชื่อมต่อฐานข้อมูล
    $conn = mysqli_connect("localhost", "root", "", "registration_system");

    // ตรวจสอบการเชื่อมต่อ
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // รับค่าที่ส่งมาจากฟอร์มแก้ไข
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number = $_POST['number'];

        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE dept SET name='$name', number='$number' WHERE id='$id'";
        if (mysqli_query($conn, $sql)) {
            echo "แก้ไขข้อมูลเรียบร้อยแล้ว";
            header("Refresh: 3; URL=dept-google.php");
            exit;
        } else {
            echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล: " . mysqli_error($conn);
        }
    } else {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // ดึงข้อมูลจากฐานข้อมูล
            $sql = "SELECT * FROM dept WHERE id='$id'";
            $result = mysqli_query($conn, $sql);

            // ตรวจสอบว่ามีข้อมูลหรือไม่
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                ?>
                <form action="edit_datayourdept_google.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
                    <input type="number" name="number" value="<?php echo $row['number']; ?>"><br><br>
                    <button type="submit">Save</button>
                </form>
                <?php
            } else {
                echo "ไม่พบข้อมูล";
            }
        } else {
            echo "ไม่ได้ระบุรหัสข้อมูล";
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);
    ?>
</body>
</html>