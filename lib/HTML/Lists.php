<?php
class Lists
{
    public function deleteModal($id)
    {
        ?>
        <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $id; ?>"><i class="glyphicon glyphicon-trash"></i></a>
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="confirm-delete-<?php echo $id; ?>" role="dialog">
            <div class="modal-dialog">
                <form action="" method="POST">
                    <!-- Modal content -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Confirm</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="del_id" id="del_id" value="<?php echo $id; ?>">
                            <p>Are you sure you want to delete the #<?php echo $id?> row?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-default pull-left">Yes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- //Delete Confirmation Modal -->
        <?php
    }

    public function paginationLinks($current_page, $total_pages, $base_url)
    {
        if ($total_pages <= 1) {
            return false;
        }

        $html = '';

        if (!empty($_GET)) {
            // We must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            // To keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }

        $html = '<ul class="pagination text-center">';

        if ($current_page == 1) {

            $html .= '<li class="disabled"><a>First</a></li>';
        } else {
            $html .= '<li><a href="' . $base_url . $http_query . '&page=1">First</a></li>';
        }

        // Show pagination links

        //var i = (Number(data.page) > 5 ? Number(data.page) - 4 : 1);

        if ($current_page > 5) {
            $i = $current_page - 4;
        } else {
            $i = 1;
        }

        for (; $i <= ($current_page + 4) && ($i <= $total_pages); $i++) {
            ($current_page == $i) ? $li_class = ' class="active"' : $li_class = '';

            $link = $base_url . $http_query;

            $html = $html . '<li' . $li_class . '><a href="' . $link . '&page=' . $i . '">' . $i . '</a></li>';

            if ($i == $current_page + 4 && $i < $total_pages) {

                $html = $html . '<li class="disabled"><a>...</a></li>';

            }

        }

        if ($current_page == $total_pages) {
            $html .= '<li class="disabled"><a>Last</a></li>';
        } else {

            $html .= '<li><a href="' . $base_url . $http_query . '&page=' . $total_pages . '">Last</a></li>';
        }

        $html = $html . '</ul>';

        return $html;
    }
}
