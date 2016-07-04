<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Modules extends Controller_Admin_Main {

	public function action_index()
	{
		$modules = Modules::instance()->get_available_list();
		
		breadcrumbs::add(array(
			'homepage' => URL::site('admin'),
			$this->set_title(___('modules.title')) => URL::site('admin/modules'),
		));
		
		$this->template->content = View::factory('admin/bmodules/index')
				->set('modules', $modules);
	}
	
	public function action_disable()
	{
		if(Kohana::$environment == Kohana::DEMO)
		{
			FlashInfo::add(___('demo_mode_error'), 'error');
			$this->redirect_referrer();
		}
		
		$name = $this->request->query('name');
		
		if ( ! empty($name))
		{
			$config = Kohana::$config->load('modules');
			$config->set($name, array(
				'enabled'   => FALSE,
			));
			
			FlashInfo::add(___('modules.disable.success'), 'success');
		}
		
		try 
		{
			Cache::instance()->delete_all();
		}
		catch(Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
		}
		
		$this->redirect_referrer();
	}
	
	public function action_enable()
	{
		if(Kohana::$environment == Kohana::DEMO)
		{
			FlashInfo::add(___('demo_mode_error'), 'error');
			$this->redirect_referrer();
		}
		
		$name = $this->request->query('name');
		
		if ( ! empty($name))
		{
			$config = Kohana::$config->load('modules');
			$config->set($name, array(
				'enabled'   => TRUE,
			));
			
			FlashInfo::add(___('modules.enable.success'), 'success');
			
		}
		
		try 
		{
			Cache::instance()->delete_all();
		}
		catch(Exception $e)
		{
			Kohana_Exception::log($e, Log::ERROR);
		}
		
		$this->redirect_referrer();
	}
}
