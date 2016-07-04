<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Settings extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.admin.settings.form');
		
		$this->form_data($params);
		
		$this->add_tab('general', ___('jobs.admin.settings.form.tab_general'));
		
		$this->general->add_input_text('header_tab_title');
		
		$this->general->add_bool('provinces_enabled');
		
		$this->general->add_bool('show_email');
		
		$this->general->add_collection('replies');
		
		$this->general->replies->add_bool('show_contact_not_logged');
		
		$this->general->add_input_text('home_promoted_box_limit')
			->add_validator('home_promoted_box_limit', 'Bform_Validator_Integer');
		
		$this->general->add_input_text('home_recent_box_limit')
			->add_validator('home_recent_box_limit', 'Bform_Validator_Integer');
		
		$this->add_tab('promotions', ___('jobs.admin.settings.form.tab_promotions'));
		
		$this->promotions->add_input_text('promotion_time')
			->add_validator('promotion_time', 'Bform_Validator_Integer');
		
		foreach(Jobs::distinctions(FALSE) as $distinction => $distinction_label)
		{
			$this->promotions->add_editor('promotion_text_'.$distinction, array(
				'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_SIMPLE,
				'label' => ___('jobs.admin.settings.form.promotion_text', array(
					':distinction' => $distinction_label,
				)),
			));
		}
		
		$this->add_tab('meta', ___('meta_tags.module_meta_tab'));
		$this->meta->add_meta_tags('meta');
		
		$this->add_input_submit(___('form.save'));
	}

}
