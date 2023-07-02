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
    include 'usergoogledark.php';
}
    else {
        include 'usergoogle.php';
    }     
?>
<ul>
  <li><a class="active" href="setting-light.php">setting-light</a></li>
  <li><a class="active" href="setting-google.php">setting-user</a></li>
</ul>
</body>
</html>


