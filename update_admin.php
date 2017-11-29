<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


$admin_user_id=  filter_input(INPUT_GET, 'admin_user_id');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If non-super user accesses this script via url. Stop the exexution
    if($_SESSION['admin_type']!=='super'){
        // show permission denied message
        echo 'Permission Denied';
        exit();
    }
    
    // Sanitize input post if we want
    extract(filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING));
    $passwd=md5($passwd);
    $data_to_update = array(
        'user_name' => $user_name,
        'passwd'=>$passwd,
        'admin_type'=>$admin_type
    );
    $db->where('id',$admin_user_id);
    $id = $db->update ('admin_accounts', $data_to_update);
    if($id){
        $stat=TRUE;
        
    }
    else{
        $stat=FALSE;
    }
    
}

//Select where clause
$db->where('id', $admin_user_id);
$result = $db->get("admin_accounts");

// Set values to $row
foreach ($result as $row) {}
// import header
require_once 'includes/header.php';
?>
<div id="page-wrapper">

    <div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Update User</h2>
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
        <fieldset>
            <!-- Form Name -->
            <legend>Add new admin user</legend>
              <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">User name</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  type="text" name="user_name" placeholder="user name" class="form-control" value="<?php echo "$row[user_name]";  ?>"
                    </div>
                </div>
            </div>
              </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label" >Password</label> 
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="password" name="passwd" placeholder="passwaord" class="form-control" required="">
                    </div>
                </div>
            </div>
            <!-- radio checks -->
            <div class="form-group">
                <label class="col-md-4 control-label">User type</label>
                <?php ($row['admin_type']==='super')?$super_checked=" checked": $super_checked="";
                ($row['admin_type']==='admin')?$admin_checked=" checked": $admin_checked="";
                
                ?>
                <div class="col-md-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="super" required="" <?php echo $super_checked; ?>/> Super admin
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="admin" required="" <?php echo $admin_checked; ?>/> Admin
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