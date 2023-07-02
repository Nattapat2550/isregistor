<?php 

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
        <a href="home-user.php">Home</a><b>|</b>
        <a href="status-user.php">Status Money</a><b>|</b>
        <a href="target-user.php">Target Money</a><b>|</b>
        <a href="dept-user.php">Your Dept</a><b>|</b>
        <a href="calculate-user.php">Calculator Money</a><b>|</b>
        <a href="contact-user.php">Contact</a>
    </div>
        <?php if (isset($_SESSION['user_login'])) {
                $user_id = $_SESSION['user_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);}  ?>
            
            <div class="dropdown-dark">
                
                <button class="dropbtn-dark" onclick="myFunction()"><?php echo $row['firstname'] . ' ' . $row['lastname'] ?>
                    <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content-dark" id="myDropdown">
                    <a href="logout.php" class="btn-dark btn-danger">Logout</a>
                    <a href="setting-light.php" class="btn-dark btn-danger">Setting</a>
                </div>
            </div> 
            <img src="<?php echo $row['profile_image']?>" class="imgac" style="width:40px;height:40px;">
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

<script>
function Function() {
   var element = document.body;
   element.classList.toggle("dark-mode");
}
</script>
</body>
</html>