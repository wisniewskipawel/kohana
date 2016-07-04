<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Cron_Products extends Controller_Cron_Main {
	
	public function action_expiring()
	{
		$products = ORM::factory('Product')
				->with('user')
				->with('catalog_company')
				->filter_by_expiring(2)
				->find_all();
		
		$i = 0;
		
		foreach ($products as $product)
		{
			if ($product->has_user()) 
			{
				$email = Model_Email::email_by_alias('products_expiring_registered');
				
				$email->set_tags(array(
					'%renew_link%'	=> HTML::anchor(
						Route::url('site_products/profile/products/renew', array('id' => $product->pk()), 'http'), 
						___('products.email.expiring.renew_link')
					),
					'%product_link%'	=> HTML::anchor(products::uri($product, 'http'), $product->product_title),
				));
				$email->send($product->user->user_email);
			}
			elseif ($product->get_email_address()) 
			{
				$email = Model_Email::email_by_alias('products_expiring_not_registered');
				
				$email->set_tags(array(
					'%add_link%'		=> HTML::anchor(
						Route::url('site_products/frontend/products/add', NULL, 'http'), 
						___('products.email.expiring.add_link')
					),
					'%product_link%'	=> HTML::anchor(products::uri($product, 'http'), $product->product_title),
				));
				$product->send_email_message($email);
			}
			$i++;
		}
		
	}
	
}
