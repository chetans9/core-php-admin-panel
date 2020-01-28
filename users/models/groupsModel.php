<?php
//  CRUD class
require_once BASE_PATH . '/lib/CRUD/CRUD.php';

class Groups extends CRUD
{
    public $table = 'users_groups';
    public $alias = 'ug';
    public $header = [
        'list' => 'groups',
        'form' => 'group'
    ];

    /**
     *  Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'ug.id' => 'ID',
            'ug.name' => 'Name',
            'ug.type' => 'Type'
        ];

        return $ordering;
    }

    /**
     *
     */
    public $types = [
        0 => 'Guest',
        1 => 'Member',
        2 => 'Moderator',
        3 => 'Administrator'
    ];
	/**
     *
     */
    public $authorization = [
        'create' => 0,
        'update_own' => 0,
        'update_all' => 0,
        'trash_own' => 0,
        'trash_all' => 0,
        'delete' => 0,
        'ban_users' => 0,
        'hide_avatar' => 0
    ];

	/**
     *
     */
    public function __construct()
    {
        $id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $task   = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
        $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);

        // Only Superuser is allowed to access this page
        if ($_SESSION['id_group'] !== 1 && ($_SESSION['admin_type'] !== 'super' || $_SESSION['admin_type'] !== 'NULL'))
        {
            // Show permission denied message
            header('HTTP/1.1 401 Unauthorized', true, 401);
            exit('401 Unauthorized');
        }

        // Serve POST request
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
			if (!$id && $task == 'create')
            {
				// Sanitize input post if we want
				$store = filter_input_array(INPUT_POST);

				$this->create($id, $task, $store);
			}

			if ($id && $task == 'update')
            {
                // Sanitize input post if we want
                $store = filter_input_array(INPUT_POST);

				$this->update($id, $task, $store);
			}

			if ($del_id)
			{
				// TODO: Do not let delete default groups
				// Do not let Users delete thenselves
/*
                if ($del_id == $_SESSION['id_user'])
				{
					$_SESSION['danger'] = 'You can not delete yourself!';
					header('Location: ' . $this->header['list'] . '.php');
					exit;
				}
*/

				$this->delete($del_id);
            }
        }
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
			$db->where('name', '%' . $search_str . '%', 'LIKE');
            $db->orWhere('type', '%' . $search_str . '%', 'LIKE');
		}
        $db->orderBy($order_by, $order_dir);

		$cols = ['ug.id id, ug.name name, ug.type type, ug.actions actions, ug.created_by created_by'];

        // Get result of the query
		$rows = $db->arraybuilder()->paginate($this->table . ' ' . $this->alias, $page, $cols);
        $total_pages = $db->totalPages;
        $pages = [$rows, $total_pages];

        return $pages;
    }


    /**
     *
     */
    public function create($id, $task, $store)
    {
        // Insert actions into one variable
        $store['actions'] = '{"create":' . $store['create'] . ', "update_own":' . $store['update_own'] . ', "update_all":' . $store['update_all'] . ', "trash_own":' . $store['trash_own'] . ', "trash_all":' . $store['trash_all'] . ', "delete":' . $store['delete'] . ', "ban_users":' . $store['ban_users'] . ', "hide_avatar":' . $store['hide_avatar'] . '}';

        // Unset actions from its variables
        foreach (json_decode($store['actions']) as $key => $value):
            unset($store[$key]);
        endforeach;

        // Insert user and timestamp
		$store['created_by'] = $_SESSION['id_user'];
		$store['created_at'] = date('Y-m-d H:i:s');

        $db = getDbInstance();
        $status = $db
            ->insert($this->table, $store);

        if (!$status)
        {
			$_SESSION['danger'] = 'Failed to create row: ' . $db->getLastError();
			$query_string = http_build_query([
				'id' => $id,
				'task' => $task
			]);
			header('Location: ' . $this->header['form'] . '.php?' . $query_string);
			exit;
		}
		else
		{
			$_SESSION['success'] = 'Row created!';
			header('Location: ' . $this->header['list'] . '.php');
			exit;
		}
    }

	/**
	 *
	 */
	public function update($id, $task, $store)
	{
        // Insert actions into one variable
        $store['actions'] = '{"create":' . $store['create'] . ', "update_own":' . $store['update_own'] . ', "update_all":' . $store['update_all'] . ', "trash_own":' . $store['trash_own'] . ', "trash_all":' . $store['trash_all'] . ', "delete":' . $store['delete'] . ', "ban_users":' . $store['ban_users'] . ', "hide_avatar":' . $store['hide_avatar'] . '}';

        // Unset actions from its variables
        foreach (json_decode($store['actions']) as $key => $value):
            unset($store[$key]);
        endforeach;

        // Insert user and timestamp
		$store['updated_by'] = $_SESSION['id_user'];
		$store['updated_at'] = date('Y-m-d H:i:s');

		$db = getDbInstance();
		$status = $db
            ->where('id', $id)
		    ->update($this->table, $store);

        if (!$status)
        {
			$_SESSION['danger'] = 'Failed to update row: ' . $db->getLastError();
			$query_string = http_build_query([
				'id' => $id,
				'task' => $task
			]);
			header('Location: ' . $this->header['form'] . '.php?' . $query_string);
			exit;
		}
		else
		{
			$_SESSION['success'] = 'Row updated!';
			header('Location: ' . $this->header['list'] . '.php');
			exit;
		}
	}

}
