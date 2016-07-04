<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

namespace AkoSoft\Updates;

class Database {

	/**
	 * @var mysqli
	 */
	protected $db;

	public function __construct()
	{
		$db_config = include DOCROOT.'private/application/config/database.php';
		$db_config = $db_config['default']['connection'];

		$this->db = new \mysqli(
			$db_config['hostname'],
			$db_config['username'],
			$db_config['password'],
			$db_config['database'],
			isset($db_config['port']) ? $db_config['port'] : NULL
		);

		if(mysqli_connect_errno())
		{
			throw new \RuntimeException('Błąd podczas połączenia z bazą: ' . mysqli_connect_error());
		}
		else
		{
			$this->db->query('SET NAMES utf8') OR die('Wystąpił błąd! Cannot set uft8!');
		}
	}

	/**
	 * @param $query
	 * @return bool|\mysqli_result
	 * @throws \Exception
	 */
	public function query($query)
	{
		$result = $this->db->query($query);

		if(!$result)
		{
			throw new \Exception('ERROR: ' . $this->db->error.' ('.htmlspecialchars(substr($query,0, 500)).')');
		}

		return $result;
	}

	/**
	 * @param $table_name
	 * @param $values
	 * @return bool|mixed
	 * @throws \Exception
	 */
	public function insert($table_name, $values)
	{
		foreach($values as &$value)
		{
			if(is_null($value))
			{
				$value = 'NULL';
			}
			elseif(is_int($value))
			{
			}
			else
			{
				$value = "'".$this->db->escape_string($value)."'";
			}
		}

		$query = "INSERT INTO $table_name (".implode(',', array_keys($values)).") VALUES(".implode(',', $values).");";
		if($this->query($query))
		{
			return $this->db->insert_id;
		}

		return FALSE;
	}

	/**
	 * @param $query
	 * @param $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function select_one($query, $key, $default = NULL)
	{
		if($res = $this->db->query($query))
		{
			$row = $res->fetch_assoc();

			return isset($row[$key]) ? $row[$key] : $default;
		}

		return $default;
	}

	/**
	 * @param $table_name
	 * @param $column
	 * @return bool
	 * @throws \Exception
	 */
	public function check_column_exists($table_name, $column)
	{
		if($result = $this->query("SHOW COLUMNS FROM `$table_name` LIKE '$column';"))
		{
			return ($result->num_rows > 0);
		}

		return FALSE;
	}

	/**
	 * @param $table_name
	 * @return bool
	 * @throws \Exception
	 */
	public function is_table_not_empty($table_name)
	{
		if($result = $this->query("SELECT * FROM `$table_name`;"))
		{
			return ($result->num_rows > 0);
		}

		return FALSE;
	}

	/**
	 * @param $file
	 * @param string $delimiter
	 * @return bool
	 * @throws \Exception
	 */
	public function insert_queries_from_file($file, $delimiter = ';')
	{
		if (is_file($file) === true)
		{
			$file = fopen($file, 'r');

			if (is_resource($file) === true)
			{
				$query = array();

				while (feof($file) === false)
				{
					$query[] = fgets($file);

					if (preg_match('~' . preg_quote($delimiter, '~') . '\s*$~iS', end($query)) === 1)
					{
						$query = trim(implode('', $query));

						if($this->db->query($query) === false)
						{
							throw new \Exception('ERROR: ' . $this->db->error.' ('.htmlspecialchars(substr($query,0, 500)).')');
						}
					}

					if (is_string($query) === true)
					{
						$query = array();
					}
				}

				fclose($file);
			}
		}

		return false;
	}

	/**
	 * @param $string
	 * @return string
	 */
	public function escape($string)
	{
		return $this->db->escape_string($string);
	}

}