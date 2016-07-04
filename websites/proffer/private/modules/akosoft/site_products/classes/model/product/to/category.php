<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Product_To_Category extends ORM {

	protected $_table_name = 'products_to_categories';
	protected $_primary_key = 'product_to_category_id';

	protected $_belongs_to = array(
		'product'	  => array('model' => 'products', 'foreign_key' => 'product_id')
	);
	
	public function delete_by_product($product)
	{
		if(empty($product))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('product_id', is_array($product) ? 'IN' : '=', $product)
			->execute($this->_db);
	}
	
	public function delete_by_category($category)
	{
		if(empty($category))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('category_id', is_array($category) ? 'IN' : '=', $category)
			->execute($this->_db);
	}

}

