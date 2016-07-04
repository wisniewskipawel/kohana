<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class ORM_Future extends ORM {
	
	public static $table_name = NULL;
	
	protected $_initialized;
	
	public function __construct($id = NULL)
	{
		$this->_belongs_to = $this->load_belongs_to();
		$this->_has_many = $this->load_has_many();
		$this->_has_one = $this->load_has_one();
		
		parent::__construct($id);
		
		$this->_initialized = TRUE;
	}
	
	private function _get_class_name($object = null)
	{
		if (!is_object($object) && !is_string($object)) 
		{
			return FALSE;
		}

		$class = explode('\\', (is_string($object) ? $object : get_class($object)));
		return $class[count($class) - 1];
	}

	/**
	 * Prepares the model database connection, determines the table name,
	 * and loads column information.
	 *
	 * @return void
	 */
	protected function _initialize()
	{
		// Set the object name and plural name
		if(!$this->_object_name)
		{
			$this->_object_name = strtolower($this->_get_class_name($this));
		}
		
		$this->_object_plural = Inflector::plural($this->_object_name);

		if ( ! $this->_errors_filename)
		{
			$this->_errors_filename = $this->_object_name;
		}

		if ( ! is_object($this->_db))
		{
			// Get database instance
			$this->_db = Database::instance($this->_db_group);
		}

		if (empty($this->_table_name))
		{
			if(static::$table_name)
			{
				$this->_table_name = static::$table_name;
			}
			else
			{
				// Table name is the same as the object name
				$this->_table_name = $this->_object_name;

				if ($this->_table_names_plural === TRUE)
				{
					// Make the table name plural
					$this->_table_name = Inflector::plural($this->_table_name);
				}
			}
		}

		foreach ($this->_belongs_to as $alias => $details)
		{
			$defaults['model'] = $alias;
			$defaults['foreign_key'] = $alias.$this->_foreign_key_suffix;

			$this->_belongs_to[$alias] = array_merge($defaults, $details);
		}

		foreach ($this->_has_one as $alias => $details)
		{
			$defaults['model'] = $alias;
			$defaults['foreign_key'] = $this->_object_name.$this->_foreign_key_suffix;

			$this->_has_one[$alias] = array_merge($defaults, $details);
		}

		foreach ($this->_has_many as $alias => $details)
		{
			$defaults['model'] = Inflector::singular($alias);
			$defaults['foreign_key'] = $this->_object_name.$this->_foreign_key_suffix;
			$defaults['through'] = NULL;
			$defaults['far_key'] = Inflector::singular($alias).$this->_foreign_key_suffix;

			$this->_has_many[$alias] = array_merge($defaults, $details);
		}

		// Load column information
		$this->reload_columns();

		// Clear initial model state
		$this->clear();
	}

	public function load_belongs_to()
	{
		return $this->_belongs_to;
	}

	public function load_has_many()
	{
		return $this->_has_many;
	}

	public function load_has_one()
	{
		return $this->_has_one;
	}

	protected function _related($alias)
	{
		if (isset($this->_related[$alias]))
		{
			return $this->_related[$alias];
		}
		elseif (isset($this->_has_one[$alias]))
		{
			return $this->_related[$alias] = new $this->_has_one[$alias]['model']();
		}
		elseif (isset($this->_belongs_to[$alias]))
		{
			return $this->_related[$alias] = new $this->_belongs_to[$alias]['model']();
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * Base set method - this should not be overridden.
	 *
	 * @param  string $column  Column name
	 * @param  mixed  $value   Column value
	 * @return void
	 */
	public function __set($column, $value)
	{
		if ( ! isset($this->_object_name) OR ! isset($this->_initialized))
		{
			// Object not yet constructed, so we're loading data from a database call cast
			$this->_cast_data[$column] = $value;
		}
		else
		{
			// Set the model's column to given value
			$this->set($column, $value);
		}
	}

	/**
	 * Handles retrieval of all model values, relationships, and metadata.
	 *
	 * @param   string $column Column name
	 * @return  mixed
	 */
	public function __get($column)
	{
		if (array_key_exists($column, $this->_object))
		{
			return (in_array($column, $this->_serialize_columns))
				? $this->_unserialize_value($this->_object[$column])
				: $this->_object[$column];
		}
		elseif (isset($this->_related[$column]))
		{
			// Return related model that has already been fetched
			return $this->_related[$column];
		}
		elseif (isset($this->_belongs_to[$column]))
		{
			$model = $this->_related($column);

			// Use this model's column and foreign model's primary key
			$col = $model->object_name().'.'.$model->primary_key();
			$val = $this->_object[$this->_belongs_to[$column]['foreign_key']];

			// Make sure we don't run WHERE "AUTO_INCREMENT column" = NULL queries. This would
			// return the last inserted record instead of an empty result.
			// See: http://mysql.localhost.net.ar/doc/refman/5.1/en/server-session-variables.html#sysvar_sql_auto_is_null
			if ($val !== NULL)
			{
				$model->where($col, '=', $val)->find();
			}

			return $this->_related[$column] = $model;
		}
		elseif (isset($this->_has_one[$column]))
		{
			$model = $this->_related($column);

			// Use this model's primary key value and foreign model's column
			$col = $model->_object_name.'.'.$this->_has_one[$column]['foreign_key'];
			$val = $this->pk();

			$model->where($col, '=', $val)->find();

			return $this->_related[$column] = $model;
		}
		elseif (isset($this->_has_many[$column]))
		{
			$model = new $this->_has_many[$column]['model']();

			if (isset($this->_has_many[$column]['through']))
			{
				// Grab has_many "through" relationship table
				$through = $this->_has_many[$column]['through'];

				// Join on through model's target foreign key (far_key) and target model's primary key
				$join_col1 = $through.'.'.$this->_has_many[$column]['far_key'];
				$join_col2 = $model->_object_name.'.'.$model->_primary_key;

				$model->join($through)->on($join_col1, '=', $join_col2);

				// Through table's source foreign key (foreign_key) should be this model's primary key
				$col = $through.'.'.$this->_has_many[$column]['foreign_key'];
				$val = $this->pk();
			}
			else
			{
				// Simple has_many relationship, search where target model's foreign key is this model's primary key
				$col = $model->_object_name.'.'.$this->_has_many[$column]['foreign_key'];
				$val = $this->pk();
			}

			return $model->where($col, '=', $val);
		}
		else
		{
			throw new Kohana_Exception('The :property property does not exist in the :class class',
				array(':property' => $column, ':class' => get_class($this)));
		}
	}

	/**
	 * Checks whether a column value is unique.
	 * Excludes itself if loaded.
	 *
	 * @param   string   $field  the field to check for uniqueness
	 * @param   mixed    $value  the value to check for uniqueness
	 * @return  bool     whteher the value is unique
	 */
	public function unique($field, $value)
	{
		$model = self::factory()
			->where($field, '=', $value)
			->find();

		if ($this->loaded())
		{
			return ( ! ($model->loaded() AND $model->pk() != $this->pk()));
		}

		return ( ! $model->loaded());
	}
	
	/**
	 * Reload column definitions.
	 *
	 * @chainable
	 * @param   boolean $force Force reloading
	 * @return  ORM
	 */
	public function reload_columns($force = FALSE)
	{
		if ($force === TRUE OR empty($this->_table_columns))
		{
			$class = get_class($this);
			
			if (isset(ORM::$_column_cache[$class]))
			{
				// Use cached column information
				$this->_table_columns = ORM::$_column_cache[$class];
			}
			else
			{
				// Grab column information from database
				$this->_table_columns = $this->list_columns();

				// Load column cache
				ORM::$_column_cache[$class] = $this->_table_columns;
			}
		}

		return $this;
	}
	
}