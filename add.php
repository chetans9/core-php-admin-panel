<?php
session_start();
require_once 'includes/header.php';
require_once 'includes/database.php';

// avoid user arriving to this page without logging in
if(!isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']!=TRUE )
{
header('Location:login.php');

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input post if we want
    extract(filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING));

    $data_to_store = array(
        'f_name' => $f_name,
        'l_name' => $l_name,
        'gender' => $gender,
        'address' => $address,
        'phone' => $phone,
        'state'=>$state,
        'email' => $email,
        'date_of_birth'=>$date_of_birth
    );
    $id = $db->insert ('customers', $data_to_store);
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
        <a href="index.php">List view</a> >
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
            <legend>Add new student</legend>
              <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">First Name</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  name="f_name" placeholder="First Name" class="form-control"  type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label" >Last Name</label> 
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="l_name" placeholder="Last Name" class="form-control"  type="text">
                    </div>
                </div>
            </div>
            <!-- radio checks -->
            <div class="form-group">
                <label class="col-md-4 control-label">Gender</label>
                <div class="col-md-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" value="male" required=""/> Male
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" value="female" required=""/> Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Address</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="address" placeholder="Address" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Phone </label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="phone" placeholder="(845)555-1212" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group"> 
                <label class="col-md-4 control-label">State</label>
                <div class="col-md-4 selectContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <?php $opt_arr = array("Maharashtra", "Kerala", "Madhya pradesh"); 
                            ?>
                        <select name="state" class="form-control selectpicker" required>
                            <option value=" " >Please select your state</option>
                            <?php
                            foreach ($opt_arr as $opt) {
                                echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Email</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label">Date of Birth</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input name="date_of_birth" placeholder="Birth date" class="form-control"  type="date">
                    </div>
                </div>
            </div>
            



            <!-- Select Basic -->





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