<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link  rel="stylesheet" href="css/bootstrap.min.css"/>
        <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>
        <link  rel="stylesheet" href="css/style.css"/> 
        <script src="js/jquery.min.js" type="text/javascript"></script> 
        <script src="js/bootstrap.min.js"></script>
        <title>Simple Admin</title>
    </head>
    <body>
        <?php
        //variables for active element class
        $adminusers_active = "";

        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $current_path = basename($uri_path);
        if ($current_path == 'index.php' || $current_path == '') {
            $home_active = 'class="active"';
        } else {
            $home_active = "";
        }
        if ($current_path == 'admin_users.php') {
            $adminusers_active = ' class="active"';
        }
        ?>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Admin Panel Demo</a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbarmain">

                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="mynavbarmain">
                    <ul class="nav navbar-nav">
                        <li <?= $home_active ?>><a href="index.php">Home</a></li>
                        <?php if (@$_SESSION['admin_type'] === 'super') { ?>
                            <li <?= $adminusers_active; ?>>
                                <a href="admin_users.php" title="About me">Admin users</a>
                            </li>

                            <?php
                        }
                        if ($current_path != 'login.php') {
                            ?>

                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">System</a> 
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="logout.php">Logout</a>      
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </nav>