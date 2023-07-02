<?php 
    session_start();

    include_once 'controllers/Comment.php'; 

    $com = new Comment();



    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname'];
        $comment = $_POST['comment'];

        if (empty($fullname) || empty($comment)) {
            echo "<span style='color: red; font-size: 20px;'>Field must not be empty</span>";
        } else {
            $com->setData($fullname, $comment);
            if ($com->create()) {
                if(isset($_SESSION['login_id'])){
                    header('Location: contact-google.php?msg='.urlencode('Comment Posting Successfully'));
                }
                if(isset($_SESSION['user_login'])){
                    header('Location: contact-user.php?msg='.urlencode('Comment Posting Successfully'));
                }
            }
        }
    }

?>