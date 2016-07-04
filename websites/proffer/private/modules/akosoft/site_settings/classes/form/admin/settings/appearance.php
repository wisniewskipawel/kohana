<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/
class Form_Admin_Settings_Appearance extends Bform_Form {
	
	public function  create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'settings.appearance.form');
		$this->form_data($params);
		
		$this->add_tab('general', ___('settings.appearance.form.general_tab'), array(
			'get_values_path' => 'site',
			'set_values_path' => 'site',
		));
		
		//Tab layout
		
		$this->add_tab('layout', ___('settings.appearance.form.layout_tab'), array(
			'get_values_path' => 'layout',
			'set_values_path' => 'layout',
		));
		
		if(Kohana::$environment != Kohana::DEMO)
		{
			$this->layout->add_input_text('google_analytics_account', array('required' => FALSE));
		}
		
		$this->layout->add_input_text('copyright_text', array('required' => FALSE));
		$this->layout->add_input_text('home_header_text', array('required' => FALSE));
		
		$this->layout->add_collection('cookie_alert', array(
			'get_values_path' => 'cookie_alert',
			'set_values_path' => 'cookie_alert',
		));
		
		$this->layout->cookie_alert->add_bool('enabled', array('required' => FALSE));
		
		$this->layout->cookie_alert->add_editor('text', array('editor_type' => 'simple_admin', 'required' => FALSE));
		
		if(Modules::enabled('site_overlay'))
		{
			$overlay_types = array(NULL => ___('overlay.settings.disabled'));

			if(Modules::enabled('site_newsletter'))
			{
				$overlay_types['newsletter'] = ___('newsletter.title');
			}

			if(Modules::enabled('site_notifier'))
			{
				if(Modules::enabled('site_announcements'))
				{
					$overlay_types['announcements'] = ___('announcements.notifier.title');
				}
				
				if(Modules::enabled('site_offers'))
				{
					$overlay_types['offers'] = ___('offers.notifier.title');
				}
			}
			
			$this->layout->add_collection('overlay');
			$this->layout->overlay->add_select('type', $overlay_types, array('required' => FALSE));

			$hot_info_fs = $this->layout->add_fieldset('hot_info_slider', $this->trans('layout.hot_info_slider.label'), array(
				'set_values_path' => 'hot_info_slider',
				'get_values_path' => 'hot_info_slider',
			));

			$hot_info_fs->add_bool('enabled');
			$hot_info_fs->add_input_text('url', array(
				'required' => $this->get_form_value('layout.hot_info_slider.enabled'),
			))
				->add_validator('url', 'Bform_Validator_URL');

			$hot_info_fs->add_input_text('text', array(
				'required' => $this->get_form_value('layout.hot_info_slider.enabled'),
			));

			$hot_info_fs->add_colorpicker('color', array(
				'required' => $this->get_form_value('layout.hot_info_slider.enabled'),
			));

			$hot_info_fs->add_colorpicker('background', array(
				'required' => $this->get_form_value('layout.hot_info_slider.enabled'),
			));
		}
		
		Events::fire('settings/form_appearance_create', array(
			'form' => $this,
		));
		
		$this->add_input_submit(___('form.save'));
	}
	
}
