<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $email = $_SESSION['user_login'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $number = $_POST['number'];
        
        if ($number <= 0) {
            // อัปเดตค่าตัวเลขในฐานข้อมูลเป็น 0
            $sql = "UPDATE dept SET number = 0 WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } else {
            // อัปเดตค่าตัวเลขในฐานข้อมูล
            $sql = "UPDATE dept SET number = number - :number WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':number', $number);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }
        
        header('Location: dept-user.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'ไม่พบข้อมูล';
    header('Location: dept-user.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minus Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Minus Data</h1>
    <form action="" method="POST">
        <label for="number">ตัวเลขที่จะลบ:</label>
        <input type="number" name="number" id="number" required>
        <button type="submit">ลบ</button>
    </form>
</body>
</html>
