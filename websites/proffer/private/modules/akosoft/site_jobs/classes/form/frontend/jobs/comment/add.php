<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Frontend_Jobs_Comment_Add extends BForm_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'jobs.comments.forms');
		
		$this->add_textarea('body', array('chars_counter' => 1000))
			->add_validator('body', 'Bform_Validator_Html')
			->add_validator('body', 'Bform_Validator_Length', array('max' => 1000));
		
		$this->add_input_submit(___('form.add'));
	}
	
}