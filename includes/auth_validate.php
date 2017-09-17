<?php
if (!isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] != TRUE) {
    header('Location:login.php');
}

 ?>