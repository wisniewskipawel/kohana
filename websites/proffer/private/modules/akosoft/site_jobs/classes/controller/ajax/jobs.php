<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Controller_Ajax_Jobs extends Controller_Ajax_Main {

	public function action_on_category_change()
	{
		$category_id = $this->request->query('category_id');
		$category = new Model_Job_Category((int)$category_id);
		$form_id = $this->request->query('form_id');
		$get = $this->request->query('get');

		if(!$category->loaded())
		{
			throw new HTTP_Exception_404;
		}

		$form = Bform::factory($form_id ? $form_id : 'Frontend_Jobs_Add', array(), array(), FALSE);
		$form->template('site');

		$data = array();

		if($get != 'attributes')
		{
			if($form->add_partial_categories($category))
			{
				$data['categories'] = $form->render_partial('category_id');
			}
		}
		
		if(!$category->has_children() OR $get == 'attributes')
		{
			if($form->add_partial_attributes($category))
			{
				$data['attributes'] = $form->render_partial(NULL, 'jobs/forms/partials/attributes');
			}
		}

		$this->response->body(json_encode($data));
	}
	
	public function action_curtain()
	{
		$model = new Model_Job();
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		switch($this->request->query('show'))
		{
			case 'email':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body(HTML::mailto($model->get_email_address(), URL::idna_decode($model->get_email_address())));
				break;
			
			case 'telephone':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body($model->contact_data()->phone);
				break;
			
			default:
				throw new HTTP_Exception_400;
		}
	}
	
	public function action_curtain_reply()
	{
		$model = new Model_Job_Reply();
		$model->find_by_pk($this->request->param('id'));
		
		if(!$model->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		switch($this->request->query('show'))
		{
			case 'email':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body(HTML::mailto($model->get_email_address(), URL::idna_decode($model->get_email_address())));
				break;
			
			case 'telephone':
				$this->response->headers('X-Robots-Tag', 'noindex, nofollow');
				$this->response->body($model->get_user()->contact_data()->phone);
				break;
			
			default:
				throw new HTTP_Exception_400;
		}
	}
	
	public function action_field_type_change()
	{
		$form = Bform::factory('Admin_Jobs_Field_Add', array(), array(), FALSE);
		
		$form->on_type_change($this->request->query('type'), TRUE);
		
		$this->response->body($form->options->render(TRUE));
	}
	
}
