<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Ad_Add extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->add_input_text('ad_title');
		
		$types = ads::types();
		Arr::unshift($types, NULL, ___('select.choose'));
		
		$this->add_select('ad_type', $types)
			->add_validator('ad_type', 'Bform_Validator_Ad_AddAdmin', array(
				'dependencies_drivers_names' => array(
					'ad_description', 'ad_banner_link', 'ad_code', 
					'ad_availability', 'ad_link',
				),
			));
				
		$this->add_textarea('ad_description', array('required' => FALSE, 'row_class' => 'hidden ad-text'));
				
		$this->add_input_text('ad_banner_link', array('required' => FALSE, 'row_class' => 'hidden ad-banner'))
			->add_filter('ad_banner_link', 'Bform_Filter_IDNA')
			->add_validator('ad_banner_link', 'Bform_Validator_Url');
		
		$this->add_textarea('ad_code', array('required' => FALSE, 'row_class' => 'hidden ad-banner'));
				
		$this->add_input_text('ad_link', array('required' => FALSE, 'row_class' => 'ad-link'))
			->add_filter('ad_link', 'Bform_Filter_IDNA')
			->add_validator('ad_link', 'Bform_Validator_Url');
		
		$this->add_datepicker('ad_date_start', array(
			'required' => TRUE,
			'date_from' => date('Y-m-d'),
		));
		
		$this->add_datepicker('ad_availability', array(
			'date_from' => $this->form_data('ad_date_start') ? $this->form_data('ad_date_start') : date('Y-m-d'),
			'required' => TRUE, 
		));
		
		$this->add_input_text('ad_clicks', array('required' => FALSE));
		
		
		$users = ORM::factory('User')
				->with('user_data')
				->order_by('user_name', 'ASC')
				->find_all();
		
		$users_select = array(
			NULL => ___('select.choose'),
			'new' => ___('ads.new_user'),
		);
		
		foreach ($users as $u) 
		{
			$users_select[$u->user_id] = $u->user_name . ' (' . $u->user_email . ')';
		}
		
		$this->add_select('user_id', $users_select, array('label' => 'user', 'id' => 'ad-user', 'value' => Request::current()->query('user_id')));
				
		$this->add_input_text('user_name', array(
			'required' => ($this->form_data('user_id') == 'new'), 
			'row_class' => 'hidden ad-user',
		))
			->add_validator('user_name', 'Bform_Validator_Auth_Username');
		
		$this->add_input_email('user_email', array('label' => 'email', 'required' => ($this->form_data('user_id') == 'new'), 'row_class' => 'hidden ad-user'))
			->add_validator('user_email', 'Bform_Validator_Auth_Email');
			
		$this->add_input_text('users_data_telephone', array('label' => 'telephone', 'required' => FALSE, 'row_class' => 'hidden ad-user'));
		
		$this->add_input_text('user_pass', array(
			'label' => 'user_pass', 
			'required' => ($this->form_data('user_id') == 'new'), 
			'html_after' => '<a onclick="main.auth.generate_password(); return false;" href="#">'.___('users.generate_pass.btn').'</a>', 
			'row_class' => 'hidden ad-user', 
			'class' => 'password',
		));
			
		$this->add_input_submit(___('form.save'));
	}
	
}
