<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Model_Offer_To_Category extends ORM {

	protected $_table_name = 'offers_to_categories';
	protected $_primary_key = 'offer_to_category_id';
	protected $_primary_val = 'offer_id';

	protected $_belongs_to = array(
		'offer'	  => array('model' => 'Offers', 'foreign_key' => 'offer_id')
	);
	
	public function delete_by_offer($offer)
	{
		if(empty($offer))
		{
			return;
		}
		
		DB::delete($this->table_name())
			->where('offer_id', is_array($offer) ? 'IN' : '=', $offer)
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

