<?php 
    error_reporting(E_ALL ^ E_NOTICE); 
    session_start();
    include('config/db.php');

    include('db_connection.php');
    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style/dark.css">
    <link rel="stylesheet" href="style/front.css">
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'set-setting-darkgoogle.php';
}
    else {
        include 'set-setting-google.php';
    }     
?>
<div style="margin-left:25%;padding:1px 16px;">
    <div class="header">
        <h2>Setting User</h2>
    </div>
	<br>
	<hr>
	<br>
        
	
    <?php if (isset($_SESSION['login_id'])) {
                $id = $_SESSION['login_id'];
                $get_user = mysqli_query($db_connection, "SELECT * FROM `users` WHERE `google_id`='$id'");
                if(mysqli_num_rows($get_user) > 0){
                    $user = mysqli_fetch_assoc($get_user);
                }
                else{
                    header('Location: logoutg.php');
                    exit;
                }
                ?>
                <img src="<?php echo $user['profile_image']; ?>" class="imgclean" style="width:40px;height:40px;" referrerpolicy="no-referrer"/>
                <?php
                echo 'FIRSTNAME : '.$user['firstname'] . ' | LASTNAME : ' . $user['lastname'];
            }
?>
	      
</div>
</body>
</html>