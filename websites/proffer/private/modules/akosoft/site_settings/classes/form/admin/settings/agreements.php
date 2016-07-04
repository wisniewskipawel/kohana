<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_Agreements extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'settings.forms.agreements');
		$this->form_data($params);
		
		$this->add_collection('agreements', array(
			'get_values_path' => 'agreements',
			'set_values_path' => 'agreements',
		));
		
		$this->agreements->add_textarea('terms');
		$this->agreements->add_textarea('trading');
		$this->agreements->add_textarea('ads');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
