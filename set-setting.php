<!DOCTYPE html>
<html>
<head>
<style>
body {
  margin: 0;
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
<ul>
  <li><a class="active" href="setting-light.php">setting-light</a></li>
  <li><a class="active" href="setting-user.php">setting-user</a></li>
</ul>
</body>
</html>


