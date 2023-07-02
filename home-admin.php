<?php 

    session_start();
    require_once('connection.php');
    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare('SELECT * FROM tbl_file_index WHERE id = :id');
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        unlink("upload_index/".$row['image']); // unlin functoin permanently remove your file

        // delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM tbl_file_index WHERE id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header("Location: home-admin.php");
    }

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if ($_COOKIE['user_light']=='dark') {  
    include 'admindark.php';
}
    else {
        include 'admin.php';
    }     
?>   
    <a href="add_index.php" class="button">Add Image</a>
        <table class="table;height:1000px;">
        
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Image</td>
                    <td>List</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $select_stmt = $db->prepare('SELECT * FROM tbl_file_index'); 
                    $select_stmt->execute();

                    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>                        
                        <td><p><img src="upload_index/<?php echo $row['image']; ?>" width="300px" height="200px" alt=""></p></td>
                        <td><?php echo $row['list']; ?></td>                        
                        <td><a href="edit_index.php?update_id=<?php echo $row['id']; ?>" class="btn">Edit</a></td>                        
                        <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn">Delete</a></td>                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>   
</body>
</html>