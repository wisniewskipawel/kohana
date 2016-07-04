<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Controller_Frontend_Jobs_Notifier extends Controller_Jobs {
	
	public function action_index()
	{
		$form = Bform::factory('Frontend_Jobs_Notifier');
		
		if ($form->validate())
		{
			$values = $form->get_values();
			
			Model_Notifier::factory()->add_notify('site_jobs', $values);
			
			FlashInfo::add(___('jobs.notifier.success'), 'success');
			$this->redirect_referrer();
		}
		
		breadcrumbs::add(array(
			$this->template->set_title(___('jobs.notifier.title')) => '',
		));
		
		$this->template->content = View::factory('frontend/notifier/index')
			->set('form', $form);
	}
	
}