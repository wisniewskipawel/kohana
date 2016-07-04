<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Admin_Catalog_Settings extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'catalog.admin.settings');
		
		$this->form_data($params);
		
		$this->add_tab('general', ___('catalog.admin.settings.general_tab'));
		
		$this->general->add_input_text('header_tab_title');
		
		$this->general->add_bool('map', array('label' => 'catalog.admin.settings.map'));
		$this->general->add_bool('email_view_disabled', array('label' => 'catalog.admin.settings.email_view_disabled'));

		$promotion_types = new Catalog_Company_Promotion_Types();

		$promotion_types_fs = $this->general->add_fieldset('promotion_types', ___('catalog.admin.settings.promotion_types.label'), array(
			'get_values_path' => 'promotion_types',
			'set_values_path' => 'promotion_types',
		));

		foreach($promotion_types->get_available() as $promotion_type)
		{
			$promotion_type_fs = $promotion_types_fs->add_collection($promotion_type->get_slug());
			$promotion_type_fs->add_bool('enabled', array(
				'label' => ___('catalog.admin.settings.promotion_types.enabled', array(':title' => $promotion_type->get_title())),
			));
		}

		$this->general->add_collection('promotion_months');
		foreach($promotion_types->get_enabled() as $promotion_type)
		{
			if($promotion_type->is_type(Model_Catalog_Company::PROMOTION_TYPE_BASIC))
				continue;
			
			$this->general->promotion_months->add_input_text($promotion_type->get_id(), array(
				'label' => ___('catalog.admin.settings.promotion_months', array(':title' => $promotion_type->get_title())),
			));
		}
		
		$this->add_tab('reviews', ___('catalog.admin.settings.reviews_tab'), array(
			'get_values_path' => 'settings.reviews',
			'set_values_path' => 'settings.reviews',
		));
		
		$this->reviews->add_bool('enabled', array('label' => 'catalog.admin.settings.reviews_enabled'));
		
		$this->reviews->add_collection('moderate');
		$this->reviews->moderate->add_bool('disabled', array('label' => 'catalog.admin.settings.reviews_moderate_disabled'));
		
		$this->add_tab('meta', ___('meta_tags.module_meta_tab'));
		$this->meta->add_meta_tags('meta');
		
		$this->add_input_submit(___('form.save'));
	}
	
}
