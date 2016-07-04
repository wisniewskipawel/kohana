<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Template_Products extends Controller_Products {
	
	public function action_home()
	{
		$from = $this->request->query('from');
		$products = NULL;
		
		$model = new Model_Product;
		
		switch($from)
		{
			case 'popular':
				$products = $model->get_popular(10);
				break;
			
			case 'promoted':
				$products = $model->get_promoted(10);
				break;
			
			default:
				$from = 'recent';
				$products = $model->get_last(10);
				break;
		}
		
		$this->template->content = View::factory('frontend/products/home')
			->set('from', $from)
			->set('products', $products);
	}
	
	public function action_contact()
	{
		$product = new Model_Product();
		$product->get_by_id((int)$this->request->param('id'));
		
		if(!$product->loaded())
		{
			throw new HTTP_Exception_404('Product not found! (:id)', array(
				':id' => $this->request->param('id'),
			));
		}
		
		$form = Bform::factory('Frontend_Product_SendMessage', array(
			'product' => $product,
		));

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_product');

			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
				'%product.title%'	=> $product->product_title,
				'%product.link%'	=> HTML::anchor(
					products::uri($product, 'http'),
					$product->product_title
				),
			));
			$product->send_email_message($email, NULL, array('reply_to' => $form->email->get_value()));
			
			FlashInfo::add(___('products.contact.success'), 'success');
			$this->redirect(Products::uri($product));
		}

		$this->template->content = View::factory('frontend/products/contact')
			->set('form', $form)
			->set('product', $product)
			->render();
	}
	
}
