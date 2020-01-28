<?php
require_once 'config/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$username = filter_input(INPUT_POST, 'username');
	$password = filter_input(INPUT_POST, 'password');
	$remember = filter_input(INPUT_POST, 'remember');

	// Get DB instance
	$db = getDbInstance();

	$db->where('username', $username);
	$row = $db->getOne('users_accounts');

	if ($db->count >= 1)
    {
		$db_password = $row['password'];
		$id_user = $row['id'];

		if (password_verify($password, $db_password))
        {
			$_SESSION['user_logged_in'] = TRUE;
            $_SESSION['id_group'] = $row['id_group'];
            $_SESSION['id_user'] = $row['id'];

			if ($remember)
            {
				$series_id = randomString(16);
				$remember_token = getSecureRandomToken(20);
				$encryted_remember_token = password_hash($remember_token, PASSWORD_DEFAULT);

				$expiry_time = date('Y-m-d H:i:s', strtotime(' + 30 days'));
				$expires = strtotime($expiry_time);

				setcookie('series_id', $series_id, $expires, '/');
				setcookie('remember_token', $remember_token, $expires, '/');

				$db = getDbInstance();
				$db->where ('id', $id_user);

				$update_remember = array(
					'series_id'=> $series_id,
					'remember_token' => $encryted_remember_token,
					'expires' =>$expiry_time
				);
				$db->update('users_accounts', $update_remember);
			}
			// Authentication successfull redirect user
			header('Location: index.php');
		}
        else
        {
			$_SESSION['danger'] = 'Invalid username or password';
			header('Location: login.php');
		}
		exit;
	}
    else
    {
		$_SESSION['danger'] = 'Invalid username or password';
		header('Location: login.php');
		exit;
	}
}
else
{
	die('Method not allowed');
}
