<?php

session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
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
    <title>Admin Page</title>
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
    include 'admindark.php';
}
    else {
        include 'admin.php';
    }     
?>
<form action="add_data.php" method="POST">
        <input type="text" name="name" placeholder="ชื่อ"><br><br>
        <input type="number" name="number" placeholder="ตัวเลข"><br><br>
        <button type="submit">Add Data</button>
    </form>

    <br><br>

    <table>
        <tr>
            <th>ลำดับ</th>
            <th>Email</th>
            <th>ชื่อที่ใส่</th>
            <th>ตัวเลข</th>
            <th>เวลา</th>
            <th>แก้ไข</th>
            <th>ลบ</th>
        </tr>
        <?php

        try {
            // ดึงข้อมูลจากฐานข้อมูล
            $sql = "SELECT email, SUM(number) AS total_number FROM status GROUP BY email ORDER BY total_number ASC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // ตัวแปรเพิ่มเติมสำหรับลำดับและแสดงผลในตาราง
            $order = 1;
            $total = 0;

            // แสดงข้อมูลในตาราง
            if ($stmt->rowCount() > 0) {
                foreach ($result as $row) {
                    $email = $row['email'];
                    $total_number = $row['total_number'];

                    // ดึงข้อมูลอื่น ๆ ของอีเมลนี้
                    $sql_email = "SELECT * FROM status WHERE email = :email";
                    $stmt_email = $conn->prepare($sql_email);
                    $stmt_email->bindParam(':email', $email);
                    $stmt_email->execute();
                    $result_email = $stmt_email->fetchAll(PDO::FETCH_ASSOC);

                    $email_total = 0;

                    foreach ($result_email as $email_row) {
                        echo "<tr>";
                        echo "<td>" . $order . "</td>";
                        echo "<td>" . $email_row['email'] . "</td>";
                        echo "<td>" . $email_row['name'] . "</td>";
                        echo "<td>" . $email_row['number'] . "</td>";
                        echo "<td>" . $email_row['time'] . "</td>";
                        echo "<td><a href='edit_data.php?id=" . $email_row['id'] . "'>แก้ไข</a></td>";
                        echo "<td><a href='delete_data.php?id=" . $email_row['id'] . "' onclick='return confirm(\"คุณต้องการลบข้อมูลนี้หรือไม่?\")'>ลบ</a></td>";
                        echo "</tr>";
                        $order++;
                        $email_total += $email_row['number'];
                    }

                    echo "<tr>";
                    echo "<td colspan='3'><strong>ผลรวม:</strong></td>";
                    echo "<td><strong>" . $email_total . "</strong></td>";
                    echo "<td colspan='3'></td>";
                    echo "</tr>";

                    $total += $email_total;
                }
            } else {
                echo "<tr><td colspan='6'>ไม่พบข้อมูล</td></tr>";
            }

            // แสดงผลรวมทั้งหมดในตาราง
            echo "<tr>";
            echo "<td colspan='2'><strong>ผลรวมทั้งหมด:</strong></td>";
            echo "<td><strong>" . $total . "</strong></td>";
            echo "<td colspan='3'></td>";
            echo "</tr>";

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        $conn = null;
        ?>
    </table>    
</body>
</html>
