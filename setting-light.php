<?php 
    error_reporting(E_ALL ^ E_NOTICE); 
    session_start();
    include('config/db.php');
    include('db_connection.php');
    if (isset($_POST['submitlight'])) {
            if (!empty($_POST['light'])) {
                if (empty($_POST['dark'])) {
                    setcookie('user_light', $_POST['light'], time() + (10 * 365 * 24 * 60 * 60));
                } else {
                    if (isset($_COOKIE['user_light'])) {
                        setcookie('user_light', 'ERROR', time() + (10 * 365 * 24 * 60 * 60));
                    }else{
                        
                        setcookie('user_light', '');
                    }
                
                header("location: setting-light.php");
                }}
             else {
                if (!empty($_POST['dark'])) {
                    setcookie('user_light', $_POST['dark'], time() + (10 * 365 * 24 * 60 * 60));
                } else {
                    setcookie('user_light', 'ERROR', time() + (10 * 365 * 24 * 60 * 60));
                }
                header("location: setting-light.php");
            }
        }
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
<?php 
if(isset($_SESSION['login_id'])){
if ($_COOKIE['user_light']=='dark') {  
    include 'set-setting-darkgoogle.php';
}
    else {
        include 'set-setting-google.php';
    }
}  
if(isset($_SESSION['user_login']) || isset($_SESSION['admin_login'])){
    if ($_COOKIE['user_light']=='dark') {  
        include 'set-setting-dark.php';
    }
        else {
            include 'set-setting.php';
        }
    }  
?>


<div style="margin-left:25%;padding:1px 16px;">
    <div class="header">
        <h2>Setting Light</h2>
    </div>
    <br>
    <hr>
    <br>
    <form action="setting-light.php" method="post">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            
            <div class="mb-3 form-check">
                <input type="checkbox" name="light" <?php if (isset($_COOKIE['user_light'])) { ?> checked <?php  } ?> value="light" class="form-check-input" id="light">
                <label class="form-check-label" for="light">Light</label>
            </div>
            <hr>
            <div class="mb-3 form-check">
                <input type="checkbox" name="dark" <?php if (isset($_COOKIE['user_light'])) { ?> checked <?php } ?> value="dark" class="form-check-input" id="dark">
                <label class="form-check-label" for="dark">Dark</label>
            </div>
            <br>
            <button type="submit" name="submitlight" class="btn btn-primary">Submit Light</button>
        </form>    
</div>
</body>
</html>