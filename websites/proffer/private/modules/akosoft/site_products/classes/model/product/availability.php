<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Product_Availability extends ORM {

	protected $_table_name = 'product_availabilities';
	protected $_primary_key = 'id';

	public function get_for_select() 
	{
		$this->order_by('availability', 'ASC');
		return $this->find_all()->as_array('availability', 'availability');
	}
	
	public function get_admin() 
	{
		$this->order_by('availability', 'ASC');
		return $this->find_all();
	}

}
