<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo (!$id) ? 'Create' : 'Update'; ?> <?php echo $obj->header['form']; ?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <form class="well form-horizontal" action="" method="post" id="<?php echo $obj->header['form']; ?>_form" enctype="multipart/form-data">
        <!-- Text input -->
        <div class="form-group">
            <label class="col-md-4 control-label">Username</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="username" placeholder="Username" class="form-control" required="" value="<?php echo $row['username']; ?>" autocomplete="off">
                </div>
            </div>
        </div>
        <!-- Password input -->
        <div class="form-group">
            <label class="col-md-4 control-label">Password</label>
            <div class="col-md-4 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="password" placeholder="Password" class="form-control" required="" autocomplete="off">
                </div>
            </div>
        </div>
        <!-- Radio checks -->
        <div class="form-group">
            <label class="col-md-4 control-label">User type</label>
            <div class="col-md-4">
                <div class="radio">
                    <label>
                        <input type="radio" name="id_group" value="1" required="" <?php echo ($row['id_group'] == 1) ? 'checked': '' ; ?>/> Superuser
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="id_group" value="2" required="" <?php echo ($row['id_group'] == 2) ? 'checked': '' ; ?>/> Admin
                    </label>
                </div>
            </div>
        </div>
        <!-- Admin type -->
        <input type="hidden" name="admin_type" id="admin_type" value="NULL">
        <!-- Submit button -->
        <div class="form-group">
            <label class="col-md-4 control-label"></label>
            <div class="col-md-4">
                <button type="submit" class="btn btn-warning">Save <i class="glyphicon glyphicon-send"></i></button>
            </div>
        </div>
	</form>
</div>
<?php include BASE_PATH . '/includes/footer.php'; ?>
