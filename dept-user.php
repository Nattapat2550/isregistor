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
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'userdark.php';
}
    else {
        include 'user.php';
    }     
?>
<form action="add_datayourdept.php" method="POST">
<a class="head">Your Dept</a><br>
    <input type="text" name="name" placeholder="รายการ"><br>
    <input type="number" name="number" placeholder="จำนวนเงิน(บาท)"><br>
    <button type="submit">เพิ่มข้อมูล</button>
    <input type="hidden" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>">
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
        if (isset($row['email'])) {
            $email = $row['email'];
            $sql = "SELECT * FROM dept WHERE email = :email ORDER BY time ASC";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // ตัวแปรเพิ่มเติมสำหรับลำดับและแสดงผลในตาราง
            $order = 1;
            $total = 0;

            // แสดงข้อมูลในตาราง
            if ($stmt->rowCount() > 0) {
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $order . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    
                    
                    if ($row['number'] > 0) {
                        echo "<td>" . $row['number'] . "</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td><a href='edit_datayourdept.php?id=" . $row['id'] . "'>แก้ไข</a></td>";
                        echo "<td><a href='minus_datadept.php?id=" . $row['id'] . "'>ผ่อน</a></td>";
                    } else {
                        echo "<td>เสร็จสิ้น</td>";
                        echo "<td>" . $row['time'] . "</td>";
                        echo "<td></td>"; // ไม่แสดงปุ่ม "ผ่อน"
                        echo "<td></td>";
                    }
                    echo "<td><a href='delete_datadept.php?id=" . $row['id'] . "' onclick='return confirm(\"คุณต้องการลบข้อมูลนี้หรือไม่?\")'>ลบ</a></td>";
                    echo "</tr>";
                    $order++;
                    $total += $row['number'];
                }
            } else {
                echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
            }

            // แสดงผลรวมในตาราง
            echo "<tr>";
            echo "<td colspan='2'><strong>ผลรวม:</strong></td>";
            echo "<td><strong>" . $total . "</strong></td>";
            echo "<td colspan='4'></td>";
            echo "</tr>";
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;
    ?>
</table>
</body>
</html>