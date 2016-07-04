<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Settings_Security extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'settings.forms.security');
		
		$this->form_data($params);
		
		$this->add_tab('forms', ___('settings.forms.security.forms'), array(
			'get_values_path' => 'site.security',
			'set_values_path' => 'site.security',
		));
		
		$this->forms->add_select('type', array(
			'captcha'	=> 'Captcha',
			'riddles'	=> ___('settings.forms.security.types.riddles'),
		), array(
			'label' => 'settings.forms.security.type',
		));
		
		if($this->form_data('site.security.type') == 'riddles')
		{
			$this->forms->add_html(HTML::anchor(
				'admin/riddles', 
				___('settings.forms.security.riddles_link'),
				array('class' => 'button')
			));
		}
		
		$this->add_input_submit(___('form.save'));
	}
	
}
