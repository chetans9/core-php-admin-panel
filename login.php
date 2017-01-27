<?php
session_start();

require_once 'includes/database.php';

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location:index.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $passwd = filter_input(INPUT_POST, 'passwd', FILTER_SANITIZE_STRING);
    $passwd=  md5($passwd);
   
    $query = "SELECT * FROM accounts WHERE user_name='$username' AND passwd='$passwd'";
    $row = $db->query($query);
   
    if (count($row) >= 1) {
        $_SESSION['user_logged_in'] = TRUE;
        $sess_id = session_id();
        header('Location:index.php');
    } else {
        $errmsg = TRUE;
    }
  
}

require_once 'includes/header.php';
?>
<div class="container">
    <form class="form loginform" method="POST">
        <div class="well login-wrapper">
            <div class="input-group loginField">
                <label class="control-label">username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="input-group loginField">
                <label class="control-label">password</label>
                <input type="password" name="passwd" class="form-control">
            </div>
            <?php
            if (isset($errmsg) && $errmsg = TRUE) {
                echo '<div class="alert alert-danger">Username or password incorrect</div>';
            }
            ?>
            <button type="submit" class="btn btn-success loginField" >Login</button>
        </div>
    </form>

</div>
<?php require_once 'includes/footer.php'; ?>