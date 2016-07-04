<?php
/**
 * @author		AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
 */

class Form_Admin_Jobs_Renew extends Bform_Form {

	public function create(array $params = array()) 
	{
		$this->param('i18n_namespace', 'jobs.form');
		
		$this->form_data($params['job']->as_array());
		
		$this->add_datetime('date_availability');
		
		$this->add_input_submit(___('form.save'));
	}

}
