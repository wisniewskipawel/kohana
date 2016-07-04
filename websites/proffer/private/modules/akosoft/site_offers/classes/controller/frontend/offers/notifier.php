<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Offers_Notifier extends Controller_Offers {
	
	public function action_index()
	{
		$form = Bform::factory('Frontend_Offer_Notifier');
		
		if ($form->validate())
		{
			$values = $form->get_values();
			
			ORM::factory('Notifier')->add_notify('site_offers', $values);
			FlashInfo::add(___('offers.notifier.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			$this->template->set_title(___('offers.notifier.title')) => '',
		));
		
		$this->template->content = View::factory('frontend/notifier/index')
				->set('form', $form);
	}
	
}