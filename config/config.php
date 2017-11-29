<?php 

define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER','simpleadmin');
define('BASE_URL', $_SERVER['SERVER_NAME']."");


require_once BASE_PATH.'/includes/MysqliDb.php';
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "simpleadmin";
// create connection object

$db =new MysqliDb($servername,$username,$password,$dbname);



function url(){
  return sprintf(
    "%s://%s%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI']
  );
}