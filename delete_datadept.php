<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "registration_system");

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ลบข้อมูลจากฐานข้อมูล
    $sql = "DELETE FROM dept WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
        header("Refresh: 3; URL=dept-user.php");
        exit;
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . mysqli_error($conn);
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>
