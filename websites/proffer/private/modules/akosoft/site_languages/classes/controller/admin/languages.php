<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Languages extends Controller_Admin_Main {
	
	public function action_index()
	{
		$languages = Languages::all();
		
		$this->template->content = View::factory('admin/languages/index')
				->set('languages', $languages);
		
		breadcrumbs::add(array(
			'homepage'		=> '/admin',
			$this->set_title(___('languages.admin.settings.title'))	=> '/admin/languages'
		));
	}
	
	public function action_set_default()
	{
		Languages::set_default($this->request->query('name'));
		
		FlashInfo::add(___('languages.admin.set_default.success'), 'success');
		$this->redirect('/admin/languages');
	}
	
}
