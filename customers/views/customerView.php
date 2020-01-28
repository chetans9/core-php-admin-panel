<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo (!$id) ? 'Create' : 'Edit'; ?> <?php echo ucfirst($obj->header['form']); ?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="<?php echo $obj->header['list']; ?>_form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="f_name">First Name *</label>
            <input type="text" name="f_name" value="<?php echo htmlspecialchars($row['f_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="First Name" class="form-control" required="required" id = "f_name">
        </div>
        <div class="form-group">
            <label for="l_name">Last name *</label>
            <input type="text" name="l_name" value="<?php echo htmlspecialchars($row['l_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Last Name" class="form-control" required="required" id="l_name">
        </div>
        <div class="form-group">
            <label>Gender *</label>
            <label class="radio-inline">
                <input type="radio" name="gender" id="male" value="male" <?php echo ($row['gender'] =='male') ? 'checked': '' ; ?> required="required" /> Male
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" id="female" value="female" <?php echo ($row['gender'] =='female')? 'checked': '' ; ?> required="required"/> Female
            </label>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
              <textarea name="address" placeholder="Address" class="form-control" id="address"><?php echo htmlspecialchars($row['address'], ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="form-group">
            <label>State *</label>
            <?php $opt_arr = array('Maharashtra', 'Kerala', 'Madhya pradesh'); ?>
            <select name="state" class="form-control selectpicker" required>
                <option value="">Please select your state</option>
                <?php
                foreach ($opt_arr as $opt) {
                    if ($edit && $opt == $row['state']) {
                        $sel = 'selected';
                    } else {
                        $sel = '';
                    }
                    echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="E-Mail Address" class="form-control" id="email">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input name="phone" value="<?php echo htmlspecialchars($row['phone'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="987654321" class="form-control"  type="text" id="phone">
        </div>
        <div class="form-group">
            <label>Date of birth *</label>
            <input name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" placeholder="Birth date" class="form-control" type="date" required="required">
        </div>
        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning" >Save <i class="glyphicon glyphicon-send"></i></button>
        </div>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function(){
   $('#<?php echo $obj->header['form']; ?>_form').validate({
       rules: {
            f_name: {
                required: true,
                minlength: 3
            },
            l_name: {
                required: true,
                minlength: 3
            },   
        }
    });
});
</script>
<?php include BASE_PATH . '/includes/footer.php'; ?>
