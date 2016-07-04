<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Offer_Settings extends Bform_Form {

	public function create(array $params = array())
	{
		$this->param('i18n_namespace', 'offers.forms.settings');
		
		$this->form_data($params);
		
		$this->add_tab('general', ___('settings.general_tab'));
		
		$this->general->add_input_text('header_tab_title');
		
		$this->general->add_bool('provinces_enabled', array('label' => 'offers.forms.settings.provinces_enabled'));
		
		$this->general->add_bool('confirm_required', array('label' => 'offers.forms.settings.confirm_required'));
		
		$this->general->add_bool('confirmation_email', array('label' => 'offers.forms.settings.confirmation_email'));
		
		$this->general->add_input_text('promotion_time', array('label' => 'offers.forms.settings.promotion_time'))
			->add_validator('promotion_time', 'Bform_Validator_Integer');
		
		$this->general->add_bool('email_view_disabled', array('label' => 'offers.forms.settings.email_view_disabled'));
		
		$this->general->add_input_text('index_box_limit', array(
			'required' => FALSE,
		))
			->add_validator('index_box_limit', 'Bform_Validator_Integer');
		
		$this->general->add_input_text('availability_max_days', array('label' => 'offers.forms.settings.availability_max_days', 'required' => FALSE))
			->add_validator('availability_max_days', 'Bform_Validator_Integer');
		
		$this->add_tab('meta', ___('meta_tags.module_meta_tab'));
		$this->meta->add_meta_tags('meta');
		
		$this->add_input_submit(___('form.save'));
	}

}
