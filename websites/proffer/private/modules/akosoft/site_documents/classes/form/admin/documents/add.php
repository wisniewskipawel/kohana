<?php defined('SYSPATH') or die('No direct script access.');
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2013, AkoSoft
*/
class Form_Admin_Documents_Add extends Bform_Form {
	
	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'documents.forms');
		
		$this->add_tab('general', ___('documents.forms.contents'));
		
		$this->general->add_input_text('document_title');
		
		$this->general->add_editor('document_content', array(
			'editor_type' => Bform_Driver_Editor::TYPE_ADMIN_FULL,
		));
		
		$this->add_tab('seo', 'SEO');

		if ($this->form_data('url-type') == 'manual' || $this->form_data('document_url'))
		{
			$this->seo->add_input_text('document_url', array('required' => FALSE))
				->add_filter('document_url', 'Bform_Filter_Url')
				->add_validator('document_url', 'Bform_Validator_Documents_Url');
		} 
		else 
		{
			$select_url = array(
				'auto'	=> ___('documents.forms.url-type.auto'),
				'manual'	=> ___('documents.forms.url-type.manual'),
			);
			
			$this->seo->add_select('url-type', $select_url, array('id' => 'select-url-type'))
				->add_validator('url-type', 'Bform_Validator_Documents_Url2', array('dependencies_drivers_names' => array('document_title')));
		}

		$this->seo->add_input_text('document_meta_title', array('required' => FALSE))
			->add_validator('document_meta_title', 'Bform_Validator_Length', array('min' => 0, 'max' => 64));
		
		$this->seo->add_textarea('document_meta_description', array('required' => FALSE))
			->add_validator('document_meta_description', 'Bform_Validator_Length', array('min' => 0, 'max' => 256));
		
		$this->seo->add_textarea('document_meta_keywords', array('required' => FALSE))
			->add_validator('document_meta_keywords', 'Bform_Validator_Length', array('min' => 0, 'max' => 256));
		
		$this->add_input_submit(___('form.add'));
	}
	
}
