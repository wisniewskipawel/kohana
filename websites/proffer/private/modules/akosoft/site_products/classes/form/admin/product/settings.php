<?php
/**
* @author       AkoSoft Team <biuro@akosoft.pl>
* @link         http://www.akosoft.pl
* @copyright    Copyright (c) 2016, AkoSoft
*/

class Form_Admin_Product_Settings extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->form_data($params);
		
		$this->param('i18n_namespace', 'products.forms.settings');
		
		$this->add_tab('general', ___('products.forms.settings.general_tab'));
		
		$this->general->add_input_text('header_tab_title');
		$this->general->add_bool('provinces_enabled', array());
		$this->general->add_bool('confirm_required', array());
		$this->general->add_bool('confirmation_email', array());
		$this->general->add_bool('email_view_disabled', array());
		
		$this->general->add_input_text('home_box_products', array('required' => FALSE))
			->add_validator('home_box_products', 'Bform_Validator_Integer');
		
		$this->add_tab('add_form', ___('products.forms.settings.add_form_tab'));
		
		$this->add_form->add_collection('photos_count');
		
		$this->add_form->photos_count->add_input_text('guest', array('required' => FALSE))
			->add_validator('guest', 'Bform_Validator_Integer');
		
		$this->add_form->photos_count->add_input_text('registered', array('required' => FALSE))
			->add_validator('registered', 'Bform_Validator_Integer');
		
		$this->add_tab('promotion', ___('products.forms.settings.promote_tab'));
		
		$this->promotion->add_input_text('promotion_time', array())
			->add_validator('promotion_time', 'Bform_Validator_Integer');
		
		if(Modules::enabled('site_catalog'))
		{
			$catalog_promotion_types = new Catalog_Company_Promotion_Types();

			foreach($catalog_promotion_types->get_promotions_enabled() as $promotion)
			{
				$collection = $this->promotion->add_collection('free_promotion_'.$promotion->get_id(), array(
					'get_values_path' => 'free_promotion',
					'set_values_path' => 'free_promotion',
				));

				$collection->add_input_text($promotion->get_id(), array(
					'label' => ___('products.forms.settings.free_promotion', array(
						':company_promotion_name' => $promotion->get_title())
					),
					'required' => FALSE,
				))
					->add_validator($promotion->get_id(), 'Bform_Validator_Integer');
			}
		}
		
		$this->add_tab('meta', ___('meta_tags.module_meta_tab'));
		$this->meta->add_meta_tags('meta');
		
		$this->add_input_submit(___('form.save'));
	}

}
