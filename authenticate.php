<?php
require_once './config/config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = filter_input(INPUT_POST, 'username');
	$passwd = filter_input(INPUT_POST, 'passwd');
	$remember = filter_input(INPUT_POST, 'remember');

	//echo password_verify('admin', '$2y$10$RnDwpen5c8.gtZLaxHEHDOKWY77t/20A4RRkWBsjlPuu7Wmy0HyBu'); exit;

	//Get DB instance.
	$db = getDbInstance();

	$db->where("user_name", $username);

	$row = $db->get('admin_accounts');

	if ($db->count >= 1) {

		$db_password = $row[0]['password'];
		$user_id = $row[0]['id'];

		if (password_verify($passwd, $db_password)) {

			$_SESSION['user_logged_in'] = TRUE;
			$_SESSION['admin_type'] = $row[0]['admin_type'];

			if ($remember) {

				$series_id = randomString(16);
				$remember_token = getSecureRandomToken(20);
				$encryted_remember_token = password_hash($remember_token,PASSWORD_DEFAULT);
				

				$expiry_time = date('Y-m-d H:i:s', strtotime(' + 30 days'));

				$expires = strtotime($expiry_time);
				
				setcookie('series_id', $series_id, $expires, "/");
				setcookie('remember_token', $remember_token, $expires, "/");

				$db = getDbInstance();
				$db->where ('id',$user_id);

				$update_remember = array(
					'series_id'=> $series_id,
					'remember_token' => $encryted_remember_token,
					'expires' =>$expiry_time
				);
				$db->update("admin_accounts", $update_remember);
			}
			//Authentication successfull redirect user
			header('Location:index.php');

		} else {
		
			$_SESSION['login_failure'] = "Invalid user name or password";
			header('Location:login.php');
		}

		exit;
	} else {
		$_SESSION['login_failure'] = "Invalid user name or password";
		header('Location:login.php');
		exit;
	}

}
else {
	die('Method Not allowed');
}