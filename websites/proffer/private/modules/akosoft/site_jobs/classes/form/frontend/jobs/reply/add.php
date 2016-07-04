<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Frontend_Jobs_Reply_Add extends BForm_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'jobs.replies.forms');
		
		$this->add_textarea('content', array('chars_counter' => 1000))
			->add_validator('content', 'Bform_Validator_Html')
			->add_validator('content', 'Bform_Validator_Length', array('max' => 1000));
		
		$this->add_input_text('price', array('required' => FALSE))
			->add_filter('price', 'Bform_Filter_Float')
			->add_validator('price', 'Bform_Validator_Html')
			->add_validator('price', 'Bform_Validator_Range', array('min' => 0, 'max' => 999999999));
		
		$price_units = Model_Job_Reply::get_price_units();
		$this->add_select('price_unit', Arr::unshift($price_units, NULL, ''), array('required' => FALSE));
		
		$this->add_input_submit(___('form.add'));
	}
	
}