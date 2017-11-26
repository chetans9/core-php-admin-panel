<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/database.php';


//Get data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$del_id = filter_input(INPUT_GET, 'del_customer_id');

$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$page = filter_input(INPUT_GET, 'page');
$pagelimit = 20;
if ($page == "") {
    $page = 1;
}
// If filter types are not selected we show latest added data first
if ($filter_col == "") {
    $filter_col = "id";
}
if ($order_by == "") {
    $order_by = "desc";
}


// Delete a user using user_id
if ($del_id && $_SESSION['admin_type']==='super') {
    $customer_id = filter_var($_GET['del_customer_id'], FILTER_SANITIZE_NUMBER_INT);
    $db->where('id', $customer_id);
    $stat = $db->delete('customers');
    
    if ($stat) {
        $del_stat = TRUE;
    }
    
}
// select the columns
$select = array('id', 'f_name', 'l_name', 'gender', 'phone');

// If user searches 
if ($search_string) {
    $db->where('f_name', '%' . $search_string . '%', 'like');
    $db->orwhere('l_name', '%' . $search_string . '%', 'like');
}


if ($order_by) {

    $db->orderBy($filter_col, $order_by);
}

$db->pageLimit = $pagelimit;
$result = $db->arraybuilder()->paginate("customers", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($result as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <?php
    if (isset($del_stat) && $del_stat == 1) {
        echo '<div class="alert alert-info">Successfully deleted</div>';
    }
    ?>
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Customers</h1>
        </div>
        <div class="col-lg-6" style="">
            <div class="page-action-links text-right">
            <a href="add.php?operation=create"> <button class="btn btn-success">Add new</button></a>
            </div>
        </div>
    </div>
    <!--    Begin filter section-->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" id="input_search" name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col">

                <?php
                foreach ($filter_options as $option) {
                    ($filter_col === $option) ? $selected = "selected" : $selected = "";
                    echo ' <option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
                }
                ?>

            </select>

            <select name="order_by" class="" id="input_order">

                <option value="Asc" <?php
                if ($order_by == 'Asc') {
                    echo "selected";
                }
                ?> >Asc</option>
                <option value="Desc" <?php
                if ($order_by == 'Desc') {
                    echo "selected";
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">

        </form>
    </div>
<!--   Filter section end-->

    <hr>


    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th class="header">#</th>
                <th>Name</th>
                <th>Gender</th>
                <th>phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result as $row) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['f_name'] . " " . $row['l_name'] . '</td>';
                echo '<td>' . $row['gender'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
                echo '<td><a href="update.php?customer_id=' . $row['id'] . '&operation=edit" class="btn btn-primary" style="margin-right: 8px;"><span class="glyphicon glyphicon-edit"></span>';
                if($_SESSION['admin_type']=='super'){
                echo '<a href="customers.php?del_customer_id=' . $row['id'] . '" class="btn btn-danger delete_btn" style="margin-right: 8px;"><span class="glyphicon glyphicon-trash"></span></td>';
                
                }
                echo '</tr>';
            }
            ?>      
        </tbody>
    </table>
<!--    Pagination links-->
    <div class="text-center">

        <?php
        if (!empty($_GET)) {
            //we must unset $_GET[page] if built by http_build_query function
            unset($_GET['page']);
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="customers.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>

</div>
<!--Main container end-->


<?php include_once './includes/footer.php'; ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('.delete_btn').click(function () {
            var r = confirm("Are you sure?")
            if (r == true) {
                return true;
            } else {
                return false;
            }
        });
    });
</script> 