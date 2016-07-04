<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Notifier extends Controller_Frontend_Main {
	
	public function action_confirm()
	{
		$notifier = new Model_Notifier();
		$notifier->filter_by_token($this->request->param('token'));
		$notifier->find_by_pk($this->request->param('id'));
		
		if($notifier->loaded())
		{
			$notifier->confirm_email();
			
			FlashInfo::add(___('notifiers.confirm.success'), 'success');
		}
		else
		{
			FlashInfo::add(___('notifiers.confirm.error'), 'error');
		}
		
		$this->redirect();
	}
	
	public function action_unsubscribe()
	{
		$notifier = new Model_Notifier();
		$notifier->filter_by_token($this->request->param('token'));
		$notifier->find_by_pk($this->request->param('id'));
		
		if($notifier->loaded())
		{
			$notifier->delete();
			
			FlashInfo::add(___('notifiers.unsubscribe.success'), 'success');
		}
		else
		{
			FlashInfo::add(___('notifiers.unsubscribe.error'), 'error');
		}
		
		$this->redirect();
	}
	
}
