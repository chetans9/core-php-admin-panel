<?php
class Authentication
{
    public function __construct()
    {
        session_start();

        // If User is not logged in, redirect to login page
        if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in'])
        {
            global $base_url;
            header('Location: ' . $base_url . '/login.php');
            exit;
        }
    }

    public function authorization($id_user, $id_group)
    {
        $db = getDBInstance();

        $row = $db
            ->join('users_groups ug', 'ug.id = ua.id_group', 'LEFT')
            ->where('ua.id', $id_user)
            ->where('ua.id_group', $id_group)
            ->getValue('users_accounts ua', 'actions')
            ;

        return $row;
    }

}
