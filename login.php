<?php
require 'db_connection.php';
if(isset($_SESSION['login_id'])){
    header('Location: home-google.php');
    exit;
}
require 'google-api/vendor/autoload.php';
// Creating new google client instance
$client = new Google_Client();
// Enter your Client ID
$client->setClientId('735361932935-f3pdkspm2keq6re1dghr4ju66ctosfqa.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('http://localhost/isregistor/login.php');
// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");
if(isset($_GET['code'])):
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token["error"])){
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
    
        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture); 
        $flname = explode(" ", $full_name);
        $urole = 'user';
        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `google_id` FROM `users` WHERE `google_id`='$id'");
        if(mysqli_num_rows($get_user) > 0){
            $_SESSION['login_id'] = $id; 
            header('Location: home-google.php');
            setcookie('user_login', $email, time() + (10 * 365 * 24 * 60 * 60));
            setcookie('user_light', 'light', time() + (10 * 365 * 24 * 60 * 60));
            exit;
        }
        else{
            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `users`(`google_id`,`firstname`,`lastname`,`email`,`profile_image`,`urole`) VALUES('$id','$flname[0]','$flname[1]','$email','$profile_pic','$urole')");
            if($insert){
                $_SESSION['login_id'] = $id; 
                header('Location: login.php');
                setcookie('user_login', $email, time() + (10 * 365 * 24 * 60 * 60));
                setcookie('user_light', 'light', time() + (10 * 365 * 24 * 60 * 60));
                exit;
            }
            else{
                echo "Sign up failed!(Something went wrong).";
            }
        }
    }
    else{
        header('Location: login.php');
        exit;
    }
    
else: 
    // Google Login Url = $client->createAuthUrl(); 
?>
    
    <a class="btn btn-outline-dark" href="<?php echo $client->createAuthUrl(); ?>" role="button" style="text-transform:none"> <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />Login with Google</a>
        
        <link   rel="stylesheet" 
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
        crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" 
        crossorigin="anonymous">
</script>
<?php endif; ?>