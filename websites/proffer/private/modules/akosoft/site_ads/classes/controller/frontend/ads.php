<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Ads extends Controller_Frontend_Main {
	
	public function action_go_to() 
	{
		$ad = ORM::factory('Ad', $this->request->param('id'));
		
		if ( ! $ad->ad_id) 
		{
			throw new HTTP_Exception_404(404);
		}
		
		$ad->inc_clicks();
		
		$this->redirect(Tools::link($ad->ad_link));
	}

	public function action_add_text_ad_pre() 
	{
		if (Modules::enabled('site_documents')) 
		{
			$document = ORM::factory('Document')->where('document_alias', '=', 'text_ads_terms')->find();
		}
		
		breadcrumbs::add(array(
			'homepage'		=> '/',
			$this->template->set_title(___('ads.add_text.title'))	=> ''
		));

		$this->template->content = View::factory('frontend/ads/add_text_ad_pre')
				->bind('document', $document);
	}

	public function action_add_text_ad() 
	{
		if (Modules::enabled('site_documents')) 
		{
			$document = ORM::factory('Document')->where('document_alias', '=', 'add_text_ad')->find();
		}
		
		$payment_module = new Payment_Ad;
		$payment_module->place('ad_'.Model_Ad::TEXT_C);
		
		$form = Bform::factory('Frontend_Ad_Add', array('payment_module' => $payment_module));

		if ($form->validate()) 
		{
			$values = $form->get_values();
			$ad = ORM::factory('Ad')->add_text_ad_site($values, $this->_current_user ? $this->_current_user : NULL);
			
			$payment_module->set_params(array(
				'id' => $ad->pk(), 
				'availability_span' => Arr::get($values, 'ad_availability'),
			));
			$payment_module->load_object($ad);
			$payment_module->pay(Arr::get($values, 'payment_method'));
		}

		breadcrumbs::add(array(
			'homepage'	=> '/',
			$this->template->set_title(___('ads.add_text.title'))   => ''
		));

		$this->template->content = View::factory('frontend/ads/add_text_ad')
				->set('form', $form)
				->bind('document', $document)
				->set('payment_module', $payment_module);
	}

}
