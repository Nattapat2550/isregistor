<?php
error_reporting(E_ALL ^ E_NOTICE);
require 'db_connection.php';
if(!isset($_SESSION['login_id'])){
    header('Location: signin.php');
    exit;
}
// เชื่อมต่อฐานข้อมูล
$db_connection = mysqli_connect("localhost", "root", "", "registration_system");

// ตรวจสอบการเชื่อมต่อ
if (!$db_connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// รับค่าที่ส่งมาจากฟอร์ม
$email = $_POST['email'];
$name = $_POST['name'];
$number1 = $_POST['number1'];
$number2 = $_POST['number2'];
$time = date('Y-m-d H:i:s');


$sqlSelect = "SELECT * FROM numbers WHERE email = '$email'";
$result = mysqli_query($db_connection, $sqlSelect);

if (mysqli_num_rows($result) > 0) {
    // มีข้อมูลของผู้ใช้อยู่แล้ว ให้อัปเดตข้อมูลในตาราง
    $sqlUpdate = "UPDATE numbers SET number1 = '$number1', number2 = '$number2', time = '$time' WHERE email = '$email'";
    mysqli_query($db_connection, $sqlUpdate);
} else {
    // ไม่มีข้อมูลของผู้ใช้ ให้เพิ่มข้อมูลใหม่ลงในตาราง
    $sqlInsert = "INSERT INTO numbers (email, number1, number2, time) VALUES ('$email', '$number1', '$number2', '$time')";
    mysqli_query($db_connection, $sqlInsert);
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($db_connection);

// กลับไปยังหน้าแรก
header("Location: calculate-google.php");
exit();

?>