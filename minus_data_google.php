<?php
error_reporting(E_ALL ^ E_NOTICE);
require 'db_connection.php';
session_start();
if (!isset($_SESSION['login_id'])) {
    header('Location: signin.php');
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $email = $_SESSION['user_login'] ?? '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $number = $_POST['number'];

        if ($number <= 0) {
            // Update the number value in the database to 0
            $sql = "UPDATE target SET number = 0 WHERE id = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param('s', $id);
            $stmt->execute();
        } else {
            // Update the number value in the database
            $sql = "UPDATE target SET number = number - ? WHERE id = ?";
            $stmt = $db_connection->prepare($sql);
            $stmt->bind_param('is', $number, $id);
            $stmt->execute();
        }

        header('Location: gallery-google.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'ไม่พบข้อมูล';
    header('Location: gallery-google.php');
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
