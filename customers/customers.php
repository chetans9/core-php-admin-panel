<?php
require_once '../config/config.php';
// Auth class
require_once BASE_PATH . '/lib/System/Auth.php';
$auth = new Authentication;
// CustomersModel class
require_once BASE_PATH . '/customers/models/customersModel.php';
$obj = new Customers;
// Lists class
require_once BASE_PATH . '/lib/HTML/Lists.php';
$lists = new Lists;

// Get Input data from query string
$page       = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
$order_by   = filter_input(INPUT_GET, 'order_by', FILTER_SANITIZE_STRING);
$order_dir  = filter_input(INPUT_GET, 'order_dir', FILTER_SANITIZE_STRING);
$search_str = filter_input(INPUT_GET, 'search_str', FILTER_SANITIZE_STRING);

// If filter inputs are not selected we show latest created data first
if (!$page) $page = 1;
if (!$order_by) $order_by = $obj->alias . '.id';
if (!$order_dir) $order_dir = 'DESC';

$pages = $obj->getPaginatedList($page, $order_by, $order_dir, $search_str);
$rows = $pages[0];
$total_pages = $pages[1];

$actions = json_decode($auth->authorization($_SESSION['id_user'], $_SESSION['id_group']));

// CustomersView class
require_once BASE_PATH . '/customers/views/customersView.php';
