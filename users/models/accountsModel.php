<?php
//  CRUD class
require_once BASE_PATH . '/lib/CRUD/CRUD.php';

class Accounts extends CRUD
{
    public $table = 'users_accounts';
    public $alias = 'ua';
    public $header = [
        'list' => 'accounts',
        'form' => 'account'
    ];

    /**
     *  Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'ua.id' => 'ID',
            'ua.username' => 'Username',
            'ug.name' => 'Usergroup'
        ];

        return $ordering;
    }

    /**
     *
     */
    public function __construct()
    {
        $id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $task   = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
        $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);

        // TODO: Let Users update themselves
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

				if ($this->checkUsername($id, $task, $store['username']))
				{
					$this->create($id, $task, $store);
				}
            }

			if ($id && $task == 'update')
            {
                // Sanitize input post if we want
                $store = filter_input_array(INPUT_POST);

				if ($this->checkUsername($id, $task, $store['username']))
				{
					$this->update($id, $task, $store);
				}
			}

			if ($del_id)
			{
				// TODO: Do not let delete Supersusers
				// Do not let Users delete thenselves
                if ($del_id == $_SESSION['id_user'])
				{
					$_SESSION['danger'] = 'You can not delete yourself!';
					header('Location: ' . $this->header['list'] . '.php');
					exit;
				}

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
			$db->where('username', '%' . $search_str . '%', 'LIKE');
		}
        $db->orderBy($order_by, $order_dir);

		$cols = ['ua.id id, ua.username username, ua.created_by created_by, ug.name usergroup'];

        // Get result of the query
		$db->join('users_groups ug', 'ug.id = ua.id_group', 'LEFT');
		$rows = $db->arraybuilder()->paginate($this->table . ' ' . $this->alias, $page, $cols);
        $total_pages = $db->totalPages;
        $pages = [$rows, $total_pages];

        return $pages;
    }

    /**
     *  Checks whether an username already exists
     */
    public function checkUsername($id, $task, $username)
    {
        $db = getDbInstance();
        $db->where('username', $username);

        if ($task == 'create')
        {
            $row = $db
                ->get($this->table);
        }
        else
        {
            $row = $db
                ->where('id', $id, '!=')
                ->getOne($this->table);
        }

        if (!empty($row['username']) || $db->count)
        {
            $_SESSION['danger'] = 'This Username already exists!';
            $query_string = http_build_query([
                'id' => $id,
                'task' => $task
            ]);

            header('Location: ' . $this->header['form'] . '.php?' . $query_string);
            exit;
        }

		return true;
    }

    /**
     *
     */
    public function create($id, $task, $store)
    {
        // Insert encrypt password and timestamp
        $store['password'] = password_hash($store['password'], PASSWORD_DEFAULT);
        $store['regtime'] = date('Y-m-d H:i:s');

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
        // Insert encrypt password
        $store['password'] = password_hash($store['password'], PASSWORD_DEFAULT);

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
