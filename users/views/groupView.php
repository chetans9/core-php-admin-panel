<?php include BASE_PATH . '/includes/header.php'; ?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header"><?php echo (!$id) ? 'Create' : 'Update'; ?> <?php echo $obj->header['form']; ?></h2>
        </div>
    </div>
    <!-- Flash messages -->
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <form class="form" action="" method="post" id="<?php echo $obj->header['form']; ?>_form" enctype="multipart/form-data">
        <!-- Group name -->
        <div class="form-group">
            <label for="f_name">Name *</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="Name" required="required">
        </div>
        <!-- Group type -->
        <div class="form-group">
            <label>Type *</label>
            <select name="type" class="form-control selectpicker" required>
                <option value="">Please select the group type</option>
                <?php foreach ($obj->types as $key => $value): ?>
                <option value="<?php echo $key; ?>"<?php if ($key == $row['type']) echo 'selected'; ?>><?php echo $value; ?></option>';
                <?php endforeach; ?>
            </select>
        </div>
        <!-- Priority -->
        <input type="hidden" name="priority" id="priority" value="1">
        <!-- Permissions -->
        <div class="form-group">
            <label>Permissions</label>
            <?php
            $values = array(1 => 'yes', 0 => 'no');
            if (!$id):
                $json = $obj->authorization;
            else:
                $db = getDbInstance();
                $default = $db
                    ->where('id', $id)
                    ->getValue($obj->table, 'actions');
                $json = json_decode($default, true);
            endif;
            ?>
            <div class="row">
                <?php foreach ($json as $index => $checked): ?>
                <?php $n = mt_rand(0, 99); ?>
                <div class="col-lg-3">
                    <div class="form-group well">
                        <div class="form-label"><?php echo ucfirst(str_replace('_', ' ', $index)); ?></div>
                        <?php foreach ($values as $key => $value): ?>
                        <input type="radio" name="<?php echo $index; ?>" id="<?php echo $value.$n; ?>" value="<?php echo $key; ?>"<?php if ($key == $checked) echo ' checked="checked"'; ?> />
                        <label for="<?php echo $value.$n; ?>"><?php echo ucfirst($value); ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning">Save <i class="glyphicon glyphicon-send"></i></button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#<?php echo $obj->header['form']; ?>_form').validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                }
            }
        });
    });
</script>
<?php include BASE_PATH . '/includes/footer.php'; ?>
