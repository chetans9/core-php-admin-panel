<?php
require_once '../config/config.php';
// Auth class
require_once BASE_PATH . '/lib/System/Auth.php';
$auth = new Authentication;
// AccountsModel class
require_once BASE_PATH . '/users/models/accountsModel.php';
$obj = new Accounts;

// 
$id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$task   = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING); 

$row = $obj->populateForm($id);

// AccountView class
require_once BASE_PATH . '/users/views/accountView.php';
