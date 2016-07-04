<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Adsystem_Index extends Controller_Adsystem_Main {

	public function action_index()
	{
		$ads = ORM::factory('Ad')
				->where('user_id', '=', $this->_session->get('user_id', 0))
				->find_all();

		breadcrumbs::add(array(
			'ads.adsystem.title'		=> '/adsystem',
			'ads.adsystem.index.title'		=> '/adsystem/'
		));

		$this->template->content = View::factory('adsystem/index/index')
				->set('ads', $ads);
	}

}
