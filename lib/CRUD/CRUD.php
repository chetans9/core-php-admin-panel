<?php
abstract class CRUD
{
    public $table = '';
    public $alias = '';
    public $header = [
        'list' => '',
        'form' => ''
    ];

    /**
     *
     */
    public function __construct()
    {
        $id     = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $task   = filter_input(INPUT_GET, 'task', FILTER_SANITIZE_STRING);
        $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);

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
				// Only Superuser is allowed to delete
                if ($_SESSION['id_group'] !== 1 && ($_SESSION['admin_type'] !== 'super' || $_SESSION['admin_type'] !== 'NULL'))
				{
					$_SESSION['danger'] = 'You don\'t have permission to perform this action';
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
    public function __destruct()
    {

    }

    /**
     *
     */
    public function getTotal()
    {
        $db = getDbInstance();
        $total = $db
            ->getValue($this->table, 'count(*)');

        return $total;
    }

    /**
     *  Get data to populate the form
     */
    public function populateForm($id)
	{
		$db = getDbInstance();
		$fields = $db
		    ->where('id', $id)
		    ->getOne($this->table);

		if (!$db->count)
		{
			return;
		}
		else
		{
			return $fields;
		}
    }

    /**
     *
     */
    public function create($id, $task, $store)
    {
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

	/**
	 *
	 */
	public function delete($id)
	{
		$db = getDbInstance();
		$status = $db
		    ->where('id', $id)
		    ->delete($this->table);

		if (!$status)
		{
			$_SESSION['danger'] = 'Failed to delete row: ' . $db->getLastError();
		}
		else
		{
			$_SESSION['success'] = 'Row deleted!';
		}

		header('Location: ' . $this->header['list'] . '.php');
		exit;
	}

}
