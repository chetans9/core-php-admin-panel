<?php include BASE_PATH . '/includes/header.php'; ?>
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header"><?php echo ucfirst($obj->header['list']); ?></h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <?php if ($actions->create): ?>
                <a href="<?php echo $obj->header['form']; ?>.php?id=0&task=create" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Add new</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php'; ?>
    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_str" value="<?php echo htmlspecialchars($search_str, ENT_QUOTES, 'UTF-8'); ?>">
            <label for="input_order">Order By</label>
            <select name="order_by" class="form-control">
                <?php
foreach ($obj->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_dir" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_dir == 'ASC') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_dir == 'DESC') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->

    <!-- Table -->
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="45%">Name</th>
                <th width="20%">Gender</th>
                <th width="20%">Phone</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['f_name'] . ' ' . $row['l_name']); ?></td>
                <td><?php echo htmlspecialchars($row['gender']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td>
                    <?php if ($actions->update_all || ($actions->update_own && $_SESSION['id_user'] == $row['created_by'])): ?>
                    <a href="<?php echo $obj->header['form']; ?>.php?id=<?php echo $row['id']; ?>&task=update" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <?php endif; ?>
                    <?php if ($actions->trash_all || ($actions->trash_own && $_SESSION['id_user'] == $row['created_by'])): ?>
                    <?php $lists->deleteModal($row['id']); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    	<?php $lists->paginationLinks($page, $total_pages, $obj->header['list'] . '.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php'; ?>
