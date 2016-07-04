<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Print_Products extends Controller_Print {
	
	public function action_index()
	{
		$product = Model_Product::factory()
			->get_by_id($this->request->param('id'));
		
		if(!$product->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$this->template->content = View::factory('print/products')
			->set('product', $product)
			->render();
	}
	
}