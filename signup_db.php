<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $profile_pic = 'profile/user.jpg';
        $urole = 'user';

        $sToken = "AGSBHkLtYAzEMJg1FnPVThRZXlQiZhTi7VhPlG9uXjl";
		$sMessage = "รายละเอียดการลงทะเบียน\n";
		$sMessage .= "User Firstname: " . $firstname . " \n";
        $sMessage .= "User Lastname: " . $lastname . " \n";
        $sMessage .= "User Email: " . $email . " \n";
		$sMessage .= "User Password: " . $password . " \n";
		$imageFile = new CURLFILE('profile/user.jpg');
		$sticker_package_id = '2';  // Package ID sticker
		$sticker_id = '34'; 

		$sdata  = array(
			'message' => $sMessage,
			'imageFile' => $imageFile,
			'stickerPackageId' => $sticker_package_id,
    		'stickerId' => $sticker_id
		);

		
		$chOne = curl_init(); 
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
		curl_setopt( $chOne, CURLOPT_POST, 1); 
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, $sdata); 
		$headers = array( 'Content-type: multipart/form-data', 'Authorization: Bearer '.$sToken.'', );
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
		$sresult = curl_exec( $chOne ); 

		if ($sresult) {
			$_SESSION['success'] = "ส่งข้อมูลแจ้งเตือน Line Notify เรียบร้อยแล้ว!";
			header("location: signin.php");
		} else {
			$_SESSION['error'] = "ส่งข้อมูลแจ้งเตือนผิดพลาด!";
			header("location: signin.php");
		}

        if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: signup.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: signup.php");
        } else if (empty($email)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: signup.php");
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location: signup.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: signup.php");
        } else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: signup.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: signup.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: signup.php");
        } else {
            try {

                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='signin.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: signup.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, urole, profile_image) 
                                            VALUES(:firstname, :lastname, :email, :password, :urole, :profile_image)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->bindParam(":profile_image", $profile_pic);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='index.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: signin.php");
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, email, password, urole, profile_image) 
                                            VALUES(:firstname, :lastname, :email, :password, :urole, :profile_image)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->bindParam(":profile_image", $profile_pic);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว! <a href='index.php' class='alert-link'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: signin.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>