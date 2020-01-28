<?php
//  CRUD class
require_once BASE_PATH . '/lib/CRUD/CRUD.php';

class Customers extends CRUD
{
    public $table = 'customers';
    public $alias = 'c';
    public $header = [
        'list' => 'customers',
        'form' => 'customer'
    ];

    /**
     *  Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'c.id' => 'ID',
            'c.f_name' => 'First Name',
            'c.l_name' => 'Last Name',
            'c.gender' => 'Gender',
            'c.phone' => 'Phone'
        ];

        return $ordering;
    }

    /**
     *
     */
    public function getPaginatedList($page = 1, $order_by = 'id', $order_dir = 'DESC', $search_str = '')
    {
        $db = getDbInstance();

		// Set pagination limit
		$page_limit = 15;
		$db->pageLimit = $page_limit;

        // Prepare query according to input parameters
		if ($search_str)
		{
			$db->where('f_name', '%' . $search_str . '%', 'LIKE');
            $db->orWhere('l_name', '%' . $search_str . '%', 'LIKE');
		}
        $db->orderBy($order_by, $order_dir);

		$cols = ['c.id id, c.f_name f_name, c.l_name l_name, c.gender gender, c.phone phone, c.created_by created_by'];

        // Get result of the query
		$rows = $db->arraybuilder()->paginate($this->table . ' ' . $this->alias, $page, $cols);
        $total_pages = $db->totalPages;
        $pages = [$rows, $total_pages];

        return $pages;
    }

}
