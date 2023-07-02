<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
require 'db_connection.php';
if(!isset($_SESSION['login_id'])){
    header('Location: signin.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'usergoogledark.php';
}
    else {
        include 'usergoogle.php';
    }     
?>
<form action="add_datayourdept_google.php" method="POST">
<a class="head">Your Dept</a><br>
    <input type="text" name="name" placeholder="รายการ"><br>
    <input type="number" name="number" placeholder="จำนวนเงิน(บาท)"><br>
    <button type="submit">เพิ่มข้อมูล</button>
    <input type="text" name="email" placeholder="Please enter your name" style="width: 230px; height: 30px;" hidden value="<?php echo $user['email'] ?>">
</form>

<br><br>

<table>
    <tr>
        <th>ลำดับ</th>
        <th>รายการ</th>
        <th>จำนวนเงิน(บาท)</th>
        <th>เวลาที่เปลี่ยนแปลงรายการล่าสุด</th>
        <th>แก้ไข</th>
        <th>ผ่อน</th>
        <th>ลบ</th>
    </tr>
    <?php
    try {
    // ดึงข้อมูลจากฐานข้อมูล
    $email = $user['email']; // เพิ่มบรรทัดนี้เพื่อกำหนดค่า $email จาก session
    $sql = mysqli_query($db_connection, "SELECT * FROM dept WHERE email = '$email' ORDER BY time ASC");
    if (mysqli_num_rows($sql) > 0) {
        $order = 1;
        $total = 0;

        while ($user = mysqli_fetch_assoc($sql)) {
            echo "<tr>";
            echo "<td>" . $order . "</td>";
            echo "<td>" . $user['name'] . "</td>";
            if ($user['number'] > 0) {
                echo "<td>" . $user['number'] . "</td>";
                echo "<td>" . $user['time'] . "</td>";
                echo "<td><a href='edit_datayourdept_google.php?id=" . $user['id'] . "'>แก้ไข</a></td>";
                echo "<td><a href='minus_datadept_google.php?id=" . $user['id'] . "'>ผ่อน</a></td>";
            } else {
                echo "<td>เสร็จสิ้น</td>";
                echo "<td>" . $user['time'] . "</td>";
                echo "<td></td>"; // ไม่แสดงปุ่ม "ผ่อน"
                echo "<td></td>";
            }
            echo "<td><a href='delete_datadept_google.php?id=" . $user['id'] . "' onclick='return confirm(\"คุณต้องการลบข้อมูลนี้หรือไม่?\")'>ลบ</a></td>";
            echo "</tr>";
            $order++;
            $total += $user['number'];
        }
    } else {
        echo "<tr><td colspan='6'>ไม่พบข้อมูล</td></tr>";
        
        exit;
    }

    // แสดงผลรวมในตาราง
    echo "<tr>";
    echo "<td colspan='2'><strong>ผลรวม:</strong></td>";
    echo "<td><strong>" . $total . "</strong></td>";
    echo "<td colspan='3'></td>";
    echo "</tr>";

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


    $db_connection = null;
    ?>
</table>
</body>
</html>