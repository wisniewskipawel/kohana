<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Model_Job_Category extends ORM_bTree {

	protected $_has_many = array(
		'fields' => array(
			'model' => 'Job_Category_Field',
			'through' => 'job_category_to_field',
			'foreign_key' => 'category_id',
			'far_key' => 'category_field_id'
		),
	);

	protected $_table_name = 'job_categories';
	
	protected $_primary_key = 'category_id';
	
	protected $_left_column = 'category_left';
	
	protected $_right_column = 'category_right';
	
	protected $_level_column = 'category_level';
	
	protected $_parent_column = 'category_parent_id';
	
	protected $_scope_column = 'category_scope';
	
	public static function root()
	{
		$model = new self(1);
		return $model;
	}

	public function get_list($parent_id = NULL, $filters = NULL) 
	{
		$this->with_count_jobs($filters);
		
		$this->select(array(
			DB::expr("IF({$this->_left_column} + 1 < {$this->_right_column}, 1, 0)")
			, 'has_children'
		));

		if ($parent_id !== NULL) 
		{
			$this->where('category_parent_id', '=', $parent_id);
		} 
		else 
		{
			$this->order_by('category_parent_id', 'ASC');
		}
		
		$this->order_by('category_left', 'ASC');

		return $this->find_all();
	}

	public function get_categories_list($filters = NULL)
	{
		$count_query = $this->get_count_jobs_query($filters)
			->where('jtc.category_id', '=', DB::expr($this->_table_name.'.category_id'));

		$query = DB::select('*')
			->select(array($count_query, 'count_jobs'))
			->select(array(
				DB::expr("IF({$this->_left_column} + 1 < {$this->_right_column}, 1, 0)")
				, 'has_children'
			))
			->from($this->_table_name)
			->order_by($this->_left_column, 'ASC')
			->execute();

		$categories = array();

		foreach($query as $category)
		{
			if(!isset($category['subcategories']))
			{
				$category['subcategories'] = array();
			}

			if($category[$this->_parent_column] == 1)
			{
				$categories[$category[$this->_primary_key]] = (object)$category;
			}
			else
			{
				$this->_append_subcategory($categories, (object)$category);
			}
		}

		return $categories;
	}

	public function get_notifier_list()
	{
		$query = DB::select('*')
			->select(array(
				DB::expr("IF({$this->_left_column} + 1 < {$this->_right_column}, 1, 0)")
				, 'has_children'
			))
			->from($this->_table_name)
			->where($this->_level_column, '<', 4)
			->order_by($this->_left_column, 'ASC')
			->execute();

		$categories = array();

		foreach($query as $category)
		{
			if(!isset($category['subcategories']))
			{
				$category['subcategories'] = array();
			}

			if($category[$this->_parent_column] == 1)
			{
				$categories[$category[$this->_primary_key]] = (object)$category;
			}
			else
			{
				$this->_append_subcategory($categories, (object)$category);
			}
		}

		return $categories;
	}
	
	public function get_count_jobs_query($filters = NULL)
	{
		$model_job = new Model_Job;
		
		$count_query = DB::select(array(DB::expr('COUNT(DISTINCT jtc.id)'), 'count_jobs'))
			->from(array('jobs_to_categories', 'jtc'))
			->join(array('jobs', 'job'))
				->on('job.id', '=', 'jtc.job_id');
		
		$model_job->query_active($count_query);

		if(!empty($filters['province']))
		{
			$count_query->where('job.province', '=', (int)$filters['province']);
		}

		if(!empty($filters['city']))
		{
			$count_query->where('job.city', 'LIKE', $filters['city']);
		}
		
		return $count_query;
	}
	
	public function with_count_jobs($filters = NULL)
	{
		$count_query = $this->get_count_jobs_query($filters)
			->where('jtc.category_id', '=', DB::expr($this->object_name().'.category_id'));
		
		$this->select(array($count_query, 'count_jobs'));
		
		return $this;
	}

	private function _append_subcategory(&$categories, $subcategory, $level = 0)
	{
		//exit before max nesting level exception
		if($level >= 5)
		{
			return TRUE;
		}

		if(isset($categories[$subcategory->{$this->_parent_column}]))
		{
			$categories[$subcategory->{$this->_parent_column}]->subcategories[$subcategory->{$this->_primary_key}] = $subcategory;
			return TRUE;
		}

		foreach($categories as &$category)
		{
			if($this->_append_subcategory($category->subcategories, $subcategory, $level+1))
				return TRUE;
		}

		return FALSE;
	}
	
	private function _get_optgroup($categories, $max_level = NULL)
	{
		$select = array();
		
		foreach($categories as $category)
		{
			if(count($category->subcategories) && $category->category_level == 2)
			{
				$select[$category->category_name] = $this->_get_optgroup($category->subcategories, $max_level);
			}
			else if(count($category->subcategories))
			{
				if($max_level && $category->category_level >= $max_level)
				{
					$select[$category->category_id] = $category->category_name;
				}
				else
				{
					foreach($this->_get_paths($category->subcategories, $category->category_name) as $id => $c)
					{
						$select[$id] = $c;
					}
				}
			}
			else
			{
				$select[$category->category_id] = $category->category_name;
			}
		}
		
		return $select;
	}
	
	private function _get_paths($categories, $parent_title = '')
	{
		$select = array();
		
		foreach($categories as $category)
		{
			$name = $parent_title.' -> '.$category->category_name;
			
			if(count($category->subcategories))
			{
				foreach($this->_get_paths($category->subcategories, $name) as $id => $c)
				{
					$select[$id] = $c;
				}
			}
			else
			{
				$select[$category->category_id] = $name;
			}
		}
		
		return $select;
	}

	public function get_select($only_leafs = FALSE, $grouped = FALSE, $max_level = NULL)
	{
		if($grouped)
		{
			$tree = $this->get_categories_list();
			return $this->_get_optgroup($tree, $max_level);
		}

		$tree = $this->get_fulltree();
		$select = array();
		
		foreach ($tree as $c) {
			if ($only_leafs)
			{
				if ( ! $c->is_leaf())
				{
					continue;
				}

				$parents = $c->get_parents(FALSE, TRUE);
				$name = '';
				$i = 1;
				foreach ($parents as $c2)
				{
					if ($i !== 1)
					{
						$name .= ' ->';
					}
					$name .= ' ' . $c2->category_name;
					$i++;
				}
				$select[$c->category_id] = $name;
			}
			else
			{
				$select[$c->category_id] = str_repeat(' - ', $c->level() - 1) . ' ' . $c->category_name;
			}
		}

		return $select;
	}
	
	public function get_parent() 
	{
		return self::factory()->where('category_id', '=', $this->category_parent_id)->find();
	}

	public function  delete($query = NULL) 
	{
		if ($this->loaded()) 
		{
			$child_cats = $this->get_descendants(TRUE)
				->as_array(NULL, $this->primary_key());

			$jobs = new Model_Job;
			$jobs->delete_by_category($child_cats);
			
			$fields = new Model_Job_Category_Field;
			$fields->delete_by_category($child_cats);
			
			$jobs_categories = new Model_Job_To_Category;
			$jobs_categories->delete_by_category($child_cats);
			
			DB::delete($this->table_name())
				->where($this->primary_key(), 'IN', $child_cats)
				->execute($this->_db);
			
			$root = new Model_Job_Category(1);
			$root->rebuild_tree();
			
			$this->clear();
		}
		
		return $this;
	}

	public function has_fields()
	{
		return $this->fields->count_all();
	}

	public function get_fields()
	{
		return $this->fields->order_by('job_category_to_field.id', 'ASC')
			->find_all()
			->as_array('name');
	}

	public function get_path($category)
	{
		return $this
			->from(array($this->table_name(), 'node'))
			->where('node.'.$this->_left_column, 'BETWEEN', array(DB::expr($this->object_name().'.'.$this->_left_column), DB::expr($this->object_name().'.'.$this->_right_column)))
			->where('node.category_id', '=', $category->pk())
			->order_by($this->object_name().'.'.$this->_left_column)
			->find_all();
	}

	public function get_full_levels($category, $for_select = FALSE)
	{
		$this->where($this->_parent_column, 'IN',
			DB::select('parent.category_id')
				->from(array($this->table_name(), 'node'))
				->from(array($this->table_name(), 'parent'))
				->where('node.'.$this->_left_column, 'BETWEEN', array(DB::expr('parent.'.$this->_left_column), DB::expr('parent.'.$this->_right_column)))
				->where('node.category_id', '=', $category->pk())
				->order_by('parent.'.$this->_left_column)
		);

		$this->order_by($this->_left_column, 'ASC');
		$categories = $this->find_all();

		$level_categories = array();

		foreach($categories as $lvl_category)
		{
			if($for_select)
			{
				$level_categories[$lvl_category->{$this->_level_column}][$lvl_category->pk()] = $lvl_category->category_name;
			}
			else
			{
				$level_categories[$lvl_category->{$this->_level_column}][] = $lvl_category;
			}
		}

		return $level_categories;
	}
	
	public function save_image($image)
	{
		if(Upload::valid($image) AND Upload::not_empty($image))
		{
			$file = Upload::save($image);
			
			$dir = DOCROOT . $this->_get_image_directory_path();

			if ( ! is_dir($dir))
			{
				if ( ! mkdir($dir, 0777, true))
				{
					throw new Exception("Directory $dir cannot be created!");
				}
			}
			
			return Image::factory($file)
				->save($dir.$this->pk().'.png');
		}
	}
	
	public function get_image()
	{
		return self::get_image_path($this->pk());
	}
	
	public function delete_image()
	{
		if($image = $this->get_image())
		{
			unlink(DOCROOT.$image);
		}
	}

	private static function _get_image_directory_path()
	{
		return Upload::$default_directory . DIRECTORY_SEPARATOR . 'jobs_categories' . DIRECTORY_SEPARATOR;
	}
	
	public static function get_image_path($id)
	{
		$img_path = self::_get_image_directory_path().$id.'.png';
		
		if(file_exists(DOCROOT.$img_path))
		{
			return $img_path;
		}
		
		return NULL;
	}
	
}
