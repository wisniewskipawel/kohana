<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Emails extends Controller_Admin_Main {
    
	public function action_index() 
	{
		$filters = $this->request->query();
		
		$config = Kohana::$config->load('emails.groups');
		
		$model = new Model_Email;
		
		if(!empty($filters['type']))
		{
			$emails_type = Arr::get($config, $filters['type']);
			
			if(!$emails_type)
			{
				throw new HTTP_Exception_404;
			}
			
			$model->where('email_alias', 'IN', $emails_type['emails']);
		}
			
		$emails = $model->order_by('email_description', 'ASC')
				->find_all();

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings'		=> '/admin/settings',
			$this->set_title(___('emails.title'))	=> '/admin/emails',
		));
		
		$types = Arr::pluck($config, 'label', TRUE);

		$this->template->content = View::factory('admin/emails/index')
			->set('emails', $emails)
			->set('types', $types)
			->set('filters', $filters);
	}

	public function action_edit() 
	{
		$email = ORM::factory('email', $this->request->param('id'));

		$form = Bform::factory('Admin_Email_Edit', $email->as_array());

		if ($form->validate()) 
		{
			$email->values($form->get_values())->save();
			FlashInfo::add(___('emails.edit.success'), 'success');
			$this->redirect('/admin/emails');
		}

		breadcrumbs::add(array(
			'homepage'	=> '/admin',
			'settings'		=> '/admin/settings',
			'emails.title'	=> '/admin/emails',
			$this->set_title(___('emails.edit.title')) => '',
		));

		$this->template->content = View::factory('admin/emails/edit')
				->set('form', $form);
	}
}
