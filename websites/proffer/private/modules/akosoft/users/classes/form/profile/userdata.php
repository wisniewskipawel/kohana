<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Profile_UserData extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->form_data($params['user']->data->as_array());
		
		$person_types = BAuth::person_types();
		$this->add_select('users_data_person_type', $person_types, array('required' => FALSE));
		
		$this->add_input_text('users_data_person', array('required' => FALSE))
			->add_validator('users_data_person', 'Bform_Validator_Html');
		
		$provinces = Regions::provinces();
		$this->add_select('users_data_province', Arr::unshift($provinces, NULL, ___('select.choose')), array(
			'label' => 'province', 
			'class' => 'provinces', 
			'required' => FALSE,
		));

		$counties = array(NULL => '');
		
		if($this->form_data('users_data_province'))
		{
			$counties += Regions::counties($this->form_data('users_data_province'));
		}

		$this->add_select('users_data_county', $counties, array('label' => 'county', 'class' => 'counties', 'required' => FALSE));
		
		$this->add_input_text('users_data_city', array('label' => 'city', 'required' => FALSE))
				->add_validator('users_data_city', 'Bform_Validator_Html');
		
		$this->add_input_text('users_data_postal_code', array('label' => 'postal_code', 'required' => FALSE))
				->add_validator('users_data_postal_code', 'Bform_Validator_Html');
		
		$this->add_input_text('users_data_street', array('label' => 'street', 'required' => FALSE))
				->add_validator('users_data_street', 'Bform_Validator_Html');
		
		$this->add_input_text('users_data_telephone', array('label' => 'telephone', 'required' => FALSE))
				->add_validator('users_data_telephone', 'Bform_Validator_Html');
		
		$this->add_input_text('users_data_fax', array('label' => 'fax', 'required' => FALSE))
				->add_validator('users_data_fax', 'Bform_Validator_Html');
		
		$this->add_input_text('users_data_www', array('label' => 'www', 'required' => FALSE))
			->add_filter('users_data_www', 'Bform_Filter_IDNA')
			->add_validator('users_data_www', 'Bform_Validator_Url');
		
		$this->add_input_submit(___('form.save'));
	}
	
}