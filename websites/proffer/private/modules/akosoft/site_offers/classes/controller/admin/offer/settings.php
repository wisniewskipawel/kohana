<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Admin_Offer_Settings extends Controller_Admin_Main {

	public function action_index()
	{
		$config = Kohana::$config->load('modules');

		$form = Bform::factory('Admin_Offer_Settings', offers::config());

		if ($form->validate())
		{
			$values = $form->get_values();
			$config->set('site_offers.settings', $values);
			
			FlashInfo::add(___('offers.admin.settings.success'), 'success');
			$this->redirect_referrer();
		}

		breadcrumbs::add(array(
			'homepage'			=> '/',
			'offers.title'			=> '/admin/offers',
			$this->set_title(___('offers.admin.settings.title'))	=> '/admin/offer/settings/index'
		));

		$this->template->content = View::factory('admin/offers/settings')
				->set('form', $form);
	}

}
