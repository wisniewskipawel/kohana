<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Events_Products_User extends Events {
	
	public function on_with_statistics()
	{
		$model = $this->param('model');
		
		$model->select(array(DB::expr('
				(
					SELECT
						COUNT(*)
					FROM
						products
					WHERE
						products.user_id = user.user_id AND 
						(products.product_distinction = '.Model_product::DISTINCTION_NONE.')
				)
			'), 'products_normal_count'));
		
		$model->select(array(DB::expr('
				(
					SELECT
						COUNT(*)
					FROM
						products
					WHERE
						products.user_id = user.user_id AND (products.product_distinction = '.Model_product::DISTINCTION_PREMIUM.')
				)
			'), 'products_promoted_count'));
	}
	
}