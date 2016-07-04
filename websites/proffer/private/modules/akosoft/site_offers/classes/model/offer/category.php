<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Offer_Category extends ORM_bTree {

	protected $_table_name = 'offer_categories';
	protected $_primary_key = 'category_id';
	protected $_primary_val = 'category_name';
	protected $_left_column = 'category_left';
	protected $_right_column = 'category_right';
	protected $_level_column = 'category_level';
	protected $_parent_column = 'category_parent_id';
	protected $_scope_column = 'category_scope';
	
	public function get_age_confirm_categories()
	{
		$age_confirm_parent_categories = $this->where('category_age_confirm', '=', TRUE)
			->find_all();
		
		if(!count($age_confirm_parent_categories))
			return NULL;
		
		$count = 0;
		foreach($age_confirm_parent_categories as $parent_category)
		{
			$this->or_where_open()
					->where('category_left', '>=', $parent_category->category_left)
					->where('category_right', '<=', $parent_category->category_right)
				->where_close();
			$count++;
		}
		
		if($count)
		{
			return $this->find_all();
		}
		
		return NULL;
	}
	
	public function get_main_list()
	{
		$root = self::factory($this->_object_name, 1);
		
		$model = self::factory($this->_object_name)
				->select(array(DB::expr("
					(
						SELECT
							GROUP_CONCAT(descendants.category_id ORDER BY descendants.{$this->_left_column} ASC SEPARATOR '||')
						FROM
							{$this->_table_name} AS descendants
						WHERE
							descendants.{$this->_left_column} > offer_category.{$this->_left_column} AND descendants.{$this->_right_column} < offer_category.{$this->_right_column} AND descendants.{$this->_level_column} = offer_category.{$this->_level_column} + 1
					)
				"), 'descendants_ids'))
				->select(array(DB::expr("
					(
						SELECT
							GROUP_CONCAT(descendants.category_name ORDER BY descendants.{$this->_left_column} ASC SEPARATOR '||')
						FROM
							{$this->_table_name} AS descendants
						WHERE
							descendants.{$this->_left_column} > offer_category.{$this->_left_column} AND descendants.{$this->_right_column} < offer_category.{$this->_right_column} AND descendants.{$this->_level_column} = offer_category.{$this->_level_column} + 1
					)
				"), 'descendants_names'))						  
				->select(array(DB::expr("
					IF (
						(
							SELECT
								COUNT(*)
							FROM
								{$this->_table_name} AS children_search
							WHERE
								children_search.{$this->_left_column} > offer_category.{$this->_left_column} AND children_search.{$this->_right_column} < offer_category.{$this->_right_column}
						) > 0,
						1,
						0
					)
				"), 'has_children'))
				->select(array(DB::expr("
					(
						SELECT
							GROUP_CONCAT(child2.{$this->_parent_column} ORDER BY child.{$this->_left_column} ASC SEPARATOR '||')
						FROM
							{$this->_table_name} AS subquery
						LEFT JOIN
							{$this->_table_name} AS child
						ON
							subquery.{$this->_primary_key} = child.{$this->_parent_column}
						LEFT JOIN
							{$this->_table_name} AS child2
						ON
							child.{$this->_primary_key} = child2.{$this->_parent_column}
						WHERE
							offer_category.{$this->_primary_key} = child.{$this->_parent_column}
					)
				"), 'descendants_has_children'))
				->select(array(DB::expr("
					(
						SELECT
							GROUP_CONCAT(descendants.offers_count SEPARATOR '||')
						FROM
							(
								SELECT
									(
										SELECT
											COUNT(*)
										FROM
											offers
										JOIN
											offers_to_categories AS pivot
										ON
											offers.offer_id = pivot.offer_id
										WHERE
											pivot.category_id = descendant.category_id AND offers.offer_is_approved = 1 AND offers.offer_availability > NOW()
									) AS offers_count,
									descendant.category_left AS descendant_category_left,
									descendant.category_right AS descendant_category_right,
									descendant.category_id AS descendant_category_id,
									descendant.category_level AS descendant_category_level
								FROM
									offer_categories AS descendant
								GROUP BY
									descendant.category_id
								ORDER BY
									descendant.category_left
							) AS descendants
						WHERE
							descendants.descendant_category_left > offer_category.category_left AND descendants.descendant_category_right < offer_category.category_right AND descendants.descendant_category_level = offer_category.category_level + 1
					)
				"), 'descendants_offers_count'))
				->where($this->_parent_column, '=', 1)
				->order_by($this->_left_column);
	   
		return $model->find_all();
	}
	
	public function get_categories_list($filters = NULL)
	{
		$model_offer = new Model_Offer;
		
		$model_offer->add_active_conditions();
		
		if(!empty($filters['province']))
		{
			$model_offer->filter_by_province($filters['province']);
		}
		
		if(!empty($filters['city']))
		{
			$model_offer->filter_by_city($filters['city']);
		}
		
		$count_query = $model_offer->get_query_builder();
		
		$count_query->select(DB::expr('COUNT(DISTINCT cc.offer_id)'))
			->from(array('offers', $model_offer->object_name()))
			->join(array('offers_to_categories', 'cc'))
				->on($model_offer->object_name().'.offer_id', '=', 'cc.offer_id')
			->where('cc.category_id', '=', DB::expr($this->_table_name.'.category_id'));
		
		$query = DB::select('*')
			->select(array($count_query, 'count_offers'))
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

	public function get_list($parent_id = 0, $province = NULL) 
	{
		$province = intval($province);
		
		$where = '';
		if ($province)
		{
			$where .= 'AND offers.province_select = ' . $province;
		}
		
		$this->select(array(DB::expr("
			(
				SELECT
					COUNT(*)
				FROM
					offers_to_categories
				JOIN
					offers
				ON
					offers_to_categories.offer_id = offers.offer_id
				WHERE
					offers_to_categories.category_id = offer_category.category_id AND offers.offer_is_approved = 1 AND offers.offer_availability > NOW() $where
			)
		"), 'offers_category_count'));
		
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					offer_categories AS cat
				WHERE
					cat.category_parent_id = offer_category.category_id
			)
		'), 'has_children'));

		if ($parent_id !== NULL) {
			$this->where('category_parent_id', '=', $parent_id);
		} else {
			$this->order_by('category_parent_id', 'ASC');
		}
		$this->order_by('category_left', 'ASC');
		
		return $this->find_all();
	}
	
	public function get_list_province($province_id, $parent_id) 
	{
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					offers_to_categories
				JOIN
					offers
				ON
					offers_to_categories.offer_id = offers.offer_id
				WHERE
					offers_to_categories.category_id = offer_category.category_id 
					AND 
					offers.offer_is_approved = 1 
					AND 
					offers.offer_availability > NOW()
					AND
					offers.province_select = '.$province_id.'
			)
		'), 'offers_category_count'));
		
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					offer_categories AS cat
				WHERE
					cat.category_parent_id = offer_category.category_id
			)
		'), 'has_children'));

		if ($parent_id !== NULL) {
			$this->where('category_parent_id', '=', $parent_id);
		} else {
			$this->order_by('category_parent_id', 'ASC');
		}
		$this->order_by('category_left', 'ASC');
		
		return $this->find_all();
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
		return ORM::factory('Offer_Category')->where('category_id', '=', $this->category_parent_id)->find();
	}
	
	public function add_category($parent_category, $values, $files)
	{
		$this->values($values);
		
		$this->insert_as_last_child($parent_category);
		
		$this->save_image(Arr::get($files, 'image'));
		
		return $this->saved();
	}
	
	public function edit_category($values, $files)
	{
		$this->values($values);
		$this->save();
		
		if($image = Arr::get($files, 'image'))
		{
			$this->delete_image(FALSE);
			
			$this->save_image($image);
		}

		if($icon = Arr::get($files, 'icon'))
		{
			offers::get_category_icon_manager()->save_image($icon, $this->pk());
		}
		
		return $this->saved();
	}
	
	public function save_image($file)
	{
		if($file AND Upload::not_empty($file))
		{
			$this->category_image = time();
			$this->save();

			$path = upload::save($file);

			img::process('offer_category', 'offer_categories', $this->pk(), $this->category_image, $path);
		}
	}
	
	public function has_image()
	{
		return $this->category_image;
	}
	
	public function delete_image($save = TRUE)
	{
		if(!$this->loaded() || !$this->has_image())
			return FALSE;
		
		img::delete('offer_category', $this->pk(), $this->category_image);
		
		$this->category_image = NULL;
		
		if($save)
		{
			$this->save();
		
			return $this->saved();
		}
		
		return TRUE;
	}
	
	public function delete($query = NULL)
	{
		if ( ! $this->_loaded)
			throw new Kohana_Exception('Cannot delete :model model because it is not loaded.', array(':model' => $this->_object_name));
		
		$categories = $this->get_descendants(TRUE);
		
		$child_cats = $categories->as_array(NULL, $this->primary_key());

		$offers = new Model_Offer;
		$offers->delete_by_category($child_cats);

		$offers_categories = new Model_Offer_To_Category;
		$offers_categories->delete_by_category($child_cats);
		
		foreach($categories as $category)
		{
			img::delete('offer_category', $category->pk(), $category->category_image);
		}

		DB::delete($this->table_name())
			->where($this->primary_key(), 'IN', $child_cats)
			->execute($this->_db);

		$root = new self(1);
		$root->rebuild_tree();
		
		$this->clear();
		
		return $this;
	}

	/**
	 * @return string
	 */
	public function get_icon_uri()
	{
		$manager = offers::get_category_icon_manager();

		return $manager->exists($this->pk()) ? $manager->get_uri($this->pk()) : NULL;
	}
	
}
