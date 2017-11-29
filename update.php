<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'customer_id', FILTER_VALIDATE_INT);
$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;

//Handle update request 
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
   
    $data_to_update = filter_input_array(INPUT_POST);
    $db->where('id',$customer_id);
    $stat = $db->update('customers', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Customer updated successfully!";
        header('location: customers.php');
        exit();
    }
}

if($edit)
{
    $db->where('id', $customer_id);
    $result = $db->get("customers");
    foreach ($result as $row) {}
}

require_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
    <h2 class="page-header">Update Customer</h2>
    	
    </div>
    <!-- Success message -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($stat == TRUE) {
            echo '<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Information updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Failed to update</div>';
        }
    }
    ?>
    <form class="" action=" " method="post" enctype="multipart/form-data" id="contact_form">
        <?php  include_once('./includes/forms/customer_form.php'); ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>