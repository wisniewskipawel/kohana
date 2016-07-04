<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Admins_Add extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->add_input_text('user_name')
			->add_validator('user_name', 'Bform_Validator_Auth_Username');
		
		$this->add_input_email('user_email')
			->add_validator('user_email', 'Bform_Validator_Auth_Email');
		
		$this->add_input_password('user_pass');
		
		$groups_orm = Model_User_Group::factory()->find_all();
		
		$this->add_fieldset('groups', ___('user_groups'), array(
			'get_values_path' => 'groups',
			'set_values_path' => 'groups',
		));

		foreach ($groups_orm as $i => $g) 
		{
			$this->groups->add_input_checkbox($g->pk(), $g->group_name, array(
				'id' => 'user_group_'.$i,
				'html_after' => $g->group_description,
				'label' => $g->group_name,
				'required' => FALSE,
			));
		}
		
		$this->add_collection('data');
		
		$person_types = BAuth::person_types();
		$this->data->add_select('users_data_person_type', $person_types, array('label' => 'users_data_person_type', 'required' => FALSE));
		
		$this->data->add_input_text('users_data_person', array('label' => 'users_data_person', 'required' => FALSE))
			->add_validator('users_data_person', 'Bform_Validator_Html');
		
		$provinces = Regions::provinces();
		$this->data->add_select('users_data_province', Arr::unshift($provinces, NULL, ___('select.choose')), array(
			'label' => 'province',
			'class' => 'provinces', 
			'required' => FALSE,
		));

		$counties = array(NULL => '');
		
		if($this->form_data('data.users_data_province'))
		{
			$counties += Regions::counties($this->form_data('data.users_data_province'));
		}

		$this->data->add_select('users_data_county', $counties, array('label' => 'county', 'class' => 'counties', 'required' => FALSE));
		
		$this->data->add_input_text('users_data_city', array('label' => 'city', 'required' => FALSE))
			->add_validator('users_data_city', 'Bform_Validator_Html');
		
		$this->data->add_input_text('users_data_postal_code', array('label' => 'postal_code', 'required' => FALSE))
			->add_validator('users_data_postal_code', 'Bform_Validator_Html');
		
		$this->data->add_input_text('users_data_street', array('label' => 'street', 'required' => FALSE))
			->add_validator('users_data_street', 'Bform_Validator_Html');
		
		$this->data->add_input_text('users_data_telephone', array('label' => 'telephone', 'required' => FALSE))
			->add_validator('users_data_telephone', 'Bform_Validator_Html');
		
		$this->data->add_input_text('users_data_fax', array('label' => 'fax', 'required' => FALSE))
			->add_validator('users_data_fax', 'Bform_Validator_Html');
		
		$this->data->add_input_text('users_data_www', array('label' => 'www', 'required' => FALSE))
			->add_filter('users_data_www', 'Bform_Filter_IDNA')
			->add_validator('users_data_www', 'Bform_Validator_Url');
		
		$this->add_input_submit(___('form.save'));
	}
}
