<?php 
    session_start();
        require_once('connection.php');
        if (isset($_REQUEST['delete_id'])) {
            $id = $_REQUEST['delete_id'];
    
            $select_stmt = $db->prepare('SELECT * FROM tbl_file WHERE id = :id');
            $select_stmt->bindParam(':id', $id);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            unlink("upload/".$row['image']); // unlin functoin permanently remove your file
    
            // delete an original record from db
            $delete_stmt = $db->prepare('DELETE FROM tbl_file WHERE id = :id');
            $delete_stmt->bindParam(':id', $id);
            $delete_stmt->execute();
    
            header("Location: target-admin.php");
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Target Money Page</title>

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
    <?php 
    $select_stmt = $db->prepare('SELECT * FROM tbl_file'); 
    $select_stmt->execute();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>    
        <div class="gallery">
            <a target="_blank" href="upload/<?php echo $row['image']; ?>">                    
            <img src="upload/<?php echo $row['image']; ?>" alt="">
            </a>
            <div class="desc"><?php echo $row['name']; ?></div>
        </div>                                               
    <?php } ?>
</body>
</html>