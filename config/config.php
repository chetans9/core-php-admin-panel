<?php
//  Note: this file should be included first in every php page

/*  ------------------------------------
    GLOBAL CONFIGURATION
    --------------------------------- */
error_reporting(E_ALL);
ini_set('display_errors', 'On');
define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'simpleadmin');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));

//  Some workaround so we have absolute paths both in local and remote enviroments
$base_dir  = __DIR__; // Absolute path to your installation, ex: /var/www/mywebsite
$doc_root  = preg_replace("!${_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
$base_url  = preg_replace("!^${doc_root}!", '', $base_dir); # ex: '' or '/mywebsite'
$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$domain    = $_SERVER['SERVER_NAME'];
$port      = $_SERVER['SERVER_PORT'];
$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
if($domain == 'localhost')
{
    $explode  = explode("\\", $base_dir);
    $base_url = "${protocol}://${domain}${disp_port}/${explode[3]}"; # Ex: 'http://localhost', 'https://localhost/folder', etc.
}
else
{
    $base_url = "${protocol}://${domain}${disp_port}${base_url}"; # Ex: 'http://example.com', 'https://example.com/mywebsite', etc.
}

require_once BASE_PATH . '/lib/MysqliDb/MysqliDb.php';
require_once BASE_PATH . '/helpers/helpers.php';

/*  ------------------------------------
    DATABASE CONFIGURATION
    --------------------------------- */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'corephpadmin');

/**
 *  Get instance of DB object
 */
function getDbInstance() {
	return new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
