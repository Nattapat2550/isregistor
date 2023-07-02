<?php session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Calculator Money Page</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'headdark.php';
}
    else {
        include 'head.php';
    }     
?>
</body>
</html>