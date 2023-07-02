<!DOCTYPE html>
<html>
<head>
<style>
    ul{
        background-color: black;
    }
    button{
        background: blue;
    }
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
  <li><a class="active-dark" href="setting-light.php">setting-light</a></li>
  <li><a class="active-dark" href="setting-google.php">setting-user</a></li>
</ul>
</body>
</html>


