<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Frontend_Ad_Add extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'ads.forms.ad_add');
		
		$this->add_input_text('ad_title')
			->add_validator('ad_title', 'Bform_Validator_Length', array('min' => 0, 'max' => 30))
			->add_validator('ad_title', 'Bform_Validator_Html');
		
		$this->add_textarea('ad_description')
			->add_validator('ad_description', 'Bform_Validator_Length', array('min' => 0, 'max' => 100))
			->add_validator('ad_description', 'Bform_Validator_Html');
		
		$this->add_input_text('ad_link')
			->add_filter('ad_link', 'Bform_Filter_IDNA')
			->add_validator('ad_link', 'Bform_Validator_Url')
			->add_validator('ad_link', 'Bform_Validator_Length', array('min' => 0, 'max' => 150));
		
		$display_length = ads::availabilities(Model_Ad::TEXT_C);
		$this->add_select('ad_availability', $display_length);
		
		$this->add_input_submit(___('ads.forms.ad_add.submit'));

		$this->template('site');
	}
	
}
