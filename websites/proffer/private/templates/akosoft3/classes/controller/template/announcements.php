<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Controller_Template_Announcements extends Controller_Announcements {
	
	public function action_home()
	{
		$from = $this->request->query('from');
		$announcements = NULL;
		
		$model = new Model_Announcement;
		
		switch($from)
		{
			case 'popular':
				$announcements = $model->get_popular(10);
				break;
			
			case 'promoted':
				$announcements = $model->get_promoted(10);
				break;
			
			default:
				$from = 'recent';
				$announcements = $model->get_last(10);
				break;
		}
		
		$this->template->content = View::factory('frontend/announcements/home')
			->set('from', $from)
			->set('announcements', $announcements);
	}
	
	public function action_contact()
	{
		$announcement = new Model_Announcement();
		$announcement->get_by_id((int)$this->request->param('id'));
		
		if(!$announcement->loaded())
		{
			throw new HTTP_Exception_404('Announcement not found! (:id)', array(
				':id' => $this->request->param('id'),
			));
		}
		
		$form = Bform::factory('Frontend_Announcement_SendMessage', array(
			'announcement' => $announcement,
		));

		if($form->validate())
		{
			$email = Model_Email::email_by_alias('send_to_announcement');

			$email->set_tags(array(
				'%email.subject%'	   => $form->subject->get_value(),
				'%email.message%'	   => $form->message->get_value(),
				'%email.from%'		  => $form->email->get_value(),
				'%announcement.title%'	=> $announcement->annoucement_title,
				'%announcement.link%'	=> HTML::anchor(
					announcements::url($announcement, 'http'),
					$announcement->annoucement_title
				),
			));
			$email->send($announcement->annoucement_email, array('reply_to' => $form->email->get_value()));
			FlashInfo::add(___('announcements.sendmessage.success'), 'success');
			
			$this->redirect(announcements::uri($announcement));
		}

		$this->template->content = View::factory('frontend/announcements/contact')
			->set('form', $form)
			->set('announcement', $announcement)
			->render();
	}
	
}
