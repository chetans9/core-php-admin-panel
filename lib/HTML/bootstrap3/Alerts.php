<?php
class Alerts
{
    public function __construct()
    {
        
    }

    public function __destruct()
    {
        
    }

    /**
     *  $session    string
     *  $type       string  success|info|warning|danger
     *  $heading    string
     */
    public function alerts($session, $type, $heading = '')
    {
        if (isset($_SESSION[$session])):
        ?>
        <div class="alert alert-<?php echo $type; ?> alert-dismissable fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php if ($heading): ?>
            <strong><?php echo $heading; ?></strong>
            <?php endif; ?>
            <?php echo $_SESSION[$session]; ?>
        </div>
        <?php
        //echo '<pre>';print_r($_SESSION);echo '</pre>';
        //unset($_SESSION[$session]);
        endif;
    }
}
?>
