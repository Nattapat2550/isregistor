<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "registration_system");

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าที่ส่งมาจากฟอร์ม
$email = $_POST['email'];
$name = $_POST['name'];
$number = $_POST['number'];
$time = date('Y-m-d H:i:s');

// เพิ่มข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO target (name, email, number, time) VALUES ('$name','$email', '$number', '$time')";
mysqli_query($conn, $sql);

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);

// กลับไปยังหน้าแรก
header("Location: target-user.php");
exit();
?>

