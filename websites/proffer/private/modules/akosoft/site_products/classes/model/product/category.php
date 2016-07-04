<?php
/**
 * @author       AkoSoft Team <biuro@akosoft.pl>
 * @link         http://www.akosoft.pl
 * @copyright    Copyright (c) 2016, AkoSoft
 */

class Model_Product_Category extends ORM_bTree {

	protected $_table_name = 'product_categories';
	
	protected $_primary_key = 'category_id';
	protected $_primary_val = 'category_name';
	protected $_left_column = 'category_left';
	protected $_right_column = 'category_right';
	protected $_level_column = 'category_level';
	protected $_parent_column = 'category_parent_id';
	protected $_scope_column = 'category_scope';

	/**
	 * @param Model_Product_Category $category
	 * @param $values
	 * @return bool|Model_Product_Category
	 */
	public function add_category(self $category, $values)
	{
		$this->values($values);
		$this->insert_as_last_child($category);

		return $this->saved() ? $this : FALSE;
	}

	/**
	 * @return ORM_Tree
	 */
	public function find_childrens_for_admin()
	{
		$self = new self;
		$self->with_products_counter();

		return $this->get_children(FALSE, 'ASC', FALSE, $self);
	}

	/**
	 * @param array|null $filters
	 * @return array
	 */
	public function get_categories_list($filters = NULL)
	{
		$query = DB::select('*')
			->select(array(
				DB::expr("IF({$this->_left_column} + 1 < {$this->_right_column}, 1, 0)")
				, 'has_children'
			))
			->from(array($this->_table_name, $this->object_name()))
			->order_by($this->_left_column, 'ASC');
		
		$this->with_products_counter($filters, $query);
		
		$rows = $query->execute();

		$categories = array();

		foreach($rows as $category)
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

	/**
	 * @param $categories
	 * @param $subcategory
	 * @param int $level
	 * @return bool
	 */
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

	/**
	 * @param array|null $filters
	 * @param ORM|Database_Query_Builder|null $query
	 * @return $this
	 */
	public function with_products_counter($filters = NULL, $query = NULL)
	{
		if(!$query)
		{
			$query = $this;
		}

		$model_product = new Model_Product;
		
		$count_query = DB::select(DB::expr('COUNT(DISTINCT cc.product_id)'))
			->from(array('products_to_categories', 'cc'))
			->join(array('products', $model_product->object_name()))
				->on($model_product->object_name().'.product_id', '=', 'cc.product_id')
			->where('cc.category_id', '=', DB::expr($this->_db->quote_column($this->object_name().'.category_id')));
		
		$model_product->query_active($count_query);

		if(!empty($filters['province']))
		{
			$count_query->where($model_product->object_name().'.product_province', '=', (int)$filters['province']);
		}

		if(!empty($filters['city']))
		{
			$count_query->where($model_product->object_name().'.product_city', 'LIKE', $filters['city']);
		}

		return $query->select(array($count_query, 'count_products'));
	}

	/**
	 * @param bool $only_leafs
	 * @return array
	 */
	public function get_select($only_leafs = FALSE) 
	{
		$tree = $this->get_fulltree();
		$select = array();

		foreach ($tree as $c)
		{
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
				$select[$c->pk()] = $name;
			}
			else
			{
				$select[$c->pk()] = str_repeat(' - ', $c->level() - 1) . ' ' . $c->category_name;
			}
		}

		return $select;
	}

	/**
	 * @param null $query
	 * @return $this
	 */
	public function  delete($query = NULL) 
	{
		if($this->loaded())
		{
			$child_cats = $this->get_descendants(TRUE)
				->as_array(NULL, $this->primary_key());

			$products = new Model_Product;
			$products->delete_by_category($child_cats);
			
			$products_categories = new Model_Product_To_Category;
			$products_categories->delete_by_category($child_cats);
			
			DB::delete($this->table_name())
				->where($this->primary_key(), 'IN', $child_cats)
				->execute($this->_db);
			
			$root = new Model_Product_Category(1);
			$root->rebuild_tree();
			
			$this->clear();
		}
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_icon_uri()
	{
		$manager = Products::get_category_icon_manager();

		return $manager->exists($this->pk()) ? $manager->get_uri($this->pk()) : NULL;
	}
	
}
