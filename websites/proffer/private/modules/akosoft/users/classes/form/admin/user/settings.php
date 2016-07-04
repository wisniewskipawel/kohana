<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_User_Settings extends Bform_Form {
	
	public function  create(array $params = array())
	{
		$this->form_data($params);
		
		$this->add_fieldset('facebook', 'Facebook', array(
			'get_values_path' => 'bauth.facebook',
			'set_values_path' => 'bauth.facebook',
		));
		
		$this->facebook->add_bool('enabled', array('label' => 'users.facebook.settings.enable'));
		
		$this->facebook->add_html(___('users.facebook.settings.info', array(
			':link' => HTML::anchor('https://developers.facebook.com/apps', ___('users.facebook.settings.info.link'), array('target' => '_blank')),
		)), array(
			'no_decorate' => TRUE,
		));

		if(Kohana::$environment !== Kohana::DEMO)
		{
			$this->facebook->add_input_text('app_id', array('label' => 'App ID', 'required' => !!$this->form_data('bauth.facebook.enabled')));
			$this->facebook->add_input_text('app_secret', array('label' => 'App Secret', 'required' => !!$this->form_data('bauth.facebook.enabled')));
		}
		else
		{
			$this->facebook->add_html(___('demo_mode_error'));
		}
		
		$this->add_input_submit(___('form.save'));
	}
}
