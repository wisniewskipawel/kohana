<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Product_Type extends ORM {

	protected $_table_name = 'product_types';
	protected $_primary_key = 'id';

	public function get_for_select() 
	{
		return $this->find_all()
			->as_array($this->primary_key(), 'name');
	}

	public function get_admin() 
	{
		$this->select(array(DB::expr('
			(
				SELECT
					COUNT(*)
				FROM
					products
				WHERE
					product_type = id
			)
		'), 'products_count'));
		
		return $this->find_all();
	}

}
