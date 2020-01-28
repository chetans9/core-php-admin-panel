<?php
require_once '../config/config.php';
// Auth class
require_once BASE_PATH . '/lib/System/Auth.php';
$auth = new Authentication;
// CustomersModel class
require_once BASE_PATH . '/customers/models/customersModel.php';
$obj = new Customers;

// 
$id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$task   = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING); 

$row = $obj->populateForm($id);
($task == 'update') ? $edit = true : $edit = false;

// CustomerView class
require_once BASE_PATH . '/customers/views/customerView.php';
