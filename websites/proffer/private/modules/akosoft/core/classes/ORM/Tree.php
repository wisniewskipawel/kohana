<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class ORM_Tree extends ORM {
	
	protected $_left_column = 'lft';
	protected $_right_column = 'rgt';
	protected $_parent_column = 'parent_id';

	/**
	 * @return mixed
	 */
	public function get_left()
	{
		return $this->{$this->_left_column};
	}

	/**
	 * @return mixed
	 */
	public function get_right()
	{
		return $this->{$this->_right_column};
	}

	/**
	 * @return mixed
	 */
	public function get_parent_id()
	{
		return $this->{$this->_parent_column};
	}

	/**
	 * @return bool
	 */
	public function is_root()
	{
		return $this->loaded() AND !$this->get_parent_id() AND $this->get_left() == 1;
	}

	/**
	 * @param ORM_Tree|NULL $parent_node
	 * @return bool
	 * @throws Exception
	 */
	public function insert_node(ORM_Tree $parent_node = NULL)
	{
		$this->_db->begin();
		
		if($parent_node)
		{
			$this->{$this->_parent_column} = $parent_node->pk();
			$this->create_space($parent_node->{$this->_right_column});
			
			$this->{$this->_left_column} = $parent_node->{$this->_right_column};
			$this->{$this->_right_column} = $parent_node->{$this->_right_column} + 1;
		}
		else
		{
			$offset_query = DB::select($this->_right_column)
				->from($this->table_name());
			
			$offset_rgt = $offset_query
				->order_by($this->_right_column, 'DESC')
				->limit(1)
				->execute($this->_db)
				->get($this->_right_column, 0);
			
			$this->{$this->_left_column} = $offset_rgt + 1;
			$this->{$this->_right_column} = $offset_rgt + 2;
		}
		
		try
		{
			$this->save();
		}
		catch (Exception $e)
		{
			$this->_db->rollback();
			
			throw $e;
		}
		
		$this->_db->commit();
		
		return $this->saved();
	}
	
	public function create_space($start, $size = 2)
	{
		DB::update($this->_table_name)
			->set(array($this->_right_column => DB::expr($this->_right_column.' + '.$size)))
			->where($this->_right_column,'>=', $start)
			->execute($this->_db);
		
		DB::update($this->_table_name)
			->set(array($this->_left_column => DB::expr($this->_left_column.' + '.$size)))
			->where($this->_left_column,'>=', $start)
			->execute($this->_db);
	}
	
	protected function delete_space($start, $size = 2)
	{
		DB::update($this->_table_name)
			->set(array($this->_left_column => DB::expr($this->_left_column.' - '.$size)))
			->where($this->_left_column, '>=', $start)
			->execute($this->_db);

		DB::update($this->_table_name)
			->set(array($this->_right_column => DB::expr($this->_right_column.' - '.$size)))
			->where($this->_right_column,'>=', $start)
			->execute($this->_db);
	}

	/**
	 * @return static
	 */
	public function create_root()
	{
		$this->parent_id = NULL;
		$this->lft = 1;
		$this->rgt = 2;

		$this->save();

		return $this;
	}

	/**
	 * @return $this|ORM_Tree
	 * @throws Kohana_Exception
	 */
	public function find_root()
	{
		$this->where($this->object_name().'.parent_id', 'IS', NULL);
		$this->where($this->object_name().'.lft', '=', 1);
		$this->find();

		if(!$this->loaded())
		{
			return $this->create_root();
		}

		return $this;
	}

	/**
	 * @return static[]
	 * @throws Kohana_Exception
	 */
	public function find_childrens()
	{
		$self = new static();
		$self->where('parent_id', '=', $this->pk());
		$self->order_by('lft', 'ASC');
		return $self->find_all();
	}

	public function has_parent()
	{
		return $this->_parent_column AND $this->{$this->_parent_column};
	}

	public function has_next_sibling()
	{
		$next = (new static())
			->where($this->_parent_column, '=', $this->{$this->_parent_column})
			->where($this->_left_column, '>', $this->{$this->_left_column})
			->order_by($this->_left_column, 'ASC')
			->find();

		if($next->loaded())
		{
			return $next->pk();
		}

		return FALSE;
	}

	public function has_prev_sibling()
	{
		$prev = (new static())
			->where($this->_parent_column, '=', $this->{$this->_parent_column})
			->where($this->_left_column, '<', $this->{$this->_left_column})
			->order_by($this->_left_column, 'DESC')
			->find();

		if($prev->loaded())
		{
			return $prev->pk();
		}

		return FALSE;
	}

	public function move_to_prev_sibling(ORM_Tree $target)
	{
		return $this->move($target);
	}

	public function move_to_next_sibling(ORM_Tree $target)
	{
		return $target->move($this);
	}

	protected function move(ORM_Tree $target)
	{
		if(!$this->loaded())
			return FALSE;

		// Start the transaction
		$this->_db->begin();

		// Catch any database or other excpetions and unlock
		try
		{
			$new_pos = $target->get_left();
			$old_right_pos = $this->get_right();
			$width = $this->get_right() - $this->get_left() + 1;
			$distance = $new_pos - $this->get_left();
			$tmp_pos = $this->get_left();

			if($distance < 0)
			{
				$distance -= $width;
				$tmp_pos += $width;
			}

			//create space
			DB::update($this->table_name())
				->set(array(
					$this->_left_column => DB::expr($this->_db->quote_column($this->_left_column).' + '.$width),
				))
				->where($this->_left_column, '>=', $new_pos)
				->execute($this->_db);

			DB::update($this->table_name())
				->set(array(
					$this->_right_column => DB::expr($this->_db->quote_column($this->_right_column).' + '.$width),
				))
				->where($this->_right_column, '>=', $new_pos)
				->execute($this->_db);

			//update positions
			DB::update($this->table_name())
				->set(array(
					$this->_left_column => DB::expr($this->_db->quote_column($this->_left_column).' + '.$distance),
					$this->_right_column => DB::expr($this->_db->quote_column($this->_right_column).' + '.$distance),
				))
				->where($this->_left_column, '>=', $tmp_pos)
				->where($this->_right_column, '<', $tmp_pos + $width)
				->execute($this->_db);

			//delete space
			DB::update($this->table_name())
				->set(array(
					$this->_left_column => DB::expr($this->_db->quote_column($this->_left_column).' - '.$width),
				))
				->where($this->_left_column, '>', $old_right_pos)
				->execute($this->_db);

			DB::update($this->table_name())
				->set(array(
					$this->_right_column => DB::expr($this->_db->quote_column($this->_right_column).' - '.$width),
				))
				->where($this->_right_column, '>', $old_right_pos)
				->execute($this->_db);
		}
		catch(Exception $e)
		{
			$this->_db->rollback();
			throw $e;
		}

		// Commit the transaction
		$this->_db->commit();

		$this->reload();
		$target->reload();

		return $this;
	}
	
	public function delete_nodes($nodes)
	{
		if(empty($nodes))
		{
			return;
		}

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', (array)$nodes)
			->execute($this->_db);
	}
	
	public function delete()
	{
		$nodes = DB::select($this->primary_key())
			->from($this->table_name())
			->where($this->_left_column, 'BETWEEN', array($this->get_left(), $this->get_right()))
			->execute($this->_db)
			->as_array(NULL, $this->primary_key());
		
		$this->delete_nodes($nodes);
		
		$this->clear();
		
		return $this;
	}

	/**
	 * @param null $left
	 * @return mixed|null
	 */
	public function rebuild_tree($left = NULL)
	{
		$left = $left ? $left : $this->lft;

		if(!$left)
			throw new RuntimeException('You must set left id!');

		// Start the transaction
		$this->_db->begin();

		$right = $left + 1;

		$children = $this->find_childrens();

		foreach($children as $child)
		{
			$child->lft = $this->lft + 1;
			$right = $child->rebuild_tree($right);
		}

		$this->lft = $left;
		$this->rgt = $right;
		$this->save();

		// Commit the transaction
		$this->_db->commit();

		return $right + 1;
	}

	/**
	 * @return static[]
	 * @throws Kohana_Exception
	 */
	public function find_all()
	{
		$this->order_by($this->_left_column, 'ASC');
		return parent::find_all();
	}

	/**
	 * @return static[]
	 */
	public function get_path()
	{
		return (new static())
			->where($this->object_name().'.'.$this->_left_column, 'BETWEEN', array(
				DB::expr($this->object_name().'.'.$this->_left_column),
				DB::expr($this->object_name().'.'.$this->_right_column),
			))
			->where($this->object_name().'.'.$this->primary_key(), '=', $this->pk())
			->order_by($this->object_name().'.'.$this->_left_column)
			->find_all();
	}

}
