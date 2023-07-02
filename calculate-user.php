<?php 
session_start();

require_once 'config/db.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: signin.php');
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
<?php if ($_COOKIE['user_light'] == 'dark') {  
    include 'userdark.php';
} else {
    include 'user.php';
}     
?>

<form action="add_datacalculate.php" method="POST" >
    <a class="head">Calculator Money</a>
    <br>
    <input type="number" name="number1" placeholder="รายได้ต่อเดือน"><br>
    <input type="number" name="number2" placeholder="รายจ่ายต่อเดือน"><br>
    <button type="submit">แก้ไข</button>
    <input type="text" name="email" placeholder="Please enter your name" style="width: 230px; height: 30px;" hidden value="<?php echo $row['email'] ?>">
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
        $email = $row['email'];
        $sql1 = "SELECT * FROM numbers WHERE email = '$email' ORDER BY time ASC";
        $sql2 = "SELECT * FROM status WHERE email = '$email' ORDER BY time ASC";
        $sql3 = "SELECT * FROM target WHERE email = '$email' ORDER BY time ASC";
        $sql4 = "SELECT * FROM dept WHERE email = '$email' ORDER BY time ASC";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute();
        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        $stmt3 = $conn->prepare($sql3);
        $stmt3->execute();
        $result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
        $stmt4 = $conn->prepare($sql4);
        $stmt4->execute();
        $result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        // ตัวแปรเพิ่มเติมสำหรับลำดับและแสดงผลในตาราง
        $total1 = 0;
        $total2 = 0;
        $total3 = 0;
        $total4 = 0;
        $number1 = 0;
        $number2 = 0;

        // แสดงข้อมูลในตาราง
        if ($stmt1->rowCount() > 0) {
            foreach ($result1 as $row) {
                echo "<tr>";
                echo "<td>" . $row['number1'] . "</td>";
                echo "<td>" . $row['number2'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                $number1 += $row['number1'];
                $number2 += $row['number2'];
            }
        } else {
            echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";
            echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";
            echo "<td>" . "ไม่มีข้อมูลในระบบ" . "</td>";
        }
        if ($stmt2->rowCount() > 0) {
            foreach ($result2 as $row) {
                
                $total2 += $row['number'];
            }
        } else {
            echo "";
        }
        if ($stmt3->rowCount() > 0) {
            foreach ($result3 as $row) {
                
                $total3 += $row['number'];
            }
        } else {
            echo "";
        }
        if ($stmt4->rowCount() > 0) {
            foreach ($result4 as $row) {
                
                $total4 += $row['number'];
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
            if ($stmt1->rowCount() > 0) {
                foreach ($result1 as $row) {
            echo "<tr>";
            echo "<td colspan='1'><strong>ความอยู่รอด:</strong></td>";
            echo "<td><strong>" . $number1 / $number2. "</strong></td>";
            if($number1 / $number2 >1){
                echo "<td colspan='1'><strong>มีเงินพอใช้ในแต่ละเดือน</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";
        }
    } else {
        echo "";
    }
    if ($stmt2->rowCount() > 0 and $stmt3->rowCount() > 0) {
        foreach ($result2 as $row) {
            echo "<tr>";
            echo "<td colspan='1'><strong>สภาพคล่อง:</strong></td>";
            echo "<td><strong>" . $total2/$total3 . "</strong></td>";
            if($total2/$total3 >1){
                echo "<td colspan='1'><strong>มีเงินพอชำระค่าเช่า</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดค่าเช่า</strong></td>";
            }
            echo "</tr>";
        }
    } else {
        echo "";
    }
    if ($stmt2->rowCount() > 0 and $stmt1->rowCount() > 0) {
        foreach ($result2 as $row) {
            echo "<tr>";
            echo "<td colspan='1'><strong>สภาพคล่องพื้นฐาน:</strong></td>";
            echo "<td><strong>" . $total2/$number2 . "</strong></td>";
            if($total2 / $number2 >3){
                echo "<td colspan='1'><strong>มีเงินสำรอง</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
            echo "</tr>";
        }
    } else {
        echo "";
    }
    if ($stmt2->rowCount() > 0 and $stmt3->rowCount() > 0 and $stmt4->rowCount()) {
        foreach ($result2 as $row) {
            echo "<tr>";
            echo "<td colspan='1'><strong>หนึ้สินต่อสินทรัพย์:</strong></td>";
            echo "<td><strong>" . ($total4 + $total3 )/$total2 . "</strong></td>";
            if(($total4 + $total3 )/$total2 <0.5){
                echo "<td colspan='1'><strong>มีความมั่นคงทางการเงิน</strong></td>";
            }else{
                echo "<td colspan='1'><strong>ควรลดรายจ่าย</strong></td>";
            }
        }
    } else {
        echo "";
    }
            echo "</tr>";

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
    ?>
</table>
</html>
