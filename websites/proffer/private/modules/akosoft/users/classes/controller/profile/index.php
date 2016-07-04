<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Profile_Index extends Controller_Profile_Main {
	
	public function action_index() 
	{
		$this->template->content = View::factory('profile/profile/index');

		breadcrumbs::add(array(
			'homepage'			=> '/',
			$this->template->set_title(___('profile'))	=> '',
		));
	}
}
