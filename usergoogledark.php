<?php
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
    <link rel="stylesheet" href="style/dark.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    .header{
        background: blue;
    }
    body{
        background: rgb(40,40,40);
        color: white;    
    }
    .textdescription{
  border: 1px solid white;
  color: white;
  font-size: 15px;
  padding: 8px 12px;
  position: relative;
  top:60px;
  bottom: 8px;
  width: 100%;
  text-align: left;
}
.boxarea{
    background: rgb(56,56,56); 
    border: 1px solid blue;
}
form {
    width: 30%;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid blue;
    background: rgb(56,56,56);
    border-radius: 0px 0px 10px 10px;
}
</style>    
<div class="navbar-dark">
    <div class="navbarleft">
        <img src="QG.jpg" class="imgclean" style="width:40px;height:40px;">
        <a>InvestmentPocket</a>
        <a href="home-google.php">Home</a><b>|</b>
        <a href="status-google.php">Status Money</a><b>|</b>
        <a href="target-google.php">Target Money</a><b>|</b>
        <a href="dept-google.php">Your Dept</a><b>|</b>
        <a href="calculate-google.php">Calculator Money</a><b>|</b>
        <a href="contact-google.php">Contact</a>
    </div>
        <?php if (isset($_SESSION['login_id'])) {
                $id = $_SESSION['login_id'];
                $get_user = mysqli_query($db_connection, "SELECT * FROM `users` WHERE `google_id`='$id'");
                if(mysqli_num_rows($get_user) > 0){
                    $user = mysqli_fetch_assoc($get_user);
                }
                else{
                    header('Location: logoutg.php');
                    exit;
                }}  ?>
            
            <div class="dropdown-dark">
                
                <button class="dropbtn-dark" onclick="myFunction()"><?php echo $user['firstname'].' '.$user['lastname']?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content-dark" id="myDropdown">
                    <a href="logoutg.php" class="btn-dark btn-danger">Logout</a>
                    <a href="setting-google.php" class="btn-dark btn-danger">Setting</a>
                </div>
            </div>
            <img src="<?php echo $user['profile_image']; ?>" class="imgac" style="width:40px;height:40px;" referrerpolicy="no-referrer"/> 
</div>

<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(e) {
    if (!e.target.matches('.dropbtn-dark')) {
    var myDropdown = document.getElementById("myDropdown");
        if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
        }
    }
    }
</script>

</body>
</html>