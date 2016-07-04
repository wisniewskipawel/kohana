<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Controller_Frontend_Documents extends Controller_Frontend_Main {

	public function action_show()
	{
		$document = ORM::factory('Document', array('document_url' => $this->request->param('url', '')));
			
		if ( ! $document->loaded())
		{
			throw new HTTP_Exception_404(404);
		}
		
		if ($document->document_alias == 'contact')
		{
			$form = Bform::factory('Frontend_Contact');
			
			if ($form->validate())
			{
				$admins = ORM::factory('User')
						->with_groups(array('Administrator'))
						->find_all();
				
				foreach ($admins as $admin)
				{
					Email::send(
						$admin->user_email, 
						$form->subject->get_value(), 
						View::factory('email/documents/contact')
							->set('form_values', $form->get_values())
							->render(), 
						array('reply_to' => $form->email->get_value())
					);
				}
				
				FlashInfo::add(___('documents.contact.success'), 'success');
				$this->redirect_referrer();
			}
		}
		
		$meta_title = $document->document_meta_title;

		if (empty($meta_title)) {
			$meta_title = $document->document_title;
		}

		$this->template->set_title($meta_title);
		
		breadcrumbs::add(array(
			'homepage' => URL::site(),
			$meta_title => '',
		));

		$this->template->content = View::factory('frontend/documents/show')
				->set('document', $document)
				->bind('form', $form);

		$this->template->add_meta_name('keywords', $document->document_meta_keywords);
		$this->template->add_meta_name('description', Text::limit_chars(strip_tags($document->document_content), 180));
	}

	public function action_index()
	{
		$documents = ORM::factory('Document')
			->order_by('document_title', 'ASC')
			->find_all();
		
		$this->template->content = View::factory('documents/index')
				->set('documents', $documents);
	}
	
}
