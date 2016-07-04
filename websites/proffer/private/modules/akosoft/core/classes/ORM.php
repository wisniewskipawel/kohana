<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class ORM extends Kohana_ORM {

	/**
	 * Creates and returns a new model.
	 *
	 * @chainable
	 * @param   string  $model  Model name
	 * @param   mixed   $id     Parameter for find()
	 * @return  static
	 */
	public static function factory($model = NULL, $id = NULL)
	{
		if($model === NULL)
		{
			$model = get_called_class();
		}
		else
		{
			// Set class name
			$model = 'Model_'.ucfirst($model);
		}

		return new $model($id);
	}

	/**
	 * @return array|mixed
	 * @throws Cache_Exception
	 */
	public function list_columns()
	{
		$cache = Cache::instance();
		$cache_id = 'list_columns|'.$this->_table_name;
		$columns = $cache->get($cache_id);
		
		if(Kohana::$environment === Kohana::PRODUCTION AND $columns)
		{
			return $columns;
		}
		
		$columns = parent::list_columns();
		$cache->set($cache_id, $columns, Date::DAY);
		
		return $columns;
	}

	/**
	 * @param Validation|NULL $validation
	 * @return ORM
	 */
	public function save(Validation $validation = NULL)
	{
		foreach ($this->_changed as $column)
		{
			//cast to integer all integer columns
			if(isset($this->_table_columns[$column]['type']) AND $this->_table_columns[$column]['type'] == 'int')
			{
				$this->_object[$column] = (int)$this->_object[$column];
			}
			
			//limit chars for string columns
			if(isset($this->_table_columns[$column]['type']) AND $this->_table_columns[$column]['type'] == 'string' AND !empty($this->_table_columns[$column]['character_maximum_length']))
			{
				$this->_object[$column] = Text::limit_chars($this->_object[$column], $this->_table_columns[$column]['character_maximum_length'], '');
			}
			
			//force set NULL to empty columns (only if column is nullable)
			if(!$this->_object[$column] AND isset($this->_table_columns[$column]['is_nullable']) AND $this->_table_columns[$column]['is_nullable'])
			{
				$this->_object[$column] = NULL;
			}
		}
		
		return parent::save($validation);
	}

	/**
	 * @param $pk
	 * @return static
	 * @throws Kohana_Exception
	 */
	public function find_by_pk($pk)
	{
		return $this
			->where($this->object_name().'.'.$this->primary_key(), '=', (int)$pk)
			->find();
	}

	/**
	 * @param Pagination $pagination
	 * @return $this
	 */
	public function set_pagination(Pagination $pagination)
	{
		return $this->limit($pagination->items_per_page)
			->offset($pagination->offset);
	}

}