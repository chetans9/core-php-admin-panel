<?php
class Users
{
    /**
     *
     */
    public function __construct()
    {
        // Only super admin is allowed to access this page
        if ($_SESSION['admin_type'] !== 'super')
        {
            // Show permission denied message
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit('401 Unauthorized');
        }
    }

    /**
     *
     */
    public function __destruct()
    {
    }
    
    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'user_name' => 'Username',
            'admin_type' => 'Admin Type'
        ];

        return $ordering;
    }
}
?>
