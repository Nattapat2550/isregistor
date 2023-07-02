<?php
// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect("localhost", "root", "", "registration_system");

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าที่ส่งมาจากฟอร์ม
$email = mysqli_real_escape_string($conn, $_POST['email']);
$number1 = mysqli_real_escape_string($conn, $_POST['number1']);
$number2 = mysqli_real_escape_string($conn, $_POST['number2']);
$time = date('Y-m-d H:i:s');

// ตรวจสอบว่ามีข้อมูลของผู้ใช้ในฐานข้อมูลหรือไม่ โดยใช้คำสั่ง SQL SELECT
$sqlSelect = "SELECT * FROM numbers WHERE email = '$email'";
$result = mysqli_query($conn, $sqlSelect);

if (mysqli_num_rows($result) > 0) {
    // มีข้อมูลของผู้ใช้อยู่แล้ว ให้อัปเดตข้อมูลในตาราง
    $sqlUpdate = "UPDATE numbers SET number1 = '$number1', number2 = '$number2', time = '$time' WHERE email = '$email'";
    mysqli_query($conn, $sqlUpdate);
} else {
    // ไม่มีข้อมูลของผู้ใช้ ให้เพิ่มข้อมูลใหม่ลงในตาราง
    $sqlInsert = "INSERT INTO numbers (email, number1, number2, time) VALUES ('$email', '$number1', '$number2', '$time')";
    mysqli_query($conn, $sqlInsert);
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);

// กลับไปยังหน้าแรก
header("Location: calculate-user.php");
exit();
?>
