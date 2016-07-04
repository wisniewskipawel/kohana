<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Riddles extends Controller_Admin_Main {
	
	public function before()
	{
		parent::before();
		
		if(!$this->_auth->permissions('admin/settings/site'))
			throw new HTTP_Exception_403;
	}
	
	public function action_index()
	{
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'settings.title'		=> '/admin/settings',
			'settings.security.title'	=> '/admin/settings/security',
			$this->set_title(___('settings.security.riddles.title')) => 'admin/riddles',
		));
		
		$riddles = Kohana::$config->load('global.site.security.riddles');
		
		$this->template->content = View::factory('admin/settings/riddles/index')
				->set('riddles', $riddles);
	}
	
	public function action_add()
	{
		$form = BForm::factory('Admin_Settings_Riddle_Add');
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$riddle = array(
				'question' => Arr::get($values, 'question'),
				'answers' => Arr::get($values, 'answers'),
			);
			
			$riddles = Kohana::$config->load('global.site.security.riddles');
			$riddles[] = $riddle;
			
			Kohana::$config->load('global')->set('site.security.riddles', $riddles);
			
			FlashInfo::add(___('settings.security.riddles.add.success'));
			$this->redirect('admin/riddles/index');
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'settings.title'		=> '/admin/settings',
			'settings.security.title'	=> '/admin/settings/security',
			'settings.security.riddles.title' => 'admin/riddles',
			$this->set_title(___('settings.security.riddles.add.title')) => '',
		));
		
		$this->template->content = View::factory('admin/settings/riddles/add')
				->set('form', $form);
	}
	
	public function action_edit()
	{
		$riddle_id = (int)$this->request->param('id');
		$riddles = Kohana::$config->load('global.site.security.riddles');
		
		if(!isset($riddles[$riddle_id]))
		{
			throw new HTTP_Exception_404;
		}
		
		$form = BForm::factory('Admin_Settings_Riddle_Edit', array('riddle' => $riddles[$riddle_id]));
		
		if($form->validate())
		{
			$values = $form->get_values();
			
			$riddles[$riddle_id] = array(
				'question' => Arr::get($values, 'question'),
				'answers' => Arr::get($values, 'answers'),
			);
			
			Kohana::$config->load('global')->set('site.security.riddles', $riddles);
			
			FlashInfo::add(___('settings.security.riddles.edit.success'));
			$this->redirect('admin/riddles/index');
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			'settings.title'		=> '/admin/settings',
			'settings.security.title'	=> '/admin/settings/security',
			'settings.security.riddles.title' => 'admin/riddles',
			$this->set_title(___('settings.security.riddles.edit.title')) => '',
		));
		
		$this->template->content = View::factory('admin/settings/riddles/edit')
				->set('form', $form);
	}
	
	public function action_delete()
	{
		$riddle_id = (int)$this->request->param('id');
		$config = Kohana::$config->load('global');
		
		$riddles = Arr::path($config, 'site.security.riddles');
		
		if(!isset($riddles[$riddle_id]))
		{
			throw new HTTP_Exception_404;
		}
		$config->delete_group('site.security.riddles.'.$riddle_id);
		
		FlashInfo::add(___('settings.security.riddles.delete.success'));
		$this->redirect('admin/riddles/index');
	}
	
}
