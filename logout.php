<?php
session_start();
session_destroy();

if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
	unset($_COOKIE['username']);
    unset($_COOKIE['password']);
    setcookie('username', null, -1, '/');
    setcookie('password', null, -1, '/');
}
header('Location:index.php');

 ?>