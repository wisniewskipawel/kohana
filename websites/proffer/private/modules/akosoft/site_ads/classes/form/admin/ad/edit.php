<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Ad_Edit extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->add_input_text('ad_title');
		
		if ($params['ad_type'] == Model_Ad::TEXT_C OR $params['ad_type'] == Model_Ad::TEXT_C1) 
		{
			$this->add_textarea('ad_description');
		}
		else
		{
			$this->add_input_text('ad_banner_link', array('required' => FALSE))
				->add_filter('ad_banner_link', 'Bform_Filter_IDNA')
				->add_validator('ad_banner_link', 'Bform_Validator_Url');
			
			$this->add_textarea('ad_code', array('required' => FALSE));
		}
		
		$this->add_input_text('ad_link', array('required' => FALSE))
			->add_filter('ad_link', 'Bform_Filter_IDNA')
			->add_validator('ad_link', 'Bform_Validator_Url');
		
		$this->add_datepicker('ad_date_start', array(
			'required' => TRUE,
		));
		
		$this->add_datepicker('ad_availability', array(
			'date_from' => $this->form_data('ad_date_start') ? $this->form_data('ad_date_start') : date('Y-m-d'),
		));
		
		$this->add_input_text('ad_clicks');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
