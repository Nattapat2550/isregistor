<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    require 'db_connection.php';
if(!isset($_SESSION['login_id'])){
    header('Location: signin.php');
    exit;
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
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'usergoogledark.php';
}
    else {
        include 'usergoogle.php';
    }     
?>
<div class="header">
<h3>Contact Us</h3>
</div>
<div class="boxarea" >
<h5>FullName Developer : Nattapat Yansungvon</h5>
<h5>Email : nyansungvon@gmail.com</h5>
<h5>Facebook : Nattapat Yansungwon</h5>
<h5>Line id : guitar-_-</h5>
</div>
    <?php 
    
        if(isset($_GET['msg'])) {
            $msg = $_GET['msg'];
            echo "<span style='color: green; font-size: 20px'>".$msg."</span>";
        }

    ?>

    <form action="post_comment.php" method="post">
        <table style="height: 150px;">
            <tr>
                <td class="textbox">ชื่อติดต่อ: <?php echo $user['firstname'].' '.$user['lastname']?></td>
                <td><textarea type="text" name="fullname" placeholder="Please enter your name" style="width: 230px; height: 30px;" hidden><?php echo $user['firstname'].' '.$user['lastname']?></textarea></td>
            </tr>
            <tr>
                <td class="textbox" >ข้อความที่ส่ง:</td>
                <td>
                    <textarea name="comment" cols="30" rows="4" placeholder="Please enter your comment" class="textarea" ></textarea>
                </td>
            </tr>
            <tr>
                <td><input class="button" type="submit" name="submit" value="Post" style="top:100px;width: 120px; height: 40px;"></td>
            </tr>
        </table>
    </form>
</body>
</html>