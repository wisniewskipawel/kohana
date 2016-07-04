<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Catalog_Category extends ORM_bTree {

	protected $_table_name = 'catalog_categories';
	protected $_primary_key = 'category_id';
	protected $_primary_val = 'category_name';
	protected $_left_column = 'category_left';
	protected $_right_column = 'category_right';
	protected $_level_column = 'category_level';
	protected $_parent_column = 'category_parent_id';
	protected $_scope_column = 'category_scope';

	protected $_has_many = array(
		'companies'	 => array('model' => 'Category_Company', 'foreign_key' => 'category_id')
	);
	
	public function get_main_list()
	{
		$query = DB::select('*')
			->select(array(
				DB::select(DB::expr('COUNT(cc.company_id)'))
				->from(array('catalog_categories_to_companies', 'cc'))
				->join(array('catalog_companies', 'companies'))
					->on('companies.company_id', '=', 'cc.company_id')
				->where('cc.category_id', '=', DB::expr($this->_table_name.'.category_id'))
				->where('companies.company_is_approved', '=', 1)
				, 'count_companies')
			)
			->select(array(
				DB::expr("IF({$this->_left_column} + 1 < {$this->_right_column}, 1, 0)")
				, 'has_children'
			))
			->from($this->_table_name)
			->where($this->_parent_column, '=', 1)
			->or_where($this->_level_column, '=', 3)
			->order_by($this->_left_column, 'ASC')
			->execute();
		
		$categories = array();
		
		foreach($query as $category)
		{
			if($category[$this->_parent_column] == 1)
			{
				$category['subcategories'] = array();
				
				$categories[$category[$this->_primary_key]] = (object)$category;
			}
			else
			{
				$categories[$category[$this->_parent_column]]->subcategories[$category[$this->_primary_key]] = (object)$category;
			}
		}

		return $categories;
	}
	
	public function get_categories_list($filters = NULL)
	{
		$count_query = DB::select(DB::expr('COUNT(cc.company_id)'))
				->from(array('catalog_categories_to_companies', 'cc'))
				->join(array('catalog_companies', 'companies'))
					->on('companies.company_id', '=', 'cc.company_id')
				->where('cc.category_id', '=', DB::expr($this->_table_name.'.category_id'))
				->where('companies.company_is_approved', '=', 1);
		
		if(!empty($filters))
		{
			if(!empty($filters['province']))
			{
				$count_query->where('companies.province_select', '=', (int)$filters['province']);
			}
			
			if(!empty($filters['city']))
			{
				$count_query->where('companies.company_city', 'LIKE', $filters['city']);
			}
		}
		
		$query = DB::select('*')
			->select(array($count_query, 'count_companies'))
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
	
	public function with_companies_counter($province_id = NULL)
	{
		$count_query = DB::select(DB::expr('COUNT(companies.company_id)'))
				->from(array('catalog_categories_to_companies', 'cc'))
				->join(array('catalog_companies', 'companies'))
					->on('companies.company_id', '=', 'cc.company_id')
				->where('cc.category_id', '=', DB::expr($this->object_name().'.category_id'))
				->where('companies.company_is_approved', '=', 1);
		
		if($province_id)
		{
			$count_query
				->where('companies.province_select', '=', (int)$province_id);
		}
		
		$this->select(array($count_query, 'count_companies'));
		
		return $this;
	}

	public function get_list($parent_id = NULL)
	{
		$this->_add_has_children();
		$this->_add_companies_count();
		if ($parent_id !== NULL) {
			$this->where('category_parent_id', '=', $parent_id);
		} else {
			$this->order_by('category_parent_id', 'ASC');
		}
		$this->order_by('category_left', 'ASC');
		return $this->find_all();
	}

	public function get_select_tree()
	{
		$root = ORM::factory('Catalog_Category', 1);
		$tree = $root->get_fulltree();
		$select = array();
		
		foreach ($tree as $c)
		{
			$select[$c->category_id] = str_repeat(' - ', $c->level() - 1) . ' ' . $c->category_name;
		}
		return $select;
	}

	protected function _add_companies_count()
	{
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(catalog_company.company_id)
				FROM
					catalog_categories_to_companies AS pivot
				JOIN
					catalog_companies AS catalog_company
				ON
					pivot.company_id = catalog_company.company_id
				WHERE
					pivot.category_id = catalog_category.category_id
			)
		'), 'companies_count'));
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(catalog_company.company_id)
				FROM
					catalog_categories_to_companies AS pivot
				JOIN
					catalog_companies AS catalog_company
				ON
					pivot.company_id = catalog_company.company_id
				WHERE
					pivot.category_id = catalog_category.category_id AND catalog_company.company_is_approved = 0
			)
		'), 'companies_not_approved_count'));
	}

	protected function _add_has_children() 
	{
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					catalog_categories AS c
				WHERE
					c.category_parent_id = catalog_category.category_id
			)
		'), 'has_children'));
	}

	public function get_select($parent_id) 
	{
		if ($parent_id === TRUE)
		{
			$categories = self::factory($this->_object_name)
					->get_fulltree();
			
			$select = array();
			
			foreach ($categories as $c)
			{
				if ($c->is_leaf())
				{
					$parents = $c->get_parents(FALSE, TRUE);
					$name = '';
					$i = 1;
					foreach ($parents as $c2)
					{
						if ($i !== 1)
						{
							$name .= ' -> ';
						}
						$name .= $c2->category_name;
						$i++;
					}
					
					$select[$c->category_id] = $name;
				}
			}
			
			return $select;
		}
		elseif (is_int($parent_id))
		{
			
			$categories = $this->get_list($parent_id);

			$select = array();
			$select[NULL] = '--- wybierz ---';

			foreach ($categories as $c) {
				$select[$c->category_id] = $c->category_name;
			}

			return $select;

		}
		else
		{
			throw new Exception('Check API!');
		}
		
	}

	public function  delete($query = NULL) 
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));
		
		$child_cats = $this->get_descendants(TRUE)
			->as_array(NULL, $this->primary_key());

		$companies = new Model_Catalog_Company;
		$companies->delete_by_category($child_cats);

		$companies_categories = new Model_Catalog_CategoryToCompany;
		$companies_categories->delete_by_category($child_cats);

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $child_cats)
			->execute($this->_db);
		
		$this->clear();
		
		$root = new Model_Catalog_Category(1);
		$root->rebuild_tree();
		
		return $this;
	}

	public function get_parent()
	{
		$c = ORM::factory('Catalog_Category')->where('category_id', '=', $this->category_parent_id)->find();
		return $c;
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

	/**
	 * @return string
	 */
	public function get_icon_uri()
	{
		$manager = catalog::get_category_icon_manager();

		return $manager->exists($this->pk()) ? $manager->get_uri($this->pk()) : NULL;
	}
	
}
