<?php
echo 'Updating... Please, wait<br /><br />';
$db = getDbInstance();

// Rename admin_accounts to users_accounts
if ($db->tableExists('admin_accounts'))
{
    echo 'Updating table admin_accounts<br />';
    $admin_accounts = $db->rawQuery('ALTER TABLE admin_accounts RENAME TO users_accounts;');
    if ($db->getLastErrno() === 0)
        echo 'Update succesfull<br />';
    else
        echo 'Update failed. Error: '. $db->getLastError();
    echo '<br />';
}

if ($db->tableExists('users_accounts'))
{
    echo 'Table users_accounts ok!<br /><br />';

    // Change user_name to username
    $user_name = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'user_name\'');
    $username = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'username\'');
    if ($user_name && !$username)
    {
        echo 'Updating field user_name<br />';
        $username = $db->rawQuery('ALTER TABLE `users_accounts` CHANGE `user_name` `username` VARCHAR(63) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;');
        if ($db->getLastErrno() === 0)
            echo '"username" field update succesfull<br />';
        else
            echo 'Update failed. Error: '. $db->getLastError();
        echo '<br />';
    }

    // Change passwd to password
    $passwd = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'passwd\'');
    $password = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'password\'');
    if ($passwd && !$password)
    {
        echo 'Updating table passwd<br />';
        $password = $db->rawQuery('ALTER TABLE `users_accounts` CHANGE `passwd` `password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;');
        if ($db->getLastErrno() === 0)
            echo '"password" field update succesfull<br />';
        else
            echo 'Update failed. Error: '. $db->getLastError();
        echo '<br />';
    }

    // Add id_group
    $id_group = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'id_group\'');
    if (!$id_group)
    {
        echo 'Creating field id_group<br />';
        $id_group = $db->rawQuery('ALTER TABLE `users_accounts` ADD `id_group` INT(11) UNSIGNED NOT NULL DEFAULT 0;');
        if ($db->getLastErrno() === 0)
            echo '"id_group" field update succesfull<br />';
        else
            echo 'Update failed. Error: '. $db->getLastError();
        echo '<br />';
    }

    // Add regtime
    $regtime = $db->rawQuery('SHOW COLUMNS FROM `users_accounts` LIKE \'regtime\'');
    if (!$regtime)
    {
        echo 'Creating field regtime<br />';
        $regtime = $db->rawQuery('ALTER TABLE `users_accounts` ADD `regtime` TIMESTAMP NULL DEFAULT NULL AFTER `id_group`;');
        if ($db->getLastErrno() === 0)
            echo '"regtime" field create succesfull<br />';
        else
            echo 'Update failed. Error: '. $db->getLastError();
        echo '<br />';
    }
}
