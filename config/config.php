<?php 

define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER','simpleadmin');


require_once BASE_PATH.'/lib/MysqliDb.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "corephpadmin";
// create connection object

$db =new MysqliDb($servername,$username,$password,$dbname);