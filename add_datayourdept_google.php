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
$number = $_POST['number'];
$time = date('Y-m-d H:i:s');

// เพิ่มข้อมูลลงในฐานข้อมูล
$sql = "INSERT INTO dept (name, email, number, time) VALUES ('$name','$email', '$number', '$time')";
mysqli_query($db_connection, $sql);

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($db_connection);

// กลับไปยังหน้าแรก
header("Location: dept-google.php");
exit();

?>