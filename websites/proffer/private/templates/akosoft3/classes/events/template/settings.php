<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Events_Template_Settings extends Event {
	
	public function on_form_appearance_create()
	{
		$form = $this->param('form');
		
		//Tab homepage modules
		
		$homepage_boxes_tab = $form->add_tab('homepage_boxes', ___('frontend.settings.home_boxes_tab'), array(
			'get_values_path' => 'templates.frontend',
			'set_values_path' => 'templates.frontend',
		));
		
		$on_off_select = array(
			FALSE => ___('frontend.settings.off'),
			TRUE => ___('frontend.settings.on'),
		);
		
		if(Modules::enabled('site_ads'))
		{
			$homepage_boxes_tab->add_collection('site_ads')
				->add_select('index_box_enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_ads.index_box_enabled'),
					'required' => FALSE,
				));
		}
		
		if(Modules::enabled('site_newsletter'))
		{
			$homepage_boxes_tab->add_collection('site_newsletter')
				->add_select('index_box_enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_newsletter.index_box_enabled'),
					'required' => FALSE,
				));
		}
		
		if(Modules::enabled('site_catalog'))
		{
			$homepage_boxes_tab->add_collection('site_catalog', array(
				'get_values_path' => 'site_catalog.widgets.recommended',
				'set_values_path' => 'site_catalog.widgets.recommended',
			))
				->add_select('enabled', $on_off_select, array(
					'label' => ___('frontend.settings.site_catalog.widgets.recommended.enabled'),
					'required' => FALSE,
				));
		}
		
		$homepage_boxes_tab->add_select('modules_box_enabled', $on_off_select, array(
				'label' => ___('frontend.settings.modules_box_enabled'),
				'required' => FALSE,
			));
		
	}
	
}

