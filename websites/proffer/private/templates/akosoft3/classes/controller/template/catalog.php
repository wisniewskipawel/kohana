<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Template_Catalog extends Controller_Catalog {
	
	public function action_contact()
	{
		$company = new Model_Catalog_Company();
		$company->get_by_id((int)$this->request->param('id'));
		
		if(!$company->loaded())
		{
			throw new HTTP_Exception_404('Company not found! (:id)', array(
				':id' => $this->request->param('id'),
			));
		}
		
		$form = Bform::factory('Frontend_Catalog_SendMessage', array(
			'company' => $company,
		));

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_company');
			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
			));
			$email->send($company->company_email, array(
				'reply_to' => $form->email->get_value(),
			));
			
			FlashInfo::add(___('catalog.companies.contact.success'), 'success');
			
			$this->redirect(catalog::url($company));
		}

		$this->template->content = View::factory('frontend/catalog/contact')
			->set('form', $form)
			->set('company', $company)
			->render();
	}
	
}
