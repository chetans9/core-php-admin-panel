<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page
if ($_SESSION['admin_type'] !== 'super') {
    // show permission denied message
    echo 'Permission Denied';
    exit();
}
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input post if we want
    extract(filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING));
    $passwd=md5($passwd);

    $data_to_store = array(
        'user_name' => $user_name,
        'passwd'=>$passwd,
        'admin_type'=>$admin_type
    );
    $id = $db->insert ('admin_accounts', $data_to_store);
    if($id){
        $stat=TRUE;
        
    }
    else{
        $stat=FALSE;
    }
    
}


require_once 'includes/header.php';
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add User</h2>
        </div>
        
</div>
    
    <!-- Success message -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($stat) {
        echo '<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Form saved successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Failed to add</div>';
    }
}
?>
    <form class="well form-horizontal" action=" " method="post"  id="contact_form" enctype="multipart/form-data">
        <?php include_once './includes/forms/admin_users_form.php'; ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>