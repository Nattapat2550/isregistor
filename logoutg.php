<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();
// Unset all of the session variables.
$_SESSION = array();
// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie('user_password', ''); 
    setcookie('user_login', '');
}
// Finally, destroy the session.
session_destroy();
header("Location: index.php");
exit;
?>