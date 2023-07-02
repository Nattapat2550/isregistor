<?php 

    session_start();
    require_once 'config/db.php';
    if (!isset($_SESSION['admin_login'])) {
        $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
        header('location: signin.php');
    }

    include_once 'controllers/Comment.php';
    $com = new Comment();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'admindark.php';
}
    else {
        include 'admin.php';
    }     
?>  
    <table class="tablead">
            <thead>
                <tr>
                    <td>FullName</td>
                    <td>Comment</td>
                    <td>Time To Send Comments</td>
                </tr>
            </thead>

            <tbody>
            <?php 
                if($result = $com->index()) {
                while ($data = $result->fetch_assoc()) {
            ?>
                <li>
                    <tr>
                        <td><?php echo $data['fullname']; ?></td>                        
                        <td><?php echo $data['comment']; ?></td>                        
                        <td><?php echo $data['comment_time']; ?></td>                                                
                    </tr>
                    </li>
                <?php } ?>
            <?php }?>
            </tbody>
        </table>
</body>
</html>