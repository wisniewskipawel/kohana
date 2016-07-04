<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Newsletter extends Controller_Frontend_Main {
    
	public function action_submit()
	{
		$form = Bform::factory('Frontend_Newsletter_Subscribe');
		
		if ($form->validate()) 
		{
			$values = $form->get_values();
			
			$result = Newsletter::subscribe(Arr::get($values, 'email'), !empty($values['accept_ads']));
		
			if ($result) 
			{
				if(empty($values['accept_ads']))
				{
					FlashInfo::add(___('newsletter.subscribe.success'), FlashInfo::SUCCESS);
				}
			} 
			else 
			{
				FlashInfo::add(___('newsletter.subscribe.error'), FlashInfo::ERROR);
			}
		
			$this->redirect_referrer();
		}
		
		$this->template->content = View::factory('frontend/newsletter/subscribe')
			->set('form', $form);
	}
	
	public function action_unsubscibe()
	{
		$subsciber = new Model_Newsletter_Subscriber;
		$subsciber->filter_by_token($this->request->param('token'));
		$subsciber->find_by_pk($this->request->param('id'));
		
		if(!$subsciber->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$subsciber->delete();
		
		$this->template->content = View::factory('frontend/newsletter/unsubscribe');
	}
	
	public function action_confirmation()
	{
		$subsciber = new Model_Newsletter_Subscriber;
		$subsciber->filter_by_token($this->request->param('token'));
		$subsciber->find_by_pk($this->request->param('id'));
		
		if(!$subsciber->loaded())
		{
			throw new HTTP_Exception_404;
		}
		
		$subsciber->confirm();
		
		$this->template->content = View::factory('frontend/newsletter/confirmation');
	}
	
}
