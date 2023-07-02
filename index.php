<?php 

    session_start();
    require_once 'config/db.php';
    if (isset($_SESSION['user_login'])) {
        header('location: home-user.php');
    }
    if (isset($_SESSION['admin_login'])) {
        header('location: home-admin.php');
    }
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
    
            header("Location: target-admin.php");
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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
    $select_stmt = $db->prepare('SELECT * FROM tbl_file_index'); 
    $select_stmt->execute();
    while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>    
        <div class="slideshow-container">
        <div class="mySlides fade">
          <div class="numbertext"> <?php echo $row['list']; ?></div>                   
          <img src="upload_index/<?php echo $row['image']; ?>" style="top: 30px;width:100%; height:400px">
          <div class="textdescription">DESCRIPTION : <?php echo $row['name']; ?></div>
          <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
        </div>

        </div>
                                                 
    <?php } ?>
    <script>
var slideIndex = 1;
var timer = null;
showSlides(slideIndex);

function plusSlides(n) {
  clearTimeout(timer);
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  clearTimeout(timer);
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n==undefined){n = ++slideIndex}
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  timer = setTimeout(showSlides, 5000);
}
</script>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>
</body>
</html>