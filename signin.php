<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registration System PDO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <h3 class="mt-4">เข้าสู่ระบบ</h3>
        <hr>
        <form action="signin_db.php" method="post">
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <div class="container mt-5">
    <form method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" value="<?php if (isset($_COOKIE['user_login'])) { echo $_COOKIE['user_login']; } ?>" name="email" aria-describedby="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" value="<?php if (isset($_COOKIE['user_password'])) { echo $_COOKIE['user_password']; } ?>" name="password" id="password-input">
          <span class="input-group-text">
          <input type="checkbox" name="hide_password" class="form-check-input" id="remember" onchange="showHidePassword()">
<label class="form-check-label" for="hide_password">hide password</label>
          </span>
        </div>
      </div>
      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" <?php if (isset($_COOKIE['user_login'])) { ?> checked <?php } ?> class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Remember Me</label>
      </div>
      <button type="submit" name="signin" class="btn btn-primary">Sign In</button>
    </form>
    <hr>
    <p>ยังไม่เป็นสมาชิกใช่ไหม คลิ๊กที่นี่เพื่อ <a href="signup.php">สมัครสมาชิก</a></p>
    <div class="g-signin2" data-onsuccess="onSignIn"></div>
  </div>
    <?php
        session_destroy();
     include 'login.php';
     ?>
     <!-- PHP code to check if the checkbox is checked -->
<?php
    $show_password = false;
    if (isset($_POST['hide_password'])) {
        $show_password = true;
    }
?>

<!-- JavaScript code to show or hide the password input -->
<script>
    function showHidePassword() {
        const checkbox = document.querySelector('#remember');
        const passwordInput = document.querySelector('#password-input');
        
        if (checkbox.checked) {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    }
    
    // Check if the checkbox was checked before submitting the form
    const checkbox = document.querySelector('#remember');
    if (<?php echo json_encode($show_password); ?>) {
        checkbox.checked = true;
        showHidePassword();
    }
</script>
    
</body>
</html>