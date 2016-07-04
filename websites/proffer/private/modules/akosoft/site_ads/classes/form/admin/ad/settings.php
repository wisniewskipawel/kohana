<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Ad_Settings extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->form_data($params);
		
		$this->add_collection('settings', array(
			'get_values_path' => 'site_ads.settings',
			'set_values_path' => 'site_ads.settings',
		));
		
		$this->settings->add_input_text('auto_refresh', array(
			'label' => 'ads.forms.settings.auto_refresh',
			'required' => FALSE,
		))
			->add_validator('auto_refresh', 'Bform_Validator_Integer');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
