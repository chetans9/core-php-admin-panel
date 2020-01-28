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
     *  $type       string  primary|secondary|success|danger|warning|info|light|dark
     *  $heading    string
     */
    public function alerts($session, $type, $heading = '')
    {
        if (isset($_SESSION[$session])):
        ?>
        <div class="alert alert-<?php echo $type; ?> alert-dismissable fade show" role="alert">
            <?php if ($heading): ?>
            <h4 class="alert-heading"><?php echo $heading; ?></h4>
            <?php endif; ?>
            <?php echo $_SESSION[$session]; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        //echo '<pre>';print_r($_SESSION);echo '</pre>';
        //unset($_SESSION[$session]);
        endif;
    }
}
?>
