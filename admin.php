<?php 


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
    <link rel="stylesheet" href="style/front.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
    <div class="navbarleft">
        <img src="QG.jpg" class="imgclean" style="width:40px;height:40px;">
        <a>QuoteG</a>
        <a href="home-admin.php">Home</a><b>|</b>
        <a href="status-admin.php">Status Money</a><b>|</b>
        <a href="gallery-admin.php">Target Money</a><b>|</b>
        <a href="dept-admin.php">Your Dept</a><b>|</b>
        <a href="calculate-admin.php">Calculator Money</a><b>|</b>
        <a href="contact-admin.php">Contact</a>
    </div>
        <?php if (isset($_SESSION['admin_login'])) {
                $admin_id = $_SESSION['admin_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);}  ?>
            
            <div class="dropdown">
                <button class="dropbtn" onclick="myFunction()">Admin:<?php echo $row['firstname'] . ' ' . $row['lastname'] ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content" id="myDropdown">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
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
    
    
</body>
</html>