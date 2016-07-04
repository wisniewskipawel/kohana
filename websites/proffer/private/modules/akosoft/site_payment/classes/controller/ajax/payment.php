<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Ajax_Payment extends Controller_Ajax_Main {
	
	public function action_get_payment_info()
	{
		$query = $this->request->query();
		
		if(empty($query['payment_module']) OR empty($query['provider']))
		{
			throw new HTTP_Exception_404('No required payment parameters!');
		}
		
		$payment_module = payment::load_payment_module($query['payment_module']);
		$payment_module->place($this->request->query('place'));
		$payment_module->discount($this->request->query('discount'));
		
		$provider = payment::load_provider($query['provider']);
		$payment_module->provider($provider);
		
		$this->response->body($payment_module->provider()->get_text($this->request->query('text_type'), $this->request->query('type')));
	}
	
}
