<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Controller_Admin_Index extends Controller_Admin_Main {

	public function action_index()
	{
		breadcrumbs::add(array(
			'homepage' => '',
		));

		$this->template->content = View::factory('admin/index/index');
	}
	
	public function permissions()
	{
		if($this->request->action() == 'index')
		{
			return TRUE;
		}
		
		return parent::permissions();
	}

}
