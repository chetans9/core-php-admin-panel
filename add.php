<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/database.php';

$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING); 
($operation == 'edit') ? $edit = true : $edit = false;

if($edit)
{
    $db->where('id', $customer_id);
    $result = $db->get("customers");
    foreach ($result as $row) {}
}
//serve POST method, create operation
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);
    $id = $db->insert ('customers', $data_to_store);
    $stat = ($id)? TRUE :FALSE;
   
}

require_once 'includes/header.php'; 
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Customers</h2>
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
    <form class="form" action=" " method="post"  id="customer_form" enctype="multipart/form-data">
       <?php  include_once('./includes/forms/customer_form.php'); ?>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#customer_form").validate({
       rules: {
            f_name: {
                required: true,
                minlength: 3
            },
            l_name: {
                required: true,
                minlength: 3
            },
            
        }
       
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>