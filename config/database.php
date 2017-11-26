<?php
require_once 'includes/MysqliDb.php';
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "simpleadmin";
// create connection object

$db =new MysqliDb($servername,$username,$password,$dbname);


 ?>