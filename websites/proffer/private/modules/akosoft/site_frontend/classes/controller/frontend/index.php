<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Index extends Controller_Frontend_Main {

	public function action_index() 
	{
		breadcrumbs::add(array('homepage' => '/'));

		$this->template->content = View::factory('index/index');
	}

}
