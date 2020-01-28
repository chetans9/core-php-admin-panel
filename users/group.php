<?php
require_once '../config/config.php';
// Auth class
require_once BASE_PATH . '/lib/System/Auth.php';
$auth = new Authentication;
// Groups class
require_once BASE_PATH . '/users/models/groupsModel.php';
$obj = new Groups;

// ID for which we are performing task
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$row = $obj->populateForm($id);

// GroupView class
require_once BASE_PATH . '/users/views/groupView.php';
