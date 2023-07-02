<?php
setcookie('user_light', 'light', time() + (10 * 365 * 24 * 60 * 60));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="style/front.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="navbar">
    <div class="navbarleft">
        <img src="QG.jpg" class="imgclean" style="width:40px;height:40px;">
        <a>InvestmentPocket</a>
        <a href="index.php">Home</a><b>|</b>
        <a href="status.php">Status Money</a><b>|</b>
        <a href="target.php">Target Money</a><b>|</b>
        <a href="dept.php">Your Dept</a><b>|</b>
        <a href="calculate.php">Calculator Money</a><b>|</b>
        <a href="contact.php">Contact</a>
    </div>
        <div class="dropdown">
            <button class="dropbtn" onclick="myFunction()">SignUp & Login GUIYA
                <i class="fa fa-caret-down"></i>
            </button>
            <div class="dropdown-content" id="myDropdown">
                <a href="signup.php" class="btn btn-danger">SignUp</a>
                <a href="signin.php" class="btn btn-danger">Login</a>
                <a href="setting-light.php" class="btn btn-danger">Setting</a>
            </div>
        </div>
</div>
<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("myDropdown");
        if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
        }
    }
    }
</script>

<script>
function Function() {
   var element = document.body;
   element.classList.toggle("dark-mode");
}
</script>
</body>
</html>