<?php
/**
* @author	AkoSoft Team <biuro@akosoft.pl>
* @link		http://www.akosoft.pl
* @copyright	Copyright (c) 2014, AkoSoft
*/

class Form_Admin_News_Settings extends Bform_Form {
	
	public function create(array $params = array())
	{
		$this->form_data($params);
		
		$this->add_tab('meta', ___('meta_tags.module_meta_tab'));
		$this->meta->add_meta_tags('meta');
		
		$this->add_input_submit(___('form.save'));
	}
	
}