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
<form action="add_datacalculate_google.php" method="POST">
<a class="head">Calculator Money</a>
    <input type="number" name="number1" placeholder="รายได้ต่อเดือน"><br>
    <input type="number" name="number2" placeholder="รายจ่ายต่อเดือน"><br>
    <button type="submit">แก้ไข</button>
    <input type="text" name="email" placeholder="Please enter your name" style="width: 230px; height: 30px;" hidden value="<?php echo $user['email'] ?>">
</form>

<br>

<table>
    <tr>
        <th>รายได้ต่อเดือน</th>
        <th>รายจ่ายต่อเดือน</th>
        <th>เวลา</th>
    </tr>
    <?php
    try {
    // ดึงข้อมูลจากฐานข้อมูล
    $email = $user['email']; // เพิ่มบรรทัดนี้เพื่อกำหนดค่า $email จาก session
    $sql1 = mysqli_query($db_connection, "SELECT * FROM numbers WHERE email = '$email' ORDER BY time ASC");
    $sql2 = mysqli_query($db_connection, "SELECT * FROM status WHERE email = '$email' ORDER BY time ASC");
    $sql3 = mysqli_query($db_connection, "SELECT * FROM target WHERE email = '$email' ORDER BY time ASC");
    $sql4 = mysqli_query($db_connection, "SELECT * FROM dept WHERE email = '$email' ORDER BY time ASC");

    $number1 = 0;
    $number2 = 0;
    if (mysqli_num_rows($sql1) > 0) {

        while ($user = mysqli_fetch_assoc($sql1)) {
            echo "<tr>";
            echo "<td>" . $user['number1'] . "</td>";
            echo "<td>" . $user['number2'] . "</td>";
            echo "<td>" . $user['time'] . "</td>";
            $number1 += $user['number1'];
            $number2 += $user['number2'];
        }
    } else {
        echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";
        echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";
        echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";

    }
    
    if (mysqli_num_rows($sql2) > 0) {

        $total2 = 0;

        while ($user = mysqli_fetch_assoc($sql2)) {
            
            $total2 += $user['number'];
        }
    } else {
        echo "";
    }
    if (mysqli_num_rows($sql3) > 0) {

        $total3 = 0;

        while ($user = mysqli_fetch_assoc($sql3)) {
            
            $total3 += $user['number'];
        }
    } else {
        echo "";
    }
    if (mysqli_num_rows($sql4) > 0) {

        $total4 = 0;

        while ($user = mysqli_fetch_assoc($sql4)) {
            
            $total4 += $user['number'];
        }
    } else {
        echo "";
    }
?>
        </table>
    <table>
    <br>
    <tr>
        <th>ความมั่นคงทางการเงิน</th>
        <th>อัตราส่วน</th>
        <th>คำแนะนำ</th>
    </tr>
    <?php
    if (mysqli_num_rows($sql1) > 0) {
        echo "<tr>";
            echo "<td colspan='1'><strong>ความอยู่รอด:</strong></td>";
            echo "<td><strong>" . $number1 / $number2. "</strong></td>";
            if($number1 / $number2 >1){
                echo "<td colspan='1'><strong>มีเงินพอใช้ในแต่ละเดือน</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";

    }else{
        echo "";
    }
    if (mysqli_num_rows($sql2) > 0 and mysqli_num_rows($sql3) > 0) {
        echo "<tr>";
        echo "<td colspan='1'><strong>สภาพคล่อง:</strong></td>";
        echo "<td><strong>" . $total2/$total3 . "</strong></td>";
        if($total2/$total3 >1){
            echo "<td colspan='1'><strong>มีเงินพอชำระค่าเช่า</strong></td>";
        }else{
            echo "<td colspan='1'><strong>ควรลดค่าเช่า</strong></td>";
        }
        echo "</tr>";
    }else{
        echo "";
    }
    if (mysqli_num_rows($sql2) > 0 and mysqli_num_rows($sql1) > 0) {
        echo "<tr>";
            echo "<td colspan='1'><strong>สภาพคล่องพื้นฐาน:</strong></td>";
            echo "<td><strong>" . $total2/$number2 . "</strong></td>";
            if($total2 / $number2 >3){
                echo "<td colspan='1'><strong>มีเงินสำรอง</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";
    }else{
        echo "";
    }
    if (mysqli_num_rows($sql2) > 0 and mysqli_num_rows($sql3) > 0 and mysqli_num_rows($sql4) > 0) {
        echo "<tr>";
        echo "<td colspan='1'><strong>หนึ้สินต่อสินทรัพย์:</strong></td>";
        echo "<td><strong>" . ($total4 + $total3 )/$total2 . "</strong></td>";
        if(($total4 + $total3 )/$total2 <0.5){
            echo "<td colspan='1'><strong>มีความมั่นคงทางการเงิน</strong></td>";
        }else{
            echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
        }
    }else{
        echo "";
    }
    /* // แสดงผลรวมในตาราง
    echo "<tr>";
            echo "<td colspan='1'><strong>ความอยู่รอด:</strong></td>";
            echo "<td><strong>" . $number1 / $number2. "</strong></td>";
            if($number1 / $number2 >1){
                echo "<td colspan='1'><strong>มีเงินพอใช้ในแต่ละเดือน</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='1'><strong>สภาพคล่อง:</strong></td>";
            echo "<td><strong>" . $total2/$total3 . "</strong></td>";
            if($total2/$total3 >1){
                echo "<td colspan='1'><strong>มีเงินพอชำระค่าเช่า</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดค่าเช่า</strong></td>";
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='1'><strong>สภาพคล่องพื้นฐาน:</strong></td>";
            echo "<td><strong>" . $total2/$number2 . "</strong></td>";
            if($total2 / $number2 >3){
                echo "<td colspan='1'><strong>มีเงินสำรอง</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan='1'><strong>หนึ้สินต่อสินทรัพย์:</strong></td>";
            echo "<td><strong>" . ($total4 + $total3 )/$total2 . "</strong></td>";
            if(($total4 + $total3 )/$total2 <0.5){
                echo "<td colspan='1'><strong>มีความมั่นคงทางการเงิน</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>"; */

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


    $db_connection = null;
    ?>
</table>
</body>
</html>