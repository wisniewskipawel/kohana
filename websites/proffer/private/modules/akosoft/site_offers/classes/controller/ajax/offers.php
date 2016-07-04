<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Ajax_Offers extends Controller_Ajax_Main {
	  
	public function action_curtain()
	{
		$model = new Model_Offer();
		$model->add_active_conditions();
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		switch($this->request->query('show'))
		{
			case 'email':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body(HTML::mailto($model->contact_data()->email, URL::idna_decode($model->contact_data()->email)));
				break;
			
			case 'telephone':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body($model->contact_data()->phone);
				break;
			
			default:
				throw new HTTP_Exception_400;
		}
	}
	
}
