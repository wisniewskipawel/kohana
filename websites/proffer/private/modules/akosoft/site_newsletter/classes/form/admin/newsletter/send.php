<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Newsletter_Send extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'newsletter.forms.send');
		
		$this->add_input_text('letter_subject');
		
		$this->add_editor('letter_message', array(
			'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
			'placeholders' => array(
				'unsubscribe' => ___('newsletter.forms.send.letter_message_placeholders.unsubscribe'),
			),
		));
		
		$this->add_datetime('queue_send_at', array(
			'value' => date('Y-m-d H:i'),
		));
		
		$this->add_select('accepted_ads', array(
			NULL => ___('newsletter.forms.send.accepted_ads_values.all'),
			'1' => ___('newsletter.forms.send.accepted_ads_values.accepted_ads'),
		), array(
			'required' => FALSE,
		));
		
		$this->add_input_submit(___('form.send'));
	}
	
}
