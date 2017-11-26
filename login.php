<?php
session_start();
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location:index.php');
}

require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $passwd = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_STRING);
    $passwd=  md5($passwd);
   
    $query = "SELECT * FROM admin_accounts WHERE user_name='$username' AND passwd='$passwd'";
    $row = $db->query($query);
     
    if (count($row) >= 1) {
        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['admin_type'] = $row[0]['admin_type'];
        $sess_id = session_id();
        header('Location:index.php');
    } else {
        $errmsg = TRUE;
    }
  
}

require_once 'includes/header.php';
?>
<div id="page-" class="col-md-4 col-md-offset-4">

    <form class="form loginform" method="POST">
        <div class="login-panel panel panel-default">
        <div class="panel-heading">Please Sign in</div>
            <div class="panel-body">
            <div class="form-group">
                <label class="control-label">username</label>
                <input type="text" name="username" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label class="control-label">password</label>
                <input type="password" name="passwd" class="form-control" required="required">
            </div>
            <?php
            if (isset($errmsg) && $errmsg = TRUE) {
                echo '<div class="alert alert-danger">Username or password incorrect</div>';
            }
            ?>
            <button type="submit" class="btn btn-success loginField" >Login</button>
            </div>
        </div>
    </form>

</div>
<?php require_once 'includes/footer.php'; ?>