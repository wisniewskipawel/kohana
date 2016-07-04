<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_Riddle_Add extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'settings.forms.riddles');
		
		$this->add_input_text('question');
		
		$this->add_textarea('answers', array(
			'html_before' => ___('settings.forms.riddles.answers_info'),
		));
		
		$this->add_input_submit(___('form.save'));
	}
	
}