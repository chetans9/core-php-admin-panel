<?php
session_start();
require_once 'includes/header.php';
require_once 'includes/database.php';

// avoid user arriving to this page without logging in
if(!isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']!=TRUE )
{
header('Location:login.php');

}
//Only super admin is allowed to access this page
if ($_SESSION['admin_type'] !== 'super') {
    // show permission denied message
    echo 'Permission Denied';
    exit();
}

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
?>
<div class="container">

    <ul class="breadcrumb">
        <a href="admin_users.php">List view</a> >
        <a href="">add</a>

    </ul>
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
        <fieldset>
            <!-- Form Name -->
            <legend>Add new admin user</legend>
              <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">User name</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  type="text" name="user_name" placeholder="First Name" class="form-control"  >
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label" >Password</label> 
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="password" name="passwd" placeholder="Last Name" class="form-control" >
                    </div>
                </div>
            </div>
            <!-- radio checks -->
            <div class="form-group">
                <label class="col-md-4 control-label">User type</label>
                <div class="col-md-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="super" required=""/> Super admin
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="admin" required=""/> Admin
                        </label>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>

        </fieldset>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>