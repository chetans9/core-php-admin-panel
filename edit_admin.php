<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//User ID for which we are performing operation
$admin_user_id = filter_input(INPUT_GET, 'admin_user_id');
$operation = filter_input(INPUT_GET, 'operation', FILTER_SANITIZE_STRING);
($operation == 'edit') ? $edit = true : $edit = false;
//Serve POST request.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// If non-super user accesses this script via url. Stop the exexution
	if ($_SESSION['admin_type'] !== 'super') {
		// show permission denied message
		echo 'Permission Denied';
		exit();
	}

	// Sanitize input post if we want
	$data_to_update = filter_input_array(INPUT_POST);
	//Check whether the user name already exists ;
	$db = getDbInstance();
	$db->where('user_name', $data_to_update['user_name']);
	$db->where('id', $admin_user_id, '!=');
	//print_r($data_to_update['user_name']);die();
	$row = $db->getOne('admin_accounts');
	//print_r($data_to_update['user_name']);
	//print_r($row); die();

	if (!empty($row['user_name'])) {

		$_SESSION['failure'] = "User name already exists";

		$query_string = http_build_query(array(
			'admin_user_id' => $admin_user_id,
			'operation' => $operation,
		));
		header('location: edit_admin.php?'.$query_string );
		exit;
	}

	$admin_user_id = filter_input(INPUT_GET, 'admin_user_id', FILTER_VALIDATE_INT);
	//Encrypting the password
	$data_to_update['password'] = password_hash($data_to_update['password'], PASSWORD_DEFAULT);

	$db = getDbInstance();
	$db->where('id', $admin_user_id);
	$stat = $db->update('admin_accounts', $data_to_update);

	if ($stat) {
		$_SESSION['success'] = "Admin user has been updated successfully";
	} else {
		$_SESSION['failure'] = "Failed to update Admin user : " . $db->getLastError();
	}

	header('location: admin_users.php');
	exit;

}

//Select where clause
$db = getDbInstance();
$db->where('id', $admin_user_id);

$admin_account = $db->getOne("admin_accounts");

// Set values to $row

// import header
require_once 'includes/header.php';
?>
<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Update User</h2>
        </div>

    </div>
    <?php include_once 'includes/flash_messages.php';?>
    <form class="well form-horizontal" action="" method="post"  id="contact_form" enctype="multipart/form-data">
        <?php include_once './forms/admin_users_form.php';?>
    </form>
</div>




<?php include_once 'includes/footer.php';?>